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
<div class="sesatoz_features_three_wrapper clearfix sesbasic_bxs">
	<h3><?php echo $this->translate("How it Works?"); ?></h3>
  <p class="sesbasic_text_light"><?php echo $this->translate("You must be wondering how our community works. It’s too easy and in few steps:"); ?></p>
  <div class="sesatoz_features_three_inner">
     <div class="sesatoz_features_three_item">
       <div class="_icon"><i><img src="application/modules/Sesatoz/externals/images/story.png" /></i></div>
       <span class="_head"><?php echo $this->translate("Signup / Login"); ?></span>
       <span class="_desc"><?php echo $this->translate("You need to signup on our community to get started. If already have an account, simply login with your details."); ?></span>
     </div>
      <div class="sesatoz_features_three_item">
       <div class="_icon"><i><img src="application/modules/Sesatoz/externals/images/vid.png" /></i></div>
       <span class="_head"><?php echo $this->translate("Post Content"); ?></span>
       <span class="_desc"><?php echo $this->translate("Start by posting your updates, content like groups, contests, pages, businesses, blogs, quotes, etc inside."); ?></span>
     </div>
      <div class="sesatoz_features_three_item">
       <div class="_icon"><i><img src="application/modules/Sesatoz/externals/images/intro.png" /></i></div>
       <span class="_head"><?php echo $this->translate("Share Globally"); ?></span>
       <span class="_desc"><?php echo $this->translate("You can share content, profiles or posts from within this community to many social networking sites globally."); ?></span>
     </div>
  </div>
</div>
