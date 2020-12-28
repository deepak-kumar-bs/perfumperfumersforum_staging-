<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Create.php 10168 2014-04-17 16:29:36Z andres $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Form_Create extends Engine_Form
{
    public $_error = array();

    public function init()
    {
        $viewer = Engine_Api::_()->user()->getViewer();
        $level_id = $viewer->level_id;

        $settings = Engine_Api::_()->getApi('settings', 'core');

        $this->setTitle('Create New Question')
            ->setDescription('Create your new Question below.')
            ->setAttrib('class', 'global_form create_qa')
            ->setAttrib('name', 'questions_create');
        $user = Engine_Api::_()->user()->getViewer();
        
        $this->addElement('Text', 'title', array(
            'label' => 'Title',
            'allowEmpty' => false,
            'required' => true,
            'filters' => array(
                new Engine_Filter_Censor(),
                'StripTags'
            ),
            'autofocus' => 'autofocus',
        ));

        
        $categories = Engine_Api::_()->getDbTable('categories', 'siteqa')->getCategories(null);
        if (count($categories) != 0) {

            $this->addElement('Select', 'category_id_1', array(
                    'RegisterInArrayValidator' => false,
                    'allowEmpty' => true,
                    'required' => false,
                    'decorators' => array(array('ViewScript', array(
                                            'viewScript' => 'application/modules/Siteqa/views/scripts/_formCategory.tpl',
                                            'class' => 'form element')))
            ));
        }

        if($settings->getSetting('siteqa.tag', 1)) {
            $this->addElement('Text', 'tags',array(
                'label'=>'Tags (Keywords)',
                'autocomplete' => 'off',
                'description' => 'Separate tags with commas.',
                'filters' => array(
                    new Engine_Filter_Censor(),
                ),
            ));
            $this->tags->getDecorator("Description")->setOption("placement", "append");
        }

        $this->addElement('File', 'photo', array(
            'label' => 'Upload Photo',
        ));
        $this->photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');

        $this->addElement('TinyMce', 'body', array(
            'label' => 'Description',
            'disableLoadDefaultDecorators' => true,
            'required' => true,
            'allowEmpty' => false,
            'decorators' => array(
            'ViewHelper',
            'Label',
            ),
            'filters' => array(
                new Engine_Filter_Censor(),
            ),
        ));

        $availableLabels = array(
            'everyone'            => 'Everyone',
            'registered'          => 'All Registered Members',
            'owner_network'       => 'Friends and Networks',
            'owner_member_member' => 'Friends of Friends',
            'owner_member'        => 'Friends Only',
            'owner'               => 'Just Me'
        );

        $this->addElement('Select', 'comment_privacy', array(
            'label' => 'Comment Privacy',
            'description' => 'Who can post comments on this question?',
            'multiOptions' => $availableLabels,
        ));

        // Element: submit
        $this->addElement('Button', 'submit', array(
            'label' => 'Create',
            'type' => 'submit',
        ));
    }

}
