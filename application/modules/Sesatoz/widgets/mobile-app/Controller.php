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

class Sesatoz_Widget_MobileAppController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->design = $this->_getParam('design', 1);
    $this->view->allParams = $allParams = $this->_getAllParams();
    if(empty($allParams))
        return $this->setNoRender();
  }
}
