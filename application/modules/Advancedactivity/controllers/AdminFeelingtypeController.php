<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Advancedactivity
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: AdminFeelingtypeController.php 6590 2016-07-07 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Advancedactivity_AdminFeelingtypeController extends Core_Controller_Action_Admin {
  public function init() {
    //GET NAVIGATION
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('advancedactivity_admin_main', array(), 'advancedactivity_admin_main_feelingtype');  }

  public function indexAction() {
   
    $table = Engine_Api::_()->getDbtable('feelingtypes', 'advancedactivity');	
    $select = $table->select()		
      ->order('order ASC');		
    $this->view->feelingtypes = $table->fetchAll($select); 
    
  }

  public function createAction() {
   
    // Get form
    $this->view->form = $form = new Advancedactivity_Form_Admin_Feelingtype_Create();

    if (!$this->getRequest()->isPost()) {
      return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    $db = Engine_Api::_()->getItemTable('advancedactivity_feelingtype')->getAdapter();
    $db->beginTransaction();

    try {
        $form->saveValues();
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }

    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function addMoreAction() {

    $feelingtype_id = $this->_getParam('feelingtype_id');
    $this->view->feelingtype = $feelingtype = Engine_Api::_()->getItem('advancedactivity_feelingtype', $feelingtype_id);
    // Get form
    $this->view->form = $form = new Advancedactivity_Form_Admin_Feelingtype_Feeling_Add();
    $form->setTitle("Add more feelings for: " . $feelingtype->getTitle());

    if (!$this->getRequest()->isPost()) {
        return;
    }

    if (!$form->isValid($this->getRequest()->getPost())) {
        return;
    }

    $db = Engine_Api::_()->getItemTable('advancedactivity_feelingtype')->getAdapter();
    $db->beginTransaction();

    try {

        $form->saveValues($feelingtype);
        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        throw $e;
    }

    $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }

  public function manageAction() {
   
    $feelingtype_id = $this->_getParam('feelingtype_id');
    $this->view->feelingtype = $feelingtype = Engine_Api::_()->getItem('advancedactivity_feelingtype', $feelingtype_id);
    
  }

  public function editAction() {
 
    $feelingtype_id = $this->_getParam('feelingtype_id');
    $this->view->feelingtype = $feelingtype = Engine_Api::_()->getItem('advancedactivity_feelingtype', $feelingtype_id);
    $this->view->form = $form = new Advancedactivity_Form_Admin_Feelingtype_Edit();
    if (!$this->getRequest()->isPost()) {
      $feelingtypeArray = $feelingtype->toArray();
      if (date('Y-m-d H:i:s', strtotime($feelingtypeArray['end_time'])) === '2050-12-31 23:59:59') {
        unset($feelingtypeArray['end_time']);
      }
      $form->populate($feelingtypeArray);
      if(empty($feelingtype->type)){
          $form->removeElement('type');
      } else { 
          $contentTypes = json_decode($feelingtype->type);
          $form->type->setValue($contentTypes);
      }
      return;
    }
    if (!$form->isValid($this->getRequest()->getPost())) {
      return;
    }

    // Process
    $values = $form->getValues();
    if ($values['end_time'] === '0000-00-00') {
      unset($values['end_time']);
    }
    if(!empty($values['photo'])){
        $feelingtype->photo_id = $feelingtype->setContentIcon($form->photo);
    }
    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {
      $values['type'] = $values['type'] ? Zend_Json::encode($values['type']): null;
      $feelingtype->setFromArray($values);		
      $feelingtype->save();
      $db->commit();
    } catch (Exception $e) {
      $db->rollBack();
      throw $e;
    }
    $this->_redirect('admin/advancedactivity/feelingtype');
  }

  public function deleteAction() {
    //LAYOUT
    $this->_helper->layout->setLayout('admin-simple');
    $this->view->feelingtype_id = $feelingtype_id = $this->_getParam('feelingtype_id');

    if (!$this->getRequest()->isPost()) {
      return;
    }
    $values = $this->getRequest()->getPost();

    if ($values['confirm'] != $feelingtype_id) {
      return;
    }

    $db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();

    try {
       $row = Engine_Api::_()->getItem('advancedactivity_feelingtype', $feelingtype_id);	
       $row->delete();
      $db->commit();
    } catch (Exception $ex) {
      $db->rollBack();
      throw $ex;
    }
    $this->_forward('success', 'utility', 'core', array(
      'smoothboxClose' => 10,
      'parentRefresh' => 10,
      'messages' => array(Zend_Registry::get('Zend_Translate')->_('Deleted'))
    ));
  }

//ACTION FOR UPDATE ORDER 
  public function updateOrderAction() {
    //CHECK POST
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->beginTransaction();
      $values = $_POST;
      try {
        foreach ($values['order'] as $key => $value) {
          $row = Engine_Api::_()->getItem('advancedactivity_feelingtype', (int) $value);
          if (!empty($row)) {
            $row->order = $key + 1;
            $row->save();
          }
        }
        $db->commit();
        $this->_redirect('admin/advancedactivity/feelingtype');
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }
  public function enabledAction() {
      $this->view->feelingtype_id = $feelingtype_id = $this->_getParam('feelingtype_id');
    
      $item = Engine_Api::_()->getItem('advancedactivity_feelingtype', $feelingtype_id);
      $item->enabled = !$item->enabled;
      $item->save();
       
     $this->_helper->redirector->gotoRoute(array('action' => 'index'));
  }
   

}
