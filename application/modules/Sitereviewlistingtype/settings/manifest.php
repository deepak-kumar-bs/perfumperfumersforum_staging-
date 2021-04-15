<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereviewlistingtype
 * @copyright  Copyright 2012-2013 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: manifest.php 6590 2013-04-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
return array(
    'package' =>
    array(
        'type' => 'module',
        'name' => 'sitereviewlistingtype',
        'version' => '5.4.1',
        'path' => 'application/modules/Sitereviewlistingtype',
        'title' => 'Multiple Listing Types - Listing Type Creation Extension',
        'description' => 'Multiple Listing Types - Listing Type Creation Extension',
      'author' => '<a href="http://www.socialapps.tech" style="text-decoration:underline;" target="_blank">SocialApps.tech</a>',
        'actions' => array(
            'install',
            'upgrade',
            'refresh',
            'enable',
            'disable',
        ),
        'callback' => array(
            'path' => 'application/modules/Sitereviewlistingtype/settings/install.php',
            'class' => 'Sitereviewlistingtype_Installer',
            'priority' => 1680,
        ),
        'directories' => array(
            'application/modules/Sitereviewlistingtype',
        ),
        'files' =>
        array(
            0 => 'application/languages/en/sitereviewlistingtype.csv',
        ),
    ),
);
