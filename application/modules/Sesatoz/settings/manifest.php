<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: manifest.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

return array(
	'package' => array(
        'type' => 'module',
        'name' => 'sesatoz',
        'sku' => 'sesatoz',
        'version' => '4.10.3p4',
        'dependencies' => array(
            array(
                'type' => 'module',
                'name' => 'core',
                'minVersion' => '4.9.4p3',
            ),
        ),
        'path' => 'application/modules/Sesatoz',
        'title' => 'SES - Responsive A to Z Theme',
        'description' => 'SES - Responsive A to Z Theme',
        'author' => '<a href="http://www.socialenginesolutions.com" style="text-decoration:underline;" target="_blank">SocialEngineSolutions</a>',
        'actions' => array(
                'install',
                'upgrade',
                'refresh',
                'enable',
                'disable',
        ),
        'callback' => array(
                'path' => 'application/modules/Sesatoz/settings/install.php',
                'class' => 'Sesatoz_Installer',
        ),
        'directories' =>
        array(
            'application/modules/Sesatoz',
            'application/themes/sesatoz'
        ),
        'files' => array(
            'application/languages/en/sesatoz.csv',
            'public/admin/blank.png',
            'public/admin/slide1.jpg',
            'public/admin/slide2.jpg',
            'public/admin/slide3.jpg',
            'public/admin/slide4.jpg',
            'public/admin/slider-bg-01.jpg',
            'public/admin/content-circle-bg.jpg',
            'public/admin/photo-icon.png',
            'public/admin/trophy.png',
            'public/admin/music-icon.png',
            'public/admin/video-icon.png',
            'public/admin/event-icon.png',
            'public/admin/group-icon.png',
            'public/admin/popup-bg.png',
            'public/admin/logo-az.png',
        ),
	),
	// Hooks ---------------------------------------------------------------------
	'hooks' => array(
		array(
			'event' => 'onRenderLayoutDefault',
			'resource' => 'Sesatoz_Plugin_Core'
		),
        array(
            'event' => 'onUserDeleteBefore',
            'resource' => 'Sesatoz_Plugin_Core',
        ),
	),
	// Items ---------------------------------------------------------------------
	'items' => array(
		'sesatoz_slideimage', 'sesatoz_slide', 'sesatoz_banner', 'sesatoz_customthemes', 'sesatoz_newsletteremail'
	),
);
