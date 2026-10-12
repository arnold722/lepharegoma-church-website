<?php

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * solace Theme Customizer
 *
 * @package solace
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function solace_customize_register($wp_customize)
{

	$wp_customize->remove_control( 'woocommerce_checkout_address_2_field' );
	$wp_customize->remove_section("colors");
	$wp_customize->remove_section("header_image");
	// $wp_customize->remove_section("sidebar-widgets-blog-sidebar");
	$wp_customize->remove_section("solace_style_section");
}
add_action('customize_register', 'solace_customize_register', 999);

function solace_customize_register_footer_widgets( $wp_customize ) {
    // Footer One Widgets
    $footer_one_widgets_section = $wp_customize->get_section('sidebar-widgets-footer-one-widgets');
    if ( null !== $footer_one_widgets_section ) {
        $footer_one_widgets_section->panel = 'widgets';
        $footer_one_widgets_section->title = __('Footer One', 'solace');
        $footer_one_widgets_section->priority = 10; // Set priority as needed
    }

    // Footer Two Widgets
    $footer_two_widgets_section = $wp_customize->get_section('sidebar-widgets-footer-two-widgets');
    if ( null !== $footer_two_widgets_section ) {
        $footer_two_widgets_section->panel = 'widgets';
        $footer_two_widgets_section->title = __('Footer Two', 'solace');
        $footer_two_widgets_section->priority = 20; // Set priority as needed
    }

    // Footer Three Widgets
    $footer_three_widgets_section = $wp_customize->get_section('sidebar-widgets-footer-three-widgets');
    if ( null !== $footer_three_widgets_section ) {
        $footer_three_widgets_section->panel = 'widgets';
        $footer_three_widgets_section->title = __('Footer Three', 'solace');
        $footer_three_widgets_section->priority = 30; // Set priority as needed
    }

    // Footer Four Widgets
    $footer_four_widgets_section = $wp_customize->get_section('sidebar-widgets-footer-four-widgets');
    if ( null !== $footer_four_widgets_section ) {
        $footer_four_widgets_section->panel = 'widgets';
        $footer_four_widgets_section->title = __('Footer Four', 'solace');
        $footer_four_widgets_section->priority = 40; // Set priority as needed
    }
}
add_action( 'customize_register', 'solace_customize_register_footer_widgets' );


function solace_customizer_change_to_refresh($wp_customize) {

	// Header Component Contact 
    $header_contact_setting = $wp_customize->get_setting('header_contact_component_align');
    if ($header_contact_setting !== null) {
        $header_contact_setting->transport = 'refresh';
    }	

	// Footer Component Cart 
    $footer_cart_setting = $wp_customize->get_setting('footer_cart_icon_component_align');
    if ($footer_cart_setting !== null) {
        $footer_cart_setting->transport = 'refresh';
    }

	// Footer Component Button 
    $button_base3_setting = $wp_customize->get_setting('button_base3_component_align');
    if ($button_base3_setting !== null) {
        $button_base3_setting->transport = 'refresh';
    }

	// Footer Component Social 
    $footer_social_setting = $wp_customize->get_setting('footer_social_component_align');
    if ($footer_social_setting !== null) {
        $footer_social_setting->transport = 'refresh';
    }

	// Footer Component Contact 
    $footer_contact_setting = $wp_customize->get_setting('footer_contact_component_align');
    if ($footer_contact_setting !== null) {
        $footer_contact_setting->transport = 'refresh';
    }

	// Footer Component Search 
    $footer_search_setting = $wp_customize->get_setting('footer_search_component_align');
    if ($footer_search_setting !== null) {
        $footer_search_setting->transport = 'refresh';
    }

	// Footer Component Button 2 
    $button_base4_setting = $wp_customize->get_setting('button_base4_component_align');
    if ($button_base4_setting !== null) {
        $button_base4_setting->transport = 'refresh';
    }

	// Footer Component Account
    $footer_account_setting = $wp_customize->get_setting('footer_account_component_align');
    if ($footer_account_setting !== null) {
        $footer_account_setting->transport = 'refresh';
    }
}
add_action('customize_register', 'solace_customizer_change_to_refresh', 999);


function customizer_panel( $wp_customize ) {	
	
	$wp_customize->add_section( 'solace_general_options', array(
		'title' => __( 'General Options', 'solace' ),
		'priority' => 10,
	  	'active_callback' => '__return_true',
	) );
	
	$wp_customize->remove_section( 'typography_font_pair_section' );
	$wp_customize->remove_section( 'solace_typography_general' );
	$wp_customize->remove_section( 'solace_typography_blog' );
	
	$wp_customize->remove_control('background_image');
	$wp_customize->remove_control('background_preset');
	$wp_customize->remove_control('background_size');
	$wp_customize->remove_control('background_repeat');
	$wp_customize->remove_control('background_attachment');
	$wp_customize->remove_control('background_position');
	
}
add_action( 'customize_register', 'customizer_panel' );

function solace_pages_layout( $wp_customize ) {
	$wp_customize->remove_control( 'solace_page_header_layout_heading' );
	$wp_customize->remove_control( 'solace_page_header_layout' );
	$wp_customize->remove_control( 'solace_page_cover_height' );
	$wp_customize->remove_control( 'solace_page_cover_padding' );
	$wp_customize->remove_control( 'solace_page_hide_title' );
	$wp_customize->remove_control( 'solace_page_title_alignment' );
	$wp_customize->remove_control( 'solace_page_title_position' );
	$wp_customize->remove_control( 'solace_page_cover_background_color' );
}
add_action( 'customize_register', 'solace_pages_layout' );

function solace_post_layout( $wp_customize ) {
	$wp_customize->remove_control( 'solace_post_page_elements_heading' );
	
}
add_action( 'customize_register', 'solace_post_layout' );


function solace_page_settings( $wp_customize ) {
	$wp_customize->add_section( 'solace_page_settings', array(
		'title' => __( 'Page Settings', 'solace' ),
		'priority' => 14,
	  ) );
	
	// $wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'solace_form_fields_section' );
	$wp_customize->remove_section( 'solace_typography_blog' );
	$wp_customize->remove_section( 'solace_buttons_section' );
	$wp_customize->remove_section( 'solace_typography_general' );
	$wp_customize->remove_section( 'solace_typography_general' );
	// $wp_customize->remove_section( 'custom_css' );
}
add_action( 'customize_register', 'solace_page_settings' );

function solace_logo_site_identity( $wp_customize ) {
	// $wp_customize->remove_control( 'blogdescription' );
	// $wp_customize->remove_control( 'logo_display' );

	
}
add_action( 'customize_register', 'solace_logo_site_identity' );

function solace_section_core_options( $wp_customize ) {
	// $wp_customize->remove_control( 'blogdescription' );
	// $wp_customize->remove_control( 'logo_display' );
	$wp_customize->add_section( 'solace_core_options', array(
		'title' => __( 'Core Options', 'solace' ),
		'priority' => 900, 
	) );
	$wp_customize->add_section( 'solace_core_site_identity', array(
		'title' => __( 'Site Identity', 'solace' ),
		'priority' => 901, 
	) );
	$wp_customize->add_section( 'solace_core_widgets', array(
		'title' => __( 'Widgets', 'solace' ),
		'priority' => 902, 
	) );
	$wp_customize->add_section( 'solace_core_menus', array(
		'title' => __( 'Menus', 'solace' ),
		'priority' => 903, 
	) );
	$wp_customize->add_section( 'solace_core_homepage', array(
		'title' => __( 'Homepage Settings', 'solace' ),
		'priority' => 904, 
	) );
	$wp_customize->add_section( 'solace_core_custom_css', array(
		'title' => __( 'Additional CSS', 'solace' ),
		'priority' => 905, 
	) );
	

	
}
add_action( 'customize_register', 'solace_section_core_options' );

function solace_customizer_settings_default($wp_customize) {

    $wp_customize->add_setting('blogname', array(
        'default' => get_option('blogname'),
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage', // Live preview
    ));

    $wp_customize->add_control('solace_site_title', array(
        'label' => __('Site Title', 'solace'),
        'section' => 'solace_core_site_identity',
        'settings' => 'blogname',
        'type' => 'text',
        'transport' => 'postMessage', // Live preview
    ));

    $wp_customize->add_setting('blogdescription', array(
        'default' => get_option('blogdescription'),
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage', // Live preview
    ));

    $wp_customize->add_control('solace_site_tagline', array(
        'label' => __('Tagline', 'solace'),
        'section' => 'solace_core_site_identity',
        'settings' => 'blogdescription',
        'type' => 'text',
        'transport' => 'postMessage', // Live preview
    ));

    // Optional: Adding site icon control
    $wp_customize->add_setting('site_icon', array(
        'default' => get_option('site_icon'),
        'capability' => 'manage_options',
		'sanitize_callback' => 'absint', // Sanitize as integer (ID)
		'transport' => 'postMessage', // Live preview

    ));

    $wp_customize->add_control(new WP_Customize_Cropped_Image_Control($wp_customize, 'solace_site_icon', array(
        'label' => __('Site Icon', 'solace'),
        'section' => 'solace_core_site_identity',
        'settings' => 'site_icon',
        'flex_width' => true,
        'flex_height' => true,
        'width' => 512,
        'height' => 512,
    )));

}

add_action('customize_register', 'solace_customizer_settings_default');


add_action('customize_register', 'solace_customizer_settings_default');

function solace_sync_blogname_and_description_save($wp_customize_manager) {
	$customizer_blogname = get_theme_mod('blogname', get_option('blogname'));
	$customizer_blogdescription = get_theme_mod('blogdescription', get_option('blogdescription'));

	$site_icon_id = get_theme_mod('site_icon');

	update_option('blogname', $customizer_blogname);
	update_option('blogdescription', $customizer_blogdescription);

	// Update site icon
	if ($site_icon_id) {
		$site_icon_url = wp_get_attachment_url($site_icon_id);
		if ($site_icon_url) {
			update_option('site_icon', $site_icon_id);
		}
	} else {
		delete_option('site_icon');
	}
}

add_action('customize_save_after', 'solace_sync_blogname_and_description_save');
function save_site_icon_id( $wp_customize ) {
    $site_icon_id = get_theme_mod('site_icon');
    if ( ! is_numeric($site_icon_id) ) {
        $attachment_id = attachment_url_to_postid($site_icon_id);
        if ($attachment_id) {
            set_theme_mod('site_icon', $attachment_id);
        }
    }
}
add_action('customize_save_after', 'save_site_icon_id');

function solace_move_core_controls( $wp_customize ) {
    foreach ( $wp_customize->settings() as $setting ) {
        $control = $wp_customize->get_control( $setting->id );

        // if ( $control && $control->section === 'title_tagline' ) {
        //     $control->section = 'solace_core_site_identity';
        // }
		if ( $control && $control->section === 'static_front_page' ) {
            $control->section = 'solace_core_homepage';
        }
        
    }
    $store_notice_control = $wp_customize->get_control('woocommerce_demo_store');
    if ( $store_notice_control ) {
        $store_notice_control->priority = 109;
    }
    $nav_menus = $wp_customize->get_panel( 'nav_menus' );

    if ( $nav_menus ) {
        $nav_menus->priority = 903; 
    }
    $widgets = $wp_customize->get_panel( 'widgets' );

    if ( $widgets ) {
        $widgets->priority = 902; 
    }

	$custom_css = $wp_customize->get_section( 'custom_css' );

    if ( $custom_css ) {
        $custom_css->priority = 905; 
    }


	
}
add_action( 'customize_register', 'solace_move_core_controls', 20 );

function solace_duplicate_title_tagline_controls( $wp_customize ) {
    // Check if the target section exists
    if ( $wp_customize->get_section( 'solace_core_site_identity' ) ) {
        // Check if the 'title_tagline' section exists
        if ( $wp_customize->get_section( 'title_tagline' ) ) {
            // Loop through all controls
            foreach ( $wp_customize->controls() as $control_id => $control ) {
                // Check if control belongs to 'title_tagline' section
                if ( $control->section === 'title_tagline' ) {
                    // Clone the control object
                    $new_control = clone $control;
                    $new_control->section = 'solace_core_site_identity'; // Set new section

                    // Generate a unique ID for the cloned control
                    $new_id = $control_id . '_default';

                    // Ensure no conflict with existing controls
                    if ( $wp_customize->get_control( $new_id ) ) {
                        $wp_customize->remove_control( $new_id );
                    }

                    // Update ID for cloned control
                    $new_control->id = $new_id;

                    // Add the cloned control to the customizer
                    $wp_customize->add_control( $new_control );

				}
			}
		}
	}
}

// add_action( 'customize_register', 'solace_duplicate_title_tagline_controls', 20 );



function solace_wc_custom( $wp_customize ) {
	$wp_customize->add_panel( 'solace_wc_custom', array(
		'title' => __( 'WooCommerce', 'solace' ),
		'priority' => 104, 
	  ) );
	$wp_customize->add_panel('solace_wc_custom_general', array(
		'title' => __('General', 'solace'),
		'priority' => 105,
	));

}
if ( class_exists( 'WooCommerce' ) ) {
	add_action( 'customize_register', 'solace_wc_custom' );
}

// ADD CUSTOM CLASS FOR SOLACE PANEL AND SECTION
function solace_customize_render_panels() {
    $panel_ids = array(
        'solace_wc_custom_general',
        'widgets',
        'nav_menus'
    );

    echo '<script>
            jQuery(document).ready(function($) {';

    foreach ( $panel_ids as $panel_id ) {
        echo '$("#accordion-panel-' . esc_js( $panel_id ) . '").addClass("solace-child");';
    }

    echo '});
          </script>';
}
add_action( 'customize_controls_print_footer_scripts', 'solace_customize_render_panels', 20 );

function solace_customize_render_section() {
    $section_ids = array(
        'solace_colors_background_section',
        'solace_typography_headings',
		'solace_wc_custom_general_buttons',
        'solace_blog_archive_layout',
        'solace_single_post_layout',
        'solace_features_scroll_to_top',
        'solace_wc_product_page',
        'solace_wc_single_product',
        'solace_wc_custom_general_cart_pages',
        'solace_wc_custom_general_checkout',
        'solace_container',
        'solace_core_homepage',
        'custom_css',
        'solace_core_site_identity',
        'solace_single_page_layout'
    );

    echo '<script>
            jQuery(document).ready(function($) {';

    foreach ( $section_ids as $section_id ) {
        echo '$("#accordion-section-' . esc_js( $section_id ) . '").addClass("solace-child");';
    }

    echo '});
          </script>';
}
add_action( 'customize_controls_print_footer_scripts', 'solace_customize_render_section', 20 );

function remove_customizer_panel( $components ) {
    unset( $components['nav_menus'] ); 
	unset( $components['widgets'] ); 
    return $components;
}
// add_filter( 'customize_loaded_components', 'remove_customizer_panel' );

function solace_woocommerce_control( $wp_customize ) {
	$wp_customize->remove_section( 'solace_single_product_layout' );
	$wp_customize->remove_control( 'solace_checkout_settings_heading' );
	$wp_customize->remove_control( 'solace_woo_checkout_settings_heading' );
}
add_action( 'customize_register', 'solace_woocommerce_control', 9999 );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function solace_customize_partial_blogname()
{
	bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function solace_customize_partial_blogdescription()
{
	bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function solace_customize_preview_js()
{ 
	wp_enqueue_script('solace-customizer', get_template_directory_uri() . '/js/customizer.js?v=' . time(), array('jquery','customize-preview'), SOLACE_VERSION, true);

	wp_enqueue_style('solace-style-customizer', get_template_directory_uri() . '/assets-solace/customizer/css/customizer.css?v=' . time(), array(), SOLACE_VERSION, 'all');

}
add_action('customize_preview_init', 'solace_customize_preview_js');

function my_scripts_method() {
	wp_enqueue_script(
		  'custom-script',
		  get_stylesheet_directory_uri() . '/js/topbutton.js?v=' . time(),
		  array( 'jquery' )
	);

	wp_enqueue_script(
		  'solace-js-script',
		  get_stylesheet_directory_uri() . '/js/scripts.js?v=' . time(),
		  array( 'jquery' )
	);

	wp_enqueue_script(
		'solace-global-elementor-script',
		get_stylesheet_directory_uri() . '/js/elementor.js?v=' . time(),
		array( 'jquery' )
  	);

}

add_action( 'wp_enqueue_scripts', 'my_scripts_method' );

function solace_scroll_to_top_customize_css()
{

    ?>
         <style type="text/css">
            /* .topbutton::before { content: url('<?php //echo get_template_directory_uri() . '/assets/img/customizer/'.get_theme_mod('solace_scroll_to_top','up_arrow1').'.svg'; ?>'); } */
			.topbutton svg {
				width: <?php echo absint(get_theme_mod('solace_scroll_to_top_icon_size','19'));?>px;
				height: auto;
			}
			.container-all {
				max-width: <?php echo esc_html(get_theme_mod('solace_container_layout'));?> !important;
			}
		 </style>
    <?php
}
add_action( 'wp_head', 'solace_scroll_to_top_customize_css');

/**
 * Load dynamic logic for the customizer controls area.
 */
function solace_customizer_controls() {
	wp_enqueue_script( 'solace-customize-controls', get_template_directory_uri() . '/assets-solace/customizer/js/customizer-controls.js?v=' . time(), array('jquery'), SOLACE_VERSION, true );
	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_script( 'solace-customize-woocommerce-controls', get_template_directory_uri() . '/assets-solace/customizer/js/customizer-woocommerce-controls.js?v=' . time(), array('jquery'), SOLACE_VERSION, true );
	}
}
add_action( 'customize_controls_enqueue_scripts', 'solace_customizer_controls' ,9999);

/**
 * Load dynamic logic for the customizer preview area.
 */
function solace_customize_previews_js() {
	wp_enqueue_script( 'solace-customize-preview', get_template_directory_uri() . '/assets-solace/customizer/js/customizer-preview.js?v=' . time(), array( 'customize-preview' ), SOLACE_VERSION, true );
	wp_enqueue_script(
        'solace-customizer-fonts',
        get_template_directory_uri() . '/assets-solace/customizer/js/customizer-fonts.js?v=' . time(),
        array( 'jquery', 'customize-preview' ),
        false,
        true
    );
}
add_action( 'customize_preview_init', 'solace_customize_previews_js' );

// Style component Header HTML
function solace_style_component_html_header()
{

    $top_row_color = get_theme_mod('hfg_header_layout_top_new_text_color', 'var(--sol-color-page-title-text)');
    $main_row_color = get_theme_mod('hfg_header_layout_main_new_text_color', 'var(--sol-color-page-title-text)');
    $bottom_row_color = get_theme_mod('hfg_header_layout_bottom_new_text_color', 'var(--sol-color-page-title-text)');
    $custom_html_color = get_theme_mod('custom_html_color');

	// Top
	if (empty($top_row_color) && empty($custom_html_color)) {
		$base_font = "header .header-top { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}

	// Main
	if (empty($main_row_color) && empty($custom_html_color)) {
		$base_font = "header .header-main { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}

	// Bottom
	if (empty($bottom_row_color) && empty($custom_html_color)) {
		$base_font = "header .header-bottom { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}
}
add_action('wp_enqueue_scripts', 'solace_style_component_html_header');

// Style component Footer HTML
function solace_style_component_html_footer()
{

    $top_row_color = get_theme_mod('hfg_footer_layout_top_new_text_color', 'var(--sol-color-page-title-text)');
    $main_row_color = get_theme_mod('hfg_footer_layout_main_new_text_color', 'var(--sol-color-page-title-text)');
    $bottom_row_color = get_theme_mod('hfg_footer_layout_bottom_new_text_color', 'var(--sol-color-page-title-text)');
    $custom_html_color = get_theme_mod('footer_html_color');

	// Top
	if (empty($top_row_color) && empty($custom_html_color)) {
		$base_font = "footer .footer-top { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}

	// Main
	if (empty($main_row_color) && empty($custom_html_color)) {
		$base_font = "footer .footer-main { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}

	// Bottom
	if (empty($bottom_row_color) && empty($custom_html_color)) {
		$base_font = "footer .footer-bottom { --color: var(--sol-color-base-font);}";
		wp_add_inline_style('solace-theme', $base_font);
	}
}
add_action('wp_enqueue_scripts', 'solace_style_component_html_footer');

// Style Row Header
function solace_style_row_header_builder()
{
    $header_layouts = array(
        'top' => wp_filter_nohtml_kses(get_theme_mod('hfg_header_layout_top_layout', 'layout-custom')),
        'main' => wp_filter_nohtml_kses(get_theme_mod('hfg_header_layout_main_layout', 'layout-custom')),
        'bottom' => wp_filter_nohtml_kses(get_theme_mod('hfg_header_layout_bottom_layout', 'layout-custom')),
    );

    $boxed = '708px';
    $container = '1280px';
    $fullwidth = '100%';

    foreach ($header_layouts as $area => $layout) {
        $style = "";

        if ($layout === 'layout-boxed') {
            $style .= "header .header--row.header-$area .container {max-width: $boxed;}";
        } elseif ($layout === 'layout-custom') {
			$custom = get_theme_mod('hfg_header_layout_' . $area . '_width', '{"desktop": "1280", "tablet": "768", "mobile": "580"}');
			$custom = json_decode($custom);

			$desktop = $custom->desktop . 'px';
			$tablet = $custom->tablet . 'px';
			$mobile = $custom->mobile . 'px';

            $style .= "header .header--row.header-$area .container {max-width: $desktop;}";

			// Tablet
			$style .= "@media (max-width: 768px) {";
			$style .= "header .header--row.header-$area .container {max-width: $tablet;}";
			$style .= "}";

			// Mobile
			$style .= "@media (max-width: 580px) {";
			$style .= "header .header--row.header-$area .container {max-width: $mobile;}";
			$style .= "}";

        } elseif ($layout === 'layout-fullwidth') {
            $style .= "header .header--row.header-$area .container {max-width: $fullwidth;}";
        } else {
            $style .= "header .header--row.header-$area .container {max-width: $container;}";
        }

        wp_add_inline_style('solace-theme', $style);
    }
}
add_action('wp_enqueue_scripts', 'solace_style_row_header_builder');

// Style Row Footer
function solace_style_row_footer_builder()
{
    $footer_layouts = array(
        'top' => wp_filter_nohtml_kses(get_theme_mod('hfg_footer_layout_top_layout', 'layout-custom')),
        'main' => wp_filter_nohtml_kses(get_theme_mod('hfg_footer_layout_main_layout', 'layout-custom')),
        'bottom' => wp_filter_nohtml_kses(get_theme_mod('hfg_footer_layout_bottom_layout', 'layout-custom')),
    );

    $boxed = '708px';
    $container = '1280px';
    $fullwidth = '100%';

    foreach ($footer_layouts as $area => $layout) {
        $style = "";

        if ($layout === 'layout-boxed') {
            $style .= "footer .footer--row.footer-$area .container {max-width: $boxed;}";
        } elseif ($layout === 'layout-custom') {
			$custom = get_theme_mod('hfg_footer_layout_' . $area . '_width', '{"desktop": "1280", "tablet": "768", "mobile": "580"}');
			$custom = json_decode($custom);

			$desktop = $custom->desktop . 'px';
			$tablet = $custom->tablet . 'px';
			$mobile = $custom->mobile . 'px';

            $style .= "footer .footer--row.footer-$area .container {max-width: $desktop;}";

			// Tablet
			$style .= "@media (max-width: 768px) {";
			$style .= "footer .footer--row.footer-$area .container {max-width: $tablet;}";
			$style .= "}";

			// Mobile
			$style .= "@media (max-width: 580px) {";
			$style .= "footer .footer--row.footer-$area .container {max-width: $mobile;}";
			$style .= "}";

        } elseif ($layout === 'layout-fullwidth') {
            $style .= "footer .footer--row.footer-$area .container {max-width: $fullwidth;}";
        } else {
            $style .= "footer .footer--row.footer-$area .container {max-width: $container;}";
        }

        wp_add_inline_style('solace-theme', $style);
    }
}
add_action('wp_enqueue_scripts', 'solace_style_row_footer_builder');

// Style component contact header
function solace_style_component_contact_header()
{
    $font_color = get_theme_mod('header_contact_font_color_setting', 'var(--sol-color-link-button-initial)');
    $icon_color = get_theme_mod('header_contact_icon_color_setting', '#fff');
    $icon_background = get_theme_mod('header_contact_icon_background_setting', '#0f2e5f');
    $icon_size = absint(get_theme_mod('header_contact_icon_size', 19)) . 'px';

	$header_contact = ".component-wrap.component-wrap-header-contact .box-contact .box-content .title span {color: $font_color;}";
	$header_contact .= ".component-wrap.component-wrap-header-contact .box-contact .box-content .content span {color: $font_color;}";
    $header_contact .= ".component-wrap.component-wrap-header-contact .box-contact .box-icon svg {fill: $icon_color;}";
    $header_contact .= ".component-wrap.component-wrap-header-contact .box-contact .box-icon svg {width: $icon_size;}";
    $header_contact .= ".component-wrap.component-wrap-header-contact .box-contact .box-icon svg {height: $icon_size;}";
    $header_contact .= ".component-wrap.component-wrap-header-contact .box-contact .box-icon {background: $icon_background;}";

    wp_add_inline_style('solace-theme', $header_contact);
}
add_action('wp_enqueue_scripts', 'solace_style_component_contact_header');

// Style component contact footer
function solace_style_component_contact_footer()
{
    $font_color = get_theme_mod('footer_contact_font_color_setting', 'var(--sol-color-link-button-initial)');
    $icon_color = get_theme_mod('footer_contact_icon_color_setting', '#fff');
    $icon_background = get_theme_mod('footer_contact_icon_background_setting', '#0f2e5f');
    $icon_size = absint(get_theme_mod('footer_contact_icon_size', 19)) . 'px';

	$footer_contact = ".component-wrap.component-wrap-footer-contact .box-contact .box-content .title span {color: $font_color;}";
	$footer_contact .= ".component-wrap.component-wrap-footer-contact .box-contact .box-content .content span {color: $font_color;}";
    $footer_contact .= ".component-wrap.component-wrap-footer-contact .box-contact .box-icon svg {fill: $icon_color;}";
    $footer_contact .= ".component-wrap.component-wrap-footer-contact .box-contact .box-icon svg {width: $icon_size;}";
    $footer_contact .= ".component-wrap.component-wrap-footer-contact .box-contact .box-icon svg {height: $icon_size;}";
    $footer_contact .= ".component-wrap.component-wrap-footer-contact .box-contact .box-icon {background: $icon_background;}";

    wp_add_inline_style('solace-theme', $footer_contact);
}
add_action('wp_enqueue_scripts', 'solace_style_component_contact_footer');

// Style component social header
function solace_style_component_social_header()
{
    $facebook = get_theme_mod('header_social_icon_color_facebook_setting', '#3b5998');
    $youtube = get_theme_mod('header_social_icon_color_youtube_setting', '#ff0000');
    $twitter = get_theme_mod('header_social_icon_color_twitter_setting', '#000000');
    $tiktok = get_theme_mod('header_social_icon_color_tiktok_setting', '#010101');
    $telegram = get_theme_mod('header_social_icon_color_telegram_setting', '#0088cc');
    $pinterest = get_theme_mod('header_social_icon_color_pinterest_setting', '#bd081c');
    $linkedin = get_theme_mod('header_social_icon_color_linkedin_setting', '#0a66c2');
    $instagram = get_theme_mod('header_social_icon_color_instagram_setting', '#c13584');
    $threads = get_theme_mod('header_social_icon_color_threads_setting', '#000000');
    $whatsapp = get_theme_mod('header_social_icon_color_whatsapp_setting', '#25d366');
    $icon_size = absint(get_theme_mod('header_social_icon_size', 22)) . 'px';

    $header_sosial = ".component-wrap-header-social .box-social.facebook svg {fill: $facebook;}";
    $header_sosial .= ".component-wrap-header-social .box-social.youtube svg {fill: $youtube;}";
    $header_sosial .= ".component-wrap-header-social .box-social.twitter svg {fill: $twitter;}";
    $header_sosial .= ".component-wrap-header-social .box-social.tiktok svg {fill: $tiktok;}";
    $header_sosial .= ".component-wrap-header-social .box-social.telegram svg {fill: $telegram;}";
    $header_sosial .= ".component-wrap-header-social .box-social.pinterest svg {fill: $pinterest;}";
    $header_sosial .= ".component-wrap-header-social .box-social.linkedin svg {fill: $linkedin;}";
    $header_sosial .= ".component-wrap-header-social .box-social.instagram svg {fill: $instagram;}";
    $header_sosial .= ".component-wrap-header-social .box-social.threads svg {fill: $threads;}";
    $header_sosial .= ".component-wrap-header-social .box-social.whatsapp svg {fill: $whatsapp;}";
    $header_sosial .= ".component-wrap-header-social .box-social svg {width: $icon_size; height: $icon_size;}";

    wp_add_inline_style('solace-theme', $header_sosial);
}
add_action('wp_enqueue_scripts', 'solace_style_component_social_header');

// Style component social footer
function solace_style_component_social_footer()
{
    $facebook = get_theme_mod( 'footer_social_icon_color_facebook_setting', 'var(--sol-color-base-font)' );
    $youtube = get_theme_mod( 'footer_social_icon_color_youtube_setting', 'var(--sol-color-base-font)' );
    $twitter = get_theme_mod( 'footer_social_icon_color_twitter_setting', 'var(--sol-color-base-font)' );
    $tiktok = get_theme_mod( 'footer_social_icon_color_tiktok_setting', 'var(--sol-color-base-font)' );
    $telegram = get_theme_mod( 'footer_social_icon_color_telegram_setting', 'var(--sol-color-base-font)' );
    $pinterest = get_theme_mod( 'footer_social_icon_color_pinterest_setting', 'var(--sol-color-base-font)' );
    $linkedin = get_theme_mod( 'footer_social_icon_color_linkedin_setting', 'var(--sol-color-base-font)' );
    $instagram = get_theme_mod('footer_social_icon_color_instagram_setting', 'var(--sol-color-base-font)' );
    $threads = get_theme_mod('footer_social_icon_color_threads_setting', 'var(--sol-color-base-font)' );
    $whatsapp = get_theme_mod('footer_social_icon_color_whatsapp_setting', 'var(--sol-color-base-font)' );
    $icon_size = absint(get_theme_mod( 'footer_social_icon_size', 22)) . 'px';

    $footer_sosial = ".component-wrap-footer-social .box-social.facebook svg {fill: $facebook;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.youtube svg {fill: $youtube;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.twitter svg {fill: $twitter;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.tiktok svg {fill: $tiktok;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.telegram svg {fill: $telegram;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.pinterest svg {fill: $pinterest;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.linkedin svg {fill: $linkedin;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.instagram svg {fill: $instagram;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.threads svg {fill: $threads;}";
    $footer_sosial .= ".component-wrap-footer-social .box-social.whatsapp svg {fill: $whatsapp;}";	
    $footer_sosial .= ".component-wrap-footer-social .box-social svg {width: $icon_size; height: $icon_size;}";

    wp_add_inline_style('solace-theme', $footer_sosial);
}
add_action('wp_enqueue_scripts', 'solace_style_component_social_footer');

// Style component logo footer
function solace_style_component_logo_footer()
{

    $logo_size = json_decode(get_theme_mod('logo_footer_max_width', '{"mobile":120,"tablet":120,"desktop":120,"suffix":{"desktop":"px","tablet":"px","mobile":"px"}}'), true);
    $logo_size_mobile =  $logo_size['mobile'];
    $logo_size_tablet =  $logo_size['tablet'];
    $logo_size_desktop =  $logo_size['desktop'];
    $logo_size_suffix_mobile =  !empty($logo_size['suffix'])?$logo_size['suffix']['mobile']:'px';
    $logo_size_suffix_tablet =  !empty($logo_size['suffix'])?$logo_size['suffix']['tablet']:'px';
    $logo_size_suffix_desktop =  !empty($logo_size['suffix'])?$logo_size['suffix']['desktop']:'px';

	// Desktop
    // $footer_logo = ".site-logo-footer img {width: $logo_size_desktop$logo_size_suffix_desktop;}";
    $footer_logo = ".site-logo-footer img {max-width: var(--maxwidth);}";

	// // Tablet
	// $footer_logo .= "@media only screen and (max-width: 992px) {";

	// $footer_logo .= ".site-logo-footer img {width: $logo_size_tablet$logo_size_suffix_tablet;}";

	// $footer_logo .= "}";

	// // Mobile
	// $footer_logo .= "@media only screen and (max-width: 580px) {";

	// $footer_logo .= ".site-logo-footer img {width: $logo_size_mobile$logo_size_suffix_mobile;}";

	// $footer_logo .= "}";

    wp_add_inline_style('solace-theme', $footer_logo);
}
add_action('wp_enqueue_scripts', 'solace_style_component_logo_footer');

/**
 * Enqueues styles for the block-based editor.
 *
 * @since Twenty Seventeen 1.8
 */
function solace_block_editor_styles() {
	$body = esc_html(get_theme_mod('solace_body_font_family', 'DM Sans'));
	$h1 = esc_html(get_theme_mod('solace_h1_font_family_general', 'DM Sans'));
    $h2 = esc_html(get_theme_mod('solace_h2_font_family_general', 'DM Sans'));
    $h3 = esc_html(get_theme_mod('solace_h3_font_family_general', 'DM Sans'));
    $h4 = esc_html(get_theme_mod('solace_h4_font_family_general', 'DM Sans'));
    $h5 = esc_html(get_theme_mod('solace_h5_font_family_general', 'DM Sans'));
    $h6 = esc_html(get_theme_mod('solace_h6_font_family_general', 'DM Sans'));

	$fonts = array(
		'Arial, Helvetica, sans-serif',
		'Arial Black, Gadget, sans-serif',
		'Bookman Old Style, serif',
		'Comic Sans MS, cursive',
		'Courier, monospace',
		'Georgia, serif',
		'Garamond, serif',
		'Impact, Charcoal, sans-serif',
		'Lucida Console, Monaco, monospace',
		'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'MS Sans Serif, Geneva, sans-serif',
		'MS Serif, New York, sans-serif',
		'Palatino Linotype, Book Antiqua, Palatino, serif',
		'Tahoma, Geneva, sans-serif',
		'Times New Roman, Times, serif',
		'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif',
		'Paratina Linotype',
		'Trebuchet MS',
		// 'Manrope, sans-serif'
	);

	if ( !in_array($body, $fonts) ) {
		wp_enqueue_style('google-fonts-' . $body, 'https://fonts.googleapis.com/css2?family='.$body.'&display=swap&v=' . time());
	}

	for ($i = 1; $i <= 6; $i++) {
		$heading = 'h' . $i;
		$fontVariable = 'h' . $i;
		
		if (!in_array($$fontVariable, $fonts)) {
			wp_enqueue_style('google-fonts-' . $heading, 'https://fonts.googleapis.com/css?family=' . $$fontVariable . '&display=swap&v=' . time());
		}
	}
	
	// Block styles.
	wp_enqueue_style( 'solace-block-editor-style', get_template_directory_uri() . '/assets/css/editor-block.min.css&v=' . time(), array(), '1.0.0' );

}
add_action( 'enqueue_block_editor_assets', 'solace_block_editor_styles' );

// Style component social footer
function solace_style_general_font()
{
    $h1 = esc_html(get_theme_mod('solace_h1_font_family_general', 'DM Sans, sans-serif'));
    $h2 = esc_html(get_theme_mod('solace_h2_font_family_general', 'DM Sans, sans-serif'));
    $h3 = esc_html(get_theme_mod('solace_h3_font_family_general', 'DM Sans, sans-serif'));
    $h4 = esc_html(get_theme_mod('solace_h4_font_family_general', 'DM Sans, sans-serif'));
    $h5 = esc_html(get_theme_mod('solace_h5_font_family_general', 'DM Sans, sans-serif'));
    $h6 = esc_html(get_theme_mod('solace_h6_font_family_general', 'DM Sans, sans-serif'));

    $heading = "html body h1 {font-family: $h1;}";
    $heading .= "html body h2 {font-family: $h2;}";
    $heading .= "html body h3 {font-family: $h3;}";
    $heading .= "html body h4 {font-family: $h4;}";
    $heading .= "html body h5 {font-family: $h5;}";
    $heading .= "html body h6 {font-family: $h6;}";

    wp_add_inline_style('solace-theme', $heading);
}
add_action('wp_enqueue_scripts', 'solace_style_general_font');

function solace_style_general_font_for_editor_blocks()
{
    $h1 = esc_html(get_theme_mod('solace_h1_font_family_general', 'DM Sans, sans-serif'));
    $h2 = esc_html(get_theme_mod('solace_h2_font_family_general', 'DM Sans, sans-serif'));
    $h3 = esc_html(get_theme_mod('solace_h3_font_family_general', 'DM Sans, sans-serif'));
    $h4 = esc_html(get_theme_mod('solace_h4_font_family_general', 'DM Sans, sans-serif'));
    $h5 = esc_html(get_theme_mod('solace_h5_font_family_general', 'DM Sans, sans-serif'));
    $h6 = esc_html(get_theme_mod('solace_h6_font_family_general', 'DM Sans, sans-serif'));
	$body = esc_html(get_theme_mod('solace_body_font_family', 'DM Sans, sans-serif'));

    $heading = "div.editor-styles-wrapper h1, div.editor-styles-wrapper h1.wp-block {font-family: $h1;}";
    $heading .= "div.editor-styles-wrapper h2, div.editor-styles-wrapper h2.wp-block {font-family: $h2;}";
    $heading .= "div.editor-styles-wrapper h3, div.editor-styles-wrapper h3.wp-block {font-family: $h3;}";
    $heading .= "div.editor-styles-wrapper h4, div.editor-styles-wrapper h4.wp-block {font-family: $h4;}";
    $heading .= "div.editor-styles-wrapper h5, div.editor-styles-wrapper h5.wp-block {font-family: $h5;}";
    $heading .= "div.editor-styles-wrapper h6, div.editor-styles-wrapper h6.wp-block {font-family: $h6;}";
    $heading .= "div.editor-styles-wrapper, div.editor-styles-wrapper {font-family: $body;}";

    wp_add_inline_style('solace-block-editor-style', $heading);
}
add_action( 'enqueue_block_editor_assets', 'solace_style_general_font_for_editor_blocks' );

// Style header builder color dekstop
function solace_header_builder_color_dekstop()
{
	// Header Button
	// $header = ".header--row .builder-item--button_base a.button { color: inherit; }";

	// Header search input
	$header = ".header--row.hide-on-mobile.hide-on-tablet .builder-item--header_search input { color: inherit; border-style: solid;}";

	// Header widgets
	$header .= ".header--row.hide-on-mobile.hide-on-tablet .builder-item--header-widgets .widget-title { color: inherit; }";
	$header .= ".header--row.hide-on-mobile.hide-on-tablet .builder-item--header-widgets p { color: inherit; }";

    wp_add_inline_style('solace-theme', $header);
}
add_action('wp_enqueue_scripts', 'solace_header_builder_color_dekstop');

// Style header footer top color
function solace_footer_builder_color()
{
	// parent
	$footer = ".footer--row .builder-item { color: var(--sol-color-page-title-text); }";

	// Search form
	$footer .= ".footer--row .builder-item--footer_search input { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer_search .widget { color: inherit; }";

	// Widgets one
	$footer .= ".footer--row .builder-item--footer-one-widgets .widget { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-one-widgets .widget .widget-title { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-one-widgets .widget p { color: inherit; }";
	// $footer .= ".footer--row .builder-item--footer-one-widgets .widget a { color: var(--sol-color-link-button-initial); }";

	// Widgets two
	$footer .= ".footer--row .builder-item--footer-two-widgets .widget { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-two-widgets .widget .widget-title { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-two-widgets .widget p { color: inherit; }";
	// $footer .= ".footer--row .builder-item--footer-two-widgets .widget a { color: var(--sol-color-link-button-initial); }";

	// Widgets three
	$footer .= ".footer--row .builder-item--footer-three-widgets .widget { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-three-widgets .widget .widget-title { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-three-widgets .widget p { color: inherit; }";
	// $footer .= ".footer--row .builder-item--footer-three-widgets .widget a { color: var(--sol-color-link-button-initial); }";

	// Widgets four
	$footer .= ".footer--row .builder-item--footer-four-widgets .widget { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-four-widgets .widget .widget-title { color: inherit; }";
	$footer .= ".footer--row .builder-item--footer-four-widgets .widget p { color: inherit; }";
	// $footer .= ".footer--row .builder-item--footer-four-widgets .widget a { color: var(--sol-color-link-button-initial); }";

    wp_add_inline_style('solace-theme', $footer);
}
add_action('wp_enqueue_scripts', 'solace_footer_builder_color');

// Style component button1
function solace_style_component_header_button1()
{
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

    $button_style = esc_html(get_theme_mod('button_base_style_btn_id', 'button2'));
	
	if ($button_style === 'button2') {
		
		$button_border_width = get_theme_mod('button_base_button_border_width_style_setting', $default_border_width);
		$button_color = sanitize_hex_color(get_theme_mod('button_base_button_bg_color_style_setting', '#ED6700'));

		if (!empty($button_color)) {
			$style = "html .builder-item--button_base a.button { border-color: $button_color; }";
			wp_add_inline_style('solace-theme', $style);
		} else {
			// $font_color = sanitize_hex_color(get_theme_mod('button_base_font_color_style_setting'));
			// if (!empty($font_color)) {
			// 	$style = "html .builder-item--button_base a.button { border-color: $font_color; }";
			// 	wp_add_inline_style('solace-theme', $style);
			// } else {
			// 	$style = "html .builder-item--button_base a.button { border-color: #ffffff; }";
			// 	wp_add_inline_style('solace-theme', $style);
			// }
			$style = "html .builder-item--button_base a.button { border-color: #ffffff; }";
			wp_add_inline_style('solace-theme', $style);
		}

		$top = absint($button_border_width['desktop']['top']);
		$right = absint($button_border_width['desktop']['right']);
		$bottom = absint($button_border_width['desktop']['bottom']);
		$left = absint($button_border_width['desktop']['left']);

		$style = "html .builder-item--button_base a.button { background: transparent; }";
		$style .= "html .builder-item--button_base a.button { border-top-width: {$top}px; }";
		$style .= "html .builder-item--button_base a.button { border-right-width: {$right}px; }";
		$style .= "html .builder-item--button_base a.button { border-bottom-width: {$bottom}px; }";
		$style .= "html .builder-item--button_base a.button { border-left-width: {$left}px; }";

		wp_add_inline_style('solace-theme', $style);
	}

}
// add_action('wp_enqueue_scripts', 'solace_style_component_header_button1');

// Style component contact header
function solace_style_scroll_to_top()
{
    $toggle = absint( get_theme_mod( 'toggle_scroll_to_top', false ) );
    $color = sanitize_hex_color( get_theme_mod( 'solace_scroll_to_top_icon_color', '#fff' ) );

	if ( $toggle ) {
		$style = '.box-scroll-to-top { display: block; }';
	} else {
		$style = '.box-scroll-to-top { display: none; }';
	}

	$style .= ".box-scroll-to-top svg { fill: $color; }";

	wp_add_inline_style('solace-theme', $style);
}
add_action('wp_enqueue_scripts', 'solace_style_scroll_to_top');

// Check whether the 'core/button' block uses a custom color

function is_button_using_custom_color() {
    if (has_blocks()) {
        $blocks = parse_blocks(get_the_content());
        foreach ($blocks as $block) {
            if ($block['blockName'] === 'core/button') {
                if (isset($block['attrs']['backgroundColor']) && $block['attrs']['backgroundColor'] !== '') {
                    return true;
                }
            }
        }
    }
    return false;
}

function defer_dokan_style() {
    wp_dequeue_style('dokan-style');
    
    add_action('wp_footer', function() {
        echo '<link rel="stylesheet" href="' . plugins_url('dokan-lite/assets/css/style.css') . '" type="text/css" media="all" defer>';
    }, 20);
}

if (!function_exists('is_plugin_active')) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if (is_plugin_active('dokan-lite/dokan.php')) {
	add_action('wp_enqueue_scripts', 'defer_dokan_style', 20);
}

// Woocommerce Notice
function solace_wc_notice()
{
    $notice = get_option('woocommerce_demo_store');
	if ($notice === 'yes') {
		$style = "header.header {margin-top: 59px !important;}";
	}

    wp_add_inline_style('solace-theme', $style);
}
// add_action('wp_enqueue_scripts', 'solace_wc_notice');

// Fix style color position
function solace_add_style_inline641() {
    $versi_wordpress = get_bloginfo('version');
    if (version_compare($versi_wordpress, '6.4.1', '>=')) {
        // $style = '.components-popover:has(.solace-palettes-wrap) { transform: translateY(301px) translateX(15px) !important;}';
        // $style .= '.components-popover:has(.solace-fonts-list) { translate: -4px !important; }';
		// wp_add_inline_style( 'sol-customizer-ui-style', $style );

		$style_list_element = '.no-components {
			text-align: center;
			padding: 30px;
		}

		div.popup-list-elements span.name::before {
			position: relative;
			display: block;
			margin: 0 auto;
		}
		
		div.popover-header {
			display: flex;
			justify-content: center;
			border-bottom: 1px solid #e1e4e7;
			background: #fff;
			width: auto;
			padding: 0;
			top: -42px;
			position: absolute;
		
			input {
				appearance: none;
				width: 100%;
				height: 35px;
				border: 1px solid #8d96a0;
				outline: none;
				box-shadow: none;
				font-size: 13px;
				margin: 16px;
				padding: 11px 16px 11px 30px;
				border-radius: 4px;
			}
		
			>svg {
				position: absolute;
				fill: #8d96a0;
				left: 30px;
				top: 50%;
				transform: translateY(-50%);
			}
		}
		
		div.popover-header.list-components {
			display: flex;
			padding: 5px 10px;
			position: relative;
			border-bottom: 1px solid #e1e4e7;
			background: #fff;
			width: 410px;
			top: 0;			
		}

		div.popover-header.list-components > svg {
			position: absolute;
			fill: #8d96a0;
			left: 30px;
			top: 50%;
			transform: translateY(-50%);
		}

		div.popover-header.list-components input {
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			width: 100%;
			height: 35px;
			border: 1px solid #8d96a0;
			outline: none;
			box-shadow: none;
			font-size: 13px;
			margin: 16px;
			padding: 11px 16px 11px 30px;
			border-radius: 4px;
		}

		div.popover-header.list-components button {
			justify-content: center;
			min-width: 36px;
			padding: 6px;
			background: none;
			border: 0;
			border-radius: 0;
			box-shadow: none;
			color: var(--wp-components-color-accent,var(--wp-admin-theme-color,#3858e9));
			height: auto;
			margin: 0;
			outline: none;
			text-align: left;
			text-decoration: underline;
			transition-duration: .05s;
			transition-property: border,background,color;
			transition-timing-function: ease-in-out;
			align-items: center;
			-webkit-appearance: none;
			cursor: pointer;
			display: inline-flex;
			font-family: inherit;
			font-size: 13px;
			font-weight: 400;
			transition: box-shadow .1s linear;
		}

		.items-popover-content {
			width: 400px;
			padding: 10px 15px;
			overflow-y: auto;
			max-height: 375px;
			background-color: #fff;
			display: flex;
			flex-direction: column;
		}
		
		.items-popover-list {
			display: grid;
			grid-template-columns: repeat(3, 1fr);
			grid-row-gap: 10px;
			grid-column-gap: 15px;
		}
		
		button.popover-item {
			width: 100%;
			height: auto;
			height: 60px;
			cursor: pointer;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center !important;
			box-sizing: border-box;
			padding: 7px 3px;
			color: #545d66;
			line-height: 1.4em;
			font-size: 13px;
			border: 1px solid #efefef;
			box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
		}

		button.popover-item.active {
			opacity: .5;
		}

		button.popover-item.active:focus:not(:disabled) {
			box-shadow: none;
			outline: none;
		}

		button.popover-item:hover span.name {
			color: #545d66;
		}
		
		.ext.popover-item {
			position: relative;
			opacity: .45;
			cursor: not-allowed;
		}
		
		.nv-lock {
			color: $wp-blue;
			top: 5px;
			right: 5px;
			position: absolute;
			width: unset;
			height: unset;
			font-size: 12px;
		
			.dashicons {
				margin: 0 !important;
				width: 14px;
				height: 14px;
				font-size: 13px;
			}
		}';

		wp_add_inline_style( 'sol-customizer-ui-style', $style_list_element );
    }
}
add_action( 'admin_enqueue_scripts', 'solace_add_style_inline641', 99999 );

/**
 * Enqueues font menu.
 */
function solace_element_menu_font() {

	$default_menu_font_family = null;
	$get_base_font_theme_mod = get_theme_mod( 
		'solace_body_font_family',
		Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL )
	);
	
	if ( $get_base_font_theme_mod === Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL ) ) {
		$default_menu_font_family = $get_base_font_theme_mod;
	} else {
		$default_menu_font_family = get_theme_mod( 'primary-menu_font_family', $get_base_font_theme_mod );
	}

	$header_menu_one = esc_html( get_theme_mod( 'primary-menu_font_family', $default_menu_font_family ) );
	$header_menu_two = esc_html( get_theme_mod( 'secondary-menu_font_family', $default_menu_font_family ) );	
	$footer_menu_one = esc_html( get_theme_mod( 'footer-menu_font_family', $default_menu_font_family ) );	

	$fonts = array(
		'Arial, Helvetica, sans-serif',
		'Arial Black, Gadget, sans-serif',
		'Bookman Old Style, serif',
		'Comic Sans MS, cursive',
		'Courier, monospace',
		'Georgia, serif',
		'Garamond, serif',
		'Impact, Charcoal, sans-serif',
		'Lucida Console, Monaco, monospace',
		'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'MS Sans Serif, Geneva, sans-serif',
		'MS Serif, New York, sans-serif',
		'Palatino Linotype, Book Antiqua, Palatino, serif',
		'Tahoma, Geneva, sans-serif',
		'Times New Roman, Times, serif',
		'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif',
		'Paratina Linotype',
		'Trebuchet MS',
		// 'Manrope, sans-serif'
	);

	$header_menu_one = esc_html( get_theme_mod( 'primary-menu_font_family', $default_menu_font_family ) );
	$header_menu_two = esc_html( get_theme_mod( 'secondary-menu_font_family', $default_menu_font_family ) );	
	$footer_menu_one = esc_html( get_theme_mod( 'footer-menu_font_family', $default_menu_font_family ) );	

	if ( ! in_array( $header_menu_one, $fonts ) ) {
		wp_enqueue_style('google-fonts-' . $header_menu_one, 'https://fonts.googleapis.com/css2?family='.$header_menu_one.'&display=swap&v=' . time());
	}

	if ( ! in_array( $header_menu_two, $fonts ) ) {
		wp_enqueue_style('google-fonts-' . $header_menu_two, 'https://fonts.googleapis.com/css2?family='.$header_menu_two.'&display=swap&v=' . time());
	}

	if ( ! in_array( $footer_menu_one, $fonts ) ) {
		wp_enqueue_style('google-fonts-' . $footer_menu_one, 'https://fonts.googleapis.com/css2?family='.$footer_menu_one.'&display=swap&v=' . time());
	}
}
add_action( 'wp_enqueue_scripts', 'solace_element_menu_font' );

/**
 * Filter the excerpt length using the Customizer setting.
 *
 * @param int $length Default excerpt length.
 * @return int Modified excerpt length based on Customizer setting.
 */
function solace_filter_excerpt_length( $length ) {
	// Get the Customizer setting
	$custom_length = get_theme_mod( 'solace_archive_maximum_excerpt_length', 55 );

	// If it's a number and >= 0, return it as integer
	if ( is_numeric( $custom_length ) && $custom_length >= 0 ) {
		return (int) $custom_length;
	}

	// Fallback to default 55 if not valid
	return 55;
}
add_filter( 'excerpt_length', 'solace_filter_excerpt_length' );

function solace_editor_iframe_css() {
    $css = '
    .editor-styles-wrapper,
    .editor-styles-wrapper * {
        background: transparent !important;
    }';

    wp_add_inline_style( 'wp-block-library', $css );
}
add_action( 'enqueue_block_editor_assets', 'solace_editor_iframe_css' );