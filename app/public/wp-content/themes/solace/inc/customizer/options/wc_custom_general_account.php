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
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;


/**
 * Class Colors_Background
 *
 * @package Solace\Customizer\Options
 */
class WC_Custom_General_Account extends Base_Customizer {
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
				'solace_wc_custom_general_account',
				array(
					'priority' 	=> 107,
					'title'    	=> esc_html__( 'My Account', 'solace' ),
					// 'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {
		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_title_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Title', 'solace'),
					'section'         => 'solace_wc_custom_general_account',
					'priority'        => 2,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);
		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_title_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_account',
					'priority'              => 3,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_title_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 4,
					'section'               => 'solace_wc_custom_general_account',
					'input_attrs'           => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => 700,
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => '16',
							'tablet'  => '16',
							'desktop' => '16',
						),
						'line_height_units' => ['em'],
						'line_height_default'    => array(
							'mobile'  => '1.5',
							'tablet'  => '1.5',
							'desktop' => '1.5',
						),
						'letter_spacing_default' => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_wc_custom_general_account_title_font_family',
					'live_refresh_selector' => 'body.woocommerce-account:not(.elementor-page) .woocommerce th, body.woocommerce-account .woocommerce h2, body.woocommerce-account .woocommerce p label',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-account-title-texttransform'         => 'textTransform',
								'--sol-account-title-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-account-title-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-title-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-title-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-account-title-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-title-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-title-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-account-title-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-title-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-title-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-account:not(.elementor-page) .woocommerce th, body.woocommerce-account .woocommerce h2, body.woocommerce-account:not(.elementor-page) .woocommerce p label',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_title_color',
				array(
					'default' 				=> 'var(--sol-color-heading)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 5,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-button-color' => 'color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce th, body.woocommerce-account .woocommerce h2',
						),
					],
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_description_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Description', 'solace'),
					'section'         => 'solace_wc_custom_general_account',
					'priority'        => 8,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_description_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_account',
					'priority'              => 9,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_description_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 10,
					'section'               => 'solace_wc_custom_general_account',
					'input_attrs'           => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => 700,
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => '16',
							'tablet'  => '16',
							'desktop' => '16',
						),
						'line_height_units' => ['em'],
						'line_height_default'    => array(
							'mobile'  => '1.5',
							'tablet'  => '1.5',
							'desktop' => '1.5',
						),
						'letter_spacing_default' => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_wc_custom_general_account_description_font_family',
					'live_refresh_selector' => 'body.woocommerce-account .woocommerce td, body.woocommerce-account .woocommerce p',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-account-description-texttransform'         => 'textTransform',
								'--sol-account-description-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-account-description-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-description-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-description-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-account-description-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-description-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-description-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-account-description-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-description-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-description-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-account .woocommerce td, body.woocommerce-account .woocommerce p',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_description_color',
				array(
					'default' 				=> 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 11,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-description-color' => 'color', 
							],
							'selector' => 'body.woocommerce-account:not(.elementor-page) .woocommerce td, body.woocommerce-account .woocommerce p, body.woocommerce-account:not(.elementor-page) .woocommerce p label',
						),
					],
				)
				
			)
		);	

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_price_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Price', 'solace'),
					'section'         => 'solace_wc_custom_general_account',
					'priority'        => 13,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_price_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_account',
					'priority'              => 14,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_price_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 15,
					'section'               => 'solace_wc_custom_general_account',
					'input_attrs'           => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => 700,
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => '16',
							'tablet'  => '16',
							'desktop' => '16',
						),
						'line_height_units' => ['em'],
						'line_height_default'    => array(
							'mobile'  => '1.5',
							'tablet'  => '1.5',
							'desktop' => '1.5',
						),
						'letter_spacing_default' => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_wc_custom_general_account_price_font_family',
					'live_refresh_selector' => 'body, .site-price',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-account-price-texttransform'         => 'textTransform',
								'--sol-account-price-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-account-price-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-price-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-price-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-account-price-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-price-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-price-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-account-price-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-price-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-price-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_price_color',
				array(
					'default' 				=> 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 16,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-price-color' => 'color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce td.woocommerce-table__product-total.product-total, body.woocommerce-account .woocommerce td span.woocommerce-Price-amount.amount, body.woocommerce-account .woocommerce .woocommerce-orders-table__cell-order-total span.woocommerce-Price-amount.amount',
						),
					],
				)
				
			)
		);	
		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Button', 'solace'),
					'section'         => 'solace_wc_custom_general_account',
					'priority'        => 18,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_account',
					'priority'              => 19,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 20,
					'section'               => 'solace_wc_custom_general_account',
					'input_attrs'           => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => 700,
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => '16',
							'tablet'  => '16',
							'desktop' => '16',
						),
						'line_height_units' => ['em'],
						'line_height_default'    => array(
							'mobile'  => '1.5',
							'tablet'  => '1.5',
							'desktop' => '1.5',
						),
						'letter_spacing_default' => array(
							'mobile'  => '',
							'tablet'  => '',
							'desktop' => '',
						),
					),
					'type'                  => 'solace_typeface_control',
					'font_family_control'   => 'solace_wc_custom_general_account_button_font_family',
					'live_refresh_selector' => 'body, .site-button',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-account-button-texttransform'         => 'textTransform',
								'--sol-account-button-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-account-button-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-button-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-button-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-account-button-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-button-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-button-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-account-button-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-account-button-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-account-button-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_color',
				array(
					'default' 				=> 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 21,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-button-color' => 'color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce button, body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit], body.woocommerce-account .woocommerce a.button:not(header a.button):not(footer a.button), body.woocommerce-account .woocommerce .button:not(header .button):not(footer .button)',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_color_hover',
				array(
					'default'               => 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 22,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-price-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce button:hover, body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover, body.woocommerce-account .woocommerce a.button:not(header a.button):not(footer a.button):hover, body.woocommerce-account .woocommerce .button:not(header .button):not(footer .button):hover',
						),
					],
				)
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_color_bg',
				array(
					'default' 				=> 'var(--sol-color-button-initial)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 23,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-button-color-bg' => 'background-color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce button, body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit], body.woocommerce-account .woocommerce a.button:not(header a.button):not(footer a.button), body.woocommerce-account .woocommerce .button:not(header .button):not(footer .button)',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_account_button_color_bg_hover',
				array(
					'default'               => 'var(--sol-color-button-hover)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_account',
					'priority'        		=> 24,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-account-button-color-bg-hover' => 'background-color', 
							],
							'selector' => 'body.woocommerce-account .woocommerce button:hover, body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover, body.woocommerce-account .woocommerce a.button:not(header a.button):not(footer a.button):hover, body.woocommerce-account .woocommerce .button:not(header .button):not(footer .button):hover',
						),
					],
				)
			)
		);	

		
		
	}
	

}
