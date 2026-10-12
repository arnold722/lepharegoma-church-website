<?php
/**
 * Single post layout section.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use HFG\Traits\Core;
use Solace\Customizer\Defaults\Layout;
use Solace\Customizer\Types\Control;

/**
 * Class Layout_Single_Post
 *
 * @package Solace\Customizer\Options
 */
class Layout_Single_Post extends Base_Layout_Single {
	use Core;
	use Layout;

	/**
	 * Returns the post type.
	 *
	 * @return string
	 */
	public function get_post_type() {
		return 'post';
	}

	/**
	 * @return string
	 */
	public function get_cover_selector() {
		return '.single .nv-post-cover';
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
				'solace_blog_single_post',
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
						'layout'           => array(
							'label' => esc_html__( 'Layout', 'solace' ),
						),	
						'design' => array(
							'label' => esc_html__( 'Design', 'solace' ),
						),
					),
					'controls' => array(
						'general'           => array(
							Config::MODS_BLOG_POST_FEATURED_IMAGE   => array(),
							Config::MODS_BLOG_POST_DESIGN_MARGIN    => array(),
							Config::MODS_BLOG_POST_DESIGN_SEPARATOR => array(),
							Config::MODS_BLOG_POST_DESIGN_TITLE => array(),
							Config::MODS_BLOG_POST_DESIGN_POST_META => array(),
							'solace_single_post_element'    => array(),
							'solace_single_only_available_for_custom_layout'    => array(),
							'solace_single_show_author_box' => array(),
							'solace_single_show_comments'   => array(),						
							'solace_show_single_post_navigation' => array(),
							'solace_show_single_related_posts'   => array(),							
						),						
						'layout'           => array(
							'solace_post_header_layout' 			 => array(),
							'solace_post_layout'	    			 => array(),
							'solace_layout_single_post_social_order' => array(),
						),							
						'design' => array(
							'solace_single_post_label_link_highlights' => array(),
							'solace_single_post_link_initial'          => array(),
							'solace_single_post_link_hover'            => array(),
							'solace_single_post_label_content_area'    => array(),
							'solace_single_post_background'		       => array(),
							'solace_single_post_box_shadow'    		   => array(),
							'solace_single_post_padding'    		   => array(),
							'solace_single_post_border_radius'         => array(),
						),																	
					),
				),
				'Solace\Customizer\Controls\Tabs_Custom'
			)
		);		

		// ==================== Design ====================
		$this->add_control(
			new Control(
				'solace_single_post_label_link_highlights',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Link Highlights', 'solace' ),
					'section'         => $this->section,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);		

		$this->add_control(
			new Control(
				'solace_single_post_link_initial',
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'var(--sol-color-link-button-initial)',
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__( 'Text Color', 'solace' ),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--single-link-color',
							'selector' => 'body.single a, div.preview a',
						),
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);		

		$this->add_control(
			new Control(
				'solace_single_post_link_hover',
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'var(--sol-color-link-button-hover)',
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__( 'Text Color Hover', 'solace' ),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--single-link-hover',
							'selector' => 'body.single a:hover, div.preview a:hover',
						),
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);			

		$this->add_control(
			new Control(
				'solace_single_post_label_content_area',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Content Area', 'solace' ),
					'section'         => $this->section,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);		

		$this->add_control(
			new Control(
				'solace_single_post_background',
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'var(--sol-color-background)',
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__( 'Background', 'solace' ),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--single-bg',
							'selector' => 'body.single, div.preview',
						),
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);			

		$this->add_control(
			new Control(
				'solace_single_post_box_shadow',
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => 'transparant',
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__( 'Box Shadow', 'solace' ),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--single-box-shadow',
							'selector' => '.main-single .container-single .row1 article .boxes-ordering',
						),
					],
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);		

		$padding = [
			'mobile'       => [
				'top'    => 20,
				'right'  => 20,
				'bottom' => 20,
				'left'   => 20,
			],
			'tablet'       => [
				'top'    => 30,
				'right'  => 30,
				'bottom' => 30,
				'left'   => 30,
			],
			'desktop'      => [
				'top'    => 40,
				'right'  => 40,
				'bottom' => 40,
				'left'   => 40,
			],
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		];		

		$this->add_control(
			new Control(
				'solace_single_post_padding',
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => 'postMessage',
					'default'           => $padding,
				],
				[
					'label'                 => esc_html__( 'Padding', 'solace' ),
					'section'               => $this->section,
					'input_attrs'           => [
						'units' => [ 'px', 'em', 'rem' ],
						'min'   => 0,
					],
					'default'               => $padding,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'       => '--single-padding-area',
							'selector'   => 'body.single .main-single article.status-publish, div.preview .main-single article.status-publish',
							'responsive' => true,
						),
					],
				],
				'\Solace\Customizer\Controls\React\Spacing'
			)
		);		

		$border_radius = [
			'mobile'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'tablet'       => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'desktop'      => [
				'top'    => 0,
				'right'  => 0,
				'bottom' => 0,
				'left'   => 0,
			],
			'mobile-unit'  => 'px',
			'tablet-unit'  => 'px',
			'desktop-unit' => 'px',
		];		

		$this->add_control(
			new Control(
				'solace_single_post_border_radius',
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => 'postMessage',
					'default'           => $border_radius,
				],
				[
					'label'                 => esc_html__( 'Border Radius', 'solace' ),
					'section'               => $this->section,
					'input_attrs'           => [
						'units' => [ 'px' ],
						'min'   => 0,
					],
					'default'               => $border_radius,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'       => '--single-border-radius',
							'selector'   => '.main-single .container-single .row1 article .boxes-ordering',
							'responsive' => true,
						),
					],
				],
				'\Solace\Customizer\Controls\React\Spacing'
			)
		);				

		// ==================== General ====================
		$defaults = Mods::get_alternative_mod_default( Config::MODS_BLOG_POST_FEATURED_IMAGE );
		$this->add_control(
			new Control(
				Config::MODS_BLOG_POST_FEATURED_IMAGE,
				[
					// 'sanitize_callback' => 'sanitize_featured_image',
					// 'transport' 	    => $this->selective_refresh,
					'transport' 	    => 'refresh',
					'default'   	    => $defaults,
				],
				[
					'label'                 => esc_html__( 'Post Element: Featured Image', 'solace' ),
					'section'               => $this->section,
					'choices'               => [
						// 'imageRatio'  => [
						// 	'unset' => esc_html__( 'Original', 'solace' ),
						// 	'100%'  => esc_html__( '1/1', 'solace' ),
						// 	'75%'  	=> esc_html__( '4/3', 'solace' ),
						// 	'56.3%' => esc_html__( '16/9', 'solace' ),
						// 	'50%'  	=> esc_html__( '2/1', 'solace' ),
						// ],
						'imageRatio'  => [
							'original' => esc_html__( 'Original', 'solace' ),
							'1/1'  => esc_html__( '1/1', 'solace' ),
							'4/3'  	=> esc_html__( '4/3', 'solace' ),
							'16/9' => esc_html__( '16/9', 'solace' ),
							'2/1'  	=> esc_html__( '2/1', 'solace' ),
						],
						'imageScale'     => [
							'contain' => esc_html__( 'Contain', 'solace' ),
							'cover'   => esc_html__( 'Cover', 'solace' ),
							'fill'    => esc_html__( 'Fill', 'solace' ),
						],
						'imageSize' => [
							'full'         			=> esc_html__( 'Full', 'solace' ),
							'large' 	   			=> esc_html__( 'Large', 'solace' ),
							'medium_large' 			=> esc_html__( 'Medium Large', 'solace' ),
							'medium' 	   			=> esc_html__( 'Medium', 'solace' ),
							'thumbnail'    		    => esc_html__( 'Thumbnail', 'solace' ),
							'solace-single2'        => esc_html__( '2000x975', 'solace' ),
							'solace-single-default' => esc_html__( '1220x700', 'solace' ),
							'solace-default-blog'   => esc_html__( '1214x715', 'solace' ),							
							'solace-related-posts'  => esc_html__( '250x277', 'solace' ),							
						],
						'imageVisibility' => true,
					],
					'show_labels'           => true,
					'live_refresh_selector' => 'body',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--singleimageRatio'    => [
									'key'        => 'imageRatio',
									'responsive' => true,
								],								
								'--singleimageScale' 	  => [
									'key'        => 'imageScale',
									'responsive' => true,
								],							
								'--singleimageSize' 	  => [
									'key'        => 'imageSize',
									'responsive' => true,
								],							
								'--singleimageVisibility' 	  => [
									'key'        => 'imageVisibility',
									'responsive' => true,
								],							
							],
							'selector' => 'body',
						],
					],					
				],
				'\Solace\Customizer\Controls\React\Featured_Image'
			)
		);		

		$this->add_control(
			new Control(
				Config::MODS_BLOG_POST_DESIGN_MARGIN,
				[
					'sanitize_callback' => [ $this, 'sanitize_spacing_array' ],
					'transport'         => 'postMessage',
					'default'           => $this->margin_divider_default(),
				],
				[
					'label'                 => esc_html__( 'Margin', 'solace' ),
					'section'               => $this->section,
					'input_attrs'           => [
						'units' => [ 'px', 'em' ],
						'min'   => 0,
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'       => '--single-margin-divider',
							'selector'   => '.main-single-custom .container-single .row1 article .boxes-ordering .divider-border',
							'responsive' => true,
						),
					],
				],
				'\Solace\Customizer\Controls\React\Spacing_Divider'
			)
		);		
	
		$this->add_control(
			new Control(
				Config::MODS_BLOG_POST_DESIGN_SEPARATOR,
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'transport'         => 'refresh',
					'default'           => 'separator1',
				],
				[
					'label'                 => esc_html__( 'Separator', 'solace' ),
					'is_for'                => 'separators',
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'       => '--single-design-separator',
							'selector'   => '.main-single .container-single .row1 article .boxes-ordering .the-categories',
							'responsive' => true,
						),
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Popup'
			)
		);			

		$order_default_components = array(
			'featured-image',
			'categories',
			'title',
			'post-meta',
			'content',
			'tags',
			'divider',
		);

		$prefix = 'solace_single_post_element';
		$order_default_components = array(
			$prefix . '-featured-image',
			$prefix . '-categories',
			$prefix . '-title',
			$prefix . '-post-meta',
			$prefix . '-content',
			$prefix . '-tags',
			$prefix . '-divider',
		);		

		$components = array(
			'featured-image'   => __( 'Featured Image', 'solace' ),
			'categories'       => __( 'Categories', 'solace' ),
			'title'            => __( 'Title', 'solace' ),
			'post-meta'        => __( 'Post Meta', 'solace' ),
			'content'          => __( 'Content', 'solace' ),
			'tags'             => __( 'Tags', 'solace' ),
			'divider'          => __( 'Divider', 'solace' ),
		);		

		$this->add_control(
			new Control(
				'solace_single_post_element',
				[
					'sanitize_callback' => [ $this, 'sanitize_post_element' ],
					'default'           => wp_json_encode( $order_default_components ),
				],
				[
					'label'      => esc_html__( 'Post Element', 'solace' ),
					'section'    => $this->section,
					'components' => $components,
				],
				'\Solace\Customizer\Controls\React\New_Ordering'
			)
		);

		$this->add_control(
			new Control(
				'solace_single_only_available_for_custom_layout',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Only enable for custom layout', 'solace' ),
					'section'         => $this->section,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);		

		$defaults = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_TITLE);
		$this->add_control(
			new Control(
				Config::MODS_BLOG_POST_DESIGN_TITLE,
				[
					'transport' => $this->selective_refresh,
					'default'   => $defaults,
				],
				[
					'section'               => $this->section,
					'input_attrs'           => array(
						// 'size_units'             => ['px'],
						'heading_tag_default'    => 'h1',
						'size_default'           => $defaults['fontSize'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--single-title-heading'    => 'headingTag',
								'--single-title-fontsize'   => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
							],
							'selector' => '
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h1,
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h2,
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h3,
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h4,
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h5,
							.main-single-custom .container-single .row1 article .boxes-ordering .box-title h6',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typeface_Title'
			)
		);	
	
		$defaults = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);
		$this->add_control(
			new Control(
				Config::MODS_BLOG_POST_DESIGN_POST_META,
				[
					'transport' => 'refresh',
					'default'   => $defaults,
				],
				[
					'section'               => $this->section,
					// 'input_attrs'           => array(
						// 'size_units'             => ['px'],
						// 'size_default'      => $defaults['fontSize'],
						// 'show_avatar'       => true,
					// ),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--single-post-meta-author'    			=> 'author',
								'--single-post-meta-published-date'     => 'publishedDate',
								'--single-post-meta-comments'    		=> 'comments',
								'--single-post-meta-author-label'       => 'authorLabel',
								'--single-post-meta-show-avatar'    	=> 'showAvatar',
								'--single-post-meta-avatar-size'    	=> 'avatarSize',
								'--single-post-meta-words-per-minute'   => 'wordsPerMinute',
								'--single-post-meta-updated-label'      => 'updatedLabel',
								'--single-post-meta-show-updated-label' => 'showUpdatedLabel',
							],
							'selector' => '.main-single-custom .container-single .row1 article .boxes-ordering',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Post_Meta'
			)
		);		

		$this->add_control(
			new Control(
				'solace_single_show_comments',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Show Comments', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				'solace_single_show_author_box',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Show Author Box', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				'solace_post_layout_hide_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Hide Title', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 1,
					'description'     => esc_html__( '- You can change individual layout from Single Metabox Options. If the post is in blocks, then the single post layout will automatically switch to Boxed.', 'solace' ),
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$all_components_social_share = [
			'facebook'  => __( 'Facebook', 'solace' ),
			'instagram' => __( 'Instagram', 'solace' ),
			'twitter'   => __( 'Twitter (X)', 'solace' ),
			'copylink'  => __( 'Copy to Clipboard', 'solace' ),
		];

		// $default_social_share = $this->post_ordering();
		$default_social_share = array(
			'facebook',
			'instagram',
			'twitter',
			'copylink',
		);

		/**
		 * Filters the elements on the single post page.
		 *
		 * @param array $all_components Single post page components.
		 *
		 * @since 2.11.4
		 */
		// $componentsx = apply_filters( 'solace_single_post_social', $all_componentsx );

		$this->add_control(
			new Control(
				'solace_layout_single_post_social_order',
				[
					'sanitize_callback' => [ $this, 'sanitize_post_social_ordering' ],
					'default'           => wp_json_encode( $default_social_share ),
				],
				[
					'label'      => esc_html__( 'Social Share', 'solace' ),
					'section'    => $this->section,
					'components' => $all_components_social_share,
					'priority'   => 100,
				],
				'Solace\Customizer\Controls\React\Ordering'
			)
		);

		// $this->control_content_order();

		$this->add_control(
			new Control(
				'solace_container_post_width',
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
							'vars'       => '--container-post',
							'responsive' => true,
							'suffix'     => 'px',
						],
					],
					'priority'              => 25,
				],
				'\Solace\Customizer\Controls\React\Responsive_Range'
			)
		);

		// if ( solace_is_new_skin() ) {
		// 	$this->add_subsections();
		// 	$this->header_layout();
		// 	$this->post_meta();
		// 	$this->comments();
		// 	add_action( 'customize_register', [ $this, 'adjust_headings' ], PHP_INT_MAX );
		// }

		$this->add_control(
			new Control(
				'solace_show_single_post_navigation',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Show Post Navigation', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				'solace_show_single_related_posts',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Show Related Posts', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

	}

	/**
	 * Add sections headings.
	 */
	private function add_subsections() {

		$headings = [
			'page_elements'    => [
				'title'            => esc_html__( 'Page Elements', 'solace' ),
				'priority'         => 95,
				'controls_to_wrap' => 2,
				'expanded'         => false,
			],
			'meta'             => [
				'title'            => esc_html__( 'Post Meta', 'solace' ),
				'priority'         => 110,
				'controls_to_wrap' => 5,
				'expanded'         => false,
			],
			'comments_section' => [
				'title'           => esc_html__( 'Comments Section', 'solace' ),
				'priority'        => 150,
				'expanded'        => true,
				'accordion'       => false,
				'active_callback' => function() {
					return $this->element_is_enabled( 'comments' );
				},
			],
			'comments_form'    => [
				'title'           => esc_html__( 'Submit Form Section', 'solace' ),
				'priority'        => 175,
				'expanded'        => true,
				'accordion'       => false,
				'active_callback' => function() {
					return $this->element_is_enabled( 'comments' );
				},
			],
		];

		foreach ( $headings as $heading_id => $heading_data ) {
			$this->add_control(
				new Control(
					'solace_post_' . $heading_id . '_heading',
					[
						'sanitize_callback' => 'sanitize_text_field',
					],
					[
						'label'            => $heading_data['title'],
						'section'          => $this->section,
						'priority'         => $heading_data['priority'],
						'class'            => $heading_id . '-accordion',
						'expanded'         => $heading_data['expanded'],
						'accordion'        => array_key_exists( 'accordion', $heading_data ) ? $heading_data['accordion'] : true,
						'controls_to_wrap' => array_key_exists( 'controls_to_wrap', $heading_data ) ? $heading_data['controls_to_wrap'] : 0,
						'active_callback'  => array_key_exists( 'active_callback', $heading_data ) ? $heading_data['active_callback'] : '__return_true',
					],
					'Solace\Customizer\Controls\Heading'
				)
			);
		}
	}

	/**
	 * Add header layout controls.
	 */
	private function header_layout() {
		$this->add_control(
			new Control(
				'solace_post_cover_meta_before_title',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => false,
				],
				[
					'label'           => esc_html__( 'Display meta before title', 'solace' ),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control',
					'priority'        => 40,
					'active_callback' => [ $this, 'is_cover_layout' ],
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);
	}

	/**
	 * Add content order control.
	 */
	private function control_content_order() {

		$all_components = [
			'title-meta'      => __( 'Title & Meta', 'solace' ),
			'thumbnail'       => __( 'Thumbnail', 'solace' ),
			'content'         => __( 'Content', 'solace' ),
			'tags'            => __( 'Tags', 'solace' ),
			'post-navigation' => __( 'Post navigation', 'solace' ),
			'comments'        => __( 'Comments', 'solace' ),
		];

		if ( self::is_cover_layout() ) {
			$all_components = [
				'content'         => __( 'Content', 'solace' ),
				'tags'            => __( 'Tags', 'solace' ),
				'post-navigation' => __( 'Post navigation', 'solace' ),
				'comments'        => __( 'Comments', 'solace' ),
			];
		}

		$order_default_components = $this->post_ordering();

		/**
		 * Filters the elements on the single post page.
		 *
		 * @param array $all_components Single post page components.
		 *
		 * @since 2.11.4
		 */
		$components = apply_filters( 'solace_single_post_elements', $all_components );

		$this->add_control(
			new Control(
				'solace_layout_single_post_elements_order',
				[
					'sanitize_callback' => [ $this, 'sanitize_post_elements_ordering' ],
					'default'           => wp_json_encode( $order_default_components ),
				],
				[
					'label'      => esc_html__( 'Elements Order', 'solace' ),
					'section'    => $this->section,
					'components' => $components,
					'priority'   => 100,
				],
				'Solace\Customizer\Controls\React\Ordering'
			)
		);

		if ( solace_is_new_skin() ) {
			$this->add_control(
				new Control(
					'solace_single_post_elements_spacing',
					[
						'sanitize_callback' => 'solace_sanitize_range_value',
						'transport'         => $this->selective_refresh,
						'default'           => '{"desktop":60,"tablet":60,"mobile":60}',
					],
					[
						'label'                 => esc_html__( 'Spacing between elements', 'solace' ),
						'section'               => $this->section,
						'type'                  => 'solace_responsive_range_control',
						'input_attrs'           => [
							'max'        => 500,
							'units'      => [ 'px', 'em', 'rem' ],
							'defaultVal' => [
								'mobile'  => 60,
								'tablet'  => 60,
								'desktop' => 60,
								'suffix'  => [
									'mobile'  => 'px',
									'tablet'  => 'px',
									'desktop' => 'px',
								],
							],
						],
						'priority'              => 105,
						'live_refresh_selector' => true,
						'live_refresh_css_prop' => [
							'cssVar' => [
								'responsive' => true,
								'vars'       => '--spacing',
								'selector'   => '.nv-single-post-wrap',
								'suffix'     => 'px',
							],
						],
					],
					'\Solace\Customizer\Controls\React\Responsive_Range'
				)
			);

		}
	}

	/**
	 * Add post meta controls.
	 */
	private function post_meta() {

		$components    = apply_filters(
			'solace_meta_filter',
			[
				'author'   => __( 'Author', 'solace' ),
				'category' => __( 'Category', 'solace' ),
				'date'     => __( 'Date', 'solace' ),
				'comments' => __( 'Comments', 'solace' ),
			]
		);
		$default       = wp_json_encode( [ 'author', 'date', 'comments' ] );
		$default_value = solace_get_default_meta_value( 'solace_post_meta_ordering', $default );
		$default_value = get_theme_mod( 'solace_blog_post_meta_fields', wp_json_encode( $default_value ) );
		$default_value = get_theme_mod( 'solace_single_post_meta_fields', $default_value );

		$this->add_control(
			new Control(
				'solace_single_post_meta_fields',
				[
					'sanitize_callback' => 'solace_sanitize_meta_repeater',
					'default'           => $default_value,
				],
				[
					'label'            => esc_html__( 'Meta Order', 'solace' ),
					'section'          => $this->section,
					'fields'           => [
						'hide_on_mobile' => [
							'type'  => 'checkbox',
							'label' => __( 'Hide on mobile', 'solace' ),
						],
					],
					'components'       => $components,
					'allow_new_fields' => 'no',
					'priority'         => 115,
				],
				'\Solace\Customizer\Controls\React\Repeater'
			)
		);

		$default_separator = get_theme_mod( 'solace_metadata_separator', esc_html( '/' ) );
		$this->add_control(
			new Control(
				'solace_single_post_metadata_separator',
				[
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $default_separator,
				],
				[
					'priority'    => 120,
					'section'     => $this->section,
					'label'       => esc_html__( 'Separator', 'solace' ),
					'description' => esc_html__( 'For special characters make sure to use Unicode. For example > can be displayed using \003E.', 'solace' ),
					'type'        => 'text',
				]
			)
		);

		$author_avatar_default = get_theme_mod( 'solace_author_avatar', false );
		$this->add_control(
			new Control(
				'solace_single_post_author_avatar',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => $author_avatar_default,
				],
				[
					'label'    => esc_html__( 'Show Author Avatar', 'solace' ),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 125,
				]
			)
		);

		$avatar_size_default = get_theme_mod( 'solace_author_avatar_size', '{ "mobile": 20, "tablet": 20, "desktop": 20 }' );
		$this->add_control(
			new Control(
				'solace_single_post_avatar_size',
				[
					'sanitize_callback' => 'solace_sanitize_range_value',
					'default'           => $avatar_size_default,
				],
				[
					'label'           => esc_html__( 'Avatar Size', 'solace' ),
					'section'         => $this->section,
					'units'           => [ 'px' ],
					'input_attr'      => [
						'mobile'  => [
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						],
						'tablet'  => [
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						],
						'desktop' => [
							'min'          => 20,
							'max'          => 50,
							'default'      => 20,
							'default_unit' => 'px',
						],
					],
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
						'units'      => [ 'px', 'em', 'rem' ],
					],
					'priority'        => 130,
					'active_callback' => function () {
						return get_theme_mod( 'solace_single_post_author_avatar', false );
					},
					'responsive'      => true,
				],
				'Solace\Customizer\Controls\React\Responsive_Range'
			)
		);

		$this->add_control(
			new Control(
				'solace_single_post_show_last_updated_date',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => get_theme_mod( 'solace_show_last_updated_date', false ),
				],
				[
					'label'    => esc_html__( 'Use last updated date instead of the published one', 'solace' ),
					'section'  => $this->section,
					'type'     => 'solace_toggle_control',
					'priority' => 135,
				]
			)
		);
	}

	/**
	 * Add comments controls.
	 */
	private function comments() {

		$this->add_control(
			new Control(
				'solace_post_comment_section_title',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'           => esc_html__( 'Section title', 'solace' ),
					'description'     => esc_html__( 'The following magic tags are available for this field: {title} and {comments_number}. Leave this field empty for default behavior.', 'solace' ),
					'priority'        => 155,
					'section'         => $this->section,
					'type'            => 'text',
					'active_callback' => function() {
						return $this->element_is_enabled( 'comments' );
					},
				]
			)
		);

		$this->add_boxed_layout_controls(
			'comments',
			[
				'priority'                  => 160,
				'section'                   => $this->section,
				'padding_default'           => $this->padding_default(),
				'background_default'        => 'var(--nv-light-bg)',
				'color_default'             => 'var(--sol-color-base-font)',
				'boxed_selector'            => '.nv-is-boxed.nv-comments-wrap',
				'text_color_css_selector'   => '.nv-comments-wrap.nv-is-boxed, .nv-comments-wrap.nv-is-boxed a',
				'border_color_css_selector' => '.nv-comments-wrap.nv-is-boxed .nv-comment-article',
				'toggle_active_callback'    => function() {
					return $this->element_is_enabled( 'comments' );
				},
				'active_callback'           => function() {
					return $this->element_is_enabled( 'comments' ) && get_theme_mod( 'solace_comments_boxed_layout', false );
				},
			]
		);

		$this->add_control(
			new Control(
				'solace_post_comment_form_title',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'           => esc_html__( 'Section title', 'solace' ),
					'priority'        => 180,
					'section'         => $this->section,
					'type'            => 'text',
					'active_callback' => function() {
						return $this->element_is_enabled( 'comments' );
					},
				]
			)
		);

		$this->add_control(
			new Control(
				'solace_post_comment_form_button_style',
				[
					'default'           => 'primary',
					'sanitize_callback' => 'solace_sanitize_button_type',
				],
				[
					'label'           => esc_html__( 'Button style', 'solace' ),
					'section'         => $this->section,
					'priority'        => 185,
					'type'            => 'select',
					'choices'         => [
						'primary'   => esc_html__( 'Primary', 'solace' ),
						'secondary' => esc_html__( 'Secondary', 'solace' ),
					],
					'active_callback' => function() {
						return $this->element_is_enabled( 'comments' );
					},
				]
			)
		);

		$this->add_control(
			new Control(
				'solace_post_comment_form_button_text',
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'           => esc_html__( 'Button text', 'solace' ),
					'priority'        => 190,
					'section'         => $this->section,
					'type'            => 'text',
					'active_callback' => function() {
						return $this->element_is_enabled( 'comments' );
					},
				]
			)
		);

		$this->add_boxed_layout_controls(
			'comments_form',
			[
				'priority'                => 195,
				'section'                 => $this->section,
				'padding_default'         => $this->padding_default(),
				'is_boxed_default'        => true,
				'background_default'      => 'var(--nv-light-bg)',
				'color_default'           => 'var(--sol-color-base-font)',
				'boxed_selector'          => '.nv-is-boxed.comment-respond',
				'text_color_css_selector' => '.comment-respond.nv-is-boxed, .comment-respond.nv-is-boxed a',
				'toggle_active_callback'  => function() {
					return $this->element_is_enabled( 'comments' );
				},
				'active_callback'         => function() {
					return $this->element_is_enabled( 'comments' ) && get_theme_mod( 'solace_comments_form_boxed_layout', solace_is_new_skin() );
				},
			]
		);
	}

	/**
	 * Change heading controls properties.
	 */
	public function adjust_headings() {
		$this->change_customizer_object( 'control', 'solace_comments_heading', 'controls_to_wrap', 15 );
	}

	/**
	 * Active callback for sharing controls.
	 *
	 * @param string $element Post page element.
	 *
	 * @return bool
	 */
	public function element_is_enabled( $element ) {
		$default_order = apply_filters(
			'solace_single_post_elements_default_order',
			array(
				'title-meta',
				'thumbnail',
				'content',
				'tags',
				'comments',
			)
		);

		$content_order = get_theme_mod( 'solace_layout_single_post_elements_order', wp_json_encode( $default_order ) );
		$content_order = json_decode( $content_order, true );
		if ( ! in_array( $element, $content_order, true ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Sanitize content order control.
	 */
	public function sanitize_post_elements_ordering( $value ) {
		$allowed = [
			'thumbnail',
			'title-meta',
			'content',
			'tags',
			'post-navigation',
			'comments',
			'author-biography',
			'related-posts',
			'sharing-icons',
		];

		if ( empty( $value ) ) {
			return wp_json_encode( $allowed );
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return wp_json_encode( $allowed );
			}
		}

		return $value;
	}

	public function sanitize_post_element( $value ) {

		$prefix = 'solace_single_post_element';

		$elements = array(
			'featured-image', 'categories', 'title', 'post-meta', 'content',
			'tags', 'divider',
		);

		// Generate the list of allowed elements with and without '-solhide' suffix
		$allowed = array_merge(
			array_map( fn($el) => $prefix . '-' . $el, $elements ),
			array_map( fn($el) => $prefix . '-' . $el . '-solhide', $elements )
		);

		if ( empty( $value ) ) {
			return wp_json_encode( $allowed );
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return wp_json_encode( $allowed );
			}
		}

		return $value;	
	
	}	

	public function sanitize_post_social_ordering( $value ) {
		$allowed = [
			'facebook',
			'twitter',
			'instagram',
			'whatsapp',
			'pinterest',
			'threads',
			'copylink',
		];

		if ( empty( $value ) ) {
			return wp_json_encode( $allowed );
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return wp_json_encode( $allowed );
			}
		}

		return $value;
	}

	/**
	 * Fuction used for active_callback control property.
	 *
	 * @return bool
	 */
	public static function is_cover_layout() {
		return get_theme_mod( 'solace_post_header_layout' ) === 'layout 1' && solace_is_new_skin();
	}

	/**
	 *  Fuction used for active_callback control property for boxed title.
	 *
	 * @return bool
	 */
	public function is_boxed_title() {
		if ( ! self::is_cover_layout() ) {
			return false;
		}
		return get_theme_mod( 'solace_post_cover_title_boxed_layout', false );
	}
}
