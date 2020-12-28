<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: AdminSettingsController.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Siteqa_AdminSettingsController extends Core_Controller_Action_Admin
{
	//ACTION FOR GLOBAL SETTINGS
  public function indexAction()
  {
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_settings');

    $this->view->form  = $form = new Siteqa_Form_Admin_Settings_Settings();
    
    if( $this->getRequest()->isPost() && $form->isValid($this->_getAllParams()) )
    {
      $values = $form->getValues();

      foreach ($values as $key => $value){
        Engine_Api::_()->getApi('settings', 'core')->setSetting($key, $value);
      }
      $form->addNotice('Your changes have been saved.');
    }       
  }

	//ACTION FOR LEVEL SETTINGS
  public function levelAction()
  {
  	//MAKE NAVIGATION
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_level');

    //FETCH LEVEL ID 
    if( null !== ($level_id = $this->_getParam('id')) ) {
      $level = Engine_Api::_()->getItem('authorization_level', $level_id);
    } else {
      $level = Engine_Api::_()->getItemTable('authorization_level')->getDefaultLevel();
    }

    if( !$level instanceof Authorization_Model_Level ) {
      throw new Engine_Exception($this->view->translate('missing level'));
    }

		//GET LEVEL ID
    $level_id = $level->level_id;

    //GENERATE FORM
    $this->view->form = $form = new Siteqa_Form_Admin_Settings_Level(array(
      'public' => ( in_array($level->type, array('public')) ),
      'moderator' => ( in_array($level->type, array('admin', 'moderator')) ),
    ));

		if(!empty($level_id)) {
			$form->level_id->setValue($level_id);
		}

    //GET AUTHORIZATION
    $permissionsTable = Engine_Api::_()->getDbtable('permissions', 'authorization');

    if( !$this->getRequest()->isPost() ) {
      $form->populate($permissionsTable->getAllowed('siteqa_question', $level_id, array_keys($form->getValues())));
      return;
    }
    
		//FORM VALIDATION
    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    //GET POSTED VALUE
    $values = $form->getValues();
    if($level_id != 5) {
			unset($values['dummy_siteqa_creation']);
		}

		unset($values['dummy_siteqa_general']);

		//BEGIN TRANSCATION
    $db = $permissionsTable->getAdapter();
    $db->beginTransaction();

    try {
      $permissionsTable->setAllowed('siteqa_question', $level_id, $values);
	    $db->commit();
    }
    catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }

	$form->addNotice('Your changes have been saved.');
  }

  //ACTION FOR MAPPING OF Questions
  Public function mappingCategoryAction()
  {
    //SET LAYOUT
    $this->_helper->layout->setLayout('admin-simple');

    //GET CATEGORY ID
    $this->view->catid = $catid = $this->_getParam('catid');

    //GET CATEGORY TITLE
    $this->view->oldcat_title = $oldcat_title = $this->_getParam('oldcat_title');

    //GET CATEGORY DEPENDANCY
    $this->view->subcat_dependency = $subcat_dependency = $this->_getParam('subcat_dependency');

    //CREATE FORM
    $this->view->form = $form = new Siteqa_Form_Admin_Settings_Mapping();

    $this->view->close_smoothbox = 0;

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    if( $this->getRequest()->isPost()){ 

      //GET FORM VALUES
      $values = $form->getValues();

      //GET FAQ TABLE
      $tableqa = Engine_Api::_()->getDbtable('questions', 'siteqa');

      //GET CATEGORY TABLE
      $tableCategory = Engine_Api::_()->getDbtable('categories', 'siteqa');

      //ON CATEGORY DELETE
      $rows = $tableCategory->getSubCategories($catid);
      foreach ($rows as $row) {
        $tableCategory->delete(array('cat_dependency = ?' => $row->category_id));
        $tableCategory->delete(array('category_id = ?' => $row->category_id));
      }

      //Question TABLE CATEGORY DELETE WORK
      if(isset($values['new_category_id']) && !empty($values['new_category_id']) ) {
        $tableqa->updateQuesCategories($catid, 'category_delete', $values['new_category_id']);
      }
      else {
        $tableqa->updateQuesCategories($catid, 'category_delete', 0);
      }
      $tableCategory->delete(array('category_id = ?' => $catid));
    }

    $this->view->close_smoothbox = 1;
  }

  //ACTION FOR GETTING THE CATGEORIES, SUBCATEGORIES AND 3RD LEVEL CATEGORIES
  public function categoriesAction() {

    //GET NAVIGATION
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_categories');

    //GET TASK
    if (isset($_POST['task'])) {
      $task = $_POST['task'];
    } elseif (isset($_GET['task'])) {
      $task = $_GET['task'];
    } else {
      $task = "main";
    }

    //GET CATEGORIES TABLE
    $tableCategory = Engine_Api::_()->getDbTable('categories', 'siteqa');
    $tableCategoryName = $tableCategory->info('name');
		//GET STORAGE API
		$this->view->storage = Engine_Api::_()->storage();

    //GET Questions TABLE
    $tableSiteqa = Engine_Api::_()->getDbtable('questions', 'siteqa');
    
    if ($task == "savecat") {

      //GET CATEGORY ID
      $category_id = $_GET['cat_id'];

      $cat_title_withoutparse = $_GET['cat_title'];

      //GET CATEGORY TITLE
      $cat_title = str_replace("'", "\'", trim($_GET['cat_title']));

      //GET CATEGORY DEPENDANCY
      $cat_dependency = $_GET['cat_dependency'];
      $subcat_dependency = $_GET['subcat_dependency'];
      if ($cat_title == "") {
        if ($category_id != "new") {
          if ($cat_dependency == 0) {
						//ON CATEGORY DELETE
            $row_ids = $tableCategory->getSubCategories($category_id);
            foreach ($row_ids as $values) {
              $tableCategory->delete(array('cat_dependency = ?' => $values->category_id));
              $tableCategory->delete(array('category_id = ?' => $values->category_id));
            }

						//Question TABLE CATEGORY DELETE WORK
            $tableSiteqa->updateQuesCategories($category_id, 'category_delete', 0);

            $tableCategory->delete(array('category_id = ?' => $category_id));

          } else {
            $tableCategory->update(array('category_name' => $cat_title), array('category_id = ?' => $category_id, 'cat_dependency = ?' => $cat_dependency));

						//Question TABLE SUB-CATEGORY/3RD LEVEL DELETE WORK
            $tableSiteqa->updateQuesCategories($category_id, '', 0);

            $tableCategory->delete(array('cat_dependency = ?' => $category_id));
            $tableCategory->delete(array('category_id = ?' => $category_id));
          }
        }
        //SEND AJAX CONFIRMATION
        echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
        echo "window.parent.removecat('$category_id');";
        echo "</script></head><body></body></html>";
        exit();
      } else {
        if ($category_id == 'new') {
          $row_info = $tableCategory->fetchRow($tableCategory->select()->from($tableCategoryName, 'max(cat_order) AS cat_order'));
          $cat_order = $row_info['cat_order'] + 1;
          $row = $tableCategory->createRow();
          $row->category_name = $cat_title_withoutparse;
          $row->cat_order = $cat_order;
          $row->cat_dependency = $cat_dependency;
          $newcat_id = $row->save();
        } else {
          $tableCategory->update(array('category_name' => $cat_title_withoutparse), array('category_id = ?' => $category_id));
          $newcat_id = $category_id;
        }

        //SEND AJAX CONFIRMATION
        echo "<html><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8'><script type='text/javascript'>";
        echo "window.parent.savecat_result('$category_id', '$newcat_id', '$cat_title', '$cat_dependency', '$subcat_dependency');";
        echo "</script></head><body></body></html>";
        exit();
      }
    } elseif ($task == "changeorder") {
      $divId = $_GET['divId'];
      $sitefaqOrder = explode(",", $_GET['sitefaqorder']);
      //RESORT CATEGORIES
      if ($divId == "categories") {
        for ($i = 0; $i < count($sitefaqOrder); $i++) {
          $category_id = substr($sitefaqOrder[$i], 4);
          $tableCategory->update(array('cat_order' => $i + 1), array('category_id = ?' => $category_id));
        }
      } elseif (substr($divId, 0, 7) == "subcats") {
        for ($i = 0; $i < count($sitefaqOrder); $i++) {
          $category_id = substr($sitefaqOrder[$i], 4);
          $tableCategory->update(array('cat_order' => $i + 1), array('category_id = ?' => $category_id));
        }
      } elseif (substr($divId, 0, 11) == "treesubcats") {
        for ($i = 0; $i < count($sitefaqOrder); $i++) {
          $category_id = substr($sitefaqOrder[$i], 4);
          $tableCategory->update(array('cat_order' => $i + 1), array('category_id = ?' => $category_id));
        }
      }
    }

    $categories = array();
    $category_info = $tableCategory->getCategories(null);
    foreach ($category_info as $value) {
      $sub_cat_array = array();
      $subcategories = $tableCategory->getAllCategories($value->category_id, 'subcategory_id', 0, 'subcategory_id', 0, 0, null, null);
      foreach ($subcategories as $subresults) {

				//GET TOTAL Question COUNT
				$subcategory_faq_count = 0;

         $sub_cat_array[] = $tmp_array = array('sub_cat_id' => $subresults->category_id,
            'sub_cat_name' => $subresults->category_name,
            'tree_sub_cat' => $treesubarrays[$subresults->category_id],
            'count' => $subcategory_faq_count,
						'file_id' => $subresults->file_id,
            'order' => $subresults->cat_order);
      }

			//GET TOTAL Question COUNT
			$category_faq_count = 0;

      $categories[] = $category_array = array('category_id' => $value->category_id,
          'category_name' => $value->category_name,
          'order' => $value->cat_order,
          'count' => $category_faq_count,
					'file_id' => $value->file_id,
          'sub_categories' => $sub_cat_array);
    }

	$this->view->categories = $categories;
  }

	//ACTION FOR ADD THE CATEGORY ICON
	Public function addIconAction()
	{
		//SET LAYOUT
		$this->_helper->layout->setLayout('admin-simple');

		//GET CATEGORY ID
		$this->view->category_id = $category_id = $this->_getParam('category_id');
		
    $category = Engine_Api::_()->getItem('siteqa_category', $category_id);
    
    //CREATE FORM
    $this->view->form = $form = new Siteqa_Form_Admin_Settings_Addicon();

		$this->view->close_smoothbox = 0;

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

		//UPLOAD PHOTO
		if( isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name']) )
		{
			//UPLOAD PHOTO
			$photoFile = $category->setPhoto($_FILES['photo']);

			//UPDATE FILE ID IN CATEGORY TABLE
			if(!empty($photoFile->file_id)) {
				$category->file_id = $photoFile->file_id;
				$category->save();
			}
		}

		$this->view->close_smoothbox = 1;
	}

	//ACTION FOR EDIT THE CATEGORY ICON
	Public function editIconAction()
	{
		//SET LAYOUT
		$this->_helper->layout->setLayout('admin-simple');

		//GET CATEGORY ID
		$this->view->category_id = $category_id = $this->_getParam('category_id');

		//GET CATEGORY ITEM
		$category = Engine_Api::_()->getItem('siteqa_category', $category_id);

    //CREATE FORM
    $this->view->form = $form = new Siteqa_Form_Admin_Settings_Editicon();

		$this->view->close_smoothbox = 0;

    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

		//UPLOAD PHOTO
		if( isset($_FILES['photo']) && is_uploaded_file($_FILES['photo']['tmp_name']) )
		{
			//UPLOAD PHOTO
			$photoFile = $category->setPhoto($_FILES['photo']);

			//UPDATE FILE ID IN CATEGORY TABLE
			if(!empty($photoFile->file_id)) {
				$previous_file_id = $category->file_id;
				$category->file_id = $photoFile->file_id;
				$category->save();
			
				//DELETE PREVIOUS CATEGORY ICON
				$file = Engine_Api::_()->getItem('storage_file', $previous_file_id);
				$file->delete();
			}
		}

		$this->view->close_smoothbox = 1;
	}

  //ACTION FOR DELETE THE CATEGORY ICON
  public function deleteIconAction()
  {
		//SET LAYOUT
		$this->_helper->layout->setLayout('admin-simple');

		//GET CATEGORY ID
		$this->view->category_id = $category_id = $this->_getParam('category_id');

		//GET CATEGORY ITEM
		$category = Engine_Api::_()->getItem('siteqa_category', $category_id);

		$this->view->close_smoothbox = 0;

		if( $this->getRequest()->isPost() && !empty($category->file_id)){

			//DELETE CATEGORY ICON
			$file = Engine_Api::_()->getItem('storage_file', $category->file_id);
			$file->delete();

			//UPDATE FILE ID IN CATEGORY TABLE
			$category->file_id = 0;
			$category->save();

			$this->view->close_smoothbox = 1;
   	}
		$this->renderScript('admin-settings/delete-icon.tpl');
	}

  //ACTION FOR Question SECTION
  public function qaAction()
  {
		//GET NAVIGATION
  	$this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
      	 ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_qa');
  }


}