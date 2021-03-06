<?php
/**
 * Defines the tab structure for Cloudinary settings page.
 *
 * @package Cloudinary
 */

$struct = array(
	'title'             => __( 'Video Settings', 'cloudinary' ),
	'heading'           => __( 'Global Video Settings', 'cloudinary' ),
	'success_notice'    => __( 'Global Video Settings have been updated.', 'cloudinary' ),
	'classes'           => array(
		'connect',
	),
	'sanitize_callback' => function ( $value ) {
		if ( 'off' === $value['video_autoplay'] && 'off' === $value['video_controls'] && 'off' === $value['video_loop'] ) {
			return new WP_Error( 'cant_play', __( 'At least one of the video player settings must be set to "On".', 'cloudinary' ) );
		}

		return $value;
	},
	'assets'            => array(
		'style'  => array(
			'cld-player',
		),
		'script' => array(
			'cld-player',
		),
	),
	'fields'            => array(
		'video_player'        => array(
			'label'       => __( 'Video player', 'cloudinary' ),
			'description' => __( 'Which video player to use on all videos.', 'cloudinary' ),
			'type'        => 'select',
			'default'     => 'cld',
			'choices'     => array(
				'cld' => __( 'Cloudinary Player', 'cloudinary' ),
				'wp'  => __( 'WordPress Player', 'cloudinary' ),
			),
		),
		'video_controls'      => array(
			'label'     => __( 'Player options', 'cloudinary' ),
			'suffix'    => __( 'Show controls', 'cloudinary' ),
			'type'      => 'checkbox',
			'default'   => 'on',
			'condition' => array(
				'video_player' => 'cld',
			),
		),
		'video_autoplay_mode' => array(
			'label'     => null,
			'prefix'    => __( 'Autoplay:', 'cloudinary' ),
			'type'      => 'select',
			'default'   => 'never',
			'choices'   => array(
				'off'       => __( 'Off', 'cloudinary' ),
				'always'    => __( 'Always', 'cloudinary' ),
				'on-scroll' => __( 'On-Scroll (Autoplay when in view)', 'cloudinary' ),
			),
			'condition' => array(
				'video_player' => 'cld',
			),
		),

		'video_loop'          => array(
			'label'     => null,
			'suffix'    => __( ' Repeat video', 'cloudinary' ),
			'type'      => 'checkbox',
			'default'   => 'off',
			'condition' => array(
				'video_player' => 'cld',
			),
		),
		'video_limit_bitrate' => array(
			'label'       => __( 'Bitrate', 'cloudinary' ),
			'suffix'      => __( 'Limit bitrate', 'cloudinary' ) . ' <a href="https://cloudinary.com/documentation/video_transformation_reference#bit_rate" target="_blank"><span class="dashicons dashicons-info"></span></a>',
			'description' => __( 'If set, all videos will be delivered in the defined bitrate.', 'cloudinary' ),
			'type'        => 'checkbox',
			'context'     => 'video',
		),
		'video_bitrate'       => array(
			'label'       => null,
			'prefix'      => __( 'Bitrate limit', 'cloudinary' ),
			'suffix'      => __( 'k', 'cloudinary' ),
			'description' => __( 'Maximum number of bits per second in Kilobytes.', 'cloudinary' ),
			'type'        => 'number',
			'min'         => '500',
			'default'     => '500',
			'max'         => '90000',
			'context'     => 'video',
			'condition'   => array(
				'video_limit_bitrate' => true,
			),
		),
		'video_freeform'      => array(
			'label'             => __( 'Video Transformation String', 'cloudinary' ),
			'description'       => sprintf(
				// translators: Placeholders are <a> tags.
				__( 'The set of transformations to apply to all video assets, as a URL transformation string. %1$sVideo transformation reference%2$s.', 'cloudinary' ),
				'<br><a href="https://cloudinary.com/documentation/video_transformation_reference" target="_blank">',
				'</a>'
			),
			'type'              => 'textarea',
			'contextual'        => true, // Flags the field to be used in a contextual basis. i.e. taxonomies.
			'context'           => 'video',
			'sanitize_callback' => 'trim',
			'error_notice'      => __( 'Format and Quality cannot be used in free form.' ),
		),
		'video_preview'       => array(
			'label'      => __( 'Preview', 'cloudinary' ),
			'contextual' => true, // Flags the field to be used in a contextual basis. i.e. taxonomies.
			'context'    => 'video',
			'type'       => function () {
				\Cloudinary\get_plugin_instance()->components['media']->global_transformations->load_preview( true );
			},
		),
	),
);

return apply_filters( 'cloudinary_admin_tab_global_transformations', $struct );
