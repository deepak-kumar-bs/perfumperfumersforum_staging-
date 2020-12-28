<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: IndexController.php 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitereview_ProfileController extends Seaocore_Controller_Action_Standard {

    //ACTION FOR Email Me FOR THIS listing
    public function emailMeAction() {

      //DEFAULT LAYOUT
      $this->_helper->layout->setLayout('default-simple');

      //GET VIEWER DETAIL
      $viewer = Engine_Api::_()->user()->getViewer();
      $viewr_id = $viewer->getIdentity();

      //GET listing ID AND listing OBJECT
      $this->view->listing_id  = $listing_id = $this->_getParam('listing_id', $this->_getParam('id', null));
      $sitereview = Engine_Api::_()->getItem('sitereview_listing', $listing_id);
      if (empty($sitereview))
        return $this->_forwardCustom('notfound', 'error', 'core'); 

      //FORM GENERATION
      $this->view->form = $form = new Sitereview_Form_EmailMe();

      if (!empty($viewr_id)) {
        $value['sender_email'] = $viewer->email;
        $value['sender_name'] = $viewer->displayname;
        $form->populate($value);
      }

      if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {

        $values = $form->getValues();
        $otherInfo = Engine_Api::_()->getDbTable('otherinfo', 'sitereview')->getOtherinfo($listing_id);
        //EDPLODES EMAIL IDS
        $reciver_ids = $otherInfo->email; //explode(',', $values['sitereview_reciver_emails']);
        $values['sitereview_sender_email'] = $otherInfo->email;
        if (!empty($values['sitereview_send_me'])) {
          $reciver_ids = $values['sitereview_sender_email'];
        }
        $sender_email = $values['sitereview_sender_email'];

        //CHECK VALID EMAIL ID FORMITE
        $validator = new Zend_Validate_EmailAddress();
        $validator->getHostnameValidator()->setValidateTld(false);

        if (!$validator->isValid($sender_email)) {
          $form->addError(Zend_Registry::get('Zend_Translate')->_('Invalid sender email address value'));
          return;
        }
 
        $sender = $values['sitereview_sender_name'];
        $message = $values['sitereview_message'];
        $heading = ucfirst($sitereview->getTitle());
        $link = (_ENGINE_SSL ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
        Engine_Api::_()->getApi('mail', 'core')->sendSystem($reciver_ids, 'SITEREVIEW_EMAILME_EMAIL', array(
            'host' => $_SERVER['HTTP_HOST'],
            'sender_name' => $sender,
            'listing_title' => $heading,
            'listing_media_type' => ucwords($sitereview->getMediaType()),
            'message' => '<div>' . $message . '</div>',
            'object_link' => $link . $sitereview->getHref(),
            'sender_email' => $sender_email,
            'queue' => true
        ));

        $this->_forwardCustom('success', 'utility', 'core', array(
            'smoothboxClose' => true,
            'parentRefresh' => false,
            'format' => 'smoothbox',
            'messages' => array(Zend_Registry::get('Zend_Translate')->_('Your message to '.$sitereview->getMediaType().' owner has been sent successfully.'))
        ));
      }
    }

}