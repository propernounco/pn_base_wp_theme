<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//WooCommerce
//=================================================================================================
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
if ( is_plugin_active( 'woocommerce/woocommerce.php' )) {
	if (is_singular( array( 'product' ) )) {
		//OG Price
		function seopress_woocommerce_product_og_price_option() {
			$seopress_woocommerce_product_og_price_option = get_option("seopress_pro_option_name");
			if ( ! empty ( $seopress_woocommerce_product_og_price_option ) ) {
				foreach ($seopress_woocommerce_product_og_price_option as $key => $seopress_woocommerce_product_og_price_value)
					$options[$key] = $seopress_woocommerce_product_og_price_value;
				 if (isset($seopress_woocommerce_product_og_price_option['seopress_woocommerce_product_og_price'])) { 
				 	return $seopress_woocommerce_product_og_price_option['seopress_woocommerce_product_og_price'];
				 }
			}
		};

		function seopress_woocommerce_product_og_price_hook() {
			if (seopress_woocommerce_product_og_price_option() =='1') {
				
				$product = wc_get_product(get_the_id());
				$price = $product->get_price();

				$seopress_social_og_price = '<meta property="product:price:amount" content="'.$price.'" />';
				
				echo $seopress_social_og_price."\n";
			}
		}
		add_action( 'wp_head', 'seopress_woocommerce_product_og_price_hook', 1 );

		//OG Currency
		function seopress_woocommerce_product_og_currency_option() {
			$seopress_woocommerce_product_og_currency_option = get_option("seopress_pro_option_name");
			if ( ! empty ( $seopress_woocommerce_product_og_currency_option ) ) {
				foreach ($seopress_woocommerce_product_og_currency_option as $key => $seopress_woocommerce_product_og_currency_value)
					$options[$key] = $seopress_woocommerce_product_og_currency_value;
				 if (isset($seopress_woocommerce_product_og_currency_option['seopress_woocommerce_product_og_currency'])) { 
				 	return $seopress_woocommerce_product_og_currency_option['seopress_woocommerce_product_og_currency'];
				 }
			}
		}

		function seopress_woocommerce_product_og_currency_hook() {
			if (seopress_woocommerce_product_og_currency_option() =='1') {

				$seopress_social_og_currency = '<meta property="product:price:currency" content="'.get_woocommerce_currency().'" />';
				
				echo $seopress_social_og_currency."\n";
			}
		}
		add_action( 'wp_head', 'seopress_woocommerce_product_og_currency_hook', 1 );
	}

	//WooCommerce Meta tag generator
	function seopress_woocommerce_meta_generator_option() {
		$seopress_woocommerce_meta_generator_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_woocommerce_meta_generator_option ) ) {
			foreach ($seopress_woocommerce_meta_generator_option as $key => $seopress_woocommerce_meta_generator_value)
				$options[$key] = $seopress_woocommerce_meta_generator_value;
			 if (isset($seopress_woocommerce_meta_generator_option['seopress_woocommerce_meta_generator'])) { 
			 	return $seopress_woocommerce_meta_generator_option['seopress_woocommerce_meta_generator'];
			 }
		}
	}
	function seopress_woocommerce_meta_generator_hook() {
		if (seopress_woocommerce_meta_generator_option() =='1') {
			remove_action('get_the_generator_html','wc_generator_tag', 10, 2);
   			remove_action('get_the_generator_xhtml','wc_generator_tag', 10, 2);
		}
	}
	add_action('get_header','seopress_woocommerce_meta_generator_hook');

	//WooCommerce Structured data
	function seopress_woocommerce_schema_output_option() {
		$seopress_woocommerce_schema_output_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_woocommerce_schema_output_option ) ) {
			foreach ($seopress_woocommerce_schema_output_option as $key => $seopress_woocommerce_schema_output_value)
				$options[$key] = $seopress_woocommerce_schema_output_value;
			 if (isset($seopress_woocommerce_schema_output_option['seopress_woocommerce_schema_output'])) { 
			 	return $seopress_woocommerce_schema_output_option['seopress_woocommerce_schema_output'];
			 }
		}
	}
	function seopress_woocommerce_schema_output_hook() {
		if (seopress_woocommerce_schema_output_option() =='1') {
			remove_action( 'wp_footer', array( WC()->structured_data, 'output_structured_data' ), 10 ); 
			remove_action( 'woocommerce_email_order_details', array( WC()->structured_data, 'output_email_structured_data' ), 30 );
		}
	}
	add_action('wp_head','seopress_woocommerce_schema_output_hook');

	//WooCommerce Breadcrulbs Structured data
	function seopress_woocommerce_schema_breadcrumbs_output_option() {
		$seopress_woocommerce_schema_breadcrumbs_output_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_woocommerce_schema_breadcrumbs_output_option ) ) {
			foreach ($seopress_woocommerce_schema_breadcrumbs_output_option as $key => $seopress_woocommerce_schema_breadcrumbs_output_value)
				$options[$key] = $seopress_woocommerce_schema_breadcrumbs_output_value;
			 if (isset($seopress_woocommerce_schema_breadcrumbs_output_option['seopress_woocommerce_schema_breadcrumbs_output'])) { 
			 	return $seopress_woocommerce_schema_breadcrumbs_output_option['seopress_woocommerce_schema_breadcrumbs_output'];
			 }
		}
	}
	if (seopress_woocommerce_schema_breadcrumbs_output_option() =='1') {
		add_filter('woocommerce_structured_data_breadcrumblist', '__return_false');
	}
}