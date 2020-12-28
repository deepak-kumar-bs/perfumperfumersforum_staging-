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
<style type="text/css">
  .settings h4{font-size: 10.5pt; line-height: 2em;}
</style>

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
		return confirm('<?php echo $this->string()->escapeJavascript($this->translate("Are you sure you want to delete selected Question ?")) ?>');
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

<h3><?php echo $this->translate("Manage Questions") ?></h3>

<p><?php echo $this->translate("This page lists all the Questions created in your community.  Entering criteria into the filter fields will help you find specific Questions. Here, you can monitor the Question, mark approve / disapprove them. To create a new Question, click on the link below.");?></p>

<br /><br />

<?php echo $this->htmlLink(array('route' => 'qa_general', 'action' => 'create'), $this->translate('Create New Question'), array('class'=> 'buttonlink seaocore_icon_add', 'target' => '_blank')) ?>

<div class='admin_search'>
	<?php echo $this->formFilter->render($this) ?>
</div>

<br />

<div class="admin_search sead_admin_search">
	<div class="search">
		<form method="post" class="global_form_box" action="">

			<div>
				<label>
					<?php echo  $this->translate("Question Title") ?>
				</label>
				<?php if( empty($this->title)):?>
					<input type="text" name="title" /> 
					<?php else: ?>
						<input type="text" name="title" value="<?php echo $this->translate($this->title)?>"/>
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
						<label>
							<?php echo  $this->translate("Approved") ?>
						</label>
						<select name="approved">
							<option value="0" ></option>
							<option value="2" <?php if( $this->approved == 2) echo "selected";?> ><?php echo $this->translate("Yes") ?></option>
							<option value="1" <?php if( $this->approved == 1) echo "selected";?> ><?php echo $this->translate("No") ?></option>
						</select>
					</div>

					
					<?php  $categories = Engine_Api::_()->getDbTable('categories', 'siteqa')->getCategories(null); ?>
					<?php if(count($categories) > 0) :?>
						<div>
							<label>
								<?php echo  $this->translate("Category") ?>
							</label>
							<select class="siteqa_cat_select" id="" name="category_id" onchange="subcategories(this.value, '', '', '');">
								<option value=""></option>
								<?php if (count($categories) != 0) : ?>
									<?php $categories_prepared[0] = "";
									foreach ($categories as $category) {
										$categories_prepared[$category->category_id] = $category->category_name; ?>
										<option value="<?php echo $category->category_id;?>" <?php if( $this->category_id == $category->category_id) echo "selected";?>><?php echo $this->translate($category->category_name);?></option>
									<?php } ?>
								<?php endif ; ?>
							</select>
						</div>

						<div id="subcategory_backgroundimage" class="cat_loader" style="display: none;"><img src="<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/loading.gif" /></div>
						<div id="subcategory_id-label">
							<label>
								<?php echo  $this->translate("Subcategory") ?>	
							</label>
							
							<select class="siteqa_cat_select" name="subcategory_id" id="subcategory_id" onchange=""></select>
						</div>
					<?php endif;?>
					
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
					<?php echo $this->translate(array('%s Question found.', '%s Questions found.', $this->paginator->getTotalItemCount()), $this->locale()->toNumber($this->paginator->getTotalItemCount())) ?>
				</div>
				<?php echo $this->paginationControl($this->paginator); ?>
			</div>

			<br />

			<form id='multidelete_form' method="post" action="<?php echo $this->url(array('action'=>'multi-delete'));?>" onSubmit="return multiDelete()">
				<table class='admin_table seaocore_admin_table'>
					<thead>
						<tr>
							<th style='width: 1%;' align="left"><input onclick="selectAll()" type='checkbox' class='checkbox'></th>

							<?php $class = ( $this->order == 'question_id' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th class="<?php echo $class ?>" style='width: 1%;' align="center"><a href="javascript:void(0);" onclick="javascript:changeOrder('question_id', 'DESC');"><?php echo $this->translate('ID'); ?></a></th>

							<?php $class = ( $this->order == 'username' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th class="<?php echo $class ?>" style='width: 2%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('username', 'DESC');"><?php echo $this->translate('Owner'); ?></a></th> 

							<?php $class = ( $this->order == 'title' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th class="<?php echo $class ?>" style='width: 1%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('title', 'ASC');"><?php echo $this->translate('Question');?></a></th>

							

							<?php $class = ( $this->order == 'approved' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('approved', 'ASC');"><?php echo $this->translate('Approved'); ?></a></th>

							

							<?php $class = ( $this->order == 'view_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('view_count', 'ASC');"><?php echo $this->translate('Views'); ?></a></th>

							<?php $class = ( $this->order == 'answer_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('answer_count', 'ASC');"><?php echo $this->translate('Answers'); ?></a></th>

							<?php $class = ( $this->order == 'vote_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('vote_count', 'ASC');"><?php echo $this->translate('Votes'); ?></a></th>

							<?php $class = ( $this->order == 'comment_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('comment_count', 'ASC');"><?php echo $this->translate('Comments'); ?></a></th>

							<?php $class = ( $this->order == 'like_count' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th style='width: 1%;' class="admin_table_centered <?php echo $class ?>"><a href="javascript:void(0);" onclick="javascript:changeOrder('like_count', 'ASC');"><?php echo $this->translate('Likes'); ?></a></th>

							<?php $class = ( $this->order == 'creation_date' ? 'admin_table_ordering admin_table_direction_' . strtolower($this->order_direction) : '' ) ?>
							<th class="<?php echo $class ?>" style='width: 3%;' align="left"><a href="javascript:void(0);" onclick="javascript:changeOrder('creation_date', 'DESC');"><?php echo $this->translate('Creation Date'); ?></a></th>

							<th style='width: 3%;' align="left"><?php echo $this->translate('Options'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php if( count($this->paginator) ): ?>
							<?php foreach( $this->paginator as $siteqa ): ?>
								<tr>
									
									<td><input name='delete_<?php echo $siteqa->question_id;?>' type='checkbox' class='checkbox' value="<?php echo $siteqa->question_id ?>"/></td>

									<td class="admin_table_centered"><?php echo $siteqa->question_id ?></td>
									
									<?php 
									$owner_name = $this->user($siteqa->owner_id)->username;
									$truncate_owner_name = Engine_Api::_()->siteqa()->truncateText($owner_name, 10);
									?>		
									<td><?php echo $this->htmlLink($this->item('user', $siteqa->owner_id)->getHref()	, $truncate_owner_name, array('target' => '_blank')) ?></td>

									<?php $siteqa_title = Engine_Api::_()->siteqa()->truncateText($siteqa->getTitle(), 20);?>

									<td><?php echo $this->htmlLink($siteqa->getHref(), $siteqa_title, array('title' => $siteqa->getTitle(), 'target' => '_blank')) ?></td>

									
									<?php if($siteqa->approved == 1):?>
										<td align="center" class="admin_table_centered">
											<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'approved', 'question_id' => $siteqa->question_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Siteqa/externals/images/approved.gif', '', array('title'=> $this->translate('Dis-approve Question')))) ?> 
										</td>       
										<?php else: ?>  
											<td align="center" class="admin_table_centered"> 
												<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'approved', 'question_id' => $siteqa->question_id), $this->htmlImage($this->layout()->staticBaseUrl . 'application/modules/Siteqa/externals/images/disapproved.gif', '', array('title'=> $this->translate('Approve Question')))) ?>
											</td>
										<?php endif; ?>

										
										<td align="center" class="admin_table_centered"><?php echo $siteqa->view_count ?></td>

										<td align="center" class="admin_table_centered"><?php echo $siteqa->answer_count ?></td>

										<td align="center" class="admin_table_centered"><?php echo $siteqa->vote_count ?></td>

										<td align="center" class="admin_table_centered"><?php echo $siteqa->comment_count ?></td>

										<td align="center" class="admin_table_centered"><?php echo $siteqa->like_count ?></td>

										
										<td><?php echo $siteqa->creation_date ?></td>
										
										<td>
											<?php echo $this->htmlLink($siteqa->getHref(), $this->translate('view'), array('target' => '_blank')) ?>
											|
											<?php echo $this->htmlLink(array('route' => 'qa_specific', 'action' => 'edit', 'question_id' => $siteqa->getIdentity()), $this->translate('edit'), array('target' => '_blank')) ?>
											|
											<?php echo $this->htmlLink(array('route' => 'default', 'module' => 'siteqa', 'controller' => 'admin-site-qa', 'action' => 'delete', 'question_id' => $siteqa->question_id), $this->translate('delete'), array('class' => 'smoothbox')) ?> 
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
					var subcategories = function(category_id, sub, subcatname)
					{ 
						if($('subcategory_backgroundimage'))
							$('subcategory_backgroundimage').style.display = 'block';
						if($('subcategory_id'))
							$('subcategory_id').style.display = 'none';
						if($('subcategory_id-label'))
							$('subcategory_id-label').style.display = 'none';
						var url = '<?php echo $this->url(array('action' => 'sub-category'), 'siteqa_category', true);?>';
						en4.core.request.send(new Request.JSON({      	
							url : url,
							data : {
								format : 'json',
								category_id_temp : category_id
								
							},
							onSuccess : function(responseJSON) {
								if($('subcategory_backgroundimage'))
									$('subcategory_backgroundimage').style.display = 'none';				
								clear('subcategory_id');				
								var  subcatss = responseJSON.subcats;
								addOption($('subcategory_id')," ", '0');
								for (i=0; i< subcatss.length; i++) {
									addOption($('subcategory_id'), subcatss[i]['category_name'], subcatss[i]['category_id']);
									$('subcategory_id').value = sub;
								}				
								if(category_id == 0) {
									clear('subcategory_id');
									if($('subcategory_id'))
										$('subcategory_id').style.display = 'none';
									if($('subcategory_id-label'))
										$('subcategory_id-label').style.display = 'none';
									
								}
							}
						}));
					};
					
					function clear(ddName)
					{ 
						for (var i = (document.getElementById(ddName).options.length-1); i >= 0; i--) 
						{ 
							document.getElementById(ddName).options[ i ]=null; 
						} 
					}

					function addOption(selectbox,text,value )
					{
						var optn = document.createElement("OPTION");
						optn.text = text;
						optn.value = value;
						if(optn.text != '' && optn.value != '') {
							$('subcategory_id').style.display = 'block';
							$('subcategory_id-label').style.display = 'block';
							selectbox.options.add(optn);
						}
						else {
							$('subcategory_id').style.display = 'none';
							$('subcategory_id-label').style.display = 'none';
							selectbox.options.add(optn);
						}
					}

					var cat = '<?php echo $this->category_id ?>';
					if(cat != '') {
						var sub = '<?php echo $this->subcategory_id; ?>';
						var subcatname = "<?php echo $this->subcategory_name; ?>";
						subcategories(cat, sub, subcatname);
					}

					function addSubOption(selectbox,text,value )
					{
						var optn = document.createElement("OPTION");
						optn.text = text;
						optn.value = value;
						if(optn.text != '' && optn.value != '') {
							selectbox.options.add(optn);
						} else {
							selectbox.options.add(optn);
						}

					}
					if($('subcategory_id'))
						$('subcategory_id').style.display = 'none';
					if($('subcategory_id-label'))
						$('subcategory_id-label').style.display = 'none';
				</script>
