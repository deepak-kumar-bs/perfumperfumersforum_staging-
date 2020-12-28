<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'siteqa',
    'version' => '5.2.1',
    'path' => 'application/modules/Siteqa',
    'title' => 'Professional Questions and Answers Plugin',
    'description' => 'Professional Questions and Answers Plugin',
    'author' => 'SocialApps.tech',
    'callback' => array(
      'path' => 'application/modules/Siteqa/settings/install.php',
      'class' => 'Siteqa_Installer',
    ),
    'actions' => 
    array (
      0 => 'install',
      1 => 'upgrade',
      2 => 'refresh',
      3 => 'enable',
      4 => 'disable',
    ),
    'directories' => 
    array (
      0 => 'application/modules/Siteqa',
    ),
    'files' => 
    array (
      0 => 'application/languages/en/siteqa.csv',
    ),
  ),
  // Hooks 
  'hooks' => array( 
    array(
      'event' => 'onItemDeleteBefore',
      'resource' => 'Siteqa_Plugin_Core'
    ),
    array(
      'event' => 'onUserDeleteBefore',
      'resource' => 'Siteqa_Plugin_Core',
    ),
  ),
  // Items 
  'items' => array(
    'question',
    'siteqa_category',
    'siteqa_question',
    'siteqa_answer',
    'siteqa_itemofthedays',
    'siteqa_votes',
  ),
  // Routes 
  'routes' => array(
    'qa_specific' => array(
      'route' => 'questions/:action/:question_id/*',
      'defaults' => array(
        'module' => 'siteqa',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'question_id' => '\d+',
        'action' => '(delete|edit)',
      ),
    ),
    'ans_specific' => array(
      'route' => 'questions/:action/:answer_id/*',
      'defaults' => array(
        'module' => 'siteqa',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'answer_id' => '\d+',
        'action' => '(answerdelete|answeredit)',
      ),
    ),
    'qa_entry_view' => array(
        'route' => 'question/:question_id/*',
        'defaults' => array(
            'module' => 'siteqa',
            'controller' => 'index',
            'action' => 'view',
        ),
    ),
    'ans_entry_view' => array(
        'route' => 'answer/*',
        'defaults' => array(
            'module' => 'siteqa',
            'controller' => 'index',
            'action' => 'answerview',
        ),
    ),

    'qa_general' => array(
      'route' => 'questions/:action/*',
      'defaults' => array(
        'module' => 'siteqa',
        'controller' => 'index',
        'action' => 'index',
      ),
      'reqs' => array(
        'action' => '(index|answer|tagscloud|create|manage|style|tag|upload-photo|browse)',
      ),
    ),
    'qa_view' => array(
      'route' => 'questions/:user_id/*',
      'defaults' => array(
        'module' => 'siteqa',
        'controller' => 'index',
        'action' => 'list',
      ),
      'reqs' => array(
        'user_id' => '\d+',
      ),
    ),
    'vote_view' => array(
      'route' => 'questions/:id/:type/*',
      'defaults' => array(
        'module' => 'siteqa',
        'controller' => 'index',
        'action' => 'votecheck',
      ),
      'reqs' => array(
        'id' => '\d+',
        'type' => '(siteqa_que|siteqa_ans)',
      ),
    ),
    'siteqa_category' => array(
            'route' => 'qa/category/:action/*',
            'defaults' => array(
                'module' => 'siteqa',
                'controller' => 'index',
                'action' => 'sub-category',
            ),
            'reqs' => array(
                'action' => '(sub-category|subsub-category)',
            ),
        ),
  ),
); ?>