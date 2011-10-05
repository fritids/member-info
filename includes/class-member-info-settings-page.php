<?php

$member_info_settings_page = new member_info_settings_page;

class member_info_settings_page {
	
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
			'Biographical Info', 'The option for the user to add a brief bio about themselves.', 'user_description'
		),
		array(
			'New Password', 'Give the user the ability to change their password.', 'password'
		),
								
	);

	function member_info_settings_page(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_action ('admin_menu', array(&$this, 'add_settings_page_menu' ));
	
	} // function
	
	function add_settings_page_menu(){

		add_options_page('Member Settings', 'Members', 'manage_options', 'mi_settings', array(&$this, 'member_info_settings_page_page') );
			
	} // function
	
	function member_info_settings_page_page(){
	
		if(isset($_POST['submit_member_info'])){
			$this->process_settings_post();
		}
		
		add_meta_box(	'member_info_show_hide_defaults', __('Default Fields'), array( &$this, 'member_info_show_hide_defaults' ), 'Settings', 'normal', 'core');	
			
		add_meta_box(	'member_info_extra_fields', __('Custom Fields'), array( &$this, 'member_info_extra_fields' ), 'Settings', 'normal', 'core');
		
		add_meta_box(	'member_info_other_options', __('Other options'), array( &$this, 'member_info_other_options' ), 'Settings', 'normal', 'core');
				
		wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
		wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );					
		
		?>
		
<!--
		<script type="text/javascript" charset="utf-8">
			//<![CDATA[
			jQuery(document).ready( function($) {
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				postboxes.add_postbox_toggles('Settings');
			});			
			//]]>
		</script>
-->		
	
		<div class="wrap">
			
			<div id="icon-edit" class="icon32 icon32-posts-members"><br></div>
		    
		    <h2>Member Info Settings</h2>
		    	
		    <div id="poststuff">
		    
		    	<form method="POST" action="options-general.php?page=mi_settings">
		    		
		    		<br><br>
		    		
		    		<input type="submit" value="Update Settings" name="submit_member_info" class="button-primary" onClick="submitSettings();"/>
		    		
		    		<br><br>
		    		
					<?php $meta_boxes = do_meta_boxes('Settings', 'normal', null); 
					
					echo do_action( 'member_info_settings', 'var'); ?>
					
					<input type="submit" value="Update Settings" name="submit_member_info" class="button-primary" onClick="submitSettings();"/>
					
				</form>	
				
				<br style="clear:both" />
		
		    </div>
		    
		    <br style="clear:both" />
		    
		</div>
		    
		
	<?php }
	
	function member_info_show_hide_defaults(){ 
	
		$show_defaults = explode( '~', get_option('show_defaults') );
		$required_fields = explode( '~', get_option('required_fields') );
		$reg_fields = explode( '~', get_option('reg_fields') );
		$frontend_fields = explode( '~', get_option('frontend_fields') );
			
		?>
	
		<table id="mi_field_defaults" class="form-table">
		
			<thead>
				<td colspan="2"><!-- Select the default fields on the profile pages to <em>hide</em>. --></td>
				<td align="center"><strong>Hide?</strong></td>
				<td align="center"><strong>Required?</strong></td>
				<td align="center"><strong>Show on registration form?</strong></td>	
				<?php if( get_option('member-info-public-profile-installed') == 'yup'){ ?>
					<td align="center"><strong>Display on user's (public) profile?</strong></td>
				<?php } ?>
			</thead>	
			
			<?php foreach($this->default_fields as $field){ ?>
			
				<tr>
				
					<?php if($field[1] == ''){ ?>
						<td colspan="5">
							<?php echo '<strong>' . $field[0] . '</strong>'; ?>
						</td>
					<?php }else{ ?>
						<td>
							<?php echo $field[0]; ?>
						</td>
						
						<td>
							<?php echo $field[1]; ?>
						</td>
						
						<td align="center">
							<input type="checkbox" <?php if (in_array($field[2], $show_defaults)) { echo ' checked="checked" '; } ?> name="showdefault[]" value="<?php echo $field[2]; ?>" />
						</td>
						
						<td align="center">
							<?php if($field[2] == 'nickname' || $field[2] == 'email'){ ?>
								<input type="hidden" name="required_fields[]" value="<?php echo $field[2]; ?>" />
							<?php }else{?>
								<input type="checkbox" <?php if (in_array($field[2], $required_fields)) { echo ' checked="checked" '; } ?> name="required_fields[]" value="<?php echo $field[2]; ?>" />
							<?php } ?>
						</td>	
						
						<td align="center">
							<?php if($field[2] == 'username' || $field[2] == 'email'){ ?>
								<input type="hidden" name="reg_fields[]" value="<?php echo $field[2]; ?>" />
							<?php }else{?>
								<input type="checkbox" <?php if (in_array($field[2], $reg_fields)) { echo ' checked="checked" '; } ?> name="reg_fields[]" value="<?php echo $field[2]; ?>" />
							<?php } ?>						
						</td>	
						
						<?php if( get_option('member-info-public-profile-installed') == 'yup'){ ?>	
						
							<td align="center">
								<input type="checkbox" <?php if (in_array($field[2], $frontend_fields)) { echo ' checked="checked" '; } ?> name="frontend_fields[]" value="<?php echo $field[2]; ?>" />
							</td>	
						
						<?php } ?>															
						
					<?php } ?>
													
				</tr>	
				
			<?php } ?>																																																		
			
		</table>
	
	<?php }
	
	function member_info_extra_fields(){
	
		$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );
		$fields_desc = explode( ',', get_option('mi_field_desc') );
		$image_limit = explode( ',', get_option('mi_fields_image_limit') );
		$document_limit = explode( ',', get_option('mi_fields_document_limit') );
		$custom_select = explode( ',', get_option('mi_custom_select_option') );
		$custom_checkbox = explode( ',', get_option('mi_custom_checkbox_checkboxes') );
		
		$required_fields = explode( '~', get_option('required_fields') );
		$reg_fields = explode( '~', get_option('reg_fields') );
		$frontend_fields = explode( '~', get_option('frontend_fields') );
	
		?>
		
		<a style="cursor:pointer" onClick="add_field();"><img src="<?php echo MI_url; ?>/img/plus.png" />Add a field.</a>
	
		<table id="mi_fields" class="form-table">
		
			<thead>
				<td><strong>Name</strong></td>
				<td><strong>Type</strong></td>
				<td><strong>Description</strong></td>
				<td align="center"><strong>Required?</strong></td>
				<td align="center"><strong>Show on registration form?</strong></td>
				<?php if( get_option('member-info-public-profile-installed') == 'yup'){ ?>	
					<td align="center">
						<strong>Display on user's (public) profile?</strong>
					</td>
				<?php } ?>					
				<td align="center">     </td>
				<td align="center"></td>
			</thead>
		
			<?php
			$i=0;
			foreach($fields_name as $field_name){
			
				echo 	'<tr id="mi_fields_row' . $i . '">
							<td>
								<input type="text" name="mi_fields_name[]" value="' .  $field_name . '"/>
							</td>
							<td>
								<select name="mi_fields_type[]" class="select_type" onChange="type_select_change(this.value, jQuery(this).parent().parent().attr(\'id\') )">';
									
									do_action( 'extra_fields_options', $fields_type[$i] );
									
									echo '<option ';
									if($fields_type[$i] == 'text'){
										echo "selected";
									}
									echo ' value="text">Text</option>
									<option ';
									if($fields_type[$i] == 'textarea'){
										echo "selected";
									}
									echo ' value="textarea">Text Area</option>
									<option ';
									if($fields_type[$i] == 'address'){
										echo "selected";
									}
									echo ' value="address">Address</option>
									<option ';
									if($fields_type[$i] == 'address_map'){
										echo "selected";
									}
									echo ' value="address_map">Address (including google map)</option>									
									<option ';
									if($fields_type[$i] == 'image'){
										echo "selected";
									}
									echo ' value="image">Image</option>	
									<option ';
									if($fields_type[$i] == 'document'){
										echo "selected";
									}
									echo ' value="document">Document</option>										
									<option ';
									if($fields_type[$i] == 'custom_select'){
										echo "selected";
									}
									echo ' value="custom_select">Custom Select</option>		
									<option ';
									if($fields_type[$i] == 'custom_checkbox'){
										echo "selected";
									}
									echo ' value="custom_checkbox">Custom Checkboxes</option>	
									<option ';
									if($fields_type[$i] == 'dob'){
										echo "selected";
									}
									echo ' value="dob">Date of birth</option>																												
								</select>';
								if($fields_type[$i] == 'image'){
								 	echo '<span class="image_limit"><br>Limit number of images to: <input type="text" size="3" name="mi_fields_image_limit[]" value="' . $image_limit[$i] . '" /></span>';
								}else{
									echo '<span class="image_limit"><input type="hidden" name="mi_fields_image_limit[]" value="0" /></span>';
								}
								if($fields_type[$i] == 'document'){
								 	echo '<span class="document_limit"><br>Limit number of documents to: <input type="text" size="3" name="mi_fields_document_limit[]" value="' . $document_limit[$i] . '" /></span>';
								}else{
									echo '<span class="document_limit"><input type="hidden" name="mi_fields_document_limit[]" value="0" /></span>';
								}								
								if($fields_type[$i] == 'custom_select'){
									$custom_options = explode( ',', get_option('custom_select_option_' . $custom_select[$i]) );
								 	echo '<span class="add_option_button"><br><a style="cursor:pointer;" onClick="add_custom_select(\'mi_fields_row' . $i . '\')"><img src="' . MI_url . '/img/plus.png" width="12" height="12"/>Add an option.</a> <br>(Hint: Type "Other" as an option name and if selected a new text box will appear for the user to type an alternative option.)</span><input type="hidden" name="mi_custom_select_option[]" value="' . $custom_select[$i] . '" class="select_option_identifier"/>';
								 	$ii=0;
								 	foreach($custom_options as $option){
								 		$timestamp = mktime() . $ii;
								 		if($option != ''){
								 			echo '<span class="custom_select ' . $timestamp . '"><br>Option Name: <input type="text" size="10" name="custom_select_option_' . $custom_select[$i] . '[]" value="' . $option . '"/> <a style="cursor:pointer;" onClick="jQuery(\'.' . $timestamp . '\').remove()"><img alt="Delete this option" src="' . MI_url . '/img/delete.png"  style="cursor: pointer; margin-left: 20px;"/></a> </span>';
								 			$ii++;
								 		}
								 	}
								}else{
									echo '<span class="custom_select"><input type="hidden" name="mi_custom_select_option[]" value="0" /></span>';
								}
								if($fields_type[$i] == 'custom_checkbox'){
									$custom_checkboxes = explode( ',', get_option('custom_checkbox_checkboxes_' . $custom_checkbox[$i]) );
								 	echo '<span class="add_checkbox_button"><br><a style="cursor:pointer;" onClick="add_custom_checkbox(\'mi_fields_row' . $i . '\')"><img src="' . MI_url . '/img/plus.png" width="12" height="12"/>Add a checkbox.</a></span><input type="hidden" name="mi_custom_checkbox_checkboxes[]" value="' . $custom_checkbox[$i] . '" class="checkbox_checkbox_identifier"/>';
								 	$ii=0;
								 	foreach($custom_checkboxes as $checkbox){
								 		$timestamp = mktime() . $ii;
								 		if($checkbox != ''){
								 			echo '<span class="custom_checkbox ' . $timestamp . '"><br>Checkbox Name: <input type="text" size="10" name="custom_checkbox_checkboxes_' . $custom_checkbox[$i] . '[]" value="' . $checkbox . '"/> <a style="cursor:pointer;" onClick="jQuery(\'.' . $timestamp . '\').remove()"><img alt="Delete this checkbox" src="' . MI_url . '/img/delete.png"  style="cursor: pointer; margin-left: 20px;"/></a> </span>';
								 			$ii++;
								 		}
								 	}
								}else{
									echo '<span class="custom_checkbox"><input type="hidden" name="mi_custom_checkbox_checkbox[]" value="0" /></span>';
								}																
							echo '</td>
							<td>
								<input type="text" name="mi_fields_desc[]" value="' . $fields_desc[$i] . '"/>
							</td>
							<td align="center">
								<input type="checkbox"';
								if (in_array( 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ), $required_fields)) { echo ' checked="checked" '; }; 
								echo 'name="required_fields[]" value="' . 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ) . '" />
							</td>
							<td align="center">
								<input type="checkbox"';
								if (in_array( 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ), $reg_fields)) { echo ' checked="checked" '; }; 
								echo 'name="reg_fields[]" value="' . 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ) . '"';
								if($fields_type[$i] == 'image'){ echo 'disabled="disabled"'; };
								echo ' />
							</td>';
							if( get_option('member-info-public-profile-installed') == 'yup'){	
								echo '<td align="center">
									<input type="checkbox"';
									if (in_array( 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ), $frontend_fields)) { echo ' checked="checked" '; }; 
									echo 'name="frontend_fields[]" value="' . 'custom_field_' . strtolower( str_replace(' ', '_', $field_name ) ) . '" />
								</td>';
							}	
							echo '<td align="center">
								<a style="cursor:pointer;" onClick="jQuery(\'#mi_fields_row' . $i . '\').remove();"><img src="' . MI_url . '/img/delete.png" style="cursor: pointer; margin-left: 20px;" /></a>
							</td>
							<td class="dragHandle" align="center">
								<img class="handle" src="' . MI_url . '/img/move.png" style="cursor: move; margin-left: 20px;"/>
							</td>
						</tr>';
						
				$i++;
			
			}
			
			?>
		
		</table>	
		
		<script type="text/javascript">
			var i = 500;
			function add_field(){
				jQuery('#mi_fields').append('<tr id="mi_fields_row' + i + '">\
												<td>\
													<input type="text" name="mi_fields_name[]" value=""/>\
												</td>\
												<td>\
													<select name="mi_fields_type[]" class="select_type" onChange="type_select_change(this.value, jQuery(this).parent().parent().attr(\'id\'))">\
														<?php
														do_action( 'extra_fields_options_js' );
														?>
														<option value="text">Text</option>\
														<option value="textarea">Text Area</option>\
														<option value="address">Address</option>\
														<option value="address_map">Address (including google map)</option>\
														<option value="image">Image</option>\
														<option value="document">Document</option>\
														<option value="custom_select">Custom Select</option>\
														<option value="custom_checkbox">Custom Checkboxes</option>\
														<option value="dob">Date of birth</option>\
													</select>\
												</td>\
												<td>\
													<input type="text" name="mi_fields_desc[]" value=""/>\
												</td>\
												<td align="center" colspan="2">\
													Add required and registration options after updating.\
												</td>\
												<td align="center">\
													<a style="cursor:pointer;" onClick="jQuery(\'#mi_fields_row' + i + '\').remove();"><img src="<?php echo MI_url; ?>/img/delete.png"  style="cursor: pointer; margin-left: 20px;"/></a>\
												</td>\
												<td class="dragHandle" align="center">\
													<img class="handle" src="<?php echo MI_url; ?>/img/move.png" style="cursor: move; margin-left: 20px;"/>\
												</td>\
											</tr>');
				i++;
			}
		</script>
		<?php
	
	}
	
	function process_settings_post(){
	
		$fields_name="";
		
		if(!empty($_POST['mi_fields_name'])){
		
			foreach($_POST['mi_fields_name'] as $field_name){
			
				if($fields_name == ""){
					$fields_name .= $field_name;
				}else{
					$fields_name .= ',' . $field_name;
				}
			
			}
		
			if(update_option('mi_field_name', $fields_name)){
				$updated = TRUE;
			}
			
		}
		
		$fields_type="";
		
		if(!empty($_POST['mi_fields_type'])){
		
			foreach($_POST['mi_fields_type'] as $field_type){
			
				if($fields_type == ""){
					$fields_type .= $field_type;
				}else{
					$fields_type .= ',' . $field_type;
				}
			
			}
			
			if(update_option('mi_field_type', $fields_type)){
				$updated = TRUE;
			}
		
		}
		
		$fields_desc="";
		
		if(!empty($_POST['mi_fields_desc'])){
		
			foreach($_POST['mi_fields_desc'] as $field_desc){
			
				if($fields_desc == ""){
					$fields_desc .= $field_desc;
				}else{
					$fields_desc .= ',' . $field_desc;
				}
			
			}
			
			if(update_option('mi_field_desc', $fields_desc)){
				$updated = TRUE;
			}
		
		}
		
		$fields_custom_select="";
		
		if(!empty($_POST['mi_custom_select_option'])){
		
			foreach($_POST['mi_custom_select_option'] as $field_select){
			
				if($fields_custom_select == ""){
					$fields_custom_select .= $field_select;
				}else{
					$fields_custom_select .= ',' . $field_select;
				}
				
				$custom_option = "";
				
				if($_POST['custom_select_option_' . $field_select] != ''){

					foreach($_POST['custom_select_option_' . $field_select] as $option){
					
						if($fields_custom_select == ""){
							$custom_option .= $option;
						}else{
							$custom_option .= ',' . $option;
						}				
					
					}
				
					if(update_option('custom_select_option_' . $field_select, $custom_option)){
						$updated = TRUE;
					}	
				
				}								
			
			}
			
			if(update_option('mi_custom_select_option', $fields_custom_select)){
				$updated = TRUE;
			}
		
		}	
		
		$fields_custom_checkbox="";
		
		if(!empty($_POST['mi_custom_checkbox_checkboxes'])){
		
			foreach($_POST['mi_custom_checkbox_checkboxes'] as $field_checkbox){
			
				if($fields_custom_checkbox == ""){
					$fields_custom_checkbox .= $field_checkbox;
				}else{
					$fields_custom_checkbox .= ',' . $field_checkbox;
				}
				
				$custom_checkbox = "";
				
				if($_POST['custom_checkbox_checkboxes_' . $field_checkbox] != ''){

					foreach($_POST['custom_checkbox_checkboxes_' . $field_checkbox] as $checkbox){
					
						if($custom_checkbox == ""){
							$custom_checkbox .= $checkbox;
						}else{
							$custom_checkbox .= ',' . $checkbox;
						}				
					
					}
				
					if(update_option('custom_checkbox_checkboxes_' . $field_checkbox, $custom_checkbox)){
						$updated = TRUE;
					}	
				
				}								
			
			}
			
			if(update_option('mi_custom_checkbox_checkboxes', $fields_custom_checkbox)){
				$updated = TRUE;
			}
		
		}				
		
		if(update_option('mi_display_method', $_POST['mi_display_method'])){
			$updated = TRUE;
		}
		
		$image_limits = '';
		
		if(!empty($_POST['mi_fields_image_limit'])){
		
			foreach($_POST['mi_fields_image_limit'] as $image_limit){
			
				if($image_limits == ""){
					$image_limits .= $image_limit;
				}else{
					$image_limits .= ',' . $image_limit;
				}
			
			}
			
			if(update_option('mi_fields_image_limit', $image_limits)){
				$updated = TRUE;
			}
		
		}
		
		$document_limits = '';
		
		if(!empty($_POST['mi_fields_document_limit'])){
		
			foreach($_POST['mi_fields_document_limit'] as $document_limit){
			
				if($document_limits == ""){
					$document_limits .= $document_limit;
				}else{
					$document_limits .= ',' . $document_limit;
				}
			
			}
			
			if(update_option('mi_fields_document_limit', $document_limits)){
				$updated = TRUE;
			}
		
		}		
		
		if(update_option('mi_display_method', $_POST['mi_display_method'])){
			$updated = TRUE;
		}
		
		$show = '';
		
		if($_POST['showdefault']){
		
			foreach($_POST['showdefault'] as $default_field){
			
				$show .= '~' . $default_field;
			
			}
		
		}
		
		if(update_option('show_defaults', $show)){
			$updated = TRUE;
		}
		
		$required = '';
		
		if($_POST['required_fields']){
		
			foreach($_POST['required_fields'] as $required_field){
			
				$required .= '~' . $required_field;
			
			}
		
		}
		
		if(update_option('required_fields', $required)){
			$updated = TRUE;
		}
		
		$reg = '';
		
		if($_POST['reg_fields']){
		
			foreach($_POST['reg_fields'] as $reg_field){
			
				$reg .= '~' . $reg_field;
			
			}
		
		}
		
		if(update_option('reg_fields', $reg)){
			$updated = TRUE;
		}
		
		$fe = '';
		
		if($_POST['frontend_fields']){
		
			foreach($_POST['frontend_fields'] as $fe_field){
			
				$fe .= '~' . $fe_field;
			
			}
		
		}
		
		if(update_option('frontend_fields', $fe)){
			$updated = TRUE;
		}
		
		if($_POST['mi_reg_recaptcha']){
		
			if(update_option('mi_reg_recaptcha', $_POST['mi_reg_recaptcha'])){
				$updated = TRUE;
			}
		
		}			
		
		do_action('save_member_info_settings', $updated);					
		
		if($updated){
			echo '<div id="message" class="updated">Settings Updated!</div>';
		}
				
	} // function
	
	function member_info_other_options(){
	
		?>
		<table class="form-table">
		
			<tr>
			
				<td>
		
					<span class="member_info_label">Display reCaptcha on registration form?</span>
					<select name="mi_reg_recaptcha">
						<option value="yes" <?php if(get_option('mi_reg_recaptcha') == 'yes'){ echo 'selected'; } ?>>Yes</option>
						<option value="no" <?php if(get_option('mi_reg_recaptcha') == 'no'){ echo 'selected'; } ?>>No</option>
					</select>
					
				</td>
		
			</tr>					
					
			<tr>
			
				<td>
				
					<span class="description">
					</span>
					
				</td>
		
			</tr>
		
		</table>
		
		<?php
	
	}
	
}