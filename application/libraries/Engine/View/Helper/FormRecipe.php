<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: FormText.php 9382 2011-10-14 00:41:45Z john $
 */


/**
 * Abstract class for extension
 */
// require_once 'Zend/View/Helper/FormElement.php';


/**
 * Helper to generate a "text" element
 *
 * @category   Zend
 * @package    Zend_View
 * @subpackage Helper
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Engine_View_Helper_FormRecipe extends Zend_View_Helper_FormElement
{
    /**
     * Generates a 'text' element.
     *
     * @access public
     *
     * @param string|array $name If a string, the element name.  If an
     * array, all other parameters are ignored, and the array elements
     * are used in place of added parameters.
     *
     * @param mixed $value The element value.
     *
     * @param array $attribs Attributes for the element tag.
     *
     * @return string The element XHTML.
     */
    public function formRecipe($name, $value = null, $attribs = null)
    {   
        $fields_param = explode("_",$name);
        $field_el_id = "'".$name."'";
        $field_id = $fields_param[2];

        $field_object = Engine_Api::_()->fields()->getFieldsMeta('sitereview_listing')->getRowMatching('field_id', $fields_param[2]);

        $new_values = array();
        if(isset($value['name']) && !empty($value['name'])) {
          $new_values[] = json_encode($value['name']);
          $new_values[] = json_encode($value['amount']);
          $new_values[] = json_encode($value['dilution']);
          $new_values[] = json_encode($value['listing_id']);

          // set values 
          $value = $new_values;
        }
        
        $recipe_data = array();
        $counter = count(json_decode($value[0]));

        if (!empty($value)) {
          $value[0] = json_decode($value[0]);
          $value[1] = json_decode($value[1]);
          $value[2] = json_decode($value[2]);
          $value[3] = json_decode($value[3]);

          while($counter--) {
            $ingredient_id = array_shift($value[0]);
            $recipe_data[] = array('field_name' => $field_el_id, 'name' => $ingredient_id, 'amount' => array_shift($value[1]), 'dilution' =>array_shift($value[2]));
          }

          $set_value  = $recipe_data[0];
          if(!empty($recipe_data)) {
            $recipe_data = json_encode($recipe_data);
          } else {
            $recipe_data = json_encode(array('field_name'=> $name, 'field_id' => $field_id));
          }
          
        } else {
          $set_value = array('name' => '','amount' => '', 'dilution' => '100' );
          $recipe_data = json_encode(array('field_name'=> $name, 'field_id' => $field_id));
        }

        $this->addRequiredFiles();
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable

        // build the element
        $disabled = '';
        if ($disable) {
            // disabled
            $disabled = ' disabled="disabled"';
        }
        
        // input type (support for html5)
        $type = 'text';
        if( !empty($attribs['inputType']) ) {
          $type = $attribs['inputType'];
          unset($attribs['inputType']);
        }
        
        // XHTML or HTML end tag?
        $endTag = ' />';
        if (($this->view instanceof Zend_View_Abstract) && !$this->view->doctype()->isXhtml()) {
            $endTag= '>';
        }

        // ADD SCRIPT
        $script = '<script>';
        $js = 'en4.core.runonce.add(initializeRecipeField('.$recipe_data.'))' ;
        $script .= $js;
        $script .= '</script>';

        $classes =  Explode(' ', $attribs['class']);
        $classes[1] = $classes[1].'_name';
        $classes[] = 'input_element_select2';
        $attribs1 = $attribs;
        $attribs1['class'] = implode(' ', $classes);

        unset($attribs1['show']);
        unset($attribs1['quick_info']);
        unset($attribs1['style']);

        $attribs['placeholder'] = 'Enter the amount of '.$field_object->label;
        $classes =  Explode(' ', $attribs['class']);
        $classes[1] = $classes[1].'_amount';
        $attribs2 = $attribs;
        $attribs2['class'] = implode(' ', $classes);

        $attribs['placeholder'] = 'Enter the amount of dilution ( % ) of '.$field_object->label;
        $classes =  Explode(' ', $attribs['class']);
        $classes[1] = $classes[1].'_dilution';
        $attribs3 = $attribs;
        $attribs3['class'] = implode(' ', $classes);
        $attribs3['min'] = '0';
        $attribs3['max'] = '100';

        $label1 = '<label for="'.$this->view->escape($name).'['.'name'.'][]'.'" >Name</label>';
        $xhtml1 = "<div class = 'name'>".$label1.'<select name="' . $this->view->escape($name).'['.'name'.'][]'. '"'
                . ' id="' . $this->view->escape($id) .'_name'. '"'
                . ' value="' . $this->view->escape($set_value['name']) . '"'
                . $disabled
                . $this->_htmlAttribs($attribs1)
                . ">\n    ";
        // make the options 

        $option_table = Engine_Api::_()->fields()->getTable('sitereview_listing', 'options');
        $option = $option_table->select()
            ->from($option_table->info('name'))
            ->where('field_id = ?', $field_id)
            ->query()
            ->fetchAll();

        $listings = Engine_Api::_()->getDbtable('listings', 'sitereview')->getListings(array('listingtype_id' => $option[0]['label']));

        $option_ele = '<option></option>';
        foreach ($listings as $value) {
          // $data[] = array('id' => $value->listing_id, 'label' => $value->title);
          $option_ele = $option_ele.'<option value ='.$value->listing_id.' >'.$value->title.'</option>';
        }
        
        $xhtml1 = $xhtml1.$option_ele."</select></div>";

        // option work ended.

        $label2 = '<label for="'.$this->view->escape($name).'['.'amount'.'][]'.'" >Amount</label>';
        $xhtml2 = "<div class = 'amount'>".$label2.'<input type="' . 'number' . '"'
                . ' name="' . $this->view->escape($name).'['.'amount'.'][]'. '"'
                . ' id="' . $this->view->escape($id) .'_amount'. '"'
                . ' value="' . $this->view->escape($set_value['amount']) . '"'
                . $disabled
                . $this->_htmlAttribs($attribs2)
                . $endTag."</div>";

        $label3 = '<label for="'.$this->view->escape($name).'['.'dilution'.'][]'.'" >Dilution</label>';
        $xhtml3 = "<div class = 'dilution'>".$label3.'<input type="' . 'number' . '"'
                . ' name="' . $this->view->escape($name).'['.'dilution'.'][]'. '"'
                . ' id="' . $this->view->escape($id) .'_dilution'. '"'
                . ' value="' . $this->view->escape($set_value['dilution']) . '"'
                . $disabled
                . $this->_htmlAttribs($attribs3)
                . $endTag."</div>";

        $return_xhtml = $xhtml1.' '.$xhtml2.' '.$xhtml3;
        $return_xhtml .= "\n" . $script;
        return $return_xhtml;
    }

    protected function addRequiredFiles() {
      $this->view->headScript()->appendFile($this->view->layout()->staticBaseUrl . 'application/modules/Recipefield/externals/scripts/Recipe.js')->appendFile($this->view->layout()->staticBaseUrl .  'externals/autocompleter/Observer.js')->appendFile($this->view->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')->appendFile($this->view->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')->appendFile($this->view->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js')->appendFile($this->view->layout()->staticBaseUrl . 'application/modules/Recipefield/externals/scripts/jquery.min.js')->appendFile($this->view->layout()->staticBaseUrl . 'application/modules/Recipefield/externals/scripts/select2.min.js');

        $this->view->headLink()->appendStylesheet($this->view->layout()->staticBaseUrl . 'application/modules/Recipefield/externals/styles/select2.min.css')
        ->appendStylesheet($this->view->layout()->staticBaseUrl . 'application/modules/Recipefield/externals/styles/main.css');

    }
}
