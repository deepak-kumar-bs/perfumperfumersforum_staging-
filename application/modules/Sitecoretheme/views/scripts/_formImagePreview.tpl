<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: _formImagePreview.tpl 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
 ?>
<script type="text/javascript">
  window.addEvent('domready', function () {
<?php foreach ($this->bindPreviews as $el): ?>
	    (function () {
	      var el = $('<?php echo $el ?>');
	      var previewEl = new Element('span', {
	        class: 'sitecoretheme_admin_background_image_preview'
	      });
	      previewEl.inject(el.getParent());
	      var onChangeHandler = function () {
	        previewEl.empty();
	        if (!el.get('value')) {
	          return;
	        }
	        (new Request.JSON({
			    'format': 'json',
			    'url' : '<?php echo $this->url(array('module' => 'sitecoretheme', 'controller' => 'settings', 'action' => 'get-image-src'), 'admin_default', true) ?>',
			    'data' : {
			      'format' : 'json',
			      'image' : el.get('value'),
			    },  
			    onSuccess: function(responseJSON, responseText) {
			        var imgEl = new Element('img', {
			          src:  responseJSON.actualImageurl
			        });
			        imgEl.inject(previewEl);

			    }     
			})).send();
	      };
	      el.addEvent('change', onChangeHandler);
				onChangeHandler();
	    })();
<?php endforeach; ?>

  });
</script>