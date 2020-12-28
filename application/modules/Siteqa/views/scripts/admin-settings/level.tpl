<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: level.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>
<style type="text/css">
  .settings h4{font-size: 10.5pt; line-height: 2em;}
</style>

<script type="text/javascript">
  var fetchLevelSettings =function(level_id){
    window.location.href= en4.core.baseUrl+'admin/siteqa/settings/level/id/'+level_id;
  }
</script>

<h2><?php echo $this->translate('Professional Questions and Answers Plugin'); ?></h2>

<?php if( count($this->navigation) ): ?>
	<div class='seaocore_admin_tabs tabs clr'>
		<?php	echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
	</div>
<?php endif; ?>

<div class='clear seaocore_settings_form'>
  <div class='settings'>
    <?php echo $this->form->render($this) ?>
  </div>
</div>