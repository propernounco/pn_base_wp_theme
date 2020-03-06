<?php
/**
 * Class SEOPRESS_CSV_Importers file
 *
 * @package     SEOPress/inc/admin
 * @version     3.7
 * @source 		WooCommerce/Admin/Importers/class-wc-product-csv-importer-controller.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action('init', 'seopress_do_output_buffer');
function seopress_do_output_buffer() {
    if ((isset($_GET['page']) && ($_GET['page'] == 'seopress_csv_importer')) || (isset($_GET['import']) && ($_GET['import'] == 'seopress_csv_importer'))) {
        ob_start();
    }
}
/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 *
 * @param string|array $var Data to sanitize.
 * @return string|array
 */
function seopress_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'seopress_clean', $var );
	} else {
		return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
	}
}

/**
 * SEOPRESS_CSV_Importers class.
 */
class SEOPRESS_CSV_Importers {

	/**
	 * Array of importer IDs.
	 *
	 * @var string[]
	 */
	protected $importers = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! $this->import_allowed() ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'add_to_menus' ), 20 );
		add_action( 'admin_init', array( $this, 'register_importers' ), 20 );
		add_action( 'admin_head', array( $this, 'hide_from_menus' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 20 );
		add_action( 'wp_ajax_seopress_do_ajax_metadatas_import', array( $this, 'seopress_do_ajax_metadatas_import' ) );

		// Register CSV importers.
		$this->importers['seopress_csv_importer'] = array(
			'menu'       => 'admin.php?page=seopress_csv_importer',
			'name'       => __( 'CSV Import', 'woocommerce' ),
			'capability' => 'import',
			'callback'   => array( $this, 'seopress_csv_importer' ),
		);
	}
	
	/**
	 * Return true if SEOPress imports are allowed for current user, false otherwise.
	 *
	 * @return bool Whether current user can perform imports.
	 */
	protected function import_allowed() {
		return current_user_can( 'edit_posts' ) && current_user_can( 'import' );
	}

	/**
	 * Add admin menus/screens.
	 */
	public function add_to_menus() {
		//add_submenu_page('seopress-option', '', '', 'manage_options', 'seopress_csv_importer', array($this, 'seopress_csv_importer'));
		foreach ( $this->importers as $id => $importer ) {
			add_submenu_page( $importer['menu'], $importer['name'], $importer['name'], $importer['capability'], $id, $importer['callback'] );
		}
	}

	/**
	 * Hide menu items from view so the pages exist, but the menu items do not.
	 */
	public function hide_from_menus() {
		//remove_submenu_page('seopress-option','seopress_csv_importer'); //CSV Importer
		global $submenu;

		foreach ( $this->importers as $id => $importer ) {
			if ( isset( $submenu[ $importer['menu'] ] ) ) {
				foreach ( $submenu[ $importer['menu'] ] as $key => $menu ) {
					if ( $id === $menu[2] ) {
						unset( $submenu[ $importer['menu'] ][ $key ] );
					}
				}
			}
		}
	}

	/**
	 * Register/enqueue scripts and styles for the Setup Wizard.
	 *
	 * Hooked onto 'admin_enqueue_scripts'.
	 */
	public function admin_scripts() {
		if (isset($_GET['page']) && ($_GET['page'] == 'seopress_csv_importer') ) {
			wp_register_script( 'seopress-csv-import', plugins_url( 'assets/js/seopress-csv-import.js', dirname(dirname(dirname(__FILE__)))), array( 'jquery' ), SEOPRESS_VERSION, true );
		}
	}

	/**
	 * The CSV importer.
	 *
	 * This has a custom screen - the Tools > Import item is a placeholder.
	 * If we're on that screen, redirect to the custom one.
	 */
	public function seopress_csv_importer() {
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
			wp_safe_redirect(admin_url('admin.php?page=seopress_csv_importer'));
			exit;
		}

		include_once dirname( __FILE__ ) . '/class-csv-importer.php';
		include_once dirname( __FILE__ ) . '/class-csv-controller.php';

		$importer = new SEOPRESS_CSV_Setup_Wizard_Controller();
		$importer->dispatch();
	}

	/**
	 * Register WordPress based importers.
	 */
	public function register_importers() {
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
			add_action( 'import_start', array( $this, 'post_importer_compatibility' ) );
			register_importer( 'seopress_csv_importer', __( 'SEO metadata (CSV)', 'wp-seopress-pro' ), __( 'Import <strong>metadata</strong> (title, meta description, social metas...) to your site via a csv file.', 'wp-seopress-pro' ), array( $this, 'seopress_csv_importer' ) );
		}
	}

	/**
	 * Ajax callback for importing one batch of metadata from a CSV.
	 */
	public function seopress_do_ajax_metadatas_import() {
		global $wpdb;
		check_ajax_referer( 'seopress-csv-importer', 'security' );

		if ( ! $this->import_allowed() || ! isset( $_POST['file'] ) ) {
			wp_send_json_error( array( 'message' => __( 'Insufficient privileges to import metadata.', 'wp-seopress-pro' ) ) );
		}
		
		include_once dirname( __FILE__ ) . '/class-csv-controller.php';
		include_once dirname( __FILE__ ) . '/class-csv-importer.php';

		$file   = sanitize_text_field( wp_unslash( $_POST['file'] ) );
		$params = array(
			'delimiter'       => ! empty( $_POST['delimiter'] ) ? sanitize_text_field( wp_unslash( $_POST['delimiter'] ) ) : ';',
			'start_pos'       => isset( $_POST['position'] ) ? absint( $_POST['position'] ) : 0,
			'mapping'         => isset( $_POST['mapping'] ) ? (array) wp_unslash( $_POST['mapping'] ) : array(),
			'lines'           => apply_filters( 'seopress_metadata_import_batch_size', 30 ),
			'parse'           => true,
		);


		// Log failures.
		if ( 0 !== $params['start_pos'] ) {
			$error_log = array_filter( (array) get_user_option( 'seopress_import_error_log' ) );
		} else {
			$error_log = array();
		}

		$importer         = SEOPRESS_CSV_Setup_Wizard_Controller::get_importer( $file, $params );
		$results          = $importer->import();
		$percent_complete = $importer->get_percent_complete();
		$error_log        = array_merge( $error_log, $results['failed'], $results['skipped'] );

		update_user_option( get_current_user_id(), 'seopress_import_error_log', $error_log );

		if ( 100 === $percent_complete ) {
			$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_original_id' ) );

			// // Clean up orphaned data.
			// $wpdb->query(
			// 	"
			// 	DELETE {$wpdb->postmeta}.* FROM {$wpdb->postmeta}
			// 	LEFT JOIN {$wpdb->posts} wp ON wp.ID = {$wpdb->postmeta}.post_id
			// 	WHERE wp.ID IS NULL
			// "
			// );

			// Send success.
			wp_send_json_success(
				array(
					'position'   => 'done',
					'percentage' => 100,
					'url'        => add_query_arg( array( '_wpnonce' => wp_create_nonce( 'seopress-csv-importer' ) ), admin_url( 'admin.php?page=seopress_csv_importer&step=done' ) ),
					'imported'   => count( $results['imported'] ),
					'failed'     => count( $results['failed'] ),
					'updated'    => count( $results['updated'] ),
					'skipped'    => count( $results['skipped'] ),
				)
			);
		} else {
			wp_send_json_success(
				array(
					'position'   => $importer->get_file_position(),
					'percentage' => $percent_complete,
					'imported'   => count( $results['imported'] ),
					'failed'     => count( $results['failed'] ),
					'updated'    => count( $results['updated'] ),
					'skipped'    => count( $results['skipped'] ),
				)
			);
		}
	}
}
new SEOPRESS_CSV_Importers();