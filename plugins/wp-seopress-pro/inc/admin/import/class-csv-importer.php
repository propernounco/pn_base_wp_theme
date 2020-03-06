<?php
/**
 * Class SEOPRESS_CSV_Setup_Wizard_Controller file
 *
 * @package     SEOPress PRO/inc/admin/import
 * @version     3.7
 * @source 		WooCommerce/Admin/Importers/class-wc-product-csv-importer-controller.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include dependencies.
 */
if ( ! class_exists( 'SEOPRESS_Importer_Interface', false ) ) {
	include_once dirname( __FILE__ ) . '/class-csv-importer-interface.php';
}

/**
 * SEOPRESS_Importer Class.
 */
abstract class SEOPRESS_Importer implements SEOPRESS_Importer_Interface {

	/**
	 * CSV file.
	 *
	 * @var string
	 */
	protected $file = '';

	/**
	 * The file position after the last read.
	 *
	 * @var int
	 */
	protected $file_position = 0;

	/**
	 * Importer parameters.
	 *
	 * @var array
	 */
	protected $params = array();

	/**
	 * Raw keys - CSV raw headers.
	 *
	 * @var array
	 */
	protected $raw_keys = array();

	/**
	 * Mapped keys - CSV headers.
	 *
	 * @var array
	 */
	protected $mapped_keys = array();

	/**
	 * Raw data.
	 *
	 * @var array
	 */
	protected $raw_data = array();

	/**
	 * File positions.
	 *
	 * @var array
	 */
	protected $file_positions = array();

	/**
	 * Parsed data.
	 *
	 * @var array
	 */
	protected $parsed_data = array();

	/**
	 * Start time of current import.
	 *
	 * (default value: 0)
	 *
	 * @var int
	 */
	protected $start_time = 0;

	/**
	 * Get file raw headers.
	 *
	 * @return array
	 */
	public function get_raw_keys() {
		return $this->raw_keys;
	}

	/**
	 * Get file mapped headers.
	 *
	 * @return array
	 */
	public function get_mapped_keys() {
		return ! empty( $this->mapped_keys ) ? $this->mapped_keys : $this->raw_keys;
	}

	/**
	 * Get raw data.
	 *
	 * @return array
	 */
	public function get_raw_data() {
		return $this->raw_data;
	}

	/**
	 * Get parsed data.
	 *
	 * @return array
	 */
	public function get_parsed_data() {
		return apply_filters( 'seopress_csv_importer_parsed_data', $this->parsed_data, $this->get_raw_data() );
	}

	/**
	 * Get importer parameters.
	 *
	 * @return array
	 */
	public function get_params() {
		return $this->params;
	}

	/**
	 * Get file pointer position from the last read.
	 *
	 * @return int
	 */
	public function get_file_position() {
		return $this->file_position;
	}

	/**
	 * Get file pointer position as a percentage of file size.
	 *
	 * @return int
	 */
	public function get_percent_complete() {
		$size = filesize( $this->file );
		if ( ! $size ) {
			return 0;
		}

		return absint( min( round( ( $this->file_position / $size ) * 100 ), 100 ) );
	}

	/**
	 * Process a single item and save.
	 *
	 * @throws Exception If item cannot be processed.
	 * @param  array $data Raw CSV data.
	 * @return array|WP_Error
	 */
	protected function process_item( $data ) {
		try {
			do_action( 'seopress_csv_import_before_process_item', $data );

			if (isset($data['meta_title']) && !empty($data['meta_title'])) {
				update_post_meta($data['id'], '_seopress_titles_title', $data['meta_title']);
			}
			if (isset($data['meta_desc']) && !empty($data['meta_desc'])) {
				update_post_meta($data['id'], '_seopress_titles_desc', $data['meta_desc']);
			}
			if (isset($data['fb_title']) && !empty($data['fb_title'])) {
				update_post_meta($data['id'], '_seopress_social_fb_title', $data['fb_title']);
			}
			if (isset($data['fb_desc']) && !empty($data['fb_desc'])) {
				update_post_meta($data['id'], '_seopress_social_fb_desc', $data['fb_desc']);
			}
			if (isset($data['fb_img']) && !empty($data['fb_img'])) {
				update_post_meta($data['id'], '_seopress_social_fb_img', $data['fb_img']);
			}
			if (isset($data['tw_title']) && !empty($data['tw_title'])) {
				update_post_meta($data['id'], '_seopress_social_twitter_title', $data['tw_title']);
			}
			if (isset($data['tw_desc']) && !empty($data['tw_desc'])) {
				update_post_meta($data['id'], '_seopress_social_twitter_desc', $data['tw_desc']);
			}
			if (isset($data['tw_img']) && !empty($data['tw_img'])) {
				update_post_meta($data['id'], '_seopress_social_twitter_img', $data['tw_img']);
			}
			if (isset($data['noindex']) && $data['noindex'] =='yes' ) {
				update_post_meta($data['id'], '_seopress_robots_index', 'yes');
			}
			if (isset($data['nofollow']) && $data['nofollow'] =='yes') {
				update_post_meta($data['id'], '_seopress_robots_follow', 'yes');
			}
			if (isset($data['noodp']) && $data['noodp'] =='yes') {
				update_post_meta($data['id'], '_seopress_robots_odp', 'yes');
			}
			if (isset($data['noimageindex']) && $data['noimageindex'] =='yes') {
				update_post_meta($data['id'], '_seopress_robots_imageindex', 'yes');
			}
			if (isset($data['noarchive']) && $data['noarchive'] =='yes') {
				update_post_meta($data['id'], '_seopress_robots_archive', 'yes');
			}
			if (isset($data['nosnippet']) && $data['nosnippet'] =='yes') {
				update_post_meta($data['id'], '_seopress_robots_snippet', 'yes');
			}
			if (isset($data['canonical_url']) && !empty($data['canonical_url'])) {
				update_post_meta($data['id'], '_seopress_robots_canonical', $data['canonical_url']);
			}
			if (isset($data['target_kw']) && !empty($data['target_kw'])) {
				update_post_meta($data['id'], '_seopress_analysis_target_kw', $data['target_kw']);
			}

			return array(
				'id'	=> $data['id'],
			);
		} catch ( Exception $e ) {
			return new WP_Error( 'seopress_csv_importer_error', $e->getMessage(), array( 'status' => $e->getCode() ) );
		}
	}

	/**
	 * Memory exceeded
	 *
	 * Ensures the batch process never exceeds 90%
	 * of the maximum WordPress memory.
	 *
	 * @return bool
	 */
	protected function memory_exceeded() {
		$memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
		$current_memory = memory_get_usage( true );
		$return         = false;
		if ( $current_memory >= $memory_limit ) {
			$return = true;
		}
		return apply_filters( 'seopress_metadata_importer_memory_exceeded', $return );
	}

	/**
	 * Get memory limit
	 *
	 * @return int
	 */
	protected function get_memory_limit() {
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		} else {
			// Sensible default.
			$memory_limit = '128M';
		}

		if ( ! $memory_limit || -1 === intval( $memory_limit ) ) {
			// Unlimited, set to 32GB.
			$memory_limit = '32000M';
		}
		return intval( $memory_limit ) * 1024 * 1024;
	}

	/**
	 * Time exceeded.
	 *
	 * Ensures the batch never exceeds a sensible time limit.
	 * A timeout limit of 30s is common on shared hosting.
	 *
	 * @return bool
	 */
	protected function time_exceeded() {
		$finish = $this->start_time + apply_filters( 'seopress_metadata_importer_default_time_limit', 20 ); // 20 seconds
		$return = false;
		if ( time() >= $finish ) {
			$return = true;
		}
		return apply_filters( 'seopress_metadata_importer_time_exceeded', $return );
	}

	/**
	 * Explode CSV cell values using commas by default, and handling escaped
	 * separators.
	 *
	 * @param  string $value     Value to explode.
	 * @param  string $separator Separator separating each value. Defaults to comma.
	 * @return array
	 */
	protected function explode_values( $value, $separator = ',' ) {
		$value  = str_replace( '\\,', '::separator::', $value );
		$values = explode( $separator, $value );
		$values = array_map( array( $this, 'explode_values_formatter' ), $values );

		return $values;
	}

	/**
	 * Remove formatting and trim each value.
	 *
	 * @param  string $value Value to format.
	 * @return string
	 */
	protected function explode_values_formatter( $value ) {
		return trim( str_replace( '::separator::', ',', $value ) );
	}

	/**
	 * The exporter prepends a ' to escape fields that start with =, +, - or @.
	 * Remove the prepended ' character preceding those characters.
	 *
	 * @param  string $value A string that may or may not have been escaped with '.
	 * @return string
	 */
	protected function unescape_data( $value ) {
		$active_content_triggers = array( "'=", "'+", "'-", "'@" );

		if ( in_array( mb_substr( $value, 0, 2 ), $active_content_triggers, true ) ) {
			$value = mb_substr( $value, 1 );
		}

		return $value;
	}

}

/**
 * SEOPRESS_CSV_Importer Class.
 */
class SEOPRESS_CSV_Importer extends SEOPRESS_Importer {

	/**
	 * Tracks current row being parsed.
	 *
	 * @var integer
	 */
	protected $parsing_raw_data_index = 0;

	/**
	 * Initialize importer.
	 *
	 * @param string $file   File to read.
	 * @param array  $params Arguments for the parser.
	 */
	public function __construct( $file, $params = array() ) {
		if ( ! $this->import_allowed() ) {
			return;
		}
		
		$default_args = array(
			'start_pos'        => 0, // File pointer start.
			'end_pos'          => -1, // File pointer end.
			'lines'            => -1, // Max lines to read.
			'mapping'          => array(), // Column mapping. csv_heading => schema_heading.
			'parse'            => false, // Whether to sanitize and format data.
			'delimiter'        => ';', // CSV delimiter.
			'prevent_timeouts' => true, // Check memory and time usage and abort if reaching limit.
			'enclosure'        => '"', // The character used to wrap text in the CSV.
			'escape'           => "\0", // PHP uses '\' as the default escape character. This is not RFC-4180 compliant. This disables the escape character.
		);

		$this->params = wp_parse_args( $params, $default_args );
		$this->file   = $file;

		if ( isset( $this->params['mapping']['from'], $this->params['mapping']['to'] ) ) {
			$this->params['mapping'] = array_combine( $this->params['mapping']['from'], $this->params['mapping']['to'] );
		}
		
		// Import mappings for CSV data.
		include_once dirname( __FILE__ ) . '/mapping.php';

		$this->read_file();
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
	 * Read file.
	 */
	protected function read_file() {
		if ( ! SEOPRESS_CSV_Setup_Wizard_Controller::is_file_valid_csv( $this->file ) ) {
			wp_die( esc_html__( 'Invalid file type. The importer supports CSV and TXT file formats.', 'wp-seopress-pro' ) );
		}

		$handle = fopen( $this->file, 'r' );

		if ( false !== $handle ) {
			$this->raw_keys = version_compare( PHP_VERSION, '5.3', '>=' ) ? array_map( 'trim', fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'], $this->params['escape'] ) ) : array_map( 'trim', fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'] ) );

			// Remove BOM signature from the first item.
			if ( isset( $this->raw_keys[0] ) ) {
				$this->raw_keys[0] = $this->remove_utf8_bom( $this->raw_keys[0] );
			}

			if ( 0 !== $this->params['start_pos'] ) {
				fseek( $handle, (int) $this->params['start_pos'] );
			}

			while ( 1 ) {
				$row = version_compare( PHP_VERSION, '5.3', '>=' ) ? fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'], $this->params['escape'] ) : fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'] );

				if ( false !== $row ) {
					$this->raw_data[]                                 = $row;
					$this->file_positions[ count( $this->raw_data ) ] = ftell( $handle );

					if ( ( $this->params['end_pos'] > 0 && ftell( $handle ) >= $this->params['end_pos'] ) || 0 === --$this->params['lines'] ) {
						break;
					}
				} else {
					break;
				}
			}

			$this->file_position = ftell( $handle );
		}

		if ( ! empty( $this->params['mapping'] ) ) {
			$this->set_mapped_keys();
		}

		if ( $this->params['parse'] ) {
			$this->set_parsed_data();
		}
	}

	/**
	 * Remove UTF-8 BOM signature.
	 *
	 * @param string $string String to handle.
	 *
	 * @return string
	 */
	protected function remove_utf8_bom( $string ) {
		if ( 'efbbbf' === substr( bin2hex( $string ), 0, 6 ) ) {
			$string = substr( $string, 3 );
		}

		return $string;
	}

	/**
	 * Set file mapped keys.
	 */
	protected function set_mapped_keys() {
		$mapping = $this->params['mapping'];

		foreach ( $this->raw_keys as $key ) {
			$this->mapped_keys[] = isset( $mapping[ $key ] ) ? $mapping[ $key ] : $key;
		}
	}

	/**
	 * Parse the ID field.
	 *
	 * If we're not doing an update, create a placeholder metadata so mapping works
	 * for rows following this one.
	 *
	 * @param string $value Field value.
	 *
	 * @return int
	 */
	public function parse_id_field( $value ) {
		global $wpdb;

		$id = absint( $value );

		if ( ! $id ) {
			return 0;
		}

		return $id && ! is_wp_error( $id ) ? $id : 0;
	}

	/**
	 * Parse images list from a CSV. Images can be filenames or URLs.
	 *
	 * @param string $value Field value.
	 *
	 * @return array
	 */
	public function parse_images_field( $value ) {
		if ( empty( $value ) ) {
			return '';
		}

		$images    = '';
		$separator = apply_filters( 'seopress_metadata_import_image_separator', ',' );

		if ( stristr( $value, '://' ) ) {
			$images = esc_url_raw( $value );
		} else {
			$images = sanitize_file_name( $value );
		}

		return $images;
	}

	/**
	 * Just skip current field.
	 *
	 * By default is applied seopress_clean() to all not listed fields
	 * in self::get_formating_callback(), use this method to skip any formating.
	 *
	 * @param string $value Field value.
	 *
	 * @return string
	 */
	public function parse_skip_field( $value ) {
		return $value;
	}

	/**
	 * Parse a description value field
	 *
	 * @param string $description field value.
	 *
	 * @return string
	 */
	public function parse_description_field( $description ) {
		$parts = explode( "\\\\n", $description );
		foreach ( $parts as $key => $part ) {
			$parts[ $key ] = str_replace( '\n', "\n", $part );
		}

		return implode( '\\\n', $parts );
	}

	/**
	 * Get formatting callback.
	 *
	 * @return array
	 */
	protected function get_formating_callback() {

		/**
		 * Columns not mentioned here will get parsed with 'seopress_clean'.
		 * column_name => callback.
		 */
		$data_formatting = array(
			'id'                => array( $this, 'parse_id_field' ),
			'meta_title'        => array( $this, 'parse_skip_field' ),
			'meta_desc'         => array( $this, 'parse_description_field' ),
			'fb_title'          => array( $this, 'parse_skip_field' ),
			'fb_desc'          	=> array( $this, 'parse_description_field' ),
			'fb_img'          	=> array( $this, 'parse_images_field' ),
			'tw_title'          => array( $this, 'parse_skip_field' ),
			'tw_desc'          	=> array( $this, 'parse_description_field' ),
			'tw_img'          	=> array( $this, 'parse_images_field' ),
			'noindex'          	=> array( $this, 'parse_skip_field' ),
			'nofollow'          => array( $this, 'parse_skip_field' ),
			'noodp'          	=> array( $this, 'parse_skip_field' ),
			'noimageindex'      => array( $this, 'parse_skip_field' ),
			'noarchive'         => array( $this, 'parse_skip_field' ),
			'nosnippet'         => array( $this, 'parse_skip_field' ),
			'canonical_url'     => 'esc_url_raw',
			'target_kw'			=> array( $this, 'parse_skip_field' ),			
		);

		$callbacks = array();

		// Figure out the parse function for each column.
		foreach ( $this->get_mapped_keys() as $index => $heading ) {
			$callback = 'seopress_clean';

			if ( isset( $data_formatting[ $heading ] ) ) {
				$callback = $data_formatting[ $heading ];
			}

			$callbacks[] = $callback;
		}

		return apply_filters( 'seopress_metadata_importer_formatting_callbacks', $callbacks, $this );
	}

	/**
	 * Check if strings starts with determined word.
	 *
	 * @param string $haystack Complete sentence.
	 * @param string $needle   Excerpt.
	 *
	 * @return bool
	 */
	protected function starts_with( $haystack, $needle ) {
		return substr( $haystack, 0, strlen( $needle ) ) === $needle;
	}

	/**
	 * Map and format raw data to known fields.
	 */
	protected function set_parsed_data() {
		$parse_functions = $this->get_formating_callback();
		$mapped_keys     = $this->get_mapped_keys();
		$use_mb          = function_exists( 'mb_convert_encoding' );

		// Parse the data.
		foreach ( $this->raw_data as $row_index => $row ) {
			// Skip empty rows.
			if ( ! count( array_filter( $row ) ) ) {
				continue;
			}

			$this->parsing_raw_data_index = $row_index;

			$data = array();

			do_action( 'seopress_metadata_importer_before_set_parsed_data', $row, $mapped_keys );

			foreach ( $row as $id => $value ) {
				// Skip ignored columns.
				if ( empty( $mapped_keys[ $id ] ) ) {
					continue;
				}

				// Convert UTF8.
				if ( $use_mb ) {
					$encoding = mb_detect_encoding( $value, mb_detect_order(), true );
					if ( $encoding ) {
						$value = mb_convert_encoding( $value, 'UTF-8', $encoding );
					} else {
						$value = mb_convert_encoding( $value, 'UTF-8', 'UTF-8' );
					}
				} else {
					$value = wp_check_invalid_utf8( $value, true );
				}

				$data[ $mapped_keys[ $id ] ] = call_user_func( $parse_functions[ $id ], $value );
			}
			
			$this->parsed_data[] = apply_filters( 'seopress_csv_importer_parsed_data', $data, $this );
		}
	}

	/**
	 * Get a string to identify the row from parsed data.
	 *
	 * @param array $parsed_data Parsed data.
	 *
	 * @return string
	 */
	protected function get_row_id( $parsed_data ) {
		$id       = isset( $parsed_data['id'] ) ? absint( $parsed_data['id'] ) : 0;
		$row_data = array();

		if ( $id ) {
			/* translators: %d: metadata ID */
			$row_data[] = sprintf( __( 'ID %d', 'wp-seopress-pro' ), $id );
		}

		return implode( ', ', $row_data );
	}

	/**
	 * Process importer.
	 *
	 * @return array
	 */
	public function import() {
		$this->start_time = time();
		$index            = 0;
		$data             = array(
			'imported' => array(),
			'failed'   => array(),
			'updated'  => array(),
			'skipped'  => array(),
		);

		foreach ( $this->parsed_data as $parsed_data_key => $parsed_data ) {
			do_action( 'seopress_metadata_import_before_import', $parsed_data );

			$id         = isset( $parsed_data['id'] ) ? absint( $parsed_data['id'] ) : 0;

			if ( $id ) {
				$metadata   = get_post( $id );
			}

			$result = $this->process_item( $parsed_data );

			if ( is_wp_error( $result ) ) {
				$result->add_data( array( 'row' => $this->get_row_id( $parsed_data ) ) );
				$data['failed'][] = $result;
			} elseif ( $result['updated'] ) {
				$data['updated'][] = $result['id'];
			} else {
				$data['imported'][] = $result['id'];
			}

			$index ++;

			if ( $this->params['prevent_timeouts'] && ( $this->time_exceeded() || $this->memory_exceeded() ) ) {
				$this->file_position = $this->file_positions[ $index ];
				break;
			}
		}

		return $data;
	}
}