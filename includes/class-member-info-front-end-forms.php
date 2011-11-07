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
	
		do_action( 'account_page_head'); 
		
		if($_GET['message'] != ''){
		
			echo '<p class="message">' . $_GET['message'] . '</p>';
		
		}
	
		global $current_user, $wp_roles, $wpdb;
		get_currentuserinfo();
		
		$show_form = true;
	 
		require_once( ABSPATH . WPINC . '/registration.php' );
		require_once( ABSPATH . 'wp-admin/includes' . '/template.php' ); 
		
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {
		
			do_action( 'member_info_save_member_details', $current_user->id);
	 
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
	 
			update_usermeta( $current_user->id, 'user_description', addslashes( $_POST['user_description'] ) );
	 	 
			update_usermeta( $current_user->id, 'twitter_url', esc_attr( $_POST['twitter_url'] ) );	
	 
			update_usermeta( $current_user->id, 'facebook_url', esc_attr( $_POST['facebook_url'] ) );	
	 
			update_usermeta( $current_user->id, 'youtube_url', $_POST['youtube_url'] );	
	 
			update_usermeta( $current_user->id, 'linkedin_url', esc_attr( $_POST['linkedin_url'] ) );	
			
			update_usermeta( $current_user->id, 'soundcloud_url', esc_attr( $_POST['soundcloud_url'] ) );	
			
			$this->member_info_save_member_data($current_user->id);
	 
			/* Redirect so the page will show updated info. */

			if ( !$error ) {
				echo "<meta http-equiv='refresh' content='0;url='" .get_permalink(). "?updated=true' />";
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
						$error = 'Required fields are empty. Please fill in ' . $_REQUEST['field'] . ' to continue using the site.';
					break;
				} 
				
				do_action( 'profile_errors', $_GET['error']); 
			
			} ?>		

			<?php if ( $error ) echo '<p class="error">' . $error . '</p>'; ?>
			
			<script type="text/javascript">
			jQuery(function() {
				jQuery('.wysiwyg').wysiwyg({
					css: '<?php echo MI_url; ?>/js/wysiwyg/custom.css',
					initialContent: "",
				    controls: {
				        strikeThrough: { visible: false },
				        underline: { visible: false },
				        subscript: { visible: false },
				        superscript: { visible: false },
				        insertHorizontalRule: { visible: false },
				        insertImage: { visible: false },
				        h1: { visible: false },
				        h2: { visible: false },
				        h3: { visible: false },
				        decreaseFontSize: { visible: false },
				        html: { visible: false },
				        insertTable: { visible: false },
				        code: { visible: false },
				        bold: { visible: false },
				        italic: { visible: false },
				        justifyLeft: { visible: false },
				        justifyCenter: { visible: false },
				        justifyRight: { visible: false },
				        justifyFull: { visible: false },
				        indent: { visible: false },
				        outdent: { visible: false },
				        insertOrderedList: { visible: false },
				        insertUnorderedList: { visible: false },
				        createLink: { visible: false },
				        redo: { visible: false },
				        undo: { visible: false },
				        removeFormat: { visible: false }
				    }
				});
			});
			</script>	
			
			<?php if($show_form){ 
			
			do_action( 'profile_page_pre_form', $current_user->id); ?>

			<form method="post" id="edituser" class="user-forms" action="<?php the_permalink(); ?>">
				
				<table class="form-table">

					<?php $this->member_info_location_inner($current_user); ?>
				
				</tbody></table>
				
				<p class="form-submit">
					<?php echo $referer; ?>
					<input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', ' member-info'); ?>"/>
					<div id="error_message"></div>
					<?php wp_nonce_field( 'update-user' ) ?>
					<input name="action" type="hidden" id="action" value="update-user" />
				</p>

			</form>	
			
			<?php } ?>
			
			<br style="clear:both:">		

		<?php endif;
 	
	} // function
	
}