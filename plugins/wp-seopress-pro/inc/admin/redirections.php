<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );
if (seopress_get_toggle_404_option() =='1') {

    if ( is_admin() ) {
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Register SEOPress 404 / 301 Custom Post Type
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function seopress_404_fn() {

            $labels = array(
                'name'                  => _x( '404 / 301', 'Post Type General Name', 'wp-seopress-pro' ),
                'singular_name'         => _x( '404 / 301', 'Post Type Singular Name', 'wp-seopress-pro' ),
                'menu_name'             => __( '404 / 301', 'wp-seopress-pro' ),
                'name_admin_bar'        => __( '404 / 301', 'wp-seopress-pro' ),
                'archives'              => __( 'Item Archives', 'wp-seopress-pro' ),
                'parent_item_colon'     => __( 'Parent Item:', 'wp-seopress-pro' ),
                'all_items'             => __( 'All 404 / 301', 'wp-seopress-pro' ),
                'add_new_item'          => __( 'Add New redirection', 'wp-seopress-pro' ),
                'add_new'               => __( 'Add redirection', 'wp-seopress-pro' ),
                'new_item'              => __( 'New redirection', 'wp-seopress-pro' ),
                'edit_item'             => __( 'Edit redirection', 'wp-seopress-pro' ),
                'update_item'           => __( 'Update redirection', 'wp-seopress-pro' ),
                'view_item'             => __( 'View redirection', 'wp-seopress-pro' ),
                'search_items'          => __( 'Search redirection', 'wp-seopress-pro' ),
                'not_found'             => __( 'Not found', 'wp-seopress-pro' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'wp-seopress-pro' ),
                'featured_image'        => __( 'Featured Image', 'wp-seopress-pro' ),
                'set_featured_image'    => __( 'Set featured image', 'wp-seopress-pro' ),
                'remove_featured_image' => __( 'Remove featured image', 'wp-seopress-pro' ),
                'use_featured_image'    => __( 'Use as featured image', 'wp-seopress-pro' ),
                'insert_into_item'      => __( 'Insert into item', 'wp-seopress-pro' ),
                'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-seopress-pro' ),
                'items_list'            => __( 'Redirections list', 'wp-seopress-pro' ),
                'items_list_navigation' => __( 'Redirections list navigation', 'wp-seopress-pro' ),
                'filter_items_list'     => __( 'Filter redirections list', 'wp-seopress-pro' ),
            );
            $args = array(
                'label'                 => __( '404', 'wp-seopress-pro' ),
                'description'           => __( 'Monitoring 404', 'wp-seopress-pro' ),
                'labels'                => $labels,
                'supports'              => array( 'title' ),
                'hierarchical'          => false,
                'public'                => false,
                'show_ui'               => true,
                'show_in_menu'          => false,
                'menu_icon'             => 'dashicons-admin-links',
                'show_in_admin_bar'     => false,
                'show_in_nav_menus'     => false,
                'can_export'            => true,
                'has_archive'           => false,       
                'exclude_from_search'   => true,
                'publicly_queryable'    => false,
                'capability_type'       => 'post',
            );
            register_post_type( 'seopress_404', $args );

        }
        add_action( 'init', 'seopress_404_fn', 10 );

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Register SEOPress Custom Taxonomy Categories for Redirections
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function seopress_404_cat_fn() {

            $labels = array(
                'name'                       => _x( 'Categories', 'Taxonomy General Name', 'wp-seopress-pro' ),
                'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'wp-seopress-pro' ),
                'menu_name'                  => __( 'Categories', 'wp-seopress-pro' ),
                'all_items'                  => __( 'All Categories', 'wp-seopress-pro' ),
                'parent_item'                => __( 'Parent Category', 'wp-seopress-pro' ),
                'parent_item_colon'          => __( 'Parent Category:', 'wp-seopress-pro' ),
                'new_item_name'              => __( 'New Category Name', 'wp-seopress-pro' ),
                'add_new_item'               => __( 'Add New Category', 'wp-seopress-pro' ),
                'edit_item'                  => __( 'Edit Category', 'wp-seopress-pro' ),
                'update_item'                => __( 'Update Category', 'wp-seopress-pro' ),
                'view_item'                  => __( 'View Category', 'wp-seopress-pro' ),
                'separate_items_with_commas' => __( 'Separate categories with commas', 'wp-seopress-pro' ),
                'add_or_remove_items'        => __( 'Add or remove categories', 'wp-seopress-pro' ),
                'choose_from_most_used'      => __( 'Choose from the most used', 'wp-seopress-pro' ),
                'popular_items'              => __( 'Popular Categories', 'wp-seopress-pro' ),
                'search_items'               => __( 'Search Categories', 'wp-seopress-pro' ),
                'not_found'                  => __( 'Not Found', 'wp-seopress-pro' ),
                'no_terms'                   => __( 'No items', 'wp-seopress-pro' ),
                'items_list'                 => __( 'Categories list', 'wp-seopress-pro' ),
                'items_list_navigation'      => __( 'Categories list navigation', 'wp-seopress-pro' ),
            );
            $args = array(
                'labels'                     => $labels,
                'hierarchical'               => true,
                'public'                     => false,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => false,
                'show_tagcloud'              => false,
                'rewrite'                    => false,
                'show_in_rest'               => false,
            );
            register_taxonomy( 'seopress_404_cat', array( 'seopress_404' ), $args );
        }
        add_action( 'init', 'seopress_404_cat_fn', 10 );

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Add custom buttons to SEOPress Redirections Custom Post Type
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        function seopress_404_btn_cpt() {
            $screen = get_current_screen();
            if  ( 'seopress_404' == $screen->post_type ) {
                ?>
                <script>
                jQuery(function(){
                    jQuery("body.post-type-seopress_404 .wrap h1 ~ a").after('<a href="<?php echo admin_url( 'edit-tags.php?taxonomy=seopress_404_cat&post_type=seopress_404' ); ?>" id="seopress-cat-redirects" style="margin: 10px 0 0 10px;" class="page-title-action"><?php _e('Manage categories redirects','wp-seopress-pro'); ?></a>');
                });
                jQuery(function(){
                    jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-cat-redirects").after('<a href="<?php echo admin_url( 'admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects' ); ?>" id="seopress-import-redirects" style="margin: 10px 0 0 10px;" class="button"><?php _e('Import your redirects','wp-seopress-pro'); ?></a>');
                });
                jQuery(function(){
                    jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-import-redirects").after('<a href="<?php echo admin_url( 'admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects' ); ?>" id="seopress-export-redirections" style="margin: 10px 0 0 10px;" class="button"><?php _e('Export your redirects','wp-seopress-pro'); ?></a>');
                });
                jQuery(function(){
                    jQuery("body.post-type-seopress_404 .wrap h1 ~ #seopress-export-redirections").after('<a href="<?php echo admin_url( 'admin.php?page=seopress-import-export#tab=tab_seopress_tool_redirects' ); ?>" id="seopress-clean-404" style="margin: 10px 0 0 10px;" class="button"><?php _e('Clean your 404','wp-seopress-pro'); ?></a>');
                });
                </script>
            <?php
            }
        }
        add_action('admin_head', 'seopress_404_btn_cpt');

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Row actions links
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        function seopress_404_row_actions($actions, $post) {
            if(get_post_type() === 'seopress_404'){
                if (get_post_meta(get_the_ID(), "_seopress_redirections_value", true) !='' && get_post_meta(get_the_ID(), "_seopress_redirections_enabled", true) =='yes') {
                    $actions['seopress_404_test'] = "<a href='".get_home_url()."/".get_the_title()."' target='_blank'>" . __( 'Test redirection', 'wp-seopress-pro' ) . "</a>";
                }
            }
            return $actions;
        }
        add_filter('post_row_actions', 'seopress_404_row_actions', 10, 2);

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Filters view
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        function seopress_404_filters_cpt() {
            global $typenow;
            
            if( $typenow == 'seopress_404' ) {

                $args = array(
                    'show_option_all'    => __('All categories','wp-seopress-pro'),
                    'show_option_none'   => '',
                    'option_none_value'  => '-1',
                    'orderby'            => 'ID',
                    'order'              => 'ASC',
                    'show_count'         => 1,
                    'hide_empty'         => 0,
                    'child_of'           => 0,
                    'exclude'            => '',
                    'include'            => '',
                    'echo'               => 1,
                    'selected'           => 0,
                    'hierarchical'       => 0,
                    'name'               => 'redirect-cat',
                    'id'                 => '',
                    'class'              => 'postform',
                    'depth'              => 0,
                    'tab_index'          => 0,
                    'taxonomy'           => 'seopress_404_cat',
                    'hide_if_empty'      => false,
                    'value_field'        => 'slug',
                );
                wp_dropdown_categories($args);

                $redirections_type = array('301', '302', '307', '404', '410', '451');
                $redirections_enabled = array('yes' => 'Enabled','no' => 'Disabled');

                echo "<select name='redirection-type' id='redirection-type' class='postform'>";
                echo "<option value=''>".__('Show All','wp-seopress-pro')."</option>";
                foreach ($redirections_type as $type) {
                    echo '<option value='. $type, isset($_GET[$type]) == $type ? ' selected="selected"' : '','>' .$type.'</option>'; 
                }
                echo "</select>";

                echo "<select name='redirection-enabled' id='redirection-enabled' class='postform'>";
                echo "<option value=''>".__('All status','wp-seopress-pro')."</option>";
                foreach ($redirections_enabled as $enabled => $value) {
                    echo '<option value='. $enabled, isset($_GET[$enabled]) == $enabled ? ' selected="selected"' : '','>' .$value.'</option>'; 
                }
                echo "</select>";
            }
        }
        add_action( 'restrict_manage_posts', 'seopress_404_filters_cpt' );

        function seopress_404_filters_action($query) {
            global $pagenow;
            $current_page = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';

            if ( is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && (isset( $_GET['redirect-cat'] ) && 
                ($_GET['redirect-cat'] !='0') )) {
                $redirection_cat = $_GET['redirect-cat'];
                $query->query_vars['tax_query'] = array(
                    array(
                        'taxonomy' => 'seopress_404_cat',
                        'field'    => 'slug',
                        'terms'    => $redirection_cat,
                    ),
                );
            }

            if ( is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && (isset( $_GET['redirect-cat'] ) && 
                $_GET['redirect-cat'] !='' && isset( $_GET['redirection-type'] ) && 
                $_GET['redirection-type'] !='' && isset( $_GET['redirection-enabled'] ) && $_GET['redirection-enabled'] !='')) {
                
                
                $redirection_type = $_GET['redirection-type'];
                $redirection_enabled = $_GET['redirection-enabled'];

                $query->query_vars['meta_relation'] = 'AND';
                if ($_GET['redirection-enabled'] =='no') {
                    $compare = 'NOT EXISTS';
                } else {
                    $compare = '=';
                }
                $query->query_vars['meta_query'] = array(
                    'relation' => 'AND',
                    array(
                        'key'     => '_seopress_redirections_type',
                        'value'   => $redirection_type,
                        'compare' => '=',
                    ),
                    array(
                        'key'     => '_seopress_redirections_enabled',
                        'value'   => $redirection_enabled,
                        'compare' => $compare,
                    )
                );
            }

            if ( is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && isset( $_GET['redirection-type'] ) && 
                $_GET['redirection-type'] != '') {
                $redirection_type = $_GET['redirection-type'];
                $query->query_vars['meta_key'] = '_seopress_redirections_type';
                $query->query_vars['meta_value'] = $redirection_type;
                $query->query_vars['meta_compare'] = '=';
                if ($redirection_type =='404') {
                    $query->query_vars['meta_compare'] = 'NOT EXISTS';
                }
            }
            if ( is_admin() && 'seopress_404' == $current_page && 'edit.php' == $pagenow && isset( $_GET['redirection-enabled'] ) && 
                $_GET['redirection-enabled'] != '') {
                $redirection_enabled = $_GET['redirection-enabled'];
                $query->query_vars['meta_key'] = '_seopress_redirections_enabled';
                $query->query_vars['meta_value'] = $redirection_enabled;
                if ($redirection_enabled =='no') {
                    $query->query_vars['meta_compare'] = 'NOT EXISTS';
                } else {
                    $query->query_vars['meta_compare'] = '=';
                }
            }
        }
        add_filter( 'parse_query', 'seopress_404_filters_action' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Bulk actions
        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //enable 301
        add_filter( 'bulk_actions-edit-seopress_404', 'seopress_bulk_actions_enable' );

        function seopress_bulk_actions_enable($bulk_actions) {
            $bulk_actions['seopress_enable'] = __( 'Enable redirection', 'wp-seopress-pro');
            return $bulk_actions;
        }
        
        add_filter( 'handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_enable_handler', 10, 3 );

        function seopress_bulk_action_enable_handler( $redirect_to, $doaction, $post_ids ) {
            if ( $doaction !== 'seopress_enable' ) {
                return $redirect_to;
            }
            foreach ( $post_ids as $post_id ) {
                // Perform action for each post.
                update_post_meta( $post_id, '_seopress_redirections_enabled', 'yes' );
            }
            $redirect_to = add_query_arg( 'bulk_enable_posts', count( $post_ids ), $redirect_to );
            return $redirect_to;
        }

        add_action( 'admin_notices', 'seopress_bulk_action_enable_admin_notice' );

        function seopress_bulk_action_enable_admin_notice() {
            if ( ! empty( $_REQUEST['bulk_enable_posts'] ) ) {
                $enable_count = intval( $_REQUEST['bulk_enable_posts'] );
                printf( '<div id="message" class="updated fade"><p>' .
                        _n( '%s redirections enabled.',
                                '%s redirections enabled.',
                                $enable_count,
                                'wp-seopress-pro'
                                ) . '</p></div>', $enable_count );
            }
        }

        //disable 301
        add_filter( 'bulk_actions-edit-seopress_404', 'seopress_bulk_actions_disable' );

        function seopress_bulk_actions_disable($bulk_actions) {
            $bulk_actions['seopress_disable'] = __( 'Disable redirection', 'wp-seopress-pro');
            return $bulk_actions;
        }
        
        add_filter( 'handle_bulk_actions-edit-seopress_404', 'seopress_bulk_action_disable_handler', 10, 3 );

        function seopress_bulk_action_disable_handler( $redirect_to, $doaction, $post_ids ) {
            if ( $doaction !== 'seopress_disable' ) {
                return $redirect_to;
            }
            foreach ( $post_ids as $post_id ) {
                // Perform action for each post.
                update_post_meta( $post_id, '_seopress_redirections_enabled', '' );
            }
            $redirect_to = add_query_arg( 'bulk_enable_posts', count( $post_ids ), $redirect_to );
            return $redirect_to;
        }

        add_action( 'admin_notices', 'seopress_bulk_action_disable_admin_notice' );

        function seopress_bulk_action_disable_admin_notice() {
            if ( ! empty( $_REQUEST['bulk_disable_posts'] ) ) {
                $enable_count = intval( $_REQUEST['bulk_disable_posts'] );
                printf( '<div id="message" class="updated fade"><p>' .
                        _n( '%s redirections disabled.',
                                '%s redirections disabled.',
                                $enable_count,
                                'wp-seopress-pro'
                                ) . '</p></div>', $enable_count );
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Set title placeholder for 404 / 301 Custom Post Type
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        function seopress_404_cpt_title( $title ){
            if (function_exists('get_current_screen')) {
                 $screen = get_current_screen();
                 if  ( 'seopress_404' == $screen->post_type ) {
                      $title = __('Enter the old URL here without domain name', 'wp-seopress-pro');
                 }
                 return $title;
            }
        }
         
        add_filter( 'enter_title_here', 'seopress_404_cpt_title' );

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Display help after title
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        add_action( 'edit_form_after_title', 'seopress_301_after_title' );
        function seopress_301_after_title() {
            global $typenow;
            if (isset($typenow) && "seopress_404" == $typenow) {
                echo '<p>'.__('Enter your <strong>relative</strong> URL above. Do not use anchors, they are not sent by your browser.','wp-seopress-pro').'</p>';
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Set messages for 404 / 301 Custom Post Type
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        function seopress_404_set_messages($messages) {
            global $post, $post_ID, $typenow;
            $post_type = 'seopress_404';
            $seopress_404_test = '';
            
            if( $typenow === 'seopress_404' ) {
                $obj = get_post_type_object($post_type);
                $singular = $obj->labels->singular_name;

                if (get_post_meta(get_the_ID(), "_seopress_redirections_value", true) !='' && get_post_meta(get_the_ID(), "_seopress_redirections_enabled", true) =='yes') {
                    $seopress_404_test = "<a href='".get_home_url()."/".get_the_title()."' target='_blank'>" . __( 'Test redirection', 'wp-seopress-pro' ) . "</a><span class='dashicons dashicons-external'></span>";
                }

                $messages[$post_type] = array(
                    0 => '', // Unused. Messages start at index 1.
                    1 => sprintf(__($singular.' updated. %s'), $seopress_404_test),
                    2 => __('Custom field updated.'),
                    3 => __('Custom field deleted.'),
                    4 => sprintf(__($singular.' updated. %s'), $seopress_404_test),
                    5 => isset($_GET['revision']) ? sprintf( __($singular.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
                    6 => sprintf( __($singular.' published. %s'), $seopress_404_test ),
                    7 => __('Redirection saved.'),
                    8 => sprintf( __($singular.' submitted.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
                    9 => sprintf( __($singular.' scheduled for: <strong>%1$s</strong>. '), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
                    10 => sprintf( __($singular.' draft updated.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
                );
                return $messages;
            } else {
                return $messages;
            }
        }

        add_filter('post_updated_messages', 'seopress_404_set_messages' );

        function seopress_404_set_messages_list( $bulk_messages, $bulk_counts ) {

            $bulk_messages['seopress_404'] = array(
                'updated'   => _n( '%s redirection updated.', '%s redirections updated.', $bulk_counts['updated'] ),
                'locked'    => _n( '%s redirection not updated, somebody is editing it.', '%s redirections not updated, somebody is editing them.', $bulk_counts['locked'] ),
                'deleted'   => _n( '%s redirection permanently deleted.', '%s redirections permanently deleted.', $bulk_counts['deleted'] ),
                'trashed'   => _n( '%s redirection moved to the Trash.', '%s redirections moved to the Trash.', $bulk_counts['trashed'] ),
                'untrashed' => _n( '%s redirection restored from the Trash.', '%s redirections restored from the Trash.', $bulk_counts['untrashed'] ),
            );

            return $bulk_messages;

        }
        add_filter( 'bulk_post_updated_messages', 'seopress_404_set_messages_list', 10, 2 );

        ///////////////////////////////////////////////////////////////////////////////////////////////////
        //Columns for SEOPress 404 / 301 Custom Post Type
        ///////////////////////////////////////////////////////////////////////////////////////////////////

        add_filter('manage_edit-seopress_404_columns', 'seopress_404_count_columns');
        add_action('manage_seopress_404_posts_custom_column', 'seopress_404_count_display_column', 10, 2);

        function seopress_404_count_columns($columns) {
            $columns['seopress_404'] = __('Count', 'wp-seopress-pro');
            $columns['seopress_404_redirect_enable'] = __('Enable?', 'wp-seopress-pro');
            $columns['seopress_404_redirect_type'] = __('Type', 'wp-seopress-pro');
            $columns['seopress_404_redirect_value'] = __('URL redirect', 'wp-seopress-pro');
            $columns['seopress_404_redirect_ua'] = __('User agent', 'wp-seopress-pro');
            return $columns;
        }

        function seopress_404_count_display_column($column, $post_id) {
            if ($column == 'seopress_404') {
                echo get_post_meta($post_id, "seopress_404_count", true);
            }
            if ($column == 'seopress_404_redirect_enable') {
                if (get_post_meta($post_id, "_seopress_redirections_enabled", true) =='yes') {
                    echo '<span class="dashicons dashicons-yes"></span>';
                }
            }
            if ($column == 'seopress_404_redirect_type') {
                $seopress_redirections_type = get_post_meta($post_id, "_seopress_redirections_type", true);
                switch ($seopress_redirections_type) {
                case '307':
                    echo '<span class="seopress_redirection_307 seopress_redirection_status">'.$seopress_redirections_type.'</span>';
                    break;

                case '302':
                    echo '<span class="seopress_redirection_302 seopress_redirection_status">'.$seopress_redirections_type.'</span>';
                    break;

                case '301':
                    echo '<span class="seopress_redirection_301 seopress_redirection_status">'.$seopress_redirections_type.'</span>';
                    break;

                case '410':
                    echo '<span class="seopress_redirection_410 seopress_redirection_status">'.$seopress_redirections_type.'</span>';
                    break;

                case '451':
                    echo '<span class="seopress_redirection_451 seopress_redirection_status">'.$seopress_redirections_type.'</span>';
                    break;

                default:
                    echo '<span class="seopress_redirection_default seopress_redirection_status">'.__('404','wp-seopress-pro').'</span>';
                    break;
                }
            }
            if ($column == 'seopress_404_redirect_value') {
                echo get_post_meta($post_id, "_seopress_redirections_value", true);
            }
            if ($column == 'seopress_404_redirect_ua') {
                echo get_post_meta($post_id, "seopress_redirections_ua", true);
            }
        }
        //Sortable columns
        add_filter( 'manage_edit-seopress_404_sortable_columns' , 'seopress_404_sortable_columns' );
        
        function seopress_404_sortable_columns($columns) {
            $columns['seopress_404'] = 'seopress_404';
            $columns['seopress_404_redirect_enable'] = 'seopress_404_redirect_enable';
            $columns['seopress_404_redirect_type'] = 'seopress_404_redirect_type';
            return $columns;
        }
        
        add_filter( 'pre_get_posts', 'seopress_404_sort_columns_by');
        function seopress_404_sort_columns_by( $query ) {
            if( ! is_admin() ) {
                return;
            } else {
                $orderby = $query->get('orderby');
                if( 'seopress_404' == $orderby ) {
                    $query->set('meta_key', 'seopress_404_count');
                    $query->set('orderby','meta_value_num');
                }
                if( 'seopress_404_redirect_enable' == $orderby ) {
                    $query->set('meta_key', '_seopress_redirections_enabled');
                    $query->set('orderby','meta_value');
                }
                if( 'seopress_404_redirect_type' == $orderby ) {
                    $query->set('meta_key', '_seopress_redirections_type');
                    $query->set('orderby','meta_value');
                }
            }
        }
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Do redirect
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    function seopress_301_do_redirect() {
        if (!is_admin()) {
            global $wp;
            global $post;

            $get_init_current_url = htmlspecialchars(rawurldecode(add_query_arg( $_SERVER['QUERY_STRING'], '', home_url($wp->request))));
            $get_current_url = wp_parse_url($get_init_current_url);

            $uri = '';
            $uri2 = '';
            $seopress_get_page = '';
            $if_exact_match = true;

            //Path and Query
            if (isset($get_current_url['path']) && !empty($get_current_url['path']) && isset($get_current_url['query']) && !empty($get_current_url['query'])) {
                
                $uri = trailingslashit($get_current_url['path']).'?'.$get_current_url['query'];
                $uri2 = $get_current_url['path'].'?'.$get_current_url['query'];
                $uri = ltrim($uri, '/');
                $uri2 = ltrim($uri2, '/');

            } 
            //Path only
            elseif (isset($get_current_url['path']) && !empty($get_current_url['path']) && !isset($get_current_url['query'])) {
                
                $uri = $get_current_url['path'];
                $uri = ltrim($uri, '/');

            } 
            //Query only
            elseif (isset($get_current_url['query']) && !empty($get_current_url['query']) && !isset($get_current_url['path'])) {
                
                $uri = '?'.$get_current_url['query'];
                $uri = ltrim($uri, '/');

            } 
            //default - home
            else {
                $uri = $get_current_url['host'];
            }

            //Find URL in Redirections post type --- EXACT MATCH
            /**With trailing slash**/
            if (isset($uri) && $uri !='' && get_page_by_title(trailingslashit($uri), '',  'seopress_404')) {
                $seopress_get_page = get_page_by_title(trailingslashit($uri), '',  'seopress_404');
            } 
            /**Without trailing slash**/
            elseif (isset($uri2) && $uri2 !='' && get_page_by_title($uri2, '',  'seopress_404')) {
                $seopress_get_page = get_page_by_title($uri2, '',  'seopress_404');
            } 
            /**Default**/
            else {
                $seopress_get_page = get_page_by_title($uri, '',  'seopress_404');
            }

            //Find URL in Redirections post type --- IGNORE ALL PARAMETERS
            if ($seopress_get_page =='') {
                $if_exact_match = false;

                $uri = wp_parse_url($uri, PHP_URL_PATH);
                $uri2 = wp_parse_url($uri2, PHP_URL_PATH);
                $uri = ltrim($uri, '/');
                $uri2 = ltrim($uri2, '/');

                /**With trailing slash**/
                if (isset($uri) && $uri !='' && get_page_by_title(trailingslashit($uri), '',  'seopress_404')) {
                    $seopress_get_page = get_page_by_title(trailingslashit($uri), '',  'seopress_404');
                } 
                /**Without trailing slash**/
                elseif (isset($uri2) && $uri2 !='' && get_page_by_title($uri2, '',  'seopress_404')) {
                    $seopress_get_page = get_page_by_title($uri2, '',  'seopress_404');
                } 
                /**Default**/
                else {
                    $seopress_get_page = get_page_by_title($uri, '',  'seopress_404');
                }
            }
            
            if (isset($seopress_get_page->ID)) {
                if (get_post_status($seopress_get_page->ID) =='publish') {
                    if (get_post_meta($seopress_get_page->ID,'_seopress_redirections_enabled',true)) {

                        //Query parameters
                        if (get_post_meta($seopress_get_page->ID,'_seopress_redirections_param',true)) {
                            $query_param = get_post_meta($seopress_get_page->ID,'_seopress_redirections_param',true);
                        } else {
                            $query_param = 'exact_match';
                        }

                        //451 / 410
                        if (get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true) =='410' || get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true) == '451') {
                            
                            //URL redirection
                            $seopress_redirections_value = $get_init_current_url;
                            
                            //Update counter
                            $seopress_404_count = get_post_meta($seopress_get_page->ID,'seopress_404_count', true);
                            update_post_meta($seopress_get_page->ID, 'seopress_404_count', ++$seopress_404_count);
                            
                            //Do redirect
                            if ($if_exact_match == true) {
                                header('Location:'.$seopress_redirections_value, true, get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true));
                                exit();
                            } elseif ($if_exact_match == false && $query_param !='exact_match') {
                                header('Location:'.$seopress_redirections_value, true, get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true));
                                exit();
                            }
                        } 
                        //301 / 302 / 307
                        elseif (get_post_meta($seopress_get_page->ID,'_seopress_redirections_value',true)) {
                            //URL redirection
                            $seopress_redirections_value = html_entity_decode(get_post_meta($seopress_get_page->ID,'_seopress_redirections_value',true));

                            //Query parameters
                            if ($query_param =='with_ignored_param' && isset($get_current_url['query']) && !empty($get_current_url['query'])) {
                                $seopress_redirections_value = $seopress_redirections_value.'?'.$get_current_url['query'];    
                            }
                            
                            //Update counter
                            $seopress_404_count = get_post_meta($seopress_get_page->ID,'seopress_404_count', true);
                            update_post_meta($seopress_get_page->ID, 'seopress_404_count', ++$seopress_404_count);
                            
                            //Do redirect
                            if ($if_exact_match == true) {
                                wp_redirect($seopress_redirections_value, get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true));
                                exit();
                            } elseif ($if_exact_match == false && $query_param !='exact_match') {
                                wp_redirect($seopress_redirections_value, get_post_meta($seopress_get_page->ID,'_seopress_redirections_type',true));
                                exit();
                            }
                        }
                    }
                }
            }
        }
    }
    add_action('template_redirect', 'seopress_301_do_redirect', 1);

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Monitor 404
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    //404 monitoring
    function seopress_404_enable_option() {
        $seopress_404_enable_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_enable_option ) ) {
            foreach ($seopress_404_enable_option as $key => $seopress_404_enable_value)
                $options[$key] = $seopress_404_enable_value;
             if (isset($seopress_404_enable_option['seopress_404_enable'])) { 
                return $seopress_404_enable_option['seopress_404_enable'];
             }
        }
    }    
    //Redirect to home
    function seopress_404_redirect_home_option() {
        $seopress_404_redirect_home_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_redirect_home_option ) ) {
            foreach ($seopress_404_redirect_home_option as $key => $seopress_404_redirect_home_value)
                $options[$key] = $seopress_404_redirect_home_value;
             if (isset($seopress_404_redirect_home_option['seopress_404_redirect_home'])) { 
                return $seopress_404_redirect_home_option['seopress_404_redirect_home'];
             }
        }
    }    
    //Redirect to custom url
    function seopress_404_redirect_custom_url_option() {
        $seopress_404_redirect_custom_url_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_redirect_custom_url_option ) ) {
            foreach ($seopress_404_redirect_custom_url_option as $key => $seopress_404_redirect_custom_url_value)
                $options[$key] = $seopress_404_redirect_custom_url_value;
             if (isset($seopress_404_redirect_custom_url_option['seopress_404_redirect_custom_url'])) { 
                return $seopress_404_redirect_custom_url_option['seopress_404_redirect_custom_url'];
             }
        }
    }
    //Status code
    function seopress_404_redirect_status_code_option() {
        $seopress_404_redirect_status_code_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_redirect_status_code_option ) ) {
            foreach ($seopress_404_redirect_status_code_option as $key => $seopress_404_redirect_status_code_value)
                $options[$key] = $seopress_404_redirect_status_code_value;
             if (isset($seopress_404_redirect_status_code_option['seopress_404_redirect_status_code'])) { 
                return $seopress_404_redirect_status_code_option['seopress_404_redirect_status_code'];
             }
        }
    }
    //Enable Mail notifications
    function seopress_404_enable_mails_option() {
        $seopress_404_enable_mails_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_enable_mails_option ) ) {
            foreach ($seopress_404_enable_mails_option as $key => $seopress_404_enable_mails_value)
                $options[$key] = $seopress_404_enable_mails_value;
             if (isset($seopress_404_enable_mails_option['seopress_404_enable_mails'])) { 
                return $seopress_404_enable_mails_option['seopress_404_enable_mails'];
             }
        }
    }
    //To Mail Alert
    function seopress_404_enable_mails_from_option() {
        $seopress_404_enable_mails_from_option = get_option("seopress_pro_option_name");
        if ( ! empty ( $seopress_404_enable_mails_from_option ) ) {
            foreach ($seopress_404_enable_mails_from_option as $key => $seopress_404_enable_mails_from_value)
                $options[$key] = $seopress_404_enable_mails_from_value;
             if (isset($seopress_404_enable_mails_from_option['seopress_404_enable_mails_from'])) { 
                return $seopress_404_enable_mails_from_option['seopress_404_enable_mails_from'];
             }
        }
    }
    function seopress_404_send_alert($get_current_url) {
        function seopress_404_send_alert_content_type() {
            return 'text/html';
        }
        add_filter( 'wp_mail_content_type', 'seopress_404_send_alert_content_type' );
        
        $to = seopress_404_enable_mails_from_option();
        $subject = 'SEOPress: 404 alert - '.get_bloginfo('name');

        $body = "<style>
            #wrapper {
                background-color: #F9F9F9;
                margin: 0;
                padding: 70px 0 70px 0;
                -webkit-text-size-adjust: none !important;
                width: 100%;
            }

            #template_container {
                box-shadow:0 0 0 1px #f3f3f3 !important;
                background-color: #ffffff;
                border: 1px solid #e9e9e9;
                padding: 0;
            }

            #template_header {
                color: #333;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            }

            #template_header h1,
            #template_header h1 a {
                color: #232323;
            }

            #template_footer td {
                padding: 0;
            }

            #template_footer #credit {
                font-family: courier, 'Helvetica Neue', Helvetica, Arial, 'Lucida Grande', sans-serif;
                font-size: 12px;
                line-height: 125%;
                text-align: center;
                padding: 12px 28px 28px 28px;
            }

            #body_content {
                background-color: #ffffff;
            }

            #body_content table td {
                padding: 48px;
            }

            #body_content table td td {
                padding: 12px;
            }

            #body_content table td th {
                padding: 12px;
            }

            #body_content p {
                margin: 0 0 16px;
            }

            #body_content_inner {
                color: #505050;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
                font-size: 14px;
                line-height: 150%;
            }

            .td {
                color: #505050;
                border: 1px solid #E5E5E5;
            }

            .text {
                color: #505050;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            }

            .link {
                color: #232323;
            }

            #header_wrapper {
                padding: 12px 0 8px 60px;
                display: block;
                border-bottom: 1px solid #F1F1F1;
            }

            h1 {
                color: #232323;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
                font-size: 18px;
                margin: 0;
                -webkit-font-smoothing: antialiased;
            }

            h2 {
                color: #232323;
                display: block;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
                font-size: 18px;
                font-weight: bold;
                line-height: 130%;
                margin: 16px 0 8px;
            }

            h3 {
                color: #232323;
                display: block;
                font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
                font-size: 16px;
                font-weight: bold;
                line-height: 130%;
                margin: 16px 0 8px;
            }

            a {
                color: #232323;
                font-weight: normal;
                text-decoration: underline;
            }

            img {
                border: none;
                display: inline;
                font-size: 14px;
                font-weight: bold;
                height: auto;
                line-height: 100%;
                outline: none;
                text-decoration: none;
                text-transform: capitalize;
            }
        </style>";
        $body .= '<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
            <div id="wrapper">
                <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container">
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Header -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_header">
                                            <tr>
                                                <td id="header_wrapper">
                                                    <h1><img style="height:40px;width:40px;vertical-align: middle;margin-right: 10px;" src="data:image/png;base64,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">'. __("404 alert","wp-seopress-pro").'</h1>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Header -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Body -->
                                        <table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
                                            <tr>
                                                <td valign="top" id="body_content">
                                                    <!-- Content -->
                                                    <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td valign="top">
                                                                <div id="body_content_inner">
                                                                    <p>'.__('You are receiving this email because a new 404 error has been logged on your site. See below:','wp-seopress-pro').'</p>
                                                                    <ul><li>'.get_home_url().'/'.$get_current_url.'</li></ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <!-- End Content -->
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Body -->
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" valign="top">
                                        <!-- Footer -->
                                        <table border="0" cellpadding="10" cellspacing="0" width="600" id="template_footer">
                                            <tr>
                                                <td valign="top">
                                                    <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td colspan="2" id="credit" style="border:0;color: #878787; border-top: 1px solid #F1F1F1;" valign="middle">
                                                                <p><a href="https://www.seopress.org/fr">SEOPress</a></p>
                                                                Made with love in Biarritz - France</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                        <!-- End Footer -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </body>';
         
        wp_mail( $to, $subject, $body );
         
        remove_filter( 'wp_mail_content_type', 'seopress_404_send_alert_content_type' );
    }

    //Create Redirection in Post Type
    function seopress_404_create_redirect() {
        global $wp;
        global $post;

        $get_current_url = add_query_arg(array(),$wp->request);

        //Exclude URLs from cache
        $match = false;
        $seopress_404_exclude = array('wp-content/cache');
        $seopress_404_exclude = apply_filters('seopress_404_exclude', $seopress_404_exclude);

        foreach($seopress_404_exclude as $kw) {
            if (strpos($get_current_url, $kw) === 0) {
                $match = true;
                break;
            }
        }

        //Creating 404 error in seopress_404
        if ($match === false) {
            $seopress_get_page = get_page_by_title( $get_current_url, '',  'seopress_404');

            //Get Title
            if ($seopress_get_page !='') {
                $seopress_get_post_title = $seopress_get_page->post_title;
            } else {
                $seopress_get_post_title = '';
            }        

            //Get User Agent
            if (!empty($_SERVER['HTTP_USER_AGENT'])) {
                $seopress_get_ua = $_SERVER['HTTP_USER_AGENT'];
            }

            if ($get_current_url && $seopress_get_post_title != $get_current_url) {
                wp_insert_post(array('post_title' => $get_current_url, 'meta_input' => array('seopress_redirections_ua' => $seopress_get_ua), 'post_type' => 'seopress_404', 'post_status' => 'publish'));
                if (seopress_404_enable_mails_option() =='1' && seopress_404_enable_mails_from_option() !='') {
                    seopress_404_send_alert($get_current_url);
                }
            } elseif ($get_current_url && $seopress_get_page->post_title == $get_current_url) {
                $seopress_404_count = get_post_meta($seopress_get_page->ID,'seopress_404_count', true);
                update_post_meta($seopress_get_page->ID, 'seopress_404_count', ++$seopress_404_count);
                update_post_meta($seopress_get_page->ID, 'seopress_redirections_ua', $seopress_get_ua);
            }
        }
    }
    function seopress_is_bot() {
        $bot_regex = '/BotLink|bingbot|AhrefsBot|ahoy|AlkalineBOT|anthill|appie|arale|araneo|AraybOt|ariadne|arks|ATN_Worldwide|Atomz|bbot|Bjaaland|Ukonline|borg\-bot\/0\.9|boxseabot|bspider|calif|christcrawler|CMC\/0\.01|combine|confuzzledbot|CoolBot|cosmos|Internet Cruiser Robot|cusco|cyberspyder|cydralspider|desertrealm, desert realm|digger|DIIbot|grabber|downloadexpress|DragonBot|dwcp|ecollector|ebiness|elfinbot|esculapio|esther|fastcrawler|FDSE|FELIX IDE|ESI|fido|H�m�h�kki|KIT\-Fireball|fouineur|Freecrawl|gammaSpider|gazz|gcreep|golem|googlebot|griffon|Gromit|gulliver|gulper|hambot|havIndex|hotwired|htdig|iajabot|INGRID\/0\.1|Informant|InfoSpiders|inspectorwww|irobot|Iron33|JBot|jcrawler|Teoma|Jeeves|jobo|image\.kapsi\.net|KDD\-Explorer|ko_yappo_robot|label\-grabber|larbin|legs|Linkidator|linkwalker|Lockon|logo_gif_crawler|marvin|mattie|mediafox|MerzScope|NEC\-MeshExplorer|MindCrawler|udmsearch|moget|Motor|msnbot|muncher|muninn|MuscatFerret|MwdSearch|sharp\-info\-agent|WebMechanic|NetScoop|newscan\-online|ObjectsSearch|Occam|Orbsearch\/1\.0|packrat|pageboy|ParaSite|patric|pegasus|perlcrawler|phpdig|piltdownman|Pimptrain|pjspider|PlumtreeWebAccessor|PortalBSpider|psbot|Getterrobo\-Plus|Raven|RHCS|RixBot|roadrunner|Robbie|robi|RoboCrawl|robofox|Scooter|Search\-AU|searchprocess|Senrigan|Shagseeker|sift|SimBot|Site Valet|skymob|SLCrawler\/2\.0|slurp|ESI|snooper|solbot|speedy|spider_monkey|SpiderBot\/1\.0|spiderline|nil|suke|http:\/\/www\.sygol\.com|tach_bw|TechBOT|templeton|titin|topiclink|UdmSearch|urlck|Valkyrie libwww\-perl|verticrawl|Victoria|void\-bot|Voyager|VWbot_K|crawlpaper|wapspider|WebBandit\/1\.0|webcatcher|T\-H\-U\-N\-D\-E\-R\-S\-T\-O\-N\-E|WebMoose|webquest|webreaper|webs|webspider|WebWalker|wget|winona|whowhere|wlm|WOLP|WWWC|none|XGET|Nederland\.zoek|AISearchBot|woriobot|NetSeer|Nutch|YandexBot|YandexMobileBot|SemrushBot|FatBot|MJ12bot|DotBot|AddThis|baiduspider|SeznamBot|mod_pagespeed|CCBot|openstat.ru\/Bot|m2e/i';

        $bot_regex = apply_filters('seopress_404_bots', $bot_regex);

        $userAgent = empty($_SERVER['HTTP_USER_AGENT']) ? FALSE : $_SERVER['HTTP_USER_AGENT'];
        if ($bot_regex !='' && $userAgent !='') {
            $isBot = !$userAgent || preg_match($bot_regex, $userAgent);
            return $isBot;
        }
    }
    if (seopress_404_enable_option()) {
        function seopress_404_log() {
            if (is_404() && !is_admin() && seopress_404_redirect_home_option() !='') {
                if (seopress_404_redirect_home_option() =='home') {
                    if (seopress_404_redirect_status_code_option() !='') {
                        if (seopress_is_bot() !='1') {
                            seopress_404_create_redirect();
                        }
                        wp_redirect(get_home_url(), seopress_404_redirect_status_code_option());
                        exit;
                    } else {
                        if (seopress_is_bot() !='1') {
                            seopress_404_create_redirect();
                        }
                        wp_redirect(get_home_url(), '301');
                        exit;
                    }
                } elseif (seopress_404_redirect_home_option() =='custom' && seopress_404_redirect_custom_url_option() !='') {
                    if (seopress_404_redirect_status_code_option() !='') {
                        if (seopress_is_bot() !='1') {
                            seopress_404_create_redirect();
                        }
                        wp_redirect(seopress_404_redirect_custom_url_option(), seopress_404_redirect_status_code_option());
                        exit;
                    } else {
                        if (seopress_is_bot() !='1') {
                            seopress_404_create_redirect();
                        }
                        wp_redirect(seopress_404_redirect_custom_url_option(), '301');
                        exit;
                    }
                } else {
                    if (seopress_is_bot() !='1') {
                        seopress_404_create_redirect();
                    }
                }
            } elseif (is_404() && !is_admin()) {
                if (seopress_is_bot() !='1') {
                    seopress_404_create_redirect();
                }
            }
        }
        add_action('template_redirect', 'seopress_404_log');
    }
}
