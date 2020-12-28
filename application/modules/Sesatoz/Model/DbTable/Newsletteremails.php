<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: Newsletteremails.php  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */

class Sesatoz_Model_DbTable_Newsletteremails extends Core_Model_Item_DbTable_Abstract {

    protected $_rowClass = "Sesatoz_Model_Newsletteremail";

    public function isExist($email) {

        return $this->select()
                        ->from($this->info('name'), array('newsletteremail_id'))
                        ->where('email =?', $email)
                        ->query()
                        ->fetchColumn();
    }
}
