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
<?php $this->headLink()->prependStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/styles/styles.css');
$this->headLink()->prependStylesheet($this->layout()->staticBaseUrl . '\application\modules\Siteqa\externals\styles\style_siteqa.css');
$this->headScript()->appendFile($this->layout()->staticBaseUrl .'application/modules/Siteqa/externals/scripts/core.js');
 ?>
<div id = "list-service-browse" class="siteqa_list">
  <div class="question_browse_class" id="question_browse">
    <?php if(empty($this->is_ajax) || $this->is_ajax=='2') { ?>
      <div class="tabs_alt" id="tabs_question_type">
        <ul>
          <li id="creation_date" onclick="getQuestions('creation_date');" class="li_question active"><a><?php echo $this->translate('Latest');?></a></li> 
          <li id="unanswered" onclick="getQuestions('unanswered');" class="li_question"><a><?php echo $this->translate('Unanswered');?></a></li> 
          <li id="vote_count" onclick="getQuestions('vote_count');" class="li_question"><a><?php echo $this->translate('Most Voted');?></a></li> 
        </ul>
      </div>
    <?php } ?>
    <?php if(count($this->paginator) <= 0): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('No Questions found.');?>
        </span>
      </div>
    <?php endif; ?>

 
      <div class="question_inner_browse_class" id="question_inner_browse">
           <?php foreach( $this->paginator as $item ) : ?>
            <div class="brows-container">
              <div class="_inner">
                <!-- Inner -->   
                <div class="qa-icon">
                  <?php if(!empty($item->photo_id)) : 
                    echo $this->itemBackgroundPhoto($item, 'thumb.normal');
                  else : ?>
                    <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/question_icon.png'/>
                  <?php endif; ?>  
                </div> 
                <div class="qa-weapper">
                  <h3><?php echo $this->htmlLink(array('action' => 'view','question_id' => $item->getIdentity(),'route' => 'qa_entry_view'), Engine_Api::_()->siteqa()->truncateText($item->title,75)) ?></h3>
                  <div><?php echo Engine_Api::_()->siteqa()->truncateText($item->body,100); ?></div>

                  <div class="qa-profile-tag">
                    <?php $questionTags = $item->tags()->getTagMaps();
                    if (count($questionTags)):?>
                    <?php foreach ($questionTags as $tag): ?>
                    <span><a href='javascript:void(0);' onclick='javascript:tagAction(<?php echo $tag->getTag()->tag_id; ?>);'>#<?php echo $tag->getTag()->text?></a></span>
                    <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                  <div class="_info">
                  <p>
                    <span class="tille-info asked"><?php echo $this->translate('Asked In');?> :</span>
                    <span><?php echo (Engine_Api::_()->getItem('siteqa_category', 
                  $item->category_id))->category_name; ?></span>
                  </p>
                  <p class="ask-user">
                    <span class="tille-info posted"><?php echo $this->translate('Asked By');?> :</span> 
                    <span><?php echo $this->htmlLink($this->user($item->owner_id)->getHref(), $this->itemBackgroundPhoto($this->user($item->owner_id), 'thumb.icon')) ?></span><?php echo ucfirst($this->user($item->owner_id)->username);?>
                  </p>
                  <p>
                    <span class="tille-info created"><?php echo $this->translate('Created On');?> :</span>
                    <span><?php echo $this->timestamp(strtotime($item->creation_date))?></span>
                  </p>
                </div>

                </div>
              </div>
              <div class="coutn-stus">
                <p class="ans"><span><?php echo $item->answer_count ?></span><?php echo $this->translate('Answers');?></p>
                <p class="view"><span><?php echo $item->view_count ?></span><?php echo $this->translate('Views');?></p>
                <?php if($item->vote_count >= 0) : ?>
                  <p class="votes">
                  <span><?php echo $this->locale()->toNumber($item->vote_count); ?></span>
                <?php else : ?>
                  <p class="votes neg_vote">
                  <span class=""><?php echo $this->locale()->toNumber($item->vote_count); ?></span>
                <?php endif; ?>
                <?php echo $this->translate('Votes');?>
              </p>
            </div>
          </div>
          <?php endforeach;?> 
      </div>

<div class="clr" id="scroll_bar_height"></div>
<div class="seaocore_view_more" id="loding_image" style="display:none;">
  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Seaocore/externals/images/core/loading.gif' style='margin-right: 5px;' />
  <?php echo $this->translate("Loading ...") ?>
</div>
<div id="hideResponse_div"></div>

<?php if(!$this->isAjax): ?>
  <?php $totalCount = $this->paginator->count();
  $currentPageNumber = $this->paginator->getCurrentPageNumber();
  if (($totalCount != $currentPageNumber) && ($totalCount != 0)): ?>
   <button class="siteqa_more" id="siteqa_more" onclick="viewMorePage();"><?php echo $this->translate('View more');?></button>
<?php endif; ?>
<?php endif; ?>
</div></div>
<script type="text/javascript">
  $$('.core_main_question').getParent().addClass('active');
  
  var totalCount = '<?php echo $this->paginator->count(); ?>';
  var currentPageNumber = '<?php echo $this->paginator->getCurrentPageNumber(); ?>';

  function viewMorePage()
  {
    var orderby = document.getElementsByClassName('li_question active')[0].id;
    
    $('loding_image').style.display = '';
    var params = {
      requestParams:<?php echo json_encode($this->params) ?>
    };
    setTimeout(function() {
      en4.core.request.send(new Request.HTML({
        method: 'get',
        'url' : en4.core.baseUrl + 'widget/index/mod/siteqa/name/browse-questions',
        data: $merge(params.requestParams, {
          format: 'html',
          subject: en4.core.subject.guid,
          page: getNextPage(),
          isajax: 1,
          itemCount: '<?php echo $this->limit; ?>',
          show_content: '<?php echo $this->showContent;?>',
          limit: '<?php echo $this->limit; ?>',
          loaded_by_ajax: true,
          orderby : orderby,
        }),
        evalScripts: true,
        onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
          $('hideResponse_div').innerHTML = responseHTML;
          if($('question_browse')) {
            $('question_browse').getElement('.question_inner_browse_class').append($('hideResponse_div').getElement('.question_inner_browse_class'));
          }
          $('loding_image').style.display = 'none';
          $('hideResponse_div').innerHTML = "";
          if(totalCount == currentPageNumber){
            $('siteqa_more').style.display ='none';
            return false;
          }
        }
      }));
    }, 800);

    return false;
  }

  function getNextPage() {
    return <?php echo sprintf('%d', $this->paginator->getCurrentPageNumber() + 1) ?>
  }

  function getQuestions(that) {
   en4.core.request.send(new Request.HTML({
    method: 'get',
    'url' : en4.core.baseUrl + 'widget/index/mod/siteqa/name/browse-questions',
    'data':{
      format: 'html',
      itemCount: '<?php echo $this->limit; ?>',
      limit: '<?php echo $this->limit; ?>',
      subject: en4.core.subject.guid,
      isajax: 2,
      loaded_by_ajax: true,
      orderby : that,
    },
    evalScripts: true,
    onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
      if($('question_browse')) {
        $('question_browse').innerHTML = responseHTML;
      }
      $('creation_date').removeClass('active');
      $(that).addClass('active');
    }
  }));
 }

 var pageAction =function(page){
  $('page').value = page;
  $('filter_form').submit();
}
</script>