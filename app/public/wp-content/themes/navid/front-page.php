<?php
/**
 * Front Page Template
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// If a static page is set as front page and user disabled magazine sections on static page
if ( 'page' === get_option( 'show_on_front' ) && ! get_theme_mod( 'navid_frontpage_sections_on_static', true ) ) {
    get_template_part( 'page' );
    return;
}

get_header();

// Get featured post (sticky or latest)
$hero_source = get_theme_mod( 'navid_hero_source', 'latest' );

$featured = null;
if ( 'latest' === $hero_source ) {
    $featured = get_posts( array( 'posts_per_page' => 1, 'ignore_sticky_posts' => true ) );
} elseif ( 'sticky' === $hero_source || 'custom' === $hero_source ) {
    $featured = get_posts( array(
        'posts_per_page' => 1,
        'post__in'       => get_option( 'sticky_posts' ),
    ) );
    if ( empty( $featured ) ) {
        $featured = get_posts( array( 'posts_per_page' => 1 ) );
    }
}
$featured_post = ! empty( $featured ) ? $featured[0] : null;

$default_layout = array(
    'hero',
    'marquee',
    'categories',
    'shortcode',
    'custom',
    'feed',
    'podcast',
    'featured',
    'interlude',
    'masonry',
    'newsletter',
    'social-proof',
    'services',
);

$layout = get_theme_mod( 'navid_homepage_layout', $default_layout );
if ( is_string( $layout ) ) {
    $layout = explode( ',', $layout );
}

if ( is_array( $layout ) ) {
    $layout = array_filter( array_map( 'trim', $layout ) );

    // If the database had an empty string, array_filter makes it empty. Fallback to default.
    if ( empty( $layout ) ) {
        $layout = $default_layout;
    }

    // If layout was saved before newer sections were added, append them at the end.
    if ( ! in_array( 'social-proof', $layout, true ) && ! in_array( 'social_proof', $layout, true ) ) {
        $layout[] = 'social-proof';
    }
    if ( ! in_array( 'services', $layout, true ) ) {
        $layout[] = 'services';
    }

    $static_content_pos = get_theme_mod( 'navid_frontpage_static_page_content_position', 'below_hero' );
    $rendered_static    = false;

    // Static Page Content: above_hero
    if ( 'above_hero' === $static_content_pos && function_exists( 'navid_render_frontpage_static_content' ) ) {
        navid_render_frontpage_static_content();
        $rendered_static = true;
    }

    // Determine when to inject below_hero: after marquee if present, otherwise after hero.
    $has_marquee     = in_array( 'marquee', $layout, true );
    $hero_break_slug = $has_marquee ? 'marquee' : 'hero';

    foreach ( $layout as $section_id ) {
        $template_slug = str_replace( '_', '-', trim( $section_id ) );

        // If below_sections, inject right before newsletter
        if ( 'below_sections' === $static_content_pos && ! $rendered_static && 'newsletter' === $template_slug && function_exists( 'navid_render_frontpage_static_content' ) ) {
            navid_render_frontpage_static_content();
            $rendered_static = true;
        }

        get_template_part( 'template-parts/home/' . esc_attr( $template_slug ), null, array( 'featured_post' => $featured_post ) );

        // If below_hero, inject right after hero/marquee
        if ( 'below_hero' === $static_content_pos && ! $rendered_static && $template_slug === $hero_break_slug && function_exists( 'navid_render_frontpage_static_content' ) ) {
            navid_render_frontpage_static_content();
            $rendered_static = true;
        }
    }

    // Fallback if target section wasn't in layout
    if ( ! $rendered_static && 'hide' !== $static_content_pos && function_exists( 'navid_render_frontpage_static_content' ) ) {
        navid_render_frontpage_static_content();
    }
}

get_footer();
