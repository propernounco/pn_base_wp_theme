<?php
/*
Plugin Name: SEOPress PRO
Plugin URI: https://www.seopress.org/seopress-pro/
Description: The PRO version of SEOPress. SEOPress required (free).
Version: 3.7.8
Author: SEOPress
Author URI: https://www.seopress.org/seopress-pro/
License: GPLv2
Text Domain: wp-seopress-pro
Domain Path: /languages
*/

/*  Copyright 2016 - 2019 - Benjamin Denis  (email : contact@seopress.org)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// To prevent calling the plugin directly
if ( !function_exists( 'add_action' ) ) {
    echo 'Please don&rsquo;t call the plugin directly. Thanks :)';
    exit;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Hooks activation
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_pro_activation() {
    add_option( 'seopress_pro_activated', 'yes' );
    
    flush_rewrite_rules();
    
    if (!wp_next_scheduled('seopress_404_cron_cleaning') ) {
        wp_schedule_event( time(), 'daily', 'seopress_404_cron_cleaning');
    }
    
    do_action('seopress_pro_activation');
}
register_activation_hook(__FILE__, 'seopress_pro_activation');

function seopress_pro_deactivation() {
    delete_option( 'seopress_pro_activated' );
    flush_rewrite_rules();
    wp_clear_scheduled_hook('seopress_404_cron_cleaning');
    do_action('seopress_pro_deactivation');
}
register_deactivation_hook(__FILE__, 'seopress_pro_deactivation');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Define
///////////////////////////////////////////////////////////////////////////////////////////////////
define( 'SEOPRESS_PRO_VERSION', '3.7.8' ); 
define( 'SEOPRESS_PRO_AUTHOR', 'Benjamin Denis' ); 
define( 'STORE_URL_SEOPRESS', 'https://www.seopress.org' );
define( 'ITEM_ID_SEOPRESS', 113);
define( 'ITEM_NAME_SEOPRESS', 'SEOPress PRO');
define( 'SEOPRESS_LICENSE_PAGE', 'seopress-license' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//SEOPRESS PRO INIT
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_pro_init() {
    load_plugin_textdomain( 'wp-seopress-pro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    global $pagenow;

    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if (is_plugin_active('wp-seopress/seopress.php')) {
        if ( is_admin() || is_network_admin() ) {
            require_once dirname( __FILE__ ) . '/inc/admin/admin.php';
            require_once dirname( __FILE__ ) . '/inc/admin/ajax.php';
            if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
                require_once dirname( __FILE__ ) . '/inc/admin/admin-metaboxes.php';
            }
            global $pagenow;
            if ( $pagenow == 'index.php' ) {
                require_once dirname( __FILE__ ) . '/inc/admin/dashboard-google-analytics.php';
            }

            //CSV Import
            include_once dirname( __FILE__ ) . '/inc/admin/import/class-csv-wizard.php';
        }

        require_once dirname( __FILE__ ) . '/inc/admin/redirections.php';
        require_once dirname( __FILE__ ) . '/inc/admin/bot.php';
        require_once dirname( __FILE__ ) . '/inc/functions/bot/seopress-bot.php';
        require_once dirname( __FILE__ ) . '/inc/admin/backlinks.php';
        require_once dirname( __FILE__ ) . '/inc/functions/options.php';

        //TranslationsPress
        if (!class_exists( 'SEOPRESS_Language_Packs' )) {
            require_once dirname( __FILE__ ) . '/inc/admin/updater/t15s-registry.php';
        }
    }
}
add_action('plugins_loaded', 'seopress_pro_init', 999);

///////////////////////////////////////////////////////////////////////////////////////////////////
//TranslationsPress
///////////////////////////////////////////////////////////////////////////////////////////////////

function seopress_init_t15s() {
    if (class_exists( 'SEOPRESS_Language_Packs' )) {
        $t15s_updater = new SEOPRESS_Language_Packs(
            'plugin',
            'wp-seopress-pro',
            'https://s3.eu-central-1.amazonaws.com/api.translationspress.com/seopress/wp-seopress-pro/wp-seopress-pro.json'
        );
        $project = $t15s_updater->add_project();
    }
}
add_action('init', 'seopress_init_t15s');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Check if a feature is ON
///////////////////////////////////////////////////////////////////////////////////////////////////

// Is WooCommerce enable?
function seopress_get_toggle_woocommerce_option() {
    $seopress_get_toggle_woocommerce_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_woocommerce_option ) ) {
        foreach ($seopress_get_toggle_woocommerce_option as $key => $seopress_get_toggle_woocommerce_value)
            $options[$key] = $seopress_get_toggle_woocommerce_value;
         if (isset($seopress_get_toggle_woocommerce_option['toggle-woocommerce'])) { 
            return $seopress_get_toggle_woocommerce_option['toggle-woocommerce'];
         }
    }
}
// Is EDD enable?
function seopress_get_toggle_edd_option() {
    $seopress_get_toggle_edd_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_edd_option ) ) {
        foreach ($seopress_get_toggle_edd_option as $key => $seopress_get_toggle_edd_value)
            $options[$key] = $seopress_get_toggle_edd_value;
         if (isset($seopress_get_toggle_edd_option['toggle-edd'])) { 
            return $seopress_get_toggle_edd_option['toggle-edd'];
         }
    }
}
// Is Local Business enable?
function seopress_get_toggle_local_business_option() {
    $seopress_get_toggle_local_business_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_local_business_option ) ) {
        foreach ($seopress_get_toggle_local_business_option as $key => $seopress_get_toggle_local_business_value)
            $options[$key] = $seopress_get_toggle_local_business_value;
         if (isset($seopress_get_toggle_local_business_option['toggle-local-business'])) { 
            return $seopress_get_toggle_local_business_option['toggle-local-business'];
         }
    }
}
// Is Dublin Core enable?
function seopress_get_toggle_dublin_core_option() {
    $seopress_get_toggle_dublin_core_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_dublin_core_option ) ) {
        foreach ($seopress_get_toggle_dublin_core_option as $key => $seopress_get_toggle_dublin_core_value)
            $options[$key] = $seopress_get_toggle_dublin_core_value;
         if (isset($seopress_get_toggle_dublin_core_option['toggle-dublin-core'])) { 
            return $seopress_get_toggle_dublin_core_option['toggle-dublin-core'];
         }
    }
}
// Is Rich Snippets enable?
function seopress_get_toggle_rich_snippets_option() {
    $seopress_get_toggle_rich_snippets_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_rich_snippets_option ) ) {
        foreach ($seopress_get_toggle_rich_snippets_option as $key => $seopress_get_toggle_rich_snippets_value)
            $options[$key] = $seopress_get_toggle_rich_snippets_value;
         if (isset($seopress_get_toggle_rich_snippets_option['toggle-rich-snippets'])) { 
            return $seopress_get_toggle_rich_snippets_option['toggle-rich-snippets'];
         }
    }
}
// Is Breadcrumbs enable?
function seopress_get_toggle_breadcrumbs_option() {
    $seopress_get_toggle_breadcrumbs_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_breadcrumbs_option ) ) {
        foreach ($seopress_get_toggle_breadcrumbs_option as $key => $seopress_get_toggle_breadcrumbs_value)
            $options[$key] = $seopress_get_toggle_breadcrumbs_value;
         if (isset($seopress_get_toggle_breadcrumbs_option['toggle-breadcrumbs'])) { 
            return $seopress_get_toggle_breadcrumbs_option['toggle-breadcrumbs'];
         }
    }
}
// Is Robots enable?
function seopress_get_toggle_robots_option() {
    $seopress_get_toggle_robots_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_robots_option ) ) {
        foreach ($seopress_get_toggle_robots_option as $key => $seopress_get_toggle_robots_value)
            $options[$key] = $seopress_get_toggle_robots_value;
         if (isset($seopress_get_toggle_robots_option['toggle-robots'])) { 
            return $seopress_get_toggle_robots_option['toggle-robots'];
         }
    }
}
// Is Google News enable?
function seopress_get_toggle_news_option() {
    $seopress_get_toggle_news_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_news_option ) ) {
        foreach ($seopress_get_toggle_news_option as $key => $seopress_get_toggle_news_value)
            $options[$key] = $seopress_get_toggle_news_value;
         if (isset($seopress_get_toggle_news_option['toggle-news'])) { 
            return $seopress_get_toggle_news_option['toggle-news'];
         }
    }
}
// Is 404/301 enable?
function seopress_get_toggle_404_option() {
    $seopress_get_toggle_404_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_404_option ) ) {
        foreach ($seopress_get_toggle_404_option as $key => $seopress_get_toggle_404_value)
            $options[$key] = $seopress_get_toggle_404_value;
         if (isset($seopress_get_toggle_404_option['toggle-404'])) { 
            return $seopress_get_toggle_404_option['toggle-404'];
         }
    }
}
// Is Bot enable?
function seopress_get_toggle_bot_option() {
    $seopress_get_toggle_bot_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_bot_option ) ) {
        foreach ($seopress_get_toggle_bot_option as $key => $seopress_get_toggle_bot_value)
            $options[$key] = $seopress_get_toggle_bot_value;
         if (isset($seopress_get_toggle_bot_option['toggle-bot'])) { 
            return $seopress_get_toggle_bot_option['toggle-bot'];
         }
    }
}
//Google Data Structured Types metaboxe ON?
function seopress_rich_snippets_enable_option() {
    $seopress_rich_snippets_enable_option = get_option("seopress_pro_option_name");
    if ( ! empty ( $seopress_rich_snippets_enable_option ) ) {
        foreach ($seopress_rich_snippets_enable_option as $key => $seopress_rich_snippets_enable_value)
            $options[$key] = $seopress_rich_snippets_enable_value;
         if (isset($seopress_rich_snippets_enable_option['seopress_rich_snippets_enable'])) { 
            return $seopress_rich_snippets_enable_option['seopress_rich_snippets_enable'];
         }
    }
}
//Rewrite ON?
function seopress_get_toggle_rewrite_option() {
    $seopress_get_toggle_rewrite_option = get_option("seopress_toggle");
    if ( ! empty ( $seopress_get_toggle_rewrite_option ) ) {
        foreach ($seopress_get_toggle_rewrite_option as $key => $seopress_get_toggle_rewrite_value)
            $options[$key] = $seopress_get_toggle_rewrite_value;
         if (isset($seopress_get_toggle_rewrite_option['toggle-rewrite'])) { 
            return $seopress_get_toggle_rewrite_option['toggle-rewrite'];
         }
    }
}
//White Label?
function seopress_get_toggle_white_label_option() {
    if (is_multisite()) {
        $seopress_toggle = get_blog_option(get_network()->site_id,"seopress_toggle");
    } else {
        $seopress_toggle = get_option("seopress_toggle");
    }
    $seopress_get_toggle_white_label_option = $seopress_toggle;
    if ( ! empty ( $seopress_get_toggle_white_label_option ) ) {
        foreach ($seopress_get_toggle_white_label_option as $key => $seopress_get_toggle_white_label_value)
            $options[$key] = $seopress_get_toggle_white_label_value;
         if (isset($seopress_get_toggle_white_label_option['toggle-white-label'])) { 
            return $seopress_get_toggle_white_label_option['toggle-white-label'];
         }
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//Loads the JS/CSS in admin
///////////////////////////////////////////////////////////////////////////////////////////////////
//Backlinks
function seopress_pro_admin_backlinks_scripts() {
    wp_enqueue_script( 'seopress-backlinks', plugins_url( 'assets/js/seopress-backlinks.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION, true );
    $seopress_backlinks = array(
        'seopress_nonce' => wp_create_nonce('seopress_backlinks_nonce'),
        'seopress_backlinks' => admin_url( 'admin-ajax.php'),
    );
    wp_localize_script( 'seopress-backlinks', 'seopressAjaxBacklinks', $seopress_backlinks );
}

//Google Page Speed
function seopress_pro_admin_ps_scripts() {
    wp_enqueue_script( 'seopress-pro-admin-easypiechart-js', plugins_url( 'assets/js/jquery.easypiechart.min.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION );
    wp_enqueue_script( 'seopress-pro-admin-google-chart-js', 'https://www.gstatic.com/charts/loader.js', array( 'jquery' ), SEOPRESS_PRO_VERSION );

    wp_enqueue_script( 'seopress-page-speed', plugins_url( 'assets/js/seopress-page-speed.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION, true );

    $seopress_request_page_speed = array(
        'seopress_nonce' => wp_create_nonce('seopress_request_page_speed_nonce'),
        'seopress_request_page_speed' => admin_url( 'admin-ajax.php'),
    );
    wp_localize_script( 'seopress-page-speed', 'seopressAjaxRequestPageSpeed', $seopress_request_page_speed );

    $seopress_clear_page_speed_cache = array(
        'seopress_nonce' => wp_create_nonce('seopress_clear_page_speed_cache_nonce'),
        'seopress_clear_page_speed_cache' => admin_url( 'admin-ajax.php'),
    );
    wp_localize_script( 'seopress-page-speed', 'seopressAjaxClearPageSpeedCache', $seopress_clear_page_speed_cache );
}

//SEOPRESS PRO Options page
function seopress_pro_add_admin_options_scripts($hook) {
    wp_register_style( 'seopress-pro-admin', plugins_url('assets/css/seopress-pro.min.css', __FILE__), array(), SEOPRESS_PRO_VERSION);
    wp_enqueue_style( 'seopress-pro-admin' );

    //Dashboard GA
    global $pagenow;
    if ( $pagenow == 'index.php' ) {
        wp_register_style( 'seopress-ga-dashboard-widget', plugins_url('assets/css/seopress-pro-dashboard.css', __FILE__), array(), SEOPRESS_PRO_VERSION);
        wp_enqueue_style( 'seopress-ga-dashboard-widget' );

        //GA Embed API
        wp_enqueue_script( 'seopress-pro-ga-embed', plugins_url( 'assets/js/chart.bundle.min.js', __FILE__ ), array(), SEOPRESS_PRO_VERSION );

        wp_enqueue_script( 'seopress-pro-ga', plugins_url( 'assets/js/seopress-pro-ga.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs' ), SEOPRESS_PRO_VERSION);

        $seopress_request_google_analytics = array(
            'seopress_nonce' => wp_create_nonce('seopress_request_google_analytics_nonce'),
            'seopress_request_google_analytics' => admin_url( 'admin-ajax.php'),
        );
        wp_localize_script( 'seopress-pro-ga', 'seopressAjaxRequestGoogleAnalytics', $seopress_request_google_analytics );
    }
    
    //GA tab
    if (isset($_GET['page']) && ($_GET['page'] == 'seopress-google-analytics')) {
        wp_enqueue_script( 'seopress-pro-ga-lock', plugins_url( 'assets/js/seopress-pro-ga-lock.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION, true );

        $seopress_google_analytics_lock = array(
            'seopress_nonce' => wp_create_nonce('seopress_google_analytics_lock_nonce'),
            'seopress_google_analytics_lock' => admin_url('admin-ajax.php'),
        );
        wp_localize_script( 'seopress-pro-ga-lock', 'seopressAjaxLockGoogleAnalytics', $seopress_google_analytics_lock );
    }

    //Pro Tabs
    if (isset($_GET['page']) && ($_GET['page'] == 'seopress-pro-page')) {
        wp_enqueue_script( 'seopress-pro-admin-tabs-js', plugins_url( 'assets/js/seopress-pro-tabs.js', __FILE__ ), array( 'jquery-ui-tabs' ), SEOPRESS_PRO_VERSION );
    }

    if (isset($_GET['page']) && ($_GET['page'] == 'seopress-pro-page' || $_GET['page'] == 'seopress-network-option') ) {
        //htaccess    
        wp_enqueue_script( 'seopress-save-htaccess', plugins_url( 'assets/js/seopress-htaccess.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION, true );

        $seopress_save_htaccess = array(
            'seopress_nonce' => wp_create_nonce('seopress_save_htaccess_nonce'),
            'seopress_save_htaccess' => admin_url( 'admin-ajax.php'),
        );
        wp_localize_script( 'seopress-save-htaccess', 'seopressAjaxSaveHtaccess', $seopress_save_htaccess );

        wp_enqueue_media();
    }

    //Google Page Speed
    if ( $hook == 'edit.php' ) {
        seopress_pro_admin_ps_scripts();
    } elseif (isset($_GET['page']) && ($_GET['page'] == 'seopress-pro-page')) {
        seopress_pro_admin_ps_scripts();
    }

    //Bot Tabs
    if (isset($_GET['page']) && ($_GET['page'] == 'seopress-bot-batch') ) {
        wp_enqueue_script( 'seopress-bot-admin-tabs-js', plugins_url( 'assets/js/seopress-bot-tabs.js', __FILE__ ), array( 'jquery-ui-tabs' ), SEOPRESS_PRO_VERSION );

        $seopress_bot = array(
            'seopress_nonce' => wp_create_nonce('seopress_request_bot_nonce'),
            'seopress_request_bot' => admin_url( 'admin-ajax.php'),
        );
        wp_localize_script( 'seopress-bot-admin-tabs-js', 'seopressAjaxBot', $seopress_bot );
    }

    //Backlinks
    if (isset($_GET['post_type']) && ($_GET['post_type'] == 'seopress_backlinks')) {
        seopress_pro_admin_backlinks_scripts();
    }

    //License
    if (isset($_GET['page']) && ($_GET['page'] == 'seopress-license') ) {
        wp_enqueue_script( 'seopress-license', plugins_url( 'assets/js/seopress-pro-license.js', __FILE__ ), array( 'jquery' ), SEOPRESS_PRO_VERSION, true );

        $seopress_request_reset_license = array(
            'seopress_nonce' => wp_create_nonce('seopress_request_reset_license_nonce'),
            'seopress_request_reset_license' => admin_url( 'admin-ajax.php'),
        );
        wp_localize_script( 'seopress-license', 'seopressAjaxResetLicense', $seopress_request_reset_license );
    }
}

add_action('admin_enqueue_scripts', 'seopress_pro_add_admin_options_scripts', 10, 1);

///////////////////////////////////////////////////////////////////////////////////////////////////
//SEOPress PRO Notices
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_pro_notice() {
    if ( !is_plugin_active( 'wp-seopress/seopress.php' ) && current_user_can('manage_options') ) {
        ?>
        <div class="error notice">
            <p>
                <?php _e( 'Please enable <strong>SEOPress</strong> in order to use SEOPress PRO.', 'wp-seopress-pro' ); ?>
                <a href="<?php echo esc_url( admin_url('plugin-install.php?tab=plugin-information&plugin=wp-seopress&TB_iframe=true&width=600&height=550')); ?>" class="thickbox button-primary" target="_blank"><?php _e('Enable / Download now!','wp-seopress-pro'); ?></a>
            </p>
        </div>
        <?php
    }
}
add_action( 'admin_notices', 'seopress_pro_notice' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//Shortcut settings page
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('plugin_action_links', 'seopress_pro_plugin_action_links', 10, 2);

function seopress_pro_plugin_action_links($links, $file) {
    static $this_plugin;

    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }

    if ($file == $this_plugin) {
        $settings_link = '<a href="' . admin_url( 'admin.php?page=seopress-pro-page'). '">'.__("Settings","wp-seopress-pro").'</a>';
        $website_link = '<a href="https://www.seopress.org/support/" target="_blank">'.__("Support","wp-seopress-pro").'</a>';

        if (get_option( 'seopress_pro_license_status' ) !='valid') {
            $license_link = '<a style="color:red;font-weight:bold" href="'.admin_url( 'admin.php?page=seopress-license').'">'.__("Activate your license","wp-seopress").'</a>';
        } else {
            $license_link = '<a href="'.admin_url( 'admin.php?page=seopress-license').'">'.__("License","wp-seopress").'</a>';
        }

        array_unshift($links, $settings_link, $website_link, $license_link);
    }

    return $links;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//SEOPress PRO Updater
///////////////////////////////////////////////////////////////////////////////////////////////////
if( !class_exists( 'SEOPRESS_Updater' ) && is_admin() ) {
    // load our custom updater
    require_once dirname( __FILE__ ) . '/inc/admin/updater/plugin-updater.php';
    require_once dirname( __FILE__ ) . '/inc/admin/updater/plugin-licence.php';
}

function SEOPRESS_Updater() {

    // retrieve our license key from the DB
    $license_key = trim(get_option('seopress_pro_license_key'));

    // setup the updater
    $edd_updater = new SEOPRESS_Updater(STORE_URL_SEOPRESS, __FILE__, array(
            'version'   => SEOPRESS_PRO_VERSION, 
            'license'   => $license_key,
            'item_id'   => ITEM_ID_SEOPRESS,
            'author'    => SEOPRESS_PRO_AUTHOR,
            'url'       => home_url(),
            'beta'      => false
        )
    );
}
add_action('admin_init', 'SEOPRESS_Updater', 0);

///////////////////////////////////////////////////////////////////////////////////////////////////
//Google News Sitemap
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_xml_sitemap_news_enable_option() {
    $seopress_xml_sitemap_news_enable_option = get_option("seopress_pro_option_name");
    if ( ! empty ( $seopress_xml_sitemap_news_enable_option ) ) {
        foreach ($seopress_xml_sitemap_news_enable_option as $key => $seopress_xml_sitemap_news_enable_value)
            $options[$key] = $seopress_xml_sitemap_news_enable_value;
         if (isset($seopress_xml_sitemap_news_enable_option['seopress_news_enable'])) { 
            return $seopress_xml_sitemap_news_enable_option['seopress_news_enable'];
         }
    }
}

if (seopress_xml_sitemap_news_enable_option() =='1' && seopress_get_toggle_news_option() =='1') {

    add_action( 'init', 'seopress_google_news_rewrite' );
    add_action( 'query_vars', 'seopress_google_news_query_vars' );
    add_action( 'template_include', 'seopress_google_news_change_template', 9999 );

    //WPML compatibility
    if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
        add_filter( 'request', 'seopress_wpml_block_secondary_languages2' );
    }
    function seopress_wpml_block_secondary_languages2( $q ) {
        $current_language = apply_filters( 'wpml_current_language', false );
        $default_language = apply_filters( 'wpml_default_language', false );
        if ( $current_language !== $default_language ) {
            unset( $q['seopress_news'] );
        }
        return $q;
    }

    function seopress_google_news_rewrite() {
        //Google News
        if (seopress_xml_sitemap_news_enable_option() !='') {
            add_rewrite_rule( 'sitemaps/news.xml?$', 'index.php?seopress_news=1', 'top' );
        }
    }

    function seopress_google_news_query_vars($vars) {
        $vars[] = 'seopress_news';
        return $vars;
    }

    function seopress_google_news_change_template( $template ) {
        if( get_query_var( 'seopress_news') === '1' ) {
            $seopress_news = plugin_dir_path( __FILE__ ) . 'inc/functions/google-news/template-xml-sitemaps-news.php';
            if( file_exists( $seopress_news ) ) {
                return $seopress_news;
            }
        }
        return $template;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Video XML Sitemap
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_xml_sitemap_video_enable_option() {
    $seopress_xml_sitemap_video_enable_option = get_option("seopress_xml_sitemap_option_name");
    if ( ! empty ( $seopress_xml_sitemap_video_enable_option ) ) {
        foreach ($seopress_xml_sitemap_video_enable_option as $key => $seopress_xml_sitemap_video_enable_value)
            $options[$key] = $seopress_xml_sitemap_video_enable_value;
         if (isset($seopress_xml_sitemap_video_enable_option['seopress_xml_sitemap_video_enable'])) { 
            return $seopress_xml_sitemap_video_enable_option['seopress_xml_sitemap_video_enable'];
         }
    }
}

if (seopress_xml_sitemap_video_enable_option() =='1' ) {
    add_action( 'init', 'seopress_video_xml_rewrite' );
    add_action( 'query_vars', 'seopress_video_xml_query_vars' );
    add_action( 'template_include', 'seopress_video_xml_change_template', 9999 );

    //WPML compatibility
    if ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
        add_filter( 'request', 'seopress_wpml_block_secondary_languages3' );
    }
    function seopress_wpml_block_secondary_languages3( $q ) {
        $current_language = apply_filters( 'wpml_current_language', false );
        $default_language = apply_filters( 'wpml_default_language', false );
        if ( $current_language !== $default_language ) {
            unset( $q['seopress_video'] );
        }
        return $q;
    }

    function seopress_video_xml_rewrite() {
        //XML Video sitemap
        if (seopress_xml_sitemap_video_enable_option() !='') {
            add_rewrite_rule( 'sitemaps/video.xml?$', 'index.php?seopress_video=1', 'top' );
        }
    }

    function seopress_video_xml_query_vars($vars) {
        $vars[] = 'seopress_video';
        return $vars;
    }

    function seopress_video_xml_change_template( $template ) {
        if( get_query_var( 'seopress_video') === '1' ) {
            $seopress_video = plugin_dir_path( __FILE__ ) . 'inc/functions/video-sitemap/template-xml-sitemaps-video.php';
            if( file_exists( $seopress_video ) ) {
                return $seopress_video;
            }
        }
        return $template;
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////
//Robots.txt
///////////////////////////////////////////////////////////////////////////////////////////////////
//Robots Enable
if (seopress_get_toggle_robots_option() =='1' || (!is_network_admin() && is_multisite())) {
    if (is_multisite()) {
        function seopress_pro_robots_enable_option() {
            $seopress_pro_mu_robots_enable_option = get_option("seopress_pro_mu_option_name");
            if ( ! empty ( $seopress_pro_mu_robots_enable_option ) ) {
                foreach ($seopress_pro_mu_robots_enable_option as $key => $seopress_pro_mu_robots_enable_value)
                    $options[$key] = $seopress_pro_mu_robots_enable_value;
                if (isset($seopress_pro_mu_robots_enable_option['seopress_mu_robots_enable'])) { 
                    return $seopress_pro_mu_robots_enable_option['seopress_mu_robots_enable'];
                }
            }
        }
    } else {
        function seopress_pro_robots_enable_option() {
            $seopress_pro_robots_enable_option = get_option("seopress_pro_option_name");
            if ( ! empty ( $seopress_pro_robots_enable_option ) ) {
                foreach ($seopress_pro_robots_enable_option as $key => $seopress_pro_robots_enable_value)
                    $options[$key] = $seopress_pro_robots_enable_value;
                if (isset($seopress_pro_robots_enable_option['seopress_robots_enable'])) { 
                    return $seopress_pro_robots_enable_option['seopress_robots_enable'];
                }
            }
        }
    }
    //Options Robots.txt
    if (seopress_pro_robots_enable_option() =='1') {
        //Rewrite Rules for Virtual Robots.txt
        add_action('init', 'seopress_robots_rewrite');
        add_action('query_vars', 'seopress_robots_query_vars');
        add_action('template_include', 'seopress_robots_change_template', 30);
        add_filter('redirect_canonical', 'seopress_robots_canonical', 10, 2);

        function seopress_robots_rewrite() {
            //Robots.txt
            add_rewrite_rule( '^robots\.txt', 'index.php?seopress_robots=1', 'top' );
        }

        function seopress_robots_query_vars($vars) {
            $vars[] = 'seopress_robots';
            return $vars;
        }

        function seopress_robots_change_template( $template ) {
            if( get_query_var( 'seopress_robots' ) === '1' ) {
                $seopress_robots = plugin_dir_path( __FILE__ ) . 'inc/functions/robots/template-robots.php';
                if( file_exists( $seopress_robots ) ) {
                    return $seopress_robots;
                }
            }
            return $template;
        }

        function seopress_robots_canonical($redirect_url, $requested_url) {
            if ($redirect_url == get_home_url().'/robots.txt/') { // robots.txt requested
                return false;
            } else {
                return $redirect_url;
            }
        }
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
// Highlight Current menu when Editing Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
add_filter('parent_file', 'seopress_submenu_current');
function seopress_submenu_current($current_menu) {
    global $pagenow;
    global $typenow;
    if ( $pagenow == 'post-new.php' || $pagenow == 'post.php' ) {
        if ( 'seopress_404' == $typenow || 'seopress_bot' == $typenow || 'seopress_backlinks' == $typenow || 'seopress_schemas' == $typenow ) { 
            global $plugin_page;
            $plugin_page = 'seopress-option';
        }
    }
    return $current_menu;
}

///////////////////////////////////////////////////////////////////////////////////////////////////
// 404 Cleaning CRON
///////////////////////////////////////////////////////////////////////////////////////////////////
//Enable CRON 404 cleaning
function seopress_404_cleaning_option() {
    $seopress_404_cleaning_option = get_option("seopress_pro_option_name");
    if ( ! empty ( $seopress_404_cleaning_option ) ) {
        foreach ($seopress_404_cleaning_option as $key => $seopress_404_cleaning_value)
            $options[$key] = $seopress_404_cleaning_value;
         if (isset($seopress_404_cleaning_option['seopress_404_cleaning'])) { 
            return $seopress_404_cleaning_option['seopress_404_cleaning'];
         }
    }
}

function seopress_404_cron_cleaning_action() {
    if (seopress_404_cleaning_option() ==='1') {
        $args = array(
            'date_query' => array(
                array(
                    'column' => 'post_date_gmt',
                    'before'  => '1 month ago',
                ),
            ),
            'posts_per_page' => -1,
            'post_type' => 'seopress_404',
            'meta_key'     => '_seopress_redirections_type',
            'meta_compare' => 'NOT EXISTS'
        );

        $args = apply_filters('seopress_404_cleaning_query', $args);

        // The Query
        $old_404_query = new WP_Query( $args );

        // The Loop
        if ( $old_404_query->have_posts() ) {
            while ( $old_404_query->have_posts() ) {
                $old_404_query->the_post();
                wp_delete_post(get_the_ID(),true);
            }
            /* Restore original Post Data */
            wp_reset_postdata();
        }
    }

}
add_action( 'seopress_404_cron_cleaning', 'seopress_404_cron_cleaning_action' );