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
class WC_Custom_General_Product_Badges extends Base_Customizer {
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
				'solace_wc_custom_general_product_badges',
				array(
					'priority' 	=> 108,
					'title'    	=> esc_html__( 'Product Badges', 'solace' ),
					'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {

		$this->add_control(
			new Control(
				'solace_wc_custom_general_product_badges_shape',
				array(
					'sanitize_callback' => array( $this, 'sanitize_product_badges' ),
					'default'           => 'badge-1',
					'transport'             => 'postMessage',
				),
				array(
					'label'           => esc_html__( 'Badge Shape', 'solace' ),
					'section'         => 'solace_wc_custom_general_product_badges',
					'priority'        => 2,
					// 'choices'         => $this->solace_wc_custom_badge_shape_choices( 'solace_wc_custom_general_product_badges_shape_choice' ),
					'choices'  => [
						'badge-1' => [
							'name'  => __('Rounded', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/badge-1.svg',
						],
						'badge-2'  => [
							'name'  => __('Box', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/badge-2.svg',
						],
						'badge-3'    => [
							'name'  => __('Circle', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/badge-3.svg',
						],
						
					],
					// 'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_product_badges_label',
				array(
					'default'               => 'Sale!',
					'sanitize_callback'     => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Label Text', 'solace' ),
					'type'                  => 'text',
					'section'         		=> 'solace_wc_custom_general_product_badges',
					'priority'        		=> 3,
				)
				
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_product_badges_color',
				array(
					'default'               => 'var(--sol-color-selection-initial)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Font Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_product_badges',
					'priority'        		=> 3,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--wc-product-badge-font-color',
							'selector' => 'body.woocommerce',
						),
					],
				)
			)
		);	
		

		$this->add_control(
			new Control(
				'solace_wc_custom_general_product_badges_background_color',
				array(
					'default'               => 'var(--sol-color-selection-high)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					// 'transport'             => 'postMessage',
					'label'                 => __( 'Background Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_product_badges',
					'priority'        		=> 4,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--wc-product-badge-bg-color',
							'selector' => 'body.woocommerce',
						),
					],					
				)
				
			)
		);	
	}

		/**
	 * Active callback function for site-wide options
	 */
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

	/**
	 * Active callback function for advanced controls
	 */
	public function advanced_options_active_callback() {
		return get_theme_mod( 'solace_wc_custom_general_product_badges', false );
	}

		/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_product_badges( $value ) {
		$allowed_values = array( 'badge-1', 'badge-2', 'badge-3' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'badge-1';
		}

		return esc_html( $value );
	}

			/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function solace_wc_custom_badge_shape_choices( $control_id ) {
		$options = apply_filters(
			'solace_wc_custom_general_product_badges_shape_choice',
			array(
				'badge-1' => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/badge-1.svg',
				),
				'badge-2'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/badge-2.svg',
				),
				'badge-3'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/badge-3.svg',
				),
			),
			$control_id
		);
	}
	

}
