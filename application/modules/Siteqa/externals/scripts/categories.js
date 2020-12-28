/* $Id: categories.js 6590 2012-18-05 00:00:00Z SocialEngineAddOns Copyright 2011-2012 BigStep Technologies Pvt. Ltd. $ */

var field_id;
var subcategories = function(category_id, sub, thisObject)
{ 
	field_id = thisObject;
	if($('buttons-wrapper')) {
		$('buttons-wrapper').style.display = 'none';
	}
	
	$('sub'+field_id+'_backgroundimage').style.display = 'block';
	$('sub'+field_id).style.display = 'none';
	if($('sub'+field_id+'-label'))
		$('sub'+field_id+'-label').style.display = 'none';
		$('sub'+field_id+'_backgroundimage').innerHTML = '<img src="application/modules/Core/externals/images/loading.gif" alt="" />';
	
	var request = new Request.JSON({
		url : siteqa_subcategory_url,
		data : {
			format : 'json', 
			category_id_temp : category_id
		},
		onSuccess : function(responseJSON) {          
			if($('buttons-wrapper')) {
				$('buttons-wrapper').style.display = 'block';
			}
			$('sub'+field_id+'_backgroundimage').style.display = 'none';
			clear('sub'+field_id);
			var  subcatss = responseJSON.subcats;		

			addOption($('sub'+field_id)," ", '0');
			for (i=0; i< subcatss.length; i++) {
				addOption($('sub'+field_id), subcatss[i]['category_name'], subcatss[i]['category_id']);
				$('sub'+field_id).value = sub;
			}
		
			if(category_id == 0) {
				clear('sub'+field_id);
				$('sub'+field_id).style.display = 'none';
				if($('sub'+field_id+'-label'))
					$('sub'+field_id+'-label').style.display = 'none';
			}
		}
	});
	request.send();
};

function clear(ddName)
{ 
	for (var i = (document.getElementById(ddName).options.length-1); i >= 0; i--) 
	{ 
		document.getElementById(ddName).options[ i ]=null; 
	} 
}	

function addOption(selectbox,text,value)
{ 
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;

	if(optn.text != '' && optn.value != '') {
		$('sub'+field_id).style.display = 'block';
		if($('sub'+field_id+'-wrapper'))
			$('sub'+field_id+'-wrapper').style.display = 'block';
		if($('sub'+field_id+'-label'))
			$('sub'+field_id+'-label').style.display = 'block';
		selectbox.options.add(optn);
	} else {
		$('sub'+field_id).style.display = 'none';
		if($('sub'+field_id+'-wrapper'))
			$('sub'+field_id+'-wrapper').style.display = 'none';
		if($('sub'+field_id+'-label'))
			$('sub'+field_id+'-label').style.display = 'none';
		selectbox.options.add(optn);
	}
}

function addSubOption(selectbox,text,value)
{
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	if(optn.text != '' && optn.value != '') {
		selectbox.options.add(optn);
	} else {
		selectbox.options.add(optn);
	}
}