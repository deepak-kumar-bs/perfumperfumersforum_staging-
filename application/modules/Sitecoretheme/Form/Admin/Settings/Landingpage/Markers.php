<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Markers.php 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Sitecoretheme_Form_Admin_Settings_Landingpage_Markers extends Engine_Form
{

  public function init()
  {
    $description = sprintf(Zend_Registry::get('Zend_Translate')->_("Here you can manage the information to be displayed on the Markers Block. This block can be used in numerous ways. In order to make it more presentable, options to add counts, icons along with the title has been provided. <a title='Preview - Markers Block' href='application/modules/Sitecoretheme/externals/images/screenshots/marker.png' target='_blank' class='sitecoretheme_icon_view' > </a>"));
    $this->setTitle("Manage Markers Block");
    $this->setDescription("$description");
    $this->loadDefaultDecorators();
    $this->getDecorator('Description')->setOption('escape', false);
    $coreSettings = Engine_Api::_()->getApi('settings', 'core');
    $this->setAttrib('id', 'form-upload');

    $imgOptions = Engine_Api::_()->sitecoretheme()->getImages(array('0' => 'Default image'));


      $this->addElement('Select', 'sitecoretheme_landing_markers_bgimage', array(
        'label' => 'Background Image',
        'description' => 'Select background image for Achievement Block. [Note: You can add new image from "Appearance" > "File & Media Manager".]',
        'multiOptions' => $imgOptions,
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.bgimage', ''),
      ));

      $this->addElement('Text', 'sitecoretheme_landing_markers_title1', array(
        'label' => '1st stat title',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.title1', 'Clients'),
      )); 

      $this->addElement('File', 'sitecoretheme_landing_markers_icon1', array(
          'label' => 'Upload 1st stat Icon',
      )); 

      $this->addElement('Text', 'sitecoretheme_landing_markers_count1', array(
        'label' => '1st stat count',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.count1', '7000+'),
      ));

      $this->addElement('Text', 'sitecoretheme_landing_markers_title2', array(
        'label' => '2nd stat title',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.title2', 'Products'),
      ));

      $this->addElement('File', 'sitecoretheme_landing_markers_icon2', array(
          'label' => 'Upload 2nd stat Icon',
      )); 

      $this->addElement('Text', 'sitecoretheme_landing_markers_count2', array(
        'label' => '2nd stat count',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.count2', '100+'),
      ));

      $this->addElement('Text', 'sitecoretheme_landing_markers_title3', array(
        'label' => '3rd stat title',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.title3', 'Reviews'),
      ));

      $this->addElement('File', 'sitecoretheme_landing_markers_icon3', array(
          'label' => 'Upload 3rd stat Icon',
      )); 

      $this->addElement('Text', 'sitecoretheme_landing_markers_count3', array(
        'label' => '3rd stat count',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.count3', '975+'),
      ));

      $this->addElement('Text', 'sitecoretheme_landing_markers_title4', array(
        'label' => '4th stat title',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.title4', 'Projects Done'),
      ));

      $this->addElement('File', 'sitecoretheme_landing_markers_icon4', array(
          'label' => 'Upload Icon',
      )); 

      $this->addElement('Text', 'sitecoretheme_landing_markers_count4', array(
        'label' => '4th stat count',
        'value' => $coreSettings->getSetting('sitecoretheme.landing.markers.count4', '12597+'),
      ));

      $this->addDisplayGroup( array('sitecoretheme_landing_markers_title1', 'sitecoretheme_landing_markers_count1', 'sitecoretheme_landing_markers_icon1'), 'sitecoretheme_landing_markers_block1');
      $this->addDisplayGroup( array('sitecoretheme_landing_markers_title2', 'sitecoretheme_landing_markers_count2', 'sitecoretheme_landing_markers_icon2'), 'sitecoretheme_landing_markers_block2');
      $this->addDisplayGroup( array('sitecoretheme_landing_markers_title3', 'sitecoretheme_landing_markers_count3', 'sitecoretheme_landing_markers_icon3'), 'sitecoretheme_landing_markers_block3');
      $this->addDisplayGroup( array('sitecoretheme_landing_markers_title4', 'sitecoretheme_landing_markers_count4', 'sitecoretheme_landing_markers_icon4'), 'sitecoretheme_landing_markers_block4');

      $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'decorators' => array(
          'ViewHelper',
        ),
      ));
  }

}
?>