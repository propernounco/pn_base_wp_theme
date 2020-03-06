<?php
/**
 * Upload Sync to Cloudinary.
 *
 * @package Cloudinary
 */

namespace Cloudinary\Sync;

use Cloudinary\Sync;

/**
 * Class Upload_Queue.
 *
 * Queue assets for Cloudinary sync.
 */
class Upload_Queue {

	/**
	 * Holds the plugin instance.
	 *
	 * @since   0.1
	 *
	 * @var     \Cloudinary\Plugin Instance of the global plugin.
	 */
	private $plugin;

	/**
	 * Holds the key for saving the queue.
	 *
	 * @var     string
	 */
	private static $queue_key = '_cloudinary_sync_queue';

	/**
	 * Holds flag to make the queue run.
	 *
	 * @var     bool
	 */
	private $running = null;

	/**
	 * Upload_Queue constructor.
	 *
	 * @param \Cloudinary\Plugin $plugin The plugin.
	 */
	public function __construct( \Cloudinary\Plugin $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Get the current Queue.
	 *
	 * @return array|mixed
	 */
	public function get_queue() {
		$queue = get_option( self::$queue_key, array() );
		if ( empty( $queue ) ) {
			$queue = $this->build_queue();
		}

		return $queue;
	}

	/**
	 * Set the queue.
	 *
	 * @param array $queue The queue array to set.
	 *
	 * @return bool
	 */
	public function set_queue( $queue ) {
		return update_option( self::$queue_key, $queue );
	}

	/**
	 * Get a set of pending items.
	 *
	 * @return bool
	 */
	public function get_post() {
		$id = 0;
		if ( $this->is_running() ) {
			$queue = $this->get_queue();
			if ( ! empty( $queue['pending'] ) ) {
				$id                    = array_shift( $queue['pending'] );
				$queue['processing'][] = $id;
				$this->set_queue( $queue );
			}
		}

		return $id;
	}


	/**
	 * Mark an id as done or error.
	 *
	 * @param int    $id   The post ID.
	 * @param string $type The type of marking to apply.
	 */
	public function mark( $id, $type = 'done' ) {
		$queue = $this->get_queue();
		$key   = array_search( (int) $id, $queue['processing'], true );
		if ( false !== $key ) {
			unset( $queue['processing'][ $key ] );
			if ( 'error' === $type ) {
				$state = $this->plugin->components['sync']->managers['push']->prepare_upload( $id );
				if ( is_wp_error( $state ) ) {
					$file             = get_attached_file( $id );
					$queue[ $type ][] = '<div>' . basename( $file ) . ': ' . $state->get_error_message() . '</div>';
					// Add a flag that this file had an error as to not try process it again.
					update_post_meta( $id, Sync::META_KEYS['sync_error'], $state->get_error_message() );
				}
			} else {
				if ( ! in_array( $id, $queue[ $type ], true ) ) {
					$queue[ $type ][] = $id;
				}
			}
		}
		$this->set_queue( $queue );
	}

	/**
	 * Check if the queue is running.
	 *
	 * @return bool
	 */
	public function is_running() {
		if ( null === $this->running ) {
			$queue         = $this->get_queue();
			$this->running = empty( $queue['started'] ) ? false : true;
		}

		return $this->running;
	}

	/**
	 * Gets the current upload sync queue status.
	 *
	 * @return array
	 */
	public function get_queue_status() {
		$queue      = $this->get_queue();
		$pending    = count( $queue['pending'] );
		$done       = count( $queue['done'] );
		$processing = count( $queue['processing'] );
		$error      = count( $queue['error'] );
		$total      = $done + $pending + $processing + $error;
		$completed  = $done;
		$file       = null;
		if ( ! empty( $queue['processing'][0] ) ) {
			$file = get_attached_file( $queue['processing'][0] );
		}
		$percent = 100;
		if ( $completed < $total ) {
			$percent = round( ( $completed + $error ) / ( $total ) * 100, 1 );
		}

		$return = array(
			'total'        => $total,
			'processing'   => $processing,
			'current_file' => $file ? basename( $file ) : null,
			'pending'      => $pending + $processing,
			'done'         => $completed,
			'error'        => $queue['error'],
			'percent'      => $percent,
		);
		if ( ! empty( $queue['started'] ) ) {
			$return['started'] = $queue['started'];
		}

		// Auto Stop.
		if ( 100 === $return['percent'] ) {
			$this->stop_queue();
		}

		return $return;
	}

	/**
	 * Build the upload sync queue.
	 */
	public function build_queue() {

		$args = array(
			'post_type'           => 'attachment',
			'post_mime_type'      => array( 'image', 'video' ),
			'post_status'         => 'inherit',
			'posts_per_page'      => 1000, // phpcs:ignore
			'fields'              => 'ids',
			'meta_query'          => array( // phpcs:ignore
				'relation' => 'AND',
				array(
					'key'     => Sync::META_KEYS['sync_error'],
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => Sync::META_KEYS['public_id'],
					'compare' => 'NOT EXISTS',
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => Sync::META_KEYS['signature'],
						'compare' => 'NOT EXISTS',
					),
				),
			),
			'ignore_sticky_posts' => false,
			'no_found_rows'       => true,
		);

		$attachments = new \WP_Query( $args );
		$ids         = $attachments->get_posts();
		// Transform attachments.
		$return = array(
			'pending'    => array(),
			'large'      => array(),
			'done'       => array(),
			'processing' => array(),
			'error'      => array(),
		);

		// Add items to pending queue.
		$return['pending'] = $ids;

		$this->set_queue( $return );

		return $return;
	}

	/**
	 * Stop the queue by removing the started flag.
	 */
	public function stop_queue() {
		$queue = $this->get_queue();
		if ( ! empty( $queue['started'] ) ) {
			unset( $queue['started'] );
			$this->set_queue( $queue );
		}
		$this->running = false;
	}


	/**
	 * Startthe queue by setting the started flag.
	 */
	public function start_queue() {
		$queue            = $this->get_queue();
		$queue['started'] = current_time( 'timestamp' );
		$this->set_queue( $queue );
		$this->running = true;
	}

}
