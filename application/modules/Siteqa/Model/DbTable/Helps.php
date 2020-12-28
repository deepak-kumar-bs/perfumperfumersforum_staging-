<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Helps.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Siteqa_Model_DbTable_Helps extends Engine_Db_Table
{
  protected $_rowClass = "Siteqa_Model_Help";

	 /**
   * Make siteqa helpful
   * @param int $question_id : siteque id
	 * @param int $owner_id : user id
	 * @param int $helpful : helpful value
   */

  public function setHelful($question_id, $owner_id, $helpful,$option_id) {

    //FETCH DATA
    $done_helpful = $this->select()
                    ->from($this->info('name'), array('question_id'))
                    ->where('question_id = ?', $question_id)
                    ->query()
                    ->fetchColumn();

		//INSERT HELPFUL ENTRIES IN TABLE
    if (empty($done_helpful)) {
      $this->insert(array(
          'question_id' => $question_id,
          'owner_id' => $owner_id,
          'helpful' => $helpful,
          'option_id' => $option_id,
          'modified_date' => new Zend_Db_Expr('NOW()')
      ));
    }else{
      $this->update(array(
          'helpful' => $helpful,
          'option_id' => $option_id,
          'modified_date' => new Zend_Db_Expr('NOW()')
      ),array(
          'question_id = ?' => $question_id,
      ));
	}

	$getHelpful = $this->getHelpful($question_id, 1);

	Engine_Api::_()->getDbtable('answers', 'siteqa')->update(array(
			'helpful' => 0
	),array(
			'question_id = ?' => $question_id,
	));

	Engine_Api::_()->getDbtable('answers', 'siteqa')->update(array(
			'helpful' => $helpful
	),array(
			'answer_id = ?' => $option_id,
	));
	return $getHelpful;
  }

	/**
   * Get previous helpful answer
   * @param int $question_id : siteqa id
	 * @param int $viewer_id : viewer id
   */
  public function getHelpful($question_id, $viewer_id) {

	//RETURN NULL IF QUESTION ID IS NULL
	if(empty($question_id) || empty($viewer_id)) {
		return 0;
	}

	//FETCH DATA
    $previousHelpMark = $this->select()
        ->from($this->info('name'),array('option_id'))
        ->where('question_id = ?', $question_id)
        ->where('owner_id = ?', $viewer_id)
        ->query()
		->fetchColumn();
	//RETURN DATA
    if (!empty($previousHelpMark)) {
      return $previousHelpMark;
	}
    
	return 0;
  }

}