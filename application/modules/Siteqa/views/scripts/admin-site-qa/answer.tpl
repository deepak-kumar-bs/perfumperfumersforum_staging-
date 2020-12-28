<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: manage.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

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

	function multiDelete()
	{
		return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected Answer ?")) ?>');
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

<h2><?php echo $this->translate('Professional Questions and Answers Plugin')?></h2>

<?php if( count($this->navigation) ):?>
	<div class='seaocore_admin_tabs tabs clr'>
		<?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
	</div>
<?php endif; ?>

<h3><?php echo $this->translate("Manage Answers") ?></h3>

<p><?php echo $this->translate(" This page lists all the Answers created in your community. Here, you can monitor the Answers, edit or delete them. Entering criteria into the filter fields will help you find specific Answers.");?></p>

<br /><br />

<div class='admin_search'>
	<?php echo $this->formFilter->render($this) ?>
</div>

<br />

<div class="admin_search sead_admin_search">
	<div class="search">
		<form method="post" class="global_form_box" action="">

				<div>
					<label>
						<?php echo  $this->translate("Answer Title") ?>
					</label>
					<?php if( empty($this->title)):?>
						<input type="text" name="title" /> 
					<?php else: ?>
						<input type="text" name="title" value="<?php echo $this->translate($this->title)?>"/>
					<?php endif;?>
				</div>

				<div>
				<label>
					<?php echo  $this->translate("Question Title") ?>
				</label>
				<?php if( empty($this->que_title)):?>
					<input type="text" name="que_title" /> 
					<?php else: ?>
						<input type="text" name="que_title" value="<?php echo $this->translate($this->que_title)?>"/>
					<?php endif;?>
				</div>

				<div>
					<label>
						<?php echo  $this->translate("Owner") ?>
					</label>	
					<?php if( empty($this->owner)):?>
						<input type="text" name="owner" /> 
						<?php else: ?> 
							<input type="text" name="owner" value="<?php echo $this->translate($this->owner)?>" />
						<?php endif;?>
					</div>

				<div>
					<div class="buttons clr fleft mtop10">
						<button type="submit" name="search" ><?php echo $this->translate("Search") ?></button>
					</div>	
				</div>
			</form>
		</div>
	</div>
	<br />

	<?php if($this->paginator->getTotalItemCount()): ?>

		<div class='admin_members_results'>
			<div style="margin-bottom:5px;">
				<?php echo $this->translate(array('%s Answer found.', '%s Answers found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
			</div>
			<?php echo $this->paginationControl($this->paginator); ?>
		</div>

		<br />

		<form id='multidelete_form' method="post" action="<?php echo $this->url(array('action'=>'multi-delete-answer'));?>" onSubmit="return multiDelete()">
			<table class='admin_table seaocore_admin_table'>
				<thead>
					<tr>
						<th style='width: 1%;' align="left"><input onclick="selectAll()" type='checkbox' class='checkbox'></th>

						<?php $class = ( $this->order == 'answer_id' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th class="<?php echo $class ?>" style='width: 1%;' align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('answer_id', 'DESC');"><?php echo $this->translate('ID'); ?></a></th>

						<?php $class = ( $this->order == 'title' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th class="<?php echo $class ?>" style='width: 3%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate('Question');?></a></th>

						<?php $class = ( $this->order == 'body' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th class="<?php echo $class ?>" style='width: 3%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('body', 'ASC');"><?php echo $this->translate('Answer');?></a></th>

						<?php $class = ( $this->order == 'username' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th class="<?php echo $class ?>" style='width: 2%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('username', 'DESC');"><?php echo $this->translate('Owner'); ?></a></th> 

						<?php $class = ( $this->order == 'vote_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('vote_count', 'ASC');"><?php echo $this->translate('Votes'); ?></a></th>

						<?php $class = ( $this->order == 'view_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('view_count', 'ASC');"><?php echo $this->translate('Views'); ?></a></th>

						<th style='width: 1%;' class="admin_table_centered "><a href="javascript:void(0);" onclick=""><?php echo $this->translate('Best Answer'); ?></a></th>

						<?php $class = ( $this->order == 'creation_date' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
						<th class="<?php echo $class ?>" style='width: 2%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'DESC');"><?php echo $this->translate('Creation Date'); ?></a></th>

						<th style='width: 2%;' align="left"><?php echo $this->translate('Options'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php if( count($this->paginator) ): ?>
						<?php foreach( $this->paginator as $siteqa ): ?>
							<tr>

								<td><input name='delete_<?php echo $siteqa->answer_id;?>' type='checkbox' class='checkbox' value="<?php echo $siteqa->answer_id ?>"/></td>

								<td class="admin_table_centered"><?php echo $siteqa->answer_id ?></td>

								<?php $siteqa_title = Engine_Api::_()->siteqa()->truncateText($siteqa->getTitle(), 20);?>

								<td><?php echo $this->htmlLink($this->item('question', $siteqa->question_id)->getHref(),$siteqa_title, array('target' => '_blank')) ?></td>

								<td align="" class="admin_table_centered" style="text-align: left;"><?php echo $siteqa_body = Engine_Api::_()->siteqa()->truncateText($siteqa->body, 20); ?></td>

								<?php 
								$owner_name = $this->user($siteqa->owner_id)->username;
								$truncate_owner_name = Engine_Api::_()->siteqa()->truncateText($owner_name, 10);
								?>		
								<td><?php echo $this->htmlLink($this->item('user', $siteqa->owner_id)->getHref()	, $truncate_owner_name, array('target' => '_blank')) ?></td>

								<td align="center" class="admin_table_centered"><?php echo $siteqa->vote_count ?></td>

								<td align="center" class="admin_table_centered"><?php echo $siteqa->view_count ?></td>

								<td align="center" class="admin_table_centered"><?php $answer_id = Engine_Api::_()->getDbtable('helps', 'siteqa')->getHelpful($siteqa->question_id,$this->item('question', $siteqa->question_id)->owner_id);
									if($answer_id == $siteqa->answer_id) :
										echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'helpful', 'question_id' => $siteqa->question_id ,'answer_id' => 0), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Siteqa/externals/images/help-full.png', '', array('title'=> $this->translate('Best Answer')))); 
									else :
										echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'helpful', 'question_id' => $siteqa->question_id ,'answer_id' => $siteqa->answer_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Siteqa/externals/images/not-help-full.png', '', array('title'=> $this->translate('Not Best Answer')))); 
									endif;
								?></td>

								<td><?php echo $siteqa->creation_date ?></td>

								<td>
									<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'answeredit', 'answer_id' => $siteqa->answer_id), $this->translate('edit'), array('class' => 'smoothbox')) ?>
									|
									<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'answerdelete', 'answer_id' => $siteqa->answer_id), $this->translate('delete'), array('class' => 'smoothbox')) ?> 
								</td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
			<br />
			<div class='buttons'>
				<button type='submit'><?php echo $this->translate('Delete Selected'); ?></button>
			</div>
		</form>
		<?php else:?>
			<div class="tip">
				<span>
					<?php echo $this->translate('No results were found.');?>
				</span>
			</div>
		<?php endif; ?>

		<script type="text/javascript">
			function clear(ddName)
			{ 
				for (var i = (document.getElementById(ddName).options.length-1); i >= 0; i--) 
				{ 
					document.getElementById(ddName).options[ i ]=null; 
				} 
			}
		</script>
