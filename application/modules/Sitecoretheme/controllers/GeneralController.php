<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: GeneralController.php 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitecoretheme_GeneralController extends Core_Controller_Action_Standard
{
  public function videoAction()
  {
    $this->view->videoEmbedCode = Engine_Api::_()->getApi('settings', 'core')->getSetting('sitecoretheme.landing.highlights.videoEmbed', ''); 
  }
  public function videoUrlAction()
  {
    $this->_helper->layout->disableLayout(true);
    $this->view->url = $this->_getParam('url', null);
  }

  //ACTION FOR GET THE SEARCH RESULT BASED ON CORE SEARCH TABLE
  public function getSearchContentAction() {

	//GET SEARCHABLE TEXT FROM GLOBAL SEARCH BOX
  	$text = $this->_getParam('text', null);
  	$pos = strpos($text, '#');
  	if (!empty($text)) {
  		$values = array();
  		$values['text'] = $text; 
  		$values['pagination'] = '';
  		$values['resource_type'] = '';
  		$values['limit'] = $this->_getParam('limit');

  		$items = $this->getCoreSearchData($values); 
  	} 
  		$data = array();
  		$dataSearchable = array();
  		$i = 0;


  		if (!empty($text)) {
  			foreach ($items as $item) {

            $type = $item->type;
            if( !Engine_Api::_()->hasItemType($type) ) {
              continue;
            }
            $item = $this->view->item($type, $item->id);
            if( empty($item) ) {
              continue;
            }
            if ($item->getPhotoUrl() != '') {
                $content_photo = $this->view->itemPhoto($item, 'thumb.icon');
            }	else {
                $content_photo = "<img src='" . $this->view->layout()->staticBaseUrl . "application/modules/Sitecoretheme/externals/images/nophoto_icon.png' alt='' />";
            }

  					$i++;

  					$resourceTitle = $item->getShortType();
  					if ($type == 'user') {
  						$resourceTitle = 'member';
  					}
  					$iType = $this->view->translate(ucfirst($resourceTitle));
  					if (is_array($iType) && isset($iType[0])) {
  						$iType = $iType[0];
  					}
  					$dataSearchable[] = array(
  						'label' => $item->getTitle(),
  						'type' => $iType,
  						'photo' => $content_photo,
  						'item_url' => $item->getHref(),
  					//	'total_count' => $count,
  						'count' => $i
  					);
  			}
          $realCount = $i; 
  				$data = $dataSearchable;
  				if( empty($dataSearchable) ) {
            $data[] = array(
              'label' => $this->view->translate('No result found for "%s".', $text),
              'type' => 'no_resuld_found',
              'item_url' => 'no_resuld_found',
              'search_text' => $text,
            );
          } else {
            $count = $realCount;
            $data[]['id'] = 'stopevent';
            $data[]['label'] = $this->_getParam('text');
            $data[$count]['item_url'] = 'seeMoreLink';
          }
  			//	$data[$count]['total_count'] = $count;
  			} 
  		 

  		return $this->_helper->json($data);
  	}

  	public function getCoreSearchData($params = array()) {

  	    $SearchTable = Engine_Api::_()->getDbtable('search', 'core');
  	    $searchTableName = $SearchTable->info('name');
  	    $items = array();
  	    $text = trim($params['text']);
  	    if (!empty($text)) {
  	        $select = $SearchTable->select()
  	                ->setIntegrityCheck(false)
  	                ->from($SearchTable->info('name'), array('type', 'id', 'description', 'keywords'));
  	        $select->where("(`title` LIKE  ? OR `description` LIKE  ? OR `keywords` LIKE  ? OR `hidden` LIKE  ?)","%$text%");

            $select = $select->limit($params['limit']);
            return $items = $SearchTable->fetchAll($select);
  	    } else {
  	        return $items;
  	    }
  	}
    
  public function previewBlockAction()
  {
    $this->view->block_id = $blockId = $this->_getParam('id');
    $block = Engine_Api::_()->getDbtable('blocks', 'sitecoretheme')->getBlock($blockId);
    if( !$block ) {
      throw new Core_Model_Exception('missing block');
    }
    $this->_helper->layout->setLayout('default-simple');
    $this->view->block = $block;
  }
}