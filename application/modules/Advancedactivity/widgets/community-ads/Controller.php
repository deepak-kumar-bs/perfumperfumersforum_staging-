<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Advancedactivity
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Controller.php 6590 2012-26-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Advancedactivity_Widget_CommunityAdsController extends Engine_Content_Widget_Abstract {
    protected $_session;
    protected $_boost;

    public function indexAction() {
        //Return if community Adv. Plugin is not installed
        if ((!Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('communityad') && !Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitead'))) {
            return $this->setNoRender();
        }
        // Return if setting is disabled from widget
        if (!$this->_getParam('integrateCommunityAdv')) {
            return $this->setNoRender();
        }
        $this->_session = new Zend_Session_Namespace('Activity_Display_Sitead');
        $this->_boost = new Zend_Session_Namespace('Activity_Display_Boostfeed');

        if(!$this->_getParam('integrateBoostFeed')) {
        $this->view->addType = $adType = $this->_getAdType();
        if (empty($adType))
            return $this->setNoRender();
        
        if($adType == 1) {
           $render = $this->_displayCoreAd();
        } elseif ($adType == 2) {
           $render = $this->_displayCommunityAdv();
        } else {
            $render = $this->_displaySiteAdv();
        }
        if (empty($render))
            return $this->setNoRender();
    }
    else {
        $this->view->boostActionId = $feedArray = $this->_displaySiteAdvBoostFeed();
        if (empty($feedArray)) {
            return $this->setNoRender();
        }
    }
  }

    private function _getAdType() {
        $settings = Engine_Api::_()->getApi('settings', 'core');
        $enableCommunityAdv = $settings->getSetting('advancedactivity.community.adv', 0);
        $enableCoreAdv = $settings->getSetting('advancedactivity.campaign.adv', 0);
        $enableSiteAdv = $settings->getSetting('advancedactivity.sitead.adv', 0);
        $addType = 0;

        if (empty($enableCommunityAdv) && empty($enableCoreAdv) && empty($enableSiteAdv))
            return;

        // Generate a random adv type if both are enabled
        if ($enableCommunityAdv && $enableCoreAdv && $enableSiteAdv)
            $addType = rand(1, 3);
        else if (!empty($enableCoreAdv) && !empty($enableCommunityAdv))
            $addType = rand(1, 2);
        else if (!empty($enableCommunityAdv) && !empty($enableSiteAdv))
            $addType = rand(2, 3);
        else if (!empty($enableCommunityAdv) && !empty($enableSiteAdv)) {
            $addType = rand(1, 3);
            if($addType == 2)
                $addType = 3;
        } 
        else if(!empty($enableCoreAdv))
            $addType = 1;
        else if(!empty($enableCommunityAdv))
            $addType = 2;
        else if(!empty($enableSiteAdv))
            $addType = 3;

        return $addType;
    }

    private function _displayCoreAd() {
        $coreAdsSelectedArray = array();
        $coreAdsSelectedArray = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.coreads'));
        $coreAdds = Engine_Api::_()->advancedactivity()->getCoreAddMultioptions(1);
        $coreAdsSelected = array_intersect((array)$coreAdsSelectedArray, $coreAdds);
        $viewer = Engine_Api::_()->user()->getViewer();

        if (!is_array($coreAdsSelected) || count($coreAdsSelected) < 1) {
            return false;
        }

        $displayAdsKey = array_rand($coreAdsSelected, 1);

        if (!($ad_id = $coreAdsSelected[$displayAdsKey] ) ||
                !($ad = Engine_Api::_()->getItem('core_ad', $ad_id))) {
            return false;
        }

        if (!($id = $ad->ad_campaign) ||
                !($campaign = Engine_Api::_()->getItem('core_adcampaign', $id)) || !$campaign->isActive() || !$campaign->isAllowedToView($viewer)) {
            return false;
        }

        $campaign->views++;
        $campaign->save();

        $ad->views++;
        $ad->save();

        $this->view->campaign = $campaign;
        $this->view->ad = $ad;

        return true;
    }

    private function _displayCommunityAdv() {
        // Display Community Adv
        $this->view->showContent = true;
        $this->view->limit = $advCountPerBlock = $this->_getParam('noOfAdv', 3);
        $this->view->showType = $this->_getParam('show_type', 'all');
        $this->view->adBlockWidth = 100;

        $communityAdsSelectedArray = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.communityads'));

        $cancelledAdvs = Engine_Api::_()->advancedactivity()->getCancelAdvs();
        //Remove Ads Cancelled By User
        if (is_array($cancelledAdvs)) {
            $communityAdsSelectedArray = array_diff((array)$communityAdsSelectedArray, $cancelledAdvs);
        }
        //Set total ads per block to total ads if ads is less.
        $communityAdds = Engine_Api::_()->advancedactivity()->getCommunityAddsMultioptions(1);
        $communityAdsSelected = array_intersect($communityAdsSelectedArray, $communityAdds);

        if (is_array($communityAdsSelected) && count($communityAdsSelected) >= 3) {
            //Generate random ads
            $displayAdsKey = array_rand($communityAdsSelected, $advCountPerBlock);
            foreach ($displayAdsKey as $key => $random_ad) {
                $community_ad = Engine_Api::_()->getItem('userads', $communityAdsSelected[$random_ad]);
                if ($community_ad) {
                    $fetch_community_ads[] = $community_ad;
                }
            }
        } else {
            return false;
        }

        // Check if ads to be displayed are not empty
        if (!empty($fetch_community_ads)) {
            $this->view->communityads_array = $fetch_community_ads;
            $this->view->hideCustomUrl = Engine_Api::_()->communityad()->hideCustomUrl();
            return true;
        } else {
            return false;
        }
        return false;
    }

    private function _displaySiteAdv() {
        // Display Site Adv
        $this->view->showContent = true;
        $this->view->limit = $advCountPerBlock = $this->_getParam('noOfAdv', 3);
        $this->view->showType = $this->_getParam('show_type', 'all');
        $this->view->adBlockWidth = 100;
        
        $cancelledAdvs = Engine_Api::_()->sitead()->getCancelAdvs();
        $siteAdsSelectedArray = json_decode(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.siteads'));
        $siteAdds = Engine_Api::_()->sitead()->getSiteAddsMultioptions(1, $this->_get());

        if(empty(Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.sitead.adselect', 1))) {
          $siteAdsSelectedArray = $siteAdds;
        }

        //Remove Ads Cancelled By User
        if (is_array($cancelledAdvs)) {
            $siteAdsSelectedArray = array_diff((array)$siteAdsSelectedArray, $cancelledAdvs);
        }

        $siteAdsSelected = array_intersect($siteAdsSelectedArray, $siteAdds);

        //Set total ads per block to total ads if ads is less.
        if (is_array($siteAdsSelected) && count($siteAdsSelected) >= 1) {
            //Generate random ads
            $displayAdsKey[] = array_rand($siteAdsSelected, 1);
            foreach ($displayAdsKey as $key => $random_ad) {
                $site_ad = Engine_Api::_()->getItem('userads', $siteAdsSelected[$random_ad]);
                $manifest = $this->_get();
                $manifest[] = $siteAdsSelected[$random_ad];
                $this->_session->user_ad = $manifest;
                if ($site_ad) {
                    $fetch_site_ads[] = $site_ad;
                }
            }
        } else {
            return false;
        }

        $siteadinfo_table = Engine_Api::_()->getItemTable('sitead_adsinfo');
        $fetch_site_adsinfo = $siteadinfo_table->fetchAll();
       
        // Check if ads to be displayed are not empty
        if (!empty($fetch_site_ads) && !empty($fetch_site_adsinfo)) {
            $this->view->siteads_array = $fetch_site_ads;
            $this->view->siteadsinfo_array = $fetch_site_adsinfo;
            $this->view->hideCustomUrl = Engine_Api::_()->sitead()->hideCustomUrl();
            return true;
        } else {
            return false;
        }
        return false;
    }

    private function _displaySiteAdvBoostFeed() {
        $siteAddsBoost = Engine_Api::_()->sitead()->getSiteAddsMultioptions(1, $this->_getBoostFeed(), 1);
        $cancelledAdvs = Engine_Api::_()->sitead()->getCancelAdvs();
        //Remove Ads Cancelled By User
        if (is_array($cancelledAdvs)) {
            $siteAdsSelectedArray = array_diff($siteAddsBoost, $cancelledAdvs);
        }
        //Set total ads per block to total ads if ads is less.
        
        $siteAdsBoostSelected = $siteAdsSelectedArray;

        if (is_array($siteAdsBoostSelected) && count($siteAdsBoostSelected) >= 1) {
            //Generate random ads
            $displayAdsKey[] = array_rand($siteAdsBoostSelected, 1);
            foreach ($displayAdsKey as $key => $random_ad) {
                $site_ad_boost = Engine_Api::_()->getItem('userads', $siteAdsBoostSelected[$random_ad]);
                $displayedFeed = $this->_getBoostFeed();
                $displayedFeed[] = $siteAdsBoostSelected[$random_ad];
                $this->_boost->user_ad_boost = $displayedFeed;
                if ($site_ad_boost) {
                    $fetch_site_ads_boost[] = $site_ad_boost;
                }
            }
        } else {
            return array();
        }
   
        // Check if ads of boost feed to be displayed are not empty
        if (!empty($fetch_site_ads_boost) ) {
            return $fetch_site_ads_boost[0]['resource_id'];
        } else {
            return array();
        }
        return array();
    }

    private function _get() {

        return isset($this->_session->user_ad) ? $this->_session->user_ad : array();

       // return Zend_Registry::isRegistered('Sitead_Userad') ? Zend_Registry::get('Sitead_Userad') : Zend_Registry::set('Sitead_Userad');
    }

     private function _getBoostFeed() {

        return isset($this->_boost->user_ad_boost) ? $this->_boost->user_ad_boost : array();
    }

}
