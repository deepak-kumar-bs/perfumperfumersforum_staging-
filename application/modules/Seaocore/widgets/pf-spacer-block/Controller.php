<?php
/**
 * SocialEngine - Search Widget Controller
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2012 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     Matthew
 */

class Seaocore_Widget_PfSpacerBlockController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {

  	$this->view->layoutWidth = $this->_getParam('layoutSpace', 0);
    if (empty($this->view->layoutWidth)) {
      return $this->setNoRender();
    }

    if($this->view->layoutWidth >= 1){
    	$this->view->layoutWidth = $this->view->layoutWidth;
    }
  }
}
?>