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
class Siteqa_Model_DbTable_Answers extends Core_Model_Item_DbTable_Abstract
{
    protected $_rowClass = "Siteqa_Model_Answer";

    /**
     * Gets a select object for the user's Answer entries
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Db_Table_Select
     */
    public function getAnswersSelect($params = array())
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewerId = $viewer->getIdentity();
        $table = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $rName = $table->info('name');

        $tableSiteans = Engine_Api::_()->getDbtable('answers', 'siteqa');
	    $tableSiteansName = $tableSiteans->info('name');

        $select = $table->select()
            ->setIntegrityCheck(false)  	
            ->from($rName)
            ->join($tableSiteansName, "$tableSiteansName.question_id = $rName.question_id", array(''))
            ->where($tableSiteansName.'.owner_id = ?', $viewer->getIdentity())
		  	->order( !empty($params['orderby']) ? $rName.'.'.$params['orderby'].' DESC' : $tableSiteansName.'.creation_date DESC' )
            ->group($rName.'.question_id');

        if($params['category']){
            $select->where($rName.'.category_id = ?', $params['category']);
        }

        return $select;
    }

    /**
     * Gets a paginator for Answer
     *
     * @param Core_Model_Item_Abstract $user The user to get the messages for
     * @return Zend_Paginator
     */
    public function getAnswersPaginator($params = array())
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
    * Get all top users based on the most vosted answers
    * @param string $que_id : question id 
    * @param int $limit : result limit
    */
    public function getTopUsers($limit)
    {
        $table = Engine_Api::_()->getDbtable('answers', 'siteqa');
        $select = $table->select()
            ->order('vote_count DESC')
            ->group('owner_id')
            ->limit($limit);
        
        $topUsers = $table->fetchAll($select);
        
        return $topUsers;    
    }
}
