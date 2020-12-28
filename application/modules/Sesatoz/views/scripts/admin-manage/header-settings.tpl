<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: header-settings.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>
<div class='tabs'>
  <ul class="navigation">
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesatoz', 'controller' => 'manage', 'action' => 'header-settings'), $this->translate('Header Settings')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesatoz', 'controller' => 'manage', 'action' => 'index'), $this->translate('Main Menu Icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesatoz', 'controller' => 'manage', 'action' => 'mini-menu-icons'), $this->translate('Mini Menu icons')) ?>
    </li>
    <li>
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesatoz', 'controller' => 'menu'), $this->translate('Mini Menu')) ?>
    </li>
  </ul>
</div>
<div class='clear sesbasic_admin_form atoz_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  showSocialShare("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.show.socialshare', 1); ?>");
  showHidePanel("<?php echo Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_sidepanel_effect'); ?>");
  showHeaderDesigns("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 1); ?>");
});

function showHidePanel(value) {
  if(value == 1) {
    if($('sesatoz_sidepanel_showhide-wrapper'))
      $('sesatoz_sidepanel_showhide-wrapper').style.display = 'none';
  } else if(value == 2) {
    if($('sesatoz_sidepanel_showhide-wrapper'))
      $('sesatoz_sidepanel_showhide-wrapper').style.display = 'block';
  }
}

function showHeaderDesigns(value) {

  if(value == 1) {
    if($('sesatoz_menu_img-wrapper'))
      $('sesatoz_menu_img-wrapper').style.display = 'none';
    if($('sesatoz_sidepanel_effect-wrapper'))
      $('sesatoz_sidepanel_effect-wrapper').style.display = 'none';
    if($('sesatoz_menuinformation_img-wrapper'))
      $('sesatoz_menuinformation_img-wrapper').style.display = 'none';
    if($('sesatoz_sidepanel_showhide-wrapper'))
      $('sesatoz_sidepanel_showhide-wrapper').style.display = 'none';
    if($('sesatoz_limit-wrapper'))
      $('sesatoz_limit-wrapper').style.display = 'block';
    if($('sesatoz_moretext-wrapper'))
      $('sesatoz_moretext-wrapper').style.display = 'block';
  } else {
    if($('sesatoz_menu_img-wrapper'))
      $('sesatoz_menu_img-wrapper').style.display = 'block';
    if($('sesatoz_sidepanel_effect-wrapper'))
      $('sesatoz_sidepanel_effect-wrapper').style.display = 'block';   
    if($('sesatoz_menuinformation_img-wrapper'))
      $('sesatoz_menuinformation_img-wrapper').style.display = 'block';
    if($('sesatoz_sidepanel_effect').value == 1){
      if($('sesatoz_sidepanel_showhide-wrapper'))
        $('sesatoz_sidepanel_showhide-wrapper').style.display = 'none';
    } else {
      if($('sesatoz_sidepanel_showhide-wrapper'))
        $('sesatoz_sidepanel_showhide-wrapper').style.display = 'block';
    }
    if($('sesatoz_limit-wrapper'))
      $('sesatoz_limit-wrapper').style.display = 'none';
    if($('sesatoz_moretext-wrapper'))
      $('sesatoz_moretext-wrapper').style.display = 'none';
  }
}

function showSocialShare(value) {

  if(value == 1) {
    if($('sesatoz_facebookurl-wrapper'))
      $('sesatoz_facebookurl-wrapper').style.display = 'block';
    if($('sesatoz_googleplusurl-wrapper'))
      $('sesatoz_googleplusurl-wrapper').style.display = 'block';
    if($('sesatoz_twitterurl-wrapper'))
      $('sesatoz_twitterurl-wrapper').style.display = 'block';
    if($('sesatoz_pinteresturl-wrapper'))
      $('sesatoz_pinteresturl-wrapper').style.display = 'block';
  } else {
    if($('sesatoz_facebookurl-wrapper'))
      $('sesatoz_facebookurl-wrapper').style.display = 'none';
    if($('sesatoz_googleplusurl-wrapper'))
      $('sesatoz_googleplusurl-wrapper').style.display = 'none';
    if($('sesatoz_twitterurl-wrapper'))
      $('sesatoz_twitterurl-wrapper').style.display = 'none';
    if($('sesatoz_pinteresturl-wrapper'))
      $('sesatoz_pinteresturl-wrapper').style.display = 'none';
  }
}
</script>
