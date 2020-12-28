<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2012-2013 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Otherinfo.php 6590 2013-04-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitereview_Model_DbTable_Recipeinfo extends Engine_Db_Table {

  protected $_rowClass = "Sitereview_Model_Recipeinfo";

  public function getRecipeinfo($recipeitem_id) {

    $rName = $this->info('name');
    $select = $this->select()
            ->where($rName . '.recipeinfo_id = ?', $recipeitem_id);

    $row = $this->fetchRow($select);

    if (empty($row))
      return;

    return $row;
  }

  public function getColumnValue($recipeitem_id, $column_name) {

    $select = $this->select()
            ->from($this->info('name'), array("$column_name"));

    $select->where('recipeinfo_id = ?', $recipeitem_id);


    return $select->limit(1)->query()->fetchColumn();
  }

  public function saveRecipeInfo($listing_recipe_id, $content) {

    // $this->delete(array(
    //   'listing_recipe_id = ?' => $listing_recipe_id,
    // ));

    $row = $this->createRow();
    $row->listing_id_recipe = $listing_recipe_id;
    $row->listing_id_ingredient = $content['listing_id_ingredient'];
    $row->amount = $content['amount'];
    $row->dilution = $content['dilution'];

    $row->save();

  }

}