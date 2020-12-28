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
<?php if($this->bgimage): ?>
  <?php 
    $photoUrl = $this->baseUrl() . '/' . $this->bgimage;
    ?>
  <?php else: ?>
	<?php 
    $photoUrl = $this->baseUrl() . '/application/modules/Sesatoz/externals/images/parallax-bg.jpeg';
	?>
  <?php endif; ?>
  <div class="atoz_parallax_block_wrapper sesbasic_bxs sesbasic_clearfix">
    <div class="atoz_parallax_block" style="background-image: url(<?php echo $photoUrl ?>);">
      <div class="atoz_parallax_foreground_container">
        <div class="atoz_parallax_foreground_content">
          <div>
          	<div class="atoz_parallax_content">
            	<span class="atoz_parallax_title"><?php echo $this->translate($this->heading); ?></span>
              <span class="atoz_parallax_desc">
                 <?php echo $this->translate($this->description); ?>
              </span>
              <span class="atoz_parallax_btn">
                <a href="<?php echo $this->translate($this->buttonlink); ?>"><?php echo $this->translate($this->buttontext); ?></a>
              </span>
            </div>  
          </div>
        </div>
      </div>
    </div>
  </div>
