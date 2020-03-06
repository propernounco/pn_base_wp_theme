<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

function seopress_license_menu() {
	$seopress_license_help_tab = add_submenu_page('seopress-option', __('License','wp-seopress'), __('License','wp-seopress'), 'manage_options', 'seopress-license', 'seopress_pro_license_page');

	function seopress_license_help_tab() {
	    $screen = get_current_screen();

	    $seopress_license_help_tab_content = wp_oembed_get('https://youtu.be/cUqUQAp49ks', array('width'=>530)).'<br>';
	    $seopress_license_help_tab_content .= __('<strong>Steps to follow to activate your license:</strong> <ul><li>1/ Paste your license key</li> <li>2/ Save changes</li> <li>3/ Activate License.</li> <li>That\'s it! Do NOT save changes after that!</li></ul>','wp-seopress-pro');

	    $screen->add_help_tab( array(
	        'id'    => 'seopress_license_help_tab',
	        'title' => __('Enable your license'),
	        'content'   => $seopress_license_help_tab_content,
	    ));

	    if (function_exists('seopress_get_locale')) {
	        if (seopress_get_locale() =='fr') {
	            $screen->set_help_sidebar(
	                '<ul>
	                    <li><a href="https://www.seopress.org/fr/support/guides/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Browse our guides","wp-seopress").'</a></li>
	                    <li><a href="https://www.seopress.org/fr/support/faq/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Read our FAQ","wp-seopress").'</a></li>
	                    <li><a href="https://www.seopress.org/fr/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Check our website","wp-seopress").'</a></li>
	                </ul>'
	            );
	        } else {
	            $screen->set_help_sidebar(
	                '<ul>
	                    <li><a href="https://www.seopress.org/support/guides/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Browse our guides","wp-seopress").'</a></li>
	                    <li><a href="https://www.seopress.org/support/faq/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Read our FAQ","wp-seopress").'</a></li>
	                    <li><a href="https://www.seopress.org/?utm_source=plugin&utm_medium=wp-admin-help-tab&utm_campaign=seopress" target="_blank">'.__("Check our website","wp-seopress").'</a></li>
	                </ul>'
	            );
	        }
	    }
	}
	add_action('load-'.$seopress_license_help_tab, 'seopress_license_help_tab');
}
add_action('admin_menu', 'seopress_license_menu', 20);

function seopress_pro_license_page() {
	$license 	= get_option( 'seopress_pro_license_key' );
	$selected 	= $license ? '********************************' : '';
	$status 	= get_option( 'seopress_pro_license_status' );
	$seopress_docs_link = array();
	
		if (is_plugin_active('wp-seopress/seopress.php')) {
            if (function_exists('seopress_admin_header')) {
                echo seopress_admin_header();
            }
        }
	?>

		<form class="seopress-option" method="post" action="<?php echo admin_url('options.php'); ?>">

			<h1><span class="dashicons dashicons-admin-network"></span><?php _e('Plugin License Options', 'wp-seopress-pro'); ?></h1>
			
			<?php 
				if (function_exists('seopress_get_locale')) {
		            if (seopress_get_locale() =='fr') {
		                $seopress_docs_link['support']['license'] = 'https://www.seopress.org/fr/compte/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
		                $seopress_docs_link['support']['license_errors'] = 'https://www.seopress.org/fr/support/guides/activer-licence-seopress-pro/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
		            } else {
		                $seopress_docs_link['support']['license'] = 'https://www.seopress.org/account/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
		                $seopress_docs_link['support']['license_errors'] = 'https://www.seopress.org/support/guides/activate-seopress-pro-license/?utm_source=plugin&utm_medium=wp-admin&utm_campaign=seopress';
		            }
		        }
	        ?>

			<?php settings_fields('seopress_license'); ?>
			<p><?php _e('The license key is used to access automatic updates and support.','wp-seopress-pro'); ?></p>
			<p>
				<a href="<?php echo $seopress_docs_link['support']['license']; ?>" class="button" target="_blank"><span class="dashicons dashicons-external"></span><?php _e('View my account','wp-seopress-pro'); ?></a>
				<button id="seopress_pro_license_reset" class="button"><span class="dashicons dashicons-update"></span><?php _e('Reset your license','wp-seopress-pro'); ?></button>
			</p>
			<p><?php _e('<strong>Steps to follow to activate your license:</strong>','wp-seopress-pro'); ?></p>
			<ul><?php _e('<li>1/ Paste your license key</li> <li>2/ Save changes</li> <li>3/ Activate License.</li> <li>That\'s it! Do NOT save changes after that!</li>','wp-seopress-pro'); ?></ul>
			<p>
				<a href="<?php echo $seopress_docs_link['support']['license_errors']; ?>" target="_blank">
					<?php _e('Download unauthorized? - Can‘t activate?','wp-seopress-pro'); ?>
				</a>
			</p>
			<table class="form-table" role="presentation">
				<tbody>
					<tr valign="top">
						<td valign="top">
							<strong><?php _e('License Key', 'wp-seopress-pro'); ?></strong>
						</td>
						<td>
							<input id="seopress_pro_license_key" name="seopress_pro_license_key" type="password" autocomplete="off" class="regular-text" value="<?php esc_attr_e( $selected ); ?>" />
							<label class="description" for="seopress_pro_license_key"><?php _e('Enter your license key', 'wp-seopress-pro'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">
							<td scope="row" valign="top">
								<strong><?php _e('Activate License', 'wp-seopress-pro'); ?></strong>
							</td>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color: green;vertical-align: middle;margin: 0 0 0 10px;line-height: 30px;font-style: italic;font-weight: bold;"><?php _e('active', 'wp-seopress-pro'); ?></span>
									<?php wp_nonce_field( 'seopress_nonce', 'seopress_nonce' ); ?>
									<input id="seopress-edd-license-btn" type="submit" class="button-secondary" name="seopress_license_deactivate" value="<?php _e('Deactivate License', 'wp-seopress-pro'); ?>"/>
									<div class="spinner"></div>
								<?php } else {
									wp_nonce_field( 'seopress_nonce', 'seopress_nonce' ); ?>
									<input id="seopress-edd-license-btn" type="submit" class="button-secondary" name="seopress_license_activate" value="<?php _e('Activate License', 'wp-seopress-pro'); ?>"/>
									<div class="spinner"></div>
								<?php } ?>
							</td>
						</tr>
						<?php if ( isset( $_GET['sl_activation'] ) && ! empty( $_GET['message'] ) ) { ?>
							<tr valign="top">
								<td scope="row" valign="top">
									<strong><?php _e('License status','wp-seopress-pro'); ?></strong>
								</td>
								<td>
									<?php
									switch( $_GET['sl_activation'] ) {
										case 'false':
											$message = htmlspecialchars(urldecode( $_GET['message'] ));
											?>
											<div class="notice notice-error" style="margin-left: 0">
												<p><?php echo $message; ?></p>
											</div>
											<?php
											break;
										case 'true':
										default:
											?>
											<div class="notice notice-success" style="margin-left: 0">
												<p><?php _e('Your license has been successfully activated!','wp-seopress-pro'); ?></p>
											</div>
											<?php
											break;
									} ?>
								</td>
							</tr>
						<?php }
					} ?>
				</tbody>
			</table>
			<?php if( $status !== false && $status == 'valid' ) {
				//do nothing
			} else {
				submit_button();
			} ?>
		</form>
	<?php
}

function seopress_register_option() {
	// creates our settings in the options table
	register_setting('seopress_license', 'seopress_pro_license_key', 'seopress_sanitize_license' );
}
add_action('admin_init', 'seopress_register_option');

function seopress_sanitize_license( $new ) {
	$old = get_option( 'seopress_pro_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'seopress_pro_license_status' ); // new license has been entered, so must reactivate
	}
	if ($new =='********************************') {
		return $old;
	} else {
		return $new;
	}
}

/************************************
* this illustrates how to activate
* a license key
*************************************/

function seopress_activate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['seopress_license_activate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'seopress_nonce', 'seopress_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'seopress_pro_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_id' 	 => ITEM_ID_SEOPRESS, // the ID of our product in EDD
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( STORE_URL_SEOPRESS, array( 'user-agent' =>'WordPress/' . get_bloginfo( 'version' ), 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again. Response code: ', 'wp-seopress-pro' ).wp_remote_retrieve_response_code( $response );
			}

		} else {

			$license_data = json_decode( wp_remote_retrieve_body( $response ) );
			if ( false === $license_data->success ) {

				switch( $license_data->error ) {

					case 'expired' :

						$message = sprintf(
							__( 'Your license key expired on %s.', 'wp-seopress-pro' ),
							date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires, current_time( 'timestamp' ) ) )
						);
						break;

					case 'revoked' :

						$message = __( 'Your license key has been disabled.', 'wp-seopress-pro' );
						break;

					case 'missing' :

						$message = __( 'Invalid license.', 'wp-seopress-pro' );
						break;

					case 'invalid' :
					case 'site_inactive' :

						$message = __( 'Your license is not active for this URL.', 'wp-seopress-pro' );
						break;

					case 'item_name_mismatch' :

						$message = sprintf( __( 'This appears to be an invalid license key for %s.', 'wp-seopress-pro' ), ITEM_NAME_SEOPRESS );
						break;

					case 'no_activations_left':

						$message = __( 'Your license key has reached its activation limit.', 'wp-seopress-pro' );
						break;

					default :

						$message = __( 'An error occurred, please try again.', 'wp-seopress-pro' );
						break;
				}
			}
		}

		// Check if anything passed on a message constituting a failure
		if ( ! empty( $message ) ) {
			$base_url = admin_url( 'admin.php?page=' . SEOPRESS_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );
			
			wp_redirect( $redirect );
			exit();
		}

		// $license_data->license will be either "valid" or "invalid"

		update_option( 'seopress_pro_license_status', $license_data->license );
		wp_redirect( admin_url( 'admin.php?page=' . SEOPRESS_LICENSE_PAGE ) );
		exit();
	}
}
add_action('admin_init', 'seopress_activate_license');

/***********************************************
* Illustrates how to deactivate a license key.
* This will descrease the site count
***********************************************/

function seopress_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['seopress_license_deactivate'] ) ) {

		// run a quick security check
	 	if( ! check_admin_referer( 'seopress_nonce', 'seopress_nonce' ) )
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'seopress_pro_license_key' ) );


		// data to send in our API request
		$api_params = array(
			'edd_action'=> 'deactivate_license',
			'license' 	=> $license,
			'item_id' 	=> ITEM_ID_SEOPRESS, // the ID of our product in EDD
			'url'       => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( STORE_URL_SEOPRESS, array( 'user-agent' =>'WordPress/' . get_bloginfo( 'version' ), 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {

			if ( is_wp_error( $response ) ) {
				$message = $response->get_error_message();
			} else {
				$message = __( 'An error occurred, please try again.', 'wp-seopress-pro' );
			}

			$base_url = admin_url( 'admin.php?page=' . SEOPRESS_LICENSE_PAGE );
			$redirect = add_query_arg( array( 'sl_activation' => 'false', 'message' => urlencode( $message ) ), $base_url );

			wp_redirect( $redirect );
			exit();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' ) {
			delete_option( 'seopress_pro_license_status' );
		}
		
		wp_redirect( admin_url( 'admin.php?page=' . SEOPRESS_LICENSE_PAGE ) );
		exit();
	}
}
add_action('admin_init', 'seopress_deactivate_license');
