<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: footer-settings.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js'); ?>
<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form atoz_header_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

window.addEvent('domready', function() {
  socialmedialinks("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.socialenable', 1); ?>");
  enableleftcolumn("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.leftcolumnenable', 1); ?>");
  enablerightcolumn("<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.rightcolumnenable', 1); ?>");
});

function enablerightcolumn(value) {
  if(value == 1){
    if($('sesatoz_rightcolhdingtext-wrapper'))
      $('sesatoz_rightcolhdingtext-wrapper').style.display = 'block';
    if($('sesatoz_rightcolhdingdes-wrapper'))
      $('sesatoz_rightcolhdingdes-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdingbtn1-wrapper'))
      $('sesatoz_leftcolhdingbtn1-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdingbtn2-wrapper'))
      $('sesatoz_leftcolhdingbtn2-wrapper').style.display = 'block';
  } else {
    if($('sesatoz_rightcolhdingtext-wrapper'))
      $('sesatoz_rightcolhdingtext-wrapper').style.display = 'none';
    if($('sesatoz_rightcolhdingdes-wrapper'))
      $('sesatoz_rightcolhdingdes-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdingbtn1-wrapper'))
      $('sesatoz_leftcolhdingbtn1-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdingbtn2-wrapper'))
      $('sesatoz_leftcolhdingbtn2-wrapper').style.display = 'none';
  }
} 

function enableleftcolumn(value) {
  if(value == 1){
    if($('sesatoz_leftcolhdingtext-wrapper'))
      $('sesatoz_leftcolhdingtext-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdingdes-wrapper'))
      $('sesatoz_leftcolhdingdes-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdinglocation-wrapper'))
      $('sesatoz_leftcolhdinglocation-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdingemail-wrapper'))
      $('sesatoz_leftcolhdingemail-wrapper').style.display = 'block';
    if($('sesatoz_leftcolhdingphone-wrapper'))
      $('sesatoz_leftcolhdingphone-wrapper').style.display = 'block';
  } else {
    if($('sesatoz_leftcolhdingtext-wrapper'))
      $('sesatoz_leftcolhdingtext-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdingdes-wrapper'))
      $('sesatoz_leftcolhdingdes-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdinglocation-wrapper'))
      $('sesatoz_leftcolhdinglocation-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdingemail-wrapper'))
      $('sesatoz_leftcolhdingemail-wrapper').style.display = 'none';
    if($('sesatoz_leftcolhdingphone-wrapper'))
      $('sesatoz_leftcolhdingphone-wrapper').style.display = 'none';
  }
} 


function socialmedialinks(value){
  if(value == 1){
    if($('sesatoz_socialsharelink-wrapper'))
      $('sesatoz_socialsharelink-wrapper').style.display = 'block';
  } else {
    if($('sesatoz_socialsharelink-wrapper'))
      $('sesatoz_socialsharelink-wrapper').style.display = 'none';
  }
}
</script>
