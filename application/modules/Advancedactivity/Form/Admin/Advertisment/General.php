<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Advancedactivity
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: General.php 6590 2012-26-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Advancedactivity_Form_Admin_Advertisment_General extends Engine_Form {

  public function init() {

    $settings = Engine_Api::_()->getApi('settings', 'core');
    $view = Zend_Registry::isRegistered('Zend_View') ? Zend_Registry::get('Zend_View') : null;

    $this->setTitle('Advanced Activity Advertisement Settings')
            ->setDescription("You can display Community Ads (From Advertisements / Community Ads Plugin) / Ad Campaigns (From SE-Core feature) and Ads (From Advertisements, Community Ads & Marketing Campaigns Plugin) in your activity feed. Thus, an attractive advertising can be done using this feature. Below, you can configure the settings as per your requirement.[Note: Please enable setting from 'Advanced Activity Feeds' widget to showcase Community Ads / Campaigns / Ads  in activity feed.]");

    //For community ads
    if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('communityad') && !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitead')) {        
    $this->addElement('Radio', 'advancedactivity_community_adv', array(
        'label' => 'Display Community Ads',
        'description' => 'Do you want to display Community Ads in Activity Feed?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('advancedactivity.community.adv', 1),
    ));

    //For core ads
    $this->addElement('Radio', 'advancedactivity_campaign_adv', array(
        'label' => 'Display Ad Campaigns',
        'description' => 'Do you want to display Ad Campaigns in Activity Feed?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('advancedactivity.campaign.adv', 1),
    ));

    //Availabel Community Ads
    $communityAdds = Engine_Api::_()->advancedactivity()->getCommunityAddsMultioptions();
    //Selected Community Ads
    $communityAdsSelected = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.communityads'));
    $communityDescription = 'Select multiple Ads to display in your Activity Feeds. Click here to ';
    if (!empty($communityAdds)) {
      $this->addElement('Multiselect', 'community_adv_types', array(
          'label' => 'Select Community Ads',
          'description' => $communityDescription . "<a href='" . $view->url(array('module' => 'communityad', 'controller' => 'viewad'), 'admin_default', true) . "' target='_blank'>" . Zend_Registry::get('Zend_Translate')->_('Manage Advertisement') . "</a>.<br>" . "[Note: Maximum visible Ads at a time in the activity feeds is 3. But, if you have selected more than 3 Ads then at random 3 Ads will be shown from the selected Ads. In case, you have selected less than 3 Ads then Ad will not be visible in the feeds.]",
          'multiOptions' => $communityAdds,
          'value' => $communityAdsSelected
      ));
    } else {
      $communityDescription = 'Currently there are no Community Ads. Click here to ';
      $this->addElement('Dummy', 'community_adv_types', array(
          'label' => 'Select Community Ads',
          'description' => $communityDescription . "<a href='" . $view->url(array('module' => 'communityad', 'controller' => 'viewad'), 'admin_default', true) . "' target='_blank'>" . Zend_Registry::get('Zend_Translate')->_('Manage Advertisement') . "</a>",
      ));
    }
    $this->getElement('community_adv_types')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));

    //Available Core Ads
    $coreAdds = Engine_Api::_()->advancedactivity()->getCoreAddMultioptions();
    //Selected Core Ads
    $coreAdsSelected = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.coreads'));
    $URL = $view->baseUrl() . "/admin/ads";
    $click = '<a href="' . $URL . '" target="_blank">Manage Campaigns.</a>';
    $coreDescription = sprintf("Select multiple Ads to display in your Activity Feeds. Click here to %s ", $click);
    if (!empty($coreAdds)) {
      $this->addElement('Multiselect', 'core_adv_types', array(
          'label' => 'Select Ad Campaigns',
          'description' => $coreDescription,
          'multiOptions' => $coreAdds,
          'value' => $coreAdsSelected
      ));
    } else {
      $coreDescription = sprintf("Currently there are no active Ad Campaigns. Click here to %s ", $click);
      $this->addElement('Dummy', 'core_adv_types', array(
          'label' => 'Select Ad Campaigns',
          'description' => $coreDescription,
      ));
    }
    $this->getElement('core_adv_types')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  }

// for Siteads
  if(Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitead')) {
    $this->addElement('Radio', 'advancedactivity_sitead_adv', array(
        'label' => 'Display Ads',
        'description' => 'Do you want to display Ads in Activity Feed?',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No'
        ),
        'value' => $settings->getSetting('advancedactivity.sitead.adv', 1),
    ));

    $this->addElement('Radio', 'advancedactivity_sitead_adselect', array(
        'label' => 'Manually Select Ads',
        'description' => 'Do you want to choose ads manually?(Note: If selected NO, random advertisements will get displayed in the activity feed automatically)',
        'multiOptions' => array(
            1 => 'Yes',
            0 => 'No',
        ),
        'onclick' => 'changeOptions(this.value)',
        'value' => $settings->getSetting('advancedactivity.sitead.adselect', 1),
    ));
  
    //Availabel Site Ads
    $siteAdds = Engine_Api::_()->sitead()->getSiteAddsMultioptions();
    //Selected Community Ads
    $siteAdsSelected = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.siteads'));
    $communityDescription = 'Select multiple Ads to display in your Activity Feeds. Click here to ';
    if (!empty($siteAdds)) {
      $this->addElement('Multiselect', 'site_adv_types', array(
          'label' => 'Select Ads',
          'description' => $communityDescription . "<a href='" . $view->url(array('module' => 'sitead', 'controller' => 'viewad'), 'admin_default', true) . "' target='_blank'>" . Zend_Registry::get('Zend_Translate')->_('Manage Advertisement') . "</a>.<br>" . "[Note: Ads will be shown randomly from the selected Ads.]",
          'multiOptions' => $siteAdds,
          'value' => $siteAdsSelected
      ));
    } else {
      $communityDescription = 'Currently there are no Ads. Click here to ';
      $this->addElement('Dummy', 'site_adv_types', array(
          'label' => 'Select Ads',
          'description' => $communityDescription . "<a href='" . $view->url(array('module' => 'sitead', 'controller' => 'viewad'), 'admin_default', true) . "' target='_blank'>" . Zend_Registry::get('Zend_Translate')->_('Manage Advertisement') . "</a>",
      ));
    }
    $this->getElement('site_adv_types')->getDecorator('Description')->setOptions(array('placement' => 'PREPEND', 'escape' => false));
  }

    //Set the no of repeating feed after which adv block should come
    $this->addElement('Text', 'advancedactivity_adv_count', array(
        'label' => 'Ads / Ad Campaign Placement',
        'description' => 'After how many feeds you want to show Ads / Ad Campaign?',
        'value' => $settings->getSetting('advancedactivity.adv.count', 5),
    ));

   $this->addElement('Button', 'submit', array(
        'label' => 'Save Changes',
        'type' => 'submit',
        'ignore' => true,
        'decorators' => array('ViewHelper')
    ));
}

}

?>
