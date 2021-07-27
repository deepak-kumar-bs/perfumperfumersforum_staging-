<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2012-2013 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: _formReplyReview.tpl 6590 2013-04-01 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<?php
$reviewTitleSingular = $this->reviewTitleSingular ? $this->reviewTitleSingular : 'Review';
$reviewTitlePlular = $this->reviewTitlePlular ? $this->reviewTitlePlular : 'Reviews';


?>

<div class="sr_reviews_listing_option b_medium" id= "reply-form">
  <ul> 
    <?php if ($this->checkPage == "listingProfile") : ?> 
      <?php $reviewGuid = $review->getGuid() . "_0"; ?>
      <?php if ($review->owner_id) : ?>
        <li> 
          <?php echo $this->htmlLink($review->getHref() . "#comments-form_$reviewGuid", $this->translate("<b>Comment on this $reviewTitleSingular</b>"), array('title' => $this->translate("Comment on this $reviewTitleSingular"), 'class' => 'reply icon_sitereviews_comment')) ?>
        </li> 
        <li>|</li>  
      <?php endif; ?>
      <?php
      $commentCountSelect = $review->comments()->getCommentSelect();
      $commentsCount = Zend_Paginator::factory($commentCountSelect)->getTotalItemCount();
      ?>
      <?php if ($commentsCount): ?>
        <li> 
          <?php echo $this->htmlLink($review->getHref() . "#comments-form_$reviewGuid", $this->translate(array('Read comment (%s)', 'Read comments (%s)', $commentsCount), $this->locale()->toNumber($commentsCount)), array('title' => $this->translate("Read comment"))) ?>
        </li>
        <li>|</li>
      <?php endif; ?>
    <?php endif; ?> 
    <li> 
      <div> 
        <div id="review_helpful_<?php echo $review->review_id; ?>" style="display:block;">
          <span><?php echo $this->translate("Was this Editor $reviewTitleSingular helpful?"); ?></span> 
          <?php $this->countHelpfulReviews = $helpfulTable->getCountHelpful($review->review_id, 1); ?>
          <a href="javascript:void(0);" onclick="reviewHelpful(1, '<?php echo $review->review_id; ?>');" title="<?php echo $this->translate('Yes'); ?>"><i class="thumbup"></i></a>
          <?php echo $this->countHelpfulReviews ?>
          <?php $this->countHelpfulReviews = $helpfulTable->getCountHelpful($review->review_id, 2); ?>
          <a href="javascript:void(0);" onclick="reviewHelpful(2, '<?php echo $review->review_id; ?>');" title="<?php echo $this->translate('No'); ?>"><i class="thumbdown"></i> </a>
          <?php echo $this->countHelpfulReviews; ?>
        </div>
        <?php if ($this->viewer_id): ?>
          <div id="review_helpful_message_<?php echo $review->review_id; ?>" style="display:none;">
            <i class="sr_icon sr_icon_tick fleft mright5"></i>
            <?php echo $this->translate("Thanks for your feedback!"); ?>
          </div>
          <div id="review_helpful_already_message_<?php echo $review->review_id; ?>" style="display:none;">
            <?php echo $this->translate("You have already submitted your feedback for this $reviewTitleSingular!"); ?>
          </div>
        <?php endif; ?>
      </div> 
    </li> 
  </ul> 
</div>

<script type="text/javascript">
  var active_request_review = false;
  function reviewHelpful(option, review_id) {
    if(active_request_review)
     return;
		<?php if (!$this->viewer_id): ?>
			window.location.href = en4.core.baseUrl+'sitereview/review/helpful/review_id/'+review_id+'/helpful/'+option+'/anonymous/1';
		<?php endif; ?>
     active_request_review = true;
    var request = new Request.JSON({ 
      url : en4.core.baseUrl+'sitereview/review/helpful',
      data : {
        format : 'html',
        review_id : review_id,
        helpful: option
      },
      onSuccess : function(responseJSON) {
        if(responseJSON.already_entry == 0 && $('review_helpful_message_' + review_id )) {        
          $('review_helpful_message_' + review_id ).style.display = 'block';
          $('review_helpful_already_message_' + review_id ).style.display = 'none';
        } else if((responseJSON.already_entry == 1 || responseJSON.already_entry == 2) &&  $('review_helpful_already_message_' + review_id )) {
          $('review_helpful_message_' + review_id ).style.display = 'none';
          $('review_helpful_already_message_' + review_id ).style.display = 'block';
        }
        $('review_helpful_' + review_id).style.display = 'none';
        active_request_review = false;
      }
    });
    request.send();
    return false;
  }

</script>