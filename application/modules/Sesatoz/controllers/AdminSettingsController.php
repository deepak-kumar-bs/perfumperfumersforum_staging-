<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminSettingsController.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_AdminSettingsController extends Core_Controller_Action_Admin {

  public function indexAction() {

    $db = Engine_Db_Table::getDefaultAdapter();

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_settings');

    $this->view->form = $form = new Sesatoz_Form_Admin_Global();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      include_once APPLICATION_PATH . "/application/modules/Sesatoz/controllers/License.php";
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.pluginactivated')) {
        //Landing Page Work
				if (!empty($values['sesatoz_layout_enable'])) {
          $this->landingpagesetup();
				}
				//Landing Page Work

				//Here we have set the value of theme active.
				$themeactive = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.themeactive');
				if (empty($themeactive)) {

					$db->query("INSERT IGNORE INTO `engine4_core_themes` (`name`, `title`, `description`, `active`) VALUES ('sesatoz', 'Atoz', '', 0)");
          $themeName = 'sesatoz';
					$themeTable = Engine_Api::_()->getDbtable('themes', 'core');
					$themeSelect = $themeTable->select()
									->orWhere('theme_id = ?', $themeName)
									->orWhere('name = ?', $themeName)
									->limit(1);
					$theme = $themeTable->fetchRow($themeSelect);
					if ($theme) {
						$db = $themeTable->getAdapter();
						$db->beginTransaction();
						try {
							$themeTable->update(array('active' => 0), array('1 = ?' => 1));
							$theme->active = true;
							$theme->save();
							// clear scaffold cache
							Core_Model_DbTable_Themes::clearScaffoldCache();
							// Increment site counter
							$settings = Engine_Api::_()->getApi('settings', 'core');
							$settings->core_site_counter = $settings->core_site_counter + 1;
							$db->commit();
						} catch (Exception $e) {
							$db->rollBack();
							throw $e;
						}
					}
					Engine_Api::_()->getApi('settings', 'core')->setSetting('sesatoz.themeactive', 1);
				}

				//Start Make extra file for atoz theme custom css
        $themeDirName = APPLICATION_PATH . '/application/themes/sesatoz';
        @chmod($themeDirName, 0777);
        if (!is_readable($themeDirName)) {
          $itemError = Zend_Registry::get('Zend_Translate')->_("You have not read permission on below file path. So, please give chmod 777 recursive permission to continue this process. Path Name: %s", $themeDirName);
          $form->addError($itemError);
          return;
        }
        $fileName = $themeDirName . '/sesatoz-custom.css';
        $fileexists = @file_exists($fileName);
        if (empty($fileexists)) {
          @chmod($themeDirName, 0777);
          if (!is_writable($themeDirName)) {
            $itemError = Zend_Registry::get('Zend_Translate')->_("You have not writable permission on below file path. So, please give chmod 777 recursive permission to continue this process. <br /> Path Name: $themeDirName");
            $form->addError($itemError);
            return;
          }
          $fh = @fopen($fileName, 'w');
          @fwrite($fh, '/* ADD YOUR CUSTOM CSS HERE */');
          @chmod($fileName, 0777);
          @fclose($fh);
          @chmod($fileName, 0777);
          @chmod($fileName, 0777);
        }
        //Start Make extra file for atoz theme custom css

				foreach ($values as $key => $value) {
				 if ($key == 'sesatoz_responsive_layout' || $key == 'sesatoz_body_background_image' || $key == 'sesatoz_left_columns_width' || $key == 'sesatoz_right_columns_width' || $key == 'sesatoz_feed_style' || $key == 'sesatoz_user_photo_round') {
					 	if($key ==  'sesatoz_body_background_image') {
							if($value == '0') {
								$value = 'public/admin/blank.png';
              }
						}
           Engine_Api::_()->sesatoz()->readWriteXML($key, $value);
          }
          if($key ==  'sesatoz_loginsignupbgimage') {
            if($value == '0')
              $value = 'public/admin/blank.png';
          }
          if($value != '')
					Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
				}

				$form->addNotice('Your changes have been saved.');
				$this->_helper->redirector->gotoRoute(array());
      }
    }
  }

    public function supportAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_support');

    }

  public function stylingAction() {

    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_styling');

    $this->view->customtheme_id = $this->_getParam('customtheme_id', null);

    $this->view->form = $form = new Sesatoz_Form_Admin_Styling();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
      $values = $form->getValues();
      unset($values['header_settings']);
      unset($values['footer_settings']);
      unset($values['body_settings']);
      $db = Engine_Db_Table::getDefaultAdapter();

      $settingsTable = Engine_Api::_()->getDbTable('settings', 'core');
      $settingsTableName = $settingsTable->info('name');

      foreach ($values as $key => $value) {

//         if($value == '')
//             continue;
        if (isset($_POST['save'])) {
          Engine_Api::_()->sesatoz()->readWriteXML($key, $value, '');
        }

        if ((isset($_POST['submit']) || isset($_POST['save'])) && $values['custom_theme_color'] > '13') {
          if ($values['custom_theme_color'] > '13') {

            //$db->query("INSERT INTO `engine4_sesatoz_customthemes` (`name`, `value`, `column_key`,`default`,`theme_id`) VALUES ('Theme - 12', '".$value."','".$key."','0','13') ON DUPLICATE KEY UPDATE `value`='".$value."';");
            $theme_id = $values['custom_theme_color'];
            $dbInsert = Engine_Db_Table::getDefaultAdapter();
            foreach($values as $key => $value) {
               $dbInsert->query("UPDATE `engine4_sesatoz_customthemes` SET `value` = '".$value."' WHERE `engine4_sesatoz_customthemes`.`theme_id` = '".$theme_id."' AND  `engine4_sesatoz_customthemes`.`column_key` = '".$key."';");
               //echo "UPDATE `engine4_sesatoz_customthemes` SET `value` = '".$value."' WHERE `engine4_sesatoz_customthemes`.`theme_id` = '".$theme_id."' AND  `engine4_sesatoz_customthemes`.`column_key` = '".$key."';";
            }


            //$description = serialize($values);
            //$db->query("UPDATE `engine4_sesatoz_customthemes` SET `description` = '".$description."' WHERE `engine4_sesatoz_customthemes`.`customtheme_id` = '".$values['custom_theme_color']."'");
          }
        }

        if ($values['theme_color'] == '5') {
          $stringReplace = str_replace('_', '.', $key);
          if($key == 'sesatoz_button_background_color') {
            $stringReplace = 'sesatoz.button.backgroundcolor';
          }
          if($key == 'sesatoz_font_color') {
            $stringReplace = 'sesatoz.fontcolor';
          }

          $columnVal = $settingsTable->select()
                                    ->from($settingsTableName, array('value'))
                                    ->where('name = ?', $stringReplace)
                                    ->query()
                                    ->fetchColumn();
          if($columnVal) {
            $db->query('UPDATE `engine4_core_settings` SET `value` = "'.$value.'" WHERE `engine4_core_settings`.`name` = "'.$stringReplace.'";');
          } else {
            $db->query('INSERT IGNORE INTO `engine4_core_settings` (`name`, `value`) VALUES ("'.$stringReplace.'", "'.$value.'");');
          }
        }
      }


      //Clear scaffold cache
      Core_Model_DbTable_Themes::clearScaffoldCache();
      //Increment site counter
      Engine_Api::_()->getApi('settings', 'core')->core_site_counter = Engine_Api::_()->getApi('settings', 'core')->core_site_counter + 1;

      $form->addNotice('Your changes have been saved.');

      if($values['theme_color'] != 5 || $values['custom_theme_color'] < 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesatoz', 'controller' => 'settings', 'action' => 'styling'),'admin_default',true);
      } else if($values['theme_color'] == 5 && $values['custom_theme_color'] > 13) {
        $this->_helper->redirector->gotoRoute(array('module' => 'sesatoz', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $values['custom_theme_color']),'admin_default',true);
      }
    }
    $this->view->activatedTheme = Engine_Api::_()->sesatoz()->getContantValueXML('custom_theme_color');
  }

  //Get Custom theme color values
  public function getcustomthemecolorsAction() {

    $customtheme_id = $this->_getParam('customtheme_id', 22);
    if(empty($customtheme_id))
      return;

    $themecustom = Engine_Api::_()->getDbTable('customthemes','sesatoz')->getThemeKey(array('theme_id'=>$customtheme_id,'default'=>1));
    $customthecolorArray = array();
    foreach($themecustom as $value) {

      $customthecolorArray[] = $value['column_key'].'||'.$value['value'];
    }
    echo json_encode($customthecolorArray);die;


//     $customthemeItem = Engine_Api::_()->getItem('sesatoz_customthemes', $customtheme_id);
//     $customthecolorvalue = unserialize($customthemeItem->description);
//     $customthecolorArray = array();
//     foreach($customthecolorvalue as $key =>  $customthecolorvalues) {
//       $customthecolorArray[] = $key.'||'.$customthecolorvalues;
//     }
//     echo json_encode($customthecolorArray);die;
  }

  public function addCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $customtheme_id = $this->_getParam('customtheme_id', 0);
    $this->view->form = $form = new Sesatoz_Form_Admin_CustomTheme();
    if ($customtheme_id) {
      $form->setTitle("Edit Custom Theme Name");
      $form->submit->setLabel('Save Changes');
      $customtheme = Engine_Api::_()->getItem('sesatoz_customthemes', $customtheme_id);
      $form->populate($customtheme->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('customthemes', 'sesatoz')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('customthemes', 'sesatoz');
        $values = $form->getValues();

        if(!$customtheme_id) {
            $customtheme = $table->createRow();
            $customtheme->setFromArray($values);
            $customtheme->save();

            $theme_id = $customtheme->customtheme_id;

            if(!empty($values['customthemeid'])) {

                $dbInsert = Engine_Db_Table::getDefaultAdapter();

                $getThemeValues = Engine_Api::_()->getDbTable('customthemes', 'sesatoz')->getThemeValues(array('customtheme_id' => $values['customthemeid']));
                foreach($getThemeValues as $key => $value) {
                    $dbInsert->query("INSERT INTO `engine4_sesatoz_customthemes` (`name`, `value`, `column_key`,`default`,`theme_id`) VALUES ('".$values['name']."','".$value->value."','".$value->column_key."','1','".$theme_id."') ON DUPLICATE KEY UPDATE `value`='".$value->value."';");
                }
                $db->query("UPDATE `engine4_sesatoz_customthemes` SET `value` = '" . $theme_id . "' WHERE theme_id = " . $theme_id . " AND column_key = 'custom_theme_color';");
                $db->query('DELETE FROM `engine4_sesatoz_customthemes` WHERE `engine4_sesatoz_customthemes`.`theme_id` = "0";');
            }
        } else if(!empty($customtheme_id)) {
            $db->query("UPDATE `engine4_sesatoz_customthemes` SET `name` = '" . $values['name'] . "' WHERE theme_id = " . $customtheme_id);
        }
        $db->commit();
        return $this->_forward('success', 'utility', 'core', array(
          'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesatoz', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $customtheme->customtheme_id),'admin_default',true),
          'messages' => array('New Custom theme created successfully.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

    }

  }

  public function deleteCustomThemeAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $this->view->customtheme_id = $customtheme_id = $this->_getParam('customtheme_id', 0);

    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();

      try {
        $dbQuery = Zend_Db_Table_Abstract::getDefaultAdapter();
        $dbQuery->query("DELETE FROM engine4_sesatoz_customthemes WHERE theme_id = ".$customtheme_id);
        $db->commit();
        $activatedTheme = Engine_Api::_()->sesatoz()->getContantValueXML('custom_theme_color');
        $this->_forward('success', 'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesatoz', 'controller' => 'settings', 'action' => 'styling', 'customtheme_id' => $activatedTheme),'admin_default',true),
            'messages' => array('You have successfully delete custom theme.')
        ));
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }

    } else {
      // Output
      $this->renderScript('admin-settings/delete-custom-theme.tpl');
    }
  }

  public function widgetCheck($params = array()) {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    return $db->select()
                    ->from('engine4_core_content', 'content_id')
                    ->where('type = ?', 'widget')
                    ->where('page_id = ?', $params['page_id'])
                    ->where('name = ?', $params['widget_name'])
                    ->limit(1)
                    ->query()
                    ->fetchColumn();
  }

  public function landingpagesetup() {

    $db = Engine_Db_Table::getDefaultAdapter();

    //Landing Page
    $LandingPageOrder = 1;
    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3  AND `engine4_core_content`.`name` !='main' AND `engine4_core_content`.`name` !='middle' AND `engine4_core_content`.`type`='container';");

    $db->query("DELETE FROM `engine4_core_content` WHERE `engine4_core_content`.`page_id` =3;");
    $page_id = 3;
    // Insert top
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'top',
        'page_id' => $page_id,
        'order' => $LandingPageOrder++,
    ));
    $top_id = $db->lastInsertId();
    // Insert main
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'main',
        'page_id' => $page_id,
        'order' => $LandingPageOrder++,
    ));
    $main_id = $db->lastInsertId();
    // Insert top-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $top_id,
        'order' => $LandingPageOrder++,
    ));
    $top_middle_id = $db->lastInsertId();
    // Insert main-middle
    $db->insert('engine4_core_content', array(
        'type' => 'container',
        'name' => 'middle',
        'page_id' => $page_id,
        'parent_content_id' => $main_id,
        'order' => $LandingPageOrder++,
    ));
    $main_middle_id = $db->lastInsertId();
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.lp-header',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $top_middle_id,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.home-slider',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $top_middle_id,
        'params' => '{"height":"650","title":"","nomobile":"0","name":"sesatoz.home-slider"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.features',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesatoz_highlight_module":"sesevent_event","popularitycriteria":"like_count","sesatoz_highlight_design":"1","widgetdescription":"","title":"Popular Events","nomobile":"0","name":"sesatoz.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.features-block-two',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"title":"","name":"sesatoz.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.purchase-strip',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"description":"Want to avail the benefits of our Premium Package?","buttontext":"Purchase Now","buttonlink":"#","title":"","nomobile":"0","name":"sesatoz.purchase-strip"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesatoz_highlight_module":"sesalbum_album","popularitycriteria":"creation_date","sesatoz_highlight_design":"2","widgetdescription":"","title":"Popular Albums","nomobile":"0","name":"sesatoz.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.features-block-three',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesatoz_highlight_module":"sesvideo_video","popularitycriteria":"creation_date","sesatoz_highlight_design":"5","widgetdescription":"","title":"Popular Videos","nomobile":"0","name":"sesatoz.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesatoz_highlight_module":"sesmusic_album","popularitycriteria":"like_count","sesatoz_highlight_design":"4","widgetdescription":"","title":"Popular Music","nomobile":"0","name":"sesatoz.highlight"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.counters',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"backgroundimage":"public\/admin\/hero-13.jpg","counter1":"5000+","counter1text":"Members","counter2":"6500+","counter2text":"Directories","counter3":"10000+","counter3text":"Products","counter4":"2000+","counter4text":"Prayers","title":"","nomobile":"0","name":"sesatoz.counters"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.mobile-app',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"heading":"Download App","description":"Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.","mobilescreenshot":"public\/admin\/screenshot.png","androidlink":"#","ioslink":"#","title":"","nomobile":"0","name":"sesatoz.mobile-app"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"sesatoz_highlight_module":"sesblog_blog","popularitycriteria":"creation_date","sesatoz_highlight_design":"3","widgetdescription":"","title":"Popular Blogs","nomobile":"0","name":"sesatoz.highlight"}',
    ));
    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.member-cloud',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
        'params' => '{"title":"","name":"sesatoz.member-cloud"}',
    ));

    $db->insert('engine4_core_content', array(
        'type' => 'widget',
        'name' => 'sesatoz.static-buttons',
        'page_id' => 3,
        'order' => $LandingPageOrder++,
        'parent_content_id' => $main_middle_id,
    ));
  }

  //Upload Home Banner images
	public function uploadHomeBanner(){

		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
		$slideData = array('slide_1', 'slide_2', 'slide_3');
		foreach($slideData as $data) {
      $data1 = explode('_', $data);
      $PathFile = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'application' . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'Sesatoz' . DIRECTORY_SEPARATOR . "externals" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . "homebanner" . DIRECTORY_SEPARATOR;
      if (is_file($PathFile . $data . '.jpg')) {
        $storage = Engine_Api::_()->getItemTable('storage_file');
        $filename = $storage->createFile($PathFile . $data.'.jpg', array(
            'parent_id' => $data1[1],
            'parent_type' => 'sesatoz_slide',
            'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
        ));
        $file_id = $filename->file_id;
        $db->query("UPDATE `engine4_sesatoz_slides` SET `file_id` = '" . $file_id . "' WHERE slide_id = " . $data1[1]);
      }
		}
	}


  public function typographyAction() {

    $db = Zend_Db_Table_Abstract::getDefaultAdapter();
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_typography');

    $this->view->form = $form = new Sesatoz_Form_Admin_Typography();

    if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

      $values = $form->getValues();
      unset($values['sesatoz_body']);
      unset($values['sesatoz_heading']);
      unset($values['sesatoz_mainmenu']);
      unset($values['sesatoz_tab']);

      $db = Engine_Db_Table::getDefaultAdapter();
      if (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.pluginactivated')) {

        foreach ($values as $key => $value) {

          if($values['sesatoz_googlefonts']) {
            unset($values['sesatoz_body_fontfamily']);
            unset($values['sesatoz_heading_fontfamily']);
            unset($values['sesatoz_mainmenu_fontfamily']);
            unset($values['sesatoz_tab_fontfamily']);

            unset($values['sesatoz_body_fontsize']);
            unset($values['sesatoz_heading_fontsize']);
            unset($values['sesatoz_mainmenu_fontsize']);
            unset($values['sesatoz_tab_fontsize']);

            if($values['sesatoz_googlebody_fontfamily'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_body_fontfamily', $values['sesatoz_googlebody_fontfamily']);

            if($values['sesatoz_googlebody_fontsize'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_body_fontsize', $values['sesatoz_googlebody_fontsize']);

            if($values['sesatoz_googleheading_fontfamily'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_heading_fontfamily', $values['sesatoz_googleheading_fontfamily']);

            if($values['sesatoz_googleheading_fontsize'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_heading_fontsize', $values['sesatoz_googleheading_fontsize']);

            if($values['sesatoz_googlemainmenu_fontfamily'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_mainmenu_fontfamily', $values['sesatoz_googlemainmenu_fontfamily']);

            if($values['sesatoz_googlemainmenu_fontsize'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_mainmenu_fontsize', $values['sesatoz_googlemainmenu_fontsize']);

            if($values['sesatoz_googletab_fontfamily'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_tab_fontfamily', $values['sesatoz_googletab_fontfamily']);

            if($values['sesatoz_googletab_fontsize'])
              Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_tab_fontsize', $values['sesatoz_googletab_fontsize']);

            //Engine_Api::_()->sesatoz()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          } else {
            unset($values['sesatoz_googlebody_fontfamily']);
            unset($values['sesatoz_googleheading_fontfamily']);
            unset($values['sesatoz_googleheading_fontfamily']);
            unset($values['sesatoz_googletab_fontfamily']);

            unset($values['sesatoz_googlebody_fontsize']);
            unset($values['sesatoz_googleheading_fontsize']);
            unset($values['sesatoz_googlemainmenu_fontsize']);
            unset($values['sesatoz_googletab_fontsize']);

            Engine_Api::_()->sesatoz()->readWriteXML($key, $value);
            Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
          }
        }
        $form->addNotice('Your changes have been saved.');
        $this->_helper->redirector->gotoRoute(array());
      }
    }
  }
}
