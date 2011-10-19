<?php

new member_info_meta_boxes;

class member_info_meta_boxes {

	function member_info_meta_boxes(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
/*
		add_action( 'admin_init', array( &$this, 'member_info_custom_meta_boxes'), 1 );
		
		add_action( 'save_post', array( &$this, 'member_info_save_postdata') );	
*/
		
		add_action( 'show_user_profile', array( &$this, 'member_info_location_inner' ), 10  );

		add_action( 'edit_user_profile', array( &$this, 'member_info_location_inner' ), 10  );
		
		add_action( 'personal_options_update', array( &$this, 'member_info_save_member_data' ) );

		add_action( 'edit_user_profile_update', array( &$this, 'member_info_save_member_data' ) );
	
	}
	
	function member_info_save_member_data($user_id){
	
		if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    	
    	$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );
															
		$mi_meta['lng'] =  $_POST['lng'] ;
		$mi_meta['lat'] =  $_POST['lat'] ;
		$mi_meta['general_location'] =  $_POST['general_location'] ;
		$mi_meta['show_map'] =  $_POST['show_map'] ;
		$mi_meta['map_width'] =  $_POST['map_width'] ;
		$mi_meta['map_height'] =  $_POST['map_height'] ;
		$mi_meta['mi_location'] =  $_POST['mi_location'] ;
		
		$i=0;
		foreach($fields_name as $field){
		
			$mi_meta[strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )] =  $_POST[strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )] ;
			do_action( 'pre_member_info_save_member_data', $fields_type[$i], $_POST[strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) )], $user_id );
			$i++;
			
		} 
		
	    foreach ($mi_meta as $key => $value) { 
	    	
	        $value = implode(',', (array)$value); 
	       	update_usermeta( $user_id, $key, $value );
    			        
	    }
	    //echo "Refreshing your profile...";
	    
	
	} //function	
	
	function member_info_location_inner($user){
	
		$user_info = get_userdata($user->ID);

		$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );
		$fields_desc = explode( ',', get_option('mi_field_desc') );
		$image_limit = explode( ',', get_option('mi_fields_image_limit') );
		$document_limit = explode( ',', get_option('mi_fields_document_limit') );
		$document_type = explode( ',', get_option('mi_fields_document_type') );
		$custom_select = explode( ',', get_option('mi_custom_select_option') );
		
		$i = 0;
		
		echo '<h3>Other Info</h3>';
		
		echo '<table class="form-table">';
		
			foreach($fields_name as $field){
			
				$sanitized_field = strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9 ]", "", $field) ) );
				
				do_action( 'front_end_display_fields', $fields_type[$i], $field, $sanitized_field, $fields_desc[$i]); 
			
				switch ($fields_type[$i]){
					case 'text':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>
									<input class="input" type="text" id="custom_field_' . $sanitized_field . '" name="' . $sanitized_field . '" value="' . $user_info->$sanitized_field . '"/>
									<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';
					break;
					case 'textarea':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>
									<textarea class="input wysiwyg" id="custom_field_' . $sanitized_field . '" name="' . $sanitized_field . '">
										' . $user_info->$sanitized_field . '
									</textarea>
									<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';							
					break;
					case 'address':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';
									$this->show_map($sanitized_field, $user->ID, 'no');
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';							
					break;	
					case 'address_map':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';
									$this->show_map($sanitized_field , $user->ID);
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';							
					break;						
					case 'image':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';
									$this->member_image($sanitized_field, $user->ID, $image_limit[$i]);
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';							
					break;	
					case 'document':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';
									$this->member_document($sanitized_field, $user->ID, $document_limit[$i], $document_type[$i]);
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';							
					break;	
					case 'custom_select';
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';					
									$custom_options = explode( ',', get_option('custom_select_option_' . $custom_select[$i]) );
								 	echo '<select class="input custom_select" onChange="check_other();" id="custom_field_' . $sanitized_field . '" name="' . $sanitized_field . '" >';
								 	foreach($custom_options as $option){
								 		$timestamp = mktime() . $ii;
								 		if($option != ''){
								 			echo '<option';
								 			if( ( strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $option) ) ) == $user_info->$sanitized_field ) || ( strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $option) ) ) == 'other' && !$matched ) ){
								 				echo ' selected="selected"';
								 				if(strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $option) ) ) != 'other'){
								 					$matched = true;
								 				}
								 			}
								 			echo ' value="' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $option) ) ) . '" >' . $option . '</option>';
								 		}
								 	}
								 	echo '</select>';	
								 	if(!$matched){
								 		echo '<input class="input other_option" type="text" name="' . $sanitized_field . '" value="' . $user_info->$sanitized_field . '" />';
								 	}
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';		
					break;	
					case 'custom_checkbox';
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>';					
									$custom_checkboxes = explode( ',', get_option('custom_checkbox_checkboxes_' . $custom_checkbox[$i]) );
								 	
								 	foreach($custom_checkboxes as $checkbox){
								 		$timestamp = mktime() . $ii;
								 		if($checkbox != ''){
								 			echo '<span class="checkbox">';
								 			echo '<input type="checkbox" id="custom_field_' . $sanitized_field . '" name="' . $sanitized_field . '[]" ';
								 			$checkboxes_values = explode(',', $user_info->$sanitized_field);
								 			if(in_array(strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $checkbox) ) ), $checkboxes_values) ){
								 				echo ' checked="checked"';
								 			}
								 			echo ' value="' . strtolower( str_replace(' ', '_', ereg_replace("[^A-Za-z0-9]", "", $checkbox) ) ) . '">' . $checkbox;
								 			echo '</span>';
								 		}
								 	}
									echo '<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';	
					break;
					case 'dob':
						echo '<tr>
								<th><label for="' .$field. '">' .$field. '</label</th>
								<a name="custom_field_' . $sanitized_field . '"></a>
								<td>
									<input class="input dob" type="text" id="custom_field_' . $sanitized_field . '" name="' . $sanitized_field . '" value="' . $user_info->$sanitized_field . '"/>
									<span class="description">
										' . $fields_desc[$i] . '
									</span>
								</td>
							</tr>';
					break;								 																			
			
				}
								
				$i++;
				
			}
		
		echo '</table>';
		
		//wp_nonce_field('mi_product_meta_nonce', 'mi_product_meta_nonce'); 
		
	} //function
	
	function show_map($name, $id=0, $show_map = 'yes'){
	
		$user_info = get_userdata($id);
		
		?>
	
		<input type="text" class="input" name="mi_location" id="member_info_location" value="<?php echo $user_info->mi_location; ?>" />
		<input type="button" class="button-primary button" value="Lookup" onClick="codeAddress('YES')" />
		<br>
		<span class="description" style="float: left;">
			Enter a location in any format and click the "Lookup" button.
		</span>
		<?php if($show_map == 'yes'){ ?>
			<br>
			<br>
			<div id="map_canvas" style="float:left; width:60%; height:400px; margin-right: 10px;">
			</div>
		<?php } ?>	
		<div style="width: 35%;float:left;clear:left;" id="didyoumean">
		</div>
		<br style="clear:both;">
		<br>
		<br>
		<!-- <span class="member_info_label">Address: <br><br>(Will be filled in with a location you select from the google map above.)</span>  -->
		<textarea name="<?php echo $name; ?>" id="member_info_address" cols="30" rows="9" class="input custom_field_<?php echo $name; ?>" ><?php echo $user_info->$name; ?></textarea>
		<br style="clear:both;">
		<input type="hidden" name="lng" id="lng" value="<?php echo $user_info->lng; ?>" />
		<input type="hidden" name="lat" id="lat" value="<?php echo $user_info->lat; ?>" />
		<input type="hidden" name="general_location" id="general_location" value="<?php echo $user_info->general_location; ?>" />
<!--
		<span class="member_info_label">Show Map?</span>
		<select name="show_map" onChange="show_hide_map_sizes()" id="mi_show_map">
			<option value="true" <?php if($user_info->show_map == 'true'){ echo 'selected'; } ?>>True</option>
			<option value="false" <?php if($user_info->show_map == 'false'){ echo 'selected'; } ?>>False</option>
		</select>
		<span class="description">
			Show a map of the member's location?
		</span>
		<div id="mi_map_sizes">
			<br>
			<span class="member_info_label">Map width: </span><input type="text" name="map_width" value="<?php echo $user_info->map_width; ?>" /><br>
			<span class="member_info_label">Map height: </span><input type="text" name="map_height" value="<?php echo $user_info->map_height; ?>" />
		</div>
-->
		<?php
	
	} // function
	
	function member_image($name, $id, $image_limit){
	
		$user_info = get_userdata($id);
	
		?>
		<input type="hidden" id="image_limit" value="<?php echo $image_limit; ?>"/>
		<input type="hidden" id="upload_image" name="<?php echo $name; ?>" value="<?php echo $user_info->$name; ?>"  class="custom_field_<?php echo $name; ?>"/>
		<input type="button" id="mi_upload_image_button" value="Upload an image" class="button" />
		<br><!-- <span class="member_info_label"> Current Image: </span> -->
		<div id="mi_images">
			<?php
			$images = explode( '~', $user_info->$name );
			$i = 0;
			while($i <= $image_limit -1){
				if($images[$i] != ''){
					echo '<div><img class="mi_uploaded_img" src="' . $images[$i] . '" /><br><img style="cursor:pointer;" onClick="deleteImage(\'' . $images[$i] . '\');" src="' . MI_url . '/img/delete.png" class="delete_image" /></div>';
				}else{
					echo '<div><img class="mi_image" src="' . MI_url . '/img/profile_pic.png" /></div>';
				}
				$i++;
			}
			?>
		</div>
		<br style="clear:both;">
		<?php
	
	}
	
	function member_document($name, $id, $document_limit, $document_type){
	
		$user_info = get_userdata($id);
	
		?>
		<input type="hidden" id="document_limit" value="<?php echo $document_limit; ?>"/>
		<input type="hidden" id="document_type" value="<?php echo $document_type; ?>"/>
		<?php
			$limit_docs = explode( '~', $user_info->$name );
			$ii = 0;
			$user_info->$name = '';
			while($ii <= $document_limit -1){
				$user_info->$name .= $limit_docs[$ii]  . '~';
				$ii++;
			}
			
		?>
		<input type="hidden" id="upload_document" name="<?php echo $name; ?>" value="<?php echo $user_info->$name; ?>"  class="custom_field_<?php echo $name; ?>"/>
		<input type="button" id="mi_upload_document_button" value="Upload a document" class="button" rel="<?php echo $document_type; ?>"/>
		<br><!-- <span class="member_info_label"> Current document: </span> -->
		<div id="mi_documents">
			<?php
			$documents = explode( '~', $user_info->$name );
			$i = 0;
			while($i <= $document_limit -1){
				if($documents[$i] != ''){
					$document = explode( '=', $documents[$i] );
					echo '<div class="single_row" title="' . $document[0] . '"><div class="mi_uploaded_doc" >' . $document[1] . '</div><img style="cursor:pointer;" onClick="deleteDocument(\'' . $document[0] . '\', \'' . $document[1] . '\');" src="' . MI_url . '/img/delete.png" class="delete_document" /></div>';
				}else{
					echo '<div class="single_row"><img class="mi_document" src="' . MI_url . '/img/file.png" /></div>';
				}
				$i++;
			}
			?>
		</div>
		<br style="clear:both;">
		<?php
	
	}	

}