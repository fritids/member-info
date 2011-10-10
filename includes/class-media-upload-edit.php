<?php

new media_upload_edit;

class media_upload_edit{

	function media_upload_edit(){
		$this->__construct();
	}
	
	function __construct(){ 
	
		global $pagenow;

		$referer = $_SERVER['HTTP_REFERER'];
		$queries = explode('&', $referer);

		foreach($queries as $query){
			$q = explode('=', $query);
			if($q[0] == 'member_info_type'){
				add_filter( 'attachment_fields_to_edit', array( &$this, 'attachment_fields_to_edit' ), 1, 2 );
			}
			
			if($_GET['file_types'] != '' ){
				//echo 'here ' . $_GET['file_types'];
			}
		}
				
		add_action( 'media_upload_tabs', array( &$this, 'edit_tabs' ) );

	}	//function
	
	function edit_tabs($tabs){
	
		if($_GET['member_info_type'] == 'image' || $_GET['member_info_type'] == 'document'){	
	
			$tabs = array('');
		
		}
		
		return $tabs;
		
	} // function
	
	function attachment_fields_to_edit($form_fields, $post){
	
			$mime_type = explode('/',$post->post_mime_type);
			
			$file_type = $mime_type[1];
			 
			$referer = $_SERVER['HTTP_REFERER'];
			$queries = explode('&', $referer);
			
			$allowed_types = array();
	
			foreach($queries as $query){
				$q = explode('=', $query);
				if($q[0] == 'file_types'){
					$types = explode(',', $q[1]);
					$types_list = $q[1];
					foreach($types as $type){
						$allowed_types[] = strtolower( $type );
					}
					
				}

			}			 
			 
			 if(!in_array(strtolower( $file_type ), $allowed_types)){
			 
			 
			 	echo 	'<script type="text/javascript">
			 				jQuery(\'.buttons\').remove();
			 				jQuery(\'#media-head-' . $post->ID . '\').parent().parent().html(\'<div class="error" style="margin:0;"><strong>Upload of ' . $post->post_title . ' failed-</strong><br><br>You can not upload this file type. Please upload one of the following-<br><br><em>' . $types_list . '</em></div>\');
			 			</script>';
			 			
			 	wp_delete_post( $post->ID, true );
			 
			 }
		
			echo 	'<script type="text/javascript">
						jQuery(\'.savebutton, #media-upload-header, .howto, .post_title, .image_alt, .post_excerpt, .post_content, .url, .align, .image-size\').hide();
						jQuery(\'.savebutton\').remove();
					</script>';	


	        $form_fields['buttons'] = array(
	            'label' => '', 
	            'value' => '',
	            'html' => "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add to profile' ) . "' />",
	            'input' => 'html'
	        );

			return $form_fields;
	
	} // function		

}

?>