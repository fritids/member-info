<?php

class member_info_default_fields{

	function member_info_default_fields(){
	
		$this->__construct();
	
	} // function
	
	function __construct(){
	
	
	
	}//
	
	function visual_editor($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th scope="row"><label for="visual_editor"><?php echo $field; ?></label></th>
			<td><label for="rich_editing"><input class="input" name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php if(get_the_author_meta( 'rich_editing', $current_user->id ) == 'false'){ echo " checked=\checked\" "; }; ?>> Disable the visual editor when writing</label></td>
		</tr>		
		
		<?php
	
	} // function
	
	function keyboard_shortcuts($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th scope="row"><label for="keyboard_shortcuts"><?php echo $field; ?></label></th>
		
			<td>
				<label for="comment_shortcuts">
				<input class="input" type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if(get_the_author_meta( 'comment_shortcuts', $current_user->id ) == 'true'){ echo " checked=\"checked\" "; }; ?>> Enable keyboard shortcuts for comment moderation.</label> <a href="http://codex.wordpress.org/Keyboard_Shortcuts" target="_blank">More information</a>
			</td>
		
		</tr>
		
		<?php
	
	} // function
	
	function admin_color_scheme($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
		<th scope="row"><label for="admin_color_scheme"><?php echo $field; ?></label></th>
		<td>
			<fieldset>
				<legend class="screen-reader-text"><span><?php echo $field; ?></span></legend>
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
		
		<?php
	
	} // function
				
	function show_admin_bar($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
			<tr class="show-admin-bar">
			<th scope="row"><label for="show_admin_bar"><?php echo $field; ?></label></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $field; ?></span></legend>
					<label for="admin_bar_front">
					<input class="input" name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1" <?php if($current_user->show_admin_bar_front  == 'true'){ echo " checked=\"checked\" "; }; ?>>
					when viewing site</label><br>
					<label for="admin_bar_admin">
					<input class="input" name="admin_bar_admin" type="checkbox" id="admin_bar_admin" value="1" <?php if($current_user->show_admin_bar_admin == 'true'){ echo " checked=\"checked\" "; }; ?>>
					in dashboard</label>
				</fieldset>
			</td>
		</tr>
	
		<?php
	
	} // function
				
	function username($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="user_login"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="user_login" id="user_login" value="<?php the_author_meta( 'user_login', $current_user->id ); ?>" disabled="disabled" class="regular-text"> <span class="description">Usernames cannot be changed.</span></td>
		</tr>		

		<?php
	
	} // function
				
	function first_name($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="first_name"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="first_name" id="first_name" value="<?php the_author_meta( 'first_name', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function last_name($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="last_name"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="last_name" id="last_name" value="<?php the_author_meta( 'last_name', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function nickname($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="nickname"><?php echo $field; ?> <span class="description">(required)</span></label></th>
			<td><input class="input" type="text" name="nickname" id="nickname" value="<?php the_author_meta( 'nickname', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function display_name_publicly($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="display_name"><?php echo $field; ?></label></th>
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
		
		<?php
	
	} // function
				
	function email($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="email"><?php echo $field; ?> <span class="description">(required)</span></label></th>
			<td><input class="input" type="text" name="email" id="email" value="<?php the_author_meta( 'email', $current_user->id ); ?>" class="regular-text">
				</td>
		</tr>		
		
		<?php
	
	} // function
				
	function website($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="url" id="url" value="<?php the_author_meta( 'url', $current_user->id ); ?>" class="regular-text code"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function aim($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="aim"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="aim" id="aim" value="<?php the_author_meta( 'aim', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function yahoo_im($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="yim">Yahoo IM</label></th>
			<td><input class="input" type="text" name="yim" id="yim" value="<?php the_author_meta( 'yim', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function jabber_google_talk($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="jabber"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="jabber" id="jabber" value="<?php the_author_meta( 'jabber', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function twitter($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="twitter_url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="twitter_url" id="twitter_url" value="<?php the_author_meta( 'twitter_url', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function facebook($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="facebook_url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="facebook_url" id="facebook_url" value="<?php the_author_meta( 'facebook_url', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function youtube($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
	
		<tr>
			<th><label for="youtube_url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="youtube_url" id="youtube_url" value="<?php the_author_meta( 'youtube_url', $current_user->id ); ?>" class="regular-text"></td>
		</tr>
				
		<?php
	
	} // function
				
	function linkedin($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="linkedin_url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="linkedin_url" id="linkedin_url" value="<?php the_author_meta( 'linkedin_url', $current_user->id ); ?>" class="regular-text"></td>
		</tr>	
		
		<?php
	
	} // function
				
	function sound_cloud($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="soundcloud_url"><?php echo $field; ?></label></th>
			<td><input class="input" type="text" name="soundcloud_url" id="soundcloud_url" value="<?php the_author_meta( 'soundcloud_url', $current_user->id ); ?>" class="regular-text"></td>
		</tr>		
		
		<?php
	
	} // function
				
	function user_description($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
	
		?>
		
		<tr>
			<th><label for="description"><?php echo $field; ?></label></th>
			<td><textarea name="description" class="wysiwyg" id="description" rows="5" cols="30"><?php echo stripslashes( get_the_author_meta( 'description', $current_user->id ) ) ; ?></textarea><br>
			<span class="description">Share a little biographical information to fill out your profile. This may be shown publicly.</span></td>
		</tr>		
		
		<?php
	
	} // function
				
	function password($type, $field, $sanitized_field, $fields_desc, $user_id){
	
		global $current_user;
		
		?>
		
		<tr id="password">
			<th><label for="pass1"><?php echo $field; ?></label></th>
			<td><input class="input" type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off"> <span class="description">If you would like to change the password type a new one. Otherwise leave this blank.</span><br>
				<input class="input" type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off"> <span class="description">Type your new password again.</span><br>
				<div id="pass-strength-result" style="display: block; ">Strength indicator</div>
				<p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>
			</td>
		</tr>		
		
		<?php
	
	
	} // function
	
}

class member_info_default_fields_for_reg_form{

	function member_info_default_fields_for_reg_form(){
	
		$this->__construct();
	
	} // function
	
	function __construct(){
	
	
	
	}//
	
	function visual_editor( $field ){
	
		global $current_user;
	
		?>
		
		<input class="input" name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php if(get_the_author_meta( 'rich_editing', $current_user->id ) == 'false'){ echo " checked=\checked\" "; }; ?>>
		
		<?php
	
	} // function
	
	function keyboard_shortcuts( $field ){
	
		global $current_user;
	
		?>
		
		<input class="input" type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if(get_the_author_meta( 'comment_shortcuts', $current_user->id ) == 'true'){ echo " checked=\"checked\" "; }; ?>>
			 
		
		<?php
	
	} // function
	
	function admin_color_scheme( $field ){
	
		global $current_user;
	
		?>
			<fieldset>
				<legend class="screen-reader-text"><span><?php echo $field; ?></span></legend>
				<div class="color-option">
					<input class="input" name="admin_color" id="admin_color_classic" type="radio" value="classic" class="tog" <?php if(get_the_author_meta( 'admin_color', $current_user->id ) == 'classic'){ echo " checked=\"checked\" "; }; ?>>
					<table class="color-palette">
					<tbody> 
						<td style="background-color: #5589aa" title="classic">&nbsp; 
						<td style="background-color: #cfdfe9" title="classic">&nbsp; 
						<td style="background-color: #d1e5ee" title="classic">&nbsp; 
						<td style="background-color: #eff8ff" title="classic">&nbsp; 
						 
					</tbody></table>
				
					 Blue</label>
				</div>
				<div class="color-option">
					<input class="input" name="admin_color" id="admin_color_fresh" type="radio" value="fresh" class="tog" <?php if(get_the_author_meta( 'admin_color', $current_user->id ) == 'fresh'){ echo " checked=\"checked\" "; }; ?>>
					<table class="color-palette">
					<tbody> 
						<td style="background-color: #7c7976" title="fresh">&nbsp; 
						<td style="background-color: #c6c6c6" title="fresh">&nbsp; 
						<td style="background-color: #e0e0e0" title="fresh">&nbsp; 
						<td style="background-color: #f1f1f1" title="fresh">&nbsp; 
						 
					</tbody></table>
				
					 Gray</label>
				</div>
			</fieldset>	
		
		<?php
	
	} // function
				
	function show_admin_bar( $field ){
	
		global $current_user;
	
		?>
				<fieldset>
					<legend class="screen-reader-text"><span><?php echo $field; ?></span></legend>
					 
					<input class="input" name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1" <?php if($current_user->show_admin_bar_front  == 'true'){ echo " checked=\"checked\" "; }; ?>>
					when viewing site</label><br>
					 
					<input class="input" name="admin_bar_admin" type="checkbox" id="admin_bar_admin" value="1" <?php if($current_user->show_admin_bar_admin == 'true'){ echo " checked=\"checked\" "; }; ?>>
					in dashboard</label>
				</fieldset>
	
		<?php
	
	} // function
				
	function username( $field ){
	
		global $current_user;
	
		?>			 
		<input class="input" type="text" name="user_login" id="user_login" value="<?php the_author_meta( 'user_login', $current_user->id ); ?>" class="regular-text">

		<?php
	
	} // function
				
	function first_name( $field ){
	
		global $current_user;
	
		?>
			 
		<input class="input" type="text" name="first_name" id="first_name" value="<?php the_author_meta( 'first_name', $current_user->id ); ?>" class="regular-text">		
		
		<?php
	
	} // function
				
	function last_name( $field ){
	
		global $current_user;
	
		?>
				 
		<input class="input" type="text" name="last_name" id="last_name" value="<?php the_author_meta( 'last_name', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function nickname( $field ){
	
		global $current_user;
	
		?>
			 
			 <input class="input" type="text" name="nickname" id="nickname" value="<?php the_author_meta( 'nickname', $current_user->id ); ?>" class="regular-text"> 
		 		
		<?php
	
	} // function
				
	function display_name_publicly( $field ){
	
		global $current_user;
	
		?>
					 
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
			 
		 		
		
		<?php
	
	} // function
				
	function email( $field ){
	
		global $current_user;
	
		?>
					 
			 <input class="input" type="text" name="email" id="email" value="<?php the_author_meta( 'email', $current_user->id ); ?>" class="regular-text">
				 
		<?php
	
	} // function
				
	function website( $field ){
	
		global $current_user;
	
		?>
		
			 <input class="input" type="text" name="url" id="url" value="<?php the_author_meta( 'url', $current_user->id ); ?>" class="regular-text code"> 	
		
		<?php
	
	} // function
				
	function aim( $field ){
	
		global $current_user;
	
		?>
		
			 <input class="input" type="text" name="aim" id="aim" value="<?php the_author_meta( 'aim', $current_user->id ); ?>" class="regular-text"> 
		 		
		
		<?php
	
	} // function
				
	function yahoo_im( $field ){
	
		global $current_user;
	
		?>
		
			<input class="input" type="text" name="yim" id="yim" value="<?php the_author_meta( 'yim', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function jabber_google_talk( $field ){
	
		global $current_user;
	
		?>
			 
			<input class="input" type="text" name="jabber" id="jabber" value="<?php the_author_meta( 'jabber', $current_user->id ); ?>" class="regular-text"></td>
		
		<?php
	
	} // function
				
	function twitter( $field ){
	
		global $current_user;
	
		?>
			 
			<input class="input" type="text" name="twitter_url" id="twitter_url" value="<?php the_author_meta( 'twitter_url', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function facebook( $field ){
	
		global $current_user;
	
		?>
					 
			<input class="input" type="text" name="facebook_url" id="facebook_url" value="<?php the_author_meta( 'facebook_url', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function youtube( $field ){
	
		global $current_user;
	
		?>
				 
			<input class="input" type="text" name="youtube_url" id="youtube_url" value="<?php the_author_meta( 'youtube_url', $current_user->id ); ?>" class="regular-text">
				
		<?php
	
	} // function
				
	function linkedin( $field ){
	
		global $current_user;
	
		?>
					 
			<input class="input" type="text" name="linkedin_url" id="linkedin_url" value="<?php the_author_meta( 'linkedin_url', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function sound_cloud( $field ){
	
		global $current_user;
	
		?>
					 
			<input class="input" type="text" name="soundcloud_url" id="soundcloud_url" value="<?php the_author_meta( 'soundcloud_url', $current_user->id ); ?>" class="regular-text">
		
		<?php
	
	} // function
				
	function user_description( $field ){
	
		global $current_user;
	
		?>			 
				<textarea name="description" class="wysiwyg" id="description" rows="5" cols="30"><?php echo stripslashes( get_the_author_meta( 'description', $current_user->id ) ) ; ?></textarea>
		
		<?php
	
	} // function
				
	function password( $field ){
	
		global $current_user;
		
		?>
			 
			<input class="input" type="password" name="pass1" id="pass1" size="16" value="" autocomplete="off">  <br>
				<input class="input" type="password" name="pass2" id="pass2" size="16" value="" autocomplete="off">  <br>
				<div id="pass-strength-result" style="display: block; ">Strength indicator</div>
				<p class="description indicator-hint">Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ &amp; ).</p>
		
		<?php
	
	
	} // function
	
}

?>