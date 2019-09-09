jQuery(function ($) {	
	// START JQUERY FILE
	
	///
	///
	///
	////Initialize The jQuery Plugins and Animations. Remove if not using. 
		
		//Modals
		$('.modal').iziModal()

		//Fade in animation events
		if(document.getElementsByClassName('fade-in-content').length > 0){	
			$.each(['fade-in-content'], function(i, classname) {
				
			  var elements = $('.' + classname)		  	
			  elements.each(function() {
			    new Waypoint({
			      element: this,
			      handler: function(direction) {
			        var previousWaypoint = this.previous()
			        var nextWaypoint = this.next()
			        var the_content = $(this)[0].element;
			        if(direction == 'down'){		        	
			        	$(the_content).addClass('animation fade-in-up');
			        }
			        
			      },
			      offset: '80%',
			      group: classname
			    })
			  })
			})
		}	

	////Initialize The jQuery Plugins and Animations. Remove if not using.	
	///
	///
	///



	///
	///
	///
	//Slick Slider Example
	if($('.slider-name').length > 0){
		$('.slider-name').slick({
			dots: false,
			infinite: true,
			speed: 300,
			slidesToShow: 1,
			slidesToScroll: 1
		})
	}
	//Slick Slider Example
	///
	///
	///



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