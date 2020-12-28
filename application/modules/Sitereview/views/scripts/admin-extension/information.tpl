<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitereview
 * @copyright  Copyright 2013-2014 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: information.tpl 2014-05-19 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>

<h2>
  <?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitereviewlistingtype')) { echo 'Reviews & Ratings - Multiple Listing Types Plugin'; } else { echo 'Reviews & Ratings Plugin'; }?>
</h2>

<?php if (count($this->navigation)): ?>
  <div class='seaocore_admin_tabs clr'>
    <?php echo $this->navigation()->menu()->setContainer($this->navigation)->render() ?>
  </div>
<?php endif; ?>

<h3><?php if (Engine_Api::_()->getDbtable('modules', 'core')->isModuleEnabled('sitereviewlistingtype')) { echo 'Reviews & Ratings - Multiple Listing Types Plugin'; } else { echo 'Reviews & Ratings Plugin'; }?><?php echo ' Extensions Information'?></h3>
<div class='tabs'>
  <ul class="navigation">
    <li >
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sitereview', 'controller' => 'extension', 'action' => 'upgrade'), $this->translate('Extension Upgrade'), array()) ?>
    </li>
    <li class="active">
      <?php echo $this->htmlLink(array('route' => 'admin_default', 'module' => 'sitereview', 'controller' => 'extension', 'action' => 'information'), $this->translate('Extension Information'), array()) ?>
    </li>
  </ul>
</div>
<div class='clear sitereview_settings_form'>
  <div class='settings'>
    <?php //echo $this->form->render($this) ?>
  </div>
</div>

<?php echo $this->content()->renderWidget('sitereview.extension-information') ?>