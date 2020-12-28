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

<div class="sesatoz_newsletter_wrapper clearfix sesbasic_bxs">
	<div class="sesatoz_newsletter_wrapper_inner">
     <div class="icon"><img src="application/modules/Sesatoz/externals/images/icon-letter.png" /></div>
     <div class="head">
       <p><?php echo $this->translate("Our"); ?></p>
       <h4><?php echo $this->translate("Newsletter"); ?></h4>
     </div>
     <div class="input-box">
       <input name="email" id="sesatoz_newsletter_email" type="email" placeholder="<?php echo $this->translate('Enter Your Email Address'); ?>"/>
       <button id="sesatoz_newsletter" type="submit">Subscribe</button>
     </div>
  </div>
</div>
<script>
  sesJqueryObject(document).ready(function() {
    sesJqueryObject("#sesatoz_newsletter_email").click(function(e) {
      e.preventDefault();
      var sesatoz_newsletter_email = sesJqueryObject('#sesatoz_newsletter_email').val();
      if(sesatoz_newsletter_email)
        sendNewsletter();
    });
    
    sesJqueryObject('#sesatoz_newsletter_email').keydown(function(e) {
      if (e.which === 13) {
        sendNewsletter();
      }
    });
  });
  
  function sendNewsletter() {
  
    var newsletteremail = sesJqueryObject('#sesatoz_newsletter_email').val();
    if(newsletteremail == '')
      return;
    sesJqueryObject('#sesatoz_newsletter_email').val('');
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesatoz/index/newsletter',
      data: {
        format: 'json',
        'email': newsletteremail,
      },
      onSuccess: function(responseJSON) {
        if(responseJSON.newsletteremail_id) {
          //location.reload();
        }
      }
    }));
  
  }
</script>
