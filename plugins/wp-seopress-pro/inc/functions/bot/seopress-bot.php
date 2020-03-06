<?php
defined( 'ABSPATH' ) or die( 'Please don&rsquo;t call the plugin directly. Thanks :)' );

/**
 * Main plugin class.
 *
 * @since 1.0.0
 *
 * @package SEOPress_Bot_batch
 * @author  Thomas Griffin + Benjamin Denis
 */
class SEOPress_Bot_batch {    
    /**
     * Holds the class object.
     *
     * @since 1.0.0
     *
     * @var object
     */
    public static $instance;
    /**
     * Unique plugin slug identifier.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $plugin_slug = 'seopress-bot-batch';
    /**
     * Plugin file.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $file = __FILE__;
    /**
     * Plugin menu hook.
     *
     * @since 1.0.0
     *
     * @var string
     */
    public $hook = false;
    /**
     * Primary class constructor.
     *
     * @since 1.0.0
     */
    public function __construct() {
        // Load the plugin.
        add_action( 'init', array( $this, 'init' ), 0 );
    }
    /**
     * Loads the plugin into WordPress.
     *
     * @since 1.0.0
     */
    public function init() {
        add_action( 'admin_menu', array( $this, 'menu' ) );
    }
    /**
     * Loads the admin menu item under the SEOPress menu.
     *
     * @since 1.0.0
     */
    public function menu() {
        if(seopress_get_toggle_bot_option()=='1') { 
            $this->hook = add_submenu_page('seopress-option', __('Broken links','wp-seopress-pro'), __('BOT','wp-seopress-pro'), 'manage_options', $this->plugin_slug, array( $this, 'menu_cb' ));
        }
    }

    /**
     * Outputs the menu view.
     *
     * @since 1.0.0
     */
    public function menu_cb() { 
        $this->options = get_option( 'seopress_bot_option_name' );
        
        if (is_plugin_active('wp-seopress/seopress.php')) {
            if (function_exists('seopress_admin_header')) {
                echo seopress_admin_header();
            }
        }
        ?>
        <div class="seopress-option">
            <?php
            global $wp_version, $title;
            $current_tab = '';
            $tag = version_compare( $wp_version, '4.4' ) >= 0 ? 'h1' : 'h2';
            echo '<'.$tag.'><span class="dashicons dashicons-admin-generic"></span>'.$title.'</'.$tag.'>';
            ?>

            <div id="seopress-tabs" class="wrap">
                <?php 
                    $plugin_settings_tabs = array(
                        'tab_seopress_scan' => __( "Scan", "wp-seopress-pro" ),
                        'tab_seopress_scan_settings' => __( "Settings", "wp-seopress-pro" )
                    );

                    echo '<div class="nav-tab-wrapper">';
                    foreach ( $plugin_settings_tabs as $tab_key => $tab_caption ) {
                        echo '<a id="'. $tab_key .'-tab" class="nav-tab" href="?page=seopress-bot-batch#tab=' . $tab_key . '">' . $tab_caption . '</a>';
                    }
                    echo '</div>';
                ?>

                <!-- Scan -->
                <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_scan') { echo 'active'; } ?>" id="tab_seopress_scan">
                    <?php do_settings_sections( 'seopress-settings-admin-bot' ); ?>
                    <br>
                    <br>
                    <hr>
                    <br>
                    <?php if (get_option('seopress-bot-log') !='') { ?>
                            <strong><?php _e('Latest scan: ','wp-seopress-pro'); ?></strong>
                            <?php echo get_option('seopress-bot-log'); ?>
                            <br><br>
                            <strong><?php _e('Links found: ','wp-seopress-pro'); ?></strong>
                            <?php echo wp_count_posts( 'seopress_bot' )->publish; ?>
                            <br>
                        <form method="post">
                            <input type="hidden" name="seopress_action" value="export_csv_links_settings" />
                            <p>
                                <?php wp_nonce_field( 'seopress_export_csv_links_nonce', 'seopress_export_csv_links_nonce' ); ?>
                                <?php submit_button( __( 'Export CSV', 'wp-seopress-pro' ), 'secondary', '', false ); ?>
                                <br>
                                <br>
                            </p>
                        </form>
                    <?php } else { 
                        _e('No scan','wp-seopress-pro');
                    } ?>
                    <hr>
                    <div class="wrap-bot-form">
                        <div id="seopress_launch_bot" class="button">
                            <?php _e('Launch the bot!','wp-seopress-pro'); ?>
                        </div>
                        <span class="spinner"></span>
                        <br>
                        <textarea id="seopress_bot_log" rows="10" width="100%" readonly style="display:none"><?php _e('---Scan in progress (don\'t close this window)---','wp-seopress-pro'); ?></textarea>
                    </div>
                </div><!--end .wrap-bot-form-->
                
                <!-- Settings -->
                <div class="seopress-tab <?php if ($current_tab == 'tab_seopress_scan_settings') { echo 'active'; } ?>" id="tab_seopress_scan_settings">
                    <form method="post" action="<?php echo admin_url('options.php'); ?>">
                        <?php settings_fields( 'seopress_bot_option_group' ); ?>
                        <?php do_settings_sections( 'seopress-settings-admin-bot-settings' ); ?>
                        <?php submit_button(); ?>
                    </form>
                </div>

            </div><!--seopress-tabs-->
        </div>
        <?php
    }
    /**
     * Returns the singleton instance of the class.
     *
     * @since 1.0.0
     *
     * @return object The SEOPress_Bot_batch object.
     */
    public static function get_instance() {
        if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SEOPress_Bot_batch ) ) {
            self::$instance = new SEOPress_Bot_batch();
        }
        return self::$instance;
    }
}
// Load the main plugin class.
$seopress_bot_batch = SEOPress_Bot_batch::get_instance();