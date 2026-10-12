<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package solace
 */

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Customizer_Defaults;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function solace_body_classes( $classes ) {
	global $wp_version;

	// Get the current layout setting for the single product page from the theme customizer.
    $single_product_page_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
    );

    $sticky_container = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER)
    );

    // Check if the current view is the Customizer and WordPress version is 6.7 or higher.
    if ( is_customize_preview() && version_compare( $wp_version, '6.7', '>=' ) ) {
        // Append the custom class to the existing body classes.
        $classes[] = ' solace-wp-version-6-7-plus';
    }

	// If the layout is 'single-product-special2', add a specific class for styling.
	if ( 'single-product-special2' === $single_product_page_layout ) {
		$classes[] = 'solace-single-custom-sticky-special2';
	}

	// If the layout is 'single-product-layout-custom', add another class for custom sticky layout.
	if ( 'single-product-layout-custom' === $single_product_page_layout && $sticky_container ) {
		$classes[] = 'solace-single-custom-sticky';
	}

	// Adds a class solacewp
	$classes[] = 'solacewp';

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'solace_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function solace_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'solace_pingback_header' );
