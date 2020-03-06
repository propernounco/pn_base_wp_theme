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

add_filter( 'seopress_sitemaps_video_query', function( $args ) {
    global $sitepress, $sitepress_settings;

    $sitepress_settings['auto_adjust_ids'] = 0;
    remove_filter( 'terms_clauses', array( $sitepress, 'terms_clauses' ) );
    remove_filter( 'category_link', array( $sitepress, 'category_link_adjust_id' ), 1 );

    return $args;
});

function seopress_xml_sitemap_video() {
	$home_url = home_url().'/';
	
	if (function_exists('pll_home_url')) {
        $home_url = site_url().'/';
    }

	$seopress_sitemaps ='<?xml version="1.0" encoding="UTF-8"?>';
	$seopress_sitemaps .='<?xml-stylesheet type="text/xsl" href="'.$home_url.'sitemaps_xsl.xsl"?>';
	$seopress_sitemaps .= "\n";
	$seopress_sitemaps .='<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';

	//CPT
	if (seopress_xml_sitemap_post_types_list_option() !='') {
		foreach (seopress_xml_sitemap_post_types_list_option() as $cpt_key => $cpt_value) {
			foreach ($cpt_value as $_cpt_key => $_cpt_value) {
				if($_cpt_value =='1') {
					$args = array('post_type' => $cpt_key, 'post_status' => 'publish', 'ignore_sticky_posts' => true, 'posts_per_page' => 1000, 'meta_query' => array( array( 'key' => '_seopress_robots_index', 'value' => 'yes', 'compare' => 'NOT EXISTS' ) ), 'order' => 'DESC', 'orderby' => 'modified', 'lang' => '', 'has_password' => false);
					
					$args = apply_filters('seopress_sitemaps_video_query', $args, $cpt_key);

				    $postslist = get_posts( $args );
				    
					foreach ( $postslist as $post ) {
					  	setup_postdata( $post );
					  	
					  	$seopress_video_disabled     	= get_post_meta($post->ID,'_seopress_video_disabled', true);
					  	$seopress_video     			= get_post_meta($post->ID,'_seopress_video');

					  	if (!empty($seopress_video[0][0]["url"]) && $seopress_video_disabled !='yes') {
					  		$seopress_sitemaps .= "\n";
						  	$seopress_sitemaps .= '<url>';
						  	$seopress_sitemaps .= "\n";
							$seopress_sitemaps .= '<loc>';
							$seopress_sitemaps .= htmlspecialchars(urldecode(get_permalink($post->ID)));
							$seopress_sitemaps .= '</loc>';
							$seopress_sitemaps .= "\n";

							foreach ($seopress_video[0] as $key => $value) {
								$seopress_sitemaps .= '<video:video>';
								$seopress_sitemaps .= "\n";
								
								//Thumbnail
								if ($seopress_video[0][$key]["thumbnail"] !='') {//Video Thumbnail
									$seopress_sitemaps .= '<video:thumbnail_loc>'.htmlspecialchars(urldecode(esc_attr(wp_filter_nohtml_kses($seopress_video[0][$key]["thumbnail"])))).'</video:thumbnail_loc>';
									$seopress_sitemaps .= "\n";
								} elseif(get_the_post_thumbnail_url($post->ID) !='') {//Post Thumbnail
									$seopress_sitemaps .= '<video:thumbnail_loc>'.htmlspecialchars(urldecode(esc_attr(wp_filter_nohtml_kses(get_the_post_thumbnail_url($post->ID))))).'</video:thumbnail_loc>';
									$seopress_sitemaps .= "\n";
								}
								//Post Title
								if ($seopress_video[0][$key]["title"] !='') {//Video Title
									$seopress_sitemaps .= '<video:title><![CDATA['.$seopress_video[0][$key]["title"].']]></video:title>';
									$seopress_sitemaps .= "\n";
								} elseif(get_post_meta($post->ID,'_seopress_titles_title',true) !='') {//SEO Custom Title
									$seopress_sitemaps .= '<video:title><![CDATA['.get_post_meta($post->ID,'_seopress_titles_title',true).']]></video:title>';
									$seopress_sitemaps .= "\n";
								} elseif(get_the_title($post->ID) !='') {//Post title
									$seopress_sitemaps .= '<video:title><![CDATA['.get_the_title($post->ID).']]></video:title>';
									$seopress_sitemaps .= "\n";
								}
								//Description
								if ($seopress_video[0][$key]["desc"] !='') {//Video Description
									$seopress_sitemaps .= '<video:description><![CDATA['.$seopress_video[0][$key]["desc"].']]></video:description>';
									$seopress_sitemaps .= "\n";
								} elseif(get_post_meta($post->ID,'_seopress_titles_desc',true) !='') {//SEO Custom Meta desc
									$seopress_sitemaps .= '<video:description><![CDATA['.get_post_meta($post->ID,'_seopress_titles_desc',true).']]></video:description>';
									$seopress_sitemaps .= "\n";
								} elseif (get_the_excerpt($post->ID) !='') {//Excerpt

									$seopress_sitemaps .= '<video:description><![CDATA['.wp_trim_words(esc_attr(wp_filter_nohtml_kses(htmlentities(get_the_excerpt($post->ID)))),60).']]></video:description>';
									$seopress_sitemaps .= "\n";
								}
								//URL
								if ($seopress_video[0][$key]["url"] !='' && $seopress_video[0][$key]['internal_video'] !='') {
									$seopress_sitemaps .= '<video:content_loc><![CDATA['.$seopress_video[0][$key]["url"].']]></video:content_loc>';
									$seopress_sitemaps .= "\n";
								} elseif ($seopress_video[0][$key]["url"] !='') {
									$seopress_sitemaps .= '<video:player_loc><![CDATA['.$seopress_video[0][$key]["url"].']]></video:player_loc>';
									$seopress_sitemaps .= "\n";
								}
								//Duration
								if ($seopress_video[0][$key]["duration"] !='') {
									$seopress_sitemaps .= '<video:duration>'.$seopress_video[0][$key]["duration"].'</video:duration>';
									$seopress_sitemaps .= "\n";
								}
								//Rating
								if ($seopress_video[0][$key]["rating"] !='') {
									$seopress_sitemaps .= '<video:rating>'.$seopress_video[0][$key]["rating"].'</video:rating>';
									$seopress_sitemaps .= "\n";
								}
								//View count
								if ($seopress_video[0][$key]["view_count"] !='') {
									$seopress_sitemaps .= '<video:view_count>'.$seopress_video[0][$key]["view_count"].'</video:view_count>';
									$seopress_sitemaps .= "\n";
								}
								//Publication date
								$seopress_sitemaps .= '<video:publication_date>'.get_the_modified_date('c', $post).'</video:publication_date>';
								$seopress_sitemaps .= "\n";

								//Family Friendly
								if ($seopress_video[0][$key]["family_friendly"] !='') {
									$seopress_sitemaps .= '<video:family_friendly>no</video:family_friendly>';
									$seopress_sitemaps .= "\n";
								} else {
									$seopress_sitemaps .= '<video:family_friendly>yes</video:family_friendly>';
									$seopress_sitemaps .= "\n";
								}
								//Tags
								$seopress_target_kw ='';
								if (get_post_meta($post->ID,'_seopress_analysis_target_kw',true) !='') {
									$seopress_target_kw = get_post_meta($post->ID,'_seopress_analysis_target_kw',true).',';
								}
								if ($seopress_video[0][$key]["tag"] !='') {//Video tags
									$seopress_sitemaps .= '<video:tag>'.esc_attr(wp_filter_nohtml_kses($seopress_target_kw.$seopress_video[0][$key]["tag"])).'</video:tag>';
									$seopress_sitemaps .= "\n";
								} else {//Post tags
									$tags = get_the_tags($post->ID);
									if ( ! empty( $tags ) ) {
										$tags_list;
										$count = count($tags);
										$i = 1;
										foreach ($tags as $tag) {
											$tags_list .= $tag->name;
											if ($i < $count) {
												$tags_list .=',';
											}
											$i++;
										}
									    $seopress_sitemaps .= '<video:tag>'.$seopress_target_kw.$tags_list.'</video:tag>';
										$seopress_sitemaps .= "\n";  
									}
								}
								//Cats
								if ($seopress_video[0][$key]["cat"] !='') {//Video categories
									$seopress_sitemaps .= '<video:category>'.esc_attr(wp_filter_nohtml_kses($seopress_video[0][$key]["cat"])).'</video:category>';
									$seopress_sitemaps .= "\n";
								} else {//Post category
									$categories = get_the_category($post->ID);
									if ( ! empty( $categories ) ) {
									    $first_cat = esc_html( $categories[0]->name );
									    $seopress_sitemaps .= '<video:category>'.$first_cat.'</video:category>';
										$seopress_sitemaps .= "\n";  
									}
								}
								
								$seopress_sitemaps .= '</video:video>';
								$seopress_sitemaps .= "\n";
							}
							$seopress_sitemaps .= '</url>';
						}
					}
				}
			}
		}
	}
	$seopress_sitemaps .= "\n";
	$seopress_sitemaps .='</urlset>';

	$seopress_sitemaps = apply_filters( 'seopress_sitemaps_xml_video', $seopress_sitemaps );
	
	return $seopress_sitemaps;
} 
echo seopress_xml_sitemap_video();