<?php

/**
 * Product Elements.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Customizer_Defaults;

/**
 * Class Wc_Single_Product_Elements
 *
 * This class manages the customization options for the WooCommerce.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Single_Product_Elements extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the Gallery Options customization.
	 */
	private $section = 'solace_single_product_elements';

	/**
	 * Adds customizer controls for the Gallery Options.
	 *
	 * This function is intended to be extended to add specific controls.
	 *
	 * @return void
	 */
	public function add_controls()
	{
		$this->section();
		$this->controls();
	}

	/**
	 * Adds the customization section for the Product Elements.
	 *
	 * @return void
	 */
	private function section()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'title'    => esc_html__('Product Elements', 'solace'),
				)
			)
		);
	}

	/**
	 * Adds the controls for the product elements customization.
	 *
	 * @return void
	 */	
	private function controls()
	{
		$prefix = Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS;
		$order_default_components = array(
			$prefix . '-breadcrumbs',
			$prefix . '-title',
			$prefix . '-star-rating',
			$prefix . '-price',
			$prefix . '-short-description',
			$prefix . '-divider-1',
			$prefix . '-add-to-cart',
			$prefix . '-divider-2',
			$prefix . '-meta',
			$prefix . '-payment-methods',
			$prefix . '-additional-info',
		);

		$components = array(
			$prefix . '-breadcrumbs' 	   => __( 'Breadcrumbs', 'solace' ),
			$prefix . '-title'   		   => __( 'Title', 'solace' ),
			$prefix . '-star-rating'       => __( 'Star Rating', 'solace' ),
			$prefix . '-price'             => __( 'Price', 'solace' ),
			$prefix . '-short-description' => __( 'Short Description', 'solace' ),
			$prefix . '-divider-1'    	   => __( 'Divider 1', 'solace' ),
			$prefix . '-add-to-cart'       => __( 'Add to Cart', 'solace' ),
			$prefix . '-divider-2'    	   => __( 'Divider 2', 'solace' ),			
			$prefix . '-meta'    		   => __( 'Meta', 'solace' ),			
			$prefix . '-payment-methods'   => __( 'Payment Methods', 'solace' ),			
			$prefix . '-additional-info'   => __( 'Additional Info', 'solace' ),			
		);		

		$this->add_control(
			new Control(
				Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS,
				[
					'sanitize_callback' => [ $this, 'sanitize_ordering_product_elements' ],
					'default'           => wp_json_encode( $order_default_components ),
				],
				[
					'label'      => esc_html__( 'Product Elements', 'solace' ),
					'section'    => $this->section,
					'components' => $components,
				],
				'\Solace\Customizer\Controls\React\Solace_Sortable'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_BREADCRUMBS),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_BREADCRUMBS),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-breadcrumbs'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-title'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .product_title.entry-title',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Heading_Bottom_Spacing'
			)
		);		

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_STAR_RATING),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_STAR_RATING),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-star-rating'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .woocommerce-product-rating',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);	

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PRICE),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PRICE),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-price'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary p.price',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);	

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_SHORT_DESCRIPTION),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_SHORT_DESCRIPTION),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-short-description'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .woocommerce-product-details__short-description p',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);	

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER1),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER1),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-divider1'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .divider1',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);	

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'vars'     => [
								'--wc-product-elements-add-to-cart-btn-width' => [
									'key'        => 'buttonWidth',
									'responsive' => true,
								],
								'--wc-product-elements-add-to-cart-bottom-spacing' => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary >form.cart',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Product_Element_Add_To_Cart'
			)
		);			

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER2),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER2),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-divider2'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .divider2',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_META),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_META),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-product-elements-meta'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary .product_meta',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Popup_Only_Bottom_Spacing'
			)
		);	

		// $prefix = Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS;
		// $order_default_components = array(
		// 	$prefix . '-breadcrumbs',
		// 	$prefix . '-title',
		// 	$prefix . '-star-rating',
		// 	$prefix . '-price',
		// 	$prefix . '-short-description',
		// 	$prefix . '-divider-1',
		// 	$prefix . '-add-to-cart',
		// 	$prefix . '-divider-2',
		// 	$prefix . '-meta',
		// 	$prefix . '-payment-methods',
		// 	$prefix . '-additional-info',
		// );

		// $components = array(
		// 	$prefix . '-breadcrumbs' 	   => __( 'Breadcrumbs', 'solace' ),
		// 	$prefix . '-title'   		   => __( 'Title', 'solace' ),
		// 	$prefix . '-star-rating'       => __( 'Star Rating', 'solace' ),
		// 	$prefix . '-price'             => __( 'Price', 'solace' ),
		// 	$prefix . '-short-description' => __( 'Short Description', 'solace' ),
		// 	$prefix . '-divider-1'    	   => __( 'Divider 1', 'solace' ),
		// 	$prefix . '-add-to-cart'       => __( 'Add to Cart', 'solace' ),
		// 	$prefix . '-divider-2'    	   => __( 'Divider 2', 'solace' ),			
		// 	$prefix . '-meta'    		   => __( 'Meta', 'solace' ),			
		// 	$prefix . '-payment-methods'   => __( 'Payment Methods', 'solace' ),			
		// 	$prefix . '-additional-info'   => __( 'Additional Info', 'solace' ),			
		// );		

		// $this->add_control(
		// 	new Control(
		// 		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS,
		// 		[
		// 			'sanitize_callback' => [ $this, 'sanitize_ordering_product_elements' ],
		// 			'default'           => wp_json_encode( $order_default_components ),
		// 		],
		// 		[
		// 			'label'      => esc_html__( 'Product Elements', 'solace' ),
		// 			'section'    => $this->section,
		// 			'components' => $components,
		// 		],
		// 		'\Solace\Customizer\Controls\React\Solace_Sortable'
		// 	)
		// );

		$prefix = Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS;
		$order_default_payment_methods = array(
			$prefix . '-breadcrumbs',
			$prefix . '-title',
			$prefix . '-star-rating',
			$prefix . '-price',
			$prefix . '-short-description',
			$prefix . '-divider-1',
			$prefix . '-add-to-cart',
			$prefix . '-divider-2',
			$prefix . '-meta',
			$prefix . '-payment-methods',
			$prefix . '-additional-info',
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS),
				[
					'transport' => $this->selective_refresh,
					// 'sanitize_callback' => [ $this, 'aaaaaa' ],
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'vars'     => [
								'--wc-product-elements-payment-methods-icon-size' => [
									'key'        => 'iconSize',
									'responsive' => true,
								],
								'--wc-product-elements-payment-methods-bottom-spacing' => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product',
						],
					],					
				],
				'\Solace\Customizer\Controls\React\Popup_Payment_Methods'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO),
				],
				[
					'section'    => $this->section,
					'relation'   => $this->section,					
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar'   => [
							'vars'     => [
								'--wc-product-elements-additional-info-bottom-spacing' => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.single-product div.product div.summary',
						],
					],					
				],
				'\Solace\Customizer\Controls\React\Popup_Additional_Info'
			)
		);		


		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER),
				array(
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				),
				array(
					'label'           => __( 'Sticky Container', 'solace' ),
					'section'  => $this->section,
					'type'			  => 'solace_toggle_control_flex',
				),
			)
		);



	}

	/**
	 * Sanitizes the ordering of product elements.
	 *
	 * This function sanitizes the ordering of product elements by ensuring that only allowed elements are included.
	 * It also ensures that the order of elements is consistent with the allowed elements.
	 *
	 * @param string $value The value to be sanitized.
	 * @return string The sanitized value.
	 */
	public function sanitize_ordering_product_elements( $value ) {

		$prefix = Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS;

		$elements = array(
			'breadcrumbs', 'star-rating', 'price', 'short-description',
			'divider-1', 'add-to-cart', 'title', 'divider-2', 'meta',
			'payment-methods', 'additional-info'
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

}
