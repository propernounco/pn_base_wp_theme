<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Rewrite
//=================================================================================================
//Search results rewrite
function seopress_rewrite_search_option() {
	$seopress_rewrite_search_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rewrite_search_option ) ) {
		foreach ($seopress_rewrite_search_option as $key => $seopress_rewrite_search_value)
			$options[$key] = $seopress_rewrite_search_value;
		 if (isset($seopress_rewrite_search_option['seopress_rewrite_search'])) { 
		 	return $seopress_rewrite_search_option['seopress_rewrite_search'];
		 }
	}
}

if (seopress_rewrite_search_option() !='') {
	function seopress_search_url_rewrite() {
	 	if ( is_search() && ! empty( $_GET['s'] ) ) {
	 		wp_redirect( home_url( "/".seopress_rewrite_search_option()."/" ) . urlencode( get_query_var( 's' ) ) );
	 		exit();
	 	}
	}
	add_action( 'template_redirect', 'seopress_search_url_rewrite' );
	
	function seopress_rewrite_search_slug() {
	 	add_rewrite_rule(
	 			seopress_rewrite_search_option().'(/([^/]+))?(/([^/]+))?(/([^/]+))?/?',
	 			'index.php?s=$matches[2]&paged=$matches[6]',
	 			'top'
	 			);
	}
	add_action( 'init', 'seopress_rewrite_search_slug' );

	function seopress_rewrite_breadcrumbs($link, $search) {
		$link = home_url( "/".seopress_rewrite_search_option()."/" ) . urlencode( get_query_var( 's' ));
		return $link;
	}
	add_filter('search_link', 'seopress_rewrite_breadcrumbs', 10, 2);
}