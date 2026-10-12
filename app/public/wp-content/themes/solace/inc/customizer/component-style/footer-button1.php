<?php

function solace_style_footer_button1()
{
    // Default 
    $default_border_width = [
        'desktop-unit' => 'px',
        'tablet-unit'  => 'px',
        'mobile-unit'  => 'px',
        'desktop'      => [
            'top'    => 1,
            'right'  => 1,
            'bottom' => 1,
            'left'   => 1,
        ],
        'tablet'       => [
            'top'    => 1,
            'right'  => 1,
            'bottom' => 1,
            'left'   => 1,
        ],
        'mobile'       => [
            'top'    => 1,
            'right'  => 1,
            'bottom' => 1,
            'left'   => 1,
        ],
    ];

    $default_border_radius = [
        'desktop-unit' => 'px',
        'tablet-unit'  => 'px',
        'mobile-unit'  => 'px',
        'desktop'      => [
            'top'    => 3,
            'right'  => 3,
            'bottom' => 3,
            'left'   => 3,
        ],
        'tablet'       => [
            'top'    => 3,
            'right'  => 3,
            'bottom' => 3,
            'left'   => 3,
        ],
        'mobile'       => [
            'top'    => 3,
            'right'  => 3,
            'bottom' => 3,
            'left'   => 3,
        ],
    ];

    $button_style = esc_html(get_theme_mod('button_base3_style_btn_id', 'button1'));
    $font_color = get_theme_mod('button_base3_font_color_style_setting', 'var(--sol-color-page-title-text)');
    if (empty($font_color)) {
        $font_color = 'inherit';
    }
    $font_hover_color = get_theme_mod('button_base3_font_hover_color_style_setting', 'var(--sol-color-page-title-text)');
    $button_color = get_theme_mod('button_base3_button_bg_color_style_setting', 'var(--sol-color-button-initial)');
    $button_hover_color = get_theme_mod('button_base3_button_bg_hover_color_style_setting', 'var(--sol-color-button-initial)');
    $button_border_color = get_theme_mod('button_base3_button_border_color_style_setting', 'var(--sol-color-button-initial)');
    $button_border_hover_color = get_theme_mod('button_base3_button_border_hover_color_style_setting', 'var(--sol-color-button-initial)');
    $button_border_width = get_theme_mod('button_base3_button_border_width_style_setting', $default_border_width);
    $button_border_top_width = absint($button_border_width['desktop']['top']);
    $button_border_right_width = absint($button_border_width['desktop']['right']);
    $button_border_bottom_width = absint($button_border_width['desktop']['bottom']);
    $button_border_left_width = absint($button_border_width['desktop']['left']);
    $button_border_desktop_unit = esc_html($button_border_width['desktop-unit']);
    // $button_width = absint(get_theme_mod('button_base3_button_size_style_setting', 100));
    // $button_px = esc_html('px');

    // Border Radius Style
    $border_radius_styles = '';
    $border_radius = get_theme_mod('button_base3_button_border_radius_style_setting', $default_border_radius);
    $border_radius_desktop_unit = $border_radius['desktop-unit'];
    $border_radius_tablet_unit = $border_radius['tablet-unit'];
    $border_radius_mobile_unit = $border_radius['mobile-unit'];

    // Desktop, Tablet, and Mobile
    $breakpoints = array(
        'desktop' => '@media only screen and (min-width: 992px)',
        'tablet' => '@media only screen and (max-width: 992px)',
        'mobile' => '@media only screen and (max-width: 580px)'
    );

    foreach ($breakpoints as $breakpoint => $media_query) {
        $unit = ${"border_radius_{$breakpoint}_unit"};
        $values = implode("{$unit} ", $border_radius[$breakpoint]);
        $style = "border-radius: {$values}{$unit};";

        $border_radius_styles .= $media_query . " {
            .builder-item--button_base3 a.button {
                $style
            }
        }";
    }
    wp_add_inline_style('solace-theme', $border_radius_styles);

    // Fix Margin And Padding
    // $style_color_basefont = ".builder-item--button_base3 a.button {--primarybtnpadding: var(--padding);}";
    $style_color_basefont = ".builder-item--button_base3 a.button { padding: var(--padding, 8px 12px); --primarybtnpadding: var(--padding);}";
    $style_color_basefont .= "div.item--inner.builder-item--button_base3 {padding: 0;}";
    wp_add_inline_style('solace-theme', $style_color_basefont);     

    // Style button1
    $style1 = ".builder-item--button_base3 a.button {color: $font_color;}";
    $style1 .= ".builder-item--button_base3:hover a.button1 {color: $font_hover_color;}";
    $style1 .= ".builder-item--button_base3 a.button1 {background: $button_color;}";
    $style1 .= ".builder-item--button_base3:hover a.button1 {background: $button_hover_color;}";
    // $style1 .= ".builder-item--button_base3 a.button1 {width: $button_width$button_px}";
    $style1 .= ".builder-item--button_base3 a.button1 {border: none;}";
    wp_add_inline_style('solace-theme', $style1);

    // Style button2
    $style2 = ".builder-item--button_base3 a.button {color: $font_color;}";
    $style2 .= ".builder-item--button_base3:hover a.button2 {color: $font_hover_color;}";
    $style2 .= ".builder-item--button_base3 a.button2 {background: transparent;}";
    $style2 .= ".builder-item--button_base3:hover a.button2 {background: transparent;}";
    $style2 .= ".builder-item--button_base3 a.button2 {border-color: $button_border_color !important;}";
    $style2 .= ".builder-item--button_base3:hover a.button2 {border-color: $button_border_hover_color !important;}";
    $style2 .= ".builder-item--button_base3 a.button2 {border-top-width: $button_border_top_width$button_border_desktop_unit !important;} ";
    $style2 .= ".builder-item--button_base3 a.button2 {border-right-width: $button_border_right_width$button_border_desktop_unit !important;} ";
    $style2 .= ".builder-item--button_base3 a.button2 {border-bottom-width: $button_border_bottom_width$button_border_desktop_unit !important;} ";
    $style2 .= ".builder-item--button_base3 a.button2 {border-left-width: $button_border_left_width$button_border_desktop_unit !important;} ";
    $style2 .= ".builder-item--button_base3 a.button2 {border-style: solid !important;} ";
    // $style2 .= ".builder-item--button_base3 a.button2 {width: $button_width$button_px}";
    wp_add_inline_style('solace-theme', $style2);

    if (!is_customize_preview()) {
        $row_top_inherit = get_theme_mod('hfg_footer_layout_top_new_text_color', 'var(--sol-color-page-title-text)');
        $row_main_inherit = get_theme_mod('hfg_footer_layout_main_new_text_color', 'var(--sol-color-page-title-text)');
        $row_bottom_inherit = get_theme_mod('hfg_footer_layout_bottom_new_text_color', 'var(--sol-color-page-title-text)');
    
        if (empty($row_top_inherit)) {
            $row_top_inherit = 'inherit';
        }
    
        if (empty($row_main_inherit)) {
            $row_main_inherit = 'inherit';
        }
    
        if (empty($row_bottom_inherit)) {
            $row_bottom_inherit = 'inherit';
        }
    
        $style_inherit = ".footer-top .item--inner.builder-item--button_base3 {color: $row_top_inherit}";
        $style_inherit .= ".footer-main .item--inner.builder-item--button_base3 {color: $row_main_inherit}";
        $style_inherit .= ".footer-bottom .item--inner.builder-item--button_base3 {color: $row_bottom_inherit}";
    
        wp_add_inline_style('solace-theme', $style_inherit);
    }
    
    $style_color_basefont = ".site-footer .footer-top, .site-footer .footer-main, .site-footer .footer-bottom {color: var(--sol-color-base-font)}";
    wp_add_inline_style('solace-theme', $style_color_basefont);  

}
add_action('wp_enqueue_scripts', 'solace_style_footer_button1');
