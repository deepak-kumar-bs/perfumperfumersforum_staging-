<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Core.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Api_Core extends Core_Api_Abstract {


    public function groupMembers($groupId = '') {
        $table = Engine_Api::_()->getDbTable('users', 'user');
        $subtable = Engine_Api::_()->getDbTable('membership', 'group');
        $tableName = $table->info('name');
        $subtableName = $subtable->info('name');
        $select = $table->select()
                ->from($tableName, array('user_id', 'photo_id','displayname'))
                ->setIntegrityCheck(false)
                ->join($subtableName, '`' . $subtableName . '`.`user_id` = `' . $tableName . '`.`user_id`', array('resource_approved', 'user_approved', 'active'))
                ->where('`' . $subtableName . '`.`resource_id` = ?', $groupId)
                ->where('resource_approved =?', 1)
                ->where('user_approved =?', 1)
                ->where($subtableName . '.active =?', 1)
                ->order('RAND()');
        return $table->fetchAll($select);
    }

    public function getUserId($email) {

        $table = Engine_Api::_()->getDbTable('users','user');
        return Engine_Api::_()->getDbTable('users','user')->select()
                        ->from($table, array('user_id'))
                        ->where('email =?', $email)
                        ->query()
                        ->fetchColumn();
    }

  public function getModulesEnable(){
    $modules = Engine_Api::_()->getDbTable('modules','core')->getEnabledModuleNames();
    $moduleArray = array();
    if(in_array('album',$modules))
      $moduleArray['album'] = 'Albums';
    if(in_array('blog',$modules))
      $moduleArray['blog'] = 'Blogs';
    if(in_array('video',$modules))
      $moduleArray['video'] = 'Videos';
    if(in_array('classified',$modules))
      $moduleArray['classified'] = 'Classifieds';
    if(in_array('group',$modules))
      $moduleArray['group'] = 'Groups';
    if(in_array('event',$modules))
      $moduleArray['event'] = 'Events';
    if(in_array('music_playlist',$modules))
      $moduleArray['music'] = 'Music';
    if(in_array('sesalbum',$modules))
      $moduleArray['sesalbum_album'] = 'SES - Advanced Photos & Albums Plugin';
    if(in_array('sesblog',$modules))
      $moduleArray['sesblog_blog'] = 'SES - Advanced Blog Plugin';
    if(in_array('sesvideo',$modules))
      $moduleArray['sesvideo_video'] = 'SES - Advanced Videos & Channels Plugin';
    if(in_array('sesevent',$modules))
      $moduleArray['sesevent_event'] = 'SES - Advanced Events Plugin';
    if(in_array('sesmusic',$modules))
      $moduleArray['sesmusic_album'] = 'SES - Advanced Music Albums, Songs & Playlists Plugin';
    if(in_array('sespage',$modules))
      $moduleArray['sespage_page'] = 'SES - Page Directories Plugin';
    if(in_array('sesgroup',$modules))
      $moduleArray['sesgroup_group'] = 'SES - Group Communities Plugin ';
    if(in_array('sesbusiness',$modules))
      $moduleArray['businesses'] = 'SES - Business Directories Plugin';
    if(in_array('sescontest',$modules))
      $moduleArray['contest'] = 'SES - Advanced Contests Plugin';
    return $moduleArray;
  }
  public function getMenuIcon($menuName) {

    $table = Engine_Api::_()->getDbTable('menuitems', 'core');
    $menuId =  $table->select()
                    ->from($table, 'id')
                    ->where('name =?', $menuName)
                    ->query()
                    ->fetchColumn();
    if($menuId){
      $row = Engine_Api::_()->getDbTable('menusicons','sesbasic')->getRow($menuId);
    if($row)
      return $row->icon_id;
    }
   return false;
  }

  public function setPhoto($photo, $menuId = null) {

    //GET PHOTO DETAILS
    $mainName = dirname($photo['tmp_name']) . '/' . $photo['name'];

    //GET VIEWER ID
    $photo_params = array(
        'parent_id' => $menuId,
        'parent_type' => "sesatoz_slideshow_image",
    );
    copy($photo['tmp_name'], $mainName);
    try {
      $photoFile = Engine_Api::_()->storage()->create($mainName, $photo_params);
    } catch (Exception $e) {
      if ($e->getCode() == Storage_Api_Storage::SPACE_LIMIT_REACHED_CODE) {
        echo $e->getMessage();
        exit();
      }
    }

    return $photoFile;
  }

  public function getContantValueXML($key) {
    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
    $nodeName = @$xmlNodes[0];
    $value = @$nodeName->value;
    return $value;
  }

  public function readWriteXML($keys, $value, $default_constants = null) {

    $filePath = APPLICATION_PATH . "/application/settings/constants.xml";
    $results = simplexml_load_file($filePath);
    $contactsThemeArray = array();
    if (!empty($keys) && !empty($value) && ($keys != 'atoz_body_background_image' || $keys != 'atoz_footer_background_image')) {
      $contactsThemeArray = array($keys => $value);
    } elseif (!empty($keys) && ($keys == 'atoz_body_background_image' || $keys == 'atoz_footer_background_image')) {
      $contactsThemeArray = array($keys => '');
    } elseif ($default_constants) {
      $contactsThemeArray = $default_constants;
    }

    foreach ($contactsThemeArray as $key => $value) {
      $xmlNodes = $results->xpath('/root/constant[name="' . $key . '"]');
      $nodeName = @$xmlNodes[0];
      $params = json_decode(json_encode($nodeName));
      $paramsVal = @$params->value;
      if ($paramsVal && $paramsVal != '' && $paramsVal != null) {
        $nodeName->value = $value;
      } else {
        $entry = $results->addChild('constant');
        $entry->addChild('name', $key);
        $entry->addChild('value', $value);
      }
    }
    return $results->asXML($filePath);
  }
}
