  <?php

  class Recipefield_Installer extends Engine_Package_Installer_Module {
    
  public function onDisable()
  {
    $db = $this->getDb();
    $db->query('DELETE FROM `engine4_sitereview_listing_fields_meta` WHERE `type` = "recipe"');

    parent::onDisable();
  }
}
  ?>