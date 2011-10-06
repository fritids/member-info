<?php

new media_upload_edit;

class media_upload_edit{

	function media_upload_edit(){
		$this->__construct();
	}
	
	function __construct(){ 
		add_action( 'media_upload_tabs', array( &$this, 'edit_tabs' ) );
		add_filter( 'attachment_fields_to_edit', array( &$this, 'attachment_fields_to_edit' ), 1, 2 );

	}	//function
	
	function edit_tabs($tabs){
	
		if($_GET['member_info_type'] == 'image'){	
	
			$tabs = array('');
		
		}
		
		return $tabs;
		
	} // function
	
	function attachment_fields_to_edit($form_fields, $post){
	
		//if($_GET['member_info_type'] == 'image'){
		
			echo 	'<script type="text/javascript">
						jQuery(\'.savebutton, #media-upload-header, .howto, .post_title, .image_alt, .post_excerpt, .post_content, .url, .align, .image-size\').hide();
						jQuery(\'.savebutton\').remove();
					</script>';	


	        $form_fields['buttons'] = array(
	            'label' => '', 
	            'value' => '',
	            'html' => "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add image to product' ) . "' />",
	            'input' => 'html'
	        );

			return $form_fields;
    
    	//}
	
	} // function	

}

?>