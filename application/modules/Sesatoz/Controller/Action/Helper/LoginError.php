<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: LoginError.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Controller_Action_Helper_LoginError extends Zend_Controller_Action_Helper_Abstract {

  public function postDispatch() {
    $front = Zend_Controller_Front::getInstance();
    $module = $front->getRequest()->getModuleName();
    $action = $front->getRequest()->getActionName();
    $controller = $front->getRequest()->getControllerName();
    if ($module == 'user' && $controller == 'auth' && ($action == 'login') ){
       $form = $this->getActionController()->view->form;
      
       $arrMessages = $form->getMessages();
       $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
       $error = '';
      foreach($arrMessages as $field => $arrErrors) {
        if($field){
          $error .= sprintf(
              '<li>%s%s</li>',
              $form->getElement($field)->getLabel(),
              $view->formErrors($arrErrors)
      
          );
        }else{
           $error .= sprintf(
              '<li>%s</li>',
              $arrErrors
          );
        }
      }
      if ($this->getRequest()->isPost() && $error) {
        $error = '<ul class="form-errors">'.$error.'<ul>';
        $script ="sesJqueryObject(document).ready(function(){
        var elem = sesJqueryObject('#user_form_login').find('.form-description').first();
        var html = '$error';
         sesJqueryObject(elem).after(html);
        });";
        $view->headScript()->appendScript($script);
      }
    }
  }

}