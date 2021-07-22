<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions 
 * @package    Advancedactivity
 * @copyright  Copyright 2009-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl  2011-02-16 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>
<?php if ($this->addType == 1): ?>
<div class="cmad_ad_clm">
    <div class="cmad_block_wrp">
        <?php
        include APPLICATION_PATH . '/application/modules/Advancedactivity/views/scripts/_displayCoreAds.tpl';
        ?>
    </div>
</div>
<?php elseif ($this->addType == 2): ?>
<?php $content_id = $this->identity ? $this->identity : ($this->widgetId?$this->widgetId:rand(1000000000, 9999999999))?>
<div class="cmad_ad_clm">
    <div class="cmad_block_wrp">
        <?php
        include APPLICATION_PATH . '/application/modules/Communityad/views/scripts/_adsDisplay.tpl';
        ?>
    </div>
</div>
<?php elseif($this->addType == 3): ?>
<div class="sitead_ad_clm">
    <div class="sitead_block_wrp">
        <?php
        include APPLICATION_PATH . '/application/modules/Sitead/views/scripts/_adsDisplay.tpl';
        ?>   
    </div>
</div>
<?php endif; ?>
<?php 
if(!empty($this->boostActionId)) {
     $action = Engine_Api::_()->getDbtable('actions', 'advancedactivity')->getActionById($this->boostActionId);
     echo $this->advancedActivity($action, array('noList' => true, 'feedSettings' => array('memberPhotoStyle' => 'left'))); 
}
?>


