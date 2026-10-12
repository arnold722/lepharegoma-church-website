<?php

/**
 * Customizer typography controls.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Controls\React\Typography_Extra_Section;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Typography
 *
 * @package Solace\Customizer\Options
 */
class Typography extends Base_Customizer
{
	/**
	 * Add controls
	 */
	public function add_controls()
	{
		$this->sections_typography();
		$this->controls_font_pairs();
		$this->controls_typography_general();
		$this->controls_typography_headings();
		$this->controls_typography_blog();
		$this->section_extra();
	}

	/**
	 * Add controls for font pair section
	 *
	 * @return void
	 */
	private function controls_font_pairs()
	{
		/**
		 * Filters the font pairs that are available inside Customizer.
		 *
		 * @param array $pairs The font pairs array.
		 *
		 * @since 3.5.0
		 */
		$pairs = apply_filters('solace_font_pairings', Mods::get(Config::MODS_TPOGRAPHY_FONT_PAIRS, Config::$typography_default_pairs));

		/**
		 * Font Pairs Control
		 */
		$this->add_control(
			new Control(
				Config::MODS_TPOGRAPHY_FONT_PAIRS,
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => $pairs,
				],
				array(
					'input_attrs' => array(
						'pairs'       => $pairs,
						'description' => array(
							'text' => __('Choose Font family presets for your Headings and Text.', 'solace'),
							'link' => apply_filters('solace_external_link', '#', esc_html__('Learn more', 'solace')),
						),
					),
					'label'       => esc_html__('Font presets', 'solace'),
					'section'     => 'typography_font_pair_section',
					'priority'    => 10,
					'type'        => 'solace_font_pairings_control',
				),
				'\Solace\Customizer\Controls\React\Font_Pairings'
			)
		);
	}

	/**
	 * Add the customizer section.
	 */
	private function sections_typography()
	{
		$typography_sections = array(
			'typography_font_pair_section' => array(
				'title'    => __('Font presets', 'solace'),
				'priority' => 15,
			),
			'solace_typography_general'      => array(
				'title'    => __('General', 'solace'),
				'priority' => 25,
			),
			'solace_typography_headings'     => array(
				'title'    => __('Fonts', 'solace'),
				'priority' => 11,
			),
			'solace_typography_blog'         => array(
				'title'    => __('Blog', 'solace'),
				'priority' => 45,
			),
		);

		foreach ($typography_sections as $section_id => $section_data) {
			$this->add_section(
				new Section(
					$section_id,
					array(
						'priority' => 10,
						'title'    => $section_data['title'],
						// 'panel'    => 'sol_general',
						'priority' => $section_data['priority'],
					)
				)
			);
		}
	}

	/**
	 * Add general typography controls
	 */
	private function controls_typography_general()
	{

		/**
		 * Smaller font family
		 */

		$this->add_control(
			new Control(
				Config::MODS_FONT_SMALLER,
				array(
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => Mods::get_alternative_mod_default(Config::MODS_FONT_SMALLER),
				),
				array(
					'settings'              => [
						'default'  => Config::MODS_FONT_SMALLER,
						'variants' => Config::MODS_FONT_SMALLER_VARIANTS,
					],
					'label'                 => esc_html__('Smaller', 'solace'),
					'section'               => 'solace_typography_headings',
					'priority'              => 1,
					'type'                  => 'solace_font_family_control',
					'live_refresh_selector' => apply_filters('solace_smaller_font_family_selectors', 'h1:not(.site-title), small'),
					'live_refresh_css_prop' => [
						
						'cssVar' => [
							'vars'     => [
								'--e-global-typography-primary-font-family',
								'--smallerfontfamily',
							],
							'selector' => '[class*="elementor-kit-"], body',
							'fallback' => Mods::get_alternative_mod_default(Config::MODS_FONT_SMALLER),
						],	
					],
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		/**
		 * Smaller font family subsets.
		 */
		$this->wpc->add_setting(
			Config::MODS_FONT_SMALLER_VARIANTS,
			[
				'transport'         => $this->selective_refresh,
				'sanitize_callback' => 'solace_sanitize_font_variants',
				'default'           => [],
			]
		);

		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_SMALLER);
		$this->add_control(
			new Control(
				Config::MODS_TYPEFACE_SMALLER,
				[
					'transport' => $this->selective_refresh,
					'default'   => $defaults,
				],
				[
					'priority'              => 2,
					'section'               => 'solace_typography_headings',
					'input_attrs'           => array(
						'size_units'             => ['em', 'px'],
						'weight_default'         => 400,
						'size_default'           => $defaults['fontSize'],
						'line_height_default'    => $defaults['lineHeight'],
						'letter_spacing_default' => $defaults['letterSpacing'],
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_smaller_font_family',
					'live_refresh_selector' => 'body, .site-title',
					'live_refresh_css_prop' => [
						'cssVar' => [
							
							'vars'     => [
								'--e-global-typography-primary-text-transform' => 'textTransform',
								'--e-global-typography-primary-font-weight'    => 'fontWeight',
								'--e-global-typography-primary-font-size'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--e-global-typography-primary-line-height'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--e-global-typography-primary-letter-spacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => '[class*="elementor-kit-"], body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);

		/**
		 * Fallback Font Family.
		 */
		$this->add_control(
			new Control(
				'solace_fallback_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'DM Sans, sans-serif',
				],
				[
					'label'                 => esc_html__('Fallback Font', 'solace'),
					'section'               => 'solace_typography_general',
					'priority'              => 3,
					'type'                  => 'solace_font_family_control',
					'input_attrs'           => [
						'system' => true,
					],
					'live_refresh_selector' => solace_is_new_skin(),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--nv-fallback-ff',
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		$this->add_control(
			new Control(
				Config::MODS_FONT_LOGOTITLE,
				array(
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => Mods::get_alternative_mod_default(Config::MODS_FONT_LOGOTITLE),
				),
				array(
					'settings'              => [
						'default'  => Config::MODS_FONT_LOGOTITLE,
						'variants' => Config::MODS_FONT_LOGOTITLE_VARIANTS,
					],
					'label'                 => esc_html__('Logo Title / Subtitle', 'solace'),
					'section'               => 'solace_typography_headings',
					'priority'              => 4,
					'type'                  => 'solace_font_family_control',
					'live_refresh_selector' => apply_filters('solace_logotitle_font_family_selectors', 'h1.site-title, p.site-title'),
					'live_refresh_css_prop' => [
						

						'cssVar' => [
							'vars'     => [
								'--e-global-typography-secondary-font-family',
								'--logotitlefontfamily',
							],
							'selector' => '[class*="elementor-kit-"], body',
							'fallback' => Mods::get_alternative_mod_default(Config::MODS_FONT_LOGOTITLE),
						],
						
					],
					// 'input_attrs'           => [
					// 	'default_is_inherit' => true,
					// ],
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		/**
		 * LogoTitle font family subsets.
		 */
		$this->wpc->add_setting(
			Config::MODS_FONT_LOGOTITLE_VARIANTS,
			[
				'transport'         => $this->selective_refresh,
				'sanitize_callback' => 'solace_sanitize_font_variants',
				'default'           => [],
			]
		);

		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_LOGOTITLE);
		$this->add_control(
			new Control(
				Config::MODS_TYPEFACE_LOGOTITLE,
				[
					'transport' => $this->selective_refresh,
					'default'   => $defaults,
				],
				[
					'priority'              => 5,
					'section'               => 'solace_typography_headings',
					'input_attrs'           => array(
						'size_units'             => ['em', 'px'],
						'weight_default'         => 400,
						'size_default'           => $defaults['fontSize'],
						'line_height_default'    => $defaults['lineHeight'],
						'letter_spacing_default' => $defaults['letterSpacing'],
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_logotitle_font_family',
					'live_refresh_selector' => 'body, .site-title',
					'live_refresh_css_prop' => [
						'cssVar' => [
							
							'vars'     => [
								'--e-global-typography-secondary-text-transform' => 'textTransform',
								'--e-global-typography-secondary-font-weight'    => 'fontWeight',
								'--e-global-typography-secondary-font-size'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--e-global-typography-secondary-line-height'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--e-global-typography-secondary-letter-spacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => '[class*="elementor-kit-"]',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);

		/**
		 * Fallback Font Family.
		 */
		$this->add_control(
			new Control(
				'solace_fallback_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'DM Sans, sans-serif',
				],
				[
					'label'                 => esc_html__('Fallback Font', 'solace'),
					'section'               => 'solace_typography_general',
					'priority'              => 6,
					'type'                  => 'solace_font_family_control',
					'input_attrs'           => [
						'system' => true,
					],
					'live_refresh_selector' => solace_is_new_skin(),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--nv-fallback-ff',
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		$this->add_control(
			new Control(
				Config::MODS_FONT_BUTTON,
				array(
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => Mods::get_alternative_mod_default(Config::MODS_FONT_BUTTON),

				),
				array(
					'settings'              => [
						'default'  => Config::MODS_FONT_BUTTON,
						'variants' => Config::MODS_FONT_BUTTON_VARIANTS,
					],
					'label'                 => esc_html__('Button', 'solace'),
					'section'               => 'solace_typography_headings',
					'priority'              => 10,
					'type'                  => 'solace_font_family_control',
					'live_refresh_selector' => apply_filters('solace_button_font_family_selectors', '.elementor-button,.wp-block-button__link'),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--e-global-typography-accent-font-family',
								'--buttonfontfamily',
							],
							'selector' => '[class*="elementor-kit-"], body',
							'fallback' => Mods::get_alternative_mod_default(Config::MODS_FONT_BUTTON),
							'suffix'   => ', var(--nv-fallback-ff)',
						],
						// 'type'   => 'svg-icon-size',
					],
					// 'input_attrs'           => [
					// 	'default_is_inherit' => true,
					// ],
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		/**
		 * Button font family subsets.
		 */
		$this->wpc->add_setting(
			Config::MODS_FONT_BUTTON_VARIANTS,
			[
				'transport'         => $this->selective_refresh,
				'sanitize_callback' => 'solace_sanitize_font_variants',
				'default'           => [],
			]
		);

		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_BUTTON);
		$this->add_control(
			new Control(
				Config::MODS_TYPEFACE_BUTTON,
				[
					'transport' => $this->selective_refresh,
					'default'   => $defaults,
				],
				[
					'priority'              => 11,
					'section'               => 'solace_typography_headings',
					'input_attrs'           => array(
						'size_units'             => ['em', 'px'],
						'weight_default'         => 400,
						'size_default'           => $defaults['fontSize'],
						'line_height_default'    => $defaults['lineHeight'],
						'letter_spacing_default' => $defaults['letterSpacing'],
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_button_font_family',
					'live_refresh_selector' => 'body, .site-title, .wp-block-button__link, .comment-form .submit',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--buttontexttransform' => 'textTransform',
								'--buttonfontweight'    => 'fontWeight',
								'--buttonfontsize'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--buttonlineheight'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--buttonletterspacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
								'--e-global-typography-accent-text-transform' => 'textTransform',
								'--e-global-typography-accent-font-weight'    => 'fontWeight',
								'--e-global-typography-accent-font-size'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--e-global-typography-accent-line-height'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--e-global-typography-accent-letter-spacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => '[class*="elementor-kit-"], body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);

		/**
		 * Fallback Font Family.
		 */
		$this->add_control(
			new Control(
				'solace_fallback_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'DM Sans, sans-serif',
				],
				[
					'label'                 => esc_html__('Fallback Font', 'solace'),
					'section'               => 'solace_typography_general',
					'priority'              => 12,
					'type'                  => 'solace_font_family_control',
					'input_attrs'           => [
						'system' => true,
					],
					'live_refresh_selector' => solace_is_new_skin(),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--nv-fallback-ff',
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);


		/**
		 * Body font family
		 */
		$this->add_control(
			new Control(
				Config::MODS_FONT_GENERAL,
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => Mods::get_alternative_mod_default(Config::MODS_FONT_GENERAL),
				],
				array(
					'settings'              => [
						'default'  => Config::MODS_FONT_GENERAL,
						'variants' => Config::MODS_FONT_GENERAL_VARIANTS,
					],
					'label'                 => esc_html__('Base Font', 'solace'),
					'section'               => 'solace_typography_headings',
					'priority'              => 7,
					'type'                  => 'solace_font_family_control',
					'live_refresh_selector' => apply_filters('solace_body_font_family_selectors', 'body, .site-title'),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--e-global-typography-text-font-family',
								'--buttonfontfamily',
							],
							'selector' => '[class*="elementor-kit-"],body',
							'fallback' => Mods::get_alternative_mod_default(Config::MODS_FONT_GENERAL),
							'suffix'   => ', var(--nv-fallback-ff)',
						],
					],
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		/**
		 * Body font family subsets.
		 */
		$this->wpc->add_setting(
			Config::MODS_FONT_GENERAL_VARIANTS,
			[
				'transport'         => $this->selective_refresh,
				'sanitize_callback' => 'solace_sanitize_font_variants',
				'default'           => [],
			]
		);


		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);
		$this->add_control(
			new Control(
				Config::MODS_TYPEFACE_GENERAL,
				[
					'transport' => $this->selective_refresh,
					'default'   => $defaults,
				],
				[
					'priority'              => 8,
					'section'               => 'solace_typography_headings',
					'input_attrs'           => array(
						'size_units'             => ['em', 'px'],
						'weight_default'         => 400,
						'size_default'           => $defaults['fontSize'],
						'line_height_default'    => $defaults['lineHeight'],
						'letter_spacing_default' => $defaults['letterSpacing'],
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_body_font_family',
					'live_refresh_selector' => 'body, .site-title',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--bodytexttransform' => 'textTransform',
								'--bodyfontweight'    => 'fontWeight',
								'--bodyfontsize'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--bodylineheight'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--bodyletterspacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
								'--e-global-typography-text-text-transform' => 'textTransform',
								'--e-global-typography-text-font-weight'    => 'fontWeight',
								'--e-global-typography-text-font-size'      => [
									'key'        => 'fontSize',
									'responsive' => true,
								],
								'--e-global-typography-text-line-height'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
								],
								'--e-global-typography-text-letter-spacing' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
								],
							],
							'selector' => '[class*="elementor-kit-"],body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);

		/**
		 * Fallback Font Family.
		 */
		$this->add_control(
			new Control(
				'solace_fallback_font_family',
				[
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'DM Sans, sans-serif',
				],
				[
					'label'                 => esc_html__('Fallback Font', 'solace'),
					'section'               => 'solace_typography_general',
					'priority'              => 9,
					'type'                  => 'solace_font_family_control',
					'input_attrs'           => [
						'system' => true,
					],
					'live_refresh_selector' => solace_is_new_skin(),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--nv-fallback-ff',
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
	}

	/**
	 * Add controls for typography headings.
	 */
	private function controls_typography_headings()
	{
		/**
		 * Headings font family
		 */
		$this->add_control(
			new Control(
				'solace_headings_font_family',
				array(
					'transport'         => $this->selective_refresh,
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'section'               => 'solace_typography_headings',
					'priority'              => 200,
					'type'                  => 'solace_font_family_control',
					'live_refresh_selector' => apply_filters('solace_headings_font_family_selectors', 'h1:not(.site-title), .single h1.entry-title, h2, h3, .woocommerce-checkout h3, h4, h5, h6'),
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--headingsfontfamily',
							'selector' => 'body',
							'vars'     => [
								'--smallerfontfamily',
							],
						],
						'type'   => 'svg-icon-size',
					],
					'input_attrs'           => [
						'default_is_inherit' => true,
					],
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);

		$selectors = solace_get_headings_selectors();
		$priority  = 124;
		foreach (['h1', 'h2', 'h3', 'h4', 'h5', 'h6'] as $heading_id) {
			$mod_key        = 'solace_' . $heading_id . '_typeface_general';
			$default_values = Mods::get_alternative_mod_default($mod_key);
			$fonts_family = get_theme_mod('solace_' . $heading_id . '_font_family_general', 'DM Sans, sans-serif');
			$data_heading = get_theme_mod('solace_' . $heading_id . '_typeface_general');

			// Font Family
			if ($fonts_family == false) {
				$fonts_family = esc_html__('Default', 'solace');
			}
			if (strlen($fonts_family) > 6) {
				$fonts_family = explode(' ', $fonts_family);
				$fonts_family = esc_html($fonts_family[0]);
			}

			// Font Size
			if (!empty($data_heading)) {
				$font_size_desktop = $data_heading['fontSize']['desktop'];
				$font_size_tablet = $data_heading['fontSize']['tablet'];
				$font_size_mobile = $data_heading['fontSize']['mobile'];
			} else {
				$font_size_desktop = $default_values['fontSize']['desktop'];
				$font_size_tablet = $default_values['fontSize']['tablet'];
				$font_size_mobile = $default_values['fontSize']['mobile'];
			}

			// Suffix
			if (!empty($data_heading)) {
				$font_size_suffix_desktop = $data_heading['fontSize']['suffix']['desktop'];
				$font_size_suffix_tablet = $data_heading['fontSize']['suffix']['tablet'];
				$font_size_suffix_mobile = $data_heading['fontSize']['suffix']['mobile'];
			} else {
				$font_size_suffix_desktop = $default_values['fontSize']['suffix']['desktop'];
				$font_size_suffix_tablet = $default_values['fontSize']['suffix']['tablet'];
				$font_size_suffix_mobile = $default_values['fontSize']['suffix']['mobile'];
			}

			// Suffix
			if (empty($font_size_suffix_desktop)) {
				$font_size_suffix_desktop = 'px';
			}
			if (empty($font_size_suffix_tablet)) {
				$font_size_suffix_tablet = 'px';
			}
			if (empty($font_size_suffix_mobile)) {
				$font_size_suffix_mobile = 'px';
			}

			// H1
			if ($heading_id === 'h1') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 68;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 50;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 38;
				}
			}

			// H2
			if ($heading_id === 'h2') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 50;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 38;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 28;
				}
			}

			// H3
			if ($heading_id === 'h3') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 38;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 28;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 21;
				}
			}

			// H4
			if ($heading_id === 'h4') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 28;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 21;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 18;
				}
			}

			// H5
			if ($heading_id === 'h5') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 21;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 18;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 16;
				}
			}

			// H6
			if ($heading_id === 'h6') {
				// Font size
				if (empty($font_size_desktop)) {
					$font_size_desktop = 16;
				}
				if (empty($font_size_tablet)) {
					$font_size_tablet = 14;
				}
				if (empty($font_size_mobile)) {
					$font_size_mobile = 14;
				}
			}

			// Font Weight
			$list_bold = array(
				100 => esc_attr__('Thin', 'solace'),
				200 => esc_attr__('Extra Light', 'solace'),
				300 => esc_attr__('Light', 'solace'),
				400 => esc_attr__('Regular', 'solace'),
				500 => esc_attr__('Medium', 'solace'),
				600 => esc_attr__('Semi Bold', 'solace'),
				700 => esc_attr__('Bold', 'solace'),
				800 => esc_attr__('Extra Bold', 'solace'),
				900 => esc_attr__('Black', 'solace'),
			);

			$font_weight = '';
			if (!empty($data_heading)) {
				$get_weight = $data_heading['fontWeight'];
			} else {
				$get_weight = 700;
			}

			if (isset($list_bold[$get_weight])) {
				$font_weight = $list_bold[$get_weight];
			} else {
				$font_weight = esc_attr__('Unknown', 'solace');
			}
			$font_weight = '';

			$label_heading = '';
			$label_heading .= esc_html($fonts_family) . '|';
			$label_heading .= esc_html($font_size_desktop) . '|';
			$label_heading .= esc_html($font_size_tablet) . '|';
			$label_heading .= esc_html($font_size_mobile) . '|';
			$label_heading .= esc_html($font_size_suffix_desktop) . '|';
			$label_heading .= esc_html($font_size_suffix_tablet) . '|';
			$label_heading .= esc_html($font_size_suffix_mobile);
			// $label_heading .= esc_html($font_weight);

			$this->add_control(
				new Control(
					'solace_' . $heading_id . '_accordion_wrap',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'transport'         => $this->selective_refresh,
					),
					array(
						'label'            => $label_heading,
						'section'          => 'solace_typography_headings',
						'priority'         => $priority += 1,
						'class'            => esc_attr('advanced-sidebar-accordion-' . $heading_id),
						'accordion'        => true,
						'controls_to_wrap' => 2,
						'expanded'         => false,
					),
					'Solace\Customizer\Controls\React\Heading'
				)
			);

			$mod_key        = 'solace_' . $heading_id . '_typeface_general';
			$default_values = Mods::get_alternative_mod_default($mod_key);

			$mod_key2        = 'solace_' . $heading_id . '_font_family_general';
			$this->add_control(
				new Control(
					$mod_key2,
					[
						'transport'         => $this->selective_refresh,
						'sanitize_callback' => 'sanitize_text_field',
						'default'           => Mods::get_alternative_mod_default(Config::MODS_FONT_GENERAL),
					],
					array(
						'label'                 => esc_html__('Font', 'solace'),
						'section'               => 'solace_typography_headings',
						'priority'              => $priority += 1,
						'type'                  => 'solace_font_family_control',
						'live_refresh_selector' => apply_filters('solace_body_font_family_selectors', 'body, .site-title'),
						'live_refresh_css_prop' => [
							'cssVar' => [
								'vars'     => [
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-font-family',
									'--headingsfontfamily',
								],
								'selector' => '[class*="elementor-kit-"], ' . $heading_id,
								'fallback' => Mods::get_alternative_mod_default(Config::MODS_FONT_GENERAL),
								'suffix'   => ', var(--nv-fallback-ff)',
							],
						],
					),
					'\Solace\Customizer\Controls\React\Font_Family'
				)
			);

			$this->add_control(
				new Control(
					$mod_key,
					[
						'transport' => $this->selective_refresh,
						'default'   => $default_values,
					],
					[
						'priority'              => $priority += 1,
						'section'               => 'solace_typography_headings',
						'input_attrs'           => array(
							'size_units'             => ['em', 'px'],
							'weight_default'         => $default_values['fontWeight'],
							'size_default'           => $default_values['fontSize'],
							'line_height_default'    => $default_values['lineHeight'],
							'letter_spacing_default' => $default_values['letterSpacing'],
						),
						'type'                  => 'solace_typeface_control',
						'font_family_control'   => $mod_key2,
						'live_refresh_selector' => $selectors[$heading_id],
						'live_refresh_css_prop' => [
							'cssVar' => [
								'vars'     => [
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-text-transform' => 'textTransform',
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-font-weight'    => 'fontWeight',
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-font-size'      => [
										'key'        => 'fontSize',
										'responsive' => true,
									],
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-line-height'    => [
										'key'        => 'lineHeight',
										'responsive' => true,
									],
									'--e-global-typography-solace_' . $heading_id . '_font_family_general-letter-spacing' => [
										'key'        => 'letterSpacing',
										'suffix'     => 'px',
										'responsive' => true,
									],
									'--' . $heading_id . 'texttransform' => 'textTransform',
									'--' . $heading_id . 'fontweight'    => 'fontWeight',
									'--' . $heading_id . 'fontsize'      => [
										'key'        => 'fontSize',
										'responsive' => true,
									],
									'--' . $heading_id . 'lineheight'    => [
										'key'        => 'lineHeight',
										'responsive' => true,
									],
									'--' . $heading_id . 'letterspacing' => [
										'key'        => 'letterSpacing',
										'suffix'     => 'px',
										'responsive' => true,
									],
								],
								'selector' => '[class*="elementor-kit-"], body',
							],
						],
					],
					'\Solace\Customizer\Controls\React\Typography'
				)
			);
		}
	}

	/**
	 * Add controls for blog typography.
	 */
	private function controls_typography_blog()
	{
		$controls = array(
			'solace_archive_typography_post_title'         => array(
				'label'                 => __('Post title', 'solace'),
				'category_label'        => __('Blog Archive', 'solace'),
				'priority'              => 10,
				'font_family_control'   => 'solace_headings_font_family',
				'live_refresh_selector' => '.blog .blog-entry-title, .archive .blog-entry-title',
			),
			'solace_archive_typography_post_excerpt'       => array(
				'label'                 => __('Post excerpt', 'solace'),
				'priority'              => 20,
				'font_family_control'   => 'solace_body_font_family',
				'live_refresh_selector' => '.blog .entry-summary, .archive .entry-summary, .blog .post-pages-links',
			),
			'solace_archive_typography_post_meta'          => array(
				'label'                 => __('Post meta', 'solace'),
				'priority'              => 30,
				'font_family_control'   => 'solace_body_font_family',
				'live_refresh_selector' => '.blog .nv-meta-list li, .archive .nv-meta-list li',
			),
			'solace_single_post_typography_post_title'     => array(
				'label'                 => __('Post title', 'solace'),
				'category_label'        => __('Single Post', 'solace'),
				'priority'              => 40,
				'font_family_control'   => 'solace_headings_font_family',
				'live_refresh_selector' => '.single h1.entry-title',
			),
			'solace_single_post_typography_post_meta'      => array(
				'label'                 => __('Post meta', 'solace'),
				'priority'              => 50,
				'font_family_control'   => 'solace_body_font_family',
				'live_refresh_selector' => '.single .nv-meta-list li',
			),
			'solace_single_post_typography_comments_title' => array(
				'label'                 => __('Comments reply title', 'solace'),
				'priority'              => 60,
				'font_family_control'   => 'solace_headings_font_family',
				'live_refresh_selector' => '.single .comment-reply-title',
			),
		);

		foreach ($controls as $control_id => $control_settings) {
			$settings = array(
				'label'            => $control_settings['label'],
				'section'          => 'solace_typography_blog',
				'priority'         => $control_settings['priority'],
				'class'            => esc_attr('typography-blog-' . $control_id),
				'accordion'        => true,
				'controls_to_wrap' => 1,
				'expanded'         => false,
			);
			if (array_key_exists('category_label', $control_settings)) {
				$settings['category_label'] = $control_settings['category_label'];
			}

			$this->add_control(
				new Control(
					$control_id . '_accordion_wrap',
					array(
						'sanitize_callback' => 'sanitize_text_field',
						'transport'         => $this->selective_refresh,
					),
					$settings,
					'Solace\Customizer\Controls\Heading'
				)
			);

			$this->add_control(
				new Control(
					$control_id,
					[
						'transport' => $this->selective_refresh,
					],
					[
						'priority'              => $control_settings['priority'] += 1,
						'section'               => 'solace_typography_blog',
						'type'                  => 'solace_typeface_control',
						'font_family_control'   => $control_settings['font_family_control'],
						'live_refresh_selector' => solace_is_new_skin() ? true : $control_settings['live_refresh_selector'],
						'live_refresh_css_prop' => [
							'cssVar' => [
								'vars'     => [
									'--texttransform' => 'textTransform',
									'--fontweight'    => 'fontWeight',
									'--fontsize'      => [
										'key'        => 'fontSize',
										'responsive' => true,
									],
									'--lineheight'    => [
										'key'        => 'lineHeight',
										'responsive' => true,
									],
									'--letterspacing' => [
										'key'        => 'letterSpacing',
										'suffix'     => 'px',
										'responsive' => true,
									],
								],
								'selector' => $control_settings['live_refresh_selector'],
							],
						],
						'refresh_on_reset'      => true,
						'input_attrs'           => array(
							'default_is_empty'       => true,
							'size_units'             => ['em', 'px'],
							'weight_default'         => 'none',
							'size_default'           => array(
								'suffix'  => array(
									'mobile'  => 'px',
									'tablet'  => 'px',
									'desktop' => 'px',
								),
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
							'line_height_default'    => array(
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
							'letter_spacing_default' => array(
								'mobile'  => '',
								'tablet'  => '',
								'desktop' => '',
							),
						),
					],
					'\Solace\Customizer\Controls\React\Typography'
				)
			);
		}
	}

	/**
	 * Add section for extra inline controls
	 *
	 * @return void
	 */
	private function section_extra()
	{
		$this->wpc->add_section(
			new Typography_Extra_Section(
				$this->wpc,
				'typography_extra_section',
				[
					'priority' => 10, // upsell priority(10000) - 1
					'panel'    => 'solace_typography',
				]
			)
		);
	}
}
