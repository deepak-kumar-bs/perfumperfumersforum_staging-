
<div id='core_search_widget'>
  <?php if($this->search_check):?>
    <div id="searchform" class="global_form_box">
      <?php echo $this->form->setAttrib('class', '')->render($this) ?>
    </div>
  </div>
<br/>
<br />
<?php endif;?>


<script type="text/javascript">



function addOptionInSearch() {
  type = $('searchform').getElementById('type').value;
  
  (new Request.JSON({
    'format': 'json',
    'url' : '<?php echo $this->url(array('module' => 'seaocore', 'controller' => 'search', 'action' => 'valid-order'), 'default', true) ?>',
    'data' : {
      'type' : type,
    },  
    onSuccess: function(responseJSON, responseText) {

      $('searchform').getElementById('order').innerHTML = "";

      var most_recent = document.createElement("option");
      most_recent.text = "Most Recent";
      most_recent.value = '';
      $('searchform').getElementById('order').add(most_recent);

      if(responseJSON.like_count == "true"){
        var like_count = document.createElement("option");
        like_count.text = "Most Liked";
        like_count.value = "like_count";
        $('searchform').getElementById('order').add(like_count);
      }
      if(responseJSON.view_count == "true"){
        var view_count = document.createElement("option");
        view_count.text = "Most Viewed";
        view_count.value = "view_count";
        $('searchform').getElementById('order').add(view_count)
      }
          
    }     
  })).send();
}

en4.core.runonce.add(function() {
	addOptionInSearch();

	$('searchform').getElementById('type').addEvent('change',function(){

	  addOptionInSearch();
	});
});

</script>

