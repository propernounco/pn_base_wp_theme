<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//SEOPRESS Core
///////////////////////////////////////////////////////////////////////////////////////////////////

//Local Business
if (seopress_get_toggle_local_business_option() =='1') {
	add_action('wp_head', 'seopress_pro_local_business', 0);
	function seopress_pro_local_business() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-local-business.php'); //Local Business
		}
	}
}

//WooCommerce
if (seopress_get_toggle_woocommerce_option() =='1') {
	add_action('init', 'seopress_pro_woocommerce_sitemap', 0);
	function seopress_pro_woocommerce_sitemap() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-woocommerce-sitemap.php'); //WooCommerce sitemap
		}	
	}
	add_action('get_header', 'seopress_pro_woocommerce', 0);
	function seopress_pro_woocommerce() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-woocommerce.php'); //WooCommerce
		}	
	}
}

//EDD
if (seopress_get_toggle_edd_option() =='1') {
	add_action('get_header', 'seopress_pro_edd', 0);
	function seopress_pro_edd() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-edd.php'); //EDD
		}	
	}
}

//Dublin Core
if (seopress_get_toggle_dublin_core_option() =='1') {
	add_action('wp_head', 'seopress_pro_dublin_core', 0);
	function seopress_pro_dublin_core() {
		if (!is_admin()){
			if( function_exists('is_wpforo_page') && is_wpforo_page() ){//disable on wpForo pages to avoid conflicts
				//do nothing
			} else {
				require_once ( dirname( __FILE__ ) . '/options-dublin-core.php'); //Dublin Core
			}
		}
	}
}

//Rich Snippets
if (seopress_get_toggle_rich_snippets_option() =='1') {
	add_action('wp_head', 'seopress_pro_rich_snippets', 2); // Must be !=0
	function seopress_pro_rich_snippets() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-rich-snippets.php'); //Rich Snippets
			require_once ( dirname( __FILE__ ) . '/options-automatic-rich-snippets.php'); //Automatic Rich Snippets
		}
	}
	add_action('init', 'seopress_load_schemas_options', 9);
	function seopress_load_schemas_options() {
		require_once ( dirname(dirname( __FILE__ )) . '/admin/schemas.php'); //Schemas
	}
}

//Breadcrumbs
if (seopress_get_toggle_breadcrumbs_option() =='1') {
	//Breadcrumbs
	function seopress_breadcrumbs_enable_option() {
		$seopress_breadcrumbs_enable_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_breadcrumbs_enable_option ) ) {
			foreach ($seopress_breadcrumbs_enable_option as $key => $seopress_breadcrumbs_enable_value)
				$options[$key] = $seopress_breadcrumbs_enable_value;
			 if (isset($seopress_breadcrumbs_enable_option['seopress_breadcrumbs_enable'])) { 
			 	return $seopress_breadcrumbs_enable_option['seopress_breadcrumbs_enable'];
			 }
		}
	}

	//Breadcrumbs JSON-LD
	function seopress_breadcrumbs_json_enable_option() {
		$seopress_breadcrumbs_json_enable_option = get_option("seopress_pro_option_name");
		if ( ! empty ( $seopress_breadcrumbs_json_enable_option ) ) {
			foreach ($seopress_breadcrumbs_json_enable_option as $key => $seopress_breadcrumbs_json_enable_value)
				$options[$key] = $seopress_breadcrumbs_json_enable_value;
			 if (isset($seopress_breadcrumbs_json_enable_option['seopress_breadcrumbs_json_enable'])) { 
			 	return $seopress_breadcrumbs_json_enable_option['seopress_breadcrumbs_json_enable'];
			 }
		}
	}
	//WooCommerce / Storefront with Breadcrumbs
	if (seopress_breadcrumbs_json_enable_option() =='1') {
		add_action('init','seopress_pro_compatibility_wc');
		function seopress_pro_compatibility_wc() {
		    //If WooCommerce, disable default JSON-LD Breadcrumbs to avoid conflicts
		    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		    if ( is_plugin_active( 'woocommerce/woocommerce.php' )) {
		        add_action('woocommerce_structured_data_breadcrumblist', '__return_false', 10, 2);
		        remove_action('storefront_before_content', 'woocommerce_breadcrumb', 10);
		    }
		}
	}
	add_action('wp_head', 'seopress_pro_breadcrumbs', 0);
	function seopress_pro_breadcrumbs() {
		if (!is_admin()){
			require_once ( dirname( __FILE__ ) . '/options-breadcrumbs.php'); //Breadcrumbs
		}
	}
}

//RSS
add_action('init', 'seopress_pro_rss', 0);
function seopress_pro_rss() {
	if (!is_admin()){
		require_once ( dirname( __FILE__ ) . '/options-rss.php'); //RSS
	}
}

//Rewrite
if (seopress_get_toggle_rewrite_option() =='1') {
	add_action('init', 'seopress_pro_rewrite', 0);
	function seopress_pro_rewrite() {
		require_once ( dirname( __FILE__ ) . '/options-rewrite.php'); //Rewrite
	}
}

//White Label
if (seopress_get_toggle_white_label_option() =='1') {
	if (is_admin() || is_network_admin()) {
		require_once ( dirname( __FILE__ ) . '/options-white-label.php'); //White Label
	}
}
