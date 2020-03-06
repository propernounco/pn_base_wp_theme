<?php
/**
 * HTML content for the Sync Media tab.
 *
 * @package Cloudinary
 */

?>
<?php if ( ! empty( $this->plugin->config['connect'] ) ) : ?>
	<div class="settings-tab-section-card">
		<div class="settings-tab-section-fields-dashboard-success">
			<span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'Auto Sync is on', 'cloudinary' ); ?>
			<p class="description">
				<?php esc_html_e( 'WordPress Media Library assets are synced with Cloudinary automatically when you connect your account.', 'cloudinary' ); ?><br>
				<?php esc_html_e( 'If you had existing assets in your WordPress Media Library you may need to perform a Bulk-Sync below.', 'cloudinary' ); ?>
			</p>
		</div>
	</div>
<?php endif; ?>
