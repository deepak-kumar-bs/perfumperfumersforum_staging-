<?php
/**
 * SocialEngine - Search Widget Controller
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2012 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     Matthew
 */

class Seaocore_Widget_PfSearchHashtagsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    if (!in_array(
      'hashtags',
      Engine_Api::_()->getApi('settings', 'core')->getSetting('activity.composer.options')
    )) {
      return $this->setNoRender();
    }

    $searchApi = Engine_Api::_()->getApi('search', 'core'); 

    // Make form
    $this->view->form = $form = new Seaocore_Form_SearchHashtags();

    $optionparam = $this->_getParam('contentTypeOptions');

    // Get available types
      $availableTypes = $searchApi->getAvailableTypes();

      //add listing types

      if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitereview')){
        $listingtypesTable = Engine_Api::_()->getDbtable('listingtypes', 'sitereview');
        $listingTypes = $listingtypesTable->fetchAll($listingtypesTable->select());
        foreach ($listingTypes as $key => $type) {
          
          $optionkey = "sitereview_listing_".$type['listingtype_id'];
          $type1 = str_replace("_",'',$optionkey);
          if(in_array($type1, $optionparam))
            $listingoptions[$optionkey] = $type['title_plural'];
        }
        if(!empty($listingoptions))
          $form->content_type->addMultiOptions($listingoptions);
      }

      if(in_array('post', $optionparam))
        $form->content_type->addMultiOptions(array('post' => 'Post'));

      if(in_array('comment', $optionparam))
        $form->content_type->addMultiOptions(array('comment' => 'Comments'));


      if( is_array($availableTypes) && count($availableTypes) > 0 ) {
        $options = array();
        foreach( $availableTypes as $index => $type ) {
          $type1 = str_replace("_",'',$type);
          if(in_array($type1, $optionparam))
            $options[$type] = strtoupper('ITEM_TYPE_' . $type);
          }
        $form->content_type->addMultiOptions($options);

      } else {
        $form->removeElement('content_type');
      }

      
      // $form->order->addMultiOptions(array(
      //   'like_count' => 'Most Liked',
      //   // 'view_count' => 'Most Viewed',
      // ));

    $params = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    $form->populate($params);

    if(empty(array_filter($params['content_type'])) ){
      $this->view->AllCheckBox = true;
      
    }

  }
}
?>