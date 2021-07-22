<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereaction
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Add.php 6590 2016-07-07 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Sitereaction_Form_Admin_Collection_Sticker_Add extends Sitereaction_Form_Admin_Collection_Create {
  public function init() {

    // Init form
    $this
      ->setTitle('Add more stickers')
      ->setDescription('Upload stickers from your computer to add to this sticker collection.')
      ->setAttrib('id', 'form-upload')
      ->setAttrib('name', 'admin_collection_add_more')
      ->setAttrib('enctype', 'multipart/form-data')
      ->setAttrib('class', 'global_form')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
    ;

    $this->addElement('File', 'file', array(
      'label' => "Choose Photo",
      'Description' => 'Click "Choose File" to select stickers from your computer and click the button below your sticker list to save them to your collection.',
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
