<?php

class Siteqa_IndexController extends Core_Controller_Action_Standard
{
  /*
  * CreateAction is for create Question form
  */
  public function createAction() 
  {

    //Render
    $this->_helper->content
         ->setEnabled()
    ;
    
    if( !$this->_helper->requireUser()->isValid() ) return;

  	$viewer = Engine_Api::_()->user()->getViewer();
    $this->view->form = $form = new Siteqa_Form_Create();

    //APPROVE PERMISSION 
    $itemApprove = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'approved');

    $itemcreate = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'create');
    
    //PERMISSION CHECK ALLOWED OR NOT
    if(empty($itemcreate)){
        return $this->_forward('requireauth', 'error', 'core');
    }

    // set up data needed to check quota
    $values['user_id'] = $viewer->getIdentity();
    $paginator = Engine_Api::_()->getItemTable('question')->getQuestionsPaginator($values);

    $this->view->quota = $quota = Engine_Api::_()->authorization()->getPermission($viewer->level_id, 'siteqa_question', 'max');
    $this->view->current_count = $paginator->getTotalItemCount();

    //GET TOTAL CATEGORIES
    $categories = Engine_Api::_()->getDbTable('categories', 'siteqa')->getCategories(null);
        $this->view->category_exist = 0;
    if (count($categories) != 0) {
        $this->view->category_exist = 1;
    }

    //GET CATEGORIES ARRAY
    foreach($_POST as $key => $value) {
        $sub = strstr($key, 'sub');
        $subsub = strstr($key, 'subsub');
        $category = strstr($key, 'category_id_');

        if(empty($sub) && !empty($category) && !empty($value)) {
            //CATEGORY ID
            $category_id = "$value";
        }
        elseif(!empty($sub) && !empty($category) && !empty($value)) {
            //SUB-CATEGORY ID
            $subcategory_id = "$value";
        }
    }

    $this->view->alreadyCreated = Count($category_id);
    if($this->view->alreadyCreated == 0) {
        $this->view->alreadyCreated = 1;
    }

    if( !$this->getRequest()->isPost() ) {
        return;
    }
    if( !$form->isValid($this->getRequest()->getPost()) ) {
        return;
    }

    $this->view->alreadyCreated = 1;   
    $auth = Engine_Api::_()->authorization()->context; 
    $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

    if (empty($category_id)) {
        $error = $this->view->translate('Category <BR /> Please complete this field - it is required.');
        $form->getDecorator('errors')->setOption('escape', false);
        $form->addError($error);
        return;
    }

    // Process
    $table = Engine_Api::_()->getItemTable('question');
    $db = $table->getAdapter();
    $db->beginTransaction();

    try {
        // Create Question
        $viewer = Engine_Api::_()->user()->getViewer();
        $viewer_id = $viewer->getIdentity();
        $formValues = $form->getValues();
        $question = $table->createRow();
        $question->setFromArray($formValues);
        //ENCODE CATEGORIES
        $question->owner_id = $viewer_id;
        //ENCODE CATEGORIES
        $question->category_id = ($category_id)?$category_id:0;
        $question->subcategory_id = ($subcategory_id)?$subcategory_id:0;
        
        $question->approved = $itemApprove??0;
        $question->save();
        if( !empty($formValues['photo']) ) {
                $question->setPhoto($form->photo);
        }

        
        //TO ADD ACTIVITY
        $action = Engine_Api::_()->getDbtable('actions','activity')->addActivity($viewer,$question,'question_new','',array(''));
        if($action){
            Engine_Api::_()->getDbtable('actions','activity')->attachActivity($action,$question);
        }

        // Commit
        $db->commit();
        //ADDING TAGS
        $keywords = '';
        if (isset($formValues['tags']) && !empty($formValues['tags'])) {
            $tags = preg_split('/[,]+/', $formValues['tags']);
            $tags = array_filter(array_map("trim", $tags));
            $question->tags()->addTagMaps($viewer, $tags);

            foreach($tags as $tag) {
                $keywords .= " $tag";
            }
        }

        // Auth
        $commentMax = array_search($formValues['comment_privacy'], $roles);

        foreach( $roles as $i => $role ) {
            $auth->setAllowed($question, $role, 'comment', ($i <= $commentMax));
        }

        //UPDATE KEYWORDS IN SEARCH TABLE
        // if(!empty($keywords)) {
            Engine_Api::_()->getDbTable('search', 'core')->insert(array('keywords' => $keywords, 'type' => 'siteqa_question', 'id' => $question->question_id, 'title' => $question->title, 'description' => $question->body));
        // }

        return $this->_helper->redirector->gotoRoute(array('action' => 'manage'));
    } catch( Exception $e ) {
        return $this->exceptionWrapper($e, $form, $db);
    }    
   }

    //ACTION FOR Questions LISTING
    public function browseAction()
    {
        $this->view->can_view = $this->_helper->requireAuth()->setAuthParams('siteqa_question', null, 'view')->checkRequire();

        
        if (empty($this->view->can_view)) {
          return $this->_forwardCustom('requireauth', 'error', 'core');
        }
        
        //RENDER PAGE
        $this->_helper->content
         ->setNoRender()
         ->setEnabled();

    }

    //ACTION FOR CONSTRUCT TAG CLOUD
    public function tagscloudAction() {

        //Render
        $this->_helper->content
             ->setEnabled()
        ;
        //GET navigation
        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('siteqa_main', array(), '');
        
        //CONSTRUCTING TAG CLOUD
        $tag_array = array();
        $tag_cloud_array = Engine_Api::_()->siteqa()->getTags(0, 0, 0);

        foreach ($tag_cloud_array as $vales) {
          $tag_array[$vales['text']] = $vales['Frequency'];
          $tag_id_array[$vales['text']] = $vales['tag_id'];
        }

        if (!empty($tag_array)) {
          $max_font_size = 18;
          $min_font_size = 12;
          $max_frequency = max(array_values($tag_array));
          $min_frequency = min(array_values($tag_array));
          $spread = $max_frequency - $min_frequency;
          if ($spread == 0) {
            $spread = 1;
          }
          $step = ($max_font_size - $min_font_size) / ($spread);

          $tag_data = array('min_font_size' => $min_font_size, 'max_font_size' => $max_font_size, 'max_frequency' => $max_frequency, 'min_frequency' => $min_frequency, 'step' => $step);
          $this->view->tag_data = $tag_data;
          $this->view->tag_id_array = $tag_id_array;
        }
        $this->view->tag_array = $tag_array;
      }


    /*
    * viewFunction is to view particular question details
    */
    public function viewAction()
    {
        $viewer = Engine_Api::_()->user()->getViewer();

        //Render
        $this->_helper->content
             ->setEnabled()
        ;

        $question_id = (int) $this->_getParam('question_id');
        //SET QUESTION SUBJECT
        if( 0 !== ($question_id) &&
            null !== ($siteqa = Engine_Api::_()->getItem('siteqa_question', $question_id)) && !$this->_getParam('isajax') ) {
          Engine_Api::_()->core()->setSubject($siteqa);
        }

        $this->view->can_view = $this->_helper->requireAuth()->setAuthParams('siteqa_question', null, 'view')->checkRequire();

        if (empty($this->view->can_view)) {
          return $this->_forwardCustom('requireauth', 'error', 'core');
        }

        $this->view->is_ajax = $is_ajax = $this->_getParam('isajax',0);
        $this->view->level_id = ($viewer->getIdentity()) ? $viewer->level_id : 0;

        //IF LISTING IS NOT EXIST
        if (empty($siteqa)) {
          return $this->_forward('notfound', 'error', 'core');
        }  

        $this->view->question = $question = Engine_Api::_()->getItem('question', $this->getRequest()->getParam('question_id'));

        if(empty($question->approved)){
            if(($viewer->getIdentity() != $question->owner_id) && $viewer->level_id != 1){
                return $this->_forward('notfound', 'error', 'core');     
            }
        }

        $values = $this->_getAllParams();

        // Prepare data
        $queTable = Engine_Api::_()->getDbtable('questions', 'siteqa');

        if( !$question->isOwner($viewer) ) {
            $queTable->update(array(
                'view_count' => new Zend_Db_Expr('view_count + 1'),
            ), array(
                'question_id = ?' => $question->getIdentity(),
            ));
        }

        // Get tags
        $this->view->questionTags = $question->tags()->getTagMaps();
        $siteqa_api = Engine_Api::_()->siteqa();
        
        if($values['resource_type'] || $values['resource_id']){
            //ENTER IN VOTES
            $votes =  Engine_Api::_()->getDbtable('votes', 'siteqa')->setVote($viewer->getIdentity(),$values['resource_type'],$values['resource_id'],$values['vote']);

            $vote = ($values['vote'] > 0) ? 'Positive' : 'Negative';
            
            if($values['resource_type'] != 'siteqa_que'){
                //TO GET ANSWER OWNER
                $answer = Engine_Api::_()->getItem('siteqa_answer', $values['resource_id']);
                $answer_owner = $answer->getOwner();

                //TO SEND NOTIFICATION
                $url =  Zend_Registry::get('Zend_View')->url(array('question_id' => $question_id), 'qa_entry_view', true);
                $link = '<a href="'.$url.'"> Answer.</a>';
                $siteqa_api->addCustomNotifications($answer_owner, $viewer, $answer, 'answer_vote' , array('vote' => $vote,'link' => $link));    
            }else if($values['resource_type'] == 'siteqa_que'){
                //TO GET ANSWER OWNER
                $question = Engine_Api::_()->getItem('siteqa_question', $values['resource_id']);
                $question_owner = $question->getOwner();

                //TO SEND NOTIFICATION

                $url =  Zend_Registry::get('Zend_View')->url(array('question_id' => $question_id), 'qa_entry_view', true);
                $link = '<a href="'.$url.'"> Question.</a>';
                $siteqa_api->addCustomNotifications($question_owner, $viewer, $question, 'question_vote', array('vote' => $vote,'link' => $link));

            }
            
            echo $this->_helper->json($votes); exit;
        }

        if($values['helpful'] || $values['option_id']){
            //TO GET ANSWER OWNER
            $answer = Engine_Api::_()->getItem('siteqa_answer', $values['option_id']);
            $answer_owner = $answer->getOwner();

            //TO SEND NOTIFICATION
            $url =  Zend_Registry::get('Zend_View')->url(array('question_id' => $question_id), 'qa_entry_view', true);
            $link = '<a href="'.$url.'"> Question.</a>';
            $siteqa_api->addCustomNotifications($answer_owner, $viewer, $answer, 'answer_helpful', array('link' => $link));

            //ENTER IN VOTES
            $helpful =  Engine_Api::_()->getDbtable('helps', 'siteqa')->setHelful($this->getRequest()->getParam('question_id'),$viewer->getIdentity(),$values['helpful'],$values['option_id']);
            
            echo $this->_helper->json($helpful); exit;
        }
        
        $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('question')->getAnswerFromQueId($values);
        $items_per_page = '10';

        //$items_per_page = Engine_Api::_()->getApi('settings', 'core')->question_page;
        $paginator->setItemCountPerPage($items_per_page);
        $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );
    }


    /*
    * manageAction is for display Question and perform edit delete *  operation
    */
    public function manageAction()
    {
   		$viewer = Engine_Api::_()->user()->getViewer();
        
        if( !$this->_helper->requireUser()->isValid() ) return;

        //Render
        if(!$this->_getParam('isajax')){
            $this->_helper->content
            //->setNoRender()
            ->setEnabled()
        ;
        }

        $itemview = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'view');

        if(empty($itemview)){
            return $this->_forward('requireauth', 'error', 'core');
        }

        $this->view->form = $form = new Siteqa_Form_Search();
        
        // Process form
        $defaultValues = $form->getValues();
        if( $form->isValid($this->_getAllParams()) ) {
            $values = $form->getValues();
        } else {
            $values = $defaultValues;
        }
        $this->view->formValues = array_filter($values);
        
        $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('question')->getQuestionsPaginator($values);
        $items_per_page = '10';
        //$items_per_page = Engine_Api::_()->getApi('settings', 'core')->question_page;
        $paginator->setItemCountPerPage($items_per_page);
        $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );    
        
    }

    /*
    * Function is to edit question
    */
    public function editAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
        $question = Engine_Api::_()->getItem('question', $this->_getParam('question_id'));

        $itemedit = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'edit');
        //PERMISSION CHECK ALLOWED OR NOT
        if(empty($itemedit)){
            return $this->_forward('requireauth', 'error', 'core');
        }

        //GET CORE SETTING 
        $settings = Engine_Api::_()->getApi('settings', 'core');
        
        // Prepare form
        $this->view->form = $form = new Siteqa_Form_Edit(array(
        ));
        
        if($settings->getSetting('siteqa.tag', 1)){
            //PREPARE TAGS
            $siteqaTags = $question->tags()->getTagMaps();
            $tagString = '';
            foreach ($siteqaTags as $tagmap) {
                if ($tagString !== '') {
                    $tagString .= ', ';
                }
                $tagString .= $tagmap->getTag()->getTitle();
            }
            $this->view->tagNamePrepared = $tagString;
            $form->tags->setValue($tagString);
        }
        // Populate form
        $form->populate($question->toArray());

        // Check post/form
        if( !$this->getRequest()->isPost() ) {
            return;
        }
        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        //GET CATEGORIES ARRAY
        foreach($_POST as $key => $value) {
            $sub = strstr($key, 'sub');
            $subsub = strstr($key, 'subsub');
            $category = strstr($key, 'category_id_');

            if(empty($sub) && !empty($category) && !empty($value)) {
                //CATEGORY ID
                $category_id = "$value";
            }
            elseif(!empty($sub) && empty($subsub) && !empty($category) && !empty($value)) {
                //SUB-CATEGORY ID
                $subcategory_id = "$value";
            }
        }

        $auth = Engine_Api::_()->authorization()->context; 
        $roles = array('owner', 'owner_member', 'owner_member_member', 'owner_network', 'registered', 'everyone');

        // Process
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();

        try {
            $values = $form->getValues();
            $question->setFromArray($values);
            //ENCODE CATEGORIES
            $question->category_id = ($category_id);
            $question->subcategory_id = ($subcategory_id);
            
            $question->save();
            if( !empty($values['photo']) ) {
                $question->setPhoto($form->photo);
            }
            //ADDING TAGS
            if (isset($values['tags'])) {
                $tags = preg_split('/[,]+/', $values['tags']);
                $tags = array_filter(array_map("trim", $tags));
                $question->tags()->setTagMaps($viewer, $tags);

                foreach($tags as $tag) {
                    $keywords .= " $tag";
                }
            }

            //UPDATE KEYWORDS IN SEARCH TABLE
            if(!empty($keywords)) {
                Engine_Api::_()->getDbTable('search', 'core')->update(array('keywords' => $keywords,'title' => $values['title'], 'desciption' => $values['body']), array('type = ?' => 'siteqa_question', 'id = ?' => $question->question_id));
            }

            // Auth
            $commentMax = array_search($values['comment_privacy'], $roles);

            foreach( $roles as $i => $role ) {
                $auth->setAllowed($question, $role, 'comment', ($i <= $commentMax));
            }

            $db->commit();

        }
        catch( Exception $e ) {
            $db->rollBack();
            throw $e;
        }
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your entry has been updated.');
        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'qa_general', true),
            'messages' => Array($this->view->message)
        ));
    }

    /*
    * Function is to delete questions
    */
    public function deleteAction()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        
        $itemdelete = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'delete');
        //PERMISSION CHECK ALLOWED OR NOT
        if(empty($itemdelete)){
            return $this->_forward('requireauth', 'error', 'core');
        }

        $question = Engine_Api::_()->getItem('question', $this->getRequest()->getParam('question_id'));
        
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        $this->view->form = $form = new Siteqa_Form_Delete();

        if( !$question ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Question entry doesn't exist or not authorized to delete");
            return;
        }

        //RETURN IF NOT POSTED
        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $this->view->question_id = $question_id = $this->_getParam('question_id');

        //DELETE QUESTION OBJECT
        Engine_Api::_()->getItem('siteqa_question', $question_id)->delete();

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your Question with all its Tags, Answers has been Deleted.');
        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'qa_general', true),
            'messages' => Array($this->view->message)
        ));
    }

    /*
    * Function is to delete answers
    */
    public function answerdeleteAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
        $answer = Engine_Api::_()->getItem('siteqa_answer', $this->getRequest()->getParam('answer_id'));
        
        // In smoothbox
        $this->_helper->layout->setLayout('default-simple');

        $this->view->form = $form = new Siteqa_Form_Answer_Delete();

        if( !$answer ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_("Answer entry doesn't exist or not authorized to delete");
            return;
        }

        if( !$this->getRequest()->isPost() ) {
            $this->view->status = false;
            $this->view->error = Zend_Registry::get('Zend_Translate')->_('Invalid request method');
            return;
        }

        $this->view->answer_id = $answer_id = $this->_getParam('answer_id');
        
        //DELETE Answer OBJECT
        $answer = Engine_Api::_()->getItem('siteqa_answer', $answer_id);

        //Decrement anwer count to Question table
        $queTable = Engine_Api::_()->getDbtable('questions', 'siteqa');
        $queTable->update(array(
            'answer_count' => new Zend_Db_Expr('answer_count - 1'),
        ), array(
            'question_id = ?' => $answer->question_id,
        ));

        $answer->delete();

        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your Answer has been Deleted.');
        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'qa_general', true),
            'messages' => Array($this->view->message)
        ));
    }

    /*
    * Function is to edit answers
    */
    public function answereditAction()
    {
        if( !$this->_helper->requireUser()->isValid() ) return;

        $viewer = Engine_Api::_()->user()->getViewer();
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
        
        $this->view->status = true;
        $this->view->message = Zend_Registry::get('Zend_Translate')->_('Your entry has been updated.');
        return $this->_forward('success' ,'utility', 'core', array(
            'parentRedirect' => Zend_Controller_Front::getInstance()->getRouter()->assemble(array('action' => 'manage'), 'qa_general', true),
            'messages' => Array($this->view->message)
        ));
    }

    //ACTION TO GET SUB-CATEGORY
    public function subCategoryAction() {

        //GET CATEGORY ID
        $category_id_temp = $this->_getParam('category_id_temp');

            //INTIALIZE ARRAY
            $this->view->subcats = $data = array();

            //RETURN IF CATEGORY ID IS EMPTY
        if (empty($category_id_temp))
          return;

            //GET CATEGORY TABLE
            $tableCategory = Engine_Api::_()->getDbTable('categories', 'siteqa');

            //GET CATEGORY
        $category = $tableCategory->getCategory($category_id_temp);
        if (!empty($category->category_name)) {
          $categoryName = $tableCategory->getCategorySlug($category->category_name);
        }

            //GET SUB-CATEGORY
        $subCategories = $tableCategory->getSubCategories($category_id_temp);
      
        foreach ($subCategories as $subCategory) {
          $content_array = array();
          $content_array['category_name'] = Zend_Registry::get('Zend_Translate')->_($subCategory->category_name);
          $content_array['category_id'] = $subCategory->category_id;
          $content_array['categoryname_temp'] = $categoryName;
          $data[] = $content_array;
        }
     
        $this->view->subcats = $data;
    } 

  /*
  *Action for post answer
  */
  public function answerAction()
  { 
    //LAYOUT
    if (null === $this->_helper->ajaxContext->getCurrentContext()) {
      $this->_helper->layout->setLayout('default-simple');
    } else {
      $this->_helper->layout->disableLayout(true);
    }

    $viewer = Engine_Api::_()->user()->getViewer();
    $viewer_id = $viewer->getIdentity();

    //CREATE FORM
    $this->view->form = $form = new Siteqa_Form_Answer();
    $this->view->question_id = $question_id = $this->_getParam('question_id');
    //CHECK METHOD/DATA VALIDITY
    if( !$this->getRequest()->isPost() ) {
      return;
    }

    if( !$form->isValid($this->getRequest()->getPost()) ) {
      return;
    }

    //PROCESS
    $values = $form->getValues();
    $db = Engine_Api::_()->getDbtable('questions', 'siteqa')->getAdapter();
    $db->beginTransaction();

    try {
      $question_owner = Engine_Api::_()->getItem('question', $question_id)->getOwner();
      //Create Answer
      $tableSiteans = Engine_Api::_()->getDbtable('answers', 'siteqa');
      $siteans = $tableSiteans->createRow();

      $siteans->setFromArray($values);
      $siteans->question_id = $question_id;
      $siteans->owner_id = $viewer_id;
      $siteans->save();

      //Increment anwer count to Question table
      $queTable = Engine_Api::_()->getDbtable('questions', 'siteqa');
      $queTable->update(array(
            'answer_count' => new Zend_Db_Expr('answer_count + 1'),
        ), array(
            'question_id = ?' => $question_id,
      ));
    

    if( !empty($values['photo']) ) {
        $siteans->setPhoto($form->photo);
      }

      //TO SEND NOTIFICATION
      $siteqa_api = Engine_Api::_()->siteqa();
      $url =  Zend_Registry::get('Zend_View')->url(array('question_id' => $question_id), 'qa_entry_view', true);
      $link = '<a href="'.$url.'"> Question.</a>';
      $siteqa_api->addCustomNotifications($question_owner, $viewer, $siteans, 'answer_create', array('link' => $link));
      
      //COMMIT
      $db->commit();

        
    } catch( Exception $e ) {
      $db->rollBack();
      throw $e;
    }
    $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 800,
                'parentRefresh' => 100,
                'messages' => array('Your answer has been submitted.')
        ));
  }

    /*
     * This function is for display answer posted by user
    */
    public function answerviewAction(){
        $viewer = Engine_Api::_()->user()->getViewer();

        //Render
        $this->_helper->content
            //->setNoRender()
            ->setEnabled()
        ;
    
        // Process form
        $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('answers', 'siteqa')->getAnswersPaginator($values);
        $items_per_page = '10';
        //$items_per_page = Engine_Api::_()->getApi('settings', 'core')->question_page;
        $paginator->setItemCountPerPage($items_per_page);
        $this->view->paginator = $paginator->setCurrentPageNumber( $values['page'] );    
    }

    public function votecheckAction(){
        $viewer = Engine_Api::_()->user()->getViewer();
        
        $values = $this->_getAllParams();
        $getVoteDetail = Engine_Api::_()->getDbtable('votes', 'siteqa')->getVoteDetails($values['type'],$values['id']);
        
        $this->view->votes = $getVoteDetail['voteDetails'];
        $this->view->vote_count = $getVoteDetail['vote_count'];
    }
}
