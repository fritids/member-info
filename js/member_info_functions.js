jQuery(document).ready(function () {
	
	show_hide_map_sizes();
	
	var fixHelper = function(e, ui) {
	    ui.children().each(function() {
	        jQuery(this).width(jQuery(this).width());
	    });
	    return ui;
	};
	
	if(jQuery('#mi_fields tbody').length > 0){
		jQuery("#mi_fields tbody").sortable({
		    helper: fixHelper,
		    handle: '.handle'
		});
	}
	
    jQuery("#edituser").submit(function() {
      	if(check_required() == true){
      		return true;
      	}else{
      		return false;
      	}
    });	
    
    jQuery( ".dob" ).datepicker({
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd/mm/yy',
		yearRange: '-80'
	});
	
});

function show_hide_map_sizes(){

	if(jQuery('#mi_show_map').val() == 'true'){
		jQuery('#mi_map_sizes').show();
	}else{
		jQuery('#mi_map_sizes').hide();
	}

}

function type_select_change(val, row){
	if(val == 'image'){
		remove_image_limit(row);
		add_image_limit(row);
		remove_document_limit(row);
		remove_document_type(row);
		add_empty_document_limit(row);
		add_empty_document_type(row);
		remove_custom_select(row);
		add_empty_custom_select(row);
		remove_custom_checkbox(row);
		add_empty_custom_checkbox(row);			
	}else if(val == 'document'){
		remove_image_limit(row);
		add_empty_image_limit(row);	
		remove_document_limit(row);
		remove_document_type(row);
		add_document_limit(row);
		add_document_type(row);
		remove_custom_select(row);
		add_empty_custom_select(row);
		remove_custom_checkbox(row);
		add_empty_custom_checkbox(row);			
	}else if(val == 'custom_select'){
		remove_image_limit(row);
		add_empty_image_limit(row);
		remove_document_limit(row);
		remove_document_type(row);
		add_empty_document_limit(row);
		add_empty_document_type(row);
		remove_custom_select(row);
		add_add_option_button(row);
		add_custom_select(row);
		remove_custom_checkbox(row);
		add_empty_custom_checkbox(row);			
	}else if(val == 'custom_checkbox'){
		remove_image_limit(row);
		add_empty_image_limit(row);
		remove_document_limit(row);
		remove_document_type(row);
		add_empty_document_limit(row);
		add_empty_document_type(row);
		remove_custom_select(row);
		add_empty_custom_select(row);
		remove_custom_checkbox(row);
		add_add_checkbox_button(row);
		add_custom_checkbox(row);		
	}else{
		remove_image_limit(row);
		add_empty_image_limit(row);
		remove_document_limit(row);
		remove_document_type(row);
		add_empty_document_limit(row);
		add_empty_document_type(row);
		remove_custom_select(row);
		add_empty_custom_select(row);
		remove_custom_checkbox(row);
		add_empty_custom_checkbox(row);		
	}
}

function remove_image_limit(row){
	jQuery('#' + row + ' .image_limit').remove();
}

function add_image_limit(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="image_limit"><br>Limit number of images to: <input type="text" size="3" name="mi_fields_image_limit[]" /></span>\
	');
}

function add_empty_image_limit(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="image_limit"><input type="hidden" name="mi_fields_image_limit[]" value="0" /></span>\
	');
}

function remove_document_limit(row){
	jQuery('#' + row + ' .document_limit').remove();
}

function remove_document_type(row){
	jQuery('#' + row + ' .document_type').remove();
}

function add_document_limit(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="document_limit"><br>Limit number of documents to: <input type="text" size="3" name="mi_fields_document_limit[]" /></span>\
	');
}

function add_document_type(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="document_type"><br>Limit type of documents to (separate with a comma with no fullstops. e.g. doc,pdf,docx ): <input type="text" size="3" name="mi_fields_document_type[]" /></span>\
	');
}

function add_empty_document_limit(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="document_limit"><input type="hidden" name="mi_fields_document_limit[]" value="0" /></span>\
	');
}

function add_empty_document_type(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="document_type"><input type="hidden" name="mi_fields_document_type[]" value="0" /></span>\
	');
}

// <!-- Custom select

function remove_custom_select(row){
	jQuery('#' + row + ' .custom_select').remove();
	jQuery('#' + row + ' .select_option_identifier').remove();
	jQuery('#' + row + ' .add_option_button').remove();
}

function add_empty_custom_select(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="custom_select"><input type="hidden" name="mi_custom_select_option[]" value="0" /></span>\
	');
}

function add_custom_select(row){

	var epoch_class = new Date().getTime();

	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="custom_select ' + epoch_class + '"><br>Option Name: <input type="text" size="10" name="custom_select_option_' + jQuery('#' + row + ' .select_option_identifier').val() + '[]" /> <a style="cursor:pointer;" onClick="jQuery(\'.' + epoch_class + '\').remove()"><img alt="Delete this option" src="' + settings.MI_url + '/img/delete.png"  style="cursor: pointer; margin-left: 20px;"/></a> </span>\
	');

}

function add_add_option_button(row){

	var epoch_time = new Date().getTime();

	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="add_option_button"><br><a style="cursor:pointer;" onClick="add_custom_select(\'' + row + '\')"><img src="' + settings.MI_url + '/img/plus.png" width="12" height="12"/>Add an option.</a><br>(Hint: Type "Other" as an option name and if selected a new text box will appear for the user to type an alternative option.)</span>\
		<input type="hidden" name="mi_custom_select_option[]" value="' + epoch_time + '" class="select_option_identifier"/>\
	');

}

// --> Custom select

// <!-- Custom Checkboxes

function remove_custom_checkbox(row){
	jQuery('#' + row + ' .custom_checkbox').remove();
	jQuery('#' + row + ' .checkbox_checkbox_identifier').remove();
	jQuery('#' + row + ' .add_checkbox_button').remove();
}

function add_empty_custom_checkbox(row){
	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="custom_checkbox"><input type="hidden" name="mi_custom_checkbox_checkboxes[]" value="0" /></span>\
	');
}

function add_custom_checkbox(row){

	var epoch_class = new Date().getTime();

	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="custom_checkbox ' + epoch_class + '"><br>Checkbox Name: <input type="text" size="10" name="custom_checkbox_checkboxes_' + jQuery('#' + row + ' .checkbox_checkbox_identifier').val() + '[]" /> <a style="cursor:pointer;" onClick="jQuery(\'.' + epoch_class + '\').remove()"><img alt="Delete this checkbox" src="' + settings.MI_url + '/img/delete.png"  style="cursor: pointer; margin-left: 20px;"/></a> </span>\
	');

}

function add_add_checkbox_button(row){

	var epoch_time = new Date().getTime();

	jQuery('#' + row + ' .select_type').parent().append('\
		<span class="add_checkbox_button"><br><a style="cursor:pointer;" onClick="add_custom_checkbox(\'' + row + '\')"><img src="' + settings.MI_url + '/img/plus.png" width="12" height="12"/>Add a checkbox.</a></span>\
		<input type="hidden" name="mi_custom_checkbox_checkboxes[]" value="' + epoch_time + '" class="checkbox_checkbox_identifier"/>\
	');

}

// --> Custom Checkboxes

function fillEmptyFields(){
	
	jQuery('input[name="mi_fields_desc[]"]').each(function(index) {
    	if(jQuery(this).val() == '' ){
    		jQuery(this).val(' ')
    	};
  	});	
	
}

function submitSettings(){

	fillEmptyFields();

}

function updateProfile(){

	check_required();

}

function check_required(){

	jQuery('#error_message').html('')

	var submit = true;

	jQuery( '.required').each(function() {
	
		if(jQuery(this).val() == '' ){
			jQuery(this).parent().parent().css('border', '1px solid red');
			jQuery('#error_message').css('border', '1px solid red').css('padding', '10px').css('line-height', '30px').html(jQuery('#error_message').html() + '<strong><a href="#custom_field_'+ jQuery(this).attr('name').toLowerCase().replace(" ","_") +'">' + jQuery(this).parent().parent().find('th label').text().replace("  (required)"," is required.</a></strong><br>"));
			submit = false;
		}
	
	});
	
	return submit;

}

function deleteImage(img){
	
	var replace = jQuery('input[title="'+img+'"]').val();

	var value = jQuery('img[src="' + img + '"]').parent().parent().parent().find('#upload_image');

	value.val(value.val().replace(img + '~', '').replace( '~' + img, '').replace( img, ''));

	jQuery('img[src="' + img + '"]').parent().html('<div><img class="mi_image" src="' + replace + '" /></div>')

}

function deleteDocument(doc, name){

	var replace = jQuery('input[title="'+doc+'"]').val();

	var value = jQuery('div[title="' + doc + '"]').parent().parent().find('#upload_document');

	value.val(value.val().replace(doc + '=' + name + '~', '').replace( '~' + doc + '=' + name, '').replace( doc + '=' + name, ''));

	jQuery('div[title="' + doc + '"]').html('<img class="mi_document" src="' + replace + '" />').attr('title', '');

}

function check_other(){

	jQuery('.custom_select').each(function(){
	
		if(jQuery(this).val().toLowerCase() == 'other'){
			jQuery(this).parent().append('<input class="input other_option" type="text" name="' + jQuery(this).attr('name') + '" value="" />');
		}else{
			jQuery(this).parent().find('.other_option').remove();
		}	
	
	})

}