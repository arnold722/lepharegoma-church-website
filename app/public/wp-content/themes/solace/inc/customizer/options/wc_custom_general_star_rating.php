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
class WC_Custom_General_Star_Rating extends Base_Customizer {
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
				'solace_wc_custom_general_star_rating',
				array(
					'priority' 	=> 108,
					'title'    	=> esc_html__( 'Star Rating', 'solace' ),
					'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {
		$this->add_control(
			new Control(
				'solace_wc_custom_general_star_rating_show',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
					'transport'         => 'postMessage',
				],
				[
					'label'           => esc_html__( 'Show', 'solace' ),
					'section'         => 'solace_wc_custom_general_star_rating',
					'type'            => 'solace_toggle_control',
					'priority'        => 10,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_star_rating_color',
				array(
					'default' 				=> 'var(--sol-color-selection-high)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Icon Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_star_rating',
					'priority'        		=> 11,
				)
				
			)
		);	
	}
	

}
