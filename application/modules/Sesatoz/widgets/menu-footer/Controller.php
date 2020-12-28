<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Controller.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Widget_MenuFooterController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

    $this->view->storage = Engine_Api::_()->storage();
    $this->view->navigation = $navigation = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_footer');
    $this->view->quickLinksMenu = Engine_Api::_()->getApi('menus', 'core')->getNavigation('sesatoz_quicklinks_footer');

    // Languages
    $translate = Zend_Registry::get('Zend_Translate');
    $languageList = $translate->getList();

    //$currentLocale = Zend_Registry::get('Locale')->__toString();
    // Prepare default langauge
    $defaultLanguage = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.locale.locale', 'en');
    if (!in_array($defaultLanguage, $languageList)) {
      if ($defaultLanguage == 'auto' && isset($languageList['en'])) {
        $defaultLanguage = 'en';
      } else {
        $defaultLanguage = null;
      }
    }

    // Prepare language name list
    $languageNameList = array();
    $languageDataList = Zend_Locale_Data::getList(null, 'language');
    $territoryDataList = Zend_Locale_Data::getList(null, 'territory');

    foreach ($languageList as $localeCode) {
      $languageNameList[$localeCode] = Engine_String::ucfirst(Zend_Locale::getTranslation($localeCode, 'language', $localeCode));
      if (empty($languageNameList[$localeCode])) {
        if (false !== strpos($localeCode, '_')) {
          list($locale, $territory) = explode('_', $localeCode);
        } else {
          $locale = $localeCode;
          $territory = null;
        }
        if (isset($territoryDataList[$territory]) && isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory] . ' ' . $languageDataList[$locale];
        } else if (isset($territoryDataList[$territory])) {
          $languageNameList[$localeCode] = $territoryDataList[$territory];
        } else if (isset($languageDataList[$locale])) {
          $languageNameList[$localeCode] = $languageDataList[$locale];
        } else {
          continue;
        }
      }
    }
    $languageNameList = array_merge(array(
        $defaultLanguage => $defaultLanguage
            ), $languageNameList);
    $this->view->languageNameList = $languageNameList;

    // Get affiliate code
    $this->view->affiliateCode = Engine_Api::_()->getDbtable('settings', 'core')->core_affiliate_code;
    $settings = Engine_Api::_()->getApi('settings', 'core');

    $this->view->aboutusdescription =  $settings->getSetting('sesatoz.aboutusdescription', 'Lorem Ipsum Is Simply Dummy Text Of The Printing And Typesetting Industry.');
    $this->view->quicklinksenable =  $settings->getSetting('sesatoz.quicklinksenable', '1');
    $this->view->quicklinksheading =  $settings->getSetting('sesatoz.quicklinksheading', 'QUICK LINKS');
    $this->view->helpenable =  $settings->getSetting('sesatoz.helpenable', '1');
    $this->view->helpheading =  $settings->getSetting('sesatoz.helpheading', 'HELP');
    $this->view->socialenable =  $settings->getSetting('sesatoz.socialenable', '1');
    $this->view->socialheading =  $settings->getSetting('sesatoz.socialheading', 'SOCIAL');
    $this->view->core_social_sites = Engine_Api::_()->getApi('menus', 'core')->getNavigation('core_social_sites');

    $this->view->leftcolhdingtext = $settings->getSetting('sesatoz.leftcolhdingtext', 'ABOUT & CONTACT');
    $this->view->leftcolhdingdes = $settings->getSetting('sesatoz.leftcolhdingdes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');
    $this->view->leftcolhdinglocation = $settings->getSetting('sesatoz.leftcolhdinglocation', 'Los Angeles, USA');
    $this->view->leftcolhdingemail = $settings->getSetting('sesatoz.leftcolhdingemail', 'info@abc.com');
    $this->view->leftcolhdingphone = $settings->getSetting('sesatoz.leftcolhdingphone', '+91-1234567890');
    $this->view->leftcolumnenable = $settings->getSetting('sesatoz.leftcolumnenable', 1);

    $this->view->rightcolhdingbtn1 = $settings->getSetting('sesatoz.rightcolhdingbtn1', '');
    $this->view->rightcolhdingbtn2 = $settings->getSetting('sesatoz.rightcolhdingbtn2', '');

    $this->view->sesatoz_twitterembed = $settings->getSetting('sesatoz.twitterembed', '');
  }

}
