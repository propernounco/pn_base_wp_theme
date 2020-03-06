<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//XML
Header('Content-type: text/xml');

//Remove primary category
remove_filter( 'post_link_category', 'seopress_titles_primary_cat_hook', 10, 3 ); 

//WPML
function seopress_remove_wpml_home_url_filter( $home_url, $url, $path, $orig_scheme, $blog_id ) {
    return $url;
}
add_filter( 'wpml_get_home_url', 'seopress_remove_wpml_home_url_filter', 20, 5 );

add_filter( 'seopress_sitemaps_single_gnews_query', function( $args ) {
    global $sitepress, $sitepress_settings;

    $sitepress_settings['auto_adjust_ids'] = 0;
    remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
    remove_filter( 'category_link', array( $sitepress, 'category_link_adjust_id' ), 1 );

    return $args;
});

function seopress_xml_sitemap_news() {
	//Publication Name
	function seopress_xml_sitemap_news_name_option() {
	    $seopress_xml_sitemap_news_name_option = get_option("seopress_pro_option_name");
	    if ( ! empty ( $seopress_xml_sitemap_news_name_option ) ) {
	        foreach ($seopress_xml_sitemap_news_name_option as $key => $seopress_xml_sitemap_news_name_value)
	            $options[$key] = $seopress_xml_sitemap_news_name_value;
	         if (isset($seopress_xml_sitemap_news_name_option['seopress_news_name'])) { 
	            return $seopress_xml_sitemap_news_name_option['seopress_news_name'];
	         }
	    }
	}
	//Include Custom Post Types
	function seopress_xml_sitemap_news_cpt_option() {
    	$seopress_xml_sitemap_news_cpt_option = get_option("seopress_pro_option_name");
	    if ( ! empty ( $seopress_xml_sitemap_news_cpt_option ) ) {
	        foreach ($seopress_xml_sitemap_news_cpt_option as $key => $seopress_xml_sitemap_news_cpt_value)
	            $options[$key] = $seopress_xml_sitemap_news_cpt_value;
	         if (isset($seopress_xml_sitemap_news_cpt_option['seopress_news_name_post_types_list'])) { 
	            return $seopress_xml_sitemap_news_cpt_option['seopress_news_name_post_types_list'];
	         }
	    }
	}
	if (seopress_xml_sitemap_news_cpt_option() !='') {
		$seopress_xml_sitemap_news_cpt_array = array();
	    foreach (seopress_xml_sitemap_news_cpt_option() as $cpt_key => $cpt_value) {
	        foreach ($cpt_value as $_cpt_key => $_cpt_value) {
	            if($_cpt_value =='1') {
	                array_push($seopress_xml_sitemap_news_cpt_array, $cpt_key);
	            }
	        }
	    }
	}

	$home_url = home_url().'/';
	
	if (function_exists('pll_home_url')) {
        $home_url = site_url().'/';
    }

	$seopress_sitemaps = '<?xml version="1.0" encoding="UTF-8"?>';
	$seopress_sitemaps .='<?xml-stylesheet type="text/xsl" href="'.$home_url.'sitemaps_xsl.xsl"?>';
	$seopress_sitemaps .= "\n";
	$seopress_sitemaps .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd http://www.google.com/schemas/sitemap-news/0.9 http://www.google.com/schemas/sitemap-news/0.9/sitemap-news.xsd">';
	$seopress_sitemaps .= "\n";
	
				$args = array( 'exclude' => '', 'posts_per_page' => 1000, 'order'=> 'DESC', 'orderby' => 'date', 'post_type' => $seopress_xml_sitemap_news_cpt_array, 'post_status' => 'publish', 'meta_query' => array( array( 'key' => '_seopress_robots_index', 'value' => 'yes', 'compare' => 'NOT EXISTS' ) ), 'date_query' => array(array('after' => '2 days ago')), 'post__not_in' => get_option( 'sticky_posts' ), 'lang' => '', 'has_password' => false);
				
				$args = apply_filters('seopress_sitemaps_single_gnews_query', $args);

				$postslist = get_posts( $args );
				foreach ( $postslist as $post ) {
				  	setup_postdata( $post );
				  	if (get_post_meta($post->ID,'_seopress_news_disabled',true) !='yes') {
					  	$seopress_sitemaps .= '<url>';
					  	$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '<loc>';
						$seopress_sitemaps .= htmlspecialchars(urldecode(get_permalink($post)));
						$seopress_sitemaps .= '</loc>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '<news:news>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '<news:publication>';
						$seopress_sitemaps .= "\n";
	        			$seopress_sitemaps .= '<news:name>'.seopress_xml_sitemap_news_name_option().'</news:name>';
	        			$seopress_sitemaps .= "\n";
						$lang = explode('_', get_locale());
						$lang = $lang[0];
	        			$seopress_sitemaps .= '<news:language>'.$lang.'</news:language>';
	        			$seopress_sitemaps .= "\n";
	      				$seopress_sitemaps .= '</news:publication>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '<news:publication_date>';
						$seopress_sitemaps .= get_the_date('c', $post);
						$seopress_sitemaps .= '</news:publication_date>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '<news:title>';
						$seopress_sitemaps .= htmlspecialchars(urldecode(esc_attr(html_entity_decode(get_the_title($post)))));
						$seopress_sitemaps .= '</news:title>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '</news:news>';
						$seopress_sitemaps .= "\n";
						$seopress_sitemaps .= '</url>';
						$seopress_sitemaps .= "\n";
					}
				}
				wp_reset_postdata();

	$seopress_sitemaps .= '</urlset>';

	$seopress_sitemaps = apply_filters( 'seopress_sitemaps_xml_news', $seopress_sitemaps );

	return $seopress_sitemaps;
} 
echo seopress_xml_sitemap_news();