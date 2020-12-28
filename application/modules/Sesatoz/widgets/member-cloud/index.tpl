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
<?php if($this->memberlink == 1 && $this->sesmemberEnable && $this->showinfotooltip == 1){ ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesmember/externals/styles/styles.css'); ?>
<?php } ?>

<div class="atoz_member_block sesbasic_clearfix sesbasic_bxs">
  <div class="atoz_member_block_heading">
  	<h2><?php echo $this->translate($this->heading); ?></h2>
    <p class="sesbasic_text_light"><?php echo $this->translate($this->caption); ?></p>
  </div>
	<div class="atoz_member_block_members">
    <?php foreach( $this->paginator as $user ): ?>
      <?php if($this->memberlink == 1){ ?>
      <a href="<?php echo $user->getHref(); ?>" <?php if($this->sesmemberEnable && $this->showinfotooltip == 1){ ?> class="ses_tooltip" <?php } ?> data-src="<?php echo $user->getGuid(); ?>">
      <?php } ?>
      <?php echo $this->itemPhoto($user, 'thumb.profile') ?>
      <?php if($this->memberlink == 1){ ?>
      </a>
      <?php } ?>
    <?php endforeach; ?>
  </div>
</div>
<style type="text/css">
/*.atoz_member_block{height:<?php echo $this->height * 1 ?>px}*/
.atoz_member_block_members > a,
.atoz_member_block_members > img{height:<?php echo $this->height ?>px;width:<?php echo $this->width ?>px;max-width:<?php echo $this->width ?>px;}
</style>
