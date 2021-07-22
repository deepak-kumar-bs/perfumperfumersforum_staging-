<?php

/**
* SocialEngine
*
* @category   Application_Extensions
* @package    Advancedactivity
* @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
* @license    http://www.socialengineaddons.com/license/
* @version    $Id: index.tpl 6590 2012-26-01 00:00:00Z SocialEngineAddOns $
* @author     SocialEngineAddOns
*/
?>
<h2>
<?php echo $this->translate("ADVANCED_ACTIVITY_PLUGIN_NAME") . " " . $this->translate("Plugin") ?>
</h2>
<?php if (count($this->navigation)): ?>
<div class='seaocore_admin_tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
</div>
<?php endif; ?>
<?php if (!empty($this->errorMessage)): ?>
<div class='seaocore_tip'>
    <span>
    <?php echo $this->errorMessage ?>
    </span>
</div>
<?php else: ?>
<div class="seaocore_settings_form">
    <div class='settings'>
	  <?php echo $this->form->render($this); ?>
    </div>
</div>	
<?php endif; ?>
<script type="text/javascript">
	window.addEvent('domready', function() {
       var autoSelect = <?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('advancedactivity.sitead.adselect', 1) ?>;
       if(autoSelect) {
           $('site_adv_types-wrapper').style.display = 'block';
       } else {
           $('site_adv_types-wrapper').style.display = 'none';
       }
	});

	function changeOptions(value) { 
		$('site_adv_types-wrapper').style.display = 'none';
		if(value == 1) {
          $('site_adv_types-wrapper').style.display = 'block';
		}
	}
</script>
