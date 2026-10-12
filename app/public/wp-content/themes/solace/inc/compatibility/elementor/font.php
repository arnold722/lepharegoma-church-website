<?php
/**
 * Author:          
 * Created on:      05/09/2018
 *
 */

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Repeater;
use Elementor\Plugin;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
  
function solace_font_elementor_after_save( $elementor_element, $data ) {

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

	if ( isset( $data['settings']['post_status'] ) && ( $data['settings']['post_status'] === 'publish' || $data['settings']['post_status'] === 'save' ) ) {
		$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();

		if ( $current ){
			
			// GET SYSTEM TYPOGRAPHY ELEMENTOR FOR BASE FONT
			$system_typography 		= $current['system_typography'];

			$primary 				= $system_typography[0]['typography_font_family'];
			$secondary 				= $system_typography[1]['typography_font_family'];
			$text 					= $system_typography[2]['typography_font_family'];
			$accent 				= $system_typography[3]['typography_font_family'];

			$smaller_font = $primary;
			$logotitle_font = $secondary;
			$base_font = $text;
			$button_font = $accent;

			set_theme_mod('solace_smaller_font_family',$smaller_font);
			set_theme_mod('solace_logotitle_font_family',$logotitle_font);
			set_theme_mod('solace_button_font_family',$button_font);

			$t = $system_typography[2] ?? [];

			$base_font_size              = $t['typography_font_size']['size'] ?? '';
			$base_font_size_unit         = $t['typography_font_size']['unit'] ?? '';
			$base_font_size_tablet       = $t['typography_font_size_tablet']['size'] ?? '';
			$base_font_size_tablet_unit  = $t['typography_font_size_tablet']['unit'] ?? '';
			$base_font_size_mobile       = $t['typography_font_size_mobile']['size'] ?? '';
			$base_font_size_mobile_unit  = $t['typography_font_size_mobile']['unit'] ?? '';

			$font_weights                = $t['typography_font_weight'] ?? '';
			$font_transform              = $t['typography_text_transform'] ?? '';

			$font_line_height            = $t['typography_line_height']['size'] ?? '';
			$font_line_height_unit       = $t['typography_line_height']['unit'] ?? '';
			$font_line_height_tablet     = $t['typography_line_height_tablet']['size'] ?? '';
			$font_line_height_tablet_unit= $t['typography_line_height_tablet']['unit'] ?? '';
			$font_line_height_mobile     = $t['typography_line_height_mobile']['size'] ?? '';
			$font_line_height_mobile_unit= $t['typography_line_height_mobile']['unit'] ?? '';

			$font_letter_spacing         = $t['typography_letter_spacing']['size'] ?? '';
			$font_letter_spacing_tablet  = $t['typography_letter_spacing_tablet']['size'] ?? '0';
			$font_letter_spacing_mobile  = $t['typography_letter_spacing_mobile']['size'] ?? '0';

			$font_size_tablet            = $base_font_size_tablet;
			$font_size_mobile            = $base_font_size_mobile;
			// Synchronize Above (Text) with (Solace Base)
			$sync_text_to_solace_base = [
				[
					'_id' => 'solace_body_font_family',
					'title' => 'Solace Base',
					'typography_typography' => 'custom',
					'typography_font_family' => $text,
					'typography_font_size' => [
						'unit' => '',
						'size' => $base_font_size,
						'sizes' => []
					],
					'typography_font_weight' => $font_weights,
					'typography_text_transform' => $font_transform,
					'typography_line_height' => [
						'unit' => $font_line_height_unit,
						'size' => $font_line_height,
						'sizes' => []
					],
					'typography_letter_spacing' => [
						'unit' => 'px',
						'size' => $font_letter_spacing,
						'sizes' => []
					],
					'typography_font_size_tablet' => [
						'unit' => '',
						'size' => $base_font_size_tablet,
						'sizes' => []
					],
					'typography_font_size_mobile' => [
						'unit' => '',
						'size' => $base_font_size_mobile,
						'sizes' => []
					],
					'typography_line_height_tablet' => [
						'unit' => $font_line_height_tablet_unit,
						'size' => $font_line_height_tablet,
						'sizes' => []
					],
					'typography_line_height_mobile' => [
						'unit' => $font_line_height_mobile_unit,
						'size' => $font_line_height_mobile,
						'sizes' => []
					],
					'typography_letter_spacing_tablet' => [
						'unit' => 'px',
						'size' => $font_letter_spacing_tablet,
						'sizes' => []
					],
					'typography_letter_spacing_mobile' => [
						'unit' => 'px',
						'size' => $font_letter_spacing_mobile,
						'sizes' => []
					]
				]
			];

			if (class_exists('Elementor\Plugin')) {
				// \Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_typography', $sync_text_to_solace_base );		
			}


			set_theme_mod('solace_body_font_family', $base_font);
			$current_values = get_theme_mod('solace_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_base = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL );

			// Update fontSize values
			$current_values['fontSize']['mobile'] = !empty($base_font_size_mobile) ? $base_font_size_mobile : ($defaults_base['fontSize']['mobile'] ?? '');
			$current_values['fontSize']['tablet'] = isset($base_font_size_tablet)?$base_font_size_tablet:$defaults_base['fontSize']['tablet'];
			$current_values['fontSize']['desktop'] = isset($base_font_size)?$base_font_size:$defaults_base['fontSize']['desktop'];

			// Update fontSize suffix values
			$current_values['fontSize']['suffix']['mobile'] = isset($base_font_size_mobile_unit)?$base_font_size_mobile_unit:$defaults_base['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($base_font_size_tablet_unit)?$base_font_size_tablet_unit:$defaults_base['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($base_font_size_unit)?$base_font_size_unit:$defaults_base['fontSize']['suffix']['desktop'];

			// Update fontWeight and textTransform
			$current_values['fontWeight'] = isset($font_weights)?$font_weights:$defaults_base['fontWeight'];
			$current_values['textTransform'] = isset($font_transform)?$font_transform:$defaults_base['textTransform'];

			// Update lineHeight values
			$current_values['lineHeight']['desktop'] = isset($font_line_height)?$font_line_height:$defaults_base['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet)?$font_line_height_tablet:$defaults_base['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile)?$font_line_height_mobile:$defaults_base['lineHeight']['mobile'];

			// Update lineHeight suffix values
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit)?$font_line_height_unit:$defaults_base['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_tablet_unit)?$font_line_height_tablet_unit:$defaults_base['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_mobile_unit)?$font_line_height_mobile_unit:$defaults_base['lineHeight']['suffix']['mobile'];

			// Update letterSpacing values
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing)?$font_letter_spacing:$defaults_base['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet)?$font_letter_spacing_tablet:$defaults_base['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile)?$font_letter_spacing_mobile:$defaults_base['letterSpacing']['mobile'];
			
			set_theme_mod('solace_typeface_general', $current_values);

			$font_families 			= array();
			$font_sizes 			= array();
			$font_sizes_unit 		= array();
			$font_sizes_tablet		= array();
			$font_sizes_mobile = array();
			$font_sizes_tablet_unit = array();
			$font_sizes_mobile_unit = array();
			$font_weights 			= array();
			$font_transform 		= array();

			$font_line_height 		= array();
			$font_line_height_tablet = array();
			$font_line_height_mobile = array();
			$font_line_height_unit 	= array();
			$font_line_height_unit_tablet = array();
			$font_line_height_unit_mobile = array();

			$font_letter_spacing 	= array();
			$font_letter_spacing_tablet = array();
			$font_letter_spacing_mobile = array();

			$font_letter_spacing_unit= array();

			for ($i = 0; $i <= 10; $i++) {
				if (isset($system_typography[$i])) {
					$t = $system_typography[$i];

					$font_families[$i]            = $t['typography_font_family'] ?? '';
					$font_sizes[$i]                = $t['typography_font_size']['size'] ?? '';
					$font_sizes_unit[$i]           = $t['typography_font_size']['unit'] ?? '';
					$font_sizes_tablet[$i]         = $t['typography_font_size_tablet']['size'] ?? '';
					$font_sizes_mobile[$i]         = $t['typography_font_size_mobile']['size'] ?? '';
					$font_sizes_tablet_unit[$i]    = $t['typography_font_size_tablet']['unit'] ?? '';
					$font_sizes_mobile_unit[$i]    = $t['typography_font_size_mobile']['unit'] ?? '';

					$font_weights[$i]              = $t['typography_font_weight'] ?? '';
					$font_transform[$i]            = $t['typography_text_transform'] ?? '';

					$font_line_height[$i]          = $t['typography_line_height']['size'] ?? '';
					$font_line_height_tablet[$i]   = $t['typography_line_height_tablet']['size'] ?? '';
					$font_line_height_mobile[$i]   = $t['typography_line_height_mobile']['size'] ?? '';
					$font_line_height_unit[$i]         = $t['typography_line_height']['unit'] ?? '';
					$font_line_height_unit_tablet[$i]  = $t['typography_line_height_tablet']['unit'] ?? '';
					$font_line_height_unit_mobile[$i]  = $t['typography_line_height_mobile']['unit'] ?? '';

					$font_letter_spacing[$i]              = $t['typography_letter_spacing']['size'] ?? '';
					$font_letter_spacing_tablet[$i]       = $t['typography_letter_spacing_tablet']['size'] ?? '0';
					$font_letter_spacing_mobile[$i]       = $t['typography_letter_spacing_mobile']['size'] ?? '0';
					$font_letter_spacing_unit[$i]         = $t['typography_letter_spacing']['unit'] ?? '';
					$font_letter_spacing_tablet_unit[$i]  = $t['typography_letter_spacing_tablet']['unit'] ?? 'px';
					$font_letter_spacing_mobile_unit[$i]  = $t['typography_letter_spacing_mobile']['unit'] ?? 'px';
				}
			}

			set_theme_mod('solace_smaller_font_family',$font_families[0]);
			set_theme_mod('solace_logotitle_font_family',$font_families[1]);
			set_theme_mod('solace_body_font_family',$font_families[2]);
			set_theme_mod('solace_button_font_family',$font_families[3]);

			set_theme_mod('solace_h1_font_family_general', $font_families[5]  ?? '');
			set_theme_mod('solace_h2_font_family_general', $font_families[6]  ?? '');
			set_theme_mod('solace_h3_font_family_general', $font_families[7]  ?? '');
			set_theme_mod('solace_h4_font_family_general', $font_families[8]  ?? '');
			set_theme_mod('solace_h5_font_family_general', $font_families[9]  ?? '');
			set_theme_mod('solace_h6_font_family_general', $font_families[10] ?? '');

			$current_values = get_theme_mod('solace_h1_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h1 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H1 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[5])?$font_sizes[5]:$defaults_h1['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[5])?$font_sizes_tablet[5]:$defaults_h1['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[5])?$font_sizes_mobile[5]:$defaults_h1['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[5])?$font_sizes_mobile_unit[5]:$defaults_h1['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[5])?$font_sizes_tablet_unit[5]:$defaults_h1['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[5])?$font_sizes_unit[5]:$defaults_h1['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[5])?$font_weights[5]:$defaults_h1['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[5])?$font_transform[5]:$defaults_h1['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[5])?$font_line_height[5]:$defaults_h1['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[5])?$font_line_height_tablet[5]:$defaults_h1['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[5])?$font_line_height_mobile[5]:$defaults_h1['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[5])?$font_line_height_unit[5]:$defaults_h1['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[5])?$font_line_height_unit_tablet[5]:$defaults_h1['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[5])?$font_line_height_unit_mobile[5]:$defaults_h1['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[5])?$font_letter_spacing[5]:$defaults_h1['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[5])?$font_letter_spacing_tablet[5]:$defaults_h1['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[5])?$font_letter_spacing_mobile[5]:$defaults_h1['letterSpacing']['mobile'];
			set_theme_mod('solace_h1_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_h2_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h2 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H2 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[6])?$font_sizes[6]:$defaults_h2['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[6])?$font_sizes_tablet[6]:$defaults_h2['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[6])?$font_sizes_mobile[6]:$defaults_h2['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[6])?$font_sizes_mobile_unit[6]:$defaults_h2['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[6])?$font_sizes_tablet_unit[6]:$defaults_h2['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[6])?$font_sizes_unit[6]:$defaults_h2['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[6])?$font_weights[6]:$defaults_h2['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[6])?$font_transform[6]:$defaults_h2['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[6])?$font_line_height[6]:$defaults_h2['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[6])?$font_line_height_tablet[6]:$defaults_h2['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[6])?$font_line_height_mobile[6]:$defaults_h2['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[6])?$font_line_height_unit[6]:$defaults_h2['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[6])?$font_line_height_unit_tablet[6]:$defaults_h2['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[6])?$font_line_height_unit_mobile[6]:$defaults_h2['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[6])?$font_letter_spacing[6]:$defaults_h2['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[6])?$font_letter_spacing_tablet[6]:$defaults_h2['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[6])?$font_letter_spacing_mobile[6]:$defaults_h2['letterSpacing']['mobile'];
			set_theme_mod('solace_h2_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_h3_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h3 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H3 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[7])?$font_sizes[7]:$defaults_h3['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[7])?$font_sizes_tablet[7]:$defaults_h3['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[7])?$font_sizes_mobile[7]:$defaults_h3['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[7])?$font_sizes_mobile_unit[7]:$defaults_h3['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[7])?$font_sizes_tablet_unit[7]:$defaults_h3['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[7])?$font_sizes_unit[7]:$defaults_h3['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[7])?$font_weights[7]:$defaults_h3['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[7])?$font_transform[7]:$defaults_h3['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[7])?$font_line_height[7]:$defaults_h3['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[7])?$font_line_height_tablet[7]:$defaults_h3['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[7])?$font_line_height_mobile[7]:$defaults_h3['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[7])?$font_line_height_unit[7]:$defaults_h3['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[7])?$font_line_height_unit_tablet[7]:$defaults_h3['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[7])?$font_line_height_unit_mobile[7]:$defaults_h3['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[7])?$font_letter_spacing[7]:$defaults_h3['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[7])?$font_letter_spacing_tablet[7]:$defaults_h3['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[7])?$font_letter_spacing_mobile[7]:$defaults_h3['letterSpacing']['mobile'];
			set_theme_mod('solace_h3_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_h4_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h4 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H4 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[8])?$font_sizes[8]:$defaults_h4['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[8])?$font_sizes_tablet[8]:$defaults_h4['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[8])?$font_sizes_mobile[8]:$defaults_h4['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[8])?$font_sizes_mobile_unit[8]:$defaults_h4['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[8])?$font_sizes_tablet_unit[8]:$defaults_h4['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[8])?$font_sizes_unit[8]:$defaults_h4['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[8])?$font_weights[8]:$defaults_h4['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[8])?$font_transform[8]:$defaults_h4['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[8])?$font_line_height[8]:$defaults_h4['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[8])?$font_line_height_tablet[8]:$defaults_h4['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[8])?$font_line_height_mobile[8]:$defaults_h4['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[8])?$font_line_height_unit[8]:$defaults_h4['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[8])?$font_line_height_unit_tablet[8]:$defaults_h4['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[8])?$font_line_height_unit_mobile[8]:$defaults_h4['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[8])?$font_letter_spacing[8]:$defaults_h4['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[8])?$font_letter_spacing_tablet[8]:$defaults_h4['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[8])?$font_letter_spacing_mobile[8]:$defaults_h4['letterSpacing']['mobile'];
			set_theme_mod('solace_h4_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_h5_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h5 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H5 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[9])?$font_sizes[9]:$defaults_h5['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[9])?$font_sizes_tablet[9]:$defaults_h5['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[9])?$font_sizes_mobile[9]:$defaults_h5['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[9])?$font_sizes_mobile_unit[9]:$defaults_h5['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[9])?$font_sizes_tablet_unit[9]:$defaults_h5['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[9])?$font_sizes_unit[9]:$defaults_h5['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[9])?$font_weights[9]:$defaults_h5['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[9])?$font_transform[9]:$defaults_h5['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[9])?$font_line_height[9]:$defaults_h5['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[9])?$font_line_height_tablet[9]:$defaults_h5['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[9])?$font_line_height_mobile[9]:$defaults_h5['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[9])?$font_line_height_unit[9]:$defaults_h5['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[9])?$font_line_height_unit_tablet[9]:$defaults_h5['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[9])?$font_line_height_unit_mobile[9]:$defaults_h5['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[9])?$font_letter_spacing[9]:$defaults_h5['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[9])?$font_letter_spacing_tablet[9]:$defaults_h5['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[9])?$font_letter_spacing_mobile[9]:$defaults_h5['letterSpacing']['mobile'];
			set_theme_mod('solace_h5_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_h6_typeface_general');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_h6 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H6 );
			$current_values['fontSize']['desktop'] = isset($font_sizes[10])?$font_sizes[10]:$defaults_h6['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[10])?$font_sizes_tablet[10]:$defaults_h6['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[10])?$font_sizes_mobile[10]:$defaults_h6['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[10])?$font_sizes_mobile_unit[10]:$defaults_h6['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[10])?$font_sizes_tablet_unit[10]:$defaults_h6['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[10])?$font_sizes_unit[10]:$defaults_h6['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[10])?$font_weights[10]:$defaults_h6['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[10])?$font_transform[10]:$defaults_h6['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[10])?$font_line_height[10]:$defaults_h6['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[10])?$font_line_height_tablet[10]:$defaults_h6['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[10])?$font_line_height_mobile[10]:$defaults_h6['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[10])?$font_line_height_unit[10]:$defaults_h6['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[10])?$font_line_height_unit_tablet[10]:$defaults_h6['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[10])?$font_line_height_unit_mobile[10]:$defaults_h6['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[10])?$font_letter_spacing[10]:$defaults_h6['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[10])?$font_letter_spacing_tablet[10]:$defaults_h6['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[10])?$font_letter_spacing_mobile[10]:$defaults_h6['letterSpacing']['mobile'];
			set_theme_mod('solace_h6_typeface_general', $current_values);

			$current_values = get_theme_mod('solace_typeface_smaller');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_smaller = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_SMALLER );
			$current_values['fontSize']['desktop'] = isset($font_sizes[0])?$font_sizes[0]:$defaults_smaller['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[0])?$font_sizes_tablet[0]:$defaults_smaller['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[0])?$font_sizes_mobile[0]:$defaults_smaller['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[0])?$font_sizes_mobile_unit[0]:$defaults_smaller['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[0])?$font_sizes_tablet_unit[0]:$defaults_smaller['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[0])?$font_sizes_unit[0]:$defaults_smaller['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[0])?$font_weights[0]:$defaults_smaller['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[0])?$font_transform[0]:$defaults_smaller['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[0])?$font_line_height[0]:$defaults_smaller['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[0])?$font_line_height_tablet[0]:$defaults_smaller['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[0])?$font_line_height_mobile[0]:$defaults_smaller['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[0])?$font_line_height_unit[0]:$defaults_smaller['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[0])?$font_line_height_unit_tablet[0]:$defaults_smaller['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[0])?$font_line_height_unit_mobile[0]:$defaults_smaller['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[0])?$font_letter_spacing[0]:$defaults_smaller['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[0])?$font_letter_spacing_tablet[0]:$defaults_smaller['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[0])?$font_letter_spacing_mobile[0]:$defaults_smaller['letterSpacing']['mobile'];
			set_theme_mod('solace_typeface_smaller', $current_values);

			$current_values = get_theme_mod('solace_typeface_logotitle');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_logotitle = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_LOGOTITLE );
			$current_values['fontSize']['desktop'] = isset($font_sizes[1])?$font_sizes[1]:$defaults_logotitle['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[1])?$font_sizes_tablet[1]:$defaults_logotitle['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[1])?$font_sizes_mobile[1]:$defaults_logotitle['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[1])?$font_sizes_mobile_unit[1]:$defaults_logotitle['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[1])?$font_sizes_tablet_unit[1]:$defaults_logotitle['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[1])?$font_sizes_unit[1]:$defaults_logotitle['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[1])?$font_weights[1]:$defaults_logotitle['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[1])?$font_transform[1]:$defaults_logotitle['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[1])?$font_line_height[1]:$defaults_logotitle['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[1])?$font_line_height_tablet[1]:$defaults_logotitle['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[1])?$font_line_height_mobile[1]:$defaults_logotitle['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[1])?$font_line_height_unit[1]:$defaults_logotitle['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[1])?$font_line_height_unit_tablet[1]:$defaults_logotitle['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[1])?$font_line_height_unit_mobile[1]:$defaults_logotitle['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[1])?$font_letter_spacing[1]:$defaults_logotitle['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[1])?$font_letter_spacing_tablet[1]:$defaults_logotitle['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[1])?$font_letter_spacing_mobile[1]:$defaults_logotitle['letterSpacing']['mobile'];
			$current_values['letterSpacing']['suffix']['desktop'] = isset($font_letter_spacing_unit[1])?$font_letter_spacing_unit[1]:$defaults_logotitle['letterSpacing']['suffix']['desktop'];
			$current_values['letterSpacing']['suffix']['tablet'] = isset($font_letter_spacing_tablet_unit[1])?$font_letter_spacing_tablet_unit[1]:$defaults_logotitle['letterSpacing']['suffix']['tablet'];
			$current_values['letterSpacing']['suffix']['mobile'] = isset($font_letter_spacing_mobile_unit[1])?$font_letter_spacing_mobile_unit[1]:$defaults_logotitle['letterSpacing']['suffix']['mobile'];
			set_theme_mod('solace_typeface_logotitle', $current_values);
			// $font_letter_spacing_tablet_unit[$i]	= !empty($system_typography[$i]['typography_letter_spacing_tablet']['unit'])?$system_typography[$i]['typography_letter_spacing_tablet']['unit']:'px';

			$current_values = get_theme_mod('solace_typeface_button');
			if (!is_array($current_values)) {
				$current_values = [];
			}
			$defaults_button = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_BUTTON );
			$current_values['fontSize']['desktop'] = isset($font_sizes[3])?$font_sizes[3]:$defaults_button['fontSize']['desktop'];
			$current_values['fontSize']['tablet'] = isset($font_sizes_tablet[3])?$font_sizes_tablet[3]:$defaults_button['fontSize']['tablet'];
			$current_values['fontSize']['mobile'] = isset($font_sizes_mobile[3])?$font_sizes_mobile[3]:$defaults_button['fontSize']['mobile'];
			$current_values['fontSize']['suffix']['mobile'] = isset($font_sizes_mobile_unit[3])?$font_sizes_mobile_unit[3]:$defaults_button['fontSize']['suffix']['mobile'];
			$current_values['fontSize']['suffix']['tablet'] = isset($font_sizes_tablet_unit[3])?$font_sizes_tablet_unit[3]:$defaults_button['fontSize']['suffix']['tablet'];
			$current_values['fontSize']['suffix']['desktop'] = isset($font_sizes_unit[3])?$font_sizes_unit[3]:$defaults_button['fontSize']['suffix']['desktop'];
			$current_values['fontWeight'] = isset($font_weights[3])?$font_weights[3]:$defaults_button['fontWeight'];
			$current_values['textTransform'] = isset($font_transform[3])?$font_transform[3]:$defaults_button['textTransform'];
			$current_values['lineHeight']['desktop'] = isset($font_line_height[3])?$font_line_height[3]:$defaults_button['lineHeight']['desktop'];
			$current_values['lineHeight']['tablet'] = isset($font_line_height_tablet[3])?$font_line_height_tablet[3]:$defaults_button['lineHeight']['tablet'];
			$current_values['lineHeight']['mobile'] = isset($font_line_height_mobile[3])?$font_line_height_mobile[3]:$defaults_button['lineHeight']['mobile'];
			$current_values['lineHeight']['suffix']['desktop'] = isset($font_line_height_unit[3])?$font_line_height_unit[3]:$defaults_button['lineHeight']['suffix']['desktop'];
			$current_values['lineHeight']['suffix']['tablet'] = isset($font_line_height_unit_tablet[3])?$font_line_height_unit_tablet[3]:$defaults_button['lineHeight']['suffix']['tablet'];
			$current_values['lineHeight']['suffix']['mobile'] = isset($font_line_height_unit_mobile[3])?$font_line_height_unit_mobile[3]:$defaults_button['lineHeight']['suffix']['mobile'];
			$current_values['letterSpacing']['desktop'] = isset($font_letter_spacing[3])?$font_letter_spacing[3]:$defaults_button['letterSpacing']['desktop'];
			$current_values['letterSpacing']['tablet'] = isset($font_letter_spacing_tablet[3])?$font_letter_spacing_tablet[3]:$defaults_button['letterSpacing']['tablet'];
			$current_values['letterSpacing']['mobile'] = isset($font_letter_spacing_mobile[3])?$font_letter_spacing_mobile[3]:$defaults_button['letterSpacing']['mobile'];
			set_theme_mod('solace_typeface_button', $current_values);
		}
	}
}

function solace_typography_elementor_add_to_customizer() {

	$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$system_typography 		= $current['system_typography'];
	
	$h1_font 				= $system_typography[5]['typography_font_family'];
	$h2_font 				= $system_typography[6]['typography_font_family'];
	$h3_font 				= $system_typography[7]['typography_font_family'];
	$h4_font 				= $system_typography[8]['typography_font_family'];
	$h5_font 				= $system_typography[9]['typography_font_family'];
	$h6_font 				= $system_typography[10]['typography_font_family'];
	$primary 				= $system_typography[0]['typography_font_family'];
	$secondary 				= $system_typography[1]['typography_font_family'];
	$text 					= $system_typography[2]['typography_font_family'];
	$button 				= $system_typography[3]['typography_font_family'];
	$base_font 				= $system_typography[4]['typography_font_family'];

	set_theme_mod('solace_smaller_font_family',$primary);
	set_theme_mod('solace_logotitle_font_family',$secondary);
	set_theme_mod('solace_body_font_family', $text);
	set_theme_mod('solace_button_font_family',$button);
	
	set_theme_mod('solace_h1_font_family_general',$h1_font);
	set_theme_mod('solace_h2_font_family_general',$h2_font);
	set_theme_mod('solace_h3_font_family_general',$h3_font);
	set_theme_mod('solace_h4_font_family_general',$h4_font);
	set_theme_mod('solace_h5_font_family_general',$h5_font);
	set_theme_mod('solace_h6_font_family_general',$h6_font);
	
}


function solace_typography_elementor_add_custom() {

	$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$system_typography 		= $current['system_typography'];
	if ((!empty($system_typography) && isset($system_typography[5]['typography_font_family'])) && empty(get_theme_mod('solace_h1_font_family_general' ))) {
		solace_typography_elementor_add_to_customizer();
	} else {
// 		$solace_base_font 			   = get_theme_mod('solace_typeface_general','DM Sans' );
		$solace_base_font 			   = get_theme_mod('solace_body_font_family','DM Sans' );
		$solace_h1_font_family_general = get_theme_mod('solace_h1_font_family_general','DM Sans' );
		$solace_h2_font_family_general = get_theme_mod('solace_h2_font_family_general','DM Sans' );
		$solace_h3_font_family_general = get_theme_mod('solace_h3_font_family_general','DM Sans' );
		$solace_h4_font_family_general = get_theme_mod('solace_h4_font_family_general','DM Sans' );
		$solace_h5_font_family_general = get_theme_mod('solace_h5_font_family_general','DM Sans' );
		$solace_h6_font_family_general = get_theme_mod('solace_h6_font_family_general','DM Sans' );

		$solace_smaller_font_family = get_theme_mod('solace_smaller_font_family','DM Sans' );
		$solace_logotitle_font_family = get_theme_mod('solace_logotitle_font_family','DM Sans' );
		$solace_button_font_family = get_theme_mod('solace_button_font_family','DM Sans' );

		$primary = $solace_smaller_font_family;
		$secondary = $solace_logotitle_font_family;
		$text = $solace_base_font;
		$accent = $solace_button_font_family;

		// BASE FONT
		$defaults_base = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL );
		$base_font = get_theme_mod('solace_typeface_general');
		$base_font_size_desktop = isset($base_font['fontSize']['desktop'])?$base_font['fontSize']['desktop']:$defaults_base['fontSize']['desktop'];
		$base_font_size_tablet = isset($base_font['fontSize']['tablet'])?$base_font['fontSize']['tablet']:$defaults_base['fontSize']['tablet'];
		$base_font_size_mobile = isset($base_font['fontSize']['mobile'])?$base_font['fontSize']['mobile']:$defaults_base['fontSize']['mobile'];

		$base_font_size_desktop_unit = isset($base_font['fontSize']['suffix']['desktop'])?$base_font['fontSize']['suffix']['desktop']:$defaults_base['fontSize']['suffix']['desktop'];
		$base_font_size_tablet_unit = isset($base_font['fontSize']['suffix']['tablet'])?$base_font['fontSize']['suffix']['tablet']:$defaults_base['fontSize']['suffix']['tablet'];
		$base_font_size_mobile_unit = isset($base_font['fontSize']['suffix']['mobile'])?$base_font['fontSize']['suffix']['mobile']:$defaults_base['fontSize']['suffix']['mobile'];

		$base_font_lineHeight_desktop = isset($base_font['lineHeight']['desktop'])?$base_font['lineHeight']['desktop']:$defaults_base['lineHeight']['desktop'];
		$base_font_lineHeight_tablet = isset($base_font['lineHeight']['tablet'])?$base_font['lineHeight']['tablet']:$defaults_base['lineHeight']['tablet'];
		$base_font_lineHeight_mobile = isset($base_font['lineHeight']['mobile'])?$base_font['lineHeight']['mobile']:$defaults_base['lineHeight']['mobile'];
		$base_font_lineHeight_suffix_desktop = isset($base_font['lineHeight']['suffix']['desktop'])?$base_font['lineHeight']['suffix']['desktop']:$defaults_base['lineHeight']['suffix']['desktop'];
		$base_font_lineHeight_suffix_tablet = isset($base_font['lineHeight']['suffix']['tablet'])?$base_font['lineHeight']['suffix']['tablet']:$defaults_base['lineHeight']['suffix']['tablet'];
		$base_font_lineHeight_suffix_mobile = isset($base_font['lineHeight']['suffix']['mobile'])?$base_font['lineHeight']['suffix']['mobile']:$defaults_base['lineHeight']['suffix']['mobile'];

		$base_font_letterSpacing_desktop = isset($base_font['letterSpacing']['desktop'])?$base_font['letterSpacing']['desktop']:'';
		$base_font_letterSpacing_tablet = isset($base_font['letterSpacing']['tablet'])?$base_font['letterSpacing']['tablet']:'';
		$base_font_letterSpacing_mobile = isset($base_font['letterSpacing']['mobile'])?$base_font['letterSpacing']['mobile']:'';

		$base_font_weight = isset($base_font['fontWeight'])?$base_font['fontWeight']:$defaults_base['fontWeight'];
		$base_font_textTransform = isset($base_font['textTransform'])?$base_font['textTransform']:$defaults_base['textTransform'];
		// END OF BASE FONT

		// H1
		$defaults_h1 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H1 );
		$h1_font = get_theme_mod('solace_h1_typeface_general');
		$h1_font_size_desktop = isset($h1_font['fontSize']['desktop'])?$h1_font['fontSize']['desktop']:$defaults_h1['fontSize']['desktop'];
		$h1_font_size_desktop_unit = isset($h1_font['fontSize']['suffix']['desktop'])?$h1_font['fontSize']['suffix']['desktop']:$defaults_h1['fontSize']['suffix']['desktop'];
		$h1_font_size_tablet = isset($h1_font['fontSize']['tablet'])?$h1_font['fontSize']['tablet']:$defaults_h1['fontSize']['tablet'];
		$h1_font_size_tablet_unit = isset($h1_font['fontSize']['suffix']['tablet'])?$h1_font['fontSize']['suffix']['tablet']:$defaults_h1['fontSize']['suffix']['tablet'];
		$h1_font_size_mobile = isset($h1_font['fontSize']['mobile'])?$h1_font['fontSize']['mobile']:$defaults_h1['fontSize']['mobile'];
		$h1_font_size_mobile_unit = isset($h1_font['fontSize']['suffix']['mobile'])?$h1_font['fontSize']['suffix']['mobile']:$defaults_h1['fontSize']['suffix']['mobile'];
		
		$h1_font_lineHeight_desktop = isset($h1_font['lineHeight']['desktop'])?$h1_font['lineHeight']['desktop']:$defaults_h1['lineHeight']['desktop'];
		$h1_font_lineHeight_tablet = isset($h1_font['lineHeight']['tablet'])?$h1_font['lineHeight']['tablet']:$defaults_h1['lineHeight']['tablet'];
		$h1_font_lineHeight_mobile = isset($h1_font['lineHeight']['mobile'])?$h1_font['lineHeight']['mobile']:$defaults_h1['lineHeight']['mobile'];
		$h1_font_lineHeight_suffix_desktop = isset($h1_font['lineHeight']['suffix']['desktop'])?$h1_font['lineHeight']['suffix']['desktop']:$defaults_h1['lineHeight']['suffix']['desktop'];
		$h1_font_lineHeight_suffix_tablet = isset($h1_font['lineHeight']['suffix']['tablet'])?$h1_font['lineHeight']['suffix']['tablet']:$defaults_h1['lineHeight']['suffix']['tablet'];
		$h1_font_lineHeight_suffix_mobile = isset($h1_font['lineHeight']['suffix']['mobile'])?$h1_font['lineHeight']['suffix']['mobile']:$defaults_h1['lineHeight']['suffix']['mobile'];

		$h1_font_letterSpacing_desktop = isset($h1_font['letterSpacing']['desktop'])?$h1_font['letterSpacing']['desktop']:'';
		$h1_font_letterSpacing_tablet = isset($h1_font['letterSpacing']['tablet'])?$h1_font['letterSpacing']['tablet']:'';
		$h1_font_letterSpacing_mobile = isset($h1_font['letterSpacing']['mobile'])?$h1_font['letterSpacing']['mobile']:'';

		$h1_font_weight = isset($h1_font['fontWeight'])?$h1_font['fontWeight']:$defaults_h1['fontWeight'];
		$h1_font_textTransform = isset($h1_font['textTransform'])?$h1_font['textTransform']:'';

		// H2
		$defaults_h2 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H2 );
		$h2_font = get_theme_mod('solace_h2_typeface_general');
		$h2_font_size_desktop = isset($h2_font['fontSize']['desktop'])?$h2_font['fontSize']['desktop']:$defaults_h2['fontSize']['desktop'];
		$h2_font_size_desktop_unit = isset($h2_font['fontSize']['suffix']['desktop'])?$h2_font['fontSize']['suffix']['desktop']:$defaults_h2['fontSize']['suffix']['desktop'];
		$h2_font_size_tablet = isset($h2_font['fontSize']['tablet'])?$h2_font['fontSize']['tablet']:$defaults_h2['fontSize']['tablet'];
		$h2_font_size_tablet_unit = isset($h2_font['fontSize']['suffix']['tablet'])?$h2_font['fontSize']['suffix']['tablet']:$defaults_h2['fontSize']['suffix']['tablet'];
		$h2_font_size_mobile = isset($h2_font['fontSize']['mobile'])?$h2_font['fontSize']['mobile']:$defaults_h2['fontSize']['mobile'];
		$h2_font_size_mobile_unit = isset($h2_font['fontSize']['suffix']['mobile'])?$h2_font['fontSize']['suffix']['mobile']:$defaults_h2['fontSize']['suffix']['mobile'];
		
		$h2_font_lineHeight_desktop = isset($h2_font['lineHeight']['desktop'])?$h2_font['lineHeight']['desktop']:$defaults_h2['lineHeight']['desktop'];
		$h2_font_lineHeight_tablet = isset($h2_font['lineHeight']['tablet'])?$h2_font['lineHeight']['tablet']:$defaults_h2['lineHeight']['tablet'];
		$h2_font_lineHeight_mobile = isset($h2_font['lineHeight']['mobile'])?$h2_font['lineHeight']['mobile']:$defaults_h2['lineHeight']['mobile'];
		$h2_font_lineHeight_suffix_desktop = isset($h2_font['lineHeight']['suffix']['desktop'])?$h2_font['lineHeight']['suffix']['desktop']:$defaults_h2['lineHeight']['suffix']['desktop'];
		$h2_font_lineHeight_suffix_tablet = isset($h2_font['lineHeight']['suffix']['tablet'])?$h2_font['lineHeight']['suffix']['tablet']:$defaults_h2['lineHeight']['suffix']['tablet'];
		$h2_font_lineHeight_suffix_mobile = isset($h2_font['lineHeight']['suffix']['mobile'])?$h2_font['lineHeight']['suffix']['mobile']:$defaults_h2['lineHeight']['suffix']['mobile'];

		$h2_font_letterSpacing_desktop = isset($h2_font['letterSpacing']['desktop'])?$h2_font['letterSpacing']['desktop']:'';
		$h2_font_letterSpacing_tablet = isset($h2_font['letterSpacing']['tablet'])?$h2_font['letterSpacing']['tablet']:'';
		$h2_font_letterSpacing_mobile = isset($h2_font['letterSpacing']['mobile'])?$h2_font['letterSpacing']['mobile']:'';

		$h2_font_weight = isset($h2_font['fontWeight'])?$h2_font['fontWeight']:$defaults_h2['fontWeight'];
		$h2_font_textTransform = isset($h2_font['textTransform'])?$h2_font['textTransform']:'';

		// H3
		$defaults_h3 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H3 );
		$h3_font = get_theme_mod('solace_h3_typeface_general');
		$h3_font_size_desktop = isset($h3_font['fontSize']['desktop'])?$h3_font['fontSize']['desktop']:$defaults_h3['fontSize']['desktop'];
		$h3_font_size_desktop_unit = isset($h3_font['fontSize']['suffix']['desktop'])?$h3_font['fontSize']['suffix']['desktop']:$defaults_h3['fontSize']['suffix']['desktop'];
		$h3_font_size_tablet = isset($h3_font['fontSize']['tablet'])?$h3_font['fontSize']['tablet']:$defaults_h3['fontSize']['tablet'];
		$h3_font_size_tablet_unit = isset($h3_font['fontSize']['suffix']['tablet'])?$h3_font['fontSize']['suffix']['tablet']:$defaults_h3['fontSize']['suffix']['tablet'];
		$h3_font_size_mobile = isset($h3_font['fontSize']['mobile'])?$h3_font['fontSize']['mobile']:$defaults_h3['fontSize']['mobile'];
		$h3_font_size_mobile_unit = isset($h3_font['fontSize']['suffix']['mobile'])?$h3_font['fontSize']['suffix']['mobile']:$defaults_h3['fontSize']['suffix']['mobile'];
		
		$h3_font_lineHeight_desktop = isset($h3_font['lineHeight']['desktop'])?$h3_font['lineHeight']['desktop']:$defaults_h3['lineHeight']['desktop'];
		$h3_font_lineHeight_tablet = isset($h3_font['lineHeight']['tablet'])?$h3_font['lineHeight']['tablet']:$defaults_h3['lineHeight']['tablet'];
		$h3_font_lineHeight_mobile = isset($h3_font['lineHeight']['mobile'])?$h3_font['lineHeight']['mobile']:$defaults_h3['lineHeight']['mobile'];
		$h3_font_lineHeight_suffix_desktop = isset($h3_font['lineHeight']['suffix']['desktop'])?$h3_font['lineHeight']['suffix']['desktop']:$defaults_h3['lineHeight']['suffix']['desktop'];
		$h3_font_lineHeight_suffix_tablet = isset($h3_font['lineHeight']['suffix']['tablet'])?$h3_font['lineHeight']['suffix']['tablet']:$defaults_h3['lineHeight']['suffix']['tablet'];
		$h3_font_lineHeight_suffix_mobile = isset($h3_font['lineHeight']['suffix']['mobile'])?$h3_font['lineHeight']['suffix']['mobile']:$defaults_h3['lineHeight']['suffix']['mobile'];

		$h3_font_letterSpacing_desktop = isset($h3_font['letterSpacing']['desktop'])?$h3_font['letterSpacing']['desktop']:'';
		$h3_font_letterSpacing_tablet = isset($h3_font['letterSpacing']['tablet'])?$h3_font['letterSpacing']['tablet']:'';
		$h3_font_letterSpacing_mobile = isset($h3_font['letterSpacing']['mobile'])?$h3_font['letterSpacing']['mobile']:'';

		$h3_font_weight = isset($h3_font['fontWeight'])?$h3_font['fontWeight']:$defaults_h3['fontWeight'];
		$h3_font_textTransform = isset($h3_font['textTransform'])?$h3_font['textTransform']:'';

		// H4
		$defaults_h4 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H4 );

		$h4_font = get_theme_mod('solace_h4_typeface_general');
		$h4_font_size_desktop = isset($h4_font['fontSize']['desktop'])?$h4_font['fontSize']['desktop']:$defaults_h4['fontSize']['desktop'];
		$h4_font_size_desktop_unit = isset($h4_font['fontSize']['suffix']['desktop'])?$h4_font['fontSize']['suffix']['desktop']:$defaults_h4['fontSize']['suffix']['desktop'];
		$h4_font_size_tablet = isset($h4_font['fontSize']['tablet'])?$h4_font['fontSize']['tablet']:$defaults_h4['fontSize']['tablet'];
		$h4_font_size_tablet_unit = isset($h4_font['fontSize']['suffix']['tablet'])?$h4_font['fontSize']['suffix']['tablet']:$defaults_h4['fontSize']['suffix']['tablet'];
		$h4_font_size_mobile = isset($h4_font['fontSize']['mobile'])?$h4_font['fontSize']['mobile']:$defaults_h4['fontSize']['mobile'];
		$h4_font_size_mobile_unit = isset($h4_font['fontSize']['suffix']['mobile'])?$h4_font['fontSize']['suffix']['mobile']:$defaults_h4['fontSize']['suffix']['mobile'];
		
		$h4_font_lineHeight_desktop = isset($h4_font['lineHeight']['desktop'])?$h4_font['lineHeight']['desktop']:$defaults_h4['lineHeight']['desktop'];
		$h4_font_lineHeight_tablet = isset($h4_font['lineHeight']['tablet'])?$h4_font['lineHeight']['tablet']:$defaults_h4['lineHeight']['tablet'];
		$h4_font_lineHeight_mobile = isset($h4_font['lineHeight']['mobile'])?$h4_font['lineHeight']['mobile']:$defaults_h4['lineHeight']['mobile'];
		$h4_font_lineHeight_suffix_desktop = isset($h4_font['lineHeight']['suffix']['desktop'])?$h4_font['lineHeight']['suffix']['desktop']:$defaults_h4['lineHeight']['suffix']['desktop'];
		$h4_font_lineHeight_suffix_tablet = isset($h4_font['lineHeight']['suffix']['tablet'])?$h4_font['lineHeight']['suffix']['tablet']:$defaults_h4['lineHeight']['suffix']['tablet'];
		$h4_font_lineHeight_suffix_mobile = isset($h4_font['lineHeight']['suffix']['mobile'])?$h4_font['lineHeight']['suffix']['mobile']:$defaults_h4['lineHeight']['suffix']['mobile'];

		$h4_font_letterSpacing_desktop = isset($h4_font['letterSpacing']['desktop'])?$h4_font['letterSpacing']['desktop']:'';
		$h4_font_letterSpacing_tablet = isset($h4_font['letterSpacing']['tablet'])?$h4_font['letterSpacing']['tablet']:'';
		$h4_font_letterSpacing_mobile = isset($h4_font['letterSpacing']['mobile'])?$h4_font['letterSpacing']['mobile']:'';

		$h4_font_weight = isset($h4_font['fontWeight'])?$h4_font['fontWeight']:$defaults_h4['fontWeight'];
		$h4_font_textTransform = isset($h4_font['textTransform'])?$h4_font['textTransform']:'';

		// H5
		$defaults_h5 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H5 );
		$h5_font = get_theme_mod('solace_h5_typeface_general');
		$h5_font_size_desktop = isset($h5_font['fontSize']['desktop'])?$h5_font['fontSize']['desktop']:$defaults_h5['fontSize']['desktop'];
		$h5_font_size_desktop_unit = isset($h5_font['fontSize']['suffix']['desktop'])?$h5_font['fontSize']['suffix']['desktop']:$defaults_h5['fontSize']['suffix']['desktop'];
		$h5_font_size_tablet = isset($h5_font['fontSize']['tablet'])?$h5_font['fontSize']['tablet']:$defaults_h5['fontSize']['tablet'];
		$h5_font_size_tablet_unit = isset($h5_font['fontSize']['suffix']['tablet'])?$h5_font['fontSize']['suffix']['tablet']:$defaults_h5['fontSize']['suffix']['tablet'];
		$h5_font_size_mobile = isset($h5_font['fontSize']['mobile'])?$h5_font['fontSize']['mobile']:$defaults_h5['fontSize']['mobile'];
		$h5_font_size_mobile_unit = isset($h5_font['fontSize']['suffix']['mobile'])?$h5_font['fontSize']['suffix']['mobile']:$defaults_h5['fontSize']['suffix']['mobile'];
		
		$h5_font_lineHeight_desktop = isset($h5_font['lineHeight']['desktop'])?$h5_font['lineHeight']['desktop']:$defaults_h5['lineHeight']['desktop'];
		$h5_font_lineHeight_tablet = isset($h5_font['lineHeight']['tablet'])?$h5_font['lineHeight']['tablet']:$defaults_h5['lineHeight']['tablet'];
		$h5_font_lineHeight_mobile = isset($h5_font['lineHeight']['mobile'])?$h5_font['lineHeight']['mobile']:$defaults_h5['lineHeight']['mobile'];
		$h5_font_lineHeight_suffix_desktop = isset($h5_font['lineHeight']['suffix']['desktop'])?$h5_font['lineHeight']['suffix']['desktop']:$defaults_h5['lineHeight']['suffix']['desktop'];
		$h5_font_lineHeight_suffix_tablet = isset($h5_font['lineHeight']['suffix']['tablet'])?$h5_font['lineHeight']['suffix']['tablet']:$defaults_h5['lineHeight']['suffix']['tablet'];
		$h5_font_lineHeight_suffix_mobile = isset($h5_font['lineHeight']['suffix']['mobile'])?$h5_font['lineHeight']['suffix']['mobile']:$defaults_h5['lineHeight']['suffix']['mobile'];

		$h5_font_letterSpacing_desktop = isset($h5_font['letterSpacing']['desktop'])?$h5_font['letterSpacing']['desktop']:'';
		$h5_font_letterSpacing_tablet = isset($h5_font['letterSpacing']['tablet'])?$h5_font['letterSpacing']['tablet']:'';
		$h5_font_letterSpacing_mobile = isset($h5_font['letterSpacing']['mobile'])?$h5_font['letterSpacing']['mobile']:'';

		$h5_font_weight = isset($h5_font['fontWeight'])?$h5_font['fontWeight']:$defaults_h5['fontWeight'];
		$h5_font_textTransform = isset($h5_font['textTransform'])?$h5_font['textTransform']:'';

		// H6
		$defaults_h6 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H6 );
		$h6_font = get_theme_mod('solace_h6_typeface_general');
		$h6_font_size_desktop = isset($h6_font['fontSize']['desktop'])?$h6_font['fontSize']['desktop']:$defaults_h6['fontSize']['desktop'];
		$h6_font_size_desktop_unit = isset($h6_font['fontSize']['suffix']['desktop'])?$h6_font['fontSize']['suffix']['desktop']:$defaults_h6['fontSize']['suffix']['desktop'];
		$h6_font_size_tablet = isset($h6_font['fontSize']['tablet'])?$h6_font['fontSize']['tablet']:$defaults_h6['fontSize']['tablet'];
		$h6_font_size_tablet_unit = isset($h6_font['fontSize']['suffix']['tablet'])?$h6_font['fontSize']['suffix']['tablet']:$defaults_h6['fontSize']['suffix']['tablet'];
		$h6_font_size_mobile = isset($h6_font['fontSize']['mobile'])?$h6_font['fontSize']['mobile']:$defaults_h6['fontSize']['mobile'];
		$h6_font_size_mobile_unit = isset($h6_font['fontSize']['suffix']['mobile'])?$h6_font['fontSize']['suffix']['mobile']:$defaults_h6['fontSize']['suffix']['mobile'];
		
		$h6_font_lineHeight_desktop = isset($h6_font['lineHeight']['desktop'])?$h6_font['lineHeight']['desktop']:$defaults_h6['lineHeight']['desktop'];
		$h6_font_lineHeight_tablet = isset($h6_font['lineHeight']['tablet'])?$h6_font['lineHeight']['tablet']:$defaults_h6['lineHeight']['tablet'];
		$h6_font_lineHeight_mobile = isset($h6_font['lineHeight']['mobile'])?$h6_font['lineHeight']['mobile']:$defaults_h6['lineHeight']['mobile'];
		$h6_font_lineHeight_suffix_desktop = isset($h6_font['lineHeight']['suffix']['desktop'])?$h6_font['lineHeight']['suffix']['desktop']:$defaults_h6['lineHeight']['suffix']['desktop'];
		$h6_font_lineHeight_suffix_tablet = isset($h6_font['lineHeight']['suffix']['tablet'])?$h6_font['lineHeight']['suffix']['tablet']:$defaults_h6['lineHeight']['suffix']['tablet'];
		$h6_font_lineHeight_suffix_mobile = isset($h6_font['lineHeight']['suffix']['mobile'])?$h6_font['lineHeight']['suffix']['mobile']:$defaults_h6['lineHeight']['suffix']['mobile'];

		$h6_font_letterSpacing_desktop = isset($h6_font['letterSpacing']['desktop'])?$h6_font['letterSpacing']['desktop']:'';
		$h6_font_letterSpacing_tablet = isset($h6_font['letterSpacing']['tablet'])?$h6_font['letterSpacing']['tablet']:'';
		$h6_font_letterSpacing_mobile = isset($h6_font['letterSpacing']['mobile'])?$h6_font['letterSpacing']['mobile']:'';

		$h6_font_weight = isset($h6_font['fontWeight'])?$h6_font['fontWeight']:$defaults_h6['fontWeight'];
		$h6_font_textTransform = isset($h6_font['textTransform'])?$h6_font['textTransform']:'';

		// $smaller_font = get_theme_mod('solace_smaller_typeface_general');
		
		$smaller_font = get_theme_mod('solace_typeface_smaller');
		$defaults_smaller = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_SMALLER );

		$smaller_font_size_desktop = isset($smaller_font['fontSize']['desktop'])?$smaller_font['fontSize']['desktop']:$defaults_smaller['fontSize']['desktop'];
		$smaller_font_size_desktop_unit = isset($smaller_font['fontSize']['suffix']['desktop'])?$smaller_font['fontSize']['suffix']['desktop']:$defaults_smaller['fontSize']['suffix']['desktop'];
		$smaller_font_size_tablet = isset($smaller_font['fontSize']['tablet'])?$smaller_font['fontSize']['tablet']:$defaults_smaller['fontSize']['tablet'];
		$smaller_font_size_tablet_unit = isset($smaller_font['fontSize']['suffix']['tablet'])?$smaller_font['fontSize']['suffix']['tablet']:$defaults_smaller['fontSize']['suffix']['tablet'];
		$smaller_font_size_mobile = isset($smaller_font['fontSize']['mobile'])?$smaller_font['fontSize']['mobile']:$defaults_smaller['fontSize']['mobile'];
		$smaller_font_size_mobile_unit = isset($smaller_font['fontSize']['suffix']['mobile'])?$smaller_font['fontSize']['suffix']['mobile']:$defaults_smaller['fontSize']['suffix']['mobile'];
		
		$smaller_font_lineHeight_desktop = isset($smaller_font['lineHeight']['desktop'])?$smaller_font['lineHeight']['desktop']:$defaults_smaller['lineHeight']['desktop'];
		$smaller_font_lineHeight_tablet = isset($smaller_font['lineHeight']['tablet'])?$smaller_font['lineHeight']['tablet']:$defaults_smaller['lineHeight']['tablet'];
		$smaller_font_lineHeight_mobile = isset($smaller_font['lineHeight']['mobile'])?$smaller_font['lineHeight']['mobile']:$defaults_smaller['lineHeight']['mobile'];
		$smaller_font_lineHeight_suffix_desktop = isset($smaller_font['lineHeight']['suffix']['desktop'])?$smaller_font['lineHeight']['suffix']['desktop']:$defaults_smaller['lineHeight']['suffix']['desktop'];
		$smaller_font_lineHeight_suffix_tablet = isset($smaller_font['lineHeight']['suffix']['tablet'])?$smaller_font['lineHeight']['suffix']['tablet']:$defaults_smaller['lineHeight']['suffix']['tablet'];
		$smaller_font_lineHeight_suffix_mobile = isset($smaller_font['lineHeight']['suffix']['mobile'])?$smaller_font['lineHeight']['suffix']['mobile']:$defaults_smaller['lineHeight']['suffix']['mobile'];

		$smaller_font_letterSpacing_desktop = isset($smaller_font['letterSpacing']['desktop'])?$smaller_font['letterSpacing']['desktop']:'';
		$smaller_font_letterSpacing_tablet = isset($smaller_font['letterSpacing']['tablet'])?$smaller_font['letterSpacing']['tablet']:'';
		$smaller_font_letterSpacing_mobile = isset($smaller_font['letterSpacing']['mobile'])?$smaller_font['letterSpacing']['mobile']:'';

		$smaller_font_weight = isset($smaller_font['fontWeight'])?$smaller_font['fontWeight']:$defaults_smaller['fontWeight'];
		$smaller_font_textTransform = isset($smaller_font['textTransform'])?$smaller_font['textTransform']:'';

		$logotitle_font = get_theme_mod('solace_typeface_logotitle');
		$defaults_logotitle = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_LOGOTITLE );

		$logotitle_font_size_desktop = isset($logotitle_font['fontSize']['desktop'])?$logotitle_font['fontSize']['desktop']:$defaults_logotitle['fontSize']['desktop'];
		$logotitle_font_size_desktop_unit = isset($logotitle_font['fontSize']['suffix']['desktop'])?$logotitle_font['fontSize']['suffix']['desktop']:$defaults_logotitle['fontSize']['suffix']['desktop'];
		$logotitle_font_size_tablet = isset($logotitle_font['fontSize']['tablet'])?$logotitle_font['fontSize']['tablet']:$defaults_logotitle['fontSize']['tablet'];
		$logotitle_font_size_tablet_unit = isset($logotitle_font['fontSize']['suffix']['tablet'])?$logotitle_font['fontSize']['suffix']['tablet']:$defaults_logotitle['fontSize']['suffix']['tablet'];
		$logotitle_font_size_mobile = isset($logotitle_font['fontSize']['mobile'])?$logotitle_font['fontSize']['mobile']:$defaults_logotitle['fontSize']['mobile'];
		$logotitle_font_size_mobile_unit = isset($logotitle_font['fontSize']['suffix']['mobile'])?$logotitle_font['fontSize']['suffix']['mobile']:$defaults_logotitle['fontSize']['suffix']['mobile'];
		
		$logotitle_font_lineHeight_desktop = isset($logotitle_font['lineHeight']['desktop'])?$logotitle_font['lineHeight']['desktop']:$defaults_logotitle['lineHeight']['desktop'];
		$logotitle_font_lineHeight_tablet = isset($logotitle_font['lineHeight']['tablet'])?$logotitle_font['lineHeight']['tablet']:$defaults_logotitle['lineHeight']['tablet'];
		$logotitle_font_lineHeight_mobile = isset($logotitle_font['lineHeight']['mobile'])?$logotitle_font['lineHeight']['mobile']:$defaults_logotitle['lineHeight']['mobile'];
		$logotitle_font_lineHeight_suffix_desktop = isset($logotitle_font['lineHeight']['suffix']['desktop'])?$logotitle_font['lineHeight']['suffix']['desktop']:$defaults_logotitle['lineHeight']['suffix']['desktop'];
		$logotitle_font_lineHeight_suffix_tablet = isset($logotitle_font['lineHeight']['suffix']['tablet'])?$logotitle_font['lineHeight']['suffix']['tablet']:$defaults_logotitle['lineHeight']['suffix']['tablet'];
		$logotitle_font_lineHeight_suffix_mobile = isset($logotitle_font['lineHeight']['suffix']['mobile'])?$logotitle_font['lineHeight']['suffix']['mobile']:$defaults_logotitle['lineHeight']['suffix']['mobile'];

		$logotitle_font_letterSpacing_desktop = isset($logotitle_font['letterSpacing']['desktop'])?$logotitle_font['letterSpacing']['desktop']:'';
		$logotitle_font_letterSpacing_tablet = isset($logotitle_font['letterSpacing']['tablet'])?$logotitle_font['letterSpacing']['tablet']:'';
		$logotitle_font_letterSpacing_mobile = isset($logotitle_font['letterSpacing']['mobile'])?$logotitle_font['letterSpacing']['mobile']:'';

		$logotitle_font_weight = isset($logotitle_font['fontWeight'])?$logotitle_font['fontWeight']:$defaults_logotitle['fontWeight'];
		$logotitle_font_textTransform = isset($logotitle_font['textTransform'])?$logotitle_font['textTransform']:'';

		$button_font = get_theme_mod('solace_typeface_button');
		$defaults_button = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_BUTTON );
		$button_font_size_desktop = isset($button_font['fontSize']['desktop'])?$button_font['fontSize']['desktop']:$defaults_button['fontSize']['desktop'];
		$button_font_size_desktop_unit = isset($button_font['fontSize']['suffix']['desktop'])?$button_font['fontSize']['suffix']['desktop']:$defaults_button['fontSize']['suffix']['desktop'];
		$button_font_size_tablet = isset($button_font['fontSize']['tablet'])?$button_font['fontSize']['tablet']:$defaults_button['fontSize']['tablet'];
		$button_font_size_tablet_unit = isset($button_font['fontSize']['suffix']['tablet'])?$button_font['fontSize']['suffix']['tablet']:$defaults_button['fontSize']['suffix']['tablet'];
		$button_font_size_mobile = isset($button_font['fontSize']['mobile'])?$button_font['fontSize']['mobile']:$defaults_button['fontSize']['mobile'];
		$button_font_size_mobile_unit = isset($button_font['fontSize']['suffix']['mobile'])?$button_font['fontSize']['suffix']['mobile']:$defaults_button['fontSize']['suffix']['mobile'];
		
		$button_font_lineHeight_desktop = isset($button_font['lineHeight']['desktop'])?$button_font['lineHeight']['desktop']:$defaults_button['lineHeight']['desktop'];
		$button_font_lineHeight_tablet = isset($button_font['lineHeight']['tablet'])?$button_font['lineHeight']['tablet']:$defaults_button['lineHeight']['tablet'];
		$button_font_lineHeight_mobile = isset($button_font['lineHeight']['mobile'])?$button_font['lineHeight']['mobile']:$defaults_button['lineHeight']['mobile'];
		$button_font_lineHeight_suffix_desktop = isset($button_font['lineHeight']['suffix']['desktop'])?$button_font['lineHeight']['suffix']['desktop']:$defaults_button['lineHeight']['suffix']['desktop'];
		$button_font_lineHeight_suffix_tablet = isset($button_font['lineHeight']['suffix']['tablet'])?$button_font['lineHeight']['suffix']['tablet']:$defaults_button['lineHeight']['suffix']['tablet'];
		$button_font_lineHeight_suffix_mobile = isset($button_font['lineHeight']['suffix']['mobile'])?$button_font['lineHeight']['suffix']['mobile']:$defaults_button['lineHeight']['suffix']['mobile'];

		$button_font_letterSpacing_desktop = isset($button_font['letterSpacing']['desktop'])?$button_font['letterSpacing']['desktop']:'';
		$button_font_letterSpacing_tablet = isset($button_font['letterSpacing']['tablet'])?$button_font['letterSpacing']['tablet']:'';
		$button_font_letterSpacing_mobile = isset($button_font['letterSpacing']['mobile'])?$button_font['letterSpacing']['mobile']:'';

		$button_font_weight = isset($button_font['fontWeight'])?$button_font['fontWeight']:$defaults_button['fontWeight'];
		$button_font_textTransform = isset($button_font['textTransform'])?$button_font['textTransform']:'';


		$custom_typography = [
			[
				'_id' => 'primary',
				'title' => 'Smaller',
				'typography_typography' => 'custom',
				'typography_font_family' => $primary,
				'typography_font_size' => [
					'unit' => $smaller_font_size_desktop_unit,
					'size' => isset($smaller_font_size_desktop)?$smaller_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $smaller_font_weight,
				'typography_text_transform' => $smaller_font_textTransform,
				'typography_line_height' => [
					'unit' => $smaller_font_lineHeight_suffix_desktop,
					'size' => $smaller_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $smaller_font_size_tablet_unit,
					'size' => $smaller_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $smaller_font_size_mobile_unit,
					'size' => $smaller_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $smaller_font_lineHeight_suffix_tablet,
					'size' => $smaller_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $smaller_font_lineHeight_suffix_mobile,
					'size' => $smaller_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'secondary',
				'title' => 'Logo Title / Subtitle',
				'typography_typography' => 'custom',
				'typography_font_family' => $secondary,
				'typography_font_size' => [
					'unit' => $logotitle_font_size_desktop_unit,
					'size' => isset($logotitle_font_size_desktop)?$logotitle_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $logotitle_font_weight,
				'typography_text_transform' => $logotitle_font_textTransform,
				'typography_line_height' => [
					'unit' => $logotitle_font_lineHeight_suffix_desktop,
					'size' => $logotitle_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $logotitle_font_size_tablet_unit,
					'size' => $logotitle_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $logotitle_font_size_mobile_unit,
					'size' => $logotitle_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $logotitle_font_lineHeight_suffix_tablet,
					'size' => $logotitle_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $logotitle_font_lineHeight_suffix_mobile,
					'size' => $logotitle_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'text',
				'title' => 'Solace Base',
				'typography_typography' => 'custom',
				'typography_font_family' => $text,
				'typography_font_size' => [
					'unit' => $base_font_size_desktop_unit,
					'size' => $base_font_size_desktop,
					'sizes' => []
				],
				'typography_font_weight' => $base_font_weight,
				'typography_text_transform' => $base_font_textTransform,
				'typography_line_height' => [
					'unit' => $base_font_lineHeight_suffix_desktop,
					'size' => $base_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $base_font_size_tablet_unit,
					'size' => $base_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $base_font_size_mobile_unit,
					'size' => $base_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $base_font_lineHeight_suffix_tablet,
					'size' => $base_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $base_font_lineHeight_suffix_mobile,
					'size' => $base_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'accent',
				'title' => 'Button',
				'typography_typography' => 'custom',
				'typography_font_family' => $accent,
				'typography_font_size' => [
					'unit' => $button_font_size_desktop_unit,
					'size' => isset($button_font_size_desktop)?$button_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $button_font_weight,
				'typography_text_transform' => $button_font_textTransform,
				'typography_line_height' => [
					'unit' => $button_font_lineHeight_suffix_desktop,
					'size' => $button_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $button_font_size_tablet_unit,
					'size' => $button_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $button_font_size_mobile_unit,
					'size' => $button_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $button_font_lineHeight_suffix_tablet,
					'size' => $button_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $button_font_lineHeight_suffix_mobile,
					'size' => $button_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_body_font_family',
				'title' => 'Solace Base',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_base_font,
				'typography_font_size' => [
					'unit' => $base_font_size_desktop_unit,
					'size' => $base_font_size_desktop,
					'sizes' => []
				],
				'typography_font_weight' => $base_font_weight,
				'typography_text_transform' => $base_font_textTransform,
				'typography_line_height' => [
					'unit' => $base_font_lineHeight_suffix_desktop,
					'size' => $base_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $base_font_size_tablet_unit,
					'size' => $base_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $base_font_size_mobile_unit,
					'size' => $base_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $base_font_lineHeight_suffix_tablet,
					'size' => $base_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $base_font_lineHeight_suffix_mobile,
					'size' => $base_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h1_font_family_general',
				'title' => 'Solace H1',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h1_font_family_general,
				'typography_font_size' => [
				'unit' => $h1_font_size_desktop_unit,
					'size' => isset($h1_font_size_desktop)?$h1_font_size_desktop:'68',
					'sizes' => []
				],
				'typography_font_weight' => $h1_font_weight,
				'typography_text_transform' => $h1_font_textTransform,
				'typography_line_height' => [
					'unit' => $h1_font_lineHeight_suffix_desktop,
					'size' => $h1_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h1_font_size_tablet_unit,
					'size' => $h1_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h1_font_size_mobile_unit,
					'size' => $h1_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h1_font_lineHeight_suffix_tablet,
					'size' => $h1_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h1_font_lineHeight_suffix_mobile,
					'size' => $h1_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h2_font_family_general',
				'title' => 'Solace H2',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h2_font_family_general,
				'typography_font_size' => [
				'unit' => $h2_font_size_desktop_unit,
					'size' => isset($h2_font_size_desktop)?$h2_font_size_desktop:'50',
					'sizes' => []
				],
				'typography_font_weight' => $h2_font_weight,
				'typography_text_transform' => $h2_font_textTransform,
				'typography_line_height' => [
					'unit' => $h2_font_lineHeight_suffix_desktop,
					'size' => $h2_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h2_font_size_tablet_unit,
					'size' => $h2_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h2_font_size_mobile_unit,
					'size' => $h2_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h2_font_lineHeight_suffix_tablet,
					'size' => $h2_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h2_font_lineHeight_suffix_mobile,
					'size' => $h2_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h3_font_family_general',
				'title' => 'Solace H3',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h3_font_family_general,
				'typography_font_size' => [
				'unit' => $h3_font_size_desktop_unit,
					'size' => isset($h3_font_size_desktop)?$h3_font_size_desktop:'38',
					'sizes' => []
				],
				'typography_font_weight' => $h3_font_weight,
				'typography_text_transform' => $h3_font_textTransform,
				'typography_line_height' => [
					'unit' => $h3_font_lineHeight_suffix_desktop,
					'size' => $h3_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h3_font_size_tablet_unit,
					'size' => $h3_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h3_font_size_mobile_unit,
					'size' => $h3_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h3_font_lineHeight_suffix_tablet,
					'size' => $h3_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h3_font_lineHeight_suffix_mobile,
					'size' => $h3_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h4_font_family_general',
				'title' => 'Solace H4',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h4_font_family_general,
				'typography_font_size' => [
				'unit' => $h4_font_size_desktop_unit,
					'size' => isset($h4_font_size_desktop)?$h4_font_size_desktop:'28',
					'sizes' => []
				],
				'typography_font_weight' => $h4_font_weight,
				'typography_text_transform' => $h4_font_textTransform,
				'typography_line_height' => [
					'unit' => $h4_font_lineHeight_suffix_desktop,
					'size' => $h4_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h4_font_size_tablet_unit,
					'size' => $h4_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h4_font_size_mobile_unit,
					'size' => $h4_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h4_font_lineHeight_suffix_tablet,
					'size' => $h4_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h4_font_lineHeight_suffix_mobile,
					'size' => $h4_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h5_font_family_general',
				'title' => 'Solace H5',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h5_font_family_general,
				'typography_font_size' => [
				'unit' => $h5_font_size_desktop_unit,
					'size' => isset($h5_font_size_desktop)?$h5_font_size_desktop:'21',
					'sizes' => []
				],
				'typography_font_weight' => $h5_font_weight,
				'typography_text_transform' => $h5_font_textTransform,
				'typography_line_height' => [
					'unit' => $h5_font_lineHeight_suffix_desktop,
					'size' => $h5_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h5_font_size_tablet_unit,
					'size' => $h5_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h5_font_size_mobile_unit,
					'size' => $h5_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h5_font_lineHeight_suffix_tablet,
					'size' => $h5_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h5_font_lineHeight_suffix_mobile,
					'size' => $h5_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h6_font_family_general',
				'title' => 'Solace H6',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h6_font_family_general,
				'typography_font_size' => [
				'unit' => $h6_font_size_desktop_unit,
					'size' => isset($h6_font_size_desktop)?$h6_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $h6_font_weight,
				'typography_text_transform' => $h6_font_textTransform,
				'typography_line_height' => [
					'unit' => $h6_font_lineHeight_suffix_desktop,
					'size' => $h6_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h6_font_size_tablet_unit,
					'size' => $h6_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h6_font_size_mobile_unit,
					'size' => $h6_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h6_font_lineHeight_suffix_tablet,
					'size' => $h6_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h6_font_lineHeight_suffix_mobile,
					'size' => $h6_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_smaller_font_family',
				'title' => 'Smaller',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_smaller_font_family,
				'typography_font_size' => [
				'unit' => $smaller_font_size_desktop_unit,
					'size' => isset($smaller_font_size_desktop)?$smaller_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $smaller_font_weight,
				'typography_text_transform' => $smaller_font_textTransform,
				'typography_line_height' => [
					'unit' => $smaller_font_lineHeight_suffix_desktop,
					'size' => $smaller_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $smaller_font_size_tablet_unit,
					'size' => $smaller_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $smaller_font_size_mobile_unit,
					'size' => $smaller_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $smaller_font_lineHeight_suffix_tablet,
					'size' => $smaller_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $smaller_font_lineHeight_suffix_mobile,
					'size' => $smaller_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_logotitle_font_family',
				'title' => 'Logo Title / Subtitle',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_logotitle_font_family,
				'typography_font_size' => [
				'unit' => $logotitle_font_size_desktop_unit,
					'size' => isset($logotitle_font_size_desktop)?$logotitle_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $logotitle_font_weight,
				'typography_text_transform' => $logotitle_font_textTransform,
				'typography_line_height' => [
					'unit' => $logotitle_font_lineHeight_suffix_desktop,
					'size' => $logotitle_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $logotitle_font_size_tablet_unit,
					'size' => $logotitle_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $logotitle_font_size_mobile_unit,
					'size' => $logotitle_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $logotitle_font_lineHeight_suffix_tablet,
					'size' => $logotitle_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $logotitle_font_lineHeight_suffix_mobile,
					'size' => $logotitle_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_button_font_family',
				'title' => 'Button',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_button_font_family,
				'typography_font_size' => [
				'unit' => $button_font_size_desktop_unit,
					'size' => isset($button_font_size_desktop)?$button_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $button_font_weight,
				'typography_text_transform' => $button_font_textTransform,
				'typography_line_height' => [
					'unit' => $button_font_lineHeight_suffix_desktop,
					'size' => $button_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $button_font_size_tablet_unit,
					'size' => $button_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $button_font_size_mobile_unit,
					'size' => $button_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $button_font_lineHeight_suffix_tablet,
					'size' => $button_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $button_font_lineHeight_suffix_mobile,
					'size' => $button_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_mobile,
					'sizes' => []
				]
			]
		];

		if (class_exists('Elementor\Plugin')) {
			\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_typography', $custom_typography );		
		}
	}
}

function solace_font_save_customizer_settings() {
    if (is_customize_preview()) {
		$solace_base_font 			   = get_theme_mod('solace_body_font_family','DM Sans' );
		$solace_h1_font_family_general = get_theme_mod('solace_h1_font_family_general','DM Sans' );
		$solace_h2_font_family_general = get_theme_mod('solace_h2_font_family_general','DM Sans' );
		$solace_h3_font_family_general = get_theme_mod('solace_h3_font_family_general','DM Sans' );
		$solace_h4_font_family_general = get_theme_mod('solace_h4_font_family_general','DM Sans' );
		$solace_h5_font_family_general = get_theme_mod('solace_h5_font_family_general','DM Sans' );
		$solace_h6_font_family_general = get_theme_mod('solace_h6_font_family_general','DM Sans' );

		$solace_smaller_font_family = get_theme_mod('solace_smaller_font_family','DM Sans' );
		$solace_logotitle_font_family = get_theme_mod('solace_logotitle_font_family','DM Sans' );
		$solace_button_font_family = get_theme_mod('solace_button_font_family','DM Sans' );

		$primary = $solace_smaller_font_family;
		$secondary = $solace_logotitle_font_family;
		$text = $solace_base_font;
		$accent = $solace_button_font_family;

		// BASE FONT
		$defaults_base = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL );
		$base_font = get_theme_mod('solace_typeface_general');
		$base_font_size_desktop = isset($base_font['fontSize']['desktop'])?$base_font['fontSize']['desktop']:$defaults_base['fontSize']['desktop'];
		$base_font_size_tablet = isset($base_font['fontSize']['tablet'])?$base_font['fontSize']['tablet']:$defaults_base['fontSize']['tablet'];
		$base_font_size_mobile = isset($base_font['fontSize']['mobile'])?$base_font['fontSize']['mobile']:$defaults_base['fontSize']['mobile'];

		$base_font_size_desktop_unit = isset($base_font['fontSize']['suffix']['desktop'])?$base_font['fontSize']['suffix']['desktop']:$defaults_base['fontSize']['suffix']['desktop'];
		$base_font_size_tablet_unit = isset($base_font['fontSize']['suffix']['tablet'])?$base_font['fontSize']['suffix']['tablet']:$defaults_base['fontSize']['suffix']['tablet'];
		$base_font_size_mobile_unit = isset($base_font['fontSize']['suffix']['mobile'])?$base_font['fontSize']['suffix']['mobile']:$defaults_base['fontSize']['suffix']['mobile'];

		$base_font_lineHeight_desktop = isset($base_font['lineHeight']['desktop'])?$base_font['lineHeight']['desktop']:$defaults_base['lineHeight']['desktop'];
		$base_font_lineHeight_tablet = isset($base_font['lineHeight']['tablet'])?$base_font['lineHeight']['tablet']:$defaults_base['lineHeight']['tablet'];
		$base_font_lineHeight_mobile = isset($base_font['lineHeight']['mobile'])?$base_font['lineHeight']['mobile']:$defaults_base['lineHeight']['mobile'];
		$base_font_lineHeight_suffix_desktop = isset($base_font['lineHeight']['suffix']['desktop'])?$base_font['lineHeight']['suffix']['desktop']:$defaults_base['lineHeight']['suffix']['desktop'];
		$base_font_lineHeight_suffix_tablet = isset($base_font['lineHeight']['suffix']['tablet'])?$base_font['lineHeight']['suffix']['tablet']:$defaults_base['lineHeight']['suffix']['tablet'];
		$base_font_lineHeight_suffix_mobile = isset($base_font['lineHeight']['suffix']['mobile'])?$base_font['lineHeight']['suffix']['mobile']:$defaults_base['lineHeight']['suffix']['mobile'];

		$base_font_letterSpacing_desktop = isset($base_font['letterSpacing']['desktop'])?$base_font['letterSpacing']['desktop']:'';
		$base_font_letterSpacing_tablet = isset($base_font['letterSpacing']['tablet'])?$base_font['letterSpacing']['tablet']:'';
		$base_font_letterSpacing_mobile = isset($base_font['letterSpacing']['mobile'])?$base_font['letterSpacing']['mobile']:'';

		$base_font_weight = isset($base_font['fontWeight'])?$base_font['fontWeight']:$defaults_base['fontWeight'];
		$base_font_textTransform = isset($base_font['textTransform'])?$base_font['textTransform']:$defaults_base['textTransform'];
		// END OF BASE FONT

		// H1
		$defaults_h1 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H1 );
		$h1_font = get_theme_mod('solace_h1_typeface_general');
		$h1_font_size_desktop = isset($h1_font['fontSize']['desktop'])?$h1_font['fontSize']['desktop']:$defaults_h1['fontSize']['desktop'];
		$h1_font_size_desktop_unit = isset($h1_font['fontSize']['suffix']['desktop'])?$h1_font['fontSize']['suffix']['desktop']:$defaults_h1['fontSize']['suffix']['desktop'];
		$h1_font_size_tablet = isset($h1_font['fontSize']['tablet'])?$h1_font['fontSize']['tablet']:$defaults_h1['fontSize']['tablet'];
		$h1_font_size_tablet_unit = isset($h1_font['fontSize']['suffix']['tablet'])?$h1_font['fontSize']['suffix']['tablet']:$defaults_h1['fontSize']['suffix']['tablet'];
		$h1_font_size_mobile = isset($h1_font['fontSize']['mobile'])?$h1_font['fontSize']['mobile']:$defaults_h1['fontSize']['mobile'];
		$h1_font_size_mobile_unit = isset($h1_font['fontSize']['suffix']['mobile'])?$h1_font['fontSize']['suffix']['mobile']:$defaults_h1['fontSize']['suffix']['mobile'];
		
		$h1_font_lineHeight_desktop = isset($h1_font['lineHeight']['desktop'])?$h1_font['lineHeight']['desktop']:$defaults_h1['lineHeight']['desktop'];
		$h1_font_lineHeight_tablet = isset($h1_font['lineHeight']['tablet'])?$h1_font['lineHeight']['tablet']:$defaults_h1['lineHeight']['tablet'];
		$h1_font_lineHeight_mobile = isset($h1_font['lineHeight']['mobile'])?$h1_font['lineHeight']['mobile']:$defaults_h1['lineHeight']['mobile'];
		$h1_font_lineHeight_suffix_desktop = isset($h1_font['lineHeight']['suffix']['desktop'])?$h1_font['lineHeight']['suffix']['desktop']:$defaults_h1['lineHeight']['suffix']['desktop'];
		$h1_font_lineHeight_suffix_tablet = isset($h1_font['lineHeight']['suffix']['tablet'])?$h1_font['lineHeight']['suffix']['tablet']:$defaults_h1['lineHeight']['suffix']['tablet'];
		$h1_font_lineHeight_suffix_mobile = isset($h1_font['lineHeight']['suffix']['mobile'])?$h1_font['lineHeight']['suffix']['mobile']:$defaults_h1['lineHeight']['suffix']['mobile'];

		$h1_font_letterSpacing_desktop = isset($h1_font['letterSpacing']['desktop'])?$h1_font['letterSpacing']['desktop']:'';
		$h1_font_letterSpacing_tablet = isset($h1_font['letterSpacing']['tablet'])?$h1_font['letterSpacing']['tablet']:'';
		$h1_font_letterSpacing_mobile = isset($h1_font['letterSpacing']['mobile'])?$h1_font['letterSpacing']['mobile']:'';

		$h1_font_weight = isset($h1_font['fontWeight'])?$h1_font['fontWeight']:$defaults_h1['fontWeight'];
		$h1_font_textTransform = isset($h1_font['textTransform'])?$h1_font['textTransform']:'';

		// H2
		$defaults_h2 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H2 );
		$h2_font = get_theme_mod('solace_h2_typeface_general');
		$h2_font_size_desktop = isset($h2_font['fontSize']['desktop'])?$h2_font['fontSize']['desktop']:$defaults_h2['fontSize']['desktop'];
		$h2_font_size_desktop_unit = isset($h2_font['fontSize']['suffix']['desktop'])?$h2_font['fontSize']['suffix']['desktop']:$defaults_h2['fontSize']['suffix']['desktop'];
		$h2_font_size_tablet = isset($h2_font['fontSize']['tablet'])?$h2_font['fontSize']['tablet']:$defaults_h2['fontSize']['tablet'];
		$h2_font_size_tablet_unit = isset($h2_font['fontSize']['suffix']['tablet'])?$h2_font['fontSize']['suffix']['tablet']:$defaults_h2['fontSize']['suffix']['tablet'];
		$h2_font_size_mobile = isset($h2_font['fontSize']['mobile'])?$h2_font['fontSize']['mobile']:$defaults_h2['fontSize']['mobile'];
		$h2_font_size_mobile_unit = isset($h2_font['fontSize']['suffix']['mobile'])?$h2_font['fontSize']['suffix']['mobile']:$defaults_h2['fontSize']['suffix']['mobile'];
		
		$h2_font_lineHeight_desktop = isset($h2_font['lineHeight']['desktop'])?$h2_font['lineHeight']['desktop']:$defaults_h2['lineHeight']['desktop'];
		$h2_font_lineHeight_tablet = isset($h2_font['lineHeight']['tablet'])?$h2_font['lineHeight']['tablet']:$defaults_h2['lineHeight']['tablet'];
		$h2_font_lineHeight_mobile = isset($h2_font['lineHeight']['mobile'])?$h2_font['lineHeight']['mobile']:$defaults_h2['lineHeight']['mobile'];
		$h2_font_lineHeight_suffix_desktop = isset($h2_font['lineHeight']['suffix']['desktop'])?$h2_font['lineHeight']['suffix']['desktop']:$defaults_h2['lineHeight']['suffix']['desktop'];
		$h2_font_lineHeight_suffix_tablet = isset($h2_font['lineHeight']['suffix']['tablet'])?$h2_font['lineHeight']['suffix']['tablet']:$defaults_h2['lineHeight']['suffix']['tablet'];
		$h2_font_lineHeight_suffix_mobile = isset($h2_font['lineHeight']['suffix']['mobile'])?$h2_font['lineHeight']['suffix']['mobile']:$defaults_h2['lineHeight']['suffix']['mobile'];

		$h2_font_letterSpacing_desktop = isset($h2_font['letterSpacing']['desktop'])?$h2_font['letterSpacing']['desktop']:'';
		$h2_font_letterSpacing_tablet = isset($h2_font['letterSpacing']['tablet'])?$h2_font['letterSpacing']['tablet']:'';
		$h2_font_letterSpacing_mobile = isset($h2_font['letterSpacing']['mobile'])?$h2_font['letterSpacing']['mobile']:'';

		$h2_font_weight = isset($h2_font['fontWeight'])?$h2_font['fontWeight']:$defaults_h2['fontWeight'];
		$h2_font_textTransform = isset($h2_font['textTransform'])?$h2_font['textTransform']:'';

		// H3
		$defaults_h3 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H3 );
		$h3_font = get_theme_mod('solace_h3_typeface_general');
		$h3_font_size_desktop = isset($h3_font['fontSize']['desktop'])?$h3_font['fontSize']['desktop']:$defaults_h3['fontSize']['desktop'];
		$h3_font_size_desktop_unit = isset($h3_font['fontSize']['suffix']['desktop'])?$h3_font['fontSize']['suffix']['desktop']:$defaults_h3['fontSize']['suffix']['desktop'];
		$h3_font_size_tablet = isset($h3_font['fontSize']['tablet'])?$h3_font['fontSize']['tablet']:$defaults_h3['fontSize']['tablet'];
		$h3_font_size_tablet_unit = isset($h3_font['fontSize']['suffix']['tablet'])?$h3_font['fontSize']['suffix']['tablet']:$defaults_h3['fontSize']['suffix']['tablet'];
		$h3_font_size_mobile = isset($h3_font['fontSize']['mobile'])?$h3_font['fontSize']['mobile']:$defaults_h3['fontSize']['mobile'];
		$h3_font_size_mobile_unit = isset($h3_font['fontSize']['suffix']['mobile'])?$h3_font['fontSize']['suffix']['mobile']:$defaults_h3['fontSize']['suffix']['mobile'];
		
		$h3_font_lineHeight_desktop = isset($h3_font['lineHeight']['desktop'])?$h3_font['lineHeight']['desktop']:$defaults_h3['lineHeight']['desktop'];
		$h3_font_lineHeight_tablet = isset($h3_font['lineHeight']['tablet'])?$h3_font['lineHeight']['tablet']:$defaults_h3['lineHeight']['tablet'];
		$h3_font_lineHeight_mobile = isset($h3_font['lineHeight']['mobile'])?$h3_font['lineHeight']['mobile']:$defaults_h3['lineHeight']['mobile'];
		$h3_font_lineHeight_suffix_desktop = isset($h3_font['lineHeight']['suffix']['desktop'])?$h3_font['lineHeight']['suffix']['desktop']:$defaults_h3['lineHeight']['suffix']['desktop'];
		$h3_font_lineHeight_suffix_tablet = isset($h3_font['lineHeight']['suffix']['tablet'])?$h3_font['lineHeight']['suffix']['tablet']:$defaults_h3['lineHeight']['suffix']['tablet'];
		$h3_font_lineHeight_suffix_mobile = isset($h3_font['lineHeight']['suffix']['mobile'])?$h3_font['lineHeight']['suffix']['mobile']:$defaults_h3['lineHeight']['suffix']['mobile'];

		$h3_font_letterSpacing_desktop = isset($h3_font['letterSpacing']['desktop'])?$h3_font['letterSpacing']['desktop']:'';
		$h3_font_letterSpacing_tablet = isset($h3_font['letterSpacing']['tablet'])?$h3_font['letterSpacing']['tablet']:'';
		$h3_font_letterSpacing_mobile = isset($h3_font['letterSpacing']['mobile'])?$h3_font['letterSpacing']['mobile']:'';

		$h3_font_weight = isset($h3_font['fontWeight'])?$h3_font['fontWeight']:$defaults_h3['fontWeight'];
		$h3_font_textTransform = isset($h3_font['textTransform'])?$h3_font['textTransform']:'';

		// H4
		$defaults_h4 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H4 );

		$h4_font = get_theme_mod('solace_h4_typeface_general');
		$h4_font_size_desktop = isset($h4_font['fontSize']['desktop'])?$h4_font['fontSize']['desktop']:$defaults_h4['fontSize']['desktop'];
		$h4_font_size_desktop_unit = isset($h4_font['fontSize']['suffix']['desktop'])?$h4_font['fontSize']['suffix']['desktop']:$defaults_h4['fontSize']['suffix']['desktop'];
		$h4_font_size_tablet = isset($h4_font['fontSize']['tablet'])?$h4_font['fontSize']['tablet']:$defaults_h4['fontSize']['tablet'];
		$h4_font_size_tablet_unit = isset($h4_font['fontSize']['suffix']['tablet'])?$h4_font['fontSize']['suffix']['tablet']:$defaults_h4['fontSize']['suffix']['tablet'];
		$h4_font_size_mobile = isset($h4_font['fontSize']['mobile'])?$h4_font['fontSize']['mobile']:$defaults_h4['fontSize']['mobile'];
		$h4_font_size_mobile_unit = isset($h4_font['fontSize']['suffix']['mobile'])?$h4_font['fontSize']['suffix']['mobile']:$defaults_h4['fontSize']['suffix']['mobile'];
		
		$h4_font_lineHeight_desktop = isset($h4_font['lineHeight']['desktop'])?$h4_font['lineHeight']['desktop']:$defaults_h4['lineHeight']['desktop'];
		$h4_font_lineHeight_tablet = isset($h4_font['lineHeight']['tablet'])?$h4_font['lineHeight']['tablet']:$defaults_h4['lineHeight']['tablet'];
		$h4_font_lineHeight_mobile = isset($h4_font['lineHeight']['mobile'])?$h4_font['lineHeight']['mobile']:$defaults_h4['lineHeight']['mobile'];
		$h4_font_lineHeight_suffix_desktop = isset($h4_font['lineHeight']['suffix']['desktop'])?$h4_font['lineHeight']['suffix']['desktop']:$defaults_h4['lineHeight']['suffix']['desktop'];
		$h4_font_lineHeight_suffix_tablet = isset($h4_font['lineHeight']['suffix']['tablet'])?$h4_font['lineHeight']['suffix']['tablet']:$defaults_h4['lineHeight']['suffix']['tablet'];
		$h4_font_lineHeight_suffix_mobile = isset($h4_font['lineHeight']['suffix']['mobile'])?$h4_font['lineHeight']['suffix']['mobile']:$defaults_h4['lineHeight']['suffix']['mobile'];

		$h4_font_letterSpacing_desktop = isset($h4_font['letterSpacing']['desktop'])?$h4_font['letterSpacing']['desktop']:'';
		$h4_font_letterSpacing_tablet = isset($h4_font['letterSpacing']['tablet'])?$h4_font['letterSpacing']['tablet']:'';
		$h4_font_letterSpacing_mobile = isset($h4_font['letterSpacing']['mobile'])?$h4_font['letterSpacing']['mobile']:'';

		$h4_font_weight = isset($h4_font['fontWeight'])?$h4_font['fontWeight']:$defaults_h4['fontWeight'];
		$h4_font_textTransform = isset($h4_font['textTransform'])?$h4_font['textTransform']:'';

		// H5
		$defaults_h5 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H5 );
		$h5_font = get_theme_mod('solace_h5_typeface_general');
		$h5_font_size_desktop = isset($h5_font['fontSize']['desktop'])?$h5_font['fontSize']['desktop']:$defaults_h5['fontSize']['desktop'];
		$h5_font_size_desktop_unit = isset($h5_font['fontSize']['suffix']['desktop'])?$h5_font['fontSize']['suffix']['desktop']:$defaults_h5['fontSize']['suffix']['desktop'];
		$h5_font_size_tablet = isset($h5_font['fontSize']['tablet'])?$h5_font['fontSize']['tablet']:$defaults_h5['fontSize']['tablet'];
		$h5_font_size_tablet_unit = isset($h5_font['fontSize']['suffix']['tablet'])?$h5_font['fontSize']['suffix']['tablet']:$defaults_h5['fontSize']['suffix']['tablet'];
		$h5_font_size_mobile = isset($h5_font['fontSize']['mobile'])?$h5_font['fontSize']['mobile']:$defaults_h5['fontSize']['mobile'];
		$h5_font_size_mobile_unit = isset($h5_font['fontSize']['suffix']['mobile'])?$h5_font['fontSize']['suffix']['mobile']:$defaults_h5['fontSize']['suffix']['mobile'];
		
		$h5_font_lineHeight_desktop = isset($h5_font['lineHeight']['desktop'])?$h5_font['lineHeight']['desktop']:$defaults_h5['lineHeight']['desktop'];
		$h5_font_lineHeight_tablet = isset($h5_font['lineHeight']['tablet'])?$h5_font['lineHeight']['tablet']:$defaults_h5['lineHeight']['tablet'];
		$h5_font_lineHeight_mobile = isset($h5_font['lineHeight']['mobile'])?$h5_font['lineHeight']['mobile']:$defaults_h5['lineHeight']['mobile'];
		$h5_font_lineHeight_suffix_desktop = isset($h5_font['lineHeight']['suffix']['desktop'])?$h5_font['lineHeight']['suffix']['desktop']:$defaults_h5['lineHeight']['suffix']['desktop'];
		$h5_font_lineHeight_suffix_tablet = isset($h5_font['lineHeight']['suffix']['tablet'])?$h5_font['lineHeight']['suffix']['tablet']:$defaults_h5['lineHeight']['suffix']['tablet'];
		$h5_font_lineHeight_suffix_mobile = isset($h5_font['lineHeight']['suffix']['mobile'])?$h5_font['lineHeight']['suffix']['mobile']:$defaults_h5['lineHeight']['suffix']['mobile'];

		$h5_font_letterSpacing_desktop = isset($h5_font['letterSpacing']['desktop'])?$h5_font['letterSpacing']['desktop']:'';
		$h5_font_letterSpacing_tablet = isset($h5_font['letterSpacing']['tablet'])?$h5_font['letterSpacing']['tablet']:'';
		$h5_font_letterSpacing_mobile = isset($h5_font['letterSpacing']['mobile'])?$h5_font['letterSpacing']['mobile']:'';

		$h5_font_weight = isset($h5_font['fontWeight'])?$h5_font['fontWeight']:$defaults_h5['fontWeight'];
		$h5_font_textTransform = isset($h5_font['textTransform'])?$h5_font['textTransform']:'';

		// H6
		$defaults_h6 = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_H6 );
		$h6_font = get_theme_mod('solace_h6_typeface_general');
		$h6_font_size_desktop = isset($h6_font['fontSize']['desktop'])?$h6_font['fontSize']['desktop']:$defaults_h6['fontSize']['desktop'];
		$h6_font_size_desktop_unit = isset($h6_font['fontSize']['suffix']['desktop'])?$h6_font['fontSize']['suffix']['desktop']:$defaults_h6['fontSize']['suffix']['desktop'];
		$h6_font_size_tablet = isset($h6_font['fontSize']['tablet'])?$h6_font['fontSize']['tablet']:$defaults_h6['fontSize']['tablet'];
		$h6_font_size_tablet_unit = isset($h6_font['fontSize']['suffix']['tablet'])?$h6_font['fontSize']['suffix']['tablet']:$defaults_h6['fontSize']['suffix']['tablet'];
		$h6_font_size_mobile = isset($h6_font['fontSize']['mobile'])?$h6_font['fontSize']['mobile']:$defaults_h6['fontSize']['mobile'];
		$h6_font_size_mobile_unit = isset($h6_font['fontSize']['suffix']['mobile'])?$h6_font['fontSize']['suffix']['mobile']:$defaults_h6['fontSize']['suffix']['mobile'];
		
		$h6_font_lineHeight_desktop = isset($h6_font['lineHeight']['desktop'])?$h6_font['lineHeight']['desktop']:$defaults_h6['lineHeight']['desktop'];
		$h6_font_lineHeight_tablet = isset($h6_font['lineHeight']['tablet'])?$h6_font['lineHeight']['tablet']:$defaults_h6['lineHeight']['tablet'];
		$h6_font_lineHeight_mobile = isset($h6_font['lineHeight']['mobile'])?$h6_font['lineHeight']['mobile']:$defaults_h6['lineHeight']['mobile'];
		$h6_font_lineHeight_suffix_desktop = isset($h6_font['lineHeight']['suffix']['desktop'])?$h6_font['lineHeight']['suffix']['desktop']:$defaults_h6['lineHeight']['suffix']['desktop'];
		$h6_font_lineHeight_suffix_tablet = isset($h6_font['lineHeight']['suffix']['tablet'])?$h6_font['lineHeight']['suffix']['tablet']:$defaults_h6['lineHeight']['suffix']['tablet'];
		$h6_font_lineHeight_suffix_mobile = isset($h6_font['lineHeight']['suffix']['mobile'])?$h6_font['lineHeight']['suffix']['mobile']:$defaults_h6['lineHeight']['suffix']['mobile'];

		$h6_font_letterSpacing_desktop = isset($h6_font['letterSpacing']['desktop'])?$h6_font['letterSpacing']['desktop']:'';
		$h6_font_letterSpacing_tablet = isset($h6_font['letterSpacing']['tablet'])?$h6_font['letterSpacing']['tablet']:'';
		$h6_font_letterSpacing_mobile = isset($h6_font['letterSpacing']['mobile'])?$h6_font['letterSpacing']['mobile']:'';

		$h6_font_weight = isset($h6_font['fontWeight'])?$h6_font['fontWeight']:$defaults_h6['fontWeight'];
		$h6_font_textTransform = isset($h6_font['textTransform'])?$h6_font['textTransform']:'';

		// $smaller_font = get_theme_mod('solace_smaller_typeface_general');
		$smaller_font = get_theme_mod('solace_typeface_smaller');
		$defaults_smaller = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_SMALLER );
		$smaller_font_size_desktop = isset($smaller_font['fontSize']['desktop'])?$smaller_font['fontSize']['desktop']:$defaults_smaller['fontSize']['desktop'];
		$smaller_font_size_desktop_unit = isset($smaller_font['fontSize']['suffix']['desktop'])?$smaller_font['fontSize']['suffix']['desktop']:$defaults_smaller['fontSize']['suffix']['desktop'];
		$smaller_font_size_tablet = isset($smaller_font['fontSize']['tablet'])?$smaller_font['fontSize']['tablet']:$defaults_smaller['fontSize']['tablet'];
		$smaller_font_size_tablet_unit = isset($smaller_font['fontSize']['suffix']['tablet'])?$smaller_font['fontSize']['suffix']['tablet']:$defaults_smaller['fontSize']['suffix']['tablet'];
		$smaller_font_size_mobile = isset($smaller_font['fontSize']['mobile'])?$smaller_font['fontSize']['mobile']:$defaults_smaller['fontSize']['mobile'];
		$smaller_font_size_mobile_unit = isset($smaller_font['fontSize']['suffix']['mobile'])?$smaller_font['fontSize']['suffix']['mobile']:$defaults_smaller['fontSize']['suffix']['mobile'];
		
		$smaller_font_lineHeight_desktop = isset($smaller_font['lineHeight']['desktop'])?$smaller_font['lineHeight']['desktop']:$defaults_smaller['lineHeight']['desktop'];
		$smaller_font_lineHeight_tablet = isset($smaller_font['lineHeight']['tablet'])?$smaller_font['lineHeight']['tablet']:$defaults_smaller['lineHeight']['tablet'];
		$smaller_font_lineHeight_mobile = isset($smaller_font['lineHeight']['mobile'])?$smaller_font['lineHeight']['mobile']:$defaults_smaller['lineHeight']['mobile'];
		$smaller_font_lineHeight_suffix_desktop = isset($smaller_font['lineHeight']['suffix']['desktop'])?$smaller_font['lineHeight']['suffix']['desktop']:$defaults_smaller['lineHeight']['suffix']['desktop'];
		$smaller_font_lineHeight_suffix_tablet = isset($smaller_font['lineHeight']['suffix']['tablet'])?$smaller_font['lineHeight']['suffix']['tablet']:$defaults_smaller['lineHeight']['suffix']['tablet'];
		$smaller_font_lineHeight_suffix_mobile = isset($smaller_font['lineHeight']['suffix']['mobile'])?$smaller_font['lineHeight']['suffix']['mobile']:$defaults_smaller['lineHeight']['suffix']['mobile'];

		$smaller_font_letterSpacing_desktop = isset($smaller_font['letterSpacing']['desktop'])?$smaller_font['letterSpacing']['desktop']:'';
		$smaller_font_letterSpacing_tablet = isset($smaller_font['letterSpacing']['tablet'])?$smaller_font['letterSpacing']['tablet']:'';
		$smaller_font_letterSpacing_mobile = isset($smaller_font['letterSpacing']['mobile'])?$smaller_font['letterSpacing']['mobile']:'';

		$smaller_font_weight = isset($smaller_font['fontWeight'])?$smaller_font['fontWeight']:$defaults_smaller['fontWeight'];
		$smaller_font_textTransform = isset($smaller_font['textTransform'])?$smaller_font['textTransform']:'';

		$logotitle_font = get_theme_mod('solace_typeface_logotitle');
		$defaults_logotitle = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_LOGOTITLE );
		$logotitle_font_size_desktop = isset($logotitle_font['fontSize']['desktop'])?$logotitle_font['fontSize']['desktop']:$defaults_logotitle['fontSize']['desktop'];
		$logotitle_font_size_desktop_unit = isset($logotitle_font['fontSize']['suffix']['desktop'])?$logotitle_font['fontSize']['suffix']['desktop']:$defaults_logotitle['fontSize']['suffix']['desktop'];
		$logotitle_font_size_tablet = isset($logotitle_font['fontSize']['tablet'])?$logotitle_font['fontSize']['tablet']:$defaults_logotitle['fontSize']['tablet'];
		$logotitle_font_size_tablet_unit = isset($logotitle_font['fontSize']['suffix']['tablet'])?$logotitle_font['fontSize']['suffix']['tablet']:$defaults_logotitle['fontSize']['suffix']['tablet'];
		$logotitle_font_size_mobile = isset($logotitle_font['fontSize']['mobile'])?$logotitle_font['fontSize']['mobile']:$defaults_logotitle['fontSize']['mobile'];
		$logotitle_font_size_mobile_unit = isset($logotitle_font['fontSize']['suffix']['mobile'])?$logotitle_font['fontSize']['suffix']['mobile']:$defaults_logotitle['fontSize']['suffix']['mobile'];
		
		$logotitle_font_lineHeight_desktop = isset($logotitle_font['lineHeight']['desktop'])?$logotitle_font['lineHeight']['desktop']:$defaults_logotitle['lineHeight']['desktop'];
		$logotitle_font_lineHeight_tablet = isset($logotitle_font['lineHeight']['tablet'])?$logotitle_font['lineHeight']['tablet']:$defaults_logotitle['lineHeight']['tablet'];
		$logotitle_font_lineHeight_mobile = isset($logotitle_font['lineHeight']['mobile'])?$logotitle_font['lineHeight']['mobile']:$defaults_logotitle['lineHeight']['mobile'];
		$logotitle_font_lineHeight_suffix_desktop = isset($logotitle_font['lineHeight']['suffix']['desktop'])?$logotitle_font['lineHeight']['suffix']['desktop']:$defaults_logotitle['lineHeight']['suffix']['desktop'];
		$logotitle_font_lineHeight_suffix_tablet = isset($logotitle_font['lineHeight']['suffix']['tablet'])?$logotitle_font['lineHeight']['suffix']['tablet']:$defaults_logotitle['lineHeight']['suffix']['tablet'];
		$logotitle_font_lineHeight_suffix_mobile = isset($logotitle_font['lineHeight']['suffix']['mobile'])?$logotitle_font['lineHeight']['suffix']['mobile']:$defaults_logotitle['lineHeight']['suffix']['mobile'];

		$logotitle_font_letterSpacing_desktop = isset($logotitle_font['letterSpacing']['desktop'])?$logotitle_font['letterSpacing']['desktop']:'';
		$logotitle_font_letterSpacing_tablet = isset($logotitle_font['letterSpacing']['tablet'])?$logotitle_font['letterSpacing']['tablet']:'';
		$logotitle_font_letterSpacing_mobile = isset($logotitle_font['letterSpacing']['mobile'])?$logotitle_font['letterSpacing']['mobile']:'';

		$logotitle_font_weight = isset($logotitle_font['fontWeight'])?$logotitle_font['fontWeight']:$defaults_logotitle['fontWeight'];
		$logotitle_font_textTransform = isset($logotitle_font['textTransform'])?$logotitle_font['textTransform']:'';

		$button_font = get_theme_mod('solace_typeface_button');
		$defaults_button = Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_BUTTON );
		$button_font_size_desktop = isset($button_font['fontSize']['desktop'])?$button_font['fontSize']['desktop']:$defaults_button['fontSize']['desktop'];
		$button_font_size_desktop_unit = isset($button_font['fontSize']['suffix']['desktop'])?$button_font['fontSize']['suffix']['desktop']:$defaults_button['fontSize']['suffix']['desktop'];
		$button_font_size_tablet = isset($button_font['fontSize']['tablet'])?$button_font['fontSize']['tablet']:$defaults_button['fontSize']['tablet'];
		$button_font_size_tablet_unit = isset($button_font['fontSize']['suffix']['tablet'])?$button_font['fontSize']['suffix']['tablet']:$defaults_button['fontSize']['suffix']['tablet'];
		$button_font_size_mobile = isset($button_font['fontSize']['mobile'])?$button_font['fontSize']['mobile']:$defaults_button['fontSize']['mobile'];
		$button_font_size_mobile_unit = isset($button_font['fontSize']['suffix']['mobile'])?$button_font['fontSize']['suffix']['mobile']:$defaults_button['fontSize']['suffix']['mobile'];
		
		$button_font_lineHeight_desktop = isset($button_font['lineHeight']['desktop'])?$button_font['lineHeight']['desktop']:$defaults_button['lineHeight']['desktop'];
		$button_font_lineHeight_tablet = isset($button_font['lineHeight']['tablet'])?$button_font['lineHeight']['tablet']:$defaults_button['lineHeight']['tablet'];
		$button_font_lineHeight_mobile = isset($button_font['lineHeight']['mobile'])?$button_font['lineHeight']['mobile']:$defaults_button['lineHeight']['mobile'];
		$button_font_lineHeight_suffix_desktop = isset($button_font['lineHeight']['suffix']['desktop'])?$button_font['lineHeight']['suffix']['desktop']:$defaults_button['lineHeight']['suffix']['desktop'];
		$button_font_lineHeight_suffix_tablet = isset($button_font['lineHeight']['suffix']['tablet'])?$button_font['lineHeight']['suffix']['tablet']:$defaults_button['lineHeight']['suffix']['tablet'];
		$button_font_lineHeight_suffix_mobile = isset($button_font['lineHeight']['suffix']['mobile'])?$button_font['lineHeight']['suffix']['mobile']:$defaults_button['lineHeight']['suffix']['mobile'];

		$button_font_letterSpacing_desktop = isset($button_font['letterSpacing']['desktop'])?$button_font['letterSpacing']['desktop']:'';
		$button_font_letterSpacing_tablet = isset($button_font['letterSpacing']['tablet'])?$button_font['letterSpacing']['tablet']:'';
		$button_font_letterSpacing_mobile = isset($button_font['letterSpacing']['mobile'])?$button_font['letterSpacing']['mobile']:'';

		$button_font_weight = isset($button_font['fontWeight'])?$button_font['fontWeight']:$defaults_button['fontWeight'];
		$button_font_textTransform = isset($button_font['textTransform'])?$button_font['textTransform']:'';


		$custom_typography = [
			[
				'_id' => 'primary',
				'title' => 'Smaller',
				'typography_typography' => 'custom',
				'typography_font_family' => $primary,
				'typography_font_size' => [
					'unit' => $smaller_font_size_desktop_unit,
					'size' => isset($smaller_font_size_desktop)?$smaller_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $smaller_font_weight,
				'typography_text_transform' => $smaller_font_textTransform,
				'typography_line_height' => [
					'unit' => $smaller_font_lineHeight_suffix_desktop,
					'size' => $smaller_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $smaller_font_size_tablet_unit,
					'size' => $smaller_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $smaller_font_size_mobile_unit,
					'size' => $smaller_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $smaller_font_lineHeight_suffix_tablet,
					'size' => $smaller_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $smaller_font_lineHeight_suffix_mobile,
					'size' => $smaller_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'secondary',
				'title' => 'Logo Title / Subtitle',
				'typography_typography' => 'custom',
				'typography_font_family' => $secondary,
				'typography_font_size' => [
					'unit' => $logotitle_font_size_desktop_unit,
					'size' => isset($logotitle_font_size_desktop)?$logotitle_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $logotitle_font_weight,
				'typography_text_transform' => $logotitle_font_textTransform,
				'typography_line_height' => [
					'unit' => $logotitle_font_lineHeight_suffix_desktop,
					'size' => $logotitle_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $logotitle_font_size_tablet_unit,
					'size' => $logotitle_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $logotitle_font_size_mobile_unit,
					'size' => $logotitle_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $logotitle_font_lineHeight_suffix_tablet,
					'size' => $logotitle_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $logotitle_font_lineHeight_suffix_mobile,
					'size' => $logotitle_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'text',
				'title' => 'Solace Base',
				'typography_typography' => 'custom',
				'typography_font_family' => $text,
				'typography_font_size' => [
					'unit' => $base_font_size_desktop_unit,
					'size' => $base_font_size_desktop,
					'sizes' => []
				],
				'typography_font_weight' => $base_font_weight,
				'typography_text_transform' => $base_font_textTransform,
				'typography_line_height' => [
					'unit' => $base_font_lineHeight_suffix_desktop,
					'size' => $base_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $base_font_size_tablet_unit,
					'size' => $base_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $base_font_size_mobile_unit,
					'size' => $base_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $base_font_lineHeight_suffix_tablet,
					'size' => $base_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $base_font_lineHeight_suffix_mobile,
					'size' => $base_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'accent',
				'title' => 'Button',
				'typography_typography' => 'custom',
				'typography_font_family' => $accent,
				'typography_font_size' => [
					'unit' => $button_font_size_desktop_unit,
					'size' => isset($button_font_size_desktop)?$button_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $button_font_weight,
				'typography_text_transform' => $button_font_textTransform,
				'typography_line_height' => [
					'unit' => $button_font_lineHeight_suffix_desktop,
					'size' => $button_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $button_font_size_tablet_unit,
					'size' => $button_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $button_font_size_mobile_unit,
					'size' => $button_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $button_font_lineHeight_suffix_tablet,
					'size' => $button_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $button_font_lineHeight_suffix_mobile,
					'size' => $button_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_body_font_family',
				'title' => 'Solace Base',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_base_font,
				'typography_font_size' => [
					'unit' => $base_font_size_desktop_unit,
					'size' => $base_font_size_desktop,
					'sizes' => []
				],
				'typography_font_weight' => $base_font_weight,
				'typography_text_transform' => $base_font_textTransform,
				'typography_line_height' => [
					'unit' => $base_font_lineHeight_suffix_desktop,
					'size' => $base_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $base_font_size_tablet_unit,
					'size' => $base_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $base_font_size_mobile_unit,
					'size' => $base_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $base_font_lineHeight_suffix_tablet,
					'size' => $base_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $base_font_lineHeight_suffix_mobile,
					'size' => $base_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $base_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h1_font_family_general',
				'title' => 'Solace H1',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h1_font_family_general,
				'typography_font_size' => [
				'unit' => $h1_font_size_desktop_unit,
					'size' => isset($h1_font_size_desktop)?$h1_font_size_desktop:'68',
					'sizes' => []
				],
				'typography_font_weight' => $h1_font_weight,
				'typography_text_transform' => $h1_font_textTransform,
				'typography_line_height' => [
					'unit' => $h1_font_lineHeight_suffix_desktop,
					'size' => $h1_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h1_font_size_tablet_unit,
					'size' => $h1_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h1_font_size_mobile_unit,
					'size' => $h1_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h1_font_lineHeight_suffix_tablet,
					'size' => $h1_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h1_font_lineHeight_suffix_mobile,
					'size' => $h1_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h1_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h2_font_family_general',
				'title' => 'Solace H2',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h2_font_family_general,
				'typography_font_size' => [
				'unit' => $h2_font_size_desktop_unit,
					'size' => isset($h2_font_size_desktop)?$h2_font_size_desktop:'50',
					'sizes' => []
				],
				'typography_font_weight' => $h2_font_weight,
				'typography_text_transform' => $h2_font_textTransform,
				'typography_line_height' => [
					'unit' => $h2_font_lineHeight_suffix_desktop,
					'size' => $h2_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h2_font_size_tablet_unit,
					'size' => $h2_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h2_font_size_mobile_unit,
					'size' => $h2_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h2_font_lineHeight_suffix_tablet,
					'size' => $h2_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h2_font_lineHeight_suffix_mobile,
					'size' => $h2_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h2_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h3_font_family_general',
				'title' => 'Solace H3',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h3_font_family_general,
				'typography_font_size' => [
				'unit' => $h3_font_size_desktop_unit,
					'size' => isset($h3_font_size_desktop)?$h3_font_size_desktop:'38',
					'sizes' => []
				],
				'typography_font_weight' => $h3_font_weight,
				'typography_text_transform' => $h3_font_textTransform,
				'typography_line_height' => [
					'unit' => $h3_font_lineHeight_suffix_desktop,
					'size' => $h3_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h3_font_size_tablet_unit,
					'size' => $h3_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h3_font_size_mobile_unit,
					'size' => $h3_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h3_font_lineHeight_suffix_tablet,
					'size' => $h3_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h3_font_lineHeight_suffix_mobile,
					'size' => $h3_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h3_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h4_font_family_general',
				'title' => 'Solace H4',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h4_font_family_general,
				'typography_font_size' => [
				'unit' => $h4_font_size_desktop_unit,
					'size' => isset($h4_font_size_desktop)?$h4_font_size_desktop:'28',
					'sizes' => []
				],
				'typography_font_weight' => $h4_font_weight,
				'typography_text_transform' => $h4_font_textTransform,
				'typography_line_height' => [
					'unit' => $h4_font_lineHeight_suffix_desktop,
					'size' => $h4_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h4_font_size_tablet_unit,
					'size' => $h4_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h4_font_size_mobile_unit,
					'size' => $h4_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h4_font_lineHeight_suffix_tablet,
					'size' => $h4_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h4_font_lineHeight_suffix_mobile,
					'size' => $h4_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h4_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h5_font_family_general',
				'title' => 'Solace H5',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h5_font_family_general,
				'typography_font_size' => [
				'unit' => $h5_font_size_desktop_unit,
					'size' => isset($h5_font_size_desktop)?$h5_font_size_desktop:'21',
					'sizes' => []
				],
				'typography_font_weight' => $h5_font_weight,
				'typography_text_transform' => $h5_font_textTransform,
				'typography_line_height' => [
					'unit' => $h5_font_lineHeight_suffix_desktop,
					'size' => $h5_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h5_font_size_tablet_unit,
					'size' => $h5_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h5_font_size_mobile_unit,
					'size' => $h5_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h5_font_lineHeight_suffix_tablet,
					'size' => $h5_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h5_font_lineHeight_suffix_mobile,
					'size' => $h5_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h5_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_h6_font_family_general',
				'title' => 'Solace H6',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_h6_font_family_general,
				'typography_font_size' => [
				'unit' => $h6_font_size_desktop_unit,
					'size' => isset($h6_font_size_desktop)?$h6_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $h6_font_weight,
				'typography_text_transform' => $h6_font_textTransform,
				'typography_line_height' => [
					'unit' => $h6_font_lineHeight_suffix_desktop,
					'size' => $h6_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
				'unit' => $h6_font_size_tablet_unit,
					'size' => $h6_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $h6_font_size_mobile_unit,
					'size' => $h6_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $h6_font_lineHeight_suffix_tablet,
					'size' => $h6_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $h6_font_lineHeight_suffix_mobile,
					'size' => $h6_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $h6_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_smaller_font_family',
				'title' => 'Smaller',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_smaller_font_family,
				'typography_font_size' => [
				'unit' => $smaller_font_size_desktop_unit,
					'size' => isset($smaller_font_size_desktop)?$smaller_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $smaller_font_weight,
				'typography_text_transform' => $smaller_font_textTransform,
				'typography_line_height' => [
					'unit' => $smaller_font_lineHeight_suffix_desktop,
					'size' => $smaller_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $smaller_font_size_tablet_unit,
					'size' => $smaller_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $smaller_font_size_mobile_unit,
					'size' => $smaller_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $smaller_font_lineHeight_suffix_tablet,
					'size' => $smaller_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $smaller_font_lineHeight_suffix_mobile,
					'size' => $smaller_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $smaller_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_logotitle_font_family',
				'title' => 'Logo Title / Subtitle',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_logotitle_font_family,
				'typography_font_size' => [
				'unit' => $logotitle_font_size_desktop_unit,
					'size' => isset($logotitle_font_size_desktop)?$logotitle_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $logotitle_font_weight,
				'typography_text_transform' => $logotitle_font_textTransform,
				'typography_line_height' => [
					'unit' => $logotitle_font_lineHeight_suffix_desktop,
					'size' => $logotitle_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $logotitle_font_size_tablet_unit,
					'size' => $logotitle_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $logotitle_font_size_mobile_unit,
					'size' => $logotitle_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $logotitle_font_lineHeight_suffix_tablet,
					'size' => $logotitle_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $logotitle_font_lineHeight_suffix_mobile,
					'size' => $logotitle_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $logotitle_font_letterSpacing_mobile,
					'sizes' => []
				]
			],
			[
				'_id' => 'solace_button_font_family',
				'title' => 'Button',
				'typography_typography' => 'custom',
				'typography_font_family' => $solace_button_font_family,
				'typography_font_size' => [
				'unit' => $button_font_size_desktop_unit,
					'size' => isset($button_font_size_desktop)?$button_font_size_desktop:'16',
					'sizes' => []
				],
				'typography_font_weight' => $button_font_weight,
				'typography_text_transform' => $button_font_textTransform,
				'typography_line_height' => [
					'unit' => $button_font_lineHeight_suffix_desktop,
					'size' => $button_font_lineHeight_desktop,
					'sizes' => []
				],
				'typography_letter_spacing' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_desktop,
					'sizes' => []
				],
				'typography_font_size_tablet' => [
					'unit' => $button_font_size_tablet_unit,
					'size' => $button_font_size_tablet,
					'sizes' => []
				],
				'typography_font_size_mobile' => [
					'unit' => $button_font_size_mobile_unit,
					'size' => $button_font_size_mobile,
					'sizes' => []
				],
				'typography_line_height_tablet' => [
					'unit' => $button_font_lineHeight_suffix_tablet,
					'size' => $button_font_lineHeight_tablet,
					'sizes' => []
				],
				'typography_line_height_mobile' => [
					'unit' => $button_font_lineHeight_suffix_mobile,
					'size' => $button_font_lineHeight_mobile,
					'sizes' => []
				],
				'typography_letter_spacing_tablet' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_tablet,
					'sizes' => []
				],
				'typography_letter_spacing_mobile' => [
					'unit' => 'px',
					'size' => $button_font_letterSpacing_mobile,
					'sizes' => []
				]
			]
		];

		if (class_exists('Elementor\Plugin')) {
			\Elementor\Plugin::$instance->kits_manager->update_kit_settings_based_on_option( 'system_typography', $custom_typography );		
			\Elementor\Plugin::$instance->files_manager->clear_cache();
		}

	}
}

add_action( 'elementor/editor/init', 'solace_typography_elementor_add_custom' ,999,2);

add_action( 'elementor/document/after_save', 'solace_font_elementor_after_save', 9999, 2 );

add_action('customize_save_after', 'solace_font_save_customizer_settings');
