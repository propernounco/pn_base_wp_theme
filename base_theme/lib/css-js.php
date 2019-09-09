<?php 
function pn_enqueue_style() {          
        wp_enqueue_style('theme-styles', get_template_directory_uri() . '/assets/css/lontv-styles.css', array(), null, false);    
        // wp_enqueue_style('fa', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', array(), null, false);
        wp_enqueue_style('main-style', get_template_directory_uri() . '/style.css');
}

function pn_enqueue_script(){
    
    
        // wp_enqueue_script('jquery-min', get_template_directory_uri() . '/assets/vendors/jquery/jquery.1.11.3.min.js', array(), null, true);
        
        wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/dist/js/lontv-js.dist.js', '1.0.0', true);

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