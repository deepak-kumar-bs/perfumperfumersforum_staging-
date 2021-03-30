<?php

class Sitereview_Form_Searchhashtag extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'sitereview_filter_form_custom',
        'class' => 'global_form_box',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(
        array('module' => 'sitereview', 'controller' => 'hashtagfeed', 'action' => 'index'),
        "default",
        true
      ))
      ->setMethod('GET')
      ;

    $this->addElement('Text', 'search', array(
      'label' => 'Search Hashtags',
      // 'required' => true,
      // 'allowEmpty' => false,
    ));

    $this->addElement('Hidden', 'content_type', array(
      'value' => 'sitereview_listing',
    ));

    // $this->addElement('Select', 'order', array(
    //   'label' => 'Order By',
    //   'multiOptions' => array(
    //     '' => 'Most Recent',
    //   ),
    // ));

    

    $this->addElement('Button', 'submit', array(
      'type' => 'submit',
      'label' => 'Search',
    ));
  }
}
