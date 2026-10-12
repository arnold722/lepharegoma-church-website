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
class WC_Custom_General_Cart_Pages extends Base_Customizer {
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
				'solace_wc_custom_general_cart_pages',
				array(
					'priority' 	=> 106,
					'title'    	=> esc_html__( 'Cart', 'solace' ),
					// 'panel' 	=> 'solace_wc_custom_general'
				)
			)
		);
	}

	private function add_main_controls() {
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_tab',
				array(
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				),
				array(
					'priority'         => 1,
					'section'  => 'solace_wc_custom_general_cart_pages',
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
							'solace_wc_custom_general_cart_coupon'    => array(),
						),						
												
						'design' => array(
							'solace_wc_custom_general_cart_title_label'			=> array(),
							'solace_wc_custom_general_cart_title_font_family'   => array(),
							'solace_wc_custom_general_cart_title_typeface'		=> array(),
							'solace_wc_custom_general_cart_title_color'    		=> array(),
							'solace_wc_custom_general_cart_title_color_hover'	=> array(),

							'solace_wc_custom_general_cart_description_label'	=> array(),
							'solace_wc_custom_general_cart_description_font_family' => array(),
							'solace_wc_custom_general_cart_description_typeface'	=> array(),
							'solace_wc_custom_general_cart_description_color'    	=> array(),
							// 'solace_wc_custom_general_cart_description_color_hover'	=> array(),
							
							'solace_wc_custom_general_cart_price_label'			=> array(),
							'solace_wc_custom_general_cart_price_font_family'	=> array(),
							'solace_wc_custom_general_cart_price_typeface'		=> array(),
							'solace_wc_custom_general_cart_price_color'    		=> array(),
							// 'solace_wc_custom_general_cart_price_color_hover'	=> array(),
							
							'solace_wc_custom_general_cart_button_label'		=> array(),
							'solace_wc_custom_general_cart_button_font_family'	=> array(),
							'solace_wc_custom_general_cart_button_typeface'		=> array(),
							'solace_wc_custom_general_cart_button_color'    	=> array(),
							'solace_wc_custom_general_cart_button_color_hover'	=> array(),
							'solace_wc_custom_general_cart_button_color_bg'    	=> array(),
							'solace_wc_custom_general_cart_button_color_bg_hover'=> array(),
						),																	
					),
				),
				'Solace\Customizer\Controls\Tabs_Custom'
			)
		);		

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_coupon',
				[
					'sanitize_callback' => 'solace_sanitize_checkbox',
					'default'           => true,
					'transport'         => 'postMessage',

				],
				[
					'label'           => esc_html__( 'Coupon Codes', 'solace' ),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'type'            => 'solace_toggle_control',
					'priority'        => 2,
				],
				'Solace\Customizer\Controls\Checkbox'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_title_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Title', 'solace'),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'priority'        => 3,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_title_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_cart_pages',
					'priority'              => 4,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_title_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 5,
					'section'               => 'solace_wc_custom_general_cart_pages',
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
					'font_family_control'   => 'solace_wc_custom_general_cart_title_font_family',
					'live_refresh_selector' => 'body.woocommerce-cart .wc-block-cart-items .wc-block-components-product-name, .woocommerce-cart .cross-sells-product .wc-block-components-product-name, .woocommerce-cart .wc-block-cart table th span, .woocommerce-cart .wc-block-cart .wp-block-woocommerce-cart-cross-sells-block h2, .woocommerce-cart .wc-block-cart .wc-block-cart__totals-title, .woocommerce-cart .wc-block-cart .wc-block-components-totals-item__label, body.woocommerce-cart .wc-block-components-totals-coupon .wc-block-components-panel__button,body.woocommerce-cart .is-large.wc-block-cart .wc-block-cart__totals-title, body.woocommerce-cart .woocommerce .woocommerce-cart-form .shop_table th, body.woocommerce-cart .woocommerce-cart-form .shop_table td.product-name a, body.woocommerce-cart .cart-collaterals .cross-sells h2, body.woocommerce-cart .cart-collaterals .cross-sells ul.products li.product a.woocommerce-loop-product__link>h2, body.woocommerce-cart .cart-collaterals .cart_totals h2, body.woocommerce-cart .cart-collaterals .cart_totals th',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-cart-title-texttransform'         => 'textTransform',
								'--sol-cart-title-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-cart-title-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-title-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-title-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-cart-title-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-title-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-title-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-cart-title-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-title-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-title-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-cart .wc-block-cart-items .wc-block-components-product-name, .woocommerce-cart .cross-sells-product .wc-block-components-product-name, .woocommerce-cart .wc-block-cart table th span, .woocommerce-cart .wc-block-cart .wp-block-woocommerce-cart-cross-sells-block h2, .woocommerce-cart .wc-block-cart .wc-block-cart__totals-title, .woocommerce-cart .wc-block-cart .wc-block-components-totals-item__label, body.woocommerce-cart .wc-block-components-totals-coupon .wc-block-components-panel__button,body.woocommerce-cart .is-large.wc-block-cart .wc-block-cart__totals-title, body.woocommerce-cart .woocommerce .woocommerce-cart-form .shop_table th, body.woocommerce-cart .woocommerce-cart-form .shop_table td.product-name a, body.woocommerce-cart .cart-collaterals .cross-sells h2, body.woocommerce-cart .cart-collaterals .cross-sells ul.products li.product a.woocommerce-loop-product__link>h2, body.woocommerce-cart .cart-collaterals .cart_totals h2, body.woocommerce-cart .cart-collaterals .cart_totals th',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_title_color',
				array(
					'default' 				=> 'var(--sol-color-heading)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 6,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-title-color' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .wc-block-cart-items .wc-block-components-product-name, body.woocommerce-cart .cross-sells-product .wc-block-components-product-name, .woocommerce-cart .wc-block-cart table th span, .woocommerce-cart .wc-block-cart .wp-block-woocommerce-cart-cross-sells-block h2, .woocommerce-cart .wc-block-cart .wc-block-cart__totals-title, .woocommerce-cart .wc-block-cart .wc-block-components-totals-item__label, body.woocommerce-cart .is-large.wc-block-cart .wc-block-cart__totals-title',
						),
					],
					
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_title_color_hover',
				array(
					'default'               => 'var(--sol-color-link-button-hover)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 7,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-title-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .wc-block-cart-items .wc-block-components-product-name:hover,body.woocommerce-cart .cross-sells-product .wc-block-components-product-name:hover, body.woocommerce-cart .woocommerce-cart-form .shop_table td.product-name a:hover',
						),
					],
				)
			)
		);	


		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_description_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Description', 'solace'),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'priority'        => 8,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_description_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_cart_pages',
					'priority'              => 9,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_description_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 10,
					'section'               => 'solace_wc_custom_general_cart_pages',

					'type'                  => 'solace_typeface_control',
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
					'font_family_control'   => 'solace_wc_custom_general_cart_description_font_family',
					'live_refresh_selector' => 'body.woocommerce-cart .wc-block-components-product-metadata__description>p',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-cart-description-texttransform'         => 'textTransform',
								'--sol-cart-description-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-cart-description-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-description-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-description-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-cart-description-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-description-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-description-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-cart-description-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-description-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-description-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-cart .wc-block-components-product-metadata__description>p',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_description_color',
				array(
					'default' 				=> 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 11,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-description-color' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .wc-block-components-product-metadata__description>p',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_description_color_hover',
				array(
					'default'               => 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 12,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-description-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce, h3 a',
						),
					],
				)
			)
		);	



		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_price_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Price', 'solace'),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'priority'        => 13,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_price_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_cart_pages',
					'priority'              => 14,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_price_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 15,
					'section'               => 'solace_wc_custom_general_cart_pages',
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
					'font_family_control'   => 'solace_wc_custom_general_cart_price_font_family',
					// 'live_refresh_selector' => 'body.woocommerce-cart .wc-block-components-product-price__regular, body.woocommerce-cart .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart .wc-block-components-product-price__value, body.woocommerce-cart .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart .wc-block-components-sale-badge, body.woocommerce-cart .cross-sells-product .wc-block-components-quantity-selector input,body.woocommerce-cart .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-price .woocommerce-Price-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-subtotal .woocommerce-Price-amount, body.woocommerce-cart .cart-collaterals .cross-sells ul.products li.product .price .woocommerce-Price-amount, body.woocommerce-cart .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-Price-amount.amount,.wc-custom-general-cart_pages',
					'live_refresh_selector' => 'body.woocommerce-cart .wc-block-components-product-price__regular, body.woocommerce-cart .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart .wc-block-components-product-price__value, body.woocommerce-cart .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart .wc-block-components-sale-badge, body.woocommerce-cart .cross-sells-product .wc-block-components-quantity-selector input, body.woocommerce-cart .wc-block-cart-items .wc-block-cart-item__total .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-price .woocommerce-Price-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-subtotal .woocommerce-Price-amount, body.woocommerce-cart .cart-collaterals .cross-sells ul.products li.product .price .woocommerce-Price-amount, body.woocommerce-cart .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-Price-amount.amount',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-cart-price-texttransform'         => 'textTransform',
								'--sol-cart-price-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-cart-price-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-price-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-price-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-cart-price-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-price-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-price-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-cart-price-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-price-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-price-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							// 'selector' => 'body.woocommerce-cart .wc-block-components-product-price__regular, body.woocommerce-cart .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart .wc-block-components-sale-badge, body.woocommerce-cart .cross-sells-product .wc-block-components-quantity-selector input,body.woocommerce-cart .wc-block-components-formatted-money-amount',
							'selector' => 'body.woocommerce-cart .wc-block-components-product-price__regular, body.woocommerce-cart .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart .wc-block-components-product-price__value, body.woocommerce-cart .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart .wc-block-components-sale-badge, body.woocommerce-cart .cross-sells-product .wc-block-components-quantity-selector input, body.woocommerce-cart .wc-block-cart-items .wc-block-cart-item__total .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-price .woocommerce-Price-amount, body.woocommerce-cart .woocommerce-cart-form .shop_table .product-subtotal .woocommerce-Price-amount, body.woocommerce-cart .cart-collaterals .cross-sells ul.products li.product .price .woocommerce-Price-amount, body.woocommerce-cart .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-Price-amount.amount',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_price_color',
				array(
					'default' 				=> 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 16,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-price-color' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .wc-block-components-product-price__regular, body.woocommerce-cart .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart .wc-block-components-sale-badge, body.woocommerce-cart .cross-sells-product .wc-block-components-quantity-selector input,body.woocommerce-cart .wc-block-cart-items .wc-block-cart-item__total .wc-block-components-formatted-money-amount, body.woocommerce-cart .wc-block-components-formatted-money-amount, body.woocommerce-cart .woocommerce-Price-amount.amount',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_price_color_hover',
				array(
					'default'               => 'var(--sol-color-base-font)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 17,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-price-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce, h3 a',
						),
					],
				)
			)
		);	



		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_label',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Button', 'solace'),
					'section'         => 'solace_wc_custom_general_cart_pages',
					'priority'        => 18,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_font_family',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => esc_html__('Font', 'solace'),
					'section'               => 'solace_wc_custom_general_cart_pages',
					'priority'              => 19,
					'type'                  => 'solace_font_family_control',
				),
				'\Solace\Customizer\Controls\React\Font_Family'
			)
		);
		$defaults = Mods::get_alternative_mod_default(Config::MODS_TYPEFACE_GENERAL);

		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_typeface',
				array(
					'default'   => $defaults,
					'transport'             => 'postMessage',
				),
				[
					'priority'              => 20,
					'section'               => 'solace_wc_custom_general_cart_pages',
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
					'font_family_control'   => 'solace_wc_custom_general_cart_button_font_family',
					'live_refresh_selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button, body.woocommerce-cart .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span, body.woocommerce-cart .wc-block-components-totals-coupon__content button.wc-block-components-button span',
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--sol-cart-button-texttransform'         => 'textTransform',
								'--sol-cart-button-fontweight'            => 'fontWeight',
								
								// Responsive font-size with desktop, tablet, and mobile
								'--sol-cart-button-fontsize-mobile'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-button-fontsize-tablet'      => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-button-fontsize-desktop'     => [
									'key'        => 'fontSize',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive line-height with desktop, tablet, and mobile
								'--sol-cart-button-lineheight-mobile'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-button-lineheight-tablet'    => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-button-lineheight-desktop'   => [
									'key'        => 'lineHeight',
									'responsive' => true,
									'device'     => 'desktop',
								],

								// Responsive letter-spacing with suffix 'px'
								'--sol-cart-button-letterspacing-mobile' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'mobile',
								],
								'--sol-cart-button-letterspacing-tablet' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'tablet',
								],
								'--sol-cart-button-letterspacing-desktop' => [
									'key'        => 'letterSpacing',
									'suffix'     => 'px',
									'responsive' => true,
									'device'     => 'desktop',
								],
							],
							'selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button, body.woocommerce-cart .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span, body.woocommerce-cart .wc-block-components-totals-coupon__content button.wc-block-components-button span',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Typography'
			)
		);
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_color',
				array(
					'default' 				=> 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Text', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 21,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-button-color' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button, body.woocommerce-cart .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span, body.woocommerce-cart .wc-block-components-totals-coupon__content button.wc-block-components-button span',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_color_hover',
				array(
					'default'               => 'var(--sol-color-page-title-text)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 22,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-button-color-hover' => 'color', 
							],
							'selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button:hover, body.woocommerce-cart .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span:hover, body.woocommerce-cart .wc-block-components-totals-coupon__content button.wc-block-components-button:hover span',
						),
					],
				)
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_color_bg',
				array(
					'default' 				=> 'var(--sol-color-button-initial)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Color', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 23,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-button-color-bg' => 'background-color', 
							],
							'selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button, body.woocommerce-cart .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained',
						),
					],
				)
				
			)
		);	
		$this->add_control(
			new Control(
				'solace_wc_custom_general_cart_button_color_bg_hover',
				array(
					'default'               => 'var(--sol-color-button-hover)',
					'sanitize_callback'     => 'solace_sanitize_colors',
					'transport'             => 'postMessage',
				),
				array(
					'label'                 => __( 'Background Hover', 'solace' ),
					'type'                  => 'solace_color_control',
					'section'         		=> 'solace_wc_custom_general_cart_pages',
					'priority'        		=> 24,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => [
								'--sol-cart-button-color-bg-hover' => 'background-color', 
							],
							'selector' => 'body.woocommerce-cart .cross-sells-product button.add_to_cart_button:hover, body.woocommerce-cart.wp-block-woocommerce-cart-totals-block.wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover',
						),
					],
				)
			)
		);	
	}
	

}
