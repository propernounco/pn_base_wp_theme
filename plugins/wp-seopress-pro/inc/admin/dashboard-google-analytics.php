<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

//Google Analytics Dashboard widget
//=================================================================================================
if (seopress_get_toggle_google_analytics_option() =='1') {

    $seopress_ga_dashboard_widget_cap = 'edit_dashboard';
    
    $seopress_ga_dashboard_widget_cap = apply_filters( 'seopress_ga_dashboard_widget_cap', $seopress_ga_dashboard_widget_cap ); 

    if(current_user_can($seopress_ga_dashboard_widget_cap)) {

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

        add_action( 'wp_dashboard_setup', 'seopress_ga_dashboard_widget' );

        function seopress_ga_dashboard_widget() {
            $return_false ='';
            $return_false = apply_filters( 'seopress_ga_dashboard_widget', $return_false ); 
                             
            if (has_filter('seopress_ga_dashboard_widget') && $return_false == false) {
                //do nothing 
            } else {
                wp_add_dashboard_widget('seopress_ga_dashboard_widget', 'Google Analytics', 'seopress_ga_dashboard_widget_display', 'seopress_ga_dashboard_widget_handle');
            }
        }

        function seopress_ga_dashboard_widget_display() {            
            if (seopress_google_analytics_auth_option() !='' && seopress_google_analytics_auth_token_option() !='') {
        
                echo '<span class="spinner"></span>';
                
                //If GA values
                //if ( get_transient( 'seopress_results_google_analytics' ) !="") {
                            
                    $seopress_results_google_analytics_cache = get_transient( 'seopress_results_google_analytics' );
                    
                    function seopress_ga_table_html($ga_dimensions, $seopress_results_google_analytics_cache, $i18n) {
                        if (isset($seopress_results_google_analytics_cache[$ga_dimensions]) && !empty($seopress_results_google_analytics_cache[$ga_dimensions])) {
                            echo '<div class="wrap-single-stat table-row">';                    
                                echo '<span class="label-stat">'.__($i18n,'wp-seopress-pro').'</span>';
                                echo '<ul id="seopress-ga-'.$ga_dimensions.'" class="value-stat wrap-row-stat">';
                                    $i = 0;
                                    foreach($seopress_results_google_analytics_cache[$ga_dimensions] as $value) {
                                        echo '<li>'.$value[0].' <span>'.$value[1].'</span></li>';
                                        if (++$i == 10) break;
                                    }
                                echo '</ul>';
                            echo '</div>';
                        }
                    }
                    
                    //Line Chart
                    echo '<div class="wrap-chart-stat">';
                        echo '<canvas id="seopress_ga_dashboard_widget_sessions" width="400" height="250"></canvas>';
                        echo '<script>var ctx = document.getElementById("seopress_ga_dashboard_widget_sessions");</script>';
                    echo '</div>';
                    
                    //Tabs
                    echo '<div id="seopress-tabs2">
                            <ul>
                                <li class="nav-tab nav-tab-active"><a href="#sp-tabs-1">'.__('Main','wp-seopress-pro').'</a></li>
                                <li class="nav-tab nav-tab-active"><a href="#sp-tabs-2">'.__('Audience','wp-seopress-pro').'</a></li>
                                <li class="nav-tab"><a href="#sp-tabs-3">'.__('Acquisition','wp-seopress-pro').'</a></li>
                                <li class="nav-tab"><a href="#sp-tabs-4">'.__('Behavior','wp-seopress-pro').'</a></li>
                                <li class="nav-tab"><a href="#sp-tabs-5">'.__('Events','wp-seopress-pro').'</a></li>
                            </ul>';
                        
                        //Tab1
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        echo '<div id="sp-tabs-1" class="seopress-tab active">';
            
                            //Sessions
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-visibility"></span>'.__('Sessions','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-sessions" class="value-stat"></span>';
                            echo '</div>';
                        
                            //Users
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-admin-users"></span>'.__('Users','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-users" class="value-stat"></span>';
                            echo '</div>';
                
                            //Page
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-admin-page"></span>'.__('Page Views','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-pageviews" class="value-stat"></span>';
                            echo '</div>';
                            
                            //Page View / Session
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-admin-page"></span>'.__('Page view / session','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-pageviewsPerSession" class="value-stat"></span>';
                            echo '</div>';
                            
                            //Average session duration
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-clock"></span>'.__('Average session duration','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-avgSessionDuration" class="value-stat"></span>';
                            echo '</div>';
                
                            //Bounce rate
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-migrate"></span>'.__('Bounce rate','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-bounceRate" class="value-stat"></span>';
                            echo '</div>';
                
                            //New sessions
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-chart-bar"></span>'.__('New sessions','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-percentNewSessions" class="value-stat"></span>';
                            echo '</div>';
                        echo '</div>';
                        
                        //Tab2
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        echo '<div id="sp-tabs-2" class="seopress-tab active">';
                            //Device category
                            seopress_ga_table_html('deviceCategory', $seopress_results_google_analytics_cache, __('Device category','wp-seopress-pro'));
                            
                            //Language
                            seopress_ga_table_html('language', $seopress_results_google_analytics_cache, __('Language','wp-seopress-pro'));
                            
                            //Country
                            seopress_ga_table_html('country', $seopress_results_google_analytics_cache, __('Country','wp-seopress-pro'));
                            
                            //Operating System
                            seopress_ga_table_html('operatingSystem', $seopress_results_google_analytics_cache, __('Operating System','wp-seopress-pro'));
                            
                            //Browser
                            seopress_ga_table_html('browser', $seopress_results_google_analytics_cache, __('Browser','wp-seopress-pro'));
                            
                            //Screen resolution
                            seopress_ga_table_html('screenResolution', $seopress_results_google_analytics_cache, __('Screen resolution','wp-seopress-pro'));
                        echo '</div>';

                        //Tab3
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        echo '<div id="sp-tabs-3" class="seopress-tab">';
                        //Social networks
                        seopress_ga_table_html('socialNetwork', $seopress_results_google_analytics_cache, __('Social Networks','wp-seopress-pro'));

                        //Channel grouping
                        seopress_ga_table_html('channelGrouping', $seopress_results_google_analytics_cache, __('Channels','wp-seopress-pro'));

                        //Keyword
                        seopress_ga_table_html('keyword', $seopress_results_google_analytics_cache, __('Keywords','wp-seopress-pro'));

                        //Source
                        seopress_ga_table_html('source', $seopress_results_google_analytics_cache, __('Source','wp-seopress-pro'));

                        //Referrals
                        seopress_ga_table_html('fullReferrer', $seopress_results_google_analytics_cache, __('Referrals','wp-seopress-pro'));

                        //Medium
                        seopress_ga_table_html('medium', $seopress_results_google_analytics_cache, __('Medium','wp-seopress-pro'));
                        
                        echo '</div>';
                        
                        //Tab4
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        echo '<div id="sp-tabs-4" class="seopress-tab">';
                        
                            //Content pages
                            seopress_ga_table_html('contentpageviews', $seopress_results_google_analytics_cache, __('Page views','wp-seopress-pro'));
                                                    
                        echo '</div>';

                        //Tab 5
                        /////////////////////////////////////////////////////////////////////////////////////////////////
                        echo '<div id="sp-tabs-5" class="seopress-tab">';

                            //Events
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-chart-bar"></span>'.__('Total events','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-totalEvents" class="value-stat">'.$seopress_results_google_analytics_cache['totalEvents'].'</span>';
                            echo '</div>';
                            
                            //Total unique events
                            echo '<div class="wrap-single-stat col-6">';
                                echo '<span class="label-stat"><span class="dashicons dashicons-chart-bar"></span>'.__('Total unique events','wp-seopress-pro').'</span>';
                                echo '<span id="seopress-ga-uniqueEvents" class="value-stat">'.$seopress_results_google_analytics_cache['uniqueEvents'].'</span>';
                            echo '</div>';
                            
                            //Event category
                            seopress_ga_table_html('eventCategory', $seopress_results_google_analytics_cache, __('Event category','wp-seopress-pro'));
                            
                            //Event action
                            seopress_ga_table_html('eventAction', $seopress_results_google_analytics_cache, __('Event action','wp-seopress-pro'));
                            
                            //Event label
                            seopress_ga_table_html('eventLabel', $seopress_results_google_analytics_cache, __('Event label','wp-seopress-pro'));
                        echo '</div>';

                    echo '</div>';
                //}
                
            } else {
                echo '<p>'.__('You need to login to Google Analytics','wp-seopress-pro').'</p>';
                echo '<p><a class="button" href="'.admin_url( 'admin.php?page=seopress-google-analytics#tab=tab_seopress_google_analytics_dashboard').'">'.__('Authenticate','wp-seopress-pro').'</a></p>';
            }
        }
        function seopress_ga_dashboard_widget_handle() {
            # get saved data
            if( !$widget_options = get_option('seopress_ga_dashboard_widget_options'))
                $widget_options = array();

            # process update
            if( 'POST' == $_SERVER['REQUEST_METHOD'] && isset( $_POST['seopress_ga_dashboard_widget_options'] ) ) {
                $widget_options['period'] = $_POST['seopress_ga_dashboard_widget_options']['period'];
                $widget_options['type'] = $_POST['seopress_ga_dashboard_widget_options']['type'];
                # save update
                update_option( 'seopress_ga_dashboard_widget_options', $widget_options );
                delete_transient('seopress_results_google_analytics');
            }

            # set defaults  
            if( !isset( $widget_options['period'] ) )
                $widget_options['period'] = '30daysAgo';

                echo "<p><strong>".__('Period','wp-seopress-pro')."</strong></p>";

                echo '<p><select id="period" name="seopress_ga_dashboard_widget_options[period]">';
                echo ' <option '; 
                    if ('today' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="today">'. __("Today","wp-seopress-pro") .'</option>';
                echo ' <option '; 
                    if ('yesterday' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="yesterday">'. __("Yesterday","wp-seopress-pro") .'</option>';
                echo ' <option '; 
                    if ('7daysAgo' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="7daysAgo">'. __("7 days ago","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('30daysAgo' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="30daysAgo">'. __("30 days ago","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('90daysAgo' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="90daysAgo">'. __("90 days ago","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('180daysAgo' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="180daysAgo">'. __("180 days ago","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('360daysAgo' == $widget_options['period']) echo 'selected="selected"'; 
                    echo ' value="360daysAgo">'. __("360 days ago","wp-seopress-pro") .'</option>';
                echo '</select></p>';

            if( !isset( $widget_options['type'] ) )
                $widget_options['type'] = 'ga_sessions';

                echo "<p><strong>".__('Stats','wp-seopress-pro')."</strong></p>";

                echo '<p><select id="type" name="seopress_ga_dashboard_widget_options[type]">';
                echo ' <option '; 
                    if ('ga_sessions' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_sessions">'. __("Sessions","wp-seopress-pro") .'</option>';
                echo ' <option '; 
                    if ('ga_users' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_users">'. __("Users","wp-seopress-pro") .'</option>';
                echo ' <option '; 
                    if ('ga_pageviews' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_pageviews">'. __("Page views","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('ga_pageviewsPerSession' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_pageviewsPerSession">'. __("Page views per session","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('ga_avgSessionDuration' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_avgSessionDuration">'. __("Average session duration","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('ga_bounceRate' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_bounceRate">'. __("Bounce rate","wp-seopress-pro") .'</option>';
                echo '<option ';
                    if ('ga_percentNewSessions' == $widget_options['type']) echo 'selected="selected"'; 
                    echo ' value="ga_percentNewSessions">'. __("New Sessions","wp-seopress-pro") .'</option>';
                echo '</select></p>';

        }
    }
}