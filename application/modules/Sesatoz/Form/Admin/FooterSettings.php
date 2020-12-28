<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: FooterSettings.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_FooterSettings extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Footer Settings')
            ->setDescription('Here, you can configure the settings for the Footer of your website.');

    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;


    $banner_options[] = '';
    $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
    foreach ($path as $file) {
      if ($file->isDot() || !$file->isFile())
        continue;
      $base_name = basename($file->getFilename());
      if (!($pos = strrpos($base_name, '.')))
        continue;
      $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
      if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
        continue;
      $banner_options['public/admin/' . $base_name] = $base_name;
    }
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
    $fileLink = $view->baseUrl() . '/admin/files/';
    $this->addElement('Select', 'sesatoz_footer_background_image', array(
        'label' => 'Footer Background Image',
        'description' => 'Choose from below the footer background image for your website. [Note: You can add a new photo from the "File & Media Manager" section from here: <a href="' . $fileLink . '" target="_blank">File & Media Manager</a>.]',
        'multiOptions' => $banner_options,
        'escape' => false,
        'value' => Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_footer_background_image'),
    ));
    $this->sesatoz_footer_background_image->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

    $fileLink = $view->baseUrl() . '/admin/menus/index/name/sesatoz_quicklinks_footer';
    $this->addElement('Radio',
      'sesatoz_quicklinksenable',
      array(
          'label' => 'Enable Quick Links',
          'description' => 'Do you want to enable quick links to your preferred links in the footer? If you choose Yes, the the menu items will display which have been configured from <a href="' . $fileLink . '" target="_blank">Click Here</a>.',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>$settings->getSetting('sesatoz.quicklinksenable', '1'),
    ));
    $this->sesatoz_quicklinksenable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Radio',
      'sesatoz_helpenable',
      array(
          'label' => 'Enable Footer Menu Links',
          'description' => 'Do you want to enable the SocialEngine default <a href="admin/menus?name=core_footer" target="_blank">Footer Menu links in the footer</a>?',
          'multiOptions' => array('1'=>'Yes','0'=>'No'),
          'value'=>$settings->getSetting('sesatoz.helpenable', '1'),
    ));
    $this->sesatoz_helpenable->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));


    $this->addElement('Radio',
    'sesatoz_leftcolumnenable',
    array(
      'label' => 'Enable Left Column',
      'description' => 'Do you want to enable the left column in the footer?',
      'multiOptions' => array('1'=>'Yes','0'=>'No'),
      'onchange'=>'enableleftcolumn(this.value)',
      'value'=>$settings->getSetting('sesatoz.leftcolumnenable', '1'),
    ));

    $this->addElement('Text', "sesatoz_leftcolhdingtext", array(
        'label' => 'Left Column Heading Text',
        'description' => "Enter the left column heading text.",
        'value' => $settings->getSetting('sesatoz.leftcolhdingtext', 'ABOUT & CONTACT'),
    ));
    $this->addElement('Textarea', "sesatoz_leftcolhdingdes", array(
        'label' => 'Left Column Description',
        'description' => "Enter the left column description.",
        'value' => $settings->getSetting('sesatoz.leftcolhdingdes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.'),
    ));
    $this->addElement('Text', "sesatoz_leftcolhdinglocation", array(
        'label' => 'Left Column Location',
        'description' => "Enter the left column location.",
        'value' => $settings->getSetting('sesatoz.leftcolhdinglocation', 'Los Angeles, USA'),
    ));
    $this->addElement('Text', "sesatoz_leftcolhdingemail", array(
        'label' => 'Left Column Email',
        'description' => "Enter the left column email.",
        'value' => $settings->getSetting('sesatoz.leftcolhdingemail', 'info@abc.com'),
    ));
    $this->addElement('Text', "sesatoz_leftcolhdingphone", array(
        'label' => 'Left Column Phone',
        'description' => "Enter the left column phone.",
        'value' => $settings->getSetting('sesatoz.leftcolhdingphone', '+91-1234567890'),
    ));

    $this->addElement('Textarea', "sesatoz_twitterembed", array(
        'label' => 'Twitter Embed Code',
        'description' => "Enter the twitter embed code.",
        'value' => $settings->getSetting('sesatoz.twitterembed', ''),
    ));


    $this->addElement('Radio',
    'sesatoz_rightcolumnenable',
    array(
      'label' => 'Enable Right Column',
      'description' => 'Do you want to enable the right column in the footer?',
      'multiOptions' => array('1'=>'Yes','0'=>'No'),
      'onchange'=>'enablerightcolumn(this.value)',
      'value' => $settings->getSetting('sesatoz.rightcolumnenable', '1'),
    ));

    $this->addElement('Text', "sesatoz_rightcolhdingtext", array(
        'label' => 'Right Column Heading Text',
        'description' => "Enter the right column heading text.",
        'value' => $settings->getSetting('sesatoz.rightcolhdingtext', 'MOBILE APPS'),
    ));

    $this->addElement('Textarea', "sesatoz_rightcolhdingdes", array(
        'label' => 'Right Column Description',
        'description' => "Enter the right column description.",
        'value' => $settings->getSetting('sesatoz.rightcolhdingdes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.'),
    ));
    $this->addElement('Text', "sesatoz_rightcolhdingbtn1", array(
        'label' => 'Right Column Button - 1 Link',
        'description' => "Enter the right column button 1 link.",
        'value' => $settings->getSetting('sesatoz.rightcolhdingbtn1', ''),
    ));
    $this->addElement('Text', "sesatoz_rightcolhdingbtn2", array(
        'label' => 'Right Column Button - 2 Link',
        'description' => "Enter the right column button 2 link.",
        'value' => $settings->getSetting('sesatoz.rightcolhdingbtn2', ''),
    ));

    $this->addElement('Radio',
    'sesatoz_socialenable',
    array(
      'label' => 'Enable Social Site Links',
      'description' => 'Do you want to enable the social links in the footer?',
      'multiOptions' => array('1'=>'Yes','0'=>'No'),
      'onchange'=>'socialmedialinks(this.value)',
      'value'=>$settings->getSetting('sesatoz.socialenable', '1'),
    ));

    $fileLink = $view->baseUrl() . '/admin/menus/index/name/core_social_sites';
    $this->addElement('Dummy',
      'sesatoz_socialsharelink',
      array(
          'label' => 'Social Share Links',
          'description' => 'The the menu items will display which have been configured from <a href="' . $fileLink . '" target="_blank">Click Here</a>.',
    ));
    $this->sesatoz_socialsharelink->addDecorator('Description', array('placement' => Zend_Form_Decorator_Abstract::PREPEND, 'escape' => false));

//     $this->addElement(
//       'Text',
//       'sesatoz_facebookurl',
//       array(
//         'label' => 'Facebook Page URL',
//         'description' => 'Enter the URL of your Facebook Page.',
//         'class'=>'socialclass',
//         'value' => $settings->getSetting('sesatoz.facebookurl', 'http://www.facebook.com/'),
//       )
//     );
//
//     $this->addElement(
//       'Text',
//       'sesatoz_googleplusurl',
//         array(
//           'label' => 'Google Plus URL',
//           'description' => 'Enter the URL of your Google Plus account.',
//           'class'=>'socialclass',
//           'value' => $settings->getSetting('sesatoz.googleplusurl', 'http://plus.google.com/'),
//         )
//     );
//
//     $this->addElement(
//       'Text',
//       'sesatoz_twitterurl',
//       array(
//         'label' => 'Twiiter URL',
//         'description' => 'Enter the URL of your Twitter account.',
//         'class'=>'socialclass',
//         'value' => $settings->getSetting('sesatoz.twitterurl', 'https://www.twitter.com/'),
//       )
//     );
//
//     $this->addElement(
//       'Text',
//       'sesatoz_pinteresturl',
//       array(
//         'label' => 'Pinterest URL',
//         'description' => 'Enter the URL of your Pinterest account.',
//         'class'=>'socialclass',
//         'value' => $settings->getSetting('sesatoz.pinteresturl', 'https://www.pinterest.com/'),
//       )
//     );

    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }
}
