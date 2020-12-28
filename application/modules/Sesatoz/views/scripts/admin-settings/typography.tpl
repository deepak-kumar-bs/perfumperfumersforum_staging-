<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: typography.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>
<div class='clear sesbasic_admin_form sesatoz_typography_setting'>
  <div class='settings'>
    <?php echo $this->form->render($this); ?>
  </div>
</div>

<script>
  window.addEvent('domready',function() {
    usegooglefont('<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.googlefonts', 0);?>');
  });
  
  function usegooglefont(value) {
  
    if(value == 1) {
    
//       $('sesatoz_googlebody_fontfamily').value = 'Open Sans';
//       $('sesatoz_googleheading_fontfamily').value = 'Open Sans';
//       if('sesatoz_body-wrapper')
//         $('sesatoz_body-wrapper').style.display = 'none';
      if($('sesatoz_bodygrp'))
        $('sesatoz_bodygrp').style.display = 'none';
//       if('sesatoz_heading-wrapper')
//         $('sesatoz_heading-wrapper').style.display = 'none';
      if($('sesatoz_headinggrp'))
        $('sesatoz_headinggrp').style.display = 'none';
//       if('sesatoz_mainmenu-wrapper')
//         $('sesatoz_mainmenu-wrapper').style.display = 'none';
      if($('sesatoz_mainmenugrp'))
        $('sesatoz_mainmenugrp').style.display = 'none';
//       if('sesatoz_tab-wrapper')
//         $('sesatoz_tab-wrapper').style.display = 'none';
      if($('sesatoz_tabgrp'))
        $('sesatoz_tabgrp').style.display = 'none';
        
      if($('sesatoz_googlebodygrp'))
        $('sesatoz_googlebodygrp').style.display = 'block';
      if($('sesatoz_googleheadinggrp'))
        $('sesatoz_googleheadinggrp').style.display = 'block';
      if($('sesatoz_googlemainmenugrp'))
        $('sesatoz_googlemainmenugrp').style.display = 'block';
      if($('sesatoz_googletabgrp'))
        $('sesatoz_googletabgrp').style.display = 'block';
    } else {
//       if('sesatoz_body-wrapper')
//         $('sesatoz_body-wrapper').style.display = 'block';
      if($('sesatoz_bodygrp'))
        $('sesatoz_bodygrp').style.display = 'block';
//       if('sesatoz_heading-wrapper')
//         $('sesatoz_heading-wrapper').style.display = 'block';
      if($('sesatoz_headinggrp'))
        $('sesatoz_headinggrp').style.display = 'block';
//       if('sesatoz_mainmenu-wrapper')
//         $('sesatoz_mainmenu-wrapper').style.display = 'block';
      if($('sesatoz_mainmenugrp'))
        $('sesatoz_mainmenugrp').style.display = 'block';
//       if('sesatoz_tab-wrapper')
//         $('sesatoz_tab-wrapper').style.display = 'block';
      if($('sesatoz_tabgrp'))
        $('sesatoz_tabgrp').style.display = 'block';
        
      if($('sesatoz_googlebodygrp'))
        $('sesatoz_googlebodygrp').style.display = 'none';
      if($('sesatoz_googleheadinggrp'))
        $('sesatoz_googleheadinggrp').style.display = 'none';
      if($('sesatoz_googlemainmenugrp'))
        $('sesatoz_googlemainmenugrp').style.display = 'none';
      if($('sesatoz_googletabgrp'))
        $('sesatoz_googletabgrp').style.display = 'none';
        
        
    }
  }
</script>
<!--<?php 
  $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyDczHMCNc0JCmJACM86C7L8yYdF9sTvz1A";
  $results = json_decode(file_get_contents($url),true);
  
  $string = 'https://fonts.googleapis.com/css?family=';
  foreach($results['items'] as $re) {
  	$string .= $re['family'] . '|';
  }
?>

<link href="<?php echo $string; ?>" type="text/css" rel="stylesheet" />
<style type="text/css">
 <?php foreach($results['items'] as $re) { ?>
      
	select option[value="<?php echo $re['family'];?>"]{
		font-family:<?php echo $re['family'];?>;
	}
	<?php } ?>
	-->
</style>
