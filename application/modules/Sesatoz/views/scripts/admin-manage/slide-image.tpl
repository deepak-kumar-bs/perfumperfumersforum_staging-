<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: slide-image.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>

<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>

<script type="text/javascript">
  
  
  var SortablesInstance;

  window.addEvent('load', function() {
    SortablesInstance = new Sortables('menu_list', {
      clone: true,
      constrain: false,
      handle: '.item_label',
      onComplete: function(e) {
        reorder(e);
      }
    });
  });

 var reorder = function(e) {
     var menuitems = e.parentNode.childNodes;
     var ordering = {};
     var i = 1;
     for (var menuitem in menuitems)
     {
       var child_id = menuitems[menuitem].id;

       if ((child_id != undefined))
       {
         ordering[child_id] = i;
         i++;
       }
     }
 
    ordering['format'] = 'json';

    // Send request
    var url = '<?php echo $this->url(array('action' => 'order')) ?>';
    var request = new Request.JSON({
      'url' : url,
      'method' : 'POST',
      'data' : ordering,
      onSuccess : function(responseJSON) {
      }
    });

    request.send();
  }

 
  function selectAll(){
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;

    for (i = 1; i < inputs.length - 1; i++) {
      if (!inputs[i].disabled) {
       inputs[i].checked = inputs[0].checked;
      }
    }
  }
  
  function multiDelete(){
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected slide image?")) ?>');
  }

</script>


<h3><?php echo "Manage Slides for Slideshow"; ?></h3>
<p><?php echo "Here, you can manage slides which will be shown in the “Atoz Theme - Slideshow” widget. Below, you can add new slides by using the “Upload New Slide” link, edit and delete them. You can drag the slides vertically and click on “Save Order” button to change their order."; ?> </p>
<br />
<div>
  <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sesatoz', 'controller' => 'manage', 'action' => 'upload-slideshow-photo'), $this->translate('Upload New Image'), array('class' => 'buttonlink admin_files_upload smoothbox')) ?>
</div><br />
<?php if(count($this->paginator) > 0):?>
  <div class="atoz_manage_slides">
    <form id='multidelete_form' method="post" action="<?php echo $this->url(array('action' => 'multi-delete-slide'));?>" onSubmit="return multiDelete()">
      <div class="atoz_manage_slides_head">
        <div style="width:5%">
          <input onclick="selectAll()" type='checkbox' class='checkbox'>
        </div>
        <div style="width:10%">
          <?php echo "Id";?>
        </div>
        <div style="width:30%">
          <?php echo "Slide Image";?>
        </div>
        <div style="width:20%">
          <?php echo "URL";?>
        </div>
        <div style="width:15%" class="">
          <?php echo "Options";?>
        </div>   
      </div>
      <ul class="atoz_manage_slides_list" id='menu_list'>
        <?php foreach ($this->paginator as $item) : ?>
          <li class="item_label" id="slideimage_<?php echo $item->slideimage_id ?>">
            <input type='hidden'  name='order[]' value='<?php echo $item->slideimage_id; ?>'>
            <div style="width:5%;">
              <input name='delete_<?php echo $item->slideimage_id ?>_<?php echo $item->file_id ?>' type='checkbox' class='checkbox' value="<?php echo $item->slideimage_id ?>_<?php echo $item->file_id ?>"/>
		</div>
		<div style="width:10%;">
              <?php echo $item->slideimage_id; ?>
		</div>
		<div style="width:30%;">
              <img class="atoz_manangeslides_slide" alt="" src="<?php echo $this->storage->get($item->file_id, '')->getPhotoUrl(); ?>" />
		</div>
    <div style="width:20%;">
      <?php if(!empty($item->image_url)):?>
        <a href="<?php echo $item->image_url;?>" ><?php echo $item->image_url?></a>
      <?php else:?>
        <?php echo '---'; ?>
      <?php endif;?>
		</div>
		<div style="width:15%;">          
              <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesatoz', 'controller' => 'admin-manage', 'action' => 'upload-slideshow-photo', 'id' => $item->slideimage_id, 'file_id' => $item->file_id),
                $this->translate("Edit"),
                array('class' => 'smoothbox')) ?> |
                <?php echo $this->htmlLink(
                array('route' => 'default', 'module' => 'sesatoz', 'controller' => 'admin-manage', 'action' => 'delete-photo', 'id' => $item->slideimage_id, 'file_id' => $item->file_id),
                $this->translate("Delete"),
                array('class' => 'smoothbox')) ?>
            </div>
          </li>
        <?php endforeach; ?>
	</ul>
      <div class='buttons'>
        <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
      </div>
    </form>
  </div>
<?php else:?>
  <div class="tip">
    <span>
      <?php echo "You have not uploaded any slide yet.";?>
    </span>
  </div>
<?php endif;?>