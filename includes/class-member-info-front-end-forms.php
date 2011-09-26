<?php

$member_info_front_end_forms = new member_info_front_end_forms;

class member_info_front_end_forms extends member_info_meta_boxes{

	function member_info_front_end_forms(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_shortcode( SHORTCODE_account , array( &$this, 'account_page' ) );
	
	} // function
	
	function account_page(){
	
		global $current_user, $wp_roles, $wpdb;
		get_currentuserinfo();
	 
		require_once( ABSPATH . WPINC . '/registration.php' );
		require_once( ABSPATH . 'wp-admin/includes' . '/template.php' ); 
		
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
	 
			/* Update user password. */
			if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
				if ( $_POST['pass1'] == $_POST['pass2'] )
					wp_update_user( array( 'ID' => $current_user->id, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
				else
					$error = __('The passwords you entered do not match.  Your password was not updated.', ' member-info');
			}
			
			$user = new stdClass;
			
			$user->ID = (int) $current_user->id;
			$userdata = get_userdata( $current_user->id );
			$user->user_login = $wpdb->escape( $userdata->user_login );
			
			$user->rich_editing = isset( $_POST['rich_editing'] ) && 'false' == $_POST['rich_editing'] ? 'false' : 'true';
			$user->admin_color = isset( $_POST['admin_color'] ) ? sanitize_text_field( $_POST['admin_color'] ) : 'fresh';
			$user->show_admin_bar_front = isset( $_POST['admin_bar_front'] ) ? 'true' : 'false';
			$user->show_admin_bar_admin = isset( $_POST['admin_bar_admin'] ) ? 'true' : 'false';
	 		$user->comment_shortcuts = isset( $_POST['comment_shortcuts'] ) && 'true' == $_POST['comment_shortcuts'] ? 'true' : '';	

			wp_update_user( get_object_vars( $user ) );
				 
			update_usermeta( $current_user->id, 'first_name', esc_attr( $_POST['first_name'] ) );
	 
			update_usermeta( $current_user->id, 'last_name', esc_attr( $_POST['last_name'] ) );
	 
			if ( !empty( $_POST['nickname'] ) )
				update_usermeta( $current_user->id, 'nickname', esc_attr( $_POST['nickname'] ) );
	 
			update_usermeta( $current_user->id, 'display_name', esc_attr( $_POST['display_name'] ) );
	 
			if ( !empty( $_POST['email'] ) )
				update_usermeta( $current_user->id, 'user_email', esc_attr( $_POST['email'] ) );
	 
			if(strpos($_POST['url'], 'ttp://') || empty( $_POST['url'] ))
				update_usermeta( $current_user->id, 'user_url', esc_attr( $_POST['url'] ) );
			else
				update_usermeta( $current_user->id, 'user_url', 'http://' . esc_attr( $_POST['url'] ) );
	 
			update_usermeta( $current_user->id, 'aim', esc_attr( $_POST['aim'] ) );
	 
			update_usermeta( $current_user->id, 'yim', esc_attr( $_POST['yim'] ) );
	 
			update_usermeta( $current_user->id, 'jabber', esc_attr( $_POST['jabber'] ) );
	 
			update_usermeta( $current_user->id, 'description', esc_attr( $_POST['description'] ) );
	 	 
			update_usermeta( $current_user->id, 'twitter_url', esc_attr( $_POST['twitter_url'] ) );	
	 
			update_usermeta( $current_user->id, 'facebook_url', esc_attr( $_POST['facebook_url'] ) );	
	 
			update_usermeta( $current_user->id, 'youtube_url', $_POST['youtube_url'] );	
	 
			update_usermeta( $current_user->id, 'linkedin_url', esc_attr( $_POST['linkedin_url'] ) );	
			
			update_usermeta( $current_user->id, 'soundcloud_url', esc_attr( $_POST['soundcloud_url'] ) );	
			
			$this->member_info_save_member_data($current_user->id);
	 
			/* Redirect so the page will show updated info. */

			if ( !$error ) {
				echo "<meta http-equiv='refresh' content='0;url='" .get_permalink(). "?updated=true' />";
				exit;
			}else{
				echo $error;
			}
			
		}
		 
		if ( !is_user_logged_in() ) : ?>

			<p class="warning">
				<?php _e('You must be logged in to edit your profile.', ' member-info'); ?>
			</p>

		<?php else : ?>
		
			<?php if(isset( $_REQUEST['error'] ) ){

				switch($_REQUEST['error']){
					case 'required_empty':
						$error = 'Required fields are empty. Please fill in ' . $_REQUEST['field'] . ' continue using the site.';
					break;
				} 
				
				do_action( 'profile_errors', $_GET['error']); 
			
			} ?>		

			<?php if ( $error ) echo '<p class="error">' . $error . '</p>'; ?>
			
			<script type="text/javascript">
			

			var isInIFrame = (window.location != window.parent.location) ? true : false;
			
			if(isInIFrame){
				parent.document.location=settings.account;
			}

			
			function change_parent_url(url){
				$.fancybox.close();
				document.location=url;
			}

			</script>

			<form method="post" id="edituser" class="user-forms" action="<?php the_permalink(); ?>">

				<h3>Personal Options</h3>
				
				<table class="form-table">
					<tbody><tr>
						<th scope="row">Visual Editor</th>
						<td><label for="rich_editing"><input class="input" name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php if(get_the_author_meta( 'rich_editing', $current_user->id ) == 'false'){ echo " checked=\checked\" "; }; ?>> Disable the visual editor when writing</label></td>
					</tr>
				<tr>
				<th scope="row">Admin Color Scheme</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Admin Color Scheme</span></legend>
						<div class="color-option">
							<input class="input" name="admin_color" id="admin_color_classic" type="radio" value="classic" class="tog" <?php if(get_the_author_meta( 'admin_color', $current_user->id ) == 'classic'){ echo " checked=\"checked\" "; }; ?>>
							<table class="color-palette">
							<tbody><tr>
								<td style="background-color: #5589aa" title="classic">&nbsp;</td>
								<td style="background-color: #cfdfe9" title="classic">&nbsp;</td>
								<td style="background-color: #d1e5ee" title="classic">&nbsp;</td>
								<td style="background-color: #eff8ff" title="classic">&nbsp;</td>
								</tr>
							</tbody></table>
						
							<label for="admin_color_classic">Blue</label>
						</div>
						<div class="color-option">
							<input class="input" name="admin_color" id="admin_color_fresh" type="radio" value="fresh" class="tog" <?php if(get_the_author_meta( 'admin_color', $current_user->id ) == 'fresh'){ echo " checked=\"checked\" "; }; ?>>
							<table class="color-palette">
							<tbody><tr>
								<td style="background-color: #7c7976" title="fresh">&nbsp;</td>
								<td style="background-color: #c6c6c6" title="fresh">&nbsp;</td>
								<td style="background-color: #e0e0e0" title="fresh">&nbsp;</td>
								<td style="background-color: #f1f1f1" title="fresh">&nbsp;</td>
								</tr>
							</tbody></table>
						
							<label for="admin_color_fresh">Gray</label>
						</div>
					</fieldset>
				</td>
				</tr>
				<tr>
				<th scope="row">Keyboard Shortcuts</th>
				<td>
					<label for="comment_shortcuts">
					<input class="input" type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if(get_the_author_meta( 'comment_shortcuts', $current_user->id ) == 'true'){ echo " checked=\"checked\" "; }; ?>> Enable keyboard shortcuts for comment moderation.</label> <a href="http://codex.wordpress.org/Keyboard_Shortcuts" target="_blank">More information</a>
				</td>
				</tr>
				<tr class="show-admin-bar">
				<th scope="row">Show Admin Bar</th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span>Show Admin Bar</span></legend>
						<label for="admin_bar_front">
						<input class="input" name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1" <?php if($current_user->show_admin_bar_front  == 'true'){ echo " checked=\"checked\" "; }; ?>>
						when viewing site</label><br>
						<label for="admin_bar_admin">
						<input class="input" name="admin_bar_admin" type="checkbox" id="admin_bar_admin" value="1" <?php if($current_user->show_admin_bar_admin == 'true'){ echo " checked=\"checked\" "; }; ?>>
						in dashboard</label>
					</fieldset>
				</td>
				</tr>
				</tbody></table>
				
				<h3>Name</h3>
				
				<table class="form-table">
					<tbody><tr>
						<th><label for="user_login">Username</label></th>
						<td><input class="input" type="text" name="user_login" id="user_login" value="<?php the_author_meta( 'user_login', $current_user->id ); ?>" disabled="disabled" class="regular-text"> <span class="description">Usernames cannot be changed.</span></td>
					</tr>
				
				
				<tr>
					<th><label for="first_name">First Name</label></th>
					<td><input class="input" type="text" name="first_name" id="first_name" value="<?php the_author_meta( 'first_name', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				
				<tr>
					<th><label for="last_name">Last Name</label></th>
					<td><input class="input" type="text" name="last_name" id="last_name" value="<?php the_author_meta( 'last_name', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				
				<tr>
					<th><label for="nickname">Nickname <span class="description">(required)</span></label></th>
					<td><input class="input" type="text" name="nickname" id="nickname" value="<?php the_author_meta( 'nickname', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				
				<tr>
					<th><label for="display_name">Display name publicly as</label></th>
					<td>
						<select name="display_name" id="display_name">
						<?php
							$public_display = array();
							$public_display['display_nickname']  = $current_user->nickname;
							$public_display['display_username']  = $current_user->user_login;
							if ( !empty($current_user->first_name) )
								$public_display['display_firstname'] = $current_user->first_name;
							if ( !empty($current_user->last_name) )
								$public_display['display_lastname'] = $current_user->last_name;
							if ( !empty($current_user->first_name) && !empty($current_user->last_name) ) {
								$public_display['display_firstlast'] = $current_user->first_name . ' ' . $current_user->last_name;
								$public_display['display_lastfirst'] = $current_user->last_name . ' ' . $current_user->first_name;
							}
							if ( !in_array( $current_user->display_name, $public_display ) )// Only add this if it isn't duplicated elsewhere
								$public_display = array( 'display_displayname' => $current_user->display_name ) + $public_display;
							$public_display = array_map( 'trim', $public_display );
							foreach ( $public_display as $id => $item ) {
						?>
							<option id="<?php echo $id; ?>" value="<?php echo esc_attr($item); ?>"<?php selected( $current_user->display_name, $item ); ?>><?php echo $item; ?></option>
						<?php
							}
						?>
						</select>
					</td>
				</tr>
				</tbody></table>
				
				<h3>Contact Info</h3>
				
				<table class="form-table">
				<tbody><tr>
					<th><label for="email">E-mail <span class="description">(required)</span></label></th>
					<td><input class="input" type="text" name="email" id="email" value="<?php the_author_meta( 'email', $current_user->id ); ?>" class="regular-text">
						</td>
				</tr>
				
				<tr>
					<th><label for="url">Website</label></th>
					<td><input class="input" type="text" name="url" id="url" value="<?php the_author_meta( 'url', $current_user->id ); ?>" class="regular-text code"></td>
				</tr>
				
				<tr>
					<th><label for="aim">AIM</label></th>
					<td><input class="input" type="text" name="aim" id="aim" value="<?php the_author_meta( 'aim', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="yim">Yahoo IM</label></th>
					<td><input class="input" type="text" name="yim" id="yim" value="<?php the_author_meta( 'yim', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="jabber">Jabber / Google Talk</label></th>
					<td><input class="input" type="text" name="jabber" id="jabber" value="<?php the_author_meta( 'jabber', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="twitter_url">Twitter</label></th>
					<td><input class="input" type="text" name="twitter_url" id="twitter_url" value="<?php the_author_meta( 'twitter_url', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="facebook_url">Facebook</label></th>
					<td><input class="input" type="text" name="facebook_url" id="facebook_url" value="<?php the_author_meta( 'facebook_url', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="youtube_url">YouTube</label></th>
					<td><input class="input" type="text" name="youtube_url" id="youtube_url" value="<?php the_author_meta( 'youtube_url', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="linkedin_url">Linkedin</label></th>
					<td><input class="input" type="text" name="linkedin_url" id="linkedin_url" value="<?php the_author_meta( 'linkedin_url', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				<tr>
					<th><label for="soundcloud_url">Sound Cloud</label></th>
					<td><input class="input" type="text" name="soundcloud_url" id="soundcloud_url" value="<?php the_author_meta( 'soundcloud_url', $current_user->id ); ?>" class="regular-text"></td>
				</tr>
				</tbody></table>
				
				<h3>About Yourself</h3>
				
				<table class="form-table">
				<tbody><tr>
					<th><label for="description">Biographical Info</label></th>
					<td><textarea name="description" id="description" rows="5" cols="30"><?php the_author_meta( 'description', $current_user->id ); ?></textarea><br>
					<span class="description">Share a little biographical information to fill out your profile. This may be shown publicly.</span></td>
				</tr>
				
				<tr id="password">
					<th><label for="pass1">New Password</label></th>
					<td><input class="input" type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off"> <span class="description">If you would like to change the password type a new one. Otherwise leave this blank.</span><br>
						<input class="input" type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off"> <span class="description">Type your new password again.</span><br>
						<div id="pass-strength-result" style="display: block; ">Strength indicator</div>
						<p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>
					</td>
				</tr>
				</tbody></table>
			
				<?php $this->member_info_location_inner($current_user); ?>
				
				<p class="form-submit">
					<?php echo $referer; ?>
					<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', ' member-info'); ?>"/>
					<div id="error_message"></div>
					<?php wp_nonce_field( 'update-user' ) ?>
					<input name="action" type="hidden" id="action" value="update-user" />
				</p>

			</form>	
			
			<br style="clear:both:">		

		<?php endif;
 	
	} // function
	
}