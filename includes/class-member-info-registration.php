<?php

new member_info_registration;

class member_info_registration extends member_info_meta_boxes {

		public $default_fields = array(
		array(
			'Personal Options', '', ''
		),
		array(
			'Visual Editor', 'Disable the WYSIWYG when writing posts. This will not be applicable if your members join as a subscriber level user (which is the default).', 'visual_editor'
		),
		array(
			'Keyboard Shortcuts', 'Enable keyboard shortcuts for comment moderation. As above, unless your users are joining as anything other than Subscribers you do not need this.', 'keyboard_shortcuts'
		),
		array(
			'Admin Color Scheme', 'The option for the user to change the default color scheme.', 'admin_color_scheme'
		),
		array(
			'Show Admin Bar', 'Allow the user control of whether or not the admin bar is shown and where it is show.', 'show_admin_bar'
		),	
		array(
			'Name', '', ''
		),
		array(
			'Username', 'The username cannot be changed anyway but this field simply displays it.', 'username'
		),
		array(
			'First Name', 'The user\'s first name.', 'first_name'
		),
		array(
			'Last Name', 'The user\'s last name.', 'last_name'
		),
		array(
			'Nickname', 'The user\'s nickname for this site. A required field but once registered the user does not have to have the option to update it.', 'nickname'
		),
		array(
			'Display name publicly as', 'The user can choose between their username, nickname, first name or last name or any combination of first and last name to be used as their public name on this site.', 'display_name_publicly'
		),
		array(
			'Contact Info', '', ''
		),
		array(
			'E-mail', 'A required field but the user does not have to have access to it once initially registered.', 'email'
		),
		array(
			'Website', 'The user\'s personal website.', 'website'
		),
		array(
			'AIM', 'The user\'s AIM account.', 'aim'
		),
		array(
			'Yahoo IM', 'The user\'s Yahoo IM account.', 'yahoo_im'
		),
		array(
			'Jabber / Google Talk', 'The user\'s Jabber / Google Talk account.', 'jabber_google_talk'
		),
		array(
			'Twitter', 'The user\'s Twitter account.', 'twitter'
		),
		array(
			'Facebook', 'The user\'s Facebook account.', 'facebook'
		),
		array(
			'YouTube', 'The user\'s YouTube account.', 'youtube'
		),
		array(
			'Linkedin', 'The user\'s Linkedin account.', 'linkedin'
		),
		array(
			'Sound Cloud', 'The user\'s Sound Cloud account.', 'sound_cloud'
		),
		array(
			'About Yourself', '', ''
		),
		array(
			'Biographical Info', 'The option for the user to add a brief bio about themselves.', 'biographical_info'
		),
		array(
			'New Password', 'Give the user the ability to change their password.', 'password'
		),
								
	);

	function member_info_registration(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
		
		add_action('register_form', array( &$this, 'add_fields_to_reg_form' ));
		
		add_action('init', array( &$this, 'redirect' ));
		
		add_shortcode( SHORTCODE_register , array( &$this, 'register_form' ) );
		
		add_filter('shake_error_codes', array( &$this, 'redirect_login' ));
		
		add_shortcode( SHORTCODE_login , array( &$this, 'register_form' ) );
		

		//add_action('register_post', array( &$this, 'check_fields' ),10,3);
		
		//add_action('user_register', array( &$this, 'register_member' ));
		
		add_filter('login_headerurl', array( &$this, 'login_url' )); 
		
		add_filter('login_headertitle', array( &$this, 'login_title' ));
		
		add_action('login_head', array( &$this, 'login_image' ));
		
		/*
		
		add_filter('new_member_email_head', array( &$this, 'welcome_email_header' )); 
		
		add_filter('new_member_email_content', array( &$this, 'welcome_email_content' )); 
		
		add_filter('new_member_email_footer', array( &$this, 'welcome_email_footer' )); 

		*/

	
	} // function
	
	function add_fields_to_reg_form(){
	
		$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );
		$fields_desc = explode( ',', get_option('mi_field_desc') );
		$custom_select = explode( ',', get_option('mi_custom_select_option') );

		$reg_fields = explode( '~', get_option('reg_fields') );
		
		$i=0;
		
		foreach($fields_name as $field){
			if(in_array('custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ), $reg_fields)){
				
				?>
				<p>
					<label>
						<?php echo $field; ?>
						<br>
						<?php do_action( 'registration_profile_url', $fields_type[$i], $field ); ?>
						<?php
						if($fields_type[$i] == 'custom_select'){
						
							$custom_options = explode( ',', get_option('custom_select_option_' . $custom_select[$i]) );
						 	echo '<select class="input" id="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '" name="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '" >';
						 	foreach($custom_options as $option){
						 		$timestamp = mktime() . $ii;
						 		if($option != ''){
						 			echo '<option value="' . strtolower( str_replace( ' ', '_', $option ) ) . '">' . $option . '</option>';
						 		}
						 	}
						 	echo '</select>';
						 	
						}elseif($fields_type[$i] == 'address_map'){
						
							$this->show_map(strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ));
						
						}elseif($fields_type[$i] == 'address'){
						
							$this->show_map('custom_field_'. strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ), '', 'no');
						
						}elseif($fields_type[$i] == 'text'){
						
							echo '<input id="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '" class="input" type="text" tabindex="20" size="25" value="' . $_POST['custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )] . '" name="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '">';
						
						}elseif($fields_type[$i] == 'textarea'){
						
							echo '<textarea rows="9" cols="30" id="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '" class="input" name="custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ) . '">' . $_POST['custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )] . '</textarea>';
						
						}						
						?>
<!-- 						<input id="<?php echo 'custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ); ?>" class="input" type="text" tabindex="20" size="25" value="<?php echo $_POST['skillclip_url']; ?>" name="skillclip_url"> -->
						<p class="description">
							<?php echo $fields_desc[$i]; ?>
						</p>
					</label>
				</p>	
				<?php			
			}
			$i++;
		}		
	
	} // function
	
	function register_form(){
	
		do_action( 'login_enqueue_scripts' );
		do_action( 'login_head' );
		do_action( 'login_init' );
		do_action( 'login_form_register' );
			
		if(is_page(get_option('register_page_id'))){
	
			if ( is_user_logged_in() ){ ?>
			
				<p id="login_error">
					<?php _e('You are already signed in. Please <a href="' . wp_logout_url( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) . '">sign out</a> to register a new profile.', ' member-info'); ?>
				</p>
			
			<?php }else{
		
				$fields_name = explode( ',', get_option('mi_field_name') );
				$fields_type = explode( ',', get_option('mi_field_type') );
				$fields_desc = explode( ',', get_option('mi_field_desc') );
				$custom_select = explode( ',', get_option('mi_custom_select_option') );
				
				$required_fields = explode( '~', get_option('required_fields') );			
				$reg_fields = explode( '~', get_option('reg_fields') );
				
				$registration = get_option( 'users_can_register' );
		 
				if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'adduser' ) {
					$user_pass = wp_generate_password();
					$userdata = array(
						'user_pass' => $user_pass,
						'user_login' => esc_attr( $_POST['username'] ),
						'user_email' => esc_attr( $_POST['email'] ),
						'role' =>'basic_member',
					);
					
					foreach($this->default_fields as $field){
					
						if($field[2] != '' && in_array($field[2], $reg_fields)){
							
							$userdata[$field[2]] = $_POST[$field[2]];			
						
					}
					
					}					
				 
					if ( !$userdata['user_login'] ){
						$error = __('A username is required for registration.', 'member-info');
					}elseif ( username_exists($userdata['user_login']) ){
						$error = __('Sorry, that username already exists!', 'member-info');
				 	}elseif ( !is_email($userdata['user_email'], true) ){
						$error = __('You must enter a valid email address.', 'member-info');
					}elseif ( email_exists($userdata['user_email']) ){
						$error = __('Sorry, that email address is already used!', 'member-info');
				 	}
				 	
				 	if($required_fields != ''){
				 	
				 		$extra_meta = array();
				 		
				 		$i = 0;
				 	
						foreach($fields_name as $field){
							if(in_array('custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ), $required_fields) && in_array('custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ), $reg_fields)){
				 			
					 			$post_name = 'custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) );
					 			
					 			//echo $post_name . ' = ' . $_POST[$post_name] . '<br>';
					 					 			
					 			if ( $_POST[$post_name] == '' ){
					 			
					 				$error = __($fields_name[$i] . '  is required for registration.', 'member-info'); 
					 			
					 			}else{
					 			
					 				//add checks for extra field type. e.g.. If it is a map/address we need to save the lat and lng as well.
					 			
					 				$extra_meta[strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )]['value'] =  $_POST[$post_name]; // make an array of all the user data to be saved.
					 				
					 				$extra_meta[strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )]['type'] =  $fields_type[$i];
					 			
					 			}
				 			
				 			}
				 			
				 			$i++;
				 	
				 		}
				 	
				 	}
				 	
					if(!$error){
						//print_r($userdata);
						
						$new_user = wp_insert_user( $userdata );

						//save user meta from $extra_meta array
						
						foreach($extra_meta as $metakey => $metavalue){
						
							do_action( 'registration_save_custom_fields', $metavalue['type'], $metavalue['value']  );
						
							//echo $metakey . ' ' . $metavalue['value'];
						
							update_usermeta( $new_user, $metakey, $metavalue['value'] );
						
						}
						
						wp_new_user_notification($new_user, $user_pass);
						
					}
					
					if ( $error ) { ?>
						<div id="login_error">
							<?php echo $error; ?>
						</div>
					<?php }else{ ?>
						<p class="message">	
							Registration complete. Please check your e-mail.<br>
						</p>
					<?php }
				 
				} 
				
				?>
				
				<form method="post" action="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" id="registerform" name="registerform">
				
					<?php foreach($this->default_fields as $field){
					
						if($field[2] != '' && in_array($field[2], $reg_fields)){ ?>
		
							<p>
								<label><?php echo $field[0]; ?><br>
								<input type="text" tabindex="10" size="20" value="<?php if ( $error ) echo esc_html( $_POST[$field[2]], 1 ); ?>" class="input" id="<?php echo $field[2]; ?>" name="<?php echo $field[2]; ?>"></label>
							</p>						
						
						<?php }
					
					} ?>
					
					<?php do_action('register_form'); ?>
					
<!-- 					<p id="reg_passmail">A password will be e-mailed to you.</p> -->
<!-- 					<br class="clear"> -->
					<input type="hidden" value="" name="redirect_to">
					
					<?php wp_nonce_field( 'add-user' ) ?>
					
					<input name="action" type="hidden" id="action" value="adduser" />
					<p class="submit"><input type="submit" tabindex="100" value="<?php if ( current_user_can( 'create_users' ) ) echo'Add User'; else echo 'Register'; ?>" class="button-primary" id="wp-submit" name="wp-submit"></p>
				</form>
				
			<?php }
			
		}elseif($_GET['action'] == 'lostpassword'){
					
			if ( $_REQUEST['error'] != '' ) { ?>
				<div id="login_error">
					<?php
					
					switch($_REQUEST['error']){
					
						case 'invalidcombo';
						echo "<strong>ERROR</strong>: Invalid username or e-mail.";
						break;
						
						case 'empty_username';
						echo "<strong>ERROR</strong>: Enter a username or e-mail address.";
						break;
					
					}
					
					?>
				</div>
			<?php }elseif($_REQUEST['reset'] == 'true'){ ?>
			
				<p class="message">	Check your e-mail for the confirmation link.<br></p>
			
			<?php }else{ ?>
			
				<p class="message">Please enter your username or email address. You will receive a link to create a new password via email.</p>
				
			<?php } ?>
			
			<form method="post" action="<?php echo site_url() ?>/wp-login.php?action=lostpassword" id="registerform" name="registerform">
				<p>
					<label for="user_login" class="hide"><?php _e('Username or Email'); ?>: </label>
					<input type="text" name="user_login" value="" size="20" id="user_login" tabindex="1001" />
				</p>
				<p class="submit">
					<?php do_action('login_form', 'resetpass'); ?>
					<input type="submit" value="<?php _e('Reset my password'); ?>" class="button-primary" id="wp-submit" name="wp-submit" />
					<?php $reset = $_GET['reset']; if($reset == true) { echo '<p>A message will be sent to your email address.</p>'; } ?>
					<input type="hidden" name="redirect_to" value="<?php echo get_permalink(get_option('login_page_id')); ?>?action=lostpassword&reset=true" />
					<input type="hidden" name="user-cookie" value="1" />
				</p>
			</form>			
			
			<?php
			
		}else{

			if ( $_REQUEST['error'] != '' ) { ?>
				<div id="login_error">
					<?php
					
					switch($_REQUEST['error']){
					
						case 'empty_password';
						echo "<strong>ERROR</strong>: The  password field is empty.";
						break;
						
						case 'empty_username';
						echo "<strong>ERROR</strong>: The username field is empty.";
						break;	
						
						case 'invalid_username';
						echo "<strong>ERROR</strong>: Invalid username. <a href=\"\">Lost your password?</a>";
						break;		
						
						case 'incorrect_password';
						echo "<strong>ERROR</strong>: The password you entered is incorrect. <a href=\"\">Lost your password?</a>";
						break;	
						
						case 'empty';
						echo "<strong>ERROR</strong>: Nothing was submitted.";
						break;											
					
					}
					
					?>
				</div>
			<?php } ?>
			
			<form action="<?php bloginfo('url'); ?>/wp-login.php" method="post" name="loginform" id="registerform" >
				<p>
					<label>Username<br>
					<input type="text" name="log" id="user_login" class="input" value="" size="20" tabindex="10"></label>
				</p>
				<p>
					<label>Password<br>
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" tabindex="20"></label>
				</p>
				
				<?php do_action('login_form'); ?>
				
				<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="90"> Remember Me</label></p>
				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" tabindex="100">
					<input name="action" type="hidden" id="action" value="login" />
					<input type="hidden" name="redirect_to" value="<?php echo get_permalink( get_option('profile_page_id') ); ?>" />
				</p>
				<p>
					<a href="<?php echo get_permalink(get_option('login_page_id')); ?>?action=lostpassword">Forgotten password?</a>
				</p>				
			</form>	
			
			<?php }
		
		do_action('login_footer');
		
	
	} // function
	
	function redirect_login(){
	
		if(get_option( 'login_page_id' ) != '' ){
		
			global $errors;
		
			$error_message = '';
			
	/*
			echo '<pre>';
			print_r($errors);
			echo '</pre>';
	*/
			
			if($errors){
			
				foreach($errors as $error){
					foreach($error as $key => $val){
						$error_message = $key;
					}
				}
			
			}
	
		
			if($_GET['action'] != 'rp' && $_GET['action'] != 'resetpass' ){
			
				if($error_message != '' || ($_POST['pwd'] && $_POST['pwd'] == '' && $_POST['log'] && $_POST['log'] == '' ) ){
					if($_POST['pwd'] == '' && $_POST['log'] == ''){
						if($_GET['action'] != 'lostpassword'){
							$error_message = 'empty';
						}
					}
					wp_redirect( get_permalink( get_option( 'login_page_id' ) ) . '?error=' . $error_message . '&action=' . $_GET['action'] );	
				}else{
					if($_GET['action'] == 'register' && get_option('register_page_id') != ''){
						wp_redirect( get_permalink( get_option( 'register_page_id' ) ) );
					}else{
						wp_redirect( get_permalink( get_option( 'login_page_id' ) ) . '?action=' . $_GET['action'] );	
					}
				}
				
			}
			
		}
		
	}
	
	function redirect(){
	
		if( ($_SERVER['REQUEST_URI'] == '/' . get_option( 'login_page_slug' ) . '/' || $_SERVER['REQUEST_URI'] == '/' . get_option( 'register_page_slug' ) . '/' ) && is_user_logged_in() ){
		
			wp_redirect( get_permalink( get_option( 'profile_page_id' ) ) );
		
		}
	
	}



	function login_url( $url ) {
    	return get_bloginfo( 'siteurl' );
	} // function
	
	function login_title( $title ){
		return "Developed by Jealous Designs [jealousdesigns.com]";
	} // function
	
	function login_image(){
	    echo '<style type="text/css">
	        h1 a { background-image:url('.get_bloginfo('template_directory').'/images/logo.png) !important; }
	        .register{ display:none; }
	    </style>';	
	} // function
	
/*
	function welcome_email_header($message){
	
		return 'header' . $message;
	
	}
	
	function welcome_email_content($message){
	
		return $message . 'Content';
	
	}	
	
	function welcome_email_footer($message){
	
		return $message . 'footer';
	
	}	
*/
	
}

//override the wp_new_user_notification function

if ( !function_exists('wp_new_user_notification') ) {  
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {  
        $user = new WP_User($user_id);  
  
        $user_login = stripslashes($user->user_login);  
        $user_email = stripslashes($user->user_email);  
  
        $admin_message  = stripslashes(sprintf(__('Someone new has registered on %s! Here\s their details-'), get_option('blogname'))) . "\r\n\r\n";  
        $admin_message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";  
        $admin_message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";  
  
        @wp_mail(get_option('admin_email'), sprintf(__('[%s] New Member Registration'), get_option('blogname')), $admin_message);  

        if ( empty($plaintext_pass) )  
            return;  
            
		$message = apply_filters( 'new_member_email_head', $message, $user->ID ); 
   		
        $message  .= __('Hey,') . "\r\n\r\n";  
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n"; 
        $message .= wp_login_url() . "\r\n"; 
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n"; 
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n"; 
        
        $message = apply_filters( 'new_member_email_content', $message, $user->ID ); 
        
        $message .= sprintf(__('If you have any problems, please contact me at %s.'), get_option('admin_email')) . "\r\n\r\n"; 
        $message .= __('All the best!'); 
        
        $message = apply_filters( 'new_member_email_footer', $message, $user->ID ); 
 
        wp_mail($user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message);  
  
    }  
}

?>