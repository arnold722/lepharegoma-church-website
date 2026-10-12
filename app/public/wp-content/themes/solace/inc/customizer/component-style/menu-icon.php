<?php
function solace_style_components_menu_icon()
{
    $top = get_theme_mod('hfg_header_layout_top_new_text_color', '#fff');
    $main = get_theme_mod('hfg_header_layout_main_new_text_color', '#fff');
    $bottom = get_theme_mod('hfg_header_layout_bottom_new_text_color', '#fff');

    $style = '';
    if (empty($top)) {
        $style .= ".header-top .builder-item--nav-icon button svg {fill: var(--sol-color-link-button-initial);}";
        $style .= ".header-top .builder-item--nav-icon button:hover svg {fill: var(--sol-color-link-button-initial) !important;}";
        $style .= ".header-top .builder-item--nav-icon button span {color: var(--sol-color-link-button-initial);}";
        $style .= ".header-top .builder-item--nav-icon button {border-color: var(--sol-color-link-button-initial);}";
        $style .= ".header-top .builder-item--nav-icon button:hover {border-color: var(--sol-color-link-button-initial);}";
    }

    if (empty($main)) {
        $style .= ".header-main .builder-item--nav-icon button svg {fill: var(--sol-color-link-button-initial);}";
        $style .= ".header-main .builder-item--nav-icon button:hover svg {fill: var(--sol-color-link-button-initial) !important;}";
        $style .= ".header-main .builder-item--nav-icon button span {color: var(--sol-color-link-button-initial);}";
        $style .= ".header-main .builder-item--nav-icon button {border-color: var(--sol-color-link-button-initial);}";
        $style .= ".header-main .builder-item--nav-icon button:hover {border-color: var(--sol-color-link-button-initial);}";
    }

    if (empty($bottom)) {
        $style .= ".header-bottom .builder-item--nav-icon button svg {fill: var(--sol-color-link-button-initial);}";
        $style .= ".header-bottom .builder-item--nav-icon button:hover svg {fill: var(--sol-color-link-button-initial) !important;}";
        $style .= ".header-bottom .builder-item--nav-icon button span {color: var(--sol-color-link-button-initial);}";
        $style .= ".header-bottom .builder-item--nav-icon button {border-color: var(--sol-color-link-button-initial);}";
        $style .= ".header-bottom .builder-item--nav-icon button:hover {border-color: var(--sol-color-link-button-initial);}";
    }
    wp_add_inline_style('solace-theme', $style);
}
add_action('wp_enqueue_scripts', 'solace_style_components_menu_icon');
