<?php

/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitehashtag
 * @copyright  Copyright 2017-2021 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: ProjectPayments.php 2017-03-27 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */ 

class Sitehashtag_Plugin_Job_Hashtags extends Core_Plugin_Job_Abstract {

    protected function _execute() {
        // Get job and params
        $job = $this->getJob();
        set_time_limit(0);
         // Process

        if (!($attachments = $this->getParam('attachments'))) {
            $this->_setState('failed', 'No attachments provided.');
            $this->_setWasIdle();
            return;
        }

        try {
                $actionsIds = array();
                $hashtags = $this->getParam('hashtags');
                $actionHashTag = array();
                foreach ($attachments as $attachment) {
                    $action = Engine_Api::_()->getItem('activity_action', $attachment['action_id']);
                    if(!$action){
                        continue;
                    }
                    if ($action->body) {
                        $actionHashtags = Engine_Api::_()->sitehashtag()->getHashTags($action->body);
                        if (!empty($actionHashtags[0])) {
                            $actionHashTag[$attachment['action_id']] = $actionHashtags[0];
                        }
                    }
                    $actionsIds[] = $attachment['action_id'];
                }
                $tagMap = Engine_Api::_()->getDbtable('tags', 'sitehashtag');
                foreach (array_unique($actionsIds) as $action_id) {
                    $tags = !empty($actionHashTag[$action_id]) ? array_merge($actionHashTag[$action_id], $hashtags) : $hashtags;
                    $tagMap->editHashTagMaps($action_id, array($tags));
                }
            $this->_setIsComplete(true);
        } catch (Exception $e) {
            $this->_setState('failed', 'Exception: ' . $e->getMessage());
        }
    }
}