<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: content.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

$arrayGallery = array();
if(Engine_Api::_()->getDbtable("modules", "core")->isModuleEnabled("sesatoz") && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.pluginactivated')) {

  $banner_options[] = '';
  $path = new DirectoryIterator(APPLICATION_PATH . '/public/admin/');
  foreach ($path as $file) {
    if ($file->isDot() || !$file->isFile())
      continue;
    $base_name = basename($file->getFilename());
    if (!($pos = strrpos($base_name, '.')))
      continue;
    $extension = strtolower(ltrim(substr($base_name, $pos), '.'));
//     if (!in_array($extension, array('gif', 'jpg', 'jpeg', 'png')))
//       continue;
    $banner_options['public/admin/' . $base_name] = $base_name;
  }

  $results = Engine_Api::_()->getDbtable('banners', 'sesatoz')->getBanner(array('fetchAll' => true));
  if (count($results) > 0) {
    foreach ($results as $gallery)
      $arrayGallery[$gallery['banner_id']] = $gallery['banner_name'];
  }
}
$moduleEnable = Engine_Api::_()->sesatoz()->getModulesEnable();
$headScript = new Zend_View_Helper_HeadScript();
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$headScript->appendFile(Zend_Registry::get('StaticBaseUrl') . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
$atoz_theme_widget = array(
		array(
			'title' => 'SES - Responsive A to Z Theme - Custom Navigation Menu',
			'description' => "Displays the plugin name in the menu inside an attractive banner. The menu name is automatically taken from the plugin on which the widget is placed. Edit this widget to configure various settings.",
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'sesatoz.custom-navigation-menu',
      'adminForm' => array(
        'elements' => array(
          array(
            'Select',
            'backgroundimage',
            array(
              'label' => 'Choose the Background Image to be shown in this widget.',
              'multiOptions' => $banner_options,
              'value' => '',
            )
          ),
          array(
              'Text',
              'height',
              array(
                  'label' => 'Enter the height of this Banner (in pixels).',
                  'value' => 150,
                  'validators' => array(
                      array('Int', true),
                      array('GreaterThan', true, array(0)),
                  )
              ),
          ),
          array(
              'Select',
              'textalignment',
              array(
                  'label' => 'Title text alignment.',
                  'multiOptions' => array(
                      'center' => 'Center',
                      'left' => 'Left'
                  ),
                  'value' => 'center',
              )
          ),
        ),
      ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Banner Slideshow',
        'description' => 'Displays banner slideshows as configured by you in the admin panel of this theme. Edit this widget to choose the slideshow to be shown and configure various settings.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'autoEdit' => true,
        'name' => 'sesatoz.banner-slideshow',
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'banner_id',
                    array(
                        'label' => 'Choose the Banner to be shown in this widget.',
                        'multiOptions' => $arrayGallery,
                        'value' => 1,
                    )
                ),
                array(
                    'Select',
                    'full_width',
                    array(
                        'label' => 'Do you want to show this Banner in full width?',
                        'multiOptions' => array(
                            '1' => 'Yes',
                            '0' => 'No'
                        ),
                        'value' => 1,
                    )
                ),
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of this Banner (in pixels).',
                        'value' => 200,
                        'validators' => array(
                            array('Int', true),
                            array('GreaterThan', true, array(0)),
                        )
                    ),
                ),
            ),
        ),
    ),
    array(
			'title' => 'SES - Responsive A to Z Theme - Footer Menu',
			'description' => 'This widget shows the site-wide footer menu. You can edit its contents in your menu editor. You can upload icons for each menu item of Footer Menu from the "Manage Menu Icons" section of Atoz Theme.',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.menu-footer',
      'autoEdit' => false,
    ),
		array(
			'title' => 'SES - Responsive A to Z Theme - Landing Page Header',
			'description' => 'This widget shows the Landing Page Header.',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.lp-header',
      'autoEdit' => false,
    ),
    array(
			'title' => 'SES - Responsive A to Z Theme - Login',
			'description' => 'This widget displays login form in a transparent block with an image in background of the page.',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.login',
      'autoEdit' => true,
      'adminForm' => array(
        ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Home Slider',
        'description' => 'This widget displays a banner in which the text will come in a very attractive floating way. This widget can be placed multiple times on a single or separate pages.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'name' => 'sesatoz.home-slider',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'height',
                    array(
                        'label' => 'Enter the height of slide.',
                    ),
                    'value' => '600',
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Content Highlight',
        'description' => 'This widget highlight content from chosen module in any of the 3 different designs available in this widget. Edit this widget to choose the module and design and configure various other settings.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'name' => 'sesatoz.highlight',
        'autoEdit' => true,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'sesatoz_highlight_module',
                    array(
                        'label' => 'Choose the Module to be shown in this widget.',
                        'multiOptions' => $moduleEnable,
                    )
                ),
                array(
                'Select',
                'popularitycriteria',
                array(
                    'label' => 'Choose the popularity criteria in this widget.',
                    'multiOptions' => array(
                    'creation_date' => 'Recently Created',
                    'view_count' => 'View Count',
                    'like_count' => 'Most Liked',
                    'comment_count' => 'Most Commented',
                    'modified_date' => 'Recently Modified'
                    ),
                )
                ),
                array(
                    'Select',
                    'sesatoz_highlight_design',
                    array(
                        'label' => 'Select the design',
                        'value' => 1,
                        'multiOptions' => array(1=>'Design 1',2=>'Design 2',3=>'Design 3',4=>'Design 4',5=>'Design 5',6=>'Design 6',7=>'Design 7' ),
                    ),
                ),
                array(
                    'Textarea',
                    'widgetdescription',
                    array(
                        'label' => 'Enter the description.',
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Features',
        'description' => 'This widget displays the features entered in the admin panel of this theme.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'name' => 'sesatoz.features',
        'autoEdit' => false,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'design',
                    array(
                        'label' => 'Select the design',
                        'value' => 1,
                        'multiOptions' => array(1=>'Design 1',2=>'Design 2'),
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Purchase Strip',
        'description' => 'This widget displays the purchase strip of this theme.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'name' => 'sesatoz.purchase-strip',
        'autoEdit' => false,
        'adminForm' => array(
            'elements' => array(
                array(
                  'Text',
                  'description',
                  array(
                    'label' => 'Enter Text',
                  ),
                  'value' => 'Grab our A to Z Theme Now.',
                ),
                array(
                  'Text',
                  'buttontext',
                  array(
                    'label' => 'Enter Button Text.',
                  ),
                  'value' => 'Purchase',
                ),
                array(
                  'Text',
                  'buttonlink',
                  array(
                    'label' => 'Enter Button Link.',
                  ),
                  'value' => '',
                ),
            ),
        ),
    ),
    array(
        'title' => 'SES - Responsive A to Z Theme - Counters',
        'description' => 'This widget displays the counters entered in the admin panel of this theme.',
        'category' => 'SES - Responsive A to Z Theme',
        'type' => 'widget',
        'name' => 'sesatoz.counters',
        'autoEdit' => false,
        'adminForm' => array(
            'elements' => array(
                array(
                    'Select',
                    'backgroundimage',
                    array(
                        'label' => 'Choose the Background Image to be shown in this widget.',
                        'multiOptions' => $banner_options,
                        'value' => '',
                    )
                ),
                array(
                  'Text',
                  'counter1',
                  array(
                    'label' => 'Enter Counter - 1 Value.',
                  ),
                  'value' => '500',
                ),
                array(
                  'Text',
                  'counter1text',
                  array(
                    'label' => 'Enter Counter - 1 Text.',
                  ),
                  'value' => 'Members',
                ),
                array(
                  'Text',
                  'counter2',
                  array(
                    'label' => 'Enter Counter - 2 Value.',
                  ),
                  'value' => '9',
                ),
                array(
                  'Text',
                  'counter2text',
                  array(
                    'label' => 'Enter Counter - 2 Text.',
                  ),
                  'value' => 'Year',
                ),
                array(
                  'Text',
                  'counter3',
                  array(
                    'label' => 'Enter Counter - 3 Value.',
                  ),
                  'value' => '25',
                ),
                array(
                  'Text',
                  'counter3text',
                  array(
                    'label' => 'Enter Counter - 3 Text.',
                  ),
                  'value' => 'Clients',
                ),

                array(
                  'Text',
                  'counter4',
                  array(
                    'label' => 'Enter Counter - 4 Value.',
                  ),
                  'value' => '200',
                ),
                array(
                  'Text',
                  'counter4text',
                  array(
                    'label' => 'Enter Counter - 4 Text.',
                  ),
                  'value' => 'Projects',
                ),
            ),
        ),
    ),
    array(
			'title' => 'SES - Responsive A to Z Theme - Member Cloud',
			'description' => "Displays members of your site in an attractive widget with a color affect on mouse-over on member's profile picture. You can configure various settings of this widget by clicking on 'edit'.",
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'autoEdit' => false,
			'name' => 'sesatoz.member-cloud',
    ),
			array(
			'title' => 'SES - Responsive A to Z Theme - Header',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.header',
			'autoEdit' => false,
		),
		 array(
			'title' => 'SES - Responsive A to Z Theme - Features Block Two',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.features-block-two',
			'autoEdit' => false,
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - Features Block Three',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.features-block-three',
			'autoEdit' => false,
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - Newsletter',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.newsletter',
			'autoEdit' => false,
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - Static Buttons',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.static-buttons',
			'autoEdit' => false,
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - More Features',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.more-features',
			'autoEdit' => false,
            'adminForm' => array(
                'elements' => array(
                    array(
                        'Select',
                        'fe1img',
                        array(
                            'label' => 'Choose the Feature - 1 Image.',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'fe1heading',
                        array(
                            'label' => 'Enter Feature - 1 Heading.',
                        ),
                        'value' => 'NO ADS',
                    ),
                    array(
                        'Text',
                        'fe1description',
                        array(
                            'label' => 'Enter Feature - 1 description.',
                        ),
                        'value' => "We don't display ads or related publications anywhere to distract readers from your content.",
                    ),
                    array(
                        'Text',
                        'fe1linktext',
                        array(
                            'label' => 'Enter Feature - 1 link text.',
                        ),
                        'value' => "START PUBLISHING",
                    ),
                    array(
                        'Text',
                        'fe1textlink',
                        array(
                            'label' => 'Enter Feature - 1 text link.',
                        ),
                        'value' => "#",
                    ),
                    array(
                        'Select',
                        'fe2img',
                        array(
                            'label' => 'Choose the Feature - 2 Image.',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'fe2heading',
                        array(
                            'label' => 'Enter Feature - 2 Heading.',
                        ),
                        'value' => 'NO ADS',
                    ),
                    array(
                        'Text',
                        'fe2description',
                        array(
                            'label' => 'Enter Feature - 2 description.',
                        ),
                        'value' => "We don't display ads or related publications anywhere to distract readers from your content.",
                    ),
                    array(
                        'Text',
                        'fe2linktext',
                        array(
                            'label' => 'Enter Feature - 2 link text.',
                        ),
                        'value' => "START PUBLISHING",
                    ),
                    array(
                        'Text',
                        'fe2textlink',
                        array(
                            'label' => 'Enter Feature - 2 text link.',
                        ),
                        'value' => "#",
                    ),
                    array(
                        'Select',
                        'fe3img',
                        array(
                            'label' => 'Choose the Feature - 3 Image.',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'fe3heading',
                        array(
                            'label' => 'Enter Feature - 3 Heading.',
                        ),
                        'value' => 'NO ADS',
                    ),
                    array(
                        'Text',
                        'fe3description',
                        array(
                            'label' => 'Enter Feature - 3 description.',
                        ),
                        'value' => "We don't display ads or related publications anywhere to distract readers from your content.",
                    ),
                    array(
                        'Text',
                        'fe3linktext',
                        array(
                            'label' => 'Enter Feature - 3 link text.',
                        ),
                        'value' => "START PUBLISHING",
                    ),
                    array(
                        'Text',
                        'fe3textlink',
                        array(
                            'label' => 'Enter Feature - 3 text link.',
                        ),
                        'value' => "#",
                    ),
                    array(
                        'Select',
                        'fe4img',
                        array(
                            'label' => 'Choose the Feature - 4 Image.',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'fe4heading',
                        array(
                            'label' => 'Enter Feature - 4 Heading.',
                        ),
                        'value' => 'NO ADS',
                    ),
                    array(
                        'Text',
                        'fe4description',
                        array(
                            'label' => 'Enter Feature - 4 description.',
                        ),
                        'value' => "We don't display ads or related publications anywhere to distract readers from your content.",
                    ),
                    array(
                        'Text',
                        'fe4linktext',
                        array(
                            'label' => 'Enter Feature - 4 link text.',
                        ),
                        'value' => "START PUBLISHING",
                    ),
                    array(
                        'Text',
                        'fe4textlink',
                        array(
                            'label' => 'Enter Feature - 4 text link.',
                        ),
                        'value' => "#",
                    ),
                ),
            ),
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - Parallax',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.parallax',
			'autoEdit' => true,
            'adminForm' => array(
                'elements' => array(
                    array(
                        'Select',
                        'bgimage',
                        array(
                            'label' => 'Choose the Background Image to be shown in this widget.',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'heading',
                        array(
                            'label' => 'Enter Heading for this widget',
                        ),
                        'value' => 'Stay in touch. Share moments.',
                    ),
                    array(
                        'Text',
                        'description',
                        array(
                            'label' => 'Enter description for this widget',
                        ),
                        'value' => 'We help you connect and share with the people in your life.',
                    ),
                    array(
                        'Text',
                        'buttontext',
                        array(
                            'label' => 'Enter button text for this widget',
                        ),
                        'value' => 'Join Us Today',
                    ),
                    array(
                        'Text',
                        'buttonlink',
                        array(
                            'label' => 'Enter button link for this widget',
                        ),
                        'value' => 'signup',
                    ),
                ),
            ),
		),
		array(
			'title' => 'SES - Responsive A to Z Theme - Mobile App',
			'description' => '',
			'category' => 'SES - Responsive A to Z Theme',
			'type' => 'widget',
			'name' => 'sesatoz.mobile-app',
			'autoEdit' => true,
            'adminForm' => array(
                'elements' => array(
                    array(
                        'Select',
                        'design',
                        array(
                            'label' => 'Select the design',
                            'value' => 1,
                            'multiOptions' => array(1=>'Design 1',2=>'Design 2'),
                        ),
                    ),
                    array(
                        'Select',
                        'mobilescreenshot',
                        array(
                            'label' => 'Choose the Image to be shown in this widget
														            [Note: For Design 1: Screenshot of Size 197 * 415
																				and For Design 2: Image of Size 505 * 450.]',
                            'multiOptions' => $banner_options,
                            'value' => '',
                        )
                    ),
                    array(
                        'Text',
                        'androidlink',
                        array(
                            'label' => 'Enter Android Store Link [Note: Doesnot Work in Design 2]',
                        ),
                        'value' => '',
                    ),
                    array(
                    'Text',
                    'ioslink',
                    array(
                        'label' => 'Enter iOS Store Link [Note: Doesnot Work in Design 2]',
                    ),
                    'value' => '',
                    ),
                ),
            ),
		),
  );

return $atoz_theme_widget;
