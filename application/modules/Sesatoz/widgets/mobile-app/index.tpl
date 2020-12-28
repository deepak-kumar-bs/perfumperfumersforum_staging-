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
<?php $allParams = $this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/styles/styles.css'); ?>
<?php if($this->design == 1) { ?>
<div class="sesatoz_app_wrapper clearfix sesbasic_bxs">
	<div class="sesatoz_app_wrapper_inner">
     <div class="cont_right">
       <div class="mobile_img">
        <img src="<?php echo $allParams['mobilescreenshot']; ?>" />
       </div>
     </div>
     <div class="cont_left">
       <h4><?php echo $this->translate("Our Mobile Apps"); ?></h4>
       <p class="sesbasic_text_light"><?php echo $this->translate("Get access to our community on your smart mobile phones and access all the features quickly easily accessible within your palm."); ?></p>
       <ul class="sesbasic_text_light">
         <li><?php echo $this->translate("Simple search, instant updates and a great user experience."); ?></li>
         <li><?php echo $this->translate("Upload Photos, Manage albums & Edit your profile easily."); ?></li>
         <li><?php echo $this->translate("Get instant notifications about all key updates."); ?></li>
         <li><?php echo $this->translate("Download our apps which are the best rated in online communities."); ?></li>
       </ul>
       <div class="sesatoz_emailbox">
         <h3><?php echo $this->translate("Get our apps"); ?></h3>
         <p class="_des sesbasic_text_light"><?php echo $this->translate("Enter your email and we’ll send you the links to them. Open the links in your phone and download our app."); ?></p>
          <div class="_inputbox">
           <form class="clearfix" method="post">
             <input id="sesatoz_app_email" type="email" name="app_name" placeholder='<?php echo $this->translate("Enter Your Email"); ?>'><button id="sesatoz_app_link" class="button"><?php echo $this->translate("E-mail App Links"); ?></button>
           </form>
          </div>
          <a href="<?php echo $this->translate($allParams['ioslink']); ?>"><img src="application/modules/Sesatoz/externals/images/a-store.png" /></a>
          <a href="<?php echo $this->translate($allParams['androidlink']); ?>"><img src="application/modules/Sesatoz/externals/images/g-play.png" /></a>
       </div>
     </div>
  </div>
</div>
<?php } else { ?>
  <div class="sesatoz_app_two_wrapper clearfix sesbasic_bxs">
  <div class="sesatoz_app_second" style="background-image:url(application/modules/Sesatoz/externals/images/app-sec-bg.png);">
     <div class="sesatoz_app_second_inner">
       <div class="app_second_left">
         <p class="mobile-friendly"><?php echo $this->translate("Mobile Friendly"); ?></p>
         <h3><?php echo $this->translate("Our Mobile Apps"); ?></h3>
         <h5><?php echo $this->translate("We understand that you can not carry your desktop / laptop with you all the time, so our community is available on Android and iOS app stores as well making it available on the device of your choice."); ?></h5>
         <div class="devices-row">
            <img src="application/modules/Sesatoz/externals/images/tab-icon.png"  />
            <img src="application/modules/Sesatoz/externals/images/mobile-icon.png"  />
         </div>
         <p class="support"><?php echo $this->translate("Download the Apps Now"); ?></p>
       </div>
        <div class="app_second_right">
          <div class="app-img">
            <img src="<?php echo $allParams['mobilescreenshot']; ?>"  />
          </div>
       </div>
     </div>
  </div>
</div>
<?php } ?>
<script>
  sesJqueryObject(document).ready(function() {
    sesJqueryObject("#sesatoz_app_link").click(function(e) {
      e.preventDefault();
      var sesatoz_app_email = sesJqueryObject('#sesatoz_app_email').val();
      if(sesatoz_app_email)
        sendAppEmail();
    });
    
    sesJqueryObject('#sesatoz_app_email').keydown(function(e) {
      if (e.which === 13) {
        sendAppEmail();
      }
    });
  });
  
  function sendAppEmail() {
  
    var sesatoz_app_email = sesJqueryObject('#sesatoz_app_email').val();
    if(sesatoz_app_email == '')
      return;
    sesJqueryObject('#sesatoz_app_email').val('');
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesatoz/index/sendappemail',
      data: {
        format: 'json',
        'sesatoz_app_email': sesatoz_app_email,
        'androidlink': '<?php echo $allParams["androidlink"]; ?>',
        'ioslink': '<?php echo $allParams["ioslink"]; ?>',
      },
      onSuccess: function(responseJSON) {
        if(responseJSON.mobile_app_linksent) {
          //location.reload();
        }
      }
    }));
  }
</script>
