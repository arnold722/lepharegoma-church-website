<?php

// If the class is not found, terminate further execution of the script.
if ( class_exists( 'Solace_Extra_Admin' ) ) {
    return;
}

/**
 * Display admin notice.
 */
function solace_display_admin_notice() {
	$active_plugins = get_option( 'active_plugins' );
	if ( ! is_array( $active_plugins ) ) {
        $active_plugins = [];
    }
	if ( in_array( 'solace-extra/solace-extra.php', $active_plugins ) ) {
		return;
	}

	?>
	<div class="notice-success notice-solace notice is-dismissible" style="width: 100%; padding: 0; background-image: url(<?php echo esc_url( SOLACE_ASSETS_URL . 'img/dashboard/solace-banner-dashboard.jpg' ); ?>); background-position: center; background-repeat: no-repeat; background-size: cover; min-height: 300px; max-height: 400px;">
		<div class="boxes">
			<div class="solace-col-left">
				<h2 class="notice-title"><?php esc_html_e( 'Welcome to Solace Theme! Build Your Stunning Website with Ease', 'solace' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Get started quickly with our Starter Templates and create a professional website in minutes.', 'solace' ); ?></p>
				<div class="notice-actions">
				<?php
				// Ensure the is_plugin_active function is available
				if ( ! function_exists( 'is_plugin_active' ) ) {
					include_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$plugin_file = 'solace-extra/solace-extra.php';
				$plugin_path = WP_PLUGIN_DIR . '/' . $plugin_file;

				// Check if the plugin file exists (plugin is installed)
				if ( file_exists( $plugin_path ) ) {
					// Plugin is installed but not active
					if ( ! is_plugin_active( $plugin_file ) ) {
						?>
						<button type="button" class="starter-templates">
							<?php esc_html_e( "Activate Starter Templates", 'solace' ); ?>
						</button>
						<?php
					}
				} else {
					// Plugin is not installed
					?>
					<button type="button" class="starter-templates">
						<?php esc_html_e( "Install Starter Templates Now", 'solace' ); ?>
					</button>
					<?php
				}
				?>
				</div>
				<a class="error" style="display: none;" href="<?php echo esc_url('#'); ?>" target="_blank"></a>
				<p class="sub-notice-description">
					<?php esc_html_e( 'Got feedback or found a bug?', 'solace' ); ?>
					<a href="<?php echo esc_url('https://solacewp.com/suggestions/'); ?>" target="_blank">
						<?php esc_html_e( 'Let Us Know Here', 'solace' ); ?>
					</a>
				</p>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'admin_notices', 'solace_display_admin_notice' );

/**
 * Handle AJAX request to check if specified plugins are active.
 *
 * This function expects a security nonce and an array of plugin slugs.
 * It returns a JSON response indicating whether each plugin is active,
 * inactive, or missing (not installed).
 *
 * @return void
 */
function solace_ajax_check_plugins_status() {
	// Ensure only users with plugin management capabilities can check plugin status.
	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error( [
			'message' => 'Insufficient permissions.',
			'status'  => 'error',
		] );
	}

	// Verify the security nonce.
	if (
		! isset( $_POST['solace_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['solace_nonce'] ) ), 'solace-ajax-verification' )
	) {
		// Return error if nonce is invalid or missing.
		wp_send_json_error( [
			'message' => 'Security check failed. Invalid or missing nonce',
			'status'  => 'error',
		] );
	}

	if ( ! current_user_can( 'activate_plugins' ) ) {
        wp_send_json_error( [
            'message' => 'Unauthorized access.',
            'status'  => 'error',
        ], 403 );
        return;
    }

	// Check if plugin_slugs parameter is provided and is an array.
	if ( empty( $_POST['plugin_slugs'] ) || ! is_array( $_POST['plugin_slugs'] ) ) {
		// Return error if plugin_slugs parameter is missing or not an array.
		wp_send_json_error( [
			'message' => 'Missing or invalid plugin_slugs parameter. Expected a non-empty array.',
			'status'  => 'error',
		] );
	}

	$plugin_slugs  = $_POST['plugin_slugs'];
	$invalid_slugs = [];

	// Sanitize and validate each plugin slug.
	foreach ( $plugin_slugs as $key => $slug ) {
		$sanitized = sanitize_text_field( $slug );

		// Slug must be lowercase letters, numbers, and dashes only.
		if ( empty( $sanitized ) || ! preg_match( '/^[a-z0-9\-]+$/', $sanitized ) ) {
			$invalid_slugs[] = $slug;
			unset( $plugin_slugs[ $key ] );
		} else {
			$plugin_slugs[ $key ] = $sanitized;
		}
	}

	// Return error if any of the slugs are invalid.
	if ( ! empty( $invalid_slugs ) ) {
		wp_send_json_error( [
			'message'       => 'Invalid plugin slug(s) provided.',
			'invalid_slugs' => $invalid_slugs,
			'status'        => 'error',
		] );
	}

	$results = [];

	// Check each plugin's status.
	foreach ( $plugin_slugs as $slug ) {
		$plugin_file      = $slug . '/' . $slug . '.php';
		$plugin_file_path = WP_PLUGIN_DIR . '/' . $plugin_file;

		// If the plugin file doesn't exist, mark it as "missing".
		if ( ! file_exists( $plugin_file_path ) ) {
			$results[ $slug ] = [
				'active'  => false,
				'status'  => 'missing',
				'message' => 'Plugin file not found',
			];
			continue;
		}

		// Check if the plugin is active.
		$is_active = is_plugin_active( $plugin_file );

		$results[ $slug ] = [
			'active' => $is_active,
			'status' => $is_active ? 'active' : 'inactive',
		];
	}

	// Return a success response with plugin status details.
	wp_send_json_success( [
		'success' => true,
		'status'  => 'success',
		'plugins' => $results,
	] );

	wp_die();
}
add_action( 'wp_ajax_solace_check_plugin_status', 'solace_ajax_check_plugins_status' );

/**
 * Handle AJAX request to install plugins from WordPress.org.
 */
function solace_ajax_install_plugins_from_wporg() {
	// Ensure only users with plugin installation capabilities can install plugins.
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_send_json_error( [
			'message' => 'Insufficient permissions.',
			'status'  => 'error',
		] );
	}

	// Validate nonce.
	if (
		! isset( $_POST['solace_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['solace_nonce'] ) ), 'solace-ajax-verification' )
	) {
		wp_send_json_error( [
			'message' => 'Security check failed. Invalid or missing nonce',
			'status'  => 'error',
		] );
	}

	if ( ! current_user_can( 'install_plugins' ) ) {
        wp_send_json_error( [
            'message' => 'Unauthorized: You do not have permission to install plugins.',
            'status'  => 'error',
        ], 403 );
        return;
    }

	// Validate input.
	if ( empty( $_POST['plugin_slugs'] ) || ! is_array( $_POST['plugin_slugs'] ) ) {
		wp_send_json_error( [
			'message' => 'No plugin slugs provided.',
			'status'  => 'error',
		] );
	}

	// Include required files.
	require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
	require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/misc.php';
	require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

	$slugs   = array_map( 'sanitize_text_field', wp_unslash( $_POST['plugin_slugs'] ) );
	$results = [];

	foreach ( $slugs as $slug ) {
		// Get plugin info.
		$api = plugins_api( 'plugin_information', [
			'slug'   => $slug,
			'fields' => [ 'sections' => false ],
		] );

		if ( is_wp_error( $api ) ) {
			$results[ $slug ] = [
				'message' => 'Plugin not found on WordPress.org.',
				'status'  => 'error',
			];
			continue;
		}

		// Check if already installed.
		$installed_plugins = get_plugins();
		$is_installed = false;

		foreach ( $installed_plugins as $plugin_file => $plugin_data ) {
			if ( strpos( $plugin_file, $slug . '/' ) === 0 || strpos( $plugin_file, $slug . '.php' ) !== false ) {
				$is_installed = true;
				break;
			}
		}

		if ( $is_installed ) {
			$results[ $slug ] = [
				'message' => 'Plugin is already installed.',
				'status'  => 'already_installed',
			];
			continue;
		}

		// Install plugin.
		$upgrader = new Plugin_Upgrader( new WP_Ajax_Upgrader_Skin() );
		$result   = $upgrader->install( $api->download_link );

		if ( is_wp_error( $result ) ) {
			$results[ $slug ] = [
				'message' => $result->get_error_message(),
				'status'  => 'error',
			];
		} elseif ( $result === false ) {
			$results[ $slug ] = [
				'message' => 'Installation failed due to unknown reason.',
				'status'  => 'error',
			];
		} else {
			$results[ $slug ] = [
				'message' => 'Plugin installed successfully.',
				'status'  => 'success',
			];
		}
	}

	wp_send_json_success( [
		'status'  => 'completed',
		'results' => $results,
	] );

	wp_die();
}
add_action( 'wp_ajax_solace_install_plugin', 'solace_ajax_install_plugins_from_wporg' );

/**
 * Handle AJAX request to activate plugins by slug.
 *
 * This function validates the nonce and user capabilities before attempting to activate
 * the provided list of plugin slugs. It returns a status report for each plugin.
 *
 * @return void
 */
function handle_solace_plugin_activation_ajax() {
	// Verify nonce to ensure request authenticity.
	if (
		! isset( $_POST['solace_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['solace_nonce'] ) ), 'solace-ajax-verification' )
	) {
		wp_send_json_error( [
			'message' => 'Security check failed. Invalid or missing nonce',
			'status'  => 'error',
		] );
	}

	// Check if the current user has permission to activate plugins.
	if ( ! current_user_can( 'activate_plugins' ) ) {
		wp_send_json_error( [ 
			'message' => 'Permission denied.',
			'status'  => 'error',
		] );
	}

	// Get the plugin slugs from the AJAX request.
	$plugin_slugs = isset( $_POST['plugin_slugs'] ) ? (array) $_POST['plugin_slugs'] : [];

	// Ensure plugin.php functions are available.
	require_once ABSPATH . 'wp-admin/includes/plugin.php';

	$results = [];

	foreach ( $plugin_slugs as $slug ) {
		// Construct plugin file path using the standard format.
		$plugin_file = "{$slug}/{$slug}.php";

		// Check if plugin file exists.
		if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
			$results[ $slug ] = [ 'status' => 'missing' ];
		} elseif ( is_plugin_active( $plugin_file ) ) {
			// Plugin is already active.
			$results[ $slug ] = [ 'status' => 'already_active' ];
		} else {

			$active_plugins = get_option( 'active_plugins', [] );

			if ( ! is_array( $active_plugins ) ) {
				update_option( 'active_plugins', [] );
			}

			if ( is_multisite() ) {
				$sitewide_plugins = get_site_option( 'active_sitewide_plugins', [] );

				if ( ! is_array( $sitewide_plugins ) ) {
					update_site_option( 'active_sitewide_plugins', [] );
				}
			}

			try {

				$activated = activate_plugin( $plugin_file );

				if ( is_wp_error( $activated ) ) {

					$results[ $slug ] = [
						'status'  => 'failed',
						'message' => $activated->get_error_message(),
					];

				} else {

					$results[ $slug ] = [
						'status' => 'activated',
					];

				}

			} catch ( Throwable $e ) {

				error_log(
					sprintf(
						'Solace activation error for %s: %s',
						$plugin_file,
						$e->getMessage()
					)
				);

				$results[ $slug ] = [
					'status'  => 'failed',
					'message' => $e->getMessage(),
				];

			}
		}
	}

	// Build redirect URL to custom admin page.
	$redirect_url = admin_url( 'admin.php?page=solace' );

	// Return results along with redirect URL.
	wp_send_json_success( [
		'results' => $results,
		'redirect_url' => $redirect_url,
	] );

	wp_die();
}
add_action( 'wp_ajax_solace_activate_plugin', 'handle_solace_plugin_activation_ajax' );