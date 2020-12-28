<?php return array (
  'package' => 
  array (
    'type' => 'module',
    'name' => 'recipefield',
    'version' => '4.10.4',
    'path' => 'application/modules/Recipefield',
    'title' => 'Recipefield',
    'description' => 'new recipe field element will get added.',
    'author' => '',
    'callback' =>
        array(
            'path' => 'application/modules/Recipefield/settings/install.php',
            'class' => 'Recipefield_Installer',
            'priority' => 2000,
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
      'application/modules/Recipefield'
    ),
    'files' => 
    array (
      'application/libraries/Engine/View/Helper/FormRecipe.php',
      'application/modules/Fields/Form/Admin/Field/Recipe.php',
      'application/modules/Fields/Form/Element/Recipe.php',
      'application/modules/Fields/Model/Meta.php',
      'application/modules/Fields/View/Helper/FieldRecipe.php',
      'application/modules/Fields/settings/fields.php',
      'application/modules/Sitereview/Form/Custom/Standard.php',
      'application/modules/Fields/Api/Core.php',
      'application/modules/Sitereview/controllers/AdminFieldsController.php',
      'application/modules/Fields/views/helpers/AdminFieldMeta.php',
      'application/modules/Sitereview/Model/DbTable/Listingtypes.php',
      'application/modules/Sitereview/Model/DbTable/Listings.php',
      'application/modules/Sitereview/controllers/IndexController.php',
      'application/modules/Sitereview/views/scripts/admin-fields/index.tpl',
      'application/modules/Sitereviewlistingtype/Form/Admin/Listingtypes/Create.php',
      'application/modules/Sitereview/Model/DbTable/Recipeinfo.php',
      'application/modules/Sitereview/Model/Recipeinfo.php'
    ),
  ),
); ?>