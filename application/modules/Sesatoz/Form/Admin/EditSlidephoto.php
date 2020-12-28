<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: EditSlidephoto.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_EditSlidephoto extends Sesatoz_Form_Admin_Slidephoto {

  public function init() {

    parent::init();
    $this->setTitle('Edit Slide');
    $this->submit->setLabel('Save Changes');
  }

}