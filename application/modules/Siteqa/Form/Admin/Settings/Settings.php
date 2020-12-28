<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Settings.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Siteqa_Form_Admin_Settings_Settings extends Engine_Form
{
  public function init()
  {
    $this
    ->setTitle('Global Settings')
    ->setDescription('These settings affect all members in your community.');

		$settings = Engine_Api::_()->getApi('settings', 'core');
    
    $this->addElement('Radio', 'siteqa_share', array(
        'label' => 'Allow Sharing of Questions',
        'description' => 'Do you want to allow members to share questions?',
        'multiOptions' => array(
          1 => 'Yes',
          0 => 'No'
        ),
        'value' => $settings->getSetting('siteqa.share', 1),
      ));

		$this->addElement('Radio', 'siteqa_tag', array(
    	'label' => 'Tag Field',
      'description' => 'Do you want the Tag field to be displayed in the Question creation form? (Assigning tags to Question will enable the tags to appear in the Tag Cloud. Tags of Question will be used in the SocialEngine Global Search for returning results and to return results in the Related Question widget.)',
      'multiOptions' => array(
        1 => ' 	Yes',
        0 => ' 	No'
      ),
      'value' => $settings->getSetting('siteqa.tag', 1),
    ));

    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true
    ));
  }

}