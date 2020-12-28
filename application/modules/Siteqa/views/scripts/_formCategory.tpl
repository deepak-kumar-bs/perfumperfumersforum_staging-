<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: _formCategory.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<?php
  
	$tableCategory = Engine_Api::_()->getDbTable('categories', 'siteqa');
	$categories = $tableCategory->getCategories(null);

	if (count($categories) != 0) {

		$que_id = Zend_Controller_Front::getInstance()->getRequest()->getParam('question_id', null);
		if(!empty($que_id) && empty($_POST)) {
			$siteqa = Engine_Api::_()->getItem('siteqa_question', $que_id);
		}
		elseif(empty($que_id) && empty($_POST)) {
			$siteqa->category_id = '["0"]';
			$siteqa->subcategory_id = '["0"]';
		}
		else {

			//GET CATEGORIES ARRAY
			foreach($_POST as $key => $value) {
				$sub = strstr($key, 'sub');
				$category = strstr($key, 'category_id_');

				if(empty($sub) && !empty($category) && !empty($value)) {

					$explode_array = explode('category_id_', $key);
					$key = $explode_array[1];

					//CATEGORY ID ARRAY
					$category_id[] = "$value";

					if(isset($_POST["category_id_$key"]) && (!isset($_POST["subcategory_id_$key"]) || (isset($_POST["subcategory_id_$key"]) && empty($_POST["subcategory_id_$key"])))) {
					}

				}
				elseif(!empty($sub) && !empty($category) && !empty($value)) {

					$explode_array = explode('subcategory_id_', $key);
					$key = $explode_array[1];

					//SUB-CATEGORY ID ARRAY
					$subcategory_id[] = "$value";

				}
				elseif(!empty($category) && !empty($value)) {
				}
			}

			$default_value = array(0 => '0');
			if(!empty($category_id)) {
				$siteqa->category_id = Zend_Json_Encoder::encode($category_id);
			}
			else {
				$siteqa->category_id = Zend_Json_Encoder::encode($default_value);
			}

			if(!empty($subcategory_id)) {
				$siteqa->subcategory_id = Zend_Json_Encoder::encode($subcategory_id);
			}
			else {
				$siteqa->subcategory_id = Zend_Json_Encoder::encode($default_value);
			}

		}

		$category_details = array();

		if(!empty($siteqa->category_id)) {
			$category_details[1][] = $siteqa->category_id;
		}

		if(!empty($siteqa->subcategory_id)) {
			$category_details[1][] = $siteqa->subcategory_id;
		}

		foreach($category_details as $key => $value) {

			$category_id = $value[0];
			$subcategory_id = $value[1];
			
			$subcategories_prepared = array();
			$subcategory_options_string = '';
			$subCategories = $tableCategory->getSubCategories($category_id);
			if (count($subCategories) != 0) {
				$subcategory_options_string = "<option value='0' label=''></option>";
				foreach ($subCategories as $subcategory) {
	
					$subcategory->category_name = Zend_Registry::get('Zend_Translate')->_("$subcategory->category_name");
					$subcategories_prepared[$subcategory->category_id] = $subcategory->category_name;

					if($subcategory_id == $subcategory->category_id) {
						$subcategory_options_string .= "<option value='$subcategory->category_id' label='$subcategory->category_name' selected='selected'>$subcategory->category_name</option>";
					}
					else {
						$subcategory_options_string .= "<option value='$subcategory->category_id' label='$subcategory->category_name'>$subcategory->category_name</option>";
					}
				}
			}

			$level = '';
			if($key == 1) {
				$level = Zend_Registry::get('Zend_Translate')->_('Category');
			}

			$category_options_string = "<option value='0' label=''></option>";
			foreach ($categories as $category) {
				$category->category_name = Zend_Registry::get('Zend_Translate')->_("$category->category_name");
				if($category_id == $category->category_id) {
					$category_options_string .= "<option value='$category->category_id' label='$category->category_name' selected='selected'>$category->category_name</option>";
				}
				else {
					$category_options_string .= "<option value='$category->category_id' label='$category->category_name'>$category->category_name</option>";
				}
			}

			if(Count($subcategories_prepared)) {
				$subCategoryElement = "<div class='fleft'>
						<div id='subcategory_id_$key"."_backgroundimage'></div>
						<div id='subcategory_id_$key-wrapper'>
							<div id='subcategory_id_$key-element'>
								<select name='subcategory_id_$key' id='subcategory_id_$key' >
									$subcategory_options_string
								</select>
							</div>
						</div>
					</div>";
			}
			else { 
				$subCategoryElement = "<div class='fleft'>
						<div id='subcategory_id_$key"."_backgroundimage'></div>
						<div id='subcategory_id_$key-wrapper' style='display:none;'>
							<div id='subcategory_id_$key-element'>
								<select name='subcategory_id_$key' id='subcategory_id_$key'>
									$subcategory_options_string
								</select>
							</div>
						</div>
					</div>";
			}

			echo "
			<div id='category_id_$key-wrapper' class='form-wrapper'>
				<div id='category_id_$key-label' class='form-label'>
					<label for='category_id_$key' class='required'>$level</label>
				</div>
				<div id='category_id_$key-element' class='form-element'>

					<div class='fleft'>
						<select name='category_id_$key' id='category_id_$key' onchange='subcategories(this.value, \"\", this.id);'>
								$category_options_string
						</select>
					</div>	

						$subCategoryElement


				</div>
			</div>

			";
		}
	}
?>