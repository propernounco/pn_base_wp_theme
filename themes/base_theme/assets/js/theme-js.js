jQuery(function ($) {	
	// START JQUERY FILE
	
	

	///
	///
	///
	//jQuery Waypoints Example. If Header scrolled to waypoint, fire event
	var headerScrolled = new Waypoint({
	  element: $('#header-trigger'),
	  handler: function(direction) {		  
	    if(direction == 'down'){		    			    	
	    	$('.header').addClass('scrolled')			
	    }		
	    if(direction == 'up'){		    	
	    	$('.header').removeClass('scrolled')	  		
	    }		   		    
	  },
	  offset: '-6%'
	})
	//jQuery Waypoints Example. If Header scrolled to waypoint, fire event
	///
	///
	///



	///
	///
	///START CUSTOM CODE BELOW HERE
	///
	///
	///


	

	//END JQUERY FILE
})