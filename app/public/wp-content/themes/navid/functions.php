<?php
/**
 * Navid Theme — Functions
 *
 * @package Navid
 * @version 1.2.3
 */
 
 // Exit if accessed directly.
 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }
 
 define( 'NAVID_VERSION', '1.2.3' );
 define( 'NAVID_DIR', get_template_directory() );
 define( 'NAVID_URI', get_template_directory_uri() );
 
 /**
  * Set the content width in pixels, based on the theme's design and stylesheet.
  *
  * @global int $content_width
  */
 if ( ! isset( $content_width ) ) {
 	$content_width = 1280; /* pixels */
 }

/**
 * Sanitize SVG markup for safe output.
 *
 * wp_kses() lowercases attribute names, breaking SVG attributes like viewBox.
 * This helper strips all tags except known-safe SVG elements and attributes.
 *
 * @param string $svg The SVG markup to sanitize.
 * @return string Sanitized SVG string.
 */
function navid_sanitize_svg( $svg ) {
    $allowed = array(
        'svg'      => array( 'viewbox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'width' => true, 'height' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'xmlns' => true, 'class' => true ),
        'path'     => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true ),
        'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
        'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'fill' => true, 'stroke' => true ),
        'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke' => true ),
        'polygon'  => array( 'points' => true, 'fill' => true, 'stroke' => true ),
        'polyline' => array( 'points' => true, 'fill' => true, 'stroke' => true ),
    );

    // Use wp_kses then restore viewBox casing.
    $clean = wp_kses( $svg, $allowed );
    $clean = str_replace( 'viewbox=', 'viewBox=', $clean );

    return $clean;
}

/**
 * Check if Navid Pro is active and licensed.
 * Uses a filter so the Pro plugin can intercept and validate the license.
 */
function navid_is_pro_active() {
    // If the plugin is completely inactive, short-circuit to false.
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    if ( ! is_plugin_active( 'navid-pro/navid-pro.php' ) ) {
        return false;
    }
    
    // Allow the Pro plugin to return true ONLY IF the license is valid.
    return apply_filters( 'navid_is_pro_active', false );
}

// Dashboard & Plugin Recommendation
require_once NAVID_DIR . '/inc/class-navid-dashboard.php';
require_once NAVID_DIR . '/inc/class-plugin-notify.php';
require_once NAVID_DIR . '/inc/customizer-notice/class-navid-customizer-notify.php';
require_once NAVID_DIR . '/inc/wptt-webfont-loader.php';

new Navid_Blog_Dashboard();
new Navid_Customizer_Notify();

/**
 * Theme Setup
 */
function navid_setup() {
    // Text domain
    load_theme_textdomain( 'navid', NAVID_DIR . '/languages' );

    // Theme support
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'post-formats', array( 'video', 'audio', 'quote' ) );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'
    ));
    // Custom Logo
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
    
    // WooCommerce Support
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 600,
        'single_image_width'    => 800,
    ) );

    add_editor_style( 'assets/css/editor-style.css' );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'custom-background', array(
        'default-color' => 'ffffff',
    ) );
    add_theme_support( 'custom-header', apply_filters( 'navid_custom_header_args', array(
        'default-image' => '',
        'width'         => 1920,
        'height'        => 400,
        'flex-height'   => true,
        'flex-width'    => true,
    ) ) );

    // Image sizes
    add_image_size( 'navid-hero', 1400, 900, true );
    add_image_size( 'navid-featured', 700, 467, true );
    add_image_size( 'navid-card', 500, 340, true );

    // Navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'navid' ),
        'footer'  => __( 'Footer Menu', 'navid' ),
    ));
}
add_action( 'after_setup_theme', 'navid_setup' );

/**
 * WooCommerce Wrapper overrides
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'navid_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'navid_wrapper_end', 10 );

// Replace WooCommerce default sidebar with our layout-sidebar wrapper
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 'navid_woocommerce_sidebar', 10 );

function navid_wrapper_start() {
    $sidebar_pos = get_theme_mod( 'navid_archive_sidebar', 'center' );
    $has_sidebar = ( 'right' === $sidebar_pos || 'left' === $sidebar_pos );
    $layout_class = 'layout-container';
    
    if ( $has_sidebar ) {
        $layout_class .= ' layout-has-sidebar';
        if ( 'left' === $sidebar_pos ) {
            $layout_class .= ' layout-sidebar-left';
        }
    } else {
        $layout_class .= ' layout-no-sidebar';
    }
    
    echo '<div class="' . esc_attr( $layout_class ) . '" style="padding-top:clamp(40px,5vw,72px); padding-bottom:clamp(40px,5vw,72px);">';
    echo '<div class="layout-main">';
}

function navid_wrapper_end() {
    echo '</div>'; // Close layout-main
}

function navid_woocommerce_sidebar() {
    $sidebar_pos = get_theme_mod( 'navid_archive_sidebar', 'center' );
    $has_sidebar = ( 'right' === $sidebar_pos || 'left' === $sidebar_pos );
    
    if ( $has_sidebar ) {
        echo '<aside class="layout-sidebar">';
        get_sidebar();
        echo '</aside>';
    }
    echo '</div>'; // Close layout-container
}

/**
 * Enqueue Styles & Scripts
 */
function navid_scripts() {
    // Google Fonts — dynamic based on customizer
    $heading_font = get_theme_mod( 'navid_heading_font', 'Playfair Display' );
    $body_font    = get_theme_mod( 'navid_body_font', 'Inter' );
    $families     = array();
    $families[]   = str_replace( ' ', '+', $heading_font ) . ':ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600';
    $families[]   = str_replace( ' ', '+', $body_font ) . ':wght@300;400;500;600;700';
    $font_url     = 'https://fonts.googleapis.com/css2?family=' . implode( '&family=', $families ) . '&display=swap';
    
    if ( function_exists( 'wptt_get_webfont_url' ) ) {
        $font_url = wptt_get_webfont_url( $font_url );
    }

    wp_enqueue_style(
        'navid-fonts',
        $font_url,
        array(),
        null
    );

    // Theme stylesheet
    wp_enqueue_style(
        'navid-style',
        NAVID_URI . '/assets/css/theme.css',
        array( 'navid-fonts' ),
        NAVID_VERSION
    );

    // Theme JavaScript
    wp_enqueue_script(
        'navid-script',
        NAVID_URI . '/assets/js/theme.js',
        array(),
        NAVID_VERSION,
        true
    );

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'navid_scripts' );

/**
 * Enqueue inline styles for dynamic customizer values (accent colour, image radius, etc.)
 * Uses wp_add_inline_style() as required by WP theme guidelines.
 */
/**
 * Helper function to mix a hex color with white or black (PHP alternative to CSS color-mix).
 */
function navid_mix_hex_color( $hex, $mix_with = 'white', $percentage = 50 ) {
    $hex = ltrim( $hex, '#' );
    if ( strlen( $hex ) === 3 ) {
        $hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
    }
    
    // Fallback if invalid hex
    if ( strlen( $hex ) !== 6 ) {
        return '#' . $hex;
    }

    $r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );

    $mix_r = ( 'white' === $mix_with ) ? 255 : 0;
    $mix_g = ( 'white' === $mix_with ) ? 255 : 0;
    $mix_b = ( 'white' === $mix_with ) ? 255 : 0;

    $factor = $percentage / 100;
    $inv_factor = 1 - $factor;

    $new_r = round( $r * $inv_factor + $mix_r * $factor );
    $new_g = round( $g * $inv_factor + $mix_g * $factor );
    $new_b = round( $b * $inv_factor + $mix_b * $factor );

    return sprintf( "#%02x%02x%02x", $new_r, $new_g, $new_b );
}

function navid_enqueue_inline_styles() {
    $palette  = get_theme_mod( 'navid_color_palette', 'rose' );
    $palettes = array(
        'sage'       => '#728c69',
        'ocean'      => '#2d6a8a',
        'rose'       => '#b5565d',
        'amber'      => '#c47834',
        'slate'      => '#5a6575',
        'plum'       => '#7a5c8a',
        'terracotta' => '#c9a96e',
    );

    if ( 'custom' === $palette ) {
        $accent = get_theme_mod( 'navid_accent_color', '#b5565d' );
    } else {
        $accent = isset( $palettes[ $palette ] ) ? $palettes[ $palette ] : '#b5565d';
    }

    $accent     = esc_attr( $accent );
    $max_width  = absint( get_theme_mod( 'navid_content_width', 1280 ) );

    // Calculate mixed colors via PHP to ensure 100% Safari compatibility
    $sage_pale  = navid_mix_hex_color( $accent, 'white', 85 );
    $sage_light = navid_mix_hex_color( $accent, 'white', 40 );
    $sage_deep  = navid_mix_hex_color( $accent, 'black', 20 );

    // Layout Density
    $layout_density = get_theme_mod( 'navid_layout_density', 'standard' );
    $section_spacing_y = 'clamp(32px, 5vw, 64px)';
    $section_spacing_y_hero = 'clamp(80px, 10vw, 120px)';

    if ( 'compact' === $layout_density ) {
        $section_spacing_y = 'clamp(20px, 3vw, 40px)';
        $section_spacing_y_hero = 'clamp(50px, 7vw, 80px)';
    } elseif ( 'relaxed' === $layout_density ) {
        $section_spacing_y = 'clamp(60px, 8vw, 100px)';
        $section_spacing_y_hero = 'clamp(120px, 12vw, 180px)';
    }

    // Apply Pro Scale if available
    $scale = (float) get_theme_mod( 'navid_pro_layout_scale', 1.0 );
    if ( $scale && $scale !== 1.0 ) {
        $section_spacing_y = "calc( $section_spacing_y * $scale )";
        $section_spacing_y_hero = "calc( $section_spacing_y_hero * $scale )";
    }

    $css  = ':root {';
    $css .= '--sage: ' . $accent . ';';
    $css .= '--sage-pale: ' . $sage_pale . ';';
    $css .= '--sage-deep: ' . $sage_deep . ';';
    $css .= '--sage-light: ' . $sage_light . ';';
    // Sync the secondary 'terracotta' color to the primary accent color as well, 
    // so Newspaper elements respect the global Customizer palette.
    $css .= '--terracotta: ' . $accent . ';';
    $css .= '--terracotta-light: ' . $sage_pale . ';';
    $css .= '--max-width: ' . $max_width . 'px;';
    $css .= '--navid-section-spacing-y: ' . $section_spacing_y . ';';
    $css .= '--navid-hero-spacing-y: ' . $section_spacing_y_hero . ';';
    $css .= '}';

    // --- Frontend Section Density Overrides ---
    $css .= '
    .bento-section, .featured-grid-section, .posts-grid-section, .about-values.navid-home-services {
        padding-bottom: var(--navid-section-spacing-y) !important;
    }
    .category-bar {
        margin-bottom: var(--navid-section-spacing-y) !important;
    }
    .podcast-banner-section, .navid-shortcode-section, .navid-custom-cta .cta-overlay-wrapper, .cs-section {
        padding-top: var(--navid-section-spacing-y) !important;
        padding-bottom: var(--navid-section-spacing-y) !important;
    }
    .newsletter-cta {
        margin-bottom: var(--navid-section-spacing-y) !important;
    }
    ';

    $image_radius = intval( get_theme_mod( 'navid_global_image_radius', 0 ) );
    $css .= '.post-thumbnail, .post-card, .post-card-img-wrap, .post-card-img-wrap img, .bento-item, .category-card, .wp-block-image img, .entry-content img, .woocommerce-product-gallery__image img { border-radius: ' . $image_radius . 'px !important; }';
    if ( $image_radius > 0 ) {
        $css .= '.post-thumbnail, .post-card, .post-card-img-wrap, .bento-item, .category-card { -webkit-mask-image: -webkit-radial-gradient(white, black); transform: translateZ(0); overflow: hidden; }';
    }

    if ( ! get_theme_mod( 'navid_enable_dropcap', true ) ) {
        $css .= '
        .single-body>p:first-of-type::first-letter,
        .about-text p:first-of-type::first-letter,
        .newspaper-excerpt::first-letter {
            float: none !important;
            font-size: inherit !important;
            line-height: inherit !important;
            padding: 0 !important;
            margin: 0 !important;
            font-weight: inherit !important;
            font-family: inherit !important;
            color: inherit !important;
        }
        ';
    }

    wp_add_inline_style( 'navid-style', $css );
}
add_action( 'wp_enqueue_scripts', 'navid_enqueue_inline_styles', 15 );

/**
 * Register Widget Areas
 */
function navid_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'navid' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets to the blog sidebar.', 'navid' ),
        'before_widget' => '<div class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'Shop Sidebar', 'navid' ),
        'id'            => 'sidebar-shop',
        'description'   => __( 'Widgets added here will appear on WooCommerce shop pages.', 'navid' ),
        'before_widget' => '<div class="sidebar-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'Contact Form Area', 'navid' ),
        'id'            => 'contact-form',
        'description'   => __( 'Add your contact form widget (like WPForms) here to display it on the Contact Page Template.', 'navid' ),
        'before_widget' => '<div class="contact-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 style="display:none;">',
        'after_title'   => '</h3>',
    ));

    register_sidebar( array(
        'name'          => __( 'In-Feed Widget Area 1', 'navid' ),
        'id'            => 'sidebar-in-feed-1',
        'description'   => __( 'Displays directly inside the post feed (after the 2nd post). Best used for the Editorial Team widget.', 'navid' ),
        'before_widget' => '<div class="in-feed-widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title in-feed-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar( array(
        'name'          => __( 'In-Feed Widget Area 2', 'navid' ),
        'id'            => 'sidebar-in-feed',
        'description'   => __( 'Displays directly inside the post feed (after the 4th post). Best used for Shop My Favorites or Trending Now widgets.', 'navid' ),
        'before_widget' => '<div class="in-feed-widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title in-feed-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar( array(
        'name'          => __( 'In-Feed Widget Area 3', 'navid' ),
        'id'            => 'sidebar-in-feed-3',
        'description'   => __( 'Displays directly inside the post feed (after the 6th post).', 'navid' ),
        'before_widget' => '<div class="in-feed-widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title in-feed-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar( array(
        'name'          => __( 'In-Feed Widget Area 4', 'navid' ),
        'id'            => 'sidebar-in-feed-4',
        'description'   => __( 'Displays directly inside the post feed (after the 8th post).', 'navid' ),
        'before_widget' => '<div class="in-feed-widget-container %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title in-feed-title">',
        'after_title'   => '</h4>',
    ));

    register_sidebar( array(
        'name'          => __( 'Footer Widgets', 'navid' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets to the footer area.', 'navid' ),
        'before_widget' => '<div class="footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action( 'widgets_init', 'navid_widgets_init' );

/**
 * Custom excerpt length
 */
function navid_excerpt_length( $length ) {
    if ( is_admin() ) {
        return $length;
    }
    return 20;
}
add_filter( 'excerpt_length', 'navid_excerpt_length' );

/**
 * Custom excerpt more
 */
function navid_excerpt_more( $more ) {
    if ( is_admin() ) {
        return $more;
    }
    return '&hellip;';
}
add_filter( 'excerpt_more', 'navid_excerpt_more' );

/**
 * Remove standard archive title prefixes (e.g. "Category: ", "Tag: ", "Archives: ")
 */
function navid_archive_title_clean( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    } elseif ( is_post_type_archive() ) {
        $title = post_type_archive_title( '', false );
    } elseif ( is_tax() ) {
        $title = single_term_title( '', false );
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'navid_archive_title_clean' );

/**
 * Get primary term (Category or Custom Taxonomy) for a post.
 */
function navid_get_post_term( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    if ( ! $post_id ) {
        return null;
    }

    // 1. Check standard WP categories first
    $cats = get_the_category( $post_id );
    if ( ! empty( $cats ) ) {
        return $cats[0];
    }

    // 2. If on custom taxonomy archive, get term from current taxonomy
    if ( is_tax() ) {
        $queried = get_queried_object();
        if ( $queried && isset( $queried->taxonomy ) ) {
            $terms = get_the_terms( $post_id, $queried->taxonomy );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                return $terms[0];
            }
        }
    }

    // 3. Check any custom taxonomies associated with this post type
    $taxonomies = get_object_taxonomies( get_post_type( $post_id ), 'objects' );
    if ( ! empty( $taxonomies ) ) {
        foreach ( $taxonomies as $tax_slug => $tax_obj ) {
            if ( in_array( $tax_slug, array( 'post_tag', 'post_format', 'nav_menu', 'link_category' ), true ) ) {
                continue;
            }
            $terms = get_the_terms( $post_id, $tax_slug );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                return $terms[0];
            }
        }
    }

    return null;
}

/**
 * Get category tag class
 */
function navid_get_tag_class( $category = '' ) {
    if ( is_object( $category ) && isset( $category->slug ) ) {
        $category = $category->slug;
    } elseif ( ! $category ) {
        $term = navid_get_post_term();
        $category = ( $term && isset( $term->slug ) ) ? $term->slug : 'default';
    }

    $slug = sanitize_title( $category );
    return 'tag-color-' . $slug;
}

/**
 * Generate inline style for category pill colors.
 * Creates unique colors for any category based on slug hash.
 */
function navid_get_tag_style( $category = '' ) {
    if ( is_object( $category ) && isset( $category->slug ) ) {
        $category = $category->slug;
    } elseif ( ! $category ) {
        $term = navid_get_post_term();
        $category = ( $term && isset( $term->slug ) ) ? $term->slug : 'default';
    }

    // Curated palette — 10 distinct hues
    $palette = array(
        array( '#2c5282', '#e1edf8' ), // Blue
        array( '#2f7d5e', '#e0f5ec' ), // Green
        array( '#9b2c7d', '#f8e1f3' ), // Magenta
        array( '#b7602c', '#fdecd8' ), // Orange
        array( '#6b3fa0', '#efe3f9' ), // Purple
        array( '#c43b5c', '#fce1e8' ), // Rose
        array( '#1a7a6d', '#dff5f1' ), // Teal
        array( '#3548a2', '#e3e8f9' ), // Indigo
        array( '#c44a22', '#fce5db' ), // Rust
        array( '#8b3ca0', '#f2e3f9' ), // Violet
    );

    $hash  = crc32( sanitize_title( $category ) );
    $index = abs( $hash ) % count( $palette );
    $color = $palette[ $index ];

    return sprintf( '--tag-color:%s;--tag-bg:%s;', $color[0], $color[1] );
}

/**
 * Get post reading time
 */
function navid_reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( wp_strip_all_tags( $content ) );
    $minutes = ceil( $word_count / 200 );
    return $minutes . ' ' . esc_html__( 'min read', 'navid' );
}

/**
 * Returns an allowed HTML array for inline SVG social link output.
 * Used with wp_kses() to safely output SVG icons without phpcs:ignore.
 */
function navid_kses_svg_links() {
    return array(
        'a'        => array(
            'href'       => true,
            'target'     => true,
            'rel'        => true,
            'aria-label' => true,
            'class'      => true,
        ),
        'svg'      => array(
            'width'           => true,
            'height'          => true,
            'viewbox'         => true,
            'fill'            => true,
            'stroke'          => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
            'stroke-linejoin' => true,
            'aria-hidden'     => true,
            'xmlns'           => true,
        ),
        'path'     => array(
            'd'               => true,
            'fill'            => true,
            'stroke'          => true,
            'stroke-width'    => true,
            'stroke-linecap'  => true,
            'stroke-linejoin' => true,
        ),
        'circle'   => array(
            'cx'     => true,
            'cy'     => true,
            'r'      => true,
            'fill'   => true,
            'stroke' => true,
        ),
        'rect'     => array(
            'x'      => true,
            'y'      => true,
            'width'  => true,
            'height' => true,
            'rx'     => true,
            'fill'   => true,
            'stroke' => true,
        ),
        'line'     => array(
            'x1'           => true,
            'y1'           => true,
            'x2'           => true,
            'y2'           => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
        'polyline' => array(
            'points'       => true,
            'fill'         => true,
            'stroke'       => true,
            'stroke-width' => true,
        ),
    );
}

/**
 * Get author social links — returns kses-safe HTML with SVG icons.
 */
function navid_author_socials( $user_id = false ) {
    $twitter   = get_the_author_meta( 'twitter', $user_id );
    $instagram = get_the_author_meta( 'instagram', $user_id );
    $links     = array();

    if ( $twitter ) {
        $links[] = '<a href="https://twitter.com/' . esc_attr( $twitter ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__( 'Twitter', 'navid' ) . '"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 4s-1.2 1-2.5 1.5A4.5 4.5 0 0 0 12 8v1A10.5 10.5 0 0 1 3 4s-4 9 5 13a11.5 11.5 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.1-.9A7.4 7.4 0 0 0 22 4z"/></svg></a>';
    }
    if ( $instagram ) {
        $links[] = '<a href="https://instagram.com/' . esc_attr( $instagram ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr__( 'Instagram', 'navid' ) . '"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5"/></svg></a>';
    }

    return wp_kses( implode( '', $links ), navid_kses_svg_links() );
}

/**
 * Custom pagination
 */
function navid_pagination() {
    global $wp_query;
    $big = 999999999;
    $pages = paginate_links( array(
        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format'    => '?paged=%#%',
        'current'   => max( 1, get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : absint( get_query_var( 'page' ) ) ),
        'total'     => $wp_query->max_num_pages,
        'type'      => 'array',
        'prev_text' => '&larr;',
        'next_text' => '&rarr;',
    ));

    if ( is_array( $pages ) ) {
        echo '<nav class="pagination" aria-label="' . esc_attr__( 'Posts navigation', 'navid' ) . '">';
        foreach ( $pages as $page ) {
            echo wp_kses_post( $page );
        }
        echo '</nav>';
    }
}

/**
 * Add custom meta fields to user profile
 */
function navid_user_meta_fields( $user ) {
    ?>
    <h3><?php esc_html_e( 'Social Profiles', 'navid' ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="twitter"><?php esc_html_e( 'Twitter Username', 'navid' ); ?></label></th>
            <td><input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="instagram"><?php esc_html_e( 'Instagram Username', 'navid' ); ?></label></th>
            <td><input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /></td>
        </tr>
    </table>
    <?php wp_nonce_field( 'navid_save_user_meta', 'navid_user_meta_nonce' ); ?>
    <?php
}
add_action( 'show_user_profile', 'navid_user_meta_fields' );
add_action( 'edit_user_profile', 'navid_user_meta_fields' );

/**
 * Save custom meta fields
 */
function navid_save_user_meta_fields( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if ( ! isset( $_POST['navid_user_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['navid_user_meta_nonce'] ) ), 'navid_save_user_meta' ) ) {
        return false;
    }
    if ( isset( $_POST['twitter'] ) ) {
        update_user_meta( $user_id, 'twitter', sanitize_text_field( wp_unslash( $_POST['twitter'] ) ) );
    }
    if ( isset( $_POST['instagram'] ) ) {
        update_user_meta( $user_id, 'instagram', sanitize_text_field( wp_unslash( $_POST['instagram'] ) ) );
    }
}
add_action( 'personal_options_update', 'navid_save_user_meta_fields' );
add_action( 'edit_user_profile_update', 'navid_save_user_meta_fields' );


/**
 * Customizer
 */
require get_template_directory() . '/inc/customizer.php';


/**
 * Render an ad slot
 */
function navid_render_ad( $placement ) {
    $enabled = get_theme_mod( 'navid_ad_' . $placement . '_enable', false );
    if ( ! $enabled ) return;

    $code     = get_theme_mod( 'navid_ad_' . $placement . '_code', '' );
    $image    = get_theme_mod( 'navid_ad_' . $placement . '_image', '' );
    $link     = get_theme_mod( 'navid_ad_' . $placement . '_link', '' );
    $nofollow = get_theme_mod( 'navid_ad_' . $placement . '_nofollow', true );

    if ( empty( $code ) && empty( $image ) ) return;

    echo '<div class="navid-ad navid-ad-' . esc_attr( $placement ) . '">';
    echo '<span class="navid-ad-label">' . esc_html__( 'Advertisement', 'navid' ) . '</span>';

    echo '<!-- DEBUG: code=[' . esc_html($code) . '] image=[' . esc_html($image) . '] -->';
    if ( ! empty( trim( $code ) ) ) {
        echo wp_kses_post( $code );
    } elseif ( ! empty( trim( $image ) ) ) {
        $rel = $nofollow ? ' rel="nofollow noopener"' : ' rel="noopener"';
        if ( ! empty( $link ) ) {
            echo '<a href="' . esc_url( $link ) . '" target="_blank"' . $rel . '>';
        }
        echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Advertisement', 'navid' ) . '" loading="lazy" style="max-width:100%;height:auto;" />';
        if ( ! empty( $link ) ) {
            echo '</a>';
        }
    }

    echo '</div>';
}

/**
 * Header Ad Banner – renders above header
 */
function navid_header_ad_banner() {
    navid_render_ad( 'header' );
}
add_action( 'wp_body_open', 'navid_header_ad_banner', 5 );

/**
 * Single Post Ads — before and after content
 */
function navid_single_post_ads( $content ) {
    if ( ! is_single() ) return $content;

    $before = '';
    $after  = '';

    if ( get_theme_mod( 'navid_ad_before_enable', false ) ) {
        ob_start();
        navid_render_ad( 'before' );
        $before = ob_get_clean();
    }

    if ( get_theme_mod( 'navid_ad_after_enable', false ) ) {
        ob_start();
        navid_render_ad( 'after' );
        $after = ob_get_clean();
    }

    return $before . $content . $after;
}
add_filter( 'the_content', 'navid_single_post_ads', 50 );

/**
 * Default Marquee Strip Renderer
 */
function navid_default_marquee() {
    if ( ! get_theme_mod( 'navid_marquee_show', true ) ) {
        return;
    }

    $marquee_source = get_theme_mod( 'navid_marquee_source', 'categories' );
    $ticker_html = '';

    if ( 'custom' === $marquee_source ) {
        // Custom text mode
        $custom_text = get_theme_mod( 'navid_marquee_text', 'LIFESTYLE • TECHNOLOGY • BUSINESS • CULTURE • DESIGN • WELLNESS' );
        $items = array_map( 'trim', preg_split( '/[•|·,]/', $custom_text ) );
        foreach ( $items as $item ) {
            if ( ! empty( $item ) ) {
                $ticker_html .= '<span class="marquee-item"><span class="marquee-title">' . esc_html( $item ) . '</span></span><span class="marquee-dot">&bull;</span>';
            }
        }
    } else {
        // Posts mode (default)
        $marquee_count = get_theme_mod( 'navid_marquee_count', 10 );
        $trending = new WP_Query( array( 'posts_per_page' => $marquee_count, 'ignore_sticky_posts' => 1 ) );
        
        if ( $trending->have_posts() ) {
            while ( $trending->have_posts() ) {
                $trending->the_post();
                $thumb = '';
                if ( has_post_thumbnail() ) {
                    $thumb = '<img class="marquee-thumb" src="' . esc_url( get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ) . '" alt="" loading="lazy" />';
                }
                $ticker_html .= '<a href="' . esc_url( get_permalink() ) . '" class="marquee-item">' . $thumb . '<span class="marquee-title">' . esc_html( wp_trim_words( get_the_title(), 6, '…' ) ) . '</span></a><span class="marquee-dot">&bull;</span>';
            }
            wp_reset_postdata();
        }
    }

    if ( ! empty( $ticker_html ) ) {
        ?>
        <div id="marquee-wrapper">
          <div class="marquee-strip">
            <div class="marquee-track">
            <?php 
            // Duplicate 4 times for seamless infinite scroll
            for ( $i = 0; $i < 4; $i++ ) {
                echo wp_kses_post( $ticker_html );
            }
            ?>
            </div>
          </div>
        </div>
        <?php
    }
}
add_action( 'navid_render_marquee', 'navid_default_marquee' );

/**
 * Register Block Styles & Patterns
 */
function navid_register_block_styles() {
	register_block_style(
		'core/quote',
		array(
			'name'         => 'navid-large-quote',
			'label'        => __( 'Large Quote', 'navid' ),
		)
	);
}
add_action( 'init', 'navid_register_block_styles' );

function navid_register_block_patterns() {
	register_block_pattern_category(
		'navid',
		array( 'label' => __( 'Navid Patterns', 'navid' ) )
	);

	register_block_pattern(
		'navid/hero-pattern',
		array(
			'title'       => __( 'Navid Hero', 'navid' ),
			'categories'  => array( 'navid' ),
			'content'     => '<!-- wp:group {"align":"full","layout":{"type":"constrained"}} --><div class="wp-block-group alignfull"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">' . esc_html__( 'Welcome to Navid', 'navid' ) . '</h2><!-- /wp:heading --></div><!-- /wp:group -->',
		)
	);
}
add_action( 'init', 'navid_register_block_patterns' );

/**
 * TGM Plugin Activation
 */
require_once NAVID_DIR . '/inc/navid-tgmpa.php';

/**
 * Hero Layout: Classic Newspaper (Tribune) — Free version renderer.
 * Mirrors the navid-pro template but registered here so the free Quick Start
 * Preset can switch to this layout without needing navid-pro active.
 * Skipped entirely when navid-pro is active (it registers its own richer version).
 */
if ( ! navid_is_pro_active() ) {

    function navid_free_render_hero_newspaper() {
        $visible_count = 3;
        $hero_source         = get_theme_mod( 'navid_hero_source', 'latest' );
        $editor_picks_source = get_theme_mod( 'navid_editor_picks_source', 'latest' );
        $editor_picks_cat    = get_theme_mod( 'navid_editor_picks_category', 0 );

        $excluded_post_ids = array();

        // 1. Center Featured Post
        $featured_post = null;
        if ( 'custom' === $hero_source ) {
            // Custom content handled directly in markup
        } elseif ( 'reviews' === $hero_source && function_exists( 'navid_get_review_posts' ) ) {
            $reviews = navid_get_review_posts( 1 );
            if ( ! empty( $reviews ) ) {
                $featured_post = $reviews[0];
                $excluded_post_ids[] = $featured_post->ID;
            }
        } elseif ( 'sticky' === $hero_source ) {
            $sticky = get_option( 'sticky_posts' );
            if ( ! empty( $sticky ) ) {
                $sticky_posts_query = get_posts( array(
                    'post__in'            => $sticky,
                    'posts_per_page'      => 1,
                    'ignore_sticky_posts' => true,
                    'no_found_rows'       => true,
                ) );
                if ( ! empty( $sticky_posts_query ) ) {
                    $featured_post = $sticky_posts_query[0];
                    $excluded_post_ids[] = $featured_post->ID;
                }
            }
        }

        if ( 'custom' !== $hero_source && ! $featured_post ) {
            $feat_query = get_posts( array(
                'posts_per_page'      => 1,
                'ignore_sticky_posts' => true,
                'post_status'         => 'publish',
                'no_found_rows'       => true,
            ) );
            if ( ! empty( $feat_query ) ) {
                $featured_post = $feat_query[0];
                $excluded_post_ids[] = $featured_post->ID;
            }
        }

        if ( 'custom' !== $hero_source && ! $featured_post ) {
            return;
        }

        // 2. Right Stack Posts
        $right_posts = array();
        if ( 'category' === $editor_picks_source && ! empty( $editor_picks_cat ) ) {
            $right_args = array(
                'posts_per_page'      => $visible_count,
                'cat'                 => $editor_picks_cat,
                'ignore_sticky_posts' => true,
                'post_status'         => 'publish',
                'no_found_rows'       => true,
            );
            if ( ! empty( $excluded_post_ids ) ) {
                $right_args['post__not_in'] = $excluded_post_ids;
            }
            $right_posts = get_posts( $right_args );
            foreach ( $right_posts as $rp ) {
                $excluded_post_ids[] = $rp->ID;
            }
        } elseif ( 'reviews' === $editor_picks_source && function_exists( 'navid_get_review_posts' ) ) {
            $right_posts = navid_get_review_posts( $visible_count );
            foreach ( $right_posts as $rp ) {
                $excluded_post_ids[] = $rp->ID;
            }
        }

        // 3. Left Stack Posts (Smart Deduplicated & Category Excluded)
        $left_args = array(
            'posts_per_page'      => $visible_count,
            'ignore_sticky_posts' => true,
            'post_status'         => 'publish',
            'no_found_rows'       => true,
        );

        if ( ! empty( $excluded_post_ids ) ) {
            $left_args['post__not_in'] = array_unique( $excluded_post_ids );
        }

        if ( 'category' === $editor_picks_source && ! empty( $editor_picks_cat ) ) {
            $left_args['category__not_in'] = array( (int) $editor_picks_cat );
        }

        $left_posts = get_posts( $left_args );

        if ( count( $left_posts ) < $visible_count && ! empty( $left_args['category__not_in'] ) ) {
            $needed = $visible_count - count( $left_posts );
            $current_left_ids = wp_list_pluck( $left_posts, 'ID' );
            $backfill_excluded = array_merge( $excluded_post_ids, $current_left_ids );
            
            $backfill_posts = get_posts( array(
                'posts_per_page'      => $needed,
                'ignore_sticky_posts' => true,
                'post_status'         => 'publish',
                'post__not_in'        => array_unique( $backfill_excluded ),
                'no_found_rows'       => true,
            ) );
            if ( ! empty( $backfill_posts ) ) {
                $left_posts = array_merge( $left_posts, $backfill_posts );
            }
        }

        // 4. Fallback for Right Stack if not category-specific
        if ( empty( $right_posts ) ) {
            $all_shown_ids = array_merge( $excluded_post_ids, wp_list_pluck( $left_posts, 'ID' ) );
            $right_posts = get_posts( array(
                'posts_per_page'      => $visible_count,
                'ignore_sticky_posts' => true,
                'post_status'         => 'publish',
                'post__not_in'        => array_unique( $all_shown_ids ),
                'no_found_rows'       => true,
            ) );
        }

        ?>
        <section class="hero-newspaper-wrapper">
          <div class="hero-newspaper-grid">

            <!-- Left Stack -->
            <div class="newspaper-column newspaper-stack-left">
              <?php foreach ( $left_posts as $p ) :
                  global $post;
                  $post = $p;
                  setup_postdata( $post );
                  $cats     = get_the_category();
                  $cat_name = ! empty( $cats ) ? $cats[0]->name : 'Story';
              ?>
              <article class="newspaper-card-small">
                  <span class="newspaper-cat"><?php echo esc_html( $cat_name ); ?></span>
                  <h3 class="newspaper-title-small"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( wp_trim_words( get_the_title(), 12 ) ); ?></a></h3>
                  <div class="newspaper-meta"><?php echo esc_html( get_the_date( 'M j' ) ); ?></div>
              </article>
              <?php endforeach; wp_reset_postdata(); ?>
            </div>

            <!-- Center Feature -->
            <div class="newspaper-column newspaper-feature">
              <?php
              $hero_source = get_theme_mod( 'navid_hero_source', 'latest' );
              if ( 'custom' === $hero_source ) {
                  $img = get_theme_mod( 'navid_hero_image' );
                  if ( empty( $img ) ) {
                      $img = get_template_directory_uri() . '/assets/images/hero-navid.jpg';
                  }
                  $cat_name = 'Featured';
                  $title    = get_theme_mod( 'navid_hero_title', 'The Modern <em>Aesthetic</em>' );
                  $excerpt  = get_theme_mod( 'navid_hero_excerpt', "Discover the world's most fascinating stories, curated for the modern, curious mind." );
                  $link     = get_theme_mod( 'navid_hero_btn_url', '#' );
                  $author   = get_bloginfo( 'name' );
                  $date     = date_i18n( 'F j, Y' );
              ?>
              <article class="newspaper-card-featured">
                  <a href="<?php echo esc_url( $link ); ?>" class="newspaper-img-wrapper">
                      <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>" loading="lazy" />
                  </a>
                  <div class="newspaper-featured-content">
                      <span class="newspaper-cat"><?php echo esc_html( $cat_name ); ?></span>
                      <h1 class="newspaper-title-large"><a href="<?php echo esc_url( $link ); ?>"><?php echo wp_kses_post( $title ); ?></a></h1>
                      <p class="newspaper-excerpt"><?php echo esc_html( $excerpt ); ?></p>
                      <div class="newspaper-meta">By <strong><?php echo esc_html( $author ); ?></strong> &middot; <?php echo esc_html( $date ); ?></div>
                  </div>
              </article>
              <?php
              } else {
                  global $post;
                  $post = $featured_post;
                  setup_postdata( $post );
                  $img = get_the_post_thumbnail_url( get_the_ID(), 'large' );
                  if ( empty( $img ) ) {
                      $img = get_template_directory_uri() . '/assets/images/hero-navid.jpg';
                  }
                  $cats     = get_the_category();
                  $cat_name = ! empty( $cats ) ? $cats[0]->name : 'Story';
              ?>
              <article class="newspaper-card-featured">
                  <a href="<?php the_permalink(); ?>" class="newspaper-img-wrapper">
                      <img src="<?php echo esc_url( $img ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                  </a>
                  <div class="newspaper-featured-content">
                      <span class="newspaper-cat"><?php echo esc_html( $cat_name ); ?></span>
                      <h1 class="newspaper-title-large"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( get_the_title() ); ?></a></h1>
                      <p class="newspaper-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
                      <div class="newspaper-meta">By <strong><?php the_author(); ?></strong> &middot; <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></div>
                  </div>
              </article>
              <?php wp_reset_postdata(); } ?>
            </div>

            <!-- Right Stack -->
            <div class="newspaper-column newspaper-stack-right">
              <?php foreach ( $right_posts as $p ) :
                  global $post;
                  $post = $p;
                  setup_postdata( $post );
                  $cats     = get_the_category();
                  $cat_name = ! empty( $cats ) ? $cats[0]->name : 'Story';
              ?>
              <article class="newspaper-card-small">
                  <span class="newspaper-cat"><?php echo esc_html( $cat_name ); ?></span>
                  <h3 class="newspaper-title-small"><a href="<?php the_permalink(); ?>"><?php echo wp_kses_post( wp_trim_words( get_the_title(), 12 ) ); ?></a></h3>
                  <div class="newspaper-meta"><?php echo esc_html( get_the_date( 'M j' ) ); ?></div>
              </article>
              <?php endforeach; wp_reset_postdata(); ?>
            </div>

          </div>
        </section>
        <?php
    }
    add_action( 'navid_render_hero_newspaper', 'navid_free_render_hero_newspaper' );

}

/**
 * Register Block Patterns
 */
function navid_register_patterns() {
    if ( function_exists( 'register_block_pattern_category' ) ) {
        register_block_pattern_category(
            'navid-patterns',
            array( 'label' => __( 'Navid Patterns', 'navid' ) )
        );
    }
}
add_action( 'init', 'navid_register_patterns' );

/**
 * Render Static Front Page Content.
 *
 * Renders static page editor content (blocks/text/shortcodes) when 'show_on_front' is set to 'page'.
 * Ensures 100% compliance with WordPress Theme Review Team requirements while providing
 * seamless integration with Navid magazine layout.
 */
function navid_render_frontpage_static_content() {
    if ( 'page' !== get_option( 'show_on_front' ) ) {
        return;
    }

    $pos = get_theme_mod( 'navid_frontpage_static_page_content_position', 'below_hero' );
    if ( 'hide' === $pos ) {
        return;
    }

    $page_id = (int) get_option( 'page_on_front' );
    if ( ! $page_id ) {
        $page_id = get_queried_object_id();
    }

    if ( ! $page_id ) {
        return;
    }

    $front_post = get_post( $page_id );
    if ( ! $front_post || empty( trim( $front_post->post_content ) ) ) {
        return;
    }

    ?>
    <section class="navid-front-page-static-content" aria-label="<?php esc_attr_e( 'Front Page Content', 'navid' ); ?>">
        <div class="container" style="max-width: var(--content-width, 1200px); margin: 0 auto; padding-top: clamp(30px, 4vw, 60px); padding-bottom: clamp(30px, 4vw, 60px);">
            <div class="single-body page-body article-body">
                <?php
                global $post;
                $post = $front_post;
                setup_postdata( $post );

                the_content();

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'navid' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span>',
                    'link_after'  => '</span>',
                ) );

                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
    <?php
}

/**
 * Filter imported demo custom links pointing to demo site (e.g. "Home" link) to current site home URL.
 *
 * @param array $items The menu items.
 * @return array
 */
function navid_filter_demo_menu_home_links( $items ) {
    if ( empty( $items ) || ! is_array( $items ) ) {
        return $items;
    }

    $demo_host = 'navid.wpmatcha.com';
    $home_url  = trailingslashit( home_url() );

    foreach ( $items as $item ) {
        if ( isset( $item->type ) && 'custom' === $item->type && ! empty( $item->url ) ) {
            if ( false !== strpos( $item->url, $demo_host ) ) {
                $path = trim( (string) wp_parse_url( $item->url, PHP_URL_PATH ), '/' );
                if ( in_array( $path, array( '', 'magazine', 'newspaper', 'news', 'bento' ), true ) ) {
                    $item->url = $home_url;
                }
            }
        }
    }

    return $items;
}
add_filter( 'wp_nav_menu_objects', 'navid_filter_demo_menu_home_links', 10, 1 );
