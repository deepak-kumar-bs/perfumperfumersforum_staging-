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
class Sesatoz_Widget_LoginController extends Engine_Content_Widget_Abstract {

  public function indexAction() {
    $this->view->showlogo = $this->_getParam('showlogo', 1);
    $this->view->form = $form = new User_Form_Login();
    //$form->addError('testing');
  }

}
