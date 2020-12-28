<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Widget_MemberCloudController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->heading = $this->_getParam('heading', 1);
    $settings = Engine_Api::_()->getApi('settings', 'core');
    $this->view->showinfotooltip = $settings->getSetting('sesatoz.member.infotooltip', 1);
    $this->view->heading = $settings->getSetting('sesatoz.memeber.heading', '');
    $this->view->caption = $settings->getSetting('sesatoz.memeber.caption', '');
    $this->view->memberlink = $settings->getSetting('sesatoz.member.link', '1');
    $this->view->sesmemberEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sesmember');
    $this->view->height = $settings->getSetting('sesatoz.memeber.height', '200');;
    $this->view->width = $settings->getSetting('sesatoz.memeber.width', '200');;
    $sesatoz_landingpage = Zend_Registry::isRegistered('sesatoz_landingpage') ? Zend_Registry::get('sesatoz_landingpage') : null;
    if(empty($sesatoz_landingpage)) {
      return $this->setNoRender();
    }
    $table = Engine_Api::_()->getDbtable('users', 'user');
    $info = $table->select()
            ->from($table, array('COUNT(*) AS count'))
            ->where('enabled = ?', true)
            ->query()
            ->fetch();
    $this->view->member_count = $info['count'];

    $select = $table->select()
            ->where('search = ?', 1)
            ->where('enabled = ?', 1)
            //->where('photo_id != ?', 0)
            ->order('Rand()');
    $this->view->paginator = $paginator = Zend_Paginator::factory($select);

    // Set item count per page and current page number
    $paginator->setItemCountPerPage(16);
    $paginator->setCurrentPageNumber($this->_getParam('page', 1));

    // Do not render if nothing to show
    if ($paginator->getTotalItemCount() <= 0)
      return $this->setNoRender();
  }

}
