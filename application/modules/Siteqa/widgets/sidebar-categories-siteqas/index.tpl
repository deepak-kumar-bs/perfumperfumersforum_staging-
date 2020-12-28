<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Site
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<?php 

	$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl
  	              . 'application/modules/Siteqa/externals/styles/style_siteqa.css');

?>

<script type="text/javascript">

	var form;

  var categoryAction =function(category_id,categoryname, subcategory_id, subcategoryname)
  {
  	  	if($('filter_form_category')){
			var form = document.getElementById('filter_form_category');
		
		if($('category')){
			form.elements['category'].value = category_id;
		}

		if($('category_id')){
			form.elements['category_id'].value = category_id;
		}

		if($('categoryname')){
			form.elements['categoryname'].value = categoryname;
		}

		if($('subcategory')){
			form.elements['subcategory'].value = subcategory_id;
		}

		if($('subcategory_id')){
			form.elements['subcategory_id'].value = subcategory_id;
		}

		if($('subcategoryname')){
			form.elements['subcategoryname'].value = subcategoryname;
		}
	}
		form.submit();
  }

  function show_subcat(cat_id)
  {
    if(document.getElementById('subcat_' + cat_id)) {
      if(document.getElementById('subcat_' + cat_id).style.display == 'block') {
        document.getElementById('subcat_' + cat_id).style.display = 'none';
        document.getElementById('img_' + cat_id).removeClass('cat_minus');
        document.getElementById('img_' + cat_id).addClass('cat_plus');
      }
      else if(document.getElementById('subcat_' + cat_id).style.display == '') {
        document.getElementById('subcat_' + cat_id).style.display = 'none';
        document.getElementById('img_' + cat_id).removeClass('cat_minus');
        document.getElementById('img_' + cat_id).addClass('cat_plus');;
      }
      else {
        document.getElementById('subcat_' + cat_id).style.display = 'block';
        document.getElementById('img_' + cat_id).removeClass('cat_plus');
        document.getElementById('img_' + cat_id).addClass('cat_minus');
      }
    }
  }

	window.addEvent('domready', function() {
		var subcategory_default = '<?php echo $this->subcategorys; ?>';
		var subsubcategory_default = '<?php echo $this->subsubcategorys;?>';
		if(subcategory_default == 0)
		show_subcat('<?php echo $this->category; ?>');
	});
</script>

<?php if (count($this->categories)):?>
	<?php if(!$this->search_form_widget):?>
		<form id='filter_form_category' class='global_form_box' method='get' action='<?php echo $this->url(array('action' => 'browse'), 'qa_general', true) ?>' style='display: none;'>
			<input type="hidden" id="category" name="category"  value=""/>
			<input type="hidden" id="category_id" name="category_id"  value=""/>
			<input type="hidden" id="categoryname" name="categoryname"  value=""/>
			<input type="hidden" id="subcategory" name="subcategory"  value=""/>
			<input type="hidden" id="subcategory_id" name="subcategory_id"  value=""/>
			<input type="hidden" id="subcategoryname" name="subcategoryname"  value=""/>
			<input type="hidden" id="subsubcategory" name="subsubcategory"  value=""/>
			<input type="hidden" id="subsubcategory_id" name="subsubcategory_id"  value=""/>
			<input type="hidden" id="subsubcategoryname" name="subsubcategoryname"  value=""/> 
		</form>
	<?php endif; ?>
  <ul class="siteqa_browse_category">
    
		<?php foreach ($this->categories as $category):?>
			<?php $total_subcat = count($category['sub_categories']); ?>

			<?php if ($total_subcat > 0): ?>
				<li>
					<a href="javascript:show_subcat('<?php echo $category['category_id'] ?>')" id='button_<?php echo $category['category_id'] ?>' class="right_bottom_arrow">
						<?php if ($this->category != $category['category_id']): ?>
							<span class="cat_plus" border='0' id='img_<?php echo $category['category_id'] ?>'/></span>
						<?php elseif ($this->subcategorys != 0 && $this->category == $category['category_id']): ?>
							<span class="cat_minus" border='0' id='img_<?php echo $category['category_id'] ?>'></span>
						<?php elseif ($this->category != 0 && $this->category == $category['category_id']): ?>
							<span class="cat_plus" border='0' id='img_<?php echo $category['category_id'] ?>'>
							</span>
						<?php endif; ?>
					</a>
					<?php $category_name = $this->translate($category['category_name']);?>
					<?php $truncate_category = $this->siteqa_api->truncateText($category_name, $this->catTruncLimit);?>
					<a <?php if ($this->category == $category['category_id']): ?>class="bold"<?php endif; ?> href='javascript:void(0);' onclick="javascript:categoryAction('<?php echo $category['category_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($category['category_name']) ?>',0, '');">
						<span class="cat_icon"><?php if($category['file_id']):?><img alt=""  src='<?php echo $this->storage->get($category['file_id'], '')->getPhotoUrl(); ?>' /><?php endif; ?></span>
						<span class="cat_name" title="<?php echo $category_name; ?>"><?php echo $truncate_category; ?></span>
					</a>

					<ul id="subcat_<?php echo $category['category_id'] ?>" <?php if ($this->category != $category['category_id'] || $this->subcategorys == 0): ?>style="display:none;"<?php endif; ?> >
					<?php foreach ($category['sub_categories'] as $subcategory) : ?>
						<?php $total_subsubcat = count($subcategory['tree_sub_cat']); ?>
						<?php if ($total_subsubcat > 0): ?>
							<li>
								<a href="javascript:show_subsubcat('<?php echo $subcategory['sub_cat_id'] ?>')" id='button_<?php echo $subcategory['sub_cat_id'] ?>' class="right_bottom_arrow">
									<?php if ($this->subcategorys != $subcategory['sub_cat_id']): ?>
										<span alt="" class="cat_plus" border='0' id='img_<?php echo $subcategory['sub_cat_id'] ?>'></span>
									<?php elseif ($this->subsubcategorys != 0 && $this->subcategorys == $subcategory['sub_cat_id']): ?>
										<span class="cat_minus" border='0' id='img_<?php echo $subcategory['sub_cat_id'] ?>'></span>
									<?php elseif ($this->subcategorys != 0 && $this->subcategorys == $subcategory['sub_cat_id']): ?>
										<span alt="" class="cat_plus" border='0' id='img_<?php echo $subcategory['sub_cat_id'] ?>'></span>
									<?php endif; ?>
								</a>
								<?php $subcategory_name = $this->translate($subcategory['sub_cat_name']);?>
								<?php $truncate_subcategory = $this->siteqa_api->truncateText($subcategory_name, $this->subCatTruncLimit);?>
								<a <?php if ($this->subcategorys == $subcategory['sub_cat_id']): ?>class="bold"<?php endif; ?>  href='javascript:void(0);' onclick="javascript:categoryAction('<?php echo $category['category_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($category['category_name']) ?>','<?php echo $subcategory['sub_cat_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($subcategory['sub_cat_name']) ?>');">

									<span class="cat_icon"><?php if($subcategory['file_id']):?><img alt=""  src='<?php echo $this->storage->get($subcategory['file_id'], '')->getPhotoUrl(); ?>' /><?php endif; ?></span>
									<span class="cat_name" title="<?php echo $subcategory_name ?>"><?php echo $truncate_subcategory ?></span>
								</a>

								<ul id="subsubcat_<?php echo $subcategory['sub_cat_id'] ?>" <?php if ($this->subcategorys != $subcategory['sub_cat_id'] || $this->subsubcategorys == 0): ?>style="display:none;"<?php endif; ?> >

									<?php if(isset($subcategory['tree_sub_cat'])):?>
										<?php foreach ($subcategory['tree_sub_cat'] as $subsubcategory) : ?>
											<li>
												<?php $subsubcategory_name = $this->translate($subsubcategory['tree_sub_cat_name']);?>
												<?php $truncate_subsubcategory = $this->siteqa_api->truncateText($subsubcategory_name, $this->subsubCatTruncLimit);?>
												<a <?php if ($this->subsubcategorys == $subsubcategory['tree_sub_cat_id']): ?>class="bold"<?php endif; ?>  href='javascript:void(0);' onclick="javascript:categoryAction('<?php echo $category['category_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($category['category_name']) ?>','<?php echo $subcategory['sub_cat_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($subcategory['sub_cat_name']) ?>', '<?php echo $subsubcategory['tree_sub_cat_id'] ?>', '<?php echo $subsubcategory['tree_sub_cat_name']?>');">
													<span class="cat_icon"><?php if($subsubcategory['file_id']):?><img alt=""  src='<?php echo $this->storage->get($subsubcategory['file_id'], '')->getPhotoUrl(); ?>' /><?php endif; ?></span>
													<span class="cat_name" title="<?php echo $subsubcategory_name ?>"><?php echo $truncate_subsubcategory; ?></span>
												</a>
											</li>
										<?php endforeach; ?>
									<?php endif;?>
								</ul>
							</li>  
						<?php else:?>
							<li>
								<?php $subcategory_name = $this->translate($subcategory['sub_cat_name']);?>
								<?php $truncate_subcategory = $this->siteqa_api->truncateText($subcategory_name, $this->subCatTruncLimit);?>
								<a <?php if ($this->subcategorys == $subcategory['sub_cat_id']): ?>class="bold"<?php endif; ?>  href='javascript:void(0);' onclick="javascript:categoryAction('<?php echo $category['category_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($category['category_name']) ?>','<?php echo $subcategory['sub_cat_id'] ?>','<?php echo $this->categoryTable->getCategorySlug($subcategory['sub_cat_name']) ?>');">
									<span class="cat_icon"><?php if($subcategory['file_id']):?><img alt=""  src='<?php echo $this->storage->get($subcategory['file_id'], '')->getPhotoUrl(); ?>' /><?php endif; ?></span>
									<span class="cat_name" title="<?php echo $subcategory_name ?>"><?php echo $truncate_subcategory; ?></span>
								</a>
							</li>  
						<?php endif;?>
						<?php endforeach; ?>
					</ul>
				</li>
      <?php else: ?>
        <li>
					<?php $category_name = $this->translate($category['category_name']);?>
					<?php $truncate_category = $this->siteqa_api->truncateText($category_name, $this->catTruncLimit);?>
					<a <?php if ($this->category == $category['category_id']): ?>class="bold"<?php endif; ?>  href='javascript:void(0);' onclick="javascript:categoryAction('<?php echo $category["category_id"] ?>','<?php echo $this->categoryTable->getCategorySlug($category["category_name"]) ?>', 0, '');">
						<span class="cat_icon"><?php if($category['file_id']):?><img alt=""  src='<?php echo $this->storage->get($category['file_id'], '')->getPhotoUrl(); ?>' /><?php endif;?></span>
						<span class="cat_name" title="<?php echo $category_name ?>"><?php echo $truncate_category ?></span>
					</a>
        </li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
<?php endif;?>