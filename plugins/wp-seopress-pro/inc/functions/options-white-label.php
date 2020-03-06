<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//White Label
//=================================================================================================
//Remove SEOPress admin header
function seopress_white_label_admin_header_option() {
	$seopress_white_label_admin_header_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_admin_header_option ) ) {
		foreach ($seopress_white_label_admin_header_option as $key => $seopress_white_label_admin_header_value)
			$options[$key] = $seopress_white_label_admin_header_value;
		 if (isset($seopress_white_label_admin_header_option['seopress_white_label_admin_header'])) { 
		 	return $seopress_white_label_admin_header_option['seopress_white_label_admin_header'];
		 }
	}
}

if (seopress_white_label_admin_header_option() =='1') {
	if (!defined('SEOPRESS_WL_ADMIN_HEADER')) {
		define('SEOPRESS_WL_ADMIN_HEADER', false);
	}
}

//Remove SEOPress admin header (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_admin_header_option() {
		$seopress_mu_white_label_admin_header_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_admin_header_option ) ) {
			foreach ($seopress_mu_white_label_admin_header_option as $key => $seopress_mu_white_label_admin_header_value)
				$options[$key] = $seopress_mu_white_label_admin_header_value;
			 if (isset($seopress_mu_white_label_admin_header_option['seopress_mu_white_label_admin_header'])) { 
			 	return $seopress_mu_white_label_admin_header_option['seopress_mu_white_label_admin_header'];
			 }
		}
	}

	if (seopress_mu_white_label_admin_header_option() =='1') {
		if (!defined('SEOPRESS_WL_ADMIN_HEADER')) {
			define('SEOPRESS_WL_ADMIN_HEADER', false);
		}
	}
}

//Remove SEOPress icons in header
function seopress_white_label_admin_notices_option() {
	$seopress_white_label_admin_notices_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_admin_notices_option ) ) {
		foreach ($seopress_white_label_admin_notices_option as $key => $seopress_white_label_admin_notices_value)
			$options[$key] = $seopress_white_label_admin_notices_value;
		 if (isset($seopress_white_label_admin_notices_option['seopress_white_label_admin_notices'])) { 
		 	return $seopress_white_label_admin_notices_option['seopress_white_label_admin_notices'];
		 }
	}
}

if (seopress_white_label_admin_notices_option() =='1') {
	if (!defined('SEOPRESS_WL_ICONS_HEADER')) {
		define('SEOPRESS_WL_ICONS_HEADER', false);
	}
}

//Remove SEOPress icons in header (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_admin_notices_option() {
		$seopress_mu_white_label_admin_notices_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_admin_notices_option ) ) {
			foreach ($seopress_mu_white_label_admin_notices_option as $key => $seopress_mu_white_label_admin_notices_value)
				$options[$key] = $seopress_mu_white_label_admin_notices_value;
			 if (isset($seopress_mu_white_label_admin_notices_option['seopress_mu_white_label_admin_notices'])) { 
			 	return $seopress_mu_white_label_admin_notices_option['seopress_mu_white_label_admin_notices'];
			 }
		}
	}

	if (seopress_mu_white_label_admin_notices_option() =='1') {
		if (!defined('SEOPRESS_WL_ICONS_HEADER')) {
			define('SEOPRESS_WL_ICONS_HEADER', false);
		}
	}
}

//Filter SEO admin menu dashicons
function seopress_white_label_admin_menu_option() {
	$seopress_white_label_admin_menu_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_admin_menu_option ) ) {
		foreach ($seopress_white_label_admin_menu_option as $key => $seopress_white_label_admin_menu_value)
			$options[$key] = $seopress_white_label_admin_menu_value;
		 if (isset($seopress_white_label_admin_menu_option['seopress_white_label_admin_menu'])) { 
		 	return $seopress_white_label_admin_menu_option['seopress_white_label_admin_menu'];
		 }
	}
}

if (seopress_white_label_admin_menu_option() !='') {
	function sp_seo_admin_menu_hook($html) {
		return seopress_white_label_admin_menu_option();
	}
	add_filter('seopress_seo_admin_menu', 'sp_seo_admin_menu_hook'); 
}

//Filter SEO admin menu dashicons (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_admin_menu_option() {
		$seopress_mu_white_label_admin_menu_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_admin_menu_option ) ) {
			foreach ($seopress_mu_white_label_admin_menu_option as $key => $seopress_mu_white_label_admin_menu_value)
				$options[$key] = $seopress_mu_white_label_admin_menu_value;
			 if (isset($seopress_mu_white_label_admin_menu_option['seopress_mu_white_label_admin_menu'])) { 
			 	return $seopress_mu_white_label_admin_menu_option['seopress_mu_white_label_admin_menu'];
			 }
		}
	}

	if (seopress_mu_white_label_admin_menu_option() !='') {
		function sp_mu_seo_admin_menu_hook($html) {
			return seopress_mu_white_label_admin_menu_option();
		}
		add_filter('seopress_seo_admin_menu', 'sp_mu_seo_admin_menu_hook'); 
	}
}

//Change / remove SEOPress icon in admin bar
function seopress_white_label_admin_bar_icon_option() {
	$seopress_white_label_admin_bar_icon_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_admin_bar_icon_option ) ) {
		foreach ($seopress_white_label_admin_bar_icon_option as $key => $seopress_white_label_admin_bar_icon_value)
			$options[$key] = $seopress_white_label_admin_bar_icon_value;
		 if (isset($seopress_white_label_admin_bar_icon_option['seopress_white_label_admin_bar_icon'])) { 
		 	return $seopress_white_label_admin_bar_icon_option['seopress_white_label_admin_bar_icon'];
		 }
	}
}

if (seopress_white_label_admin_bar_icon_option() !='') {
	function sp_adminbar_icon_hook($html) { 
		$html = seopress_white_label_admin_bar_icon_option(); 
		return $html; 
	}
	add_filter('seopress_adminbar_icon', 'sp_adminbar_icon_hook');
}

//Change / remove SEOPress icon in admin bar (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_admin_bar_icon_option() {
		$seopress_mu_white_label_admin_bar_icon_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_admin_bar_icon_option ) ) {
			foreach ($seopress_mu_white_label_admin_bar_icon_option as $key => $seopress_mu_white_label_admin_bar_icon_value)
				$options[$key] = $seopress_mu_white_label_admin_bar_icon_value;
			 if (isset($seopress_mu_white_label_admin_bar_icon_option['seopress_mu_white_label_admin_bar_icon'])) { 
			 	return $seopress_mu_white_label_admin_bar_icon_option['seopress_mu_white_label_admin_bar_icon'];
			 }
		}
	}

	if (seopress_mu_white_label_admin_bar_icon_option() !='') {
		function sp_mu_adminbar_icon_hook($html) { 
			$html = seopress_mu_white_label_admin_bar_icon_option(); 
			return $html; 
		}
		add_filter('seopress_adminbar_icon', 'sp_mu_adminbar_icon_hook');
	}
}

//Add your custom logo in SEOPress admin header
function seopress_white_label_admin_bar_logo_option() {
	$seopress_white_label_admin_bar_logo_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_admin_bar_logo_option ) ) {
		foreach ($seopress_white_label_admin_bar_logo_option as $key => $seopress_white_label_admin_bar_logo_value)
			$options[$key] = $seopress_white_label_admin_bar_logo_value;
		 if (isset($seopress_white_label_admin_bar_logo_option['seopress_white_label_admin_bar_logo'])) { 
		 	return $seopress_white_label_admin_bar_logo_option['seopress_white_label_admin_bar_logo'];
		 }
	}
}

if (seopress_white_label_admin_bar_logo_option() !='') {
	if (!defined('SEOPRESS_WL_ADMIN_HEADER_LOGO')) {
		define('SEOPRESS_WL_ADMIN_HEADER_LOGO', seopress_white_label_admin_bar_logo_option());
	}
}

//Add your custom logo in SEOPress admin header (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_admin_bar_logo_option() {
		$seopress_mu_white_label_admin_bar_logo_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_admin_bar_logo_option ) ) {
			foreach ($seopress_mu_white_label_admin_bar_logo_option as $key => $seopress_mu_white_label_admin_bar_logo_value)
				$options[$key] = $seopress_mu_white_label_admin_bar_logo_value;
			 if (isset($seopress_mu_white_label_admin_bar_logo_option['seopress_mu_white_label_admin_bar_logo'])) { 
			 	return $seopress_mu_white_label_admin_bar_logo_option['seopress_mu_white_label_admin_bar_logo'];
			 }
		}
	}

	if (seopress_mu_white_label_admin_bar_logo_option() !='') {
		if (!defined('SEOPRESS_WL_ADMIN_HEADER_LOGO')) {
			define('SEOPRESS_WL_ADMIN_HEADER_LOGO', seopress_mu_white_label_admin_bar_logo_option());
		}
	}
}

//Remove SEOPress credits in footer admin pages
function seopress_white_label_footer_credits_option() {
	$seopress_white_label_footer_credits_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_white_label_footer_credits_option ) ) {
		foreach ($seopress_white_label_footer_credits_option as $key => $seopress_white_label_footer_credits_value)
			$options[$key] = $seopress_white_label_footer_credits_value;
		 if (isset($seopress_white_label_footer_credits_option['seopress_white_label_footer_credits'])) { 
		 	return $seopress_white_label_footer_credits_option['seopress_white_label_footer_credits'];
		 }
	}
}

if (seopress_white_label_footer_credits_option() =='1') {
	if (isset($_GET['page']) && ($_GET['page'] == 'seopress-option' || $_GET['page'] == 'seopress-network-option' || $_GET['page'] == 'seopress-titles' || $_GET['page'] == 'seopress-xml-sitemap' || $_GET['page'] == 'seopress-social' || $_GET['page'] == 'seopress-google-analytics' || $_GET['page'] == 'seopress-advanced' || $_GET['page'] == 'seopress-pro-page') ) {      
		add_filter('admin_footer_text', '__return_empty_string'); 
	}
}

//Remove SEOPress credits in footer admin pages (multisite)
if (is_multisite()) {
	function seopress_mu_white_label_footer_credits_option() {
		$seopress_mu_white_label_footer_credits_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_footer_credits_option ) ) {
			foreach ($seopress_mu_white_label_footer_credits_option as $key => $seopress_mu_white_label_footer_credits_value)
				$options[$key] = $seopress_mu_white_label_footer_credits_value;
			 if (isset($seopress_mu_white_label_footer_credits_option['seopress_mu_white_label_footer_credits'])) { 
			 	return $seopress_mu_white_label_footer_credits_option['seopress_mu_white_label_footer_credits'];
			 }
		}
	}

	if (seopress_mu_white_label_footer_credits_option() =='1') {
		if (isset($_GET['page']) && ($_GET['page'] == 'seopress-option' || $_GET['page'] == 'seopress-network-option' || $_GET['page'] == 'seopress-titles' || $_GET['page'] == 'seopress-xml-sitemap' || $_GET['page'] == 'seopress-social' || $_GET['page'] == 'seopress-google-analytics' || $_GET['page'] == 'seopress-advanced' || $_GET['page'] == 'seopress-pro-page') ) {      
			add_filter('admin_footer_text', '__return_empty_string'); 
		}
	}
}

//Remove SEOPress menu/submenu pages (multisite only)
if (is_multisite()) {
	function seopress_mu_white_label_menu_pages_option() {
		$seopress_mu_white_label_menu_pages_option = get_blog_option(get_network()->site_id,"seopress_pro_mu_option_name");
		if ( ! empty ( $seopress_mu_white_label_menu_pages_option ) ) {
			foreach ($seopress_mu_white_label_menu_pages_option as $key => $seopress_mu_white_label_menu_pages_value)
				$options[$key] = $seopress_mu_white_label_menu_pages_value;
			 if (isset($seopress_mu_white_label_menu_pages_option['seopress_mu_white_label_menu_pages'])) { 
			 	return $seopress_mu_white_label_menu_pages_option['seopress_mu_white_label_menu_pages'];
			 }
		}
	}

	if (!empty(seopress_mu_white_label_menu_pages_option())) {
		if (!is_super_admin()) {
			add_action( 'admin_menu', 'seopress_remove_menu_page_hook'); 
			function seopress_remove_menu_page_hook() {
				$seopress_menu_pages_array = seopress_mu_white_label_menu_pages_option();

				if (array_key_exists('seopress-option', $seopress_menu_pages_array)) {
					remove_menu_page( 'seopress-option' ); //SEO
				}
			}
			
			add_action( 'admin_menu', 'seopress_remove_submenu_page_hook', 999 );
			function seopress_remove_submenu_page_hook() {
				$seopress_menu_pages_array = seopress_mu_white_label_menu_pages_option();

				foreach ($seopress_menu_pages_array as $key => $value) {
					remove_submenu_page('seopress-option', $key); 
				}
			}
		}
	}
}
