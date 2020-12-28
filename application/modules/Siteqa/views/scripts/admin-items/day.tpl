<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: day.tpl 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<script type="text/javascript">

  function multiDelete()
  {
    return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected item ?")) ?>');
  }

  function selectAll()
  {
    var i;
    var multidelete_form = $('multidelete_form');
    var inputs = multidelete_form.elements;
    for (i = 1; i < inputs.length - 1; i++) {
      if (!inputs[i].disabled) {
        inputs[i].checked = inputs[0].checked;
      }
    }
  }
</script>

<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
  var changeOrder = function(order, default_direction){

    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }
</script>

<div class='admin_search'>
  <?php echo $this->formFilter->render($this) ?>
</div>

<h2 class="fleft"><?php echo $this->translate('Professional Questions and Answers Plugin'); ?></h2>

<?php include APPLICATION_PATH . '/application/modules/Sitegroup/views/scripts/manageExtensions.tpl'; ?>

<?php if (count($this->navigation)): ?>
  <div class='seaocore_admin_tabs tabs clr'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
  </div>
<?php endif; ?>

<div class='clear'>
  <div class='settings'>
    <form id='multidelete_form' method="post" action="<?php echo $this->url(array('module' => 'siteqa', 'controller' => 'items', 'action' => 'multi-delete'), 'admin_default'); ?>" onSubmit="return multiDelete()" class="global_form">
      <div>
        <h3><?php echo $this->translate("Question Of The Day") ?> </h3>
        <p class="description">
          <?php echo $this->translate("Add and Manage the questions on your site to be shown in the Question of the day widget. You can also mark these items for future dates such that the marked Question automatically shows up as Question of the day on the desired date. Note that for this Question of the day to be shown, you must first place the Question of the day widget at the desired location.") ?>
        </p>
        <?php
        echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'siteqa', 'controller' => 'items', 'action' => 'add-item'), $this->translate('Add a Question of the day'), array(
            'class' => 'smoothbox buttonlink',
            'style' => 'background-image: url('.$this->layout()->staticBaseUrl.'application/modules/Core/externals/images/admin/new_category.png);'));?><br /><br />
        <?php if ($this->paginator->getTotalItemCount() > 0): ?>
          <table class='admin_table' width="80%">
            <thead>
              <tr>
								<?php $class = ( $this->order == 'engine4_siteqa_questions.title' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
                <th style='width: 1%;' align="left"><input onclick="selectAll()" type='checkbox' class='checkbox'></th>
                <th width="550" align="left" class="<?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('engine4_siteqa_groups.title', 'DESC');"><?php echo $this->translate("Question Title") ?></a></th>

                <?php $class = ( $this->order == 'start_date' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
                <th width="70" align="left" class="<?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('start_date', 'DESC');"><?php echo $this->translate("Start Date") ?></a></th>
                <?php //Start End date work  ?>
                <?php $class = ( $this->order == 'end_date' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
                <th width="70" align="left" class="<?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('end_date', 'DESC');"><?php echo $this->translate("End Date") ?></a></th>
                <?php //End End date work  ?>
                <th width="70" align="left"><?php echo $this->translate("Option") ?></th>
              </tr>
            </thead>
            <tbody>
							<?php foreach ($this->paginator as $item): ?>
                <tr>
                  <td><input name='delete_<?php echo $item->itemoftheday_id; ?>' type='checkbox' class='checkbox' value="<?php echo $item->itemoftheday_id ?>"/></td>
                  <td class='admin_table_bold admin-txt-normal' title="<?php echo $this->translate($item->getTitle()) ?>">
                    <a href=""  target='_blank'>
                    <?php echo $this->htmlLink(array('action' => 'view','question_id' => $item->getIdentity(),'route' => 'qa_entry_view'), Engine_Api::_()->siteqa()->truncateText($item->getTitle(),50)) ?></a>
                  </td>
                  <td align="left"><?php echo $item->start_date ?></td>
                  <?php //Start End date work ?>
                  <td align="left"><?php echo $item->end_date ?></td>
                  <?php //End End date work  ?>
                  <td align="left">
										<?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'siteqa', 'controller' => 'items', 'action' => 'delete-item', 'id' => $item->itemoftheday_id), $this->translate('delete'), array('class' => 'smoothbox',)) ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table><br />
          <div class='buttons'>
            <button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
          </div>
        <?php else: ?>
          <div class="tip"><span><?php echo $this->translate("No questions have been marked as Question of the day."); ?></span> </div><?php endif; ?>
      </div>
    </form>
  </div>
</div>
<?php echo $this->paginationControl($this->paginator); ?>