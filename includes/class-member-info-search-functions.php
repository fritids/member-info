<?php

new member_info_search_functions;

class member_info_search_functions{

	function member_info_search_functions(){
		$this->__construct();
	}
	
	function __construct(){ 
			
		if(!is_admin()){
	
			add_filter( 'request', array( &$this, 'fix_blank_search_string' ) );
		
			add_filter( 'request', array( &$this, 'advanced_search_queries' ) );
					
		}
			
	}

	function fix_blank_search_string( $query_vars ) {

	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {

	        $query_vars['s'] = ".";

	    }

	    return $query_vars;

	} // function

	
	function advanced_search_queries($query_vars){
	
		if( isset( $_GET['s'] )){
	
			foreach($_GET as $k => $g){
			
				if($k != 'country_region'){
					
					$query_vars['s'] .= ' ' . $g;
					
				}else{
				
					$term = get_term( $g, 'country_region' );
				
					$query_vars['country_region'] = $term->slug;
				
				}
						
			}	
		
		}

		 return $query_vars;
	
	}
	
}

?>