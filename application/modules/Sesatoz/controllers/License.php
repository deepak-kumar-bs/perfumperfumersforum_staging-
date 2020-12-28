<?php

if (!$this->getRequest()->isPost()) {
  return;
}

if (!$form->isValid($this->getRequest()->getPost())) {
  return;
}

if ($this->getRequest()->isPost()) {

  //here we can set some variable for checking in plugin files.
  if (1) {

    if (!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.pluginactivated')) {

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

        $db->query('INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
        ("sesatoz_admin_main_menuslanding", "sesatoz", "Manage Landing Page", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage", "action":"landing-page-settings"}\', "sesatoz_admin_main", "", 2),
        ("sesatoz_admin_main_menus", "sesatoz", "Manage Header", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage", "action":"header-settings"}\', "sesatoz_admin_main", "", 3),
        ("sesatoz_admin_main_menusfooter", "sesatoz", "Manage Footer", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage", "action":"footer-settings"}\', "sesatoz_admin_main", "", 4),
        ("sesatoz_admin_main_styling", "sesatoz", "Color Schemes", "", \'{"route":"admin_default","module":"sesatoz","controller":"settings", "action":"styling"}\', "sesatoz_admin_main", "", 5),
        ("sesatoz_admin_main_customcss", "sesatoz", "Custom CSS", "", \'{"route":"admin_default","module":"sesatoz","controller":"custom-theme", "action":"index"}\', "sesatoz_admin_main", "", 6),
        ("sesatoz_admin_main_managebanners", "sesatoz", "Manage Banners", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage-banner","action":"index"}\', "sesatoz_admin_main", "", 990),
        ("sesatoz_admin_main_typography", "sesatoz", "Typography", "", \'{"route":"admin_default","module":"sesatoz","controller":"settings", "action":"typography"}\', "sesatoz_admin_main", "", 50),
        ("sesatoz_admin_main_managenewsemail", "sesatoz", "Newsletter Emails", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage-newsletter"}\', "sesatoz_admin_main", "", 992),
        ("sesatoz_admin_main_managenewsemails", "sesatoz", "Emails", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage-newsletter"}\', "sesatoz_admin_main_managenewsemail", "", 1),
        ("sesatoz_admin_main_managesendnews", "sesatoz", "Send Newsletter", "", \'{"route":"admin_default","module":"sesatoz","controller":"manage-newsletter", "action":"send-newsletter"}\', "sesatoz_admin_main_managenewsemail", "", 2),
        ("sesatoz_admin_main_support", "sesatoz", "Help", "", \'{"route":"admin_default","module":"sesatoz","controller":"settings", "action":"support"}\', "sesatoz_admin_main", "", 999);
        ');

        $db->query("DROP TABLE IF EXISTS engine4_sesatoz_newsletteremails;");
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesatoz_newsletteremails` (
            `newsletteremail_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `email` varchar(255) NOT NULL,
            `user_id` int(11) DEFAULT "0",
            `level_id` int(11) DEFAULT "5"
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');

        $db->query('INSERT IGNORE INTO `engine4_core_menus` (`name`, `type`, `title`, `order`) VALUES    ("sesatoz_quicklinks_footer", "standard", "SES - Responsive A to Z Theme - Footer Quicklinks", 1);');

        $db->query('DROP TABLE IF EXISTS `engine4_sesatoz_banners`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesatoz_banners` (
            `banner_id` int(11) unsigned NOT NULL auto_increment,
            `banner_name` VARCHAR(255)  NULL ,
            `creation_date` datetime NOT NULL,
            `modified_date` datetime NOT NULL,
            `enabled` TINYINT(1) NOT NULL DEFAULT "1",
            PRIMARY KEY (`banner_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;'
        );

        $db->query('DROP TABLE IF EXISTS `engine4_sesatoz_customthemes`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesatoz_customthemes` (
            `customtheme_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `value` varchar(255) NOT NULL,
            `column_key` varchar(255) NOT NULL,
            `theme_id` int(11) NOT NULL,
            `default` TINYINT(1) NOT NULL DEFAULT "0" ,
            PRIMARY KEY (`customtheme_id`),
            UNIQUE KEY `UNIQUEKEY` (`column_key`,`theme_id`,`default`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16;');

        $db->query('DROP TABLE IF EXISTS `engine4_sesatoz_slides`;');
        $db->query('CREATE TABLE IF NOT EXISTS `engine4_sesatoz_slides` (
            `slide_id` int(11) unsigned NOT NULL auto_increment,
            `banner_id` int(11) DEFAULT NULL,
            `title` varchar(255) DEFAULT NULL,
            `title_button_color` varchar(255) DEFAULT NULL,
            `description` text,
            `description_button_color` varchar(255) DEFAULT NULL,
            `file_type` varchar(255) DEFAULT NULL,
            `file_id` INT(11) DEFAULT "0",
            `status` ENUM("1","2","3") NOT NULL DEFAULT "1",
            `extra_button_linkopen` TINYINT(1) NOT NULL DEFAULT "0",
            `extra_button` tinyint(1) DEFAULT "0",
            `extra_button_text` varchar(255) DEFAULT NULL,
            `extra_button_link` varchar(255) DEFAULT NULL,
            `order` tinyint(10) NOT NULL DEFAULT "0",
            `creation_date` datetime NOT NULL,
            `modified_date` datetime NOT NULL,
            `enabled` TINYINT(1) NOT NULL DEFAULT "1",
            PRIMARY KEY (`slide_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
        ');
        include_once APPLICATION_PATH . "/application/modules/Sesatoz/controllers/defaultsettings.php";
        Engine_Api::_()->getApi('settings', 'core')->setSetting('sesatoz.pluginactivated', 1);
    }
  }
}
