<?php

new media_upload_edit;

class media_upload_edit{

	function media_upload_edit(){
		$this->__construct();
	}
	
	function __construct(){ 
<<<<<<< HEAD
		add_action( 'media_upload_tabs', array( &$this, 'edit_tabs' ) );
		add_filter( 'attachment_fields_to_edit', array( &$this, 'attachment_fields_to_edit' ), 1, 2 );
=======
	
		global $pagenow;

		$referer = $_SERVER['HTTP_REFERER'];
		$queries = explode('&', $referer);
		
		foreach($queries as $query){
			$q = explode('=', $query);
			if($q[0] == 'member_info_type'){
				add_filter( 'attachment_fields_to_edit', array( &$this, 'attachment_fields_to_edit' ), 1, 2 );
				break;
			}
		}
		add_action( 'media_upload_tabs', array( &$this, 'edit_tabs' ) );
>>>>>>> Media Uploader now works.

	}	//function
	
	function edit_tabs($tabs){
	
<<<<<<< HEAD
		if($_GET['member_info_type'] == 'image'){	
=======
		if($_GET['member_info_type'] == 'image' || $_GET['member_info_type'] == 'document'){	
>>>>>>> Media Uploader now works.
	
			$tabs = array('');
		
		}
		
		return $tabs;
		
	} // function
	
	function attachment_fields_to_edit($form_fields, $post){
<<<<<<< HEAD
	
		//if($_GET['member_info_type'] == 'image'){
=======
>>>>>>> Media Uploader now works.
		
			echo 	'<script type="text/javascript">
						jQuery(\'.savebutton, #media-upload-header, .howto, .post_title, .image_alt, .post_excerpt, .post_content, .url, .align, .image-size\').hide();
						jQuery(\'.savebutton\').remove();
					</script>';	


	        $form_fields['buttons'] = array(
	            'label' => '', 
	            'value' => '',
<<<<<<< HEAD
	            'html' => "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add image to product' ) . "' />",
=======
	            'html' => "<input type='submit' class='button' name='send[$post->ID]' value='" . esc_attr__( 'Add to profile' ) . "' />",
>>>>>>> Media Uploader now works.
	            'input' => 'html'
	        );

			return $form_fields;
<<<<<<< HEAD
    
    	//}
	
	} // function	
=======
	
	} // function		
>>>>>>> Media Uploader now works.

}

?>