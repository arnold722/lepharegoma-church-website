<?php 

// use Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Repeater;
use Elementor\Plugin;
use Solace\Core\Settings\Mods;

function solace_init_elementor_add_theme_colors() {
	$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$primary = $current['system_colors'][0]['color'];
	$secondary = $current['system_colors'][1]['color'];
	$text = $current['system_colors'][2]['color'];
	$accent = $current['system_colors'][3]['color'];

	$base_color = $text;
	$heading_color = $current['solace_colors'][1]['color'];
	$link_button_color = $current['solace_colors'][2]['color'];
	$link_button_hover_color = $current['solace_colors'][3]['color'];
	// $button_color = $current['solace_colors'][4]['color'];
	$button_color = $primary;
	$button_hover_color = $current['solace_colors'][5]['color'];
	$text_selection_color = $current['solace_colors'][6]['color'];
	$text_selection_bg_color = $current['solace_colors'][7]['color'];
	$border_color = $current['solace_colors'][8]['color'];
	$background_color = $current['solace_colors'][9]['color'];
	$page_title_text_color = $current['solace_colors'][10]['color'];
	// $page_title_bg_color = $current['solace_colors'][11]['color'];
	$page_title_bg_color = $secondary;
	$bg_menu_dropdown = $accent;


	$system_colors = array(
		array(
			'_id' => 'primary',
			'title'  => __( 'Button', 'solace' ),
			'color' => isset($button_color)?strtoupper($button_color):'#1D70DB',
		),
		array(
			'_id' => 'secondary',
			'title'  => __( 'Page Title Background', 'solace' ),
			'color' => isset($page_title_bg_color)?strtoupper($page_title_bg_color):'#000F44',
		),
		array(
			'_id' => 'text',
			'title'  => __( 'Base Font', 'solace' ),
			'color' => isset($base_color)?strtoupper($base_color):'#000000',
		),
		array(
			'_id' => 'accent',
			'title'  => __( 'Submenu Background', 'solace' ),
			'color' => isset($bg_menu_dropdown)?strtoupper($bg_menu_dropdown):'#DEDEDE',
		),
	);
	if (class_exists('Elementor\Plugin')) {
		\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_colors', $system_colors );
	}

	$theme_colors = array(
		array(
			'_id' => 'sol-color-base-font',
			'title'  => __( 'Base Font', 'solace' ),
			'color' => isset($base_color)?strtoupper($base_color):'#000000',
		),
		array(
			'_id' => 'sol-color-heading',
			'title'  => __( 'Heading', 'solace' ),
			'color' => isset($heading_color)?strtoupper($heading_color):'#1D70DB',
		),
		array(
			'_id' => 'sol-color-link-button-initial',
			'title'  => __( 'Link', 'solace' ),
			'color' => isset($link_button_color)?strtoupper($link_button_color):'#1D70DB',
		),
		array(
			'_id' => 'sol-color-link-button-hover',
			'title'  => __( 'Link Hover', 'solace' ),
			'color' => isset($link_button_hover_color)?strtoupper($link_button_hover_color):'#1D70DB',
		),
		array(
			'_id' => 'sol-color-button-initial',
			'title'  => __( 'Button', 'solace' ),
			'color' => isset($button_color)?strtoupper($button_color):'#1D70DB',
		),
		array(
			'_id' => 'sol-color-button-hover',
			'title'  => __( 'Button Hover', 'solace' ),
			'color' => isset($button_hover_color)?strtoupper($button_hover_color):'#1D70DB',
		),
		array(
			'_id' => 'sol-color-selection',
			'title'  => __( 'Text Selection', 'solace' ),
			'color' => isset($text_selection_color)?strtoupper($text_selection_color):'#FF9500',
		),
		array(
			'_id' => 'sol-color-selection-high',
			'title'  => __( 'Text Selection Background', 'solace' ),
			'color' => isset($text_selection_bg_color)?strtoupper($text_selection_bg_color):'#FF9500',
		),
		array(
			'_id' => 'sol-color-border',
			'title'  => __( 'Border', 'solace' ),
			'color' => isset($border_color)?strtoupper($border_color):'#DEDEDE',
		),
		array(
			'_id' => 'sol-color-background',
			'title'  => __( 'Background', 'solace' ),
			'color' => isset($background_color)?strtoupper($background_color):'#EBEBEB',
		),
		array(
			'_id' => 'sol-color-page-title-text',
			'title'  => __( 'Page Title', 'solace' ),
			'color' => isset($page_title_text_color)?strtoupper($page_title_text_color):'#FFFFFF',
		),
		array(
			'_id' => 'sol-color-page-title-background',
			'title'  => __( 'Page Title Background', 'solace' ),
			'color' => isset($page_title_bg_color)?strtoupper($page_title_bg_color):'#000F44',
		),
		array(
			'_id' => 'sol-color-bg-menu-dropdown',
			'title'  => __( 'Submenu Background', 'solace' ),
			'color' => isset($bg_menu_dropdown)?strtoupper($bg_menu_dropdown):'#DEDEDE',
		),
	);
	if (class_exists('Elementor\Plugin')) {
		\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'solace_colors', $theme_colors );
	}
	set_theme_mod('solace_colors',$theme_colors);
}

function solace_color_elementor_after_save( $elementor_element, $data ) {
	if ( isset( $data['settings']['post_status'] ) && ( $data['settings']['post_status'] === 'publish' || $data['settings']['post_status'] === 'save' ) ) {
		// Retrieve the $get_current_settings data from Elementor
		$get_current_settings = \Elementor\Plugin::$instance->kits_manager->get_current_settings();

		// $base_font = $get_current_settings['solace_colors'][0]['color'];
		$base_font = $data['settings']['system_colors'][2]['color'];
		$heading = $get_current_settings['solace_colors'][1]['color'];
		$link_initial = $get_current_settings['solace_colors'][2]['color'];
		$link_hover = $get_current_settings['solace_colors'][3]['color'];
		// $button_initial = $get_current_settings['solace_colors'][4]['color'];
		$button_initial = $data['settings']['system_colors'][0]['color'];
		$button_hover = $get_current_settings['solace_colors'][5]['color'];
		$selection = $get_current_settings['solace_colors'][6]['color'];
		$selection_high = $get_current_settings['solace_colors'][7]['color'];
		$border = $get_current_settings['solace_colors'][8]['color'];
		$background = $get_current_settings['solace_colors'][9]['color'];
		$title_text = $get_current_settings['solace_colors'][10]['color'];
		// $title_background = $get_current_settings['solace_colors'][11]['color'];
		$title_background = $data['settings']['system_colors'][1]['color'];
		// $bg_menu_dropdown = $get_current_settings['solace_colors'][12]['color'];
		$bg_menu_dropdown = $data['settings']['system_colors'][3]['color'];

		$solace_global_colors = get_theme_mod( 'solace_global_colors', solace_get_global_colors_default( true ) );

		$list_palettes = $solace_global_colors['palettes'];
		$active_palette = $solace_global_colors['activePalette'];
		$palettes = $list_palettes[$active_palette]['colors'];

		if ( ! empty( $get_current_settings ) && ! empty( $solace_global_colors ) ) {

			// Base font color.
			if ( ! empty( $base_font ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-base-font'] = strtoupper( sanitize_hex_color( $base_font ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );
			}

			// Heading color.
			if ( ! empty( $heading ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-heading'] = strtoupper( sanitize_hex_color( $heading ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );				
			}

			// Link initial color.
			if ( ! empty( $link_initial ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-link-button-initial'] = strtoupper( sanitize_hex_color( $link_initial ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );	
			}		
	
			// Link hover color.
			if ( ! empty( $link_hover ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-link-button-hover'] = strtoupper( sanitize_hex_color( $link_hover ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );				
			}

			// Button color.
			if ( ! empty( $button_initial ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-initial'] = strtoupper( sanitize_hex_color( $button_initial ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );				
			}

			// Button hover color.
			if ( ! empty( $button_hover ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-hover'] = strtoupper( sanitize_hex_color( $button_hover ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );	
			}

			// Selection inital color.
			if ( ! empty( $selection ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-selection-initial'] = strtoupper( sanitize_hex_color( $selection ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );
			}
	
			// Selection high color.
			if ( ! empty( $selection_high ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-selection-high'] = strtoupper( sanitize_hex_color( $selection_high ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );
			}
	
			// border color.
			if ( ! empty( $border ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-border'] = strtoupper( sanitize_hex_color( $border ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );
			}

			// Background color.
			if ( ! empty( $background ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-background'] = strtoupper( sanitize_hex_color( $background ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );
			}

			// Title text color.
			if ( ! empty( $title_text ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-page-title-text'] = strtoupper( sanitize_hex_color( $title_text ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );	
			}

			// Title background color.
			if ( ! empty( $title_background ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-page-title-background'] = strtoupper( sanitize_hex_color( $title_background ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );	
			}

			// Menu dropdown color.
			if ( ! empty( $bg_menu_dropdown ) ) {
				$solace_global_colors['palettes'][$active_palette]['colors']['sol-color-bg-menu-dropdown'] = strtoupper( sanitize_hex_color( $bg_menu_dropdown ) );
				set_theme_mod( 'solace_global_colors' , $solace_global_colors );	
			}			
		}
	}
}

/**
 * Add Global Colors
 */
function solace_elementor_add_theme_color_controls( $widget, $section_id ) {

    // if ( 'section_global_colors' == $section_id ) {
        // Add control
        $widget->start_controls_section(
			'section_theme_global_colors',
			array(
				'label' => __( 'Theme Global Solace', 'solace' ),
				'tab' => 'global-colors',
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'title',
			array(
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'required' => true,
			)
		);

		// Color Value
		$repeater->add_control(
			'color',
			array(
				'type' => Controls_Manager::COLOR,
				'label_block' => true,
				'dynamic' => [],
				'selectors' => array(
					'{{WRAPPER}}.el-is-editing' => '--global-{{_id.VALUE}}: {{VALUE}}',
				),
				'global' => array(
					'active' => false,
				),
			)
		);
		$theme_colors = array(
			array(
				'_id' => 'sol-color-base-font',
				'title'  => __( 'Base Font', 'solace' ),
				'color' => '#000000',
			),
			array(
				'_id' => 'sol-color-heading',
				'title'  => __( 'Heading', 'solace' ),
				'color' => '#3E3E3E',
			),
			array(
				'_id' => 'sol-color-link-button-initial',
				'title'  => __( 'Link', 'solace' ),
				'color' => '#1D70DB',
			),
			array(
				'_id' => 'sol-color-link-button-hover',
				'title'  => __( 'Link Hover', 'solace' ),
				'color' => '#1D70DB',
			),
			array(
				'_id' => 'sol-color-button-initial',
				'title'  => __( 'Button', 'solace' ),
				'color' => '#1D70DB',
			),
			array(
				'_id' => 'sol-color-button-hover',
				'title'  => __( 'Button Hover', 'solace' ),
				'color' => '#1D70DB',
			),			
			array(
				'_id' => 'sol-color-selection-initial',
				'title'  => __( 'Text Selection', 'solace' ),
				'color' => '#FF9500',
			),
			array(
				'_id' => 'sol-color-selection-high',
				'title'  => __( 'Text Selection Background', 'solace' ),
				'color' => '#FF9500',
			),
			array(
				'_id' => 'sol-color-border',
				'title'  => __( 'Border', 'solace' ),
				'color' => '#DEDEDE',
			),
			array(
				'_id' => 'sol-color-background',
				'title'  => __( 'Background', 'solace' ),
				'color' => '#EBEBEB',
			),
			array(
				'_id' => 'sol-color-page-title-text',
				'title'  => __( 'Page Title', 'solace' ),
				'color' => '#FFFFFF',
			),
			array(
				'_id' => 'sol-color-page-title-background',
				'title'  => __( 'Page Title Background', 'solace' ),
				'color' => '#000F44',
			),
			array(
				'_id' => 'sol-color-bg-menu-dropdown',
				'title'  => __( 'Submenu Background', 'solace' ),
				'color' => '#DEDEDE',
			),
		);


        $widget->add_control(
			'solace_colors',
			array(
				'type' => Global_Style_Repeater::CONTROL_TYPE,
				'fields' => $repeater->get_controls(),
				'default' => $theme_colors,
				'item_actions' => array(
					'add' => false,
					'remove' => false,
				),
			)
		);
       
        $widget->end_controls_section();

}

function solace_save_customizer_settings() {
    if (is_customize_preview()) {

		$solace_global_colors = get_theme_mod( 'solace_global_colors', solace_get_global_colors_default( true ) );
		$active_palette = $solace_global_colors['activePalette'];
		$base_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-base-font'];
		$heading_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-heading'];
		$link_button_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-link-button-initial'];
		$link_button_hover_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-link-button-hover'];
		$button_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-initial'];
		$button_hover_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-hover'];
		$text_selection_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-selection-initial'];
		$text_selection_bg_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-selection-high'];
		$border_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-border'];
		$background_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-background'];
		$page_title_text_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-page-title-text'];
		$page_title_bg_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-page-title-background'];
		$bg_menu_dropdown = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-bg-menu-dropdown'];

		$system_colors = array(
			array(
				'_id' => 'primary',
				'title'  => __( 'Button', 'solace' ),
				'color' => isset($button_color)?strtoupper($button_color):'#1D70DB',
			),
			array(
				'_id' => 'secondary',
				'title'  => __( 'Page Title Background', 'solace' ),
				'color' => isset($page_title_bg_color)?strtoupper($page_title_bg_color):'#000F44',
			),
			array(
				'_id' => 'text',
				'title'  => __( 'Base Font', 'solace' ),
				'color' => isset($base_color)?strtoupper($base_color):'#000000',
			),
			array(
				'_id' => 'accent',
				'title'  => __( 'Submenu Background', 'solace' ),
				'color' => isset($bg_menu_dropdown)?strtoupper($bg_menu_dropdown):'#DEDEDE',
			),
		);
		if (class_exists('Elementor\Plugin')) {
			\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_colors', $system_colors );
		}

		$theme_colors = array(
			array(
				'_id' => 'sol-color-base-font',
				'title'  => __( 'Text / Base Font', 'solace' ),
				'color' => isset($base_color)?strtoupper($base_color):'#000000',
			),
			array(
				'_id' => 'sol-color-heading',
				'title'  => __( 'Heading', 'solace' ),
				'color' => isset($heading_color)?strtoupper($heading_color):'#1D70DB',
			),
			array(
				'_id' => 'sol-color-link-button-initial',
				'title'  => __( 'Link', 'solace' ),
				'color' => isset($link_button_color)?strtoupper($link_button_color):'#1D70DB',
			),
			array(
				'_id' => 'sol-color-link-button-hover',
				'title'  => __( 'Link Hover', 'solace' ),
				'color' => isset($link_button_hover_color)?strtoupper($link_button_hover_color):'#1D70DB',
			),
			array(
				'_id' => 'sol-color-button-initial',
				'title'  => __( 'Primary / Button', 'solace' ),
				'color' => isset($button_color)?strtoupper($button_color):'#1D70DB',
			),
			array(
				'_id' => 'sol-color-button-hover',
				'title'  => __( 'Button Hover', 'solace' ),
				'color' => isset($button_hover_color)?strtoupper($button_hover_color):'#1D70DB',
			),
			array(
				'_id' => 'sol-color-selection',
				'title'  => __( 'Text Selection', 'solace' ),
				'color' => isset($text_selection_color)?strtoupper($text_selection_color):'#FF9500',
			),
			array(
				'_id' => 'sol-color-selection-high',
				'title'  => __( 'Text Selection Bg', 'solace' ),
				'color' => isset($text_selection_bg_color)?strtoupper($text_selection_bg_color):'#FF9500',
			),
			array(
				'_id' => 'sol-color-border',
				'title'  => __( 'Border', 'solace' ),
				'color' => isset($border_color)?strtoupper($border_color):'#DEDEDE',
			),
			array(
				'_id' => 'sol-color-background',
				'title'  => __( 'Background', 'solace' ),
				'color' => isset($background_color)?strtoupper($background_color):'#EBEBEB',
			),
			array(
				'_id' => 'sol-color-page-title-text',
				'title'  => __( 'Page Title', 'solace' ),
				'color' => isset($page_title_text_color)?strtoupper($page_title_text_color):'#FFFFFF',
			),
			array(
				'_id' => 'sol-color-page-title-background',
				'title'  => __( 'Secondary Page Title Bg', 'solace' ),
				'color' => isset($page_title_bg_color)?strtoupper($page_title_bg_color):'#000F44',
			),
			array(
				'_id' => 'sol-color-bg-menu-dropdown',
				'title'  => __( 'Submenu Background', 'solace' ),
				'color' => isset($bg_menu_dropdown)?strtoupper($bg_menu_dropdown):'#DEDEDE',
			),
		);
		if (class_exists('Elementor\Plugin')) {
			\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'solace_colors', $theme_colors );
			set_theme_mod('solace_colors',$theme_colors);
		}
		
		
    }
}


function custom_function_before_solace_theme_activation() {
	$border_color="";
	$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$solace_system_colors_primary 	= strtoupper($current['system_colors'][0]['color']);
	$solace_system_colors_secondary = strtoupper($current['system_colors'][1]['color']);
	$solace_system_colors_text		= strtoupper($current['system_colors'][2]['color']);
	$solace_system_colors_accent	= strtoupper($current['system_colors'][3]['color']);

	set_theme_mod('solace_system_colors_primary',$solace_system_colors_primary);
	set_theme_mod('solace_system_colors_secondary',$solace_system_colors_secondary);
	set_theme_mod('solace_system_colors_text',$solace_system_colors_text);
	set_theme_mod('solace_system_colors_accent',$solace_system_colors_accent);

}

function custom_function_before_theme_deactivation() {
	$theme_mods_solace = get_option('theme_mods_solace', array());

    $solace_system_colors_primary = strtoupper($theme_mods_solace['solace_system_colors_primary']);
	$solace_system_colors_secondary = strtoupper($theme_mods_solace['solace_system_colors_secondary']);
	$solace_system_colors_text = strtoupper($theme_mods_solace['solace_system_colors_text']);
	$solace_system_colors_accent = strtoupper($theme_mods_solace['solace_system_colors_accent']);

    if (defined('ELEMENTOR_PATH') && class_exists('\Elementor\Plugin')) {
		$system_colors = array(
			array(
				'_id' => 'primary',
				'color' => isset($solace_system_colors_primary)?$solace_system_colors_primary:'',
			),
			array(
				'_id' => 'secondary',
				'color' => isset($solace_system_colors_secondary)?$solace_system_colors_secondary:'',
			),
			array(
				'_id' => 'text',
				'color' => isset($solace_system_colors_text)?$solace_system_colors_text:'',
			),
			array(
				'_id' => 'accent',
				'color' => isset($solace_system_colors_accent)?$solace_system_colors_accent:'',
			),
		);

		\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_colors', $system_colors );
        }
}

function solace_set_default_color () {
	$solace_global_colors = get_theme_mod( 'solace_global_colors' );

	$border_color = $solace_global_colors['palettes']['base']['colors']['sol-color-border'];
	if (empty($solace_global_colors['palettes']['base']['colors']['sol-color-bg-menu-dropdown'])){
		$solace_global_colors['palettes']['base']['colors']['sol-color-bg-menu-dropdown'] = $border_color;	
	}
	
	set_theme_mod( 'solace_global_colors' , $solace_global_colors );
	$active_palette = $solace_global_colors['activePalette'];

	$primary = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-initial'];
	$secondary = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-page-title-background'];
	$text = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-base-font'];
	$border_color = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-border'];
	$accent = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-bg-menu-dropdown'];
	$accent = empty($accent)?$border_color:$accent;

	if (defined('ELEMENTOR_PATH') && class_exists('\Elementor\Plugin')) {
		$system_colors = array(
			array(
				'_id' => 'primary',
				'color' => isset($primary)?strtoupper($primary):'',
			),
			array(
				'_id' => 'secondary',
				'color' => isset($secondary)?strtoupper($secondary):'',
			),
			array(
				'_id' => 'text',
				'color' => isset($text)?strtoupper($text):'',
			),
			array(
				'_id' => 'accent',
				'color' => isset($accent)?strtoupper($accent):'',
			),
		);

		\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_colors', $system_colors );
    }
	
}

add_action('customize_controls_enqueue_scripts', 'solace_set_default_color');

add_action('switch_theme', 'custom_function_before_theme_deactivation');

add_action( 'elementor/editor/init', 'custom_function_before_solace_theme_activation' , 1 );

add_action( 'elementor/element/kit/section_global_colors/after_section_end', 'solace_elementor_add_theme_color_controls' , 10, 2 );
add_action( 'elementor/editor/init', 'solace_init_elementor_add_theme_colors'  );

add_action( 'elementor/document/after_save', 'solace_color_elementor_after_save', 10, 2 );

add_action('customize_save_after', 'solace_save_customizer_settings');