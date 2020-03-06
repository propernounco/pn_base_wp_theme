<?php
/**
 * Defines the tab structure for Cloudinary settings page.
 *
 * @package Cloudinary
 */
$dirs = wp_get_upload_dir();
$base = wp_parse_url( $dirs['baseurl'] );

$struct = array(
	'title'           => __( 'Sync Media', 'cloudinary' ),
	'description'     => __( 'Sync WordPress Media with Cloudinary', 'cloudinary' ),
	'hide_button'     => true,
	'requires_config' => true,
	'fields'          => array(
		'cloudinary_folder' => array(
			'label'             => __( 'Cloudinary folder path', 'cloudinary' ),
			'description'       => __( 'Specify the folder in your Cloudinary account where WordPress assets are uploaded to. All assets uploaded to WordPress from this point on will be synced to the specified folder in Cloudinary.', 'cloudinary' ),
			'default'           => trim( $base['host'], '/' ),
			'sanitize_callback' => array( '\Cloudinary\Media', 'sanitize_cloudinary_folder' ),
			'required'          => true,
			'suffix'            => '<button type="submit" class="button button-primary">' . __( 'Save folder settings', 'cloudinary' ) . '</button>',
		),
	),
);

return apply_filters( 'cloudinary_admin_tab_sync_media', $struct );
