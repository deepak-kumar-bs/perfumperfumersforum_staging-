<?php

class Seaocore_Form_SearchHashtags extends Engine_Form
{
  public function init()
  {
    $this
      ->setAttribs(array(
        'id' => 'filter_form',
        'class' => 'global_form_box hasgtag_custom_form',
      ))
      ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
      ->setMethod('GET')
      ;

    $this->addElement('Text', 'search', array(
      'label' => 'Search Hashtags',
      'description' => Zend_Registry::get('Zend_Translate')->_('Separate tags with Hash(#).'),
      // 'required' => true,
      // 'allowEmpty' => false,
    ));
    $this->search->getDecorator("Description")->setOption("placement", "append");

    $this->addElement('MultiCheckbox', 'content_type', array(
      'label' => 'Show Only',
      'multiOptions' => array(
        // ''   => 'All'
      ),
      // 'value' => array(''),
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
