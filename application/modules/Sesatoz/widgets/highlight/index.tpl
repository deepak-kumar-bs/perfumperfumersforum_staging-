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
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/styles/animate.css'); ?>
<?php if($this->design == 7){ ?>
  <div class="sesatoz_ongoing_contest_wrapper clearfix sesbasic_bxs">
    <div class="sesatoz_ongoing_contest_inner clearfix sesbasic_bxs">
      <h3><?php echo $this->translate($this->heading); ?></h3>
      <?php if($this->widgetdescription): ?>
        <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>
      <?php endif; ?>
      <ul class="sesatoz_ongoing_contest_main">
        <?php  foreach($this->result as $result) { ?>
          <li class="sesatoz_ongoing_contest_item clearfix sesbasic_bg">
						<div class="prelative">
            <div class="sesatoz_ongoing_thumb">
              <a href="<?php echo $result->getHref(); ?>">
                <span class="sesatoz_ongoing_thumb_img" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);"></span>
              </a>
              <?php if($this->module == 'contest') { ?>
                <?php if($result->contest_type == 3):?>
                  <a href="<?php echo $result->getHref(); ?>"><span class="sescontest_ongoing_type"><i class="fa fa-video-camera"></i></span></a>
                <?php elseif($result->contest_type == 4):?>
                  <a href="<?php echo $result->getHref(); ?>"><span class="sescontest_ongoing_type"><i class="fa fa-music"></i></span></a>
                <?php elseif($result->contest_type == 2):?>
                  <a href="<?php echo $result->getHref(); ?>"><span class="sescontest_ongoing_type"><i class="fa fa-picture-o"></i></span></a>
                <?php else: ?>
                  <a href="<?php echo $result->getHref(); ?>"><span class="sescontest_ongoing_type"><i class="fa fa-file-text-o"></i></span></a>
                <?php endif; ?>
              <?php } ?>
            </div>
            <div class="sescontest_ongoing_hover_box">
              <a href="<?php echo $result->getHref(); ?>"><?php echo $this->translate("Read More"); ?></a>
            </div>
            <?php if($this->module == 'contest') { ?>
              <?php $countEntries = Engine_Api::_()->getDbTable('participants', 'sescontest')->getContestEntries($result->contest_id);?>
              <?php $viewer = Engine_Api::_()->user()->getViewer();?>
              <?php if($viewer->getIdentity()):?>
                <?php $oldTz = date_default_timezone_get();?>
              <?php endif;?>
              <?php $endtime = strtotime($result->endtime);?>
              <?php if($viewer->getIdentity()):?>
                <?php date_default_timezone_set($viewer->timezone);?>
              <?php endif;?>
              <?php $endtime = strtotime(date('Y-m-d H:i:s',$endtime));?>
              <?php $currentTime = time();?>
              <?php $diff=($endtime-$currentTime);?>
              <?php $temp = $diff/86400;?>
              <?php $dd = floor($temp); $temp = 24*($temp-$dd);?>
              <?php $hh = floor($temp); $temp = 60*($temp-$hh);?>
              <?php $mm = floor($temp); $temp = 60*($temp-$mm); ?>
              <?php $ss = floor($temp);?>
              <div class="sescontest_ongoing_item_bottom sesbasic_clearfix">
                <div class="sescontest_ongoing_item_total">
                  <div class="_ent">
                    <span class="_count"><?php echo $countEntries;?></span>
                    <span class="_text"><?php echo $this->translate("Entries"); ?></span>
                  </div>
                  <?php if(strtotime($result->endtime) > time()) {?>
                    <?php if($dd > 0) { ?>
                      <div class="_dl">
                        <span class="_count"><?php echo $dd ?></span>
                        <span class="_text"><?php echo $this->translate("Days left"); ?></span>
                      </div>
                    <?php } else { ?>
                      <div class="_countdown">
                          <span class="_count">
                          <div class="countdown-contest">
                            <div style="display: none;"><?php echo str_replace('timestamp','timestamp sescontest-timestamp-update ',$this->timestamp($result->endtime)); ?></div>
                            <?php if($dd > 0):?>
                              <div>
                                <p>
                                  <span class='day'><?php echo $dd;?></span><span><?php echo $this->translate("d")?></span>
                                </p>
                              </div>
                            <?php endif;?>
                            <div>
                              <p>
                                <span class='hour'><?php echo $hh;?></span><span><?php echo $this->translate("h")?></span>
                              </p> 
                            </div>
                            <div>
                              <p>
                                <span class='minute'><?php echo $mm;?></span><span><?php echo $this->translate("m")?></span>
                              </p>
                            </div>
                            <div>
                              <p>
                                <span class='second'><?php echo $ss;?></span><span><?php echo $this->translate("s")?></span>
                              </p>
                            </div>
                          </div>
                        </span>
                      </div>
                    <?php } ?>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
            </div>
            <div class="sescontest_ongoing_top">
              <div class="sescontest_ongoing_top_img">
                <a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $this->itemPhoto($result->getOwner(), 'thumb.icon'); ?></a>
              </div>
              <div class="sescontest_ongoing_top_info">
                <div class="sescontest_ongoing_title"><a href="<?php echo $result->getHref(); ?>"><?php echo $result->getTitle(); ?></a></div>
                <div class="sescontest_ongoing_meta"><?php echo $this->translate("by&nbsp;"); ?><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a><?php echo $this->translate("&nbsp;in&nbsp;"); ?><?php if($this->module == 'contest') { ?><?php $category = Engine_Api::_ ()->getDbtable('categories', 'sescontest')->find($result->category_id)->current();?><a href="<?php echo $category->getHref(); ?>"><?php echo $this->translate($category->category_name) ?></a><?php } ?></div>
              </div>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
<?php } else if($this->design == 6){ ?>



  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/slick.min.js'); ?>



  <?php $randonNumber = $this->identity; ?>







  <div class="sesatoz_pages_carousel_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_pages_carousel_main clearfix">



      <div class="sesatoz_pages_carousel sesatoz_pages_carousel_<?php echo $randonNumber; ?>">



        <?php  foreach($this->result as $result){    ?>



          <div class="sesatoz_pages_carousel_item">



            <a href="<?php echo $result->getHref(); ?>">



              <div class="sesatoz_pages_carousel_item_photo" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);">
              </div>

             </a>

              <div class="sesatoz_pages_carousel_item_cont clearfix">
                <span class="pages_title"><a href="<?php echo $result->getHref(); ?>"><?php echo $this->translate($result->getTitle()); ?></a></span>
                <span class="pages_description"><?php echo $this->translate($result->getDescription()); ?></span>
                
                <?php if(in_array($this->module, array('sesgroup_group', 'group'))) { ?>
                  <?php if($this->module == 'sesgroup_group') { ?>
                    <?php $members = Engine_Api::_()->getDbTable('membership','sesgroup')->groupMembers($result->group_id);?>
                  <?php } else { ?>
                    <?php $members = Engine_Api::_()->sesatoz()->groupMembers($result->group_id);?>
                  <?php } ?>
                  <span class="members_count">
                    <?php $countMember = 1;?>
                    <?php foreach($members as $member):?>
                      <?php if($countMember > 5):?>
                        <?php break;?>
                      <?php endif;?>
                      <a href="<?php echo $member->getHref();?>"><?php echo $this->itemPhoto($member, 'thumb.icon', $member->getTitle());?></a>
                      <?php $countMember++;?>
                    <?php endforeach;?>
                    <?php if(count($members) > 5):?>
                    <?php $tab_id = Engine_Api::_()->sesgroup()->getWidgetTabId(array('name' => 'sesgroup.profile-members','pageDesign' => $result->groupstyle));?>
                    <a href="<?php echo $result->getHref().'/tab/'.$tab_id;?>"><p>+<?php echo count($members) - $limitMember;?></p></a>
                    <?php endif;?>
                  </span>
                  <span class="join_btn">
                    <a href="<?php echo $result->getHref(); ?>" class="button"><i class="fa fa-plus"></i><?php echo $this->translate("Join"); ?></a>
                  </span>
                <?php } ?>
              </div>
          </div>
        <?php } ?>
      </div>



    </div>



  </div>



  <script type="text/javascript">



  sesJqueryObject('.sesatoz_pages_carousel_<?php echo $randonNumber; ?>').slick({



    centerPadding: '0px',



    slidesToShow: 1,



    responsive: [



      {



        breakpoint: 768,



        settings: {



          arrows: true,



          centerMode: false,



          centerPadding: '0',



          slidesToShow: 1



        }



      },



      {



        breakpoint: 480,



        settings: {



          arrows: true,



          centerMode: false,



          centerPadding: '0',



          slidesToShow: 1



        }



      }



    ]



  });



  </script>



<?php } else if($this->design == 5) { ?>



  <div class="sesatoz_video_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_video_wrapper_inner">



      <?php  foreach($this->result as $result){    ?>



        <div class="sesatoz_video_item">



          <a href="<?php echo $result->getHref(); ?>">



            <div class="sesatoz_video_photo" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);">

            </div>



            <div class="sesatoz_video_cont clearfix">



              <span class="video_title"><?php echo $this->translate($result->getTitle()); ?></span>



              <?php if($this->module == 'sesvideo_video' && $result->category_id) { ?>



                <?php if($this->module == 'sesvideo_video') { ?>



                  <?php $category = Engine_Api::_()->getItem('sesvideo_category', $result->category_id);  ?>



                  <span class="video_category"><?php echo $this->translate($category->category_name); ?></span>



                <?php } ?>



              <?php } ?>



            </div>



            <?php if($this->module == 'sesvideo_video' || $this->module == 'video') { ?>



              <div class="sesatoz_video_overlay">



                <div class="overlay_inner"><i class="fa fa-play"></i><a href="<?php echo $result->getHref(); ?>"><?php echo $this->translate("Watch"); ?></a></div>



              </div>



            <?php } ?>



          </a>



        </div>



      <?php } ?>



    </div>



  </div>



<?php } else if($this->design == 4){ ?>



  <div class="sesatoz_group_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_group_wrapper_inner">



      <?php  foreach($this->result as $result){    ?>



        <div class="sesatoz_group_item wow zoomIn">



          <a href="<?php echo $result->getHref(); ?>">



            <div class="sesatoz_group_photo" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);">

            </div>



              <div class="sesatoz_group_cont clearfix">



                <span class="group_title"><?php echo $this->translate($result->getTitle()); ?></span>



                <span class="group_owner"><i class="fa fa-user"></i><a href="<?php echo $result->getOwner()->getHref(); ?>"><?php echo $result->getOwner()->getTitle(); ?></a></span>



              </div>



          </a>



        </div>



      <?php } ?>



    </div>



  </div>



<?php } else if($this->design == 3){ ?>



  <?php $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/slick.min.js'); ?>



  <?php $randonNumber = $this->identity; ?>







  <div class="sesatoz_content_carousel_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_content_carousel_main clearfix">



      <div class="sesatoz_content_carousel sesatoz_content_carousel_<?php echo $randonNumber; ?>">



        <?php  foreach($this->result as $result){    ?>



          <div class="sesatoz_content_carousel_item">



            <a href="<?php echo $result->getHref(); ?>">



              <div class="sesatoz_content_carousel_item_photo" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);">
              </div>



              <div class="sesatoz_content_carousel_item_cont clearfix">



                <span class="blog_title"><?php echo $this->translate($result->getTitle()); ?></span>



                <span class="blog_description"><?php echo $this->translate($result->getDescription()); ?></span>



              </div>



              <div class="blog_date"><?php echo date("F j, Y", strtotime($result->creation_date)); ?></div>



            </a>    



          </div>



        <?php } ?>



      </div>



    </div>



  </div>



  <script type="text/javascript">



  sesJqueryObject('.sesatoz_content_carousel_<?php echo $randonNumber; ?>').slick({



    slidesToShow: 2,



    responsive: [



      {



        breakpoint: 768,



        settings: {



          arrows: true,



          slidesToShow: 2



        }



      },



      {



        breakpoint: 480,



        settings: {



          arrows: true,



          slidesToShow: 1



        }



      }



    ]



  });



  </script>



<?php } else if($this->design == 2){ ?>



  <div class="sesatoz_highlights_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_highlights_cont clearfix">



      <div class="sesatoz_highlights_cont_row clearfix">



      <?php  foreach($this->result as $result){    ?>



        <div class="sesatoz_highlights_item">



          <div class="sesatoz_highlights_item_inner">



            <div class="sesatoz_highlights_item_photo">



              <a href="<?php echo $result->getHref(); ?>">
                 <span style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);"></span>
              </a>



            </div>



            <div class="sesatoz_highlights_item_cont clearfix">



              <a href="<?php echo $result->getHref(); ?>">



                <?php echo $this->translate($result->getTitle()); ?>             



              </a>



            </div>



          </div>



        </div>



      <?php } ?>



      </div>



    </div>



  </div>



<?php }else{ ?>



  <div class="sesatoz_content_wrapper clearfix sesbasic_bxs">



    <h3><?php echo $this->translate($this->heading); ?></h3>



    <?php if($this->widgetdescription): ?>



      <p class="sesbasic_text_light"><?php echo $this->translate($this->widgetdescription); ?></p>



    <?php endif; ?>



    <div class="sesatoz_content_inner clearfix">



      <?php foreach($this->result as $result) { ?>



        <div class="sesatoz_content_item sesbasic_bg wow zoomIn">



          <a href="<?php echo $result->getHref(); ?>">



            <div class="sesatoz_content_item_img" style="background-image:url(<?php echo $result->getPhotoUrl('thumb.normal'); ?>);">

            </div>



            <div class="sesatoz_content_item_inner sesbasic_bg">



              <div class="sesatoz_content_item_title">



                <?php echo $this->translate($result->getTitle()); ?>



              </div>



              <?php if(isset($result->category_id) && !empty($result->category_id) && ($this->module == 'sesevent_event' || $this->module == 'event')) { ?>



              <div class="sesatoz_content_data">


                <?php if($this->module == 'sesevent_event') { ?>
                  <?php $category = Engine_Api::_()->getItem('sesevent_category', $result->category_id); ?>
                <?php } else { ?>
                  <?php $category = Engine_Api::_()->getItem('event_category', $result->category_id); ?>
                <?php } ?>



                <div class="sesatoz_content_data">



                  <?php if(isset($category->title)) { ?>



                    <span class="_cat"><?php echo $this->translate($category->title); ?></span>



                  <?php } elseif(isset($category->category_name)) { ?>



                    <span class="_cat"><?php echo $this->translate($category->category_name); ?></span>



                  <?php } ?>



                </div>



              </div>



              <?php } ?>



              <div class="_desc sesbasic_text_light"><?php echo $this->translate($result->getDescription()); ?></div>



            </div>



          </a>



        </div>



      <?php } ?>



    </div>



  </div>



<?php } ?>



