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

class Sesatoz_Widget_FeaturesController extends Engine_Content_Widget_Abstract {

    public function indexAction() {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $this->view->design = $this->_getParam('design', 1);
        $this->view->heading = $settings->getSetting('sesatoz.feature.heading', '');
        $this->view->caption = $settings->getSetting('sesatoz.feature.caption', '');
        $this->view->bgimage = $settings->getSetting('sesatoz.feature.bgimage', '');
        $this->view->content = $settings->getSetting('sesatoz.feature.content', '');
        if(!$this->view->content)
        $this->setNoRender();
    }
}
