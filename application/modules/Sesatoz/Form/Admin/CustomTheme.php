<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: CustomTheme.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Form_Admin_CustomTheme extends Engine_Form {

  public function init() {

    $customtheme_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('customtheme_id', 0);

    $this->setTitle('Add New Custom Theme');
    $this->setMethod('post');

    $this->addElement('Text', 'name', array(
        'label' => 'Enter the new custom theme name.',
        'allowEmpty' => false,
        'required' => true,
    ));

    if(empty($customtheme_id)) {
        $getCustomThemes = Engine_Api::_()->getDbTable('customthemes', 'sesatoz')->getCustomThemes(array('all' => 1));
        if(count($getCustomThemes) > 0) {
            foreach($getCustomThemes as $getCustomTheme){
            $sestheme[$getCustomTheme['theme_id']] = $getCustomTheme['name'];
            }

            $this->addElement('Select', 'customthemeid', array(
                'label' => 'Choose From Existing Theme',
                'multiOptions' => $sestheme,
                'escape' => false,
            ));
        }
    }

    // Buttons
    $this->addElement('Button', 'submit', array(
        'label' => 'Create',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));

    $this->addElement('Cancel', 'cancel', array(
        'label' => 'Cancel',
        'link' => true,
        'prependText' => ' or ',
        'href' => '',
        'onClick' => 'javascript:parent.Smoothbox.close();',
        'decorators' => array(
            'ViewHelper'
        )
    ));
    $this->addDisplayGroup(array('submit', 'cancel'), 'buttons');
  }

}
