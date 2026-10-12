<?php
/**
 * Single page layout section.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Types\Control;

/**
 * Class Layout_Single_Page
 */
class Layout_Single_Page extends Base_Layout_Single {

	/**
	 * Returns the post type.
	 *
	 * @return string
	 */
	public function get_post_type() {
		return 'page';
	}

	/**
	 * @return string
	 */
	public function get_cover_selector() {
		return '.page .nv-post-cover';
	}

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		parent::add_controls();
		
		$this->add_control(
			new Control(
				'solace_page_layout_hide_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Hide Title', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 1,
					'description'     => esc_html__( '- You can change individual layout from Single Metabox Options', 'solace' ),
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$this->add_control(
			new Control(
				'solace_container_page_width',
				[
					'sanitize_callback' => 'solace_sanitize_range_value',
					// 'transport'         => $this->selective_refresh,
					'default'           => '{ "mobile": 748, "tablet": 992, "desktop": 1280 }',
				],
				[
					'section'               => $this->section,
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
							'vars'       => '--container-page',
							'responsive' => true,
							'suffix'     => 'px',
						],
					],
					'priority'              => 25,
				],
				'\Solace\Customizer\Controls\React\Responsive_Range'
			)
		);

		$this->add_control(
			new Control(
				'solace_page_hide_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'    => esc_html__( 'Disable Title', 'solace' ),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 25,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
	}

	/**
	 * Fuction used for active_callback control property.
	 *
	 * @return bool
	 */
	public static function is_cover_layout() {
		return get_theme_mod( 'solace_page_header_layout' ) === 'normal' && solace_is_new_skin();
	}
}
