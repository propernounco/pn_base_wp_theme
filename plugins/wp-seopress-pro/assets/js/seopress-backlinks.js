//Request Majestic API
jQuery(document).ready(function($) {
	$('#seopress-find-backlinks').on('click', function() {
		$.ajax({
			method : 'GET',
			url : seopressAjaxBacklinks.seopress_backlinks,
			data : {
				action: 'seopress_backlinks',
				_ajax_nonce: seopressAjaxBacklinks.seopress_nonce,
			},
			success : function( data ) {
				window.location.reload(true);
			},
		});
	});
	$('#seopress-find-backlinks').on('click', function() {
		$(this).attr("disabled", "disabled");
		$( '.spinner' ).css( "visibility", "visible" );
		$( '.spinner' ).css( "float", "none" );
	});
});