<?php

/**
 * Blog layout section.
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
 * Class Layout_Blog
 *
 * @package Solace\Customizer\Options
 */
class Layout_Blog extends Base_Customizer
{
	use Layout;

	/**
	 * Holds the section name.
	 *
	 * @var string $section
	 */
	private $section = 'solace_blog_archive_layout';

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls()
	{
		$this->section_blog();
		$this->add_layout_controls();
		$this->add_featured_post();
		$this->add_content_ordering_controls();
		$this->add_post_meta_controls();
		$this->add_typography_shortcut();

		add_action('customize_register', [$this, 'adapt_old_pro'], PHP_INT_MAX);
	}

	/**
	 * Adapting old pro versions to make them still usable with the old theme version.
	 */
	public function adapt_old_pro()
	{
		if (!defined('SOLACE_PRO_VERSION')) {
			return;
		}

		if (version_compare(SOLACE_PRO_VERSION, '1.2.8', '>')) {
			return;
		}

		$changes = [
			'solace_posts_order'                   => ['priority' => 51],
			'solace_post_content_ordering'         => ['active_callback' => '__return_true'],
			'solace_single_post_element'           => ['active_callback' => '__return_true'],
			'solace_blog_ordering_content_heading' => ['controls_to_wrap' => 6],
			'solace_blog_post_meta_heading'        => ['controls_to_wrap' => 3],
			'solace_read_more_options'             => [
				'accordion' => true,
				'expanded'  => false,
				'class'     => 'read-more-options-accordion',
			],
		];

		foreach ($changes as $control_slug => $props) {
			foreach ($props as $prop => $new_value) {
				$this->change_customizer_object('control', $control_slug, $prop, $new_value);
			}
		}

		$this->wpc->remove_control('solace_metadata_options');
	}

	/**
	 * Add customize section
	 */
	private function section_blog()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'priority' => 16,
					'title'    => esc_html__('Blog / Archive', 'solace'),
				)
			)
		);

		
	}

	/**
	 * Add blog layout controls.
	 */
	private function add_layout_controls()
	{
		$this->add_control(
			new Control(
				'solace_jump_to_blog_page_title',
				[
					'sanitize_callback' => '',
				],
				[
					'label'    => __( 'Link', 'solace' ),
					'section'  => $this->section,
					'priority' => 0,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => [ 'section', 'solace_blog_page_title' ],
						'string' => esc_html__( 'Blog Page Title', 'solace' ),
					],
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);		

		// $this->add_control(
		// 	new Control(
		// 		'solace_blog_layout_hide_title',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_checkbox',
		// 			'default'           => false,
		// 		],
		// 		[
		// 			'label'           => esc_html__( 'Hide Title', 'solace' ),
		// 			'section'         => $this->section,
		// 			'type'            => 'solace_toggle_control',
		// 			'priority'        => 1,
					
		// 		],
		// 		'Solace\Customizer\Controls\Checkbox'
		// 	)
		// );

		$this->add_control(
			new Control(
				'solace_blog_layout_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'label'            => esc_html__('Blog Layout', 'solace'),
					'section'          => $this->section,
					'priority'         => 10,
					'class'            => 'blog-layout-accordion',
					'accordion'        => false,
					'controls_to_wrap' => 6,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				$this->section,
				[
					'default'           => '1x3',
					'sanitize_callback' => [$this, 'sanitize_blog_layout'],
				],
				[
					'section'  => $this->section,
					'priority' => 11,
					'choices'  => [
						'3x3' => [
							'name'  => __('3 columns', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/blog-layout/3x3.svg',
						],
						'2x3'  => [
							'name'  => __('2 columns', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/blog-layout/2x3.svg',
						],
						'1x3'    => [
							'name'  => __('1 column', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/blog-layout/1x3.svg',
						],
						'custom'    => [
							'name'  => __('Custom', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/blog-layout/custom.png',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$grid_layout_default = solace_is_new_skin() ? '{"desktop":3,"tablet":2,"mobile":1}' : '{"desktop":1,"tablet":1,"mobile":1}';

		$this->add_control(
			new Control(
				'solace_grid_layout',
				array(
					'sanitize_callback' => 'solace_sanitize_range_value',
					'default'           => $grid_layout_default,
				),
				array(
					'label'           => esc_html__('Columns', 'solace'),
					'section'         => $this->section,
					'units'           => array(
						'items',
					),
					'input_attrs'     => [
						'min'        => 1,
						'max'        => 4,
						'defaultVal' => json_decode($grid_layout_default, true),
					],
					'priority'        => 11,
					'active_callback' => array($this, 'is_column_layout'),
				),
				'Solace\Customizer\Controls\React\Responsive_Range'
			)
		);

		$this->add_control(
			new Control(
				'solace_blog_covers_text_color',
				array(
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => '#ffffff',
					'transport'         => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Text Color', 'solace'),
					'section'               => $this->section,
					'priority'              => 15,
					'default'               => '#ffffff',
					'active_callback'       => function () {
						return get_theme_mod($this->section) === 'covers';
					},
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--color',
							'selector' => '.solace-main',
						],
					],
				),
				'Solace\Customizer\Controls\React\Color'
			)
		);

		// $this->add_control(
		// 	new Control(
		// 		'solace_archive_hide_title',
		// 		[
		// 			'sanitize_callback' => 'solace_sanitize_checkbox',
		// 			'default'           => false,
		// 		],
		// 		[
		// 			'label'           => esc_html__('Disable Title', 'solace'),
		// 			'section'         => $this->section,
		// 			'type'            => 'solace_toggle_control',
		// 			'priority'        => 16,
		// 			'active_callback' => function () {
		// 				return get_option('show_on_front') !== 'posts';
		// 			},
		// 		],
		// 		'Solace\Customizer\Controls\Checkbox'
		// 	)
		// );

		$this->add_control(
			new Control(
				'solace_blog_list_alternative_layout',
				array(
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'type'            => 'solace_toggle_control',
					'priority'        => 17,
					'section'         => $this->section,
					'label'           => esc_html__('Alternating layout', 'solace'),
					'active_callback' => function () {
						$is_list_layout = get_theme_mod($this->section) === 'default';
						$has_image      = true;
						if ($is_list_layout) {
							$has_image = defined('SOLACE_PRO_VERSION') ? get_theme_mod('solace_blog_list_image_position', 'left') !== 'no' : false;
						}
						return $is_list_layout && $has_image;
					},
				)
			)
		);

		$this->add_control(
			new Control(
				'solace_enable_masonry',
				array(
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'type'            => 'solace_toggle_control',
					'priority'        => 35,
					'section'         => $this->section,
					'label'           => esc_html__('Enable Masonry', 'solace'),
					'active_callback' => array($this, 'should_show_masonry'),
				)
			)
		);

		$this->add_control(
			new Control(
				'solace_jump_to_container',
				[
					'sanitize_callback' => '',
				],
				[
					'label'    => __( 'Link', 'solace' ),
					'section'  => $this->section,
					'priority' => 36,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => [ 'section', 'solace_container' ],
						'string' => esc_html__( 'Go to Container Setting', 'solace' ),
					],
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);			

		$this->add_control(
			new Control(
				'solace_archive_maximum_excerpt_length',
				array(
					'sanitize_callback' => 'absint',
					'default'           => 55,
				),
				array(
					'label'       => esc_html__('Maximum Excerpt Length', 'solace'),
					'section'  => $this->section,
					'priority'    => 36,
					'type'        => 'solace_range_control',
					'input_attrs' => [
						'min'        => 0,
						'max'        => 300,
						'defaultVal' => 55,
					],
				),
				'Solace\Customizer\Controls\React\Range'
			)
		);		

		$this->add_control(
			new Control(
				'solace_blog_post_navigation',
				array(
					'sanitize_callback' => array( $this, 'sanitize_post_navigation_layout' ),
					'default'           => 'number',
				),
				array(
					'label'           => esc_html__( 'Post Navigation', 'solace' ),
					'section'         => $this->section,
					'priority'        => 37,
					'choices'         => $this->post_navigation_choices( 'solace_blog_post_navigation_post_navigation' ),
					'active_callback' => array( $this, 'sidewide_options_active_callback' ),
				),
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);
	}

	/**
	 * Add featured post controls.
	 */
	private function add_featured_post()
	{
		$this->add_control(
			new Control(
				'solace_featured_post_heading',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'            => esc_html__('Featured Post', 'solace'),
					'section'          => $this->section,
					'priority'         => 40,
					'class'            => 'featured-post-accordion',
					'accordion'        => true,
					'expanded'         => false,
					'controls_to_wrap' => 2,
				],
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				'solace_enable_featured_post',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'    => esc_html__('Enable featured post section', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 41,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$this->add_control(
			new Control(
				'solace_featured_post_target',
				array(
					'default'           => 'latest',
					'sanitize_callback' => array($this, 'sanitize_featured_post_target'),
				),
				array(
					'label'           => esc_html__('Featured Post', 'solace'),
					'section'         => $this->section,
					'priority'        => 42,
					'type'            => 'select',
					'choices'         => [
						'latest' => esc_html__('Latest Post', 'solace'),
						'sticky' => esc_html__('Sticky Post', 'solace'),
					],
					'active_callback' => function () {
						return get_theme_mod('solace_enable_featured_post', false);
					},
				)
			)
		);
	}

	/**
	 * Add content ordering and controls.
	 */
	private function add_content_ordering_controls()
	{
		$this->add_control(
			new Control(
				'solace_blog_ordering_content_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'label'            => esc_html__('Ordering and Content', 'solace'),
					'section'          => $this->section,
					'priority'         => 50,
					'class'            => 'blog-layout-ordering-content-accordion',
					'accordion'        => true,
					'expanded'         => false,
					'controls_to_wrap' => 4,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				'solace_pagination_type',
				array(
					'default'           => 'number',
					'sanitize_callback' => array($this, 'sanitize_pagination_type'),
				),
				array(
					'label'    => esc_html__('Post Pagination', 'solace'),
					'section'  => $this->section,
					'priority' => 53,
					'type'     => 'select',
					'choices'  => array(
						'number'   => esc_html__('Number', 'solace'),
						'infinite' => esc_html__('Infinite Scroll', 'solace'),
						'jump-to'  => esc_html__('Number', 'solace') . ' & ' . esc_html__('Search Field', 'solace'),
					),
				)
			)
		);

		$order_default_components = array(
			'thumbnail',
			'title-meta',
			'excerpt',
		);

		$components = array(
			'thumbnail'  => __('Thumbnail', 'solace'),
			'title-meta' => __('Title & Meta', 'solace'),
			'excerpt'    => __('Excerpt', 'solace'),
		);

		$this->add_control(
			new Control(
				'solace_post_content_ordering',
				array(
					'sanitize_callback' => array($this, 'sanitize_post_content_ordering'),
					'default'           => wp_json_encode($order_default_components),
				),
				array(
					'label'      => esc_html__('Post Content Order', 'solace'),
					'section'    => $this->section,
					'components' => $components,
					'priority'   => 55,
				),
				'Solace\Customizer\Controls\React\Ordering'
			)
		);

		$this->add_control(
			new Control(
				'solace_post_excerpt_length',
				array(
					'sanitize_callback' => 'solace_sanitize_range_value',
					'default'           => 25,
				),
				array(
					'label'       => esc_html__('Excerpt Length', 'solace'),
					'section'     => $this->section,
					'type'        => 'solace_range_control',
					'input_attrs' => [
						'min'        => 5,
						'max'        => 300,
						'defaultVal' => 25,
						'step'       => 5,
					],
					'priority'    => 58,
				),
				'Solace\Customizer\Controls\React\Range'
			)
		);

		$this->add_control(
			new Control(
				'solace_post_thumbnail_box_shadow',
				array(
					'sanitize_callback' => 'absint',
					'default'           => 0,
				),
				array(
					'label'       => esc_html__('Thumbnail Shadow', 'solace'),
					'section'     => $this->section,
					'type'        => 'solace_range_control',
					'step'        => 1,
					'input_attrs' => [
						'min'        => 0,
						'max'        => 5,
						'defaultVal' => 0,
					],
					'priority'    => 59,
				),
				'Solace\Customizer\Controls\React\Range'
			)
		);
	}

	/**
	 * Add controls for post meta.
	 */
	private function add_post_meta_controls()
	{
		$this->add_control(
			new Control(
				'solace_blog_post_meta_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'label'            => esc_html__('Post Meta', 'solace'),
					'section'          => $this->section,
					'priority'         => 70,
					'class'            => 'blog-layout-post-meta-accordion',
					'accordion'        => true,
					'controls_to_wrap' => 5,
					'expanded'         => false,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);


		$default       = wp_json_encode(['author', 'date', 'comments']);
		$default_value = solace_get_default_meta_value('solace_post_meta_ordering', $default);
		$this->add_control(
			new Control(
				'solace_blog_post_meta_fields',
				[
					'sanitize_callback' => 'solace_sanitize_meta_repeater',
					'default'           => wp_json_encode($default_value),
				],
				[
					'label'            => esc_html__('Meta Order', 'solace'),
					'section'          => $this->section,
					'fields'           => [
						'hide_on_mobile' => [
							'type'  => 'checkbox',
							'label' => __('Hide on mobile', 'solace'),
						],
					],
					'components'       => apply_filters(
						'solace_meta_filter',
						array(
							'author'   => __('Author', 'solace'),
							'category' => __('Category', 'solace'),
							'date'     => __('Date', 'solace'),
							'comments' => __('Comments', 'solace'),
						)
					),
					'allow_new_fields' => 'no',
					'priority'         => 71,
					'active_callback'  => [$this, 'should_show_meta_order'],
				],
				'\Solace\Customizer\Controls\React\Repeater'
			)
		);

		$this->add_control(
			new Control(
				'solace_metadata_separator',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => esc_html('/'),
				),
				array(
					'priority'    => 72,
					'section'     => $this->section,
					'label'       => esc_html__('Separator', 'solace'),
					'description' => esc_html__('For special characters make sure to use Unicode. For example > can be displayed using \003E.', 'solace'),
					'type'        => 'text',
				)
			)
		);

		$this->add_control(
			new Control(
				'solace_author_avatar',
				array(
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'label'    => esc_html__('Show Author Avatar', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 73,
				)
			)
		);

		$this->add_control(
			new Control(
				'solace_author_avatar_size',
				array(
					'sanitize_callback' => 'solace_sanitize_range_value',
					'default'           => '{ "mobile": 20, "tablet": 20, "desktop": 20 }',
				),
				array(
					'label'           => esc_html__('Avatar Size', 'solace'),
					'section'         => $this->section,
					'units'           => array(
						'px',
					),
					'input_attr'      => array(
						'mobile'  => array(
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						),
						'tablet'  => array(
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						),
						'desktop' => array(
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						),
					),
					'input_attrs'     => [
						'min'        => self::RELATIVE_CSS_UNIT_SUPPORTED_MIN_VALUE,
						'max'        => 50,
						'defaultVal' => [
							'mobile'  => 20,
							'tablet'  => 20,
							'desktop' => 20,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
						'units'      => ['px', 'em', 'rem'],
					],
					'priority'        => 74,
					'active_callback' => function () {
						return get_theme_mod('solace_author_avatar', false);
					},
					'responsive'      => true,
				),
				'Solace\Customizer\Controls\React\Responsive_Range'
			)
		);

		$this->add_control(
			new Control(
				'solace_show_last_updated_date',
				array(
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'label'    => esc_html__('Use last updated date instead of the published one', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 85,
				)
			)
		);
	}

	/**
	 * Sanitize the container layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_blog_layout($value)
	{
		$allowed_values = array('3x3', '2x3', '1x3', 'custom');
		if (!in_array($value, $allowed_values, true)) {
			return '1x3';
		}

		return sanitize_text_field($value);
	}

	/**
	 * Sanitize the pagination type
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_pagination_type($value)
	{
		$allowed_values = array('number', 'infinite', 'jump-to');
		if (!in_array($value, $allowed_values, true)) {
			return 'number';
		}

		return esc_html($value);
	}

	/**
	 * Sanitize featured post target
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_featured_post_target($value)
	{
		$allowed_values = ['sticky', 'latest'];
		if (!in_array($value, $allowed_values, true)) {
			return 'latest';
		}

		return esc_html($value);
	}

	/**
	 * Sanitize content order control.
	 */
	public function sanitize_post_content_ordering($value)
	{
		$allowed = array(
			'thumbnail',
			'title-meta',
			'excerpt',
		);

		if (empty($value)) {
			return wp_json_encode($allowed);
		}

		$decoded = json_decode($value, true);

		foreach ($decoded as $val) {
			if (!in_array($val, $allowed, true)) {
				return wp_json_encode($allowed);
			}
		}

		return $value;
	}

	/**
	 * Sanitize the arrow layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return string
	 */
	public function sanitize_post_navigation_layout( $value ) {
		$allowed_values = array( 'infinite', 'number', 'arrow' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'number';
		}

		return esc_html( $value );
	}

	/**
	 * Callback to show the meta order control.
	 *
	 * @return bool
	 */
	public function should_show_meta_order()
	{
		$default       = array(
			'thumbnail',
			'title-meta',
			'excerpt',
		);
		$content_order = get_theme_mod('solace_post_content_ordering', wp_json_encode($default));
		$content_order = json_decode($content_order, true);
		if (!in_array('title-meta', $content_order, true)) {
			return false;
		}

		return true;
	}

	/**
	 * Callback to show grid columns control.
	 *
	 * @return bool
	 */
	public function is_column_layout()
	{
		$blog_layout = get_theme_mod($this->section, '1x3');

		return in_array($blog_layout, ['1x3', '2x3'], true);
	}

	/**
	 * Callback to show masonry control.
	 *
	 * @return bool
	 */
	public function should_show_masonry()
	{
		if (!$this->is_column_layout()) {
			return false;
		}

		$columns = json_decode(get_theme_mod('solace_grid_layout', $this->grid_columns_default()), true);
		$columns = array_filter(
			array_values($columns),
			function ($value) {
				return $value > 1;
			}
		);

		if (empty($columns)) {
			return false;
		}

		return true;
	}

	/**
	 * Add typography shortcut.
	 */
	private function add_typography_shortcut()
	{
		$this->add_control(
			new Control(
				'solace_blog_typography_shortcut',
				array(
					'sanitize_callback' => 'solace_sanitize_text_field',
				),
				array(
					'button_class'     => 'nv-top-bar-menu-shortcut',
					'text_before'      => __('Customize Typography for the Archive page', 'solace'),
					'text_after'       => '.',
					'button_text'      => __('here', 'solace'),
					'is_button'        => false,
					'control_to_focus' => 'solace_archive_typography_post_title_accordion_wrap',
					'shortcut'         => true,
					'section'          => $this->section,
					'priority'         => 1000,
				),
				'\Solace\Customizer\Controls\Button'
			)
		);
	}
		/**
	 * Get the Arrow layout choices.
	 *
	 * @param string $control_id Name of the control.
	 *
	 * @return array
	 */
	private function post_navigation_choices( $control_id ) {
		$options = apply_filters(
			'solace_blog_post_navigation_post_navigation',
			array(
				'infinite' => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/infinite.svg',
				),
				'number'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/number.svg',
				),
				'arrow'       => array(
					'url'  => get_template_directory_uri() . '/assets/img/customizer/arrow.svg',
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
	 * Active callback function for site-wide options
	 */
	public function sidewide_options_active_callback() {
		return ! $this->advanced_options_active_callback();
	}

	/**
	 * Active callback function for advanced controls
	 */
	public function advanced_options_active_callback() {
		return get_theme_mod( 'solace_blog_post_navigation', false );
	}
}
// <<<<<<< HEAD