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

class Sesatoz_Widget_HomeSliderController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

        $this->view->viewer_id = $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->staticContent = $settings->getSetting('sesatoz.staticcontent', '');
        $this->view->bgimage = $settings->getSetting('sesatoz.banner.bgimage', '');
        $this->view->sesatoz_banner_content = explode('||',$settings->getSetting('sesatoz.banner.content', ''));
        $this->view->height = $this->_getParam('height', '600');
        if($viewer_id == 0) {
            $defaultoptn = array('search','miniMenu','mainMenu','logo', 'socialshare');
            $nonloggedinHeaderCondition = $settings->getSetting('sesatoz.header.nonloggedin.options',$defaultoptn);
            if(!in_array('miniMenu',$nonloggedinHeaderCondition))
                $this->view->show_mini = 0;
            else
                $this->view->show_mini = 1;
        }
  }
}
