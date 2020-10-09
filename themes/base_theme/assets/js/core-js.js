jQuery(function($){
	

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
	
	$('.accordion .accordion-step .title').on('click', function(e){
		e.preventDefault();
		$('.accordion-step .content').slideUp();
		$(this).parent().find('.content').slideDown()
		$('.accordion-step .content').removeClass('active')
		$('.accordion-step').removeClass('active')
		$(this).parent().addClass('active')
	})
	
	function getTextWidth(text) { 
  
        inputText = text; 
        font = "18px times new roman"; 

        canvas = document.createElement("canvas"); 
        context = canvas.getContext("2d"); 
        context.font = font; 
        width = context.measureText(inputText).width; 
        formattedWidth = Math.ceil(width); 

        // document.querySelector('.output').textContent 
                    // = formattedWidth; 
		return formattedWidth
    } 
	
	$('.sub-sub-links').each(function(){
		$(this).parent().parent().addClass('flex')
	})

	$('a[href^="#"]').on('click',function (e) {
        e.preventDefault();

        var target = this.hash,        
        $target = $(target);

        if(target == '#' || target == '#none'){
        	return;
        }

       $('html, body').stop().animate({
         'scrollTop': $target.offset().top - 300
        }, 500, 'swing', function () {
         // window.location.hash = target;
        });
    });

    function check_width_overflow(elem){
	    return element.scrollWidth > element.clientWidth;
	}

	$('.modal').iziModal()
	
	feather.replace()		      
	
	if($('.pn-select').length > 0){
		var max_width = 0;		
		var text_width = 0;
		$('.pn-select').each(function(){
			$(this).find('li').each(function(){
				// console.log($(this).find('a').textWidth())	
				text_width = getTextWidth($(this).find('a').text());
				
				if(text_width > max_width){
					console.log(text_width)
					max_width = text_width + 120
				}
			})	
			$(this).css('min-width', max_width + 'px')
		})

		
	}
	
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

	if(document.getElementsByClassName('fade-in-content-left').length > 0){	
		$.each(['fade-in-content-left'], function(i, classname) {
			
		  var elements = $('.' + classname)		  	
		  elements.each(function() {
		    new Waypoint({
		      element: this,
		      handler: function(direction) {
		        var previousWaypoint = this.previous()
		        var nextWaypoint = this.next()
		        var the_content = $(this)[0].element;
		        if(direction == 'down'){		        	
		        	$(the_content).addClass('animation fade-in-left');
		        }
		        
		      },
		      offset: '80%',
		      group: classname
		    })
		  })
		})
	}	

	if(document.getElementsByClassName('fade-in-content-right').length > 0){	
		$.each(['fade-in-content-right'], function(i, classname) {
			
		  var elements = $('.' + classname)		  	
		  elements.each(function() {
		    new Waypoint({
		      element: this,
		      handler: function(direction) {
		        var previousWaypoint = this.previous()
		        var nextWaypoint = this.next()
		        var the_content = $(this)[0].element;
		        if(direction == 'down'){		        	
		        	$(the_content).addClass('animation fade-in-right');
		        }
		        
		      },
		      offset: '80%',
		      group: classname
		    })
		  })
		})
	}	

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

	if($('.testimonials-slider').length > 0){
		console.log('as')
		$('.testimonials-slider').slick({
			dots: true,
			infinite: true,
			speed: 600,
			centerMode: true,
			arrows:false,
			autoplay: true,
			autoplaySpeed: 5000,
			slidesToShow: 1,
			slidesToScroll: 1
		})
	}	


	$('.pn-selector-close').on('click', function(){
		$(this).parent().removeClass('active')
		$(this).parent().find('li').each(function(){							
			$(this).css({
				'top' : '0px'
			})
		})
		console.log('asdoajdoaisd')
	})


	$('.pn-select-option').on('click', function(e){
		e.preventDefault()
		// console.log('yeee')
		if($(this).parent().parent().hasClass('active')){

			console.log('yee')
			
			$(this).parent().parent().find('li').removeClass('active')
			$(this).parent().addClass('active')


			$(this).parent().parent().find('li').each(function(){							
				$(this).css({
					'top' : '0px'
				})
			})

			$(this).parent().parent().removeClass('active')

		}
		else{
			var item_count = 0;
			var item_height = $(this).height();

			$(this).parent().parent().find('li').each(function(){
				
				var top_offset = (item_count * item_height) 
				// $(this).css({
				// 	'top' : top_offset + 'px'
				// })
				var item = $(this)
				$(item).css({
						'top' : top_offset + 'px'
					})
				// setTimeout(function(){
				// 	// console.log('pokk')

					
				// }, 150 * item_count)

				item_count++;

				
			})

			$(this).parent().parent().toggleClass('active')

		}
	
		
	})
	
	$('.nav-item.top-level').hover(function(){
		if($(window).width() > 768){
			console.log('asds')
			$(this).addClass('active')
			$(this).find('.sub-links').addClass('active')
		}		
	}, function(){
		if($(window).width() > 768){
			$(this).removeClass('active')
			$(this).find('.sub-links').removeClass('active')
		}
	})
	
	
	$('.mobile-nav-trigger').on('click', function(e){
		e.preventDefault()
		$('.nav').toggleClass('active')
		$(this).toggleClass('active')	
	})

	$('.nav-item.top-level a').on('click', function(e){
		
		if($(window).width() < 768){
			if($(this).parent().find('.sub-links').length > 0 ){			
				
				if(!$(this).hasClass('can-click')){
					e.preventDefault();	
					$(this).parent().find('.sub-links').slideDown()
					$(this).addClass('can-click')
				}
				else{
					$(this).parent().find('.sub-links').slideUp(250)
				}

			}
		}

		
	})
	

	$('.wpbb-file-upload .file-upload-field').on('change', function(e){

		var appendFacility = $(this).hasClass('append-facility-images')

        e.preventDefault()
        if(this.files.length > 0){
        	
        	var parentBlock = $(this).parent()
        	$(parentBlock).find('.clear-upload-input').addClass('active')
        	if($(this)[0].hasAttribute('multiple')){        		
        		var nameString = '';
        		parentBlock.find('.input-filename-text').text('')
				$(this.files).each(function(){			

					if(this.name.includes('jpg') || this.name.includes('png')){
						var reader = new FileReader();
	
					    reader.onload = function(e) {

					      var previewImg = '<img class="img-preview" src="'+e.target.result+'">';						  
						  parentBlock.find('.input-filename-text').append(previewImg)		

						  
					    }
					    
					    reader.readAsDataURL(this); // convert to base64 string
					}					
					else{
						$(parentBlock).find('.input-filename-text').text(this.name)	
					}
					
				    
					
				})
				// $(this).parent().find('.input-filename-text').text(nameString)		
        	}
        	else{              	 	
        	 	if(this.files[0].name.includes('jpg') || this.files[0].name.includes('png')){
					var reader = new FileReader();
	
				    reader.onload = function(e) {

				    	console.log(e.target.result)

				      var previewImg = '<img class="img-preview" src="'+e.target.result+'">';
					  parentBlock.find('.input-filename-text').text('')	
					  parentBlock.find('.input-filename-text').append(previewImg)		

					  	
				    }
				    
				    reader.readAsDataURL(this.files[0]); // convert to base64 string
        	 	}	
        	 	else{
        	 		$(parentBlock).find('.input-filename-text').text(this.files[0].name)		
        	 	}	
            	
        	}
                
        }
        else{
            $(this).parent().find('.clear-upload-input').removeClass('active')
            $(this).parent().find('.input-filename-text').text('Drag & Drop Your File To Upload')
        }
    })

    $('.clear-upload-input').on('click', function(e){
        e.preventDefault();
        $(this).parent().find('.file-upload-field').val('')
        $(this).parent().find('.file-upload-field').trigger('change')
    })


	$('.image-upload').on('change', function(){

		var imgInput = $(this)

		var imageFormData = new FormData();
		imageFormData.append( "image", $(this)[0].files[0]);

		imageFormData.append('action', 'wpbb_upload_image');
	    // imageFormData.append('async-upload', $imgFile[0].files[0]);
	    imageFormData.append('name', $(this)[0].files[0].name);
	    imageFormData.append('_wpnonce', php_array.nonce);

		$.ajax({
            url: php_array.admin_ajax,
            type: 'POST',		
            processData: false,
			contentType: false,			      
            data:imageFormData,
            beforeSend: function(){
            
            },
            success: function(data){    
				console.log(data)
            },
            error: function(data){
                
                $('.listing-continue').prop('disabled', false)
            }
        })

	})
	


})

