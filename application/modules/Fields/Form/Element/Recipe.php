<?php
/**
 * SocialEngine
 *
 * @category   Application_Core
 * @package    Fields
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: FirstName.php 9747 2012-07-26 02:08:08Z john $
 * @author     John
 */

/**
 * @category   Application_Core
 * @package    Fields
 * @copyright  Copyright 2006-2010 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @author     John
 */
class Fields_Form_Element_Recipe extends Zend_Form_Element_Xhtml
{
	public $helper = 'formRecipe';

	public function setValue($value)
  	{	
    	if( is_array($value) )
    	{
        	// /$value = $value['year'].'-'.$value['month'].'-'.$value['day'];
        	if (empty($value)) {
          		return parent::setValue(NULL);
        	}
    	}
    return parent::setValue($value);
  }

    /**
   * Load default decorators
   *
   * @return void
   */
  public function loadDefaultDecorators()
  {
    if( $this->loadDefaultDecoratorsIsDisabled() )
    {
      return;
    }

    $decorators = $this->getDecorators();
    if( empty($decorators) )
    {
      $this->addDecorator('ViewHelper');
      Engine_Form::addDefaultDecorators($this);
    }
  }

  public function getValue() { 
    
    return parent::getValue($subject);
  }
}