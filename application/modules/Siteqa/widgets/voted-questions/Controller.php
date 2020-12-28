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
class Siteqa_Widget_VotedQuestionsController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
      //Get all params using subject
      $limit = $this->_getParam('limit',5);
      $this->view->truncateLimit = $this->_getParam('truncateLimit',20);
       // Process form
      $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('questions', 'siteqa')->getAllVotedQuestion($limit);
  }
}
