<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2006-2020 Webligo Developments
 * @license    http://www.socialengine.com/license/
 * @version    $Id: create.tpl 10110 2013-10-31 02:04:11Z andres $
 * @author     Siteqa
 */
?>

<?php
$this->headScript()
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Observer.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Local.js')
->appendFile($this->layout()->staticBaseUrl . 'externals/autocompleter/Autocompleter.Request.js')
->appendFile($this->layout()->staticBaseUrl.'application/modules/Siteqa/externals/scripts/categories.js');
?>

<script type="text/javascript">
  en4.core.runonce.add(function()
  {
    new Autocompleter.Request.JSON('tags', '<?php echo $this->url(array('controller' => 'tag', 'action' => 'suggest'), 'default', true) ?>', {
      'postVar' : 'text',
      'customChoices' : true,
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

<?php if (($this->current_count >= $this->quota) && !empty($this->quota)):?>
<div class="tip">
  <span>
    <?php echo $this->translate('You have already uploaded the maximum number of entries allowed.');?>
    <?php echo $this->translate('If you would like to upload a new entry, please <a href="%1$s">delete</a> an old one first.', $this->url(array('action' => 'manage'), 'qa_general'));?>
  </span>
</div>
<br/>
<?php else:?>
  <?php echo $this->form->render($this);?>
<?php endif; ?>




<script type="text/javascript">
  $$('.core_main_course').getParent().addClass('active');
</script>
