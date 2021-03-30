<?php
class Sitereview_HashtagfeedController extends Core_Controller_Action_Standard
{
    public function indexAction() {
        if (!in_array(
            'hashtags',
            Engine_Api::_()->getApi('settings', 'core')->getSetting('activity.composer.options')
        )) {
            return $this->_forward('notfound', 'error', 'core');
        }

        $this->_helper->content
            ->setEnabled()
        ;
    }
}