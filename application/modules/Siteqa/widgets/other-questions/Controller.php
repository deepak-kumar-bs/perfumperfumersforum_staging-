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
class Siteqa_Widget_OtherQuestionsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
      $hasSubject = Engine_Api::_()->core()->hasSubject('siteqa_question'); 
      if(!$hasSubject){
         $this->_helper->content
            ->setNoRender();
      }
      //Get all params using subject
      $values = Engine_Api::_()->core()->getSubject('siteqa_question'); 
      $limit = $this->_getParam('limit',5);
      $this->view->truncateLimit = $this->_getParam('truncateLimit',20);
       // Process form
      $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('questions', 'siteqa')->getAllOtherQuestion($values, $limit);
      //DONT RENDER IF OTHER QUESTIONS COUNT ZERO
      if (!(count($this->view->paginator) > 0)) {
        return $this->setNoRender();
      }
  }
}
