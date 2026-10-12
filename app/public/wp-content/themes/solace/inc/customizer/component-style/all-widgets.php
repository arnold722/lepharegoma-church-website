<?php

function solace_style_components_widgets()
{
    $header_widget   = sanitize_key(get_theme_mod('header-widgets_component_list_style', 'none'));
    $footer_one   = sanitize_key(get_theme_mod('footer-one-widgets_component_list_style', 'none'));
    $footer_two   = sanitize_key(get_theme_mod('footer-two-widgets_component_list_style', 'none'));
    $footer_three = sanitize_key(get_theme_mod('footer-three-widgets_component_list_style', 'none'));
    $footer_four  = sanitize_key(get_theme_mod('footer-four-widgets_component_list_style', 'none'));


    $style = ".builder-item--header-widgets li {list-style: $header_widget;} ";
    $style .= ".builder-item--footer-one-widgets li {list-style: $footer_one;} ";
    $style .= ".builder-item--footer-two-widgets li {list-style: $footer_two;} ";
    $style .= ".builder-item--footer-three-widgets li {list-style: $footer_three;} ";
    $style .= ".builder-item--footer-four-widgets li {list-style: $footer_four;} ";

    // Header
    if ($header_widget === 'none') {
        $style .= ".builder-item--header-widgets li {margin-left: 0;} ";
    }
    // Footer 1
    if ($footer_one === 'none') {
        $style .= ".builder-item--footer-one-widgets li {margin-left: 0;} ";
    }
    // Footer 2
    if ($footer_two === 'none') {
        $style .= ".builder-item--footer-two-widgets li {margin-left: 0;} ";
    }
    // Footer 3
    if ($footer_three === 'none') {
        $style .= ".builder-item--footer-three-widgets li {margin-left: 0;} ";
    }
    // Footer 4
    if ($footer_four === 'none') {
        $style .= ".builder-item--footer-four-widgets li {margin-left: 0;} ";
    }
    wp_add_inline_style('solace-theme', $style);
}
add_action('wp_enqueue_scripts', 'solace_style_components_widgets');
