<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereaction
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Reactionicon.php 6590 2016-07-07 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitereaction_Model_Reactionicon extends Core_Model_Item_Abstract {
  protected $_searchTriggers = false;

  public function setPhoto($photo) {
    if ($photo instanceof Zend_Form_Element_File) {
      $file = $photo->getFileName();
      $fileName = $file;
    } else if ($photo instanceof Storage_Model_File) {
      $file = $photo->temporary();
      $fileName = $photo->name;
    } else if ($photo instanceof Core_Model_Item_Abstract && !empty($photo->file_id)) {
      $tmpRow = Engine_Api::_()->getItem('storage_file', $photo->file_id);
      $file = $tmpRow->temporary();
      $fileName = $tmpRow->name;
    } else if (is_array($photo) && !empty($photo['tmp_name'])) {
      $file = $photo['tmp_name'];
      $fileName = $photo['name'];
    } else if (is_string($photo) && file_exists($photo)) {
      $file = $photo;
      $fileName = $photo;
    } else {
      throw new Core_Model_Exception('invalid argument passed to setPhoto');
    }

    if (!$fileName) {
      $fileName = basename($file);
    }

    $extension = ltrim(strrchr(basename($fileName), '.'), '.');
    $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
    $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';

    // Save
    $filesTable = Engine_Api::_()->getDbtable('files', 'storage');

    // Resize image (for restapi)
    $largeIconPath = $path . DIRECTORY_SEPARATOR . $base . '_l-i.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(192, 192)
      ->write($largeIconPath)
      ->destroy();
    
    // Resize image (main)
    $bigIconPath = $path . DIRECTORY_SEPARATOR . $base . '_b-i.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(48, 48)
      ->write($bigIconPath)
      ->destroy();

    // Resize image (profile)
    $smallIconPath = $path . DIRECTORY_SEPARATOR . $base . '_s-i.' . $extension;
    $image = Engine_Image::factory();
    $image->open($file)
      ->resize(16, 16)
      ->write($smallIconPath)
      ->destroy();


    // Store
    $bigIcon = $filesTable->createSystemFile($bigIconPath);
    $smallIcon = $filesTable->createSystemFile($smallIconPath);
    $largeIcon = $filesTable->createSystemFile($largeIconPath);
    $bigIcon->bridge($smallIcon, 'thumb.small-icon');
    $bigIcon->bridge($largeIcon, 'thumb.large-icon');

    // Remove temp files
    @unlink($bigIconPath);
    @unlink($smallIconPath);
     @unlink($largeIcon);
    $this->photo_id = $bigIcon->getIdentity();
    $this->save();
    return $this;
  }

}
