<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Theme
 * @package    sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: default_manifest.php 2019-07-09 11:51:37Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
return array(
  'package' => array(
    'type' => 'theme',
    'name' => $manifest_theme_name,
    'revision' => '$Revision: 9747 $',
    'path' => 'application/themes/sitecoretheme/' . $manifest_theme_name,
    'repository' => 'socialengineaddOns.com',
    'title' => $manifest_theme_title,
    'thumb' => 'theme.jpg',
    'author' => 'SocialApps.tech',
    'directories' => array(
      'application/themes/sitecoretheme/' . $manifest_theme_name,
    ),
  ),
  'files' => array(
//		'constants.css',
    'colorConstants.css',
  ),
  )
?>