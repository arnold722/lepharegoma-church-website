<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// BEGIN ENQUEUE PARENT ACTION.
// AUTO GENERATED - Do not modify or remove comment markers above or below.
if ( ! function_exists( 'education_formula_chld_thm_locale_css' ) ) :
	function education_formula_chld_thm_locale_css( $uri ) {
		if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) ) {
			$uri = get_template_directory_uri() . '/rtl.css';
		}
		return $uri;
	}
endif;
add_filter( 'locale_stylesheet_uri', 'education_formula_chld_thm_locale_css' );


if ( ! function_exists( 'education_formula_chld_thm_parent_css' ) ) :
	function education_formula_chld_thm_parent_css() {
		wp_enqueue_style( 'education_formula_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bootstrap-min', 'animate-min', 'fontawesome-min', 'carousel-min', 'odometer-min', 'bootstrap-smartmenus-css', 'menu-css', 'responsive' ) );
	}
endif;
add_action( 'wp_enqueue_scripts', 'education_formula_chld_thm_parent_css', 10 );


/**
 * Import Options From Parent Theme
 */
function education_formula_parent_theme_options() {
	$education_formula_mods = get_option( 'theme_mods_formula' );
	if ( ! empty( $education_formula_mods ) ) {
		foreach ( $education_formula_mods as $education_formula_mod_k => $education_formula_mod_v ) {
			set_theme_mod( $education_formula_mod_k, $education_formula_mod_v );
		}
	}
}
add_action( 'after_switch_theme', 'education_formula_parent_theme_options' );

/**
 * Fresh site activate
 */
$education_formula_fresh_site_activate = get_option( 'education_formula_fresh_site_activate' );
if ( (bool) $education_formula_fresh_site_activate == false ) {
	set_theme_mod( 'formula_custom_color', true );
	set_theme_mod( 'link_color', '#fdc800' );
	update_option( 'education_formula_fresh_site_activate', true );
}


