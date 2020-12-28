<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageBannerController.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_AdminManageBannerController extends Core_Controller_Action_Admin {

  public function indexAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_managebanners');
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('banners', 'sesatoz')->getBanner();
    if ($this->getRequest()->isPost()) {
      $db = Engine_Db_Table::getDefaultAdapter();
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $banner = Engine_Api::_()->getItem('sesatoz_banner', $value)->delete();
          $db->query("DELETE FROM engine4_sesatoz_slides WHERE banner_id = " . $value);
        }
      }
    }
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(25);
    $paginator->setCurrentPageNumber($page);
  }
  public function createSlideAction() {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_managebanners');
    $this->view->banner_id = $id = $this->_getParam('id');
    $this->view->slide_id = $slide_id = $this->_getParam('slide_id', false);
    if (!$id)
      return;

    $this->view->form = $form = new Sesatoz_Form_Admin_Createslide();
    if ($slide_id) {
      //$form->setTitle("Edit HTML5 Video Background");
      $form->submit->setLabel('Save Changes');
      $form->setTitle("Edit Photo Slide");
      $form->setDescription("Below, edit the photo slide for the banner slideshow and configure the settings for the slide.");
      $slide = Engine_Api::_()->getItem('sesatoz_slide', $slide_id);
      $form->populate($slide->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('slides', 'sesatoz')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('slides', 'sesatoz');
        $values = $form->getValues();
        if (!isset($slide))
          $slide = $table->createRow();
				$slide->status = '1';
        $slide->setFromArray($values);
				$slide->save();
        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != '') {
          // Store video in temporary storage object for ffmpeg to handle
          $storage = Engine_Api::_()->getItemTable('storage_file');
          $filename = $storage->createFile($form->file, array(
              'parent_id' => $slide->slide_id,
              'parent_type' => 'sesatoz_slide',
              'user_id' => Engine_Api::_()->user()->getViewer()->getIdentity(),
          ));
          // Remove temporary file
          @unlink($file['tmp_name']);
          $slide->file_id = $filename->file_id;
          $slide->file_type = $filename->extension;
        }

        $slide->banner_id = $id;
        $slide->save();
        $db->commit();
        $url = Zend_Controller_Front::getInstance()->getRouter()->assemble(array('module' => 'sesatoz', 'controller' => 'manage-banner', 'action' => 'manage', 'id' => $id), 'admin_default', true);
        header("Location:" . $url);
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
    }
  }

  public function deleteSlideAction() {
    $this->view->type = $this->_getParam('type', null);
    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $slide = Engine_Api::_()->getItem('sesatoz_slide', $id);
      if ($slide->file_id) {
        $item = Engine_Api::_()->getItem('storage_file', $slide->file_id);
        if ($item->storage_path) {
          @unlink($item->storage_path);
          $item->remove();
        }
      }
      $slide->delete();

      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Slide Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-banner/delete-slide.tpl');
  }

  public function manageAction() {

    if ($this->getRequest()->isPost()) {
      $values = $this->getRequest()->getPost();
      foreach ($values as $key => $value) {
        if ($key == 'delete_' . $value) {
          $slide = Engine_Api::_()->getItem('sesatoz_slide', $value);
          if ($slide->file_id) {
            $item = Engine_Api::_()->getItem('storage_file', $slide->file_id);
            if ($item->storage_path) {
              @unlink($item->storage_path);
              $item->remove();
            }
          }
          $slide->delete();
        }
      }
    }
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_managebanners');
    $this->view->banner_id = $id = $this->_getParam('id');
    if (!$id)
      return;
    $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('slides', 'sesatoz')->getSlides($id, 'show_all');
    $page = $this->_getParam('page', 1);
    $paginator->setItemCountPerPage(1000);
    $paginator->setCurrentPageNumber($page);
  }
  public function orderAction() {

    if (!$this->getRequest()->isPost())
      return;

    $slidesTable = Engine_Api::_()->getDbtable('slides', 'sesatoz');
    $slides = $slidesTable->fetchAll($slidesTable->select());
    foreach ($slides as $slide) {
      $order = $this->getRequest()->getParam('slide_' . $slide->slide_id);
      if (!$order)
        $order = 999;
      $slide->order = $order;
      $slide->save();
    }
    return;
  }
  public function deleteBannerAction() {

    // In smoothbox
    $this->_helper->layout->setLayout('admin-simple');

    $this->view->form = $form = new Sesbasic_Form_Admin_Delete();
    $form->setTitle('Delete This Banner?');
    $form->setDescription('Are you sure that you want to delete this Banner? It will not be recoverable after being deleted.');
    $form->submit->setLabel('Delete');

    $id = $this->_getParam('id');
    $this->view->item_id = $id;
    // Check post
    if ($this->getRequest()->isPost()) {
      $chanel = Engine_Api::_()->getItem('sesatoz_banner', $id)->delete();
      $db = Engine_Db_Table::getDefaultAdapter();
      $db->query("DELETE FROM engine4_sesatoz_slides WHERE banner_id = " . $id);
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Banner Delete Successfully.')
      ));
    }
    // Output
    $this->renderScript('admin-manage-banner/delete-banner.tpl');
  }

  public function createBannerAction() {

    $this->_helper->layout->setLayout('admin-simple');
    $id = $this->_getParam('id', 0);

    $this->view->form = $form = new Sesatoz_Form_Admin_Banner();
    if ($id) {
      $form->setTitle("Edit Banner Slideshow Name");
      $form->submit->setLabel('Save Changes');
      $banner = Engine_Api::_()->getItem('sesatoz_banner', $id);
      $form->populate($banner->toArray());
    }
    if ($this->getRequest()->isPost()) {
      if (!$form->isValid($this->getRequest()->getPost()))
        return;
      $db = Engine_Api::_()->getDbtable('banners', 'sesatoz')->getAdapter();
      $db->beginTransaction();
      try {
        $table = Engine_Api::_()->getDbtable('banners', 'sesatoz');
        $values = $form->getValues();
        if (!$id)
          $banner = $table->createRow();
        $banner->setFromArray($values);
        $banner->creation_date = date('Y-m-d h:i:s');
        $banner->save();
        $db->commit();
      } catch (Exception $e) {
        $db->rollBack();
        throw $e;
      }
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 10,
          'parentRefresh' => 10,
          'messages' => array('Banner created successfully.')
      ));
    }
  }
  public function enabledAction() {

    $id = $this->_getParam('id');
    $banner_id = $this->_getParam('banner_id', 0);
    if (!empty($id)) {
      if(!empty($banner_id))
      $item = Engine_Api::_()->getItem('sesatoz_slide', $id);
      else
      $item = Engine_Api::_()->getItem('sesatoz_banner', $id);
      $item->enabled = !$item->enabled;
      $item->save();
    }
    if(!empty($banner_id))
    $this->_redirect('admin/sesatoz/manage-banner/manage/id/'.$banner_id);
    else
    $this->_redirect('admin/sesatoz/manage-banner');
  }



  //For write constant in xml file during upgradation
	public function constantxmlAction() {

    $bodyFontFamily = Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_body_fontfamily');
    if(empty($bodyFontFamily)) {
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_body_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_body_fontsize', '13px');
    }
    $headingFontFamily = Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_heading_fontfamily');
    if(empty($headingFontFamily)) {
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_heading_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_heading_fontsize', '17px');
    }
    $mainmenuFontFamily = Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_mainmenu_fontfamily');
    if(empty($mainmenuFontFamily)) {
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_mainmenu_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_mainmenu_fontsize', '13px');
    }
    $tabFontFamily = Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_tab_fontfamily');
    if(empty($tabFontFamily)) {
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_tab_fontfamily', 'Arial, Helvetica, sans-serif');
      Engine_Api::_()->sesatoz()->readWriteXML('sesatoz_tab_fontsize', '15px');
    }
		$referralurl = $this->_getParam('referralurl', false);
		if($referralurl == 'install') {
			$this->_redirect('install/manage');
		} elseif($referralurl == 'query') {
			$this->_redirect('install/manage/complete');
		}
	}

}
