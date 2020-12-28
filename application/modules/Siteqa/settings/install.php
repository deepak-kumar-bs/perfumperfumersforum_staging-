<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: install.php 9895 2013-02-14 00:12:22Z shaun $
 * @author     Steve
 */

/**
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 */

require_once realpath(dirname(__FILE__)) . '/seaocore_install.php';

class Siteqa_Installer extends Sitecore_License_Installer
{
    protected $_installConfig = array(
        'sku' => 'siteqa',
    );

    public function onInstall()
    {
        $db = $this->getDb();
        $select = new Zend_Db_Select($db);

        $this->_addQuestionViewPage();
        $this->_addAnswerViewPage();
        $this->_addQuestionBrowsePage();
        $this->_addQuestionCreatePage();
        $this->_addQuestionManagePage();
        $this->_addTagsViewPage();

        parent::onInstall();
    }

    protected function _addQuestionManagePage()
    {
        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_manage')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_manage',
                'displayname' => 'Question Manage Page',
                'title' => 'My Questions',
                'description' => 'This page lists a user\'s question entries.',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $mainRightId = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $pageId,
                'parent_content_id' => $mainMiddleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.tagcloud-siteqas',
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'order' => 1,
            ));
        }
    }


    protected function _addQuestionCreatePage()
    {

        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_create')
            ->limit(1)
            ->query()
            ->fetchColumn();

        if( !$pageId ) {

            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_create',
                'displayname' => 'Question Create Page',
                'title' => 'Write New Question',
                'description' => 'This page is the question create page.',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $pageId,
                'parent_content_id' => $mainMiddleId,
                'order' => 1,
            ));
        }
    }

    protected function _addQuestionBrowsePage()
    {
        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_browse')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_browse',
                'displayname' => 'Question Browse Page',
                'title' => 'Question Browse',
                'description' => 'This page lists question entries.',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $mainRightId = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 2,
            ));

            // Insert search
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-search',
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'order' => 1,
            ));

            // Insert search
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-questions',
                'page_id' => $pageId,
                'parent_content_id' => $mainMiddleId,
                'order' => 1,
            ));

            // Most voted question
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.voted-questions', 
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'params'=> '{"title":"Most Voted Questions"}',
                'order' => 2,
            ));

            // Question of the day
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.item-sitequestion',
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'params'=> '{"title":"Question of the Day"}',
                'order' => 3,
            ));

            // Insert tag lists
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.tagcloud-siteqas',
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'order' => 4,
            ));

            // Insert list categories
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.sidebar-categories-siteqas',
                'page_id' => $pageId,
                'parent_content_id' => $mainRightId,
                'order' => 5,
            ));
        }
    }

    protected function _addQuestionViewPage()
    {
        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_view')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_view',
                'displayname' => 'Question Profile Page',
                'title' => 'Question View',
                'description' => 'This page displays a question entry.',
                'provides' => 'subject=question',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
            ));
            $mainId = $db->lastInsertId();

            // Insert left
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'left',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $leftId = $db->lastInsertId();

            // Insert middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $middleId = $db->lastInsertId();

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $middleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $pageId,
                'parent_content_id' => $middleId,
                'order' => 2,
            ));
            
            // Create Question
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.new-question',
                'page_id' => $pageId,
                'parent_content_id' => $leftId,
                'order' => 1,
            ));

            // Other Question from owner
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.other-questions',
                'page_id' => $pageId,
                'parent_content_id' => $leftId,
                'params'=> '{"title":"Other Questions from Owner"}',
                'order' => 2,
            ));

        }
    }   

    protected function _addAnswerViewPage()
    {
        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_answerview')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_answerview',
                'displayname' => 'Answer View Page',
                'title' => 'My Answers',
                'description' => 'This page displays a question entry where the user posted answer.',
                'provides' => 'subject=question',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $mainRightId = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'core.content',
                'page_id' => $pageId,
                'parent_content_id' => $mainMiddleId,
                'order' => 1,
            ));
        }
    }

    protected function _addTagsViewPage()
    {
        $db = $this->getDb();

        // profile page
        $pageId = $db->select()
            ->from('engine4_core_pages', 'page_id')
            ->where('name = ?', 'siteqa_index_tagscloud')
            ->limit(1)
            ->query()
            ->fetchColumn();

        // insert if it doesn't exist yet
        if( !$pageId ) {
            // Insert page
            $db->insert('engine4_core_pages', array(
                'name' => 'siteqa_index_tagscloud',
                'displayname' => 'Tags view Page',
                'title' => 'Tags view',
                'description' => 'This page displays tags.',
                'provides' => 'subject=question',
                'custom' => 0,
            ));
            $pageId = $db->lastInsertId();

            // Insert top
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'top',
                'page_id' => $pageId,
                'order' => 1,
            ));
            $topId = $db->lastInsertId();

            // Insert main
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'main',
                'page_id' => $pageId,
                'order' => 2,
            ));
            $mainId = $db->lastInsertId();

            // Insert top-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $topId,
            ));
            $topMiddleId = $db->lastInsertId();

            // Insert main-middle
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'middle',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 2,
            ));
            $mainMiddleId = $db->lastInsertId();

            // Insert main-right
            $db->insert('engine4_core_content', array(
                'type' => 'container',
                'name' => 'right',
                'page_id' => $pageId,
                'parent_content_id' => $mainId,
                'order' => 1,
            ));
            $mainRightId = $db->lastInsertId();

            // Insert menu
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.browse-menu',
                'page_id' => $pageId,
                'parent_content_id' => $topMiddleId,
                'order' => 1,
            ));

            // Insert content
            $db->insert('engine4_core_content', array(
                'type' => 'widget',
                'name' => 'siteqa.tagcloud-siteqas',
                'page_id' => $pageId,
                'parent_content_id' => $mainMiddleId,
                'order' => 2,
            ));
        }
    }
}
?>
