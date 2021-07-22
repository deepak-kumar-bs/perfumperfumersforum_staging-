<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteapi
 * @copyright  Copyright 2015-2016 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    Core.php 2015-09-17 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
class Advancedactivity_Api_Siteapi_Core extends Core_Api_Abstract {

    public function targetUserForm() {
        $targetForm = array();
        $targetForm[] = array(
            "type" => 'Radio',
            "name" => 'who',
            "label" => 'Gender',
            'multiOptions' => array(
                '' => 'All',
                'male' => 'Male',
                'female' => 'Female',
            ),
            'value' => '',
        );

        $age = array('');
        $ageOption = 13;
        while ($ageOption <= 98) {
            ++$ageOption;
            $age[$ageOption] = "" . $ageOption;
        }
        $targetForm[] = array(
            "type" => 'Select',
            "name" => 'min_age',
            "label" => 'Min age',
            'multiOptions' => $age,
            'value' => 0,
            "hasValidator" => true
        );
        $age[0] = '';
        $targetForm[] = array(
            "type" => 'Select',
            "name" => 'max_age',
            "label" => 'Max age',
            'multiOptions' => $age,
            'value' => 0,
            "hasValidator" => true
        );

        return $targetForm;
    }

    public function schedulePostForm() {
        $postscheduleForm = array();

        $postscheduleForm[] = array(
            "type" => 'date',
            "name" => 'schedule_time',
            "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('Schedule Your Post'),
            "hasValidator" => true
        );
        $timezone = Engine_Api::_()->getApi('settings', 'core')->core_locale_timezone;
        return $postscheduleForm;
    }

    Public function sellSomthingForm() {
        Engine_Api::_()->getApi('Core', 'siteapi')->setLocal();
        $sellSomethingForm = array();
        $sellSomethingForm[] = array(
            "type" => 'Text',
            "name" => 'title',
            "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('What to sell?'),
            "hasValidator" => true,
        );

        if (Engine_Api::_()->hasModuleBootstrap('sitemulticurrency')) {
            $currency = Engine_Api::_()->getDbTable('currencyrates', 'sitemulticurrency')->getAllowedCurrencies();
            $selected = Engine_Api::_()->sitemulticurrency()->getSelectedCurrency();
        } else {
            $translationList = Zend_Locale::getTranslationList('nametocurrency', Zend_Registry::get('Locale'));
            $symbols = array_keys($translationList);
            $currency = array_combine($symbols, $symbols);
            $selected = 'USD';
        }
        $sellSomethingForm[] = array(
            "type" => 'Select',
            "name" => 'currency',
            "label" => 'Currency',
            'multiOptions' => $currency,
            'value' => $selected,
            "hasValidator" => true
        );

        $sellSomethingForm[] = array(
            "type" => 'Text',
            "name" => 'price',
            "label" => 'What is price?',
            "inputType" => 'number',
            "hasValidator" => true
        );
        $sellSomethingForm[] = array(
            "type" => 'Text',
            "name" => 'location',
            "label" => 'Where to sell?',
            "hasValidator" => true
        );

        $sellSomethingForm[] = array(
            "type" => 'Textarea',
            "name" => 'description',
            "label" => 'Product description',
        );

        $sellSomethingForm[] = array(
            "type" => 'File',
            "name" => 'photo',
            "label" => 'Add Photo',
        );

        return $sellSomethingForm;
    }

    public function getForm() {
        try {


            $response['targetForm'] = $this->targetUserForm();
            $response['scheduleForm'] = $this->schedulePostForm();
            $response['sellingForm'] = $this->sellSomthingForm();
        } catch (Exception $ex) {
            
        }
        return $response;
    }

    public function statusBoxSettings()
    {
        try
            {
                $viewer = Engine_Api::_()->user()->getViewer();
                $viewer_id = $viewer->getIdentity();
                $allow = array();
                if (empty($viewer_id))
                    return $allow;

                $coreSettingsApi = Engine_Api::_()->getApi('settings', 'core');
                $statusBox = $coreSettingsApi->getSetting('advancedactivity.composer.options', array("withtags", "emotions", "userprivacy", "webcam", "postTarget", "schedulePost"));
                $statusBoxOption = $coreSettingsApi->getSetting('advancedactivity.composer.menuoptions');
                if (in_array("postTarget", $statusBox))
                    $allow['allowTargetPost'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_targeted_post_enable');
                else {
                    $allow['allowTargetPost'] = 0;
                }
                $allow['allowSchedulePost'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_schedule_post_enable');
                if (in_array("feelingXXXadvancedactivity", $statusBoxOption)){
                $allow['allowfeelingActivity'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_add_feeling_enable');
                }
                else
                    $allow['allowfeelingActivity'] = 0;

               $feelingCount =$this-> _fellingCount();
               if(empty($feelingCount))
                   $allow['allowfeelingActivity']=0;

                if (in_array("sellXXXadvancedactivity", $statusBoxOption))
                    $allow['allowAdvertize'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_advertise_enable');
                else {
                    $allow['allowAdvertize'] = 0;
                }


                $allow['allowPin'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_pinunpin_enable');

                $allow['allowGreeting'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_greeting_enable');

                $allow['allowMemories'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_memories_enable');
                if (in_array("bannerXXXadvancedactivity", $statusBoxOption)){
                $allow['allowBanner'] = Engine_Api::_()->authorization()->isAllowed('advancedactivity_feed', $viewer, 'aaf_feed_banner_enable');
                }
             else 
                 $allow['allowBanner'] = 0;
                return $allow;
            } 
        catch (Exception $ex)
        {

        }
    }

    public function setPhoto($photo, $values, $setRow = true) {
        if ($photo instanceof Zend_Form_Element_File) {
            $file = $photo->getFileName();
        } else if (is_array($photo) && !empty($photo['tmp_name'])) {
            $file = $photo['tmp_name'];
        } else if (is_string($photo) && file_exists($photo)) {
            $file = $photo;
        } else {
            throw new Banner_Model_Exception('invalid argument passed to setPhoto');
        }
        $imageName = $photo['name'];
        $name = basename($file);
        $path = APPLICATION_PATH . DIRECTORY_SEPARATOR . 'temporary';

        if(empty($setRow)){
           $params = array(
            'parent_type' => 'advancedactivity_story_filter',
            'parent_id' => $values->getIdentity(),
        ); 
        }
        else
        $params = array(
            'parent_type' => $values->getType(),
            'parent_id' => $values->getIdentity(),
        );


// Save
        $storage = Engine_Api::_()->storage();

// Resize image (main)
        $image = Engine_Image::factory();
        $image->open($file)
                ->resize(720, 750)
                ->write($path . '/m_' . $imageName)
                ->destroy();

// Resize image (icon)
        $image = Engine_Image::factory();
        $image->open($file);

        $size = min($image->height, $image->width);
        $x = ($image->width - $size) / 2;
        $y = ($image->height - $size) / 2;

        $image->resample($x, $y, $size, $size, 48, 48)
                ->write($path . '/is_' . $imageName)
                ->destroy();


// Store
        $iMain = $storage->create($path . '/m_' . $imageName, $params);
        $iSquare = $storage->create($path . '/is_' . $imageName, $params);

        $iMain->bridge($iSquare, 'thumb.icon');

// Remove temp files

        @unlink($path . '/m_' . $imageName);
        @unlink($path . '/is_' . $imageName);


// Update row
        if (!empty($setRow)) {
            $values->photo_id = $iMain->getIdentity();
            $values->save();
        }

        return $values;
    }

    public function getVideoUrl($video) { // Uploded Videos
        $staticBaseUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.static.baseurl', null);

        $getHost = Engine_Api::_()->getApi('Core', 'siteapi')->getHost();
        $getDefaultStorageId = Engine_Api::_()->getDbtable('services', 'storage')->getDefaultServiceIdentity();
        $getDefaultStorageType = Engine_Api::_()->getDbtable('services', 'storage')->getService($getDefaultStorageId)->getType();

        $host = '';
        if ($getDefaultStorageType == 'local')
            $host = !empty($staticBaseUrl) ? $staticBaseUrl : $getHost;

        $video_location = Engine_Api::_()->storage()->get($video->file_id, $video->getType())->getHref();

        $video_location = strstr($video_location, 'http') ? $video_location : $host . $video_location;

        return $video_location;
    }

    public function isAllowMessage($viewer, $story) {
        if (empty($story) || empty($viewer))
            return 0;
        $subject = $story->getOwner();
         $canSendMessage = Engine_Api::_()->authorization()->getPermission($viewer, 'messages', 'auth');
         if($canSendMessage=='none')
             return 0;
         if($canSendMessage == 'everyone')
             return 1;
         
        if($subject->membership()->isMember($viewer))
            return 1;
        else 
            return 0;
    }

    public function getHostUrl($imageUrl = '') {
        if (strstr($imageUrl, 'http')){
            return $imageUrl;
        }
        $getParentHost = Engine_Api::_()->getApi('Core', 'siteapi')->getHost();
        $baseParentUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $baseParentUrl = @trim($baseParentUrl, "/");
        $staticBaseUrl = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.static.baseurl', null);
        // Check IF default service "Local Storage" or not.
        $getDefaultStorageId = Engine_Api::_()->getDbtable('services', 'storage')->getDefaultServiceIdentity();
        $getDefaultStorageType = Engine_Api::_()->getDbtable('services', 'storage')->getService($getDefaultStorageId)->getType();
        $host = '';
        if ($getDefaultStorageType == 'local')
            $host = !empty($staticBaseUrl) ? $staticBaseUrl : $getParentHost;
        $imageUrl = (!strstr($imageUrl, "application/modules") && !strstr($imageUrl, 'http')) ? $host . $imageUrl : $imageUrl;
        if (!strstr($imageUrl, 'http'))
            $imageUrl = $getParentHost . DIRECTORY_SEPARATOR . $baseParentUrl . $imageUrl;
        return $imageUrl;
    }

    private function _fellingCount() {
        $table = Engine_Api::_()->getDbtable('feelingtypes', 'advancedactivity');
        $select = $table->select($table->info('name'))
                ->where("enabled =?", 1)
                ->order('order ASC');
        $feelingtypes = $table->fetchAll($select);
        if(count($feelingtypes)>0)
            return 1;
        else
            return 0;
    }
    
    public function gutterMenus($action,$canDelete,$poster,$comment){
        $viewer = Engine_Api::_()->user()->getViewer();
        $enabledAdvComment = Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('nestedcomment');
        if ($viewer->getIdentity() && (("user" == $comment->poster_type && $viewer->getIdentity() == $comment->poster_id) || ("user" !== $comment->poster_type && Engine_Api::_()->getItemByGuid($comment->poster_type . "_" . $comment->poster_id)->isOwner($viewer)))){
        // if (!empty($canDelete) || $poster->isSelf($viewer)) {
            $menus[] = array(
                "name" => "comment_edit",
                "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('Edit'),
                "url" => "advancedcomments/comment-edit",
                'urlParams' => array(
                    "action_id" => $action->getIdentity(),
                    "subject_type" => $action->getType(),
                    "subject_id" => $action->getIdentity(),
                    "comment_id" => $comment->comment_id
                )
            );
            
            $menus[] = array(
                "name" => "comment_delete",
                "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('Delete'),
                "url" => "comment-delete",
                'urlParams' => array(
                    "action_id" => $action->getIdentity(),
                    "subject_type" => $action->getType(),
                    "subject_id" => $action->getIdentity(),
                    "comment_id" => $comment->comment_id
                )
            );

           
        }
        
        $canCopy = $this->canCopy($comment);
         if($canCopy)
        $menus[] = array(
                "name" => "comment_copy",
                "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('Copy'),
                
            );
        $menus[] = array(
                "name" => "comment_cancel",
                "label" => Engine_Api::_()->getApi('Core', 'siteapi')->translate('Cancel'),
                
            );
        return $menus;
        
        
    }
    
    public function canCopy($comment){
        if(!empty($comment->body)){
                    return 1;
                }
        else
            return 0;
    }
    

}
