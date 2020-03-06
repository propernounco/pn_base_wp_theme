<?php

defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

if ( is_admin() ) {

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Register SEOPress Backlinks Custom Post Type
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    function seopress_backlinks_fn() {

        $labels = array(
            'name'                  => _x( 'Backlinks', 'Post Type General Name', 'wp-seopress-pro' ),
            'singular_name'         => _x( 'Backlinks', 'Post Type Singular Name', 'wp-seopress-pro' ),
            'menu_name'             => __( 'Backlinks', 'wp-seopress-pro' ),
            'name_admin_bar'        => __( 'Backlinks', 'wp-seopress-pro' ),
            'archives'              => __( 'Item Links', 'wp-seopress-pro' ),
            'parent_item_colon'     => __( 'Parent Link:', 'wp-seopress-pro' ),
            'all_items'             => __( 'All Backlinks', 'wp-seopress-pro' ),
            'add_new_item'          => __( 'Add New backlink', 'wp-seopress-pro' ),
            'add_new'               => __( 'Add backlink', 'wp-seopress-pro' ),
            'new_item'              => __( 'New backlink', 'wp-seopress-pro' ),
            'edit_item'             => __( 'Edit backlink', 'wp-seopress-pro' ),
            'update_item'           => __( 'Update backlink', 'wp-seopress-pro' ),
            'view_item'             => __( 'View backlink', 'wp-seopress-pro' ),
            'search_items'          => __( 'Search backlink', 'wp-seopress-pro' ),
            'not_found'             => __( 'Not found', 'wp-seopress-pro' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'wp-seopress-pro' ),
            'featured_image'        => __( 'Featured Image', 'wp-seopress-pro' ),
            'set_featured_image'    => __( 'Set featured image', 'wp-seopress-pro' ),
            'remove_featured_image' => __( 'Remove featured image', 'wp-seopress-pro' ),
            'use_featured_image'    => __( 'Use as featured image', 'wp-seopress-pro' ),
            'insert_into_item'      => __( 'Insert into item', 'wp-seopress-pro' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-seopress-pro' ),
            'items_list'            => __( 'Backlinks list', 'wp-seopress-pro' ),
            'items_list_navigation' => __( 'Backlinks list navigation', 'wp-seopress-pro' ),
            'filter_items_list'     => __( 'Filter backlinks list', 'wp-seopress-pro' ),
        );
        $args = array(
            'label'                 => __( 'Backlinks', 'wp-seopress-pro' ),
            'description'           => __( 'List of backlinks', 'wp-seopress-pro' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'custom-fields' ),
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
            'capabilities' => array(
                'create_posts' => 'false',
              ),
            'map_meta_cap' => true,
        );
        register_post_type( 'seopress_backlinks', $args );

    }
    add_action( 'init', 'seopress_backlinks_fn', 10 );

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Add custom buttons to SEOPress Backlinks Custom Post Type
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    function seopress_backlinks_btn_cpt() {
        $screen = get_current_screen();
        if  ( 'seopress_backlinks' == $screen->post_type ) {
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
            ?>
                <script>
                jQuery(function(){
                    jQuery("body.post-type-seopress_backlinks .wrap h1").append('<button id="seopress-find-backlinks" class="page-title-action"><?php _e('Check your backlinks','wp-seopress-pro'); ?></button><form method="post" style="display: inline-block;margin-left:10px"><input type="hidden" name="seopress_action" value="export_backlinks_settings" /><?php wp_nonce_field( 'seopress_export_backlinks_nonce', 'seopress_export_backlinks_nonce' ); ?><?php submit_button( esc_attr__( 'Export CSV', 'wp-seopress' ), 'secondary', '', false ); ?></form><span class="spinner"></span>');
                });
                </script>
            <?php } else { ?>
                <script>
                jQuery(function(){
                    jQuery("body.post-type-seopress_backlinks .wrap h1").append('<a href="<?php echo admin_url( 'admin.php?page=seopress-pro-page#tab=tab_seopress_backlinks$12'); ?>" class="page-title-action"><?php esc_attr_e('Enter your Majestic key','wp-seopress-pro'); ?></a>');
                });
                </script>
            <?php }
        }
    }
    add_action('admin_head', 'seopress_backlinks_btn_cpt');

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Set title placeholder for Backlinks Custom Post Type
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    function seopress_backlinks_cpt_title( $title ){
         $screen = get_current_screen();
         if  ( 'seopress_backlinks' == $screen->post_type ) {
              $title = __('Enter an URL here', 'wp-seopress-pro');
         }
         return $title;
    }
     
    add_filter( 'enter_title_here', 'seopress_backlinks_cpt_title' );

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Set messages for Backlinks Custom Post Type
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    function seopress_backlinks_set_messages($messages) {
        global $post, $post_ID;
        $post_type = 'seopress_backlinks';

        $obj = get_post_type_object($post_type);
        $singular = $obj->labels->singular_name;

        $messages[$post_type] = array(
            0 => '', // Unused. Messages start at index 1.
            1 => sprintf( __($singular.' updated.'), esc_url( get_permalink($post_ID) ) ),
            2 => __('Custom field updated.'),
            3 => __('Custom field deleted.'),
            4 => __($singular.' updated.'),
            5 => isset($_GET['revision']) ? sprintf( __($singular.' restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6 => sprintf( __($singular.' published.'), esc_url( get_permalink($post_ID) ) ),
            7 => __('Page saved.'),
            8 => sprintf( __($singular.' submitted.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
            9 => sprintf( __($singular.' scheduled for: <strong>%1$s</strong>. '), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
            10 => sprintf( __($singular.' draft updated.'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
        );
        return $messages;
    }
    add_filter('post_updated_messages', 'seopress_backlinks_set_messages' );
    
    function seopress_backlinks_set_messages_list( $bulk_messages, $bulk_counts ) {

        $bulk_messages['seopress_backlinks'] = array(
            'updated'   => _n( '%s backlink updated.', '%s backlinks updated.', $bulk_counts['updated'] ),
            'locked'    => _n( '%s backlink not updated, somebody is editing it.', '%s backlinks not updated, somebody is editing them.', $bulk_counts['locked'] ),
            'deleted'   => _n( '%s backlink permanently deleted.', '%s backlinks permanently deleted.', $bulk_counts['deleted'] ),
            'trashed'   => _n( '%s backlink moved to the Trash.', '%s backlinks moved to the Trash.', $bulk_counts['trashed'] ),
            'untrashed' => _n( '%s backlink restored from the Trash.', '%s backlinks restored from the Trash.', $bulk_counts['untrashed'] ),
        );

        return $bulk_messages;

    }
    add_filter( 'bulk_post_updated_messages', 'seopress_backlinks_set_messages_list', 10, 2 );

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Columns for BOT Custom Post Type
    ///////////////////////////////////////////////////////////////////////////////////////////////////

    add_filter('manage_edit-seopress_backlinks_columns', 'seopress_backlinks_columns');
    add_action('manage_seopress_backlinks_posts_custom_column', 'seopress_backlinks_display_column', 10, 2);

    function seopress_backlinks_columns($columns) {
        $columns['seopress_backlinks_url'] = __('URL', 'wp-seopress-pro');
        $columns['seopress_backlinks_anchor_text'] = __('Anchor Text', 'wp-seopress-pro');
        $columns['seopress_backlinks_source_citation_flow'] = __('Domain CF', 'wp-seopress-pro');
        $columns['seopress_backlinks_source_trust_flow'] = __('Domain TF', 'wp-seopress-pro');
        $columns['seopress_backlinks_target_citation_flow'] = __('URL CF', 'wp-seopress-pro');
        $columns['seopress_backlinks_target_trust_flow'] = __('URL TF', 'wp-seopress-pro');
        $columns['seopress_backlinks_found_date'] = __('First indexed', 'wp-seopress-pro');
        $columns['seopress_backlinks_last_update'] = __('Last seen', 'wp-seopress-pro');
        unset($columns['date']);
        unset($columns['title']);
        return $columns;
    }

    function seopress_backlinks_display_column($column, $post_id) {
        if ($column == 'seopress_backlinks_url') {
            echo '<span class="dashicons dashicons-admin-links"></span><strong>'.__('Source URL','wp-seopress-pro').'</strong><br><a href="'.get_the_title($post_id).'" target="_blank" title="'.__('Open link in a new window','wp-seopress-pro').'">'.get_the_title($post_id).'</a><br><br><span class="dashicons dashicons-randomize"></span><strong>'.__('Target URL','wp-seopress-pro').'</strong><br><a href="'.get_post_meta($post_id, "seopress_backlinks_target_url", true).'" target="_blank">'.get_post_meta($post_id, "seopress_backlinks_target_url", true).'</a>';
        }
        if ($column == 'seopress_backlinks_anchor_text') {
            echo get_post_meta($post_id, "seopress_backlinks_anchor_text", true);
        }
        if ($column == 'seopress_backlinks_source_citation_flow') {
            echo get_post_meta($post_id, "seopress_backlinks_source_citation_flow", true);
        }
        if ($column == 'seopress_backlinks_source_trust_flow') {
            echo get_post_meta($post_id, "seopress_backlinks_source_trust_flow", true);
        }
        if ($column == 'seopress_backlinks_target_citation_flow') {
            echo get_post_meta($post_id, "seopress_backlinks_target_citation_flow", true);
        }
        if ($column == 'seopress_backlinks_target_trust_flow') {
            echo get_post_meta($post_id, "seopress_backlinks_target_trust_flow", true);
        }
        if ($column == 'seopress_backlinks_found_date') {
            echo '<span style="color: rgba(19,191,17,1)">'.get_post_meta($post_id, "seopress_backlinks_found_date", true).'</span>';
        } 
        if ($column == 'seopress_backlinks_last_update') {
            echo get_post_meta($post_id, "seopress_backlinks_last_update", true);
        }
    }

    //Sortable columns
    add_filter( 'manage_edit-seopress_backlinks_sortable_columns' , 'seopress_backlinks_sortable_columns' );
    
    function seopress_backlinks_sortable_columns($columns) {
        $columns['seopress_backlinks_url'] = 'seopress_backlinks_url';
        $columns['seopress_backlinks_source_citation_flow'] = 'seopress_backlinks_source_citation_flow';
        $columns['seopress_backlinks_source_trust_flow'] = 'seopress_backlinks_source_trust_flow';
        $columns['seopress_backlinks_target_citation_flow'] = 'seopress_backlinks_target_citation_flow';
        $columns['seopress_backlinks_target_trust_flow'] = 'seopress_backlinks_target_trust_flow';
        return $columns;
    }
    
    add_filter( 'pre_get_posts', 'seopress_backlinks_sort_columns_by');
    function seopress_backlinks_sort_columns_by( $query ) {
        if( ! is_admin() ) {
            return;
        } else {
            $orderby = $query->get('orderby');
            if( 'seopress_backlinks_url' == $orderby ) {
                $query->set('orderby','title');
            } elseif( 'seopress_backlinks_source_citation_flow' == $orderby ) {
                $query->set('meta_key', 'seopress_backlinks_source_citation_flow');
                $query->set('orderby','meta_value');
            } elseif( 'seopress_backlinks_source_trust_flow' == $orderby ) {
                $query->set('meta_key', 'seopress_backlinks_source_trust_flow');
                $query->set('orderby','meta_value');
            } elseif( 'seopress_backlinks_target_trust_flow' == $orderby ) {
                $query->set('meta_key', 'seopress_backlinks_target_trust_flow');
                $query->set('orderby','meta_value');
            } elseif( 'seopress_backlinks_target_trust_flow' == $orderby ) {
                $query->set('meta_key', 'seopress_backlinks_target_trust_flow');
                $query->set('orderby','meta_value');
            }
        }
    }
}
