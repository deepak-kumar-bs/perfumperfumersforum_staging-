<?php echo $this->htmlLink(array('route' => 'qa_general', 
  'module' => 'siteqa',
   'controller' => 'index',
    'action' => 'create',
	), 
    $this->translate('Create New Question'), array(
  'class' => 'buttonlink icon_qa_delete'
)); ?>
