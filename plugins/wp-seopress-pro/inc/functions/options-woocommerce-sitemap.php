<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//WooCommerce
//=================================================================================================
//noindex WooCommerce page
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if (is_plugin_active('wp-seopress-pro/seopress-pro.php') && is_plugin_active( 'woocommerce/woocommerce.php' )) {
	if (!function_exists('seopress_woocommerce_xml_single_query')) {
		function seopress_woocommerce_xml_single_query($args, $cpt_key) {
			//Cart page
			if (!function_exists('seopress_woocommerce_cart_page_no_index_option')) {
				function seopress_woocommerce_cart_page_no_index_option() {
					$seopress_woocommerce_cart_page_no_index_option = get_option("seopress_pro_option_name");
					if ( ! empty ( $seopress_woocommerce_cart_page_no_index_option ) ) {
						foreach ($seopress_woocommerce_cart_page_no_index_option as $key => $seopress_woocommerce_cart_page_no_index_value)
							$options[$key] = $seopress_woocommerce_cart_page_no_index_value;
						 if (isset($seopress_woocommerce_cart_page_no_index_option['seopress_woocommerce_cart_page_no_index'])) { 
						 	return $seopress_woocommerce_cart_page_no_index_option['seopress_woocommerce_cart_page_no_index'];
						 }
					}
				}
			}
			//Checkout page
			if (!function_exists('seopress_woocommerce_checkout_page_no_index_option')) {
				function seopress_woocommerce_checkout_page_no_index_option() {
					$seopress_woocommerce_checkout_page_no_index_option = get_option("seopress_pro_option_name");
					if ( ! empty ( $seopress_woocommerce_checkout_page_no_index_option ) ) {
						foreach ($seopress_woocommerce_checkout_page_no_index_option as $key => $seopress_woocommerce_checkout_page_no_index_value)
							$options[$key] = $seopress_woocommerce_checkout_page_no_index_value;
						 if (isset($seopress_woocommerce_checkout_page_no_index_option['seopress_woocommerce_checkout_page_no_index'])) { 
						 	return $seopress_woocommerce_checkout_page_no_index_option['seopress_woocommerce_checkout_page_no_index'];
						 }
					}
				}
			}
			//Customer Account
			if (!function_exists('seopress_woocommerce_customer_account_page_no_index_option')) {
				function seopress_woocommerce_customer_account_page_no_index_option() {
					$seopress_woocommerce_customer_account_page_no_index_option = get_option("seopress_pro_option_name");
					if ( ! empty ( $seopress_woocommerce_customer_account_page_no_index_option ) ) {
						foreach ($seopress_woocommerce_customer_account_page_no_index_option as $key => $seopress_woocommerce_customer_account_page_no_index_value)
							$options[$key] = $seopress_woocommerce_customer_account_page_no_index_value;
						 if (isset($seopress_woocommerce_customer_account_page_no_index_option['seopress_woocommerce_customer_account_page_no_index'])) { 
						 	return $seopress_woocommerce_customer_account_page_no_index_option['seopress_woocommerce_customer_account_page_no_index'];
						 }
					}
				}
			}

			//Init
			$wc_pages_polylang 	= array();
			$wc_pages_wpml 		= array();
			$wc_pages 			= array();
			
			if (function_exists('wc_get_page_id')) {
				if (seopress_woocommerce_customer_account_page_no_index_option() =='1') {
					if (function_exists('icl_object_id')) { //WPML
						$translations = apply_filters( 'wpml_get_element_translations', NULL, wc_get_page_id( 'myaccount' ), 'post_page' );
						$wc_pages_wpml[] = wp_list_pluck($translations,'element_id');
					} elseif (function_exists('pll_get_post_translations')) { //Polylang
						$wc_pages_polylang[] = array_values(pll_get_post_translations(wc_get_page_id( 'myaccount' )));
					} else {
						$wc_pages[] = wc_get_page_id( 'myaccount' );
					}
				}
				if (seopress_woocommerce_checkout_page_no_index_option() =='1') {
					if (function_exists('icl_object_id')) { //WPML
						$translations = apply_filters( 'wpml_get_element_translations', NULL, wc_get_page_id( 'checkout' ), 'post_page' );
						$wc_pages_wpml[] = wp_list_pluck($translations,'element_id');
					} elseif (function_exists('pll_get_post_translations')) { //Polylang
						$wc_pages_polylang[] = array_values(pll_get_post_translations(wc_get_page_id( 'checkout' )));
					} else {
						$wc_pages[] = wc_get_page_id( 'checkout' );
					}
				}
				if (seopress_woocommerce_cart_page_no_index_option() =='1') {
					if (function_exists('icl_object_id')) { //WPML
						$translations = apply_filters( 'wpml_get_element_translations', NULL, wc_get_page_id( 'cart' ), 'post_page' );
						$wc_pages_wpml[] = wp_list_pluck($translations,'element_id');
					} elseif (function_exists('pll_get_post_translations')) { //Polylang
						$wc_pages_polylang[] = array_values(pll_get_post_translations(wc_get_page_id( 'cart' )));
					} else {
						$wc_pages[] = wc_get_page_id( 'cart' );
					}
				}
			}

		    if ($cpt_key == 'page') {
		    	if (!empty($wc_pages_wpml)) {
		        	foreach ($wc_pages_wpml as $key => $value) {
	        			foreach ($value as $_key => $_value) {
		        			$args['exclude'][] = $_value;
		        		}
		        	}
		        } elseif (!empty($wc_pages_polylang)) {
		        	foreach ($wc_pages_polylang as $key => $value) {
		        		foreach ($value as $_key => $_value) {
		        			$args['exclude'][] = $_value;
		        		}		        		
		        	}
		        } else {
        			$args['exclude'] = $wc_pages;
		        }		        
		        return $args;
		    } else {
		        return $args;
		    }
		}
		add_filter('seopress_sitemaps_single_query', 'seopress_woocommerce_xml_single_query', 10, 2);
	}
}