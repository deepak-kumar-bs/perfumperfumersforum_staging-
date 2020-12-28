<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Bootstrap.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Bootstrap extends Engine_Application_Bootstrap_Abstract {

	public function __construct($application) {

    parent::__construct($application);

    $front = Zend_Controller_Front::getInstance();
    $front->registerPlugin(new Sesatoz_Plugin_Core);
		$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
		// $view->headLink()->appendStylesheet('https://fonts.googleapis.com/css?family=Open+Sans:400,400i,600,600i,700,700i,800|Bitter:400,400i,700|Indie+Flowe');
    if(strpos($_SERVER['REQUEST_URI'],'admin/menus') !== FALSE  ){
       $headScript = new Zend_View_Helper_HeadScript();
  	  $headScript->appendFile($baseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');
      $headScript->appendFile($baseUrl . 'application/modules/Sesatoz/externals/scripts/admin.js');
    }


    $this->initViewHelperPath();
    $layout = Zend_Layout::getMvcInstance();
    $layout->getView()
            ->addFilterPath(APPLICATION_PATH . "/application/modules/Sesatoz/View/Filter", 'Sesatoz_View_Filter_')
            ->addFilter('Bodyclass');

	}

  protected function _initFrontController() {

    $this->initActionHelperPath();
    Zend_Controller_Action_HelperBroker::addHelper(new Sesatoz_Controller_Action_Helper_LoginError());
    include APPLICATION_PATH . '/application/modules/Sesatoz/controllers/Checklicense.php';
  }
}
