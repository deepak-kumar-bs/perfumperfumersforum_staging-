<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: NotificationsControllers.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_NotificationsController extends Core_Controller_Action_Standard {

  public function init() {
    $this->_helper->requireUser();
  }
  public function markreadmentionAction(){
    $action_id = $this->_getParam('actionid',0);
    if($action_id){
      $item = Engine_Api::_()->getItem('activity_notification',$action_id);
      if($item){
        $item->read = 1;
        $item->save();
      }
      echo 1;die; 
    }
    echo 0;die;  
  }
  public function pulldownAction() {
    
    $page = $this->_getParam('page');
    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->notifications = $notifications = Engine_Api::_()->getDbtable('notifications', 'sesatoz')->getNotificationsPaginator($viewer);
    $notifications->setCurrentPageNumber($page);

    if ($notifications->getCurrentItemCount() <= 0 || $page > $notifications->getCurrentPageNumber()) {
      $this->_helper->viewRenderer->setNoRender(true);
      return;
    }
    
    Engine_Api::_()->getApi('message', 'sesatoz')->setUnreadNotification($viewer);

    // Force rendering now
    $this->_helper->viewRenderer->postDispatch();
    $this->_helper->viewRenderer->setNoRender(true);
  }

}