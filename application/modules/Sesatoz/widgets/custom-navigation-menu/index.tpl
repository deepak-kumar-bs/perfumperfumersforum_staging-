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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/styles/styles.css'); ?>
<div class="sesatoz_banner_container sesbasic_bxs" style="height:<?php echo $this->height; ?>px;">
	<div class="sesatoz_banner_inner" style="height:<?php echo $this->height; ?>px;background-image:url(<?php echo $this->backgroundimage; ?>);">
  	<div id="sesatoz_custom_navigation_banner" <?php if($this->textalignment == 'center'): ?> class="_txtcenter" <?php endif; ?>></div>
  </div>  
 </div>
<?php
	$request = Zend_Controller_Front::getInstance()->getRequest();
	$moduleName = $request->getModuleName();
	
?>
<script type="application/javascript">
sesJqueryObject(document).ready(function(e){
    var bowsermenulength = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').find('.tabs').find('ul').length;
      if(bowsermenulength == 0){
        sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').hide();
    }
    if(sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').length) {
    
      sesJqueryObject ("body").addClass('sesatoz_menubanner');

      var navigationMenu = sesJqueryObject('.layout_<?php echo $moduleName; ?>_browse_menu').find('.headline');
      var finalNavigationTitle = "<h2>"+navigationMenu.find('h2').html()+"</h2>";
      sesJqueryObject('#sesatoz_custom_navigation_banner').html(finalNavigationTitle);
      navigationMenu.find('h2').remove();
      var height = sesJqueryObject(".layout_page_header").height();
      if($("global_wrapper")) {
        $("global_wrapper").setStyle("margin-top", height+"px");
      }
    } else {
      sesJqueryObject('.layout_sesatoz_custom_navigation_menu').hide();
    }
});
</script>