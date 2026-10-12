<?php
/**
 * Front end functionality
 *
 * Author:          
 * Created on:      17/08/2018
 *
 * @package Solace\Core
 */

namespace Solace\Core;

use Solace\Compatibility\Starter_Content;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Dynamic_Css;
use Solace\Core\Settings\Customizer_Defaults;

/**
 * Front end handler class.
 *
 * @package Solace\Core
 */
class Front_End {

	/**
	 * Theme setup.
	 */
	public function setup_theme() {

		// Maximum allowed width for any content in the theme, like oEmbeds and images added to posts.  https://codex.wordpress.org/Content_Width
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = apply_filters( 'solace_content_width', 1200 );
		}

		load_theme_textdomain( 'solace', get_template_directory() . '/languages' );

		$logo_settings = array(
			'flex-width'  => true,
			'flex-height' => true,
			'height'      => 50,
			'width'       => 200,
		);

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo', $logo_settings );
		add_theme_support( 'html5', array( 'search-form' ) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'custom-background', [] );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-color-palette', $this->get_gutenberg_color_palette() );
		add_theme_support( 'fl-theme-builder-headers' );
		add_theme_support( 'fl-theme-builder-footers' );
		add_theme_support( 'fl-theme-builder-parts' );
		add_theme_support( 'header-footer-elementor' );
		add_theme_support( 'lifterlms-sidebars' );
		add_theme_support( 'lifterlms' );
		add_theme_support( 'service_worker', true );
		// add_theme_support( 'starter-content', ( new Starter_Content() )->get() );
		add_filter( 'script_loader_tag', array( $this, 'filter_script_loader_tag' ), 10, 2 );
		add_filter( 'embed_oembed_html', array( $this, 'wrap_oembeds' ), 10, 3 );
		add_filter( 'video_embed_html', array( $this, 'wrap_jetpack_oembeds' ), 10, 1 );

		$this->add_amp_support();
		$nav_menus_to_register = apply_filters(
			'solace_register_nav_menus',
			array(
				'primary' => esc_html__( 'Primary Menu', 'solace' ),
				'footer'  => esc_html__( 'Footer Menu', 'solace' ),
				'top-bar' => esc_html__( 'Secondary Menu', 'solace' ),
			)
		);
		register_nav_menus( $nav_menus_to_register );

		add_image_size( 'solace-blog', 930, 620, true );
		add_filter( 'wp_nav_menu_args', array( $this, 'nav_walker' ), 1001 );
		if ( solace_is_new_skin() ) {
			add_filter( 'theme_mod_background_color', '__return_empty_string' );
		}
		$this->add_woo_support();
		add_filter( 'solace_dynamic_style_output', array( $this, 'css_global_custom_colors' ), PHP_INT_MAX, 2 );
	}

	/**
	 * Gutenberg Block Color Palettes.
	 *
	 * Get the color palette in Gutenberg from Customizer colors.
	 */
	private function get_gutenberg_color_palette() {
		$prefix                  = ( apply_filters( 'ti_wl_theme_is_localized', false ) ? __( 'Theme', 'solace' ) : 'Solace' ) . ' - ';
		$gutenberg_color_palette = array();
		$from_global_colors      = [
			'solace-link-color'       => array(
				'val'   => 'var(--sol-color-link-button-initial)',
				'label' => $prefix . __( 'Primary Accent', 'solace' ),
			),
			'solace-link-hover-color' => array(
				'val'   => 'var(--sol-color-link-button-initial)',
				'label' => $prefix . __( 'Secondary Accent', 'solace' ),
			),
			'sol-color-background'            => array(
				'val'   => 'var(--sol-color-background)',
				'label' => $prefix . __( 'Site Background', 'solace' ),
			),
			'nv-light-bg'           => array(
				'val'   => 'var(--nv-light-bg)',
				'label' => $prefix . __( 'Light Background', 'solace' ),
			),
			'sol-color-border'           => array(
				'val'   => 'var(--sol-color-border)',
				'label' => $prefix . __( 'Light Border Color', 'solace' ),
			),
			'sol-color-page-title-background'            => array(
				'val'   => 'var(--sol-color-page-title-background)',
				'label' => $prefix . __( 'Dark Background', 'solace' ),
			),
			'nv-dark-bc'           => array(
				'val'   => 'var(--nv-dark-bc)',
				'label' => $prefix . __( 'Dark Border Color', 'solace' ),
			),
			'solace-text-color'       => array(
				'val'   => 'var(--sol-color-base-font)',
				'label' => $prefix . __( 'Text Color', 'solace' ),
			),
			'sol-color-page-title-text'       => array(
				'val'   => 'var(--sol-color-page-title-text)',
				'label' => $prefix . __( 'Text Dark Background', 'solace' ),
			),
			'nv-c-1'                => array(
				'val'   => 'var(--nv-c-1)',
				'label' => $prefix . __( 'Extra Color 1', 'solace' ),
			),
			'nv-c-2'                => array(
				'val'   => 'var(--nv-c-2)',
				'label' => $prefix . __( 'Extra Color 2', 'solace' ),
			),
		];

		// Add custom global colors
		$from_global_colors = array_merge( $from_global_colors, $this->get_global_custom_color_vars() );

		foreach ( $from_global_colors as $slug => $args ) {
			array_push(
				$gutenberg_color_palette,
				array(
					'name'  => esc_html( $args['label'] ),
					'slug'  => esc_html( $slug ),
					'color' => solace_sanitize_colors( $args['val'] ),
				)
			);
		}

		return array_values( $gutenberg_color_palette );
	}

	/**
	 * Returns global custom colors with css vars
	 *
	 * @return array[]
	 */
	private function get_global_custom_color_vars() {
		$css_vars = [];
		foreach ( Mods::get( Config::MODS_GLOBAL_CUSTOM_COLORS, [] ) as $slug => $args ) {
			$css_vars[ $slug ] = [
				'label' => $args['label'],
				'val'   => sprintf( 'var(--%s)', $slug ),
			];
		}

		return $css_vars;
	}

	/**
	 * Add AMP support
	 */
	private function add_amp_support() {
		if ( ! defined( 'AMP__VERSION' ) ) {
			return;
		}
		if ( version_compare( AMP__VERSION, '1.0.0', '<' ) ) {
			return;
		}
		add_theme_support(
			'amp',
			apply_filters(
				'solace_filter_amp_support',
				array(
					'paired' => true,
				)
			)
		);
	}

	/**
	 * Add WooCommerce support
	 */
	private function add_woo_support() {
		if ( ! class_exists( 'WooCommerce', false ) ) {
			return;
		}

		$woocommerce_settings = apply_filters(
			'solace_woocommerce_args',
			array(
				'product_grid' => array(
					'default_columns' => 3,
					'default_rows'    => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
					'min_rows'        => 1,
				),
			)
		);

		add_theme_support( 'woocommerce', $woocommerce_settings );

		add_theme_support( 'wc-product-gallery-lightbox' );

		add_theme_support( 'wc-product-gallery-zoom' );

		add_theme_support( 'wc-product-gallery-slider' );

	}

	/**
	 * Adds async/defer attributes to enqueued / registered scripts.
	 *
	 * If #12009 lands in WordPress, this function can no-op since it would be handled in core.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12009
	 *
	 * @param string $tag The script tag.
	 * @param string $handle The script handle.
	 *
	 * @return string Script HTML string.
	 */
	public function filter_script_loader_tag( $tag, $handle ) {
		foreach ( array( 'async', 'defer' ) as $attr ) {
			if ( ! wp_scripts()->get_data( $handle, $attr ) ) {
				continue;
			}
			// Prevent adding attribute when already added in #12009.
			if ( ! preg_match( ":\s$attr(=|>|\s):", $tag ) ) {
				$tag = preg_replace( ':(?=></script>):', " $attr", $tag, 1 );
			}
			// Only allow async or defer, not both.
			break;
		}

		return $tag;
	}

	/**
	 * Wrap embeds.
	 *
	 * @param string $markup embed markup.
	 * @param string $url embed url.
	 * @param array  $attr embed attributes [width/height].
	 *
	 * @return string
	 */
	public function wrap_oembeds( $markup, $url, $attr ) {
		$sources = [
			'youtube.com',
			'youtu.be',
			'cloudup.com',
			'dailymotion.com',
			'ted.com',
			'vimeo.com',
			'speakerdeck.com',
		];
		foreach ( $sources as $source ) {
			if ( strpos( $url, $source ) !== false ) {
				return '<div class="nv-iframe-embed">' . $markup . '</div>';
			}
		}

		return $markup;
	}

	/**
	 * Wrap Jetpack embeds.
	 * Fixes the compose module aspect ratio issue.
	 *
	 * @param string $markup embed markup.
	 *
	 * @return string
	 */
	public function wrap_jetpack_oembeds( $markup ) {
		return '<div class="nv-iframe-embed">' . $markup . '</div>';
	}

	/**
	 * Tweak menu walker to support selective refresh.
	 *
	 * @param array $args List of arguments for navigation.
	 *
	 * @return mixed
	 */
	public function nav_walker( $args ) {
		if ( isset( $args['walker'] ) && is_string( $args['walker'] ) && class_exists( $args['walker'] ) ) {
			$args['walker'] = new $args['walker']();
		}

		return $args;
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		$this->add_styles();
		$this->add_inline_styles();
		$this->add_scripts();
	}

	/**
	 * Enqueue inline styles for core components.
	 */
	private function add_inline_styles() {

		// Add Inline styles if buttons shadows are being used.
		$primary_values   = get_theme_mod( Config::MODS_BUTTON_PRIMARY_STYLE, solace_get_button_appearance_default() );
		$secondary_values = get_theme_mod( Config::MODS_BUTTON_SECONDARY_STYLE, solace_get_button_appearance_default( 'secondary' ) );

		if (
			( isset( $primary_values['useShadow'] ) && ! empty( $primary_values['useShadow'] ) ) ||
			( isset( $primary_values['useShadowHover'] ) && ! empty( $primary_values['useShadowHover'] ) ) ||
			( isset( $secondary_values['useShadow'] ) && ! empty( $secondary_values['useShadow'] ) ) ||
			( isset( $secondary_values['useShadowHover'] ) && ! empty( $secondary_values['useShadowHover'] ) )
		) {
			wp_add_inline_style( 'solace-style', '.button.button-primary, .is-style-primary .wp-block-button__link {box-shadow: var(--primarybtnshadow, none);} .button.button-primary:hover, .is-style-primary .wp-block-button__link:hover {box-shadow: var(--primarybtnhovershadow, none);} .button.button-secondary, .is-style-secondary .wp-block-button__link {box-shadow: var(--secondarybtnshadow, none);} .button.button-secondary:hover, .is-style-secondary .wp-block-button__link:hover {box-shadow: var(--secondarybtnhovershadow, none);}' );
		}
	}

	/**
	 * Enqueue styles.
	 */
	private function add_styles() {
		if ( class_exists( 'WooCommerce', false ) ) {
			$style_path = solace_is_new_skin() ? 'css/woocommerce' : 'css/woocommerce-legacy';

			wp_register_style( 'solace-woocommerce', SOLACE_ASSETS_URL . $style_path . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), apply_filters( 'solace_version_filter', SOLACE_VERSION ) );
			wp_style_add_data( 'solace-woocommerce', 'rtl', 'replace' );
			wp_style_add_data( 'solace-woocommerce', 'suffix', '.min' );
			wp_enqueue_style( 'solace-woocommerce' );
		}

		$style_path = solace_is_new_skin() ? '/style-main-new' : '/assets/css/style-legacy';

		wp_register_style( 'solace-style', get_template_directory_uri() . $style_path . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), apply_filters( 'solace_version_filter', SOLACE_VERSION ) );
		wp_style_add_data( 'solace-style', 'rtl', 'replace' );
		wp_style_add_data( 'solace-style', 'suffix', '.min' );
		wp_enqueue_style( 'solace-style' );

		$mm_path = solace_is_new_skin() ? 'mega-menu' : 'mega-menu-legacy';

		wp_register_style( 'solace-mega-menu', get_template_directory_uri() . '/assets/css/' . $mm_path . ( ( SOLACE_DEBUG ) ? '' : '.min' ) . '.css?v=' . time(), array(), apply_filters( 'solace_version_filter', SOLACE_VERSION ) );
		wp_style_add_data( 'solace-mega-menu', 'rtl', 'replace' );
		wp_style_add_data( 'solace-mega-menu', 'suffix', '.min' );
	}

	/**
	 * Enqueue scripts.
	 */
	private function add_scripts() {
		if ( solace_is_amp() ) {
			return;
		}

		wp_register_script( 'solace-script', SOLACE_ASSETS_URL . 'js/build/modern/frontend.js?v=' . time(), apply_filters( 'solace_filter_main_script_dependencies', array() ), SOLACE_VERSION, true );

		wp_localize_script(
			'solace-script',
			'SolaceProperties',
			apply_filters(
				'solace_filter_main_script_localization',
				array(
					'ajaxurl'     => esc_url( admin_url( 'admin-ajax.php' ) ),
					'nonce'       => wp_create_nonce( 'wp_rest' ),
					'isRTL'       => is_rtl(),
					'isCustomize' => is_customize_preview(),
				)
			)
		);
		wp_enqueue_script( 'solace-script' );
		wp_script_add_data( 'solace-script', 'async', true );
		$inline_scripts = apply_filters( 'hfg_component_scripts', '' );
		if ( ! empty( $inline_scripts ) ) {
			wp_add_inline_script( 'solace-script', $inline_scripts );
		}

		if ( class_exists( 'WooCommerce', false ) && is_woocommerce() ) {
			wp_register_script( 'solace-shop-script', SOLACE_ASSETS_URL . 'js/build/modern/shop.js?v=' . time(), array(), SOLACE_VERSION, true );
			wp_enqueue_script( 'solace-shop-script' );
			wp_script_add_data( 'solace-shop-script', 'async', true );
		}

		if ( $this->should_load_comments_reply() ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Dequeue comments-reply script if comments are closed.
	 *
	 * @return bool
	 */
	public function should_load_comments_reply() {

		if ( ! is_singular() ) {
			return false;
		}

		if ( ! comments_open() ) {
			return false;
		}

		if ( ! (bool) get_option( 'thread_comments' ) ) {
			return false;
		}

		if ( post_password_required() ) {
			return false;
		}

		$post_type = get_post_type();
		if ( ! post_type_supports( $post_type, 'comments' ) ) {
			return false;
		}

		if ( ! apply_filters( 'solace_post_has_comments', false ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Register widgets for the theme.
	 *
	 * @since    1.0.0
	 */
	public function register_sidebars() {
		$sidebars = array(
			'blog-sidebar' => esc_html__( 'Sidebar', 'solace' ),
			'shop-sidebar' => esc_html__( 'Shop Sidebar', 'solace' ),
		);

		$header_sidebars = apply_filters(
			'solace_header_widget_areas_array',
			array(
				'header-widgets'   => esc_html__( 'Header Widget', 'solace' ),
			)
		);

		$footer_sidebars = apply_filters(
			'solace_footer_widget_areas_array',
			array(
				'footer-one-widgets'   => esc_html__( 'Footer One', 'solace' ),
				'footer-two-widgets'   => esc_html__( 'Footer Two', 'solace' ),
				'footer-three-widgets' => esc_html__( 'Footer Three', 'solace' ),
				'footer-four-widgets'  => esc_html__( 'Footer Four', 'solace' ),
			)
		);

		$sidebars = array_merge( $sidebars, $header_sidebars );
		$sidebars = array_merge( $sidebars, $footer_sidebars );

		foreach ( $sidebars as $sidebar_id => $sidebar_name ) {
			$sidebar_settings = array(
				'name'          => $sidebar_name,
				'id'            => $sidebar_id,
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h5>',
				'after_title'   => '</h5>',
			);
			register_sidebar( $sidebar_settings );
		}
	}

	/**
	 * Get strings.
	 *
	 * @return array
	 */
	public function get_strings() {
		return [
			'add_item'          => __( 'Add item', 'solace' ),
			'add_items'         => __( 'Add items by clicking the ones below.', 'solace' ),
			'all_selected'      => __( 'All items are already selected.', 'solace' ),
			'page_layout'       => __( 'Page Layoutx', 'solace' ),
			'page_title'        => __( 'Page Title', 'solace' ),
			'header_booster'    => esc_html__( 'Header Booster', 'solace' ),
			'blog_booster'      => esc_html__( 'Blog Booster', 'solace' ),
			'woo_booster'       => esc_html__( 'WooCommerce Booster', 'solace' ),
			'custom_layouts'    => esc_html__( 'Custom Layouts', 'solace' ),
			'white_label'       => esc_html__( 'White Label module', 'solace' ),
			'scroll_to_top'     => esc_html__( 'Scroll to Top module', 'solace' ),
			'elementor_booster' => esc_html__( 'Elementor Booster', 'solace' ),
			'ext_h_description' => esc_html__( 'Extend your header with more components and settings, build sticky/transparent headers or display them conditionally.', 'solace' ),
			'ctm_h_description' => esc_html__( 'Easily create custom headers and footers as well as adding your own custom code or content in any of the hooks locations.', 'solace' ),
			'elem_description'  => esc_html__( 'Leverage the true flexibility of Elementor with powerful addons and templates that you can import with just one click.', 'solace' ),
			'get_pro_cta'       => esc_html__( 'Get the PRO version!', 'solace' ),
			'opens_new_tab_des' => esc_html__( '(opens in a new tab)', 'solace' ),
		];
	}

	/**
	 * Adds CSS rules to resolve .has-dynamicslug-color .has-dynamicslug-background-color classes.
	 *
	 * @param  string $current_styles Current dynamic style.
	 * @param  string $context gutenberg|frontend Represents the type of the context.
	 * @return string dynamic styles has resolving global custom colors
	 */
	public function css_global_custom_colors( $current_styles, $context ) {
		if ( $context !== 'frontend' ) {
			return $current_styles;
		}

		foreach ( Mods::get( Config::MODS_GLOBAL_CUSTOM_COLORS, [] ) as $slug => $args ) {
			$css_var         = sprintf( 'var(--%s) !important', $slug );
			$current_styles .= Dynamic_CSS::minify_css( sprintf( '.has-%s-color {color:%s} .has-%s-background-color {background-color:%s}', $slug, $css_var, $slug, $css_var ) );
		}

		return $current_styles;
	}
}
