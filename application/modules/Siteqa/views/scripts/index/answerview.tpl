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
<?php $this->headLink()->prependStylesheet($this->layout()->staticBaseUrl . 'application/modules/Siteqa/externals/styles/style_siteqa.css'); ?>
<script type="text/javascript">
  var pageAction =function(page){
    $('page').value = page;
    $('filter_form').submit();
  }
</script>
<div class="question_manage broser_ans" id="question_manage">
  <?php if(count($this->paginator) <= 0): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate("You haven't posted answer on any question.");?>
        </span>
      </div>
    <?php endif; ?>
  <?php if( $this->paginator->getTotalItemCount() > 0 ): ?>
    <ul class="list_wrapper" id="question_inner_manage">
      <?php foreach( $this->paginator as $item ): ?>
        <li>
          <div class='brows-container'>
            <div class="ans-icon"><span class="qa-icon"><img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/answer-icon.png'/></span></div>
            <div class="_inner">
              <div class="qa-weapper"> 
                <h3><?php echo $this->htmlLink(array('action' => 'view','question_id' => $item->getIdentity(),'route' => 'qa_entry_view'), Engine_Api::_()->siteqa()->truncateText($item->title, 75)) ?></h3>
            </div>
            <div><p class='ques_browse_info_blurb'><?php echo Engine_Api::_()->siteqa()->truncateText($item->body, 100) ?></p></div>
            <div class="_info">
              <p>
                <span class="tille-info asked"><?php echo $this->translate('Asked In');?> :</span>
                <span><?php echo (Engine_Api::_()->getItem('siteqa_category', 
              $item->category_id))->category_name; ?></span>
              </p>
              <p>
                <span class="tille-info created"><?php echo $this->translate('Created on');?> :</span>
                <span><?php echo $this->timestamp(strtotime($item->creation_date))?></span>
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
  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Seaocore/externals/images/core/loading.gif' style='margin-right: 5px;' />
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
          'url': '<?php echo $this->url(array('action' => 'answerview'), 'ans_entry_view', true) ?>',
          data: $merge(params.requestParams, {
            format: 'html',
            subject: en4.core.subject.guid,
            page: getNextPage(),
            isajax: 1,
            itemCount: '<?php echo $this->limit; ?>',
            show_content: '<?php echo $this->showContent;?>',
            view_type: viewType,
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
          sviewMorePage();
        }
      }
    }
  }
  window.onscroll = doOnScrollLoadPage;
});
</script>
