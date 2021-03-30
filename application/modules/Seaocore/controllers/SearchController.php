<?php

class Seaocore_SearchController extends Core_Controller_Action_Standard
{
    public function indexAction()
    {

        $searchApi = Engine_Api::_()->getApi('search', 'core');

        // check public settings
        $require_check = Engine_Api::_()->getApi('settings', 'core')->core_general_search;
        if (!$require_check) {
            if (!$this->_helper->requireUser()->isValid()) {
                return;
            }
        }

        // Prepare form
        $this->view->form = $form = new Core_Form_Search();

        $form->order->addMultiOptions(array(
            'like_count' => 'Most Liked',
            'view_count' => 'Most Viewed',
          ));

        //add listing types
        if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitereview')){
            $listingtypesTable = Engine_Api::_()->getDbtable('listingtypes', 'sitereview');
            $listingTypes = $listingtypesTable->fetchAll($listingtypesTable->select());
            foreach ($listingTypes as $key => $type) {
              
                $optionkey = "sitereview_listing_".$type['listingtype_id'];
                $listingoptions[$optionkey] = $type['title_plural'];
            }

            if(!empty($listingoptions))
              $form->type->addMultiOptions($listingoptions);
        }

        $form->type->addMultiOptions(array('post' => "Post"));

        // Get available types
        $availableTypes = $searchApi->getAvailableTypes();
        if (is_array($availableTypes) && count($availableTypes) > 0) {
            $options = array();
            foreach ($availableTypes as $index => $type) {
                $options[$type] = strtoupper('ITEM_TYPE_' . $type);
            }
            $form->type->addMultiOptions($options);
        } else {
            $form->removeElement('type');
        }

        // Check form validity?
        $values = array();
        if ($form->isValid($this->_getAllParams())) {
            $values = $form->getValues();
        }

        $this->view->query = $query = (string) @$values['query'];
        $this->view->type = $type = (string) @$values['type'];
        $this->view->order = $order = (string) @$values['order'];
        $this->view->page = $page = (int) $this->_getParam('page');

        // echo $type;die("hoo");
        $this->view->feedResults = false;
        if ($query) {

            $this->view->searchTable = flase;

            $typeArray = array();
            $listing_id ='';
            $typeArray = explode("_",$type);

            if(count($typeArray) == 3 && is_numeric($typeArray[2]) && $typeArray[0]."_".$typeArray[1] == 'sitereview_listing'){

                $type = "sitereview_listing";
                $listing_id = $typeArray[2];

            }

            if($type != "post"){

                // die("not post");

                if($type){
                    $table = Engine_Api::_()->getDbtable('search', 'core');
                    $datas = $table->fetchAll($searchApi->getSelect($query, $type)->order("id DESC"));
                    $ids = array(0);
                    foreach ($datas as $key => $data) {
                        $ids[] = $data['id'];
                    }

                    // echo $type; die;
                    $primaryColumnName = '';
                    if($type == 'blog'){
                        $primaryColumnName = 'blog_id';
                    } elseif($type == 'forum_post'){
                        $primaryColumnName = 'post_id';
                    } elseif($type == 'forum_topic'){
                        $primaryColumnName = 'topic_id';    
                    } elseif($type == 'group'){
                        $primaryColumnName = 'group_id';
                    } elseif($type == 'poll'){
                        $primaryColumnName = 'poll_id';
                    } elseif($type == 'siteqa_answer'){
                        $primaryColumnName = 'question_id';
                    } elseif($type == 'sitereview_listing'){
                        $primaryColumnName = 'listing_id';
                    } elseif($type == 'sitereview_post'){
                        $primaryColumnName = 'post_id';
                    } elseif($type == 'sitereview_review'){
                        $primaryColumnName = 'review_id';
                    } elseif($type == 'sitereview_topic'){
                        $primaryColumnName = 'topic_id';
                    } elseif($type == 'user'){
                        $primaryColumnName = 'user_id';
                    }

                    if($primaryColumnName ){
                        $idsSring = implode(",",$ids);
                        $typeTable = Engine_Api::_()->getItemTable($type);

                        $tableName = $typeTable->info('name');

                        $select = $typeTable->select()->where("$primaryColumnName IN ( $idsSring )");

                        if($tableName == 'engine4_sitereview_listings' && is_numeric($listing_id)){
                            $select->where("listingtype_id = ?", $listing_id);
                        }

                        if(!empty($values['order'])){

                            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
                            $column_exist = $db->query("SHOW COLUMNS FROM $tableName LIKE '".$values['order']."'")->fetch();

                            if($values['order'] == 'like_count' && !empty($column_exist)){
                                $select->order("like_count DESC");
                            } elseif($values['order'] == 'view_count' && !empty($column_exist)){
                                $select->order("view_count DESC");
                            }
                        }

                        $this->view->searchTable = false;
                    }
                    else{
                        
                        $select = $searchApi->getSelect($query, $type)->order("id DESC");
                        $this->view->searchTable = true;
                    }

                }
                else{
                    $select = $searchApi->getSelect($query, $type)->order("id DESC");
                    $this->view->searchTable = true;

                }

                $this->view->paginator = Zend_Paginator::factory($select);
                $this->view->paginator->setCurrentPageNumber($page);
            } elseif($type == "post"){
                // die("post");
                $this->view->feedResults = true;
            }

        }

        // if ($this->isAjax()) {
        //     $results = array();
        //     if (is_array($this->view->paginator) || is_object($this->view->paginator)) {
        //         foreach ($this->view->paginator as $item) {
        //             $item = $this->view->item($item->type, $item->id);
        //             $results[] = array(
        //                 'icon' => $this->view->htmlLink($item->getHref(), $this->view->itemPhoto($item, 'thumb.icon')),
        //                 'title' => $this->view->htmlLink(
        //                     $item->getHref(),
        //                     $this->view->highlightText($item->getTitle(), $this->view->query),
        //                     array('class' => 'search_title')
        //                 )
        //             );
        //         }
        //     }
        //     header('Content-Type: application/json');
        //     echo json_encode($results);
        //     exit;
        // }

        // Render the page
        $this->_helper->content
            // ->setNoRender()
            ->setEnabled();
    }

    public function validOrderAction()
    {
        $type = $this->_getParam('type');

        $typeArray = array();
        $typeArray = explode("_",$type);
        if(count($typeArray) == 3 && is_numeric($typeArray[2]) && $typeArray[0]."_".$typeArray[1] == 'sitereview_listing'){

            $type = "sitereview_listing";

        }
        

        $data = array("status" => "status");
        $data['like_count'] = "false";
        $data['view_count'] = "false";

        if($type == 'post'){
            $type = '';
            $data['like_count'] = "true";
        }

        if(!empty($type)){

            $typeTable = Engine_Api::_()->getItemTable($type);

            $tableName = $typeTable->info('name');
            $db = Zend_Db_Table_Abstract::getDefaultAdapter();
            
            $like_count = $db->query("SHOW COLUMNS FROM $tableName LIKE 'like_count'")->fetch();
            if(!empty($like_count)){
                $data['like_count'] = "true"; 
            }
            $view_count = $db->query("SHOW COLUMNS FROM $tableName LIKE 'view_count'")->fetch();
            if(!empty($view_count)){
                $data['view_count'] = "true"; 
            }
        }

        return $this->_helper->json($data);
    }
}
