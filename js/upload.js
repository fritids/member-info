jQuery(document).ready(function() {

	jQuery('.mi_upload_image_button').each(function(e){
	
		jQuery(this).click(function() {
		
			var append = jQuery(this).parent().find('#mi_images');
			
			var value = jQuery(this).parent().find('#upload_image');
			
			var remove = jQuery(this).parent().find('#mi_images div:first');
			
			var image_limit_val = jQuery(this).parent().find('#image_limit');
		
			window.send_to_editor = function(html) {
				imgurl = jQuery('img',html).attr('src');
				
				if(value.val() == ''){
					value.val(imgurl);
				}else{
					value.val(value.val() + '~' + imgurl);
				}
	
				append.append('<div><img class="mi_uploaded_img" src="' + imgurl + '" /><br><img style="cursor:pointer;" onClick="deleteImage(\'' +imgurl + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_image" /></div>');
	 			remove.remove();
				tb_remove(); 
			}
			var i = 0;
			var current_images  = value.val();
			if(current_images != ''){
				var images_array = current_images.split('~');
				jQuery.each(images_array, function() { 
					i++;
				});	
			}	
			var image_limit = image_limit_val.val();
			if(i < image_limit){
				tb_show('', MI.WPURL + 'media-upload.php?type=image&member_info_type=image&height=500&width=700&TB_iframe=true');
			}else{
				alert('You can not add any more images.');
			}
			return false;
		});
	
	});
	
	jQuery('.mi_upload_document_button').each(function(e){
	
		jQuery(this).click(function() {
	
			var append = jQuery(this).parent().find('#mi_documents');
			
			var value = jQuery(this).parent().find('#upload_document');
			
			var remove = jQuery('#mi_documents div:first');
			
			var delete_src = jQuery('#mi_documents div:first img').attr('src');;
			
			var doc_limit_val = jQuery(this).parent().find('#document_limit');
	
			window.send_to_editor = function(html) {
				docurl = jQuery(html).attr('href');
				docname = jQuery(html).html();
	
				if(value.val() == ''){
					value.val(docurl + '=' + docname);
				}else{
					value.val(value.val() + '~' + docurl + '=' + docname);
				}
				append.append('<div class="single_row" title="'+docurl+'"><div class="mi_uploaded_doc" >' + docname + '</div><img style="cursor:pointer;" onClick="deleteDocument(\'' +docurl + '\', \'' + docname + '\');" src="' + MI.MI_url + '/img/delete.png" class="delete_document" /></div><input type="hidden" title="'+docurl+'" value="'+delete_src+'" />');
	 			remove.remove();
	
				tb_remove(); 
			}
		 
		 	var i = 0;
			var current_documents  = value.val();
			if(current_documents != ''){
				var documents_array = current_documents.split('~');
				if(current_documents != ''){
					jQuery.each(documents_array, function() { 
						i++;
					});
				}
			}
			var document_limit = doc_limit_val.val();
			if(i < document_limit){	 
				doc_types = jQuery(this).attr('rel');
				tb_show('', MI.WPURL + 'media-upload.php?type=image&member_info_type=image&file_types=' + doc_types + '&height=500&width=700&TB_iframe=true');	
			}else{
				alert('You can not add any more documents.');
			}		
			return false;
		});	
		
	});
 
});