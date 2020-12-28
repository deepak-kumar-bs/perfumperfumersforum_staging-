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
<?php
$this->headScript()
        ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/scripts/jquery.min.js');
$this->headScript()
->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/scripts/wow.js')
?>

 <script>
	  new WOW().init();
</script>

<?php if( !empty($this->description) ) : ?>
    <div class="widgets_title_border">
	   <span></span>
	   <i></i>
	   <span></span>
   </div>
  <div class="widgets_title_description">
    <?php echo $this->description; ?>
  </div>
<?php endif; ?>

<?php

$this->headLink()
        ->prependStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_sitereview.css');
?>

  <?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>


  <?php
  $ratingValue = $this->ratingType;
  $ratingShow = 'small-star';
  if ($this->ratingType == 'rating_editor') {
    $ratingType = 'editor';
  } elseif ($this->ratingType == 'rating_avg') {
    $ratingType = 'overall';
  } else {
    $ratingType = 'user';
  }
  ?>
      <div class="sr_card_view">
        <?php if (!empty($this->showMorelink)) : ?>
          <div class="seeall" >
           <?php echo $this->htmlLink(array('route' => 'sitereview_general_listtype_'.$this->listingtype_id, 'action' => 'index', "listingtype_id" => $this->listingtype_id,),
             $this->translate('See All') . '<i class="fa fa-angle-double-right"></i>',
             array( 'class' => '')); ?>
          </div>
        <?php endif; ?>
		  <!-- <div class="seeall" style="text-align: right;"><a href="#">See all <i class="fa fa-angle-double-right"></i></a></div> -->
        <ul>
          <?php $i = 0; ?>
          <?php foreach ($this->listings as $sitereview): ?>
  
  <li class="wow animated slideInUp" style="height: <?php echo ($this->blockHeight) ?>px;">
				<?php if($sitereview->newlabel && $this->newIcon):?>
					<i class="sr_list_new_label" title="<?php echo $this->translate('New'); ?>"></i>
				<?php endif;?>
         <div class="sr_card_view_image">
			  <a href="<?php echo $sitereview->getHref(array('profile_link' => 1)) ?>" title="<?php echo $sitereview->getTitle()?>">
			  <?php
			  $url = $this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/images/nophoto_listing_thumb_main.png';
			  $temp_url = $sitereview->getPhotoUrl('thumb.main');
			  if (!empty($temp_url)): $url = $sitereview->getPhotoUrl('thumb.main');
			  endif;
			  ?>
			  <span style="background-image: url(<?php echo $url; ?>); "></span>
			</a>
                   
                   <?php if((!empty($this->showOptions) && (in_array('compare', $this->showOptions)||in_array('wishlist', $this->showOptions))) || $this->sponsoredIcon || $this->featuredIcon): ?>
          <span class="sr_card_view_image_hover">
            <?php if ($sitereview->sponsored == 1 && $this->sponsoredIcon): ?>
              <i title="<?php echo $this->translate('Sponsored');?>" class="sr_icon seaocore_icon_sponsored"></i>
            <?php endif; ?>
            <?php if ($sitereview->featured == 1 && $this->featuredIcon): ?>
              <i title="<?php echo $this->translate('Featured');?>" class="sr_icon seaocore_icon_featured"></i>
            <?php endif; ?>
            <?php if (Zend_Registry::get('listingtypeArray' . $sitereview->listingtype_id)->wishlist && !empty($this->showOptions) && in_array('wishlist', $this->showOptions)): ?> 
              <?php echo $this->addToWishlist($sitereview, array('classIcon' => 'icon_wishlist_add', 'classLink' => 'sr_wishlist_link', 'text' => ''));?>
            <?php endif; ?>
          </span>
      <?php endif; ?>
                    
        </div>
<div class="sr_card_view_info">
      <?php if(!empty($this->showOptions) && in_array('creationDate', $this->showOptions)): ?>
        <div class="listing_date">
         <i class="fa fa-clock-o"></i>
          <?php
            $date = date("F d, Y", strtotime($sitereview->creation_date));
            echo $date;
            ?>
        </div>
      <?php endif;?>
      <div class="sr_title">
        <?php echo $this->htmlLink($sitereview->getHref(), Engine_Api::_()->seaocore()->seaocoreTruncateText($sitereview->getTitle(), $this->title_truncation), array('title' => $sitereview->getTitle())) ?>
      </div>
      
      <?php if(!empty($this->showOptions) && (in_array('category', $this->showOptions) || in_array('review', $this->showOptions) ||in_array('rating', $this->showOptions))): ?>
                  <div class="sr_ratingbar seaocore_txt_light">
            <?php $listingtypeArray = Zend_Registry::get('listingtypeArray' . $sitereview->listingtype_id); ?>
            <?php if(($listingtypeArray->reviews == 3 || $listingtypeArray->reviews == 2) && (!empty($this->showOptions) && in_array('review', $this->showOptions))): ?>
            <?php endif; ?>
            <?php if(!empty($this->showOptions) && in_array('rating', $this->showOptions)): ?>          
              <?php if ($ratingValue == 'rating_both'): ?>
                <?php echo $this->showRatingStar($sitereview->rating_editor, 'editor', $ratingShow, $sitereview->listingtype_id); ?>
                <br />
                <?php echo $this->showRatingStar($sitereview->rating_users, 'user', $ratingShow, $sitereview->listingtype_id); ?>
              <?php else: ?>
                <?php echo $this->showRatingStar($sitereview->$ratingValue, $ratingType, $ratingShow, $sitereview->listingtype_id); ?>
              <?php endif; ?>
            <?php endif; ?>  
          </div> 
         <div class="sr_link_info">
          <?php if(!empty($this->showOptions) && in_array('category', $this->showOptions)): ?>
            <span class="sr_category">
             <i class="fa fa-file-text-o"></i>
              <a href="<?php echo $sitereview->getCategory()->getHref() ?>"> 
                <?php echo $this->translate($sitereview->getCategory()->getTitle(true)) ?>
              </a>
            </span>
          <?php endif; ?>
            <?php if(!empty($this->showOptions) && in_array('postedBy', $this->showOptions)): ?>
          <span>
           <i class="fa fa-user-o"></i>
            <?php echo $this->translate('Posted by');?> <?php echo $this->htmlLink($sitereview->getOwner()->getHref(), $sitereview->getOwner()->getTitle()); ?>
          </span>
        <?php endif; ?>
			</div>
      <?php endif; ?>
    
    <div class="listing_description">
            <?php $readMore = ' ' . $this->translate('Read More') ;?>
            


            <?php echo Engine_Api::_()->seaocore()->seaocoreTruncateText($sitereview->body, $this->desc_truncation) ?>
 
    </div>
  
	  </div>
	   <div class="listing_readmore">
 <?php echo $this->htmlLink($sitereview->getHref(), $readMore);?>
 </div>
  </li>
            <?php $i++; ?>
          <?php endforeach; ?>
        </ul>
        

      </div>


<style>
	@media only screen and (max-width: 1199px) {
		.sr_card_view ul > li {width: 31.5%;}
	}
	@media only screen and (max-width: 767px) {
		.sr_card_view ul > li {width: 47.9%;}
	}
	@media only screen and (max-width: 600px) {
		.sr_card_view ul > li {width: 98%;}
	}
	@media only screen and (min-width: 1200px) {
		.sr_card_view ul > li {width : <?php echo ($this->blockWidth) ?>px;}
	}
</style>