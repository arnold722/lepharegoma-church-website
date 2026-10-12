<?php
/**
 * Container layout section.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Layout_Container
 *
 * @package Solace\Customizer\Options
 */
class Layout_Container extends Base_Customizer {
	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_container();
		$this->control_container_width();
		// $this->control_container_style();
	}

	/**
	 * Add customize section
	 */
	private function section_container() {
		$this->add_section(
			new Section(
				'solace_container',
				array(
					'priority' => 14,
					'title'    => esc_html__( 'Container', 'solace' ),
					// 'panel'    => 'solace_layout',
				)
			)
		);
	}

	/**
	 * Add container width control
	 */
	private function control_container_width() {

		$this->add_control(
			new Control(
				'solace_container_hide_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Hide Title', 'solace' ),
					'section'         => 'solace_container',
					'type'            => 'solace_toggle_control',
					'priority'        => 10,
					'description'     => esc_html__( 'You can change individual layout from Single Metabox Options', 'solace' ),
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$this->add_control(
			new Control(
				'solace_container_layout',
				array(
					'sanitize_callback' => array( $this, 'sanitize_arrow_layout' ),
					'default'           => 'custom',
				),
				array(
					// 'label'           => __( 'Container Layout', 'solace' ),
					'section'         => 'solace_container',
					'priority'        => 20,
					'choices'         => $this->solace_container_layout_choices( 'solace_container_layout' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),


				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'solace_container_width',
				[
					'sanitize_callback' => 'solace_sanitize_range_value',
					// 'transport'         => $this->selective_refresh,
					'default'           => '{ "mobile": 748, "tablet": 992, "desktop": 1280 }',
				],
				[
					'section'               => 'solace_container',
					'type'                  => 'solace_responsive_range_control',
					'input_attrs'           => [
						'min'        => 200,
						'max'        => 2000,
						'units'      => [ 'px' ],
						'defaultVal' => [
							'mobile'  => 748,
							'tablet'  => 992,
							'desktop' => 1280,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'selector'   => 'body',
							'vars'       => '--container',
							'responsive' => true,
							'suffix'     => 'px',
						],
					],
					'priority'              => 25,
				],
				'\Solace\Customizer\Controls\React\Responsive_Range'
			)
		);
	}

	/**
	 * Add container style controls
	 */
	private function control_container_style() {
		$container_style_controls = array(
			'solace_default_container_style'      => array(
				'priority' => 30,
				'label'    => __( 'Default Container Style', 'solace' ),
			),
			'solace_blog_archive_container_style' => array(
				'priority' => 35,
				'label'    => __( 'Blog / Archive Container Style', 'solace' ),
			),
			'solace_single_post_container_style'  => array(
				'priority' => 40,
				'label'    => __( 'Single Post Container Style', 'solace' ),
			),
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			$container_style_controls = array_merge(
				$container_style_controls,
				array(
					'solace_shop_archive_container_style'   => array(
						'priority' => 45,
						'label'    => __( 'Shop / Archive Container Style', 'solace' ),
					),
					'solace_single_product_container_style' => array(
						'priority' => 50,
						'label'    => __( 'Single Product Container Style', 'solace' ),
					),
				)
			);
		}

		/**
		 * Filters the container style controls.
		 *
		 * @param array $container_style_controls Container style controls.
		 *
		 * @since 3.1.0
		 */
		$container_style_controls = apply_filters( 'solace_container_style_filter', $container_style_controls );

		foreach ( $container_style_controls as $control_id => $control ) {
			$this->add_control(
				new Control(
					$control_id,
					array(
						'sanitize_callback' => 'solace_sanitize_container_layout',
						'transport'         => $this->selective_refresh,
						'default'           => 'contained',
					),
					array(
						'label'    => $control['label'],
						'section'  => 'solace_container',
						'type'     => 'select',
						'priority' => $control['priority'],
						'choices'  => array(
							'contained'  => __( 'Contained', 'solace' ),
							'full-width' => __( 'Full Width', 'solace' ),
						),
					)
				)
			);
		}
	}

		/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_arrow_layout( $value ) {
		$allowed_values = array( 'boxed', 'fullwidth', 'left', 'right', 'custom' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'boxed';
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
	private function solace_container_layout_choices( $control_id ) {
		$options = apply_filters(
			'solace_container_layout',
			array(
				'fullwidth'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_wide.svg',
				),
				'boxed' => array(         
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_boxed.svg',
				),
				'left'      => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_left.svg',
				),
				'right'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_right.svg',
				),
				'custom'      => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_custom.svg',
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
