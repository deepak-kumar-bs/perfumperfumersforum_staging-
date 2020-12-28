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
<?php include APPLICATION_PATH .  '/application/modules/Sesatoz/views/scripts/dismiss_message.tpl';?>

<?php if( count($this->subnavigation) ): ?>
  <div class='sesbasic-admin-sub-tabs'>
    <?php echo $this->navigation()->menu()->setContainer($this->subnavigation)->render();?>
  </div>
<?php endif; ?>

<h3>Newsletter Emails</h3>
<p>
  <?php echo $this->translate("The newsletter emails of your social network are listed here. If you need to search for a specific member, enter your search criteria in the fields below.") ?>
</p>
<br />
<?php $baseURL = $this->layout()->staticBaseUrl;?>
<script type="text/javascript">
  var currentOrder = '<?php echo $this->order ?>';
  var currentOrderDirection = '<?php echo $this->order_direction ?>';
  var changeOrder = function(order, default_direction){
    // Just change direction
    if( order == currentOrder ) {
      $('order_direction').value = ( currentOrderDirection == 'ASC' ? 'DESC' : 'ASC' );
    } else {
      $('order').value = order;
      $('order_direction').value = default_direction;
    }
    $('filter_form').submit();
  }
</script>

<div class='admin_search sesbasic_search_form'>
  <?php echo $this->formFilter->render($this) ?>
</div>
<br />

<div class='admin_results'>
  <div>
    <?php $count = $this->paginator->getTotalItemCount() ?>
    <?php echo $this->translate(array("%s newletter email found.", "%s newletter emails found.", $count),
        $this->locale()->toNumber($count)) ?>
  </div>
  <div>
    <?php echo $this->paginationControl($this->paginator, null, null, array(
      'pageAsQuery' => true,
      'query' => $this->formValues,
      //'params' => $this->formValues,
    )); ?>
  </div>
</div>

<br />
<?php if(count($this->paginator) > 0):?>
<div class="admin_table_form">
<form>
  <table class='admin_table'>
    <thead>
      <tr>
        <th style='width: 1%;'><?php echo $this->translate("ID") ?></th>
        <th><?php echo $this->translate("Display Name") ?></th>
        <th><?php echo $this->translate("Username") ?></th>
        <th style='width: 1%;'><?php echo $this->translate("Email") ?></th>
        <th style='width: 1%;' class='admin_table_centered'><?php echo $this->translate("User Level") ?></th>
        <th style='width: 1%;' class='admin_table_options'><?php echo $this->translate("Options") ?></th>
      </tr>
    </thead>
    <tbody>
      <?php if( count($this->paginator) ): ?>
        <?php foreach( $this->paginator as $item ):
          $user = Engine_Api::_()->getItem('user', $item->user_id);
          ?>
          <tr>
            <td><?php echo $item->newsletteremail_id ?></td>
            <td class='admin_table_bold'>
              <?php if($item->user_id) { ?>
                <?php echo $this->htmlLink($user->getHref(),
                  $this->string()->truncate($user->getTitle(), 16),
                  array('target' => '_blank'))?>
              <?php } else { ?>
                <?php echo "---"; ?>
              <?php } ?>
            </td>
            <td class='admin_table_user'>
              <?php if($item->user_id) { ?>
                <?php echo $this->htmlLink($this->item('user', $item->user_id)->getHref(), $this->item('user', $item->user_id)->username, array('target' => '_blank')) ?>
              <?php } else { ?>
              <?php echo "---"; ?>
              <?php } ?>
            </td>
            <td class='admin_table_email'>
              <?php if( !$this->hideEmails ): ?>
                <a href='mailto:<?php echo $item->email ?>'><?php echo $item->email ?></a>
              <?php else: ?>
                (hidden)
              <?php endif; ?>
            </td>
            <td class="admin_table_centered nowrap">
              <?php if($item->user_id) { ?>
              <a href="<?php echo $this->url(array('module'=>'authorization','controller'=>'level', 'action' => 'edit', 'id' => $item->level_id)) ?>">
                <?php echo $this->translate(Engine_Api::_()->getItem('authorization_level', $item->level_id)->getTitle()) ?>
              </a>
              <?php } else { ?>
                <?php echo $this->translate(Engine_Api::_()->getItem('authorization_level', $item->level_id)->getTitle()) ?>
              <?php } ?>
            </td>
            <td class='admin_table_options'>
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'sendnewsletteremail', 'id' => $item->newsletteremail_id));?>'>
                <?php echo $this->translate("Send Email") ?>
              </a>
              |
              <a class='smoothbox' href='<?php echo $this->url(array('action' => 'delete', 'id' => $item->newsletteremail_id));?>'>
                <?php echo $this->translate("Delete") ?>
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <br />
</form>
</div>
<?php else:?>
<div class="tip">
  <span>
    <?php echo "There are no newletter email in your search criteria.";?>
  </span>
</div>
<?php endif;?>
