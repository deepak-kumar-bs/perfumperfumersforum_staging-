<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<h2><?php echo $this->translate('Professional Questions and Answers Plugin')?></h2>

<?php if( count($this->navigation) ):?>
	<div class='seaocore_admin_tabs tabs clr'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
	</div>
<?php endif; ?>

<div class='clear seaocore_settings_form'>
  <div class='settings' style="margin-top:15px;">
    <?php echo $this->form->render($this) ?>
  </div>
</div>

<script type="text/javascript">
	if($('siteqa_multilanguage-1')) {
		$('siteqa_multilanguage-1').addEvent('click', function(){
				$('siteqa_languages-wrapper').setStyle('display', ($(this).get('value') == '1'?'block':'none'));
		});
		$('siteqa_multilanguage-0').addEvent('click', function(){
				$('siteqa_languages-wrapper').setStyle('display', ($(this).get('value') == '0'?'none':'block'));
		});
		window.addEvent('domready', function() {
			$('siteqa_languages-wrapper').setStyle('display', ($('siteqa_multilanguage-1').checked ?'block':'none'));
		});
	}
</script>