<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: Edit.php 9747 2012-07-26 02:08:08Z john $
 * @author     Jung
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */
class Siteqa_Form_Edit extends Siteqa_Form_Create
{
  
  public function init()
  {
    parent::init();
    $this->setTitle('Edit Question')
    ->setDescription('Edit your Question below, then click on Save Changes to edit your Question.');
    $this->submit->setLabel('Save Changes');
  }
}
