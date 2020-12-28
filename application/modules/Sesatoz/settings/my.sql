/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: my.sql  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
INSERT IGNORE INTO `engine4_core_menuitems` (`name`, `module`, `label`, `plugin`, `params`, `menu`, `submenu`, `order`) VALUES
('core_admin_main_plugins_sesatoz', 'sesatoz', 'SES - Responsive A to Z Theme', '', '{"route":"admin_default","module":"sesatoz","controller":"settings"}', 'core_admin_main', '', 999),
('sesatoz_admin_main_settings', 'sesatoz', 'Global Settings', '', '{"route":"admin_default","module":"sesatoz","controller":"settings"}', 'sesatoz_admin_main', '', 1);

INSERT IGNORE INTO `engine4_core_mailtemplates` (`type`, `module`, `vars`) VALUES 

("sesatoz_mobile_applinnk", "sesatoz", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description],[applinkcontent]"),
("sesatoz_mobile_subscribe", "sesatoz", "[host],[email],[recipient_title],[recipient_link],[recipient_photo],[sender_title],[sender_link],[sender_photo],[object_title],[object_link],[object_photo],[object_description]");
