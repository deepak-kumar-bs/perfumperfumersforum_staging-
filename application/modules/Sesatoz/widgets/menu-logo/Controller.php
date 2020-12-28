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
class Sesatoz_Widget_MenuLogoController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->logo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.logo', '');
    $this->view->footerlogo = $this->_getParam('logofooter',false);
    if($this->view->footerlogo){
     $this->view->logo  = $this->view->footerlogo;
    }
    $this->getElement()->removeDecorator('Container');
  }

}
