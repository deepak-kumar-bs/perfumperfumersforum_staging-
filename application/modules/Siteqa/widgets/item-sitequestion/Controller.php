<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Controller.php 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Siteqa_Widget_ItemSitequestionController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

	  $this->view->dayitem = Engine_Api::_()->getDbtable('questions', 'siteqa')->getQuestionOfDay();

    //DONT RENDER IF SITEQA COUNT ZERO
    if (!(count($this->view->dayitem) > 0)) {
      return $this->setNoRender();
    } else {
        //GET SETTINGS
        $this->view->siteqa = Engine_Api::_()->getItem('siteqa_question', $this->view->dayitem->question_id);
        $contacts = $this->_getParam('contacts', $pre_field);
        // IF EMPTY WIDGET NOT RENDER
        if (empty($contacts)) {
            $this->setNoRender();
        }
    }
  }
}
?>