<?php
/**
 * Class for Syncing Free Theme Settings to Premium.
 *
 * @package formula
 */

if ( ! class_exists( 'Formula_Customize_Sync' ) ) :

	/**
	 * Handles AJAX request to sync settings.
	 */
	class Formula_Customize_Sync {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_formula_sync_settings', array( $this, 'sync_settings' ) );
		}

		/**
		 * Sync settings from Free (theme_mods_formula) to Premium (theme_mods_formula-premium).
		 */
		public function sync_settings() {
			// verification nonce.
			check_ajax_referer( 'formula_sync_nonce', 'nonce' );

			if ( ! current_user_can( 'edit_theme_options' ) ) {
				wp_send_json_error( array( 'message' => __( 'Permission denied.', 'formula' ) ) );
			}

		// 1. Get current theme mods (Free Theme).
			$free_mods = get_theme_mods();

			if ( empty( $free_mods ) ) {
				wp_send_json_error( array( 'message' => __( 'No settings found to sync.', 'formula' ) ) );
			}

			// 2. Key Mapping: Free -> Premium (where names differ).
			$key_map = array(
				'formula_dark_theme_mode' => 'formula_theme_color_mode',
				'formula_custom_color'    => 'formula_color_scheme',
			);

			// 3. Apply key mapping.
			foreach ( $key_map as $free_key => $premium_key ) {
				if ( isset( $free_mods[ $free_key ] ) ) {
					// Copy value to new key.
					$free_mods[ $premium_key ] = $free_mods[ $free_key ];
					// Optionally remove old key to avoid clutter (Premium won't use it).
					unset( $free_mods[ $free_key ] );
				}
			}

			// 4. Target Key for Premium Theme.
			$premium_option_key = 'theme_mods_formula-premium';

			// 5. Save to Premium Key (Option API).
			// We use update_option because theme_mods_X is just an entry in wp_options.
			$updated = update_option( $premium_option_key, $free_mods );

			if ( $updated ) {
				wp_send_json_success( array( 'message' => __( 'Settings successfully synced to Premium!', 'formula' ) ) );
			} else {
				// It handles the case where data is identical too.
				wp_send_json_success( array( 'message' => __( 'Settings are already up to date.', 'formula' ) ) );
			}
		}
	}

	new Formula_Customize_Sync();

endif;
