<?php

new member_info_roles_capabilities;

class member_info_roles_capabilities {

	function member_info_roles_capabilities(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
			
		if ( is_admin() )
		add_action( 'pre_get_posts', array( &$this, 'hide_uploads_from_other_users' ) );

		//remove_role('basic_member');
		add_role('basic_member', 'Basic Member', array(
		    'read' => true, 
		    'edit_posts' => false,
		    'delete_posts' => true,
		    'upload_files' => true,
		    'edit_posts' => true,
		    'access_backend' => false
		));	
		
		update_option( 'default_role', 'basic_member' ); //update default role to be a basic member
	
	}

	function hide_uploads_from_other_users( $wp_query_obj ) {
    global $current_user, $pagenow;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( 'upload.php' != $pagenow && 'media-upload.php' != $pagenow  )
        return;

    //if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->id );

    return;

	}	
	
}

?>