<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: content.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
return array(
    array(
        'title' => $view->translate('Popular Question Tags'),
        'description' => $view->translate('Shows popular tags with frequency.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.tagcloud-siteqas',
        'defaultParams' => array(
            'title' => '',
            'titleCount' => true,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Text',
                    'itemCount',
                    array(
                        'label' => $view->translate('Count'),
                        'description' => $view->translate('(number of tags to show)'),
                        'value' => 100,
                    )
                ),
                array(
                    'Hidden',
                    'nomobile',
                    array(
                        'label' => '',
                        'order' => 1003
                    )
                ),
            ),
        ),
    ),
    array(
        'title' => $view->translate('Question Navigation Tabs'),
        'description' => $view->translate('Displays a menu in the question browse page.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.browse-menu',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => $view->translate('Question Browse Search'),
        'description' => $view->translate('Displays a search form in the question browse page.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.browse-search',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => $view->translate('Create New Question'),
        'description' => $view->translate('Displays a create question form.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.new-question',
        'requirements' => array(
            'no-subject',
        ),
    ),
    array(
        'title' => $view->translate('Categories Hierarchy for Questions (sidebar)'),
        'description' => $view->translate('Displays the Categories and Sub-categories of Questions in an expandable form. Clicking on them will redirect the viewer to the list of Questions created in that category.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.sidebar-categories-siteqas',
        'defaultParams' => array(
            'title' => $view->translate('Categories'),
            'titleCount' => true,
        ),
    ),
    array(
        'title' => $view->translate('Browse Question'),
        'description' => $view->translate('Displays the Question.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.browse-questions',
        'defaultParams' => array(
            'title' => $view->translate('Browse Question'),
            'titleCount' => true,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'limit',
                    array(
                        'label' => 'Select the number of questions you want to display',
                            'multiOptions' => array(
                              5 => '5',
                              10 => '10',
                              15 => '15',
                              20 => '20',
                              25 => '25'
                            ),
                        'value' => 5,
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => $view->translate('Most Voted Questions'),
        'description' => $view->translate('Displays the most voted Question.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.voted-questions',
        'defaultParams' => array(
            'title' => $view->translate('Most Voted Questions'),
            'titleCount' => true,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                'Text',
                'truncateLimit',
                    array(
                        'label' => 'Truncation limit',
                        'value' => 20,
                    )
                ),
                array(
                    'Radio',
                    'limit',
                    array(
                        'label' => 'Select the questions you want to display',
                            'multiOptions' => array(
                              1 => '1',
                              2 => '2',
                              3 => '3',
                              4 => '4',
                              5 => '5'
                            ),
                        'value' => 5,
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => $view->translate('Other Questions from Owner'),
        'description' => $view->translate('Displays the other Questions from owner.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.other-questions',
        'defaultParams' => array(
            'title' => $view->translate('Other Questions from Owner'),
            'titleCount' => true,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                'Text',
                'truncateLimit',
                    array(
                        'label' => 'Truncation limit',
                        'value' => 20,
                    )
                ),
                array(
                    'Radio',
                    'limit',
                    array(
                        'label' => 'Select the questions you want to display',
                            'multiOptions' => array(
                              1 => '1',
                              2 => '2',
                              3 => '3',
                              4 => '4',
                              5 => '5'
                            ),
                        'value' => 5,
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => $view->translate('Top User'),
        'description' => $view->translate('Displays the top user on the basis of most voted Answer.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.top-users',
        'defaultParams' => array(
            'title' => $view->translate('Top User'),
            'titleCount' => true,
        ),
        'adminForm' => array(
            'elements' => array(
                array(
                    'Radio',
                    'limit',
                    array(
                        'label' => 'Select the users you want to display',
                            'multiOptions' => array(
                              1 => '1',
                              2 => '2',
                              3 => '3',
                              4 => '4',
                              5 => '5'
                            ),
                        'value' => 5,
                    ),
                ),
            ),
        ),
    ),
    array(
        'title' => $view->translate('Question of the Day'),
        'description' => $view->translate('Displays the Question of the Day as selected by the Admin from the widget settings section of this plugin.'),
        'category' => $view->translate('Professional Questions and Answers Plugin'),
        'type' => 'widget',
        'name' => 'siteqa.item-sitequestion',
        'defaultParams' => array(
            'title' => $view->translate('Question of the Day'),
            'titleCount' => true,
            'contacts' => array("0" => "1", "1" => "2", "2" => "3", "3" => "4"),
        ),
    ),
);
