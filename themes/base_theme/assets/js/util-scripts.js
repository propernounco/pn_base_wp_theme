//Function To Check For Browsers That Don't Support GRID & Add Classes For CSS Fallback
function checkAncientBrowser(){

	var userAgent = navigator.userAgent;

	console.log('test')

	function detectIE(ua){
	
		var msie = ua.indexOf('MSIE ');

		if (msie > 0) {
		    // IE 10 or older => return version number
		    var body = document.getElementsByTagName('body')[0]
			body.classList.add('ie')			

		    return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		}
		var trident = ua.indexOf('Trident/');
		if (trident > 0) {

		    // IE 11 => return version number
		    var body = document.getElementsByTagName('body')[0]
			body.classList.add('ie')

		    var rv = ua.indexOf('rv:');
		    return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
		}
		var edge = ua.indexOf('Edge/');
		if (edge > 0) {

			var body = document.getElementsByTagName('body')[0]
			body.classList.add('ie')

		    // Edge (IE 12+) => return version number
		  	return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
		}			

		// other browser
		return false;
	}
	
	// Get IE or Edge browser version
	var ie_version = detectIE(userAgent);		
	
	var is_safari = /^((?!chrome|android).)*safari/i.test(userAgent);		
		if(is_safari){
			var safari_v = userAgent
			safari_v = safari_v.split(" ")

			for(var i = 0; i < safari_v.length; i++){
				if(safari_v[i].toLowerCase().includes('version')){						
					safari_v = safari_v[i].split('/')
					safari_v = parseInt(safari_v[1])						
				}
			}
						
			if(safari_v <= 10){
				is_safari = true;
			}
			else{
				is_safari = false;
			}
		}
	
	var is_chrome = /Chrome/.test(userAgent) && /Google Inc/.test(navigator.vendor); 

		if(is_chrome){
			var chrome_v = userAgent
			chrome_arr = chrome_v.split(" ")

			for(var x = 0; x < chrome_arr.length; x++){
	
				if(chrome_arr[x].toLowerCase().includes('chrome')){
					chrome_v = chrome_arr[x].split('/')
					chrome_v = chrome_v[1].split('.')
					chrome_v = parseInt(chrome_v[0])

				}
			}

						
			if(chrome_v <= 56){
				is_chrome = true;
			}
			else{
				is_chrome = false;
			}
		}

	var is_ff = navigator.userAgent.toLowerCase().indexOf('firefox') > -1;
		if(is_ff){
			var ff_v = userAgent
			ff_v = ff_v.split(" ")
			for(var i = 0; i < ff_v.length; i++){
				if(ff_v[i].toLowerCase().includes('firefox')){						
					ff_v = ff_v[i].split('/')
					ff_v = parseInt(ff_v[1])						
				}
			}							
			if(ff_v <= 51){
				is_ff = true;
			}
			else{
				is_ff = false;
			}
		}

	if(ie_version){
		return 'ie_fb';
	}
	else if(is_ff){
		return 'ff_fb';
	}	
	else if(is_safari){
		return 'safari_fb';
	}
	
	else if(is_chrome){
		return 'chrome_fb';
	}
	else{
		return false;
	}		
}

window.onload = function(){

	var ancientBrowser = checkAncientBrowser()

	//var ancientBrowser = false;

	if(ancientBrowser){

		var body = document.getElementsByTagName('body')[0]	

		body.classList.add(ancientBrowser)
		var grid = document.getElementsByClassName('grid')
		for(var a = 0; a < grid.length; a++){
			grid[a].classList.add(ancientBrowser)
		}		
	}

	var bgBlocks = document.getElementsByClassName('bg-block')
	if(bgBlocks.length > 0){
		for(var b = 0; b < bgBlocks.length; b++){		
			if(bgBlocks[b].hasAttribute('data-bg-img')){
				var bg = bgBlocks[b].getAttribute('data-bg-img')			
				bgBlocks[b].setAttribute('style', 'background-image: url("'+ bg +'")');
			}		
		}	
	}

	if(document.getElementById('mobile-toggle-menu')){
		var mobile_toggle = document.getElementById('mobile-toggle-menu');

		mobile_toggle.onclick = function() {
		  mobile_toggle.classList.toggle('on');
		}
	}

	var toggle_contain = document.querySelectorAll('.toggle-switch')

	if(toggle_contain){	
		for(var tc = 0; tc < toggle_contain.length; tc++){		
			toggle_contain[tc].addEventListener('click', function(e){ //say this is an anchor
		         //do something
		        e.preventDefault();
		        this.classList.toggle('on');	        
		    })
		}
	}

}

