<?php

defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

class seopress_pro_options
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;
    
    /**
     * Start up
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ), 999 );
        add_action( 'admin_init', array( $this, 'pro_set_default_values' ), 10 );
        add_action( 'network_admin_menu', array( $this, 'add_network_plugin_page'), 10 );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }
    
    public function activate() {
        update_option($this->seopress_options, $this->data);
    }

    public function deactivate() {
        delete_option($this->seopress_options);
    }

    public function pro_set_default_values() {

        $seopress_pro_option_name = get_option('seopress_pro_option_name');

        //WooCommerce==============================================================================
        if ( is_plugin_active( 'woocommerce/woocommerce.php' )) {    
            $seopress_pro_option_name['seopress_woocommerce_cart_page_no_index'] = '1';
            $seopress_pro_option_name['seopress_woocommerce_checkout_page_no_index'] = '1';
            $seopress_pro_option_name['seopress_woocommerce_customer_account_page_no_index'] = '1';
            $seopress_pro_option_name['seopress_woocommerce_product_og_price'] = '1';
            $seopress_pro_option_name['seopress_woocommerce_product_og_currency'] = '1';
            $seopress_pro_option_name['seopress_woocommerce_meta_generator'] = '1';
        }

        //DublinCore===============================================================================
        $seopress_pro_option_name['seopress_dublin_core_enable'] = '1';

        add_option('seopress_pro_option_name', $seopress_pro_option_name);

        //BOT======================================================================================
        $seopress_bot_option_name['seopress_bot_scan_settings_post_types']['post']['include'] = '1';
        $seopress_bot_option_name['seopress_bot_scan_settings_post_types']['page']['include'] = '1';
        $seopress_bot_option_name['seopress_bot_scan_settings_404'] = '1';

        add_option('seopress_bot_option_name', $seopress_bot_option_name);
    }

    /**
     * Add options page
     */
    public function add_network_plugin_page() {
        if (has_filter('seopress_seo_admin_menu')) {
            $sp_seo_admin_menu['icon'] = apply_filters('seopress_seo_admin_menu', $sp_seo_admin_menu['icon']);
        } else {
            $sp_seo_admin_menu['icon'] = 'dashicons-admin-seopress';
        }
        
        add_menu_page(__('SEOPress Network settings'), 'SEO', 'manage_options', 'seopress-network-option', array( $this, 'create_network_admin_page' ), $sp_seo_admin_menu['icon'], 90);
 
    }

    public function add_plugin_page()
    {
        add_submenu_page('seopress-option', __('PRO','wp-seopress-pro'), __('PRO','wp-seopress-pro'), 'manage_options', 'seopress-pro-page', array( $this,'seopress_pro_page'));
        if (seopress_get_toggle_rich_snippets_option() =='1') {
            add_submenu_page('seopress-option', __('Schemas','wp-seopress-pro'), __('Schemas','wp-seopress-pro'), 'manage_options', 'edit.php?post_type=seopress_schemas', NULL);
        }
        if (seopress_get_toggle_404_option() =='1') {
            add_submenu_page('seopress-option', __('Redirections','wp-seopress-pro'), __('Redirections','wp-seopress-pro'), 'manage_options', 'edit.php?post_type=seopress_404', NULL);
        }
        if(seopress_get_toggle_bot_option()=='1') { 
            add_submenu_page('seopress-option', __('Broken links','wp-seopress-pro'), __('Broken links','wp-seopress-pro'), 'manage_options', 'edit.php?post_type=seopress_bot', NULL);
        }
        add_submenu_page('seopress-option', __('Backlinks','wp-seopress-pro'), __('Backlinks','wp-seopress-pro'), 'manage_options', 'edit.php?post_type=seopress_backlinks', NULL);
    }

    function seopress_pro_page(){
        if (is_network_admin() && is_multisite()) {
            $this->options = get_option( 'seopress_pro_mu_option_name' );
        } else {
            $this->options = get_option( 'seopress_pro_option_name' );
        }
        
        if (is_plugin_active('wp-seopress/seopress.php')) {
            if (function_exists('seopress_admin_header')) {
                echo seopress_admin_header();
            }
        }

        ?>
        <form method="post" action="<?php echo admin_url('options.php'); ?>" class="seopress-option">
        <?php
        echo '<div id="seopress-notice-save" style="display: none"><span class="dashicons dashicons-yes"></span><span class="html"></span></div>';

        global $wp_version, $title;
        $current_tab = '';
        $tag = version_compare( $wp_version, '4.4' ) >= 0 ? 'h1' : 'h2';
        echo '<'.$tag.'><span class="dashicons dashicons-editor-table"></span>'.$title.'</'.$tag.'>';
        if (is_network_admin() && is_multisite()) {
            settings_fields( 'seopress_pro_mu_option_group' );
        } else {
            settings_fields( 'seopress_pro_option_group' );
        }
        ?>

         <div id="seopress-tabs" class="wrap">
            <?php
                $plugin_settings_tabs = array(
                    'tab_seopress_local_business' => __( "Local Business", "wp-seopress-pro" ),
                    'tab_seopress_dublin_core' => __( "Dublin Core", "wp-seopress-pro" ),
                    'tab_seopress_rich_snippets' => __( "Structured Data Types (schema.org)", "wp-seopress-pro" ),
                    'tab_seopress_breadcrumbs' => __( "Breadcrumbs", "wp-seopress-pro" ),
                    'tab_seopress_woocommerce' => __( "WooCommerce", "wp-seopress-pro" ),
                    'tab_seopress_edd' => __( "Easy Digital Downloads", "wp-seopress-pro" ),
                    'tab_seopress_page_speed' => __( "Page Speed", "wp-seopress-pro" ),
                    'tab_seopress_robots' => __( "robots.txt", "wp-seopress-pro" ),
                    'tab_seopress_news' => __( "Google News", "wp-seopress-pro" ),
                    'tab_seopress_404' => __( "404", "wp-seopress-pro" ),
                    'tab_seopress_htaccess' => __( ".htaccess", "wp-seopress-pro" ),
                    'tab_seopress_rss' => __( "RSS", "wp-seopress-pro" ),
                    'tab_seopress_backlinks' => __( "Backlinks", "wp-seopress-pro" ),
                    'tab_seopress_rewrite' => __( "URL Rewriting", "wp-seopress-pro" ),
                    'tab_seopress_white_label' => __( "White Label", "wp-seopress-pro" ),
                );
                if (!is_network_admin() && is_multisite()) {
                    unset($plugin_settings_tabs['tab_seopress_robots'], $plugin_settings_tabs['tab_seopress_htaccess'], $plugin_settings_tabs['tab_seopress_white_label']);
                }

                echo '<div class="nav-tab-wrapper">';
                foreach ( $plugin_settings_tabs as $tab_key => $tab_caption ) {
                    echo '<a id="'. $tab_key .'-tab" class="nav-tab" href="?page=seopress-pro-page#tab=' . $tab_key . '">' . $tab_caption . '</a>';
                }
                echo '</div>';
            ?>

            <!-- Local Business -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_local_business') { echo 'active'; } ?>" id="tab_seopress_local_business">
            <?php do_settings_sections( 'seopress-settings-admin-local-business' ); ?></div>

            <!-- WooCommerce -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_woocommerce') { echo 'active'; } ?>" id="tab_seopress_woocommerce">
                <?php if ( is_plugin_active( 'woocommerce/woocommerce.php' )) { ?>
                    <?php do_settings_sections( 'seopress-settings-admin-woocommerce' ); ?>
                <?php } else { ?>
                    <?php echo('<p class="seopress-notice error notice">'.__('You need to enable WooCommerce in order to view these settings.','wp-seopress-pro').'</p>'); ?>
                <?php } ?>
            </div>

            <!-- Easy Digital Downloads -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_edd') { echo 'active'; } ?>" id="tab_seopress_edd">
                <?php if ( is_plugin_active( 'easy-digital-downloads/easy-digital-downloads.php' )) { ?>
                    <?php do_settings_sections( 'seopress-settings-admin-edd' ); ?>
                <?php } else { ?>
                    <?php echo('<p class="seopress-notice error notice">'.__('You need to enable Easy Digital Downloads in order to view these settings.','wp-seopress-pro').'</p>'); ?>
                <?php } ?>
            </div>

            <!-- Dublin Core -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_dublin_core') { echo 'active'; } ?>" id="tab_seopress_dublin_core">
            <?php do_settings_sections( 'seopress-settings-admin-dublin-core' ); ?></div>

            <!-- Structured Data Types -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_rich_snippets') { echo 'active'; } ?>" id="tab_seopress_rich_snippets">
            <?php do_settings_sections( 'seopress-settings-admin-rich-snippets' ); ?></div>
            
            <!-- Breadcrumbs -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_breadcrumbs') { echo 'active'; } ?>" id="tab_seopress_breadcrumbs"><?php do_settings_sections( 'seopress-settings-admin-breadcrumbs' ); ?></div>
            
            <!-- Google Page Speed -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_page_speed') { echo 'active'; } ?>" id="tab_seopress_page_speed"><?php do_settings_sections( 'seopress-settings-admin-page-speed' ); ?></div>
            
            <!-- Robots -->
            <?php if (!is_multisite()) { ?>
                <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_robots') { echo 'active'; } ?>" id="tab_seopress_robots"><?php do_settings_sections( 'seopress-settings-admin-robots' ); ?></div>
            <?php } ?>

            <!-- Google News Sitemap -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_news') { echo 'active'; } ?>" id="tab_seopress_news">
                <?php if (seopress_get_toggle_xml_sitemap_option() =='0') {
                    echo '<p class="seopress-notice error notice">';
                    _e('You need to enable XML Sitemap feature, in order to use Google News Sitemap.','wp-seopress-pro');
                    echo ' <a href="'.admin_url( 'admin.php?page=seopress-xml-sitemap' ).'">'.__('Change this settings','wp-seopress-pro').'</a>';
                    echo '</p>';
                } ?>
            <?php do_settings_sections( 'seopress-settings-admin-news' ); ?></div>

            <!-- 404 -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_404') { echo 'active'; } ?>" id="tab_seopress_404"><?php do_settings_sections( 'seopress-settings-admin-monitor-404' ); ?></div>

            <!-- htaccess -->
            <?php if (!is_multisite()) { ?>
                <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_htaccess') { echo 'active'; } ?>" id="tab_seopress_htaccess"><?php do_settings_sections( 'seopress-settings-admin-htaccess' ); ?></div>
            <?php } ?>

            <!-- RSS -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_rss') { echo 'active'; } ?>" id="tab_seopress_rss"><?php do_settings_sections( 'seopress-settings-admin-rss' ); ?></div>

            <!-- Backlinks -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_backlinks') { echo 'active'; } ?>" id="tab_seopress_backlinks"><?php do_settings_sections( 'seopress-settings-admin-backlinks' ); ?></div>

            <!-- Rewrite -->
            <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_rewrite') { echo 'active'; } ?>" id="tab_seopress_rewrite"><?php do_settings_sections( 'seopress-settings-admin-rewrite' ); ?></div>

            <!-- White Label -->
            <?php if (!is_multisite()) { ?>
                <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_white_label') { echo 'active'; } ?>" id="tab_seopress_white_label"><?php do_settings_sections( 'seopress-settings-admin-white-label' ); ?></div>
            <?php } ?>

        </div><!--seopress-tabs-->

        <?php submit_button(); ?>
        </form>
        <?php
    }

    /**
     * Options page callback
     */
    public function create_network_admin_page() {
        if (is_plugin_active('wp-seopress/seopress.php')) {
            if (function_exists('seopress_admin_header')) {
                echo seopress_admin_header();
            } ?>

            <form method="post" action="<?php echo admin_url('options.php'); ?>" class="seopress-option">

                <?php echo '<div id="seopress-notice-save" style="display: none"><span class="dashicons dashicons-yes"></span><span class="html"></span></div>';

                global $wp_version, $title;
                $current_tab = '';
                $tag = version_compare( $wp_version, '4.4' ) >= 0 ? 'h1' : 'h2';
                echo '<'.$tag.'><span class="dashicons dashicons-editor-table"></span>'.$title.'</'.$tag.'>';
                if (is_network_admin() && is_multisite()) {
                    settings_fields( 'seopress_pro_mu_option_group' );
                } else {
                    settings_fields( 'seopress_pro_option_group' );
                }
                ?>

                <div id="seopress-tabs" class="wrap">
                    <?php 
                        $plugin_settings_tabs = array(
                            'tab_seopress_robots' => __( "robots.txt", "wp-seopress-pro" ),
                            'tab_seopress_htaccess' => __( ".htaccess", "wp-seopress-pro" ),
                            'tab_seopress_white_label' => __( "White Label", "wp-seopress-pro" ),
                        );

                        echo '<div class="nav-tab-wrapper">';
                        foreach ( $plugin_settings_tabs as $tab_key => $tab_caption ) {
                            echo '<a id="'. $tab_key .'-tab" class="nav-tab" href="?page=seopress-network-option#tab=' . $tab_key . '">' . $tab_caption . '</a>';
                        }
                        echo '</div>';
                    ?>
                    
                    <!-- Robots -->
                    <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_robots') { echo 'active'; } ?>" id="tab_seopress_robots"><?php do_settings_sections( 'seopress-mu-settings-admin-robots' ); ?></div>

                    <!-- htaccess -->
                    <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_htaccess') { echo 'active'; } ?>" id="tab_seopress_htaccess"><?php do_settings_sections( 'seopress-settings-admin-htaccess' ); ?></div>

                    <!-- white label -->
                    <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_white_label') { echo 'active'; } ?>" id="tab_seopress_white_label"><?php do_settings_sections( 'seopress-mu-settings-admin-white-label' ); ?></div>

                </div><!--seopress-tabs-->

                <?php submit_button(); ?>
            </form>
        <?php }
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'seopress_pro_mu_option_group', // Option group
            'seopress_pro_mu_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );
        register_setting(
            'seopress_pro_option_group', // Option group
            'seopress_pro_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        register_setting(
            'seopress_bot_option_group', // Option group
            'seopress_bot_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        //Bot SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_bot', // ID
            '',
            //__("Bot","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_bot' ), // Callback
            'seopress-settings-admin-bot' // Page
        ); 

        add_settings_section( 
            'seopress_setting_section_bot_settings', // ID
            '',
            //__("Settings","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_bot_settings' ), // Callback
            'seopress-settings-admin-bot-settings' // Page
        );

        add_settings_field(
            'seopress_bot_scan_settings_post_types', // ID
           __("Post types to scan","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_post_types_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                  
        );

        add_settings_field(
            'seopress_bot_scan_settings_where', // ID
           __("Find links in","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_where_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                  
        );

        add_settings_field(
            'seopress_bot_scan_settings_number', // ID
           __("Number of posts / pages / post types to scan","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_number_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                  
        );

        add_settings_field(
            'seopress_bot_scan_settings_type', // ID
           __("Scan link type (slow down the bot)","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_type_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                  
        );

        add_settings_field(
            'seopress_bot_scan_settings_404', // ID
           __("Scan 404 only","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_404_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                  
        );

        add_settings_field(
            'seopress_bot_scan_settings_timeout', // ID
           __("Request Timeout (default 5 sec)","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_timeout_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                
        );

        add_settings_field(
            'seopress_bot_scan_settings_cleaning', // ID
           __("Clean broken links list when requesting a new scan","wp-seopress-pro"), // Title
            array( $this, 'seopress_bot_scan_settings_cleaning_callback' ), // Callback
            'seopress-settings-admin-bot-settings', // Page
            'seopress_setting_section_bot_settings' // Section                
        );

        //Local Business SECTION===================================================================
        add_settings_section( 
            'seopress_setting_section_local_business', // ID
            '',
            //__("Local Business","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_local_business' ), // Callback
            'seopress-settings-admin-local-business' // Page
        );

        add_settings_field(
            'seopress_local_business_type', // ID
           __("Business type","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_type_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_street_address', // ID
           __("Street Address","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_street_address_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_address_locality', // ID
           __("City","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_address_locality_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_address_region', // ID
           __("State","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_address_region_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );
        
        add_settings_field(
            'seopress_local_business_postal_code', // ID
           __("Postal code","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_postal_code_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_address_country', // ID
           __("Country","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_address_country_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_lat', // ID
           __("Latitude","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_lat_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_lon', // ID
           __("Longitude","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_lon_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_url', // ID
           __("URL","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_url_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_phone', // ID
           __("Telephone","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_phone_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_price_range', // ID
           __("Price range","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_price_range_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        add_settings_field(
            'seopress_local_business_opening_hours', // ID
           __("Opening hours","wp-seopress-pro"), // Title
            array( $this, 'seopress_local_business_opening_hours_callback' ), // Callback
            'seopress-settings-admin-local-business', // Page
            'seopress_setting_section_local_business' // Section                  
        );

        //WooCommerce SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_woocommerce', // ID
            '',
            //__("WooCommerce","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_woocommerce' ), // Callback
            'seopress-settings-admin-woocommerce' // Page
        );  

        add_settings_field(
            'seopress_woocommerce_cart_page_no_index', // ID
           __("Cart page","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_cart_page_no_index_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );   

        add_settings_field(
            'seopress_woocommerce_checkout_page_no_index', // ID
           __("Checkout page","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_checkout_page_no_index_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );

        add_settings_field(
            'seopress_woocommerce_customer_account_page_no_index', // ID
           __("Customer account pages","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_customer_account_page_no_index_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        ); 

        add_settings_field(
            'seopress_woocommerce_product_og_price', // ID
           __("OG Price","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_product_og_price_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        ); 

        add_settings_field(
            'seopress_woocommerce_product_og_currency', // ID
           __("OG Currency","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_product_og_currency_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );        

        add_settings_field(
            'seopress_woocommerce_meta_generator', // ID
           __("Remove WooCommerce generator tag in your head","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_meta_generator_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );

        add_settings_field(
            'seopress_woocommerce_schema_output', // ID
           __("Remove WooCommerce Schemas","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_schema_output_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );

        add_settings_field(
            'seopress_woocommerce_schema_breadcrumbs_output', // ID
           __("Remove WooCommerce breadcrumbs schemas only","wp-seopress-pro"), // Title
            array( $this, 'seopress_woocommerce_schema_breadcrumbs_output_callback' ), // Callback
            'seopress-settings-admin-woocommerce', // Page
            'seopress_setting_section_woocommerce' // Section                  
        );

        //Easy Digital Downloads SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_edd', // ID
            '',
            //__("Easy Digital Downloads","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_edd' ), // Callback
            'seopress-settings-admin-edd' // Page
        );

        add_settings_field(
            'seopress_edd_product_og_price', // ID
           __("OG Price","wp-seopress-pro"), // Title
            array( $this, 'seopress_edd_product_og_price_callback' ), // Callback
            'seopress-settings-admin-edd', // Page
            'seopress_setting_section_edd' // Section                 
        ); 

        add_settings_field(
            'seopress_edd_product_og_currency', // ID
           __("OG Currency","wp-seopress-pro"), // Title
            array( $this, 'seopress_edd_product_og_currency_callback' ), // Callback
            'seopress-settings-admin-edd', // Page
            'seopress_setting_section_edd' // Section                 
        );

        add_settings_field(
            'seopress_edd_meta_generator', // ID
           __("Remove Easy Digital Downloads generator tag in your head","wp-seopress-pro"), // Title
            array( $this, 'seopress_edd_meta_generator_callback' ), // Callback
            'seopress-settings-admin-edd', // Page
            'seopress_setting_section_edd' // Section                  
        );

        //Dublin Core SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_dublin_core', // ID
            '',
            //__("Dublin Core","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_dublin_core' ), // Callback
            'seopress-settings-admin-dublin-core' // Page
        );         

        add_settings_field(
            'seopress_dublin_core_enable', // ID
           __("Enable Dublin Core","wp-seopress-pro"), // Title
            array( $this, 'seopress_dublin_core_enable_callback' ), // Callback
            'seopress-settings-admin-dublin-core', // Page
            'seopress_setting_section_dublin_core' // Section                  
        ); 

        //Structured Data Types Core SECTION===============================================================
        add_settings_section( 
            'seopress_setting_section_rich_snippets', // ID
            '',
            //__("Structured Data Types","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_rich_snippets' ), // Callback
            'seopress-settings-admin-rich-snippets' // Page
        );

        add_settings_field(
            'seopress_rich_snippets_enable', // ID
           __("Enable Structured Data Types","wp-seopress-pro"), // Title
            array( $this, 'seopress_rich_snippets_enable_callback' ), // Callback
            'seopress-settings-admin-rich-snippets', // Page
            'seopress_setting_section_rich_snippets' // Section                  
        );

        add_settings_field(
            'seopress_rich_snippets_publisher_logo', // ID
           __("Upload your publisher logo","wp-seopress-pro"), // Title
            array( $this, 'seopress_rich_snippets_publisher_logo_callback' ), // Callback
            'seopress-settings-admin-rich-snippets', // Page
            'seopress_setting_section_rich_snippets' // Section                  
        );

        add_settings_field(
            'seopress_rich_snippets_site_nav', // ID
           __("Add SiteNavigationElement schema to your main menu","wp-seopress-pro"), // Title
            array( $this, 'seopress_rich_snippets_site_nav_callback' ), // Callback
            'seopress-settings-admin-rich-snippets', // Page
            'seopress_setting_section_rich_snippets' // Section                  
        );

        //Breadcrumbs SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_breadcrumbs', // ID
            '',
            //__("Breadcrumbs","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_breadcrumbs' ), // Callback
            'seopress-settings-admin-breadcrumbs' // Page
        );         

        add_settings_field(
            'seopress_breadcrumbs_enable', // ID
           __("Enable Breadcrumbs","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_enable_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        add_settings_field(
            'seopress_breadcrumbs_enable_json', // ID
           __("Enable JSON-LD Breadcrumbs","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_enable_json_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        ); 

        add_settings_field(
            'seopress_breadcrumbs_separator', // ID
           __("Breadcrumbs Separator","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_separator_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        add_settings_field(
            'seopress_breadcrumbs_i18n_home', // ID
           __("Translation for homepage","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_i18n_home_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );        

        add_settings_field(
            'seopress_breadcrumbs_i18n_404', // ID
           __("Translation for \"Error 404\"","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_i18n_404_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );        

        add_settings_field(
            'seopress_breadcrumbs_i18n_search', // ID
           __("Translation for \"Search results for\"","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_i18n_search_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );        

        add_settings_field(
            'seopress_breadcrumbs_i18n_no_results', // ID
           __("Translation for \"No results\"","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_i18n_no_results_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        add_settings_field(
            'seopress_breadcrumbs_remove_blog_page', // ID
           __("Remove Posts page","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_remove_blog_page_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        add_settings_field(
            'seopress_breadcrumbs_remove_shop_page', // ID
           __("Remove Shop page","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_remove_shop_page_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        add_settings_field(
            'seopress_breadcrumbs_separator_disable', // ID
           __("Disable default breadcrumbs separator","wp-seopress-pro"), // Title
            array( $this, 'seopress_breadcrumbs_separator_disable_callback' ), // Callback
            'seopress-settings-admin-breadcrumbs', // Page
            'seopress_setting_section_breadcrumbs' // Section                  
        );

        //Page Speed SECTION=======================================================================
        add_settings_section( 
            'seopress_setting_section_page_speed', // ID
            '',
            //__("Page Speed","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_page_speed' ), // Callback
            'seopress-settings-admin-page-speed' // Page
        );    

        //Robots SECTION===========================================================================
        if (is_network_admin() && is_multisite()) {
            add_settings_section( 
                'seopress_mu_setting_section_robots', // ID
                '',
                //__("Robots","wp-seopress-pro"), // Title
                array( $this, 'print_section_info_robots' ), // Callback
                'seopress-mu-settings-admin-robots' // Page
            );
            add_settings_field(
                'seopress_mu_robots_enable', // ID
               __("Enable Robots","wp-seopress-pro"), // Title
                array( $this, 'seopress_robots_enable_callback' ), // Callback
                'seopress-mu-settings-admin-robots', // Page
                'seopress_mu_setting_section_robots' // Section                  
            );
            add_settings_field(
                'seopress_mu_robots_file', // ID
               __("Virtual Robots.txt file","wp-seopress-pro"), // Title
                array( $this, 'seopress_robots_file_callback' ), // Callback
                'seopress-mu-settings-admin-robots', // Page
                'seopress_mu_setting_section_robots' // Section                  
            );
        } else {
            add_settings_section( 
                'seopress_setting_section_robots', // ID
                '',
                //__("Robots","wp-seopress-pro"), // Title
                array( $this, 'print_section_info_robots' ), // Callback
                'seopress-settings-admin-robots' // Page
            );
            add_settings_field(
                'seopress_robots_enable', // ID
               __("Enable Robots","wp-seopress-pro"), // Title
                array( $this, 'seopress_robots_enable_callback' ), // Callback
                'seopress-settings-admin-robots', // Page
                'seopress_setting_section_robots' // Section                  
            );
            add_settings_field(
                'seopress_robots_file', // ID
               __("Virtual Robots.txt file","wp-seopress-pro"), // Title
                array( $this, 'seopress_robots_file_callback' ), // Callback
                'seopress-settings-admin-robots', // Page
                'seopress_setting_section_robots' // Section                  
            );
        }

        //Google News SECTION======================================================================
        add_settings_section( 
            'seopress_setting_section_news', // ID
            '',
            //__("Google News","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_news' ), // Callback
            'seopress-settings-admin-news' // Page
        );         

        add_settings_field(
            'seopress_news_enable', // ID
           __("Enable Google News Sitemap","wp-seopress-pro"), // Title
            array( $this, 'seopress_news_enable_callback' ), // Callback
            'seopress-settings-admin-news', // Page
            'seopress_setting_section_news' // Section                  
        );        

        add_settings_field(
            'seopress_news_name', // ID
           __("Publication Name (must be the same as used in Google News)","wp-seopress-pro"), // Title
            array( $this, 'seopress_news_name_callback' ), // Callback
            'seopress-settings-admin-news', // Page
            'seopress_setting_section_news' // Section                  
        );

        add_settings_field(
            'seopress_news_name_post_types_list', // ID
           __("Select your Custom Post Type to INCLUDE in your Google News Sitemap","wp-seopress-pro"), // Title
            array( $this, 'seopress_news_name_post_types_list_callback' ), // Callback
            'seopress-settings-admin-news', // Page
            'seopress_setting_section_news' // Section                  
        );

        //404 SECTION=========================================================================
        add_settings_section( 
            'seopress_setting_section_monitor_404', // ID
            '',
            //__("404","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_monitor_404' ), // Callback
            'seopress-settings-admin-monitor-404' // Page
        );         

        add_settings_field(
            'seopress_404_enable', // ID
           __("404 log","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_enable_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        ); 

        add_settings_field(
            'seopress_404_cleaning', // ID
           __("404 cleaning","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_cleaning_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );         

        add_settings_field(
            'seopress_404_redirect_home', // ID
           __("Redirect 404 to","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_redirect_home_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );

        add_settings_field(
            'seopress_404_redirect_custom_url', // ID
           __("Redirect to specific URL","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_redirect_custom_url_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );  

        add_settings_field(
            'seopress_404_redirect_status_code', // ID
           __("Status code of redirections","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_redirect_status_code_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );

        add_settings_field(
            'seopress_404_enable_mails', // ID
           __("Email notifications","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_enable_mails_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );

        add_settings_field(
            'seopress_404_enable_mails_from', // ID
           __("Send emails to","wp-seopress-pro"), // Title
            array( $this, 'seopress_404_enable_mails_from_callback' ), // Callback
            'seopress-settings-admin-monitor-404', // Page
            'seopress_setting_section_monitor_404' // Section                  
        );        

        //htaccess SECTION=========================================================================
        add_settings_section( 
            'seopress_setting_section_htaccess', // ID
            '',
            //__("htaccess","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_htaccess' ), // Callback
            'seopress-settings-admin-htaccess' // Page
        );         

        add_settings_field(
            'seopress_htaccess_file', // ID
           __("Edit your htaccess file","wp-seopress-pro"), // Title
            array( $this, 'seopress_htaccess_file_callback' ), // Callback
            'seopress-settings-admin-htaccess', // Page
            'seopress_setting_section_htaccess' // Section                  
        );

        //RSS SECTION==============================================================================
        add_settings_section( 
            'seopress_setting_section_rss', // ID
            '',
            //__("RSS","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_rss' ), // Callback
            'seopress-settings-admin-rss' // Page
        ); 

        add_settings_field(
            'seopress_rss_before_html', // ID
           __("Display content before each post","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_before_html_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );

        add_settings_field(
            'seopress_rss_after_html', // ID
           __("Display content after each post","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_after_html_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );        

        add_settings_field(
            'seopress_rss_disable_comments_feed', // ID
           __("Disable comments RSS feed","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_disable_comments_feed_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );

        add_settings_field(
            'seopress_rss_disable_posts_feed', // ID
           __("Disable posts RSS feed","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_disable_posts_feed_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );

        add_settings_field(
            'seopress_rss_disable_extra_feed', // ID
           __("Disable extra RSS feed","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_disable_extra_feed_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );

        add_settings_field(
            'seopress_rss_disable_all_feeds', // ID
           __("Disable all RSS feeds","wp-seopress-pro"), // Title
            array( $this, 'seopress_rss_disable_all_feeds_callback' ), // Callback
            'seopress-settings-admin-rss', // Page
            'seopress_setting_section_rss' // Section                  
        );

        //Google Analytics SECTION=================================================================
        add_settings_section(
            'seopress_setting_section_google_analytics_dashboard', // ID
            '',
            //__("Google Analytics","wp-seopress"), // Title
            array( $this, 'print_section_info_google_analytics_dashboard' ), // Callback
            'seopress-settings-admin-google-analytics-dashboard' // Page
        );
        add_settings_field(
            'seopress_google_analytics_auth', // ID
           __("Connect with Google Analytics API","wp-seopress-pro"), // Title
            array( $this, 'seopress_google_analytics_auth_callback' ), // Callback
            'seopress-settings-admin-google-analytics-dashboard', // Page
            'seopress_setting_section_google_analytics_dashboard' // Section                  
        );
        add_settings_field(
            'seopress_google_analytics_auth_client_id', // ID
           __("Google Console Client ID","wp-seopress-pro"), // Title
            array( $this, 'seopress_google_analytics_auth_client_id_callback' ), // Callback
            'seopress-settings-admin-google-analytics-dashboard', // Page
            'seopress_setting_section_google_analytics_dashboard' // Section                  
        );
        add_settings_field(
            'seopress_google_analytics_auth_secret_id', // ID
           __("Google Console Secret ID","wp-seopress-pro"), // Title
            array( $this, 'seopress_google_analytics_auth_secret_id_callback' ), // Callback
            'seopress-settings-admin-google-analytics-dashboard', // Page
            'seopress_setting_section_google_analytics_dashboard' // Section                  
        );

        //Security SECTION=======================================================================
        add_settings_field(
            'seopress_advanced_security_metaboxe_sdt_role', // ID
           __("Block Structured Data Types metabox to user roles","wp-seopress-pro"), // Title
            array( $this, 'seopress_advanced_security_metaboxe_sdt_role_callback' ), // Callback
            'seopress-settings-admin-advanced-security', // Page
            'seopress_setting_section_advanced_security' // Section                  
        );

        //Backlinks SECTION==============================================================================
        add_settings_section( 
            'seopress_setting_section_backlinks', // ID
            '',
            //__("Backlinks","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_backlinks' ), // Callback
            'seopress-settings-admin-backlinks' // Page
        );         

        add_settings_field(
            'seopress_backlinks_majestic_key', // ID
           __("Enter your Majestic API key","wp-seopress-pro"), // Title
            array( $this, 'seopress_backlinks_majestic_key_callback' ), // Callback
            'seopress-settings-admin-backlinks', // Page
            'seopress_setting_section_backlinks' // Section                  
        );

        //Rewrite SECTION==============================================================================
        add_settings_section( 
            'seopress_setting_section_rewrite', // ID
            '',
            //__("Rewrite","wp-seopress-pro"), // Title
            array( $this, 'print_section_info_rewrite' ), // Callback
            'seopress-settings-admin-rewrite' // Page
        );         

        add_settings_field(
            'seopress_rewrite_search', // ID
           __("Custom URL for search results","wp-seopress-pro"), // Title
            array( $this, 'seopress_rewrite_search_callback' ), // Callback
            'seopress-settings-admin-rewrite', // Page
            'seopress_setting_section_rewrite' // Section                  
        );

        //White Label SECTION==============================================================================
        if (is_network_admin() && is_multisite()) {
            add_settings_section( 
                'seopress_mu_setting_section_white_label', // ID
                '',
                //__("White Label","wp-seopress-pro"), // Title
                array( $this, 'print_section_info_white_label' ), // Callback
                'seopress-mu-settings-admin-white-label' // Page
            );

            add_settings_field(
                'seopress_mu_white_label_admin_header', // ID
               __("Remove SEOPress admin header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_header_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_admin_notices', // ID
               __("Remove SEOPress icons in header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_notices_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_admin_menu', // ID
               __("Filter SEO admin menu dashicons","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_menu_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_admin_bar_icon', // ID
               __("Edit SEOPress item in admin bar","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_bar_icon_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_admin_bar_logo', // ID
               __("Add your custom logo in SEOPress admin header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_bar_logo_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_footer_credits', // ID
               __("Remove SEOPress credits in footer admin pages","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_footer_credits_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_mu_white_label_menu_pages', // ID
               __("Remove SEOPress menu/submenu pages","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_menu_pages_callback' ), // Callback
                'seopress-mu-settings-admin-white-label', // Page
                'seopress_mu_setting_section_white_label' // Section                  
            );
        } else {
            add_settings_section( 
                'seopress_setting_section_white_label', // ID
                '',
                //__("White Label","wp-seopress-pro"), // Title
                array( $this, 'print_section_info_white_label' ), // Callback
                'seopress-settings-admin-white-label' // Page
            );

            add_settings_field(
                'seopress_white_label_admin_header', // ID
               __("Remove SEOPress admin header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_header_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_white_label_admin_notices', // ID
               __("Remove SEOPress icons in header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_notices_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_white_label_admin_menu', // ID
               __("Filter SEO admin menu dashicons","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_menu_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_white_label_admin_bar_icon', // ID
               __("Edit SEOPress item in admin bar","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_bar_icon_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_white_label_admin_bar_logo', // ID
               __("Add your custom logo in SEOPress admin header","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_admin_bar_logo_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );

            add_settings_field(
                'seopress_white_label_footer_credits', // ID
               __("Remove SEOPress credits in footer admin pages","wp-seopress-pro"), // Title
                array( $this, 'seopress_white_label_footer_credits_callback' ), // Callback
                'seopress-settings-admin-white-label', // Page
                'seopress_setting_section_white_label' // Section                  
            );
        }
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {   
        $seopress_pro_sanitize_fields = array('seopress_404_redirect_custom_url', 'seopress_404_enable_mails_from', 'seopress_news_name', 'seopress_htaccess_file', 'seopress_google_analytics_auth_secret_id', 'seopress_google_analytics_auth_client_id', 'seopress_bot_scan_settings_timeout', 'seopress_bot_scan_settings_number', 'seopress_local_business_street_address', 'seopress_local_business_address_locality', 'seopress_local_business_address_region', 'seopress_local_business_postal_code', 'seopress_local_business_address_country', 'seopress_local_business_lat', 'seopress_local_business_lon', 'seopress_local_business_url', 'seopress_local_business_phone', 'seopress_local_business_email', 'seopress_local_business_price_range', 'seopress_backlinks_majestic_key', 'seopress_robots_file', 'seopress_mu_robots_file', 'seopress_rss_before_html', 'seopress_rss_after_html', 'seopress_rewrite_search', 'seopress_breadcrumbs_i18n_home','seopress_breadcrumbs_i18n_404', 'seopress_breadcrumbs_i18n_search', 'seopress_breadcrumbs_i18n_no_results', 'seopress_white_label_admin_menu', 'seopress_white_label_admin_bar_icon', 'seopress_white_label_admin_bar_logo' );
    
        foreach ($seopress_pro_sanitize_fields as $key => $value) {
            if (isset($input[$value])) {
                if ($value =='seopress_backlinks_majestic_key' && $input[$value] =='********************************') {
                    $options = get_option( 'seopress_pro_option_name' );
                    $input[$value] = $options['seopress_backlinks_majestic_key'];
                } elseif ($value =='seopress_robots_file'){
                    $input[$value] = sanitize_textarea_field($input[$value]);
                } elseif ($value =='seopress_mu_robots_file' && is_multisite()){
                    $input[$value] = sanitize_textarea_field($input[$value]);
                } elseif ($value =='seopress_rss_after_html' || $value =='seopress_rss_before_html') {
                    $args = array(
                            'strong' => array(),
                            'em'     => array(),
                            'br'     => array(),
                            'a'      => array('href'   => array(), 'rel' => array())
                    );
                    $input[$value] = wp_kses($input[$value], $args);
                } elseif( !empty( $input[$value] ) ) {
                    $input[$value] = sanitize_text_field( $input[$value] );
                }
            }
        }

        return $input;
    }

    /** 
     * Print the Section text
     */
     
    public function print_section_info_bot()
    {
        echo '<p>'.__('The bot scans links in your content to find errors (404...). We limit this search by default to the last 100 posts/pages/custom post types.', 'wp-seopress-pro');
        echo '<br>';
            _e('You can increase this value in the settings tab just above.','wp-seopress-pro');

        if (function_exists('seopress_get_locale')) {
            if (seopress_get_locale() =='fr') {
                $seopress_docs_link['support']['bot'] = 'https://www.seopress.org/fr/support/guides/detecter-liens-casses/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            } else {
                $seopress_docs_link['support']['bot'] = 'https://www.seopress.org/support/guides/detect-broken-links/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            }
        }

        echo '<a href="'.$seopress_docs_link['support']['bot'].'" target="_blank"><span class="dashicons dashicons-info" title="'.__('Check our guide','wp-seopress-pro').'"></span></a></p>';
        echo '<a href="'.admin_url('edit.php?post_type=seopress_bot').'">'.__('View scan results','wp-seopress-pro').'</a>';

    }

    public function print_section_info_bot_settings()
    {
        print __('<p>Broken links settings</p>', 'wp-seopress-pro');
    }

    public function print_section_info_local_business()
    {
        //Logo
        function seopress_local_business_img_option() {
            $seopress_local_business_img_option = get_option("seopress_social_option_name");
            if ( ! empty ( $seopress_local_business_img_option ) ) {
                foreach ($seopress_local_business_img_option as $key => $seopress_local_business_img_value)
                    $options[$key] = $seopress_local_business_img_value;
                 if (isset($seopress_local_business_img_option['seopress_social_knowledge_img'])) { 
                    return $seopress_local_business_img_option['seopress_social_knowledge_img'];
                 }
            }
        }

        print __('<p>Local Business data type for Google.</p>', 'wp-seopress-pro');

        if (seopress_local_business_img_option() =='') {
            echo '<p class="seopress-notice error notice">';
                _e('You have to set an image in Knowledge Graph settings, otherwise, your Google Local Business data will not be valid.', 'wp-seopress-pro');
                echo ' <a href="'.admin_url('admin.php?page=seopress-social').'" class="button-primary">'.__('Fix this!','wp-seopress-pro').'</a>';
            echo '</p>';
        }
        
        if(seopress_get_toggle_local_business_option()=='1') { 
            $seopress_get_toggle_local_business_option = '"1"';
        } else { 
            $seopress_get_toggle_local_business_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-local-business" id="toggle-local-business" class="toggle" data-toggle=<?php echo $seopress_get_toggle_local_business_option; ?>>
            <label for="toggle-local-business"></label>
            
            <?php
            if(seopress_get_toggle_local_business_option()=='1') { 
                echo '<span id="local-business-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="local-business-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="local-business-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="local-business-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';

        echo '<a href="'.admin_url('admin.php?page=seopress-social#tab=tab_seopress_social_knowledge').'">'.__('To edit your business name, visit this page.','wp-seopress-pro').'</a>';
    }

    public function print_section_info_woocommerce()
    {
        print __('<p>Improve WooCommerce SEO</p>', 'wp-seopress-pro');
        
        if(seopress_get_toggle_woocommerce_option()=='1') { 
            $seopress_get_toggle_woocommerce_option = '"1"';
        } else { 
            $seopress_get_toggle_woocommerce_option = '"0"';
        }
        ?>
        
        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-woocommerce" id="toggle-woocommerce" class="toggle" data-toggle=<?php echo $seopress_get_toggle_woocommerce_option; ?>>
            <label for="toggle-woocommerce"></label>
            
            <?php
            if(seopress_get_toggle_woocommerce_option()=='1') { 
                echo '<span id="woocommerce-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="woocommerce-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="woocommerce-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="woocommerce-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';
    }

    public function print_section_info_edd()
    {
        print __('<p>Improve Easy Digital Downloads SEO</p>', 'wp-seopress-pro');
        
        if(seopress_get_toggle_edd_option()=='1') { 
            $seopress_get_toggle_edd_option = '"1"';
        } else { 
            $seopress_get_toggle_edd_option = '"0"';
        }
        ?>
        
        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-edd" id="toggle-edd" class="toggle" data-toggle=<?php echo $seopress_get_toggle_edd_option; ?>>
            <label for="toggle-edd"></label>
            
            <?php
            if(seopress_get_toggle_edd_option()=='1') { 
                echo '<span id="edd-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="edd-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="edd-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="edd-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';
    }    

    public function print_section_info_dublin_core()
    {
        print __('<p>Dublin Core is a set of meta tags to describe your content.<br> These tags are automatically generated. Recognized by states / governements, they are used by directories, Bing, Baidu and Yandex.</p>', 'wp-seopress-pro');

        if(seopress_get_toggle_dublin_core_option()=='1') { 
            $seopress_get_toggle_dublin_core_option = '"1"';
        } else { 
            $seopress_get_toggle_dublin_core_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">

            <input type="checkbox" name="toggle-dublin-core" id="toggle-dublin-core" class="toggle" data-toggle=<?php echo $seopress_get_toggle_dublin_core_option; ?>>
            <label for="toggle-dublin-core"></label>
            
            <?php
            if(seopress_get_toggle_dublin_core_option()=='1') { 
                echo '<span id="dublin-core-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="dublin-core-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="dublin-core-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="dublin-core-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }
        
        echo '</div>';
    }

    public function print_section_info_rich_snippets()
    {
        print __('<p>Add Structured Data Types support, mark your content, and get better Google Search Results.</p>', 'wp-seopress-pro');

        if(seopress_get_toggle_rich_snippets_option()=='1') { 
            $seopress_get_toggle_rich_snippets_option = '"1"';
        } else { 
            $seopress_get_toggle_rich_snippets_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-rich-snippets" id="toggle-rich-snippets" class="toggle" data-toggle=<?php echo $seopress_get_toggle_rich_snippets_option; ?>>
            <label for="toggle-rich-snippets"></label>
            <?php
            if(seopress_get_toggle_rich_snippets_option()=='1') { 
                echo '<span id="rich-snippets-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="rich-snippets-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="rich-snippets-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="rich-snippets-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';

        echo '<a class="button" href="'.admin_url('edit.php?post_type=seopress_schemas').'"><span class="dashicons dashicons-visibility"></span>'.__('View my automatic schemas','wp-seopress-pro').'</a>';
    }

    public function print_section_info_breadcrumbs()
    {
        echo '<p>'.__('Configure your breadcrumbs, using schema.org markup, allowing it to appear in Google\'s search results.', 'wp-seopress-pro').' <a href="https://developers.google.com/search/docs/data-types/breadcrumb" target="_blank" rel="nofollow" title="'.__('Google developers website (new window)','wp-seopress-pro').'">'.__('Lean more on Google developers website','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span><p>';

        if(seopress_get_toggle_breadcrumbs_option()=='1') { 
            $seopress_get_toggle_breadcrumbs_option = '"1"';
        } else { 
            $seopress_get_toggle_breadcrumbs_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-breadcrumbs" id="toggle-breadcrumbs" class="toggle" data-toggle=<?php echo $seopress_get_toggle_breadcrumbs_option; ?>>
            <label for="toggle-breadcrumbs"></label>
            
            <?php
            if(seopress_get_toggle_breadcrumbs_option()=='1') { 
                echo '<span id="breadcrumbs-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="breadcrumbs-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="breadcrumbs-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="breadcrumbs-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';

        echo '<p>'.__('Copy and paste this function into your theme (eg: header.php) to enable your breadcrumbs:','wp-seopress-pro').'</p>';
        echo '<pre>&lt;?php if(function_exists(\'seopress_display_breadcrumbs\')) { seopress_display_breadcrumbs(); } ?&gt;</pre>';
        echo '<p>'.__('This function accepts 1 parameter: <strong>true / false</strong> for <strong>echo / return</strong>. Default: <strong>true</strong>.','wp-seopress-pro').'</p>';
        echo '<p>'.__('You can also use this shortcode in your content (post, page, post type...):','wp-seopress-pro').'</p>';
        echo '<pre>[seopress_breadcrumbs]</pre>';
        echo '<p>'.__('<a href="https://www.youtube.com/watch?v=G3_l5CDS8b8" target="_blank">Watch this video guide to easily integrate your breadcrumbs with your WordPress theme</a><span class="dashicons dashicons-external"></span>','wp-seopress-pro').'</p>';
    }

    public function print_section_info_page_speed()
    {
        echo '<p>'.__('Check your site performance with Google Page Speed (beta).', 'wp-seopress-pro').'</p>';

        if ( !is_plugin_active( 'wp-rocket/wp-rocket.php' )) {
            echo '<p><a href="https://shareasale.com/r.cfm?b=1075949&u=1638109&m=74778&urllink=&afftrack=" target="_blank">'.__('We recommend WP Rocket caching plugin to quickly and easily optimize your WordPress site. Starting from just $49.','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span></p>';
        }
        
        echo '<p><a href="https://www.dareboost.com/en/home" target="_blank">'.__('Get an insightful audit of your website\'s quality for better performances with Dareboost.','wp-seopress-pro').'</a><span class="dashicons dashicons-external"></span></p>';

        echo '<button class="seopress-request-page-speed button button-primary" data_permalink="'.get_home_url().'"><span class="dashicons dashicons-dashboard"></span>'.__('Analyse homepage with Page Speed','wp-seopress-pro').'</button> ';
        
        echo '<button id="seopress-clear-page-speed-cache" class="button"><span class="dashicons dashicons-no"></span>'.__('Remove last analysis','wp-seopress-pro').'</button> ';

        echo '<span class="spinner"></span>';

        echo '<div id="seopress-notice-save" style="display: none"><span class="dashicons dashicons-yes"></span><span class="html"></span></div>';
        
        if ( is_admin() ) {
            include_once dirname( __FILE__ ) . '/report-page-speed.php';
        }
    }

    public function print_section_info_robots()
    {
        print '<p>'.__('Configure your virtual robots.txt file.', 'wp-seopress-pro').'</p>';

        if(seopress_get_toggle_robots_option()=='1') { 
            $seopress_get_toggle_robots_option = '"1"';
        } else { 
            $seopress_get_toggle_robots_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-robots" id="toggle-robots" class="toggle" data-toggle=<?php echo $seopress_get_toggle_robots_option; ?>>
            <label for="toggle-robots"></label>
            
            <?php
                if(seopress_get_toggle_robots_option()=='1') { 
                    echo '<span id="robots-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                    echo '<span id="robots-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                } else { 
                    echo '<span id="robots-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                    echo '<span id="robots-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                }
        
        echo '</div>';
        if ( isset( $_SERVER['SERVER_SOFTWARE'] )) {
            $server_software = explode('/', $_SERVER['SERVER_SOFTWARE']);
            reset($server_software);
            if (current($server_software) =='nginx' ) { //IF NGINX
                echo '<p>'.__('Your server uses NGINX. If your robots.txt doesn\'t work properly, you need to add this rule to your configuration:', 'wp-seopress').'</p><br>';
                echo '<pre style="margin:0;padding:10px;font-weight: bold;background:#F3F3F3;display:inline-block;width: 100%">
                    location = /robots.txt {
                        allow all;
                        log_not_found off;
                        access_log off;
                        ##SEOPress
                        rewrite ^/robots\.txt$ /index.php?seopress_robots=1 last;
                    }
                </pre><br><br>';
            }
        }    
        
        echo '<a href="'.get_home_url().'/robots.txt" class="button" target="_blank"><span class="dashicons dashicons-visibility"></span>'.__('View your robots.txt','wp-seopress-pro').'</a>';
        echo '&nbsp;';
        echo '<button id="seopress-flush-permalinks2" class="button"><span class="dashicons dashicons-admin-links"></span>'.__('Flush permalinks','wp-seopress-pro').'</button>';
        echo '<span class="spinner"></span>';
        
        $home_url = get_home_url();

        echo '<p>'.sprintf(__('A robots.txt file lives at the root of your site. So, for site %1$s, the robots.txt file lives at %1$s/robots.txt. robots.txt is a plain text file that follows the Robots Exclusion Standard.','wp-seopress-pro'), $home_url).'</p>';

        echo '<p>'.__('A robots.txt file consists of one or more rules. Each rule blocks (or or allows) access for a given crawler to a specified file path in that website.','wp-seopress-pro').'</p>';

        echo '<p>'.__('Our robots.txt file is virtual (like the default WordPress one). It means it‘s not physically present on your server. It‘s generated via URL rewriting.','wp-seopress-pro').'</p>';

        echo '<p><span class="dashicons dashicons-info"></span> <strong>'.__('THIS VIRTUAL FILE WILL NOT BYPASS YOUR REAL ROBOTS.TXT FILE IF YOU HAVE ONE.', 'wp-seopress-pro').'</strong></p>';
    }

    public function print_section_info_news()
    {
        print __('<p>Enable your Google News Sitemap</p>', 'wp-seopress-pro');

        if(seopress_get_toggle_news_option()=='1') { 
            $seopress_get_toggle_news_option = '"1"';
        } else { 
            $seopress_get_toggle_news_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-news" id="toggle-news" class="toggle" data-toggle=<?php echo $seopress_get_toggle_news_option; ?>>
            <label for="toggle-news"></label>
            
            <?php
            if(seopress_get_toggle_news_option()=='1') { 
                echo '<span id="news-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="news-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="news-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="news-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }
        
        echo '</div>';

        echo __('To view your sitemap, enable permalinks (not default one), and save settings to flush them.', 'wp-seopress-pro');
        echo '<br>';
        echo __('We respect the rules of Google News: Only articles published during the previous two days, and, to a limit of 1000 articles, are visible in the sitemap.', 'wp-seopress-pro');
        echo '<br>';
        echo '<br>';
        echo '<a href="'.get_option( 'home' ).'/sitemaps.xml" target="_blank" class="button"><span class="dashicons dashicons-visibility"></span>'.__('View your sitemap','wp-seopress-pro').'</a>';
        echo '&nbsp;';
        echo '<a href="https://www.google.com/ping?sitemap='.get_option( 'home' ).'/sitemaps/" target="_blank" class="button"><span class="dashicons dashicons-share-alt2"></span>'.__('Ping Google manually','wp-seopress-pro').'</a>';        
        echo '&nbsp;';
        echo '<button id="seopress-flush-permalinks" class="button"><span class="dashicons dashicons-admin-links"></span>'.__('Flush permalinks','wp-seopress-pro').'</button>';
        echo '<span class="spinner"></span>';
    }

    public function print_section_info_monitor_404()
    {
        echo '<p>'.__('Monitor 404 urls in your Dashboard. Crawlers (robots/spiders) will be automatically exclude (eg: Google Bot, Yahoo, Bing...).', 'wp-seopress-pro').'</p>';

        if(seopress_get_toggle_404_option()=='1') { 
            $seopress_get_toggle_404_option = '"1"';
        } else { 
            $seopress_get_toggle_404_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-404" id="toggle-404" class="toggle" data-toggle=<?php echo $seopress_get_toggle_404_option; ?>>
            <label for="toggle-404"></label>
            
            <?php
            if(seopress_get_toggle_404_option()=='1') { 
                echo '<span id="redirections-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="redirections-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="redirections-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="redirections-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';

        echo '<p>'.__('404 URLS are bad for:','wp-seopress-pro').'</p>';

        echo '<ul>
                <li><span class="dashicons dashicons-minus"></span>'.__('User experience','wp-seopress-pro').'</li>
                <li><span class="dashicons dashicons-minus"></span>'.__('Performances','wp-seopress-pro').'</li>
                <li><span class="dashicons dashicons-minus"></span>'.__('Crawl budget allocated by Google','wp-seopress-pro').'</li>
            </ul>';

        echo '<p>'.__('All these reasons degrade your SEO AND your conversion.','wp-seopress-pro').'</p>';
                                
    }

    public function print_section_info_htaccess()
    {
        print '<p>'.__('Edit your htaccess file.', 'wp-seopress-pro').'</p>';
        
        echo '<p><span class="dashicons dashicons-warning"></span> <strong>'.__('SAVE YOUR HTACCESS FILE BEFORE EDIT!', 'wp-seopress-pro').'</strong></p>';
    }

    public function print_section_info_rss()
    {
        print '<p>'.__('Configure WordPress default feeds.', 'wp-seopress-pro').'</p>';
    }

    public function print_section_info_backlinks()
    {
        print '<p>'.__('Check your backlinks with Majestic. You need to enter your own Majestic API key to use this feature.', 'wp-seopress-pro').'</p>';
        echo '<a href="'.admin_url('edit.php?post_type=seopress_backlinks').'" class="button"><span class="dashicons dashicons-visibility"></span>'.__('View your backlinks','wp-seopress-pro').'</a>';
    }

    public function print_section_info_rewrite()
    {
        print '<p>'.__('Change the URL rewriting.', 'wp-seopress-pro').'</p>';

        if(seopress_get_toggle_rewrite_option()=='1') { 
            $seopress_get_toggle_rewrite_option = '"1"';
        } else { 
            $seopress_get_toggle_rewrite_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-rewrite" id="toggle-rewrite" class="toggle" data-toggle=<?php echo $seopress_get_toggle_rewrite_option; ?>>
            <label for="toggle-rewrite"></label>
            
            <?php
            if(seopress_get_toggle_rewrite_option()=='1') { 
                echo '<span id="rewrite-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="rewrite-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="rewrite-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="rewrite-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';
    }

    public function print_section_info_white_label()
    {
        print '<p>'.__('Enable White Label.', 'wp-seopress-pro').'</p>';

        if(seopress_get_toggle_white_label_option()=='1') { 
            $seopress_get_toggle_white_label_option = '"1"';
        } else { 
            $seopress_get_toggle_white_label_option = '"0"';
        }
        ?>

        <div class="wrap-toggle-checkboxes">
        
            <input type="checkbox" name="toggle-white-label" id="toggle-white-label" class="toggle" data-toggle=<?php echo $seopress_get_toggle_white_label_option; ?>>
            <label for="toggle-white-label"></label>
            
            <?php
            if(seopress_get_toggle_white_label_option()=='1') { 
                echo '<span id="white-label-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
                echo '<span id="white-label-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
            } else { 
                echo '<span id="white-label-state-default" class="feature-state"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to enable this feature','wp-seopress-pro').'</span>';
                echo '<span id="white-label-state" class="feature-state feature-state-off"><span class="dashicons dashicons-arrow-left-alt"></span>'.__('Click to disable this feature','wp-seopress-pro').'</span>';
            }

        echo '</div>';
    }

    public function print_section_info_google_analytics_dashboard()
    {
        print '<p>'.__('Connect your WordPress site with Google Analytics API and get statistics right in your Dashboard.', 'wp-seopress-pro').'</p>';

        if (function_exists('seopress_get_locale')) {
            if (seopress_get_locale() =='fr') {
                $seopress_docs_link['support']['google_analytics']['dashboard'] = 'https://www.seopress.org/fr/support/guides/connectez-site-wordpress-a-google-analytics/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            } else {
                $seopress_docs_link['support']['google_analytics']['dashboard'] = 'https://www.seopress.org/support/guides/connect-wordpress-site-google-analytics/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            }
        }

        echo '<span class="dashicons dashicons-external"></span><a href="'.$seopress_docs_link['support']['google_analytics']['dashboard'].'" target="_blank">'. __('Watch our video guide to connect your WordPress site with Google Analytics API + common errors','wp-seopress-pro').'</a></p>';
    }

    public function print_section_info_google_analytics_e_commerce()
    {
        print '<p>'.__('Track transactions in Google Analytics.', 'wp-seopress-pro').'</p>';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    
    //Bot
    public function seopress_bot_scan_settings_post_types_callback() 
    {
        $options = get_option( 'seopress_bot_option_name' );

        global $wp_post_types;

        $args = array(
            'show_ui' => true,
            'public' => true,
        );

        $output = 'objects'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'

        $post_types = get_post_types( $args, $output, $operator ); 

        foreach ($post_types as $seopress_cpt_key => $seopress_cpt_value) {
            
            //List all post types
            echo '<div class="seopress_wrap_single_cpt">';
                
                $check = isset($options['seopress_bot_scan_settings_post_types'][$seopress_cpt_key]['include']);
                
                echo '<input id="seopress_bot_scan_settings_post_types_include['.$seopress_cpt_key.']" name="seopress_bot_option_name[seopress_bot_scan_settings_post_types]['.$seopress_cpt_key.'][include]" type="checkbox"';
                if ('1' == $check) echo 'checked="yes"'; 
                echo ' value="1"/>';

                echo '<label for="seopress_bot_scan_settings_post_types_include['.$seopress_cpt_key.']">'.$seopress_cpt_value->labels->name.'</label>';
                
                if (isset($this->options['seopress_bot_scan_settings_post_types'][$seopress_cpt_key]['include'])) {
                    esc_attr( $this->options['seopress_bot_scan_settings_post_types'][$seopress_cpt_key]['include']);
                }

            echo '</div>';
        }
    }

    public function seopress_bot_scan_settings_where_callback() 
    {
        $options = get_option( 'seopress_bot_option_name' );  

        $where = array('post_content' => __('Post content','wp-seopress-pro'), 'body_page' => __('Body page (extremely slow)','wp-seopress-pro'));

        foreach ($where as $key => $value) {
            echo '<div class="seopress_wrap_single_cpt">';

                if (isset($options['seopress_bot_scan_settings_where'])) { 
                    $check = $options['seopress_bot_scan_settings_where'];
                }
                else {
                    $check = 'post_content';
                }
                
                echo '<input id="seopress_bot_scan_settings_where_include['.$key.']" name="seopress_bot_option_name[seopress_bot_scan_settings_where]" type="radio"';
                if ($key == $check) echo 'checked="yes"';
                echo ' value="'.$key.'"/>';

                echo '<label for="seopress_bot_scan_settings_where_include['.$key.']">'.$value.'</label>';
                
                if (isset($this->options['seopress_bot_scan_settings_where'])) {
                    esc_attr( $this->options['seopress_bot_scan_settings_where']);
                }
            echo '</div>';
        }
    }

    public function seopress_bot_scan_settings_number_callback()
    {
        $options = get_option( 'seopress_bot_option_name' );  
        
        $check = isset($options['seopress_bot_scan_settings_number']);

        echo '<input type="number" min="10" name="seopress_bot_option_name[seopress_bot_scan_settings_number]"';
        if ('1' == $check) echo 'value="'.$options['seopress_bot_scan_settings_number'].'"'; 
        echo ' value="100"/>';

        if (isset($this->options['seopress_bot_scan_settings_number'])) {
            esc_html( $this->options['seopress_bot_scan_settings_number']);
        }

        echo '<p>'.__('The higher the value, the more time it will take. Min 10. Default: 100','wp-seopress-pro').'</p>';
    }

    public function seopress_bot_scan_settings_type_callback()
    {
        $options = get_option( 'seopress_bot_option_name' );  
        
        $check = isset($options['seopress_bot_scan_settings_type']);      
        
        echo '<input id="seopress_bot_scan_settings_type" name="seopress_bot_option_name[seopress_bot_scan_settings_type]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_bot_scan_settings_type">'. __( 'Yes', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_bot_scan_settings_type'])) {
            esc_attr( $this->options['seopress_bot_scan_settings_type']);
        }
    }

    public function seopress_bot_scan_settings_404_callback()
    {
        $options = get_option( 'seopress_bot_option_name' );  
        
        $check = isset($options['seopress_bot_scan_settings_404']);      
        
        echo '<input id="seopress_bot_scan_settings_404" name="seopress_bot_option_name[seopress_bot_scan_settings_404]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_bot_scan_settings_404">'. __( 'Yes', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_bot_scan_settings_404'])) {
            esc_attr( $this->options['seopress_bot_scan_settings_404']);
        }
    }

    public function seopress_bot_scan_settings_timeout_callback()
    {
        $options = get_option( 'seopress_bot_option_name' );  
        
        $check = isset($options['seopress_bot_scan_settings_timeout']);

        echo '<input type="number" min="0" max="60" name="seopress_bot_option_name[seopress_bot_scan_settings_timeout]"';
        if ('1' == $check) echo 'value="'.$options['seopress_bot_scan_settings_timeout'].'"'; 
        echo ' value="5"/>';

        if (isset($this->options['seopress_bot_scan_settings_timeout'])) {
            esc_html( $this->options['seopress_bot_scan_settings_timeout']);
        }

        echo '<p>'.__('If the request exceeds x seconds of delay, the link will be considered as down','wp-seopress-pro').'</p>';
    }

    public function seopress_bot_scan_settings_cleaning_callback()
    {
        $options = get_option( 'seopress_bot_option_name' );  
        
        $check = isset($options['seopress_bot_scan_settings_cleaning']);      
        
        echo '<input id="seopress_bot_scan_settings_cleaning" name="seopress_bot_option_name[seopress_bot_scan_settings_cleaning]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_bot_scan_settings_cleaning">'. __( 'Yes', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_bot_scan_settings_cleaning'])) {
            esc_attr( $this->options['seopress_bot_scan_settings_cleaning']);
        }
    }

    //Local Business
    public function seopress_local_business_type_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );    
        
        $selected = isset($options['seopress_local_business_type']) ? $options['seopress_local_business_type'] : NULL;
                
        echo '<select id="seopress_local_business_type" name="seopress_pro_option_name[seopress_local_business_type]">';
                $seopress_lb_types = array(
                    'LocalBusiness'             => 'Local Business (default)',
                    'AnimalShelter'             => 'Animal Shelter',
                    'AutomotiveBusiness'        => 'Automotive Business',
                    'AutoBodyShop' => '|-Auto Body Shop',
                    'AutoDealer' => '|-Auto Dealer',
                    'AutoPartsStore' => '|-Auto Parts Store',
                    'AutoRental' => '|-Auto Rental',
                    'AutoRepair' => '|-Auto Repair',
                    'Auto Wash' => '|-AutoWash',
                    'GasStation' => '|-Gas Station',
                    'MotorcycleDealer' => '|-Motorcycle Dealer',
                    'MotorcycleRepair' => '|-Motorcycle Repair',
                    'ChildCare' => 'Child Care',
                    'Dentist' => 'Dentist',
                    'DryCleaningOrLaundry' => 'Dry Cleaning Or Laundry',
                    'EmergencyService' => 'Emergency Service',
                    'FireStation' => '|-Fire Station',
                    'Hospital' => '|-Hospital',
                    'PoliceStation' => '|-Police Station',
                    'EmploymentAgency' => 'Employment Agency',
                    'EntertainmentBusiness' => 'Entertainment Business',
                    'AdultEntertainment' => '|-Adult Entertainment',
                    'AmusementPark' => '|-Amusement Park',
                    'ArtGallery' => '|-Art Gallery',
                    'Casino' => '|-Casino',
                    'ComedyClub' => '|-Comedy Club',
                    'MovieTheater' => '|-Movie Theater',
                    'NightClub' => '|-Night Club',
                    'FinancialService' => 'Financial Service',
                    'AccountingService' => '|-Accounting Service',
                    'AutomatedTeller' => '|-Automated Teller',
                    'BankOrCreditUnion' => '|-Bank Or Credit Union',
                    'InsuranceAgency' => '|-Insurance Agency',
                    'FoodEstablishment' => 'Food Establishment',
                    'Bakery' => '|-Bakery',
                    'BarOrPub' => '|-Bar Or Pub',
                    'Brewery' => '|-Brewery',
                    'CafeOrCoffeeShop' => '|-Cafe Or Coffee Shop',
                    'FastFoodRestaurant' => '|-Fast Food Restaurant',
                    'IceCreamShop' => '|-Ice Cream Shop',
                    'Restaurant' => '|-Restaurant',
                    'Winery' => '|-Winery',
                    'GovernmentOffice' => 'Government Office',
                    'PostOffice' => '|-PostOffice',
                    'HealthAndBeautyBusiness' => 'Health And Beauty Business',
                    'BeautySalon' => '|-Beauty Salon',
                    'DaySpa' => '|-Day Spa',
                    'HairSalon' => '|-Hair Salon',
                    'HealthClub' => '|-Health Club',
                    'NailSalon' => '|-Nail Salon',
                    'TattooParlor' => '|-Tattoo Parlor',
                    'HomeAndConstructionBusiness' => 'Home And Construction Business',
                    'Electrician' => '|-Electrician',
                    'HVACBusiness' => '|-HVAC Business',
                    'HousePainter' => '|-House Painter',
                    'Locksmith' => '|-Locksmith',
                    'MovingCompany' => '|-Moving Company',
                    'Plumber' => '|-Plumber',
                    'RoofingContractor' => '|-Roofing Contractor',
                    'InternetCafe' => 'Internet Cafe',
                    'MedicalBusiness' => 'Medical Business',
                    'CommunityHealth' => '|-Community Health',
                    'Dentist' => '|-Dentist',
                    'Dermatology' => '|-Dermatology',
                    'DietNutrition' => '|-Diet Nutrition',
                    'Emergency' => '|-Emergency',
                    'Gynecologic' => '|-Gynecologic',
                    'MedicalClinic' => '|-Medical Clinic',
                    'Midwifery' => '|-Midwifery',
                    'Nursing' => '|-Nursing',
                    'Obstetric' => '|-Obstetric',
                    'Oncologic' => '|-Oncologic',
                    'Optician' => '|-Optician',
                    'Optometric' => '|-Optometric',
                    'Otolaryngologic' => '|-Otolaryngologic',
                    'Pediatric' => '|-Pediatric',
                    'Pharmacy' => '|-Pharmacy',
                    'Physician' => '|-Physician',
                    'Physiotherapy' => '|-Physiotherapy',
                    'PlasticSurgery' => '|-Plastic Surgery',
                    'Podiatric' => '|-Podiatric',
                    'PrimaryCare' => '|-Primary Care',
                    'Psychiatric' => '|-Psychiatric',
                    'PublicHealth' => '|-Public Health',
                    'LegalService' => 'Legal Service',
                    'Attorney' => '|-Attorney',
                    'Notary' => '|-Notary',
                    'Library' => 'Library',
                    'LodgingBusiness' => 'Lodging Business',
                    'BedAndBreakfast' => '|-Bed And Breakfast',
                    'Campground' => '|-Campground',
                    'Hostel' => '|-Hostel',
                    'Hotel' => '|-Hotel',
                    'Motel' => '|-Motel',
                    'Resort' => '|-Resort',
                    'ProfessionalService' => 'Professional Service',
                    'RadioStation' => 'Radio Station',
                    'RealEstateAgent' => 'Real Estate Agent',
                    'RecyclingCenter' => 'Recycling Center',
                    'SelfStorage' => 'Real Self Storage',
                    'ShoppingCenter' => 'Shopping Center',
                    'SportsActivityLocation' => 'Sports Activity Location',
                    'BowlingAlley' => '|-Bowling Alley',
                    'ExerciseGym' => '|-Exercise Gym',
                    'GolfCourse' => '|-Golf Course',
                    'HealthClub' => '|-Health Club',
                    'PublicSwimmingPool' => '|-Public Swimming Pool',
                    'SkiResort' => '|-Ski Resort',
                    'SportsClub' => '|-Sports Club',
                    'StadiumOrArena' => '|-Stadium Or Arena',
                    'TennisComplex' => '|-Tennis Complex',
                    'Store' => 'Store',
                    'AutoPartsStore' => '|-Auto Parts Store',
                    'BikeStore' => '|-Bike Store',
                    'BookStore' => '|-Book Store',
                    'ClothingStore' => '|-Clothing Store',
                    'ComputerStore' => '|-Computer Store',
                    'ConvenienceStore' => '|-Convenience Store',
                    'DepartmentStore' => '|-Department Store',
                    'ElectronicsStore' => '|-Electronics Store',
                    'Florist' => '|-Florist',
                    'FurnitureStore' => '|-Furniture Store',
                    'GardenStore' => '|-Garden Store',
                    'GroceryStore' => '|-Grocery Store',
                    'HardwareStore' => '|-Hardware Store',
                    'HobbyShop' => '|-Hobby Shop',
                    'HomeGoodsStore' => '|-Home Goods Store',
                    'JewelryStore' => '|-Jewelry Store',
                    'LiquorStore' => '|-Liquor Store',
                    'MensClothingStore' => '|-Mens Clothing Store',
                    'MobilePhoneStore' => '|-Mobile Phone Store',
                    'MovieRentalStore' => '|-Movie Rental Store',
                    'MusicStore' => '|-Music Store',
                    'OfficeEquipmentStore' => '|-Office Equipment Store',
                    'OutletStore' => '|-Outlet Store',
                    'PawnShop' => '|-Pawn Shop',
                    'PetStore' => '|-Pet Store',
                    'ShoeStore' => '|-Shoe Store',
                    'SportingGoodsStore' => '|-Sporting Goods Store',
                    'TireShop' => '|-Tire Shop',
                    'ToyStore' => '|-Toy Store',
                    'WholesaleStore' => '|-Wholesale Store',
                    'TelevisionStation' => '|-Wholesale Store',
                    'TouristInformationCenter' => 'Tourist Information Center',
                    'TravelAgency' => 'Travel Agency',
                );

                foreach ($seopress_lb_types as $type_value => $type_i18n) {
                    echo '<option '; 
                    if ($type_value == $selected) echo 'selected="selected"'; 
                    echo ' value="'.$type_value.'">'. __($type_i18n,"wp-seopress-pro") .'</option>';
                }
        echo '</select>';

        if (isset($this->options['seopress_local_business_type'])) {
            esc_attr( $this->options['seopress_local_business_type']);
        }
    }


    public function seopress_local_business_street_address_callback()
    {
        $check = isset($this->options['seopress_local_business_street_address']) ? $this->options['seopress_local_business_street_address'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_street_address]" placeholder="'.esc_html__('eg: Place Bellevue','wp-seopress-pro').'" aria-label="'.__('Street Address','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_address_locality_callback()
    {
        $check = isset($this->options['seopress_local_business_address_locality']) ? $this->options['seopress_local_business_address_locality'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_address_locality]" placeholder="'.esc_html__('eg: Biarritz','wp-seopress-pro').'" aria-label="'.__('City','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_address_region_callback()
    {
        $check = isset($this->options['seopress_local_business_address_region']) ? $this->options['seopress_local_business_address_region'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_address_region]" placeholder="'.esc_html__('eg: Pyrenees Atlantiques','wp-seopress-pro').'" aria-label="'.__('State','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_postal_code_callback()
    {
        $check = isset($this->options['seopress_local_business_postal_code']) ? $this->options['seopress_local_business_postal_code'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_postal_code]" placeholder="'.esc_html__('eg: 64200','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_address_country_callback()
    {
        $check = isset($this->options['seopress_local_business_address_country']) ? $this->options['seopress_local_business_address_country'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_address_country]" placeholder="'.esc_html__('eg: France','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_lat_callback()
    {
        $check = isset($this->options['seopress_local_business_lat']) ? $this->options['seopress_local_business_lat'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_lat]" placeholder="'.esc_html__('eg: 43.4831389','wp-seopress-pro').'" aria-label="'.__('Latitude','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_lon_callback()
    {
        $check = isset($this->options['seopress_local_business_lon']) ? $this->options['seopress_local_business_lon'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_lon]" placeholder="'.esc_html__('eg: -1.5630987','wp-seopress-pro').'" aria-label="'.__('Longitude','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_local_business_url_callback()
    {
        $check = isset($this->options['seopress_local_business_url']) ? $this->options['seopress_local_business_url'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_url]" placeholder="'.esc_html__('default:','wp-seopress-pro').get_home_url().'" aria-label="'.__('URL','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    public function seopress_local_business_phone_callback()
    {
        $check = isset($this->options['seopress_local_business_phone']) ? $this->options['seopress_local_business_phone'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_phone]" placeholder="'.esc_html__('eg: +33559240138','wp-seopress-pro').'" aria-label="'.__('Telephone','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    public function seopress_local_business_price_range_callback()
    {
        $check = isset($this->options['seopress_local_business_price_range']) ? $this->options['seopress_local_business_price_range'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_local_business_price_range]" placeholder="'.esc_html__('eg: $$, €€€, or ££££...','wp-seopress-pro').'" aria-label="'.__('Price range','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    public function seopress_local_business_opening_hours_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );

        $days = array(__('Monday','wp-seopress-pro'), __('Tuesday','wp-seopress-pro'), __('Wednesday','wp-seopress-pro'), __('Thursday','wp-seopress-pro'), __('Friday','wp-seopress-pro'), __('Saturday','wp-seopress-pro'), __('Sunday','wp-seopress-pro') );

        $hours = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');

        $mins = array('00', '15', '30', '45', '59');

        echo '<ul class="wrap-opening-hours">';

        foreach ($days as $key => $day) {

            $check_day = isset($options['seopress_local_business_opening_hours'][$key]['open']);
            
            $selected_start_hours = isset($options['seopress_local_business_opening_hours'][$key]['start']['hours']) ? $options['seopress_local_business_opening_hours'][$key]['start']['hours'] : NULL;

            $selected_start_mins = isset($options['seopress_local_business_opening_hours'][$key]['start']['mins']) ? $options['seopress_local_business_opening_hours'][$key]['start']['mins'] : NULL;
            
            echo '<li>';

                echo '<span class="day"><strong>'.$day.'</strong></span>';

                echo '<input id="seopress_local_business_opening_hours['.$key.'][open]" name="seopress_pro_option_name[seopress_local_business_opening_hours]['.$key.'][open]" type="checkbox"';
                    if ('1' == $check_day) echo 'checked="yes"'; 
                    echo ' value="1"/>';
                    
                echo '<label for="seopress_local_business_opening_hours['.$key.'][open]">'. __( 'Closed?', 'wp-seopress-pro' ) .'</label> ';
                
                if (isset($this->options['seopress_local_business_opening_hours'][$key]['open'])) {
                    esc_attr( $this->options['seopress_local_business_opening_hours'][$key]['open']);
                }

                echo '<select id="seopress_local_business_opening_hours['.$key.'][start][hours]" name="seopress_pro_option_name[seopress_local_business_opening_hours]['.$key.'][start][hours]">';

                    foreach ($hours as $hour) {
                        echo '<option '; 
                        if ($hour == $selected_start_hours) echo 'selected="selected"'; 
                        echo ' value="'.$hour.'">'. $hour .'</option>';
                    }

                echo '</select>';

                echo ' : ';

                echo '<select id="seopress_local_business_opening_hours['.$key.'][start][mins]" name="seopress_pro_option_name[seopress_local_business_opening_hours]['.$key.'][start][mins]">';

                    foreach ($mins as $min) {
                        echo '<option '; 
                        if ($min == $selected_start_mins) echo 'selected="selected"'; 
                        echo ' value="'.$min.'">'. $min .'</option>';
                    }

                echo '</select>';

                if (isset($this->options['seopress_local_business_opening_hours'][$key]['start']['hours'])) {
                    esc_attr( $this->options['seopress_local_business_opening_hours'][$key]['start']['hours']);
                }

                if (isset($this->options['seopress_local_business_opening_hours'][$key]['start']['mins'])) {
                    esc_attr( $this->options['seopress_local_business_opening_hours'][$key]['start']['mins']);
                }

                echo ' - ';

                $selected_end_hours = isset($options['seopress_local_business_opening_hours'][$key]['end']['hours']) ? $options['seopress_local_business_opening_hours'][$key]['end']['hours'] : NULL;

                $selected_end_mins = isset($options['seopress_local_business_opening_hours'][$key]['end']['mins']) ? $options['seopress_local_business_opening_hours'][$key]['end']['mins'] : NULL;

                echo '<select id="seopress_local_business_opening_hours['.$key.'][end][hours]" name="seopress_pro_option_name[seopress_local_business_opening_hours]['.$key.'][end][hours]">';

                    foreach ($hours as $hour) {
                        echo '<option '; 
                        if ($hour == $selected_end_hours) echo 'selected="selected"'; 
                        echo ' value="'.$hour.'">'. $hour .'</option>';
                    }

                echo '</select>';

                echo ' : ';

                echo '<select id="seopress_local_business_opening_hours['.$key.'][end][mins]" name="seopress_pro_option_name[seopress_local_business_opening_hours]['.$key.'][end][mins]">';

                    foreach ($mins as $min) {
                        echo '<option '; 
                        if ($min == $selected_end_mins) echo 'selected="selected"'; 
                        echo ' value="'.$min.'">'. $min .'</option>';
                    }

                echo '</select>';

            echo '</li>';

            if (isset($this->options['seopress_local_business_opening_hours'][$key]['end']['hours'])) {
                esc_attr( $this->options['seopress_local_business_opening_hours'][$key]['end']['hours']);
            }

            if (isset($this->options['seopress_local_business_opening_hours'][$key]['end']['mins'])) {
                esc_attr( $this->options['seopress_local_business_opening_hours'][$key]['end']['mins']);
            }
        }

        echo '</ul>';
    }

    //WooCommerce
    public function seopress_woocommerce_cart_page_no_index_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_woocommerce_cart_page_no_index']);      
        
        echo '<input id="seopress_woocommerce_cart_page_no_index" name="seopress_pro_option_name[seopress_woocommerce_cart_page_no_index]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_cart_page_no_index">'. __( 'noindex', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_cart_page_no_index'])) {
            esc_attr( $this->options['seopress_woocommerce_cart_page_no_index']);
        }
    }

    public function seopress_woocommerce_checkout_page_no_index_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_woocommerce_checkout_page_no_index']);      
        
        echo '<input id="seopress_woocommerce_checkout_page_no_index" name="seopress_pro_option_name[seopress_woocommerce_checkout_page_no_index]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_checkout_page_no_index">'. __( 'noindex', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_checkout_page_no_index'])) {
            esc_attr( $this->options['seopress_woocommerce_checkout_page_no_index']);
        }
    }

    public function seopress_woocommerce_customer_account_page_no_index_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_woocommerce_customer_account_page_no_index']);      
        
        echo '<input id="seopress_woocommerce_customer_account_page_no_index" name="seopress_pro_option_name[seopress_woocommerce_customer_account_page_no_index]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_customer_account_page_no_index">'. __( 'noindex', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_customer_account_page_no_index'])) {
            esc_attr( $this->options['seopress_woocommerce_customer_account_page_no_index']);
        }
    }    

    public function seopress_woocommerce_product_og_price_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_woocommerce_product_og_price']);      
        
        echo '<input id="seopress_woocommerce_product_og_price" name="seopress_pro_option_name[seopress_woocommerce_product_og_price]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_product_og_price">'. __( 'Add product:price:amount meta for product', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_product_og_price'])) {
            esc_attr( $this->options['seopress_woocommerce_product_og_price']);
        }
    }    

    public function seopress_woocommerce_product_og_currency_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_woocommerce_product_og_currency']);      
        
        echo '<input id="seopress_woocommerce_product_og_currency" name="seopress_pro_option_name[seopress_woocommerce_product_og_currency]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_product_og_currency">'. __( 'Add product:price:currency meta for product', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_product_og_currency'])) {
            esc_attr( $this->options['seopress_woocommerce_product_og_currency']);
        }
    }    

    public function seopress_woocommerce_meta_generator_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );
        
        $check = isset($options['seopress_woocommerce_meta_generator']);
        
        echo '<input id="seopress_woocommerce_meta_generator" name="seopress_pro_option_name[seopress_woocommerce_meta_generator]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_meta_generator">'. __( 'Remove WooCommerce meta generator', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_meta_generator'])) {
            esc_attr( $this->options['seopress_woocommerce_meta_generator']);
        }
    } 

    public function seopress_woocommerce_schema_output_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );
        
        $check = isset($options['seopress_woocommerce_schema_output']);
        
        echo '<input id="seopress_woocommerce_schema_output" name="seopress_pro_option_name[seopress_woocommerce_schema_output]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_schema_output">'. __( 'Remove default JSON-LD structured data (WooCommerce 3+)', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_woocommerce_schema_output'])) {
            esc_attr( $this->options['seopress_woocommerce_schema_output']);
        }
    }

    public function seopress_woocommerce_schema_breadcrumbs_output_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );
        
        $check = isset($options['seopress_woocommerce_schema_breadcrumbs_output']);
        
        echo '<input id="seopress_woocommerce_schema_breadcrumbs_output" name="seopress_pro_option_name[seopress_woocommerce_schema_breadcrumbs_output]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_woocommerce_schema_breadcrumbs_output">'. __( 'Remove default breadcrumbs JSON-LD structured data (WooCommerce 3+)', 'wp-seopress-pro' ) .'</label>';

        echo '<p class="description">'.__('If "Remove default JSON-LD structured data (WooCommerce 3+)" option is already checked, the breadcrumbs schema is already removed from your source code.','wp-seopress-pro').'</p>';
        
        if (isset($this->options['seopress_woocommerce_schema_breadcrumbs_output'])) {
            esc_attr( $this->options['seopress_woocommerce_schema_breadcrumbs_output']);
        }
    }

    //EDD
    public function seopress_edd_product_og_price_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_edd_product_og_price']);
        
        echo '<input id="seopress_edd_product_og_price" name="seopress_pro_option_name[seopress_edd_product_og_price]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_edd_product_og_price">'. __( 'Add product:price:amount meta for product', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_edd_product_og_price'])) {
            esc_attr( $this->options['seopress_edd_product_og_price']);
        }
    }    

    public function seopress_edd_product_og_currency_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_edd_product_og_currency']);      
        
        echo '<input id="seopress_edd_product_og_currency" name="seopress_pro_option_name[seopress_edd_product_og_currency]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_edd_product_og_currency">'. __( 'Add product:price:currency meta for product', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_edd_product_og_currency'])) {
            esc_attr( $this->options['seopress_edd_product_og_currency']);
        }
    }

    public function seopress_edd_meta_generator_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_edd_meta_generator']);      
        
        echo '<input id="seopress_edd_meta_generator" name="seopress_pro_option_name[seopress_edd_meta_generator]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_edd_meta_generator">'. __( 'Remove EDD meta generator', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_edd_meta_generator'])) {
            esc_attr( $this->options['seopress_edd_meta_generator']);
        }
    }

    //Dublin Core
    public function seopress_dublin_core_enable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_dublin_core_enable']);      
        
        echo '<input id="seopress_dublin_core_enable" name="seopress_pro_option_name[seopress_dublin_core_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_dublin_core_enable">'. __( 'Enable Dublin Core meta tags (dc.title, dc.description, dc.source, dc.language, dc.relation, dc.subject)', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_dublin_core_enable'])) {
            esc_attr( $this->options['seopress_dublin_core_enable']);
        }
    }    

    //Structured Data Types
    public function seopress_rich_snippets_enable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_rich_snippets_enable']);      
        
        echo '<input id="seopress_rich_snippets_enable" name="seopress_pro_option_name[seopress_rich_snippets_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_rich_snippets_enable">'. __( 'Enable Structured Data Types metabox for your posts, pages and custom post types', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_rich_snippets_enable'])) {
            esc_attr( $this->options['seopress_rich_snippets_enable']);
        }
    }

    public function seopress_rich_snippets_publisher_logo_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );
        
        $options_set = isset($options['seopress_rich_snippets_publisher_logo']) ? $options['seopress_rich_snippets_publisher_logo'] : NULL;
        
        $options_set2 = isset($options['seopress_rich_snippets_publisher_logo_width']) ? $options['seopress_rich_snippets_publisher_logo_width'] : NULL;
        $options_set3 = isset($options['seopress_rich_snippets_publisher_logo_height']) ? $options['seopress_rich_snippets_publisher_logo_height'] : NULL;
        
        $check = isset($options['seopress_rich_snippets_publisher_logo']);      

        echo '<input id="seopress_rich_snippets_publisher_logo_meta" type="text" value="'.$options_set.'" name="seopress_pro_option_name[seopress_rich_snippets_publisher_logo]" aria-label="'.__('Upload your publisher logo','wp-seopress-pro').'" placeholder="'.esc_html__('Select your logo','wp-seopress-pro').'"  />

            <input id="seopress_rich_snippets_publisher_logo_width" type="hidden" value="'.$options_set2.'" name="seopress_pro_option_name[seopress_rich_snippets_publisher_logo_width]" />

            <input id="seopress_rich_snippets_publisher_logo_height" type="hidden" value="'.$options_set3.'" name="seopress_pro_option_name[seopress_rich_snippets_publisher_logo_height]" />
        
        <input id="seopress_rich_snippets_publisher_logo_upload" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />';
        
        if (isset($this->options['seopress_rich_snippets_publisher_logo'])) {
            esc_attr( $this->options['seopress_rich_snippets_publisher_logo']);
        }

        function seopress_rich_snippets_publisher_logo_option() {
            $seopress_rich_snippets_publisher_logo_option = get_option("seopress_pro_option_name");
            if ( ! empty ( $seopress_rich_snippets_publisher_logo_option ) ) {
                foreach ($seopress_rich_snippets_publisher_logo_option as $key => $seopress_rich_snippets_publisher_logo_value)
                    $options[$key] = $seopress_rich_snippets_publisher_logo_value;
                 if (isset($seopress_rich_snippets_publisher_logo_option['seopress_rich_snippets_publisher_logo'])) { 
                    return $seopress_rich_snippets_publisher_logo_option['seopress_rich_snippets_publisher_logo'];
                 }
            }
        }
        echo '<br>';
        echo '<br>';
        echo '<img style="width:auto;height:auto;max-width:100%" src="'.seopress_rich_snippets_publisher_logo_option().'"/>';

        echo '<ul class="seopress-list">';
        echo '<li>';
            _e('Files must be raster, such as .jpg, .png, or .gif, not vector, such as .svg.','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('Animation is not allowed.','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('Use full wordmark or full logo; not an icon.','wp-seopress-pro');
        echo '</li>';        
        echo '<li>';
            _e('The graphic must be legible on a white or light background','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('The logo should be a rectangle, not a square.','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('The logo should fit in a 600x60px rectangle, and either be exactly 60px high (preferred), or exactly 600px wide. <br/>For example, 450x45px would not be acceptable, even though it fits in the 600x60px rectangle.','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('The text in word-based logos should be at most 48px tall and centered vertically against the 60px image height. Additional space should be added to pad the height to 60px.','wp-seopress-pro');
        echo '</li>';
        echo '<li>';
            _e('Logos with a solid background should include 6px minimum padding around the wordmark.','wp-seopress-pro');
        echo '</li>';
        echo '</ul>';
        echo '<p>';
        echo '<span class="dashicons dashicons-external"></span><a href="https://developers.google.com/search/docs/data-types/articles#logo-guidelines" target="_blank">'.__('Learn more','wp-seopress-pro').'</a>';
        echo '</p>';
    }

    public function seopress_rich_snippets_site_nav_callback()
    {
        $options = get_option( 'seopress_pro_option_name' ); 
        
        $selected = isset($options['seopress_rich_snippets_site_nav']) ? $options['seopress_rich_snippets_site_nav'] : NULL;
           
        echo '<select id="seopress_rich_snippets_site_nav" name="seopress_pro_option_name[seopress_rich_snippets_site_nav]">';
            echo ' <option '; 
                if ('none' == $selected) echo 'selected="selected"'; 
                echo ' value="none">'. __("None","wp-seopress") .'</option>';
            
            if (function_exists('wp_get_nav_menus')) {
                $menus = wp_get_nav_menus();
                if (!empty($menus)) {
                    foreach($menus as $menu) {
                        echo ' <option ';
                            if (esc_attr($menu->term_id) == $selected) echo 'selected="selected"'; 
                            echo ' value="'.esc_attr($menu->term_id).'">'. esc_html($menu->name) .'</option>';
                    }
                }
            }
        echo '</select>';

        echo '<p class="description">'.__('Select your primary navigation. This can help search engines better understand the structure of your site.','wp-seopress').'</p>';

        if (isset($this->options['seopress_rich_snippets_site_nav'])) {
            esc_attr( $this->options['seopress_rich_snippets_site_nav']);
        }
    }

    //Breadcrumbs
    public function seopress_breadcrumbs_enable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_breadcrumbs_enable']);      
        
        echo '<input id="seopress_breadcrumbs_enable" name="seopress_pro_option_name[seopress_breadcrumbs_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_breadcrumbs_enable">'. __( 'Enable HTML Breadcrumbs', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_breadcrumbs_enable'])) {
            esc_attr( $this->options['seopress_breadcrumbs_enable']);
        }
    }      

    public function seopress_breadcrumbs_enable_json_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_breadcrumbs_json_enable']);      
        
        echo '<input id="seopress_breadcrumbs_json_enable" name="seopress_pro_option_name[seopress_breadcrumbs_json_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_breadcrumbs_json_enable">'. __( 'Enable JSON-LD Breadcrumbs', 'wp-seopress-pro' ) .'</label>';

        echo '<p class="description">'.__('To avoid duplicated schemas, don\'t enable this option if HTML Breadcrumbs is ON. We automatically add the JSON-LD to the head of your document using the wp_head hook. You don\'t need to manually call the breadcrumbs function.','wp-seopress-pro').'</p>';
        
        if (isset($this->options['seopress_breadcrumbs_json_enable'])) {
            esc_attr( $this->options['seopress_breadcrumbs_json_enable']);
        }
    }   

    public function seopress_breadcrumbs_separator_callback()
    {
        $check = isset($this->options['seopress_breadcrumbs_separator']) ? $this->options['seopress_breadcrumbs_separator'] : NULL;

        printf(
        '<input type="text" class="seopress_breadcrumbs_sep" name="seopress_pro_option_name[seopress_breadcrumbs_separator]" aria-label="'.__('Breadcrumbs Separator','wp-seopress-pro').'" placeholder="'.esc_html__('eg: \ ','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );

        echo '<div class="wrap-tags">
                <span id="seopress-tag-breadcrumbs-1" data-tag="-" class="tag-title"><strong>'.__('-','wp-seopress-pro').'</strong></span>
                <span id="seopress-tag-breadcrumbs-2" data-tag="–" class="tag-title"><strong>'.__('–','wp-seopress-pro').'</strong></span>
                <span id="seopress-tag-breadcrumbs-3" data-tag=">" class="tag-title"><strong>'.__('>','wp-seopress-pro').'</strong></span>
                <span id="seopress-tag-breadcrumbs-4" data-tag="<" class="tag-title"><strong>'.__('<','wp-seopress-pro').'</strong></span>
                <span id="seopress-tag-breadcrumbs-5" data-tag="|" class="tag-title"><strong>'.__('|','wp-seopress-pro').'</strong></span>
            </div>';

        if (function_exists('seopress_get_locale')) {
            if (seopress_get_locale() =='fr') {
                $seopress_docs_link['support']['breadcrumbs_sep'] = 'https://www.seopress.org/fr/support/hooks/filtrer-le-separateur-du-fil-dariane/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            } else {
                $seopress_docs_link['support']['breadcrumbs_sep'] = 'https://www.seopress.org/support/hooks/filter-breadcrumbs-separator/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            }
        }

        echo '<a class="seopress-doc" href="'.$seopress_docs_link['support']['breadcrumbs_sep'].'" target="_blank"><span class="dashicons dashicons-info" title="'.__('Customize breadcrumbs separator with a hook','wp-seopress-pro').'"></span></a></p>';
    }    

    public function seopress_breadcrumbs_i18n_home_callback()
    {
        $check = isset($this->options['seopress_breadcrumbs_i18n_home']) ? $this->options['seopress_breadcrumbs_i18n_home'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_breadcrumbs_i18n_home]" aria-label="'.__('Home','wp-seopress-pro').'" placeholder="'.esc_html__('default: Home','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    public function seopress_breadcrumbs_i18n_404_callback()
    {
        $check = isset($this->options['seopress_breadcrumbs_i18n_404']) ? $this->options['seopress_breadcrumbs_i18n_404'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_breadcrumbs_i18n_404]" aria-label="'.__('404 error','wp-seopress-pro').'" placeholder="'.esc_html__('default: 404 error','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_breadcrumbs_i18n_search_callback()
    {
        $check = isset($this->options['seopress_breadcrumbs_i18n_search']) ? $this->options['seopress_breadcrumbs_i18n_search'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_breadcrumbs_i18n_search]" aria-label="'.__('Search results for: ','wp-seopress-pro').'" placeholder="'.esc_html__('default: Search results for: ','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }    

    public function seopress_breadcrumbs_i18n_no_results_callback()
    {
        $check = isset($this->options['seopress_breadcrumbs_i18n_no_results']) ? $this->options['seopress_breadcrumbs_i18n_no_results'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_breadcrumbs_i18n_no_results]" aria-label="'.__('No results','wp-seopress-pro').'" placeholder="'.esc_html__('default: No results','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    public function seopress_breadcrumbs_remove_blog_page_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_breadcrumbs_remove_blog_page']);      
        
        echo '<input id="seopress_breadcrumbs_remove_blog_page" name="seopress_pro_option_name[seopress_breadcrumbs_remove_blog_page]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_breadcrumbs_remove_blog_page">'. __( 'Remove static Posts page defined in WordPress Reading settings', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_breadcrumbs_remove_blog_page'])) {
            esc_attr( $this->options['seopress_breadcrumbs_remove_blog_page']);
        }
    }

    public function seopress_breadcrumbs_remove_shop_page_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_breadcrumbs_remove_shop_page']);      
        
        echo '<input id="seopress_breadcrumbs_remove_shop_page" name="seopress_pro_option_name[seopress_breadcrumbs_remove_shop_page]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_breadcrumbs_remove_shop_page">'. __( 'Remove the static Shop page defined in the WooCommerce settings', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_breadcrumbs_remove_shop_page'])) {
            esc_attr( $this->options['seopress_breadcrumbs_remove_shop_page']);
        }
    }

    public function seopress_breadcrumbs_separator_disable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_breadcrumbs_separator_disable']);      
        
        echo '<input id="seopress_breadcrumbs_separator_disable" name="seopress_pro_option_name[seopress_breadcrumbs_separator_disable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_breadcrumbs_separator_disable">'. __( 'My theme / Bootstrap is already displaying a separator in my breadcrumbs', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_breadcrumbs_separator_disable'])) {
            esc_attr( $this->options['seopress_breadcrumbs_separator_disable']);
        }
    }

    //Page Speed

    //Robots
    public function seopress_robots_enable_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );  
            
            $check = isset($options['seopress_mu_robots_enable']);      
            
            echo '<input id="seopress_mu_robots_enable" name="seopress_pro_mu_option_name[seopress_mu_robots_enable]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_mu_robots_enable">'. __( 'Enable robots.txt virtual file', 'wp-seopress-pro' ) .'</label>';
            
            if (isset($this->options['seopress_mu_robots_enable'])) {
                esc_attr( $this->options['seopress_mu_robots_enable']);
            }
        } else {
            $options = get_option( 'seopress_pro_option_name' );  
            
            $check = isset($options['seopress_robots_enable']);      
            
            echo '<input id="seopress_robots_enable" name="seopress_pro_option_name[seopress_robots_enable]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_robots_enable">'. __( 'Enable robots.txt virtual file', 'wp-seopress-pro' ) .'</label>';
            
            if (isset($this->options['seopress_robots_enable'])) {
                esc_attr( $this->options['seopress_robots_enable']);
            }
        }
    }

    public function seopress_robots_file_callback()
    {
        if (defined('SEOPRESS_BLOCK_ROBOTS') && SEOPRESS_BLOCK_ROBOTS == true) {
            echo '<div class="error notice is-dismissable"><p>'.__('Access not allowed.','wp-seopress-pro').'</p></div>';
        } else {
            if (is_network_admin() && is_multisite()) {
                $options = get_option( 'seopress_pro_mu_option_name' );
                $check = isset($options['seopress_mu_robots_file']) ? $options['seopress_mu_robots_file'] : NULL;

                printf(
                '<textarea id="seopress_mu_robots_file" class="seopress_robots_file" name="seopress_pro_mu_option_name[seopress_mu_robots_file]" rows="15" aria-label="'.__('Virtual Robots.txt file','wp-seopress-pro').'" placeholder="'.esc_html__('This is your robots.txt file!','wp-seopress-pro').'">%s</textarea>',
                esc_html( $check )
                
                );
            } else {
                $options = get_option( 'seopress_pro_option_name' );
                $check = isset($options['seopress_robots_file']) ? $options['seopress_robots_file'] : NULL;

                printf(
                '<textarea id="seopress_robots_file" class="seopress_robots_file" name="seopress_pro_option_name[seopress_robots_file]" rows="15" aria-label="'.__('Virtual Robots.txt file','wp-seopress-pro').'" placeholder="'.esc_html__('This is your robots.txt file!','wp-seopress-pro').'">%s</textarea>',
                esc_html( $check )
                
                );
            }
            echo '<div class="wrap-tags">';

                echo '<span id="seopress-tag-robots-1" class="tag-title" data-tag="User-agent: SemrushBot
    Disallow: /
User-agent: SemrushBot-SA
    Disallow: /"><span class="dashicons dashicons-plus"></span>'.__('Block SemrushBot','wp-seopress-pro').'</span>';

                echo '<span id="seopress-tag-robots-2" class="tag-title" data-tag="User-agent: MJ12bot
    Disallow: /"><span class="dashicons dashicons-plus"></span>'.__('Block MajesticSEOBot','wp-seopress-pro').'</span>';

                echo '<span id="seopress-tag-robots-7" class="tag-title" data-tag="User-agent: AhrefsBot 
    Disallow: /"><span class="dashicons dashicons-plus"></span>'.__('Block AhrefsBot','wp-seopress-pro').'</span>';

                echo '<span id="seopress-tag-robots-3" class="tag-title" data-tag="Sitemap: '.get_home_url().'/sitemaps.xml"><span class="dashicons dashicons-plus"></span>'.__('Link to your sitemap','wp-seopress-pro').'</span>';

                echo '<span id="seopress-tag-robots-4" class="tag-title" data-tag="User-agent: Mediapartners-Google
    Disallow: "><span class="dashicons dashicons-plus"></span>'.__('Allow Google AdSense bot','wp-seopress-pro').'</span>';

                echo '<span id="seopress-tag-robots-5" class="tag-title" data-tag="User-agent: Googlebot-Image
    Disallow: "><span class="dashicons dashicons-plus"></span>'.__('Allow Google Image bot','wp-seopress-pro').'</span>';
                
                echo '<span id="seopress-tag-robots-6" class="tag-title" data-tag="User-agent: *
    Disallow: /wp-admin/
    Allow: /wp-admin/admin-ajax.php "><span class="dashicons dashicons-plus"></span>'.__('Default WP rules','wp-seopress-pro').'</span>';

            echo '</div>';
        }
        if (function_exists('seopress_get_locale')) {
            if (seopress_get_locale() =='fr') {
                $seopress_docs_link['support']['robots'] = 'https://www.seopress.org/fr/support/guides/editer-fichier-robots-txt/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            } else {
                $seopress_docs_link['support']['robots'] = 'https://www.seopress.org/support/guides/edit-robots-txt-file/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            }
        }

        echo '<a class="seopress-doc" href="'.$seopress_docs_link['support']['robots'].'" target="_blank"><span class="dashicons dashicons-editor-help"></span><span class="screen-reader-text">'. __('Guide to edit your robots.txt file - new window','wp-seopress-pro').'</span></a></p>';
    }

    //Google News
    public function seopress_news_enable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_news_enable']);      
        
        echo '<input id="seopress_news_enable" name="seopress_pro_option_name[seopress_news_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_news_enable">'. __( 'Enable Google News Sitemap', 'wp-seopress-pro' ) .'</label>';
        
        if (isset($this->options['seopress_news_enable'])) {
            esc_attr( $this->options['seopress_news_enable']);
        }
    }

    public function seopress_news_name_callback()
    {
        $check = isset($this->options['seopress_news_name']) ? $this->options['seopress_news_name'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_news_name]" aria-label="'.__('Publication Name (must be the same as used in Google News)','wp-seopress-pro').'" placeholder="'.esc_html__('Enter your Google News Publication Name','wp-seopress-pro').'" value="%s"></textarea>',
        esc_html( $check )
        
        );
    }

    public function seopress_news_name_post_types_list_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_news_name_post_types_list']);      
        
        global $wp_post_types;

        $args = array(
            'show_ui' => true,
        );

        $output = 'objects'; // names or objects, note names is the default
        $operator = 'and'; // 'and' or 'or'

        $post_types = get_post_types( $args, $output, $operator ); 

        foreach ($post_types as $seopress_cpt_key => $seopress_cpt_value) {
            
            //List all post types
            echo '<div class="seopress_wrap_single_cpt">';

                $options = get_option( 'seopress_pro_option_name' );  
                
                $check = isset($options['seopress_news_name_post_types_list'][$seopress_cpt_key]['include']);      
                
                echo '<input id="seopress_xml_sitemap_post_types_list_include['.$seopress_cpt_key.']" name="seopress_pro_option_name[seopress_news_name_post_types_list]['.$seopress_cpt_key.'][include]" type="checkbox"';
                if ('1' == $check) echo 'checked="yes"'; 
                echo ' value="1"/>';

                echo '<label for="seopress_xml_sitemap_post_types_list_include['.$seopress_cpt_key.']">'.$seopress_cpt_value->labels->name.'</label>';
                
                if (isset($this->options['seopress_news_name_post_types_list'][$seopress_cpt_key]['include'])) {
                    esc_attr( $this->options['seopress_news_name_post_types_list'][$seopress_cpt_key]['include']);
                }

            echo '</div>';
        }
    }

    //404
    public function seopress_404_enable_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_404_enable']);      
        
        echo '<input id="seopress_404_enable" name="seopress_pro_option_name[seopress_404_enable]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_404_enable">'. __( 'Enable 404 monitoring', 'wp-seopress-pro' ) .'</label><br><br>';

        echo '<a href="'.admin_url('edit.php?post_type=seopress_404').'">'.__('View your 404 / 301','wp-seopress-pro').'</a>';

        if (isset($this->options['seopress_404_enable'])) {
            esc_attr( $this->options['seopress_404_enable']);
        }
    }

    public function seopress_404_cleaning_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_404_cleaning']);      
        
        echo '<input id="seopress_404_cleaning" name="seopress_pro_option_name[seopress_404_cleaning]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_404_cleaning">'. __( 'Automatically delete 404 after 30 days (useful if you have a lot of 404)', 'wp-seopress-pro' ) .'</label>';

        echo '<p class="description">'.__('You must deactivate and reactivate SEOPress PRO to enable the scheduled task (CRON)','wp-seopress-pro').'</p>';

        echo '<a href="'.admin_url( 'admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects' ).'" id="seopress-clean-404" style="margin: 10px 0 0 0;" class="button">'. __('Clean manually your 404','wp-seopress-pro').'</a>';

        if (isset($this->options['seopress_404_cleaning'])) {
            esc_attr( $this->options['seopress_404_cleaning']);
        }
    }

    public function seopress_404_redirect_home_callback()
    {
        $options = get_option( 'seopress_pro_option_name' ); 
        
        $selected = isset($options['seopress_404_redirect_home']) ? $options['seopress_404_redirect_home'] : NULL;
           
        echo '<select id="seopress_404_redirect_home" name="seopress_pro_option_name[seopress_404_redirect_home]">';
            echo ' <option '; 
                if ('none' == $selected) echo 'selected="selected"'; 
                echo ' value="none">'. __("None","wp-seopress") .'</option>';
            echo ' <option '; 
                if ('home' == $selected) echo 'selected="selected"'; 
                echo ' value="home">'. __("Homepage","wp-seopress") .'</option>';
            echo '<option '; 
                if ('custom' == $selected) echo 'selected="selected"'; 
                echo ' value="custom">'. __("Custom URL","wp-seopress") .'</option>';
        echo '</select>';

        if (isset($this->options['seopress_404_redirect_home'])) {
            esc_attr( $this->options['seopress_404_redirect_home']);
        }
    }

    public function seopress_404_redirect_custom_url_callback()
    {
        $check = isset($this->options['seopress_404_redirect_custom_url']) ? $this->options['seopress_404_redirect_custom_url'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_404_redirect_custom_url]" placeholder="'.esc_html__('Enter your custom url','wp-seopress-pro').'" aria-label="'.__('Redirect to specific URL','wp-seopress-pro').'" value="%s"></textarea>',
        esc_html( $check )
        
        );
    }

    public function seopress_404_redirect_status_code_callback()
    {        
        $options = get_option( 'seopress_pro_option_name' );
        
        $selected = isset($options['seopress_404_redirect_status_code']) ? $options['seopress_404_redirect_status_code'] : NULL;
        
        echo '<select id="seopress_404_redirect_status_code" name="seopress_pro_option_name[seopress_404_redirect_status_code]">';
            echo ' <option '; 
                if ('301' == $selected) echo 'selected="selected"'; 
                echo ' value="301">'. __("301 redirect","wp-seopress") .'</option>';
            echo '<option '; 
                if ('302' == $selected) echo 'selected="selected"'; 
                echo ' value="302">'. __("302 redirect","wp-seopress") .'</option>';
            echo '<option '; 
                if ('307' == $selected) echo 'selected="selected"'; 
                echo ' value="307">'. __("307 redirect","wp-seopress") .'</option>';
        echo '</select>';

        if (isset($this->options['seopress_404_redirect_status_code'])) {
            esc_attr( $this->options['seopress_404_redirect_status_code']);
        }
    }

    public function seopress_404_enable_mails_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_404_enable_mails']);      
        
        echo '<input id="seopress_404_enable_mails" name="seopress_pro_option_name[seopress_404_enable_mails]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_404_enable_mails">'. __( '1 mail each time a new 404 is created', 'wp-seopress-pro' ) .'</label><br><br>';

        if (isset($this->options['seopress_404_enable_mails'])) {
            esc_attr( $this->options['seopress_404_enable_mails']);
        }
    }

    public function seopress_404_enable_mails_from_callback()
    {
        $check = isset($this->options['seopress_404_enable_mails_from']) ? $this->options['seopress_404_enable_mails_from'] : NULL;

        printf(
        '<input type="text" name="seopress_pro_option_name[seopress_404_enable_mails_from]" placeholder="'.esc_html__('Enter your email','wp-seopress-pro').'" aria-label="'.__('Send emails to','wp-seopress-pro').'" value="%s" />',
        esc_html( $check )
        
        );
    }

    //htaccess
    public function seopress_htaccess_file_callback()
    {
        if (defined('SEOPRESS_BLOCK_HTACCESS') && SEOPRESS_BLOCK_HTACCESS == true) {
            echo '<div class="error notice is-dismissable"><p>'.__('Access not allowed.','wp-seopress-pro').'</p></div>';
        } else {
            if ( !is_network_admin() && is_multisite()) {
                echo '<p>'.__('Multisite is enabled, go to network SEO settings to manage your .htaccess file.','wp-seopress-pro').'</p>';
            } else {
                if ( isset( $_SERVER['SERVER_SOFTWARE'] )) {
                    $server_software = explode('/', $_SERVER['SERVER_SOFTWARE']);
                    reset($server_software);
                    if (current($server_software) !='nginx' ) {
                        if (file_exists(get_home_path(). '/.htaccess')) {
                            
                            $htaccess = file_get_contents(get_home_path(). '/.htaccess');

                            echo '<textarea id="seopress_htaccess_file" name="seopress_pro_option_name[seopress_htaccess_file]" rows="15" aria-label="'.__('Edit your htaccess file','wp-seopress-pro').'" placeholder="'.esc_html__('This is your htaccess file!','wp-seopress-pro').'">'.$htaccess.'</textarea>';

                            if (isset($this->options['seopress_htaccess_file'])) {
                                esc_html( $this->options['seopress_htaccess_file']);
                            }

                            echo '<div class="wrap-tags">';

                            echo '<span id="seopress-tag-htaccess-1" class="tag-title" data-tag="Options -Indexes"><span class="dashicons dashicons-plus"></span>'.__('Block directory browsing','wp-seopress-pro').'</span>';

                            echo '<span id="seopress-tag-htaccess-2" class="tag-title" data-tag="<files wp-config.php>
                order allow,deny
                deny from all
                </files>"><span class="dashicons dashicons-plus"></span>'.__('Protect wp-config.php file','wp-seopress-pro').'</span>';

                            echo '<span id="seopress-tag-htaccess-3" class="tag-title" data-tag="redirect 301 /your-old-url/ https://www.example.com/your-new-url"><span class="dashicons dashicons-plus"></span>'.__('301 redirection','wp-seopress-pro').'</span>';

                        echo '</div>';

                            echo '<br><br><button id="seopress-save-htaccess" class="button"><span class="dashicons dashicons-upload"></span>'.__('Saves htaccess changes','wp-seopress-pro').'</button>';
                            echo '<span class="spinner"></span>';
                        } else {
                            echo '<p>'.__('You don\'t have an htaccess file on your server.','wp-seopress-pro').'</p>';
                        }
                    } else {
                        echo '<p>'.__('Your server is running Nginx, you don\'t have htaccess file.','wp-seopress-pro').'</p>';
                    }
                }
            }
        }
    }

    //RSS
    public function seopress_rss_before_html_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );
        $check = isset($options['seopress_rss_before_html']) ? $options['seopress_rss_before_html'] : NULL;

        printf(
        '<textarea id="seopress_rss_before_html" name="seopress_pro_option_name[seopress_rss_before_html]" rows="4" placeholder="'.esc_html__('Enter your HTML content','wp-seopress-pro').'" aria-label="'.__('Display content before each post','wp-seopress-pro').'">%s</textarea>',
        esc_html( $check ));

        echo '<p class="description">'.__('HTML tags allowed: strong, em, br, a href','wp-seopress-pro').'</p>';

        echo '<p class="description">'.__('Dynamic variables: %%sitetitle%%, %%tagline%%, %%post_author%%, %%post_permalink%%','wp-seopress-pro').'</p>';
    }

    public function seopress_rss_after_html_callback()
    {

        $options = get_option( 'seopress_pro_option_name' );
        $check = isset($options['seopress_rss_after_html']) ? $options['seopress_rss_after_html'] : NULL;

        printf(
        '<textarea id="seopress_rss_after_html" name="seopress_pro_option_name[seopress_rss_after_html]" rows="4" aria-label="'.__('Display content after each post','wp-seopress-pro').'" placeholder="'.esc_html__('Enter your HTML content','wp-seopress-pro').'">%s</textarea>',
        esc_html( $check ));

        echo '<p class="description">'.__('HTML tags allowed: strong, em, br, a href','wp-seopress-pro').'</p>';
        echo '<p class="description">'.__('Dynamic variables: %%sitetitle%%, %%tagline%%, %%post_author%%, %%post_permalink%%','wp-seopress-pro').'</p>';
    }

    public function seopress_rss_disable_comments_feed_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_rss_disable_comments_feed']);      
        
        echo '<input id="seopress_rss_disable_comments_feed" name="seopress_pro_option_name[seopress_rss_disable_comments_feed]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_rss_disable_comments_feed">'. __( 'Remove feed link in source code', 'wp-seopress-pro' ) .'</label><br><br>';

        if (isset($this->options['seopress_rss_disable_comments_feed'])) {
            esc_attr( $this->options['seopress_rss_disable_comments_feed']);
        }
    }

    public function seopress_rss_disable_posts_feed_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_rss_disable_posts_feed']);      
        
        echo '<input id="seopress_rss_disable_posts_feed" name="seopress_pro_option_name[seopress_rss_disable_posts_feed]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_rss_disable_posts_feed">'. __( 'Remove feed link in source code (default WordPress RSS feed)', 'wp-seopress-pro' ) .'</label><br><br>';

        if (isset($this->options['seopress_rss_disable_posts_feed'])) {
            esc_attr( $this->options['seopress_rss_disable_posts_feed']);
        }
    }

    public function seopress_rss_disable_extra_feed_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_rss_disable_extra_feed']);      
        
        echo '<input id="seopress_rss_disable_extra_feed" name="seopress_pro_option_name[seopress_rss_disable_extra_feed]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_rss_disable_extra_feed">'. __( 'Remove feed link in source code (author, categories, custom taxonomies, custom post type, comments feed for a single post...)', 'wp-seopress-pro' ) .'</label><br><br>';

        if (isset($this->options['seopress_rss_disable_extra_feed'])) {
            esc_attr( $this->options['seopress_rss_disable_extra_feed']);
        }
    }    

    public function seopress_rss_disable_all_feeds_callback()
    {
        $options = get_option( 'seopress_pro_option_name' );  
        
        $check = isset($options['seopress_rss_disable_all_feeds']);      
        
        echo '<input id="seopress_rss_disable_all_feeds" name="seopress_pro_option_name[seopress_rss_disable_all_feeds]" type="checkbox"';
        if ('1' == $check) echo 'checked="yes"'; 
        echo ' value="1"/>';
        
        echo '<label for="seopress_rss_disable_all_feeds">'. __( 'Disable all WordPress RSS feeds (all feeds will no longer be accessible)', 'wp-seopress-pro' ) .'</label><br><br>';

        if (isset($this->options['seopress_rss_disable_all_feeds'])) {
            esc_attr( $this->options['seopress_rss_disable_all_feeds']);
        }
    }

    //Backlinks
    public function seopress_backlinks_majestic_key_callback() 
    {

        $options = get_option( 'seopress_pro_option_name' );  
        $selected = isset($options['seopress_backlinks_majestic_key']) ? '********************************' : '';

        echo '<input type="password" name="seopress_pro_option_name[seopress_backlinks_majestic_key]" placeholder="'.esc_html__('Enter your Majestic API key','wp-seopress-pro','wp-seopress-pro').'" aria-label="'.__('Enter your Majestic API key','wp-seopress-pro').'" value="'.$selected.'" />';
    }    

    //Rewrite
    public function seopress_rewrite_search_callback() 
    {
        $options = get_option( 'seopress_pro_option_name' );
        $check = isset($options['seopress_rewrite_search']) ? $options['seopress_rewrite_search'] : NULL;

        echo '<input type="text" name="seopress_pro_option_name[seopress_rewrite_search]" placeholder="'.esc_html__('Search results base','wp-seopress-pro','wp-seopress-pro').'" aria-label="'.__('Search results base, eg: "search-results" without quotes','wp-seopress-pro').'" value="'.$check.'" />';

        echo '<p class="description"><span class="dashicons dashicons-info"></span>'.__('Flush your permalinks each time you edit this setting.','wp-seopress-pro').'</p>';
    }

    //White Label
    public function seopress_white_label_admin_header_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );  
        
            $check = isset($options['seopress_mu_white_label_admin_header']);      
            
            echo '<input id="seopress_mu_white_label_admin_header" name="seopress_pro_mu_option_name[seopress_mu_white_label_admin_header]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_mu_white_label_admin_header">'. __( 'Remove the SEOPress admin header including Notifications Center, SEO tools and Useful links', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_mu_white_label_admin_header'])) {
                esc_attr( $this->options['seopress_mu_white_label_admin_header']);
            }
        } else {
            $options = get_option( 'seopress_pro_option_name' );  
        
            $check = isset($options['seopress_white_label_admin_header']);      
            
            echo '<input id="seopress_white_label_admin_header" name="seopress_pro_option_name[seopress_white_label_admin_header]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_white_label_admin_header">'. __( 'Remove the SEOPress admin header including Notifications Center, SEO tools and Useful links', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_white_label_admin_header'])) {
                esc_attr( $this->options['seopress_white_label_admin_header']);
            }
        }
    }

    public function seopress_white_label_admin_notices_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );  
        
            $check = isset($options['seopress_mu_white_label_admin_notices']);      
            
            echo '<input id="seopress_mu_white_label_admin_notices" name="seopress_pro_mu_option_name[seopress_mu_white_label_admin_notices]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_mu_white_label_admin_notices">'. __( 'Remove SEOPress icons on the right in header (changelog, YouTube, Twitter...)', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_mu_white_label_admin_notices'])) {
                esc_attr( $this->options['seopress_mu_white_label_admin_notices']);
            }
        } else {
            $options = get_option( 'seopress_pro_option_name' );  
        
            $check = isset($options['seopress_white_label_admin_notices']);      
            
            echo '<input id="seopress_white_label_admin_notices" name="seopress_pro_option_name[seopress_white_label_admin_notices]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_white_label_admin_notices">'. __( 'Remove SEOPress icons on the right in header (changelog, YouTube, Twitter...)', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_white_label_admin_notices'])) {
                esc_attr( $this->options['seopress_white_label_admin_notices']);
            }
        }
    }

    public function seopress_white_label_admin_menu_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );
            $check = isset($options['seopress_mu_white_label_admin_menu']) ? $options['seopress_mu_white_label_admin_menu'] : NULL;

            echo '<input type="text" name="seopress_pro_mu_option_name[seopress_mu_white_label_admin_menu]" placeholder="'.esc_html__('Enter your dashicons CSS class name','wp-seopress-pro').'" aria-label="'.__('CSS Dashicons class name without quotes','wp-seopress-pro').'" value="'.$check.'" />';
        } else {
            $options = get_option( 'seopress_pro_option_name' );
            $check = isset($options['seopress_white_label_admin_menu']) ? $options['seopress_white_label_admin_menu'] : NULL;

            echo '<input type="text" name="seopress_pro_option_name[seopress_white_label_admin_menu]" placeholder="'.esc_html__('Enter your dashicons CSS class name','wp-seopress-pro').'" aria-label="'.__('CSS Dashicons class name without quotes','wp-seopress-pro').'" value="'.$check.'" />';
        }
        echo '<p class="description"><span class="dashicons dashicons-info"></span><a href="https://developer.wordpress.org/resource/dashicons/" target="_blank" rel="nofollow noopener noreferrer">'.__('Find your Dashicons CSS class name on the official website (new window)','wp-seopress-pro').'</a></p>';
    }

    public function seopress_white_label_admin_bar_icon_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );
            $check = isset($options['seopress_mu_white_label_admin_bar_icon']) ? $options['seopress_mu_white_label_admin_bar_icon'] : NULL;

            echo '<input type="text" name="seopress_pro_mu_option_name[seopress_mu_white_label_admin_bar_icon]" placeholder="'.esc_html__('default value: <span class="ab-icon icon-seopress-seopress"></span> SEO','wp-seopress-pro').'" aria-label="'.__('Enter the label of the link for admin bar','wp-seopress-pro').'" value="'.$check.'" />';
        } else {
            $options = get_option( 'seopress_pro_option_name' );
            $check = isset($options['seopress_white_label_admin_bar_icon']) ? $options['seopress_white_label_admin_bar_icon'] : NULL;

            echo '<input type="text" name="seopress_pro_option_name[seopress_white_label_admin_bar_icon]" placeholder="'.esc_html__('default value: <span class="ab-icon icon-seopress-seopress"></span> SEO','wp-seopress-pro').'" aria-label="'.__('Enter the label of the link for admin bar','wp-seopress-pro').'" value="'.$check.'" />';
        }
    }

    public function seopress_white_label_admin_bar_logo_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );

            $check = isset($options['seopress_mu_white_label_admin_bar_logo']) ? $options['seopress_mu_white_label_admin_bar_logo'] : NULL;

            echo '<input type="text" name="seopress_pro_mu_option_name[seopress_mu_white_label_admin_bar_logo]" placeholder="'.esc_html__('eg: https://www.example.com/my-custom-image.png','wp-seopress-pro').'" aria-label="'.__('Enter the absolute URL to your logo','wp-seopress-pro').'" value="'.$check.'" />';
        } else {
            $options = get_option( 'seopress_pro_option_name' );
            $check = isset($options['seopress_white_label_admin_bar_logo']) ? $options['seopress_white_label_admin_bar_logo'] : NULL;

            echo '<input type="text" name="seopress_pro_option_name[seopress_white_label_admin_bar_logo]" placeholder="'.esc_html__('eg: https://www.example.com/my-custom-image.png','wp-seopress-pro').'" aria-label="'.__('Enter the absolute URL to your logo','wp-seopress-pro').'" value="'.$check.'" />';
        }
    }

    public function seopress_white_label_footer_credits_callback()
    {
        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );

            $check = isset($options['seopress_mu_white_label_footer_credits']);      
        
            echo '<input id="seopress_mu_white_label_footer_credits" name="seopress_pro_mu_option_name[seopress_mu_white_label_footer_credits]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_mu_white_label_footer_credits">'. __( 'Remove "You like SEOPress? Don\'t forget to rate it 5 stars!"', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_mu_white_label_footer_credits'])) {
                esc_attr( $this->options['seopress_mu_white_label_footer_credits']);
            }
        } else {
            $options = get_option( 'seopress_pro_option_name' );

            $check = isset($options['seopress_white_label_footer_credits']);      
        
            echo '<input id="seopress_white_label_footer_credits" name="seopress_pro_option_name[seopress_white_label_footer_credits]" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_white_label_footer_credits">'. __( 'Remove "You like SEOPress? Don\'t forget to rate it 5 stars!"', 'wp-seopress-pro' ) .'</label><br><br>';

            if (isset($this->options['seopress_white_label_footer_credits'])) {
                esc_attr( $this->options['seopress_white_label_footer_credits']);
            }
        }
    }

    public function seopress_white_label_menu_pages_callback()
    {
        $seopress_menu_pages = array(
            'seopress-option' => __('SEO','wp-seopress-pro'),
            'seopress-titles' => __('Titles & Metas','wp-seopress-pro'),
            'seopress-xml-sitemap' => __('XML / HTML Sitemap','wp-seopress-pro'), 
            'seopress-social' => __('Social Networks','wp-seopress-pro'), 
            'seopress-google-analytics' => __('Google Analytics','wp-seopress-pro'), 
            'seopress-advanced' => __('Advanced','wp-seopress-pro'), 
            'seopress-import-export' => __('Tools','wp-seopress-pro'), 
            'seopress-bot-batch' => __('BOT','wp-seopress-pro'), 
            'seopress-license' => __('License','wp-seopress-pro'), 
            'seopress-pro-page' => __('PRO','wp-seopress-pro'), 
            'edit.php?post_type=seopress_404' => __('Redirections','wp-seopress-pro'), 
            'edit.php?post_type=seopress_bot' => __('Broken links','wp-seopress-pro'), 
            'edit.php?post_type=seopress_backlinks' => __('Backlinks','wp-seopress-pro')
        );

        if (is_network_admin() && is_multisite()) {
            $options = get_option( 'seopress_pro_mu_option_name' );

            foreach ($seopress_menu_pages as $seopress_menu_pages_key => $seopress_menu_pages_value) {

                echo '<div class="seopress_wrap_single_cpt">';
                    
                    $check = isset($options['seopress_mu_white_label_menu_pages'][$seopress_menu_pages_key]['include']);      
                    
                    echo '<input id="seopress_mu_white_label_menu_pages_list['.$seopress_menu_pages_key.']" name="seopress_pro_mu_option_name[seopress_mu_white_label_menu_pages]['.$seopress_menu_pages_key.'][include]" type="checkbox"';
                    if ('1' == $check) echo 'checked="yes"'; 
                    echo ' value="1"/>';

                    echo '<label for="seopress_mu_white_label_menu_pages_list['.$seopress_menu_pages_key.']">'.$seopress_menu_pages_value.'</label>';
                    
                    if (isset($this->options['seopress_mu_white_label_menu_pages'][$seopress_menu_pages_key]['include'])) {
                        esc_attr( $this->options['seopress_mu_white_label_menu_pages'][$seopress_menu_pages_key]['include']);
                    }

                echo '</div>';
            }
        }
        echo '<br>';
        echo '<p class="description">'.__('Users with the "manage_options" capability will still see the menus.','wp-seopress-pro').'</p>';
    }

    //Google Analytics
    public function seopress_google_analytics_auth_callback()
    {
        
        $options = get_option( 'seopress_google_analytics_option_name' );

        $selected = isset($options['seopress_google_analytics_auth']) ? $options['seopress_google_analytics_auth'] : NULL;
        
        function seopress_google_analytics_auth_client_id_option() {
            $seopress_google_analytics_auth_client_id_option = get_option("seopress_google_analytics_option_name");
            if ( ! empty ( $seopress_google_analytics_auth_client_id_option ) ) {
                foreach ($seopress_google_analytics_auth_client_id_option as $key => $seopress_google_analytics_auth_client_id_value)
                    $options[$key] = $seopress_google_analytics_auth_client_id_value;
                 if (isset($seopress_google_analytics_auth_client_id_option['seopress_google_analytics_auth_client_id'])) { 
                    return $seopress_google_analytics_auth_client_id_option['seopress_google_analytics_auth_client_id'];
                 }
            }
        }

        function seopress_google_analytics_auth_secret_id_option() {
            $seopress_google_analytics_auth_secret_id_option = get_option("seopress_google_analytics_option_name");
            if ( ! empty ( $seopress_google_analytics_auth_secret_id_option ) ) {
                foreach ($seopress_google_analytics_auth_secret_id_option as $key => $seopress_google_analytics_auth_secret_id_value)
                    $options[$key] = $seopress_google_analytics_auth_secret_id_value;
                 if (isset($seopress_google_analytics_auth_secret_id_option['seopress_google_analytics_auth_secret_id'])) { 
                    return $seopress_google_analytics_auth_secret_id_option['seopress_google_analytics_auth_secret_id'];
                 }
            }
        }
        
        function seopress_google_analytics_auth_token_option() {
            $seopress_google_analytics_auth_token_option = get_option("seopress_google_analytics_option_name1");
            if ( ! empty ( $seopress_google_analytics_auth_token_option ) ) {
                foreach ($seopress_google_analytics_auth_token_option as $key => $seopress_google_analytics_auth_token_value)
                    $options[$key] = $seopress_google_analytics_auth_token_value;
                    if (isset($seopress_google_analytics_auth_token_option['access_token'])) {
                        return $seopress_google_analytics_auth_token_option['access_token'];
                    }
            }
        }
        
        function seopress_google_analytics_refresh_token_option() {
            $seopress_google_analytics_refresh_token_option = get_option("seopress_google_analytics_option_name1");
            if ( ! empty ( $seopress_google_analytics_refresh_token_option ) ) {
                foreach ($seopress_google_analytics_refresh_token_option as $key => $seopress_google_analytics_refresh_token_value)
                    $options[$key] = $seopress_google_analytics_refresh_token_value;
                    if (isset($seopress_google_analytics_refresh_token_option['refresh_token'])) {
                        return $seopress_google_analytics_refresh_token_option['refresh_token'];
                    }
            }
        }
        
        function seopress_google_analytics_auth_code_option() {
            $seopress_google_analytics_auth_code_option = get_option("seopress_google_analytics_option_name1");
            if ( ! empty ( $seopress_google_analytics_auth_code_option ) ) {
                foreach ($seopress_google_analytics_auth_code_option as $key => $seopress_google_analytics_auth_code_value)
                    $options[$key] = $seopress_google_analytics_auth_code_value;
                    if (isset($seopress_google_analytics_auth_code_option['code'])) {
                        return $seopress_google_analytics_auth_code_option['code'];
                    }
            }
        }
        
        function seopress_google_analytics_debug_option() {
            $seopress_google_analytics_debug_option = get_option("seopress_google_analytics_option_name1");
            if ( ! empty ( $seopress_google_analytics_debug_option ) ) {
                foreach ($seopress_google_analytics_debug_option as $key => $seopress_google_analytics_debug_value)
                    $options[$key] = $seopress_google_analytics_debug_value;
                    if (isset($seopress_google_analytics_debug_option['debug'])) {
                        return $seopress_google_analytics_debug_option['debug'];
                    }
            }
        }
        
        require_once __DIR__ . '/../functions/google-analytics/vendor/autoload.php';
        

        if (seopress_google_analytics_auth_client_id_option() !='') {
            $client_id = seopress_google_analytics_auth_client_id_option();
        }

        if (seopress_google_analytics_auth_secret_id_option() !='') {
            $client_secret = seopress_google_analytics_auth_secret_id_option();
        }
        
        $redirect_uri = admin_url('admin.php?page=seopress-google-analytics');

        if (seopress_google_analytics_auth_client_id_option() !='' && seopress_google_analytics_auth_secret_id_option() !='') {
            $client = new Google_Client();
            $client->setApplicationName("Client_Library_Examples");
            $client->setClientId($client_id);
            $client->setClientSecret($client_secret);
            $client->setRedirectUri($redirect_uri);
            $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
            $client->setApprovalPrompt('force');   // mandatory to get this fucking refreshtoken
            $client->setAccessType('offline'); // mandatory to get this fucking refreshtoken
        } else {
            _e('To sign in with Google Analytics, you have to set a Client and Secret ID in the fields below:','wp-seopress-pro');
        }

        //Logout
        if (isset($_GET['logout'])) {
            if ($_GET['logout'] == "1") {
                $seopress_google_analytics_options = get_option('seopress_google_analytics_option_name1');
                $seopress_google_analytics_options['refresh_token'] = '';
                $seopress_google_analytics_options['access_token'] = '';
                $seopress_google_analytics_options['code'] = '';
                $seopress_google_analytics_options['debug'] = '';
                update_option('seopress_google_analytics_option_name1', $seopress_google_analytics_options, 'yes');
                
                update_option('seopress_google_analytics_lock_option_name', '', 'yes');
            }
        }
        
        if (seopress_google_analytics_auth_client_id_option() !='' && seopress_google_analytics_auth_secret_id_option() !='') {
            if (isset($_GET['code']) && seopress_google_analytics_auth_token_option() =='') {
                
                $client->authenticate($_GET['code']);  
                $_SESSION['token'] = $client->getAccessToken();
             
                $seopress_google_analytics_options = get_option('seopress_google_analytics_option_name1');
                $seopress_google_analytics_options['access_token'] = $_SESSION['token']['access_token'];
                $seopress_google_analytics_options['refresh_token'] = $_SESSION['token']['refresh_token'];
                $seopress_google_analytics_options['debug'] = $_SESSION['token'];
                $seopress_google_analytics_options['code'] = $_GET['code'];
                update_option('seopress_google_analytics_option_name1', $seopress_google_analytics_options, 'yes');
            }
            
            //Login button
            if (!$client->getAccessToken() && seopress_google_analytics_auth_token_option() =='') {
                $authUrl = $client->createAuthUrl();
                echo '<p><a class="login button button-primary" href='.$authUrl.'><span class="dashicons dashicons-chart-area"></span>'.__('Connect with Google Analytics','wp-seopress-pro').'</a></p>';
            }   
        
            //Logout button
            if (seopress_google_analytics_auth_token_option() !='') {
                
                $client->setAccessToken(seopress_google_analytics_debug_option());
            
                if ($client->isAccessTokenExpired()) {
                    $client->refreshToken(seopress_google_analytics_debug_option());
                    
                    $seopress_new_access_token = $client->getAccessToken(seopress_google_analytics_debug_option());

                    $seopress_google_analytics_options = get_option('seopress_google_analytics_option_name1');
                    $seopress_google_analytics_options['access_token'] = $seopress_new_access_token['access_token'];
                    $seopress_google_analytics_options['refresh_token'] = $seopress_new_access_token['refresh_token'];
                    $seopress_google_analytics_options['debug'] = $seopress_new_access_token;
                    update_option('seopress_google_analytics_option_name1', $seopress_google_analytics_options, 'yes');
                }
                
                echo '<p><a class="logout button" href="'.$redirect_uri.'&logout=1"><span class="dashicons dashicons-migrate"></span>'.__('Log out from Google','wp-seopress-pro').'</a></p><br>';
                
                $service = new Google_Service_Analytics($client);

                //Select view from Google Analytics
                $accounts = $service->management_accountSummaries->listManagementAccountSummaries();

                if (get_option('seopress_google_analytics_lock_option_name') =='1') {
                    echo '<p>'.__('Your Google Analytics view is locked. Log out from Google to unlocked it.','wp-seopress-pro').'</p>';            
                } else {
                    echo '<p><select id="seopress_google_analytics_auth" name="seopress_google_analytics_option_name[seopress_google_analytics_auth]">';
                    
                    foreach ($accounts->getItems() as $item) {
                        foreach($item->getWebProperties() as $wp) {
                            $views = $wp->getProfiles();
                            if (!is_null($views)) {
                                foreach($wp->getProfiles() as $view) {
                                    echo ' <option '; 
                                    if ($view['id'] == $selected) echo 'selected="selected"'; 
                                        echo ' value="'.$view['id'].'">'. $item['name'] .' > '. $wp['name'] .' > '. $view['name'] .'</option>';
                                }
                            }
                        }    
                    }
                    echo '</select></p>';

                    if ($selected != NULL) {
                    echo '<br><div class="button" id="seopress-google-analytics-lock"><span class="dashicons dashicons-lock"></span> '.__('Lock selection?','wp-seopress-pro').'</div><span class="spinner"></span>';
                    }
                }
            }
        }
        if (isset($this->options['seopress_google_analytics_auth'])) {
            esc_attr( $this->options['seopress_google_analytics_auth']);
        }
    }

    public function seopress_google_analytics_auth_client_id_callback()
    {
        $options = get_option( 'seopress_google_analytics_option_name' );  
        $selected = $options['seopress_google_analytics_auth_client_id'];

        echo '<input type="text" name="seopress_google_analytics_option_name[seopress_google_analytics_auth_client_id]" placeholder="'.esc_html__('Enter your client ID','wp-seopress-pro').'" aria-label="'.__('Google Console Client ID','wp-seopress-pro').'" value="'.$selected.'" />';
        
        if (isset($this->options['seopress_google_analytics_auth_client_id'])) {
            esc_html( $this->options['seopress_google_analytics_auth_client_id']);
        }

        echo '<a class="seopress-doc" href="https://www.seopress.org/support/guides/connect-wordpress-site-google-analytics/" target="_blank"><span class="dashicons dashicons-editor-help"></span><span class="screen-reader-text">'.__('Guide to connect your WordPress site with Google Analytics - new window','wp-seopress-pro').'</span></a>';
    }
    
    public function seopress_google_analytics_auth_secret_id_callback()
    {
        $options = get_option( 'seopress_google_analytics_option_name' );  
        $selected = $options['seopress_google_analytics_auth_secret_id'];

        echo '<input type="text" name="seopress_google_analytics_option_name[seopress_google_analytics_auth_secret_id]" placeholder="'.esc_html__('Enter your secret ID','wp-seopress-pro').'" aria-label="'.__('Google Console Secret ID','wp-seopress-pro').'" value="'.$selected.'" />';
        
        if (isset($this->options['seopress_google_analytics_auth_secret_id'])) {
            esc_html( $this->options['seopress_google_analytics_auth_secret_id']);
        }
    }

    public function seopress_advanced_security_metaboxe_sdt_role_callback()
    {
        $options = get_option( 'seopress_advanced_option_name' );  
        
        global $wp_roles;

        if ( ! isset( $wp_roles ) )
            $wp_roles = new WP_Roles();
    
        foreach ($wp_roles->get_names() as $key => $value) {

            $check = isset($options['seopress_advanced_security_metaboxe_sdt_role'][$key]);  

            echo '<input id="seopress_advanced_security_metaboxe_sdt_role_'.$key.'" name="seopress_advanced_option_name[seopress_advanced_security_metaboxe_sdt_role]['.$key.']" type="checkbox"';
            if ('1' == $check) echo 'checked="yes"'; 
            echo ' value="1"/>';
            
            echo '<label for="seopress_advanced_security_metaboxe_sdt_role_'.$key.'">'. $value .'</label><br/>';

            if (isset($this->options['seopress_advanced_security_metaboxe_sdt_role'][$key])) {
                esc_attr( $this->options['seopress_advanced_security_metaboxe_sdt_role'][$key]);
            }
        }

        if (function_exists('seopress_get_locale')) {
            if (seopress_get_locale() =='fr') {
                $seopress_docs_link['support']['security']['metaboxe_data_types'] = 'https://www.seopress.org/fr/support/hooks/filtrer-lappel-de-la-metaboxe-types-de-donnees-structurees-par-types-de-contenu/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            } else {
                $seopress_docs_link['support']['security']['metaboxe_data_types'] = 'https://www.seopress.org/support/hooks/filter-structured-data-types-metaboxe-call-by-post-type/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
            }
        }
        ?>
        <a href="<?php echo $seopress_docs_link['support']['security']['metaboxe_data_types']; ?>" target="_blank" class="seopress-doc"><span class="dashicons dashicons-editor-help"></span><span class="screen-reader-text"><?php _e('Hook to filter Structured data types metabox call by post type - new window','wp-seopress-pro'); ?></span></a>
        <?php
    }
}
    
if( is_admin() )
    $my_settings_page = new seopress_pro_options();