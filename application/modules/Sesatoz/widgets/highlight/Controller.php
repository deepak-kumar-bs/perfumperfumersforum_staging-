<?php



/**

 * SocialEngineSolutions

 *

 * @category   Application_Sesatoz

 * @package    Sesatoz

 * @copyright  Copyright 2018-2019 SocialEngineSolutions

 * @license    http://www.socialenginesolutions.com/license/

 * @version    $Id: Controller.php  2018-10-05 00:00:00 SocialEngineSolutions $

 * @author     SocialEngineSolutions

 */

class Sesatoz_Widget_HighlightController extends Engine_Content_Widget_Abstract {

  public function indexAction() {

     $this->view->contentbackgroundcolor = $this->_getParam('contentbackgroundcolor', '2fc581');

     $this->view->heading = $this->_getParam('title', '');

     $this->view->widgetdescription = $this->_getParam('widgetdescription', '');

     $this->view->design = $design = $this->_getParam('sesatoz_highlight_design', '1');

     $this->view->module = $module = $this->_getParam('sesatoz_highlight_module', '');

     $popularitycriteria = $this->_getParam('popularitycriteria', 'creation_date');

     if(!$this->view->module)

      $this->setNoRender();
			if($design == 7)
			$limit = 3;
       else if($design == 5)

            $limit = 8;

        else if($design == 4)

            $limit = 3;

        else if($design == 3)

            $limit = 3;

      else if($design == 2)

        $limit = 6;

      elseif($design == 1)

        $limit = 3;

          elseif($design == 4)

        $limit = 6;

     else	$limit = 15;

//       if( !Engine_Api::_()->hasItemType($module) ) {

//         continue;

//       }

      $table = Engine_Api::_()->getItemTable($module);

      $tableName = $table->info('name');

      $select = $table->select()->from($tableName)->limit($limit);

      $db = Zend_Db_Table_Abstract::getDefaultAdapter();

      $sesatoz_landingpage = Zend_Registry::isRegistered('sesatoz_landingpage') ? Zend_Registry::get('sesatoz_landingpage') : null;

      if(empty($sesatoz_landingpage)) {

        return $this->setNoRender();

      }

			$popularitycriteria_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE '".$popularitycriteria."'")->fetch();

			if (!empty($popularitycriteria_exist)) {

				$select->order("$popularitycriteria DESC");

			} else {

        $select->order('creation_date DESC');

      }

			$column_exist = $db->query("SHOW COLUMNS FROM ".$tableName." LIKE 'is_delete'")->fetch();

			if (!empty($column_exist)) {

				$select->where('is_delete =?',0);

			}



      $this->view->result = $result = $table->fetchAll($select);

      if(!count($result))

        $this->setNoRender();

  }

}

