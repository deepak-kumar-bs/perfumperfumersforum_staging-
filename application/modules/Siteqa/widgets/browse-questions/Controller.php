<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     John Boehr <john@socialengine.com>
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Widget_BrowseQuestionsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
      $request = Zend_Controller_Front::getInstance()->getRequest();
      $values = $request->getParams();
      
      //Get all widget settings
      $this->view->limit = $limit = $this->_getparam('limit', 10);
      // Ajax parameter is for ajax request
      $this->view->is_ajax = $is_ajax = $this->_getParam('isajax',0);
      // Process form
      $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('questions', 'siteqa')->getAllQuestionsPaginator($values);
      
      $paginator->setItemCountPerPage($limit);
      $this->view->paginator = $paginator->setCurrentPageNumber($values['page']);   
  }
}
