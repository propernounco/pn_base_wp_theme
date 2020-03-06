<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//EDD
//=================================================================================================
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' )) {
	if(is_singular('download')) {
		//OG Price
		function seopress_edd_product_og_price_option() {
			$seopress_edd_product_og_price_option = get_option("seopress_pro_option_name");
			if ( ! empty ( $seopress_edd_product_og_price_option ) ) {
				foreach ($seopress_edd_product_og_price_option as $key => $seopress_edd_product_og_price_value)
					$options[$key] = $seopress_edd_product_og_price_value;
				 if (isset($seopress_edd_product_og_price_option['seopress_edd_product_og_price'])) { 
				 	return $seopress_edd_product_og_price_option['seopress_edd_product_og_price'];
				 }
			}
		};

		function seopress_edd_product_og_price_hook() {
			if (seopress_edd_product_og_price_option() =='1') {
				if (function_exists('edd_get_download_price') && function_exists('edd_format_amount')) {
					$price = edd_format_amount(edd_get_download_price( get_the_id()));

					$seopress_social_og_price = '<meta property="product:price:amount" content="'.$price.'" />';
				
					echo $seopress_social_og_price."\n";
				}
			}
		}
		add_action( 'wp_head', 'seopress_edd_product_og_price_hook', 1 );

		//OG Currency
		function seopress_edd_product_og_currency_option() {
			$seopress_edd_product_og_currency_option = get_option("seopress_pro_option_name");
			if ( ! empty ( $seopress_edd_product_og_currency_option ) ) {
				foreach ($seopress_edd_product_og_currency_option as $key => $seopress_edd_product_og_currency_value)
					$options[$key] = $seopress_edd_product_og_currency_value;
				 if (isset($seopress_edd_product_og_currency_option['seopress_edd_product_og_currency'])) { 
				 	return $seopress_edd_product_og_currency_option['seopress_edd_product_og_currency'];
				 }
			}
		}

		function seopress_edd_product_og_currency_hook() {
			if (seopress_edd_product_og_currency_option() =='1') {
				if (function_exists('edd_get_currency') && edd_get_currency() !='') {
					$seopress_social_og_currency = '<meta property="product:price:currency" content="'.edd_get_currency().'" />';
				
					echo $seopress_social_og_currency."\n";
				}
				
			}
		}
		add_action( 'wp_head', 'seopress_edd_product_og_currency_hook', 1 );
	}
	//EDD Meta tag generator
	function seopress_edd_meta_generator_option() {
		$seopress_edd_meta_generator_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_edd_meta_generator_option ) ) {
			foreach ($seopress_edd_meta_generator_option as $key => $seopress_edd_meta_generator_value)
				$options[$key] = $seopress_edd_meta_generator_value;
			 if (isset($seopress_edd_meta_generator_option['seopress_edd_meta_generator'])) { 
			 	return $seopress_edd_meta_generator_option['seopress_edd_meta_generator'];
			 }
		}
	}
	function seopress_edd_meta_generator_hook() {
		if (seopress_edd_meta_generator_option() =='1') {
			remove_action('wp_head','edd_version_in_header');
		}
	}
	add_action('get_header','seopress_edd_meta_generator_hook');
}
