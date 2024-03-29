<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: edit.tpl 10110 2013-10-31 02:04:11Z andres $
 * @author     Jung
 */
?>

<?php
if (APPLICATION_ENV == 'production')
  $this->headScript()
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.min.js')
->appendFile($this->layout()->staticBaseUrl.  'application/modules/Siteqa/externals/scripts/categories.js');
else
  $this->headScript()
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js')
->appendFile($this->layout()->staticBaseUrl.  'application/modules/Siteqa/externals/scripts/categories.js');
?>

<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',

      'minLength': 1,
      'selectMode': 'pick',
      'autocompleteType': 'tag',
      'className': 'tag-autosuggest',
      'filterSubset' : true,
      'multiple' : true,
      'injectChoice': function(token){
        var choice = new Element('li', {'class': 'autocompleter-choices', 'value':token.label, 'id':token.id});
        new Element('div', {'html': this.markQueryValue(token.label),'class': 'autocompleter-choice'}).inject(choice);
        choice.inputValue = token;
        this.addChoiceEvents(choice).inject(this.choices);
        choice.store('autocompleteChoice', token);
      }
    });
  });

  var siteqa_subcategory_url = '<?php echo $this->url(array('action' => 'sub-category'), 'siteqa_category', true);?>';
</script>
<div class="layout_middle">
  <div class="generic_layout_container">
    <div class="headline">
      <h2>
        <?php echo $this->translate('Questions');?>
      </h2>
      <div class="tabs">
        <?php
          // Render the menu
        echo $this->navigation()
        ->menu()
        ->setContainer($this->navigation)
        ->render();
        ?>
      </div>
    </div>
  </div>
</div>
<div class="layout_middle">
  <div class="generic_layout_container">
    <?php echo $this->form->render($this) ?>
  </div>
</div>

<script type="text/javascript">
  $$('.core_main_course').getParent().addClass('active');
</script>
