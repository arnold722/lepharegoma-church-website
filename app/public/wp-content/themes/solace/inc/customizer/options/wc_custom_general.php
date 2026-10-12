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
class WC_Custom_General extends Base_Customizer {
	use Layout;
	const ICON_COLOR_ID  = 'icon_color_setting';
	const ICON_SIZE  = 'icon_size';

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
				'solace_wc_custom_general',
				array(
					'priority' => 105,
					'title'    => esc_html__( 'General2', 'solace' ),
				)
			)
		);
	}

	private function add_main_controls() {
		$this->add_control(
			new Control(
				'toggle_scroll_to_top',
				array(
					'default'           => false,
				),
				array(
					'label'           => __( 'Show Icon', 'solace' ),
					'section'         => 'solace_features_scroll_to_top',
					'type'			  => 'solace_toggle_control_flex',
				),
			)
		);

		$this->add_control(
			new Control(
				'solace_scroll_to_top',
				array(
					'sanitize_callback' => array( $this, 'sanitize_arrow_layout' ),
					'default'           => 'up_arrow1',
				),
				array(
					'label'           => __( 'Icon', 'solace' ),
					'section'         => 'solace_features_scroll_to_top',
					'priority'        => 102,
					'choices'         => $this->arrow_layout_choices( 'solace_scroll_to_top' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'solace_scroll_to_top_icon_color',
				array(
					'default'               => '#fff',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Icon Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         	=> 'solace_features_scroll_to_top',
					'priority'        => 103,
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_scroll_to_top_icon_size',
				array(
					'sanitize_callback' => 'solace_sanitize_range_value',
					'default'           => 19,
				),
				array(
					'label'       => esc_html__('Icon Size', 'solace'),
					'section'     => 'solace_features_scroll_to_top',
					'type'        => 'solace_range_control',
					'input_attrs' => [
						'min'        => 19,
						'max'        => 300,
						'defaultVal' => 25,
					],
					'priority'    => 104,
				),
				'Solace\Customizer\Controls\React\Range'
			)
		);
		
	}

		/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_arrow_layout( $value ) {
		$allowed_values = array( 'up_arrow1', 'up_arrow2', 'up_arrow3', 'up_arrow4', 'up_arrow5' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'up_arrow1';
		}

		return esc_html( $value );
	}
	/**
	 * Active callback function for callback
	 */
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

		/**
	 * Active callback function for advanced controls
	 */
	public function advanced_options_active_callback() {
		return get_theme_mod( 'solace_advanced_layout_options', false );
	}
	/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function arrow_layout_choices( $control_id ) {
		$options = apply_filters(
			'solace_scroll_to_top',
			array(
				'up_arrow1' => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/up_arrow1.svg',
				),
				'up_arrow2'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/up_arrow2.svg',
				),
				'up_arrow3'      => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/up_arrow3.svg',
				),
				'up_arrow4'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/up_arrow4.svg',
				),
				'up_arrow5'      => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/up_arrow5.svg',
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

}
