<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: manage.tpl 9987 2013-03-20 00:58:10Z john $
 * @author     Jung
 */
?>
<?php
  $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl. 'application/modules/Siteqa/externals/styles/style_siteqa.css');?>
<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
<div class="question_view" id="question_view">
  <ul class="question_inner_view list_wrapper" id="question_inner_view">
    <?php if(empty($this->is_ajax)) { ?>
      <li>
        <div class="protile-top-sec">
          <div class="user-details"> <span><?php echo $this->htmlLink($this->user($this->question->owner_id)->getHref(), $this->itemBackgroundPhoto($this->user($this->question->owner_id), 'thumb.icon')) ?></span> 
            <?php 
                  echo $owner_name = $this->user($this->question->owner_id)->displayname;
                  ?>  </div>     
          <div class="coutn-stus">
            <p class="ans"> <span><?php echo $this->paginator->getTotalItemCount(); ?></span><?php echo $this->translate('Answers');?></p>
            <p class="view"><span><?php echo $this->question->view_count; ?> </span><?php echo $this->translate('Views');?></p>
            
              <?php if($this->question->vote_count >= 0) : ?>
                <p class="Votes">
                <span id="que_item_votes"><?php echo
                  $this->locale()->toNumber($this->question->vote_count); ?>
                </span>
              <?php else : ?>
                <p class="Votes neg_vote">
                <span id="que_item_votes"><?php echo
                  $this->locale()->toNumber($this->question->vote_count); ?>
                </span>
              <?php endif;
         if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()){
           echo $this->htmlLink(array('route' => 'vote_view', 
              'module' => 'siteqa',
              'controller' => 'index',
              'action' => 'votecheck',
              'id' => $this->question->question_id,
              'type' => 'siteqa_que',
              'format' => 'smoothbox'), 
             $this->translate('Votes'), array(
              'class' => 'buttonlink smoothbox icon_qa_delete'
             ));
         }else{
            echo $this->translate('Votes');
         }
         ?></p>
          </div>
        </div>

        <?php if($this->question->photo_id) : ?>
        <div class="question-img-wrp">
          <a target="_blank" href="<?php echo $this->question->getPhotoUrl();?>">
            <span class="thumbs_photo">
            <span><?php echo $this->itemBackgroundPhoto($this->question, 'thumb.main') ?></span>
            </span>
          </a>
        </div>
      <?php endif; ?>

        <div class='questions_info'>
          <div class="vot-container">
          <?php if($this->question->owner_id != Engine_Api::_()->user()->getViewer()->getIdentity()):
           if($this->level_id) : ?>
          <div class="voting-wrp">                
            <label for="votes" title="Up Vote" class="container">
              <input  type="radio" id="vote" name="votes" value="1" data-type="siteqa_que" data-id="<?php echo $this->question->question_id ?>" onclick="votesCheck(this)">
              <span class="positive checkmark">
              </span>
            </label>

            <label for="votes" title="Down Vote" class="container">
              <input  type="radio" id="vote" name="votes" value="-1" data-type="siteqa_que" data-id="<?php echo $this->question->question_id ?>" onclick="votesCheck(this)">
              <span class="negative checkmark">
              </span>
            </label>
          </div>
        <?php endif; endif; ?>
        </div> 
          
          <div class='ques_browse_info_title'>
            <span>
              <h3><?php echo $this->question->title ?></h3>
            </span>
            <div class="profile-view-info">
                        <p class="profile-cato">
            <span>In:</span>
            <span><?php echo (Engine_Api::_()->getItem('siteqa_category', 
                  $this->question->category_id))->category_name;?> </span>
                  </p>
            <p>
            <span><?php echo $this->translate('Asked On');?> : </span>
            <?php echo $this->timestamp(strtotime($this->question->creation_date))?></p>
          </div>
            <?php
            if($this->level_id) :
              $viewer = Engine_Api::_()->user()->getViewer();
              $itemEdit = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'edit');
              $itemDelete = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'delete');
              if((!empty($itemEdit)) || (!empty($itemDelete))) :
            ?>
            <div class='ques_options'>            
                <?php if($itemEdit == 2 || $itemDelete == 2) : ?>
                   <p class="dott">
                    <span></span>
                    <span></span> 
                    <span></span> 
                   </p>
              <?php else : ?>
                    <?php if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) : ?>
                    <p class="dott">
                    <span></span>
                    <span></span> 
                    <span></span> 
                   </p>
                 <?php endif; endif; ?>

              <div class="hover-opt">
                  <?php if($itemEdit == 1): 
                    if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) :?>
                    <span>
                     <?php echo $this->htmlLink(array(
                      'action' => 'edit',
                      'question_id' => $this->question->question_id,
                      'route' => 'qa_specific',
                      'reset' => true,
                      ), $this->translate('Edit'), array(
                      'class' => 'buttonlink icon_qa_edit',
                      )) ?>
                    </span>
                  <?php endif; elseif($itemEdit == 2) : ?>
                    <span>
                     <?php echo $this->htmlLink(array(
                      'action' => 'edit',
                      'question_id' => $this->question->question_id,
                      'route' => 'qa_specific',
                      'reset' => true,
                      ), $this->translate('Edit'), array(
                      'class' => 'buttonlink icon_qa_edit',
                      )) ?>
                    </span>
                  <?php endif;

                  if($itemDelete == 1) : 
                    if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity()) :?>
                    <span>
                       <?php
                       echo $this->htmlLink(array('route' => 'qa_specific', 
                        'module' => 'siteqa',
                        'controller' => 'index',
                        'action' => 'delete',
                        'question_id' => $this->question->question_id, 
                        'format' => 'smoothbox'), 
                       $this->translate('Delete'), array(
                        'class' => 'buttonlink smoothbox icon_qa_delete'
                       )); ?>
                    </span>
                  <?php endif; elseif($itemDelete == 2) : ?>
                    <span>
                       <?php
                       echo $this->htmlLink(array('route' => 'qa_specific', 
                        'module' => 'siteqa',
                        'controller' => 'index',
                        'action' => 'delete',
                        'question_id' => $this->question->question_id, 
                        'format' => 'smoothbox'), 
                       $this->translate('Delete'), array(
                        'class' => 'buttonlink smoothbox icon_qa_delete'
                       )); ?>
                    </span>
                  <?php endif; ?>
                </div>
              </div>

              <?php endif; endif; ?>         
          </div>
        <div class="qa-profile-tag">
          <?php if (count($this->questionTags )):?>
          <?php foreach ($this->questionTags as $tag): ?>
          <span><a href='javascript:void(0);' onclick=''>#<?php echo $tag->getTag()->text?></a></span>
          <?php endforeach; ?>
          <?php endif; ?>
        </div> 
          <p class='ques_browse_info_blurb'><?php echo $this->question->body ?></p>

      <?php $settings = Engine_Api::_()->getApi('settings', 'core');
      if($this->level_id) : ?>

        <div class="answer-btn">
          <?php
              if($this->question->owner_id != Engine_Api::_()->user()->getViewer()->getIdentity() && Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'posting')) :
                echo $this->htmlLink(array('route' => 'qa_general', 
                  'module' => 'siteqa',
                  'controller' => 'index',
                  'action' => 'answer',
                  'question_id' => $this->question->question_id, 
                  'format' => 'smoothbox'), 
                $this->translate('Post Answer'), array(
                  'class' => 'buttonlink smoothbox icon_qa_info'
                ));
                endif;
            ?>
        </div>
  </div>
  <?php if($settings->getSetting('siteqa.share') == 1) : ?>
  <div class="qa-share">
        <span><?php echo $this->translate('Share')?></span>
        <?php $urlencode = urlencode(((!empty($_ENV["HTTPS"]) && 'on' == strtolower($_ENV["HTTPS"])) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . $this->question->getHref(array('showEventType' => 'upcoming')));
          $object_link = (_ENGINE_SSL ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $this->question->getHref();?>

            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $urlencode ?>" class="siteqa-fb"><i class="fab fa-facebook-f"></i><?php echo $this->translate('') ?>
            </a>

            <a target="_blank" href="http://twitter.com/share?text=<?php echo  $this->question->getTitle() ?>&url=<?php echo $urlencode ?>" class="siteqa-twitter"><i class="fab fa-twitter"></i><?php echo $this->translate('')?> </a>    

            <a target="_blank" href="https://plus.google.com/share?url=<?php echo $urlencode ?>&t=<?php echo $this->question->getTitle() ?>" class="siteqa-google"><i class="fab fa-google-plus-g"></i><?php echo $this->translate('') ?></a>        

            <a target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $object_link ?>" class="siteqa-linkedin"><i class="fab fa-linkedin-in"></i><?php echo $this->translate('') ?></a>

            <?php echo $this->htmlLink(array('route' => 'default', 
                  'module' => 'activity',
                  'controller' => 'index',
                  'action' => 'share',
                  'format' => 'smoothbox',
                  'type' => $this->question->getType(),
                  'id' => $this->question->getIdentity()), 
                  $this->translate(''), array(
                  'class' => 'buttonlink smoothbox icon_comments'
                  ));
            ?>

    </div>
    <?php endif; endif;?>

    <?php 
    //COMMENT PERMISSION
    if($this->level_id) :
    $itemComment = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $this->level_id, 'comment');
    if($itemComment) : ?>
    <div><?php echo $this->content()->renderWidget("core.comments");?></div>
  <?php endif; endif; ?>

</li>
<?php } ?>

<li class="answer-list">
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?> 
    <?php if(empty($this->is_ajax)) { ?> <h2><?php echo $this->translate('Answers');?></h2> <?php } ?>
    <?php foreach( $this->paginator as $item ): ?>
      <div class='questions_info'>
        <span class='ques_browse_info_title'>  
        <?php if($this->level_id) :
              if($item['owner_id'] != Engine_Api::_()->user()->getViewer()->getIdentity()) : ?>
                <div class="voting-wrp">                
                <label for="votes" title="Up Vote" class="container">
                  <input  type="radio" id="vote" name="votes" value="1" data-type="siteqa_ans" data-id="<?php echo $item['answer_id'] ?>" onclick="votesCheck(this)">
                  <span class="positive checkmark">
                  </span>
                </label>
              <span id="ans_item_votes_<?php echo $item['answer_id'] ?>" class="answer-count">
                <?php
                  $votes =  Engine_Api::_()->getDbtable('votes', 'siteqa')->getTotalVotes('siteqa_ans',$item['answer_id']); 
                  echo ($votes) ? $this->locale()->toNumber($votes) : 0; ?>
              </span>

              <label for="votes" title="Down Vote" class="container">
                <input  type="radio" id="vote" name="votes" value="-1" data-type="siteqa_ans" data-id="<?php echo $item['answer_id'] ?>" onclick="votesCheck(this)">
                <span class="negative checkmark">
                </span>
              </label>
            </div> 
          <?php endif; endif; ?>    
          <?php if($item->photo_id) : ?>
            <div class="question-img-wrp">
              <a target="_blank" href="<?php echo $item->getPhotoUrl();?>">
                <span class="thumbs_photo">
                  <?php echo $this->itemBackgroundPhoto($item, 'thumb.main') ?>
                </span>
              </a>
            </div>
          <?php endif; ?>

          <p> <?php echo $item->body ?></p>
          <?php if($item['owner_id'] == Engine_Api::_()->user()->getViewer()->getIdentity()) : ?>
          <div class="ques_options">
            <p class="dott">
              <span></span>
              <span></span>
              <span></span>
            </p>
            <div class="hover-opt">
             <?php
              echo $this->htmlLink(array('route' => 'ans_specific', 'module' => 'siteqa', 'controller' => 'index', 'action' => 'answeredit', 'answer_id' => $item['answer_id']), $this->translate('Edit'), array(
                'class' => 'buttonlink smoothbox icon_qa_edit',
              )) ?>
              <?php
              echo $this->htmlLink(array('route' => 'ans_specific', 'module' => 'siteqa', 'controller' => 'index', 'action' => 'answerdelete', 'answer_id' => $item['answer_id']), 
                $this->translate('Delete'), array(
                  'class' => 'buttonlink smoothbox icon_qa_delete'
                ));
              ?>
            </div>
          </div>  
        <?php endif;?>
      </span>
      <div class="answer-post-info">
        <div class="user-wrp">
    <div class="helpful_btn">
      <?php $answer_id = Engine_Api::_()->getDbtable('helps', 'siteqa')->getHelpful($this->question->question_id,$this->question->owner_id);?>
      <span id="temp_answer" data-id="<?php echo $answer_id ?>"></span>
    <?php if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity() && (Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $this->level_id, 'helpful'))) : ?>
    <button id="answer_helpful_<?php echo $item['answer_id'] ?>" class="btn btn-success answer_helpful" data-type="siteqa_ans" data-id="<?php echo $item['answer_id'] ?>" onclick="markHelpful(this)"><?php echo $this->translate('Best Answer');?></button>
    <?php endif; ?>
  <span id="marked_helpful_<?php echo $item['answer_id'] ?>" class="marked_helpful" style="display: none"><?php echo $this->translate('Marked Best Answer');?></span>
    </div>
    </div>
        <p>
            <span class="tille-info posted"><?php echo $this->translate('');?> 
            <i class="fas fa-user"></i></span> 
            <span><?php echo $this->user($item->owner_id)->username;?></span>
          </p>
          <p>
            <span class="tille-info created"><?php echo $this->translate('');?> 
            <i class="fas fa-clock"></i> </span>
            <span><?php echo $this->timestamp(strtotime($item->creation_date))?></span>
          </p>
      </div>
<?php endforeach; endif; ?>
</li>
</ul>
<div class="clr" id="scroll_bar_height"></div>
<div class="seaocore_view_more" id="loding_image" style="display:none;">
  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/loading.gif' style='margin-right: 5px;' />
  <?php echo $this->translate("Loading ...") ?>
</div>
<div id="hideResponse_div"> </div>
</div>
<script type="text/javascript">
  $$('.core_main_question').getParent().addClass('active');

  en4.core.runonce.add(function() {
    var temp = $('temp_answer').getAttribute('data-id');
    $('marked_helpful_'+temp).style.display = 'inline-block';
    <?php if($this->question->owner_id == Engine_Api::_()->user()->getViewer()->getIdentity() && (Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $this->level_id, 'helpful'))) : ?>
    $('answer_helpful_'+temp).style.display = 'none';
  <?php endif; ?>
    var totalCount = '<?php echo $this->paginator->count(); ?>';
    var currentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';
    function viewMorePage()
    {
      var viewType = 4;
      //$('seaocore_view_more').style.display = 'none';
      $('loding_image').style.display = '';
      var params = {
        requestParams:<?php echo json_encode($this->params) ?>
      };
      setTimeout(function() {
        en4.core.request.send(new Request.HTML({
          method: 'get',
          'url': '<?php echo $this->url(array('action' => 'view','question_id' => $this->question->question_id), 'qa_entry_view', true) ?>',
          data: $merge(params.requestParams, {
            format: 'html',
            subject: en4.core.subject.guid,
            page: getNextPage(),
            isajax: 1,
            itemCount: '<?php echo $this->limit; ?>',
            show_content: '<?php echo $this->showContent;?>',
            loaded_by_ajax: true,
          }),
          evalScripts: true,
          onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
            $('hideResponse_div').innerHTML = responseHTML;
            if($('question_view')) {
              $('question_view').getElement('.question_inner_view').append($('hideResponse_div').getElement('.question_inner_view'));
            }
            $('loding_image').style.display = 'none';
            $('hideResponse_div').innerHTML = "";
          }
        }));
      }, 800);

      return false;
    }

    function getNextPage() {
      return <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
    }

    function doOnScrollLoadPage() {
     if($('scroll_bar_height')) {
      if (typeof($('scroll_bar_height').offsetParent) != 'undefined') {
        var elementPostionY = $('scroll_bar_height').offsetTop;
      } else {
        var elementPostionY = $('scroll_bar_height').y;
      }
      if (elementPostionY <= window.getScrollTop() + (window.getSize().y - 40)) {
        if ((totalCount != currentPageNumber) && (totalCount != 0)) {
          viewMorePage();
        }
      }
    }
  }
  window.onscroll = doOnScrollLoadPage;

});

  function votesCheck(that) {
   en4.core.request.send(new Request.JSON({
    method: 'get',
    'url': '<?php echo $this->url(array('action' => 'view','question_id' => $this->question->question_id), 'qa_entry_view', true) ?>',
    data:{
      format: 'json',
      subject: en4.core.subject.guid,
      isajax: 1,
      loaded_by_ajax: true,
      resource_type : that.getAttribute('data-type'),
      resource_id : that.getAttribute('data-id'),
      vote : that.value,
    },
    evalScripts: true,
    onSuccess: function(responseJSON) {
      var resource_type = that.getAttribute('data-type')
      var resource_id = that.getAttribute('data-id');
      if(resource_type == 'siteqa_ans'){
        $('ans_item_votes_'+resource_id).innerHTML = responseJSON.vote;
      }else{
        $('que_item_votes').innerHTML = responseJSON.vote;
      }
      alert(responseJSON.msg);
    }
  }));
 }

 function markHelpful(that) {
   en4.core.request.send(new Request.JSON({
    method: 'get',
    'url': '<?php echo $this->url(array('action' => 'view','question_id' => $this->question->question_id), 'qa_entry_view', true) ?>',
    data:{
      format: 'json',
      subject: en4.core.subject.guid,
      isajax: 1,
      loaded_by_ajax: true,
      helpful : '1',
      option_id : that.getAttribute('data-id'),
    },
    evalScripts: true,
    onSuccess: function(responseJSON) {
      location.reload();
    }
  }));
 }
</script>
