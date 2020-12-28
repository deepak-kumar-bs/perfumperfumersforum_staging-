<?php

class Recipefield_IndexController extends Core_Controller_Action_Standard
{
  public function indexAction()
  {
    $this->view->someVar = 'someVal';
  }

  public function addOptionAction()
  {
    $params = $this->_getAllParams();

    $option_table = Engine_Api::_()->fields()->getTable('sitereview_listing', 'options');

    $option = $option_table->select()
    				->from($option_table->info('name'))
    				->where('field_id = ?', $params['field_id'])
    				->query()
    				->fetchAll();

    if(empty($option)) {
    	$row = $option_table->createRow();

    	$row->field_id = $params['field_id'];
    	$row->label = $params['listingtype_id'];
		$row->save();
    } else {
    	$option_table->update(array("label" => $params['listingtype_id']), array("field_id =?" => $params['field_id']));
    }

	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
  }

  public function listingSuggestAction()
  {
    $params = $this->_getAllParams();

    $option_table = Engine_Api::_()->fields()->getTable('sitereview_listing', 'options');
    $option = $option_table->select()
            ->from($option_table->info('name'))
            ->where('field_id = ?', $params['field_id'])
            ->query()
            ->fetchAll();

    $Listings = Engine_Api::_()->getDbtable('listings', 'sitereview')->getListings(array('listingtype_id' => $option[0]['label'], 'text' => $params['text']));

    $data = array();
    foreach ($Listings as $value) {
   		$data[] = array('id' => $value->listing_id, 'label' => $value->title);
    }

    return $this->_helper->json($data);
 
	$this->_helper->viewRenderer->setNoRender(true);
	$this->_helper->layout->disableLayout();
  }


}
