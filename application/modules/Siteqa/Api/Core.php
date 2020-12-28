<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Core.php 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Api_Core extends Core_Api_Abstract
{
	/**
   	* Get Truncation String
   	*
   	* @param string $text
   	* @param int $limit
   	* @return truncate string
   	*/
   	public function truncateText($string, $limit) {

		//IF LIMIT IS EMPTY
   		if (empty($limit)) {
   			$limit = 16;
   		}

		//RETURN TRUNCATED STRING
   		$string = strip_tags($string);
   		return ( Engine_String::strlen($string) > $limit ? Engine_String::substr($string, 0, ($limit-3)) . '...' : $string );
   	}

  	/**
   	* Get siteqa tags created by users
   	* @param int $owner_id : siteqa owner id
	* @param int $total_tags : number tags to show
   	*/
	public function getTags($owner_id = 0, $total_tags = 100, $count_only = 0) {

		//GET TAGMAP TABLE NAME
		$tableTagmaps = 'engine4_core_tagmaps';

		//GET TAG TABLE NAME
		$tableTags = 'engine4_core_tags';

		//GET DOCUMENT TABLE
		$tableSiteqa = Engine_Api::_()->getDbtable('questions', 'siteqa');
		$tableSiteqaName = $tableSiteqa->info('name');

		//MAKE QUERY
		$select = $tableSiteqa->select()
		->setIntegrityCheck(false)
		->from($tableSiteqaName, array(''))
		->joinInner($tableTagmaps, "question_id = $tableTagmaps.resource_id", array('COUNT(resource_id) AS Frequency'))
		->joinInner($tableTags, "$tableTags.tag_id = $tableTagmaps.tag_id",array('text', 'tag_id'));

		if(!empty($owner_id)) {
			$select = $select->where($tableSiteqaName . '.owner_id = ?', $owner_id);
		}

		$select = $select
		->where($tableSiteqaName . '.search = ?', 1)
		->where($tableTagmaps . '.resource_type = ?', 'siteqa_question')
		->group("$tableTags.text")
		->order("Frequency DESC");

		if(!empty($total_tags)) {
			$select = $select->limit($total_tags);
		}
		
		if(!empty($count_only)) {
			$total_results = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
			return Count($total_results);
		}

			//RETURN RESULTS
		return $select->query()->fetchAll();
	}

	/*
	* To send notification
	*/
	public function addCustomNotifications(User_Model_User $user, Core_Model_Item_Abstract $subject, Core_Model_Item_Abstract $object, $type, array $params = null) {

		if( !$user->getIdentity() || !$subject->getIdentity() || !$object->getIdentity() )
		{
			return;
		}

		$row = Engine_Api::_()->getDbtable('notifications', 'activity')->createRow();
		$row->user_id = $user->getIdentity();
		$row->subject_type = $subject->getType();
		$row->subject_id = $subject->getIdentity();
		$row->object_type = $object->getType();
		$row->object_id = $object->getIdentity();
		$row->type = $type;
		$row->params = $params;
		$row->date = date('Y-m-d H:i:s');
		$row->save();

		return $row;
	}

	public function getQueCount($category_id, $subcat_id)
	{
		//GET DOCUMENT TABLE
		$tableSiteqa = Engine_Api::_()->getDbtable('questions', 'siteqa');
		$tableSiteqaName = $tableSiteqa->info('name');

		if(!empty($category_id)) {
			$queCount = $tableSiteqa->select()
          	->from($tableSiteqaName, array('COUNT(question_id) AS count'))
          	->where('category_id = ?', $category_id)
        	->query()
  			->fetch();
		}else if(!empty($subcat_id)){
			$queCount = $tableSiteqa->select()
          	->from($tableSiteqaName, array('COUNT(question_id) AS count'))
          	->where('subcategory_id = ?', $subcat_id)
        	->query()
  			->fetch();
		}
		
  		return $queCount['count'];
            
	}
}
