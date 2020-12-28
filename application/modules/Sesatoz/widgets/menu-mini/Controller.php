<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Widget_MenuMiniController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
    if (!$require_check) {
      if ($viewer->getIdentity()) {
        $this->view->search_check = true;
      } else {
        $this->view->search_check = false;
      }
    }
    else
      $this->view->search_check = true;

    $this->view->navigation = $navigation = Engine_Api::_()
            ->getApi('menus', 'sesbasic')
            ->getNavigation('sesbasic_mini');
    if ($viewer->getIdentity()) {
      $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
      $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesatoz')->getMessagesUnreadCount($viewer);
      $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
    }
    $this->view->poupup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popupsign', 1);
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $this->view->notificationOnly = $request->getParam('notificationOnly', false);
    $this->view->updateSettings = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.notificationupdate');

    $this->view->loginsignup_logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.loginsignuplogo', '');

    //LOGIN FORM WORK
    $this->view->form = $form = new Sesbasic_Form_Login();
    $this->view->storage = Engine_Api::_()->storage();

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
		$loggedinHeaderCondition = $settings->getSetting('sesatoz.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = $settings->getSetting('sesatoz.header.nonloggedin.options',$defaultoptn);
    $viewer_id = $viewer->getIdentity();
    if($viewer_id != 0) {
			if(!in_array('search',$loggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    } else {
			if(!in_array('search',$nonloggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
		}
		$this->view->loginsignupbgimage = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.loginsignupbgimage', '');
    $this->view->settingNavigation = $settingsNavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_settings', array());

    $user = Engine_Api::_()->user()->getViewer();
    if ($user && $user->getIdentity()) {
      if (1 === count(Engine_Api::_()->user()->getSuperAdmins()) && 1 === $user->level_id) {
        foreach ($settingsNavigation as $page) {
          if ($page instanceof Zend_Navigation_Page_Mvc && $page->getAction() == 'delete') {
            $settingsNavigation->removePage($page);
          }
        }
      }
    }
  }

}
