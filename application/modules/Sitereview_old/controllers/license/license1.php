<?php

$update_table = Engine_Api::_()->getDbtable('menuItems', 'core');
$update_name = $update_table->info('name');
$check_table = $update_table->select()
        ->from($update_name, array('id'))
        ->where('name = ?', 'core_admin_main_plugins_sitereview');
$fetch_result = $check_table->query()->fetchAll();
if (!empty($fetch_result)) {
  $update_table->update(array('params' => '{"route":"admin_default","module":"sitereview","controller":"settings"}'), array('name =?' => 'core_admin_main_plugins_sitereview'));
}
$product_type = 'sitereview';
$sitereviewShowViewType = $replace_container_temp = 0;
$tempListingTypeReview = true;
$baseProductType = @base64_encode($product_type);
$baseListingType = @base64_encode('sitereviewlistingtype');
$basePaidListingType = @base64_encode('sitereviewpaidlisting');

$this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
        ->getNavigation('sitereview_admin_main', array(), 'sitereview_admin_main_settings');

$this->view->form = $form = new Sitereview_Form_Admin_Settings_Global();

$plugin_auth_name = $product_type . '.navi.auth';
$navi_auth_value = Engine_Api::_()->getApi('settings', 'core')->getSetting($plugin_auth_name);


if (empty($navi_auth_value)) {
  $form->setDescription('');
  foreach ($sitereview_global_form_content as $global_form_content) {
    $form->removeElement($global_form_content);
  }

  $hasLanguageDirectoryPermissions = Engine_Api::_()->getApi('language', 'sitereview')->hasDirectoryPermissions();
  if (!$hasLanguageDirectoryPermissions) {
    $error = 'Language file for this listing type could not be overwritten. because you do not have write permission chmod -R 777 recursively to the directory "/application/languages/". Please login in over your Cpanel or FTP and give the recursively write permission to this directory and try again.';
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->getDecorator('errors')->setOption('escape', false);
    $form->addError($error);
    $form->removeElement('submit_lsetting');
    $form->removeElement('environment_mode');
    return;
  }
} else {
  $form->removeElement('submit_lsetting');
  $form->removeElement('environment_mode');
}

$listingtypeTempPaidLsettings = $listingtypeTempLsettings = $post_key_value = 0;
$tempExtensionIlicenseKeysArray = $tempExtensionLicenseKeysArray = array();
if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
  $post_key_value = $this->getRequest()->getPost();
}

if (!empty($post_key_value)) {
  if (empty($navi_auth_value)) {
    $environment_mode = $post_key_value['environment_mode'];
  }

  if (isset($post_key_value['sitereview_lsettings']) && !empty($post_key_value['sitereview_lsettings'])) {
    $tempExtensionLicenseKeysArray['sitereview'] = array('ptype' => 'sitereview', 'key' => @trim($post_key_value['sitereview_lsettings']));
  }

  if (isset($post_key_value['sitereviewlistingtype_lsettings']) && !empty($post_key_value['sitereviewlistingtype_lsettings'])) {
    $listingtypeTempLsettings = @trim($post_key_value['sitereviewlistingtype_lsettings']);
    $tempExtensionLicenseKeysArray['sitereviewlistingtype'] = array('ptype' => 'sitereviewlistingtype', 'key' => @trim($post_key_value['sitereviewlistingtype_lsettings']));
  }

  if (isset($post_key_value['sitereviewpaidlisting_lsettings']) && !empty($post_key_value['sitereviewpaidlisting_lsettings'])) {
    $listingtypeTempPaidLsettings = @trim($post_key_value['sitereviewpaidlisting_lsettings']);
    $tempExtensionLicenseKeysArray['sitereviewpaidlisting'] = array('ptype' => 'sitereviewpaidlisting', 'key' => @trim($post_key_value['sitereviewpaidlisting_lsettings']));
  }
}

$post_key_value = @trim($post_key_value[$product_type . '_lsettings']);

$tempExtensionIlicenseKeysArray = $tempExtensionLicenseKeysArray;

if (!empty($tempExtensionLicenseKeysArray)) {
  foreach ($tempExtensionLicenseKeysArray as $key => $values) {
    $is_file_exist = @file_exists(APPLICATION_PATH . '/application/modules/' . ucfirst($values['ptype']) . '/controllers/license/ilicense.php');
    if (!empty($is_file_exist))
      unset($tempExtensionLicenseKeysArray[$key]);
  }
}

$tempExtIlicenseAvailable = @COUNT($tempExtensionLicenseKeysArray);
$extensionLicensePostValues = !empty($tempExtensionLicenseKeysArray) ? array('postValues' => @serialize($tempExtensionLicenseKeysArray), 'values' => Engine_Api::_()->getApi('settings', 'core')->getSetting('core_adminmenutype', null)) : array();

$module_status = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('seaocore');
$file_path = APPLICATION_PATH . '/application/modules/Sitereview/controllers/license/ilicense.php';
$module_like = str_replace('www.', '', strtolower($_SERVER['HTTP_HOST']));
$is_file_exist = file_exists($file_path);

if (empty($module_status) && !empty($tempExtIlicenseAvailable)) {
  $replace_container_temp = '<a href="http://www.socialengineaddons.com/resources/socialengineaddons-core-plugin-free" target="_blank">The SocialEngineAddOns Core Plugin</a> is not installed on your site. Please download the latest version of this FREE plugin from your Client Area on <a href="http://www.socialengineaddons.com" target="_blank">SocialEngineAddOns</a>.';
} else {
  if ($post_key_value) {
    if (!empty($tempExtIlicenseAvailable)) {
      $string_exe = '';
      $enabled_module_str = '';
      $rss = Zend_Feed::import('http://www.socialengineaddons.com/plugins/feed');
      foreach ($rss as $item) {
        switch ($item->ptype()) {
          case 'userconnection':
            $name = 'userconnection';
            $key_firld = 'user.licensekey';
            break;
          case 'feedbacks':
            $name = 'feedback';
            $key_firld = 'feedback.license_key';
            break;
          case 'suggestion':
            $name = 'suggestion';
            $key_firld = 'suggestion.controllersettings';
            break;
          case 'peopleyoumayknow':
            $name = 'peopleyoumayknow';
            $key_firld = 'pymk.controllersettings';
            break;
          case 'siteslideshow':
            $name = 'siteslideshow';
            $key_firld = 'siteslideshow.controllersettings';
            break;
          case 'mapprofiletypelevel':
            $name = 'mapprofiletypelevel';
            $key_firld = 'mapprofiletypelevel.controllersettings';
            break;
          case 'documentsv4':
            $name = 'document';
            $key_firld = 'document.controllersettings';
            break;
          case 'groupdocumentsv4':
            $name = 'groupdocument';
            $key_firld = 'groupdocument.controllersettings';
            break;
          case 'backup':
            $name = 'dbbackup';
            $key_firld = 'dbbackup.controllersettings';
            break;
          case 'mcard':
            $name = 'mcard';
            $key_firld = 'mcard.controllersettings';
            break;
          case 'like':
            $name = 'sitelike';
            $key_firld = 'sitelike.controllersettings';
            break;
          default:
            $name = $item->ptype();
            $key_firld = $item->ptype() . '.lsettings';
            break;
        }
        $moduleTable = Engine_Api::_()->getDbtable('modules', 'core');
        $moduleName = $moduleTable->info('name');
        $select = $moduleTable->select()
                ->setIntegrityCheck(false)
                ->from($moduleName, array('version', 'enabled'))
                ->where('name = ?', $name)
                ->limit(1);
        $module_info = $select->query()->fetchAll();
        if (!empty($module_info)) {
          $module_info_array['version'] = $module_info[0]['version'];
          $module_info_array['enabled'] = $module_info[0]['enabled'];
          $module_info_array['status'] = 1;
        } else {
          $module_info_array['status'] = 0;
        }
        $module_info_array['key'] = $key_firld;
        $modules_info = $module_info_array;

        if (!empty($modules_info['status'])) {
          if (!empty($module_info_array['enabled'])) {
            $enabled_module_str .= '::' . $item->ptype() . ':1';
          } else {
            $enabled_module_str .= '::' . $item->ptype() . ':0';
          }
        }
      }
      $string_exe = ltrim($enabled_module_str, '::');

      $str_host = 'EventLikeShow';
      $is_error = 0;
      $module_like = '';
      if (!empty($_SERVER['HTTP_HOST'])) {
        $module_like = str_replace('www.', '', strtolower($_SERVER['HTTP_HOST']));
      }

      $group_value = $post_key_value;
      $group_value = trim($group_value);
      if (empty($navi_auth_value)) {
        $socialengineName = 'meraMODULE' . $product_type . 'plugin.php';
      } else {
        $socialengineName = 'simpleMODULE' . $product_type . 'plugin.php';
      }

      $c = str_replace('www.', '', strtolower($_SERVER['HTTP_HOST']));
      $oposit_url = 'http://www.socialengineaddons.com/' . $socialengineName . '?checking=' . $group_value . '&surl=' . $c . '&type=' . $product_type . '&ptype=' . $string_exe;

      $plkjdu = 'ASDsdas';
      $brhuiwherwqnejwilq = 'http://demo.socialengineaddons.com/meraMODULE.php?ASDA=$plkjdu';

      if (empty($get_value)) {
        $group_module = $oposit_url;
        $ch = curl_init();
        $timeout = 0;
        curl_setopt($ch, CURLOPT_URL, $group_module);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $extensionLicensePostValues);
        ob_start();
        curl_exec($ch);
        curl_close($ch);
        if (empty($exe_status)) {
          $get_value = ob_get_contents();
        }
        if (empty($get_value)) {
          $get_value = @file_get_contents($oposit_url);
        }
        ob_end_clean();
      }
    } else {
      include $file_path;
      foreach ($tempExtensionIlicenseKeysArray as $key => $values) {
        if ($key != 'sitereview') {
          $isModEnabled = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled($key);
          if ($baseProductType == $isValidPlugin) {
            $sitereviewShowViewType = true;
            if (!empty($isModEnabled)) {
              $sitereviewShowViewType = 0;
              $listingTypeilicense = APPLICATION_PATH . '/application/modules/' . ucfirst($key) . '/controllers/license/ilicense.php';
              $isListingFileExist = @file_exists($listingTypeilicense);
              if (!empty($isListingFileExist)) {
                include $listingTypeilicense;
                if ($baseListingType == $isValidPlugin) {
                  $sitereviewShowViewType = true;
                }
              }
            }
          }
        }
      }
    }

    if (!empty($exe_status)) {
      curl_setopt($ch, CURLOPT_URL, $group_module);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    }
    $Clean_module = strrev($product_type);
    if (strstr($get_value, $Clean_module)) {
      if (!empty($tempListingTypeReview)) {
        if (!empty($environment_mode)) {
          // Development mode should be enabled.
          $global_file = APPLICATION_PATH . '/application/settings/general.php';
          if (file_exists($global_file)) {
            $global_setting = include $global_file;
          } else {
            $global_setting = array();
          }
          if (!is_writable($global_file)) {
            @chmod($global_file, 0666);
          }
          $global_setting['environment_mode'] = 'development';
          $file_contents = '<?php defined("_ENGINE") or die("Access Denied"); return ';
          $file_contents .= var_export($global_setting, true);
          $file_contents .= '; ?>';
          @file_put_contents($global_file, $file_contents);
        } else {
          if (!empty($form->environment_mode) && (APPLICATION_ENV == 'production')) {
            $form->addError('Please enabled the "Development Mode" at your site before activate this plugin.');
            return;
          }
        }

        $sitereview_values_array = array(
            'host_att' => $module_like,
            'auth_att' => 1,
            'is_att' => 1
        );
        $sitereview_values_serialize = serialize($sitereview_values_array);
        $sitereview_values_encode = convert_uuencode($sitereview_values_serialize);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.vieweds', $sitereview_values_encode);

        $sitereview_view_attempt = convert_uuencode($module_like);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.view.attempt', $sitereview_view_attempt);

        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.type.info', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.mod.type', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.cat.info', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.list.create', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.category.type', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.view.type', 1);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.listingtype.order', 784569);
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.ltype.attempt', 118967);
        $tempFlagArray = @serialize(array(0, 2, 10, 12, 15, 17));
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewltype.cat.attempt', $tempFlagArray);
        $dbObj = Zend_Db_Table_Abstract::getDefaultAdapter();
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.show.viewtype', $sitereviewShowViewType);

        if (!empty($tempExtIlicenseAvailable)) {
          if (strstr($socialengineName, 'simple')) {
            $getOrders = explode('::', $get_value);
            $sql = $getOrders[1];
            $getSQLArray = explode('|', $sql);
            foreach ($getSQLArray as $SQLQueries) {
              $getOrder = explode('===', $SQLQueries);
              $modSql = $getOrder[1];
              $querys = explode(';', $modSql);
              foreach ($querys as $sql) {
                if (!empty($sql) && (strlen($sql) > 2)) {
                  $sql = @trim($sql);
                  $dbObj->query($sql);
                }
              }
            }
          }
        }

        if (empty($navi_auth_value)) {
          $PluOrder = explode('::', $get_value);
          if (!empty($PluOrder)) {
            $PluOrder = $PluOrder[5 * 4 * 2 * 9 / 5 * 3 / 8 * 1 - 20 - 6];
          }
          $check_table = Engine_Api::_()->getDbtable('menuItems', 'core');
          $check_name = $check_table->info('name');
          $select = $check_table->select()
                  ->from($check_name, array('id'))
                  ->where('name = ?', 'core_admin_main_plugins_sitereview');
          $queary_info = $select->query()->fetchAll();
          if (empty($queary_info)) {
            $PluOrder = explode(';', $PluOrder);
            foreach ($PluOrder as $sql) {
              if (!empty($sql)) {
                $sql = trim($sql);
                $dbObj->query($sql);
              }
            }
          }

          include APPLICATION_PATH . '/application/modules/Sitereview/controllers/license/widgetSettings.php';
          Engine_Api::_()->getApi('settings', 'core')->setSetting($product_type . '.navi.auth', 1);
          Engine_Api::_()->getApi('settings', 'core')->setSetting($product_type . '.isActivate', 1);
          Engine_Api::_()->getApi('settings', 'core')->setSetting($product_type . '.lsettings', $post_key_value);
          $this->_helper->redirector->gotoRoute(array('route' => 'admin-default'));
        } else {
          if ($this->getRequest()->isPost() && $form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
            if (isset($values['sitereview_currency']))
              unset($values['sitereview_currency']);
            $sitereview_error = 0;
          }
          if (empty($sitereview_error)) {
            foreach ($values as $key => $value) {
              if ($key != 'sitereview_sponsored_color' && $key != 'sitereview_featured_color' && $key != 'sitereview_currency' && $key != 'is_remove_note')
                Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
            }
          }
        }

        $replace_container_temp = false;
      }
    } elseif (strstr($get_value, 'error')) {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.cat.listing', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.type.info', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.mod.type', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.cat.info', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.list.create', 0);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.category.type', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.view.type', 0);
      $tempGetValue = str_replace('error::', '', $get_value);
      $replace_container_temp = @explode('::|::', $tempGetValue);
    } else {
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.cat.listing', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.type.info', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.mod.type', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.cat.info', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereviewlistingtype.list.create', 0);

      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.category.type', 0);
      Engine_Api::_()->getApi('settings', 'core')->setSetting('sitereview.view.type', 0);
      if (!empty($tempExtensionLicenseKeysArray)) {
        foreach ($tempExtensionLicenseKeysArray as $values) {
          if ($values['ptype'] == 'sitereview')
            $pluginTitle = 'Reviews & Ratings Plugin';
          else if ($values['ptype'] == 'sitereviewlistingtype')
            $pluginTitle = 'Reviews & Ratings - Multiple Listing Types Extension';
          else if ($values['ptype'] == 'sitereviewpaidlisting')
            $pluginTitle = 'Multiple Listing Types - Paid Listings Extension';

          $replace_container_temp[] = 'License key for ‘' . $pluginTitle . '’ is not valid. Please check your key again or contact SocialEngineAddOns support.';
        }
      }
    }
  }
}

if (!empty($replace_container_temp)) {
  $errorsArray = array();
  if (!is_array($replace_container_temp))
    $errorsArray[] = $replace_container_temp;
  else
    $errorsArray = $replace_container_temp;

  foreach ($errorsArray as $error) {
    $is_error = 1;
    $this->view->status = false;
    $form->getDecorator('errors')->setOption('escape', false);
    $error = Zend_Registry::get('Zend_Translate')->_($error);
    $form->addError($error);
  }
  return;
}
?>