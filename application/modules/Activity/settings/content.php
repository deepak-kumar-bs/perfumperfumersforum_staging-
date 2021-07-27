<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Activity
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: content.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

// Get available types

$view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
$searchApi = Engine_Api::_()->getApi('search', 'core');
$availableTypes = $searchApi->getAvailableTypes();
if( is_array($availableTypes) && count($availableTypes) > 0 ) {
$options = array();
foreach( $availableTypes as $index => $type1 ) {
    $type = str_replace("_",'',$type1);
    // $options[$type] = strtoupper('ITEM_TYPE_' . $type1);

       // if(in_array($type, array("sitereviewpost","sitereviewtopic","sitereviewwishlist"))){
       //      $optionForHashtag[$type] = strtoupper('ITEM_TYPE_' . $type1);
       //  }
  }
}

$optionForHashtag['post'] = 'Post';
$optionForHashtag['comment'] = 'Comment';
// $optionForHashtag['sitereviewwishlist'] = 'List';


if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitereview')){
    $listingtypesTable = Engine_Api::_()->getDbtable('listingtypes', 'sitereview');
    $listingTypes = $listingtypesTable->fetchAll($listingtypesTable->select());
    foreach ($listingTypes as $key => $type) {
        $optionForHashtag["sitereviewlisting".$type['listingtype_id']] = $type['title_plural'];
    }

}

$optionForHashtagSearch = array(
    'MultiCheckbox',
    'contentTypeOptions',
    array(
        'label' => $view->translate('Choose the statistics that you want to be displayed for searching.'),
        'multiOptions' => $optionForHashtag,
    //'value' =>array("viewCount","likeCount","commentCount","reviewCount"),
    ),
);

// echo "<pre>"; print_r($optionForHashtag);

return array(
  array(
    'title' => 'Activity Feed',
    'description' => 'Displays the activity feed.',
    'category' => 'Core',
    'type' => 'widget',
    'name' => 'activity.feed',
    'defaultParams' => array(
      'title' => 'What\'s New',
      'max_photo' => '9',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Select', 'max_photo', array(
            'label' => 'Maximum Photos displayed in Activity Feed',
            'description' => 'Enter the maximum number of photos that you want to display as an attachment in the'
            . ' activity feed when multiple photos are uploaded by a user. Photos exceeding this value can be viewed'
            . ' by clicking the "+" thumbnail at the end of a photo stream in the activity feed.',
            'value' => 8,
            'multiOptions' => array(
              0 => 0,
              1 => 1,
              2 => 2,
              3 => 3,
              4 => 4,
              5 => 5,
              6 => 6,
              7 => 7,
              8 => 8,
              9 => 9,
              10 => 10,
              11 => 11,
              12 => 12,
            )
          )
        ),
      )
    ),
  ),
  array(
    'title' => 'PF show listing profile tag results',
    'description' => 'Displays the activity feed based on listing profile tag.',
    'category' => 'Core',
    'type' => 'widget',
    'name' => 'activity.pf-tag-feed',
    'defaultParams' => array(
      'title' => 'What\'s New',
      'max_photo' => '9',
    ),
    'adminForm' => array(
      'elements' => array(
        array(
          'Select', 'max_photo', array(
            'label' => 'Maximum Photos displayed in Activity Feed',
            'description' => 'Enter the maximum number of photos that you want to display as an attachment in the'
            . ' activity feed when multiple photos are uploaded by a user. Photos exceeding this value can be viewed'
            . ' by clicking the "+" thumbnail at the end of a photo stream in the activity feed.',
            'value' => 8,
            'multiOptions' => array(
              0 => 0,
              1 => 1,
              2 => 2,
              3 => 3,
              4 => 4,
              5 => 5,
              6 => 6,
              7 => 7,
              8 => 8,
              9 => 9,
              10 => 10,
              11 => 11,
              12 => 12,
            )
          )
        ),
        $optionForHashtagSearch,
      )
    ),
  ),
  array(
    'title' => 'Requests',
    'description' => 'Displays the current logged-in member\'s requests (i.e. friend requests, group invites, etc).',
    'category' => 'Core',
    'type' => 'widget',
    'name' => 'activity.list-requests',
    'defaultParams' => array(
      'title' => 'Requests',
    ),
    'requirements' => array(
      'viewer',
    ),
  ),
) ?>
