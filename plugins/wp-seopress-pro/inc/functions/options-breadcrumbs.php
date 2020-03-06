<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//Breadcrumbs
///////////////////////////////////////////////////////////////////////////////////////////////////
//Breadcrumbs separator
function seopress_breadcrumbs_separator_option() {
	$seopress_breadcrumbs_separator_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_separator_option ) ) {
		foreach ($seopress_breadcrumbs_separator_option as $key => $seopress_breadcrumbs_separator_value)
			$options[$key] = $seopress_breadcrumbs_separator_value;
		 if (isset($seopress_breadcrumbs_separator_option['seopress_breadcrumbs_separator'])) { 
		 	return $seopress_breadcrumbs_separator_option['seopress_breadcrumbs_separator'];
		 }
	}
}

//i18n Homepage
function seopress_breadcrumbs_i18n_home_option() {
	$seopress_breadcrumbs_i18n_home_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_i18n_home_option ) ) {
		foreach ($seopress_breadcrumbs_i18n_home_option as $key => $seopress_breadcrumbs_i18n_home_value)
			$options[$key] = $seopress_breadcrumbs_i18n_home_value;
		 if (isset($seopress_breadcrumbs_i18n_home_option['seopress_breadcrumbs_i18n_home'])) { 
		 	return $seopress_breadcrumbs_i18n_home_option['seopress_breadcrumbs_i18n_home'];
		 }
	}
}

//i18n 404 error
function seopress_breadcrumbs_i18n_404_option() {
	$seopress_breadcrumbs_i18n_404_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_i18n_404_option ) ) {
		foreach ($seopress_breadcrumbs_i18n_404_option as $key => $seopress_breadcrumbs_i18n_404_value)
			$options[$key] = $seopress_breadcrumbs_i18n_404_value;
		 if (isset($seopress_breadcrumbs_i18n_404_option['seopress_breadcrumbs_i18n_404'])) { 
		 	return $seopress_breadcrumbs_i18n_404_option['seopress_breadcrumbs_i18n_404'];
		 }
	}
}

//i18n Search results for
function seopress_breadcrumbs_i18n_search_option() {
	$seopress_breadcrumbs_i18n_search_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_i18n_search_option ) ) {
		foreach ($seopress_breadcrumbs_i18n_search_option as $key => $seopress_breadcrumbs_i18n_search_value)
			$options[$key] = $seopress_breadcrumbs_i18n_search_value;
		 if (isset($seopress_breadcrumbs_i18n_search_option['seopress_breadcrumbs_i18n_search'])) { 
		 	return $seopress_breadcrumbs_i18n_search_option['seopress_breadcrumbs_i18n_search'];
		 }
	}
}

//i18n No results
function seopress_breadcrumbs_i18n_no_results_option() {
	$seopress_breadcrumbs_i18n_no_results_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_i18n_no_results_option ) ) {
		foreach ($seopress_breadcrumbs_i18n_no_results_option as $key => $seopress_breadcrumbs_i18n_no_results_value)
			$options[$key] = $seopress_breadcrumbs_i18n_no_results_value;
		 if (isset($seopress_breadcrumbs_i18n_no_results_option['seopress_breadcrumbs_i18n_no_results'])) { 
		 	return $seopress_breadcrumbs_i18n_no_results_option['seopress_breadcrumbs_i18n_no_results'];
		 }
	}
}

//Breadcrumbs remove blog page
function seopress_breadcrumbs_remove_blog_page_option() {
	$seopress_breadcrumbs_remove_blog_page_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_remove_blog_page_option ) ) {
		foreach ($seopress_breadcrumbs_remove_blog_page_option as $key => $seopress_breadcrumbs_remove_blog_page_value)
			$options[$key] = $seopress_breadcrumbs_remove_blog_page_value;
		 if (isset($seopress_breadcrumbs_remove_blog_page_option['seopress_breadcrumbs_remove_blog_page'])) { 
		 	return $seopress_breadcrumbs_remove_blog_page_option['seopress_breadcrumbs_remove_blog_page'];
		 }
	}
}

//Breadcrumbs remove shop page
function seopress_breadcrumbs_remove_shop_page_option() {
	$seopress_breadcrumbs_remove_shop_page_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_remove_shop_page_option ) ) {
		foreach ($seopress_breadcrumbs_remove_shop_page_option as $key => $seopress_breadcrumbs_remove_shop_page_value)
			$options[$key] = $seopress_breadcrumbs_remove_shop_page_value;
		 if (isset($seopress_breadcrumbs_remove_shop_page_option['seopress_breadcrumbs_remove_shop_page'])) { 
		 	return $seopress_breadcrumbs_remove_shop_page_option['seopress_breadcrumbs_remove_shop_page'];
		 }
	}
}

//Breadcrumbs disable default separator
function seopress_breadcrumbs_separator_disable_option() {
	$seopress_breadcrumbs_separator_disable_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_breadcrumbs_separator_disable_option ) ) {
		foreach ($seopress_breadcrumbs_separator_disable_option as $key => $seopress_breadcrumbs_separator_disable_value)
			$options[$key] = $seopress_breadcrumbs_separator_disable_value;
		 if (isset($seopress_breadcrumbs_separator_disable_option['seopress_breadcrumbs_separator_disable'])) { 
		 	return $seopress_breadcrumbs_separator_disable_option['seopress_breadcrumbs_separator_disable'];
		 }
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//The Breadcrumbs
///////////////////////////////////////////////////////////////////////////////////////////////////
if (seopress_breadcrumbs_enable_option() =='1' || seopress_breadcrumbs_json_enable_option() =='1') {
	function seopress_display_breadcrumbs($echo = true) {
		/**i18n**/
		//Home
		if (seopress_breadcrumbs_i18n_home_option() !='') {
			$i18n_home = seopress_breadcrumbs_i18n_home_option();
		} else {
			$i18n_home = __('Home','wp-seopress-pro');
		}
		//404 error
		if (seopress_breadcrumbs_i18n_404_option() !='') {
			$i18n_404 = seopress_breadcrumbs_i18n_404_option();
		} else {
			$i18n_404 = __('404 error', 'wp-seopress-pro');
		}
		//Search results for
		if (seopress_breadcrumbs_i18n_search_option() !='') {
			$i18n_search_results = seopress_breadcrumbs_i18n_search_option();
		} else {
			$i18n_search_results = __('Search results for: ','wp-seopress-pro');
		}		
		//No results
		if (seopress_breadcrumbs_i18n_no_results_option() !='') {
			$i18n_no_results = seopress_breadcrumbs_i18n_no_results_option();
		} else {
			$i18n_no_results = __('No results','wp-seopress-pro');
		}

		//Globals
		global $post, $wp_query;

		//Init
		$crumbs = array();

		//Separator
		if (seopress_breadcrumbs_separator_disable_option() !='') {
			$seopress_display_breadcrumbs_separator = NULL;
		} elseif (seopress_breadcrumbs_separator_option()) {
			$seopress_display_breadcrumbs_separator = '&nbsp;'.seopress_breadcrumbs_separator_option().'&nbsp;';
		} else {
			$seopress_display_breadcrumbs_separator = ' - ';
		}

		$seopress_display_breadcrumbs_separator = apply_filters('seopress_pro_breadcrumbs_sep',$seopress_display_breadcrumbs_separator);

		//Home prefix
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( 'polylang/polylang.php' ) || is_plugin_active( 'polylang-pro/polylang.php' )) {
			$real_home = pll_home_url();
		} else {
			$real_home = get_home_url();
		}

		$crumbs[] = array(
			0 => $i18n_home, 
			1 => $real_home
		);

		//404
		if (is_404()) {
			$crumbs[] = array(
				0 => $i18n_404, 
			);
		}

		//Attachment
		if (is_attachment()) {
			$crumbs[] = array(
				0 => __('Attachments','wp-seopress-pro'), 
			);
		}

		//Single
		if (is_single() && (!is_home() && !is_front_page()) ) {
			if( is_singular( 'tribe_events' ) ){ //Events calendar
				$queried_object = get_queried_object();
				$post_type = get_post_type_object( 'tribe_events' );

				$crumbs[] = array(
					0 => $post_type->labels->name, 
					1 => esc_url(tribe_get_events_link())
				);
				
				if (get_post_meta($queried_object->ID,'_seopress_robots_breadcrumbs',true) !='') {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_post_meta($queried_object->ID,'_seopress_robots_breadcrumbs',true)), 
						1 => esc_url( tribe_get_event_link($queried_object->ID))
					);
				} else {
					$crumbs[] = array(
						0 => wp_strip_all_tags($queried_object->post_title), 
						1 => esc_url( tribe_get_event_link($queried_object->ID))
					);
				}
				
			} elseif ( 'post' != get_post_type( $post ) ) {
				$post_type = get_post_type_object( get_post_type( $post ) );
				if ($post_type->has_archive =='1' || $post_type->has_archive == true) {
					if (function_exists('is_shop') && 'product' == get_post_type( $post )) {

						//Shop base
						if (seopress_breadcrumbs_remove_shop_page_option() !='1') {
							$crumbs[] = array(
								0 => wp_strip_all_tags(get_the_title(get_option( 'woocommerce_shop_page_id' ))), 
								1 => get_page_link(get_option( 'woocommerce_shop_page_id' ))
							);
						}

           				$product_cat = current(wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' )));

           				$ancestors_cat = get_ancestors($product_cat->term_id, 'product_cat');

						$ancestors_crumb = array_reverse($ancestors_cat);

						if (!empty($ancestors_crumb)) {
							foreach ($ancestors_crumb as $key => $value) {
								$term = get_term($value, 'product_cat');

								$crumbs[] = array(
									0 => wp_strip_all_tags($term->name), 
									1 => get_term_link($value)
								);
							}
						}

						if ( $product_cat ) {
							$crumbs[] = array(
								0 => $product_cat->name, 
								1 => get_term_link($product_cat)
							);
						}

					} else {
						$crumbs[] = array(
							0 => $post_type->labels->name, 
							1 => get_post_type_archive_link(get_post_type($post))
						);
					}

					if ( $post->post_parent ) { //If post has parent pages
						$parent_id = $post->post_parent;
						while ( $parent_id ) {
							$page          = get_post( $parent_id );
							$parent_id     = $page->post_parent;
							if (get_post_meta($page->ID,'_seopress_robots_breadcrumbs',true) !='') {
								$parent_crumbs[] = array( wp_strip_all_tags(get_post_meta($page->ID,'_seopress_robots_breadcrumbs',true)), get_permalink( $page->ID ));
							} else {
								$parent_crumbs[] = array( get_the_title( $page->ID ), get_permalink( $page->ID ) );
							}
						}
		
						$parent_crumbs = array_reverse( $parent_crumbs );
		
						foreach ( $parent_crumbs as $crumb ) {
							$crumbs[] = array(
								0 => $crumb[0], 
								1 => $crumb[1]
							);
						}
					}

					if (get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true) !='') {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true)), 
							1 => get_the_permalink()
						);
					} else {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_the_title()), 
							1 => get_the_permalink()
						);
					}
				} else {
					$crumbs[] = array(
						0 => $post_type->labels->name, 
					);
					
					if (get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true) !='') {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true)), 
							1 => get_the_permalink()
						);
					} else {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_the_title()), 
							1 => get_the_permalink()
						);
					}
				}
			} else {
				//Blog parent page
				if (seopress_breadcrumbs_remove_blog_page_option() !='1') {
					if (get_option('show_on_front') =='page' && get_option('page_for_posts') !='0') {
						if (get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs',true) !='') {
							$crumbs[] = array(
								0 => wp_strip_all_tags(get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs', true)), 
								1 => get_the_permalink(get_option('page_for_posts'))
							);
						} else {
							$crumbs[] = array(
								0 => wp_strip_all_tags(get_the_title(get_option('page_for_posts'))), 
								1 => get_the_permalink(get_option('page_for_posts'))
							);
						}
					}
				}

				if (get_post_meta($post->ID,'_seopress_robots_primary_cat',true)) {
					$_seopress_robots_primary_cat = get_post_meta($post->ID,'_seopress_robots_primary_cat',true);
					
					if (isset($_seopress_robots_primary_cat) && $_seopress_robots_primary_cat !='' && $_seopress_robots_primary_cat !='none') {
						if ($post->post_type !=NULL && $post->post_type =='post') {
							$current_cat = get_category($_seopress_robots_primary_cat);
						} elseif ($post->post_type !=NULL && $post->post_type =='product') {
							$current_cat = get_term($_seopress_robots_primary_cat, 'product_cat');
						}
					} else {
						$current_cat = current( get_the_category( $post ) );
					}
				} else {
					$current_cat = current( get_the_category( $post ) );
				}

				$ancestors_cat = get_ancestors($current_cat->term_id, 'category');

				$ancestors_crumb = array_reverse($ancestors_cat);

				if (!empty($ancestors_crumb)) {
					foreach ($ancestors_crumb as $key => $value) {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_cat_name( $value )), 
							1 => get_category_link($value)
						);
					}
				}

				if ( $current_cat ) {
					$crumbs[] = array(
						0 => $current_cat->name, 
						1 => get_term_link($current_cat)
					);
				}

				//Default single post (custom + default)
				if (get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true) !='') {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true)), 
						1 => get_the_permalink()
					);
				} else {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_the_title()), 
						1 => get_the_permalink()
					);
				}
			}
		}

		//Page
		if (is_page() && (!is_home() && !is_front_page())) {
			if ( $post->post_parent ) { //If post has parent pages
				$parent_id = $post->post_parent;
				while ( $parent_id ) {
					$page          = get_post( $parent_id );
					$parent_id     = $page->post_parent;
					if (get_post_meta($page->ID,'_seopress_robots_breadcrumbs',true) !='') {
						$parent_crumbs[] = array( wp_strip_all_tags(get_post_meta($page->ID,'_seopress_robots_breadcrumbs',true)), get_permalink( $page->ID ));
					} else {
						$parent_crumbs[] = array( get_the_title( $page->ID ), get_permalink( $page->ID ) );
					}
				}

				$parent_crumbs = array_reverse( $parent_crumbs );

				foreach ( $parent_crumbs as $crumb ) {
					$crumbs[] = array(
						0 => $crumb[0], 
						1 => $crumb[1]
					);
				}
			} elseif (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url()) { //WooCommerce Endpoint
				$crumbs[] = array(
					0 => get_the_title(), 
					1 => get_permalink()
				);
			}
			//Current page
			if (function_exists('is_wc_endpoint_url') && is_wc_endpoint_url()) {

			} else {
				if (get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true) !='') {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_post_meta(get_the_id(),'_seopress_robots_breadcrumbs',true)), 
						1 => get_the_permalink()
					);
				} else {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_the_title()), 
						1 => get_the_permalink()
					);
				}
			}	
		}

		//Blog
		if (is_home()) {
			if (get_option('show_on_front') =='page' && get_option('page_for_posts') !='0') {
				if (get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs',true) !='') {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs', true)), 
						1 => get_the_permalink(get_option('page_for_posts'))
					);
				} else {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_the_title(get_option('page_for_posts'))), 
						1 => get_the_permalink(get_option('page_for_posts'))
					);
				}
			}
		}

		//Post Type Archives
		if (is_post_type_archive( 'tribe_events' )) { //Events calendar
			$post_type = get_post_type_object( 'tribe_events' );

			$crumbs[] = array(
				0 => wp_strip_all_tags($post_type->labels->name), 
				1 => esc_url(tribe_get_events_link())
			);
		} elseif (is_post_type_archive()) {
			$post_type = get_post_type_object( get_post_type() );
			if ( $post_type =='product') {
				$crumbs[] = array(
					0 => wp_strip_all_tags(get_the_title(get_option( 'woocommerce_shop_page_id' ))), 
					1 => get_post_type_archive_link('product')
				);
			} elseif(function_exists("is_shop") && is_shop() && is_search()) {
				$crumbs[] = array(
					0 => wp_strip_all_tags(get_the_title(get_option( 'woocommerce_shop_page_id' ))), 
					1 => get_permalink( get_option( 'woocommerce_shop_page_id' ))
				);
			} elseif(function_exists("is_shop") && is_shop()) {
				$crumbs[] = array(
					0 => wp_strip_all_tags(get_the_title(get_option( 'woocommerce_shop_page_id' ))), 
					1 => get_page_link(get_option( 'woocommerce_shop_page_id' ))
				);
			} elseif ($post_type) {
				$crumbs[] = array(
					0 => wp_strip_all_tags($post_type->labels->name), 
					1 => get_post_type_archive_link($post_type->name)
				);
			} else {
				$crumbs[] = array(
					0 => $i18n_no_results
				);
			}
		}

		//Date Archives
		if (is_date()) {
			if ( is_year() || is_month()) {
				$crumbs[] = array(
					0 => get_the_time('Y'), 
					1 => get_year_link(get_the_time('Y'))
				);
			}
			if ( is_month()) {
				$crumbs[] = array(
					0 => get_the_time('F'), 
					1 => get_month_link(get_the_time('Y'), get_the_time('m'))
				);
			}
		}

		//Author Archives
		if (is_author()) {
			global $author;

			$author_name = get_userdata($author);

			$crumbs[] = array(
				0 => __('Author: ','wp-seopress-pro').$author_name->display_name, 
				1 => get_author_posts_url($author_name->ID)
			);
		}

		//Tag Archives
		if (is_tag()) {
			//Blog parent page
			if (seopress_breadcrumbs_remove_blog_page_option() !='1') {
				if (get_option('show_on_front') =='page' && get_option('page_for_posts') !='0') {
					if (get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs',true) !='') {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs', true)), 
							1 => get_the_permalink(get_option('page_for_posts'))
						);
					} else {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_the_title(get_option('page_for_posts'))), 
							1 => get_the_permalink(get_option('page_for_posts'))
						);
					}
				}
			}

			$current_tag = get_queried_object()->term_id;

			$crumbs[] = array(
				0 => wp_strip_all_tags(single_tag_title('', false)), 
				1 => get_tag_link($current_tag)
			);
		}

		//Category Archives
		if (is_category()) {
			//Blog parent page
			if (seopress_breadcrumbs_remove_blog_page_option() !='1') {
				if (get_option('show_on_front') =='page' && get_option('page_for_posts') !='0') {
					if (get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs',true) !='') {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_post_meta(get_option('page_for_posts'),'_seopress_robots_breadcrumbs', true)), 
							1 => get_the_permalink(get_option('page_for_posts'))
						);
					} else {
						$crumbs[] = array(
							0 => wp_strip_all_tags(get_the_title(get_option('page_for_posts'))), 
							1 => get_the_permalink(get_option('page_for_posts'))
						);
					}
				}
			}
			$current_cat = get_category($GLOBALS['wp_query']->get_queried_object());

			$ancestors_cat = get_ancestors($current_cat->term_id, 'category');

			$ancestors_crumb = array_reverse($ancestors_cat);

			if (!empty($ancestors_crumb)) {
				foreach ($ancestors_crumb as $key => $value) {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_cat_name( $value )), 
						1 => get_category_link($value)
					);
				}
			}

			if ( $current_cat && is_paged() ) {
				$crumbs[] = array(
					0 => $current_cat->name, 
					1 => get_category_link($current_cat->term_id)
				);
			} else {
				$crumbs[] = array(
					0 => wp_strip_all_tags($current_cat->name), 
					1 => get_category_link($current_cat->term_id)
				);
			}
		}

		//Taxonomies
		if (is_tax()) {
			$current_term = $GLOBALS['wp_query']->get_queried_object();
			$taxonomy  = get_taxonomy( $current_term->taxonomy );

			//WC Cat // WC Tag
			if (seopress_breadcrumbs_remove_shop_page_option() !='1') {
				if ($taxonomy->query_var =='product_cat' || $taxonomy->query_var =='product_tag') {
					$crumbs[] = array(
						0 => wp_strip_all_tags(get_the_title(get_option( 'woocommerce_shop_page_id' ))), 
						1 => get_page_link(get_option( 'woocommerce_shop_page_id' ))
					);
				}
			}

			if ( 0 != $current_term->parent ) {
				$ancestors_term = get_ancestors( $current_term->term_id, $current_term->taxonomy );

				$ancestors_crumb = array_reverse($ancestors_term);

				foreach ($ancestors_crumb as $key => $value) {
					$current_term_name = get_term( $value, $current_term->taxonomy );
					$crumbs[] = array(
						0 => wp_strip_all_tags($current_term_name->name), 
						1 => get_term_link($value)
					);
				}
			}

			$crumbs[] = array(
				0 => wp_strip_all_tags(single_term_title( '', false )), 
				1 => get_term_link($current_term)
			);
		}

		//Search results
		if (is_search()) {
			$s_query = '';
			if (get_search_query() !='') {
				$s_query = urlencode( get_query_var( 's' ));
			}

			$crumbs[] = array(
				0 => $i18n_search_results.get_search_query(), 
				1 => get_search_link($s_query)
			);
		}

		//Pagination
		if (is_paged()) {
			global $wp;
			$current_url = home_url(add_query_arg(array(), $wp->request ));

			$current_page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

			$crumbs[] = array(
				0 => __('Page ','wp-seopress-pro').$current_page, 
				1 => $current_url
			);
		}

		//WooCommerce Endpoint
		if (function_exists('is_wc_endpoint_url') && function_exists('wc_get_account_endpoint_url')) {
			if (is_wc_endpoint_url()) {
				$crumbs[] = array(
					0 => wp_strip_all_tags(WC()->query->get_endpoint_title(WC()->query->get_current_endpoint())), 
					1 => wc_get_account_endpoint_url(WC()->query->get_current_endpoint())
				);
			}
			
		}

		//Render
		if ((is_front_page() && is_paged() ) || !is_front_page()) {
			$inline_css = "<style>.breadcrumb {list-style: none;margin:0}.breadcrumb li {margin:0;display:inline}</style>";

			$inline_css = apply_filters('seopress_pro_breadcrumbs_css',$inline_css);

			$sp_breadcrumbs = $inline_css;

			$sp_breadcrumbs_html = '';

			if ( empty( $crumbs ) || ! is_array( $crumbs ) ) {
				return;
			}

			//Schema.org itemListElement
			$crumbs = apply_filters('seopress_pro_breadcrumbs_crumbs', $crumbs);
			$last_key = array_keys($crumbs);
			$last_key = array_pop($last_key);
			
		    foreach ($crumbs as $key => $crumb) {
		    	$sep = $key;
		    	if ($last_key != $sep) {
		    		$sp_breadcrumbs_html .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="'.seopress_check_ssl().'schema.org/ListItem">';
		    	} else {
					$sp_breadcrumbs_html .= '<li class="breadcrumb-item active" aria-current="page" itemprop="itemListElement" itemscope itemtype="'.seopress_check_ssl().'schema.org/ListItem">';
		    	}
			    if ( ! empty( $crumb[1] )  ) {
			    	$sp_breadcrumbs_html .= '<a itemtype="http://schema.org/Thing" itemprop="item" href="'.$crumb[1].'">';
			    }
			    $sp_breadcrumbs_html .= '<span itemprop="name">'.$crumb[0].'</span>';
			    if ( ! empty( $crumb[1] )  ) {
			    	$sp_breadcrumbs_html .= '</a>';
			    }
			    $key = $key + 1;
			    $sp_breadcrumbs_html .= '<meta itemprop="position" content="'.$key.'" />';
			    $sp_breadcrumbs_html .= '</li>';
			    if ($last_key != $sep) {
			    	$sp_breadcrumbs_html .= $seopress_display_breadcrumbs_separator;
			    }
		    }

			$sp_breadcrumbs .= '<nav aria-label="'.esc_html__('breadcrumb','wp-seopress-pro').'"><ol class="breadcrumb" itemscope itemtype="'.seopress_check_ssl().'schema.org/BreadcrumbList">'.$sp_breadcrumbs_html.'</ol></nav>';

			$sp_breadcrumbs = apply_filters('seopress_pro_breadcrumbs_html', $sp_breadcrumbs);

			//JSON-LD
			if (seopress_breadcrumbs_json_enable_option() =='1') {
				if ( empty( $crumbs ) || ! is_array( $crumbs ) ) {
					return;
				}

				$sp_breadcrumbs_json = array();
				$sp_breadcrumbs_json = array('@context' => seopress_check_ssl().'schema.org', '@type' => 'BreadcrumbList');

				$sp_breadcrumbs_json['itemListElement'] = array();

			    foreach ($crumbs as $key => $crumb) {
			    	$sp_breadcrumbs_json['itemListElement'][$key] = array(
				    	'@type' => 'ListItem',
					    'position' => $key + 1,
						'name' => $crumb[0],						
					);

			    	//Check if URL is available
					if ( ! empty( $crumb[1] )  ) {
						$sp_breadcrumbs_json['itemListElement'][$key]['item'] = $crumb[1];
					}
			    }
			}
									
			if (seopress_breadcrumbs_json_enable_option() =='1') {
				$jsonld = '<script type="application/ld+json">';
				$jsonld .= json_encode($sp_breadcrumbs_json);
				$jsonld .= '</script>';
				$jsonld .= "\n";
			}

			if (seopress_breadcrumbs_enable_option() =='1' ) {
				if ($echo === true) {
					do_action('seopress_breadcrumbs_before_html');
					echo $sp_breadcrumbs;
					do_action('seopress_breadcrumbs_after_html');
				} elseif ($echo === false) {
					return do_action('seopress_breadcrumbs_before_html').$sp_breadcrumbs.do_action('seopress_breadcrumbs_after_html');
				}
			}

			if (seopress_breadcrumbs_json_enable_option() =='1' && $echo ==='json') {
				return $jsonld;
			}
		}
	}
	//Shortcode
	function seopress_shortcode_breadcrumbs(){
		return seopress_display_breadcrumbs(false);
	}
	if (seopress_breadcrumbs_enable_option() =='1') {
		add_shortcode( 'seopress_breadcrumbs', 'seopress_shortcode_breadcrumbs' );
	}

	//JSON-LD
	if (seopress_breadcrumbs_json_enable_option() =='1') {
		add_action('wp_head','seopress_jsonld_breadcrumbs', 2);
		function seopress_jsonld_breadcrumbs() {
			echo seopress_display_breadcrumbs('json');
		}
	}
}