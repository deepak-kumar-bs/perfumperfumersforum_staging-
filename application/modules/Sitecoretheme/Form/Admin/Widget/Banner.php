<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Banner.php 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitecoretheme_Form_Admin_Widget_Banner extends Engine_Form
{

  public function init()
  {
    $imgOptions = Engine_Api::_()->sitecoretheme()->getImages(array('0' => 'No Image'));
    $logoOptions = Engine_Api::_()->sitecoretheme()->getImages(array('0' => 'Text-only (No logo)'));

    $this->addElement('Hidden', 'title');

    $this->addElement('Select', 'logo', array(
      'label' => 'Select Logo',
      'multiOptions' => $logoOptions,
    ));

//    $this->addElement('Text', 'description', array(
//      'label' => 'Description',
//      'value' => '',
//    ));

    $this->addElement('Select', 'image', array(
      'label' => 'Select Banner Image',
      'multiOptions' => $imgOptions,
    ));

    $this->addElement('Text', 'gradient_color_first', array(
      'decorators' => array(array('ViewScript', array(
            'viewScript' => 'application/modules/Sitecoretheme/views/scripts/form-image-rainbow/_formImagerainbow1.tpl',
            'class' => 'form element',
          )))
    ));

    $this->addElement('Text', 'gradient_color_second', array(
      'decorators' => array(array('ViewScript', array(
            'viewScript' => 'application/modules/Sitecoretheme/views/scripts/form-image-rainbow/_formImagerainbow2.tpl',
            'class' => 'form element',
          )))
    ));
  }

}