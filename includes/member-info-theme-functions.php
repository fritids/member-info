<?php

function get_profile_page_url(){ //return the profile page url (dependant on the profile page being present in the first page)

	return get_permalink( get_option('profile_page_id') );

}

function profile_page_url(){ //echo the profile page url (dependant on the profile page being present in the first page)

	echo get_permalink( get_option('profile_page_id') );

}

?>