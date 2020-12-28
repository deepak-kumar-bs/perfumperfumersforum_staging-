<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: AdminSiteQaController.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Siteqa_AdminSiteQaController extends Core_Controller_Action_Admin
{
	//ACTION FOR GLOBAL SETTINGS
  public function manageAction()
  { 
		//GET NAVIGATION
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_siteqa');

    //FORM GENERATION
    $this->view->formFilter = $formFilter = new Siteqa_Form_Admin_Question_Filter();
    $page = $this->_getParam('page', 1);

		//GET CATEGORY TABLE
		$tableCategory = Engine_Api::_()->getDbTable('categories', 'siteqa');
		$tableCategoryName = $tableCategory->info('name');

		//GET USER TABLE NAME
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

		//GET HELP TABLE
		$this->view->helpTable = Engine_Api::_()->getDbtable('helps', 'siteqa');

		//GET Question TABLE
    $tableSiteqa = Engine_Api::_()->getDbtable('questions', 'siteqa');
    $tableSiteqaName = $tableSiteqa->info('name');

		//MAKE QUERY
    $select = $tableSiteqa->select()
            ->setIntegrityCheck(false)
            ->from($tableSiteqaName)
            ->joinLeft($tableUserName, "$tableSiteqaName.owner_id = $tableUserName.user_id", 'username');

    $values = array();

    if ($formFilter->isValid($this->_getAllParams())) {
      $values = $formFilter->getValues();
    }
    foreach ($values as $key => $value) {

      if (null == $value) {
        unset($values[$key]);
      }
    }

    //SEARCHING
    $this->view->owner = '';
    $this->view->title = '';
    $this->view->approved = '';
    $this->view->featured = '';
    $this->view->status = '';
    $this->view->category_id = '';
    $this->view->subcategory_id = '';
    
    $values = array_merge(array(
        'order' => 'question_id',
        'order_direction' => 'DESC',
            ), $values);

		if(!empty($_POST['owner'])) { $user_name = $_POST['owner']; } elseif(!empty($_GET['owner'])) { $user_name = $_GET['owner']; }  else { $user_name = '';}

		if(!empty($_POST['title'])) { $page_name = $_POST['title']; } elseif(!empty($_GET['title'])) { $page_name = $_GET['title']; } elseif($this->_getParam('title', '')) { $page_name = $this->_getParam('title', '');} else { $page_name = '';}

		//SEARCHING
    $this->view->owner = $values['owner'] = $user_name;
		$this->view->title = $values['title'] = $page_name; 

		if (!empty($page_name)) {
			$select->where($tableSiteqaName . '.title  LIKE ?', '%' . $page_name . '%');
		}    

		if (!empty($user_name)) {
			$select->where($tableUserName . '.username  LIKE ?', '%' . $user_name . '%');
		}

    if (isset($_POST['search'])) {

      if (!empty($_POST['approved'])) {
        $this->view->approved = $_POST['approved'];
        $_POST['approved']--;
        $select->where($tableSiteqaName . '.approved = ? ', $_POST['approved']);
      }

      if (!empty($_POST['category_id']) && empty($_POST['subcategory_id'])) {
        $this->view->category_id = $_POST['category_id'];
        $select->where($tableSiteqaName . '.category_id = ? ', $_POST['category_id']);
      } 
			elseif (!empty($_POST['category_id']) && !empty($_POST['subcategory_id'])) {
        $this->view->category_id = $_POST['category_id'];
        $subcategory_id = $this->view->subcategory_id = $_POST['subcategory_id'];

        $selectcategory = $tableCategory->select()
																->from($tableCategoryName, 'category_name')
																->where("(category_id = $subcategory_id)");
        $row = $tableCategory->fetchRow($selectcategory);

        if (!empty($row->category_name)) {
          $this->view->subcategory_name = $row->category_name;
        }

        $select->where($tableSiteqaName . '.category_id = ? ', $_POST['category_id'])
                ->where($tableSiteqaName . '.subcategory_id = ? ', $_POST['subcategory_id']);
      }
      elseif (!empty($_POST['category_id']) && !empty($_POST['subcategory_id'])) {
        
        $this->view->category_id = $_POST['category_id'];
        $subcategory_id = $this->view->subcategory_id = $_POST['subcategory_id'];
        
        $row = $tableCategory->getCategory($subcategory_id);
        if (!empty($row->category_name)) {
          $this->view->subcategory_name = $row->category_name;
        }
        $select->where($tableSiteqaName . '.category_id = ? ', $_POST['category_id'])
                ->where($tableSiteqaName . '.subcategory_id = ? ', $_POST['subcategory_id']);
      }
    }

		//SEND FORM VALUES TO TPL
    $this->view->formValues = array_filter($values);
    $this->view->assign($values);

		//SEND ORDER DIRECTION TO TPL
		$this->view->order_direction = !empty($values['order_direction']) ? $values['order_direction'] : 'DESC';

    $select->order((!empty($values['order']) ? $values['order'] : 'question_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    //MAKE PAGINATOR
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator->setItemCountPerPage(50);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
	}

	//ACTION FOR MAKE THE Question APPROVED/DIS-APPROVED
  public function approvedAction() {

		//GET Question ID
  	$question_id = $this->_getParam('question_id');

		//BEGIN TRANSCATION
   	$db = Engine_Db_Table::getDefaultAdapter();
    $db->beginTransaction();
    try {

			//GET Question OBJECT
     	$siteqa = Engine_Api::_()->getItem('siteqa_question', $question_id);
     	if($siteqa->approved == 0) {
   		  $siteqa->approved = 1;	
   		}
   		else {
   			$siteqa->approved = 0;
   		}

			//SAVE CHANGES AND COMMIT
   		$siteqa->save();
 			$db->commit();
	 	}
   	catch( Exception $e ){
     $db->rollBack();
     throw $e;
   	}

		//REDIRECT
  	$this->_redirect('admin/siteqa/site-qa/manage');   
 	}

  public function helpfulAction()
  {
    $viewer = Engine_Api::_()->user()->getViewer();

    $helpful =  Engine_Api::_()->getDbtable('helps', 'siteqa')->setHelful($this->getRequest()->getParam('question_id'),$viewer->getIdentity(),1,$this->getRequest()->getParam('answer_id'));

    $this->_redirect('admin/siteqa/site-qa/answer');
  }

  //ACTION FOR DELETE 
  public function deleteAction()
  {
    //SET LAYOUT
		$this->_helper->layout->setLayout('admin-simple');

		//GET Question ID
		$this->view->question_id = $question_id = $this->_getParam('question_id');

		if( $this->getRequest()->isPost()){

			//DELETE Question OBJECT
			Engine_Api::_()->getItem('siteqa_question', $question_id)->delete();

			$this->_forward('success', 'utility', 'core', array(
			   'smoothboxClose' => 10,
			   'parentRefresh'=> 10,
			   'messages' => array('')
			));
   	}
		$this->renderScript('admin-site-qa/delete.tpl');
	}

  //ACTION FOR ANSWER DELETE 
  public function answerdeleteAction()
  {
    //SET LAYOUT
    $this->_helper->layout->setLayout('admin-simple');

    //GET Question ID
    $this->view->answer_id = $answer_id = $this->_getParam('answer_id');

    if( $this->getRequest()->isPost()){

      //GET Answer OBJECT
      $answer = Engine_Api::_()->getItem('siteqa_answer', $answer_id);

      //Decrement anwer count to Question table
      $queTable = Engine_Api::_()->getDbtable('ques', 'siteqa');
      $queTable->update(array(
          'answer_count' => new Zend_Db_Expr('answer_count - 1'),
      ), array(
          'question_id = ?' => $answer->question_id,
      ));

      //DELETE Answer OBJECT
      $answer->delete();

      $this->_forward('success', 'utility', 'core', array(
         'smoothboxClose' => 10,
         'parentRefresh'=> 10,
         'messages' => array('')
      ));
    }
    $this->renderScript('admin-site-qa/answerdelete.tpl');
  }
    
  //ACTION FOR MULTI DELETE
  public function multiDeleteAnswerAction()
  {
    if ($this->getRequest()->isPost()) {

      //GET FORM VALUES
      $values = $this->getRequest()->getPost();
      
      foreach ($values as $key=>$value) {
        if ($key == 'delete_' . $value) {

          //GET Question ID
          $answer_id = (int)$value;

          //GET Answer OBJECT
          $answer = Engine_Api::_()->getItem('siteqa_answer', $answer_id);

          //Decrement anwer count to Question table
          $queTable = Engine_Api::_()->getDbtable('ques', 'siteqa');
          $queTable->update(array(
              'answer_count' => new Zend_Db_Expr('answer_count - 1'),
          ), array(
              'question_id = ?' => $answer->question_id,
          ));

          //DELETE Answer OBJECT
          $answer->delete();

        }
      }
    }

    //REDIRECT
    return $this->_helper->redirector->gotoRoute(array('action' => 'answer'));
  }

  //ACTION FOR MULTI DELETE
  public function multiDeleteAction()
  {
    if ($this->getRequest()->isPost()) {

			//GET FORM VALUES
      $values = $this->getRequest()->getPost();
      foreach ($values as $key=>$value) {
        if ($key == 'delete_' . $value) {

        	//GET Question ID
          $question_id = (int)$value;

					//DELETE Question OBJECT
					Engine_Api::_()->getItem('siteqa_question', $question_id)->delete();
        }
      }
    }

		//REDIRECT
    return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
  }

  //Action to manage answers
  public function answerAction($value='')
  {
    //GET NAVIGATION
    $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')
            ->getNavigation('siteqa_admin_main', array(), 'siteqa_admin_main_answer');

    //FORM GENERATION
    $this->view->formFilter = $formFilter = new Siteqa_Form_Admin_Question_Filter();
    $page = $this->_getParam('page', 1);

    //GET CATEGORY TABLE
    $tableCategory = Engine_Api::_()->getDbTable('categories', 'siteqa');
    $tableCategoryName = $tableCategory->info('name');

    //GET USER TABLE NAME
    $tableUserName = Engine_Api::_()->getItemTable('user')->info('name');

    //GET QUESTION TABLE
    $tableSiteqa = Engine_Api::_()->getDbtable('questions', 'siteqa');
    $tableSiteqaName = $tableSiteqa->info('name');

    //GET ANSWER TABLE
    $tableSiteqaAns = Engine_Api::_()->getDbtable('answers', 'siteqa');
    $tableSiteqaAnsName = $tableSiteqaAns->info('name');

    //MAKE QUERY
    $select = $tableSiteqaAns->select()
            ->setIntegrityCheck(false)
            ->from($tableSiteqaAnsName)
            ->joinLeft($tableSiteqaName, "$tableSiteqaAnsName.question_id = $tableSiteqaName.question_id",'title')
            ->joinLeft($tableUserName, "$tableSiteqaAnsName.owner_id = $tableUserName.user_id", 'username');
    $values = array();

    if ($formFilter->isValid($this->_getAllParams())) {
      $values = $formFilter->getValues();
    }
    
    foreach ($values as $key => $value) {

      if (null == $value) {
        unset($values[$key]);
      }
    }    
    //SEARCHING
    $this->view->owner = '';
    $this->view->title = '';
    $this->view->que_title = '';
    
    $values = array_merge(array(
        'order' => 'question_id',
        'order_direction' => 'DESC',
            ), $values);

    if(!empty($_POST['owner'])) { $user_name = $_POST['owner']; } elseif(!empty($_GET['owner'])) { $user_name = $_GET['owner']; }  else { $user_name = '';}

    if(!empty($_POST['title'])) { $page_name = $_POST['title']; } elseif(!empty($_GET['title'])) { $page_name = $_GET['title']; } elseif($this->_getParam('title', '')) { $page_name = $this->_getParam('title', '');} else { $page_name = '';}

    //SEARCHING
    $this->view->owner = $values['owner'] = $user_name;
    $this->view->title = $values['title'] = $page_name; 

    if (!empty($page_name)) {
      $select->where($tableSiteqaAnsName . '.body  LIKE ?', '%' . $page_name . '%');
    }    

    if (!empty($user_name)) {
      $select->where($tableUserName . '.username  LIKE ?', '%' . $user_name . '%');
    }

    if (!empty($_POST['que_title'])) {
      $select->where($tableSiteqaName . '.title  LIKE ?', '%' . $_POST['que_title'] . '%');
      $this->view->que_title = $_POST['que_title'];
    }

    //SEND FORM VALUES TO TPL
    $this->view->formValues = array_filter($values);
    $this->view->assign($values);

    //SEND ORDER DIRECTION TO TPL
    $this->view->order_direction = !empty($values['order_direction']) ? $values['order_direction'] : 'DESC';

    $select->order((!empty($values['order']) ? $values['order'] : 'question_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));

    //MAKE PAGINATOR
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);
    $this->view->paginator->setItemCountPerPage(50);
    $this->view->paginator = $paginator->setCurrentPageNumber($page);
  }

  /*
    * Function is to edit answers for admin panel
    */
    public function answereditAction()
    {
        $answer = Engine_Api::_()->getItem('siteqa_answer', $this->_getParam('answer_id'));

        // Prepare form
        $this->view->form = $form = new Siteqa_Form_Answer_Edit();
        
        // Populate form
        $form->populate($answer->toArray());

        // Check post/form
        if( !$this->getRequest()->isPost() ) {
            return;
        }
        if( !$form->isValid($this->getRequest()->getPost()) ) {
          return;
        }
        
        // Process
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            $values = $form->getValues();
        
            $answer->setFromArray($values);
            $answer->save();
            $db->commit();

        }
        catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        
      $this->_forward('success', 'utility', 'core', array(
          'smoothboxClose' => 400,
          'parentRefresh' => 10,
          'messages' => array('Your answer has been submitted.')
      ));
    }

}