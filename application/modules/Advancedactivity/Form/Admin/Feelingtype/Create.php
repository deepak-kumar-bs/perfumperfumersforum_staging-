<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Advancedactivity
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Create.php 6590 2016-07-07 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Advancedactivity_Form_Admin_Feelingtype_Create extends Engine_Form {
  public function init() {

    // Init form
    $this
      ->setTitle('Add New Feeling Type')
      ->setDescription('Here, add new feeling for your users. You can make this feeing available to users by default. 
')
      ->setAttrib('id', 'form-upload')
      ->setAttrib('name', 'admin_collection')
      ->setAttrib('enctype', 'multipart/form-data')
      ->setAttrib('class', 'global_form')
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
    ;


    // Init name
    $this->addElement('Text', 'title', array(
      'label' => 'Feeling Type Title',
      'maxlength' => '40',
      'allowEmpty' => false,
      'required' => true,
      'filters' => array(
        new Engine_Filter_HtmlSpecialChars(),
        'StripTags',
        new Engine_Filter_Censor(),
        new Engine_Filter_StringLength(array('max' => '63')),
      )
    ));
    
    $contentModuleArray = Engine_Api::_()->seaocore()->getContentModule();
    if( !empty($contentModuleArray) ) {
      $this->addElement('Multiselect', 'type', array(
        'label' => 'Activity With Content Type',
        'allowEmpty' => true,
        'multiOptions' => array_filter($contentModuleArray),
        //'onchange' => 'togglePhotoSelector(this.value)'
      ));
    }
    $this->addElement('Text', 'tagline', array(
      'label' => 'Feeling Type Tagline',
      'description' => 'Enter the tagline for this feeling type.',
      'allowEmpty' => false,
      'required' => true,
    ));
    $this->addElement('Radio', 'enabled', array(
          'label' => 'Enable / Disable',
          'description' => 'Do you want to enable this feeling type on your site?',
          'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
          ),
          'value' => 1,
        ));

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

  public function saveValues($feelingtype = null) {
    $values = $this->getValues();

    if (empty($feelingtype)) {
      $params = Array();
      $params['title'] = $values['title'];
      $params['enabled'] = $values['enabled'];
      $params['tagline'] = $values['tagline'];
      $feelingtype = Engine_Api::_()->getDbtable('feelingtypes', 'advancedactivity')->createRow(); 
      $feelingtype->setFromArray($params);
      $feelingtype->save();
    }

    //Upload Sticker
    if(!empty($values['file'])) {
      $feelingTable = Engine_Api::_()->getDbtable('feelings', 'advancedactivity');
      $feeling = $feelingTable->createRow();
      $feeling->save();

      $feeling->order = $feeling->feeling_id;
      $feeling->setSticker($this->file);
      $feeling->feelingtype_id = $feelingtype->feelingtype_id;
      $feeling->save(); 
    }

    return $feelingtype;
  }
  public function getContentItem($moduleName)
  {
    $file_path = APPLICATION_PATH . "/application/modules/" . ucfirst($moduleName) . "/settings/manifest.php";
    $contentItem = array();
    if( @file_exists($file_path) ) {
      $ret = include $file_path;
      if( isset($ret['items']) ) {

        foreach( $ret['items'] as $item )
          $contentItem[$item] = $item . " ";
      }
    }
    return $contentItem;
  }

}
