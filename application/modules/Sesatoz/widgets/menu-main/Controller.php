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

class Sesatoz_Widget_MenuMainController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_main');

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $viewerId = $viewer->getIdentity();

    $this->view->moretext = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.moretext', 'More');

    //Cover Photo work
    //Cover Photo work
    $cover = 0;
    if(Engine_Api::_()->getApi('core', 'sesbasic')->isModuleEnable(array('sesusercoverphoto')) && $viewerId) {
      if($viewer->coverphoto) {
        $this->view->menuinformationimg = $cover =	Engine_Api::_()->storage()->get($getUserInfoItem->coverphoto, '');
        if($cover) {
          $this->view->menuinformationimg = $cover->getPhotoUrl();
        }
      }
    }
		if(empty($cover)) {
      $this->view->menuinformationimg = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.menuinformation.img', '');
		}

    $this->view->backgroundImg = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.menu.img', '');

    $showMainmenu = $this->_getParam('show_main_menu', 1);
    if ($viewerId == 0 && empty($showMainmenu)) {
      $this->setNoRender();
      return;
    }
    $this->view->submenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.submenu', 1);
    $this->view->headerDesign = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2);
    $require_check = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.browse', 1);
    if (!$require_check && !$viewerId) {
      $navigation->removePage($navigation->findOneBy('route', 'user_general'));
    }
    $this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.limit', 6);
    $this->view->storage = Engine_Api::_()->storage();

    $this->view->homelinksnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('user_home');
  }

}
