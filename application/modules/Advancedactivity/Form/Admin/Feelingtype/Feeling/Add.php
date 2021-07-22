<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Advancedactivity
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Add.php 6590 2016-07-07 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Advancedactivity_Form_Admin_Feelingtype_Feeling_Add extends Advancedactivity_Form_Admin_Feelingtype_Create {
  public function init() {

    // Init form
    $this
      ->setTitle('Add more feelings')
      ->setDescription('Upload feelings from your computer to add to this feeling feelingtypes.')
      ->setAttrib('id', 'form-upload')
      ->setAttrib('name', 'admin_feelingtype_add_more')
      ->setAttrib('enctype', 'multipart/form-data')
      ->setAttrib('class', 'global_form')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
    ;


    $this->addElement('File', 'file', array(
      'label' => "Choose Photo",
      'allowEmpty' => true,
      'required' => false,
    ));
    $this->file->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');

    // Init submit
    $this->addElement('Button', 'submit', array(
      'label' => 'Save',
      'type' => 'submit',
      'order' => 999
    ));
  }

}
