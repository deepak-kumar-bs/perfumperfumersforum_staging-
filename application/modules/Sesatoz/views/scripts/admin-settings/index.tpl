<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>

<div class='clear'>
  <div class='settings sesbasic_admin_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<div class="sesbasic_waiting_msg_box" style="display:none;">
	<div class="sesbasic_waiting_msg_box_cont">
    <?php echo $this->translate("Please wait.. It might take some time to activate plugin."); ?>
    <i></i>
  </div>
</div>
<?php if(!Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.pluginactivated',0)){ 
 $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/sesJquery.js');?>
	<script type="application/javascript">
  	sesJqueryObject('.global_form').submit(function(e){
			sesJqueryObject('.sesbasic_waiting_msg_box').show();
		});
  </script>
<?php } ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popupsign', 1);
$loginsignupvisiablity = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popup.enable', 1);
?>

<script type="text/javascript">
 
  window.addEvent('domready',function() {
    showPopup('<?php echo $showPopup;?>');
    loginsignupvisiablity('<?php echo $loginsignupvisiablity;?>');
  });
  
  function loginsignupvisiablity(value) {
    if(value == 1) {
			document.getElementById('sesatoz_popup_day-wrapper').style.display = 'block';
		} else {
			document.getElementById('sesatoz_popup_day-wrapper').style.display = 'none';
    }
  }
  
  function showPopup(value) {
    if(value == 1) {
			document.getElementById('sesatoz_popup_enable-wrapper').style.display = 'block';
      document.getElementById('sesatoz_popup_day-wrapper').style.display = 'block';
			document.getElementById('sesatoz_popupfixed-wrapper').style.display = 'block';
			document.getElementById('sesatoz_loginsignuplogo-wrapper').style.display = 'block';
			document.getElementById('sesatoz_loginsignupbgimage-wrapper').style.display = 'block';
		} else {
			document.getElementById('sesatoz_popup_enable-wrapper').style.display = 'none';
      document.getElementById('sesatoz_popup_day-wrapper').style.display = 'none';
			document.getElementById('sesatoz_popupfixed-wrapper').style.display = 'none';
			document.getElementById('sesatoz_loginsignuplogo-wrapper').style.display = 'none';
			document.getElementById('sesatoz_loginsignupbgimage-wrapper').style.display = 'none';
		}
  }
</script>
     