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
<div class="question_manage" id="question_manage">
  <?php if(count($this->paginator) <= 0): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('No Questions found.');?>
        </span>
      </div>
    <?php endif; ?>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="question_inner_manage list_wrapper" id="question_inner_manage">
      <?php foreach( $this->paginator as $item ): ?>
        <li>
          <div class='questions_info'>
            <span class="qa-icon">
              <?php if(empty($item->photo_id)) : ?>
                <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/question_icon.png'/>
              <?php else : ?>
                <?php echo $this->itemBackgroundPhoto($item, 'thumb.normal') ?>
              <?php endif; ?>
            </span>
            <div class="ques_browse_info_title">
              <span>
                <h3 class="approve"><?php echo $this->htmlLink(array('action' => 'view','question_id' => $item->getIdentity(),'route' => 'qa_entry_view'), Engine_Api::_()->siteqa()->truncateText($item->title,75)) ?> <?php if($item->approved != 1): ?> <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/not_approve-icon.png' style='margin-right: 5px;' title="Not Approved"/><?php endif; ?></h3>
                <?php
                  $viewer = Engine_Api::_()->user()->getViewer();
                  $itemEdit = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'edit');
                  $itemDelete = Engine_Api::_()->getDbtable('permissions', 'authorization')->getAllowed('siteqa_question', $viewer->level_id, 'delete');
                  if((!empty($itemEdit)) || (!empty($itemDelete))) :
                ?>
                <div class='ques_options'>
                <p class="dott">
                  <span></span>
                  <span></span>
                  <span></span>
                </p>
                <div class="hover-opt">
                  <?php if(!empty($itemEdit)): ?>
                  <span><?php echo $this->htmlLink(array(
                    'action' => 'edit',
                    'question_id' => $item->getIdentity(),
                    'route' => 'qa_specific',
                    'reset' => true,
                  ), $this->translate('Edit'), array(
                    'class' => 'buttonlink icon_qa_edit',
                  )) ?>
                </span>
                <?php endif; ?>
                <?php if(!empty($itemDelete)): ?>
                <span>
                  <?php
                  echo $this->htmlLink(array('route' => 'qa_specific', 
                    'module' => 'siteqa',
                    'controller' => 'index',
                    'action' => 'delete',
                    'question_id' => $item->question_id, 
                    'format' => 'smoothbox'), 
                  $this->translate('Delete'), array(
                    'class' => 'buttonlink smoothbox icon_qa_delete'
                  ));
                  ?>
                </span>
                <?php endif; ?>     
              </div>
            </div>
            <?php endif; ?>
              </span>
              <p class='ques_browse_info_blurb'>
            <?php echo Engine_Api::_()->siteqa()->truncateText($item->body,100) ?>
          </p>
          <div class='ques_browse_info_blurb'>
            <p><span class="tille-info asked"><?php echo $this->translate('Asked In');?> :</span> 
              <span><?php echo (Engine_Api::_()->getItem('siteqa_category', $item->category_id))->category_name; ?></span></p>
            <p>
              <span class="tille-info created"><?php echo $this->translate('Asked On');?> : </span>
              <?php echo $this->timestamp(strtotime($item->creation_date))?>
            </p>
            <p>
              <span class="tille-info posted"><?php echo $this->translate('Votes');?> : </span>
              <span><?php echo $item->vote_count ?></span>
            </p>
            <p>
              <span class="tille-info answer"><?php echo $this->translate('Answers');?> : </span>
              <?php echo $item->answer_count ?>
            </p>
          </div>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>
<div class="clr" id="scroll_bar_height"></div>
<div class="seaocore_view_more" id="loding_image" style="display:none;">
  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/loading.gif' style='margin-right: 5px;' />
  <?php echo $this->translate("Loading ...") ?>
</div>
<div id="hideResponse_div"> </div>

<script type="text/javascript">
  $$('.core_main_question').getParent().addClass('active');

  en4.core.runonce.add(function() {
  var totalCount = '<?php echo $this->paginator->count(); ?>';
  var currentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';

  function viewMorePage()
  {
    var viewType = 4;
      $('loding_image').style.display = '';
      var params = {
        requestParams:<?php echo json_encode($this->params) ?>
      };
      setTimeout(function() {
        en4.core.request.send(new Request.HTML({
          method: 'get',
          'url': '<?php echo $this->url(array('action' => 'manage'), 'qa_general', true) ?>',
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
            if($('loding_image')) {
              $('question_manage').getElement('.question_inner_manage').append($('hideResponse_div').getElement('.question_inner_manage'));
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
</script>
