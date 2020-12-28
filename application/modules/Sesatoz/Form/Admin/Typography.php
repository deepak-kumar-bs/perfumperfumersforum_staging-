<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Typography.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_Typography extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Fonts / Typography Settings')
            ->setDescription('Here, you can configure the font settings in this theme on your website. You can also choose to enable the Google Fonts.');
            
    $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
    
    $ch = curl_init();
  
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec($ch);
    curl_close($ch);

    $results = json_decode($data,true);
    
    $googleFontArray = array();
    foreach($results['items'] as $re) {
      $googleFontArray['"'.$re["family"].'"'] = $re['family'];
    }

    $this->addElement('Select', 'sesatoz_googlefonts', array(
      'label' => 'Choose Fonts',
      'description' => 'Choose from below the Fonts which you want to enable in this theme.',
      'multiOptions' => array(
        '0' => 'Web Safe Font Combinations',
        '1' => 'Google Fonts',
      ),
      'onchange' => "usegooglefont(this.value)",
      'value' => $settings->getSetting('sesatoz.googlefonts', 0),
    ));
    
    $font_array = array(
      'Georgia, serif' => 'Georgia, serif',
      '"Palatino Linotype", "Book Antiqua", Palatino, serif' => '"Palatino Linotype", "Book Antiqua", Palatino, serif',
      '"Times New Roman", Times, serif' => '"Times New Roman", Times, serif',
      'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
      '"Arial Black", Gadget, sans-serif' => '"Arial Black", Gadget, sans-serif',
      '"Comic Sans MS", cursive, sans-serif' => '"Comic Sans MS", cursive, sans-serif',
      'Impact, Charcoal, sans-serif' => 'Impact, Charcoal, sans-serif',
      '"Lucida Sans Unicode", "Lucida Grande", sans-serif' => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
      'Tahoma, Geneva, sans-serif' => 'Tahoma, Geneva, sans-serif',
      '"Trebuchet MS", Helvetica, sans-serif' => '"Trebuchet MS", Helvetica, sans-serif',
      'Verdana, Geneva, sans-serif' => 'Verdana, Geneva, sans-serif',
      '"Courier New", Courier, monospace' => '"Courier New", Courier, monospace',
      '"Lucida Console", Monaco, monospace' => '"Lucida Console", Monaco, monospace',
    );
    
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $link = '<a href="http://www.w3schools.com/cssref/css_websafe_fonts.asp" target="_blank">here</a>.';
    $bodyDes = sprintf('You can see the web safe fonts %s',$link);
    $headingDes = sprintf('You can see the web safe fonts %s',$link);
    $mainmenuDes = sprintf('You can see the web safe fonts %s',$link);
    $tabDes = sprintf('You can see the web safe fonts %s',$link);
    
    //Google Font Work
    $link = '<a href="https://www.google.com/fonts" target="_blank">here</a>.';
    $bodygoogleDes = sprintf('You can see the google fonts %s',$link);
    $headinggoogleDes = sprintf('You can see the google fonts %s',$link);
    $mainmenugoogleDes = sprintf('You can see the google fonts %s',$link);
    $tabgoogleDes = sprintf('You can see the google fonts %s',$link);
    
    //Body Settings

    $this->addElement('Select', 'sesatoz_body_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_body_fontfamily'),
    ));
    $this->getElement('sesatoz_body_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesatoz_body_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_body_fontsize'),
    ));
    $this->getElement('sesatoz_body_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_body_fontfamily', 'sesatoz_body_fontsize'), 'sesatoz_bodygrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_bodygrp = $this->getDisplayGroup('sesatoz_bodygrp');
    $sesatoz_bodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_bodygrp'))));

    //Google Font work
    $this->addElement('Select', 'sesatoz_googlebody_fontfamily', array(
      'label' => 'Body - Font Family',
      'description' => "Choose font family for the text under Body Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_body_fontfamily'),
    ));
    $this->getElement('sesatoz_googlebody_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesatoz_googlebody_fontsize', array(
      'label' => 'Body - Font Size',
      'description' => 'Enter the font size for the text under Body Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_body_fontsize'),
    ));
    $this->getElement('sesatoz_googlebody_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_googlebody_fontfamily', 'sesatoz_googlebody_fontsize'), 'sesatoz_googlebodygrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_googlebodygrp = $this->getDisplayGroup('sesatoz_googlebodygrp');
    $sesatoz_googlebodygrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_googlebodygrp'))));
    

    //Heading Settings
    $this->addElement('Select', 'sesatoz_heading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_heading_fontfamily'),
    ));
    $this->getElement('sesatoz_heading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesatoz_heading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_heading_fontsize'),
    ));
    $this->getElement('sesatoz_heading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_heading_fontfamily', 'sesatoz_heading_fontsize'), 'sesatoz_headinggrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_headinggrp = $this->getDisplayGroup('sesatoz_headinggrp');
    $sesatoz_headinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_headinggrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesatoz_googleheading_fontfamily', array(
      'label' => 'Heading - Font Family',
      'description' => "Choose font family for the text under Heading Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_heading_fontfamily'),
    ));
    $this->getElement('sesatoz_googleheading_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesatoz_googleheading_fontsize', array(
      'label' => 'Heading - Font Size',
      'description' => 'Enter the font size for the text under Heading Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_heading_fontsize'),
    ));
    $this->getElement('sesatoz_googleheading_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_googleheading_fontfamily', 'sesatoz_googleheading_fontsize'), 'sesatoz_googleheadinggrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_googleheadinggrp = $this->getDisplayGroup('sesatoz_googleheadinggrp');
    $sesatoz_googleheadinggrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_googleheadinggrp'))));

    //Main Menu Settings
    $this->addElement('Select', 'sesatoz_mainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_mainmenu_fontfamily'),
    ));
    $this->getElement('sesatoz_mainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
            
    $this->addElement('Text', 'sesatoz_mainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_mainmenu_fontsize'),
    ));
    $this->getElement('sesatoz_mainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_mainmenu_fontfamily', 'sesatoz_mainmenu_fontsize'), 'sesatoz_mainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_mainmenugrp = $this->getDisplayGroup('sesatoz_mainmenugrp');
    $sesatoz_mainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_mainmenugrp'))));
    
    //Google Font work
    $this->addElement('Select', 'sesatoz_googlemainmenu_fontfamily', array(
      'label' => 'Main Menu - Font Family',
      'description' => "Choose font family for the text under Main Menu Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_mainmenu_fontfamily'),
    ));
    $this->getElement('sesatoz_googlemainmenu_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesatoz_googlemainmenu_fontsize', array(
      'label' => 'Main Menu - Font Size',
      'description' => 'Enter the font size for the text under Main Menu Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_mainmenu_fontsize'),
    ));
    $this->getElement('sesatoz_googlemainmenu_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_googlemainmenu_fontfamily', 'sesatoz_googlemainmenu_fontsize'), 'sesatoz_googlemainmenugrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_googlemainmenugrp = $this->getDisplayGroup('sesatoz_googlemainmenugrp');
    $sesatoz_googlemainmenugrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_googlemainmenugrp'))));
    

    //Tab Settings
    $this->addElement('Select', 'sesatoz_tab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $font_array,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_tab_fontfamily'),
    ));
    $this->getElement('sesatoz_tab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    $this->addElement('Text', 'sesatoz_tab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_tab_fontsize'),
    ));
    $this->getElement('sesatoz_tab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_tab_fontfamily', 'sesatoz_tab_fontsize'), 'sesatoz_tabgrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_tabgrp = $this->getDisplayGroup('sesatoz_tabgrp');
    $sesatoz_tabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_tabgrp'))));
    
    
    //Google Font work
    $this->addElement('Select', 'sesatoz_googletab_fontfamily', array(
      'label' => 'Tab - Font Family',
      'description' => "Choose font family for the text under Tab Styling.",
      'multiOptions' => $googleFontArray,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_tab_fontfamily'),
    ));
    $this->getElement('sesatoz_googletab_fontfamily')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
    
    $this->addElement('Text', 'sesatoz_googletab_fontsize', array(
      'label' => 'Tab - Font Size',
      'description' => 'Enter the font size for the text under Tab Styling.',
      'allowEmpty' => false,
      'required' => true,
      'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_tab_fontsize'),
    ));
    $this->getElement('sesatoz_googletab_fontsize')->getDecorator('Description')->setOption('escape',false); 
    
    $this->addDisplayGroup(array('sesatoz_googletab_fontfamily', 'sesatoz_googletab_fontsize'), 'sesatoz_googletabgrp', array('disableLoadDefaultDecorators' => true));
    $sesatoz_googletabgrp = $this->getDisplayGroup('sesatoz_googletabgrp');
    $sesatoz_googletabgrp->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'sesatoz_googletabgrp'))));

    
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}