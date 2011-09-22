<?php

new member_info_shortcodes;

class member_info_shortcodes {

	function member_info_shortcodes(){
	
		$this->__construct();
		
	} // function
	
	function __construct(){
	
		add_shortcode( 'member_info', array( &$this, 'member_info_display' ) );
		
		add_shortcode( 'member', array( &$this, 'member_info' ) );
	
	} // function
	
	function member_info($atts){
	
		extract( shortcode_atts( array(
			'id' => '1',
		), $atts ) );	
	
		$id = $atts['id'];
		
		$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );		
		
		$args=array(
		  //'genre' => 'mystery',
		  'post_type' => 'members',
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'caller_get_posts'=> 1,
		  'p' => $id
		);
		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			$i=0;
			foreach($fields_name as $field){
				if($fields_type[$i] == 'image'){
					echo '<img class="member_info" id="' . $field . '"  src="' . str_replace("\r\n", "<br>", get_post_meta($id, str_replace(' ', '', $field), true) ) . '" /><br>';
				}elseif($fields_type[$i] == 'address_map' && get_post_meta($id, 'show_map', true) == 'true'){
				
					$this->display_map(get_post_meta($id, 'map_width', true), get_post_meta($id, 'map_height', true), $id);
					
					echo '<p class="member_info" id="' . $field . '" ><span class="member_info_label">' . $field . ': </span>' . str_replace("\r\n", "<br>", get_post_meta($id, str_replace(' ', '', $field), true) ) . '</p>';
					
				}else{
					
					echo '<p class="member_info" id="' . $field . '" ><span class="member_info_label">' . $field . ': </span>' . str_replace("\r\n", "<br>", get_post_meta($id, str_replace(' ', '', $field), true) ) . '</p>';
					
				}
			$i++;
			}
		}
		wp_reset_query();		
	
	} // function
	
	function member_info_display($atts){

		extract( shortcode_atts( array(
			'display' => 'all',
			'type' => 'list',
		), $atts ) );
			
		switch ($atts['type']){
			case 'list':
				$this->display_list();
			break;
			case 'dropdown':
				$this->display_dropdown();
			break;
			case 'countries':
				$this->display_countries();
			break;
			case 'map':
				$this->display_map($atts['width'], $atts['height']);
			break;			
			default:
				$this->display_list();
		} 
			
	} // function
	
	function display_list(){
	
		$args=array(
		  //'genre' => 'mystery',
		  'post_type' => 'members',
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'caller_get_posts'=> 1
		);
		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			?><ul><?php
		  		while ($my_query->have_posts()) : $my_query->the_post(); ?>
		    		<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
		    		<?php
		  		endwhile;
		  	?></ul><?php
		}
		wp_reset_query();  // Restore global post data stomped by the_post().	
	
	} // function
	
	function display_dropdown(){
	
		$args=array(
		  //'genre' => 'mystery',
		  'post_type' => 'members',
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'caller_get_posts'=> 1
		);
		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			?>
			<select name="member_info_members" onChange="window.location=this.value;">
				<option value="">-- Select a member --</option><?php
		  		while ($my_query->have_posts()) : $my_query->the_post(); ?>
		    		<option value="<?php the_permalink() ?>"><?php the_title(); ?></option>
		    		<?php
		  		endwhile;
		  	?>
			  	</select>
		  	<?php
		}
		wp_reset_query();  // Restore global post data stomped by the_post().	
	
	} // function
	
	function display_countries(){
	
		$countries = array();

	 	$termsacc = get_terms("mi_countries",array('orderby' => 'slug', 'order' => 'DESC'));
	   	foreach ($termsacc as $termcountries) {
	
/*
			echo '<pre>';
			print_r($termcountries);
			echo '</pre>';
*/
	   
	   		if($termcountries->parent != '0'){
	   			$countries[$termcountries->parent]['children'][$termcountries->term_id] = array('name'=>$termcountries->name);
	   		}else{
	   			$countries[$termcountries->term_id] = array('name'=>$termcountries->name);
	   		}
	   		
	   	}
	   	
	   	echo "<ul>";
	   	
	   	foreach($countries as $country){
	   		   	
   			echo '<ul><h3>' . $country['name'] . '</h3>';
	   		
			$my_query = new WP_Query(array('post_type' => 'members', 'orderby'=> $country['name'],'order' => 'DESC','mi_countries' =>$country['name'], 'country' =>$country['name'],'posts_per_page' => 48 ));
	
			while ($my_query->have_posts()) : $my_query->the_post();
				echo '<li><a href="';
				the_permalink();
				echo '">';
				the_title();
				echo '</a></li>';
			endwhile;
			
			echo '</ul>';
				  		
		}
		
		echo "</ul>";

/*
		echo '<pre>';
		print_r($countries);
		echo '</pre>';
*/
	
	} // function
	
	function display_map($width = '', $height = '', $id = ''){
	
		global $post;
		
		if($width == ''){
			$width = get_option('mi_widget_map_width');
		}
		
		if($height == ''){
			$height = get_option('mi_widget_map_height');
		}		
		
		$fields_name = explode( ',', get_option('mi_field_name') );
		$fields_type = explode( ',', get_option('mi_field_type') );
	
		$args=array(
		  //'genre' => 'mystery',
		  'post_type' => 'members',
		  'post_status' => 'publish',
		  'posts_per_page' => -1,
		  'caller_get_posts'=> 1,
		  'p' => $id
		);
		
		$my_query = null;
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			?>
			<div id="map_canvas_display" style="<?php echo 'width:' . $width . 'px; height:' . $height . 'px;';?>"></div>
			<script type="text/javascript">
				jQuery(document).ready(function () {
					
					initialize();
					
				});
				
				var infowindow;
				var geocoder;
				var map;
				var marker;
				var markersArray = [];
				var bounds;
				
				function initialize() {
					geocoder = new google.maps.Geocoder();
				
					var latlng = new google.maps.LatLng(-34.397, 150.644);
					var myOptions = {
				  		zoom: 1,
				  		center: latlng,
				  		mapTypeId: google.maps.MapTypeId.ROADMAP
					}
					map = new google.maps.Map(document.getElementById("map_canvas_display"), myOptions);
					bounds = new google.maps.LatLngBounds ();
					<?php 
					$i = 0;
			  		while ($my_query->have_posts()) : $my_query->the_post(); ?>
			  		
						var contentString<?php echo $i; ?> = '<div>\
\
						<?php
						$ii=0;
						foreach($fields_name as $field){
							if($fields_type[$ii] == 'image'){
								echo '<img clas="mi_map_thumb" src="' .get_post_meta($post->ID, str_replace(' ', '', $field), true) . '" style="width:50px;"/>';
							}
							$ii++;
						}
						
						echo '<h2><a href="';
						the_permalink();
						echo '">';
						the_title();
						echo '</a></h2>'; 
						$iii=0;
						foreach($fields_name as $field){
						
							if($fields_type[$iii] != 'image'){
								
								echo $field . ' - ' . str_replace("\r\n", "<br>", get_post_meta($post->ID, str_replace(' ', '', $field), true) ) . '<br>';
								
							}
							
							$iii++;
						
						} ?></div>';
						
						var infowindow = new google.maps.InfoWindow({zIndex: 9999999999999999});
			  		
					    var myLatlng = new google.maps.LatLng(<?php echo get_post_meta($post->ID, 'lat', true); ?>,<?php echo get_post_meta($post->ID, 'lng', true); ?>);
						var marker<?php echo $i; ?> = new google.maps.Marker({
						position: myLatlng,
						title: "Something"
						});
						marker<?php echo $i; ?>.setMap(map); 
						google.maps.event.addListener(marker<?php echo $i; ?>, 'click', function() {
							infowindow.setContent(contentString<?php echo $i; ?>);	
						  	infowindow.open(map,marker<?php echo $i; ?>);
						});	
						<?php if($id != ''){ ?>
							map.setCenter(myLatlng);
						<?php }else{ ?>
							bounds.extend (myLatlng);
						<?php } 
						
			    		$i++;
			  		endwhile;
			  		
			  		if($id == ''){ ?>
			  			map.fitBounds (bounds);
			  		<?php } ?>
		  			//
				}
			</script>
			
		  	<?php
		}
		wp_reset_query();  // Restore global post data stomped by the_post().		
	} // function
	
}