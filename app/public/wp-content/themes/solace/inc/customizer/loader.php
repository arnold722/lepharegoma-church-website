<?php
/**
 * Author:          
 * Created on:      17/08/2018
 *
 * @package Solace\Customizer
 */

namespace Solace\Customizer;

use Solace\Core\Factory;
use Solace\Core\Settings\Config;
use Solace\Customizer\Options\Colors_Background;

/**
 * Main customizer handler.
 *
 * @package Solace\Customizer
 */
class Loader {
	const CUSTOMIZER_STYLE_HANDLE = 'solace-customizer-style';
	const CUSTOMIZER_UI_STYLE_HANDLE = 'sol-customizer-ui-style';
	const CUSTOMIZER_SOLACE_STYLE_HANDLE = 'customizer-solace-style';
	const CUSTOMIZER_SOLACE_CONTROL_STYLE = 'solace-control-style';

	/**
	 * Customizer modules.
	 *
	 * @var array
	 */
	private $customizer_modules = array();

	/**
	 * Loader constructor.
	 */
	public function __construct() {
		if ( isset( $_GET['kt-woomail-customize'] ) && $_GET['kt-woomail-customize'] == 1 ) {
			return;
		}

		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_preview' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'set_featured_image' ) );
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_controls' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_customizer_ui' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_customizer_solace' ) );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'add_customizer_body_classes' ) );
	}

	/**
	 * Initialize the customizer functionality
	 */
	public function init() {
		global $wp_customize;

		if ( ! isset( $wp_customize ) ) {
			return;
		}
		$this->define_modules();
		$this->load_modules();
		add_action( 'customize_register', array( $this, 'change_pro_controls' ), PHP_INT_MAX );
		add_action( 'customize_register', array( $this, 'register_setting_local_gf' ) );
	}

	/**
	 * Method to modify already defined controls.
	 *
	 * @param \WP_Customize_Manager $wp_customize The WP_Customize_Manager object.
	 */
	public function change_pro_controls( \WP_Customize_Manager $wp_customize ) {
		if ( solace_can_use_conditional_header() ) {
			return;
		}

		$controls_to_disable = [ 'solace_global_header', 'solace_header_conditional_selector' ];
		foreach ( $controls_to_disable as $control_slug ) {
			$wp_customize->remove_control( $control_slug );
		}
	}

	/**
	 * Define the modules that will be loaded.
	 */
	private function define_modules() {
		$this->customizer_modules = apply_filters(
			'solace_filter_customizer_modules',
			array(
				'Customizer\Options\Main',
				'Customizer\Options\Layout_Container',
				'Customizer\Options\Layout_Blog',
				'Customizer\Options\Layout_Blog_Page_Title',
				'Customizer\Options\Layout_Single_Post',
				'Customizer\Options\Layout_Single_Page',
				'Customizer\Options\Layout_Single_Product',
				'Customizer\Options\Layout_Sidebar',
				'Customizer\Options\Features_Scroll_To_Top',
				// 'Customizer\Options\WC_Custom_General',
				// 'Customizer\Options\WC_Custom_Product_Pages',
				// 'Customizer\Options\WC_Custom_Single_Product',
				'Customizer\Options\WC_Custom_General_Star_Rating',
				'Customizer\Options\WC_Custom_General_Product_Badges',
				'Customizer\Options\WC_Custom_General_Cart_Pages',
				'Customizer\Options\WC_Custom_General_Checkout',
				'Customizer\Options\WC_Custom_General_Account',
				'Customizer\Options\WC_Custom_General_Button',
				'Customizer\Options\WC_Custom_General_Store_Notice',
				'Customizer\Options\Typography',
				'Customizer\Options\Colors_Background',
				'Customizer\Options\Checkout',
				'Customizer\Options\Buttons',
				'Customizer\Options\Form_Fields',
				'Customizer\Options\Rtl',
				'Customizer\Options\Wc_Product_Page',
				'Customizer\Options\Wc_Card_Options',
				'Customizer\Options\Wc_Product_Sidebar',
				'Customizer\Options\Wc_Product_Pagination',
				'Customizer\Options\Wc_Single_Product',
				'Customizer\Options\Wc_Single_Product_Gallery',
				'Customizer\Options\Wc_Single_Product_Elements',
			)
		);
	}

		/**
	 * Enqueue customizer Solace.
	 */
	public function enqueue_customizer_solace($hook) {
		if ( 'post.php' === $hook || 'post-new.php' === $hook) {
			return;
		}
		wp_register_style( self::CUSTOMIZER_SOLACE_STYLE_HANDLE, SOLACE_ASSETS_URL . 'css/customizer-solace' . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), SOLACE_VERSION );
		wp_style_add_data( self::CUSTOMIZER_SOLACE_STYLE_HANDLE, 'rtl', 'replace' );
		wp_style_add_data( self::CUSTOMIZER_SOLACE_STYLE_HANDLE, 'suffix', '.min' );
		wp_enqueue_style( self::CUSTOMIZER_SOLACE_STYLE_HANDLE );
	}


	/**
	 * Enqueue customizer UI.
	 */
	public function enqueue_customizer_ui() {
		wp_register_style( self::CUSTOMIZER_UI_STYLE_HANDLE, SOLACE_ASSETS_URL . 'css/customizer-ui' . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), SOLACE_VERSION );
		wp_style_add_data( self::CUSTOMIZER_UI_STYLE_HANDLE, 'rtl', 'replace' );
		wp_style_add_data( self::CUSTOMIZER_UI_STYLE_HANDLE, 'suffix', '.min' );
		wp_enqueue_style( self::CUSTOMIZER_UI_STYLE_HANDLE );
	}

	/**
	 * Enqueue customizer controls script.
	 */
	public function enqueue_customizer_controls() {
		wp_register_style( self::CUSTOMIZER_STYLE_HANDLE, SOLACE_ASSETS_URL . 'css/customizer-style' . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), SOLACE_VERSION );
		wp_style_add_data( self::CUSTOMIZER_STYLE_HANDLE, 'rtl', 'replace' );
		wp_style_add_data( self::CUSTOMIZER_STYLE_HANDLE, 'suffix', '.min' );
		wp_enqueue_style( self::CUSTOMIZER_STYLE_HANDLE );

		wp_enqueue_script(
			'solace-customizer-controls',
			SOLACE_ASSETS_URL . 'js/build/all/customizer-controls.js?v=' . time(),
			array(
				'jquery',
				'wp-color-picker',
			),
			SOLACE_VERSION,
			true
		);

		$bundle_path  = get_template_directory_uri() . '/assets/apps/customizer-controls/build/';
		$dependencies = ( include get_template_directory() . '/assets/apps/customizer-controls/build/controls.asset.php' );
		wp_register_script( 'react-controls', $bundle_path . 'controls.js', $dependencies['dependencies'], $dependencies['version'], true );

		$wc_page_shop = 'not-found';
		if ( class_exists( 'WooCommerce' ) ) {
			$wc_page_shop = get_permalink( wc_get_page_id( 'shop' ) );
		}

		wp_localize_script(
			'react-controls',
			'SolaceReactCustomize',
			apply_filters(
				'solace_react_controls_localization',
				array(
					'wcPageShop'  				    => esc_url( $wc_page_shop ),
					'nonce'                         => wp_create_nonce( 'wp_rest' ),
					'headerControls'                => [],
					'instructionalVid'              => esc_url( get_template_directory_uri() . '/header-footer-grid/assets/images/customizer/hfg.mp4' ),
					'dynamicTags'                   => array(
						'controls' => array(),
						'options'  => array(),
					),
					'fonts'                         => array(
						'System' => solace_get_standard_fonts(),
						'Google' => solace_get_google_fonts(),
					),
					'fontVariants'                  => solace_get_google_fonts( true ),
					'systemFontVariants'            => solace_get_standard_fonts( true ),
					'hideConditionalHeaderSelector' => ! solace_can_use_conditional_header(),
					'dashUpdatesMessage'            => sprintf( 'Please %s to the latest version of Solace Pro to manage the conditional headers.', '<a href="' . esc_url( admin_url( 'update-core.php' ) ) . '">' . __( 'update', 'solace' ) . '</a>' ),
					'bundlePath'                    => get_template_directory_uri() . '/assets/apps/customizer-controls/build/',
					'localGoogleFonts'              => array(
						'learnMore' => apply_filters( 'solace_external_link', '#', esc_html__( 'Learn more', 'solace' ) ),
						'key'       => Config::OPTION_LOCAL_GOOGLE_FONTS_HOSTING,
					),
					'fontPairs'                     => get_theme_mod( Config::MODS_TPOGRAPHY_FONT_PAIRS, Config::$typography_default_pairs ),
					'allowedGlobalCustomColor'      => Colors_Background::CUSTOM_COLOR_LIMIT,
				)
			)
		);
		wp_enqueue_script( 'react-controls' );

		if ( function_exists( 'wp_set_script_translations' ) ) {
			wp_set_script_translations( 'react-controls', 'solace' );
		}

		wp_register_style( 'react-controls', $bundle_path . 'style-controls.css', [ 'solace-components' ], $dependencies['version'] );
		wp_style_add_data( 'react-controls', 'rtl', 'replace' );
		wp_enqueue_style( 'react-controls' );

		$fonts  = solace_get_google_fonts();
		$chunks = array_chunk( $fonts, absint( count( $fonts ) / 5 ) );

		foreach ( $chunks as $index => $fonts_chunk ) {
			wp_enqueue_style(
				'solace-fonts-control-google-fonts-' . $index,
				'https://fonts.googleapis.com/css?family=' . join( '|', $fonts_chunk ) . '&text=AbcTtheigrownfoxJumpsvlazydg"&v=' . time(),
				[],
				SOLACE_VERSION
			);
		}
	}

	/**
	 * Enqueue customizer preview script.
	 */
	public function enqueue_customizer_preview() {
		wp_enqueue_style(
			'solace-customizer-preview-style',
			SOLACE_ASSETS_URL . 'css/customizer-preview' . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(),
			array(),
			SOLACE_VERSION
		);
		wp_register_script(
			'solace-customizer-preview',
			SOLACE_ASSETS_URL . 'js/build/all/customizer-preview.js?v=' . time(),
			array(),
			SOLACE_VERSION,
			true
		);

		$shop_has_meta = 'no';
		$shop_id       = get_option( 'woocommerce_shop_page_id' );
		if ( ! empty( $shop_id ) ) {
			$meta = get_post_meta( $shop_id, 'solace_meta_sidebar', true );

			if ( ! empty( $meta ) && $meta !== 'default' ) {
				$shop_has_meta = 'yes';
			}
		}

		wp_localize_script(
			'solace-customizer-preview',
			'solaceCustomizePreview',
			apply_filters(
				'solace_customize_preview_localization',
				array(
					'currentFeaturedImage' => '',
					'newBuilder'           => solace_is_new_builder(),
					'newSkin'              => solace_is_new_skin(),
					'shopHasMetaSidebar'   => $shop_has_meta,
				)
			)
		);
		wp_enqueue_script( 'solace-customizer-preview' );
	}

	/**
	 * Save featured image in previously localized object.
	 */
	public function set_featured_image() {
		if ( ! is_customize_preview() ) {
			return;
		}
		if ( ! is_singular() ) {
			return;
		}
		$thumbnail = get_the_post_thumbnail_url();
		if ( $thumbnail === false ) {
			return;
		}
		wp_add_inline_script( 'solace-customizer-preview', 'solaceCustomizePreview.currentFeaturedImage = "' . esc_url( get_the_post_thumbnail_url() ) . '";' );
	}

	/**
	 * Load the customizer modules.
	 *
	 * @return void
	 */
	private function load_modules() {
		$factory = new Factory( $this->customizer_modules );
		$factory->load_modules();
	}

	/**
	 * Register setting for "Toggle that enables local host of Google fonts"
	 *
	 * @param \WP_Customize_Manager $wp_customize \WP_Customize_Manager instance.
	 * @return void
	 */
	public function register_setting_local_gf( $wp_customize ) {
		$wp_customize->add_setting(
			Config::OPTION_LOCAL_GOOGLE_FONTS_HOSTING,
			[
				'type'              => 'option',
				'sanitize_callback' => 'rest_sanitize_boolean',
				'default'           => false,
			]
		);
	}

	/**
	 * Add Classes for the body tag.
	 *
	 *
	 * @return array
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_customizer_body_classes() {
?>
	<script>document.body.classList.add("sol-dark-mode");</script>
<?php
	}
}
?>