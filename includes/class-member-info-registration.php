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
		)
								
	);

	function member_info_registration(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
		
		add_action('register_form', array( &$this, 'add_fields_to_reg_form' ));
		
		add_action('init', array( &$this, 'redirect' ));
		
		add_action('wp_head', array( &$this, 'redirect' ));
				
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

		if ( is_user_logged_in() ){ 
		
			$message = 'You are already signed in. You can <a href="' . get_permalink( get_option( 'profile_page_id' ) ) . '">edit your profile</a> or <a href="' . wp_logout_url( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) . '">sign out</a>.'; ?>
		
			<p id="login_error">
				<?php echo apply_filters( 'logged_in_error', $message, $message );  ?>
			</p>
		
		<?php }else{

			if(is_page(get_option('register_page_id'))){
			
					$fields_name = explode( ',', get_option('mi_field_name') );
					$fields_type = explode( ',', get_option('mi_field_type') );
					$fields_desc = explode( ',', get_option('mi_field_desc') );
					$custom_select = explode( ',', get_option('mi_custom_select_option') );
					
					$required_fields = explode( '~', get_option('required_fields') );			
					$reg_fields = explode( '~', get_option('reg_fields') );
					
					$registration = get_option( 'users_can_register' );
			 
					if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'adduser' ) {
						if($_POST['pass1'] != '' ){
							$user_pass = $_POST['pass1'];
						}else{
							$user_pass = wp_generate_password();
						}
						$userdata = array(
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
							
								do_action( 'registration_save_custom_fields', $metavalue['type'], $metavalue['value'], $new_user );
							
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
					
						<?php $i = 0; 
						foreach($this->default_fields as $field){
						
							if($field[2] != '' && in_array($field[2], $reg_fields)){ 

								if($field[2] == 'password'){ ?>
									<label>Create a password<br>
									<div id="password">
										<input class="input" type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off"> <span class="description">If you would like to change the password type a new one. Otherwise leave this blank.</span><br>
										<input class="input" type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off"> <span class="description">Type your new password again.</span><br>
										<div id="pass-strength-result" style="display: block; ">Strength indicator</div>
										<p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>							
									</div>	
								<?php }elseif($field[2] == 'username'){ ?>
									<p>
										<label><?php echo $field[0]; ?><br>
										<input type="text" tabindex="10" size="20" value="<?php if ( $error ) echo esc_html( $_POST[$field[2]], 1 ); ?>" class="input" id="user_login" name="<?php echo $field[2]; ?>"></label>
									</p>
								<?php }else{ ?>
									<p>
										<label><?php echo $field[0]; ?><br>
										<input type="text" tabindex="10" size="20" value="<?php if ( $error ) echo esc_html( $_POST[$field[2]], 1 ); ?>" class="input" id="<?php echo $field[2]; ?>" name="<?php echo $field[2]; ?>"></label>
									</p>
								<?php }						
							
							}
							$i++;
						} ?>
						
						<?php do_action('register_form'); ?>
						
	<!-- 					<p id="reg_passmail">A password will be e-mailed to you.</p> -->
	<!-- 					<br class="clear"> -->
						<input type="hidden" value="" name="redirect_to">
						
						<?php wp_nonce_field( 'add-user' ) ?>
						
						<input name="action" type="hidden" id="action" value="adduser" />
						<p class="submit"><input type="submit" tabindex="100" value="<?php if ( current_user_can( 'create_users' ) ) echo'Add User'; else echo 'Register'; ?>" class="button-primary" id="wp-submit" name="wp-submit"></p>
					</form>
					
				<?php }elseif($_GET['action'] == 'lostpassword'){
						
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
					
					<?php $this->retrieve_password(); ?>
				
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
							echo "<strong>ERROR</strong>: Invalid username. <a href=\"" . get_permalink(get_option('login_page_id')) . "?action=lostpassword\">Lost your password?</a>";
							break;		
							
							case 'incorrect_password';
							echo "<strong>ERROR</strong>: The password you entered is incorrect. <a href=\"" . get_permalink(get_option('login_page_id')) . "?action=lostpassword\">Lost your password?</a>";
							break;	
							
							case 'empty';
							echo "<strong>ERROR</strong>: Nothing was submitted.";
							break;	
							
							case 'registerdisabled';
							echo "<strong>ERROR</strong>: User registration is currently not allowed.";
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
						<input type="hidden" name="redirect_to" value="<?php echo get_bloginfo('url'); ?>" />
					</p>
					<p>
						<a href="<?php echo get_permalink(get_option('login_page_id')); ?>?action=lostpassword">Forgotten password?</a>
					</p>				
				</form>	
				
				<?php }
				
			}		
		
		do_action('login_footer');
		
	
	} // function
	
	function redirect_login(){
	
		if(get_option( 'login_page_id' ) != '' ){
		
			global $errors, $pagenow;
		
			$error_message = '';
			
			if($errors){
			
				foreach($errors as $error){
					foreach($error as $key => $val){
						$error_message = $key;
					}
				}
			
			}
	
		
			if($_GET['action'] != 'rp' && $_GET['action'] != 'resetpass'){
			
				if($error_message != '' || ($_POST['pwd'] && $_POST['pwd'] == '' && $_POST['log'] && $_POST['log'] == '' ) ){
					if($_POST['pwd'] == '' && $_POST['log'] == '' & $error_message != 'registerdisabled'){
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
	
		$fields_type = explode( ',', get_option('mi_field_type') );
		$fields_name = explode( ',', get_option('mi_field_name') );
		$required_fields = explode( '~', get_option('required_fields') );
		
		//echo '<br>' . get_option('required_fields').'<br>';
		global $pagenow;
		
		global $current_user;
	    get_currentuserinfo();		
	    
	    $redirect = false;
	
		if(is_admin() && $pagenow !='media-upload.php' && $pagenow != 'async-upload.php' ){
	      	
	      	foreach($current_user->roles as $role ){
	      		if($role == 'basic_member'){
	      			wp_redirect( get_bloginfo('url') );
	      		}
	      	}
      	
		}
		
		$required = array();
		
		$i = 0;

		if(preg_replace('/\?.*/', '', $_SERVER['REQUEST_URI']) != '/' . basename(get_permalink(get_option( 'profile_page_id' ))) . '/' && !is_admin()  && is_user_logged_in() ){
		
			if(defined("MIPP_url") && get_bloginfo('url')  . $_SERVER['REQUEST_URI'] == MIPP_url . '/functions/check_url.php'){
				return;
			}
				
			$ii=0;
			
			foreach($fields_name as $field){

				$field1 = str_replace('custom_field_', '', $field );
				
				$sanitized_field = strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 _]", "", $field1) ) );
				
				if( in_array('custom_field_' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) ), $required_fields) ){
					$required[$i]['name'] = $field;
					$required[$i]['key'] = $ii;
					$i++;
				}	
				
				$ii++;
				
			}
			
			foreach($this->default_fields as $field){
			
				$check_field = $field[2];
				
				if( in_array($check_field, $required_fields) ){
					switch($check_field){
						case 'email':
							$check_field = 'user_email';
							break;
						case 'username':
							$check_field = 'user_login';
							break;
						case 'firstname':
							$check_field = 'first_name';
							break;
						case 'lastname':
							$check_field = 'last_name';
							break;
					}						
					$required[$i]['name']  = $check_field;
					$i++; 
				}										
				
			}
			
			foreach($required as $field){
			
				$field1 = str_replace('custom_field_', '', $field['name']  );
				
				$sanitized_field = strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 _]", "", $field1) ) );	
				
				do_action( 'check_required_fields', $sanitized_field, $fields_type[$field['key']] );		
			
				if( !isset($current_user->$sanitized_field) && $sanitized_field != '' ){
					
					wp_redirect( get_permalink( get_option( 'profile_page_id' ) ) . '?error=required_empty&field=' . str_replace( '_', '%20', $field['name']  ) );
					break;
					
				}			
			
			}
			
		}

		
	} // function

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

	function retrieve_password() {
		global $wpdb, $current_site;
	
		$errors = new WP_Error();
	
		if ( empty( $_POST['user_login'] ) && empty( $_POST['user_email'] ) )
			$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
	
		if ( strpos($_POST['user_login'], '@') ) {
			$user_data = get_user_by_email(trim($_POST['user_login']));
			if ( empty($user_data) )
				$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
		} else {
			$login = trim($_POST['user_login']);
			$user_data = get_userdatabylogin($login);
		}
	
		do_action('lostpassword_post');
	
		if ( $errors->get_error_code() )
			return $errors;
	
		if ( !$user_data ) {
			$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
			return $errors;
		}
	
		// redefining user_login ensures we return the right case in the email
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
	
		do_action('retreive_password', $user_login);  // Misspelled and deprecated
		do_action('retrieve_password', $user_login);
	
		$allow = apply_filters('allow_password_reset', true, $user_data->ID);
	
		if ( ! $allow )
			return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
		else if ( is_wp_error($allow) )
			return $allow;
	
		$key = $wpdb->get_var($wpdb->prepare("SELECT user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if ( empty($key) ) {
			// Generate something random for a key...
			$key = wp_generate_password(20, false);
			do_action('retrieve_password_key', $user_login, $key);
			// Now insert the new md5 key into the db
			$wpdb->update($wpdb->users, array('user_activation_key' => $key), array('user_login' => $user_login));
		}
		$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		$message .= network_site_url() . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
		$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
	
		if ( is_multisite() )
			$blogname = $GLOBALS['current_site']->site_name;
		else
			// The blogname option is escaped with esc_html on the way into the database in sanitize_option
			// we want to reverse this for the plain text arena of emails.
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
	
		$title = sprintf( __('[%s] Password Reset'), $blogname );
	
		$title = apply_filters('retrieve_password_title', $title);
		$message = apply_filters('retrieve_password_message', $message, $key);
	
		if ( $message && !wp_mail($user_email, $title, $message) )
			wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function...') );
	
		return true;
	}
	
}

//override the wp_new_user_notification function

if ( !function_exists('wp_new_user_notification') ) {  
    function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {  
    	wp_set_password($plaintext_pass, $user_id);
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