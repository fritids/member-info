<?php

new member_info_widget;

class member_info_widget extends member_info_shortcodes {

	function member_info_widget(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_action('plugins_loaded', array(&$this, 'member_info_register_widgets' ));
	
	} // function
	
	function member_info_register_widgets(){
	
		register_sidebar_widget(__('Member Info (list view)'), array(&$this, 'display_list' ));
		
		register_sidebar_widget(__('Member Info (dropdown view)'), array(&$this, 'display_dropdown' ));
		
		register_sidebar_widget(__('Member Info (countries view)'), array(&$this, 'display_countries' ));
		
		register_sidebar_widget(__('Member Info (map view)'), array(&$this, 'display_map' ));
		
			register_widget_control(   'Member Info (map view)', array(&$this, 'member_info_map_widget_controls'), 300, 200 );
	
	} // function
	
	function member_info_map_widget_controls(){
	
		if(isset($_POST['mi_widget_map_width'])){
		
			update_option('mi_widget_map_width', $_POST['mi_widget_map_width']);
			
			update_option('mi_widget_map_height', $_POST['mi_widget_map_height']);
			
			update_option('mi_widget_map_img', $_POST['mi_widget_map_img']);
		
		}
	
		?>
		<span class="member_info_label">Width: </span><input type="text" name="mi_widget_map_width" value="<?php echo get_option('mi_widget_map_width'); ?>" /><br>
		<span class="member_info_label">Height: </span><input type="text" name="mi_widget_map_height" value="<?php echo get_option('mi_widget_map_height'); ?>" /><br>
		<span class="member_info_label">Show Images?: </span><select name="mi_widget_map_img"><option value="true" <?php if(get_option('mi_widget_map_img') == 'true'){echo 'selected';} ?>>True</option><option value="false" <?php if(get_option('mi_widget_map_img') == 'false'){echo 'selected';} ?>>False</option></select>
		<?php
	
	} // function
	
}

?>