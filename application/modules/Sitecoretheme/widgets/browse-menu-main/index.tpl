<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
 ?>
<script type="text/javascript">
  function toggleNavigation(obj) {

    navigation = obj.getNext('ul');
    if (navigation.style.display == 'block') {
      navigation.style.display = 'none';
      obj.removeClass('menu_icon_active');
    } else {
      navigation.style.display = 'block';
      obj.addClass('menu_icon_active');
    }
    return false;
  }
</script>
<div class="sitecoretheme_main_menu">
  <?php $key = 0; ?>
  <a class="menu_icon" href="javascript:void(0);" onclick="return toggleNavigation(this)"><i class="fas fa-bars"></i></a>
  <i class="fa fa-caret-up"></i>
  <ul class='navigation'>
    <?php foreach( $this->browsenavigation as $nav ): ?>       
        <?php if( isset($nav->show_to_guest) && empty($nav->show_to_guest) && !$this->viewer()->getIdentity() ): ?>
          <?php continue; ?>
        <?php endif; ?>
        <?php if( $key >= $this->max ): ?>
          <?php break; ?>
        <?php endif; ?>
        <?php $key++ ?>
        <?php $class = array(); ?>
        <?php if( $nav->active ): $class[] ='active'; endif;?> 
        <?php if( $nav->hasChildren() ): $class[] ='_main_menu_parent'; endif;?> 
        <li class="<?php echo join(' ', $class)?>">          
            <?php if( $nav->action ): ?>
          <a class= "<?php echo $nav->class ?>" href='<?php echo empty($nav->uri) ? $this->url(array('action' => $nav->action), $nav->route, true) : $nav->uri ?>' <?php if(!empty($nav->target)):?>target="_blank" <?php endif; ?>><span>
            <?php if($this->menuIcons && $nav->icon): ?>
             <i <?php echo (Zend_Uri::check($nav->icon)) ? 'style="background-image:url(' . $nav->icon . ')"' : 'class="fa ' . $nav->icon . '"' ?>></i>
            <?php endif; ?>
              <?php echo $this->translate($nav->label); ?></span></a>
          <?php else : ?>
            <a class= "<?php echo $nav->class ?>" href='<?php echo $nav->getHref() ?>' <?php if(!empty($nav->target)):?>target="_blank" <?php endif; ?>><span>
              <?php if($this->menuIcons && $nav->icon): ?>
               <i <?php echo (Zend_Uri::check($nav->icon)) ? 'style="background-image:url(' . $nav->icon . ')"' : 'class="fa ' . $nav->icon . '"' ?>></i>
              <?php endif; ?>
                <?php echo $this->translate($nav->label); ?></span></a>
          <?php endif; ?>
          <?php if( $nav->hasChildren() ): ?>
            <i class="fa fa-chevron-down sub_navigation_toggle" onclick="toogle_sub_main_menus(this)"></i>
            <?php
            echo $this->navigation()
              ->menu()
              ->renderMenu($nav, array('ulClass' => 'sub_navigation'));
            ?>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    <?php if( count($this->browsenavigation) > $this->max ): ?>
        <li class="more_link sitecoretheme_more_link"  onclick="navigation_more_toggle(this)">
        <span></span>
        <span></span>
        <span></span>
        <a href="javascript:void(0)" class="sitecoretheme_more_link_text"><span><?php echo $this->translate('More +'); ?></span></a>
        <i class="fa fa-caret-up"></i>
        <ul class="sitecoretheme_submenu">
          <?php $key = 0; ?>
          <?php foreach( $this->browsenavigation as $nav ): ?>            
            <?php if( isset($nav->show_to_guest) && empty($nav->show_to_guest) && !$this->viewer()->getIdentity() ): ?>
              <?php continue; ?>
            <?php endif; ?>
              <?php if( $key >= $this->max ): ?>
                <?php $class = array(); ?>
                <?php if( $nav->active ): $class[] ='active'; endif;?> 
                <?php if( $nav->hasChildren() ): $class[] ='_main_menu_parent'; endif;?> 
                <li class="<?php echo join(' ', $class)?>">
                    <?php if( $nav->action ): ?>
                    <a class= "<?php echo $nav->class ?>" href='<?php echo empty($nav->uri) ? $this->url(array('action' => $nav->action), $nav->route, true) : $nav->uri ?>' <?php if(!empty($nav->target)):?>target="_blank" <?php endif; ?>>
                      <span>
                      <?php if($this->menuIcons && $nav->icon): ?>
                        <i <?php echo (Zend_Uri::check($nav->icon)) ? 'style="background-image:url(' . $nav->icon . ')"' : 'class="fa ' . $nav->icon . '"' ?>></i>
                      <?php endif; ?>
                      <?php echo $this->translate($nav->label); ?></span>
                    </a>
                  <?php else : ?>
                    <a class= "<?php echo $nav->class ?>" href='<?php echo $nav->getHref() ?>' <?php if(!empty($nav->target)):?>target="_blank" <?php endif; ?>>        
                      <span>
                      <?php if($this->menuIcons && $nav->icon): ?>
                        <i <?php echo (Zend_Uri::check($nav->icon)) ? 'style="background-image:url(' . $nav->icon . ')"' : 'class="fa ' . $nav->icon . '"' ?>></i>
                      <?php endif; ?>
                      <?php echo $this->translate($nav->label); ?></span></a>
                  <?php endif; ?>
                  <?php if( $nav->hasChildren() ): ?>
                    <i class="fa fa-chevron-down sub_navigation_toggle" onclick="toogle_sub_main_menus(this)"></i>
                  <?php
                  echo $this->navigation()
                    ->menu()
                    ->renderMenu($nav, array('ulClass' => 'sub_navigation'));
                  ?>
                  <?php endif; ?>
                </li>
              <?php endif; ?>
              <?php $key++ ?>
          <?php endforeach; ?>
        </ul>
      </li>
    <?php endif; ?>
  </ul>
</div>

<style type="text/css">
  .layout_sitecoretheme_browse_menu_main > h3  {
    display:none;
  }
  /*.sitecoretheme_top_header_two .layout_sitecoretheme_browse_menu_main .sitecoretheme_main_menu .navigation > li.more_link .sitecoretheme_submenu._more_lines > li {
    float: left;
  }*/
</style>

<script type="text/javascript">
var navigation_more_toogle_set_width = function() {
    $$('.sitecoretheme_top_header_two .layout_sitecoretheme_browse_menu_main .sitecoretheme_main_menu .navigation > li.more_link .sitecoretheme_submenu').each(function(el) {
      var coords = el.getCoordinates();
      var diff = window.getSize().x - coords.right;
      if (el.getCoordinates().width == 0) {
        return;
      }
      if((el.getCoordinates().width + diff*2) > window.getSize().x) {
        el.setStyle('width', (window.getSize().x - (diff*2))+'px');
        el.addClass('_more_lines');
      }
    });
};
$$('.sitecoretheme_main_menu .navigation .sitecoretheme_more_link').addEvent('mouseover', navigation_more_toogle_set_width);
var navigation_more_toggle = function (el) {
    $$('.sitecoretheme_main_menu .navigation .sitecoretheme_more_link').toggleClass('sitecoretheme_submenu_active');
    navigation_more_toogle_set_width();
};
var toogle_sub_main_menus = function(el) {  
  !el.getParent('li').hasClass('_show_sub_nav') ? el.getParent('li').addClass('_show_sub_nav') : el.getParent('li').removeClass('_show_sub_nav');
}
</script>