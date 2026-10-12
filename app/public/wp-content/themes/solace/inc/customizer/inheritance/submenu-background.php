<?php

$theme_mods = get_theme_mods();

if ( ! isset( $theme_mods['primary-menu_submenu_background_color'] ) ) {

    if ( isset( $theme_mods['hfg_header_layout_v2'] ) ) {
        $header_layout = json_decode($theme_mods['hfg_header_layout_v2'], true);
        $get_location_primary_menu = false;

        if ( isset( $header_layout['desktop'] ) ) {
            $desktop_sections = $header_layout['desktop'];
            
            foreach ( $desktop_sections as $section => $positions ) {
                foreach ( $positions as $position => $items ) {
                    foreach ( $items as $item ) {
                        if ( isset($item['id'] ) && $item['id'] === 'primary-menu' ) {
                            $get_location_primary_menu = $section;
                            break;
                        }
                    }
                }
            }

            $row_background = "hfg_header_layout_{$get_location_primary_menu}_background";

            if ( isset( $theme_mods['hfg_header_layout_main_background'] ) ) {
                if ( isset( $theme_mods['hfg_header_layout_main_background']['colorValue'] ) ) {
                    if ( 'rgba(0,0,0,0)' === $theme_mods['hfg_header_layout_main_background']['colorValue'] ) {
                        set_theme_mod( 'primary-menu_submenu_background_color', 'var(--sol-color-bg-menu-dropdown)' );
                        // function solace_inlien_style_submenu_background() {
                        //     $style = "div.builder-item .builder-item--primary-menu ul.sub-menu {
                        //         background: var(--sol-color-bg-menu-dropdown);
                        //     }";
                        //     wp_add_inline_style('solace-theme', $style);
                        // }
                        // add_action('wp_enqueue_scripts', 'solace_inlien_style_submenu_background');
                    }
                }
            }
        }
    }
}

// remove_theme_mods();

// echo '<pre>';
// print_r($theme_mods);
// echo '</pre>';

