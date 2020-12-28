<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: WidgetController.php
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Form_Search extends Engine_Form
{
  public function init()
  {
    $this->setAttribs(array(
      'id' => 'filter_form',
      'class' => 'global_form_box',
    ))
    ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
    ->setMethod('GET')
    ;
    
    $this->addElement('Text', 'search', array(
      'label' => 'Search Questions',
    ));

    $onChangeEvent = "categoryAction(this.value,this.name,0,'');";
    $this->addElement('Select', 'category', array(
      'label' => 'Category',
      'multiOptions' => array(
        '0' => 'All Categories',
      ),
      'onchange' => $onChangeEvent,
    ));

    $this->addElement('Button', 'find', array(
      'type' => 'submit',
      'label' => 'Search',
      'ignore' => true,
      'order' => 10000001,
    ));

    $this->addElement('Hidden', 'page', array(
      'order' => 100
    ));

    $this->addElement('Hidden', 'tag', array(
      'order' => 101
    ));

    $this->addElement('Hidden', 'start_date', array(
      'order' => 102
    ));

    $this->addElement('Hidden', 'end_date', array(
      'order' => 103
    ));

    $this->addElement('Hidden', 'tag_id', array(
        'order' => 104,
    ));

    // Populate category
    $categories = Engine_Api::_()->getDbtable('categories', 'siteqa')->getCategoriesAssoc();
    if( !empty($categories) && is_array($categories) ) {
      $this->category->addMultiOptions($categories);
    }
  }
}
