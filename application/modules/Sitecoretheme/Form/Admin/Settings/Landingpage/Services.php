<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Services.php 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitecoretheme_Form_Admin_Settings_Landingpage_Services extends Engine_Form
{
  protected $_iconRequired;

  public function setIconRequired($iconRequired) {
      $this->_iconRequired = $iconRequired;
  }

  public function init()
  {
    $this->setMethod('post')
      ->setAttrib('class', 'global_form_box');

    $this->addElement('Text', 'title', array(
      'label' => 'Service Heading',
      'required' => true,
    ));

    $this->addElement('File', 'icon', array(
        'label' => 'Upload Icon',
        'required' => ($this->_iconRequired) ? true : false,
    ));

    $this->addElement('Textarea', 'description', array(
      'label' => 'Service Description',
      'required' => true,
    ));

    // Buttons
    $this->addElement('Button', 'submit', array(
      'label' => 'Save Changes',
      'type' => 'submit',
      'ignore' => true,
      'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
      'label' => 'cancel',
      'link' => true,
      'prependText' => ' or ',
      'href' => '',
      'onClick' => 'javascript:parent.Smoothbox.close();',
      'decorators' => array(
        'ViewHelper'
      )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
    $button_group = $this->getDisplayGroup('buttons');

  }

}

?>