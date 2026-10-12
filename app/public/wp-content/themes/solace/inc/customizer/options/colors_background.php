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
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Colors_Background
 *
 * @package Solace\Customizer\Options
 */
class Colors_Background extends Base_Customizer {
	const CUSTOM_COLOR_LIMIT            = 30;
	const CUSTOM_COLOR_LABEL_MAX_LENGTH = 16;

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->wpc->remove_control( 'background_color' );
		$this->section_colors_background();
		$this->controls_colors();
	}

	/**
	 * Add customize section
	 */
	private function section_colors_background() {
		$this->add_section(
			new Section(
				'solace_colors_background_section',
				array(
					'priority' => 10,
					'title'    => esc_html__( 'Colors', 'solace' ),
					// 'panel'	=> 'sol_general'
				)
			)
		);
	}

	/**
	 * Add colors controls.
	 */
	private function controls_colors() {
		$this->add_global_colors();
	}

	/**
	 * Change controls.
	 */
	public function change_controls() {
		// $priority         = 30;
		// $controls_to_move = array(
		// 	'background_image',
		// 	'background_preset',
		// 	'background_position',
		// 	'background_size',
		// 	'background_repeat',
		// 	'background_attachment',
		// );

		// foreach ( $controls_to_move as $control_slug ) {
		// 	$control           = $this->get_customizer_object( 'control', $control_slug );
		// 	$control->priority = $priority;
		// 	$control->section  = 'solace_colors_background_section';
		// 	$priority         += 5;
		// }
	}

	/**
	 * Add global colors.
	 */
	private function add_global_colors() {
		$this->add_control(
			new Control(
				'solace_global_colors',
				[
					'sanitize_callback' => [ $this, 'sanitize_global_colors' ],
					'default'           => solace_get_global_colors_default( true ),
					'transport'         => 'postMessage',
				],
				[
					'label'                 => __( 'Global Color Palette', 'solace' ),
					'priority'              => 123,
					'section'               => 'solace_colors_background_section',
					'type'                  => 'solace_global_colors',
					'default_values'        => solace_get_global_colors_default(),
					'live_refresh_selector' => true,
				],
				'Solace\Customizer\Controls\React\Global_Colors'
			)
		);

		$this->add_control(
			new Control(
				'solace_global_custom_colors',
				[
					'sanitize_callback' => [ $this, 'sanitize_global_custom_colors' ],
					'default'           => [],
					'transport'         => 'refresh',
				],
				[
					'label'                 => __( 'Custom Colors', 'solace' ),
					'priority'              => 124,
					'section'               => 'solace_colors_background_section',
					'type'                  => 'solace_global_custom_colors',
					'default_values'        => [],
					'live_refresh_selector' => true,
				],
				'Solace\Customizer\Controls\React\Global_Custom_Colors'
			)
		);
	}

	/**
	 * Sanitize Global Colors Setting
	 *
	 * @param array $value recieved value.
	 * @return array
	 */
	public function sanitize_global_colors( $value ) {
		// `flag` key is used to trigger setting change on deep state changes inside the palettes.
		if ( isset( $value['flag'] ) ) {
			unset( $value['flag'] );
		}

		$default = solace_get_global_colors_default();
		if ( ! isset( $value['activePalette'] ) || ! isset( $value['palettes'] ) ) {
			return $default;
		}

		foreach ( $value['palettes'] as $slug => $args ) {
			foreach ( $args['colors'] as $key => $color_val ) {
				$value['palettes'][ $slug ]['colors'][ $key ] = solace_sanitize_colors( $color_val );
			}
		}

		return $value;
	}

	/**
	 * Sanitize Global Custom Colors Setting
	 *
	 * @param array $value recieved value.
	 * @return array
	 */
	public function sanitize_global_custom_colors( $value ) {
		// `flag` key is used to trigger setting change on deep state changes inside the palettes.
		if ( isset( $value['flag'] ) ) {
			unset( $value['flag'] );
		}

		if ( count( $value ) > self::CUSTOM_COLOR_LIMIT ) {
			$value = array_slice( $value, 0, self::CUSTOM_COLOR_LIMIT );
		}

		foreach ( $value as $slug => $options ) {
			$color = solace_sanitize_colors( $options['val'] );

			if ( ! $color ) {
				unset( $value[ $slug ] );
				continue;
			}

			$label = sanitize_text_field( $options['label'] );

			if ( strlen( $label ) > self::CUSTOM_COLOR_LABEL_MAX_LENGTH ) {
				$label = substr( $label, 0, self::CUSTOM_COLOR_LABEL_MAX_LENGTH );
			}

			$value[ $slug ]['label'] = $label;
			$value[ $slug ]['val']   = $color;
		}

		return $value;
	}
}
