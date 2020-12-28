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
<div class="header_top clearfix">
	<div class="header_top_container clearfix">
    <?php if($this->show_menu): ?>	
      <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2) == 2 && (Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_sidepanel_effect')) == 2){ ?>
        <div class="sidebar_panel_menu_btn <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.sidepanel.showhide', 1) == 1): ?>disabledmenu<?php endif;?>">
          <a href="javascript:void(0);" id="sidebar_panel_menu_btn"><i></i></a>
        </div> 
      <?php } else if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2) == 2 && (Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_sidepanel_effect')) == 1){ ?>
        <div class="sidebar_panel_menu_btn">
          <a href="javascript:void(0);" id="sidebar_panel_menu_btn"><i></i></a>
        </div> 
      <?php } ?>
    <?php endif; ?> 
    <?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesatoz.menu-logo'); ?>
      </div>
      <div class="sesatoz_header_currencydropdown"><ul class="sesatoz_currencydropdown"></ul></div>
    <?php endif; ?>
    <?php if($this->show_search):?>
      <a href="javascript:void(0);" class="mobile_search_toggle_btn fa fa-search" id="mobile_search_toggle"></a>
    <?php endif; ?>
    <div class="minimenu_search_box" id="minimenu_search_box">
      <?php if($this->show_search):
        if(defined('sesadvancedsearch')){
            echo $this->content()->renderWidget("advancedsearch.search");
        }else{
            echo $this->content()->renderWidget("sesatoz.search");
        }
        ?>
      <?php endif; ?>  
    </div>
    <?php if($this->show_mini):?>
      <div class="header_minimenu">
        <?php echo $this->content()->renderWidget("sesatoz.menu-mini"); ?>
      </div>
    <?php endif; ?>
  </div>
</div>
<?php if($this->show_menu):?>
	<div class="header_main_menu clearfix" id="sesatoz_main_menu">
    <div class="header_main_menu_container">
       <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesmenu')) { ?>
        <?php echo $this->content()->renderWidget("sesmenu.main-menu"); ?>
      <?php } else { ?>
        <?php echo $this->content()->renderWidget("sesatoz.menu-main"); ?>
      <?php } ?>
    </div>
	</div>
<?php endif; ?>
<script>
	jqueryObjectOfSes(document).ready(function(e){
	var height = jqueryObjectOfSes('.layout_page_header').height();
		if($('global_wrapper')) {
	    $('global_wrapper').setStyle('margin-top', height+"px");
	  }
	});
</script>
<script type="text/javascript">
  sesJqueryObject(document).on('click','#mobile_search_toggle',function(){
    if(sesJqueryObject (this).hasClass('active')){
     sesJqueryObject (this).removeClass('active');
     sesJqueryObject ('.minimenu_search_box').removeClass('open_search');
    }else{
     sesJqueryObject (this).addClass('active');
     sesJqueryObject ('.minimenu_search_box').addClass('open_search');
    }
 });
    	
<?php if($this->show_menu && (Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2) == 2)){ ?>
	sesJqueryObject ("body").addClass('sidebar-panel-enable');
<?php } ?>

//Clear cache when admin choose Always show up from drop down.
sesJqueryObject(window).ready(function(e) {
  <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.header.design', 2) == 2 && (Engine_Api::_()->sesatoz()->getContantValueXML('sesatoz_sidepanel_effect')) == 2 && Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.sidepanel.showhide', 1) == 1){ ?>
    setCookiePannel('sesatoz','1','30');
  <?php } ?>
});
</script>
<script src="application/modules/Sesatoz/externals/scripts/wow.min.js" type="text/javascript"></script>
<script>
var wow = new WOW ({
	offset:       75,          // distance to the element when triggering the animation (default is 0)
	mobile:       false,       // trigger animations on mobile devices (default is true)
});
wow.init();
</script>
