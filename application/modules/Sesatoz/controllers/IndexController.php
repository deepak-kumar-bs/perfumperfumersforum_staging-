<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: IndexController.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_IndexController extends Core_Controller_Action_Standard {

    public function newsletterAction() {

        $email = $this->_getParam('email', null);
        $table = Engine_Api::_()->getDbTable('newsletteremails', 'sesatoz');

        $isExist = Engine_Api::_()->getDbTable('newsletteremails', 'sesatoz')->isExist($email);
        if(empty($isExist)) {
            $getUserId = Engine_Api::_()->sesatoz()->getUserId($email);
            if(!empty($getUserId)) {
                $user = Engine_Api::_()->getItem('user', $getUserId);
                $values = array('user_id' => $getUserId, 'level_id' => $user->level_id, 'email' => $email);
            } else {
                $values = array('user_id' => 0, 'level_id' => 5, 'email' => $email);
            }
            $db = Engine_Db_Table::getDefaultAdapter();
            $db->beginTransaction();
            try {
                $item = $table->createRow();
                $item->setFromArray($values);
                $item->save();
                $db->commit();
                $user = Engine_Api::_()->getItem('user', 1);
                Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'sesatoz_mobile_subscribe', array('sender_title' => $user->getTitle(), 'host' => $_SERVER['HTTP_HOST']));

                $this->view->newsletteremail_id = $item->newsletteremail_id;
            } catch(Exception $e) {
                $db->rollBack();
                throw $e;
            }
        } else {
            $this->view->newsletteremail_id = 0;
        }
    }

    public function sendappemailAction() {

        $email = $this->_getParam('sesatoz_app_email', null);
        if(empty($email))
            return;

        $androidlink = $this->_getParam('androidlink', null);
        $ioslink = $this->_getParam('ioslink', null);

        $applinkcontent = '';
        if($androidlink)
            $applinkcontent .= 'Android: ' . $androidlink;
        if($ioslink)
            $applinkcontent .= '<br /> iOS: ' . $ioslink;


        $user = Engine_Api::_()->getItem('user', 1);
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            Engine_Api::_()->getApi('mail', 'core')->sendSystem($email, 'sesatoz_mobile_applinnk', array('sender_title' => $user->getTitle(), 'host' => $_SERVER['HTTP_HOST'], 'applinkcontent' => $applinkcontent));

            $this->view->mobile_app_linksent = 1;
        } catch(Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }

  public function inboxAction() {

    $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->paginator = $paginator = Engine_Api::_()->getItemTable('messages_conversation')->getInboxPaginator($viewer);
    $paginator->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesatoz')->setUnreadMessage($viewer);
  }

  public function searchAction() {

    $text = $this->_getParam('text', null);
    $table = Engine_Api::_()->getDbtable('search', 'core');
    $select = $table->select()->where('title LIKE ? OR description LIKE ? OR keywords LIKE ? OR hidden LIKE ?', '%' . $text . '%')->order('id DESC');
    $select->limit('10');

    $results = Zend_Paginator::factory($select);
    foreach ($results as $result) {
      $itemType = $result->type;
      if (Engine_Api::_()->hasItemType($itemType)) {
        if ($itemType == 'sesblog')
          continue;
        $item = Engine_Api::_()->getItem($itemType, $result->id);
        $item_type = ucfirst($item->getShortType());
        $photo_icon_photo = $this->view->itemPhoto($item, 'thumb.icon');
        $data[] = array(
            'id' => $result->id,
            'label' => strip_tags($item->getTitle()),
            'photo' => $photo_icon_photo,
            'url' => $item->getHref(),
            'resource_type' => $item_type,
        );
      }
    }
    return $this->_helper->json($data);
  }

  public function friendshipRequestsAction() {

    $this->view->viewer = $viewer = Engine_Api::_()->user()->getViewer();
    $this->view->friendRequests = $newFriendRequests = Engine_Api::_()->getDbtable('notifications', 'sesatoz')->getFriendrequestPaginator($viewer);
    $newFriendRequests->setCurrentPageNumber($this->_getParam('page'));
    Engine_Api::_()->getApi('message', 'sesatoz')->setUnreadFriendRequest($viewer);

    //People You May Know work
    $userIDS = $viewer->membership()->getMembershipsOfIds();
    $userMembershipTable = Engine_Api::_()->getDbtable('membership', 'user');
    $userMembershipTableName = $userMembershipTable->info('name');
    $select_membership = $userMembershipTable->select()
            ->where('resource_id = ?', $viewer->getIdentity());
    $member_results = $userMembershipTable->fetchAll($select_membership);
    foreach($member_results as $member_result) {
      $membershipIDS[] = $member_result->user_id;
    }
    if($membershipIDS) {
    $userTable = Engine_Api::_()->getDbtable('users', 'user');
    $userTableName = $userTable->info('name');
    $select = $userTable->select()
            ->where('user_id <> ?', $viewer->getIdentity())
            ->where('user_id NOT IN (?)', $membershipIDS)
            ->order('user_id DESC');
    $this->view->peopleyoumayknow = $peopleyoumayknow = Zend_Paginator::factory($select);
    $peopleyoumayknow->setCurrentPageNumber($this->_getParam('page'));
    } else {
      $this->view->peopleyoumayknow = 0;
    }
    //People You may know work

  }

  public function newUpdatesAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->notificationCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer);
  }

  public function newFriendRequestsAction() {

    $viewer = Engine_Api::_()->user()->getViewer();

    $this->view->requestCount = Engine_Api::_()->getDbtable('notifications', 'sesbasic')->hasNotifications($viewer, 'friend');
  }

  public function newMessagesAction() {
    $this->view->messageCount = Engine_Api::_()->getApi('message', 'sesatoz')->getMessagesUnreadCount(Engine_Api::_()->user()->getViewer());
  }

  public function markallmessageAction() {

    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();
    Engine_Api::_()->getDbtable('recipients', 'messages')->update(array('atoz_read' => 1,  'inbox_read' => 1), array('`user_id` = ?' => $viewer_id));

  }

  public function deleteMessageAction() {

    $message_id = $this->getRequest()->getParam('id');
    $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

    $db = Engine_Api::_()->getDbtable('messages', 'messages')->getAdapter();
    $db->beginTransaction();
    try {
      $recipients = Engine_Api::_()->getItem('messages_conversation', $message_id)->getRecipientsInfo();
      foreach ($recipients as $r) {
        if ($viewer_id == $r->user_id) {
          $this->view->deleted_conversation_ids[] = $r->conversation_id;
          $r->inbox_deleted = true;
          $r->outbox_deleted = true;
          $r->save();
        }
      }

      $db->commit();
    } catch (Exception $e) {
      $db->rollback();
      throw $e;
    }
  }
}
