<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2012-2013 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 6590 2013-04-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>



<?php $review = $this->reviews; ?>
<?php $reviewTable = Engine_Api::_()->getDbTable('reviews', 'sitereview'); ?>
<?php $helpfulTable = Engine_Api::_()->getDbtable('helpful', 'sitereview'); ?>
<?php $reviewDescriptionsTable = Engine_Api::_()->getDbtable('reviewDescriptions', 'sitereview'); ?>

<div id="profile_review" class="pabsolute"></div>

<?php
$this->headLink()
        ->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_rating.css')
        ->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_sitereviewprofile.css')
        ->prependStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_sitereview.css');
?>

<div class="o_hidden">
  <div class="sr_view_top">
    <?php // echo "<pre>"; print_r($this->sitereview); die; ?>
    <?php echo $this->htmlLink($this->sitereview->getHref(array('profile_link' => 1)), $this->itemPhoto($this->sitereview, 'thumb.icon', $this->sitereview->getTitle()), array('class' => "thumb_icon", 'title' => $this->sitereview->getTitle())) ?>
    <div class="sr_review_view_right">
      <?php if ($this->hasPosted ):?>
      <button classs="sr_review_button" >
      <?php echo $this->htmlLink(array('route' => 'default','module' => 'sitereview', 'controller' => 'editor', 'action' => 'edit', 'listing_id' => $this->sitereview->getIdentity(), 'review_id' => $this->hasPosted), "Edit your Editor $this->reviewTitleSingular") ?></button>
    <?php endif; ?>
    <?php if (!$this->hasPosted && $this->can_create): ?>
      <button classs="sr_review_button" >
      <?php echo $this->htmlLink(array('route' => 'default','module' => 'sitereview', 'controller' => 'editor', 'action' => 'create', 'listing_id' => $this->sitereview->getIdentity()), "Write an Editor $this->reviewTitleSingular") ?></button>
    <?php endif; ?>
      <?php if ($this->price > 0): ?>
        <div class="sr_price mtop10">
          <?php echo Engine_Api::_()->sitereview()->getPriceWithCurrency($this->price); ?>
        </div>   
      <?php endif; ?> 
    </div>
    <h2>
      <?php echo $this->htmlLink($this->sitereview->getHref(), $this->sitereview->getTitle()) ?>
    </h2>
    <div class="O_hidden sr_view_top_options">
      <?php echo $this->compareButton($this->sitereview); ?>
      <?php echo $this->addToWishlist($this->sitereview, array('classIcon' => 'sr_icon_wishlist_add', 'classLink' => ''));?>
    </div> 
  </div>
<?php if($this->canshowrating): ?>
  <div class="sr_profile_review b_medium sr_review_block profile_editor_review_rating">
    <div class="sr_profile_review_left">
      <div class="sr_profile_review_title">
        <?php if (empty($reviewcatTopbox['ratingparam_name'])): ?>
          <?php echo $this->translate("Average Editor Rating"); ?>
        <?php endif; ?>
      </div>
      <?php $iteration = 1; ?>
      <div class="sr_profile_review_stars">
        <span class="sr_profile_review_rating">
          <span class="fleft">
            <?php echo $this->showRatingStar($this->sitereview->rating_editor, 'editor', 'big-star', $this->sitereview->listingtype_id); ?>
          </span>
          <?php if (count($this->ratingDataTopbox) > 1): ?>
            <i class="arrow_btm fleft"></i>
          <?php endif; ?>
        </span>	
      </div>

      <div class="sr_profile_review_stat clr">
        <?php echo $this->translate(array("Based on %s $this->reviewTitleSingular", "Based on %s $this->reviewTitlePlular", $this->totalReviews), $this->locale()->toNumber($this->totalReviews)); ?>
      </div>
    </div>
    <div class="sr_profile_review_right">

      <?php if (!empty($this->viewer_id) && $this->can_create && empty($this->isajax)): ?>
        <?php $rating_value_2 = 0; ?>	
        <?php if (!empty($this->reviewRateMyData)): ?>	
          <?php foreach ($this->reviewRateMyData as $reviewRateData): ?>
            <?php if ($reviewRateData['ratingparam_id'] == 0): ?>
              <?php $rating_value_2 = $reviewRateData['rating']; ?>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($rating_value_2)): ?>
          <div class="sr_profile_review_title mtop5" id="review-my-rating">
            <?php echo $this->translate("My Rating"); ?>
          </div>	
          <div class="sr_profile_review_stars">
            <?php echo $this->showRatingStar($rating_value_2, 'editor', 'big-star', $this->sitereview->listingtype_id); ?>		     
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

  <ul class="sr_reviews_listing" id="profile_sitereview_content">
    <?php if ($review->status == 0): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("This $this->reviewTitleSingular has been written by a visitor of your site and is not visible to the users of your site. Please %s to take an appropriate action on this $this->reviewTitleSingular.", $this->htmlLink(array('route' => 'admin_default', 'module' => 'sitereview', 'controller' => 'review', 'action' => 'take-action', 'review_id' => $review->review_id, 'listing_id' => $this->sitereview->listing_id), $this->translate('click over here'), array('class' => 'smoothbox'))); ?>
        </span>
      </div>
    <?php endif; ?>
    <li>
      <div class="sr_reviews_listing_photo">
        <?php if ($review->owner_id): ?>
          <?php echo $this->htmlLink($review->getOwner()->getHref(), $this->itemPhoto($review->getOwner(), 'thumb.icon', $review->getOwner()->getTitle()), array('class' => "thumb_icon")) ?>
        <?php else: ?>
          <?php $itemphoto = $this->layout()->staticBaseUrl . "application/modules/User/externals/images/nophoto_user_thumb_icon.png"; ?>
          <img src="<?php echo $itemphoto; ?>" class="thumb_icon" alt="" />
        <?php endif; ?>
      </div>
      <div class="sr_reviews_listing_info">
        <div class=" sr_reviews_listing_title">
          <?php if($this->canshowrating): ?>
            <div class="sr_ur_show_rating_star">
              <?php $ratingData = $review->getRatingData(); ?>
              <?php
              $rating_value = 0;
              foreach ($ratingData as $reviewcat):
                if (empty($reviewcat['ratingparam_name'])):
                  $rating_value = $reviewcat['rating'];
                  break;
                endif;
              endforeach;
              ?>
              <span class="fright">  
                <span class="fleft">
                  <?php echo $this->showRatingStar($rating_value, 'editor', 'big-star', $this->sitereview->listingtype_id); ?>
                </span>
              </span>
            </div>
          <?php endif; ?>
          <?php if ($review->featured): ?>
            <i class="sr_icon seaocore_icon_featured fright" title="<?php echo $this->translate('Featured'); ?>"></i> 
          <?php endif; ?>	
          <div class="sr_review_title"><?php echo $review->getTitle() ?></div>
        </div>
        <div class="sr_reviews_listing_stat seaocore_txt_light">
          <?php echo $this->timestamp(strtotime($review->modified_date)); ?> - 
          <?php if (!empty($review->owner_id)): ?>
            <?php echo $this->translate('by'); ?> <?php echo $this->htmlLink($review->getOwner()->getHref(), $review->getOwner()->getTitle()) ?>
          <?php else: ?>
            <?php echo $this->translate('by'); ?> <?php echo $review->anonymous_name; ?>
          <?php endif; ?>
        </div> 
        <div class="clr"></div>
        <?php if ($review->pros): ?>
          <div class="sr_reviews_listing_proscons">
            <b><?php echo $this->translate("Pros") ?>: </b>
            <?php echo $review->pros ?> 
          </div>
        <?php endif; ?>
        <?php if ($review->cons): ?>
          <div class="sr_reviews_listing_proscons"> 
            <b><?php echo $this->translate("Cons") ?>: </b>
            <?php echo $review->cons ?>
          </div>
        <?php endif; ?>

        <?php if ($this->reviews->profile_type_review): ?>
          <div class="sr_reviews_listing_proscons"> 
            <?php $custom_field_values = $this->fieldValueLoopReview($this->reviews, $this->fieldStructure); ?>
            <?php echo htmlspecialchars_decode($custom_field_values); ?>
          </div>	
        <?php endif; ?>

        <?php if ($review->getDescription()): ?>
          <div class="sr_reviews_listing_proscons">
            <b><?php // echo $this->translate("Summary") ?> </b>
            <?php echo $review->body ?>
          </div>
        <?php endif; ?>
        <?php
        include APPLICATION_PATH . '/application/modules/Sitereview/views/scripts/_formEditorReplyReview.tpl';
        ?> 
      </div>
    </li>
  </ul>
  <?php if ($this->reviews->owner_id) : ?>
    <?php 
        include_once APPLICATION_PATH . '/application/modules/Seaocore/views/scripts/_listNestedComment.tpl';
    ?>
  <?php else: ?>
    <?php if ($this->level_id == 1): ?>
      <div class="tip">
        <span><?php echo $this->translate("Comments on $this->reviewTitleSingular have been disabled, as this $this->reviewTitleSingular was written by a visitor of your site."); ?></span>
      </div>
    <?php endif; ?>
  <?php endif; ?>

  <div class="clr o_hidden b_medium sr_review_view_footer fleft">  
    <div class="fleft">
      <a href='<?php echo $this->url(array('listing_id' => $this->sitereview->listing_id, 'slug' => $this->sitereview->getSlug(), 'tab' => $this->tab_id), "sitereview_entry_view_listtype_$this->listingtype_id", true) ?>' class="buttonlink sr_item_icon_back">
        <?php echo $this->translate("Back to $this->reviewTitleSingular"); ?>
      </a>
    </div>      
    <div class="o_hidden fright sr_review_view_paging">
      <?php $pre = $this->reviews->getPreviousReview(); ?>
      <?php if ($pre): ?>
        <div id="user_group_members_previous" class="paginator_previous">
          <?php
          echo $this->htmlLink($pre->getHref(), $this->translate('Previous'), array(
              'class' => 'buttonlink icon_previous'
          ));
          ?>
        </div>
      <?php endif; ?>
      <?php $next = $this->reviews->getNextReview(); ?>
      <?php if ($next): ?>
        <div id="user_group_members_previous" class="paginator_next">
          <?php
          echo $this->htmlLink($next->getHref(), $this->translate('Next'), array(
              'class' => 'buttonlink_right icon_next'
          ));
          ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  var seaocore_content_type = '<?php echo $this->reviews->getType(); ?>';
  en4.core.runonce.add(function() {
		<?php if (count($this->ratingDataTopbox) > 1): ?>
			$$('.sr_profile_review_rating').addEvents({
				'mouseover': function(event) {
					document.getElements('.sr_ur_bdown_box_wrapper').setStyle('display','block');
				},
				'mouseleave': function(event) {    
					document.getElements('.sr_ur_bdown_box_wrapper').setStyle('display','none');
				}});
			$$('.sr_ur_bdown_box_wrapper').addEvents({
				'mouseenter': function(event) {
					document.getElements('.sr_ur_bdown_box_wrapper').setStyle('display','block');
				},
				'mouseleave': function(event) {
					document.getElements('.sr_ur_bdown_box_wrapper').setStyle('display','none');
				}});
		<?php endif; ?> 
	});
</script>