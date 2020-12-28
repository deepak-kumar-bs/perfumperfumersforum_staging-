<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Customthemes.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Model_DbTable_Customthemes extends Engine_Db_Table {

  protected $_rowClass = "Sesatoz_Model_Customtheme";

  public function getThemeKey($params = array()){
        $tableName = $this->info('name');
      $select = $this->select()->from($tableName);
      if(!empty($params['theme_id']))
        $select->where('`theme_id` =?',$params['theme_id']);
      if(!empty($params['column_key']))
        $select->where('`column_key` =?',$params['column_key']);
      if(!empty($params['customtheme_id']))
        $select->where('`customtheme_id` =?',$params['customtheme_id']);
      if(!empty($params['default']))
        $select->where('`default` =?',$params['default']);

      return $this->fetchAll($select);
  }

  public function getCustomThemes($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()->from($tableName);
    if(empty($param['all'])) {
      $select->where('`default` = ?', '1');
    }
    if(!empty($param['all']) && isset($param['all'])) {
      $select->where('theme_id <> ?', 0)->group('theme_id')->group('name');
    }
    if(!empty($param['customtheme_id'])) {
        $select->where('theme_id =?', $param['customtheme_id']);
    }

    return $this->fetchAll($select);
  }

  public function getThemeValues($param = array()) {

    $tableName = $this->info('name');
    $select = $this->select()->from($tableName);
    if(!empty($param['customtheme_id'])) {
        $select->where('theme_id =?', $param['customtheme_id']);
    }

    return $this->fetchAll($select);
  }

}
