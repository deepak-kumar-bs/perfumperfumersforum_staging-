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
  $(document).getElement('body').addClass('global_sitecoretheme_header_body_wapper');
</script>
<?php
$isSiteadvsearchEnable = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('siteadvsearch');
$viewerId = $this->viewer()->getIdentity();

$displayWidgets = $this->displayWidgets;
?>
<?php if( in_array('search_box', $displayWidgets) ) : ?>
  <?php
  $this->headScript()
    ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
    ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
    ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
    ->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js');
  ?>
<?php endif; ?>
<?php if( $this->headerStyle !=2 || $this->menuPosition == 2): ?>
  <div class="sitecoretheme_top_header sitecoretheme_top_header_one" id="sitecoretheme_top_header_wrapper">
      <?php if(in_array('sociallink', $displayWidgets) ) : ?>
        <div class="sitecoretheme_social-sites">
          <?php echo $this->content()->renderWidget("sitecoretheme.menu-social-sites", array()); ?>
        </div>
      <?php endif; ?>
    <div class="sitecoretheme_top_header_container">
      <?php if( $this->menuPosition == 2 && $this->showMenu && in_array('main_menu', $displayWidgets) && empty($this->menuParams) ): ?>
        <div class="_main_menu_toggle_wapper <?php if( $this->settings('sitecoretheme.header.menu.style', 'slide') == 'slide' && $this->settings('sitecoretheme.header.menu.alwaysOpen', '0') ): ?> _main_menu_toggle_hide <?php endif; ?>" >
          <a class="sitecoretheme_main_menu_toggle _main_menu_toggle" href="javascript:void(0);"><i></i></a>
        </div>
      <?php endif; ?>
      <?php if( in_array('logo', $displayWidgets) ) : ?>
        <div class="sitecoretheme_logo">
          <?php echo $this->content()->renderWidget("core.menu-logo", $this->logoParams); ?>
					<?php echo $this->content()->renderWidget("core.menu-logo", $this->alternateLogoParams); ?>
        </div>
      <?php endif; ?>

      <?php if( $this->menuPosition != 2 && $this->showMenu && in_array('main_menu', $displayWidgets) && $this->headerStyle ==1 ): ?>
        <div class="sitecoretheme_mainmenu">
          <?php echo $this->content()->renderWidget("sitecoretheme.browse-menu-main", array()); ?>
        </div>
      <?php endif; ?>

      <?php if( in_array('search_box', $displayWidgets) ) : ?>
        <div class="sitecoretheme_search">
          <button id="responsive_search_toggle" class="responsive_search_toggle"><i class="fa fa-search"></i></button>
          <div id="sitecoretheme_fullsite_search" class="sitecoretheme_fullsite_search">
            <?php if( !empty($isSiteadvsearchEnable) ) : ?>
              <?php echo $this->content()->renderWidget("siteadvsearch.search-box", array("widgetName" => "advmenu_mini_menu",)); ?>
            <?php else: ?>
              <form action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get"  >
                <input name='query' id='global_search_field' type="text" placeholder="<?php echo $this->translate("Search here...") ?>"/>
                <button><i class="fa fa-search"></i></button>
              </form>
            <?php endif; ?>
          </div>

        </div>
      <?php endif; ?>

      <?php if( in_array('mini_menu', $displayWidgets) ) : ?>
        <div class="sitecoretheme_minimenu">
            <?php echo $this->content()->renderWidget($this->isSitemenuEnable && $this->settings('sitecoretheme.header.siteminimenu.enable', 1) ? "sitemenu.menu-mini" : "seaocore.menu-mini", $this->miniMenuParams); ?>
        </div>
      <?php endif; ?>
    <?php if( $this->menuPosition == 2 && $this->showMenu && in_array('main_menu', $displayWidgets) && empty($this->menuParams) ): ?>
      <div class="sitecoretheme_main_menu_pannel">
        <?php
        echo $this->content()->renderWidget("sitecoretheme.menu-main", array(
          'menuType' => $this->settings('sitecoretheme.header.menu.style', 'slide'),
          'alwaysOpen' => $this->settings('sitecoretheme.header.menu.alwaysOpen', '0'),
          'mobuleNavigations' => $this->settings('sitecoretheme.header.menu.submenu', 1),
          'menuIcons' => $this->settings('sitecoretheme.header.menu.icon', 1),
          'settingNavigations' => $this->settings('sitecoretheme.header.leftmenu.settingNavigations', 1),
          'footerSection' => $this->settings('sitecoretheme.header.leftmenu.footerSection', 1),
        ));
        ?>
      </div>
    <?php endif; ?>
    </div>
  </div>


  <?php if (in_array('main_menu', $displayWidgets) && !empty($this->menuParams) && (($this->headerStyle == 3 && $this->menuPosition == 1) || $this->menuPosition == 2) && $this->showMenu) : ?>
    <div class="sitecoretheme_mainmenu">
      <?php if( $this->menuPosition == 2 ) : ?>
        <?php echo $this->content()->renderWidget("sitemenu.vertical-menu-main", $this->menuParams); ?>
      <?php else: ?>
        <?php echo $this->content()->renderWidget("sitemenu.menu-main", $this->menuParams); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php elseif( $this->headerStyle == 2): ?>
  <div class="sitecoretheme_top_header_two" id="sitecoretheme_top_header_wrapper">
    <div class="_static_top_header sitecoretheme_top_header_container">
      <div class="_top">
        <?php if(in_array('sociallink', $displayWidgets) ) : ?>
        <div class="sitecoretheme_social-sites">
        <?php echo $this->content()->renderWidget("sitecoretheme.menu-social-sites", array()); ?>
        </div>
         <?php endif; ?>
        <?php if( in_array('search_box', $displayWidgets) ) : ?>
          <div class="sitecoretheme_search">
            <div id="sitecoretheme_fullsite_search" class="sitecoretheme_fullsite_search">
              <?php if( !empty($isSiteadvsearchEnable) ) : ?>
                <?php echo $this->content()->renderWidget("siteadvsearch.search-box", array("widgetName" => "advmenu_mini_menu",)); ?>
              <?php else: ?>
                <form action="<?php echo $this->url(array('controller' => 'search'), 'default', true) ?>" method="get"  >
                  <input name='query' id='global_search_field' type="text" placeholder="<?php echo $this->translate("Search here...") ?>"/>
                  <button><i class="fa fa-search"></i></button>
                </form>
              <?php endif; ?>
            </div>

          </div>
        <?php endif; ?>
        <?php if( in_array('mini_menu', $displayWidgets) ) : ?>
          <div class="sitecoretheme_minimenu">
              <?php echo $this->content()->renderWidget($this->isSitemenuEnable && $this->settings('sitecoretheme.header.siteminimenu.enable', 1) ? "sitemenu.menu-mini" : "seaocore.menu-mini", $this->miniMenuParams); ?>
          </div>
        <?php endif; ?>
      </div>
        <?php
        $menusContent = in_array('main_menu', $displayWidgets) && $this->showMenu ? $this->content()->renderWidget("sitecoretheme.browse-menu-main", array(
          'mobuleNavigations' => $this->settings('sitecoretheme.header.menu.submenu', 1),
          'menuIcons' => $this->settings('sitecoretheme.header.menu.icon', 1)
        )) : '';
        ?>
      <div class="_bottom">
        <div class="_bottom_content">
          <?php if( in_array('logo', $displayWidgets) ) : ?>
            <div class="sitecoretheme_logo">
              <?php echo $this->content()->renderWidget("core.menu-logo", $this->logoParams); ?>
							<?php echo $this->content()->renderWidget("core.menu-logo", $this->alternateLogoParams); ?>
            </div>
          <?php endif; ?>
        <div class="_mobile_menu_options">
            <?php if( in_array('search_box', $displayWidgets) ) : ?>
            <button id="responsive_search_toggle" class="responsive_search_toggle"><i class="fa fa-search"></i></button>
            <?php endif; ?>
          <?php if( in_array('main_menu', $displayWidgets) && $this->showMenu ) : ?>
            <a class="_mobile_toggle_icon" href="javascript:void(0);" ><i class="fa fa-bars"></i></a>
          <?php endif; ?>
        </div>
        <?php if( $menusContent ) : ?>
          <div class="sitecoretheme_mainmenu">
              <?php echo $menusContent; ?>
          </div>
        <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="_fix_top_header">
      <div class="_fix_top_content">
        <?php if( in_array('logo', $displayWidgets) ) : ?>
          <div class="sitecoretheme_logo">
            <?php echo $this->content()->renderWidget("core.menu-logo", $this->logoParams); ?>
						<?php echo $this->content()->renderWidget("core.menu-logo", $this->alternateLogoParams); ?>
          </div>
        <?php endif; ?>
        <div class="_mobile_menu_options">
          <?php if( in_array('main_menu', $displayWidgets) &&  $this->showMenu ) : ?>
            <a class="_mobile_toggle_icon" href="javascript:void(0);" ><i class="fa fa-bars"></i></a>
          <?php endif; ?>
        </div>
        <?php if( in_array('main_menu', $displayWidgets) &&  $this->showMenu ) : ?>
          <div class="sitecoretheme_mainmenu">
            <?php echo $menusContent; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <div class="_background_overlay"></div>
    <?php if( in_array('main_menu', $displayWidgets) && $this->showMenu ) : ?>
    <div class="_mobile_main_menu_content">
        <?php echo $menusContent; ?>
      </div>
    </div>
    <script>
      en4.core.runonce.add(function() {
        $$('.sitecoretheme_top_header_two ._mobile_main_menu_content .layout_sitecoretheme_browse_menu_main .sitecoretheme_main_menu .navigation > li.more_link').each(function(el) {
          el.getElements('.sitecoretheme_submenu > li').inject(el.getParent('ul'));
          el.destroy();
        });
     /* $$('.sitecoretheme_top_header_two .layout_sitecoretheme_browse_menu_main .sitecoretheme_main_menu .navigation > li.more_link .sitecoretheme_submenu') */
      $$('.sitecoretheme_top_header_two ._mobile_toggle_icon').addEvent('click', function() {
        $$('.sitecoretheme_top_header_two').toggleClass('_mobile_active');
        });
      });
        </script>
    <?php endif; ?>
  </div>
<style type="text/css">
  .layout_page_header.<?php echo $this->headerClass ?> {
    background-color: transparent;
  }
  </style>
<?php endif; ?>
  <?php if( !empty($this->signupLoginPopup) ): ?>
    <?php echo $this->content()->renderWidget("seaocore.login-or-signup-popup", array(
      'popupVisibilty' => $this->popupVisibilty,
      'allowClose' => $this->popupClosable,
      'autoOpenLogin' => $this->autoShowPopup == 1,
      'autoOpenSignup' => $this->autoShowPopup == 2
    )); ?>
  <?php endif; ?>
<script type="text/javascript">
  var headerHeight = $('sitecoretheme_top_header_wrapper').getSize().y;
<?php if( $this->fixedMenu && !(($this->menuPosition == 2 && $this->isSitemenuEnable))): ?>
    en4.core.runonce.add(function () {
      var headerElement = $$('.layout_page_header');
      if (headerElement.length === 0) {
        return;
      }
      headerElement = headerElement[0];
      function headerScrolling() {
        var height = headerElement.getCoordinates().height;
        <?php if($this->menuPosition == 2): ?>
        headerElement.getParent().setStyle('minHeight', height+'px');
        if ( !headerElement.hasClass('<?php echo $this->headerClass ?>')) {
          headerElement.addClass('<?php echo $this->headerClass ?>');          
        }
        <?php else: ?>
        var scrollTop = window.getScrollTop();
        if (scrollTop > height*1.2 && !headerElement.hasClass('<?php echo $this->headerClass ?>')) {
          headerElement.getParent().setStyle('minHeight', height+'px');
          headerElement.addClass('<?php echo $this->headerClass ?>');          
        } else if (scrollTop < height && headerElement.hasClass('<?php echo $this->headerClass ?>')) {
          headerElement.removeClass('<?php echo $this->headerClass ?>');
          headerElement.getParent().setStyle('minHeight');
        }
        if (!headerElement.hasClass('<?php echo $this->headerClass ?>')) {
          headerElement.setStyle('top', '-'+scrollTop+'px');
        }else {
          headerElement.setStyle('top');
        }
        <?php endif; ?>
      }
      window.addEvent('scroll', headerScrolling);
    });
<?php endif; ?>
<?php if( in_array('search_box', $displayWidgets) ) : ?>
    $$('.responsive_search_toggle').addEvent('click', function () {
      if (!$('sitecoretheme_fullsite_search').hasClass('responsive_search_show')) {
        $('sitecoretheme_fullsite_search').addClass('responsive_search_show');
      } else {
        $('sitecoretheme_fullsite_search').removeClass('responsive_search_show');
      }
    });
<?php endif; ?>
<?php if( in_array('search_box', $displayWidgets) ) : ?>
    var requestURL = '<?php echo $this->url(array('module' => 'sitecoretheme', 'controller' => 'general', 'action' => 'get-search-content'), "default", true) ?>';
    if($('global_search_field')) {
      contentAutocomplete = new Autocompleter.Request.JSON('global_search_field', requestURL, {
        'postVar': 'text',
        'cache': false,
        'minLength': 1,
        'selectFirst': false,
        'selectMode': 'pick',
        'autocompleteType': 'tag',
        'className': 'tag-autosuggest adsearch-autosuggest adsearch-stoprequest',
        'maxChoices': 8,
        'indicatorClass': 'vertical-search-loading',
        'customChoices': true,
        'filterSubset': true,
        'multiple': false,
        'injectChoice': function (token) {
          if (typeof token.label != 'undefined') {
            var seeMoreText = '<?php echo $this->string()->escapeJavascript($this->translate('See more results for') . ' '); ?>';
            if (token.type == 'no_resuld_found') {
              var choice = new Element('li', {'class': 'autocompleter-choices', 'id': 'sitecoretheme_search_' + token.type});
              new Element('div', {'html': token.label, 'class': 'autocompleter-choicess'}).inject(choice);
              choice.inject(this.choices);
              choice.store('autocompleteChoice', token);
              return;
            }
            if (token.item_url != 'seeMoreLink') {
              var choice = new Element('li', {'class': 'autocompleter-choices', 'html': token.photo, 'item_url': token.item_url, onclick: 'javascript: showSearchResultPage("' + token.item_url + '")'});
              var divEl = new Element('div', {
                'html': token.type ? this.options.markQueryValueCustom.call(this, (token.label)) : token.label,
                'class': 'autocompleter-choice'
              });

              new Element('div', {
                'html': token.type, //this.markQueryValue(token.type)  
                'class': 'seaocore_txt_light f_small'
              }).inject(divEl);

              divEl.inject(choice);
              new Element('input', {
                'type': 'hidden',
                'value': JSON.encode(token)
              }).inject(choice);
              this.addChoiceEvents(choice).inject(this.choices);
              choice.store('autocompleteChoice', token);
            }
            if (token.item_url == 'seeMoreLink') {
              var titleAjax1 = encodeURIComponent($('global_search_field').value);
              var choice = new Element('li', {'class': 'autocompleter-choices', 'html': '', 'id': 'stopevent', 'item_url': ''});
              new Element('div', {'html': seeMoreText + '"' + titleAjax1 + '"', 'class': 'autocompleter-choicess', onclick: 'javascript:seeMoreSearchResults()'}).inject(choice);
              this.addChoiceEvents(choice).inject(this.choices);
              choice.store('autocompleteChoice', token);
            }
          }
        },
        markQueryValueCustom: function (str) {
          return (!this.options.markQuery || !this.queryValue) ? str
            : str.replace(new RegExp('(' + ((this.options.filterSubset) ? '' : '^') + this.queryValue.escapeRegExp() + ')', (this.options.filterCase) ? '' : 'i'), '<b>$1</b>');
        },
      });
    }
    function showSearchResultPage(url) {
      window.location.href = url;
    }
    function seeMoreSearchResults() {

      $('stopevent').removeEvents('click');
      var url = '<?php echo $this->url(array('controller' => 'search'), 'default', true); ?>' + '?query=' + encodeURIComponent($('global_search_field').value) + '&type=' + 'all';
      window.location.href = url;
    }
    $('global_search_field').addEvent('keydown', function (event) {
      if (event.key == 'enter') {
        $('sitecoretheme_fullsite_search').submit();
      }
    });
<?php endif; ?>
</script>