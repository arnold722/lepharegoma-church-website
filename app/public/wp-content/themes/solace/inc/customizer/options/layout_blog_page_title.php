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
 * Class Layout_Blog_Page_Title
 *
 * @package Solace\Customizer\Options
 */
class Layout_Blog_Page_Title extends Base_Customizer {
	use Layout;
	const ICON_COLOR_ID  = 'icon_color_setting';
	
    /**
	 * Holds the section name.
	 *
	 * @var string $section
	 */
	private $section = 'solace_blog_page_title';


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
				$this->section,
				array(
					'priority' => 102,
					'title'    => esc_html__( 'Blog Page Title', 'solace' ),
					// 'panel'	   => 'solace_features',
				)
			)
		);
	}

	private function add_main_controls() {

		$this->add_control(
			new Control(
				'solace_blog_page_title_tabs',
				array(
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				),
				array(
					'priority'         => 1,
					'section'  => $this->section,
					'tabs'     => array(
						'general'           => array(
							'label' => esc_html__( 'General', 'solace' ),
						),
						'design' => array(
							'label' => esc_html__( 'Design', 'solace' ),
						),
					),
					'controls' => array(
						'general'           => array(					
							'solace_blog_page_title_page_header' 		  => array(),
							'solace_blog_page_title_breadcrumb'   		  => array(),							
							'solace_blog_page_title_blog_title'   		  => array(),							
							'solace_blog_page_title_blog_description'     => array(),							
							'solace_blog_page_title_horizontal_alignment' => array(),							
							'solace_blog_page_title_vertical_spacing'     => array(),							
						),						
						'design' => array(
							'solace_blog_page_title_font_color'      => array(),
							'solace_blog_page_title_area_background' => array(),
						),																	
					),
				),
				'Solace\Customizer\Controls\Tabs_Custom'
			)
		);	

		$this->add_control(
			new Control(
				'solace_blog_page_title_page_header',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Enable Page Header', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 1,
					
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
		
		$this->add_control(
			new Control(
				'solace_blog_page_title_breadcrumb',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Breadcrumb', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 2,
					
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
		
		$this->add_control(
			new Control(
				'solace_blog_page_title_blog_title',
				// 'solace_blog_layout_hide_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Blog Title', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 3,
					
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
		
		$this->add_control(
			new Control(
				'solace_blog_page_title_blog_description',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Blog Description', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 4,
					
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$this->add_control(
			new Control(
				'solace_blog_page_title_horizontal_alignment',
				array(
					'sanitize_callback' => array( $this, 'sanitize_horizontal_alignment_layout' ),
					'default'           => 'left',
				),
				array(
					'label'           => esc_html__( 'Horizontal Alignment', 'solace' ),
					// 'type' 			  => 'solace_responsive_toggle_control',
					'section'         => $this->section,
					'priority'        => 5,
					'choices'         => $this->horizontal_alignment_choices( 'solace_blog_page_title_horizontal_alignment' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'solace_blog_page_title_vertical_spacing',
				[
					'sanitize_callback' => 'solace_sanitize_range_value',

					'default'           => 20,
				],
				[
					'label'           => esc_html__( 'Vertical Spacing', 'solace' ),
					'section'         => $this->section,
					'default'         => '{ "mobile": "20", "tablet": "20", "desktop": "20" }',
					'type'            => 'solace_range_control',
					
					'priority'        => 6,
					'hide_responsive_switches' => true,
					'media_query'              => true,
					'step'                     => 1,
					'input_attrs'     => [
						'min'        => 0,
						'max'        => 100,
						'defaultVal' => 20,
					],
				],
				
				'Solace\Customizer\Controls\React\Responsive_Range'
			)
		);		
		
		$this->add_control(
			new Control(
				'solace_blog_page_title_font_color',
				array(
					'default'               => 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Font Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> $this->section,
					'priority'        		=> 5,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--blog-page-title-font-color',
							'selector' => '.archive-header .solace-header.solace-blog-title,
							.archive-header .solace-header.solace-description h1',
						),
					],
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_blog_page_title_area_background',
				array(
					'default'               => 'var(--sol-color-page-title-background)',
					'sanitize_callback'     => 'solace_sanitize_colors',
				),
				array(
					'transport'             => 'postMessage',
					'label'                 => __( 'Content Area Background', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         => $this->section,
					'priority'        => 6,
				)
				
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
		$allowed_values = array( 'general', 'design' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'general';
		}

		return esc_html( $value );
	}
	/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_horizontal_alignment_layout( $value ) {
		$allowed_values = array( 'left', 'center', 'right' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'left';
		}

		return esc_html( $value );
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
		return get_theme_mod( 'solace_blog_page_title_tabs', false );
	}

	/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function tabs_layout_choices( $control_id ) {
		$options = apply_filters(
			'solace_blog_page_title_tabs',
			array(
				'general' => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/rectangle.svg',
				),
				'design'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/rectangle.svg',
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

		/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function horizontal_alignment_choices( $control_id ) {
		$options = apply_filters(
			'solace_blog_page_title_horizontal_alignment',
			array(
				'left' => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/ha_left.svg',
				),
				'center'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/ha_center.svg',
				),
				'right'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/ha_right.svg',
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
