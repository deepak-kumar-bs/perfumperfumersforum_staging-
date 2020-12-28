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
class Siteqa_Widget_NewQuestionController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
  	$viewer = Engine_Api::_()->user()->getViewer();

    $itemcreate = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'create');
    
    //PERMISSION CHECK ALLOWED OR NOT
    if(empty($itemcreate)){
        return $this->setNoRender();
    }
  }
}
