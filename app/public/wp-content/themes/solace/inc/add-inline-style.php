<?php

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * Adds inline styles to the 'solace-theme' style handle for single post meta.
 *
 * This function retrieves the default single post meta settings from the Mods class,
 * then fetches the current theme mod for single post meta. It then creates a style
 * string to display a block for the scroll-to-top feature and adds it to the 'solace-theme' style handle.
 *
 * @return void
 */
function solace_style_single_post_meta()
{
	$defaults_single_post_meta = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);					
	$single_post_meta = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_POST_META, $defaults_single_post_meta );

	$author = $single_post_meta['author'];
	$published_date = $single_post_meta['publishedDate'];
	$comments = $single_post_meta['comments'];
	$show_avatar = $single_post_meta['showAvatar'];
	$avatar_size = $single_post_meta['avatarSize']['value'];

	$style = '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta {background: unset;}';

	// Author.
	if ( empty( $author ) ) {
		$style .= '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta a.author-with-image { display: none; }';
	}

	// Published Date.
	if ( empty( $published_date ) ) {
		$style .= '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta .the-time { display: none; }';
	}

	// Comments.
	if ( empty( $comments ) ) {
		$style .= '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta .comment { display: none; }';
	}

	// show avatar.
	if ( empty( $show_avatar ) ) {
		$style .= '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta a.author-with-image img { display: none; }';
	}

	// Avatar size.
	$style .= '.main-single-custom .container-single .row1 article .boxes-ordering .box-meta a.author-with-image img { width:' . absint( $avatar_size ) .'px;}';

	wp_add_inline_style( 'solace-theme', $style );
}
add_action('wp_enqueue_scripts', 'solace_style_single_post_meta');

// Remove all them mods
// remove_theme_mods();

// $defaults_single_post_meta123 = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);					
// $single_post_meta123 = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_POST_META, $defaults_single_post_meta123 );
// echo '<pre>';
// print_r($single_post_meta123);
// echo '</pre>';