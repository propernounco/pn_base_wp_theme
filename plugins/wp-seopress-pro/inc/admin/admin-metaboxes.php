<?php

defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

///////////////////////////////////////////////////////////////////////////////////////////////////
//Restrict Structured Data Types metaboxes to user roles
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_advanced_security_metaboxe_sdt_role_hook_option() {
    $seopress_advanced_security_metaboxe_sdt_role_hook_option = get_option("seopress_advanced_option_name");
    if ( ! empty ( $seopress_advanced_security_metaboxe_sdt_role_hook_option ) ) {
        foreach ($seopress_advanced_security_metaboxe_sdt_role_hook_option as $key => $seopress_advanced_security_metaboxe_sdt_role_hook_value)
            $options[$key] = $seopress_advanced_security_metaboxe_sdt_role_hook_value;
         if (isset($seopress_advanced_security_metaboxe_sdt_role_hook_option['seopress_advanced_security_metaboxe_sdt_role'])) { 
            return $seopress_advanced_security_metaboxe_sdt_role_hook_option['seopress_advanced_security_metaboxe_sdt_role'];
         }
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//Display Rich Snippets metabox in Custom Post Type
///////////////////////////////////////////////////////////////////////////////////////////////////
function seopress_pro_admin_std_metaboxe_display() {
    add_action('add_meta_boxes','seopress_pro_init_metabox', 20);
    function seopress_pro_init_metabox(){
        if (function_exists('seopress_advanced_appearance_metaboxe_position_option')) {
            $seopress_advanced_appearance_metaboxe_position_option = seopress_advanced_appearance_metaboxe_position_option();
        } else {
            $seopress_advanced_appearance_metaboxe_position_option = 'default';
        }

        if (function_exists('seopress_get_post_types')) {
            
            $seopress_get_post_types = seopress_get_post_types();

            $seopress_get_post_types = apply_filters('seopress_pro_metaboxe_sdt', $seopress_get_post_types);
            
            if (!empty($seopress_get_post_types)) {
                foreach ($seopress_get_post_types as $key => $value) {
                    add_meta_box('seopress_pro_cpt', __('Structured Data Types','wp-seopress-pro'), 'seopress_pro_cpt', $key, 'normal', $seopress_advanced_appearance_metaboxe_position_option);
                }
            }
        }
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

    function seopress_advanced_appearance_advice_schema_option() {
        $seopress_advanced_appearance_advice_schema_option = get_option("seopress_advanced_option_name");
        if ( ! empty ( $seopress_advanced_appearance_advice_schema_option ) ) {
            foreach ($seopress_advanced_appearance_advice_schema_option as $key => $seopress_advanced_appearance_advice_schema_value)
                $options[$key] = $seopress_advanced_appearance_advice_schema_value;
             if (isset($seopress_advanced_appearance_advice_schema_option['seopress_advanced_appearance_advice_schema'])) { 
                return $seopress_advanced_appearance_advice_schema_option['seopress_advanced_appearance_advice_schema'];
             }
        }
    }
        
    function seopress_pro_cpt($post){
        wp_nonce_field( plugin_basename( __FILE__ ), 'seopress_pro_cpt_nonce' );
        
        wp_enqueue_script( 'jquery-ui-accordion' );
        
        wp_enqueue_script( 'seopress-pro-media-uploader-js', plugins_url('assets/js/seopress-pro-media-uploader.js', dirname(dirname( __FILE__ ))), array('jquery'), SEOPRESS_PRO_VERSION, false );
        wp_enqueue_script( 'seopress-pro-rich-snippets-js', plugins_url('assets/js/seopress-pro-rich-snippets.min.js', dirname(dirname( __FILE__ ))), array('jquery'), SEOPRESS_PRO_VERSION, false );
        wp_enqueue_media();

        wp_enqueue_script('jquery-ui-datepicker');

        global $typenow;
        
        $seopress_pro_rich_snippets_type                                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_type',true);

        //Article
        $seopress_pro_rich_snippets_article_type                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_article_type',true);
        $seopress_pro_rich_snippets_article_title                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_article_title',true);
        $seopress_pro_rich_snippets_article_img                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_article_img',true);
        $seopress_pro_rich_snippets_article_img_width                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_article_img_width',true);
        $seopress_pro_rich_snippets_article_img_height                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_article_img_height',true);

        //Local Business
        $seopress_pro_rich_snippets_lb_name                             = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_name',true);
        $seopress_pro_rich_snippets_lb_type                             = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_type',true);
        $seopress_pro_rich_snippets_lb_img                              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_img',true);
        $seopress_pro_rich_snippets_lb_img_width                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_img_width',true);
        $seopress_pro_rich_snippets_lb_img_height                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_img_height',true);
        $seopress_pro_rich_snippets_lb_street_addr                      = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_street_addr',true);
        $seopress_pro_rich_snippets_lb_city                             = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_city',true);
        $seopress_pro_rich_snippets_lb_state                            = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_state',true);
        $seopress_pro_rich_snippets_lb_pc                               = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_pc',true);
        $seopress_pro_rich_snippets_lb_country                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_country',true);
        $seopress_pro_rich_snippets_lb_lat                              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_lat',true);
        $seopress_pro_rich_snippets_lb_lon                              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_lon',true);
        $seopress_pro_rich_snippets_lb_website                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_website',true);
        $seopress_pro_rich_snippets_lb_tel                              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_tel',true);
        $seopress_pro_rich_snippets_lb_price                            = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_price',true);
        $seopress_pro_rich_snippets_lb_opening_hours                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_lb_opening_hours',false);

        //FAQ
        $seopress_pro_rich_snippets_faq                                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_faq');
        
        //Course
        $seopress_pro_rich_snippets_courses_title                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_courses_title',true);
        $seopress_pro_rich_snippets_courses_desc                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_courses_desc',true);
        $seopress_pro_rich_snippets_courses_school                      = get_post_meta($post->ID,'_seopress_pro_rich_snippets_courses_school',true);
        $seopress_pro_rich_snippets_courses_website                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_courses_website',true);
        
        //Recipe
        $seopress_pro_rich_snippets_recipes_name                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_name',true);
        $seopress_pro_rich_snippets_recipes_desc                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_desc',true);
        $seopress_pro_rich_snippets_recipes_cat                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_cat',true);
        $seopress_pro_rich_snippets_recipes_img                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_img',true);
        $seopress_pro_rich_snippets_recipes_prep_time                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_prep_time',true);
        $seopress_pro_rich_snippets_recipes_cook_time                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_cook_time',true);
        $seopress_pro_rich_snippets_recipes_calories                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_calories',true);
        $seopress_pro_rich_snippets_recipes_yield                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_yield',true);
        $seopress_pro_rich_snippets_recipes_keywords                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_keywords',true);
        $seopress_pro_rich_snippets_recipes_cuisine                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_cuisine',true);
        $seopress_pro_rich_snippets_recipes_ingredient                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_ingredient',true);
        $seopress_pro_rich_snippets_recipes_instructions                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_recipes_instructions',true);

        //Job
        $seopress_pro_rich_snippets_jobs_name                           = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_name',true);
        $seopress_pro_rich_snippets_jobs_desc                           = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_desc',true);
        $seopress_pro_rich_snippets_jobs_date_posted                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_date_posted',true);
        $seopress_pro_rich_snippets_jobs_valid_through                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_valid_through',true);
        $seopress_pro_rich_snippets_jobs_employment_type                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_employment_type',true);
        $seopress_pro_rich_snippets_jobs_identifier_name                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_identifier_name',true);
        $seopress_pro_rich_snippets_jobs_identifier_value               = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_identifier_value',true);
        $seopress_pro_rich_snippets_jobs_hiring_organization            = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_hiring_organization',true);
        $seopress_pro_rich_snippets_jobs_hiring_same_as                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_hiring_same_as',true);
        $seopress_pro_rich_snippets_jobs_hiring_logo                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_hiring_logo',true);
        $seopress_pro_rich_snippets_jobs_hiring_logo_width              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_hiring_logo_width',true);
        $seopress_pro_rich_snippets_jobs_hiring_logo_height             = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_hiring_logo_height',true);
        $seopress_pro_rich_snippets_jobs_address_street                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_address_street',true);
        $seopress_pro_rich_snippets_jobs_address_locality               = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_address_locality',true);
        $seopress_pro_rich_snippets_jobs_address_region                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_address_region',true);
        $seopress_pro_rich_snippets_jobs_postal_code                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_postal_code',true);
        $seopress_pro_rich_snippets_jobs_country                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_country',true);
        $seopress_pro_rich_snippets_jobs_remote                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_remote',true);
        $seopress_pro_rich_snippets_jobs_salary                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_salary',true);
        $seopress_pro_rich_snippets_jobs_salary_currency                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_salary_currency',true);
        $seopress_pro_rich_snippets_jobs_salary_unit                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_jobs_salary_unit',true);

        //Video
        $seopress_pro_rich_snippets_videos_name                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_name',true);
        $seopress_pro_rich_snippets_videos_description                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_description',true);
        $seopress_pro_rich_snippets_videos_img                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_img',true);
        $seopress_pro_rich_snippets_videos_img_width                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_img_width',true);
        $seopress_pro_rich_snippets_videos_img_height                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_img_height',true);
        $seopress_pro_rich_snippets_videos_duration                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_duration',true);
        $seopress_pro_rich_snippets_videos_url                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_videos_url',true);

        //Events
        $seopress_pro_rich_snippets_events_type                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_type',true);
        $seopress_pro_rich_snippets_events_name                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_name',true);
        $seopress_pro_rich_snippets_events_desc                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_desc',true);
        $seopress_pro_rich_snippets_events_img                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_img',true);
        $seopress_pro_rich_snippets_events_start_date                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_start_date',true);
        $seopress_pro_rich_snippets_events_start_time                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_start_time',true);
        $seopress_pro_rich_snippets_events_end_date                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_end_date',true);
        $seopress_pro_rich_snippets_events_end_time                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_end_time',true);
        $seopress_pro_rich_snippets_events_location_name                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_location_name',true);
        $seopress_pro_rich_snippets_events_location_url                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_location_url',true);
        $seopress_pro_rich_snippets_events_location_address             = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_location_address',true);
        $seopress_pro_rich_snippets_events_offers_name                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_name',true);
        $seopress_pro_rich_snippets_events_offers_cat                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_cat',true);
        $seopress_pro_rich_snippets_events_offers_price                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_price',true);
        $seopress_pro_rich_snippets_events_offers_price_currency        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_price_currency',true);
        $seopress_pro_rich_snippets_events_offers_availability          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_availability',true);
        $seopress_rich_snippets_events_offers_valid_from_date           = get_post_meta($post->ID,'_seopress_rich_snippets_events_offers_valid_from_date',true);
        $seopress_rich_snippets_events_offers_valid_from_time           = get_post_meta($post->ID,'_seopress_rich_snippets_events_offers_valid_from_time',true);
        $seopress_pro_rich_snippets_events_offers_url                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_offers_url',true);
        $seopress_pro_rich_snippets_events_performer                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_events_performer',true);

        //Products
        $seopress_pro_rich_snippets_product_name                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_name',true);
        $seopress_pro_rich_snippets_product_description                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_description',true);
        $seopress_pro_rich_snippets_product_img                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_img',true);
        $seopress_pro_rich_snippets_product_price                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_price',true);
        $seopress_pro_rich_snippets_product_price_valid_date            = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_price_valid_date',true);
        $seopress_pro_rich_snippets_product_sku                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_sku',true);
        $seopress_pro_rich_snippets_product_brand                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_brand',true);
        $seopress_pro_rich_snippets_product_global_ids                  = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_global_ids',true);
        $seopress_pro_rich_snippets_product_global_ids_value            = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_global_ids_value',true);
        $seopress_pro_rich_snippets_product_price_currency              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_price_currency',true);
        $seopress_pro_rich_snippets_product_condition                   = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_condition',true);
        $seopress_pro_rich_snippets_product_availability                = get_post_meta($post->ID,'_seopress_pro_rich_snippets_product_availability',true);

        //Services
        $seopress_pro_rich_snippets_service_name                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_name',true);
        $seopress_pro_rich_snippets_service_type                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_type',true);
        $seopress_pro_rich_snippets_service_description                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_description',true);
        $seopress_pro_rich_snippets_service_img                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_img',true);
        $seopress_pro_rich_snippets_service_area                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_area',true);
        $seopress_pro_rich_snippets_service_provider_name               = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_provider_name',true);
        $seopress_pro_rich_snippets_service_lb_img                      = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_lb_img',true);
        $seopress_pro_rich_snippets_service_provider_mobility           = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_provider_mobility',true);
        $seopress_pro_rich_snippets_service_slogan                      = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_slogan',true);
        $seopress_pro_rich_snippets_service_street_addr                 = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_street_addr',true);
        $seopress_pro_rich_snippets_service_city                        = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_city',true);
        $seopress_pro_rich_snippets_service_state                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_state',true);
        $seopress_pro_rich_snippets_service_pc                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_pc',true);
        $seopress_pro_rich_snippets_service_country                     = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_country',true);
        $seopress_pro_rich_snippets_service_lat                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_lat',true);
        $seopress_pro_rich_snippets_service_lon                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_lon',true);
        $seopress_pro_rich_snippets_service_tel                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_tel',true);
        $seopress_pro_rich_snippets_service_price                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_service_price',true);

        //Review
        $seopress_pro_rich_snippets_review_item                         = get_post_meta($post->ID,'_seopress_pro_rich_snippets_review_item',true);
        $seopress_pro_rich_snippets_review_item_type                    = get_post_meta($post->ID,'_seopress_pro_rich_snippets_review_item_type',true);
        $seopress_pro_rich_snippets_review_img                          = get_post_meta($post->ID,'_seopress_pro_rich_snippets_review_img',true);
        $seopress_pro_rich_snippets_review_rating                       = get_post_meta($post->ID,'_seopress_pro_rich_snippets_review_rating',true);

        //Custom
        $seopress_pro_rich_snippets_custom                              = get_post_meta($post->ID,'_seopress_pro_rich_snippets_custom',true);


    echo 
    '<div id="seopress-schemas-tabs">
        <ul class="wrap-schemas-list">
            <li><a href="#seopress-schemas-tabs-2">'. __( 'Automatic', 'wp-seopress' ) .'</a></li>
            <li><a href="#seopress-schemas-tabs-1">'. __( 'Manual', 'wp-seopress' ) .'</a></li>
        </ul>

        <div id="seopress-schemas-tabs-1">
            <div class="box-left">
                <div class="wrap-rich-snippets-type">
                    <label for="seopress_pro_rich_snippets_type_meta">'. __( 'Select your data type', 'wp-seopress-pro' ) .'</label>
                    <select id="seopress_pro_rich_snippets_type" name="seopress_pro_rich_snippets_type">
                        <option ' . selected( 'none', $seopress_pro_rich_snippets_type, false ) . ' value="none">'. __( 'None', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'articles', $seopress_pro_rich_snippets_type, false ) . ' value="articles">'. __( 'Article', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'localbusiness', $seopress_pro_rich_snippets_type, false ) . ' value="localbusiness">'. __( 'Local Business', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'faq', $seopress_pro_rich_snippets_type, false ) . ' value="faq">'. __( 'FAQ', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'courses', $seopress_pro_rich_snippets_type, false ) . ' value="courses">'. __( 'Course', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'recipes', $seopress_pro_rich_snippets_type, false ) . ' value="recipes">'. __( 'Recipe', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'jobs', $seopress_pro_rich_snippets_type, false ) . ' value="jobs">'. __( 'Job', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'videos', $seopress_pro_rich_snippets_type, false ) . ' value="videos">'. __( 'Video', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'events', $seopress_pro_rich_snippets_type, false ) . ' value="events">'. __( 'Event', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'products', $seopress_pro_rich_snippets_type, false ) . ' value="products">'. __( 'Product', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'services', $seopress_pro_rich_snippets_type, false ) . ' value="services">'. __( 'Service', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'review', $seopress_pro_rich_snippets_type, false ) . ' value="review">'. __( 'Review', 'wp-seopress-pro' ) .'</option>
                        <option ' . selected( 'custom', $seopress_pro_rich_snippets_type, false ) . ' value="custom">'. __( 'Custom', 'wp-seopress-pro' ) .'</option>
                    </select>';

                if (seopress_advanced_appearance_advice_schema_option() !='1') {
                    echo '<ul class="advice">
                        <li class="warning"><span class="dashicons dashicons-warning"></span>'.__('WARNING','wp-seopress-pro').'</li>
                        <li>'.__('Be sure to select the right structure data type for your content.','wp-seopress-pro').'</li>
                        <li>'.__('When you choose one, fill all fields with the right format.','wp-seopress-pro').'</li>
                        <li>'.__('Make sure you don\'t have already included structured data type with a theme or plugin (eg: the default WooCommerce Theme, Storefront, already implements this for single page products).','wp-seopress-pro').'</li>
                        <li>'.__('You can test your page with Google Data Structure Test tool.','wp-seopress-pro').' <a href="https://search.google.com/structured-data/testing-tool" target="_blank">'.__('Make a test','wp-seopress-pro').'</a></li>
                    </ul>';
                }
                echo '</div>
                <div class="wrap-rich-snippets-articles">
                    <p class="notice">
                        '.__('Proper structured data in your news, blog, and sports article page can enhance your appearance in Google Search results.','wp-seopress-pro').'
                    </p>';
                if (seopress_rich_snippets_publisher_logo_option() !='') {
                    echo '<p><span class="dashicons dashicons-yes"></span>'.__('You have set a publisher logo. Good!','wp-seopress-pro').'</p>';
                } else {
                    echo '<p><span class="dashicons dashicons-no-alt"></span>'.__('You don\'t have set a publisher logo. It\'s required for Article content types.','wp-seopress-pro').'</p>';
                }

                echo'
                    <p>
                        <label for="seopress_pro_rich_snippets_article_type_meta">'. __( 'Select your article type', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_article_type">
                            <option ' . selected( 'NewsArticle', $seopress_pro_rich_snippets_article_type, false ) . ' value="NewsArticle">'. __( 'News Article', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Report', $seopress_pro_rich_snippets_article_type, false ) . ' value="Report">'. __( 'Report', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ScholarlyArticle', $seopress_pro_rich_snippets_article_type, false ) . ' value="ScholarlyArticle">'. __( 'Scholarly Article', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SocialMediaPosting', $seopress_pro_rich_snippets_article_type, false ) . ' value="SocialMediaPosting">'. __( 'Social Media Posting', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'BlogPosting', $seopress_pro_rich_snippets_article_type, false ) . ' value="BlogPosting">'. __( 'Blog Posting', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'TechArticle', $seopress_pro_rich_snippets_article_type, false ) . ' value="TechArticle">'. __( 'TechArticle', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p style="margin-bottom:0">
                        <label for="seopress_pro_rich_snippets_article_title_meta">
                            '. __( 'Headline <em>(max limit: 110)</em>', 'wp-seopress-pro' ) .'</label>
                            '.__('Default value if empty: Post title','wp-seopress-pro').'
                        <input type="text" id="seopress_pro_rich_snippets_article_title" name="seopress_pro_rich_snippets_article_title" placeholder="'.esc_html__('The headline of the article','wp-seopress-pro').'" aria-label="'.__('Headline <em>(max limit: 110)</em>','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_article_title.'" />
                        <div class="wrap-seopress-counters">
                            <div id="seopress_rich_snippets_articles_counters"></div>
                            '.__('(maximum limit)','wp-seopress-pro').'
                        </div>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_article_img_meta">'. __( 'Image', 'wp-seopress-pro' ) .'</label>
                        '.__('The representative image of the article. Only a marked-up image that directly belongs to the article should be specified. ','wp-seopress-pro').'<br>
                        '.__('Default value if empty: Post thumbnail (featured image)','wp-seopress-pro').'
                        <span class="advise">'. __('Minimum size: 696px wide, JPG, PNG or GIF, crawlable and indexable (default: post thumbnail if available)', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_article_img_meta" type="text" name="seopress_pro_rich_snippets_article_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_article_img.'" />
                        <input id="seopress_pro_rich_snippets_article_img_width" type="hidden" name="seopress_pro_rich_snippets_article_img_width" value="'.$seopress_pro_rich_snippets_article_img_width.'" />
                        <input id="seopress_pro_rich_snippets_article_img_height" type="hidden" name="seopress_pro_rich_snippets_article_img_height" value="'.$seopress_pro_rich_snippets_article_img_height.'" />
                        <input id="seopress_pro_rich_snippets_article_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-local-business">
                    <p class="notice">
                        '.__('When users search for businesses on Google Search or Maps, Search results may display a prominent Knowledge Graph card with details about a business that matched the query. ','wp-seopress-pro').'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_name_meta">
                            '. __( 'Name of your business', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_name" placeholder="'.esc_html__('eg: SEOPress','wp-seopress-pro').'" aria-label="'.__('Name of your business','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_type_meta">'. __( 'Select a business type', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_lb_type">';

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
                            echo '<option ' . selected( $type_value, $seopress_pro_rich_snippets_lb_type, false ) . ' value="'.$type_value.'">'. __( $type_i18n, 'wp-seopress-pro' ) .'</option>';
                        }
                echo '</select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_img_meta">'. __( 'Image', 'wp-seopress-pro' ) .'</label>
                        <p>'.__('An image of the business.','wp-seopress-pro').'</p>
                        <span class="advise">'. __('Every page must contain at least one image (whether or not you include markup). Google will pick the best image to display in Search results based on the aspect ratio and resolution.<br>
Image URLs must be crawlable and indexable.<br>
Images must represent the marked up content.<br>
Images must be in .jpg, .png, or. gif format.<br>
For best results, provide multiple high-resolution images (minimum of 50K pixels when multiplying width and height) with the following aspect ratios: 16x9, 4x3, and 1x1.', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_lb_img_meta" type="text" name="seopress_pro_rich_snippets_lb_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_img.'" />
                        <input id="seopress_pro_rich_snippets_lb_img_width" type="hidden" name="seopress_pro_rich_snippets_lb_img_width" value="'.$seopress_pro_rich_snippets_lb_img_width.'" />
                        <input id="seopress_pro_rich_snippets_lb_img_height" type="hidden" name="seopress_pro_rich_snippets_lb_img_height" value="'.$seopress_pro_rich_snippets_lb_img_height.'" />
                        <input id="seopress_pro_rich_snippets_lb_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_street_addr_meta">
                            '. __( 'Street Address', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_street_addr" placeholder="'.esc_html__('eg: Place Bellevue','wp-seopress-pro').'" aria-label="'.__('Street Address','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_street_addr.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_city_meta">
                            '. __( 'City', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_city" placeholder="'.esc_html__('eg: Biarritz','wp-seopress-pro').'" aria-label="'.__('City','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_city.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_state_meta">
                            '. __( 'State', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_state" placeholder="'.esc_html__('eg: Pyrenees Atlantiques','wp-seopress-pro').'" aria-label="'.__('State','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_state.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_pc_meta">
                            '. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_pc" placeholder="'.esc_html__('eg: 64200','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_pc.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_country_meta">
                            '. __( 'Country', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_country" placeholder="'.esc_html__('eg: France','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_country.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_lat_meta">
                            '. __( 'Latitude', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_lat" placeholder="'.esc_html__('eg: 43.4831389','wp-seopress-pro').'" aria-label="'.__('Latitude','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_lat.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_lon_meta">
                            '. __( 'Longitude', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_lon" placeholder="'.esc_html__('eg: -1.5630987','wp-seopress-pro').'" aria-label="'.__('Longitude','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_lon.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_website_meta">
                            '. __( 'URL', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_website" placeholder="'.get_home_url().'" aria-label="'.__('URL','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_website.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_tel_meta">
                            '. __( 'Telephone', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_tel" placeholder="'.esc_html__('eg: +33559240138','wp-seopress-pro').'" aria-label="'.__('Telephone','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_tel.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_price_meta">
                            '. __( 'Price range', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_lb_price" placeholder="'.esc_html__('eg: $$, €€€, or ££££...','wp-seopress-pro').'" aria-label="'.__('Price','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_lb_price.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_lb_opening_hours_meta">
                            '. __( 'Opening hours', 'wp-seopress-pro' ) .'</label>
                    </p>';

                    $options = $seopress_pro_rich_snippets_lb_opening_hours;
                    
                    $days = array(__('Monday','wp-seopress-pro'), __('Tuesday','wp-seopress-pro'), __('Wednesday','wp-seopress-pro'), __('Thursday','wp-seopress-pro'), __('Friday','wp-seopress-pro'), __('Saturday','wp-seopress-pro'), __('Sunday','wp-seopress-pro') );

                    $hours = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');

                    $mins = array('00', '15', '30', '45', '59');

                    echo '<ul class="wrap-opening-hours">';

                    foreach ($days as $key => $day) {

                        $check_day = isset($options[0]['seopress_local_business_opening_hours'][$key]['open']);
                        
                        $check_day_am = isset($options[0]['seopress_local_business_opening_hours'][$key]['am']['open']);

                        $check_day_pm = isset($options[0]['seopress_local_business_opening_hours'][$key]['pm']['open']);

                        $selected_start_hours = isset($options[0]['seopress_local_business_opening_hours'][$key]['am']['start']['hours']) ? $options[0]['seopress_local_business_opening_hours'][$key]['am']['start']['hours'] : NULL;

                        $selected_start_mins = isset($options[0]['seopress_local_business_opening_hours'][$key]['am']['start']['mins']) ? $options[0]['seopress_local_business_opening_hours'][$key]['am']['start']['mins'] : NULL;
                        
                        echo '<li>';

                            echo '<span class="day"><strong>'.$day.'</strong></span>';

                            echo '<ul>';
                                 //Closed?
                                echo '<li>';

                                    echo '<input id="seopress_local_business_opening_hours['.$key.'][open]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][open]" type="checkbox"';
                                        if ('1' == $check_day) echo 'checked="yes"'; 
                                        echo ' value="1"/>';
                                    
                                    echo '<label for="seopress_local_business_opening_hours['.$key.'][open]">'. __( 'Closed all the day?', 'wp-seopress-pro' ) .'</label> ';
                                    
                                    if (isset($options['seopress_local_business_opening_hours'][$key]['open'])) {
                                        esc_attr($options['seopress_local_business_opening_hours'][$key]['open']);
                                    }
                                echo '</li>';

                                //AM
                                echo '<li>';
                                    echo '<input id="seopress_local_business_opening_hours['.$key.'][am][open]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][am][open]" type="checkbox"';
                                        if ('1' == $check_day_am) echo 'checked="yes"'; 
                                        echo ' value="1"/>';                            
                                    
                                    echo '<label for="seopress_local_business_opening_hours['.$key.'][am][open]">'. __( 'Open in the morning?', 'wp-seopress-pro' ) .'</label> ';

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['am']['open'])) {
                                        esc_attr($options['seopress_local_business_opening_hours'][$key]['am']['open']);
                                    }

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][am][start][hours]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][am][start][hours]">';

                                        foreach ($hours as $hour) {
                                            echo '<option '; 
                                            if ($hour == $selected_start_hours) echo 'selected="selected"'; 
                                            echo ' value="'.$hour.'">'. $hour .'</option>';
                                        }

                                    echo '</select>';

                                    echo ' : ';

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][am][start][mins]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][am][start][mins]">';

                                        foreach ($mins as $min) {
                                            echo '<option '; 
                                            if ($min == $selected_start_mins) echo 'selected="selected"'; 
                                            echo ' value="'.$min.'">'. $min .'</option>';
                                        }

                                    echo '</select>';

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['am']['start']['hours'])) {
                                        esc_attr( $options['seopress_local_business_opening_hours'][$key]['am']['start']['hours']);
                                    }

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['am']['start']['mins'])) {
                                        esc_attr( $options['seopress_local_business_opening_hours'][$key]['am']['start']['mins']);
                                    }

                                    echo ' - ';

                                    $selected_end_hours = isset($options[0]['seopress_local_business_opening_hours'][$key]['am']['end']['hours']) ? $options[0]['seopress_local_business_opening_hours'][$key]['am']['end']['hours'] : NULL;

                                    $selected_end_mins = isset($options[0]['seopress_local_business_opening_hours'][$key]['am']['end']['mins']) ? $options[0]['seopress_local_business_opening_hours'][$key]['am']['end']['mins'] : NULL;

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][am][end][hours]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][am][end][hours]">';

                                        foreach ($hours as $hour) {
                                            echo '<option '; 
                                            if ($hour == $selected_end_hours) echo 'selected="selected"'; 
                                            echo ' value="'.$hour.'">'. $hour .'</option>';
                                        }

                                    echo '</select>';

                                    echo ' : ';

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][am][end][mins]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][am][end][mins]">';

                                        foreach ($mins as $min) {
                                            echo '<option '; 
                                            if ($min == $selected_end_mins) echo 'selected="selected"'; 
                                            echo ' value="'.$min.'">'. $min .'</option>';
                                        }

                                    echo '</select>';
                                echo '</li>';
                                
                                //PM
                                echo '<li>';
                                    $selected_start_hours2 = isset($options[0]['seopress_local_business_opening_hours'][$key]['pm']['start']['hours']) ? $options[0]['seopress_local_business_opening_hours'][$key]['pm']['start']['hours'] : NULL;

                                    $selected_start_mins2 = isset($options[0]['seopress_local_business_opening_hours'][$key]['pm']['start']['mins']) ? $options[0]['seopress_local_business_opening_hours'][$key]['pm']['start']['mins'] : NULL;

                                    echo '<input id="seopress_local_business_opening_hours['.$key.'][pm][open]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][pm][open]" type="checkbox"';
                                        if ('1' == $check_day_pm) echo 'checked="yes"'; 
                                        echo ' value="1"/>';

                                    echo '<label for="seopress_local_business_opening_hours['.$key.'][pm][open]">'. __( 'Open in the afternoon?', 'wp-seopress-pro' ) .'</label> ';

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['pm']['open'])) {
                                        esc_attr($options['seopress_local_business_opening_hours'][$key]['pm']['open']);
                                    }

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][pm][start][hours]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][pm][start][hours]">';

                                        foreach ($hours as $hour) {
                                            echo '<option '; 
                                            if ($hour == $selected_start_hours2) echo 'selected="selected"'; 
                                            echo ' value="'.$hour.'">'. $hour .'</option>';
                                        }

                                    echo '</select>';

                                    echo ' : ';

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][pm][start][mins]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][pm][start][mins]">';

                                        foreach ($mins as $min) {
                                            echo '<option '; 
                                            if ($min == $selected_start_mins2) echo 'selected="selected"'; 
                                            echo ' value="'.$min.'">'. $min .'</option>';
                                        }

                                    echo '</select>';

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['pm']['start']['hours'])) {
                                        esc_attr( $options['seopress_local_business_opening_hours'][$key]['pm']['start']['hours']);
                                    }

                                    if (isset($options['seopress_local_business_opening_hours'][$key]['pm']['start']['mins'])) {
                                        esc_attr( $options['seopress_local_business_opening_hours'][$key]['pm']['start']['mins']);
                                    }

                                    echo ' - ';

                                    $selected_end_hours2 = isset($options[0]['seopress_local_business_opening_hours'][$key]['pm']['end']['hours']) ? $options[0]['seopress_local_business_opening_hours'][$key]['pm']['end']['hours'] : NULL;

                                    $selected_end_mins2 = isset($options[0]['seopress_local_business_opening_hours'][$key]['pm']['end']['mins']) ? $options[0]['seopress_local_business_opening_hours'][$key]['pm']['end']['mins'] : NULL;

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][pm][end][hours]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][pm][end][hours]">';

                                        foreach ($hours as $hour) {
                                            echo '<option '; 
                                            if ($hour == $selected_end_hours2) echo 'selected="selected"'; 
                                            echo ' value="'.$hour.'">'. $hour .'</option>';
                                        }

                                    echo '</select>';

                                    echo ' : ';

                                    echo '<select id="seopress_local_business_opening_hours['.$key.'][pm][end][mins]" name="seopress_pro_rich_snippets_lb_opening_hours[seopress_local_business_opening_hours]['.$key.'][pm][end][mins]">';

                                        foreach ($mins as $min) {
                                            echo '<option '; 
                                            if ($min == $selected_end_mins2) echo 'selected="selected"'; 
                                            echo ' value="'.$min.'">'. $min .'</option>';
                                        }

                                    echo '</select>';

                                echo '</li>';
                            echo '</ul>';

                        if (isset($options['seopress_local_business_opening_hours'][$key]['pm']['end']['hours'])) {
                            esc_attr( $options['seopress_local_business_opening_hours'][$key]['pm']['end']['hours']);
                        }

                        if (isset($options['seopress_local_business_opening_hours'][$key]['pm']['end']['mins'])) {
                            esc_attr( $options['seopress_local_business_opening_hours'][$key]['pm']['end']['mins']);
                        }

                        $seopress_pro_rich_snippets_lb_opening_hours = $options;
                    }

                    echo '</ul>
                </div>
                <div class="wrap-rich-snippets-faq">
                    <p class="notice">
                        '.__('Mark up your Frequently Asked Questions page with JSON-LD to try to get the position 0 in search results. ','wp-seopress-pro').'
                    </p>';

                    //Init $seopress_faq array if empty
                    if (empty($seopress_pro_rich_snippets_faq)) {
                        $seopress_pro_rich_snippets_faq = array('0' => array(''));
                    }

                    $count = $seopress_pro_rich_snippets_faq[0];
                    end($count);
                    $total = key($count);

                    echo '<div id="wrap-faq" data-count="'.$total.'">';
                            foreach ($seopress_pro_rich_snippets_faq[0] as $key => $value) {
                                $check_question = isset($seopress_pro_rich_snippets_faq[0][$key]["question"]) ? esc_attr($seopress_pro_rich_snippets_faq[0][$key]["question"]) : NULL;
                                $check_answer = isset($seopress_pro_rich_snippets_faq[0][$key]["answer"]) ? esc_textarea($seopress_pro_rich_snippets_faq[0][$key]["answer"]) : NULL;
                                
                            echo '<div class="faq">
                                    <h3 class="accordion-section-title" tabindex="0">'.__('Question ','wp-seopress-pro').$check_question.'</h3>
                                    <div class="accordion-section-content">
                                        <div class="inside">
                                            <p>
                                                <label for="seopress_pro_rich_snippets_faq['.$key.'][question_meta]">'. __( 'Question (required)', 'wp-seopress-pro' ) .'</label>
                                                <input id="seopress_pro_rich_snippets_faq['.$key.'][question_meta]" type="text" name="seopress_pro_rich_snippets_faq['.$key.'][question]" placeholder="'.esc_html__('Enter your question','wp-seopress-pro').'" aria-label="'.__('Question','wp-seopress-pro').'" value="'.$check_question.'" />
                                            </p>
                                            <p>
                                                <label for="seopress_pro_rich_snippets_faq['.$key.'][answer_meta]">'. __( 'Answer (required)', 'wp-seopress-pro' ) .'</label>
                                                <textarea id="seopress_pro_rich_snippets_faq['.$key.'][answer_meta]" name="seopress_pro_rich_snippets_faq['.$key.'][answer]" placeholder="'.esc_html__('Enter your answer','wp-seopress-pro').'" aria-label="'.__('Answer','wp-seopress-pro').'" value="'.$check_answer.'" rows="8">'.$check_answer.'</textarea>
                                            </p> 
                                            
                                            <p><a href="#" class="remove-faq button">'.__('Remove question','wp-seopress-pro').'</a></p>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                   echo '</div>
                   <p><a href="#" id="add-faq" class="add-faq button button-primary">'.__('Add question','wp-seopress-pro').'</a></p>
                </div>
                <div class="wrap-rich-snippets-courses">
                    <p class="notice">
                        '.__('Mark up your course lists with structured data so prospective students find you through Google Search. ','wp-seopress-pro').'
                    </p>
                    <ul>
                        <li>'.__('Only use course markup for educational content that fits the following definition of a course: A series or unit of curriculum that contains lectures, lessons, or modules in a particular subject and/or topic.','wp-seopress-pro').'</li>
                        <li>'.__('A course must have an explicit educational outcome of knowledge and/or skill in a particular subject and/or topic, and be led by one or more instructors with a roster of students.','wp-seopress-pro').'</li>
                        <li>'.__('A general public event such as "Astronomy Day" is not a course, and a single 2-minute "How to make a Sandwich Video" is not a course.','wp-seopress-pro').'</li>
                    </ul>
                    <p>
                        <label for="seopress_pro_rich_snippets_courses_title_meta">
                            '. __( 'Title', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_courses_title" placeholder="'.esc_html__('The title of your lesson, course...','wp-seopress-pro').'" aria-label="'.__('Title','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_courses_title.'" />
                    </p>
                    <p style="margin-bottom:0">
                        <label for="seopress_pro_rich_snippets_courses_desc_meta">'. __( 'Course description', 'wp-seopress-pro' ) .'</label>
                        <textarea id="seopress_pro_rich_snippets_courses_desc" style="width:100%" name="seopress_pro_rich_snippets_courses_desc" placeholder="'.esc_html__('Enter your course/lesson description','wp-seopress-pro').'" aria-label="'.__('Course description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_courses_desc.'">'.$seopress_pro_rich_snippets_courses_desc.'</textarea>
                        <div class="wrap-seopress-counters">
                            <div id="seopress_rich_snippets_courses_counters"></div>
                            '.__('(maximum limit)','wp-seopress-pro').'
                        </div>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_courses_school_meta">
                            '. __( 'School/Organization', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_courses_school" placeholder="'.esc_html__('Name of university, organization...','wp-seopress-pro').'" aria-label="'.__('School/Organization','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_courses_school.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_courses_website_meta">
                            '. __( 'School/Organization Website', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_courses_website" placeholder="'.esc_html__('Enter the URL like https://example.com/','wp-seopress-pro').'" aria-label="'.__('School/Organization Website','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_courses_website.'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-recipes">
                    <p class="notice">
                        '.__('Mark up your recipe content with structured data to provide rich cards and host-specific lists for your recipes, such as cooking and preparation times, nutrition information...','wp-seopress-pro').'
                    </p>
                    <ul>
                        <li>'.__('Use recipe markup for content about preparing a particular dish. For example, "facial scrub" or "party ideas" are not valid names for a dish.','wp-seopress-pro').'</li>
                    </ul>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_name_meta">
                            '. __( 'Recipe name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_recipes_name" placeholder="'.esc_html__('The name of your dish','wp-seopress-pro').'" aria-label="'.__('Recipe name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_desc_meta">'. __( 'Short recipe description', 'wp-seopress-pro' ) .'</label>
                        <textarea id="seopress_pro_rich_snippets_recipes_desc_meta" style="width:100%" name="seopress_pro_rich_snippets_recipes_desc" placeholder="'.esc_html__('A short summary describing the dish.','wp-seopress-pro').'" aria-label="'.__('Short recipe description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_desc.'">'.$seopress_pro_rich_snippets_recipes_desc.'</textarea>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_cat_meta">
                            '. __( 'Recipe category', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_recipes_cat" placeholder="'.esc_html__('Eg: appetizer, entree, or dessert','wp-seopress-pro').'" aria-label="'.__('Recipe category','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_cat.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_img_meta">'. __( 'Image', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Minimum size: 185px by 185px, aspect ratio 1:1', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_recipes_img_meta" type="text" name="seopress_pro_rich_snippets_recipes_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_img.'" />
                        <input id="seopress_pro_rich_snippets_recipes_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_prep_time_meta">
                            '. __( 'Preparation time (in minutes)', 'wp-seopress-pro' ) .'</label>
                        <input type="number" name="seopress_pro_rich_snippets_recipes_prep_time" placeholder="'.esc_html__('Eg: 30 min','wp-seopress-pro').'" aria-label="'.__('Preparation time (in minutes)','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_prep_time.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_cook_time_meta">
                            '. __( 'Cooking time (in minutes)', 'wp-seopress-pro' ) .'</label>
                        <input type="number" name="seopress_pro_rich_snippets_recipes_cook_time" placeholder="'.esc_html__('Eg: 45 min','wp-seopress-pro').'" aria-label="'.__('Cooking time (in minutes)','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_cook_time.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_calories_meta">
                            '. __( 'Calories', 'wp-seopress-pro' ) .'</label>
                        <input type="number" name="seopress_pro_rich_snippets_recipes_calories" placeholder="'.esc_html__('Number of calories','wp-seopress-pro').'" aria-label="'.__('Calories','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_calories.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_yield_meta">
                            '. __( 'Recipe yield', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_recipes_yield" placeholder="'.esc_html__('Eg: number of people served, or number of servings','wp-seopress-pro').'" aria-label="'.__('Recipe yield','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_yield.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_keywords_meta">
                            '. __( 'Keywords', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_recipes_keywords" placeholder="'.esc_html__('Eg: winter apple pie, nutmeg crust (NOT recommended: dessert, American)','wp-seopress-pro').'" aria-label="'.__('Keywords','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_keywords.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_cuisine_meta">
                            '. __( 'Recipe cuisine', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_recipes_cuisine" placeholder="'.esc_html__('The region associated with your recipe. For example, "French", Mediterranean", or "American".','wp-seopress-pro').'" aria-label="'.__('Recipe cuisine','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_cuisine.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_ingredient_meta">
                            '. __( 'Recipe ingredients', 'wp-seopress-pro' ) .'</label>
                        <textarea rows="12" name="seopress_pro_rich_snippets_recipes_ingredient" placeholder="'.esc_html__('Ingredients used in the recipe. One ingredient per line. Include only the ingredient text that is necessary for making the recipe. Don\'t include unnecessary information, such as a definition of the ingredient.','wp-seopress-pro').'" aria-label="'.__('Recipe ingredients','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_ingredient.'">'.$seopress_pro_rich_snippets_recipes_ingredient.'</textarea>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_recipes_instructions_meta">
                            '. __( 'Recipe instructions', 'wp-seopress-pro' ) .'</label>
                        <textarea rows="12" name="seopress_pro_rich_snippets_recipes_instructions" placeholder="'.esc_html__('eg: Heat oven to 425°F. Include only text on how to make the recipe and don\'t include other text such as "Directions", "Watch the video", "Step 1".','wp-seopress-pro').'" aria-label="'.__('Recipe instructions','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_recipes_instructions.'">'.$seopress_pro_rich_snippets_recipes_instructions.'</textarea>
                    </p>
                </div>
                <div class="wrap-rich-snippets-jobs">
                    <p class="notice">
                        '.__('Adding structured data makes your job postings eligible to appear in a special user experience in Google Search results.','wp-seopress-pro').'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_name_meta">
                            '. __( 'Job title', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_name" placeholder="'.esc_html__('The title of the job (not the title of the posting). For example, "Software Engineer" or "Barista".','wp-seopress-pro').'" aria-label="'.__('Job title','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_desc_meta">
                            '. __( 'Job description', 'wp-seopress-pro' ) .'</label>
                        <textarea rows="12" name="seopress_pro_rich_snippets_jobs_desc" placeholder="'.esc_html__('The full description of the job in HTML format.','wp-seopress-pro').'" aria-label="'.__('Job description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_desc.'">'.$seopress_pro_rich_snippets_jobs_desc.'</textarea>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_date_posted_meta">
                            '. __( 'Published date', 'wp-seopress-pro' ) .'</label>
                        <input type="text" id="seopress-date-picker4" class="seopress-date-picker" autocomplete="false" name="seopress_pro_rich_snippets_jobs_date_posted" placeholder="'.esc_html__('The original date that employer posted the job in ISO 8601 format. For example, "2017-01-24" or "2017-01-24T19:33:17+00:00".','wp-seopress-pro').'" aria-label="'.__('Published date','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_date_posted.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_valid_through_meta">
                            '. __( 'Expiration date', 'wp-seopress-pro' ) .'</label>
                        <input type="text" id="seopress-date-picker5" class="seopress-date-picker" autocomplete="false" name="seopress_pro_rich_snippets_jobs_valid_through" placeholder="'.esc_html__('The date when the job posting will expire in ISO 8601 format. For example, "2017-02-24" or "2017-02-24T19:33:17+00:00".','wp-seopress-pro').'" aria-label="'.__('Expiration date','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_valid_through.'" />
                    </p>
                    <p class="seopress_pro_rich_snippets_jobs_employment_type_p">
                        <label for="seopress_pro_rich_snippets_jobs_employment_type_meta">
                            '. __( 'Type of employment', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_employment_type" class="seopress_pro_rich_snippets_jobs_employment_type" placeholder="'.esc_html__('Type of employment, You can include more than one employmentType property.','wp-seopress-pro').'" aria-label="'.__('Type of employment','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_employment_type.'" />
                        
                        <span class="wrap-tags">';
                            echo '<span id="seopress-tag-employment-1" class="tag-title" data-tag="FULL_TIME"><span class="dashicons dashicons-plus"></span>'.__('FULL TIME','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-2" class="tag-title" data-tag="PART_TIME"><span class="dashicons dashicons-plus"></span>'.__('PART TIME','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-3" class="tag-title" data-tag="CONTRACTOR"><span class="dashicons dashicons-plus"></span>'.__('CONTRACTOR','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-4" class="tag-title" data-tag="TEMPORARY"><span class="dashicons dashicons-plus"></span>'.__('TEMPORARY','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-5" class="tag-title" data-tag="INTERN"><span class="dashicons dashicons-plus"></span>'.__('INTERN','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-6" class="tag-title" data-tag="VOLUNTEER"><span class="dashicons dashicons-plus"></span>'.__('VOLUNTEER','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-7" class="tag-title" data-tag="PER_DIEM"><span class="dashicons dashicons-plus"></span>'.__('PER_DIEM','wp-seopress-pro').'</span>';
                            echo '<span id="seopress-tag-employment-8" class="tag-title" data-tag="OTHER"><span class="dashicons dashicons-plus"></span>'.__('OTHER','wp-seopress-pro').'</span>';
                        echo '</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_identifier_name_meta">
                            '. __( 'Identifier name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_identifier_name" placeholder="'.esc_html__('The hiring organization\'s unique identifier name for the job','wp-seopress-pro').'" aria-label="'.__('Identifier name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_identifier_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_identifier_value_meta">
                            '. __( 'Identifier value', 'wp-seopress-pro' ) .'</label>
                        <input type="number" min="0" name="seopress_pro_rich_snippets_jobs_identifier_value" placeholder="'.esc_html__('The hiring organization\'s value identifier value for the job','wp-seopress-pro').'" aria-label="'.__('Identifier value','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_identifier_value.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_hiring_organization_meta">
                            '. __( 'Organization that hires', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Default: Organization name from your Knowledge Graph (SEO > Social Networks > Knowledge Graph)', 'wp-seopress-pro') .'</span>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_hiring_organization" placeholder="'.esc_html__('The organization offering the job position. This should be the name of the company.','wp-seopress-pro').'" aria-label="'.__('Organization that hires','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_hiring_organization.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_hiring_same_as_meta">
                            '. __( 'Organization website', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Default: URL of your site', 'wp-seopress-pro') .'</span>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_hiring_same_as" placeholder="'.esc_html__('The organization website URL offering the job position.','wp-seopress-pro').'" aria-label="'.__('Organization URL','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_hiring_same_as.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_hiring_logo_meta">'. __( 'Organization logo', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Default: Logo from your Knowledge Graph (SEO > Social Networks > Knowledge Graph)', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_jobs_hiring_logo_meta" type="text" name="seopress_pro_rich_snippets_jobs_hiring_logo" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Organization logo','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_hiring_logo.'" />
                        <input id="seopress_pro_rich_snippets_jobs_hiring_logo_width" type="hidden" name="seopress_pro_rich_snippets_jobs_hiring_logo_width" value="'.$seopress_pro_rich_snippets_jobs_hiring_logo_width.'" />
                        <input id="seopress_pro_rich_snippets_jobs_hiring_logo_height" type="hidden" name="seopress_pro_rich_snippets_jobs_hiring_logo_height" value="'.$seopress_pro_rich_snippets_jobs_hiring_logo_height.'" />
                        <input id="seopress_pro_rich_snippets_jobs_hiring_logo" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_address_street_meta">
                            '. __( 'Street address', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_address_street" placeholder="'.esc_html__('Street address','wp-seopress-pro').'" aria-label="'.__('Street address','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_address_street.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_address_locality_meta">
                            '. __( 'Locality address', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_address_locality" placeholder="'.esc_html__('Locality address','wp-seopress-pro').'" aria-label="'.__('Locality address','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_address_locality.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_address_region_meta">
                            '. __( 'Region', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_address_region" placeholder="'.esc_html__('Region','wp-seopress-pro').'" aria-label="'.__('Region','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_address_region.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_postal_code_meta">
                            '. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_postal_code" placeholder="'.esc_html__('Postal code','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_postal_code.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_country_meta">
                            '. __( 'Country', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_country" placeholder="'.esc_html__('Country','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_country.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_remote_meta">
                            '. __( 'Remote job?', 'wp-seopress-pro' ) .'</label>
                            <input type="checkbox" name="seopress_pro_rich_snippets_jobs_remote" aria-label="'.__('Remote job','wp-seopress-pro').'"';
                            if ('1' == $seopress_pro_rich_snippets_jobs_remote) echo 'checked="yes"'; 
                                        echo ' value="1"/>';
                    echo '</p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_salary_meta">
                            '. __( 'Salary', 'wp-seopress-pro' ) .'</label>
                        <input type="number" step="0.01" min="0" name="seopress_pro_rich_snippets_jobs_salary" placeholder="'.esc_html__('eg: 50.00','wp-seopress-pro').'" aria-label="'.__('Currency','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_salary.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_salary_currency_meta">
                            '. __( 'Currency', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_jobs_salary_currency" placeholder="'.esc_html__('eg: USD','wp-seopress-pro').'" aria-label="'.__('Currency','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_jobs_salary_currency.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_jobs_salary_unit_meta">'. __( 'Select your unit text', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_jobs_salary_unit">
                            <option ' . selected( 'HOUR', $seopress_pro_rich_snippets_jobs_salary_unit, false ) . ' value="HOUR">'. __( 'HOUR', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DAY', $seopress_pro_rich_snippets_jobs_salary_unit, false ) . ' value="DAY">'. __( 'DAY', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'WEEK', $seopress_pro_rich_snippets_jobs_salary_unit, false ) . ' value="WEEK">'. __( 'WEEK', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MONTH', $seopress_pro_rich_snippets_jobs_salary_unit, false ) . ' value="MONTH">'. __( 'MONTH', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'YEAR', $seopress_pro_rich_snippets_jobs_salary_unit, false ) . ' value="YEAR">'. __( 'YEAR', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                </div>
                <div class="wrap-rich-snippets-videos">
                    <p class="notice">
                        '.__('Mark up your video content with structured data to make Google Search an entry point for discovering and watching videos. ','wp-seopress-pro').'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_videos_name_meta">
                            '. __( 'Video name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_videos_name" placeholder="'.esc_html__('The title of your video','wp-seopress-pro').'" aria-label="'.__('Video name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_videos_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_videos_description_meta">'. __( 'Video description', 'wp-seopress-pro' ) .'</label>
                        <textarea id="seopress_pro_rich_snippets_videos_description_meta" style="width:100%" name="seopress_pro_rich_snippets_videos_description" placeholder="'.esc_html__('The description of the video','wp-seopress-pro').'" aria-label="'.__('Video description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_videos_description.'">'.$seopress_pro_rich_snippets_videos_description.'</textarea>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_videos_img_meta">'. __( 'Video thumbnail', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Minimum size: 160px by 90px - Max size: 1920x1080px - crawlable and indexable', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_videos_img_meta" type="text" name="seopress_pro_rich_snippets_videos_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Video thumbnail','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_videos_img.'" />
                        <input id="seopress_pro_rich_snippets_videos_img_width" type="hidden" name="seopress_pro_rich_snippets_videos_img_width" value="'.$seopress_pro_rich_snippets_videos_img_width.'" />
                        <input id="seopress_pro_rich_snippets_videos_img_height" type="hidden" name="seopress_pro_rich_snippets_videos_img_height" value="'.$seopress_pro_rich_snippets_videos_img_height.'" />
                        <input id="seopress_pro_rich_snippets_videos_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_videos_duration_meta">
                            '. __( 'Duration of your video (in minutes)', 'wp-seopress-pro' ) .'</label>
                        <input type="number" name="seopress_pro_rich_snippets_videos_duration" placeholder="'.esc_html__('eg: 120 min','wp-seopress-pro').'" aria-label="'.__('Duration of your video (in minutes)','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_videos_duration.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_videos_url_meta">
                            '. __( 'Video URL', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_videos_url" placeholder="'.esc_html__('Eg: https://example.com/video.mp4','wp-seopress-pro').'" aria-label="'.__('Video URL','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_videos_url.'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-events">
                    <p class="notice">
                        '.__('Event markup describes the details of organized events. When you use it in your content, that event becomes relevant for enhanced search results for relevant queries.','wp-seopress-pro').'
                    </p>
                    <ul>
                        <li>'.__('<strong>Expired events.</strong> Events data for any feature will never be shown for expired events. However, you do not have to remove markup for expired events.','wp-seopress-pro').'</li>
                        <li>'.__('<strong>Indicate the performer.</strong> Each event item must specify a performer property corresponding to the event\'s performer; that is, a musician, musical group, presenter, actor, and so on.','wp-seopress-pro').'</li>
                        <li>'.__('<strong>Do not include promotional elements in the name.</strong>','wp-seopress-pro').'</li>
                            <ul class="sublist">
                                <li><span class="dashicons dashicons-no"></span>'.__('Promoting non-event products or services: "Trip package: San Diego/LA, 7 nights"','wp-seopress-pro').'</li>
                                <li><span class="dashicons dashicons-no"></span>'.__('Prices in event titles: "Music festival - only $10!" Instead, highlight ticket prices using the tickets property in your markup.','wp-seopress-pro').'</li>
                                <li><span class="dashicons dashicons-no"></span>'.__('Using a non-event for a title, such as: "Sale on dresses!"','wp-seopress-pro').'</li>
                                <li><span class="dashicons dashicons-no"></span>'.__('Discounts or purchase opportunties, such as: "Concert - buy your tickets now," or "Concert - 50 percent off until Saturday!"','wp-seopress-pro').'</li>
                            </ul>
                        <li>'.__('<strong>Multi-day events.</strong> If your event/ticket info is for the festival itself, specify both the start and end date of the festival. If your event/ticket info is for a specific performance that is part of the festival, specify the specific date of the performance. If the specific date is unavailable, specify both the start and end date of the festival.','wp-seopress-pro').'</li>
                    </ul>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_type_meta">'. __( 'Select your event type', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_events_type">
                            <option ' . selected( 'BusinessEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="BusinessEvent">'. __( 'Business Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ChildrensEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="ChildrensEvent">'. __( 'Children\'s Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ComedyEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="ComedyEvent">'. __( 'Comedy Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CourseInstance', $seopress_pro_rich_snippets_events_type, false ) . ' value="CourseInstance">'. __( 'Course Instance', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DanceEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="DanceEvent">'. __( 'Dance Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DeliveryEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="DeliveryEvent">'. __( 'Delivery Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'EducationEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="EducationEvent">'. __( 'Education Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ExhibitionEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="ExhibitionEvent">'. __( 'Exhibition Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Festival', $seopress_pro_rich_snippets_events_type, false ) . ' value="Festival">'. __( 'Festival', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'FoodEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="FoodEvent">'. __( 'Food Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'LiteraryEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="LiteraryEvent">'. __( 'Literary Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MusicEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="MusicEvent">'. __( 'Music Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PublicationEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="PublicationEvent">'. __( 'Publication Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SaleEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="SaleEvent">'. __( 'Sale Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ScreeningEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="ScreeningEvent">'. __( 'Screening Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SocialEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="SocialEvent">'. __( 'Social Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SportsEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="SportsEvent">'. __( 'Sports Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'TheaterEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="TheaterEvent">'. __( 'Theater Event', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'VisualArtsEvent', $seopress_pro_rich_snippets_events_type, false ) . ' value="VisualArtsEvent">'. __( 'Visual Arts Event', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_name_meta">
                            '. __( 'Event name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_name" placeholder="'.esc_html__('The name of your event','wp-seopress-pro').'" aria-label="'.__('Event name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_desc_meta">
                            '. __( 'Event description (default excerpt, or beginning of the content)', 'wp-seopress-pro' ) .'</label>
                        <textarea id="seopress_pro_rich_snippets_events_desc" style="width:100%" name="seopress_pro_rich_snippets_events_desc" placeholder="'.esc_html__('Enter your event description','wp-seopress-pro').'" aria-label="'.__('Event description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_desc.'">'.$seopress_pro_rich_snippets_events_desc.'</textarea>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_img_meta">'. __( 'Image thumbnail', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Minimum width: 720px - Recommended size: 1920px -  .jpg, .png, or. gif format - crawlable and indexable', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_events_img_meta" type="text" name="seopress_pro_rich_snippets_events_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Image thumbnail','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_img.'" />
                        <input id="seopress_pro_rich_snippets_events_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_start_date_meta">
                            '. __( 'Start date', 'wp-seopress-pro' ) .'</label>
                        <input type="text" id="seopress-date-picker1" class="seopress-date-picker" autocomplete="false" name="seopress_pro_rich_snippets_events_start_date" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('Start date','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_start_date.'" />
                    </p> 
                    <p>
                        <label for="seopress_pro_rich_snippets_events_start_time_meta">
                            '. __( 'Start time', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_start_time" placeholder="'.esc_html__('Eg: HH:MM','wp-seopress-pro').'" aria-label="'.__('Start time','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_start_time.'" />
                    </p>                
                    <p>
                        <label for="seopress_pro_rich_snippets_events_end_date_meta">
                            '. __( 'End date', 'wp-seopress-pro' ) .'</label>
                        <input type="text" id="seopress-date-picker2" class="seopress-date-picker" autocomplete="false" name="seopress_pro_rich_snippets_events_end_date" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('End date','wp-seopress-pro').'"  value="'.$seopress_pro_rich_snippets_events_end_date.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_end_time_meta">
                            '. __( 'End time', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_end_time" placeholder="'.esc_html__('Eg: HH:MM','wp-seopress-pro').'" aria-label="'.__('End time','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_end_time.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_location_name_meta">
                            '. __( 'Location name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_location_name" placeholder="'.esc_html__('Eg: Hotel du Palais','wp-seopress-pro').'" aria-label="'.__('Location name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_location_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_location_url_meta">
                            '. __( 'Location Website', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_location_url" placeholder="'.esc_html__('Eg: http://www.hotel-du-palais.com/','wp-seopress-pro').'" aria-label="'.__('Location Website','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_location_url.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_location_address_meta">
                            '. __( 'Location Address', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_location_address" placeholder="'.esc_html__('Eg: 1 Avenue de l\'Imperatrice, 64200 Biarritz','wp-seopress-pro').'" aria-label="'.__('Location Address','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_location_address.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_name_meta">
                            '. __( 'Offer name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_offers_name" aria-label="'.__('Offer name','wp-seopress-pro').'" placeholder="'.esc_html__('Eg: General admission','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_offers_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_cat_meta">'. __( 'Select your offer category', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_events_offers_cat">
                            <option ' . selected( 'Primary', $seopress_pro_rich_snippets_events_offers_cat, false ) . ' value="Primary">'. __( 'Primary', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Secondary', $seopress_pro_rich_snippets_events_offers_cat, false ) . ' value="Secondary">'. __( 'Secondary', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Presale', $seopress_pro_rich_snippets_events_offers_cat, false ) . ' value="Presale">'. __( 'Presale', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Premium', $seopress_pro_rich_snippets_events_offers_cat, false ) . ' value="Premium">'. __( 'Premium', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_price_meta">
                            '. __( 'Price', 'wp-seopress-pro' ) .'</label>
                            <p>'.__('The lowest available price, including service charges and fees, of this type of ticket.','wp-seopress-pro').'</p>
                        <input type="text" name="seopress_pro_rich_snippets_events_offers_price" placeholder="'.esc_html__('Eg: 10','wp-seopress-pro').'" aria-label="'.__('Price','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_offers_price.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_price_currency_meta">'. __( 'Select your currency', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_events_offers_price_currency">
                            <option ' . selected( 'none', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="none">'. __( 'Select a Currency', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'USD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="USD">'. __( 'U.S. Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'GBP', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="GBP">'. __( 'Pound Sterling', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'EUR', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="EUR">'. __( 'Euro', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ARS', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="ARS">'. __( 'Argentina Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'AUD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="AUD">'. __( 'Australian Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'BRL', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="BRL">'. __( 'Brazilian Real', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'BGN', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="BGN">'. __( 'Bulgarian lev', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CAD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="CAD">'. __( 'Canadian Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CLP', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="CLP">'. __( 'Chilean Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CZK', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="CZK">'. __( 'Czech Koruna', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DKK', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="DKK">'. __( 'Danish Krone', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'HKD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="HKD">'. __( 'Hong Kong Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'HUF', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="HUF">'. __( 'Hungarian Forint', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'INR', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="INR">'. __( 'Indian rupee', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ILS', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="ILS">'. __( 'Israeli New Sheqel', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'JPY', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="JPY">'. __( 'Japanese Yen', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MYR', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="MYR">'. __( 'Malaysian Ringgit', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MXN', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="MXN">'. __( 'Mexican Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'NOK', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="NOK">'. __( 'Norwegian Krone', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'NZD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="NZD">'. __( 'New Zealand Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PHP', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="PHP">'. __( 'Philippine Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PLN', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="PLN">'. __( 'Polish Zloty', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'IDR', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="IDR">'. __( 'Indonesian rupiah', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'RUB', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="RUB">'. __( 'Russian Ruble', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SGD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="SGD">'. __( 'Singapore Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ZAR', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="ZAR">'. __( 'South African Rand', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SEK', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="SEK">'. __( 'Swedish Krona', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CHF', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="CHF">'. __( 'Swiss Franc', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'TWD', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="TWD">'. __( 'Taiwan New Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'THB', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="THB">'. __( 'Thai Baht', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'UAH', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="UAH">'. __( 'Ukrainian hryvnia', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'VND', $seopress_pro_rich_snippets_events_offers_price_currency, false ) . ' value="VND">'. __( 'Vietnamese đồng', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_availability_meta">'. __( 'Availability', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_events_offers_availability">
                            <option ' . selected( 'InStock', $seopress_pro_rich_snippets_events_offers_availability, false ) . ' value="InStock">'. __( 'In Stock', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SoldOut', $seopress_pro_rich_snippets_events_offers_availability, false ) . ' value="SoldOut">'. __( 'Sold Out', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PreOrder', $seopress_pro_rich_snippets_events_offers_availability, false ) . ' value="PreOrder">'. __( 'Pre Order', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_rich_snippets_events_offers_valid_from_meta_date">'. __( 'Valid From', 'wp-seopress-pro' ) .'</label>
                        '.__('The date when tickets go on sale','wp-seopress-pro').'
                        <input type="text" id="seopress-date-picker3" class="seopress-date-picker" autocomplete="false" name="seopress_rich_snippets_events_offers_valid_from_date" aria-label="'.__('The date when tickets go on sale','wp-seopress-pro').'" value="'.$seopress_rich_snippets_events_offers_valid_from_date.'" />
                        <label for="seopress_rich_snippets_events_offers_valid_from_meta_time">'. __( 'Time', 'wp-seopress-pro' ) .'</label>
                        '.__('The time when tickets go on sale','wp-seopress-pro').'
                        <input type="time" name="seopress_rich_snippets_events_offers_valid_from_time" aria-label="'.__('The time when tickets go on sale','wp-seopress-pro').'" value="'.$seopress_rich_snippets_events_offers_valid_from_time.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_offers_url_meta">
                            '. __( 'Website to buy tickets', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_offers_url" placeholder="'.esc_html__('Eg: https://fnac.com/','wp-seopress-pro').'" aria-label="'.__('Website to buy tickets','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_offers_url.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_events_performer_meta">
                            '. __( 'Performer name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_events_performer" placeholder="'.esc_html__('Eg: Lana Del Rey','wp-seopress-pro').'" aria-label="'.__('Performer name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_events_performer.'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-products">
                    <p class="notice">
                        '.__('Add markup to your product pages so Google can provide detailed product information in rich Search results - including Image Search. Users can see price, availability... right on Search results.','wp-seopress-pro').'
                    </p>
                    <ul>
                        <li>'.__('<strong>Use markup for a specific product, not a category or list of products.</strong> For example, "shoes in our shop" is not a specific product.','wp-seopress-pro').'</li>
                        <li>'.__('<strong>Adult-related products are not supported.</strong>','wp-seopress-pro').'</li>
                        <li>'.__('<strong>Works best with WooCommerce: we automatically add aggregateRating properties from user reviews (you have to enable this option from WooCommerce settings).</strong>','wp-seopress-pro').'</li>
                    </ul>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_name_meta">
                            '. __( 'Product name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_product_name" placeholder="'.esc_html__('The name of your product','wp-seopress-pro').'" aria-label="'.__('Product name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_name.'" />
                        <span class="description">'.__('Default: product title','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_description_meta">'. __( 'Product description', 'wp-seopress-pro' ) .'</label>
                        <textarea id="seopress_pro_rich_snippets_product_description_meta" style="width:100%" name="seopress_pro_rich_snippets_product_description" placeholder="'.esc_html__('The description of the product','wp-seopress-pro').'" aria-label="'.__('Product description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_description.'">'.$seopress_pro_rich_snippets_product_description.'</textarea>
                            <span class="description">'.__('Default: product excerpt','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_img_meta">'. __( 'Thumbnail', 'wp-seopress-pro' ) .'</label>
                        <span class="advise">'. __('Pictures clearly showing the product, e.g. against a white background, are preferred.', 'wp-seopress-pro') .'</span>
                        <input id="seopress_pro_rich_snippets_product_img_meta" type="text" name="seopress_pro_rich_snippets_product_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Thumbnail','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_img.'" />
                        <input id="seopress_pro_rich_snippets_product_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                        <span class="description">'.__('Default: product image','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_price_meta">
                            '. __( 'Product price', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_product_price" placeholder="'.esc_html__('Eg: 30','wp-seopress-pro').'" aria-label="'.__('Product price','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_price.'" />
                        <span class="description">'.__('Default: active product price','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_price_valid_date_meta">
                            '. __( 'Product price valid until', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_product_price_valid_date" class="seopress-date-picker" placeholder="'.esc_html__('Eg: YYYY-MM-DD','wp-seopress-pro').'" aria-label="'.__('Product price valid until','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_price_valid_date.'" />
                        <span class="description">'.__('Default: sale price dates To field','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_sku_meta">
                            '. __( 'Product SKU', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_product_sku" placeholder="'.esc_html__('Eg: 0446310786','wp-seopress-pro').'" aria-label="'.__('Product SKU','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_sku.'" />
                        <span class="description">'.__('Default: product SKU','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_global_ids_meta">
                            '. __( 'Product Global Identifiers type', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_product_global_ids">
                            <option ' . selected( 'none', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="none">'. __( 'Select a global identifier', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'gtin8', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="gtin8">'. __( 'gtin8', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'gtin13', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="gtin13">'. __( 'gtin13', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'gtin14', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="gtin14">'. __( 'gtin14', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'mpn', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="mpn">'. __( 'mpn', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'isbn', $seopress_pro_rich_snippets_product_global_ids, false ) . ' value="isbn">'. __( 'isbn', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_global_ids_value_meta">
                            '. __( 'Product Global Identifier value', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_product_global_ids_value" placeholder="'.esc_html__('Eg: 925872','wp-seopress-pro').'" aria-label="'.__('Product Global Identifiers','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_product_global_ids_value.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_brand_meta">
                            '. __( 'Product Brand', 'wp-seopress-pro' ) .'</label>';

                            if (function_exists('seopress_get_taxonomies')) {
                                $seopress_get_taxonomies = seopress_get_taxonomies();
                                if (!empty(seopress_get_taxonomies())) {
                                    echo '<select name="seopress_pro_rich_snippets_product_brand">';
                                        echo '<option ' . selected( 'none', $seopress_pro_rich_snippets_product_brand, false ) . ' value="none">'. __( 'Select a taxonomy', 'wp-seopress-pro' ) .'</option>';
                                        
                                        foreach ($seopress_get_taxonomies as $key => $value) {
                                            echo '<option ' . selected( $key, $seopress_pro_rich_snippets_product_brand, false ) . ' value="'.$key.'">'. $key .'</option>';
                                        }
                                    echo '</select>';
                                }
                            }
                    echo '</p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_price_currency_meta">
                            '. __( 'Product currency', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_product_price_currency">
                            <option ' . selected( 'none', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="none">'. __( 'Select a Currency', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'USD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="USD">'. __( 'U.S. Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'GBP', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="GBP">'. __( 'Pound Sterling', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'EUR', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="EUR">'. __( 'Euro', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ARS', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="ARS">'. __( 'Argentina Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'AUD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="AUD">'. __( 'Australian Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'BRL', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="BRL">'. __( 'Brazilian Real', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'BGN', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="BGN">'. __( 'Bulgarian lev', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CAD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="CAD">'. __( 'Canadian Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CLP', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="CLP">'. __( 'Chilean Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CZK', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="CZK">'. __( 'Czech Koruna', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DKK', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="DKK">'. __( 'Danish Krone', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'HKD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="HKD">'. __( 'Hong Kong Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'HUF', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="HUF">'. __( 'Hungarian Forint', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'INR', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="INR">'. __( 'Indian rupee', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ILS', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="ILS">'. __( 'Israeli New Sheqel', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'JPY', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="JPY">'. __( 'Japanese Yen', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MYR', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="MYR">'. __( 'Malaysian Ringgit', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MXN', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="MXN">'. __( 'Mexican Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'NOK', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="NOK">'. __( 'Norwegian Krone', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'NZD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="NZD">'. __( 'New Zealand Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PHP', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="PHP">'. __( 'Philippine Peso', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PLN', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="PLN">'. __( 'Polish Zloty', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'IDR', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="IDR">'. __( 'Indonesian rupiah', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'RUB', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="RUB">'. __( 'Russian Ruble', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SGD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="SGD">'. __( 'Singapore Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'ZAR', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="ZAR">'. __( 'South African Rand', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SEK', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="SEK">'. __( 'Swedish Krona', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CHF', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="CHF">'. __( 'Swiss Franc', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'TWD', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="TWD">'. __( 'Taiwan New Dollar', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'THB', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="THB">'. __( 'Thai Baht', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'UAH', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="UAH">'. __( 'Ukrainian hryvnia', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'VND', $seopress_pro_rich_snippets_product_price_currency, false ) . ' value="VND">'. __( 'Vietnamese đồng', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_condition_meta">'. __( 'Product Condition', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_product_condition">
                            <option ' . selected( 'NewCondition', $seopress_pro_rich_snippets_product_condition, false ) . ' value="NewCondition">'. __( 'New', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'UsedCondition', $seopress_pro_rich_snippets_product_condition, false ) . ' value="UsedCondition">'. __( 'Used', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'DamagedCondition', $seopress_pro_rich_snippets_product_condition, false ) . ' value="DamagedCondition">'. __( 'Damaged', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'RefurbishedCondition', $seopress_pro_rich_snippets_product_condition, false ) . ' value="RefurbishedCondition">'. __( 'Refurbished', 'wp-seopress-pro' ) .'</option>
                        </select>
                        <span class="description">'.__('Default: new','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_product_availability_meta">'. __( 'Product Availability', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_product_availability">
                            <option ' . selected( 'InStock', $seopress_pro_rich_snippets_product_availability, false ) . ' value="InStock">'. __( 'In Stock', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'InStoreOnly', $seopress_pro_rich_snippets_product_availability, false ) . ' value="InStoreOnly">'. __( 'In Store Only', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'OnlineOnly', $seopress_pro_rich_snippets_product_availability, false ) . ' value="OnlineOnly">'. __( 'Online Only', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'LimitedAvailability', $seopress_pro_rich_snippets_product_availability, false ) . ' value="LimitedAvailability">'. __( 'Limited Availability', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'SoldOut', $seopress_pro_rich_snippets_product_availability, false ) . ' value="SoldOut">'. __( 'Sold Out', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'OutOfStock', $seopress_pro_rich_snippets_product_availability, false ) . ' value="OutOfStock">'. __( 'Out Of Stock', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Discontinued', $seopress_pro_rich_snippets_product_availability, false ) . ' value="Discontinued">'. __( 'Discontinued', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PreOrder', $seopress_pro_rich_snippets_product_availability, false ) . ' value="PreOrder">'. __( 'Pre Order', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'PreSale', $seopress_pro_rich_snippets_product_availability, false ) . ' value="PreSale">'. __( 'Pre Sale', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                </div>
                <div class="wrap-rich-snippets-services">
                    <p class="notice">
                        '.__('Add markup to your service pages so that Google can provide detailed service information in rich Search results.','wp-seopress-pro').'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_name_meta">
                            '. __( 'Service name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_name" placeholder="'.esc_html__('The name of your service','wp-seopress-pro').'" aria-label="'.__('Service name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_name.'" />
                        <span class="description">'.__('Default: post title','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_type_meta">
                            '. __( 'Service type', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_type" placeholder="'.esc_html__('The type of your service','wp-seopress-pro').'" aria-label="'.__('Service type','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_type.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_description_meta">
                            '. __( 'Service description', 'wp-seopress-pro' ) .'</label>
                        <textarea style="width:100%" name="seopress_pro_rich_snippets_service_description" placeholder="'.esc_html__('The description of your service','wp-seopress-pro').'" aria-label="'.__('Service description','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_description.'" >'.$seopress_pro_rich_snippets_service_description.'</textarea>
                        <span class="description">'.__('Default: post excerpt','wp-seopress-pro').'</span>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_img_meta">'. __( 'Thumbnail', 'wp-seopress-pro' ) .'</label>
                        <input id="seopress_pro_rich_snippets_service_img_meta" type="text" name="seopress_pro_rich_snippets_service_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Thumbnail','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_img.'" />
                        <span class="description">'.__('Default: post thumbnail','wp-seopress-pro').'</span>
                        <input id="seopress_pro_rich_snippets_service_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_area_meta">
                            '. __( 'Area served', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_area" placeholder="'.esc_html__('The area served by your service','wp-seopress-pro').'" aria-label="'.__('Area served','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_area.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_provider_name_meta">
                            '. __( 'Provider name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_provider_name" placeholder="'.esc_html__('The provider name of your service','wp-seopress-pro').'" aria-label="'.__('Provider name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_provider_name.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_lb_img_meta">'. __( 'Location image', 'wp-seopress-pro' ) .'</label>
                        <input id="seopress_pro_rich_snippets_service_lb_img_meta" type="text" name="seopress_pro_rich_snippets_service_lb_img" placeholder="'.esc_html__('Select your location image','wp-seopress-pro').'" aria-label="'.__('Location image','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_lb_img.'" />
                        <input id="seopress_pro_rich_snippets_service_lb_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_provider_mobility_meta">
                            '. __( 'Provider mobility (static or dynamic)', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_provider_mobility" placeholder="'.esc_html__('The provider mobility of your service','wp-seopress-pro').'" aria-label="'.__('Provider mobility','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_provider_mobility.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_slogan_meta">
                            '. __( 'Slogan', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_slogan" placeholder="'.esc_html__('The slogan of your service','wp-seopress-pro').'" aria-label="'.__('Slogan','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_slogan.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_street_addr_meta">
                            '. __( 'Street Address', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_street_addr" placeholder="'.esc_html__('The street address of your service','wp-seopress-pro').'" aria-label="'.__('Street Address','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_street_addr.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_city_meta">
                            '. __( 'City', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_city" placeholder="'.esc_html__('The city of your service','wp-seopress-pro').'" aria-label="'.__('City','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_city.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_state_meta">
                            '. __( 'State', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_state" placeholder="'.esc_html__('The state of your service','wp-seopress-pro').'" aria-label="'.__('State','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_state.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_pc_meta">
                            '. __( 'Postal code', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_pc" placeholder="'.esc_html__('The postal code of your service','wp-seopress-pro').'" aria-label="'.__('Postal code','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_pc.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_country_meta">
                            '. __( 'Country', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_country" placeholder="'.esc_html__('The country of your service','wp-seopress-pro').'" aria-label="'.__('Country','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_country.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_lat_meta">
                            '. __( 'Latitude', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_lat" placeholder="'.esc_html__('The latitude of your service','wp-seopress-pro').'" aria-label="'.__('Latitude','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_lat.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_lon_meta">
                            '. __( 'Longitude', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_lon" placeholder="'.esc_html__('The longitude of your service','wp-seopress-pro').'" aria-label="'.__('Longitude','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_lon.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_tel_meta">
                            '. __( 'Telephone', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_tel" placeholder="'.esc_html__('The telephone of your service','wp-seopress-pro').'" aria-label="'.__('Telephone','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_tel.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_service_price_meta">
                            '. __( 'Price range', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_service_price" placeholder="'.esc_html__('The price range of your service','wp-seopress-pro').'" aria-label="'.__('Price range','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_service_price.'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-review">
                    <p class="notice">
                        '.__('A simple review about something. When Google finds valid reviews or ratings markup, they may show a rich snippet that includes stars and other summary info from reviews or ratings.','wp-seopress-pro').'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_review_item_meta">
                            '. __( 'Review item name', 'wp-seopress-pro' ) .'</label>
                        <input type="text" name="seopress_pro_rich_snippets_review_item" placeholder="'.esc_html__('The item name reviewed','wp-seopress-pro').'" aria-label="'.__('Review item name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_review_item.'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_review_item_type_meta">'. __( 'Review item type', 'wp-seopress-pro' ) .'</label>
                        <select name="seopress_pro_rich_snippets_review_item_type">
                            <option ' . selected( 'CreativeWorkSeason', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="CreativeWorkSeason">'. __( 'CreativeWorkSeason', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'CreativeWorkSeries', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="CreativeWorkSeries">'. __( 'CreativeWorkSeries', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Episode', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="Episode">'. __( 'Episode', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Game', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="Game">'. __( 'Game', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MediaObject', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="MediaObject">'. __( 'MediaObject', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MusicPlaylist', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="MusicPlaylist">'. __( 'MusicPlaylist', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'MusicRecording', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="MusicRecording">'. __( 'MusicRecording', 'wp-seopress-pro' ) .'</option>
                            <option ' . selected( 'Organization', $seopress_pro_rich_snippets_review_item_type, false ) . ' value="Organization">'. __( 'Organization', 'wp-seopress-pro' ) .'</option>
                        </select>
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_review_img_meta">'. __( 'Review item image', 'wp-seopress-pro' ) .'</label>
                        <input id="seopress_pro_rich_snippets_review_img_meta" type="text" name="seopress_pro_rich_snippets_review_img" placeholder="'.esc_html__('Select your image','wp-seopress-pro').'" aria-label="'.__('Review item name','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_review_img.'" />
                        <input id="seopress_pro_rich_snippets_review_img" class="button" type="button" value="'.__('Upload an Image','wp-seopress-pro').'" />
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_review_rating_meta">
                            '. __( 'Your rating', 'wp-seopress-pro' ) .'</label>
                        <input type="number" max="5" min="1" step="0.1" name="seopress_pro_rich_snippets_review_rating" placeholder="'.esc_html__('The item rating','wp-seopress-pro').'" aria-label="'.__('Your rating','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_review_rating.'" />
                    </p>
                </div>
                <div class="wrap-rich-snippets-custom">
                    <p class="notice">';
                    $pre = '<pre>'.htmlspecialchars('<script type="application/ld+json">your custom schema</script>').'</pre>';
                    echo sprintf(__('Build your custom schema. Don\'t forget to include the script tag: %s','wp-seopress-pro'),$pre).'
                    </p>
                    <p>
                        <label for="seopress_pro_rich_snippets_custom_meta">
                            '. __( 'Custom schema', 'wp-seopress-pro' ) .'</label>
                        <textarea rows="25" name="seopress_pro_rich_snippets_custom" placeholder="'.esc_html__('eg: <script type="application/ld+json">{
                            "@context": "https://schema.org/",
                            "@type": "Review",
                            "itemReviewed": {
                              "@type": "Restaurant",
                              "image": "http://www.example.com/seafood-restaurant.jpg",
                              "name": "Legal Seafood",
                              "servesCuisine": "Seafood",
                              "telephone": "1234567",
                              "address" :{
                                "@type": "PostalAddress",
                                "streetAddress": "123 William St",
                                "addressLocality": "New York",
                                "addressRegion": "NY",
                                "postalCode": "10038",
                                "addressCountry": "US"
                              }
                            },
                            "reviewRating": {
                              "@type": "Rating",
                              "ratingValue": "4"
                            },
                            "name": "A good seafood place.",
                            "author": {
                              "@type": "Person",
                              "name": "Bob Smith"
                            },
                            "reviewBody": "The seafood is great.",
                            "publisher": {
                              "@type": "Organization",
                              "name": "Washington Times"
                            }
                          }</script>','wp-seopress-pro').'" aria-label="'.__('Custom schema','wp-seopress-pro').'" value="'.$seopress_pro_rich_snippets_custom.'">'.$seopress_pro_rich_snippets_custom.'</textarea>
                    </p>
                </div>
                <p><a href="https://search.google.com/structured-data/testing-tool/#url='.get_permalink().'" target="_blank" class="button">'.__('Validate my schema','wp-seopress-pro').'</a></p>
            </div>
        </div>
        <div id="seopress-schemas-tabs-2">';
            include_once ( dirname( __FILE__ ) . '/admin-metaboxes-schemas.php');
        echo '</div>
    </div>';
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //Save datas
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    add_action('save_post', 'seopress_pro_save_metabox', 10, 2);
    function seopress_pro_save_metabox($post_id, $post){
        //Nonce
        if ( !isset( $_POST['seopress_pro_cpt_nonce'] ) || !wp_verify_nonce( $_POST['seopress_pro_cpt_nonce'], plugin_basename( __FILE__ ) ) )
            return $post_id;

        //Post type object
        $post_type = get_post_type_object( $post->post_type );

        //Check permission
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        if ( 'attachment' !== get_post_type($post_id) && 'seopress_schemas' !== get_post_type($post_id)) {
            if(isset($_POST['seopress_pro_rich_snippets_type'])){
              update_post_meta($post_id, '_seopress_pro_rich_snippets_type', esc_html($_POST['seopress_pro_rich_snippets_type']));
            }
            
            //Automatic
            if(isset($_POST['seopress_pro_schemas'])){
                update_post_meta($post_id, '_seopress_pro_schemas', $_POST['seopress_pro_schemas']);
            }

            //Article
            if(isset($_POST['seopress_pro_rich_snippets_article_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_article_type', esc_html($_POST['seopress_pro_rich_snippets_article_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_article_title'])){
              update_post_meta($post_id, '_seopress_pro_rich_snippets_article_title', esc_html($_POST['seopress_pro_rich_snippets_article_title']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_article_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_article_img', esc_html($_POST['seopress_pro_rich_snippets_article_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_article_img_width'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_article_img_width', esc_html($_POST['seopress_pro_rich_snippets_article_img_width']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_article_img_height'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_article_img_height', esc_html($_POST['seopress_pro_rich_snippets_article_img_height']));
            }
            //Local Business
            if(isset($_POST['seopress_pro_rich_snippets_lb_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_name', esc_html($_POST['seopress_pro_rich_snippets_lb_name']));
            }            
            if(isset($_POST['seopress_pro_rich_snippets_lb_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_type', esc_html($_POST['seopress_pro_rich_snippets_lb_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_img', esc_html($_POST['seopress_pro_rich_snippets_lb_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_img_width'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_img_width', esc_html($_POST['seopress_pro_rich_snippets_lb_img_width']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_img_height'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_img_height', esc_html($_POST['seopress_pro_rich_snippets_lb_img_height']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_street_addr'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_street_addr', esc_html($_POST['seopress_pro_rich_snippets_lb_street_addr']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_city'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_city', esc_html($_POST['seopress_pro_rich_snippets_lb_city']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_state'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_state', esc_html($_POST['seopress_pro_rich_snippets_lb_state']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_pc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_pc', esc_html($_POST['seopress_pro_rich_snippets_lb_pc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_country'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_country', esc_html($_POST['seopress_pro_rich_snippets_lb_country']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_lat'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_lat', esc_html($_POST['seopress_pro_rich_snippets_lb_lat']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_lon'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_lon', esc_html($_POST['seopress_pro_rich_snippets_lb_lon']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_website'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_website', esc_html($_POST['seopress_pro_rich_snippets_lb_website']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_tel'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_tel', esc_html($_POST['seopress_pro_rich_snippets_lb_tel']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_price'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_price', esc_html($_POST['seopress_pro_rich_snippets_lb_price']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_lb_opening_hours'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_lb_opening_hours', $_POST['seopress_pro_rich_snippets_lb_opening_hours']);
            }
            //FAQ
            if(isset($_POST['seopress_pro_rich_snippets_faq'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_faq', $_POST['seopress_pro_rich_snippets_faq']);
            }
            //Course
            if(isset($_POST['seopress_pro_rich_snippets_courses_title'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_courses_title', esc_html($_POST['seopress_pro_rich_snippets_courses_title']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_courses_desc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_courses_desc', esc_textarea($_POST['seopress_pro_rich_snippets_courses_desc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_courses_school'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_courses_school', esc_html($_POST['seopress_pro_rich_snippets_courses_school']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_courses_website'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_courses_website', esc_html($_POST['seopress_pro_rich_snippets_courses_website']));
            }
            //Recipe
            if(isset($_POST['seopress_pro_rich_snippets_recipes_name'])){
              update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_name', esc_html($_POST['seopress_pro_rich_snippets_recipes_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_desc'])){
              update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_desc', esc_textarea($_POST['seopress_pro_rich_snippets_recipes_desc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_cat'])){
              update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_cat', esc_html($_POST['seopress_pro_rich_snippets_recipes_cat']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_img', esc_html($_POST['seopress_pro_rich_snippets_recipes_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_prep_time'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_prep_time', esc_html($_POST['seopress_pro_rich_snippets_recipes_prep_time']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_cook_time'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_cook_time', esc_html($_POST['seopress_pro_rich_snippets_recipes_cook_time']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_calories'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_calories', esc_html($_POST['seopress_pro_rich_snippets_recipes_calories']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_recipes_yield'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_yield', esc_html($_POST['seopress_pro_rich_snippets_recipes_yield']));
            }        
            if(isset($_POST['seopress_pro_rich_snippets_recipes_keywords'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_keywords', esc_html($_POST['seopress_pro_rich_snippets_recipes_keywords']));
            }       
            if(isset($_POST['seopress_pro_rich_snippets_recipes_cuisine'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_cuisine', esc_html($_POST['seopress_pro_rich_snippets_recipes_cuisine']));
            }       
            if(isset($_POST['seopress_pro_rich_snippets_recipes_ingredient'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_ingredient', esc_textarea($_POST['seopress_pro_rich_snippets_recipes_ingredient']));
            }       
            if(isset($_POST['seopress_pro_rich_snippets_recipes_instructions'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_recipes_instructions', esc_textarea($_POST['seopress_pro_rich_snippets_recipes_instructions']));
            }
            //Job
            if(isset($_POST['seopress_pro_rich_snippets_jobs_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_name', esc_html($_POST['seopress_pro_rich_snippets_jobs_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_desc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_desc', esc_textarea($_POST['seopress_pro_rich_snippets_jobs_desc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_date_posted'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_date_posted', esc_html($_POST['seopress_pro_rich_snippets_jobs_date_posted']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_valid_through'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_valid_through', esc_html($_POST['seopress_pro_rich_snippets_jobs_valid_through']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_employment_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_employment_type', esc_html($_POST['seopress_pro_rich_snippets_jobs_employment_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_identifier_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_identifier_name', esc_html($_POST['seopress_pro_rich_snippets_jobs_identifier_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_identifier_value'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_identifier_value', esc_html($_POST['seopress_pro_rich_snippets_jobs_identifier_value']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_hiring_organization'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_hiring_organization', esc_html($_POST['seopress_pro_rich_snippets_jobs_hiring_organization']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_hiring_same_as'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_hiring_same_as', esc_html($_POST['seopress_pro_rich_snippets_jobs_hiring_same_as']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_hiring_logo'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_hiring_logo', esc_html($_POST['seopress_pro_rich_snippets_jobs_hiring_logo']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_hiring_logo_width'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_hiring_logo_width', esc_html($_POST['seopress_pro_rich_snippets_jobs_hiring_logo_width']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_hiring_logo_height'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_hiring_logo_height', esc_html($_POST['seopress_pro_rich_snippets_jobs_hiring_logo_height']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_address_street'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_address_street', esc_html($_POST['seopress_pro_rich_snippets_jobs_address_street']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_address_locality'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_address_locality', esc_html($_POST['seopress_pro_rich_snippets_jobs_address_locality']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_address_region'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_address_region', esc_html($_POST['seopress_pro_rich_snippets_jobs_address_region']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_postal_code'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_postal_code', esc_html($_POST['seopress_pro_rich_snippets_jobs_postal_code']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_country'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_country', esc_html($_POST['seopress_pro_rich_snippets_jobs_country']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_remote'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_remote', esc_attr($_POST['seopress_pro_rich_snippets_jobs_remote']));
            } else {
                delete_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_remote');
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_salary'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_salary', esc_html($_POST['seopress_pro_rich_snippets_jobs_salary']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_salary_currency'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_salary_currency', esc_html($_POST['seopress_pro_rich_snippets_jobs_salary_currency']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_jobs_salary_unit'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_jobs_salary_unit', esc_html($_POST['seopress_pro_rich_snippets_jobs_salary_unit']));
            }
            //Video
            if(isset($_POST['seopress_pro_rich_snippets_videos_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_name', esc_html($_POST['seopress_pro_rich_snippets_videos_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_description'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_description', esc_textarea($_POST['seopress_pro_rich_snippets_videos_description']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_img', esc_html($_POST['seopress_pro_rich_snippets_videos_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_img_width'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_img_width', esc_html($_POST['seopress_pro_rich_snippets_videos_img_width']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_img_height'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_img_height', esc_html($_POST['seopress_pro_rich_snippets_videos_img_height']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_duration'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_duration', esc_html($_POST['seopress_pro_rich_snippets_videos_duration']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_videos_url'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_videos_url', esc_html($_POST['seopress_pro_rich_snippets_videos_url']));
            }
            //Event
            if(isset($_POST['seopress_pro_rich_snippets_events_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_type', esc_html($_POST['seopress_pro_rich_snippets_events_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_name', esc_html($_POST['seopress_pro_rich_snippets_events_name']));
            }  
            if(isset($_POST['seopress_pro_rich_snippets_events_desc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_desc', esc_html($_POST['seopress_pro_rich_snippets_events_desc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_img', esc_html($_POST['seopress_pro_rich_snippets_events_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_desc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_desc', esc_textarea($_POST['seopress_pro_rich_snippets_events_desc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_start_date'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_start_date', esc_html($_POST['seopress_pro_rich_snippets_events_start_date']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_start_time'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_start_time', esc_html($_POST['seopress_pro_rich_snippets_events_start_time']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_end_date'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_end_date', esc_html($_POST['seopress_pro_rich_snippets_events_end_date']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_end_time'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_end_time', esc_html($_POST['seopress_pro_rich_snippets_events_end_time']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_location_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_location_name', esc_html($_POST['seopress_pro_rich_snippets_events_location_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_location_url'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_location_url', esc_html($_POST['seopress_pro_rich_snippets_events_location_url']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_location_address'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_location_address', esc_html($_POST['seopress_pro_rich_snippets_events_location_address']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_name', esc_html($_POST['seopress_pro_rich_snippets_events_offers_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_cat'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_cat', esc_html($_POST['seopress_pro_rich_snippets_events_offers_cat']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_price'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_price', esc_html($_POST['seopress_pro_rich_snippets_events_offers_price']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_price_currency'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_price_currency', esc_html($_POST['seopress_pro_rich_snippets_events_offers_price_currency']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_availability'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_availability', esc_html($_POST['seopress_pro_rich_snippets_events_offers_availability']));
            }
            if(isset($_POST['seopress_rich_snippets_events_offers_valid_from_date'])){
                update_post_meta($post_id, '_seopress_rich_snippets_events_offers_valid_from_date', esc_html($_POST['seopress_rich_snippets_events_offers_valid_from_date']));
            }
            if(isset($_POST['seopress_rich_snippets_events_offers_valid_from_time'])){
                update_post_meta($post_id, '_seopress_rich_snippets_events_offers_valid_from_time', esc_html($_POST['seopress_rich_snippets_events_offers_valid_from_time']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_offers_url'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_offers_url', esc_html($_POST['seopress_pro_rich_snippets_events_offers_url']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_events_performer'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_events_performer', esc_html($_POST['seopress_pro_rich_snippets_events_performer']));
            }
            //Product
            if(isset($_POST['seopress_pro_rich_snippets_product_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_name', esc_html($_POST['seopress_pro_rich_snippets_product_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_description'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_description', esc_textarea($_POST['seopress_pro_rich_snippets_product_description']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_img', esc_html($_POST['seopress_pro_rich_snippets_product_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_price'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_price', esc_html($_POST['seopress_pro_rich_snippets_product_price']));
            }              
            if(isset($_POST['seopress_pro_rich_snippets_product_price_valid_date'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_price_valid_date', esc_html($_POST['seopress_pro_rich_snippets_product_price_valid_date']));
            }            
            if(isset($_POST['seopress_pro_rich_snippets_product_sku'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_sku', esc_html($_POST['seopress_pro_rich_snippets_product_sku']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_global_ids'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_global_ids', esc_html($_POST['seopress_pro_rich_snippets_product_global_ids']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_brand'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_brand', esc_html($_POST['seopress_pro_rich_snippets_product_brand']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_global_ids_value'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_global_ids_value', esc_html($_POST['seopress_pro_rich_snippets_product_global_ids_value']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_price_currency'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_price_currency', esc_html($_POST['seopress_pro_rich_snippets_product_price_currency']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_condition'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_condition', esc_html($_POST['seopress_pro_rich_snippets_product_condition']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_product_availability'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_product_availability', esc_html($_POST['seopress_pro_rich_snippets_product_availability']));
            }
            //Service            
            if(isset($_POST['seopress_pro_rich_snippets_service_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_name', esc_html($_POST['seopress_pro_rich_snippets_service_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_type', esc_html($_POST['seopress_pro_rich_snippets_service_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_description'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_description', esc_textarea($_POST['seopress_pro_rich_snippets_service_description']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_img', esc_html($_POST['seopress_pro_rich_snippets_service_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_area'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_area', esc_html($_POST['seopress_pro_rich_snippets_service_area']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_provider_name'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_provider_name', esc_html($_POST['seopress_pro_rich_snippets_service_provider_name']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_lb_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_lb_img', esc_html($_POST['seopress_pro_rich_snippets_service_lb_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_provider_mobility'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_provider_mobility', esc_html($_POST['seopress_pro_rich_snippets_service_provider_mobility']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_slogan'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_slogan', esc_html($_POST['seopress_pro_rich_snippets_service_slogan']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_street_addr'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_street_addr', esc_html($_POST['seopress_pro_rich_snippets_service_street_addr']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_city'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_city', esc_html($_POST['seopress_pro_rich_snippets_service_city']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_state'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_state', esc_html($_POST['seopress_pro_rich_snippets_service_state']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_pc'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_pc', esc_html($_POST['seopress_pro_rich_snippets_service_pc']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_country'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_country', esc_html($_POST['seopress_pro_rich_snippets_service_country']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_lat'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_lat', esc_html($_POST['seopress_pro_rich_snippets_service_lat']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_lon'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_lon', esc_html($_POST['seopress_pro_rich_snippets_service_lon']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_tel'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_tel', esc_html($_POST['seopress_pro_rich_snippets_service_tel']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_service_price'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_service_price', esc_html($_POST['seopress_pro_rich_snippets_service_price']));
            }
            //Review
            if(isset($_POST['seopress_pro_rich_snippets_review_item'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_review_item', esc_html($_POST['seopress_pro_rich_snippets_review_item']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_review_item_type'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_review_item_type', esc_html($_POST['seopress_pro_rich_snippets_review_item_type']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_review_img'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_review_img', esc_html($_POST['seopress_pro_rich_snippets_review_img']));
            }
            if(isset($_POST['seopress_pro_rich_snippets_review_rating'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_review_rating', esc_html($_POST['seopress_pro_rich_snippets_review_rating']));
            }

            //Custom schema
            if(isset($_POST['seopress_pro_rich_snippets_custom'])){
                update_post_meta($post_id, '_seopress_pro_rich_snippets_custom', esc_textarea($_POST['seopress_pro_rich_snippets_custom']));
            }
        }
    }
}

if (seopress_get_toggle_rich_snippets_option() =='1' && seopress_rich_snippets_enable_option() =='1') {
    if (is_user_logged_in()) {
        if (is_super_admin()) {
            echo seopress_pro_admin_std_metaboxe_display();
        } else {
            global $wp_roles;
                
            //Get current user role
            if(isset(wp_get_current_user()->roles[0])) {
                $seopress_user_role = wp_get_current_user()->roles[0];
                //If current user role matchs values from Security settings then apply
                if (function_exists('seopress_advanced_security_metaboxe_sdt_role_hook_option') && seopress_advanced_security_metaboxe_sdt_role_hook_option() !='') {
                    if( array_key_exists( $seopress_user_role, seopress_advanced_security_metaboxe_sdt_role_hook_option())) {
                        //do nothing
                    } else {
                        echo seopress_pro_admin_std_metaboxe_display();
                    }
                } else {
                    echo seopress_pro_admin_std_metaboxe_display();
                }
            }
        }
    }
}
