<?php
/**
 * Class SEOPRESS_Importer_Interface file
 *
 * @package     SEOPress PRO/inc/admin/import
 * @version     3.7
 * @source 		WooCommerce/includes/interfaces/class-wc-importer-interface.php
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SEOPRESS_Importer_Interface class.
 */
interface SEOPRESS_Importer_Interface {

	/**
	 * Process importation.
	 * Returns an array with the imported and failed items.
	 * 'imported' contains a list of IDs.
	 * 'failed' contains a list of WP_Error objects.
	 *
	 * Example:
	 * ['imported' => [], 'failed' => []]
	 *
	 * @return array
	 */
	public function import();

	/**
	 * Get file raw keys.
	 *
	 * CSV - Headers.
	 * XML - Element names.
	 * JSON - Keys
	 *
	 * @return array
	 */
	public function get_raw_keys();

	/**
	 * Get file mapped headers.
	 *
	 * @return array
	 */
	public function get_mapped_keys();

	/**
	 * Get raw data.
	 *
	 * @return array
	 */
	public function get_raw_data();

	/**
	 * Get parsed data.
	 *
	 * @return array
	 */
	public function get_parsed_data();

	/**
	 * Get file pointer position from the last read.
	 *
	 * @return int
	 */
	public function get_file_position();

	/**
	 * Get file pointer position as a percentage of file size.
	 *
	 * @return int
	 */
	public function get_percent_complete();
}