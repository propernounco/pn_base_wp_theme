<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//RSS
//=================================================================================================
//Disable comments RSS feed
function seopress_rss_disable_comments_feed_option() {
	$seopress_rss_disable_comments_feed_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_disable_comments_feed_option ) ) {
		foreach ($seopress_rss_disable_comments_feed_option as $key => $seopress_rss_disable_comments_feed_value)
			$options[$key] = $seopress_rss_disable_comments_feed_value;
		 if (isset($seopress_rss_disable_comments_feed_option['seopress_rss_disable_comments_feed'])) { 
		 	return $seopress_rss_disable_comments_feed_option['seopress_rss_disable_comments_feed'];
		 }
	}
}
//Disable posts RSS feed
function seopress_rss_disable_posts_feed_option() {
	$seopress_rss_disable_posts_feed_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_disable_posts_feed_option ) ) {
		foreach ($seopress_rss_disable_posts_feed_option as $key => $seopress_rss_disable_posts_feed_value)
			$options[$key] = $seopress_rss_disable_posts_feed_value;
		 if (isset($seopress_rss_disable_posts_feed_option['seopress_rss_disable_posts_feed'])) { 
		 	return $seopress_rss_disable_posts_feed_option['seopress_rss_disable_posts_feed'];
		 }
	}
}
//Disable extra RSS feed
function seopress_rss_disable_extra_feed_option() {
	$seopress_rss_disable_extra_feed_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_disable_extra_feed_option ) ) {
		foreach ($seopress_rss_disable_extra_feed_option as $key => $seopress_rss_disable_extra_feed_value)
			$options[$key] = $seopress_rss_disable_extra_feed_value;
		 if (isset($seopress_rss_disable_extra_feed_option['seopress_rss_disable_extra_feed'])) { 
		 	return $seopress_rss_disable_extra_feed_option['seopress_rss_disable_extra_feed'];
		 }
	}
}
//Disable all RSS feeds
function seopress_rss_disable_all_feeds_option() {
	$seopress_rss_disable_all_feeds_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_disable_all_feeds_option ) ) {
		foreach ($seopress_rss_disable_all_feeds_option as $key => $seopress_rss_disable_all_feeds_value)
			$options[$key] = $seopress_rss_disable_all_feeds_value;
		 if (isset($seopress_rss_disable_all_feeds_option['seopress_rss_disable_all_feeds'])) { 
		 	return $seopress_rss_disable_all_feeds_option['seopress_rss_disable_all_feeds'];
		 }
	}
}

if (seopress_rss_disable_comments_feed_option() !='') {
	add_filter('feed_links_show_comments_feed', '__return_false');
}
if (seopress_rss_disable_posts_feed_option() !='') {
	remove_action('wp_head', 'feed_links', 2 );
}
if (seopress_rss_disable_extra_feed_option() !='') {
	remove_action('wp_head', 'feed_links_extra', 3 );
}
if (seopress_rss_disable_all_feeds_option() !='') {
	function seopress_rss_disable_feed() {
	    wp_die( __( 'No feed available.', 'wp-seopress-pro') );
	}

	add_action('do_feed', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_rdf', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_rss', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_rss2', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_atom', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_rss2_comments', 'seopress_rss_disable_feed', 1);
	add_action('do_feed_atom_comments', 'seopress_rss_disable_feed', 1);
}

//RSS HTML before post
function seopress_rss_before_html_option() {
	$seopress_rss_before_html_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_before_html_option ) ) {
		foreach ($seopress_rss_before_html_option as $key => $seopress_rss_before_html_value)
			$options[$key] = $seopress_rss_before_html_value;
		 if (isset($seopress_rss_before_html_option['seopress_rss_before_html'])) { 
		 	return $seopress_rss_before_html_option['seopress_rss_before_html'];
		 }
	}
}

//RSS HTML after post
function seopress_rss_after_html_option() {
	$seopress_rss_after_html_option = get_option("seopress_pro_option_name");
	if ( ! empty ( $seopress_rss_after_html_option ) ) {
		foreach ($seopress_rss_after_html_option as $key => $seopress_rss_after_html_value)
			$options[$key] = $seopress_rss_after_html_value;
		 if (isset($seopress_rss_after_html_option['seopress_rss_after_html'])) { 
		 	return $seopress_rss_after_html_option['seopress_rss_after_html'];
		 }
	}
}

function seopress_rss_html_display($content) {
	$content_before = NULL;
	$content_after = NULL;

	if (is_feed()) {
		global $post;
		$seopress_rss_template_variables_array = array(
			'%%sitetitle%%', 
			'%%tagline%%',
			'%%post_author%%',
			'%%post_permalink%%',
		);
		$seopress_rss_template_replace_array = array(
			get_bloginfo('name'), 
			get_bloginfo('description'),
			get_the_author_meta('display_name', $post->post_author),
			get_the_permalink(),
		);

		if (seopress_rss_before_html_option() !='') {
			$seopress_rss_before_html_option = str_replace($seopress_rss_template_variables_array, $seopress_rss_template_replace_array, seopress_rss_before_html_option());
			$content_before = $seopress_rss_before_html_option;
		}
		if (seopress_rss_after_html_option() !='') {
			$seopress_rss_after_html_option = str_replace($seopress_rss_template_variables_array, $seopress_rss_template_replace_array, seopress_rss_after_html_option());
			$content_after = $seopress_rss_after_html_option;
		}
	}
	return $content_before.$content.$content_after;
}
add_filter('the_excerpt_rss', 'seopress_rss_html_display');

