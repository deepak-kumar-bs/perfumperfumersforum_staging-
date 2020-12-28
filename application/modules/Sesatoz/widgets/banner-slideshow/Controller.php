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

class Sesatoz_Widget_BannerSlideshowController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->full_width = $this->_getParam('full_width', 1);
    $this->view->height = $this->_getParam('height', '583');
    $this->view->banner_id = $banner_id = $this->_getParam('banner_id', 0);
    $sesatoz_bannerwidget = Zend_Registry::isRegistered('sesatoz_bannerwidget') ? Zend_Registry::get('sesatoz_bannerwidget') : null;
    if(empty($sesatoz_bannerwidget)) {
      return $this->setNoRender();
    }
    if (!$banner_id)
      return $this->setNoRender();

    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesatoz')->getSlides($banner_id,'',true);
    if (count($paginator) == 0)
      return $this->setNoRender();

	}
}
