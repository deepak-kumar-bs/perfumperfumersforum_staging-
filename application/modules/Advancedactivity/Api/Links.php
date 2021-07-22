<?php

/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Advancedactivity
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Links.php 9747 2012-07-26 02:08:08Z john $
 * @author     Sami
 */

/**
 * @category   Application_Core
 * @package    Advancedactivity
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Advancedactivity_Api_Links extends Core_Api_Abstract {

  public function createLink(Core_Model_Item_Abstract $owner, $data)
  {
    $table = Engine_Api::_()->getDbtable('links', 'core');

    if (empty($data['parent_type']) || empty($data['parent_id'])) {
      $data['parent_type'] = $owner->getType();
      $data['parent_id'] = $owner->getIdentity();
    }

    $link = $table->createRow();
    $link->setFromArray($data);
    $link->owner_type = $owner->getType();
    $link->owner_id = $owner->getIdentity();
    $link->save();

    // Now try to create thumbnail
    $thumbnail = (string) @$data['thumb'];
    $thumbnail_parsed = @parse_url($thumbnail);
    //$ext = @ltrim(strrchr($thumbnail_parsed['path'], '.'), '.');
    //$link_parsed = @parse_url($link->uri);
    // Make sure to not allow thumbnails from domains other than the link (problems with subdomains, disabled for now)
    //if( $thumbnail && $thumbnail_parsed && $thumbnail_parsed['host'] === $link_parsed['host'] )
    //if( $thumbnail && $ext && $thumbnail_parsed && in_array($ext, array('jpg', 'jpeg', 'gif', 'png')) )
    if ($thumbnail && $thumbnail_parsed) {
      $tmp_path = APPLICATION_PATH . '/temporary/link';
      $tmp_file = $tmp_path . '/' . md5($thumbnail);

      if (!is_dir($tmp_path) && !mkdir($tmp_path, 0777, true)) {
        throw new Core_Model_Exception('Unable to create tmp link folder : ' . $tmp_path);
      }

      $page_content = file_get_contents($data['uri']);

      $dom_obj = new DOMDocument();
      $dom_obj->loadHTML($page_content);
      $meta_val = null;

      foreach($dom_obj->getElementsByTagName('meta') as $meta) {

      if($meta->getAttribute('property')=='og:image'){ 

          $meta_val = $meta->getAttribute('content');
      }
      }
      file_put_contents($tmp_file, file_get_contents($meta_val));
      if(is_null($meta_val)){
        $src_fh = fopen($thumbnail, 'r');
        $tmp_fh = fopen($tmp_file, 'w');
        stream_copy_to_stream($src_fh, $tmp_fh, 1024 * 1024 * 2);
        fclose($src_fh);
        fclose($tmp_fh);
      }


      if (($info = getimagesize($tmp_file)) && !empty($info[2])) {
        $ext = Engine_Image::image_type_to_extension($info[2]);
        // Resize image (main)
        $main_file = $tmp_path . '/thumb_m_' . md5($thumbnail) . '.' . $ext;
        $image = Engine_Image::factory();
        $image->open($tmp_file)
          ->autoRotate()
          ->resize(720, 720)
          ->write($main_file)
          ->destroy();

        $thumb_file = $tmp_path . '/thumb_' . md5($thumbnail) . '.' . $ext;

        $image = Engine_Image::factory();
        $image->open($tmp_file)
          ->resize(240, 240)
          ->write($thumb_file)
          ->destroy();
        $params = array(
            'parent_type' => $link->getType(),
            'parent_id' => $link->getIdentity()
        );
        try {
          $MainFileRow = Engine_Api::_()->storage()->create($main_file, $params);
          $thumbFileRow = Engine_Api::_()->storage()->create($thumb_file, $params);
          $MainFileRow->bridge($thumbFileRow, 'thumb.profile');
        } catch (Exception $e) {
          @unlink($thumb_file);
          @unlink($main_file);
          throw $e;
        }
        $link->photo_id = $MainFileRow->file_id;
        $link->save();

        @unlink($thumb_file);
        @unlink($main_file);
      }

      @unlink($tmp_file);
    }

    return $link;
  }

}
