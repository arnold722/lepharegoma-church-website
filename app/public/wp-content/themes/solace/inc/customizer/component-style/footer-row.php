<?php

function solace_style_footer_row()
{
    $hide_top_row = get_theme_mod( 'solace_pro_global_footer_settings_top_shortcut', false );
    $hide_main_row = get_theme_mod( 'solace_pro_global_footer_settings_main_shortcut', false );
    $hide_bottom_row = get_theme_mod( 'solace_pro_global_footer_settings_bottom_shortcut', false );

    $style = '';
    
    // Top
    if ( $hide_top_row ) {
        $style .= 'footer.site-footer .footer--row.footer-top { display: none; }';
    }

    // Main
    if ( $hide_main_row ) {
        $style .= 'footer.site-footer .footer--row.footer-main { display: none; }';
    }

    // Bottom
    if ( $hide_bottom_row ) {
        $style .= 'footer.site-footer .footer--row.footer-bottom { display: none; }';
    }    

    wp_add_inline_style('solace-theme', $style);
}
add_action('wp_enqueue_scripts', 'solace_style_footer_row');
