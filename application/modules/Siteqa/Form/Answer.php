<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Question.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Siteqa_Form_Answer extends Engine_Form {

    public function init() {
        $this->setTitle('Post an Answer');
        $this->setAttrib('class', 'global_form global_form_popup');
        $this->setAttrib('id', 'core_form_contact');
        $viewer_id = Engine_Api::_()->user()->getViewer()->getIdentity();

        $this->addElement('Hidden', 'user_id', array(
            'order' => 10001,
            'value' => $viewer_id
        ));

        $this->addElement('Textarea', 'body', array(
            'label' => 'Answer',
            'allowEmpty' => false,
            'required' => true,
            'filters' => array(
                'StripTags',
                new Engine_Filter_Censor(),
        )));

        $this->addElement('File', 'photo', array(
            'label' => 'Choose Photo',
        ));

        $this->addElement('Button', 'submit', array(
            'label' => 'Post',
            'type' => 'submit',
            'ignore' => true,
            'decorators' => array('ViewHelper')
        ));

        $this->addElement('Cancel', 'cancel', array(
            'label' => 'cancel',
            'link' => true,
            'prependText' => ' or ',
            'href' => '',
            'onClick' => 'javascript:parent.Smoothbox.close();',
            'decorators' => array(
                'ViewHelper'
            )
        ));

        $this->addDisplayGroup(array('submit', 'cancel'), 'buttons', array(
            'decorators' => array(
                'FormElements',
                'DivDivDivWrapper',
            ),
        ));
    }

}
