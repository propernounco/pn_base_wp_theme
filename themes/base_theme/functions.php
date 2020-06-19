<?php
/**
 * Theme Functions
 *
 * This file contains functions that set up the theme and add any extra
 * or custom functionality.
 *
 * @package WordPress
 * @version 1.0
 */


/**
 * Maximum width allowed for any content
 *
 * @since 1.0
 */
if ( ! isset( $content_width ) ) {
    $content_width = 660;
}

if ( ! function_exists( 'theme_setup' ) ):
/**
 * bm Theme Setup
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since 1.0
 */

require_once('lib/functions.php');


function theme_setup() {

    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on twentyfifteen, use a find and replace
     * to change 'twentyfifteen' to the name of your theme in all the template files
     */
    load_theme_textdomain( 'bm', get_template_directory() . '/languages' );

    // Add RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 825, 510, true );
    add_image_size( 'featured-post', 550, 365 );
    add_image_size( 'post-main-image', 1080, 700 );
    add_image_size( 'logo', 9999999999, 42 );
    add_image_size( 'hero', 1880, 999999999 );
    add_image_size( 'square_sm', 600, 600 );
    add_image_size( 'square', 960, 960 );
    add_image_size( 'square_lg', 1240, 1240 );
    add_image_size( 'article', 1240, 99999 );
    add_image_size( 'dashboard-thumb', 250, 250, true ); // Hard Crop Mode

    // This theme uses wp_nav_menu() in two locations.
    register_nav_menus( array(
        'primary-nav' => __( 'Primary Navigation', 'bm' ),
        'top-links'  => __( 'Top Bar Links', 'bm' ),        
        'footer-links-one' => __( 'Footer Links One', 'bm'),
        'footer-links-two' => __( 'Footer Links Two', 'bm'),
        'footer-links-three' => __( 'Footer Links Three', 'bm'),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ) );

    /*
     * Enable support for Post Formats.
     *
     * See: https://codex.wordpress.org/Post_Formats
     */
    add_theme_support( 'post-formats', array(
        'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    ) );

}
endif; // bm_setup

add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Load required stylesheets & scripts
 * @since 1.0
 */

