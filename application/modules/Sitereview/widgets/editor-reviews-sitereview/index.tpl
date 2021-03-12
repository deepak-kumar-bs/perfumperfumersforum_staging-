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

<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Seaocore/externals/styles/style_comment.css'); ?>

<?php
if($this->addEditorReview):
$this->headLink()
        ->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_rating.css');
endif;

$this->headLink()
        ->prependStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/styles/style_sitereview.css');
if ($this->show_slideshow):
  $this->headScript()
          ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sitereview/externals/scripts/_class.noobSlide.packed.js');
endif;
?>

<?php if ($this->loaded_by_ajax): ?>
  <script type="text/javascript">
    var params = {
      requestParams :<?php echo json_encode($this->params) ?>,
      responseContainer :$$('.layout_sitereview_editor_reviews_sitereview')  
    }
    en4.sitereview.ajaxTab.attachEvent('<?php echo $this->identity ?>',params);
  </script>
<?php endif; ?>

<?php if ($this->showContent): ?>
  <?php if($this->addEditorReview): ?>
    <script type="text/javascript">
      var editorPageAction = function(page){

        $('pagination_loader_image').style.display ='block';

        var url = en4.core.baseUrl + 'widget/index/mod/sitereview/name/editor-reviews-sitereview';
        en4.core.request.send(new Request.HTML({
          'url' : url,
          'data' : {
            'format' : 'html',
            subject : en4.core.subject.guid,
            'isAjax' : 1,
            'page' : page
          },
          onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript) {        
            $('pagination_loader_image').style.display ='none';
          }
        }), {
          'element' : $('editorReviewContent').getParent()
        });
      }
    </script>
  <?php endif; ?>

  <div class="sr_profile_tab_content clr">
    <?php if ($this->show_slideshow): ?>
      <?php echo $this->content()->renderWidget("sitereview.slideshow-list-photo", array('show_slideshow_always' => 1, 'slideshow_width' => $this->slideshow_width, 'slideshow_height' => $this->slideshow_height, 'showCaption' => $this->showCaption, 'captionTruncation' => $this->captionTruncation, 'showButtonSlide' => $this->showButtonSlide, 'mouseEnterEvent' => $this->mouseEnterEvent, 'thumbPosition' => $this->thumbPositions, 'autoPlay' => $this->autoPlay, 'slidesLimit' => $this->slidesLimit)) ?>
    <?php endif; ?>
    <div id='editorReviewContent'>




    <?php if($this->addEditorReview): ?>


      <!-- make this overall review -->
      <?php if($this->canshowratings): ?>
        <div class="sr_profile_review b_medium sr_review_block">
          <div class="sr_profile_review_left">
            <?php if($this->canshowratings): ?>
                
              <div class="sr_profile_review_title">
                <?php echo $this->translate("Average Editor Rating"); ?>
              </div>   
              <div class="sr_profile_review_stars">
                    <span class="sr_profile_editorreview_overall_rating">
                      <span class="fleft">
                        <?php echo $this->showRatingStar($this->sitereview->rating_editor, 'editor', 'big-star', $this->sitereview->listingtype_id); ?>
                      </span>
                      <?php if (count($ratingData) > 1): ?>
                        <i class="arrow_btm fleft"></i>
                      <?php endif; ?>
                     </span> 
              </div>  

            <?php endif; ?>
          </div>
        
          <div class="sr_profile_review_user fright">
            <?php if($this->canshowratings): ?>
              <div class="sr_profile_review_title t_right">
                <?php echo $this->translate("Average User Rating"); ?>
              </div>   
              <div class="clr sr_profile_review_stars fright sr_profile_review_rating_right">
                <?php if (count($this->userRatingDataTopbox) > 1): ?>
                  <i class="arrow_btm fright"></i>
                <?php endif; ?>
                <span class="fright">
                  <?php echo $this->showRatingStar($this->sitereview->rating_users, 'user', 'big-star', $this->sitereview->listingtype_id); ?>
                </span>
              </div>

              <?php if (count($this->userRatingDataTopbox) > 1): ?>
                <div class="sr_ur_bdown_box_wrapper_right br_body_bg b_medium">
                  <div class="sr_ur_bdown_box">
                    <div class="sr_profile_review_title">
                      <?php echo $this->translate("Average User Rating"); ?>
                    </div>
                    <div class="sr_profile_review_stars clr">
                      <?php echo $this->showRatingStar($this->sitereview->rating_users, 'user', 'big-star', $this->sitereview->listingtype_id); ?>
                    </div>
                    <?php if($this->listingType->allow_review):?>
                      <div class="sr_profile_review_stat clr">
                        <?php //echo $this->translate(array('%s user review', '%s user reviews', ($this->sitereview->review_count - 1)), $this->locale()->toNumber(($this->sitereview->review_count - 1))) ?>
                        <?php echo $this->translate(array('Based on %s review', 'Based on %s reviews', $this->subject()->getNumbersOfUserRating('user')), '<b>'.$this->locale()->toNumber($this->subject()->getNumbersOfUserRating('user')).'</b>') ?>
                      </div>
                    <?php endif;?>
                    <div class="sr_profile_review_title mtop10">
                      <?php echo $this->translate("Rating Parameter"); ?>
                    </div>
                    <div class="sr_profile_rating_parameters">
                      <?php foreach ($this->userRatingDataTopbox as $reviewcatTopbox): ?>
                        <?php if (!empty($reviewcatTopbox['ratingparam_name'])): ?>
                          <div class="o_hidden">
                            <div class="parameter_title">
                              <?php echo $this->translate($reviewcatTopbox['ratingparam_name']) ?>
                            </div>
                            <div class="parameter_value">
                              <?php echo $this->showRatingStar($reviewcatTopbox['avg_rating'], 'user', 'small-box', $this->sitereview->listingtype_id,$reviewcatTopbox['ratingparam_name']); ?>
                            </div>
                            <div class="parameter_count"><?php echo $this->subject()->getNumbersOfUserRating('user', $reviewcatTopbox['ratingparam_id']); ?>
                            </div>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                    <div class="clr"></div>
                  </div>
                </div>
              <?php endif; ?>
              <!--Rating Breakdown Hover Box Ends-->
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>

      <div class="sr_browse_lists_view_options b_medium">
        <div> 
          <?php echo $this->translate(array("%s $this->reviewTitleSingular found.", "%s $this->reviewTitlePlular found.", count($this->reviews)), $this->locale()->toNumber(count($this->reviews))) ?></div>
      </div>

      <div class="editor_review_heading"><?php echo $this->translate("Editor $this->reviewTitlePlular") ?></div>

      <?php foreach ($this->reviews as $key => $review):?>

       <!--  <?php if ($this->current == 1): ?> -->
          <div id="review_content">
            
             

            <div class="">
              <div class="">

                <div class="sr_editor_full_review">

                  <?php if($review->title):?>
                    <div class="sr_reviews_listing_proscons">
                      <?php //echo '<b>' . $this->translate("The Bottom Line:") . ' </b>' . $review->title; ?>
                      <?php echo '<b>' .$review->title . '</b>'; ?>
                    </div>
                  <?php endif;?>
                  

                  <div class="">
                <?php if ($this->min_price < 0): ?>
                  <div class="sr_profile_review_title">
                    <?php // echo $this->translate("Review Date:"); ?>
                  </div>
                  <div>
                    <?php echo $this->timestamp(strtotime($review->creation_date)) ?>
                  </div>
                <?php else: ?>
                  <div>
                    <?php if ($this->min_price == $this->max_price && $this->min_price > 0): ?>
                      <span style='font-size:24px;'>
                        <?php echo Engine_Api::_()->sitereview()->getPriceWithCurrency($this->min_price); ?>
                      </span>
                    <?php elseif($this->min_price > 0 && $this->max_price > 0): ?>

                      <?php echo $this->translate("%s to %1s", "<span style='font-size:24px;'>" . Engine_Api::_()->sitereview()->getPriceWithCurrency($this->min_price). "</span>", Engine_Api::_()->sitereview()->getPriceWithCurrency($this->max_price)); ?>
                    <?php endif; ?>
                    <div>
                      <?php // echo $this->translate("Review Date:"); ?>
                      <?php echo $this->timestamp(strtotime($review->creation_date)); ?>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
                  <?php  echo $this->translate("By:"); ?>
                  <?php echo $review->getOwner(); ?>
                </div>
                <div class="">
                  <?php if($this->canshowratings): ?>
                      
                    <div class="sr_profile_review_title">
                      <?php // echo $this->translate("Editor Rating"); ?>
                    </div>   
                    <div class="sr_profile_review_stars">
                      <?php $ratingData = Engine_Api::_()->getDbtable('ratings', 'sitereview')->profileRatingbyCategory($review->review_id); ?>
                      <?php foreach ($ratingData as $reviewCat): ?>
                        <?php if (empty($reviewCat['ratingparam_name'])): ?>
                          <span class="sr_profile_editorreview_overall_rating">
                            <span class="fleft">
                              <?php echo $this->showRatingStar($reviewCat['rating'], 'editor', 'big-star', $this->sitereview->listingtype_id); ?>
                            </span>
                            <?php if (count($ratingData) > 1): ?>
                              <i class="arrow_btm fleft"></i>
                            <?php endif; ?>
                           </span> 
                          <?php break; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>  

                    <!--Rating Breakdown Hover Box Starts-->
                    <?php if (count($ratingData) > 1): ?>
                      <div class="sr_ur_bdown_box_wrapper br_body_bg b_medium">
                        <div class="sr_ur_bdown_box">
                          <div class="sr_profile_review_title">
                            <?php echo $this->translate("Editor Rating"); ?>
                          </div>   
                          <div class="sr_profile_review_stars">
                            <?php foreach ($ratingData as $reviewCat): ?>
                              <?php if (empty($reviewCat['ratingparam_name'])): ?>
                                <?php echo $this->showRatingStar($reviewCat['rating'], 'editor', 'big-star', $this->sitereview->listingtype_id); ?>
                                <?php break; ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </div>  

                          <div class="sr_profile_rating_parameters">
                            <?php foreach ($ratingData as $reviewCat): ?>
                              <?php if (empty($reviewCat['ratingparam_name'])): ?>
                                <?php continue; ?>
                              <?php endif; ?>
                              <div class="o_hidden">
                                <div class="parameter_title">
                                  <?php echo $this->translate($reviewCat['ratingparam_name']); ?>
                                </div>
                                <div class="parameter_value">
                                  <?php echo $this->showRatingStar($reviewCat['rating'], 'editor', 'small-box', $this->sitereview->listingtype_id,$reviewCat['ratingparam_name']); ?>
                                </div>
                              </div>  
                            <?php endforeach; ?>
                          </div>
                          <div class="clr"></div>
                        </div>
                      </div>
                    <?php endif; ?>
                    <!--Rating Breakdown Hover Box Ends-->
                  <?php endif; ?>
                </div>
              
              

            </div> 

              <!-- <?php if($review->pros):?>
              <div class='sr_reviews_listing_proscons'>
                <?php echo '<b>' . $this->translate("The Good:") . ' </b>' . $this->viewMore($review->pros); ?>
              </div>
              <?php endif;?>
              <?php if($review->cons):?>
              <div class="sr_reviews_listing_proscons"> 
                <?php echo '<b>' . $this->translate("The Bad:") . ' </b>' . $this->viewMore($review->cons); ?>
              </div>
              <?php endif;?>

              <?php if($review->title):?>
              <div class="sr_reviews_listing_proscons">
                <?php echo '<b>' . $this->translate("The Bottom Line:") . ' </b>' . $review->title; ?>
              </div>
              <?php endif;?> -->

              <?php if($review->profile_type_review): ?>
                <div class="sr_reviews_listing_proscons"> 
                  <?php $custom_field_values = $this->fieldValueLoopReview($review, $this->fieldStructure); ?>
                  <?php echo htmlspecialchars_decode($custom_field_values); ?>        
                </div>   
              <?php endif; ?>

              <!-- <?php if($review->update_reason):?>
              <div class="sr_reviews_listing_proscons">
                <?php echo '<b>' . $this->translate("Update On "). $this->timestamp(strtotime($review->modified_date)) . ':</b>' . $review->update_reason; ?>
              </div>
              <?php endif;?> -->          

          </div>
        <!-- <?php endif; ?> -->

              
        <!-- 
          <?php if ($this->showconclusion && $this->review->body): ?>
            <div class='sr_reviews_listing_proscons sr_editor_review_conclusion b_medium'>
              <?php echo '<b>' . $this->translate("Conclusion: ") . '</b>'; ?>
              <?php echo $this->review->body; ?>
            </div>
          <?php endif; ?>
          <?php if ($this->pageCount > 1): ?>
            <div class="seaocore_pagination o_hidden"> 
              <div class="pages fright">    
                <ul class="paginationControl">
                  <?php /* Previous page link */ ?>
                  <?php if (isset($this->previous)): ?>
                    <li>
                      <a href="javascript:void(0)" onclick="javascript:editorPageAction('<?php echo $this->previous; ?>')"><?php echo $this->translate("&#171; Previous") ?></a>
                    </li>
                  <?php endif; ?>

                  <?php foreach ($this->pagesInRange as $page): ?>
                    <?php if ($page != $this->current): ?>
                      <li>
                        <a href="javascript:void(0)" onclick="javascript:editorPageAction('<?php echo $page; ?>')"><?php echo $page; ?></a>
                      </li>
                    <?php else: ?>
                      <li class="selected">
                        <a href="javascript:void(0)"><?php echo $page; ?></a>
                      </li>
                    <?php endif; ?>
                  <?php endforeach; ?>

                  <?php /* Next page link */ ?>
                  <?php if (isset($this->next)): ?>
                    <li>
                      <a href="javascript:void(0)" onclick="javascript:editorPageAction('<?php echo $this->next; ?>')"><?php echo $this->translate("Next &#187;") ?></a>
                    </li>	
                  <?php endif; ?>
                </ul>
              </div>
              <span id="pagination_loader_image" style="display:none;">
                <img src="<?php echo $this->layout()->staticBaseUrl; ?>application/modules/Seaocore/externals/images/core/loading.gif" alt="" />
              </span>  
            </div> 
            </div>
          <?php endif; ?> -->

          <dir class="editor_review_body">
            <?php // echo $this->body_pages; ?>
            <?php echo $review->body; ?>
          </dir>

      <?PHP endforeach; ?>

    <?php else:?>
      <div class="sr_profile_overview">
        <?php if(empty($this->CanShowOverview)):?>
					<?php echo nl2br($this->sitereview->body);?>
				<?php else:?>
				  <?php echo $this->listingType->overview && $this->overview ? $this->overview : nl2br($this->sitereview->body)?>
				<?php endif;?>
      </div>	
    <?php endif;?>
    </div>
  </div>

  <?php 

   //CHECK IF THE FACEBOOK PLUGIN IS ENABLED AND ADMIN HAS SET ONLY SHOW FACEBOOK COMMENT BOX THEN WE WILL NOT SHOW THE SITE COMMENT BOX.
   $fbmodule = Engine_Api::_()->getDbtable('modules', 'core')->getModule('facebookse');
   $success_showFBCommentBox = 0;
   $checkVersion = Engine_Api::_()->sitereview()->checkVersion($fbmodule->version, '4.2.7p1');
   if (!empty($fbmodule) && !empty($fbmodule->enabled) && $checkVersion == 1) {

     $success_showFBCommentBox =  Engine_Api::_()->facebookse()->showFBCommentBox ('sitereview');
   }

  ?>

  <?php if( empty($this->isAjax) && $this->showComments && $success_showFBCommentBox != 1):?>
     <?php 
        include_once APPLICATION_PATH . '/application/modules/Seaocore/views/scripts/_listNestedComment.tpl';
    ?>
  <?php endif;?>

  <?php if( empty($this->isAjax) && $success_showFBCommentBox != 0):?>
     <?php  echo $this->content()->renderWidget("Facebookse.facebookse-comments", array("type" => $this->sitereview->getType(), "id" => $this->sitereview->listing_id, 'task' => 1, 'module_type' => 'sitereview' , 'curr_url' => ( _ENGINE_SSL ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $this->sitereview->getHref()));?>
  <?php endif;?>

  <?php if($this->addEditorReview): ?>
    <script type="text/javascript">
      en4.core.runonce.add(function() {
        <?php if ($this->current == 1 && count($ratingData) > 1): ?>
          $$('.sr_profile_editorreview_overall_rating').addEvents({
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

        <?php if (count($this->userRatingDataTopbox) > 1): ?>
          $$('.sr_profile_review_rating_right').addEvents({
          'mouseover': function(event) {
            document.getElements('.sr_ur_bdown_box_wrapper_right').setStyle('display','block');
          },
          'mouseleave': function(event) {    
            document.getElements('.sr_ur_bdown_box_wrapper_right').setStyle('display','none');
          }});
          $$('.sr_ur_bdown_box_wrapper_right').addEvents({
          'mouseenter': function(event) {
            document.getElements('.sr_ur_bdown_box_wrapper_right').setStyle('display','block');
          },
          'mouseleave': function(event) {
            document.getElements('.sr_ur_bdown_box_wrapper_right').setStyle('display','none');
          }});
        <?php endif; ?> 
      });
    </script>
  <?php endif; ?>
<?php endif; ?>
