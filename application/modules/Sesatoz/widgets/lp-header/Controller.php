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

class Sesatoz_Widget_LpHeaderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
		$loggedinHeaderCondition = $settings->getSetting('sesatoz.header.loggedin.options', $defaultoptn);
		$nonloggedinHeaderCondition = $settings->getSetting('sesatoz.header.nonloggedin.options',$defaultoptn);
		$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_main');
		$this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
		$this->view->moretext = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.moretext', 'More');
    $this->view->submenu = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.submenu', 1);
		$this->view->max = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.limit', 6);
    $this->view->storage = Engine_Api::_()->storage();
		
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    $sesatoz_header = Zend_Registry::isRegistered('sesatoz_header') ? Zend_Registry::get('sesatoz_header') : null;
    if(empty($sesatoz_header)) {
      return $this->setNoRender();
    }
    if($viewer_id != 0) {
      if(!in_array('mainMenu',$loggedinHeaderCondition))
        $this->view->show_menu = 0;
      else
        $this->view->show_menu = 1;
			if(!in_array('miniMenu',$loggedinHeaderCondition))
        $this->view->show_mini = 0;
      else
        $this->view->show_mini = 1;
			if(!in_array('logo',$loggedinHeaderCondition))
        $this->view->show_logo = 0;
      else
        $this->view->show_logo = 1;
        
			if(!in_array('socialshare',$loggedinHeaderCondition))
        $this->view->show_socialshare = 0;
      else
        $this->view->show_socialshare = 1;
        
			if(!in_array('search',$loggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;
    } else {
      if(!in_array('mainMenu',$nonloggedinHeaderCondition))
        $this->view->show_menu = 0;
      else
        $this->view->show_menu = 1;
			if(!in_array('miniMenu',$nonloggedinHeaderCondition))
        $this->view->show_mini = 0;
      else
        $this->view->show_mini = 1;
			if(!in_array('logo',$nonloggedinHeaderCondition))
        $this->view->show_logo = 0;
      else
        $this->view->show_logo = 1;
			if(!in_array('socialshare',$nonloggedinHeaderCondition))
        $this->view->show_socialshare = 0;
      else
        $this->view->show_socialshare = 1;
			if(!in_array('search',$nonloggedinHeaderCondition))
        $this->view->show_search = 0;
      else
        $this->view->show_search = 1;	
		}
  }

}
