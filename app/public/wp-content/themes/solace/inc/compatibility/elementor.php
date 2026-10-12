<?php
/**
 * Author:          
 * Created on:      05/09/2018
 *
 * @package Solace\Compatibility
 */

namespace Solace\Compatibility;

use Solace\Core\Dynamic_Css;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * Class Elementor
 *
 * @package Solace\Compatibility
 */
class Elementor extends Page_Builder_Base {
	/**
	 * Stores Elementor templates meta
	 *
	 * @var array
	 */
	const ELEMENTOR_TEMPLATE_TYPES = [
		'single_product'  => [
			'location'            => 'single',
			'condition_indicator' => 'product',
		],
		'product_archive' => [
			'location'            => 'archive',
			'condition_indicator' => 'product_archive',
		],
	];

	/**
	 * Stores if the current page is overriden by Elementor or not (checks by ::is_elementor_template method) according to the location.
	 *
	 * @var array
	 */
	private static $cache_cp_has_template = [];

	/**
	 * Stores Elementor Pro Conditions_Manager instance.
	 *
	 * @var false|\ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager
	 */
	private static $elementor_conditions_manager = false;

	/**
	 * Custom global colors theme mod value
	 *
	 * @var array|null
	 */
	private static $custom_global_colors = null;

	/**
	 * Init function.
	 */
	public function init() {
		if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
			return;
		}

		self::$custom_global_colors = self::$custom_global_colors ?? Mods::get( Config::MODS_GLOBAL_CUSTOM_COLORS, [] );

		add_action( 'solace_dynamic_style_output', array( $this, 'fix_links' ), 99, 2 );
		add_action( 'wp', array( $this, 'add_theme_builder_hooks' ) );
		add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'maybe_set_page_template' ), 1 );
		add_filter( 'rest_request_after_callbacks', [ $this, 'alter_global_colors_in_picker' ], 999, 3 );
		add_filter( 'rest_request_after_callbacks', [ $this, 'alter_global_colors_front_end' ], 999, 3 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ), 100 );
		/**
		* Elementor - Solace Pro Compatibility
		* add_filter call for "solace_pro_run_wc_view" hook.
		*
		* The callback, suspenses some WooCommerce modifications (especially customizer support) by Solace Pro if an Elementor template is applied on the current page.
		* That gives full capability to Elementor and removes Solace Pro customizations.
		*/
		add_filter( 'solace_pro_run_wc_view', array( $this, 'suspend_woo_customizations' ), 10, 2 );
	}

	/**
	 * Enqueue Global Colors
	 */
	public function enqueue() {
		$colors = $this->get_current_palette_colors();
		$css    = ':root{';
		foreach ( $colors as $slug => $color ) {
			$css .= '--e-global-color-' . str_replace( '-', '', $slug ) . ':' . $color . ';';
		}
		$css .= '}';

		/**
		 * CSS unset
		 * li
		 * p
		 * ul
		 */
		// $css .= 'body.elementor-page .elementor li,';
		// $css .= 'body.elementor-page .elementor p,';
		// $css .= 'body.elementor-page .elementor ul {';
		// 	$css .= 'font-size: unset;';
		// 	$css .= 'line-height: unset;';
		// 	$css .= 'letter-spacing: unset;';
		// 	$css .= 'text-transform: unset;';
		// 	$css .= 'font-weight: unset;';
		// $css .= '}';

		/**
		 * Filters the css with base vars for elementor colors.
		 *
		 * @param array $css Single post page components.
		 *
		 * @since 3.1.0
		 */
		$css = apply_filters( 'solace_elementor_colors', $css );
		$css = Dynamic_Css::minify_css( $css );
		wp_add_inline_style( 'solace-style', $css );
	}

	/**
	 * Filter rest responses to add Solace Palette Colors to pages using Elementor.
	 *
	 * @param \WP_REST_Response $response request response.
	 * @param array             $handler request handler.
	 * @param \WP_REST_Request  $request rest request.
	 * @return \WP_REST_Response
	 */
	public function alter_global_colors_front_end( $response, $handler, \WP_REST_Request $request ) {
		$route         = $request->get_route();
		$rest_to_slugs = [
			'solcolorbasefont' 		=> 'sol-color-base-font',
			'solcolorheading' 		=> 'sol-color-heading',
			'solcolorlinkbuttoninitial' => 'sol-color-link-button-initial',
			'solcolorlinkbuttonhover' 	=> 'sol-color-link-button-hover',
			'solcolorbuttoninitial' 	=> 'sol-color-button-initial',
			'solcolorbuttonhover' 		=> 'sol-color-button-hover',
			'solcolorselectioninitial' 	=> 'sol-color-selection-initial',
			'solcolorselectionhigh'		=> 'sol-color-selection-high',
			'solcolorborder' 			=> 'sol-color-border',
			'solcolorbackground'		=> 'sol-color-background',
			'solcolorpagetitletext'		=> 'sol-color-page-title-text',
			'solcolorpagetitlebackground'=> 'sol-color-page-title-background',
			'solcolorbgmenudropdown'	=> 'sol-color-bg-menu-dropdown',
		];

		// introduce custom global colors
		foreach ( array_keys( self::$custom_global_colors ) as $slug ) {
			$rest_to_slugs[ str_replace( '-', '', $slug ) ] = $slug;
		}

		$rest_id = substr( $route, strrpos( $route, '/' ) + 1 );

		if ( ! in_array( $rest_id, array_keys( $rest_to_slugs ), true ) ) {
			return $response;
		}

		$colors   = $this->get_current_palette_colors();
		$response = new \WP_REST_Response(
			[
				'id'    => esc_attr( $rest_id ),
				'title' => $this->get_global_color_prefix() . esc_html( $rest_to_slugs[ $rest_id ] ),
				'value' => solace_sanitize_colors( $colors[ $rest_to_slugs[ $rest_id ] ] ),
			]
		);
		return $response;
	}

	/**
	 * Filter rest responses to add Solace Palette Colors to Elementor.
	 *
	 * @param \WP_REST_Response $response request response.
	 * @param array             $handler request handler.
	 * @param \WP_REST_Request  $request rest request.
	 * @return \WP_REST_Response
	 */
	public function alter_global_colors_in_picker( $response, $handler, \WP_REST_Request $request ) {
		$route = $request->get_route();

		if ( $route !== '/elementor/v1/globals' ) {
			return $response;
		}

		$label_map = [
			'sol-color-base-font' 	=> __('Base Font', 'solace'),
			'sol-color-heading' 	=> __('Heading','solace'),
			'sol-color-link-button-initial'   => __( 'Link', 'solace' ),
			'sol-color-link-button-hover' => __('Link Hover','solace'),
			'sol-color-button-initial'   => __( 'Button', 'solace' ),
			'sol-color-button-hover' => __('Button Hover','solace'),
			'sol-color-selection-initial'	=> __('Text Selection','solace'),
			'sol-color-selection-high' => __('Text Selection Background','solace'),
			'sol-color-border'		=> __('Border','solace'),
			'sol-color-background'	=> __('Background','solace'),
			'sol-color-page-title-text' => __('Page Title','solace'),
			'sol-color-page-title-background' => __('Page Title Background','solace'),
			'sol-color-bg-menu-dropdown' => __('Submenu Background','solace'),
		];

		foreach ( self::$custom_global_colors as $slug => $args ) {
			$label_map[ $slug ] = $args['label'];
		}

		$colors = $this->get_current_palette_colors();
		$data   = $response->get_data();

		foreach ( $colors as $slug => $color_value ) {
			$no_hyphens                    = str_replace( '-', '', $slug );
			$data['colors'][ $no_hyphens ] = [
				'id'    => esc_attr( $no_hyphens ),
				// 'title' => $this->get_global_color_prefix() . esc_html( $label_map[ $slug ] ),
				'title' => esc_html( $label_map[ $slug ] ),
				'value' => solace_sanitize_colors( $color_value ),
			];
		}

		$response->set_data( $data );
		
		return $response;
	}

	/**
	 * Add support for elementor theme locations.
	 */
	public function add_theme_builder_hooks() {
		if ( ! class_exists( '\ElementorPro\Modules\ThemeBuilder\Module', false ) ) {
			return;
		}

		// Elementor locations compatibility. (This action fires by Elementor Pro)
		add_action( 'elementor/theme/register_locations', array( $this, 'register_theme_locations' ) );

		if ( ! function_exists( 'elementor_theme_do_location' ) ) {
			return;
		}

		// Override theme templates.
		add_action( 'solace_do_top_bar', array( $this, 'do_header' ), 0 );
		add_action( 'solace_do_header', array( $this, 'do_header' ), 0 );
		add_action( 'solace_do_footer', array( $this, 'do_footer' ), 0 );
		add_action( 'solace_do_404', array( $this, 'do_404' ), 0 );
		add_action( 'solace_do_single_post', array( $this, 'do_single_post' ), 0 );
		add_action( 'solace_do_single_page', array( $this, 'do_single_page' ), 0 );
		add_action( 'solace_page_header', array( $this, 'remove_header_on_page' ), 0 );
	}

	/**
	 * Register Theme Location for Elementor
	 * see https://developers.elementor.com/theme-locations-api/
	 *
	 * @param \ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $manager Elementor object.
	 */
	public function register_theme_locations( $manager ) {
		$manager->register_all_core_location();
	}

	/**
	 * Remove actions for elementor header to act properly.
	 */
	public function do_header() {
		$did_location = elementor_theme_do_location( 'header' );
		if ( $did_location ) {
			remove_all_actions( 'solace_do_top_bar' );
			remove_all_actions( 'solace_do_header' );
		}
	}

	/**
	 * Remove actions for elementor footer to act properly.
	 */
	public function do_footer() {
		$did_location = elementor_theme_do_location( 'footer' );
		if ( $did_location ) {
			remove_all_actions( 'solace_do_footer' );
		}
	}

	/**
	 * Remove actions for elementor 404 to act properly.
	 */
	public function do_404() {
		if ( ! is_404() ) {
			return;
		}
		$did_location = elementor_theme_do_location( 'single' );
		if ( $did_location ) {
			remove_all_actions( 'solace_do_404' );
		}
	}

	/**
	 * Remove actions for elementor single post to act properly.
	 */
	public function do_single_post() {
		$did_location = elementor_theme_do_location( 'single' );
		if ( $did_location ) {
			remove_all_actions( 'solace_do_single_post' );
		}
	}

	/**
	 * Remove actions for elementor single page to act properly.
	 */
	public function do_single_page() {
		$did_location = elementor_theme_do_location( 'single' );
		if ( $did_location ) {
			remove_all_actions( 'solace_do_single_page' );
		}
	}

	/**
	 * Remove title on single page.
	 */
	public function remove_header_on_page() {
		if ( ! is_singular( 'page' ) ) {
			return;
		}
		if ( elementor_theme_do_location( 'single' ) ) {
			remove_all_actions( 'solace_page_header' );
		}
	}

	/**
	 * Check if it page was edited with page builder.
	 *
	 * @param int $pid post id.
	 *
	 * @return bool
	 */
	protected function is_edited_with_builder( $pid ) {
		$post_meta = get_post_meta( $pid, '_elementor_edit_mode', true );
		if ( $post_meta === 'builder' ) {
			return true;
		}

		return false;
	}

	/**
	 * Fix the underline of links added by solace.
	 *
	 * @param string $css Current css.
	 * @param string $context Context.
	 *
	 * @return string
	 */
	public function fix_links( $css, $context = 'frontend' ) {
		if ( $context !== 'frontend' ) {
			return $css;
		}

		return $css . '.nv-content-wrap .elementor a:not(.button):not(.wp-block-file__button){
				text-decoration: none;
			}';
	}

	/**
	 * Get current palette colors.
	 *
	 * @return array
	 */
	private function get_current_palette_colors() {
		$customizer = get_theme_mod( 'solace_global_colors', solace_get_global_colors_default( true ) );
		$active     = $customizer['activePalette'];
		$palettes   = $customizer['palettes'];
		$palette    = $palettes[ $active ];
		$colors     = $palette['colors'];

		foreach ( self::$custom_global_colors as $slug => $args ) {
			$colors[ $slug ] = $args['val'];
		}

		return $colors;
	}

	/**
	 * Get the global colors prefix.
	 *
	 * @return string
	 */
	private function get_global_color_prefix() {
		return ( apply_filters( 'ti_wl_theme_is_localized', false ) ? __( 'Theme', 'solace' ) : 'Solace' ) . ' - ';
	}

	/**
	 * Returns Condition_Manager instance of the Elementor Pro.
	 *
	 * @return false|\ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager
	 */
	private static function get_condition_manager() {
		if ( self::$elementor_conditions_manager !== false ) {
			return self::$elementor_conditions_manager;
		}

		if ( ! method_exists( '\ElementorPro\Modules\ThemeBuilder\Module', 'instance' ) ) {
			return false;
		}

		$theme_builder = \ElementorPro\Modules\ThemeBuilder\Module::instance();

		if ( ! method_exists( $theme_builder, 'get_conditions_manager' ) ) {
			return false;
		}

		self::$elementor_conditions_manager = $theme_builder->get_conditions_manager();
		return self::$elementor_conditions_manager;
	}

	/**
	 * Checks if the site has Elementor template as independent from current post ID.
	 * The method was designed to use in customizer. ! Do not use it outside of the customizer.
	 *
	 * @param  string $elementor_template_type valid types: single_product|product_archive (keys of the self::ELEMENTOR_TEMPLATE_TYPES const array).
	 * @return bool
	 */
	public static function has_template( $elementor_template_type ) {
		if ( ! class_exists( '\ElementorPro\Plugin', false ) ) {
			return false;
		}

		if ( ! array_key_exists( $elementor_template_type, self::ELEMENTOR_TEMPLATE_TYPES ) ) {
			return false;
		}

		$template_meta = self::ELEMENTOR_TEMPLATE_TYPES[ $elementor_template_type ];

		$location      = $template_meta['location'];
		$has_indicator = $template_meta['condition_indicator']; // represents second path of the Elementor condition

		/**
		 * @var \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager $conditions_manager
		 */
		$conditions_manager = self::get_condition_manager();

		if ( ! is_object( $conditions_manager ) || ! method_exists( $conditions_manager, 'get_cache' ) ) {
			return false;
		}

		/**
		 * @var \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Cache $instance_cond_cache
		 */
		$instance_cond_cache = $conditions_manager->get_cache();

		if ( ! method_exists( $instance_cond_cache, 'get_by_location' ) ) {
			return false;
		}

		$templates = $instance_cond_cache->get_by_location( $location );

		foreach ( $templates as $template_conditions_arr ) {
			/** @var string $condition_path specifies the condition such as  include/product_archive OR exclude/product_archive/product_search OR include/product/in_product_cat/18 etc. */
			foreach ( $template_conditions_arr  as $condition_path ) {
				$condition_parts = explode( '/', $condition_path );

				if ( empty( $condition_parts ) ) {
					continue;
				}

				if ( $condition_parts[0] !== 'include' ) {
					continue;
				}

				if ( $condition_parts[1] === $has_indicator ) {
					return true;
				}
			}
		}

		return false;
	}

	/**
	 * Is the current page has an elementor template. Looks if the an Elementor template is applied to the current page or not.
	 *
	 * @param  string $elementor_template_type valid types: single_product|product_archive (keys of the self::ELEMENTOR_TEMPLATE_TYPES const array). To available params; see keys of the self::ELEMENTOR_TEMPLATE_TYPES array.
	 * @return bool
	 */
	public static function is_elementor_template( $elementor_template_type ) {
		if ( ! class_exists( '\ElementorPro\Plugin', false ) ) {
			return false;
		}

		if ( ! array_key_exists( $elementor_template_type, self::ELEMENTOR_TEMPLATE_TYPES ) ) {
			return false;
		}

		$location = self::ELEMENTOR_TEMPLATE_TYPES[ $elementor_template_type ]['location'];

		if ( array_key_exists( $elementor_template_type, self::$cache_cp_has_template ) ) {
			return self::$cache_cp_has_template[ $location ];
		}

		/**
		 * @var \ElementorPro\Modules\ThemeBuilder\Classes\Conditions_Manager $conditions_manager
		 */
		$conditions_manager = self::get_condition_manager();

		if ( ! is_object( $conditions_manager ) || ! method_exists( $conditions_manager, 'get_location_templates' ) ) {
			return false;
		}

		$templates = $conditions_manager->get_location_templates( $location );

		self::$cache_cp_has_template[ $location ] = ( count( $templates ) > 0 );

		return self::$cache_cp_has_template[ $location ];
	}

	/**
	 * Conditionally suspense Woocommerce moditifications by Solace Pro if Elementor template applies to current page.
	 *
	 * @param  bool   $should_load Current loading status.
	 * @param  string $class_name Fully class name that applies the Woo Modification.
	 * @return bool
	 */
	public function suspend_woo_customizations( $should_load, $class_name ) {
		switch ( $class_name ) {
			case 'Solace_Pro\Modules\Woocommerce_Booster\Views\Shop_Page':
				$elementor_template_type = 'product_archive';
				break;

			case 'Solace_Pro\Modules\Woocommerce_Booster\Views\Shop_Product':
				$elementor_template_type = is_single() ? 'single_product' : 'product_archive'; // Sometimes shop_product is used inside of the single product as related products etc.
				break;

			case 'Solace_Pro\Modules\Woocommerce_Booster\Views\Single_Product_Video':
			case 'Solace_Pro\Modules\Woocommerce_Booster\Views\Single_Product':
				$elementor_template_type = 'single_product';
				break;

			default:
				return $should_load;
		}

		// Does the current page is overridden by an Elementor template?
		$elementor_overrides = self::is_elementor_template( $elementor_template_type );

		return ! $elementor_overrides;
	}
}
