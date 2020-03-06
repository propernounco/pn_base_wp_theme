<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );
///////////////////////////////////////////////////////////////////////////////////////////////////
//SEOPress Bot
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_request_bot() {
    check_ajax_referer( 'seopress_request_bot_nonce', $_POST['_ajax_nonce'], true );
    
    if (current_user_can('manage_options') && is_admin()) {
        //Init
        $data = array();

        //Links cleaning
        function seopress_bot_scan_settings_cleaning_option() {
            $seopress_bot_scan_settings_cleaning_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_cleaning_option ) ) {
                foreach ($seopress_bot_scan_settings_cleaning_option as $key => $seopress_bot_scan_settings_cleaning_value)
                    $options[$key] = $seopress_bot_scan_settings_cleaning_value;
                if (isset($seopress_bot_scan_settings_cleaning_option['seopress_bot_scan_settings_cleaning'])) { 
                    return $seopress_bot_scan_settings_cleaning_option['seopress_bot_scan_settings_cleaning'];
                }
            }
        }

        //Cleaning seopress_bot post type
        if (seopress_bot_scan_settings_cleaning_option() ==1 && isset($_POST['offset']) && $_POST['offset']==0) {
            global $wpdb;

            // delete all posts by post type.
            $sql = 'DELETE `posts`, `pm`
                FROM `' . $wpdb->prefix . 'posts` AS `posts` 
                LEFT JOIN `' . $wpdb->prefix . 'postmeta` AS `pm` ON `pm`.`post_id` = `posts`.`ID`
                WHERE `posts`.`post_type` = \'seopress_bot\'';
            $wpdb->query($sql);
        }

        if ( isset( $_POST['offset'])) {
            $offset = absint($_POST['offset']);
        }

        //Type of links
        function seopress_bot_scan_settings_type_option() {
            $seopress_bot_scan_settings_type_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_type_option ) ) {
                foreach ($seopress_bot_scan_settings_type_option as $key => $seopress_bot_scan_settings_type_value)
                    $options[$key] = $seopress_bot_scan_settings_type_value;
                if (isset($seopress_bot_scan_settings_type_option['seopress_bot_scan_settings_type'])) { 
                    return $seopress_bot_scan_settings_type_option['seopress_bot_scan_settings_type'];
                }
            }
        }

        //Find links in
        function seopress_bot_scan_settings_where_option() {
            $seopress_bot_scan_settings_where_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_where_option ) ) {
                foreach ($seopress_bot_scan_settings_where_option as $key => $seopress_bot_scan_settings_where_value)
                    $options[$key] = $seopress_bot_scan_settings_where_value;
                if (isset($seopress_bot_scan_settings_where_option['seopress_bot_scan_settings_where'])) { 
                    return $seopress_bot_scan_settings_where_option['seopress_bot_scan_settings_where'];
                }
            }
        }

        //404 only
        function seopress_bot_scan_settings_404_option() {
            $seopress_bot_scan_settings_404_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_404_option ) ) {
                foreach ($seopress_bot_scan_settings_404_option as $key => $seopress_bot_scan_settings_404_value)
                    $options[$key] = $seopress_bot_scan_settings_404_value;
                if (isset($seopress_bot_scan_settings_404_option['seopress_bot_scan_settings_404'])) { 
                    return $seopress_bot_scan_settings_404_option['seopress_bot_scan_settings_404'];
                }
            }
        }

        //Timeout
        function seopress_bot_scan_settings_timeout_option() {
            $seopress_bot_scan_settings_timeout_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_timeout_option ) ) {
                foreach ($seopress_bot_scan_settings_timeout_option as $key => $seopress_bot_scan_settings_timeout_value)
                    $options[$key] = $seopress_bot_scan_settings_timeout_value;
                if (isset($seopress_bot_scan_settings_timeout_option['seopress_bot_scan_settings_timeout'])) { 
                    return $seopress_bot_scan_settings_timeout_option['seopress_bot_scan_settings_timeout'];
                }
            }
        }

        //Number of content to scan
        function seopress_bot_scan_settings_number_option() {
            $seopress_bot_scan_settings_number_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_number_option ) ) {
                foreach ($seopress_bot_scan_settings_number_option as $key => $seopress_bot_scan_settings_number_value)
                    $options[$key] = $seopress_bot_scan_settings_number_value;
                 if (isset($seopress_bot_scan_settings_number_option['seopress_bot_scan_settings_number'])) { 
                    return $seopress_bot_scan_settings_number_option['seopress_bot_scan_settings_number'];
                 }
            }
        }

        //Include Custom Post Types
        function seopress_bot_scan_settings_post_types_option() {
            $seopress_bot_scan_settings_post_types_option = get_option("seopress_bot_option_name");
            if ( ! empty ( $seopress_bot_scan_settings_post_types_option ) ) {
                foreach ($seopress_bot_scan_settings_post_types_option as $key => $seopress_bot_scan_settings_post_types_value)
                    $options[$key] = $seopress_bot_scan_settings_post_types_value;
                    if (isset($seopress_bot_scan_settings_post_types_option['seopress_bot_scan_settings_post_types'])) { 
                        return $seopress_bot_scan_settings_post_types_option['seopress_bot_scan_settings_post_types'];
                    }
            }
        }
        if (seopress_bot_scan_settings_post_types_option() !='') {
            $seopress_bot_post_types_cpt_array = array();
            foreach (seopress_bot_scan_settings_post_types_option() as $cpt_key => $cpt_value) {
                foreach ($cpt_value as $_cpt_key => $_cpt_value) {
                    if($_cpt_value =='1') {
                        array_push($seopress_bot_post_types_cpt_array, $cpt_key);
                    }
                }
            }

            if (seopress_bot_scan_settings_number_option() !='' && seopress_bot_scan_settings_number_option() >= 10) {
                $limit = seopress_bot_scan_settings_number_option();
            } else {
                $limit = 100;
            }

            global $post;
            
            if ($offset > $limit) {
                wp_reset_query();
                //Log date
                update_option('seopress-bot-log', current_time( 'Y-m-d H:i' ), 'yes');
                
                $offset = 'done';
            } else {
                $args = array(
                    'posts_per_page' => 1,
                    'offset' => $offset,
                    'cache_results' => false,
                    'order' => 'DESC',
                    'orderby' => 'date',
                    'post_type' => $seopress_bot_post_types_cpt_array,
                    'post_status' => 'publish',
                    'fields' => 'ids',
                );
                $args = apply_filters('seopress_bot_query', $args);
                $bot_query = get_posts( $args );

                if ($bot_query) {
                    //DOM
                    $dom = new DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $dom->preserveWhiteSpace = false;
                    
                    //Get source code
                    if (seopress_bot_scan_settings_timeout_option() !='') {
                        $timeout = seopress_bot_scan_settings_timeout_option();
                    } else {
                        $timeout = 5;
                    }
                    $args = array(
                        'blocking' => true,
                        'timeout'  => $timeout,
                        'sslverify'   => false,
                        'compress' => true,
                    );
                    foreach ($bot_query as $post) {

                        if (seopress_bot_scan_settings_where_option() =='' || seopress_bot_scan_settings_where_option() =='post_content') {//post content
                            $response = apply_filters('the_content', get_post_field('post_content', $post));
                            
                            //Themify compatibility
                            if ( defined( 'THEMIFY_DIR' ) ) {
                                $response = get_post_field('post_content', $post);
                            }
                            $data['post_title'][] = get_the_title($post);
                        } else { //body page
                            $response = wp_remote_get(get_permalink($post), $args);

                            //Check for error
                            if ( is_wp_error( $response ) || wp_remote_retrieve_response_code($response) =='404' ) {
                                $data['post_title'] = __('Unable to request page: ', 'wp-seopress').get_the_title($post);
                            } else {
                                $response = wp_remote_retrieve_body($response);
                                $data['post_title'][] = get_the_title($post);
                                
                                if($dom->loadHTML('<?xml encoding="utf-8" ?>' .$response)) {
                                    $xpath = new DOMXPath($dom);
        
                                    //Links
                                    $links = $xpath->query("//a/@href");
        
                                    if (!empty($links)) {
                                        foreach($links as $key => $link){
                                            $links2 = array();
        
                                            //remove anchors
                                            if ($link->nodeValue !='#') {
                                                $links2[] = $link->nodeValue;
                                            }
        
                                            //remove duplicates
                                            $links2 = array_unique($links2);
        
                                            foreach ($links2 as $_key => $_value) {
                                                $args = array('timeout' => $timeout, 'blocking' => true, 'sslverify' => false, 'compress' => true);
        
                                                $response = wp_remote_get($_value, $args);
                                                $bot_status_code = wp_remote_retrieve_response_code($response);
        
                                                if(seopress_bot_scan_settings_type_option() !='')  {
                                                    $bot_status_type = wp_remote_retrieve_header($response, 'content-type');
                                                }
                                                
                                                if (seopress_bot_scan_settings_404_option() !='') {
                                                    if ($bot_status_code =='404' || strpos(json_encode($response), 'cURL error 6')) {
                                                        $check_page_id = get_page_by_title( $_value, OBJECT, 'seopress_bot');
                                                        if (($check_page_id->post_title != $_value && get_post_meta($check_page_id->ID,'seopress_bot_source_url', true) != $_value)) {
                                                            wp_insert_post(array('post_title' => $_value, 'post_type' => 'seopress_bot', 'post_status' => 'publish', 'meta_input' => array( 'seopress_bot_response' => json_encode($response), 'seopress_bot_type' => $bot_status_type, 'seopress_bot_status' => $bot_status_code, 'seopress_bot_source_url' => get_permalink($post), 'seopress_bot_source_id' => $post, 'seopress_bot_source_title' => get_the_title($post), 'seopress_bot_a_title' => $_value->title )));
                                                        } elseif ($check_page_id->post_title == $_value) {
                                                            $seopress_bot_count = get_post_meta($check_page_id->ID,'seopress_bot_count', true);
                                                            update_post_meta($check_page_id->ID, 'seopress_bot_count', ++$seopress_bot_count);
                                                        }
                                                    }
                                                } else {
                                                    $check_page_id = get_page_by_title( $_value, OBJECT, 'seopress_bot');
                                                    if (($check_page_id->post_title != $_value && get_post_meta($check_page_id->ID,'seopress_bot_source_url', true) != $_value)){
                                                        wp_insert_post(array('post_title' => $_value, 'post_type' => 'seopress_bot', 'post_status' => 'publish', 'meta_input' => array( 'seopress_bot_response' => json_encode($response), 'seopress_bot_type' => $bot_status_type, 'seopress_bot_status' => $bot_status_code, 'seopress_bot_source_url' => get_permalink($post), 'seopress_bot_source_id' => $post, 'seopress_bot_source_title' => get_the_title($post), 'seopress_bot_a_title' => $_value->title )));
                                                    } elseif ($check_page_id->post_title == $_value) {
                                                        $seopress_bot_count = get_post_meta($check_page_id->ID,'seopress_bot_count', true);
                                                        update_post_meta($check_page_id->ID, 'seopress_bot_count', ++$seopress_bot_count);
                                                    }
                                                }
                                                $data['link'][] = $_value;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }//End foreach
                    libxml_use_internal_errors($internalErrors);
                    $offset += 1;
                } else {
                    wp_reset_query();
                    //Log date
                    update_option('seopress-bot-log', current_time( 'Y-m-d H:i' ), 'yes');
                    
                    $offset = 'done';
                }
            }
        }
        $data['offset'] = $offset;

        //Return
        wp_send_json_success($data);
    }
}
add_action('wp_ajax_seopress_request_bot', 'seopress_request_bot');
///////////////////////////////////////////////////////////////////////////////////////////////////
//Admin Columns PRO
///////////////////////////////////////////////////////////////////////////////////////////////////
if ( is_plugin_active( 'admin-columns-pro/admin-columns-pro.php' ) ) {
	add_action( 'ac/column_groups', 'ac_register_seopress_column_group' );
	function ac_register_seopress_column_group( AC\Groups $groups ) {
		$groups->register_group( 'seopress', 'SEOPress' );
	}

	add_action( 'ac/column_types', 'ac_register_seopress_columns' );
	function ac_register_seopress_columns( AC\ListScreen $list_screen ) {
		if ( $list_screen instanceof ACP\ListScreen\Post ) {
			require_once plugin_dir_path( __FILE__ ) . 'admin-columns/acp-column-sp_title.php';
			require_once plugin_dir_path( __FILE__ ) . 'admin-columns/acp-column-sp_desc.php';
			require_once plugin_dir_path( __FILE__ ) . 'admin-columns/acp-column-sp_noindex.php';
			require_once plugin_dir_path( __FILE__ ) . 'admin-columns/acp-column-sp_nofollow.php';

			$list_screen->register_column_type( new ACP_Column_sp_title );
			$list_screen->register_column_type( new ACP_Column_sp_desc );
			$list_screen->register_column_type( new ACP_Column_sp_noindex );
			$list_screen->register_column_type( new ACP_Column_sp_nofollow );
		}
	}
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Request Reverse domains
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_request_reverse() {
    check_ajax_referer( 'seopress_request_reverse_nonce', $_GET['_ajax_nonce'], true );

    delete_transient('seopress_results_reverse');
    if ( false === ( $seopress_results_reverse_cache = get_transient( 'seopress_results_reverse' ) ) ) {
        $clean_url = str_replace( array('http://', 'https://'), "", ''.get_home_url() ); 
        
        $response = wp_remote_post('https://domains.yougetsignal.com/domains.php?remoteAddress='.$clean_url);

        if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

            $response_body = __( 'An error occurred, please try again.', 'wp-seopress-pro' );
            
        } else {
            $response_body = wp_remote_retrieve_body($response);
        }
        
        $seopress_results_reverse_cache = $response_body;
        set_transient( 'seopress_results_reverse', $seopress_results_reverse_cache, 365 * DAY_IN_SECONDS );
    }
    wp_send_json_success($data);
}
add_action('wp_ajax_seopress_request_reverse', 'seopress_request_reverse');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Request Google Page Speed
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_request_page_speed() {
    check_ajax_referer( 'seopress_request_page_speed_nonce', $_GET['_ajax_nonce'], true );

    $seopress_google_api_key = 'AIzaSyBqvSx2QrqbEqZovzKX8znGpTosw7KClHQ';
    

    if ( isset( $_GET['data_permalink'] ) ) {
        $seopress_get_site_url = $_GET['data_permalink'];
        delete_transient( 'seopress_results_page_speed');
    } else {
        $seopress_get_site_url = get_home_url();
    }

    $args = array('timeout' => 30);

    if ( false === ( $seopress_results_page_speed_cache = get_transient( 'seopress_results_page_speed' ) ) ) {
       $seopress_results_page_speed = wp_remote_retrieve_body(wp_remote_get('https://www.googleapis.com/pagespeedonline/v5/runPagespeed?url='.$seopress_get_site_url.'&key='.$seopress_google_api_key.'&screenshot=true&strategy=desktop&locale='.get_locale(), $args));
       $seopress_results_page_speed_cache = $seopress_results_page_speed;
       set_transient( 'seopress_results_page_speed', $seopress_results_page_speed_cache, 365 * DAY_IN_SECONDS );
    }
    
    $data = array('url' => admin_url('admin.php?page=seopress-pro-page#tab=tab_seopress_page_speed$3'));
    wp_send_json_success($data);
}
add_action('wp_ajax_seopress_request_page_speed', 'seopress_request_page_speed');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Reset License
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_request_reset_license() {
    check_ajax_referer( 'seopress_request_reset_license_nonce', $_GET['_ajax_nonce'], true );

    if (current_user_can('manage_options') && is_admin()) {

        delete_option('seopress_pro_license_status');
        delete_option('seopress_pro_license_key');

        $data = array('url' => admin_url('admin.php?page=seopress-license'));
        wp_send_json_success($data);
    }
}
add_action('wp_ajax_seopress_request_reset_license', 'seopress_request_reset_license');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Lock Google Analytics view
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_google_analytics_lock() {
    check_ajax_referer( 'seopress_google_analytics_lock_nonce', $_POST['_ajax_nonce'], true );

    update_option('seopress_google_analytics_lock_option_name', '1', 'yes');
    
    wp_send_json_success();
}
add_action('wp_ajax_seopress_google_analytics_lock', 'seopress_google_analytics_lock');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Request Google Analytics
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_request_google_analytics() {
    check_ajax_referer( 'seopress_request_google_analytics_nonce', $_GET['_ajax_nonce'], true );

    function seopress_google_analytics_auth_option() {
        $seopress_google_analytics_auth_option = get_option("seopress_google_analytics_option_name");
        if ( ! empty ( $seopress_google_analytics_auth_option ) ) {
            foreach ($seopress_google_analytics_auth_option as $key => $seopress_google_analytics_auth_value)
                $options[$key] = $seopress_google_analytics_auth_value;
             if (isset($seopress_google_analytics_auth_option['seopress_google_analytics_auth'])) { 
                return $seopress_google_analytics_auth_option['seopress_google_analytics_auth'];
             }
        }
    }

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

    if (seopress_google_analytics_auth_option() !='' && seopress_google_analytics_auth_token_option() !='') {
    
        require_once __DIR__ . '/../functions/google-analytics/vendor/autoload.php';

        //session_start(); 

        # get saved data
        if( !$widget_options = get_option( 'seopress_ga_dashboard_widget_options' ) )
        $widget_options = array();

        # check if saved data contains content
        $seopress_ga_dashboard_widget_options_period = isset( $widget_options['period'] ) 
            ? $widget_options['period'] : false;

        $seopress_ga_dashboard_widget_options_type = isset( $widget_options['type'] ) 
            ? $widget_options['type'] : false;

        # custom content saved by control callback, modify output
        if( $seopress_ga_dashboard_widget_options_period ) {
            $period = $seopress_ga_dashboard_widget_options_period;
        } else {
            $period = '30daysAgo';
        }

        if (seopress_google_analytics_auth_client_id_option() !='') {
            $client_id = seopress_google_analytics_auth_client_id_option();
        }

        if (seopress_google_analytics_auth_secret_id_option() !='') {
            $client_secret = seopress_google_analytics_auth_secret_id_option();
        }
        
        $ga_account = 'ga:'.seopress_google_analytics_auth_option();
        $redirect_uri = admin_url('admin.php?page=seopress-google-analytics');

        $client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
        $client->setApprovalPrompt('force');   // mandatory to get this fucking refreshtoken
        $client->setAccessType('offline'); // mandatory to get this fucking refreshtoken

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
        
        $service = new Google_Service_Analytics($client);

        if ( false === ( $seopress_results_google_analytics_cache = get_transient( 'seopress_results_google_analytics' ) ) ) {
            $seopress_results_google_analytics_cache = array();
            
            ////////////////////////////////////////////////////////////////////////////////////////
            //Request Google Stats
            ////////////////////////////////////////////////////////////////////////////////////////
            //Sessions
            $ga_sessions = $service->data_ga->get($ga_account, $period,'today','ga:sessions', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
            
            //Users
            $ga_users = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
            
            //Page views
            $ga_pageviews = $service->data_ga->get($ga_account, $period,'today','ga:pageviews', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));

            //Page views per session
            $ga_pageviewsPerSession = $service->data_ga->get($ga_account, $period,'today','ga:pageviewsPerSession', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));

            //Average Session Duration
            $ga_avgSessionDuration = $service->data_ga->get($ga_account, $period,'today','ga:avgSessionDuration', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
            
            //Bounce rate
            $ga_bounceRate = $service->data_ga->get($ga_account, $period,'today','ga:bounceRate', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));

            //New sessions
            $ga_percentNewSessions = $service->data_ga->get($ga_account, $period,'today','ga:percentNewSessions', array('dimensions' => 'ga:date', 'sort' => 'ga:date'));
            
            //Language
            $ga_language = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:language', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //Country
            $ga_country = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:country', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //Desktop / mobile / tablet
            $ga_deviceCategory = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:deviceCategory', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //OS
            //$ga_operatingSystem = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:operatingSystem', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //Browser
            $ga_browser = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:browser', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //Screen Resolution
            //$ga_screenResolution = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:screenResolution', 'sort'=> '-ga:users', 'max-results' => 50));
            
            //Social Networks
            $ga_socialNetwork = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:socialNetwork','sort'=> '-ga:users', 'max-results' => 50));

            //Channels
            $ga_channelGrouping = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:channelGrouping', 'max-results' => 50));
            
            //Organic searches: keywords
            //$ga_keyword = $service->data_ga->get($ga_account, $period,'today','ga:organicSearches', array('dimensions' => 'ga:keyword', 'max-results' => 50));
            
            //Sources/support
            $ga_source = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:source','sort'=> '-ga:users', 'max-results' => 50));
            
            //Referrer
            $ga_fullReferrer = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:fullReferrer','sort'=> '-ga:users', 'max-results' => 50));
            
            //Medium
            //$ga_medium = $service->data_ga->get($ga_account, $period,'today','ga:users', array('dimensions' => 'ga:medium','sort'=> '-ga:users', 'max-results' => 50));
            
            //Content pages
            $ga_contentpageviews = $service->data_ga->get($ga_account, $period,'today','ga:pageviews', array('dimensions' => 'ga:pageTitle','sort'=> '-ga:pageviews', 'max-results' => 50));
            
            //Total Events
            $ga_totalEvents = $service->data_ga->get($ga_account, $period,'today','ga:totalEvents', array('dimensions' => 'ga:date', 'sort' => 'ga:date', 'max-results' => 50));
            
            //Total Unique Events
            $ga_uniqueEvents = $service->data_ga->get($ga_account, $period,'today','ga:uniqueEvents', array('dimensions' => 'ga:date', 'sort' => 'ga:date', 'max-results' => 50));
            
            //Event category
            $ga_eventCategory = $service->data_ga->get($ga_account, $period,'today','ga:totalEvents', array('dimensions' => 'ga:eventCategory', 'sort' => '-ga:totalEvents', 'max-results' => 50));
            
            //Event action
            $ga_eventAction = $service->data_ga->get($ga_account, $period,'today','ga:totalEvents', array('dimensions' => 'ga:eventAction', 'sort' => '-ga:totalEvents', 'max-results' => 50));
            
            //Event label
            $ga_eventLabel = $service->data_ga->get($ga_account, $period,'today','ga:totalEvents', array('dimensions' => 'ga:eventLabel', 'sort' => '-ga:totalEvents', 'max-results' => 50));

            ////////////////////////////////////////////////////////////////////////////////////////
            //Saving datas
            ////////////////////////////////////////////////////////////////////////////////////////
            $seopress_results_google_analytics_cache['sessions']                = $ga_sessions['totalsForAllResults']['ga:sessions'];
            $seopress_results_google_analytics_cache['users']                   = $ga_users['totalsForAllResults']['ga:users'];
            $seopress_results_google_analytics_cache['pageviews']               = $ga_pageviews['totalsForAllResults']['ga:pageviews'];
            $seopress_results_google_analytics_cache['pageviewsPerSession']     = round($ga_pageviewsPerSession['totalsForAllResults']['ga:pageviewsPerSession'], 2);
            $seopress_results_google_analytics_cache['avgSessionDuration']      = gmdate("i:s",$ga_avgSessionDuration['totalsForAllResults']['ga:avgSessionDuration']);
            $seopress_results_google_analytics_cache['bounceRate']              = round($ga_bounceRate['totalsForAllResults']['ga:bounceRate'], 2);
            $seopress_results_google_analytics_cache['percentNewSessions']      = round($ga_percentNewSessions['totalsForAllResults']['ga:percentNewSessions'], 2);
            $seopress_results_google_analytics_cache['language']                = $ga_language['rows'];
            $seopress_results_google_analytics_cache['country']                 = $ga_country['rows'];
            $seopress_results_google_analytics_cache['deviceCategory']          = $ga_deviceCategory['rows'];
            //$seopress_results_google_analytics_cache['operatingSystem']         = $ga_operatingSystem['rows'];
            $seopress_results_google_analytics_cache['browser']                 = $ga_browser['rows'];            
            //$seopress_results_google_analytics_cache['screenResolution']        = $ga_screenResolution['rows'];
            $seopress_results_google_analytics_cache['socialNetwork']           = $ga_socialNetwork['rows'];
            $seopress_results_google_analytics_cache['channelGrouping']         = $ga_channelGrouping['rows'];
            //$seopress_results_google_analytics_cache['keyword']                 = $ga_keyword['rows'];
            $seopress_results_google_analytics_cache['source']                  = $ga_source['rows'];
            $seopress_results_google_analytics_cache['fullReferrer']            = $ga_fullReferrer['rows'];
            //$seopress_results_google_analytics_cache['medium']                  = $ga_medium['rows'];
            $seopress_results_google_analytics_cache['contentpageviews']        = $ga_contentpageviews['rows'];
            $seopress_results_google_analytics_cache['totalEvents']             = $ga_totalEvents['totalsForAllResults']['ga:totalEvents'];
            $seopress_results_google_analytics_cache['uniqueEvents']            = $ga_uniqueEvents['totalsForAllResults']['ga:uniqueEvents'];
            $seopress_results_google_analytics_cache['eventCategory']           = $ga_eventCategory['rows'];
            $seopress_results_google_analytics_cache['eventAction']             = $ga_eventAction['rows'];
            $seopress_results_google_analytics_cache['eventLabel']              = $ga_eventLabel['rows'];
        
            switch ($seopress_ga_dashboard_widget_options_type) {
                case 'ga_sessions':
                    $ga_sessions_rows = $ga_sessions->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Sessions','wp-seopress-pro');
                    break;
                case 'ga_users':
                    $ga_sessions_rows = $ga_users->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Users','wp-seopress-pro');
                    break;
                case 'ga_pageviews':
                    $ga_sessions_rows = $ga_pageviews->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Page Views','wp-seopress-pro');
                    break;
                case 'ga_pageviewsPerSession':
                    $ga_sessions_rows = $ga_pageviewsPerSession->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Page Views Per Session','wp-seopress-pro');
                    break;
                case 'ga_avgSessionDuration':
                    $ga_sessions_rows = $ga_avgSessionDuration->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Average Session Duration','wp-seopress-pro');
                    break;
                case 'ga_bounceRate':
                    $ga_sessions_rows = $ga_bounceRate->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Bounce Rate','wp-seopress-pro');
                    break;
                case 'ga_percentNewSessions':
                    $ga_sessions_rows = $ga_percentNewSessions->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('New Sessions','wp-seopress-pro');
                    break;
                default:
                    $ga_sessions_rows = $ga_sessions->getRows();
                    $seopress_ga_dashboard_widget_options_title = __('Sessions','wp-seopress-pro');
            }

            function seopress_ga_dashboard_get_sessions_labels($ga_sessions_rows){
                $labels = array();
                foreach ($ga_sessions_rows as $key => $value) {
                    foreach ($value as $_key => $_value) {
                        if ($_key == 0) {
                            array_push($labels, date_i18n( get_option( 'date_format' ), strtotime( $_value )));
                        }
                    }
                }
                return $labels;
            }

            function seopress_ga_dashboard_get_sessions_data($ga_sessions_rows){
                $data = array();
                foreach ($ga_sessions_rows as $key => $value) {
                    foreach (array_slice($value, 1) as $_key => $_value) {
                        array_push($data, $_value);
                    }
                }
                return $data;
            }

            $seopress_results_google_analytics_cache['sessions_graph_labels']       = seopress_ga_dashboard_get_sessions_labels($ga_sessions_rows);
            $seopress_results_google_analytics_cache['sessions_graph_data']         = seopress_ga_dashboard_get_sessions_data($ga_sessions_rows);
            $seopress_results_google_analytics_cache['sessions_graph_title']        = $seopress_ga_dashboard_widget_options_title;

            //Transient
            set_transient( 'seopress_results_google_analytics', $seopress_results_google_analytics_cache, 1 * HOUR_IN_SECONDS );
        }

        //Return
        $seopress_results_google_analytics_transient = get_transient('seopress_results_google_analytics');

        wp_send_json_success( $seopress_results_google_analytics_transient );
    }

    die();
}
add_action('wp_ajax_seopress_request_google_analytics', 'seopress_request_google_analytics');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Clear Google Page Speed cache
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_clear_page_speed_cache() {
    check_ajax_referer( 'seopress_clear_page_speed_cache_nonce', $_GET['_ajax_nonce'], true );

    global $wpdb;
    
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_seopress_results_page_speed' ");
    $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_timeout_seopress_results_page_speed' ");
    
    die();
}
add_action('wp_ajax_seopress_clear_page_speed_cache', 'seopress_clear_page_speed_cache');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Save htaccess file
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_save_htaccess() {
    check_ajax_referer( 'seopress_save_htaccess_nonce', $_POST['_ajax_nonce'], true );

    if (current_user_can('manage_options') && is_admin()) { 
        $filename = get_home_path().'/.htaccess';

        if ( isset( $_POST['htaccess_content'])) {
            $current_htaccess = stripslashes($_POST['htaccess_content']);
        }

        if (is_writable($filename)) {

            if (!$handle = fopen($filename, 'w')) {
                 _e('Impossible to open file: ','wp-seopress-pro').$filename;
                 exit;
            }

            if (fwrite($handle, $current_htaccess) === FALSE) {
                _e('Impossible to write in file: ','wp-seopress-pro').$filename;
                exit;
            }

            _e('htaccess successfully updated!','wp-seopress-pro');

            fclose($handle);

        } else {
            _e('Your htaccess is not writable.','wp-seopress-pro');
        }
    }
}
add_action('wp_ajax_seopress_save_htaccess', 'seopress_save_htaccess');

///////////////////////////////////////////////////////////////////////////////////////////////////
//Get backlinks from Majestic API
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_backlinks() {
    check_ajax_referer( 'seopress_backlinks_nonce', $_GET['_ajax_nonce'], true );

    function seopress_backlinks_majestic_key_option() {
        $seopress_backlinks_majestic_key_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_backlinks_majestic_key_option ) ) {
            foreach ($seopress_backlinks_majestic_key_option as $key => $seopress_backlinks_majestic_key_value)
                $options[$key] = $seopress_backlinks_majestic_key_value;
                if (isset($seopress_backlinks_majestic_key_option['seopress_backlinks_majestic_key'])) {
                    return $seopress_backlinks_majestic_key_option['seopress_backlinks_majestic_key'];
                }
        }
    }
    
    if (seopress_backlinks_majestic_key_option() !='') {
        delete_transient( 'seopress_results_majestic');
        
        if ( false === ( $seopress_results_majestic_cache = get_transient( 'seopress_results_majestic' ) ) ) {
            if (is_ssl()) {
                $ssl = 'https://';
            } else {
                $ssl = 'http://';
            }

            $response = wp_remote_get($ssl.'api.majestic.com/api/json?app_api_key='.seopress_backlinks_majestic_key_option().'&cmd=GetBackLinkData&item='.get_home_url().'&Count=100&datasource=fresh');
            

            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

                $response_body = __( 'An error occurred, please try again.', 'wp-seopress-pro' );
                
            } else {
                $response_body = wp_remote_retrieve_body($response);
            }

            $seopress_results_majestic_cache = json_decode($response_body);
            set_transient( 'seopress_results_majestic', $seopress_results_majestic_cache, 1 * DAY_IN_SECONDS );

            $backlinks = $seopress_results_majestic_cache->DataTables->BackLinks->Data;

            foreach ($backlinks as $backlink) {
                if(!get_page_by_title( $backlink->SourceURL, '',  'seopress_backlinks')) {
                    wp_insert_post(array(
                        'post_title' => $backlink->SourceURL, 
                        'post_type' => 'seopress_backlinks', 
                        'post_status' => 'publish',
                        'meta_input'   => array(
                            'seopress_backlinks_target_url' => $backlink->TargetURL,
                            'seopress_backlinks_anchor_text' => $backlink->AnchorText,
                            'seopress_backlinks_source_citation_flow' => $backlink->SourceCitationFlow,
                            'seopress_backlinks_source_trust_flow' => $backlink->SourceTrustFlow,
                            'seopress_backlinks_target_citation_flow' => $backlink->TargetCitationFlow,
                            'seopress_backlinks_target_trust_flow' => $backlink->TargetTrustFlow,
                            'seopress_backlinks_found_date' => $backlink->FirstIndexedDate,
                            'seopress_backlinks_last_update' => $backlink->LastSeenDate,
                        ),
                    ));
                }
            }
        }
    }
    
    die();
}
add_action('wp_ajax_seopress_backlinks', 'seopress_backlinks');

