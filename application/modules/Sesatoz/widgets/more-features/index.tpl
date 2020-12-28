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
<div class="sesatoz_more_features_wrapper clearfix sesbasic_bxs">
	 <div class="sesatoz_more_features_inner">
      <?php if($this->fe1img || $this->fe1heading || $this->fe1description || $this->fe1linktext || $this->fe1textlink) { ?>
      <div class="more_feature_item">
         <div class="more-img">
            <img src="<?php echo $this->baseUrl() . '/' . $this->fe1img; ?>" />
         </div>
         <div class="_cont">
            <h2><?php echo $this->translate($this->fe1heading); ?></h2>
            <p class="sesbasic_text_light"><?php echo $this->translate($this->fe1description); ?></p>
            <a href="<?php echo $this->fe1textlink; ?>"><?php echo $this->translate($this->fe1linktext) ?></a>
         </div>
      </div>
      <?php } ?>
      <?php if($this->fe2img || $this->fe2heading || $this->fe2description || $this->fe2linktext || $this->fe2textlink) { ?>
        <div class="more_feature_item">
          <div class="_cont">
            <h2><?php echo $this->translate($this->fe2heading); ?></h2>
            <p class="sesbasic_text_light"><?php echo $this->translate($this->fe2description); ?></p>
            <a href="<?php echo $this->fe2textlink; ?>"><?php echo $this->translate($this->fe2linktext) ?></a>
          </div>
            <div class="more-img">
              <img src="<?php echo $this->baseUrl() . '/' . $this->fe2img; ?>" />
          </div>
        </div>
      <?php } ?>
      <?php if($this->fe3img || $this->fe3heading || $this->fe3description || $this->fe3linktext || $this->fe3textlink) { ?>
      <div class="more_feature_item">
        <div class="more-img">
            <img src="<?php echo $this->baseUrl() . '/' . $this->fe3img; ?>" />
         </div>
         <div class="_cont">
          <h2><?php echo $this->translate($this->fe3heading); ?></h2>
          <p class="sesbasic_text_light"><?php echo $this->translate($this->fe3description); ?></p>
          <a href="<?php echo $this->fe3textlink; ?>"><?php echo $this->translate($this->fe3linktext) ?></a>
         </div>
      </div>
      <?php } ?>
      <?php if($this->fe4img || $this->fe4heading || $this->fe4description || $this->fe4linktext || $this->fe4textlink) { ?>
      <div class="more_feature_item">
         <div class="_cont">
            <h2><?php echo $this->translate($this->fe4heading); ?></h2>
            <p class="sesbasic_text_light"><?php echo $this->translate($this->fe4description); ?></p>
            <a href="<?php echo $this->fe4textlink; ?>"><?php echo $this->translate($this->fe4linktext) ?></a>
         </div>
          <div class="more-img">
            <img src="<?php echo $this->baseUrl() . '/' . $this->fe4img; ?>" />
         </div>
      </div>
      <?php } ?>
   </div>
</div>
