<?php
/**
 * Admin functionality
 *
 * Author:          
 * Created on:      17/08/2018
 *
 * @package Solace\Core
 */

namespace Solace\Core;

use Solace\Admin\Dashboard\Plugin_Helper;
use Solace\Core\Settings\Mods_Migrator;

/**
 * Class Admin
 *
 * @package Solace\Core
 */
class Admin {

	/**
	 * Dismiss notice key.
	 *
	 * @var string
	 */
	private $dismiss_notice_key = 'solace_notice_dismissed';
	/**
	 * Current theme name
	 *
	 * @var string $theme_name Theme name.
	 */
	private $theme_name;

	/**
	 * Theme Details
	 *
	 * @var \WP_Theme
	 */
	private $theme_args;

	/**
	 * Admin constructor.
	 */
	public function __construct() {
		$this->set_props();
		add_action(
			'admin_init',
			function () {
				if ( get_option( 'themeisle_ob_plugins_installed' ) !== 'yes' ) {
					return;
				}
				update_option( 'themeisle_blocks_settings_redirect', false );
				delete_transient( 'wpforms_activation_redirect' );
				update_option( 'themeisle_ob_plugins_installed', 'no' );
			},
			0
		);
		add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_gutenberg_scripts' ] );

		if ( get_option( $this->dismiss_notice_key ) !== 'yes' ) {
			add_action( 'wp_ajax_solace_dismiss_welcome_notice', [ $this, 'remove_notice' ] );
		}

		add_action( 'admin_menu', [ $this, 'remove_background_submenu' ], 110 );
		add_action( 'after_switch_theme', [ $this, 'get_previous_theme' ] );

		add_filter( 'all_plugins', array( $this, 'change_plugin_names' ) );

		$this->run_skin_and_builder_switches();

		add_filter( 'ti_tpc_theme_mods_pre_import', [ $this, 'migrate_theme_mods_for_new_skin' ] );

		add_action( 'rest_api_init', [ $this, 'register_rest_routes' ] );
		add_filter( 'solace_pro_react_controls_localization', [ $this, 'adapt_conditional_headers' ] );
		add_filter( 'solace_pro_react_controls_localization', [ $this, 'adapt_conditional_footers' ] );
	}

	/**
	 * Get data specific to TPC plugin.
	 *
	 * @return array
	 */
	private function get_tpc_plugin_data() {
		$plugin_helper = new Plugin_Helper();
		$slug          = 'templates-patterns-collection';

		$tpc_plugin_data['nonce']      = wp_create_nonce( 'wp_rest' );
		$tpc_plugin_data['slug']       = $slug;
		$tpc_plugin_data['cta']        = $plugin_helper->get_plugin_state( $slug );
		$tpc_plugin_data['path']       = $plugin_helper->get_plugin_path( $slug );
		$tpc_plugin_data['activate']   = $plugin_helper->get_plugin_action_link( $slug );
		$tpc_plugin_data['deactivate'] = $plugin_helper->get_plugin_action_link( $slug, 'deactivate' );
		$tpc_plugin_data['version']    = ! empty( $tpc_plugin_data['version'] ) ? $plugin_helper->get_plugin_version( $slug, $tpc_plugin_data['version'] ) : '';
		$tpc_plugin_data['pluginsURL'] = esc_url( admin_url( 'plugins.php' ) );
		$tpc_plugin_data['ajaxURL']    = esc_url( admin_url( 'admin-ajax.php' ) );
		$tpc_plugin_data['ajaxNonce']  = esc_attr( wp_create_nonce( 'remove_notice_confirmation' ) );

		return $tpc_plugin_data;
	}

	/**
	 * Maybe register the script required for the welcome notice.
	 * The script has a component that replaces the "Try one of our ready to use Starter Sites" button.
	 * The button installs/activates and/or dismisses the notice as required.
	 */
	private function maybe_register_notice_script_starter_sites() {
		if ( get_option( $this->dismiss_notice_key, 'no' ) === 'yes' ) {
			return;
		}
		$screen = get_current_screen();
		if ( empty( $screen ) ) {
			return;
		}
		if ( ! in_array( $screen->id, [ 'dashboard', 'themes' ], true ) ) {
			return;
		}

		// wp_localize_script( 'solace-ss-notice', 'tpcPluginData', $this->get_tpc_plugin_data() );
		wp_enqueue_script( 'solace-ss-notice' );
	}

	/**
	 * Register script for react components.
	 */
	public function register_react_components() {
		$this->maybe_register_notice_script_starter_sites();

		$deps = include trailingslashit( SOLACE_MAIN_DIR ) . 'assets/apps/components/build/components.asset.php';

		wp_register_script( 'solace-components', trailingslashit( SOLACE_ASSETS_URL ) . 'apps/components/build/components.js', $deps['dependencies'], $deps['version'], false );
		wp_localize_script(
			'solace-components',
			'nvComponents',
			[
				'shouldUseColorPickerFix' => (int) ( ! solace_is_using_wp_version( '5.8' ) ),
				'customizerURL'           => esc_url( admin_url( 'customize.php' ) ),
			]
		);
		wp_register_style( 'solace-components', trailingslashit( SOLACE_ASSETS_URL ) . 'apps/components/build/style-components.css', [ 'wp-components' ], $deps['version'] );
		wp_add_inline_style( 'solace-components', Dynamic_Css::get_root_css() );
	}

	/**
	 * Switch to the new 3.0 features.
	 *
	 * @return void
	 *
	 * @since 3.0.0
	 */
	public function run_skin_and_builder_switches() {
		$flag = 'solace_ran_migrations';

		if ( get_theme_mod( $flag ) === true ) {
			return;
		}

		set_theme_mod( $flag, true );

		if ( solace_had_old_hfb() ) {
			set_theme_mod( 'solace_migrated_builders', false );
		}

		$all_mods = get_theme_mods();

		$mods = [
			'hfg_header_layout',
			'hfg_footer_layout',
			'solace_blog_archive_layout',
			'solace_headings_font_family',
			'solace_body_font_family',
			'solace_smaller_font_family',
			'solace_logotitle_font_family',
			'solace_button_font_family',
			'solace_global_colors',
			'solace_button_appearance',
			'solace_secondary_button_appearance',
			'solace_typeface_general',
			'solace_form_fields_padding',
			'solace_default_sidebar_layout',
			'solace_advanced_layout_options',
		];

		$should_switch = false;
		foreach ( $mods as $mod_to_check ) {
			if ( isset( $all_mods[ $mod_to_check ] ) ) {
				$should_switch = true;
				break;
			}
		}

		if ( ! $should_switch ) {
			return;
		}

		set_theme_mod( 'solace_new_skin', 'old' );
		set_theme_mod( 'solace_had_old_skin', true );
	}

	/**
	 * Filter out old HFG values if the new builder is active.
	 *
	 * @param array $theme_mods the theme mods array.
	 *
	 * @return array
	 * @since 3.0.0
	 */
	public function migrate_theme_mods_for_new_skin( $theme_mods ) {
		if ( ! solace_is_new_skin() ) {
			return $theme_mods;
		}
		$migrator = new Mods_Migrator( $theme_mods );

		return $migrator->get_migrated_mods();
	}

	/**
	 * Filter localization data to adapt to the new builder.
	 *
	 * @param array $array localization array.
	 *
	 * @return array
	 */
	public function adapt_conditional_headers( $array ) {
		if ( ! solace_is_new_builder() ) {
			return $array;
		}

		if ( isset( $array['headerControls'] ) ) {
			$array['headerControls'][] = 'hfg_header_layout_v2';
		}

		$array['currentValues'] = [ 'hfg_header_layout_v2' => json_decode( get_theme_mod( 'hfg_header_layout_v2', wp_json_encode( solace_hfg_header_settings() ) ), true ) ];

		return $array;
	}

	/**
	 * Filter localization data to adapt to the new builder.
	 *
	 * @param array $array localization array.
	 *
	 * @return array
	 */
	public function adapt_conditional_footers( $array ) {
		if ( ! solace_is_new_builder() ) {
			return $array;
		}

		if ( isset( $array['footerControls'] ) ) {
			$array['footerControls'][] = 'hfg_footer_layout_v2';
		}

		$array['currentValues'] = [ 'hfg_footer_layout_v2' => json_decode( get_theme_mod( 'hfg_footer_layout_v2', wp_json_encode( solace_hfg_footer_settings() ) ), true ) ];

		return $array;
	}


	/**
	 * Register Rest Routes.
	 */
	public function register_rest_routes() {
		register_rest_route(
			'nv/migration',
			'/new_header_builder',
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'migrate_builders_data' ],
				'permission_callback' => function () {
					return current_user_can( 'manage_options' );
				},
			)
		);

		register_rest_route(
			'nv/v1/dashboard',
			'/plugin-state/(?P<slug>[a-z0-9-]+)',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_plugin_state' ],
				'permission_callback' => function() {
					return ( current_user_can( 'install_plugins' ) && current_user_can( 'activate_plugins' ) );
				},
				'args'                => [
					'slug' => [
						'sanitize_callback' => 'sanitize_key',
					],
				],
			]
		);
	}

	/**
	 * Migration routine request.
	 *
	 * @param \WP_REST_Request $request the received request.
	 *
	 * @return \WP_REST_Response
	 *
	 * @since 3.0.0
	 */
	public function migrate_builders_data( \WP_REST_Request $request ) {
		$is_rollback = $request->get_header( 'rollback' );
		$is_dismiss  = $request->get_header( 'dismiss' );

		if ( $is_dismiss === 'yes' ) {
			remove_theme_mod( 'hfg_header_layout' );
			remove_theme_mod( 'hfg_footer_layout' );

			return new \WP_REST_Response( [ 'success' => true ], 200 );
		}

		if ( $is_rollback === 'yes' ) {
			set_theme_mod( 'solace_migrated_builders', false );

			return new \WP_REST_Response( [ 'success' => true ], 200 );
		}

		$migrator = new Builder_Migrator();
		$response = $migrator->run();

		if ( $response === true ) {
			set_theme_mod( 'solace_migrated_builders', true );
		}

		return new \WP_REST_Response( [ 'success' => $response ], 200 );
	}

	/**
	 * Get any plugin's state.
	 *
	 * @param  \WP_REST_Request $request Request details.
	 * @return \WP_REST_Request|\WP_Error
	 */
	public function get_plugin_state( \WP_REST_Request $request ) {
		$slug = $request->get_param( 'slug' );

		$state = ( new Plugin_Helper() )->get_plugin_state( $slug );

		return rest_ensure_response(
			[
				'slug'  => $slug,
				'state' => $state,
			]
		);
	}

	/**
	 * Drop `Background` submenu item.
	 */
	public function remove_background_submenu() {
		global $submenu;

		if ( ! isset( $submenu['themes.php'] ) ) {
			return false;
		}

		foreach ( $submenu['themes.php'] as $index => $submenu_args ) {
			foreach ( $submenu_args as $arg_index => $arg ) {
				if ( preg_match( '/customize\.php.+autofocus%5Bcontrol%5D=background_image/', $arg ) === 1 ) {
					unset( $submenu['themes.php'][ $index ] );
				}
			}
		}
	}

	/**
	 * Setup Class Properties
	 */
	public function set_props() {
		$this->theme_args = wp_get_theme();
	}

	/**
	 * Get notice screenshot based on previous theme.
	 *
	 * @return string Image url.
	 */
	private function get_notice_picture() {
		return get_template_directory_uri() . '/assets/img/sites-list.jpg';
	}

	/**
	 * Render welcome notice content
	 */
	public function welcome_notice_content() {
		$name       = apply_filters( 'ti_wl_theme_name', $this->theme_args->__get( 'Name' ) );
		$template   = $this->theme_args->get( 'Template' );
		$slug       = $this->theme_args->__get( 'stylesheet' );
		$theme_page = ! empty( $template ) ? $template . '-welcome' : $slug . '-welcome';

		$notice_template = '
			<div class="nv-notice-wrapper">
			%1$s
			<hr/>
				<div class="nv-notice-column-container">
					<div class="nv-notice-column nv-notice-image">%2$s</div>
					<div class="nv-notice-column nv-notice-starter-sites">%3$s</div>
					<div class="nv-notice-column nv-notice-documentation">%4$s</div>
				</div>
			</div>
			<style>%5$s</style>';

		/* translators: 1 - notice title, 2 - notice message */
		$notice_header = sprintf(
			'<h2>%1$s</h2><p class="about-description">%2$s</p></hr>',
			esc_html__( 'Congratulations!', 'solace' ),
			sprintf(
				/* translators: %s - theme name */
				esc_html__( '%s is now installed and ready to use. We\'ve assembled some links to get you started.', 'solace' ),
				$name
			)
		);
		$ob_btn_link = admin_url( defined( 'TIOB_PATH' ) ? 'themes.php?page=tiob-starter-sites&onboarding=yes' : 'themes.php?page=' . $theme_page . '&onboarding=yes#starter-sites' );
		$ob_btn      = sprintf(
		/* translators: 1 - onboarding url, 2 - button text */
			'<a href="%1$s" class="button button-primary button-hero install-now" >%2$s</a>',
			esc_url( $ob_btn_link ),
			sprintf( apply_filters( 'ti_onboarding_solace_start_site_cta', esc_html__( 'Try one of our ready to use Starter Sites', 'solace' ) ) )
		);
		$ob_return_dashboard = sprintf(
		/* translators: 1 - button text */
			'<a href="' . esc_url( admin_url() ) . '" class=" ti-return-dashboard  button button-secondary button-hero install-now" ><span>%1$s</span></a>',
			__( 'Return to your dashboard', 'solace' )
		);
		$options_page_btn = sprintf(
		/* translators: 1 - options page url, 2 - button text */
			'<a href="%1$s" class="options-page-btn">%2$s</a>',
			esc_url( admin_url( 'themes.php?page=' . $theme_page ) ),
			esc_html__( 'or go to the theme settings', 'solace' )
		);
		$notice_picture    = sprintf(
			'<picture>
					<source srcset="about:blank" media="(max-width: 1024px)">
					<img src="%1$s"/>
				</picture>',
			esc_url( $this->get_notice_picture() )
		);
		$notice_sites_list = sprintf(
			'<div><h3><span class="dashicons dashicons-images-alt2"></span> %1$s</h3><p>%2$s</p><p>%3$s</p></div><div> <p id="solace-ss-install">%4$s</p><p>%5$s</p> </div>',
			__( 'Sites Library', 'solace' ),
			// translators: %s - Theme name
				sprintf( esc_html__( '%s now comes with a sites library with various designs to pick from. Visit our collection of demos that are constantly being added.', 'solace' ), $name ),
			esc_html( __( 'Install the template patterns plugin to get started.', 'solace' ) ),
			$ob_btn,
			$options_page_btn
		);
		
		$style = '
		.nv-notice-wrapper h2{
			margin: 0;
			font-size: 21px;
			font-weight: 400;
			line-height: 1.2;
		}
		.nv-notice-wrapper p.about-description{
			color: #72777c;
			font-size: 16px;
			margin: 0;
			padding:0px;
		}
		.nv-notice-wrapper{
			padding: 23px 10px 0;
			max-width: 1500px;
		}
		.nv-notice-wrapper hr {
			margin: 20px -23px 0;
			border-top: 1px solid #f3f4f5;
			border-bottom: none;
		}
		.nv-notice-column-container h3{
			margin: 17px 0 0;
			font-size: 16px;
			line-height: 1.4;
		}
		.nv-notice-column-container p {
			color: #72777c;
		}
		.nv-notice-text p.ti-return-dashboard {
			margin-top: 30px;
	}
		.nv-notice-column-container .nv-notice-column{
			 padding-right: 40px;
		}
		.nv-notice-column-container img{
			margin-top: 23px;
			width: calc(100% - 40px);
			border: 1px solid #f3f4f5;
		}
		.nv-notice-column-container {
			display: -ms-grid;
			display: grid;
			-ms-grid-columns: 24% 32% 32%;
			grid-template-columns: 24% 32% 32%;
			margin-bottom: 13px;
		}
		.nv-notice-column-container a.button.button-hero.button-secondary,
		.nv-notice-column-container a.button.button-hero.button-primary{
			margin:0px;
		}
		.nv-notice-column-container .nv-notice-column:not(.nv-notice-image) {
			display: -ms-grid;
			display: grid;
			-ms-grid-rows: auto 100px;
			grid-template-rows: auto 100px;
		}
		@media screen and (max-width: 1280px) {
			.nv-notice-wrapper .nv-notice-column-container {
				-ms-grid-columns: 50% 50%;
				grid-template-columns: 50% 50%;
			}
			.nv-notice-column-container a.button.button-hero.button-secondary,
			.nv-notice-column-container a.button.button-hero.button-primary{
				padding:6px 18px;
			}
			.nv-notice-wrapper .nv-notice-image {
				display: none;
			}
		}
		@media screen and (max-width: 870px) {

			.nv-notice-wrapper .nv-notice-column-container {
				-ms-grid-columns: 100%;
				grid-template-columns: 100%;
			}
			.nv-notice-column-container a.button.button-hero.button-primary{
				padding:12px 36px;
			}
		}
		@-webkit-keyframes spin {
			from {
				transform: rotate(0deg);
			}
			to {
				transform: rotate(360deg);
			}
		}
		#solace-ss-install button.is-loading {
			color: #828282 !important;
		}
		#solace-ss-install button.is-loading .dashicon {
			color: #646D82;
			animation-name: spin;
			animation-duration: 2000ms;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
		}
		';

		echo sprintf(
			$notice_template, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$notice_header, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$notice_picture, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$notice_sites_list, // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$style // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		);
	}

	/**
	 * Load site import module.
	 */
	public function load_site_import() {
		if ( class_exists( '\TIOB\Main' ) ) {
			\TIOB\Main::instance();
		}
	}

	/**
	 * Enqueue gutenberg scripts.
	 */
	public function enqueue_gutenberg_scripts() {
		$screen = get_current_screen();
		// if is_block_editor is `true` we should allow the Gutenberg styles to load eg. the new widgets page.
		if ( ! post_type_supports( $screen->post_type, 'editor' ) && $screen->is_block_editor !== true ) {
			return;
		}
		wp_enqueue_script(
			'solace-gutenberg-script',
			SOLACE_ASSETS_URL . 'js/build/all/gutenberg.js?v=' . time(),
			array( 'wp-blocks', 'wp-dom' ),
			SOLACE_VERSION,
			true
		);

		$path = solace_is_new_skin() ? 'gutenberg-editor-style' : 'gutenberg-editor-legacy-style';

		wp_enqueue_style( 'solace-gutenberg-style', SOLACE_ASSETS_URL . 'css/' . $path . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), SOLACE_VERSION );
	}

	/**
	 * Dismiss notice JS
	 */
	private function dismiss_script() {
		?>
		<script type="text/javascript">
			function handleNoticeActions($) {
				var actions = $('.nv-welcome-notice').find('.notice-dismiss, .ti-return-dashboard, .options-page-btn')
				$.each(actions, function (index, actionButton) {
					$(actionButton).on('click', function (e) {
						e.preventDefault()
						var redirect = $(this).attr('href')
						$.post(
							'<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
							{
								nonce: '<?php echo esc_attr( wp_create_nonce( 'remove_notice_confirmation' ) ); ?>',
								action: 'solace_dismiss_welcome_notice',
								success: function () {
									if (typeof redirect !== 'undefined' && window.location.href !== redirect) {
										window.location = redirect
										return false
									}
									$('.nv-welcome-notice').fadeOut()
								}
							}
						)
					})
				})
			}

			jQuery(document).ready(function () {
				handleNoticeActions(jQuery)
			})
		</script>
		<?php
	}

	/**
	 * Memorize the previous theme to later display the import template for it.
	 */
	public function get_previous_theme() {
		$previous_theme = strtolower( get_option( 'theme_switched' ) );
		set_theme_mod( 'ti_prev_theme', $previous_theme );
	}

	/**
	 * Remove notice;
	 */
	public function remove_notice() {
		// Ensure only administrators can dismiss admin notices.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error(
				array(
					'message' => 'Insufficient permissions.',
					'status'  => 'error',
				)
			);
		}

		if ( ! isset( $_POST['nonce'] ) ) {
			wp_send_json_error(
				array(
					'message' => 'Security check failed. Missing nonce',
					'status'  => 'error',
				)
			);
		}
		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'remove_notice_confirmation' ) ) {
			wp_send_json_error(
				array(
					'message' => 'Security check failed. Invalid nonce',
					'status'  => 'error',
				)
			);
		}
		update_option( $this->dismiss_notice_key, 'yes' );
		wp_send_json_success(
			array(
				'success' => true,
				'status'  => 'success',
			)
		);
		wp_die();
	}

	/**
	 * Change Orbit Fox and Otter plugin names to make clear where they are from.
	 */
	public function change_plugin_names( $plugins ) {
		if ( array_key_exists( 'themeisle-companion/themeisle-companion.php', $plugins ) ) {
			$plugins['themeisle-companion/themeisle-companion.php']['Name'] = 'Orbit Fox Companion by Solace theme';
		}
		if ( array_key_exists( 'otter-pro/otter-pro.php', $plugins ) ) {
			$plugins['otter-pro/otter-pro.php']['Description'] = $plugins['otter-pro/otter-pro.php']['Description'] . ' It is part of Block Editor Booster from Solace.';
		}

		return $plugins;
	}

}
