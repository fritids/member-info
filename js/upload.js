jQuery(document).ready(function() {

	jQuery('#mi_upload_image_button').click(function() {
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			var current_images  = jQuery('#upload_image').val();
			var images_array = current_images.split('~');
			var i = 0;
			jQuery.each(images_array, function() { 
				i++;
			});
			var image_limit = jQuery('#image_limit').val();
			if(i <= image_limit){
				if(jQuery('#upload_image').val() == ''){
					jQuery('#upload_image').val(imgurl);
				}else{
					jQuery('#upload_image').val(jQuery('#upload_image').val() + '~' + imgurl);
				}
				jQuery('#mi_images .mi_image:first').parent().append('<div><img class="mi_uploaded_img" src="' + imgurl + '" /><br><img style="cursor:pointer;" onClick="deleteImage(\'' +imgurl + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_image" /></div>');
	 			jQuery('.mi_image:first').remove();
			}else{
				alert('You can not add any more images.');
			}
			tb_remove(); 
		}
	 
		tb_show('', MI.WPURL + 'media-upload.php?type=image&amp;TB_iframe=true');
		return false;
	});
	
	jQuery('#mi_upload_document_button').click(function() {
		window.send_to_editor = function(html) {
			docurl = jQuery(html).attr('href');
			docname = jQuery(html).html();
			var current_documents  = jQuery('#upload_document').val();
			var documents_array = current_documents.split('~');
			var i = 0;
			jQuery.each(documents_array, function() { 
				i++;
			});
			var document_limit = jQuery('#document_limit').val();
			if(i <= document_limit){
				if(jQuery('#upload_document').val() == ''){
					jQuery('#upload_document').val(docurl + '=' + docname);
				}else{
					jQuery('#upload_document').val(jQuery('#upload_document').val() + '~' + docurl + '=' + docname);
				}
				jQuery('#mi_documents .single_row:first').parent().append('<div class="single_row"><div class="mi_uploaded_doc" >' + docname + '</div><img style="cursor:pointer;" onClick="deleteDocument(\'' +docurl + '\', \'' + docname + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_document" /></div>');
	 			jQuery('.mi_document:first').remove();
			}else{
				alert('You can not add any more documents.');
			}
			tb_remove(); 
		}
	 
		tb_show('', MI.WPURL + 'media-upload.php?TB_iframe=true');
		return false;
	});	
 
	tb_position();

});