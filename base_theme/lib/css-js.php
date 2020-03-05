<?php 


function pn_enqueue_style() {         
        
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/assets/css/theme-styles.css', array(), null, false);            
    // wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css');

    //load some dynamic css if it exists for the template
    if(is_single()){
        $template_slug = str_replace(' ', '-', strtolower(get_post_type()));        
    }
    else{
        $template_slug = str_replace(' ', '-', strtolower(pn_get_template_name()));
    }    

    $css_filename = get_template_directory().  '/assets/css/'. $template_slug .'.css';
    

    if(file_exists($css_filename)){
        wp_enqueue_style($template_slug . '-dynamic-style', get_template_directory_uri() . '/assets/css/'. $template_slug .'.css', array(), null, false);                        
    }    

}

function pn_enqueue_script(){
    
    
        // wp_enqueue_script('jquery-min', get_template_directory_uri() . '/assets/vendors/jquery/jquery.1.11.3.min.js', array(), null, true);
        
        wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/dist/js/theme-js.dist.js', '1.0.0', true);

        $php_array = array(
            'upload_url' => admin_url('async-upload.php'),
            'admin_ajax' => admin_url('admin-ajax.php'),
            'nonce'      => wp_create_nonce('media-form'),
            'base_url' => get_home_url()
        );

        wp_localize_script('main-js', 'php_array', $php_array);

}

add_action( 'wp_enqueue_scripts', 'pn_enqueue_style' );
add_action( 'wp_enqueue_scripts', 'pn_enqueue_script' );