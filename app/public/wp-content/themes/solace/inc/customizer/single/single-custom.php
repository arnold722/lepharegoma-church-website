<?php

use Solace\Core\Settings\Config;
use Solace\Customizer\Options\Layout_Single_Post;

/**
 * Adds custom styles to the theme based on the single post settings.
 *
 * @since 1.0.0
 * @access public
 * @return void
 */
function solace_add_solace_custom_styles()
{
    $single_templates = get_theme_mod('solace_post_header_layout', 'layout 1');
    $data = new Layout_Single_Post();
    $default = $data->blog_post_single_featured_image_default();
    $data = get_theme_mod('solace_single_post_featured_image', $default);

    if ('custom' === $single_templates) {
        $style_image_ratio = '';
        $style_image_ratio .= solace_generate_image_css(".main-single.main-single-custom", $data['mobile'], "mobile");
        $style_image_ratio .= solace_generate_image_css(".main-single.main-single-custom", $data['tablet'], "tablet");
        $style_image_ratio .= solace_generate_image_css(".main-single.main-single-custom", $data['desktop'], "desktop");

        wp_add_inline_style('solace-theme', $style_image_ratio);
    }
}
add_action('wp_enqueue_scripts', 'solace_add_solace_custom_styles');

/**
 * Generates CSS for image ratio, scale, and visibility.
 *
 * @param string $selector CSS selector.
 * @param array $settings Image settings including ratio, scale, and visibility.
 * @param string $media_query Media query type (mobile, tablet, desktop).
 * @return string Generated CSS.
 */
function solace_generate_image_css($selector, $settings, $media_query)
{
    $css = '';
    $css_image_base = "
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border-radius: inherit;
        -o-object-fit: cover;
        object-fit: cover;
        -o-object-position: 50% 50%;
        object-position: 50% 50%;
    ";

    $padding = solace_get_padding($settings['imageRatio']);
    $object_fit = solace_get_object_fit($settings['imageScale']);
    $object_fit_padding = solace_get_object_fit_padding($settings['imageScale']);
    $display = solace_get_display($settings['imageVisibility']);

    if ('original' !== $settings['imageRatio']) {
        $css .= "$selector figure.solace-featured-image img { $css_image_base }";
    }

    $css .= "$selector figure.solace-featured-image span.ratio { padding-bottom: $padding; }";
    if ('original' === $settings['imageRatio'] && 'contain' !== $settings['imageScale']) {
        $css .= "$selector figure.solace-featured-image img { $css_image_base $object_fit }";
        $css .= "$selector figure.solace-featured-image span.ratio { $object_fit_padding }";
    }

    if ('original' === $settings['imageRatio'] && 'contain' === $settings['imageScale']) {
        $css .= "$selector figure.solace-featured-image img { $object_fit }";
    }

    $css .= "$selector figure.solace-featured-image { display: $display; }";

    $media_query_css = solace_wrap_in_media_query($css, $media_query);
    return $media_query_css;
}

function solace_get_padding($ratio)
{
    switch ($ratio) {
        case '1/1':
            return '100%';
        case '4/3':
            return '75%';
        case '16/9':
            return '56.3%';
        case '2/1':
            return '50%';
        default:
            return 'unset';
    }
}

function solace_get_object_fit($scale)
{
    switch ($scale) {
        case 'contain':
            return 'object-fit: contain; -o-object-fit: contain;';
        case 'cover':
            return "object-fit: cover; -o-object-fit: cover;";
        case 'fill':
            return "object-fit: fill; -o-object-fit: fill;";
        default:
            return '';
    }
}

function solace_get_object_fit_padding($scale)
{
    if ($scale === 'cover' || $scale === 'fill') {
        return 'padding-bottom: 100%';
    }
    return '';
}

function solace_get_display($visibility)
{
    return $visibility ? 'block' : 'none';
}

function solace_wrap_in_media_query($css, $media_query)
{
    switch ($media_query) {
        case 'mobile':
            return "@media (max-width: 580px) { $css }";
        case 'tablet':
            return "@media (min-width: 580px) { $css }";
        case 'desktop':
            return "@media (min-width: 1024px) { $css }";
        default:
            return $css;
    }
}

/**
 * Adds custom styles to the theme based on the single post setting divider.
 *
 * @since 1.0.0
 * @access public
 * @return void
 *
 * @param string $single_templates The selected single post header layout.
 */
function solace_add_custom_styles_for_divider()
{
    $single_templates = get_theme_mod('solace_post_header_layout', 'layout 1');
    $default = [
        'mobile'       => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
        ],
        'tablet'       => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
        ],
        'desktop'      => [
            'top'    => 0,
            'right'  => 0,
            'bottom' => 0,
            'left'   => 0,
        ],
        'mobile-unit'  => 'px',
        'tablet-unit'  => 'px',
        'desktop-unit' => 'px',
    ];
    $post_meta_divider = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_MARGIN, $default );
    $post_meta_desktop_unit = $post_meta_divider['desktop-unit'];
    $post_meta_desktop_right = $post_meta_divider['desktop']['right'] . $post_meta_desktop_unit;
    $post_meta_desktop_left = $post_meta_divider['desktop']['left'] . $post_meta_desktop_unit;

    $post_meta_tablet_unit = $post_meta_divider['tablet-unit'];
    $post_meta_tablet_right = $post_meta_divider['tablet']['right'] . $post_meta_tablet_unit;
    $post_meta_tablet_left = $post_meta_divider['tablet']['left'] . $post_meta_tablet_unit;

    $post_meta_mobile_unit = $post_meta_divider['mobile-unit'];
    $post_meta_mobile_right = $post_meta_divider['mobile']['right'] . $post_meta_mobile_unit;
    $post_meta_mobile_left = $post_meta_divider['mobile']['left'] . $post_meta_mobile_unit;    

    if ('custom' === $single_templates) {
        $style = ".main-single-custom .container-single .row1 article .boxes-ordering .divider-border .divider {";
        $style .= "margin-right: $post_meta_desktop_right;";
        $style .= "margin-left: $post_meta_desktop_left;";
        $style .= "}";

        $style .= "@media (min-width: 768px) {";
            $style = ".main-single-custom .container-single .row1 article .boxes-ordering .divider-border .divider {";
            $style .= "margin-right: $post_meta_tablet_right;";
            $style .= "margin-left: $post_meta_tablet_left;";
            $style .= "}";            
        $style .= "}";

        $style .= "@media (min-width: 580px) {";
            $style = ".main-single-custom .container-single .row1 article .boxes-ordering .divider-border .divider {";
            $style .= "margin-right: $post_meta_mobile_right;";
            $style .= "margin-left: $post_meta_mobile_left;";
            $style .= "}";            
        $style .= "}";        

        wp_add_inline_style('solace-theme', $style);
    }
}
add_action('wp_enqueue_scripts', 'solace_add_custom_styles_for_divider');