<?php
/**
 * Class SEOPRESS_CSV_Setup_Wizard_Controller file
 *
 * @package     SEOPress/inc/admin
 * @version     3.7
 * @source 		WooCommerce/Admin/Importers/class-wc-product-csv-importer-controller.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Importer' ) ) {
	return;
}

/**
 * SEOPRESS_CSV_Setup_Wizard_Controller class.
 */
class SEOPRESS_CSV_Setup_Wizard_Controller {

	/**
	 * The path to the current file.
	 *
	 * @var string
	 */
	protected $file = '';

	/**
	 * Current step
	 *
	 * @var string
	 */
	private $step = '';

	/**
	 * Steps for the setup wizard
	 *
	 * @var array
	 */
	private $steps = array();

	/**
	 * Errors.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * The current delimiter for the file being read.
	 *
	 * @var string
	 */
	protected $delimiter = ';';

	/**
	 * Get importer instance.
	 *
	 * @param  string $file File to import.
	 * @param  array  $args Importer arguments.
	 * @return SEOPRESS_CSV_Importer
	 */
	public static function get_importer( $file, $args = array() ) {
		$importer_class = apply_filters( 'seopress_csv_importer_class', 'SEOPRESS_CSV_Importer' );
		$args           = apply_filters( 'seopress_csv_importer_args', $args, $importer_class );
		return new $importer_class( $file, $args );
	}

	/**
	 * Check whether a file is a valid CSV file.
	 *
	 * @param string $file File path.
	 * @param bool   $check_path Whether to also check the file is located in a valid location (Default: true).
	 * @return bool
	 */
	public static function is_file_valid_csv( $file, $check_path = true ) {
		if ( $check_path && apply_filters( 'seopress_csv_importer_check_import_file_path', true ) && false !== stripos( $file, '://' ) ) {
			return false;
		}

		$valid_filetypes = self::get_valid_csv_filetypes();
		$filetype        = wp_check_filetype( $file, $valid_filetypes );
		if ( in_array( $filetype['type'], $valid_filetypes, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get all the valid filetypes for a CSV file.
	 *
	 * @return array
	 */
	protected static function get_valid_csv_filetypes() {
		return apply_filters(
			'seopress_csv_import_valid_filetypes',
			array(
				'csv' => 'text/csv',
			)
		);
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		$default_steps = array(
			'upload' => array(
				'name'    => __( 'Upload CSV file', 'wp-seopress-pro' ),
				'view'    => array( $this, 'upload_form' ),
				'handler' => array( $this, 'upload_form_handler' ),
			),
			'mapping'     => array(
				'name'    => __( 'Column mapping', 'wp-seopress-pro' ),
				'view'    => array( $this, 'mapping_form' ),
				'handler' => '',
			),
			'import'    => array(
				'name'    => __( 'Import', 'wp-seopress-pro' ),
				'view'    => array( $this, 'import' ),
				'handler' => '',
			),
			'done'  => array(
				'name'    => __( 'Done!', 'wp-seopress-pro' ),
				'view'    => array( $this, 'done' ),
				'handler' => '',
			),
		);

		$this->steps = apply_filters( 'seopress_setup_csv_wizard_steps', $default_steps );

		$this->step            = isset( $_REQUEST['step'] ) ? sanitize_key( $_REQUEST['step'] ) : current( array_keys( $this->steps ) );
		$this->file            = isset( $_REQUEST['file'] ) ? seopress_clean( wp_unslash( $_REQUEST['file'] ) ) : '';
		$this->delimiter       = ! empty( $_REQUEST['delimiter'] ) ? seopress_clean( wp_unslash( $_REQUEST['delimiter'] ) ) : ';';
		
		// Import mappings for CSV data.
		include_once dirname( __FILE__ ) . '/mapping.php';
	}

	/**
	 * Get the URL for the next step's screen.
	 *
	 * @param string $step  slug (default: current step).
	 * @return string       URL for next step if a next step exists.
	 *                      Admin URL if it's the last step.
	 *                      Empty string on failure.
	 * @since 3.7
	 */
	public function get_next_step_link( $step = '' ) {
		if ( ! $step ) {
			$step = $this->step;
		}

		$keys = array_keys( $this->steps );

		if ( end( $keys ) === $step ) {
			return admin_url();
		}

		$step_index = array_search( $step, $keys, true );

		if ( false === $step_index ) {
			return '';
		}

		$params = array(
			'step'            => $keys[ $step_index + 1 ],
			'file'            => $this->file,
			'_wpnonce'        => wp_create_nonce( 'seopress-csv-importer' ),
		);

		return add_query_arg( $params );
	}

	/**
	 * Output header view.
	 */
	protected function output_header() {
		set_current_screen();
		echo '<div class="seopress-option">
				<h1><span class="dashicons dashicons-admin-settings"></span>'.__("Import metadata from a CSV file","wp-seopress-pro").'</h1>';
	}

	/**
	 * Output steps view.
	 */
	protected function output_steps() {
		$output_steps      = $this->steps;
		?>
		<ol class="seopress-setup-steps">
			<?php
			foreach ( $output_steps as $step_key => $step ) {
				$is_completed = array_search( $this->step, array_keys( $this->steps ), true ) > array_search( $step_key, array_keys( $this->steps ), true );

				if ( $step_key === $this->step ) {
					?>
					<li class="active"><?php echo esc_html( $step['name'] ); ?></li>
					<?php
				} elseif ( $is_completed ) {
					?>
					<li class="done">
						<a href="<?php echo esc_url( add_query_arg( 'step', $step_key, remove_query_arg( 'activate_error' ) ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a>
					</li>
					<?php
				} else {
					?>
					<li><?php echo esc_html( $step['name'] ); ?></li>
					<?php
				}
			}
			?>
		</ol>
		<?php
	}

	/**
	 * Output the content for the current step.
	 */
	public function output_content() {
		echo '<div class="seopress-setup-content"><div class="postbox section-tool"><div class="inside">';
		if ( ! empty( $this->steps[ $this->step ]['view'] ) ) {
			call_user_func( $this->steps[ $this->step ]['view'], $this );
		}
		echo '</div></div></div>';
	}

	/**
	 * Output footer view.
	 */
	protected function output_footer() {
		echo '</div>';
		do_action( 'seopress_setup_footer' );
	}

	/**
	 * Add error message.
	 *
	 * @param string $message Error message.
	 * @param array  $actions List of actions with 'url' and 'label'.
	 */
	protected function add_error( $message, $actions = array() ) {
		$this->errors[] = array(
			'message' => $message,
			'actions' => $actions,
		);
	}

	/**
	 * Add error message.
	 */
	protected function output_errors() {
		if ( ! $this->errors ) {
			return;
		}

		foreach ( $this->errors as $error ) {
			echo '<div class="error inline">';
			echo '<p>' . esc_html( $error['message'] ) . '</p>';

			if ( ! empty( $error['actions'] ) ) {
				echo '<p>';
				foreach ( $error['actions'] as $action ) {
					echo '<a class="button button-primary" href="' . esc_url( $action['url'] ) . '">' . esc_html( $action['label'] ) . '</a>';
				}
				echo '</p>';
			}
			echo '</div>';
		}
	}

	/**
	 * Dispatch current step and show correct view.
	 */
	public function dispatch() {
		if ( ! empty( $_POST['save_step'] ) && ! empty( $this->steps[ $this->step ]['handler'] ) ) {
			call_user_func( $this->steps[ $this->step ]['handler'], $this );
		}
		$this->output_header();
		$this->output_steps();
		$this->output_errors();
		$this->output_content();
		$this->output_footer();
	}

	/**
	 * Output information about the uploading process.
	 */
	protected function upload_form() {
		$bytes      = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
		$size       = size_format( $bytes );
		$upload_dir = wp_upload_dir();

		?>
		<form method="post" enctype="multipart/form-data">
			<p>
				<?php esc_html_e( 'This tool allows you to import SEO metadata to your site from a CSV file (separator: ";" ).', 'wp-seopress-pro' ); ?><br>
				<?php esc_html_e( 'Existing posts that match by ID will be updated.', 'wp-seopress-pro' ); ?><br>
				<?php esc_html_e( 'Posts, pages or custom post types that do not exist will be skipped.', 'wp-seopress-pro' ); ?>
			</p>

			<div class="postbox section-tool seopress-wizard-services">
			<?php
				if ( ! empty( $upload_dir['error'] ) ) {
					?>
					<div class="inline error">
						<p><?php esc_html_e( 'Before you can upload your import file, you will need to fix the following error:', 'wp-seopress-pro' ); ?></p>
						<p><strong><?php echo esc_html( $upload_dir['error'] ); ?></strong></p>
					</div>
					<?php
				} else { ?>
					<p>
						<label for="import_file"><?php _e('Choose a CSV file from your computer:','wp-seopress-pro'); ?></label>
						<input type="file" id="upload" name="import" size="25" />
						<input type="hidden" name="action" value="save" />
						<input type="hidden" name="max_file_size" value="<?php echo esc_attr( $bytes ); ?>" />
						<br>
						<small>
							<?php
								$bytes      = apply_filters( 'import_upload_size_limit', wp_max_upload_size() );
								$size       = size_format( $bytes );
								$upload_dir = wp_upload_dir();
								printf(
									/* translators: %s: maximum upload size */
									esc_html__( 'Maximum size: %s', 'wp-seopress-pro' ),
									esc_html( $size )
								);
							?>
						</small>
					</p>
				<?php
					}
				?>
			</div><!-- .postbox -->

			<p class="seopress-setup-actions step">
				<button type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( "Next step", 'wp-seopress-pro' ); ?>" name="save_step"><?php esc_html_e( "Next step", 'wp-seopress-pro' ); ?></button>
				<?php wp_nonce_field( 'seopress-csv-importer' ); ?>
			</p>
		</form>
	<?php
	}

	/**
	 * Handle the upload form and store options.
	 */
	public function upload_form_handler() {
		check_admin_referer( 'seopress-csv-importer' );

		$file = $this->handle_upload();

		if ( is_wp_error( $file ) ) {
			$this->add_error( $file->get_error_message() );
			return;
		} else {
			$this->file = $file;
		}

		wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
		exit;
	}

	/**
	 * Handles the CSV upload and initial parsing of the file
	 *
	 * @return string|WP_Error
	 */
	public function handle_upload() {
		$file_url = isset( $_POST['file_url'] ) ? sanitize_text_field( wp_unslash( $_POST['file_url'] ) ) : '';

		if ( empty( $file_url ) ) {
			if ( ! isset( $_FILES['import'] ) ) {
				return new WP_Error( 'seopress_metadata_csv_importer_upload_file_empty', __( 'File is empty. Please upload something more substantial. This error could also be caused by uploads being disabled in your php.ini or by post_max_size being defined as smaller than upload_max_filesize in php.ini.', 'wp-seopress-pro' ) );
			}

			if ( ! self::is_file_valid_csv( sanitize_text_field( wp_unslash( $_FILES['import']['name'] ) ), false ) ) {
				return new WP_Error( 'seopress_metadata_csv_importer_upload_file_invalid', __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'wp-seopress-pro' ) );
			}

			$overrides = array(
				'test_form' => false,
				'mimes'     => self::get_valid_csv_filetypes(),
			);
			$import    = $_FILES['import'];
			$upload    = wp_handle_upload( $import, $overrides );

			if ( isset( $upload['error'] ) ) {
				return new WP_Error( 'seopress_metadata_csv_importer_upload_error', $upload['error'] );
			}

			// Construct the object array.
			$object = array(
				'post_title'     => basename( $upload['file'] ),
				'post_content'   => $upload['url'],
				'post_mime_type' => $upload['type'],
				'guid'           => $upload['url'],
				'context'        => 'import',
				'post_status'    => 'private',
			);

			// Save the data.
			$id = wp_insert_attachment( $object, $upload['file'] );

			/*
			 * Schedule a cleanup for one day from now in case of failed
			 * import or missing wp_import_cleanup() call.
			 */
			wp_schedule_single_event( time() + DAY_IN_SECONDS, 'importer_scheduled_cleanup', array( $id ) );

			return $upload['file'];
		} elseif ( file_exists( ABSPATH . $file_url ) ) {
			if ( ! self::is_file_valid_csv( ABSPATH . $file_url ) ) {
				return new WP_Error( 'seopress_metadata_csv_importer_upload_file_invalid', __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'wp-seopress-pro' ) );
			}

			return ABSPATH . $file_url;
		}
		return new WP_Error( 'seopress_metadata_csv_importer_upload_invalid_file', __( 'Please upload or provide the link to a valid CSV file.', 'wp-seopress-pro' ) );
	}

	/**
	 * Column mapping.
	 */
	public function mapping_form() {
		check_admin_referer( 'seopress-csv-importer' );
		$args = array(
			'lines'     => 1,
			'delimiter' => ';',
		);

		$importer     = self::get_importer( $this->file, $args );
		$headers      = $importer->get_raw_keys();
		$mapped_items = $this->auto_map_columns( $headers );
		$sample       = current( $importer->get_raw_data() );

		if ( empty( $sample ) ) {
			$this->add_error(
				__( 'The file is empty or using a different encoding than UTF-8, please try again with a new file.', 'wp-seopress-pro' ),
				array(
					array(
						'url'   => admin_url( 'admin.php?page=seopress_csv_importer' ),
						'label' => __( 'Upload a new file', 'wp-seopress-pro' ),
					),
				)
			);

			// Force output the errors in the same page.
			$this->output_errors();
			return;
		}?>
		<h1><?php esc_html_e( 'Map CSV fields to post metas', 'wp-seopress-pro' ); ?></h1>
		<form method="post" action="<?php echo esc_url( $this->get_next_step_link() ); ?>">
			<p><?php esc_html_e( 'Select fields from your CSV file to map against posts fields, or to ignore during import.', 'wp-seopress-pro' ); ?></p>

			<section class="seopress-importer-mapping-table-wrapper">
				<table class="widefat seopress-importer-mapping-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Column name', 'wp-seopress-pro' ); ?></th>
							<th><?php esc_html_e( 'Map to field', 'wp-seopress-pro' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ( $headers as $index => $name ) : ?>
							<?php $mapped_value = $mapped_items[ $index ]; ?>
							<tr>
								<td class="seopress-importer-mapping-table-name">
									<?php echo esc_html( $name ); ?>
									<?php if ( ! empty( $sample[ $index ] ) ) : ?>
										<span class="description"><?php esc_html_e( 'Sample:', 'wp-seopress-pro' ); ?> <code><?php echo esc_html( $sample[ $index ] ); ?></code></span>
									<?php endif; ?>
								</td>
								<td class="seopress-importer-mapping-table-field">
									<input type="hidden" name="map_from[<?php echo esc_attr( $index ); ?>]" value="<?php echo esc_attr( $name ); ?>" />
									<select name="map_to[<?php echo esc_attr( $index ); ?>]">
										<option value=""><?php esc_html_e( 'Do not import', 'wp-seopress-pro' ); ?></option>
										<option value="">--------------</option>
										<?php foreach ( $this->get_mapping_options( $mapped_value ) as $key => $value ) : ?>
											<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $mapped_value, $key ); ?>><?php echo esc_html( $value ); ?></option>
										<?php endforeach ?>
									</select>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>

			<p class="seopress-setup-actions step">
				<button type="submit" class="button-primary button button-large button-next" value="<?php esc_attr_e( 'Run the importer', 'wp-seopress-pro' ); ?>" name="save_step"><?php esc_html_e( 'Run the importer', 'wp-seopress-pro' ); ?></button>
				<input type="hidden" name="file" value="<?php echo esc_attr( $this->file ); ?>" />
				<input type="hidden" name="delimiter" value="<?php echo esc_attr( $this->delimiter ); ?>" />
				<?php wp_nonce_field( 'seopress-csv-importer' ); ?>
			</p>
		</form>
		<?php
	}

	/**
	 * Import the file if it exists and is valid.
	 */
	public function import() {
		// Displaying this page triggers Ajax action to run the import with a valid nonce,
		// therefore this page needs to be nonce protected as well.
		check_admin_referer( 'seopress-csv-importer' );

		if ( ! self::is_file_valid_csv( $this->file ) ) {
			$this->add_error( __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'wp-seopress-pro' ) );
			$this->output_errors();
			return;
		}

		if ( ! is_file( $this->file ) ) {
			$this->add_error( __( 'The file does not exist, please try again.', 'wp-seopress-pro' ) );
			$this->output_errors();
			return;
		}

		if ( ! empty( $_POST['map_from'] ) && ! empty( $_POST['map_to'] ) ) {
			$mapping_from = seopress_clean(wp_unslash( $_POST['map_from'] ));
			$mapping_to   = seopress_clean(wp_unslash( $_POST['map_to'] ));
		} else {
			wp_redirect( esc_url_raw( $this->get_next_step_link( 'upload' ) ) );
			exit;
		}
		wp_localize_script(
			'seopress-csv-import',
			'seopress_csv_import_params',
			array(
				'import_nonce'    	=> wp_create_nonce( 'seopress-csv-importer' ),
				'mapping'         	=> array(
					'from' => $mapping_from,
					'to'   => $mapping_to,
				),
				'file'            	=> $this->file,
				'delimiter'       	=> $this->delimiter,
			)
		);
		//wp_print_scripts( 'seopress-csv-import' );
		wp_enqueue_script( 'seopress-csv-import' );
		?>
		<h1><?php esc_html_e( 'Importing', 'wp-seopress-pro' ); ?></h1>
		<p><?php esc_html_e( 'Your metadata are now being imported...', 'wp-seopress-pro' ); ?></p>
		<div class="seopress-progress-form-content seopress-importer seopress-importer__importing">
			<section>
				<span class="spinner is-active"></span>
				<progress class="seopress-importer-progress" max="100" value="0"></progress>
			</section>
		</div>
		<?php
	}

	/**
	 * Final step.
	 */
	public function done() {
		check_admin_referer( 'seopress-csv-importer' );
		$imported = isset( $_GET['metadatas-imported'] ) ? absint( $_GET['metadatas-imported'] ) : 0;
		$updated  = isset( $_GET['metadatas-updated'] ) ? absint( $_GET['metadatas-updated'] ) : 0;
		$failed   = isset( $_GET['metadatas-failed'] ) ? absint( $_GET['metadatas-failed'] ) : 0;
		$skipped  = isset( $_GET['metadatas-skipped'] ) ? absint( $_GET['metadatas-skipped'] ) : 0;
		$errors   = array_filter( (array) get_user_option( 'seopress_import_error_log' ) );
		?>
		<h2>
			<span class="dashicons dashicons-yes-alt"></span>
			<?php esc_html_e( "Import complete!", 'wp-seopress-pro' ); ?>
		</h2>

		<div class="seopress-progress-form-content seopress-importer">
			<section class="seopress-importer-done">
				<?php
				$results = array();

				if ( 0 < $imported ) {
					$results[] = sprintf(
						/* translators: %d: posts count */
						_n( '%s metadata imported', '%s posts imported', $imported, 'wp-seopress-pro' ),
						'<strong>' . number_format_i18n( $imported ) . '</strong>'
					);
				}

				if ( 0 < $updated ) {
					$results[] = sprintf(
						/* translators: %d: posts count */
						_n( '%s metadata updated', '%s posts updated', $updated, 'wp-seopress-pro' ),
						'<strong>' . number_format_i18n( $updated ) . '</strong>'
					);
				}

				if ( 0 < $skipped ) {
					$results[] = sprintf(
						/* translators: %d: posts count */
						_n( '%s metadata was skipped', '%s posts were skipped', $skipped, 'wp-seopress-pro' ),
						'<strong>' . number_format_i18n( $skipped ) . '</strong>'
					);
				}

				if ( 0 < $failed ) {
					$results [] = sprintf(
						/* translators: %d: posts count */
						_n( 'Failed to import %s metadata', 'Failed to import %s posts', $failed, 'wp-seopress-pro' ),
						'<strong>' . number_format_i18n( $failed ) . '</strong>'
					);
				}

				if ( 0 < $failed || 0 < $skipped ) {
					$results[] = '<a href="#" class="seopress-importer-done-view-errors">' . __( 'View import log', 'wp-seopress-pro' ) . '</a>';
				}

				/* translators: %d: import results */
				echo '<p>'.wp_kses_post( __( 'Import complete!', 'wp-seopress-pro' ) . ' ' . implode( '. ', $results ) ).'</p>';
				?>
			</section>
			<section class="seopress-importer-error-log" style="display:none">
				<table class="widefat seopress-importer-error-log-table">
					<thead>
						<tr>
							<th><?php esc_html_e( 'Post', 'wp-seopress-pro' ); ?></th>
							<th><?php esc_html_e( 'Reason for failure', 'wp-seopress-pro' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						if ( count( $errors ) ) {
							foreach ( $errors as $error ) {
								if ( ! is_wp_error( $error ) ) {
									continue;
								}
								$error_data = $error->get_error_data();
								?>
								<tr>
									<th><code><?php echo esc_html( $error_data['row'] ); ?></code></th>
									<td><?php echo esc_html( $error->get_error_message() ); ?></td>
								</tr>
								<?php
							}
						}
						?>
					</tbody>
				</table>
			</section>
			<script type="text/javascript">
				jQuery(function() {
					jQuery( '.seopress-importer-done-view-errors' ).on( 'click', function() {
						jQuery( '.seopress-importer-error-log' ).slideToggle();
						return false;
					} );
				} );
			</script>
			<div class="seopress-actions">
				<p>
					<a class="button button-primary" href="<?php echo esc_url( admin_url( 'edit.php' ) ); ?>"><?php esc_html_e( 'View posts', 'wp-seopress-pro' ); ?></a>
				</p>
			</div>
		</div>
		<?php
	}

	/**
	 * Columns to normalize.
	 *
	 * @param  array $columns List of columns names and keys.
	 * @return array
	 */
	protected function normalize_columns_names( $columns ) {
		$normalized = array();

		foreach ( $columns as $key => $value ) {
			$normalized[ strtolower( $key ) ] = $value;
		}

		return $normalized;
	}

	/**
	 * Auto map column names.
	 *
	 * @param  array $raw_headers Raw header columns.
	 * @param  bool  $num_indexes If should use numbers or raw header columns as indexes.
	 * @return array
	 */
	protected function auto_map_columns( $raw_headers, $num_indexes = true ) {
		$default_columns = $this->normalize_columns_names(
			apply_filters(
				'seopress_csv_metadata_import_mapping_default_columns',
				array(
					__( 'ID', 'wp-seopress-pro' )					=> 'id',
					__( 'Meta Title', 'wp-seopress-pro' )			=> 'meta_title',
					__( 'Meta description', 'wp-seopress-pro' )		=> 'meta_desc',
					__( 'Facebook title', 'wp-seopress-pro' )		=> 'fb_title',
					__( 'Facebook description', 'wp-seopress-pro' )	=> 'fb_desc',
					__( 'Facebook thumbnail', 'wp-seopress-pro' )	=> 'fb_img',
					__( 'Twitter title', 'wp-seopress-pro' )		=> 'tw_title',
					__( 'Twitter description', 'wp-seopress-pro' )	=> 'tw_desc',
					__( 'Twitter thumbnail', 'wp-seopress-pro' )	=> 'tw_img',
					__( 'noindex', 'wp-seopress-pro' )				=> 'noindex',
					__( 'nofollow', 'wp-seopress-pro' )				=> 'nofollow',
					__( 'noodp', 'wp-seopress-pro' )				=> 'noodp',
					__( 'noimageindex', 'wp-seopress-pro' )			=> 'noimageindex',
					__( 'noarchive', 'wp-seopress-pro' )			=> 'noarchive',
					__( 'nosnippet', 'wp-seopress-pro' )			=> 'nosnippet',
					__( 'Canonical URL', 'wp-seopress-pro' )		=> 'canonical_url',
					__( 'Target Keyword', 'wp-seopress-pro' )		=> 'target_kw',
				),
				$raw_headers
			)
		);

		$headers = array();
		foreach ( $raw_headers as $key => $field ) {
			$field             = strtolower( $field );
			$index             = $num_indexes ? $key : $field;
			$headers[ $index ] = $field;

			if ( isset( $default_columns[ $field ] ) ) {
				$headers[ $index ] = $default_columns[ $field ];
			}
		}

		return apply_filters( 'seopress_csv_metadata_import_mapping_default_columns', $headers, $raw_headers );
	}

	/**
	 * Get mapping options.
	 *
	 * @param  string $item Item name.
	 * @return array
	 */
	protected function get_mapping_options( $item = '' ) {
		// Available options.
		$options        = array(
			'id'                 	=> __( 'ID', 'wp-seopress-pro' ),
			'meta_title'         	=> __( 'Title', 'wp-seopress-pro' ),
			'meta_desc'          	=> __( 'Meta description', 'wp-seopress-pro' ),
			'fb_title'          	=> __( 'Facebook title', 'wp-seopress-pro' ),
			'fb_desc'          		=> __( 'Facebook description', 'wp-seopress-pro' ),
			'fb_img'          		=> __( 'Facebook thumbnail', 'wp-seopress-pro' ),
			'tw_title'          	=> __( 'Twitter title', 'wp-seopress-pro' ),
			'tw_desc'          		=> __( 'Twitter description', 'wp-seopress-pro' ),
			'tw_img'          		=> __( 'Twitter thumbnail', 'wp-seopress-pro' ),
			'noindex'          		=> __( 'noindex? (yes)', 'wp-seopress-pro' ),
			'nofollow'          	=> __( 'nofollow? (yes)', 'wp-seopress-pro' ),
			'noodp'          		=> __( 'noodp? (yes)', 'wp-seopress-pro' ),
			'noimageindex'          => __( 'noimageindex? (yes)', 'wp-seopress-pro' ),
			'noarchive'          	=> __( 'noarchive? (yes)', 'wp-seopress-pro' ),
			'nosnippet'          	=> __( 'nosnippet? (yes)', 'wp-seopress-pro' ),
			'canonical_url'         => __( 'Canonical URL', 'wp-seopress-pro' ),
			'target_kw'         	=> __( 'Target Keyword', 'wp-seopress-pro' )
		);

		return apply_filters( 'seopress_csv_metadata_import_mapping_options', $options, $item );
	}
}