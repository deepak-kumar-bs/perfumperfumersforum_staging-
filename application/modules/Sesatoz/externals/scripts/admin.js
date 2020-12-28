
sesJqueryObject(document).ready(function(e){
  sesJqueryObject('#name').removeAttr('onChange');
  sesJqueryObject('#name').change(function(e){
    var value = sesJqueryObject(this).val();
    if(value == "sesbasic_mini"){
      window.location.href = "admin/sesatoz/menu";
    }else{
       sesJqueryObject(this).parent().submit(); 
    }
  })
});