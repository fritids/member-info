jQuery(document).ready(function () {
	
	initialize();
	
});

var geocoder;
var map;
var marker;
var markersArray = [];

function initialize() {

	geocoder = new google.maps.Geocoder();
	if(jQuery('#map_canvas').length > 0 || jQuery('#map_canvas_display').length > 0){
		if(jQuery('#member_info_location').val() != ''){
			codeAddress('NO');
		}else{
			var latlng = new google.maps.LatLng(-34.397, 150.644);
		}
		var myOptions = {
  			zoom: 8,
  			center: latlng,
  			streetViewControl: false,
  			mapTypeControl: false,
  			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	
		google.maps.event.addListener(map, 'click', function(event) {
	
			//console.log(event);
	
			if (markersArray){
        		for (i in markersArray){
        		    markersArray[i].setMap(null);
        		}
    		}
	     
			var marker = new google.maps.Marker({
		    	map: map, 
		    	position: event.latLng   
			});
			markersArray.push(marker);
			jQuery('#lat').val(event.latLng.lat());
			jQuery('#lng').val(event.latLng.lng());
			codeLatLng(event.latLng.lat(), event.latLng.lng());
		});	
	
	}
	
}

function addMarkerFromDidYouMean(lat, lng){

	if(jQuery('#map_canvas').length > 0 || jQuery('#map_canvas_display').length > 0){
	
		if (markersArray){
	        for (i in markersArray){
	            markersArray[i].setMap(null);
	        }
	    }
	    var location = new google.maps.LatLng(lat, lng);
	    var marker = new google.maps.Marker({
	    	map: map, 
	    	position: location   
		});
		     
	   	map.setCenter(location);
	   	
		markersArray.push(marker);
	
	}
	
	jQuery('#lat').val(lat);
	jQuery('#lng').val(lng);
	
	codeLatLng(lat, lng);	

}

function codeAddress(update) {
    
	var address = jQuery('#member_info_location').val();
	geocoder.geocode( { 'address': address}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {
	  		jQuery('#didyoumean').html('');
	  		console.log(results);
	  		if(results.length > 1){
	  			jQuery('#didyoumean').html('<strong>Did you mean:</strong><br>');
	  			for (i=0;i<results.length;i++){
	  				jQuery('#didyoumean').html(jQuery('#didyoumean').html() + '<a style="cursor: pointer;" onClick="addMarkerFromDidYouMean(' + results[i].geometry.location.lat() + ',' +results[i].geometry.location.lng() + ')">' + results[i].formatted_address + '<a/><br>' );
	  			}
	  			jQuery('#didyoumean').html(jQuery('#didyoumean').html() + '<span class="description">If your location has not been suggested try being more specific with your search. For example add USA or UK or a city name.</span><br>');
	  		}
			if (markersArray){
		        for (i in markersArray){
		            markersArray[i].setMap(null);
		        }
		    }
		    if(jQuery('#map_canvas').length > 0 || jQuery('#map_canvas_display').length > 0){
	    		map.setCenter(results[0].geometry.location);
	    	}
	    	var marker = new google.maps.Marker({
	        	map: map, 
	        	position: results[0].geometry.location   
	    	});
	    	markersArray.push(marker); 
	    	if(update == 'YES'){
	    	
		    	jQuery('#member_info_location').val(results[0].formatted_address);
		    	jQuery('#lat').val(results[0].geometry.location.lat());
		    	jQuery('#lng').val(results[0].geometry.location.lng());
		    	
				if(results[0].address_components[1].long_name == results[0].address_components[2].long_name){
					jQuery('#general_location').val( results[0].address_components[1].long_name );
				}else{
					jQuery('#general_location').val( results[0].address_components[1].long_name+', '+results[0].address_components[2].long_name );
				}		    	
		    	
		    	jQuery('#member_info_address').html('');
		    	for (i=0;i<results[0].address_components.length;i++){
		    		jQuery('#member_info_address').html( jQuery('#member_info_address').html() + results[0].address_components[i].long_name + '\r' );
		    	}
	    	
	    	}
		    	
	  	} else {
	  		if(status == 'ZERO_RESULTS'){
	  			alert("We could not find your location… Please be a little more specific with your search. \n\nAlternatively you can simply type your address in the text box. \n\n:-)");
	  		}
	  	}
	});
}

function codeLatLng(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
  		jQuery('#didyoumean').html('');
  		//console.log(results);
  		if(results.length > 1){
  			jQuery('#didyoumean').html('<strong>Did you mean:</strong><br><br>');
  			for (i=0;i<results.length;i++){
  				jQuery('#didyoumean').html(jQuery('#didyoumean').html() + '<a style="cursor: pointer;" onClick="addMarkerFromDidYouMean(' + results[i].geometry.location.lat() + ',' +results[i].geometry.location.lng() + ')">' + results[i].formatted_address + '<a/><br>' );
  			}
  			jQuery('#didyoumean').html(jQuery('#didyoumean').html() + '<br><br><span class="description">If your location has not been suggested try being more specific with your search. For example add USA or UK or a city name.</span><br>');
  		}
		if (markersArray){
	        for (i in markersArray){
	            markersArray[i].setMap(null);
	        }
	    }
    	//map.setCenter(results[0].geometry.location);
    	var marker = new google.maps.Marker({
        	map: map, 
        	position: results[0].geometry.location   
    	});
    	markersArray.push(marker); 
    	jQuery('#member_info_location').val(results[0].formatted_address);
    	jQuery('#lat').val(results[0].geometry.location.lat());
    	jQuery('#lng').val(results[0].geometry.location.lng());
    	
		if(results[0].address_components[1].long_name == results[0].address_components[2].long_name){
			jQuery('#general_location').val( results[0].address_components[1].long_name );
		}else{
			jQuery('#general_location').val( results[0].address_components[1].long_name+', '+results[0].address_components[2].long_name );
		}		    	

    	jQuery('#member_info_address').html('');
    	for (i=0;i<results[0].address_components.length;i++){
    		jQuery('#member_info_address').html( jQuery('#member_info_address').html() + results[0].address_components[i].long_name + '\n' );
    	}    	
    	
      } else {
        alert("Geocoder failed due to: " + status);
      }
	});
}