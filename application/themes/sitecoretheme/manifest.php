<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: manifest.php 2019-07-09 11:51:37Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
return array(
  'package' => array(
    'type' => 'theme',
    'name' => 'Responsive Vertical Theme',
    'version' => '5.6.1',
    'path' => 'application/themes/sitecoretheme',
    'title' => 'Responsive Vertical Theme',
    'thumb' => 'theme.jpg',
    'author' => '<a href="http://www.socialapps.tech" style="text-decoration:underline;" target="_blank">SocialApps.tech</a>',
    'actions' => array(
      'install',
      'upgrade',
      'refresh',
      'remove',
    ),
    'callback' => array(
      'class' => 'Engine_Package_Installer_Theme',
    ),
    'directories' => array(
      'application/themes/sitecoretheme',
    ),
  ),
  'files' => array(
    'structure.css',
    'constants.css',
    'media-queries.css',
    'customization.css',
    'mixins.css',
    'theme.css',
    'pink/colorConstants.css',
  ),
) ?>