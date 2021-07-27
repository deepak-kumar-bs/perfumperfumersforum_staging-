<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>
<?php if( $this->form ): ?>
  <?php echo $this->form->render($this) ?>
<?php endif ?>

<script type="text/javascript">
	window.addEvent('domready', function () {

		// document.getElementsByTagName('li').addEventListener('click', function(event) {
			// console.log(this);
		// });
		<?php if(!$this->AllCheckBox): ?>
			if($('content_type-element').getElementById('content_type-'))
				$('content_type-element').getElementById('content_type-').checked = false;
		<?php endif; ?>
	});
</script>

