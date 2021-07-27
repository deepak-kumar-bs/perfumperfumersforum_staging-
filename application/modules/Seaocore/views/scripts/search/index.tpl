<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Core
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: index.tpl 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */
?>

<h2><?php echo $this->translate('Search') ?></h2>

<div id="searchform" class="global_form_box">
  <?php echo $this->form->setAttrib('class', '')->render($this) ?>
</div>

<br />
<br />
<?php if( $this->feedResults == true):?>
  <?php // return; ?>

<?php elseif( empty($this->paginator) ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('Please enter a search query.') ?>
    </span>
  </div>
<?php elseif( $this->paginator->getTotalItemCount() <= 0 ): ?>
  <div class="tip">
    <span>
      <?php echo $this->translate('No results were found.') ?>
    </span>
  </div>
<?php else: ?>
  <?php echo $this->translate(array('%s result found', '%s results found', $this->paginator->getTotalItemCount()),
                              $this->locale()->toNumber($this->paginator->getTotalItemCount()) ) ?>

  <?php foreach( $this->paginator as $item ):
    if($this->searchTable){
      $item = $this->item($item->type, $item->id);
      if( !$item ) continue; }?>
    <div class="search_result">
      <div class="search_photo">
        <?php echo $this->htmlLink($item->getHref(), $this->itemPhoto($item, 'thumb.icon')) ?>
      </div>
      <div class="search_info">
        <?php if( '' != $this->query ): ?>
          <?php echo $this->htmlLink($item->getHref(), $this->highlightText($item->getTitle(), $this->query), array('class' => 'search_title')) ?>
        <?php else: ?>
          <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('class' => 'search_title')) ?>
        <?php endif; ?>
        <p class="search_description">
          <?php if( '' != $this->query ): ?>
            <?php echo $this->highlightText($this->viewMore($item->getDescription()), $this->query); ?>
          <?php else: ?>
            <?php echo $this->viewMore($item->getDescription()); ?>
          <?php endif; ?>
        </p>
      </div>
    </div>
  <?php /*
    <div class="search_result">
      <div class="search_icon">
        &nbsp;
      </div>
      <div class="search_info">
        <?php echo $this->htmlLink($item->getHref(), $item->getTitle(), array('class' => 'search_title')) ?>
        <p class="search_description">
          <?php echo $item->getDescription(); ?>
        </p>
      </div>
    </div>
   *
   */ ?>
  <?php endforeach; ?>

  <br />

  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      //'params' => array(
      //  'query' => $this->query,
      //),
      'query' => array(
        'query' => $this->query,
        'type' => $this->type,
        'order' => $this->order,
      ),
    )); ?>
  </div>

<?php endif; ?>


<script type="text/javascript">
addOptionInSearch();

$('type').addEvent('click',function(){

  addOptionInSearch();
});

function addOptionInSearch() {

  console.log("tttttttttry");
  type = $('type').value;

  $('order').innerHTML = "";

      var most_recent = document.createElement("option");
      most_recent.text = "Most Recent";
      most_recent.value = '';
      $('order').add(most_recent);
  
  (new Request.JSON({
    'format': 'json',
    'url' : '<?php echo $this->url(array('module' => 'seaocore', 'controller' => 'search', 'action' => 'valid-order'), 'default', true) ?>',
    'data' : {
      'type' : type,
    },  
    onSuccess: function(responseJSON, responseText) {

      // var select = $('order');
      // var length = select.options.length;
      // for (i = length-1; i >= 0; i--) {
      //   select.options[i] = null;
      // }

      

      if(responseJSON.like_count == "true"){
        var like_count = document.createElement("option");
        like_count.text = "Most Liked";
        like_count.value = "like_count";
        $('order').add(like_count);
      }
      if(responseJSON.view_count == "true"){
        var view_count = document.createElement("option");
        view_count.text = "Most Viewed";
        view_count.value = "view_count";
        $('order').add(view_count)
      }
          
    }     
  })).send();
}
</script>


