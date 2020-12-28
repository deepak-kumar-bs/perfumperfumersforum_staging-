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
<?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/clip.js'); ?>
<?php 

$contentArray = array();

foreach($this->sesatoz_banner_content as $content) {

$contentArray[] = $this->translate($content);

}

?>
<?php $identity = $this->identity; ?>
<script type="text/javascript">

  window.addEvent('domready',function() {

    /* settings */

    var showDuration = 3000;

    var container = $('homeslideshow_container_<?php echo $identity; ?>');

    var images = container.getElements('img');

    var currentIndex = 0;

    var interval;

    /* opacity and fade */

    images.each(function(img,i){ 

      if(i > 0) {

        img.set('opacity',0);

      }

    });

    /* worker */

    var show = function() {   

      images[currentIndex].fade('out');

      images[currentIndex = currentIndex < images.length - 1 ? currentIndex+1 : 0].fade('in');

    };

    /* start once the page is finished loading */

    window.addEvent('load',function(){

      interval = show.periodical(showDuration);

    });

  });

</script>
<script type="text/javascript">
	sesJqueryObject (function(){
    sesJqueryObject(".sesariana_slider_caption").typed({
      strings: <?php echo json_encode($contentArray); ?>,
      typeSpeed: 60,
      backDelay: 500,
      callback: function () { $(this) }
    });
	});
</script>
<div class="sesatoz_home_slider clearfix sesbasic_bxs" style="height:<?php echo $this->height; ?>px;">
  <div id="homeslideshow_container_<?php echo $identity; ?>"  class="sesatoz_home_slider_img">
    <?php for($i=1;$i<=5;$i++) { ?>
    <?php $item = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.banner.bgimage.'.$i, ''); ?>
    <?php if(!empty($item)) { ?>
    <img src="<?php echo $item; ?>" />
    <?php } ?>
    <?php } ?>
  </div>
  <div class="sesatoz_home_slider_cont clearfix">
    <div class="sesatoz_home_slider_cont_inner clearfix">
      <div class="sesatoz_home_slider_cont_inner_cont">
        <h1 class="wow slideInDown"><?php echo $this->translate($this->staticContent); ?></h1>
        <div class="cd-intro">
          <p class="cd-headline clip is-full-width"> <span class="cd-words-wrapper">
            <?php $counter = 1; ?>
            <?php foreach($this->sesatoz_banner_content as $sesatoz_banner_content) { ?>
            <b  <?php if($counter == 1) { ?> class="is-visible" <?php } ?>><?php echo $sesatoz_banner_content; ?></b>
            <?php $counter++; ?>
            <?php } ?>
            </span> </p>
        </div>
        <?php if(empty($this->viewer_id)) { ?>
        <div class="sesatoz_home_slider_btns"> <a <?php if($this->show_mini) { ?> id="popup-login" href="#small-dialog" class="popup-with-move-anim wow slideInUp"  data-wow-delay=".1s" <?php } else { ?>  href="login" <?php } ?> ><?php echo $this->translate("Sign In"); ?> <i class="fa fa-arrow-circle-right"></i></a> <a <?php if($this->show_mini) { ?> id="popup-signup" href="#user_signup_form"  class="popup-with-move-anim wow slideInUp" data-wow-delay=".2s" <?php } else { ?> href="signup" <?php } ?>><?php echo $this->translate("Sign Up"); ?></a> </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
