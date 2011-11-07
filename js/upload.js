jQuery(document).ready(function() {

	jQuery('#mi_upload_image_button').each(function(){
	
	jQuery(this).click(function() {
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			
			if(jQuery('#upload_image').val() == ''){
				jQuery('#upload_image').val(imgurl);
			}else{
				jQuery('#upload_image').val(jQuery('#upload_image').val() + '~' + imgurl);
			}
			
			jQuery('#mi_images .mi_image:first').parent().append('<div><img class="mi_uploaded_img" src="' + imgurl + '" /><br><img style="cursor:pointer;" onClick="deleteImage(\'' +imgurl + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_image" /></div>');
 			jQuery('.mi_image:first').remove();
			tb_remove(); 
		}
		var current_images  = jQuery('#upload_image').val();
		var images_array = current_images.split('~');
		var i = 1;
		jQuery.each(images_array, function() { 
			i++;
		});		
		var image_limit = jQuery('#image_limit').val();
		if(i <= image_limit){
			tb_show('', MI.WPURL + 'media-upload.php?type=image&member_info_type=image&TB_iframe=true');
		}else{
			alert('You can not add any more images.');
		}
		return false;
	});
	
	});
	
	jQuery('#mi_upload_document_button').click(function() {
		window.send_to_editor = function(html) {
			docurl = jQuery(html).attr('href');
			docname = jQuery(html).html();

			if(jQuery('#upload_document').val() == ''){
				jQuery('#upload_document').val(docurl + '=' + docname);
			}else{
				jQuery('#upload_document').val(jQuery('#upload_document').val() + '~' + docurl + '=' + docname);
			}
			jQuery('#mi_documents .single_row:first').parent().append('<div class="single_row"><div class="mi_uploaded_doc" >' + docname + '</div><img style="cursor:pointer;" onClick="deleteDocument(\'' +docurl + '\', \'' + docname + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_document" /></div>');
 			jQuery('.mi_document:first').remove();

			tb_remove(); 
		}
	 
		var current_documents  = jQuery('#upload_document').val();
		var documents_array = current_documents.split('~');
		var i = 1;
		if(current_documents != ''){
			jQuery.each(documents_array, function() { 
				i++;
			});
		}
		var document_limit = jQuery('#document_limit').val();
		if(i <= document_limit){	 
			doc_types = jQuery(this).attr('rel');
			tb_show('', MI.WPURL + 'media-upload.php?type=image&member_info_type=image&file_types=' + doc_types + '&TB_iframe=true');	
		}else{
			alert('You can not add any more documents.');
		}		
		return false;
	});	
 
	tb_position();

});