//Request Google Page Speed
jQuery(document).ready(function($) {
	$('.seopress-request-page-speed').on('click', function() {
		var data_permalink = $(this).attr('data_permalink');
		$.ajax({
			method : 'GET',
			url : seopressAjaxRequestPageSpeed.seopress_request_page_speed,
			data : {
				action: 'seopress_request_page_speed',
				data_permalink : data_permalink,
				_ajax_nonce: seopressAjaxRequestPageSpeed.seopress_nonce,
			},
			success : function( data ) {
				var url_location = data.data.url;
				if ($(location).attr('href') == url_location) {
					window.location.reload(true);
				} else {
					$(location).attr('href',url_location);
				}
			},
		});
	});

	$('.seopress-request-page-speed').on('click', function() {
		$(this).attr("disabled", "disabled");
		$( '.spinner' ).css( "visibility", "visible" );
		$( '.spinner' ).css( "float", "none" );
	});
	
	//Clear Google Page Speed Transient
	$('#seopress-clear-page-speed-cache').on('click', function() {
		$.ajax({
			method : 'GET',
			url : seopressAjaxClearPageSpeedCache.seopress_clear_page_speed_cache,
			data : {
				action: 'seopress_clear_page_speed_cache',
				_ajax_nonce: seopressAjaxClearPageSpeedCache.seopress_nonce,
			},
			success : function( data ) {
				window.location.reload(true);
			},
		});
	});
	$('#seopress-clear-page-speed-cache').on('click', function() {
		$(this).attr("disabled", "disabled");
		$( '.spinner' ).css( "visibility", "visible" );
		$( '.spinner' ).css( "float", "none" );
	});
});