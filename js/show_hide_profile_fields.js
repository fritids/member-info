jQuery(document).ready(function () {

	//alert(mi_options.required + '\n' + mi_options.extra_fields);

	var show = mi_options.show_defaults.split('~');
	
	var required = mi_options.required.split('~');
	
	var extra_fields = mi_options.extra_fields.split(',');
	
	//var types = mi_options.types.split(',');
	
	var personal_options = 4;
	
	var name = 5;
	
	var contact_info = 10;
	
	var about_yourself = 2;
	
	//jQuery('table.form-table:not(:last-child)').remove();
	
	jQuery('form#your-profile').find('.form-table:not(:last)').remove();
	
	jQuery('form#your-profile h3').remove();
	
	jQuery.each(required, function(index, value) { 
			
		jQuery.each(extra_fields, function(index1, value1) { 
			if(value1 != ''){
				var val = value1.toLowerCase().replace(/ /g,"_").replace(/[^a-zA-Z 0-9 _ ?]+/g, '');
				
				if('custom_field_' + val == value){
					//alert(val + ' - ' + value);
					jQuery('#custom_field_' + value1.toLowerCase().replace(/ /g,"_").replace(/[^a-zA-Z 0-9 _]+/g, '') + ', .custom_field_' + value1.toLowerCase().replace(/ /g,"_").replace(/[^a-zA-Z 0-9 _]+/g, '') + ':first').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
				}	
			}		
		});
	  
	 	switch (value) {
	 	
			case 'visual_editor':
				jQuery('#rich_editing').parent().addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'keyboard_shortcuts':
				jQuery('#comment_shortcuts').parent().addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;			
				 	
			case 'admin_color_scheme':
				jQuery('#admin_color_classic').parent().parent().addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'show_admin_bar':
				jQuery('#admin_bar_front').parent().parent().addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'username':
				jQuery('#user_login').addClass('required').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'first_name':
				jQuery('#first_name').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'last_name':
				jQuery('#last_name').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'display_name_publicly':
				jQuery('#display_name').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'website':
				jQuery('#url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'aim':
				jQuery('#aim').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'yahoo_im':
				jQuery('#yim').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'jabber_google_talk':
				jQuery('#jabber').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'twitter':
				jQuery('#twitter_url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'facebook':
				jQuery('#facebook_url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'youtube':
				jQuery('#youtube_url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'linkedin':
				jQuery('#linkedin_url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'sound_cloud':
				jQuery('#soundcloud_url').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'biographical_info':
				jQuery('#description').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
			
			case 'password':
				jQuery('#pass1').addClass('required').parent().parent().find('th label').append('<span class="description">  (required)</span>');
			break;
		
		}
	  
	});
	
	if(personal_options == 0){
		jQuery("h3:contains('Personal Options') + table, h3:contains('Personal Options')").remove();
	}
	
	if(name == 0){
		jQuery("h3:contains('Name') + table, h3:contains('Name')").hide();
	}
	
	if(contact_info == 0){
		jQuery("h3:contains('Contact Info') + table, h3:contains('Contact Info')").remove();
	}
	
	if(about_yourself == 0){
		jQuery("h3:contains('About Yourself') + table, h3:contains('About Yourself')").remove();
	}			
	

});