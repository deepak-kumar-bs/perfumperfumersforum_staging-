<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: MiniMenuIcons.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_MiniMenuIcons extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->setTitle('Manage Mini Menu Icons')
            ->setDescription('Here, you can add icons for the Main Navigation Menu Items of your website. You can also edit and delete the icons.');
    
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    //Notification Icons
    $minimenu_notification_normal = $settings->getSetting('minimenu.notification.normal', ''); 
    $minimenu_notification_mouseover = $settings->getSetting('minimenu.notification.mouseover', 0);
    $this->addElement('Dummy', 'minimenu_icons', array(
        'label' => 'Notifications Icons',
    ));
    $this->addElement('File', 'minimenu_notification_normal', array(
        'label' => 'Normal Icon',
    ));
    $this->minimenu_notification_normal->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    if ($minimenu_notification_normal) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_notification_normal, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_notification_normal_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_notification_normalremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }
    
    $this->addElement('File', 'minimenu_notification_mouseover', array(
        'label' => 'Mouse Over Icon',
    ));
    $this->minimenu_notification_mouseover->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    if ($minimenu_notification_mouseover) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_notification_mouseover, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_notification_mouseover_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_notification_mouseoverremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }
    
    //Message icons
    $minimenu_message_normal = $settings->getSetting('minimenu.message.normal', 0); 
    $minimenu_message_mouseover = $settings->getSetting('minimenu.message.mouseover', 0);
    $this->addElement('Dummy', 'minimenu_message_icons', array(
        'label' => 'Messages Icons',
    ));
    $this->addElement('File', 'minimenu_message_normal', array(
        'label' => 'Normal Icon',
    ));
    $this->minimenu_message_normal->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    
    if ($minimenu_message_normal) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_message_normal, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_message_normal_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_message_normalremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }
    
    $this->addElement('File', 'minimenu_message_mouseover', array(
        'label' => 'Mouse Over Icon',
    ));
    $this->minimenu_message_mouseover->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    if ($minimenu_message_mouseover) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_message_mouseover, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_message_mouseover_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_message_mouseoverremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }
    
    
    //Friend Requests
    $minimenu_frrequest_normal = $settings->getSetting('minimenu.frrequest.normal', 0); 
    $minimenu_frrequest_mouseover = $settings->getSetting('minimenu.frrequest.mouseover', 0);
    $this->addElement('Dummy', 'minimenu_frrequest_icons', array(
        'label' => 'Friend Requests Icons',
    ));
    $this->addElement('File', 'minimenu_frrequest_normal', array(
        'label' => 'Normal Icon',
    ));
    $this->minimenu_frrequest_normal->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    if ($minimenu_frrequest_normal) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_frrequest_normal, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_frrequest_normal_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_frrequest_normalremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }
    
    $this->addElement('File', 'minimenu_frrequest_mouseover', array(
        'label' => 'Mouse Over Icon',
    ));
    $this->minimenu_frrequest_mouseover->addValidator('Extension', false, 'jpg,png,gif,jpeg,JPG,PNG,GIF,JPEG');
    if ($minimenu_frrequest_mouseover) {
      $img_path = Engine_Api::_()->storage()->get($minimenu_frrequest_mouseover, '')->getPhotoUrl();
      $path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
      if (isset($path) && !empty($path)) {
        $this->addElement('Image', 'minimenu_frrequest_mouseover_preview', array(
            'src' => $path,
            'width' => 17,
            'height' => 17,
        ));
      }
      $this->addElement('Checkbox', 'minimenu_frrequest_mouseoverremove', array(
          'label' => 'Remove this icon and apply default icon.'
      ));
    }

	
    // Add submit button
    $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true
    ));
  }

}
