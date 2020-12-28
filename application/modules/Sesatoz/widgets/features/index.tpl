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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/styles/lity.min.css'); ?>
<div class="sesatoz_features_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate($this->heading); ?></h3>
  <p class="sesbasic_text_light"><?php echo $this->translate($this->caption); ?></p>
  <?php if($this->design == 1) { ?>
    <div class="sesatoz_features_block">
      <div class="sesatoz_feature_inner">
      <div class="sesatoz_feature_item_main">
      <?php 
      $counter = 0;
      foreach($this->content as $content) {
        if($counter == 6)
          break;
      ?>
        <div class="sesatoz_feature_item wow slideInLeft">
          <div class="sesatoz_feature_item_icon">
            <i class="icon_feature" style="background-image:url(<?php echo $content['iconimage']; ?>);"></i>
          </div>
          <div class="sesatoz_feature_item_cont sesbasic_bg">
            <h3><a href="<?php if($content['url']){ echo $content['url'];}else{ echo 'javascript:;'; } ?>"><?php echo $this->translate($content['caption']); ?></a></h3>
            <p class="sesbasic_text_light"><?php echo $this->translate($content['description']); ?></p>
          </div>
        </div>
      <?php 
      $counter++;
        } ?>
        </div>
          <div class="sesatoz_feature_bg sesbasic_bg  wow slideInRight">
          <img src="<?php echo $this->bgimage ?>" />
          <?php if(Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.youtubevideolink', '')) { ?>
          <a href="<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.youtubevideolink', ''); ?>" data-lity><i class="fa fa-play"></i></a>
          <?php } ?>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <div class="sesatoz_features_second">
      <div class="sesatoz_feature_second_left">
        <?php 
        $counter = 0;
        foreach($this->content as $content) {
          if($counter == 4)
            break;
        ?>
        <div class="feature-item">
          <div class="feature-icon">
             <i class="icon_feature" style="background-image:url(<?php echo $content['iconimage']; ?>);"></i>
          </div>
          <div class="feature-text">
            <h3><a href="<?php if($content['url']){ echo $content['url'];}else{ echo 'javascript:;'; } ?>"><?php echo $this->translate($content['caption']); ?></a></h3>
            <p class="sesbasic_text_light"><?php echo $this->translate($content['description']); ?></p>
          </div>
        </div>
        <?php 
        $counter++;
        } ?>
      </div>
      <div class="sesatoz_feature_second_right">
        <div class="feature-img">
            <img src="<?php echo $this->bgimage ?>"  />
        </div>
      </div>
    </div>
  <?php } ?>
</div>
<script type="text/javascript" src="application/modules/Sesatoz/externals/scripts/lity.min.js"></script>
