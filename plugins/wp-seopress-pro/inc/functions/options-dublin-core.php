<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Dublin Core
//=================================================================================================
//Dublin Core enable
function seopress_dublin_core_enable_option() {
	$seopress_dublin_core_enable_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_dublin_core_enable_option ) ) {
		foreach ($seopress_dublin_core_enable_option as $key => $seopress_dublin_core_enable_value)
			$options[$key] = $seopress_dublin_core_enable_value;
		 if (isset($seopress_dublin_core_enable_option['seopress_dublin_core_enable'])) { 
		 	return $seopress_dublin_core_enable_option['seopress_dublin_core_enable'];
		 }
	}
}
//DC Tags
if (seopress_dublin_core_enable_option() =='1') { //Is DC enable
	if (is_singular() || is_home()) { //Is Singular (post, page, cpt)
		function seopress_dublin_core_title_hook() {
			if (function_exists('seopress_titles_the_title') && seopress_titles_the_title() !='') {
				$seopress_dublin_core_title = '<meta name="dc.title" content="'.seopress_titles_the_title().'" />';
				
				//Hook on post Dublin Core Title - 'seopress_dublin_core_title'
				if (has_filter('seopress_dublin_core_title')) {
					$seopress_dublin_core_title = apply_filters('seopress_dublin_core_title', $seopress_dublin_core_title);
			    }
				echo $seopress_dublin_core_title."\n";
			}
		}
		add_action( 'wp_head', 'seopress_dublin_core_title_hook', 1 );
		//DC Description
		function seopress_dublin_core_description_hook() {
			if (function_exists('seopress_titles_the_description_content') && seopress_titles_the_description_content() !='') {
				$seopress_dublin_core_desc = '<meta name="dc.description" content="'.seopress_titles_the_description_content().'" />'; 

		 		//Hook on post Dublin Core Description - 'seopress_dublin_core_desc'
				if (has_filter('seopress_dublin_core_desc')) {
					$seopress_dublin_core_desc = apply_filters('seopress_dublin_core_desc', $seopress_dublin_core_desc);
			    }
			    echo $seopress_dublin_core_desc."\n";
			}
		}
		add_action( 'wp_head', 'seopress_dublin_core_description_hook', 1 );

		//DC Relation
		function seopress_dublin_core_relation_hook() {
			//Init
			$seopress_dublin_core_relation ='';

			if ( is_home() && get_post_meta(get_option( 'page_for_posts' ),'_seopress_robots_canonical',true) !='') {
				$_seopress_robots_canonical = get_post_meta(get_option( 'page_for_posts' ),'_seopress_robots_canonical',true);
				$seopress_dublin_core_relation = '<meta name="dc.relation" content="'.htmlspecialchars(urldecode($_seopress_robots_canonical)).'" />';
			} elseif (get_post_meta(get_the_ID(),'_seopress_robots_canonical',true) !='') { //IS METABOXE
				$_seopress_robots_canonical = get_post_meta(get_the_ID(),'_seopress_robots_canonical',true);
				$seopress_dublin_core_relation = '<meta name="dc.relation" content="'.htmlspecialchars(urldecode($_seopress_robots_canonical)).'" />';
			} else {
				global $wp;
				if (seopress_advanced_advanced_trailingslash_option()) {
					$current_url = home_url(add_query_arg(array(), $wp->request));
				} else {
					$current_url = trailingslashit(home_url(add_query_arg(array(), $wp->request)));
				}
				$seopress_dublin_core_relation = '<meta name="dc.relation" content="'.htmlspecialchars(urldecode($current_url)).'" />';
			}
			//Hook on post Dublin Core Relation - 'seopress_dublin_core_relation'
			if (has_filter('seopress_dublin_core_relation')) {
				$seopress_dublin_core_relation = apply_filters('seopress_dublin_core_relation', $seopress_dublin_core_relation);
		    }

		    if (isset($seopress_dublin_core_relation) && $seopress_dublin_core_relation !='') {
				echo $seopress_dublin_core_relation."\n";
			}
		}
		add_action( 'wp_head', 'seopress_dublin_core_relation_hook', 1 );

		//DC Source
		function seopress_dublin_core_source_hook() {
			if (seopress_advanced_advanced_trailingslash_option()) {
				$seopress_dublin_core_source = '<meta name="dc.source" content="'.htmlspecialchars(urldecode(get_home_url())).'" />';
			} else {
				$seopress_dublin_core_source = '<meta name="dc.source" content="'.htmlspecialchars(urldecode(trailingslashit(get_home_url()))).'" />';
			}
			//Hook on post Dublin Core Source - 'seopress_dublin_core_source'
			if (has_filter('seopress_dublin_core_source')) {
				$seopress_dublin_core_source = apply_filters('seopress_dublin_core_source', $seopress_dublin_core_source);
		    }
			echo $seopress_dublin_core_source."\n";
		}
		add_action( 'wp_head', 'seopress_dublin_core_source_hook', 1 );

		//DC Language
		function seopress_dublin_core_language_hook() {
			$seopress_dc_language = '<meta name="dc.language" content="'.get_locale().'" />';
			
			//Hook on post Dublin Core Source - 'seopress_dublin_core_language'
			if (has_filter('seopress_dublin_core_language')) {
				$seopress_dc_language = apply_filters('seopress_dublin_core_language', $seopress_dc_language);
		    }

			echo $seopress_dc_language."\n";
		}
		add_action( 'wp_head', 'seopress_dublin_core_language_hook', 1 );
	}
}