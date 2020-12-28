<?php

/**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    Responsive Vertical Theme
 * @copyright  Copyright 2015-2016 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php 2016-11-21 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
return array (
  'package' => 
  array (
    'type' => 'theme',
    'name' => 'SES - Responsive AtoZ Theme',
    'version' => '4.9.0',
    'path' => 'application/themes/sesatoz',
    'repository' => 'socialenginesolutions.com',
    'title' => '<span style="color:#DDDDDD">SES - Responsive AtoZ Theme</span>',
    'thumb' => 'atoz_theme.jpg',
    'author' => '<a href="http://socialenginesolutions.com/" target="_blank" title="Visit our website!">SocialEngineSolutions</a>',
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'remove',
    ),
    'callback' => 
    array (
      'class' => 'Engine_Package_Installer_Theme',
    ),
    'directories' => 
    array (
      0 => 'application/themes/sesatoz',
    ),
    'description' => '',
  ),
  'files' => 
  array (
    0 => 'theme.css',
    1 => 'constants.css',
		2 => 'media-queries.css',
    3 => 'sesatoz-custom.css'
  )
); 