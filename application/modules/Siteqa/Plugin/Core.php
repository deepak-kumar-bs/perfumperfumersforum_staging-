<?php 

class Siteqa_Plugin_Core
{
  public function onItemDeleteBefore($event)
  {
    $item = $event->getPayload();
    if( $item instanceof Siteqa_Model_Que ) {
      $queTable = Engine_Api::_()->getDbtable('ques', 'siteqa');

      // Delete answers
      $answersTable = Engine_Api::_()->getDbtable('answers', 'siteqa');
      $answersTable->delete(array(
        'que_id = ?' => $item->getIdentity(),
      ));
      
      // Delete votes
      $votesTable = Engine_Api::_()->getDbtable('votes', 'siteqa');
      $votesTable->delete(array(
        'resource_type = ?' => 'siteqa_que',
        'resource_id = ?' => $item->getIdentity(),
      ));

      // Delete tags
      $tagsTable = Engine_Api::_()->getDbtable('tagmaps', 'core');
      $tagsTable->delete(array(
        'resource_type = ?' => 'siteqa_que',
        'resource_id = ?' => $item->getIdentity(),
      ));

      $tagscoreTable = Engine_Api::_()->getDbtable('tags', 'core');
      foreach ($tagsTable as $tag){
          $tagscoreTable->delete(array(
            'tag_id = ?' => $tag->getTag()->tag_id,
          ));
      } 
        

    }elseif ($item instanceof Siteqa_Model_Answer) {
      
      // Delete votes
      $votesTable = Engine_Api::_()->getDbtable('votes', 'siteqa');
      $votesTable->delete(array(
        'resource_type = ?' => 'siteqa_ans',
        'resource_id = ?' => $item->getIdentity(),
      ));
    }
  }

  public function onUserDeleteBefore($event)
  {
    $payload = $event->getPayload();
    if( $payload instanceof User_Model_User ) {
      
      // Delete Questions
      $questionTable = Engine_Api::_()->getDbtable('ques', 'siteqa');
      $questionSelect = $questionTable->select()->where('owner_id = ?', $payload->getIdentity());
      foreach( $questionTable->fetchAll($questionSelect) as $question ) {
        $question->delete();
      }
      
      // Delete answers
      $answerTable = Engine_Api::_()->getDbtable('answers', 'siteqa');
      $answerTable->delete(array(
        'owner_id = ?' => $payload->getIdentity(),
      ));

      // Delete votes
      $votesTable = Engine_Api::_()->getDbtable('votes', 'siteqa');
      $votesTable->delete(array(
        'owner_id = ?' => $payload->getIdentity(),
      ));
    }
  }

}