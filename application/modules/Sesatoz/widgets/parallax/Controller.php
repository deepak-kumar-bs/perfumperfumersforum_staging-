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

class Sesatoz_Widget_ParallaxController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 'Stay in touch. Share moments.');
    $this->view->description = $this->_getParam('description', '');
    $this->view->buttontext = $this->_getParam('buttontext', 'Join Us Today');
    $this->view->buttonlink = $this->_getParam('buttonlink', 'signup');

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->bgimage = $this->_getParam('bgimage', 0);
  }

}
