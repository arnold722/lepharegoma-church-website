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
class WC_Custom_General_Checkout extends Base_Customizer {
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
				'solace_wc_custom_general_checkout',
				array(
					'priority' 	=> 107,
					'title'    	=> esc_html__( 'Checkout', 'solace' ),
					// 'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_tab',
				array(
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				),
				array(
					'priority'         => 1,
					'section'  => 'solace_wc_custom_general_checkout',
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
							'solace_wc_custom_general_checkout_coupon'    => array(),
							'woocommerce_checkout_company_field'    => array(),
							'woocommerce_checkout_address_2_field'    => array(),
							'woocommerce_checkout_phone_field'    => array(),
							'woocommerce_checkout_highlight_required_fields'    => array(),
							'wp_page_for_privacy_policy'    => array(),
							'woocommerce_terms_page_id'    => array(),
							'woocommerce_checkout_privacy_policy_text'    => array(),
							'woocommerce_checkout_terms_and_conditions_checkbox_text'    => array(),
							
							'woocommerce_checkout_main_address_field'   => array(),
						),						
												
						'design' => array(
							'solace_wc_custom_general_checkout_title_label'   	 => array(),
							'solace_wc_custom_general_checkout_title_font_family'=> array(),
							'solace_wc_custom_general_checkout_title_typeface'   => array(),
							'solace_wc_custom_general_checkout_title_color'   	 => array(),

							'solace_wc_custom_general_checkout_description_label'	=> array(),
							'solace_wc_custom_general_checkout_description_font_family' => array(),
							'solace_wc_custom_general_checkout_description_typeface'	=> array(),
							'solace_wc_custom_general_checkout_description_color'    	=> array(),
							
							'solace_wc_custom_general_checkout_button_label'		=> array(),
							'solace_wc_custom_general_checkout_button_font_family'	=> array(),
							'solace_wc_custom_general_checkout_button_typeface'		=> array(),
							'solace_wc_custom_general_checkout_button_color'    	=> array(),
							'solace_wc_custom_general_checkout_button_color_hover'	=> array(),
							'solace_wc_custom_general_checkout_button_color_bg'    	=> array(),
							'solace_wc_custom_general_checkout_button_color_bg_hover'=> array(),
						),																	
					),
				),
				'Solace\Customizer\Controls\Tabs_Custom'
			)
		);		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_coupon',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
				],
				[
					'label'           => esc_html__( 'Coupon Form', 'solace' ),
					'section'         => 'solace_wc_custom_general_checkout',
					'type'            => 'solace_toggle_control',
					'priority'        => 1,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		// Company Name Field
		$this->add_control(
			new Control(
				'woocommerce_checkout_company_field',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => 'optional',
				],
				[
					'label'    => esc_html__( 'Company Name Field', 'solace' ),
					'section'  => 'solace_wc_custom_general_checkout',
					'choices'  => [
						'optional' => [
							'name' => __( 'Optional', 'solace' ),
						],
						'hidden' => [
							'name' => __( 'Hidden', 'solace' ),
						],
						'required' => [
							'name' => __( 'Required', 'solace' ),
						],
					],
					'priority' => 45,
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		// Country / Region
		$this->add_control(
			new Control(
				'woocommerce_checkout_main_address_field',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => 'optional',
				],
				[
					'label'    => esc_html__( 'Main Address', 'solace' ),
					'section'  => 'solace_wc_custom_general_checkout',
					'description' => esc_html__( 'Include Country, Street Address, Town/City, State/Province, ZipCode', 'solace' ),
					'choices'  => [
						'optional' => [
							'name' => __( 'Optional', 'solace' ),
						],
						'hidden' => [
							'name' => __( 'Hidden', 'solace' ),
						],
						'required' => [
							'name' => __( 'Required', 'solace' ),
						],
					],
					'priority' => 43,
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);



		// Phone Field
		$this->add_control(
			new Control(
				'woocommerce_checkout_phone_field',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'default'           => 'optional',
				],
				[
					'label'    => esc_html__( 'Phone Field', 'solace' ),
					'section'  => 'solace_wc_custom_general_checkout',
					'choices'  => [
						'optional' => [
							'name' => __( 'Optional', 'solace' ),
						],
						'hidden' => [
							'name' => __( 'Hidden', 'solace' ),
						],
						'required' => [
							'name' => __( 'Required', 'solace' ),
						],
					],
					'priority' => 49,
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);



		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_title_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Title', 'solace'),
					'section'         => 'solace_wc_custom_general_checkout',
					'priority'        => 2,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);
		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_title_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_checkout',
					'priority'              => 3,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_CHECKOUT_TITLE);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_title_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 4,
					'section'               => 'solace_wc_custom_general_checkout',
					'input_attrs'           => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => 600,
						'text_transform'         => 'uppercase',
						'size_default'           => array(
							'suffix'  => array(
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							),
							'mobile'  => 21,
							'tablet'  => 28,
							'desktop' => 38,
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
					'font_family_control'   => 'solace_wc_custom_general_checkout_title_font_family',
					'live_refresh_selector' => 'body.woocommerce-checkout h2, body.woocommerce-checkout form.checkout .nv-customer-details h3,body.woocommerce-checkout .nv-order-review h3',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-checkout-title-texttransform'         => 'textTransform',
								'--sol-checkout-title-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-checkout-title-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-title-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-title-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-checkout-title-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-title-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-title-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-checkout-title-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-title-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-title-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-checkout h2, body.woocommerce-checkout form.checkout .nv-customer-details h3,body.woocommerce-checkout .nv-order-review h3',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_title_color',
				array(
					'default' 				=> 'var(--sol-color-heading)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 5,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-title-color' => 'color', 
							],
							'selector' => 'body.woocommerce-checkout h2',
						),
					],
				)
				
			)
		);	
		

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_description_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Description', 'solace'),
					'section'         => 'solace_wc_custom_general_checkout',
					'priority'        => 8,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_description_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_checkout',
					'priority'              => 9,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_description_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 10,
					'section'               => 'solace_wc_custom_general_checkout',
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
					'font_family_control'   => 'solace_wc_custom_general_checkout_description_font_family',
					'live_refresh_selector' => 'body, .site-description',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-checkout-description-texttransform'         => 'textTransform',
								'--sol-checkout-description-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-checkout-description-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-description-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-description-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-checkout-description-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-description-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-description-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-checkout-description-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-description-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-description-letterspacing-desktop' => [
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
				'solace_wc_custom_general_checkout_description_color',
				array(
					'default' 				=> 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 11,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-description-color' => 'color', 
							],
							'selector' => 'body.woocommerce-checkout p.wc-block-components-checkout-step__description, body.woocommerce-checkout .wc-block-checkout__terms span',
						),
					],
				)
				
			)
		);	
		
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Button', 'solace'),
					'section'         => 'solace_wc_custom_general_checkout',
					'priority'        => 18,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_checkout',
					'priority'              => 19,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 20,
					'section'               => 'solace_wc_custom_general_checkout',
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
					'font_family_control'   => 'solace_wc_custom_general_checkout_button_font_family',
					'live_refresh_selector' => 'body, .site-button',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-checkout-button-texttransform'         => 'textTransform',
								'--sol-checkout-button-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-checkout-button-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-button-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-button-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-checkout-button-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-button-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-button-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-checkout-button-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-checkout-button-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-checkout-button-letterspacing-desktop' => [
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
				'solace_wc_custom_general_checkout_button_color',
				array(
					'default' 				=> 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 21,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-button-color' => 'color', 
							],
							'selector' => 'body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained, body .wc-block-components-totals-coupon__content button.wc-block-components-button span',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_color_hover',
				array(
					'default'               => 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 22,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-button-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained:hover, body .wc-block-components-totals-coupon__content button.wc-block-components-button:hover span',
						),
					],
				)
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_color_bg',
				array(
					'default' 				=> 'var(--sol-color-button-initial)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 23,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-button-color-bg' => 'background-color', 
							],
							'selector' => 'body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained, body .wc-block-components-totals-coupon__content button.wc-block-components-button',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_checkout_button_color_bg_hover',
				array(
					'default'               => 'var(--sol-color-button-hover)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_checkout',
					'priority'        		=> 24,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-checkout-button-color-bg-hover' => 'background-color', 
							],
							'selector' => 'body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained:hover, body .wc-block-components-totals-coupon__content button.wc-block-components-button',
						),
					],
				)
			)
		);	

		
		
	}
	

}
