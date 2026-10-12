<?php
/**
 * Colors / Background section.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Defaults\Layout;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Colors_Background
 *
 * @package Solace\Customizer\Options
 */
class WC_Custom_General_Button extends Base_Customizer {
	use Layout;

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_features();
		$this->add_main_controls();

	}

	/**
	 * Add customize section
	 */
	private function section_features() {
		$this->add_section(
			new Section(
				'solace_wc_custom_general_buttons',
				// 'solace_wc_custom_general_buttons',
				array(
					'priority' 	=> 12,
					'title'    	=> esc_html__( 'Buttons', 'solace' ),
					// 'panel' 	=> 'solace_wc_custom_general'
					// 'panel' 	=> 'solace_general_options'
				)
			)
		);
	}

	private function add_main_controls() {
 
		$this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_elementor',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
					// 'transport'         => 'postMessage',
				],
				[
					// 'transport'       => 'postMessage',
					'label'           => esc_html__( 'Override Elementor Settings', 'solace' ),
					'section'         => 'solace_wc_custom_general_buttons',
                    'description'     => __( "Turn this option ON to apply the custom button styles defined below, overriding Elementor’s Global Button settings", 'solace' ),
					'type'            => 'solace_toggle_control',
					'priority'        => 113,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_text_color',
				array(
					'default'               => '#FFFFFF',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					// 'transport'             => 'postMessage',
					'label'                 => __( 'Font', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 114,
				)
				
			)
		);	
        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_text_color_hover',
				array(
					'default'               => '#FFFFFF',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					// 'transport'             => 'postMessage',
					'label'                 => __( 'Font Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 115,
				)
				
			)
		);	
        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_bg_color',
				array(
					'default'               => '#3662FF',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					// 'transport'             => 'postMessage',
					'label'                 => __( 'Background', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 116,
				)
				
			)
		);	
        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_bg_color_hover',
				array(
					'default'               => '#000F4D',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					// 'transport'             => 'postMessage',
					'label'                 => __( 'Background Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 117,
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_border_style',
				array(
					'sanitize_callback' => array( $this, 'sanitize_arrow_layout' ),
					'default'           => 'none',
				),
				array(
					'label'           => __( 'Border Style', 'solace' ),
					'section'         => 'solace_wc_custom_general_buttons',
					'priority'        => 118,
					'choices'         => $this->arrow_layout_choices( 'solace_wc_custom_general_buttons_border_style' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		

        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_border_color',
				array(
					'default'               => '#000F4D',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Border', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 119,
				)
				
			)
		);	
        $this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_border_color_hover',
				array(
					'default'               => '#ff8c00',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Border Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 120,
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_border_width',
				array(
					'default'               => $this->default_borderwidth_value,
					'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Border Width', 'solace' ),
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 121,
					'default'               => $this->default_borderwidth_value,
				),
				'\Solace\Customizer\Controls\React\Spacing',
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_border_radius',
				array(
					'default'               => $this->default_radius_value,
					'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Radius', 'solace' ),
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 122,
					'default'               => $this->default_radius_value,
				),
				'\Solace\Customizer\Controls\React\Spacing',
				
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_buttons_padding',
				array(
					'default'               => $this->default_padding_value,
					'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Padding', 'solace' ),
					'section'         	    => 'solace_wc_custom_general_buttons',
					'priority'              => 123,
					'default'               => $this->default_padding_value,
				),
				'\Solace\Customizer\Controls\React\Spacing',
				
			)
		);

	}
	public function sanitize_spacing_array( $input ) {
		if ( is_array( $input ) ) {
			return $input;
		}

		return array();
	}

	protected $default_padding_value = array(
		'mobile'       => array(
			'top'    => 6,
			'right'  => 12,
			'bottom' => 6,
			'left'   => 12,
		),
		'tablet'       => array(
			'top'    => 6,
			'right'  => 12,
			'bottom' => 6,
			'left'   => 12,
		),
		'desktop'      => array(
			'top'    => 12,
			'right'  => 24,
			'bottom' => 12,
			'left'   => 24,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	protected $default_radius_value = array(
		'mobile'       => array(
			'top'    => 3,
			'right'  => 3,
			'bottom' => 3,
			'left'   => 3,
		),
		'tablet'       => array(
			'top'    => 3,
			'right'  => 3,
			'bottom' => 3,
			'left'   => 3,
		),
		'desktop'      => array(
			'top'    => 3,
			'right'  => 3,
			'bottom' => 3,
			'left'   => 3,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);
	protected $default_borderwidth_value = array(
		'mobile'       => array(
			'top'    => 1,
			'right'  => 1,
			'bottom' => 1,
			'left'   => 1,
		),
		'tablet'       => array(
			'top'    => 1,
			'right'  => 1,
			'bottom' => 1,
			'left'   => 1,
		),
		'desktop'      => array(
			'top'    => 2,
			'right'  => 2,
			'bottom' => 2,
			'left'   => 2,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	public function sanitize_arrow_layout( $value ) {
		$allowed_values = array( 'none', 'solid', 'double', 'dotted', 'dashed','groove' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'none';
		}

		return esc_html( $value );
	}

	private function arrow_layout_choices( $control_id ) {
		$options = apply_filters(
			'solace_wc_custom_general_buttons_border_style',
			array(
				'none' => array(
					'name' => 'None',
				),
				'solid' => array(
					'name' => 'Solid',
				),
				'double' => array(
					'name' => 'Double',
				),
				'dotted' => array(
					'name' => 'Dotted',
				),
				'dashed' => array(
					'name' => 'Dashed',
				),
				'groove' => array(
					'name' => 'Groove',
				),
			),
			$control_id
		);

		foreach ( $options as $slug => $args ) {
			if ( ! isset( $args['name'] ) ) {
				$options[ $slug ]['name'] = ucwords( str_replace( '-', ' ', $slug ) );
			}
		}

		return $options;
	}
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

	public function advanced_options_active_callback() {
		return get_theme_mod( 'solace_advanced_layout_options', false );
	}
	

}
