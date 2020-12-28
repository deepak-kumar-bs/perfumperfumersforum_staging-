<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Fields
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: FieldText.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Core
 * @package    Fields
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @author     John
 */
class Fields_View_Helper_FieldRecipe extends Fields_View_Helper_FieldAbstract
{
  public function fieldRecipe($subject, $field, $value)
  {
  	$content = array();
  	$labels = array('Name', 'Amount', 'Dilution');

  	foreach ($value as $key => $v) {
  		$data = $v->toArray();

  		if($data['index'] == 0) {
  			$content['Name'] = json_decode($data['value']);
  		}


  		if($data['index'] == 1) {
  			$content['Amount'] = json_decode($data['value']);
  		}


  		if($data['index'] == 2) {
  			$content['Dilution'] = json_decode($data['value']);
  		}
 
  	}

  	$lastContents = '<table class = "'.'recipe_data'.'"><tr class = "'.'recipe_elements'.'"><th>Dilution</th><th>Amount</th><th>Material</th></tr>';
  	foreach ($content['Name'] as $key => $name) {

  		$amount = 0;
  		if(!empty($content['Amount'][$key])) {
  			$amount = $content['Amount'][$key];
  		}

  		$dilution = 0;
  		if(!empty($content['Dilution'][$key])) {
  			$dilution = $content['Dilution'][$key];
  		}

      $listing_href = '';
      if(!empty($content['Name'][$key])) {
        $sitereview = Engine_Api::_()->getItem('sitereview_listing', $content['Name'][$key]);
        $listing_href = $sitereview->getHref();
      }
 
      $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

      if($view) {
        $listing_link = $view->htmlLink($listing_href, $this->view->translate($sitereview->title), array('target' => '_blank'));
      }
      
  		$lastContents .= '<tr class = "'.'recipe_elements'.'"><td>'.$dilution.'%</td><td>'.$amount.'</td><td>'.$listing_link.'</td></tr>';
  	}
  	$lastContents .= '</table>';
 
    return $this->encloseInLink($subject, $field, $lastContents, $lastContents);

  }
}