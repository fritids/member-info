<?php

new member_info_setup;

class member_info_setup {

	private $member_info_inputs = array();

	function member_info_setup(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_action("admin_init", array( &$this, 'js_libs' ));
		
		add_action("admin_print_styles", array( &$this, 'style_libs' ));
		
		add_action("wp_enqueue_scripts", array( &$this, 'js_libs_front_end' ));
		
		add_action("login_enqueue_scripts", array( &$this, 'js_libs_front_end' ));
		
		add_action("wp_print_styles", array( &$this, 'style_libs_front_end' ));
		
		add_action('save_post', array( &$this, 'catch_shortcodes' ));
		
		add_filter('user_contactmethods', array( &$this, 'modify_contactmethods' ));
		
		add_action('admin_notices', array( &$this, 'check_pages_setup' ));
			
	} // function
	
	function js_libs() {
		
		global $pagenow, $typenow;

		if (empty($typenow) && !empty($_GET['post'])) {
			$post = get_post($_GET['post']);
			$typenow = $post->post_type;
		}

  		if (is_admin()) {
    		if ($pagenow=='profile.php' || $pagenow == 'user-edit.php' || $_GET['page'] == 'mi_settings') { 
    			wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('jquery-ui-core', array('jquery'));
				wp_enqueue_script('datepicker', MI_url.'/js/datepicker.js', array('jquery-ui-core'), 1.0 );
				wp_enqueue_script('member_info_functions_js', MI_url.'/js/member_info_functions.js', '', 1.0 );
				$data = array( 'MI_url' => MI_url );
				wp_localize_script( 'member_info_functions_js', 'settings', $data );
				wp_enqueue_script('google_maps_api', 'http://maps.google.com/maps/api/js?sensor=true', '', 1.0 );
				wp_enqueue_script('member_info_location_js', MI_url.'/js/location.js', '', 1.0 );
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_script('mi_upload', MI_url . '/js/upload.js', array('jquery','media-upload','thickbox'));
				wp_enqueue_script('show_hide_profile_fields', MI_url.'/js/show_hide_profile_fields.js', '', 1.0 );
				wp_enqueue_script('wysiwyg', MI_url.'/js/wysiwyg/jquery.wysiwyg.js', '', 1.0 );
				
				$data = array( 'show_defaults' => get_option('show_defaults'), 'required' => get_option('required_fields'), 'extra_fields' => get_option('mi_field_name') );
				wp_localize_script( 'show_hide_profile_fields', 'mi_options', $data );
				
				$data = array( 'MI_url' => MI_url, 'WPURL' => get_bloginfo('url') . '/wp-admin/');
				wp_localize_script( 'mi_upload', 'MI', $data );
			}
		}

	}
	
	function style_libs(){
	
		wp_enqueue_style('member_info_styles', MI_url . '/css/member_info.css');
		wp_enqueue_style('thickbox');
	
	}
	
	function js_libs_front_end(){	
	
		global $pagenow;
	
		if(is_page(get_option('profile_page_id')) || is_page(get_option('register_page_id'))){
		
			wp_enqueue_script('jquery');
			wp_enqueue_script('jquery-ui-core', array('jquery'));
			wp_enqueue_script('datepicker', MI_url.'/js/datepicker.js', array('jquery-ui-core'), 1.0 );
			//wp_enqueue_script('jquery-ui-sortable');
			wp_enqueue_script('member_info_functions_js', MI_url.'/js/member_info_functions.js', '', 1.0 );
			wp_enqueue_script('google_maps_api', 'http://maps.google.com/maps/api/js?sensor=true', '', 1.0 );
			wp_enqueue_script('member_info_location_js', MI_url.'/js/location.js', '', 1.0 );
			wp_enqueue_script('media-upload');
			//wp_enqueue_script('thickbox');
			wp_enqueue_script('mi_upload', MI_url . '/js/upload.js', array('thickbox'));
			wp_enqueue_script('member_info_front_end_js', MI_url.'/js/member_info_front_end.js', array('thickbox'), 1.0 );
			wp_enqueue_script('show_hide_profile_fields', MI_url.'/js/show_hide_profile_fields.js', '', 1.0 );
			wp_enqueue_script('wysiwyg', MI_url.'/js/wysiwyg/jquery.wysiwyg.js', '', 1.0 );
			
			$data = array( 'MI_url' => MI_url, 'account' => get_permalink(get_option('profile_page_id')) );
			wp_localize_script( 'member_info_functions_js', 'settings', $data );				
			
			$data = array( 'show_defaults' => get_option('show_defaults'), 'required' => get_option('required_fields'), 'extra_fields' => get_option('mi_field_name') );
			wp_localize_script( 'show_hide_profile_fields', 'mi_options', $data );	
			
			$data = array( 'MI_url' => MI_url, 'WPURL' => get_bloginfo('url') . '/wp-admin/');
			wp_localize_script( 'mi_upload', 'MI', $data );

			wp_enqueue_script('mi-user-profile', get_bloginfo('url') . '/wp-admin/js/user-profile.js', '', 1.0 );
			wp_enqueue_script('mi-password-strength-meter', get_bloginfo('url') . '/wp-admin/js/password-strength-meter.dev.js', '', 1.0 );
			$data = array(
				'empty' => __('Strength indicator'),
				'short' => __('Very weak'),
				'bad' => __('Weak'),
				/* translators: password strength */
				'good' => _x('Medium', 'password strength'),
				'strong' => __('Strong'),
				'mismatch' => __('Mismatch'),
				'l10n_print_after' => 'try{convertEntities(pwsL10n);}catch(e){};'
			);
			wp_localize_script( 'mi-password-strength-meter', 'pwsL10n', $data );
		
		}
		
		if(!is_page(get_option('login_page_id') && !is_page(get_option('register_page_id')))){
		
			wp_enqueue_script('member_info_iframe_check', MI_url.'/js/iframe_check.js', '', 1.0 );
		
			$data = array( 'MI_url' => MI_url, 'account' => get_permalink(get_option('profile_page_id')), 'home' => get_bloginfo('url') );
			wp_localize_script( 'member_info_iframe_check', 'settings', $data );
		
		}

	}
	
	function style_libs_front_end(){
		
		if(is_page(get_option('profile_page_id')) || is_page(get_option('register_page_id')) || is_page(get_option('login_page_id'))){
	
			wp_enqueue_style('member_info_styles', MI_url . '/css/member_info.css');
			
			wp_enqueue_style('thickbox');	
		
			wp_enqueue_style('mi-colors-fresh', get_bloginfo('url') . '/wp-admin/css/colors-fresh.css');
		
			wp_enqueue_style('ui_lightness', MI_url . '/js/ui-lightness/jquery-ui-1.8.16.custom.css');
			
			wp_enqueue_style('wysiwyg', MI_url . '/js/wysiwyg/jquery.wysiwyg.css');
		
		}
	
	}
	
	function modify_contactmethods( $contactmethods ){
	
		$contactmethods['twitter_url'] = 'Twitter';
		
		$contactmethods['facebook_url'] = 'Facebook';
		
		$contactmethods['youtube_url'] = 'YouTube';
		
		$contactmethods['linkedin_url'] = 'Linkedin';
		
		$contactmethods['soundcloud_url'] = 'Sound Cloud';

		return $contactmethods;
	
	} // function
	
	/* 	
	
	Use the save post hook to search the content and find shortcodes 
	
	*/
	
	function catch_shortcodes($post_ID){
	
		$the_post = get_post($post_ID);
  		$post_content = $the_post->post_content;
  		
  		//check that this function is not being called by an autosave
  		
  		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
  			return;
  		}else{
  		
	  		//if the post content contains the shortcode add the id to an option
	 
	        if(strpos($post_content, SHORTCODE_account) !== false) {
				update_option('profile_page_id', $post_ID);
				
				update_option('profile_page_slug', basename(get_permalink( $post_ID )));
	        }
	        
	       if(strpos($post_content, SHORTCODE_register) !== false) {
				update_option('register_page_id', $post_ID );
				
				update_option('register_page_slug', basename(get_permalink( $post_ID )));
	        }
	        
	       if(strpos($post_content, SHORTCODE_login) !== false) {
				update_option('login_page_id', $post_ID );
				
				update_option('login_page_slug', basename(get_permalink( $post_ID )));
	        }
        
        }        
	
	}
		
	function showMessage($message, $errormsg = false){
	
		if ($errormsg) {
			echo '<div id="message" class="error">';
		}
		else {
			echo '<div id="message" class="updated fade">';
		}
	
		echo "<p><strong>$message</strong></p></div>";
	}    
	
	function check_pages_setup(){
	
	    // Only show to admins
	    if (current_user_can('manage_options')) {
	    	if(get_option('profile_page_id') == ''){
	       		$this->showMessage("You have not added a profile page for your members. To do this add [" . SHORTCODE_account . "] to any page.", true);
	       	}
	    	if(get_option('register_page_id') == ''){
	       		$this->showMessage("You have not added a register page for your members. To do this add [" . SHORTCODE_register . "] to any page.", true);
	       	}
	    	if(get_option('login_page_id') == ''){
	       		$this->showMessage("You have not added a login page for your members. To do this add [" . SHORTCODE_login . "] to any page.", true);
	       	}	       		       	
	    }
	}
	
}

?>
