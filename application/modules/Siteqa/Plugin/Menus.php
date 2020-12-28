<?php

class Siteqa_Plugin_Menus 
{

  public function canCreateQuestions()
  {
    // Must be logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }

    // Must be able to create questions
    if( !Engine_Api::_()->authorization()->isAllowed('siteqa_question', $viewer, 'create') ) {
      return false;
    }

    return true;
  }

  public function canViewQuestions()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    
    // Must be able to view questions
    if( !Engine_Api::_()->authorization()->isAllowed('siteqa_question', $viewer, 'view') ) {
      return false;
    }

    return true;
  }

  public function canManageQuestions()
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer || !$viewer->getIdentity() ) {
      return false;
    }
    
    // Must be able to view questions
    if( !Engine_Api::_()->authorization()->isAllowed('siteqa_question', $viewer, 'view') ) {
      return false;
    }

    return true;
  }

  // onMenuInitialize_SitebookingServiceGutterShare
  public function siteqaQuestionGutterShare($row)
  {
    $viewer = Engine_Api::_()->user()->getViewer();
    if( !$viewer->getIdentity() ) {
      return false;
    }

    // Admin level setting
    $sharelinkcoreSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting("siteqa.question.sharelink");

    if($sharelinkcoreSettings === "no")
      return false;
    
    // Modify params
    $params = $row->params;
    $params['params']['type'] = $subject->getType();
    $params['params']['id'] = $subject->getIdentity();
    $params['params']['format'] = 'smoothbox';
    return $params;
  }

  
}

?>