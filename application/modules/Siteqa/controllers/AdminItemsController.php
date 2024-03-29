<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: AdminItemsController.php 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Siteqa_AdminItemsController extends Core_Controller_Action_Admin {

    //ACTION FOR QUESTION OF THE DAY
    public function dayAction() {

        //TAB CREATION
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
                ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_items');

        //FORM GENERATION
        $this->view->formFilter = $formFilter = new Siteqa_Form_Admin_Filter();
        $group = $this->_getParam('page', 1);

        $values = array();
        if ($formFilter->isValid($this->_getAllParams())) {
            $values = $formFilter->getValues();
        }
        foreach ($values as $key => $value) {
            if (null == $value) {
                unset($values[$key]);
            }
        }
        $values = array_merge(array(
            'order' => 'start_date',
            'order_direction' => 'DESC',
                ), $values);

        $this->view->assign($values);

        //FETCH DATA
        $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('itemofthedays', 'siteqa')->getItemOfDayList($values, 'question_id', 'siteqa_question');
        $this->view->paginator->setItemCountPerPage(50);
        $this->view->paginator = $paginator->setCurrentPageNumber($group);
    }

    //ACTION FOR ADDING QUESTION OF THE DAY
    public function addItemAction() {

        //SET LAYOUT
        $this->_helper->layout->setLayout('admin-simple');

        //FORM GENERATION
        $form = $this->view->form = new Siteqa_Form_Admin_Item();
        $form->setAction($this->getFrontController()->getRouter()->assemble(array()));

        //CHECK POST
        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

            //GET FORM VALUES
            $values = $form->getValues();

            //BEGIN TRANSACTION
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {

                $table = Engine_Api::_()->getDbtable('itemofthedays', 'siteqa');
                $select = $table->select()->where('resource_id = ?', $values["resource_id"])->where('resource_type = ?', 'siteqa_question');
                $row = $table->fetchRow($select);

                if (empty($row)) {
                    $row = $table->createRow();
                    $row->resource_id = $values["resource_id"];
                }

                $viewer = Engine_Api::_()->user()->getViewer();
                $oldTz = date_default_timezone_get();
                date_default_timezone_set($viewer->timezone);
                $start = strtotime($values['starttime']);
                $end = strtotime($values['endtime']);
                date_default_timezone_set($oldTz);
                $values['starttime'] = date('Y-m-d H:i:s', $start);
                $values['endtime'] = date('Y-m-d H:i:s', $end);

                $row->start_date = $values["starttime"];
                $row->end_date = $values["endtime"];
                $row->resource_type = 'siteqa_question';
                $row->save();

                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('The Question of the Day has been added successfully.'))
            ));
        }
    }

    //ACTION FOR QUESTION SUGGESTION DROP-DOWN
    public function getitemAction() {

        $search_text = $this->_getParam('text', null);
        $limit = $this->_getParam('limit', 40);

        $data = array();

        $moduleContents = Engine_Api::_()->getItemTable('siteqa_question')->getDayItems($search_text, $limit = 10);

        foreach ($moduleContents as $moduleContent) {

            $content_photo = $this->view->itemPhoto($moduleContent, 'thumb.icon');

            $data[] = array(
                'id' => $moduleContent->question_id,
                'label' => $moduleContent->title,
                'photo' => $content_photo
            );
        }
        return $this->_helper->json($data);
    }

    //ACTION FOR QUESTION DELETE ENTRY
    public function deleteItemAction() {

        if ($this->getRequest()->isPost()) {
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $itemofthedaysTable = Engine_Api::_()->getDbtable('itemofthedays', 'siteqa')->delete(array('itemoftheday_id =?' => $this->_getParam('id')));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                throw $e;
            }
            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array(Zend_Registry::get('Zend_Translate')->_('Question deleted successfully'))
            ));
        }
        $this->renderScript('admin-items/delete.tpl');
    }

    //ACTION FOR MULTI DELETE QUESTION ENTRIES
    public function multiDeleteAction() {

        if ($this->getRequest()->isPost()) {
            $values = $this->getRequest()->getPost();
            foreach ($values as $key => $value) {
                if ($key == 'delete_' . $value) {
                    $sitegroupitemofthedays = Engine_Api::_()->getItem('siteqa_itemofthedays', (int) $value);
                    if (!empty($sitegroupitemofthedays)) {
                        $sitegroupitemofthedays->delete();
                    }
                }
            }
        }
        return $this->_helper->redirector->gotoRoute(array('action' => 'day'));
    }

}

?>