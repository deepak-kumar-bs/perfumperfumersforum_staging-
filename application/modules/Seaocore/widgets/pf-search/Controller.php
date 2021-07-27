<?php

class Seaocore_Widget_PfSearchController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
      $searchApi = Engine_Api::_()->getApi('search', 'core');      
      
      // check public settings
      $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
      if( !$require_check && !Zend_Controller_Action_HelperBroker::getStaticHelper('RequireUser')->checkRequire() ) {
        $this->setNoRender();
        return;
      }
        
      // Prepare form
      $this->view->form = $form = new Core_Form_Search();
      // Set Correct Action for the Search Form
      $this->view->form->setAction( "http://" . $_SERVER['HTTP_HOST'] . _ENGINE_R_BASE . '/pf-search' );

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
          $form->type->addMultiOptions($listingoptions);
      }

      if(in_array('post', $optionparam))
        $form->type->addMultiOptions(array('post' => 'Post'));


      if( is_array($availableTypes) && count($availableTypes) > 0 ) {
        $options = array();
        foreach( $availableTypes as $index => $type ) {
          $type1 = str_replace("_",'',$type);
          if(in_array($type1, $optionparam))
            $options[$type] = strtoupper('ITEM_TYPE_' . $type);
          }
        $form->type->addMultiOptions($options);

      } else {
        $form->removeElement('type');
      }



      $form->order->addMultiOptions(array(
        'like_count' => 'Most Liked',
        'view_count' => 'Most Viewed',
      ));
        
      // Check form validity?
      $values = array();
      if( $form->isValid($this->_getAllParams()) ) {
        $values = $form->getValues();
        }
      $this->view->query = $query = (string) @$values['query'];
      $this->view->type = $type = (string) @$values['type'];
      $this->view->page = $page = (int) $this->_getParam('page');
      if( $query ) {
        $this->view->paginator = $searchApi->getPaginator($query, $type);
        $this->view->paginator->setCurrentPageNumber($page);
        }
        
      $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();

    $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
    if(!$require_check){
      if( $viewer->getIdentity()){
        $this->view->search_check = true;
      }
      else{
        $this->view->search_check = false;
      }
    }
    else $this->view->search_check = true;        
      }   
}
?>