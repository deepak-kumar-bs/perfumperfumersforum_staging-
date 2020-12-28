<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bodyclass.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_View_Filter_Bodyclass {

	public function filter($string) {
	
    $layout = Zend_Layout::getMvcInstance();
    $request = Zend_Controller_Front::getInstance()->getRequest();
    $moduleName = $request->getModuleName();
    $actionName = $request->getActionName();
    $controllerName = $request->getControllerName();
    // Get body identity
    if( isset($layout->siteinfo['identity']) ) {
      $identity = $layout->siteinfo['identity'];
    } else {
      $identity = $request->getModuleName() . '-' .
      $request->getControllerName() . '-' .
      $request->getActionName();
    }
    
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2) == 2 && isset($_COOKIE['sesatoz']) && $_COOKIE['sesatoz'] == 2){
      $toogleClass = 'sidebar-toggled'; 
    }else if(empty($_COOKIE['sesatoz'])){
      $toogleClass = 'sidebar-toggled';
    } else
      $toogleClass = '';
      
    if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.landingpage.style', 0) && ($moduleName == 'core' && $actionName == 'index' && $controllerName == 'index') ) {
      $class=" sesatoz_landing_page";
    } else
      $class="";
      
    if(strpos($string,'<body id="global_page_'.$identity.'"') !== FALSE){
      $string =  str_replace('<body','<body class="'.$toogleClass.$class.'"',$string);
    }
    return $string;
  }
}