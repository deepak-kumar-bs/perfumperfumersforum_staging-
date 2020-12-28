<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Ques.php 10193 2014-05-01 13:48:30Z lucas $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Model_DbTable_Questions extends Core_Model_Item_DbTable_Abstract
{
    protected $_rowClass = "Siteqa_Model_Question";

    /**
     * Gets a select object for the user's Question entries
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Db_Table_Select
     */
    public function getQuestionsSelect($params = array())
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $table = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $rName = $table->info('name');

        $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
        $tmName = $tmTable->info('name');
        
        $select = $table->select()
            ->where($rName.'.owner_id = ?', $viewer->getIdentity())
            ->order( !empty($params['orderby']) ? $rName.'.'.$params['orderby'].' DESC' : $rName.'.creation_date DESC' );
        
        if($params['search']){
            $select->where($rName.".title LIKE ? OR ".$rName.".body LIKE ?", '%'.$params['search'].'%');
        }

        if($params['category']){
            $select->where($rName.'.category_id = ?', $params['category']);
        }

        return $select;
    }

    /**
     * Gets a paginator for Question
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Paginator
     */
    public function getQuestionsPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getQuestionsSelect($params));

        if( !empty($params['page']) )
        {
            $paginator->setCurrentPageNumber($params['page']);
        }
        if( !empty($params['limit']) )
        {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if( empty($params['limit']) )
        {
            $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('question.page', 10);
            $paginator->setItemCountPerPage($page);
        }
       
        return $paginator;
    }

    /**
     * Gets a select object for the all Question entries
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Db_Table_Select
     */
    public function getAllQuestionsSelect($params = array())
    {
        $table = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $rName = $table->info('name');

        $tmTable = Engine_Api::_()->getDbtable('TagMaps', 'core');
        $tmName = $tmTable->info('name');

        //GET TAG MAPS TABLE NAME
        $tableTagmapsName = Engine_Api::_()->getDbtable('TagMaps', 'core')->info('name');
        
        $select = $table->select();

        if (!empty($params['tag_id'])) {
            $select
            ->setIntegrityCheck(false)  
            ->from($rName)
            ->joinLeft($tableTagmapsName, "$tableTagmapsName.resource_id = $rName.question_id")
            ->where($tableTagmapsName.'.resource_type = ?', 'siteqa_question')
            ->where($tableTagmapsName.'.tag_id = ?', $params['tag_id']);
        }

        if($params['orderby'] != "unanswered"){
            $select
            ->where($rName.'.approved = ?', '1')
            ->order( !empty($params['orderby']) ? $rName.'.'.$params['orderby'].' DESC' : $rName.'.creation_date DESC' );    
        }else{
            $select
            ->where('approved = ?', '1')
            ->where('answer_count = ?', '0');
        }

        if($params['search']){
            $select->where($rName.".title LIKE ? OR ".$rName.".body LIKE ?", '%'.$params['search'].'%');
        }

        if($params['category']){
            $select->where($rName.'.category_id = ?', $params['category']);
        }
        
        return $select;
    }

    /**
     * Gets a paginator for All Questions
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Paginator
     */
    public function getAllQuestionsPaginator($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getAllQuestionsSelect($params));

        if( !empty($params['page']) )
        {
            $paginator->setCurrentPageNumber($params['page']);
        }
        if( !empty($params['limit']) )
        {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if( empty($params['limit']) )
        {
            $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('question.page', 10);
            $paginator->setItemCountPerPage($page);
        }
       
        return $paginator;
    }

    /**
     * Returns an array of dates where a given user created a Question entry
     *
     * @param User_Model_User user to calculate for
     * @return Array Dates
     */
    public function getArchiveList($spec)
    {
        if( !($spec instanceof User_Model_User) ) {
            return null;
        }

        $localeObject = Zend_Registry::get('Locale');
        if( !$localeObject ) {
            $localeObject = new Zend_Locale();
        }

        $dates = $this->select()
            ->from($this, 'creation_date')
            ->where('owner_type = ?', 'user')
            ->where('owner_id = ?', $spec->getIdentity())
            ->where('draft = ?', 0)
            ->order('question_id DESC')
            ->query()
            ->fetchAll(Zend_Db::FETCH_COLUMN);

        $time = time();

        $archive_list = array();
        foreach( $dates as $date ) {

            $date = strtotime($date);
            $ltime = localtime($date, true);
            $ltime["tm_mon"] = $ltime["tm_mon"] + 1;
            $ltime["tm_year"] = $ltime["tm_year"] + 1900;

            // LESS THAN A YEAR AGO - MONTHS
            if( $date + 31536000 > $time ) {
                $date_start = mktime(0, 0, 0, $ltime["tm_mon"], 1, $ltime["tm_year"]);
                $date_end = mktime(0, 0, 0, $ltime["tm_mon"] + 1, 1, $ltime["tm_year"]);
                $type = 'month';

                $dateObject = new Zend_Date($date);
                $format = $localeObject->getTranslation('yMMMM', 'dateitem', $localeObject);
                $label = $dateObject->toString($format, $localeObject);
            }
            // MORE THAN A YEAR AGO - YEARS
            else {
                $date_start = mktime(0, 0, 0, 1, 1, $ltime["tm_year"]);
                $date_end = mktime(0, 0, 0, 1, 1, $ltime["tm_year"] + 1);
                $type = 'year';

                $dateObject = new Zend_Date($date);
                $format = $localeObject->getTranslation('yyyy', 'dateitem', $localeObject);
                if( !$format ) {
                    $format = $localeObject->getTranslation('y', 'dateitem', $localeObject);
                }
                $label = $dateObject->toString($format, $localeObject);
            }

            if( !isset($archive_list[$date_start]) ) {
                $archive_list[$date_start] = array(
                    'type' => $type,
                    'label' => $label,
                    'date' => $date,
                    'date_start' => $date_start,
                    'date_end' => $date_end,
                    'count' => 1
                );
            } else {
                $archive_list[$date_start]['count']++;
            }
        }

        return $archive_list;
    }

    /**
   * Update Question categories value on category delete
   *
   * @param int $category_id
   * @param string $type
   */
    public function updateQuesCategories($category_id, $type, $mapping_category_id = 0) {
    
        //RETURN IF CATEGORY ID IS EMPTY
        if(empty($category_id)) {
            return;
        }

        //IF CATEGORY IS GOING TO DELETE
        if($type == 'category_delete') {

            //MAKE QUERY
            $select = $this->select()
            ->from($this->info('name'), array('question_id', 'category_id', 'subcategory_id'))
            ->where('category_id = ?', $category_id);
    
            //FETCH RESULTS
            $category_id_results = $this->fetchAll($select);

            foreach($category_id_results as $siteqa) {
                $category_ids = ($siteqa->category_id);
                $subcategory_ids = ($siteqa->subcategory_id);
                
                if(Count($category_ids) == 1) {
                    $new_category_id = $zero_string = 0;
                    if(!empty($mapping_category_id)) {
                        $new_category_id =  $mapping_category_id;
                    }
                    $this->update(array('category_id' => $new_category_id, 'subcategory_id' => $zero_string), array('question_id = ?' => $siteqa->question_id));
                    //break;
                }
                else {
                    foreach($category_ids as $key => $value) {
                        if($value == $category_id) {
                            $category_ids[$key] = "0";
                            $subcategory_ids[$key] = "0";
                            
                            if(!empty($mapping_category_id)) {
                                $category_ids[$key] = "$mapping_category_id";
                            }

                            $category_ids = Zend_Json_Encoder::encode($category_ids);
                            $subcategory_ids = Zend_Json_Encoder::encode($subcategory_ids);
                            $this->update(array('category_id' => $category_ids, 'subcategory_id' => $subcategory_ids), array('question_id = ?' => $siteqa->question_id));
                            //break;
                        }
                    }
                    //break;
                }
            }
        }
        else {

            //MAKE QUERY
            $select = $this->select()
                                         ->from($this->info('name'), array('question_id', 'category_id', 'subcategory_id'))
                                         ->where('subcategory_id LIKE ?', '%"'.$category_id.'"%');

            //FETCH RESULTS
            $subcategory_id_results = $this->fetchAll($select);

            foreach($subcategory_id_results as $siteqa) {
                $subcategory_ids = Zend_Json_Decoder::decode($siteqa->subcategory_id);
                
                foreach($subcategory_ids as $key => $value) {
                    if($value == $category_id) {
                        $subcategory_ids[$key] = "0";
                        $subcategory_ids = Zend_Json_Encoder::encode($subcategory_ids);
                        $this->update(array('subcategory_id' => $subcategory_ids), array('question_id = ?' => $siteqa->question_id));
                        //break;
                    }
                }
            }
        }
    }

    /*
    * Get content for the Question of the day widget
    */
    public function getQuestionOfDay() {

        $sitequeTable = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $sitequeTableName = $this->info('name');

        $itemofthedaytable = Engine_Api::_()->getDbtable('itemofthedays', 'siteqa');
        $itemofthedayName = $itemofthedaytable->info('name');

        $select = $this->select();
        $select = $select->setIntegrityCheck(false)
                ->from($sitequeTableName, array('question_id', 'title', 'photo_id', 'owner_id' , 'category_id'))
                ->join($itemofthedayName, $sitequeTableName . ".question_id = " . $itemofthedayName . '.resource_id', array('start_date'))
                ->where($sitequeTableName . '.approved = ?', '1')
                ->where($itemofthedayName . '.resource_type=?', 'siteqa_question')
                ->where($itemofthedayName . '.start_date <=?', date('Y-m-d'))
                ->where($itemofthedayName . '.end_date >=?', date('Y-m-d'))
                ->order('RAND()');
        
        return $this->fetchRow($select);
    }

    /*
     * Gets all answers from question id
    */
    public function getAnswersSelect($params = array())
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $table = Engine_Api::_()->getDbtable('answers', 'siteqa');
        $answer = $table->select()
            ->where('question_id = ?', $params['question_id'])
            ->order('helpful DESC')
            ->order('vote_count DESC');
            //->query()->fetchAll();
        
        return $answer;
    }

    /**
     * Gets a paginator for Answer
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Paginator
     */
    public function getAnswerFromQueId($params = array())
    {
        $paginator = Zend_Paginator::factory($this->getAnswersSelect($params));

        if( !empty($params['page']) )
        {
            $paginator->setCurrentPageNumber($params['page']);
        }
        if( !empty($params['limit']) )
        {
            $paginator->setItemCountPerPage($params['limit']);
        }

        if( empty($params['limit']) )
        {
            $page = (int) Engine_Api::_()->getApi('settings', 'core')->getSetting('answer.page', 10);
            $paginator->setItemCountPerPage($page);
        }
       
        return $paginator;
    }


    /**
    * Get all other questions from owner id
    * @param string $question_id : question id 
    * @param int $limit : result limit
    */
    public function getAllOtherQuestion($params, $limit = 5){
        $table = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $select = $table->select()
            ->where('question_id != ?', $params['question_id'])
            ->where('owner_id = ?', $params['owner_id'])
            ->limit($limit);
        $question = $table->fetchAll($select);
        
        return $question;
    }


    /**
    * Get all voted questions from owner id
    * @param string $question_id : question id 
    * @param int $limit : result limit
    */
    public function getAllVotedQuestion($limit = 5){
        $table = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $select = $table->select()
            ->order('vote_count DESC')
            ->limit($limit);
        $question = $table->fetchAll($select);
        
        return $question;
    }


    /**
   * Get questions to add as item of the day
   * @param string $title : search text
   * @param int $limit : result limit
   */
    public function getDayItems($title, $limit = 10,$category_id = null) {

        //MAKE QUERY
        $select = $this->select()
                ->from($this->info('name'), array('question_id', 'owner_id', 'title', 'photo_id'));
                
        if(!empty($category_id)) {
           $select->where('category_id = ?',$category_id);
        }
        $select->where($this->info('name') . ".title LIKE ? ", '%' . $title . '%')
                ->where('approved = ?', '1')
                ->order('title ASC')
                ->limit($limit);

        //FETCH RESULTS
        return $this->fetchAll($select);
    }

}
