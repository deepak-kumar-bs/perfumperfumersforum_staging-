<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: EmailMe.php 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitereview_Form_EmailMe extends Engine_Form {

    public $_error = array();

    public function init() {

        $listing_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('id', null);
        $sitereview = Engine_Api::_()->getItem('sitereview_listing', $listing_id); 
        $listingtype_id = $sitereview->listingtype_id;

        $this->setTitle('Email Me')
                ->setDescription('Please fill the form given below to contact.')
                ->setAction(Zend_Controller_Front::getInstance()->getRouter()->assemble(array()))
                ->setAttrib('name', 'sitereviews_create');
        $this->setAttrib('class', 'global_form seaocore_form_comment');
        $viewr_name = "";
        $viewr_email = "";
        $viewer = Engine_Api::_()->user()->getViewer();
        if ($viewer->getIdentity() > 0) {
            $viewr_name = $viewer->getTitle();
            $viewr_email = $viewer->email;
        }
        // TITLE
        $this->addElement('Text', 'sitereview_sender_name', array(
            'label' => 'Your Name',
            'allowEmpty' => false,
            'required' => true,
            'value' => $viewr_name,
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_StringLength(array('max' => '63')),
        )));

        //SENDER EMAIL
        $this->addElement('Text', 'sitereview_sender_email', array(
            'label' => 'Your Email',
            'allowEmpty' => false,
            'required' => true,
            'value' => $viewr_email,
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
                new Engine_Filter_StringLength(array('max' => '63')),
        ))); 

        $text_value = Zend_Registry::get('Zend_Translate')->_('Thought you would be interested in this.'); 
        $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;
        $photo = $view->itemPhoto($sitereview, 'thumb.icon', "", array("style" => "float: left;height: 35px;margin-right: 5px;width: 35px;")); 
        $title = $photo . "<a href='" . $view->url(array('listing_id' => $listing_id, 'slug' => $sitereview->getSlug()), "sitereview_entry_view_listtype_$listingtype_id", true) . "'  target='_blank'>" . ucfirst($sitereview->getTitle()) . "</a>";
        $this->addElement('Dummy', 'sitereview_reciver_emails', array(
            'label' => 'To',
            'description' => $title,
        ));
        $this->sitereview_reciver_emails->getDecorator('Description')->setOptions(array('placement', 'APPEND', 'escape' => false));

        // MESSAGE
        $this->addElement('textarea', 'sitereview_message', array(
            'label' => 'Message',
            'required' => true,
            'allowEmpty' => false,
            'attribs' => array('rows' => 24, 'cols' => 150, 'style' => 'width:230px; max-width:400px;height:120px;'),
            'value' => $text_value,
            'description' => 'You can send a personal note in the mail.',
            'filters' => array(
                'StripTags',
                new Engine_Filter_HtmlSpecialChars(),
                new Engine_Filter_EnableLinks(),
                new Engine_Filter_Censor(),
            ),
        ));
        $this->sitereview_message->getDecorator("Description")->setOption("placement", "append");
        // SEND COPY TO ME
        $this->addElement('Checkbox', 'sitereview_send_me', array(
            'label' => "Send a copy to my email address.",
        )); 

        // Element: SEND
        $this->addElement('Button', 'sitereview_send', array(
            'label' => 'Send',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array(
                'ViewHelper',
            ),
        ));
        // Element: cancel
        $this->addElement('Cancel', 'sitereview_cancel', array(
            'label' => 'cancel',
            'link' => true,
            'prependText' => ' or ',
            // 'href' => 'history(-2)'
            //'onclick' => 'history.go(-1); return false;',
            'onclick' => 'javascript:parent.Smoothbox.close()',
            'decorators' => array(
                'ViewHelper',
            ),
        ));

        // DisplayGroup: buttons
        $this->addDisplayGroup(array(
            'sitereview_send',
            'sitereview_cancel',
                ), 'sitereview_buttons', array(
            'decorators' => array(
                'FormElements',
                'DivDivDivWrapper'
            ),
        ));
    }

}

?>