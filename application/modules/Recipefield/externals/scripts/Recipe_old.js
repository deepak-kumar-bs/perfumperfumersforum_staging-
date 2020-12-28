
function initializeRecipeField(values) {

    var field_id = 0;
    var input_el_id = '';

    if(values['field_id']) {
        field_id = values['field_id'];
        input_el_id = values['field_name']+'_name';
        values = [];
    }

	// adding option to add 
	var messageEl = document.createElement('div')
    var inHtml = '<a href = "'+'javascript:void(0)'+'" onclick = "'+'duplicateRecipeFields('+0+','+field_id+','+"'"+input_el_id+"'"+')'+'">+ Add another Ingredient</a>'; 

    var counterElement = document.createElement('span');
    counterElement.innerText = 0;
    counterElement.className = 'counter_element';
    counterElement.setAttribute("style", "display: none;");

    var template = document.createElement('template');
    html = inHtml.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;

    messageEl.appendChild(template.content.firstChild);
    messageEl.className = "add_new_material";

    // var recipeContainer = document.querySelector('.form-recipe-wrapper');
	// var recipeLabel = recipeContainer.querySelector('.form-label');

    if(!field_id && values) {
        var fields_ids = values[0]['field_name'].split("_");
        field_id = fields_ids[2];
        input_el_id = values[0]['field_name']+'_name';
    }

    // append 'add new material' element
    var label_id = input_el_id.replace('_name', "-label");
    $(label_id).appendChild(messageEl);
    $(label_id).appendChild(counterElement);

    attachAutoSuggest(input_el_id, field_id);

    if(values) {
        values.forEach(function(data) {
           duplicateRecipeFields(data); 
        });  
    }
}

function duplicateRecipeFields(values, id = 0,el_id = '') {

    if(el_id) {
        var form_el_id = el_id.replace('_name', "-wrapper");
        var label_id = el_id.replace('_name', "-label");
    } else {
        var form_el_id = values['field_name']+'-wrapper';
        var label_id = values['field_name']+'-label';
    }
   

    var labelContainer = $(label_id);
    var counterElement = labelContainer.querySelector('.counter_element');

	// adding counter to distinguish between element
	var counter = Number(counterElement.innerText)+1;
	counterElement.innerText = counter;
    
    // duplicating element

	var recipeContainer = $(form_el_id);
    var select2_id = '#'+el_id+'_'+counterElement.innerText;

    jQuery.noConflict();
    jQuery(select2_id).select2('destroy');

	var recipElement = recipeContainer.querySelector('.form-element').cloneNode( true );
    jQuery(select2_id).select2();
    var inputElements = recipElement.querySelectorAll('.field_container');
    

    var i = 0;
    var element_id = '';
    var field_id = id;
    
    if(values) {

        field_id = values['field_name'].split("_")[2];
        delete values["field_name"];
        inputElements.forEach(function(el) {

            el.id = el.id+'_'+counter;

            if(el.id.includes('name')) {
                element_id = el.id;
                el.value = values['name'];
            }
            if(el.id.includes('amount')) {
                el.value = values['amount'];
            }
            if(el.id.includes('dilution')) {
                el.value = values['dilution'];
            }
            
        });
    } else {
        inputElements.forEach(function(el) {
            el.id = el.id+'_'+counter;
            if(el.id.includes('name')) {
              element_id = el.id;
            }
            el.value = '';
        });
    }

	// adding removing button
	var removeEl = document.createElement('div')
    var removeHtml = '<button type = "'+'button'+'" onclick = "'+'removeRecipeFields('+"'"+recipElement.id+"'"+')'+'" class = "'+'remove_button'+'"></button>'; 

    var template = document.createElement('template');
    html = removeHtml.trim(); // Never return a text node of whitespace as the result
    template.innerHTML = html;

	recipElement.appendChild(template.content.firstChild); // add remove button
	recipeContainer.appendChild(recipElement);

    attachAutoSuggest(element_id, field_id);

}

function removeRecipeFields(id) {
	$(id).destroy(); // remove the element
}

function attachAutoSuggest(element_id, field_id) {

        var el = '#'+element_id;

        // console.log(el);
        jQuery.noConflict();
        jQuery('.input_element_select2').select2({
            placeholder: "Select the ingredient.",
        });
}
