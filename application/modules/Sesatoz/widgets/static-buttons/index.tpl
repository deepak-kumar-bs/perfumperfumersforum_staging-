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

<div class="sesatoz_static_buttons_wrapper">
  <div class="sesatoz_static_buttons_inner">
    <h3><?php echo $this->translate("Post your ideas, listings, quotes, prayers, groups and share globally !!"); ?></h3>
    <div class="sesatoz_static_buttons sesbasic_clearfix">
    	<a href="blogs/home" class="button"><i class="fa fa-comment-o" aria-hidden="true"></i><?php echo $this->translate("Explore Popular Blogs"); ?></a>
      <a href="page-directories"  class="button"><i class="fa fa-calendar-o" aria-hidden="true"></i><?php echo $this->translate("Post Your Listing"); ?></a>
      <a href="group-communities"  class="button"><i class="fa fa-user-o" aria-hidden="true"></i><?php echo $this->translate("Join Groups of Your Interest"); ?></a>
    </div>
  </div>
</div>
