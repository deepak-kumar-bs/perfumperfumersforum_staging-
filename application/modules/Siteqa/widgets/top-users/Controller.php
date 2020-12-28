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
class Siteqa_Widget_TopUsersController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  { 
      //Get all params using subject
      $limit = $this->_getParam('limit',5);
       // Process form
      $this->view->paginator = $paginator = Engine_Api::_()->getDbtable('answers', 'siteqa')->getTopUsers($limit);

      //DONT RENDER IF TOP USERS COUNT ZERO
      if (!(count($this->view->paginator) > 0)) {
        return $this->setNoRender();
      }
  }
}
