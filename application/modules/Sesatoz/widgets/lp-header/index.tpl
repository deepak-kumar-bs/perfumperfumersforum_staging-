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
<style>
   #global_header{
		   display:none !important;
		}
		.sidebar-panel-enable #global_wrapper, .sidebar-panel-enable #global_footer{
			 margin-left:0 !important;
		}
</style>
<div class="sesatoz_lp_header">
  <div class="sesatoz_lp_header_inner">
     <?php $countMenu = 0; ?>
     <?php if($this->show_menu) { ?>
<a class="atoz_mobile_nav_toggle" id="atoz_mobile_nav_toggle" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
<div class="sesatoz_mobile_nav sesatoz_main_menu" id="atoz_mobile_nav">
	<ul class="navigation">
    <?php foreach( $this->navigation as $navigationMenu ): ?>
      <?php $class = explode(' ', $navigationMenu->class); ?>
    	<?php $mainMenuIcon = Engine_Api::_()->sesatoz()->getMenuIcon(end($class));?>
      <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
        <?php if(end($class) == 'core_main_invite'):?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
        <?php elseif(end($class) == 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
        <?php else:?>
          <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
        <?php endif;?>
          <?php if(!empty($mainMenuIcon)):?>
            <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
          <?php endif;?>
          <span><?php echo $this->translate($navigationMenu->label); ?></span>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php } ?>
<?php if($this->show_logo):?>
      <div class="header_logo">
        <?php echo $this->content()->renderWidget('sesatoz.menu-logo'); ?>
      </div>
     <?php endif; ?>
      <div class="sesatoz_lp_main_menu">
        <?php if($this->show_menu) { ?>
        <div class="sesatoz_main_menu">
          <ul class="navigation">
      <?php foreach( $this->navigation as $navigationMenu ):
      $explodedString = explode(' ', $navigationMenu->class);
        ?>
        <?php if( $countMenu < $this->max ): ?>
          <?php $mainMenuIcon = Engine_Api::_()->sesatoz()->getMenuIcon(end($explodedString));?>
          <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?>>
            <?php if(end($explodedString)== 'core_main_invite'):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('module' => 'invite'), $navigationMenu->route, true) ?>'>
            <?php elseif(end($explodedString)== 'core_main_home' && ($this->viewer->getIdentity() != 0)):?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo $this->url(array('action' => 'home'), $navigationMenu->route, true) ?>'>
            <?php else:?>
              <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
            <?php endif;?>
              <?php if(!empty($mainMenuIcon)):?>
                <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
              <?php endif;?>
              <span><?php echo $this->translate($navigationMenu->label); ?></span>
            </a>
              <?php 
                
                $menuName = end($explodedString); 
                $moduleName = str_replace('core_main_', '', $menuName);
              ?>
             <?php $subMenus = Engine_Api::_()->getApi('menus', 'core')->getNavigation($moduleName.'_main'); 
                $menuSubArray = $subMenus->toArray();
             ?>
            <?php if(count($subMenus) > 0 && $this->submenu): ?>
              <ul class="main_menu_submenu">
                <?php 
                $counter = 0; 
                foreach( $subMenus as $subMenu): 
                $active = isset($menuSubArray[$counter]['active']) ? $menuSubArray[$counter]['active'] : 0;
                ?>
                  <li class="sesbasic_clearfix <?php echo ($active) ? 'selected_sub_main_menu' : '' ?>">
                      <a href="<?php echo $subMenu->getHref(); ?>" class="<?php echo $subMenu->getClass(); ?>">
                      <?php if($this->show_menu_icon):?><i class="fa fa-angle-right"></i><?php endif;?><span><?php echo $this->translate($subMenu->getLabel()); ?></span>
                    </a>
                  </li>
                <?php 
                $counter++;
                endforeach; ?>
              </ul>
            <?php endif; ?>
            
          </li>
        <?php else:?>
          <?php break;?>
        <?php endif;?>
        <?php $countMenu++;?>
      <?php endforeach; ?>
      <?php if (count($this->navigation) > $this->max):?>
      <?php $countMenu = 0; ?>  
      <li class="more_tab">
        <a class="menu_core_main core_menu_more" href="javascript:void(0);">
          <span><?php echo $this->translate($this->moretext);?> + </span>
        </a>
        <ul class="main_menu_submenu">
          <?php foreach( $this->navigation as  $navigationMenu ): 
          $explodedString = explode(' ', $navigationMenu->class);
          ?>
            <?php $mainMenuIcon = Engine_Api::_()->sesatoz()->getMenuIcon(end($explodedString));?>
            <?php if ($countMenu >= $this->max): ?>
              <li <?php if ($navigationMenu->active): ?><?php echo "class='active'";?><?php endif; ?> >
                <a class= "<?php echo $navigationMenu->class ?>" href='<?php echo empty($navigationMenu->uri) ? $this->url(array(), $navigationMenu->route, true) : $navigationMenu->uri ?>'>
                  <?php if(!empty($mainMenuIcon)):?>
                    <i class="menuicon" style="background-image:url(<?php echo $this->storage->get($mainMenuIcon, '')->getPhotoUrl(); ?>);"></i>
                  <?php endif;?>
                  <span><?php echo $this->translate($navigationMenu->label); ?></span>
                </a>
              </li>
            <?php endif;?>
            <?php $countMenu++;?>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php endif;?>
  </ul>
</div>
<script>
$('atoz_mobile_nav_toggle').addEvent('click', function(event){
	event.stop();
	if($('atoz_mobile_nav').hasClass('show-nav'))
		$('atoz_mobile_nav').removeClass('show-nav');
	else
		$('atoz_mobile_nav').addClass('show-nav');
	return false;
});
</script>
<?php } ?>
        <div class="minimenu_search_box" id="minimenu_search_box">
      <?php if($this->show_search):?>
            <?php
              if(defined('sesadvancedsearch')){
                echo $this->content()->renderWidget("advancedsearch.search");
            }else{
            echo $this->content()->renderWidget("sessocialtube.search");
            }
            ?>
      <?php endif; ?>  
       </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
sesJqueryObject(document).ready(function(){
	 sesJqueryObject("#atoz_mobile_nav_toggle").click(function(){
        sesJqueryObject("#atoz_mobile_nav").toggleClass("show-nav");
    });
   sesJqueryObject(".header_searchbox button").click(function(){
        sesJqueryObject(".header_searchbox input").toggleClass("input-show");
    });
});
</script>
<script type="text/javascript">
sesJqueryObject(window).scroll(function() {    
    var scroll =sesJqueryObject(window).scrollTop();    
    if (scroll >= 100) {
        sesJqueryObject(".sesatoz_lp_header").addClass("darkHeader");
    }
		else {
			sesJqueryObject(".sesatoz_lp_header").removeClass("darkHeader");
		}
});
</script>
<script type="text/javascript">
 sesJqueryObject(document).ready(function(){
     sesJqueryObject(".atoz_mobile_nav_toggle").click(function(){
        sesJqueryObject(".sesatoz_mobile_nav").toggleClass("show-nav");
    });
});
</script>
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

