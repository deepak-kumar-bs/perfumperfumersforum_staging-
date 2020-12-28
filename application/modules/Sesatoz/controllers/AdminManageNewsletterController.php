<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: AdminManageNewsletterController.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_AdminManageNewsletterController extends Core_Controller_Action_Admin {

    public function sendNewsletterAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_managenewsemail');

        $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main_managenewsemail', array(), 'sesatoz_admin_main_managesendnews');

        $this->view->form = $form = new Sesatoz_Form_Admin_Mail();

        // let the level_ids be specified in GET string
        $level_ids = $this->_getParam('level_id', false);
        if (is_array($level_ids)) {
            $form->target->setValue($level_ids);
        }

        if( !$this->getRequest()->isPost() ) {
            return;
        }

        if( !$form->isValid($this->getRequest()->getPost()) ) {
            return;
        }

        $values = $form->getValues();


        $table = Engine_Api::_()->getItemTable('sesatoz_newsletteremail');
        $select = new Zend_Db_Select($table->getAdapter());
        $select
            ->from($table->info('name'), 'email');
            //->where('enabled = ?', true); // Do not email disabled members

//         $level_ids = $this->_getParam('target');
//         if (is_array($level_ids) && !empty($level_ids)) {
//             $select->where('level_id IN (?)', $level_ids);
//         }

        $emails = array();
        foreach( $select->query()->fetchAll(Zend_Db::FETCH_COLUMN, 0) as $email ) {
            $emails[] = $email;
        }

        // temporarily enable queueing if requested
        $temporary_queueing = Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing;
        if (isset($values['queueing']) && $values['queueing']) {
            Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = 1;
        }

        $mailApi = Engine_Api::_()->getApi('mail', 'core');

        $mail = $mailApi->create();
        $mail
            ->setFrom($values['from_address'], $values['from_name'])
            ->setSubject($values['subject'])
            ->setBodyHtml(nl2br($values['body']));
        $mail->setBodyText(strip_tags($values['body']));
//         if( !empty($values['body_text']) ) {
//             $mail->setBodyText($values['body_text']);
//         } else {
//             $mail->setBodyText(strip_tags($values['body']));
//         }

        foreach( $emails as $email ) {
            $mail->addTo($email);
        }

        $mailApi->send($mail);

        $mailComplete = $mailApi->create();
        $mailComplete
            ->addTo(Engine_Api::_()->user()->getViewer()->email)
            ->setFrom($values['from_address'], $values['from_name'])
            ->setSubject('Mailing Complete: '.$values['subject'])
            ->setBodyHtml('Your email blast to your members has completed.  Please note that, while the emails have been sent to the recipients\' mail server, there may be a delay in them actually receiving the email due to spam filtering systems, incoming mail throttling features, and other systems beyond SocialEngine\'s control.');
        $mailApi->send($mailComplete);

        // emails have been queued (or sent); re-set queueing value to original if changed
        if (isset($values['queueing']) && $values['queueing']) {
            Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = $temporary_queueing;
        }

        $this->view->form = null;
        $this->view->status = true;
    }

    public function indexAction() {

        $this->view->navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main', array(), 'sesatoz_admin_main_managenewsemail');

        $this->view->subnavigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_admin_main_managenewsemail', array(), 'sesatoz_admin_main_managenewsemails');

        $this->view->formFilter = $formFilter = new Sesatoz_Form_Admin_Filter();
        $page = $this->_getParam('page', 1);

        $newletrtable = Engine_Api::_()->getDbTable('newsletteremails', 'sesatoz');

        $select = $newletrtable->select();

        // Process form
        $values = array();
        if ($formFilter->isValid($this->_getAllParams()))
        $values = $formFilter->getValues();

        foreach ($values as $key => $value) {
        if (null === $value) {
            unset($values[$key]);
        }
        }

        $values = array_merge(array(
            'order' => 'newsletteremail_id',
            'order_direction' => 'DESC',
                ), $values);
        $this->view->assign($values);

        //Set up select info
        $select->order((!empty($values['order']) ? $values['order'] : 'newsletteremail_id' ) . ' ' . (!empty($values['order_direction']) ? $values['order_direction'] : 'DESC' ));


        if (!empty($values['email']))
        $select->where('email LIKE ?', '%' . $values['email'] . '%');

        if (!empty($values['level_id']))
        $select->where('level_id = ?', $values['level_id']);


        // Filter out junk
        $valuesCopy = array_filter($values);

        // Make paginator
        $this->view->paginator = $paginator = Zend_Paginator::factory($select);
        $this->view->paginator = $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(50);
        $this->view->formValues = $valuesCopy;
        $this->view->hideEmails = _ENGINE_ADMIN_NEUTER;
    }

    public function sendnewsletteremailAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $id = $this->_getParam('newsletteremail_id', null);

        $db = Engine_Db_Table::getDefaultAdapter();

        $newsletteremail = Engine_Api::_()->getItem('sesatoz_newsletteremail', $id);

        $this->view->form = $form = new Sesatoz_Form_Admin_SendEmail();

        if ($this->getRequest()->isPost()) {

            $values = $_POST; //$form->getValues();
            $values['email'] = $email = $newsletteremail->email;

            // temporarily enable queueing if requested
            $temporary_queueing = Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing;
            if (isset($values['queueing']) && $values['queueing']) {
                Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = 1;
            }

            $mailApi = Engine_Api::_()->getApi('mail', 'core');
            $mail = $mailApi->create();
            $mail
                //->setFrom($values['from_address'], $values['from_name'])
                ->setSubject($values['subject'])
                ->setBodyHtml(nl2br($values['body']));

            $mail->setBodyText($values['body']);
            $mail->addTo($email);
            $mailApi->send($mail);

            $mailComplete = $mailApi->create();
            $mailComplete
                ->addTo(Engine_Api::_()->user()->getViewer()->email)
                //->setFrom($values['from_address'], $values['from_name'])
                ->setSubject('Mailing Complete: '.$values['subject'])
                ->setBodyHtml('Your email blast to your members has completed.  Please note that, while the emails have been
                sent to the recipients\' mail server, there may be a delay in them actually receiving the email due to
                spam filtering systems, incoming mail throttling features, and other systems beyond SocialEngine\'s control.');

            $mailApi->send($mailComplete);

            // emails have been queued (or sent); re-set queueing value to original if changed
            if (isset($values['queueing']) && $values['queueing']) {
                Engine_Api::_()->getApi('settings', 'core')->core_mail_queueing = $temporary_queueing;
            }

            $this->view->form = null;
            $this->view->status = true;

            $this->_forward('success', 'utility', 'core', array(
                'smoothboxClose' => 10,
                'parentRefresh' => 10,
                'messages' => array('')
            ));
        }
    }

    public function deleteAction() {

        $this->_helper->layout->setLayout('admin-simple');
        $this->view->id = $id = $this->_getParam('id', 0);

        if ($this->getRequest()->isPost()) {
        $db = Engine_Db_Table::getDefaultAdapter();
        $db->beginTransaction();
        try {
            $item = Engine_Api::_()->getItem('sesatoz_newsletteremail', $id);
            $item->delete();
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }

        $this->_forward('success', 'utility', 'core', array(
            'smoothboxClose' => 10,
            'parentRefresh' => 10,
            'messages' => array('')
        ));
        }
        // Output
        $this->renderScript('admin-manage-newsletter/delete.tpl');
    }
}
