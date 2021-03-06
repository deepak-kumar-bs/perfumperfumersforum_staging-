<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2012-2013 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Edit.php 6590 2013-04-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitereview_Form_Wishlist_Edit extends Sitereview_Form_Wishlist_Create {

  public function init() {
    
    parent::init();
    $this->setTitle('Edit Wishlist')
            ->setDescription('Edit your wishlist over here and then click on "Save Changes" to save it.');
    $this->submit->setLabel('Save Changes');
  }

}