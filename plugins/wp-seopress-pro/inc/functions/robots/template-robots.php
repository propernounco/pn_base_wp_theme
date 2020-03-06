<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//XML
Header('Content-type: text/plain');

if (is_multisite()) {
	function seopress_pro_robots_file_option() {
		$seopress_pro_mu_robots_file_option = get_option("seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_pro_mu_robots_file_option ) ) {
			foreach ($seopress_pro_mu_robots_file_option as $key => $seopress_pro_mu_robots_file_value)
				$options[$key] = $seopress_pro_mu_robots_file_value;
			 if (isset($seopress_pro_mu_robots_file_option['seopress_mu_robots_file'])) { 
			 	return $seopress_pro_mu_robots_file_option['seopress_mu_robots_file'];
			 }
		}
	}
} else {
	function seopress_pro_robots_file_option() {
		$seopress_pro_robots_file_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_pro_robots_file_option ) ) {
			foreach ($seopress_pro_robots_file_option as $key => $seopress_pro_robots_file_value)
				$options[$key] = $seopress_pro_robots_file_value;
			 if (isset($seopress_pro_robots_file_option['seopress_robots_file'])) { 
			 	return $seopress_pro_robots_file_option['seopress_robots_file'];
			 }
		}
	}
}

function seopress_robots_file() {
	$seopress_robots = seopress_pro_robots_file_option();
	$seopress_robots = apply_filters( 'seopress_robots_txt_file', $seopress_robots );
	return $seopress_robots;
}
echo seopress_robots_file();