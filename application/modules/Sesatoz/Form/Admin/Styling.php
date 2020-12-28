<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Styling.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_Styling extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $sesatozApi = Engine_Api::_()->sesatoz();
    $this->setTitle('Manage Color Schemes')
            ->setDescription('Here, you can manage the color schemes of your website.');

    $this->addElement('Radio', 'theme_color', array(
        'label' => 'Light Color Schemes',
        'multiOptions' => array(
            1 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/1.png" alt="" />',
            2 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/2.png" alt="" />',
            3 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/3.png" alt="" />',
            4 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/4.png" alt="" />',
            6 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/5.png" alt="" />',
            7 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/6.png" alt="" />',
            8 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/7.png" alt="" />',
            9 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/8.png" alt="" />',
            10 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/9.png" alt="" />',
            11 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/10.png" alt="" />',
            12 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/11.png" alt="" />',
            13 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/12.png" alt="" />',
            5 => '<img src="./application/modules/Sesatoz/externals/images/color-scheme/custom.png" alt="" />',
        ),
        'onchange' => 'changeThemeColor(this.value, "")',
        'escape' => false,
        'value' => $sesatozApi->getContantValueXML('theme_color'),
    ));

    $activatedTheme = $sesatozApi->getContantValueXML('custom_theme_color');

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);
    if($customtheme_id) {
      $customtheme_value = $customtheme_id;
    } else {
      $customtheme_value = $sesatozApi->getContantValueXML('custom_theme_color');
    }

//     $sestheme = array(
//       //5 => 'New Custom',
//       1 => 'Theme - 1',
//       2 => 'Theme - 2',
//       3 => 'Theme - 3',
//       4 => 'Theme - 4',
//       6 => 'Theme - 5',
//       7 => 'Theme - 6',
//       8 => 'Theme - 7',
//       9 => 'Theme - 8',
//       10 => 'Theme - 9',
//       11 => 'Theme - 10',
//       12 => 'Theme - 11',
//       13 => 'Theme - 12'
//     );

    $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesatoz')->getCustomThemes(array('all' => 1));
    foreach($getCustomThemes as $getCustomTheme){
      $sestheme[$getCustomTheme['theme_id']] = $getCustomTheme['name'];
    }

    $this->addElement('Select', 'custom_theme_color', array(
        'label' => 'Custom Theme Color',
        'multiOptions' => $sestheme,
        'onclick' => 'changeCustomThemeColor(this.value)',
        'escape' => false,
        'value' => $customtheme_value, //$sesatozApi->getContantValueXML('custom_theme_color'),
    ));

    $this->addElement('dummy', 'custom_themes', array(
      'decorators' => array(array('ViewScript', array(
        'viewScript' => 'application/modules/Sesatoz/views/scripts/custom_themes.tpl',
        'class' => 'form element',
        'customtheme_id' => $customtheme_id,
        'activatedTheme' => $activatedTheme,
      )))
    ));


    $theme_color = $sesatozApi->getContantValueXML('theme_color');
    if($theme_color == '5') {
    	$sesatoz_header_background_color = $settings->getSetting('sesatoz.header.background.color');
			$sesatoz_menu_logo_font_color = $settings->getSetting('sesatoz.menu.logo.font.color');
			$sesatoz_mainmenu_background_color = $settings->getSetting('sesatoz.mainmenu.background.color');
			$sesatoz_mainmenu_links_color = $settings->getSetting('sesatoz.mainmenu.links.color');
			$sesatoz_mainmenu_links_background_color_hover = $settings->getSetting('sesatoz.mainmenu.links.background.color.hover');
			$sesatoz_mainmenu_links_hover_color = $settings->getSetting('sesatoz.mainmenu.links.hover.color');
			$sesatoz_minimenu_links_color = $settings->getSetting('sesatoz.minimenu.links.color');
			$sesatoz_minimenu_links_hover_color = $settings->getSetting('sesatoz.minimenu.links.hover.color');
			$sesatoz_minimenu_icon_background_color = $settings->getSetting('sesatoz.minimenu.icon.background.color');
			$sesatoz_minimenu_icon_background_active_color = $settings->getSetting('sesatoz.minimenu.icon.background.active.color');
			$sesatoz_minimenu_icon_color = $settings->getSetting('sesatoz.minimenu.icon.color');
			$sesatoz_minimenu_icon_active_color = $settings->getSetting('sesatoz.minimenu.icon.active.color');
			$sesatoz_header_searchbox_background_color = $settings->getSetting('sesatoz.header.searchbox.background.color');
			$sesatoz_header_searchbox_text_color = $settings->getSetting('sesatoz.header.searchbox.text.color');
			$sesatoz_login_popup_header_font_color = $settings->getSetting('sesatoz.login.popup.header.font.color');
			$sesatoz_footer_background_color = $settings->getSetting('sesatoz.footer.background.color');
			$sesatoz_footer_heading_color = $settings->getSetting('sesatoz.footer.heading.color');
			$sesatoz_footer_links_color = $settings->getSetting('sesatoz.footer.links.color');
			$sesatoz_footer_links_hover_color = $settings->getSetting('sesatoz.footer.links.hover.color');
			$sesatoz_footer_border_color = $settings->getSetting('sesatoz.footer.border.color');
			$sesatoz_theme_color = $settings->getSetting('sesatoz.theme.color');
			$sesatoz_body_background_color = $settings->getSetting('sesatoz.body.background.color');
			$sesatoz_font_color = $settings->getSetting('sesatoz.fontcolor');
			$sesatoz_font_color_light = $settings->getSetting('sesatoz.font.color.light');
			$sesatoz_heading_color = $settings->getSetting('sesatoz.heading.color');
			$sesatoz_links_color = $settings->getSetting('sesatoz.links.color');
			$sesatoz_links_hover_color = $settings->getSetting('sesatoz.links.hover.color');
			$sesatoz_content_header_background_color = $settings->getSetting('sesatoz.content.header.background.color');
			$sesatoz_content_header_font_color = $settings->getSetting('sesatoz.content.header.font.color');
			$sesatoz_content_background_color = $settings->getSetting('sesatoz.content.background.color');
			$sesatoz_content_border_color = $settings->getSetting('sesatoz.content.border.color');
			$sesatoz_form_label_color = $settings->getSetting('sesatoz.form.label.color');
			$sesatoz_input_background_color = $settings->getSetting('sesatoz.input.background.color');
			$sesatoz_input_font_color = $settings->getSetting('sesatoz.input.font.color');
			$sesatoz_input_border_color = $settings->getSetting('sesatoz.input.border.color');
			$sesatoz_button_background_color = $settings->getSetting('sesatoz.button.backgroundcolor');
			$sesatoz_button_background_color_hover = $settings->getSetting('sesatoz.button.background.color.hover');
			$sesatoz_button_font_color = $settings->getSetting('sesatoz.button.font.color');
			$sesatoz_button_font_hover_color = $settings->getSetting('sesatoz.button.font.hover.color');
			$sesatoz_comment_background_color = $settings->getSetting('sesatoz.comment.background.color');

    } else {
	    $sesatoz_header_background_color = $sesatozApi->getContantValueXML('sesatoz_header_background_color');
			$sesatoz_menu_logo_font_color = $sesatozApi->getContantValueXML('sesatoz_menu_logo_font_color');
			$sesatoz_mainmenu_background_color = $sesatozApi->getContantValueXML('sesatoz_mainmenu_background_color');
			$sesatoz_mainmenu_links_color = $sesatozApi->getContantValueXML('sesatoz_mainmenu_links_color');
			$sesatoz_mainmenu_links_background_color_hover = $sesatozApi->getContantValueXML('sesatoz_mainmenu_links_background_color_hover');
			$sesatoz_mainmenu_links_hover_color = $sesatozApi->getContantValueXML('sesatoz_mainmenu_links_hover_color');
			$sesatoz_minimenu_links_color = $sesatozApi->getContantValueXML('sesatoz_minimenu_links_color');
			$sesatoz_minimenu_links_hover_color = $sesatozApi->getContantValueXML('sesatoz_minimenu_links_hover_color');
			$sesatoz_minimenu_icon_background_color = $settings->getSetting('sesatoz_minimenu_icon_background_color');
			$sesatoz_minimenu_icon_background_active_color = $settings->getSetting('sesatoz_minimenu_icon_background_active_color');
			$sesatoz_minimenu_icon_color = $sesatozApi->getContantValueXML('sesatoz_minimenu_icon_color');
			$sesatoz_minimenu_icon_active_color = $sesatozApi->getContantValueXML('sesatoz_minimenu_icon_active_color');
			$sesatoz_header_searchbox_background_color = $sesatozApi->getContantValueXML('sesatoz_header_searchbox_background_color');
			$sesatoz_header_searchbox_text_color = $sesatozApi->getContantValueXML('sesatoz_header_searchbox_text_color');

			$sesatoz_toppanel_userinfo_background_color = $settings->getSetting('sesatoz_toppanel_userinfo_background_color');
			$sesatoz_toppanel_userinfo_font_color = $settings->getSetting('sesatoz_toppanel_userinfo_font_color');

			$sesatoz_footer_background_color = $sesatozApi->getContantValueXML('sesatoz_footer_background_color');
			$sesatoz_footer_heading_color = $sesatozApi->getContantValueXML('sesatoz_footer_heading_color');
			$sesatoz_footer_links_color = $sesatozApi->getContantValueXML('sesatoz_footer_links_color');
			$sesatoz_footer_links_hover_color = $sesatozApi->getContantValueXML('sesatoz_footer_links_hover_color');
			$sesatoz_footer_border_color = $sesatozApi->getContantValueXML('sesatoz_footer_border_color');
			$sesatoz_theme_color = $sesatozApi->getContantValueXML('sesatoz_theme_color');
			$sesatoz_body_background_color = $sesatozApi->getContantValueXML('sesatoz_body_background_color');
			$sesatoz_font_color = $sesatozApi->getContantValueXML('sesatoz_font_color');
			$sesatoz_font_color_light = $sesatozApi->getContantValueXML('sesatoz_font_color_light');
			$sesatoz_heading_color = $sesatozApi->getContantValueXML('sesatoz_heading_color');
			$sesatoz_links_color = $sesatozApi->getContantValueXML('sesatoz_links_color');
			$sesatoz_links_hover_color = $sesatozApi->getContantValueXML('sesatoz_links_hover_color');
			$sesatoz_content_header_background_color = $sesatozApi->getContantValueXML('sesatoz_content_header_background_color');
			$sesatoz_content_header_font_color = $sesatozApi->getContantValueXML('sesatoz_content_header_font_color');
			$sesatoz_content_background_color = $sesatozApi->getContantValueXML('sesatoz_content_background_color');
			$sesatoz_content_border_color = $sesatozApi->getContantValueXML('sesatoz_content_border_color');
			$sesatoz_form_label_color = $sesatozApi->getContantValueXML('sesatoz_form_label_color');
			$sesatoz_input_background_color = $sesatozApi->getContantValueXML('sesatoz_input_background_color');
			$sesatoz_input_font_color = $sesatozApi->getContantValueXML('sesatoz_input_font_color');
			$sesatoz_input_border_color = $sesatozApi->getContantValueXML('sesatoz_input_border_color');
			$sesatoz_button_background_color = $sesatozApi->getContantValueXML('sesatoz_button_background_color');
			$sesatoz_button_background_color_hover = $sesatozApi->getContantValueXML('sesatoz_button_background_color_hover');
			$sesatoz_button_font_color = $sesatozApi->getContantValueXML('sesatoz_button_font_color');
			$sesatoz_button_font_hover_color = $sesatozApi->getContantValueXML('sesatoz_button_font_hover_color');
			$sesatoz_comment_background_color = $sesatozApi->getContantValueXML('sesatoz_comment_background_color');
    }

    //Start Header Styling
    $this->addElement('Dummy', 'header_settings', array(
        'label' => 'Header Styling Settings',
    ));
    $this->addElement('Text', "sesatoz_header_background_color", array(
        'label' => 'Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_header_background_color,
    ));

    $this->addElement('Text', "sesatoz_menu_logo_font_color", array(
        'label' => 'Menu Logo Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_menu_logo_font_color,
    ));

    $this->addElement('Text', "sesatoz_mainmenu_background_color", array(
        'label' => 'Main Menu Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_mainmenu_background_color,
    ));

    $this->addElement('Text', "sesatoz_mainmenu_links_color", array(
        'label' => 'Main Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_mainmenu_links_color,
    ));
 $this->addElement('Text', "sesatoz_mainmenu_links_background_color_hover", array(
        'label' => 'Main Menu Background Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_mainmenu_links_background_color_hover,
    ));
    $this->addElement('Text', "sesatoz_mainmenu_links_hover_color", array(
        'label' => 'Main Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_mainmenu_links_hover_color,
    ));

    $this->addElement('Text', "sesatoz_minimenu_links_color", array(
        'label' => 'Mini Menu Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_links_color,
    ));

    $this->addElement('Text', "sesatoz_minimenu_links_hover_color", array(
        'label' => 'Mini Menu Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_links_hover_color,
    ));

    $this->addElement('Text', "sesatoz_minimenu_icon_background_color", array(
        'label' => 'Mini Menu Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_icon_background_color,
    ));
    $this->addElement('Text', "sesatoz_minimenu_icon_background_active_color", array(
        'label' => 'Mini Menu Active Icon Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_icon_background_active_color,
    ));

    $this->addElement('Text', "sesatoz_minimenu_icon_color", array(
        'label' => 'Mini Menu Icon Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_icon_color,
    ));
    $this->addElement('Text', "sesatoz_minimenu_icon_active_color", array(
        'label' => 'Mini Menu Icon Active Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_minimenu_icon_active_color,
    ));

    $this->addElement('Text', "sesatoz_header_searchbox_background_color", array(
        'label' => 'Header Searchbox Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_header_searchbox_background_color,
    ));

    $this->addElement('Text', "sesatoz_header_searchbox_text_color", array(
        'label' => 'Header Searchbox Text Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_header_searchbox_text_color,
    ));

    //Top Panel Color
    $this->addElement('Text', "sesatoz_toppanel_userinfo_background_color", array(
        'label' => 'Background Color for User section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_toppanel_userinfo_background_color,
    ));
    $this->addElement('Text', "sesatoz_toppanel_userinfo_font_color", array(
        'label' => 'Font Color for User Section in Main Menu',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_toppanel_userinfo_font_color,
    ));
    //Top Panel Color


    $this->addDisplayGroup(array('sesatoz_header_background_color', 'sesatoz_menu_logo_font_color', 'sesatoz_mainmenu_background_color', 'sesatoz_mainmenu_links_color', 'sesatoz_mainmenu_links_background_color_hover', 'sesatoz_mainmenu_links_hover_color', 'sesatoz_minimenu_links_color', 'sesatoz_minimenu_links_hover_color', 'sesatoz_minimenu_icon_background_color', 'sesatoz_minimenu_icon_background_active_color', 'sesatoz_minimenu_icon_color', 'sesatoz_minimenu_icon_active_color',  'sesatoz_header_searchbox_background_color', 'sesatoz_header_searchbox_text_color','sesatoz_toppanel_userinfo_background_color','sesatoz_toppanel_userinfo_font_color'), 'header_settings_group', array('disableLoadDefaultDecorators' => true));
    $header_settings_group = $this->getDisplayGroup('header_settings_group');
    $header_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'header_settings_group'))));
    //End Header Styling
    //Start Footer Styling
    $this->addElement('Dummy', 'footer_settings', array(
        'label' => 'Footer Styling Settings',
    ));
    $this->addElement('Text', "sesatoz_footer_background_color", array(
        'label' => 'Footer Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_footer_background_color,
    ));

//     $this->addElement('Text', "sesatoz_footer_heading_color", array(
//         'label' => 'Footer Heading Color',
//         'allowEmpty' => false,
//         'required' => true,
//         'class' => 'SEScolor',
//         'value' => $sesatoz_footer_heading_color,
//     ));

    $this->addElement('Text', "sesatoz_footer_links_color", array(
        'label' => 'Footer Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_footer_links_color,
    ));

    $this->addElement('Text', "sesatoz_footer_links_hover_color", array(
        'label' => 'Footer Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_footer_links_hover_color,
    ));
    $this->addDisplayGroup(array('sesatoz_footer_background_color', 'sesatoz_footer_heading_color', 'sesatoz_footer_links_color', 'sesatoz_footer_links_hover_color'), 'footer_settings_group', array('disableLoadDefaultDecorators' => true));
    $footer_settings_group = $this->getDisplayGroup('footer_settings_group');
    $footer_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'footer_settings_group'))));
    //End Footer Styling
    //Start Body Styling
    $this->addElement('Dummy', 'body_settings', array(
        'label' => 'Body Styling Settings',
    ));
    $this->addElement('Text', "sesatoz_theme_color", array(
        'label' => 'Theme Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_theme_color,
    ));


    $this->addElement('Text', "sesatoz_body_background_color", array(
        'label' => 'Body Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_body_background_color,
    ));

    $this->addElement('Text', "sesatoz_font_color", array(
        'label' => 'Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_font_color,
    ));

    $this->addElement('Text', "sesatoz_font_color_light", array(
        'label' => 'Font Light Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_font_color_light,
    ));

    $this->addElement('Text', "sesatoz_heading_color", array(
        'label' => 'Heading Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_heading_color,
    ));

    $this->addElement('Text', "sesatoz_links_color", array(
        'label' => 'Link Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_links_color,
    ));

    $this->addElement('Text', "sesatoz_links_hover_color", array(
        'label' => 'Link Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_links_hover_color,
    ));

    $this->addElement('Text', "sesatoz_content_header_background_color", array(
        'label' => 'Content Header Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_content_header_background_color,
    ));
    $this->addElement('Text', "sesatoz_content_header_font_color", array(
        'label' => 'Content Header Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_content_header_font_color,
    ));

    $this->addElement('Text', "sesatoz_content_background_color", array(
        'label' => 'Content Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_content_background_color,
    ));

    $this->addElement('Text', "sesatoz_content_border_color", array(
        'label' => 'Content Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_content_border_color,
    ));

    $this->addElement('Text', "sesatoz_form_label_color", array(
        'label' => 'Form Label Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_form_label_color,
    ));

    $this->addElement('Text', "sesatoz_input_background_color", array(
        'label' => 'Input Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_input_background_color,
    ));

    $this->addElement('Text', "sesatoz_input_font_color", array(
        'label' => 'Input Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_input_font_color,
    ));

    $this->addElement('Text', "sesatoz_input_border_color", array(
        'label' => 'Input Border Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_input_border_color,
    ));

    $this->addElement('Text', "sesatoz_button_background_color", array(
        'label' => 'Button Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_button_background_color,
    ));
    $this->addElement('Text', "sesatoz_button_background_color_hover", array(
        'label' => 'Button Background Hovor Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_button_background_color_hover,
    ));

    $this->addElement('Text', "sesatoz_button_font_color", array(
        'label' => 'Button Font Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_button_font_color,
    ));
    $this->addElement('Text', "sesatoz_button_font_hover_color", array(
        'label' => 'Button Font Hover Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_button_font_hover_color,
    ));
    $this->addElement('Text', "sesatoz_comment_background_color", array(
        'label' => 'Comments Background Color',
        'allowEmpty' => false,
        'required' => true,
        'class' => 'SEScolor',
        'value' => $sesatoz_comment_background_color,
    ));


    $this->addDisplayGroup(array('sesatoz_theme_color','sesatoz_body_background_color', 'sesatoz_font_color', 'sesatoz_font_color_light', 'sesatoz_heading_color', 'sesatoz_links_color', 'sesatoz_links_hover_color', 'sesatoz_content_header_background_color', 'sesatoz_content_header_font_color', 'sesatoz_content_background_color', 'sesatoz_content_border_color', 'sesatoz_form_label_color', 'sesatoz_input_background_color', 'sesatoz_input_font_color', 'sesatoz_input_border_color', 'sesatoz_button_background_color', 'sesatoz_button_background_color_hover', 'sesatoz_button_font_color', 'sesatoz_button_font_hover_color', 'sesatoz_comment_background_color'), 'body_settings_group', array('disableLoadDefaultDecorators' => true));
    $body_settings_group = $this->getDisplayGroup('body_settings_group');
    $body_settings_group->setDecorators(array('FormElements', 'Fieldset', array('HtmlTag', array('tag' => 'div', 'id' => 'body_settings_group'))));
    //End Body Styling

    //Add submit button
    $this->addElement('Button', 'save', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addElement('Button', 'submit', array(
        'label' => 'Save as Draft',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
    $this->addDisplayGroup(array('save', 'submit'), 'buttons');
  }

}
