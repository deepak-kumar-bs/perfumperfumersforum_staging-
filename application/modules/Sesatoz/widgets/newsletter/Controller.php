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

class Sesatoz_Widget_NewsletterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();

        if(!empty($viewer_id)) {
            $isExist = Engine_Api::_()->getDbTable('newsletteremails', 'sesatoz')->isExist($viewer->email);
            if($isExist)
                return $this->setNoRender();
        }
  }

}
