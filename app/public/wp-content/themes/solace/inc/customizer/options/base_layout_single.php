<?php
/**
 * Common functionalities for pages and posts.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Defaults\Single_Post;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Base_Layout_Single
 *
 * @package Solace\Customizer\Options
 */
abstract class Base_Layout_Single extends Base_Customizer {

	use Single_Post;
	/**
	 * Post type slug
	 *
	 * @var string
	 */
	private $post_type;

	/**
	 * Controls section
	 *
	 * @var string
	 */
	public $section;

	/**
	 * Cover selector
	 *
	 * @var string
	 */
	private $cover_selector;

	/**
	 * Get the value for the $post_type.
	 *
	 * @return mixed
	 */
	abstract public function get_post_type();

	/**
	 * Get the value for the $post_type.
	 *
	 * @return mixed
	 */
	abstract public function get_cover_selector();

	/**
	 * Active callback function for callback
	 */
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

		/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_arrow_layout( $value ) {
		$allowed_values = array( 'inherit','boxed', 'fullwidth', 'left', 'right', 'custom' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'inherit';
		}

		return esc_html( $value );
	}

		/**
	 * Active callback function for advanced controls
	 */
	public function advanced_options_active_callback() {
		return get_theme_mod( 'solace_advanced_layout_options', false );
	}

	/**
	 * Base_Layout_Single constructor.
	 */
	public function __construct() {
		$this->post_type      = $this->get_post_type();
		$this->cover_selector = $this->get_cover_selector();
		$this->section        = 'solace_single_' . $this->post_type . '_layout';
	}

	/**
	 * Get the label for sections.
	 */
	private function get_section_label() {
		$labels = [
			'post' => esc_html__( 'Single Post', 'solace' ),
			'page' => esc_html__( 'Page', 'solace' ),
		];

		if ( array_key_exists( $this->post_type, $labels ) ) {
			return $labels[ $this->post_type ];
		}

		return '';
	}

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		if ( ! solace_is_new_skin() && $this->post_type !== 'post' ) {
			return;
		}
		$this->create_section();
		if ( solace_is_new_skin() ) {
			$this->add_header_layout_subsection();
			$this->add_header_layout_controls();
		}
	}

	/**
	 * Create the section
	 */
	private function create_section() {
		$this->add_section(
			new Section(
				'solace_single_' . $this->post_type . '_layout',
				[
					'priority' => 17,
					'title'    => $this->get_section_label(),
					// 'panel'    => 'solace_layout',
				]
			)
		);
	}

	/**
	 * Add header layout accordion.
	 */
	private function add_header_layout_subsection() {

		$this->add_control(
			new Control(
				// 'solace_page_layout',
				'solace_' . $this->post_type . '_layout',
				array(
					'sanitize_callback' => array( $this, 'sanitize_arrow_layout' ),
					'default'           => 'inherit',
				),
				array(
					'label'           => __( 'Container Layout', 'solace' ),
					'section'         => $this->section,
					'priority'        => 10,
					'choices'         => $this->solace_container_layout_choices( 'solace_' . $this->post_type . '_layout' ),
					// 'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'solace_' . $this->post_type . '_header_layout_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'            => esc_html__( 'Header Layoutx', 'solace' ),
					'section'          => $this->section,
					'priority'         => 5,
					'class'            => 'header_layout-accordion',
					'expanded'         => true,
					'accordion'        => true,
					'controls_to_wrap' => 15,
				],
				'Solace\Customizer\Controls\Heading'
			)
		);
	}

	/**
	 * Add controls for header layout.
	 */
	private function add_header_layout_controls() {

		$this->add_control(
			new Control(
				'solace_' . $this->post_type . '_header_layout',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => 'layout 1',
				],
				[
					'label'            => esc_html__( 'Single Layout', 'solace' ),
					'section'  => $this->section,
					'priority' => 2,
					'choices'  => [
						'layout 1' => [
							'name'  => esc_html__( 'Layout 1', 'solace' ),
							'image' => get_template_directory_uri() . '/assets/img/customizer/page-setting/single1.svg'
						],
						'layout 2'  => [
							'name'  => esc_html__( 'Layout 2', 'solace' ),
							'image' => get_template_directory_uri() . '/assets/img/customizer/page-setting/single2.svg'
						],
						'layout 3' => [
							'name'  => esc_html__( 'Layout 3', 'solace' ),
							'image' => get_template_directory_uri() . '/assets/img/customizer/page-setting/single3.svg'
						],						
						'custom' => [
							'name'  => esc_html__( 'Custom', 'solace' ),
							'image' => get_template_directory_uri() . '/assets/img/customizer/page-setting/single-custom.svg'
						],						
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_height',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_range_value',
		// 			'transport'         => $this->selective_refresh,
		// 			'default'           => '{ "mobile": 250, "tablet": 320, "desktop": 400 }',
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Cover height', 'solace' ),
		// 			'section'               => $this->section,
		// 			'type'                  => 'solace_responsive_range_control',
		// 			'input_attrs'           => [
		// 				'max'        => 700,
		// 				'units'      => [ 'px', 'vh', 'em', 'rem' ],
		// 				'defaultVal' => [
		// 					'mobile'  => 250,
		// 					'tablet'  => 320,
		// 					'desktop' => 400,
		// 					'suffix'  => [
		// 						'mobile'  => 'px',
		// 						'tablet'  => 'px',
		// 						'desktop' => 'px',
		// 					],
		// 				],
		// 			],
		// 			'priority'              => 15,
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'responsive' => true,
		// 					'vars'       => '--height',
		// 					'selector'   => $this->cover_selector,
		// 					'suffix'     => 'px',
		// 				],
		// 			],
		// 			'active_callback'       => [ $this, 'is_cover_layout' ],
		// 		],
		// 		'\Solace\Customizer\Controls\React\Responsive_Range'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_padding',
		// 		[
		// 			'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
		// 			'transport'         => $this->selective_refresh,
		// 			'default'           => $this->padding_default( 'cover' ),
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Cover padding', 'solace' ),
		// 			'section'               => $this->section,
		// 			'input_attrs'           => [
		// 				'units' => [ 'px', 'em', 'rem' ],
		// 				'min'   => 0,
		// 			],
		// 			'default'               => $this->padding_default( 'cover' ),
		// 			'priority'              => 20,
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => array(
		// 					'vars'       => '--padding',
		// 					'selector'   => $this->cover_selector,
		// 					'responsive' => true,
		// 				),
		// 			],
		// 			'active_callback'       => [ $this, 'is_cover_layout' ],
		// 		],
		// 		'\Solace\Customizer\Controls\React\Spacing'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_title_alignment',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_alignment',
		// 			'transport'         => $this->selective_refresh,
		// 			'default'           => self::post_title_alignment(),
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Title Alignment', 'solace' ),
		// 			'section'               => $this->section,
		// 			'priority'              => 30,
		// 			'choices'               => [
		// 				'left'   => [
		// 					'tooltip' => esc_html__( 'Left', 'solace' ),
		// 					'icon'    => 'editor-alignleft',
		// 				],
		// 				'center' => [
		// 					'tooltip' => esc_html__( 'Center', 'solace' ),
		// 					'icon'    => 'editor-aligncenter',
		// 				],
		// 				'right'  => [
		// 					'tooltip' => esc_html__( 'Right', 'solace' ),
		// 					'icon'    => 'editor-alignright',
		// 				],
		// 			],
		// 			'show_labels'           => true,
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'vars'       => [
		// 						'--textalign',
		// 						'--justify',
		// 					],
		// 					'valueRemap' => [
		// 						'--justify' => [
		// 							'left'   => 'flex-start',
		// 							'center' => 'center',
		// 							'right'  => 'flex-end',
		// 						],
		// 					],
		// 					'responsive' => true,
		// 					'selector'   => $this->cover_selector . ',' . $this->cover_selector . ' .container, ' . ( $this->post_type === 'post' ? '.entry-header' : '.nv-page-title-wrap' ),
		// 				],
		// 			],
		// 			'active_callback'       => $this->post_type === 'post' ? '__return_true' : function() {
		// 				return ! get_theme_mod( 'solace_page_hide_title', false );
		// 			},
		// 		],
		// 		'\Solace\Customizer\Controls\React\Responsive_Radio_Buttons'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_title_position',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_position',
		// 			'transport'         => $this->selective_refresh,
		// 			'default'           => [
		// 				'mobile'  => 'center',
		// 				'tablet'  => 'center',
		// 				'desktop' => 'center',
		// 			],
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Title Position', 'solace' ),
		// 			'section'               => $this->section,
		// 			'priority'              => 35,
		// 			'choices'               => [
		// 				'flex-start' => [
		// 					'tooltip' => esc_html__( 'Top', 'solace' ),
		// 					'icon'    => 'arrow-up',
		// 				],
		// 				'center'     => [
		// 					'tooltip' => esc_html__( 'Middle', 'solace' ),
		// 					'icon'    => 'sort',
		// 				],
		// 				'flex-end'   => [
		// 					'tooltip' => esc_html__( 'Bottom', 'solace' ),
		// 					'icon'    => 'arrow-down',
		// 				],
		// 			],
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'vars'       => '--valign',
		// 					'responsive' => true,
		// 					'selector'   => $this->cover_selector,
		// 				],
		// 			],
		// 			'show_labels'           => true,
		// 			'active_callback'       => function() {
		// 				return $this->post_type === 'post' ? $this->is_cover_layout() : $this->is_cover_layout() && ! get_theme_mod( 'solace_page_hide_title', false );
		// 			},
		// 		],
		// 		'\Solace\Customizer\Controls\React\Responsive_Radio_Buttons'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_background_color',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_colors',
		// 			'default'           => 'var(--sol-color-page-title-background)',
		// 			'transport'         => $this->selective_refresh,
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Overlay color', 'solace' ),
		// 			'section'               => $this->section,
		// 			'priority'              => 45,
		// 			'input_attrs'           => [
		// 				'allow_gradient' => true,
		// 			],
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => array(
		// 					'vars'     => '--bgcolor',
		// 					'selector' => $this->cover_selector . ' .nv-overlay',
		// 				),
		// 			],
		// 			'active_callback'       => [ $this, 'is_cover_layout' ],
		// 		],
		// 		'Solace\Customizer\Controls\React\Color'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_text_color',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_colors',
		// 			'default'           => 'var(--sol-color-page-title-text)',
		// 			'transport'         => $this->selective_refresh,
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Text color', 'solace' ),
		// 			'section'               => $this->section,
		// 			'priority'              => 50,
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'vars'     => '--color',
		// 					'selector' => $this->cover_selector . ' .nv-title-meta-wrap',
		// 				],
		// 			],
		// 			'active_callback'       => function() {
		// 				return $this->post_type === 'post' ? $this->is_cover_layout() : $this->is_cover_layout() && ! get_theme_mod( 'solace_page_hide_title', false );
		// 			},
		// 		],
		// 		'Solace\Customizer\Controls\React\Color'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_overlay_opacity',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_range_value',
		// 			'transport'         => $this->selective_refresh,
		// 			'default'           => 50,
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Overlay opacity', 'solace' ) . '(%)',
		// 			'section'               => $this->section,
		// 			'input_attrs'           => [
		// 				'min'        => 0,
		// 				'max'        => 100,
		// 				'step'       => 1,
		// 				'defaultVal' => 50,
		// 			],
		// 			'priority'              => 55,
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'vars'     => '--opacity',
		// 					'selector' => $this->cover_selector . ' .nv-overlay',
		// 				],
		// 			],
		// 			'active_callback'       => [ $this, 'is_cover_layout' ],
		// 		],
		// 		'Solace\Customizer\Controls\React\Range'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_hide_thumbnail',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_checkbox',
		// 			'default'           => false,
		// 		],
		// 		[
		// 			'label'           => esc_html__( 'Hide featured image', 'solace' ),
		// 			'section'         => $this->section,
		// 			'type'            => 'solace_toggle_control',
		// 			'priority'        => 60,
		// 			'active_callback' => [ $this, 'is_cover_layout' ],
		// 		],
		// 		'Solace\Customizer\Controls\Checkbox'
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_blend_mode',
		// 		[
		// 			'default'           => 'normal',
		// 			'sanitize_callback' => 'solace_sanitize_blend_mode',
		// 			'transport'         => $this->selective_refresh,
		// 		],
		// 		[
		// 			'label'                 => esc_html__( 'Blend mode', 'solace' ),
		// 			'section'               => $this->section,
		// 			'priority'              => 65,
		// 			'type'                  => 'select',
		// 			'choices'               => [
		// 				'normal'      => esc_html__( 'Normal', 'solace' ),
		// 				'multiply'    => esc_html__( 'Multiply', 'solace' ),
		// 				'screen'      => esc_html__( 'Screen', 'solace' ),
		// 				'overlay'     => esc_html__( 'Overlay', 'solace' ),
		// 				'darken'      => esc_html__( 'Darken', 'solace' ),
		// 				'lighten'     => esc_html__( 'Lighten', 'solace' ),
		// 				'color-dodge' => esc_html__( 'Color Dodge', 'solace' ),
		// 				'saturation'  => esc_html__( 'Saturation', 'solace' ),
		// 				'color'       => esc_html__( 'Color', 'solace' ),
		// 				'difference'  => esc_html__( 'Difference', 'solace' ),
		// 				'exclusion'   => esc_html__( 'Exclusion', 'solace' ),
		// 				'hue'         => esc_html__( 'Hue', 'solace' ),
		// 				'luminosity'  => esc_html__( 'Luminosity', 'solace' ),
		// 			],
		// 			'live_refresh_selector' => true,
		// 			'live_refresh_css_prop' => [
		// 				'cssVar' => [
		// 					'vars'     => '--blendmode',
		// 					'selector' => $this->cover_selector . ' .nv-overlay',
		// 				],
		// 			],
		// 			'active_callback'       => [ $this, 'is_cover_layout' ],
		// 		]
		// 	)
		// );

		// $this->add_control(
		// 	new Control(
		// 		'solace_' . $this->post_type . '_cover_container',
		// 		[
		// 			'default'           => 'contained',
		// 			'sanitize_callback' => 'solace_sanitize_container_layout',
		// 		],
		// 		[
		// 			'label'           => esc_html__( 'Cover container', 'solace' ),
		// 			'section'         => $this->section,
		// 			'priority'        => 70,
		// 			'type'            => 'select',
		// 			'choices'         => [
		// 				'contained'  => esc_html__( 'Contained', 'solace' ),
		// 				'full-width' => esc_html__( 'Full width', 'solace' ),
		// 			],
		// 			'active_callback' => function() {
		// 				return $this->post_type === 'post' ? $this->is_cover_layout() : $this->is_cover_layout() && ! get_theme_mod( 'solace_page_hide_title', false );
		// 			},
		// 		]
		// 	)
		// );

		$this->add_boxed_layout_controls(
			$this->post_type . '_cover_title',
			[
				'priority'               => 75,
				'section'                => $this->section,
				'has_text_color'         => false,
				'padding_default'        => $this->padding_default( 'cover' ),
				'background_default'     => 'var(--sol-color-page-title-background)',
				'boxed_selector'         => $this->cover_selector . ' .nv-is-boxed.nv-title-meta-wrap',
				'toggle_active_callback' => function() {
					return $this->post_type === 'post' ? $this->is_cover_layout() : $this->is_cover_layout() && ! get_theme_mod( 'solace_page_hide_title', false );
				},
				'active_callback'        => function() {
					$is_cover = $this->post_type === 'post' ? $this->is_cover_layout() : $this->is_cover_layout() && ! get_theme_mod( 'solace_page_hide_title', false );
					return $is_cover && get_theme_mod( 'solace_' . $this->post_type . '_cover_title_boxed_layout', false );
				},
			]
		);
	}

	/**
	 * Fuction used for active_callback control property.
	 *
	 * @return bool
	 */
	abstract public static function is_cover_layout();

	/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function solace_container_layout_choices( $control_id ) {
		$options = apply_filters(
			'solace_' . $this->post_type . '_layout',
			array(
				'inherit' => array(         
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_inherit.svg',
				),
				'boxed' => array(         
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_boxed.svg',
				),
				'fullwidth'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_wide.svg',
				),
				'left'      => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_left.svg',
				),
				'right'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_right.svg',
				),
				'custom'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/layout_wide.svg',
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
