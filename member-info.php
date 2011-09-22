<?php 

/*
Plugin Name: Member Info
Plugin URI: http://jealousdesigns.com
Description: Adds fields to the user profile page including a location and allows information to be displayed in a variety of ways through the use of widgets.
Version: 0.1
Author: Jealous Designs
*/

register_activation_hook( __FILE__, 'add_installed_option' );

function add_installed_option(){

	update_option('member-info-installed', 'yup');

} // function

register_deactivation_hook(__FILE__, 'remove_installed_option');

function remove_installed_option(){

	delete_option('member-info-installed');

}

if (!defined("MI_url")) { define("MI_url", WP_PLUGIN_URL.'/member-info'); } //NO TRAILING SLASH

if (!defined("MI_dir")) { define("MI_dir", WP_PLUGIN_DIR.'/member-info'); } //NO TRAILING SLASH

if (!defined("SHORTCODE_register")) { define("SHORTCODE_register", 'register_form'); } 

if (!defined("SHORTCODE_account")) { define("SHORTCODE_account", 'member_account'); } 

if (!defined("SHORTCODE_login")) { define("SHORTCODE_login", 'login'); } 

include_once('includes/class-member-info-setup.php'); //Set up

include_once('includes/class-member-info-roles-capabilities.php'); //Custom roles and capabilities

include_once('includes/class-member-info-settings-page.php'); //Settings Page

include_once('includes/class-member-info-meta-boxes.php'); //Meta Boxes

//include_once('includes/class-member-info-shortcodes.php'); //Shortcodes

//include_once('includes/class-member-info-widget.php'); //Widget

include_once('includes/class-member-info-front-end-forms.php'); //Front end registration, log in and profile

include_once('includes/class-member-info-registration.php'); //Registration

include_once('includes/member-info-theme-functions.php'); //Presents functions for use within a theme

?>