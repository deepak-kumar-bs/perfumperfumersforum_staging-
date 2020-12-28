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

class Siteqa_Model_DbTable_Votes extends Engine_Db_Table
{
  protected $_rowClass = "Siteqa_Model_Vote";

  /**
  	* Make siteqa vote
   	* @param int $owner_id : owner id
	* @param int $resource_type : resource type
	* @param int $resource_id : resource id
  */

  public function setVote($owner_id, $resource_type, $resource_id, $vote) {

      //FETCH DATA
	    $previousVoteMark = $this->select()
        ->from($this->info('name'), array('vote'))
        ->where('owner_id = ?', $owner_id)
        ->where('resource_type = ?', $resource_type)
        ->where('resource_id = ?', $resource_id)
        ->query()
		  ->fetchColumn();

      //INSERT VOTES ENTRIES IN TABLE
      if (empty($previousVoteMark)) {
        $msg = "Your vote submitted sucessfully";
        $this->insert(array(
            'owner_id' => $owner_id,
            'resource_type' => $resource_type,
            'resource_id' => $resource_id,
            'vote' => $vote,
            'modified_date' => new Zend_Db_Expr('NOW()')
        ));
      }else{
        if($vote == $previousVoteMark){
          $msg = "You have already Voted";
        }else{
          $msg = "Your vote updated successfully";
        }
        $this->update(array(
            'vote' => $vote,
            'modified_date' => new Zend_Db_Expr('NOW()')
        ),array(
            'resource_type = ?' => $resource_type,
            'resource_id = ?' => $resource_id,
            'owner_id = ?' => $owner_id,
        ));
  	 }
     $votes = $this->getTotalVotes($resource_type,$resource_id);
     if($resource_type == 'siteqa_que'){
        
          Engine_Api::_()->getDbtable('questions', 'siteqa')->update(array(
              'vote_count' => $votes,
          ),array(
              'question_id = ?' => $resource_id,
          ));
        
      }else{
        
          Engine_Api::_()->getDbtable('answers', 'siteqa')->update(array(
              'vote_count' => $votes,
          ),array(
              'answer_id = ?' => $resource_id,
          ));
      
      }

      $votes = array('vote'=>$this->getTotalVotes($resource_type,$resource_id),'msg'=>$msg);
  	  return $votes;
  }

  /**
  	* Fetch siteqa votes
   	* @param int $resource_type : resource type
	* @param int $resource_id : resource id
  */
  public function getTotalVotes($resource_type, $resource_id){
  	$viewer = Engine_Api::_()->user()->getViewer();
  	//FETCH DATA
  	$allVotes = $this->select()
          ->from($this->info('name'), array('SUM(vote) AS votes'))
          ->where('resource_type = ?', $resource_type)
          ->where('resource_id = ?', $resource_id)
          ->query()
  		->fetch();

  	return $allVotes['votes'];
  }

  /**
  * Fetch siteqa vote basis on owner id
  * @param int $resource_type : resource type
  * @param int $resource_id : resource id
  * @param int $owner_id : owner id
  */
  public function getVoteQuestionId($resource_type, $resource_id, $owner_id){
    $viewer = Engine_Api::_()->user()->getViewer();
    //FETCH DATA
    $votes = $this->select()
          ->from($this->info('name'), array('vote'))
          ->where('resource_type = ?', $resource_type)
          ->where('resource_id = ?', $resource_id)
          ->where('owner_id = ?', $owner_id)
          ->query()
      ->fetch();
    
    if($votes['vote']){
      return $votes['vote'];
    }else{
      return 0;
    }
  }

  /**
  * Fetch siteqa vote basis on owner id
  * @param int $resource_type : resource type
  * @param int $resource_id : resource id
  */
  public function getVoteDetails($resource_type, $resource_id){
    $viewer = Engine_Api::_()->user()->getViewer();
    //FETCH DATA
    $voteDetails = $this->select()
          ->from($this->info('name'))
          ->where('resource_type = ?', $resource_type)
          ->where('resource_id = ?', $resource_id)
          ->query()
      ->fetchAll();
    
    return array('vote_count'=>$this->getTotalVotes($resource_type,$resource_id),'voteDetails'=>$voteDetails);
  }
}