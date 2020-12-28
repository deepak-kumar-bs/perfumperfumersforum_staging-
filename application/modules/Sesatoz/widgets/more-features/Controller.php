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

class Sesatoz_Widget_MoreFeaturesController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->storage = Engine_Api::_()->storage();

    $this->view->fe1img = $this->_getParam('fe1img', 'application/modules/Sesatoz/externals/images/f1.svg');
    $this->view->fe1heading = $this->_getParam('fe1heading', 'NO ADS');
    $this->view->fe1description = $this->_getParam('fe1description', "We don’t display ads or related publications anywhere to distract readers from your content.");
    $this->view->fe1linktext = $this->_getParam('fe1linktext', 'START PUBLISHING');
    $this->view->fe1textlink = $this->_getParam('fe1textlink', '#');

    $this->view->fe2img = $this->_getParam('fe2img', 'application/modules/Sesatoz/externals/images/f2.svg');
    $this->view->fe2heading = $this->_getParam('fe2heading', 'SHARING');
    $this->view->fe2description = $this->_getParam('fe2description', "Paste the link on social media to share your flipbook with followers, deliver it as email newsletter or embed it on your website. You have so many options!");
    $this->view->fe2linktext = $this->_getParam('fe2linktext', 'SHARE YOUR PUBLICATIONS');
    $this->view->fe2textlink = $this->_getParam('fe2textlink', '#');

    $this->view->fe3img = $this->_getParam('fe3img', 'application/modules/Sesatoz/externals/images/f3.svg');
    $this->view->fe3heading = $this->_getParam('fe3heading', 'INSIGHTS');
    $this->view->fe3description = $this->_getParam('fe3description', "We provide detailed real-time data analytics through our platform and Google Analytics.");
    $this->view->fe3linktext = $this->_getParam('fe3linktext', 'GET INSIGHTS');
    $this->view->fe3textlink = $this->_getParam('fe3textlink', '#');

    $this->view->fe4img = $this->_getParam('fe4img', 'application/modules/Sesatoz/externals/images/f4.svg');
    $this->view->fe4heading = $this->_getParam('fe4heading', 'NO ADS');
    $this->view->fe4description = $this->_getParam('fe4description', "We don’t display ads or related publications anywhere to distract readers from your content.");
    $this->view->fe4linktext = $this->_getParam('fe4linktext', 'START PUBLISHING');
    $this->view->fe4textlink = $this->_getParam('fe4textlink', '#');

  }
}
