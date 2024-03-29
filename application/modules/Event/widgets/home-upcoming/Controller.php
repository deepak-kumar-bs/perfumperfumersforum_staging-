<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Controller.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Extensions
 * @package    Event
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Event_Widget_HomeUpcomingController extends Engine_Content_Widget_Abstract
{
  public function indexAction()
  {
    // Don't render this if not logged in
    $viewer = Engine_Api::_()->user()->getViewer();
    $eventTable = Engine_Api::_()->getItemTable('event');
    $eventTableName = $eventTable->info('name');
    $type = $this->_getParam('type');
    $viewerEvents = false;

    // Show nothing
    if( $type == '2' && !$viewer->getIdentity() ) {
      return $this->setNoRender();
    }

    // Show member upcoming events
    else if( $type == '2' || ($type == '0' && $viewer->getIdentity()) ) {
      $eventMembership = Engine_Api::_()->getDbtable('membership', 'event');
      $select = $eventMembership->getMembershipsOfSelect($viewer);
      $viewerEvents = true;
    }

    // Show all upcoming events
    else {
      $params = array('search' => true);
      $select = $eventTable->getItemsSelect($params);
    }

    $select
      ->where("`{$eventTableName}`.`endtime` > FROM_UNIXTIME(?)", time())
      //->where("`{$eventTableName}`.`starttime` < FROM_UNIXTIME(?)", time() + (86400 * 14))
      ->order("starttime ASC");

    if( !$viewerEvents ) {
      $authorisedSelect = $eventTable->getAuthorisedSelect($select);
    }

    // Make paginator
    $this->view->paginator = $paginator = Zend_Paginator::factory($authorisedSelect);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    $paginator->setItemCountPerPage($this->_getParam('itemCountPerPage', 10));

    // Do not render if nothing to show and not viewer
    if( $paginator->getTotalItemCount() <= 0 ) {
      return $this->setNoRender();
    }

    // Check to make sure we have a title?
    if( '' == $this->getElement()->getTitle() ) {
      $this->getElement()->setTitle('Upcoming Events');
    }
  }
}