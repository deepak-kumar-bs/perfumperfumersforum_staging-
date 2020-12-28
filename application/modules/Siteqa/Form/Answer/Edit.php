<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Question.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Siteqa_Form_Answer_Edit extends Siteqa_Form_Answer {

    public function init()
  {
    parent::init();
    $this->setTitle('Edit an Answer')
    ->setDescription('Edit your Answer below, then click on "Save Changes" to post an Answer to your Question.');
    $this->submit->setLabel('Save Changes');
  }

}
