<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: styling.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php $settings = Engine_Api::_()->getApi('settings', 'core');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jscolor/jscolor.js');
$this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesbasic/externals/scripts/jquery.min.js');
?>

<script>
hashSign = '#';
</script>
<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>
<div class='clear'>
  <div class='settings sescore_admin_form sesatoz_themes_form'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>
<script>

  window.addEvent('domready', function() {
    changeThemeColor("<?php echo Engine_Api::_()->sesatoz()->getContantValueXML('theme_color'); ?>", '');
  });
  
  function changeCustomThemeColor(value) {

    if(value > 13) {
      var URL = en4.core.staticBaseUrl+'sesatoz/admin-settings/getcustomthemecolors/';
      (new Request.HTML({
          method: 'post',
          'url': URL ,
          'data': {
            format: 'html',
            customtheme_id: value,
          },
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          
            var customthevalyearray = jqueryObjectOfSes.parseJSON(responseHTML);
            
            for(i=0;i<customthevalyearray.length;i++){
              var splitValue = customthevalyearray[i].split('||');
              jqueryObjectOfSes('#'+splitValue[0]).val(splitValue[1]);
              if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor')){
                if(splitValue[1] == ""){
                  splitValue[1] = "#FFFFFF";  
                }
              try{
                document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
              }catch(err) {
                document.getElementById(splitValue[0]).value = "#FFFFFF";
              }
              }
            }
          
          
//           var customthevalyearray = jqueryObjectOfSes.parseJSON(responseHTML);
//           
//           for(i=0;i<customthevalyearray.length;i++){
//             var splitValue = customthevalyearray[i].split('||');
//             jqueryObjectOfSes('#'+splitValue[0]).val(splitValue[1]);
//             if(jqueryObjectOfSes('#'+splitValue[0]).hasClass('SEScolor'))
//             document.getElementById(splitValue[0]).color.fromString('#'+splitValue[1]);
//           }
        }
      })).send();
    }
    changeThemeColor(value, 'custom');
  }

	function changeThemeColor(value, custom) {

	  if(custom == '' && (value == 1 || value == 2 || value == 3 || value == 4 || value == 6 || value == 7 || value == 8 || value == 9 || value == 10 || value == 11 || value == 12 || value == 13)) {
	    if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'none';
		  if($('header_settings-wrapper'))
				$('header_settings-wrapper').style.display = 'none';
	    if($('footer_settings-wrapper'))
				$('footer_settings-wrapper').style.display = 'none';
		  if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'none';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'none';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'none';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'none';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'none';
	    if($('custom_theme_color-wrapper'))
				$('custom_theme_color-wrapper').style.display = 'none';
      if($('custom_themes'))
				$('custom_themes').style.display = 'none';
      if($('edit_custom_themes'))
        $('edit_custom_themes').style.display = 'none';
      if($('delete_custom_themes'))
        $('delete_custom_themes').style.display = 'none';
      if($('deletedisabled_custom_themes'))
        $('deletedisabled_custom_themes').style.display = 'none';
      if($('submit'))
        $('submit').style.display = 'none';
	  } else if(custom == '' && value == 5) {
	    
	    if($('custom_theme_color-wrapper'))
				$('custom_theme_color-wrapper').style.display = 'block';
      if($('custom_themes'))
				$('custom_themes').style.display = 'block';
      <?php if($this->customtheme_id): ?>
        //value = '<?php //echo $this->customtheme_id; ?>';
        changeCustomThemeColor('<?php echo $this->customtheme_id; ?>');
      <?php else: ?>
        changeCustomThemeColor(5);
      <?php endif; ?>
		 // changeCustomThemeColor(5);
	  } else if(custom == 'custom') {
		  if($('common_settings-wrapper'))
				$('common_settings-wrapper').style.display = 'block';
		  if($('header_settings-wrapper'))
				$('header_settings-wrapper').style.display = 'block';
	    if($('footer_settings-wrapper'))
				$('footer_settings-wrapper').style.display = 'block';
			if($('body_settings-wrapper'))
				$('body_settings-wrapper').style.display = 'block';
		  if($('general_settings_group'))
			  $('general_settings_group').style.display = 'block';
			if($('header_settings_group'))
			  $('header_settings_group').style.display = 'block';
			if($('footer_settings_group'))
			  $('footer_settings_group').style.display = 'block';
			if($('body_settings_group'))
			  $('body_settings_group').style.display = 'block';
			  
      if($('custom_theme_color').value > 13) {
        if($('submit'))
          $('submit').style.display = 'inline-block';
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'block';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'block';

        <?php if(empty($this->customtheme_id)): ?>
          history.pushState(null, null, 'admin/sesatoz/settings/styling/customtheme_id/'+$('custom_theme_color').value);
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesatoz/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);

          jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesatoz/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          //window.location.href = 'admin/sesatoz/settings/styling/customtheme_id/'+$('custom_theme_color').value;
        <?php else: ?>
          jqueryObjectOfSes('#edit_custom_themes').attr('href', 'sesatoz/admin-settings/add-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          
          var activatedTheme = '<?php echo $this->activatedTheme; ?>';
          if(activatedTheme == $('custom_theme_color').value) {
            $('delete_custom_themes').style.display = 'none';
            $('deletedisabled_custom_themes').style.display = 'block';
          } else {
            if($('deletedisabled_custom_themes'))
              $('deletedisabled_custom_themes').style.display = 'none';
            jqueryObjectOfSes('#delete_custom_themes').attr('href', 'sesatoz/admin-settings/delete-custom-theme/customtheme_id/'+$('custom_theme_color').value);
          }
        <?php endif; ?>
      } else {
        if($('edit_custom_themes'))
          $('edit_custom_themes').style.display = 'none';
        if($('delete_custom_themes'))
          $('delete_custom_themes').style.display = 'none';
        if($('deletedisabled_custom_themes'))
          $('deletedisabled_custom_themes').style.display = 'none';
        if($('submit'))
          $('submit').style.display = 'none';
      }
	  }


		if(value == 1) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FFD11B';
				document.getElementById('sesatoz_theme_color').color.fromString('#FFD11B');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#191919';
				document.getElementById('sesatoz_font_color').color.fromString('#191919');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#191919';
				document.getElementById('sesatoz_heading_color').color.fromString('#191919');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#191919';
				document.getElementById('sesatoz_links_color').color.fromString('#191919');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FFD11B';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#191919';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#191919');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#191919';
				document.getElementById('sesatoz_form_label_color').color.fromString('#191919');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FFD11B';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#191919';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#191919');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#191919';
				document.getElementById('sesatoz_button_font_color').color.fromString('#191919');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FFD11B';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FFD11B';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#191919');
			}
			if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#F2C71A';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#F2C71A');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#5D5D5D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#5D5D5D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FFD11B';
			  document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFD11B';
			  document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#FFFFFF';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#FFFFFF');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#191919';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#191919');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#243238';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FFD11B';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FFD11B');
			}
			//Footer Styling
		} 
		else if(value == 2) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#fb0060';
				document.getElementById('sesatoz_theme_color').color.fromString('#fb0060');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#243238';
				document.getElementById('sesatoz_font_color').color.fromString('#243238');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#243238';
				document.getElementById('sesatoz_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#243238';
				document.getElementById('sesatoz_links_color').color.fromString('#243238');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#fb0060';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#fb0060');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#243238';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#243238');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#243238';
				document.getElementById('sesatoz_form_label_color').color.fromString('#243238');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#fb0060';
				document.getElementById('sesatoz_button_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#243238';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#ffffff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#ffffff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#fb0060';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#fb0060');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#fb0060';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
		 if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#D90053';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#D90053');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#5D5D5D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#5D5D5D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#fb0060';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#fb0060');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#ffffff';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#ffffff');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#fff');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#fb0060';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#fff';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#fff';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#fb0060';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#fb0060');
			}
			//Footer Styling
		} 
	else if(value == 3) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FF1D23';
				document.getElementById('sesatoz_theme_color').color.fromString('#FF1D23');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#243238';
				document.getElementById('sesatoz_font_color').color.fromString('#243238');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#243238';
				document.getElementById('sesatoz_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#243238';
				document.getElementById('sesatoz_links_color').color.fromString('#243238');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FF1D23';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#243238';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#243238');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#243238';
				document.getElementById('sesatoz_form_label_color').color.fromString('#243238');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FF1D23';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#243238';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#ffffff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#ffffff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FF1D23';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FF1D23';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
			 if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#EB1B20';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#EB1B20');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#5D5D5D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#5D5D5D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FF1D23';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#ffffff';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#ffffff');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#fff');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#FF1D23';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#fff';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#fff';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FF1D23';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FF1D23');
			}
			//Footer Styling
		} 
	else if(value == 4) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FF9800';
				document.getElementById('sesatoz_theme_color').color.fromString('#FF9800');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#243238';
				document.getElementById('sesatoz_font_color').color.fromString('#243238');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#243238';
				document.getElementById('sesatoz_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#243238';
				document.getElementById('sesatoz_links_color').color.fromString('#243238');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FF9800';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FF9800');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#243238';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#243238');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#243238';
				document.getElementById('sesatoz_form_label_color').color.fromString('#243238');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FF9800';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#243238';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#ffffff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#ffffff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FF9800';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FF9800');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FF9800';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
			 if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#E38700';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#E38700');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#5D5D5D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#5D5D5D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FF9800';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FF9800');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#ffffff';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#ffffff');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#fff');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#FF9800';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#fff';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#fff';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FF9800';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FF9800');
			}
			//Footer Styling
		} 
 		else if(value == 6) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#03A9F4';
				document.getElementById('sesatoz_theme_color').color.fromString('#03A9F4');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#243238';
				document.getElementById('sesatoz_font_color').color.fromString('#243238');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#243238';
				document.getElementById('sesatoz_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#243238';
				document.getElementById('sesatoz_links_color').color.fromString('#243238');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#03A9F4';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#243238';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#243238');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#243238';
				document.getElementById('sesatoz_form_label_color').color.fromString('#243238');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_button_background_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#243238';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#ffffff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#ffffff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#03A9F4';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#0396D9';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#0396D9');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#03A9F4';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#03A9F4';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#03A9F4';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#ffffff';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#ffffff');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#fff';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#fff';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#03A9F4';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#03A9F4');
			}
			//Footer Styling
		} 
    else if(value == 7) {
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#8BC34A';
				document.getElementById('sesatoz_theme_color').color.fromString('#8BC34A');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_body_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#243238';
				document.getElementById('sesatoz_font_color').color.fromString('#243238');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#999';
				document.getElementById('sesatoz_font_color_light').color.fromString('#999');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#243238';
				document.getElementById('sesatoz_heading_color').color.fromString('#243238');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#243238';
				document.getElementById('sesatoz_links_color').color.fromString('#243238');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#8BC34A';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#243238';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#243238');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_background_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#ebecee';
				document.getElementById('sesatoz_content_border_color').color.fromString('#ebecee');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#243238';
				document.getElementById('sesatoz_form_label_color').color.fromString('#243238');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#ffffff';
				document.getElementById('sesatoz_input_background_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#6D6D6D';
				document.getElementById('sesatoz_input_font_color').color.fromString('#6D6D6D');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#CACACA';
				document.getElementById('sesatoz_input_border_color').color.fromString('#CACACA');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_button_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#243238';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#243238');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#ffffff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#ffffff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#fdfdfd';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#fdfdfd');
			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#191919';
				document.getElementById('sesatoz_header_background_color').color.fromString('#191919');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#8BC34A';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
				if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#7AAB41';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#7AAB41');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#5D5D5D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#5D5D5D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#8BC34A';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#ffffff';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#ffffff');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#fff');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#ECEFF1';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#ECEFF1');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#fff';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#fff';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#fff');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#8BC34A';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#8BC34A');
			}
			//Footer Styling
		} 
    else if(value == 8) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FFD11B';
				document.getElementById('sesatoz_theme_color').color.fromString('#FFD11B');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FFD11B';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FFD11B';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#FFE11C';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#FFE11C');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#222428';
				document.getElementById('sesatoz_button_font_color').color.fromString('#222428');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FFD11B';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FFD11B';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#191919');
			}
			if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#F2C71A';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#F2C71A');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#FFD11B';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FFD11B';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#FFD11B';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#FFD11B');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FFD11B';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FFD11B');
			}
			//Footer Styling
				
    }
     else if(value == 9) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#fb0060';
				document.getElementById('sesatoz_theme_color').color.fromString('#fb0060');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#fb0060';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#fb0060');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#fb0060';
				document.getElementById('sesatoz_button_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#fb0060';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#fb0060');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#fff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#fff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#fb0060';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#fb0060');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#fb0060';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#fff';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#D90053';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#D90053');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#fb0060';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#fb0060');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#fb0060';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#fb0060');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#fb0060';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#fb0060');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#fb0060';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#fb0060');
			}
			
			//Footer Styling
				
    }
    else if(value == 10) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FF1D23';
				document.getElementById('sesatoz_theme_color').color.fromString('#FF1D23');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
			document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
			document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FF1D23';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
			document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FF1D23';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#FF1D23';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#FF1D23');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#fff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#fff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
			  document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FF1D23';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FF1D23';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#FFFFFF');
			}
				 if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#EB1B20';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#EB1B20');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#FF1D23';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FF1D23';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#FF1D23';
			document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#FF1D23');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
			document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
		     document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FF1D23';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FF1D23');
			}
			//Footer Styling
				
    }
		else if(value == 11) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#FF9800';
				document.getElementById('sesatoz_theme_color').color.fromString('#FF9800');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#FF9800';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#FF9800');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#FF9800';
				document.getElementById('sesatoz_button_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#FF9800';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#FF9800');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#FF9800';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#FF9800');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#FF9800';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			 if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#E38700';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#E38700');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#FF9800';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#FF9800');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#FF9800';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#FF9800');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#FF9800';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#FF9800');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#FF9800';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#FF9800');
			}
			//Footer Styling
				
    }
	  else if(value == 12) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#03A9F4';
				document.getElementById('sesatoz_theme_color').color.fromString('#03A9F4');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#03A9F4';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_button_background_color').color.fromString('#03A9F4');
			}
		if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#0396D9';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#0396D9');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_button_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#FFFFFF';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#03A9F4';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#03A9F4';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#03A9F4';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#03A9F4';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#03A9F4');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#03A9F4';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#03A9F4');
			}
			//Footer Styling
				
    }
		else if(value == 13) {
				
			//Theme Base Styling
			if($('sesatoz_theme_color')) {
				$('sesatoz_theme_color').value = '#8BC34A';
				document.getElementById('sesatoz_theme_color').color.fromString('#8BC34A');
			}
			//Theme Base Styling
			
			//Body Styling
			if($('sesatoz_body_background_color')) {
				$('sesatoz_body_background_color').value = '#111418';
				document.getElementById('sesatoz_body_background_color').color.fromString('#111418');
			}
			if($('sesatoz_font_color')) {
				$('sesatoz_font_color').value = '#f1f1f1';
				document.getElementById('sesatoz_font_color').color.fromString('#f1f1f1');
			}
			if($('sesatoz_font_color_light')) {
				$('sesatoz_font_color_light').value = '#ddd';
				document.getElementById('sesatoz_font_color_light').color.fromString('#ddd');
			}
			
			if($('sesatoz_heading_color')) {
				$('sesatoz_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_color')) {
				$('sesatoz_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_links_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_links_hover_color')) {
				$('sesatoz_links_hover_color').value = '#8BC34A';
				document.getElementById('sesatoz_links_hover_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_content_header_background_color')) {
				$('sesatoz_content_header_background_color').value = '#222428';
				document.getElementById('sesatoz_content_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_header_font_color')) {
				$('sesatoz_content_header_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_content_header_font_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_content_background_color')) {
				$('sesatoz_content_background_color').value = '#222428';
				document.getElementById('sesatoz_content_background_color').color.fromString('#222428');
			}
			if($('sesatoz_content_border_color')) {
				$('sesatoz_content_border_color').value = '#36383D';
				document.getElementById('sesatoz_content_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_form_label_color')) {
				$('sesatoz_form_label_color').value = '#ffffff';
				document.getElementById('sesatoz_form_label_color').color.fromString('#ffffff');
			}
			if($('sesatoz_input_background_color')) {
				$('sesatoz_input_background_color').value = '#222428';
				document.getElementById('sesatoz_input_background_color').color.fromString('#222428');
			}
			if($('sesatoz_input_font_color')) {
				$('sesatoz_input_font_color').value = '#fff';
				document.getElementById('sesatoz_input_font_color').color.fromString('#fff');
			}
			if($('sesatoz_input_border_color')) {
				$('sesatoz_input_border_color').value = '#36383D';
				document.getElementById('sesatoz_input_border_color').color.fromString('#36383D');
			}
			if($('sesatoz_button_background_color')) {
				$('sesatoz_button_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_button_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_button_background_color_hover')) {
				$('sesatoz_button_background_color_hover').value = '#8BC34A';
				document.getElementById('sesatoz_button_background_color_hover').color.fromString('#8BC34A');
			}
			if($('sesatoz_button_font_color')) {
				$('sesatoz_button_font_color').value = '#fff';
				document.getElementById('sesatoz_button_font_color').color.fromString('#fff');
			}
			if($('sesatoz_button_font_hover_color')) {
				$('sesatoz_button_font_hover_color').value = '#fff';
				document.getElementById('sesatoz_button_font_hover_color').color.fromString('#fff');
			}
			if($('sesatoz_comment_background_color')) {
				$('sesatoz_comment_background_color').value = '#1E1F23';
				document.getElementById('sesatoz_comment_background_color').color.fromString('#1E1F23');

			}
			//Body Styling
			
			//Header Styling
			if($('sesatoz_header_background_color')) {
				$('sesatoz_header_background_color').value = '#222428';
				document.getElementById('sesatoz_header_background_color').color.fromString('#222428');
			}
			if($('sesatoz_menu_logo_font_color')) {
				$('sesatoz_menu_logo_font_color').value = '#8BC34A';
				document.getElementById('sesatoz_menu_logo_font_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_mainmenu_background_color')) {
				$('sesatoz_mainmenu_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_mainmenu_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_mainmenu_links_color')) {
				$('sesatoz_mainmenu_links_color').value = '#FFFFFF';
				document.getElementById('sesatoz_mainmenu_links_color').color.fromString('#FFFFFF');
			}
					if($('sesatoz_mainmenu_links_background_color_hover')) {
				$('sesatoz_mainmenu_links_background_color_hover').value = '#7AAB41';
				document.getElementById('sesatoz_mainmenu_links_background_color_hover').color.fromString('#7AAB41');
			}
			if($('sesatoz_mainmenu_links_hover_color')) {
				$('sesatoz_mainmenu_links_hover_color').value = '#191919';
				document.getElementById('sesatoz_mainmenu_links_hover_color').color.fromString('#191919');
			}
			if($('sesatoz_minimenu_links_color')) {
				$('sesatoz_minimenu_links_color').value = '#fff';
				document.getElementById('sesatoz_minimenu_links_color').color.fromString('#fff');
			}
			if($('sesatoz_minimenu_links_hover_color')) {
				$('sesatoz_minimenu_links_hover_color').value = '#8BC34A';
				document.getElementById('sesatoz_minimenu_links_hover_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_minimenu_icon_background_color')) {
				$('sesatoz_minimenu_icon_background_color').value = '#36383D';
				document.getElementById('sesatoz_minimenu_icon_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_minimenu_icon_background_active_color')) {
				$('sesatoz_minimenu_icon_background_active_color').value = '#8BC34A';
				document.getElementById('sesatoz_minimenu_icon_background_active_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_minimenu_icon_color')) {
				$('sesatoz_minimenu_icon_color').value = '#FFF';
				document.getElementById('sesatoz_minimenu_icon_color').color.fromString('#FFF');
			}
			if($('sesatoz_minimenu_icon_active_color')) {
				$('sesatoz_minimenu_icon_active_color').value = '#191919';
				document.getElementById('sesatoz_minimenu_icon_active_color').color.fromString('#191919');
			}
			if($('sesatoz_header_searchbox_background_color')) {
				$('sesatoz_header_searchbox_background_color').value = '#36383D';
				document.getElementById('sesatoz_header_searchbox_background_color').color.fromString('#36383D');
			}
			if($('sesatoz_header_searchbox_text_color')) {
				$('sesatoz_header_searchbox_text_color').value = '#fff';
				document.getElementById('sesatoz_header_searchbox_text_color').color.fromString('#fff');
			}
			
			//Top Panel Color
			if($('sesatoz_toppanel_userinfo_background_color')) {
				$('sesatoz_toppanel_userinfo_background_color').value = '#8BC34A';
				document.getElementById('sesatoz_toppanel_userinfo_background_color').color.fromString('#8BC34A');
			}
			if($('sesatoz_toppanel_userinfo_font_color')) {
				$('sesatoz_toppanel_userinfo_font_color').value = '#FFFFFF';
				document.getElementById('sesatoz_toppanel_userinfo_font_color').color.fromString('#FFFFFF');
			}
			//Top Panel Color
			
			//Header Styling
			
			//Footer Styling
			if($('sesatoz_footer_background_color')) {
				$('sesatoz_footer_background_color').value = '#222222';
				document.getElementById('sesatoz_footer_background_color').color.fromString('#222222');
			}
			if($('sesatoz_footer_heading_color')) {
				$('sesatoz_footer_heading_color').value = '#FFFFFF';
				document.getElementById('sesatoz_footer_heading_color').color.fromString('#FFFFFF');
			}
			if($('sesatoz_footer_links_color')) {
				$('sesatoz_footer_links_color').value = '#B3B3B3';
				document.getElementById('sesatoz_footer_links_color').color.fromString('#B3B3B3');
			}
			if($('sesatoz_footer_links_hover_color')) {
				$('sesatoz_footer_links_hover_color').value = '#8BC34A';
				document.getElementById('sesatoz_footer_links_hover_color').color.fromString('#8BC34A');
			}
			//Footer Styling
				
    }
		 else if(value == 5) {
    
      //Theme Base Styling
      if($('sesatoz_theme_color')) {
        $('sesatoz_theme_color').value = '<?php echo $settings->getSetting('sesatoz.theme.color') ?>';
       // document.getElementById('sesatoz_theme_color').color.fromString('<?php //echo $settings->getSetting('sesatoz.theme.color') ?>');
      }
      //Theme Base Styling
      //Body Styling
      if($('sesatoz_body_background_color')) {
        $('sesatoz_body_background_color').value = '<?php echo $settings->getSetting('sesatoz.body.background.color') ?>';
       // document.getElementById('sesatoz_body_background_color').color.fromString('<?php //echo $settings->getSetting('sesatoz.body.background.color') ?>');
      }
      if($('sesatoz_font_color')) {
        $('sesatoz_font_color').value = '<?php echo $settings->getSetting('sesatoz.fontcolor') ?>';
        //document.getElementById('sesatoz_font_color').color.fromString('<?php //echo $settings->getSetting('sesatoz.font.color') ?>');
      }
      if($('sesatoz_font_color_light')) {
        $('sesatoz_font_color_light').value = '<?php echo $settings->getSetting('sesatoz.font.color.light') ?>';
        //document.getElementById('sesatoz_font_color_light').color.fromString('<?php echo $settings->getSetting('sesatoz.font.color.light') ?>');
      }
      if($('sesatoz_heading_color')) {
        $('sesatoz_heading_color').value = '<?php echo $settings->getSetting('sesatoz.heading.color') ?>';
        //document.getElementById('sesatoz_heading_color').color.fromString('<?php echo $settings->getSetting('sesatoz.heading.color') ?>');
      }
      if($('sesatoz_links_color')) {
        $('sesatoz_links_color').value = '<?php echo $settings->getSetting('sesatoz.links.color') ?>';
        //document.getElementById('sesatoz_links_color').color.fromString('<?php echo $settings->getSetting('sesatoz.links.color') ?>');
      }
      if($('sesatoz_links_hover_color')) {
        $('sesatoz_links_hover_color').value = '<?php echo $settings->getSetting('sesatoz.links.hover.color') ?>';
       // document.getElementById('sesatoz_links_hover_color').color.fromString('<?php echo $settings->getSetting('sesatoz.links.color.hover') ?>');
      }
			if($('sesatoz_content_header_background_color')) {
        $('sesatoz_content_header_background_color').value = '<?php echo $settings->getSetting('sesatoz.content.header.background.color') ?>';
       // document.getElementById('sesatoz_content_header_background_color').color.fromString('<?php echo $settings->getSetting('sesatoz.content.header.background.color') ?>');
      }
			if($('sesatoz_content_header_font_color')) {
        $('sesatoz_content_header_font_color').value = '<?php echo $settings->getSetting('sesatoz.content.header.font.color') ?>';
       // document.getElementById('sesatoz_content_header_font_color').color.fromString('<?php echo $settings->getSetting('sesatoz.content.header.font.color') ?>');
      }
      if($('sesatoz_content_background_color')) {
        $('sesatoz_content_background_color').value = '<?php echo $settings->getSetting('sesatoz.content.background.color') ?>';
      //  document.getElementById('sesatoz_content_background_color').color.fromString('<?php echo $settings->getSetting('sesatoz.content.background.color') ?>');
      }
      if($('sesatoz_content_border_color')) {
        $('sesatoz_content_border_color').value = '<?php echo $settings->getSetting('sesatoz.content.border.color') ?>';
      //  document.getElementById('sesatoz_content_border_color').color.fromString('<?php echo $settings->getSetting('sesatoz.content.border.color') ?>');
      }
      if($('sesatoz_form_label_color')) {
        $('sesatoz_input_font_color').value = '<?php echo $settings->getSetting('sesatoz.form.label.color') ?>';
       // document.getElementById('sesatoz_form_label_color').color.fromString('<?php echo $settings->getSetting('sesatoz.form.label.color') ?>');
      }
      if($('sesatoz_input_background_color')) {
        $('sesatoz_input_background_color').value = '<?php echo $settings->getSetting('sesatoz.input.background.color') ?>';
      //  document.getElementById('sesatoz_input_background_color').color.fromString('<?php echo $settings->getSetting('sesatoz.input.background.color') ?>');
      }
      if($('sesatoz_input_font_color')) {
        $('sesatoz_input_font_color').value = '<?php echo $settings->getSetting('sesatoz.input.font.color') ?>';
       // document.getElementById('sesatoz_input_font_color').color.fromString('<?php echo $settings->getSetting('sesatoz.input.font.color') ?>');
      }
      if($('sesatoz_input_border_color')) {
        $('sesatoz_input_border_color').value = '<?php echo $settings->getSetting('sesatoz.input.border.color') ?>';
       // document.getElementById('sesatoz_input_border_color').color.fromString('<?php echo $settings->getSetting('sesatoz.input.border.color') ?>');
      }
      if($('sesatoz_button_background_color')) {
        $('sesatoz_button_background_color').value = '<?php echo $settings->getSetting('sesatoz.button.backgroundcolor') ?>';
        //document.getElementById('sesatoz_button_background_color').color.fromString('<?php echo $settings->getSetting('sesatoz.button.backgroundcolor') ?>');
      }
      if($('sesatoz_button_background_color_hover')) {
        $('sesatoz_button_background_color_hover').value = '<?php echo $settings->getSetting('sesatoz.button.background.color.hover') ?>';
      }
      if($('sesatoz_button_font_color')) {
        $('sesatoz_button_font_color').value = '<?php echo $settings->getSetting('sesatoz.button.font.color') ?>';
      }
      if($('sesatoz_button_font_hover_color')) {
        $('sesatoz_button_font_hover_color').value = '<?php echo $settings->getSetting('sesatoz.button.font.hover.color') ?>';
      }
      if($('sesatoz_comment_background_color')) {
        $('sesatoz_comment_background_color').value = '<?php echo $settings->getSetting('sesatoz.comment.background.color') ?>';
      }
      //Body Styling
      //Header Styling
      if($('sesatoz_header_background_color')) {
        $('sesatoz_header_background_color').value = '<?php echo $settings->getSetting('sesatoz.header.background.color') ?>';
      }
			if($('sesatoz_mainmenu_background_color')) {
        $('sesatoz_mainmenu_background_color').value = '<?php echo $settings->getSetting('sesatoz.mainmenu.background.color') ?>';
      }
      if($('sesatoz_mainmenu_links_color')) {
        $('sesatoz_mainmenu_links_color').value = '<?php echo $settings->getSetting('sesatoz.mainmenu.links.color') ?>';
      }
      if($('sesatoz_mainmenu_links_hover_color')) {
        $('sesatoz_mainmenu_links_hover_color').value = '<?php echo $settings->getSetting('sesatoz.mainmenu.links.hover.color') ?>';
      }
      if($('sesatoz_minimenu_links_color')) {
        $('sesatoz_minimenu_links_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.links.color') ?>';
      }
      if($('sesatoz_minimenu_links_hover_color')) {
        $('sesatoz_minimenu_links_hover_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.links.hover.color') ?>';
      }
      if($('sesatoz_minimenu_icon_background_color')) {
        $('sesatoz_minimenu_icon_background_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.icon.background.color') ?>';
      }
      if($('sesatoz_minimenu_icon_background_active_color')) {
        $('sesatoz_minimenu_icon_background_active_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.icon.background.active.color') ?>';
      }
      if($('sesatoz_minimenu_icon_color')) {
        $('sesatoz_minimenu_icon_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.icon.color') ?>';
      }
      if($('sesatoz_minimenu_icon_active_color')) {
        $('sesatoz_minimenu_icon_active_color').value = '<?php echo $settings->getSetting('sesatoz.minimenu.icon.active.color') ?>';
      }
      if($('sesatoz_header_searchbox_background_color')) {
        $('sesatoz_header_searchbox_background_color').value = '<?php echo $settings->getSetting('sesatoz.header.searchbox.background.color') ?>';
      }
      if($('sesatoz_header_searchbox_text_color')) {
        $('sesatoz_header_searchbox_text_color').value = '<?php echo $settings->getSetting('sesatoz.header.searchbox.text.color') ?>';
      }
			
			//Top Panel Color
      if($('sesatoz_toppanel_userinfo_background_color')) {
        $('sesatoz_toppanel_userinfo_background_color').value = '<?php echo $settings->getSetting('sesatoz.toppanel.userinfo.background.color'); ?>';
      }
      
      if($('sesatoz_toppanel_userinfo_font_color')) {
        $('sesatoz_toppanel_userinfo_font_color').value = '<?php echo $settings->getSetting('sesatoz.toppanel.userinfo.font.color'); ?>';
      }
			//Top Panel Color
			
      //Header Styling

      //Footer Styling
      if($('sesatoz_footer_background_color')) {
        $('sesatoz_footer_background_color').value = '<?php echo $settings->getSetting('sesatoz.footer.background.color') ?>';
      }
      if($('sesatoz_footer_heading_color')) {
        $('sesatoz_footer_heading_color').value = '<?php echo $settings->getSetting('sesatoz.footer.heading.color') ?>';
      }
      if($('sesatoz_footer_links_color')) {
        $('sesatoz_footer_links_color').value = '<?php echo $settings->getSetting('sesatoz.footer.links.color') ?>';
      }
      if($('sesatoz_footer_links_hover_color')) {
        $('sesatoz_footer_links_hover_color').value = '<?php echo $settings->getSetting('sesatoz.footer.links.hover.color') ?>';
      }
      //Footer Styling
    }
	}
</script>
