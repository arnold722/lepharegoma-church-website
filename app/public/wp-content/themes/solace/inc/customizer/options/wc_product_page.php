<?php

/**
 * Product page customization options.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Section;
use Solace\Customizer\Types\Control;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Customizer_Defaults;

/**
 * Class Wc_Product_Page
 *
 * This class manages the customization options for the WooCommerce product page.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Product_Page extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the product page customization.
	 */
	private $section = 'solace_wc_product_page';

	/**
	 * Adds customizer controls for the product page.
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
	 * Adds the customization section for the product page.
	 *
	 * @return void
	 */
	private function section()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'priority' => 105,
					'title'    => esc_html__('Product Pages', 'solace'),
				)
			)
		);
	}

	/**
	 * Adds the controls for the product page customization.
	 *
	 * @return void
	 */
	private function controls()
	{

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LABEL_SHOP_SETTINGS),
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Shop Settings', 'solace'),
					'section'         => $this->section,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
					'sanitize_callback' => [$this, 'sanitize_product_page_shop_settings_layout'],
				],
				[
					'section'  => $this->section,
					'choices'  => [
						'product-page-layout1' => [
							'name'  => __('Layout 1', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout1.svg',
						],
						'product-page-layout2'  => [
							'name'  => __('Layout 2', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout2.svg',
						],
						'product-page-layout3'    => [
							'name'  => __('Layout 3', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout3.svg',
						],
						'product-page-layout4'    => [
							'name'  => __('Layout 4', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout4.svg',
						],
						'product-page-layout5'    => [
							'name'  => __('Special 1', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout5.svg',
						],
						'product-page-layout6'    => [
							'name'  => __('Special 2', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout6.svg',
						],
						'product-page-layout-custom' => [
							'name'  => __('Custom', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/layout1.svg',
						],						
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LABEL_COLUMN_AND_ROW),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'           => esc_html__('Columns And Rows', 'solace'),
					'section'         => $this->section,
					'active_callback' => array($this, 'is_layout_not_layout5_active'),
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);		

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW),
				array(
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW),
					'sanitize_callback' => [$this, 'sanitize_column_and_row'],
				),
				array(
					'label'       => esc_html__('Columns & Rows', 'solace'),
					'section'     => $this->section,
					'type'        => 'solace_column_and_row_control',
					'active_callback' => array($this, 'is_layout_not_layout5_active'),
				),
				'Solace\Customizer\Controls\React\Column_And_Row'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Link', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => ['section', 'solace_wc_card_options'],
						'string' => esc_html__('Card Options', 'solace'),
					],
					'active_callback' => array($this, 'is_layout_custom_active_callback'),
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);

		$default_card_options_add_to_cart = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_add_to_cart['bottomSpacing'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-auto-hide'    => 'autoHide',
								'--wc-card-options-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product a.button.add_to_cart_button',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Cart'
			)
		);			

		$default_card_options_excerpt = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_excerpt['bottomSpacing'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-excerpt-length'   => [
									'key'        => 'length',
									'responsive' => true,
								],								
								'--wc-card-options-excerpt-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product .product-short-description',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Excerpt'
			)
		);		

		$default_card_options_star_rating = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_star_rating['bottomSpacing'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-star-rating-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product .star-rating',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Star_Rating'
			)
		);			

		$default_card_options_price = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_price['bottomSpacing'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-price-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product .price',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Price'
			)
		);		

		$default_card_options_categories = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES),
				[
					// 'transport' => 'refresh',
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_categories['bottomSpacing'],
					),
					'is_for'                => 'imageRatio',
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-categories-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product .product-categories',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Categories'
			)
		);		

		$default_card_options_title = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE);
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_title['bottomSpacing'],
					),
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-title-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product .woocommerce-loop-product__title',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Title'
			)
		);		

		$default_card_options_product_image = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE);

		$registered_image_sizes = wp_get_registered_image_subsizes();

		$image_size_options = array();
		
		foreach ($registered_image_sizes as $size => $details) {
			if ( 'solace-wc-shop-layout3-layout4-layout6' !== $size ) {
				$image_size_options[] = array( 'value' => $size, 'label' => ucwords( str_replace( ['_', '-'], ' ', $size ) ) );
			}
		}		
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE),
				[
					'transport' => $this->selective_refresh,
					'default'   => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE),
				],
				[
					'section'               => 'solace_wc_card_options',
					'input_attrs'           => array(
						'bottom_spacing_override_value'  => $default_card_options_product_image['bottomSpacing'],
					),
					// 'list_images' => [
					// 	array( 'value' => 'full', 'label' => 'full' ),
					// 	array( 'value' => 'large', 'label' => 'large' ),
					// ],						
					'list_images' 			=> $image_size_options,				
					'is_for'                => 'imageRatio1',
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => [
								'--wc-card-options-product-image-spacing'   => [
									'key'        => 'bottomSpacing',
									'responsive' => true,
								],
							],
							'selector' => 'body.woocommerce-shop .solace-shop-layout-custom ul.products li.product img',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Card_Options_Product_Image'
			)
		);		

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LABEL_PAGE_ELEMENTS),
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Page elements', 'solace'),
					'section'         => $this->section,
					'active_callback' => array($this, 'is_layout1_to_4_and_4_active_callback'),
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				],
				[
					'label'           => esc_html__('Product sorting', 'solace'),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Link', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => ['section', 'solace_wc_product_page_pagination'],
						'string' => esc_html__('Pagination', 'solace'),
					],
					'active_callback' => array($this, 'is_layout1_to_4_and_4_active_callback'),
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_sidebar),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Link', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => ['section', 'solace_wc_product_page_sidebar'],
						'string' => esc_html__('Sidebar', 'solace'),
					],
					'active_callback' => array($this, 'is_layout1_to_4_and_4_active_callback'),
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LOOP_IMAGES),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_LOOP_IMAGES),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				],
				[
					'label'           => esc_html__('Loop images', 'solace'),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
					'active_callback' => array($this, 'loop_images_active_callback'),
				],
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LABEL_FEATURED_IMAGES),
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Featured Images', 'solace'),
					'section'         => $this->section,
					'active_callback' => array($this, 'is_layout5_active_callback'),
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);		
	
		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1),
					// 'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Featured Images 1', 'solace'),
					'section'  => $this->section,
					'active_callback' => array($this, 'is_layout5_active_callback'),
					'options'           => [
						'priority'    => 0,
						'input_attrs' => [
							'compChange'    => '',
							'sameLabel'     => __( 'image.', 'solace' ),
							'height'        => 500,
							'width'         => 300,
							'flexHeight'    => false,
							'flexWidth'     => false,
						],
					]
				],
				'\Solace\Customizer\Controls\React\Media_Image'
			)
		);		

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2),
					// 'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Featured Images 2', 'solace'),
					'section'  => $this->section,
					'active_callback' => array($this, 'is_layout5_active_callback'),
					'options'           => [
						'priority'    => 0,
						'input_attrs' => [
							'compChange'    => '',
							'sameLabel'     => __( 'image.', 'solace' ),
							'height'        => null,
							'width'         => null,
							'flexHeight'    => false,
							'flexWidth'     => false,
						],
					]
				],
				'\Solace\Customizer\Controls\React\Media_Image'
			)
		);		

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3),
					// 'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Featured Images 3', 'solace'),
					'section'  => $this->section,
					'active_callback' => array($this, 'is_layout5_active_callback'),
					'options'           => [
						'priority'    => 0,
						'input_attrs' => [
							'compChange'    => '',
							'sameLabel'     => __( 'image.', 'solace' ),
							'height'        => null,
							'width'         => null,
							'flexHeight'    => false,
							'flexWidth'     => false,
						],
					]
				],
				'\Solace\Customizer\Controls\React\Media_Image'
			)
		);		

	}

	/**
	 * Sanitize the column and row data.
	 *
	 * @param array $input The input data to sanitize.
	 * @return array The sanitized data.
	 */
	function sanitize_column_and_row( $input ) {
		$sanitized_data = array();

		// Sanitize minColumn.
		if ( isset( $input['minColumn'] ) ) {
			$sanitized_data['minColumn'] = absint( $input['minColumn'] );
		} else {
			$sanitized_data['minColumn'] = 1; // default value.
		}

		// Sanitize valueColumn and ensure it is within the min and max range.
		if ( isset( $input['valueColumn'] ) ) {
			$sanitized_data['valueColumn'] = absint( $input['valueColumn'] );
			if ( $sanitized_data['valueColumn'] < $sanitized_data['minColumn'] ) {
				$sanitized_data['valueColumn'] = $sanitized_data['minColumn'];
			} elseif ( isset( $input['maxColumn'] ) && $sanitized_data['valueColumn'] > absint( $input['maxColumn'] ) ) {
				$sanitized_data['valueColumn'] = absint( $input['maxColumn'] );
			}
		} else {
			$sanitized_data['valueColumn'] = 3; // default value.
		}

		// Sanitize maxColumn.
		// if ( isset( $input['maxColumn'] ) ) {
		// 	$sanitized_data['maxColumn'] = absint( $input['maxColumn'] );
		// } else {
			$sanitized_data['maxColumn'] = 5; // default value.
		// }

		// Sanitize stepColumn.
		if ( isset( $input['stepColumn'] ) ) {
			$sanitized_data['stepColumn'] = absint( $input['stepColumn'] );
		} else {
			$sanitized_data['stepColumn'] = 1; // default value.
		}

		// Sanitize minRow.
		if ( isset( $input['minRow'] ) ) {
			$sanitized_data['minRow'] = absint( $input['minRow'] );
		} else {
			$sanitized_data['minRow'] = 1; // default value.
		}

		// Sanitize valueRow and ensure it is within the min and max range.
		if ( isset( $input['valueRow'] ) ) {
			$sanitized_data['valueRow'] = absint( $input['valueRow'] );
			// if ( $sanitized_data['valueRow'] < $sanitized_data['minRow'] ) {
			// 	$sanitized_data['valueRow'] = $sanitized_data['minRow'];
			// } elseif ( isset( $input['maxRow'] ) && $sanitized_data['valueRow'] > absint( $input['maxRow'] ) ) {
			// 	$sanitized_data['valueRow'] = absint( $input['maxRow'] );
			// }
		} else {
			$sanitized_data['valueRow'] = 4; // default value.
		}

		// Sanitize maxRow.
		// if ( isset( $input['maxRow'] ) ) {
		// 	$sanitized_data['maxRow'] = absint( $input['maxRow'] );
		// } else {
		// 	$sanitized_data['maxRow'] = 10; // default value.
		// }

		// Sanitize stepRow.
		if ( isset( $input['stepRow'] ) ) {
			$sanitized_data['stepRow'] = absint( $input['stepRow'] );
		} else {
			$sanitized_data['stepRow'] = 1; // default value.
		}

		return $sanitized_data;
	}

	/**
	 * Checks if the product page layout is set to "Layout 1" or "Layout 2" or "Layout 3" or "Layout 4" and returns true if it is, otherwise returns false.
	 * This function is used to determine whether the "Product Sorting" control should be active or not.
	 *
	 * @return bool True if the product page layout is "Layout 1", "Layout 2", "Layout 3" or "Layout 4", false otherwise.
	 */
	public function is_layout1_to_4_and_4_active_callback()
	{
		$shop_settings_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
		);

		if ('product-page-layout1' === $shop_settings_layout || 'product-page-layout2' === $shop_settings_layout || 'product-page-layout3' === $shop_settings_layout || 'product-page-layout4' === $shop_settings_layout || 'product-page-layout6' === $shop_settings_layout) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the product page layout is set to "Layout 1", "Layout 2", "Layout 3", "Layout 4", or "Layout 6"
	 * and returns true if it is, otherwise returns false.
	 * This function is used to determine whether the "Product Sorting", "Pagination", and "Sidebar" controls should be active or not.
	 *
	 * @return bool True if the product page layout is "Layout 1", "Layout 2", "Layout 3", "Layout 4", or "Layout 6", false otherwise.
	 */
	public function is_layout_not_layout5_active()
	{
		$shop_settings_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
		);

		if ('product-page-layout1' === $shop_settings_layout || 'product-page-layout2' === $shop_settings_layout || 'product-page-layout3' === $shop_settings_layout || 'product-page-layout4' === $shop_settings_layout || 'product-page-layout6' === $shop_settings_layout) {
			return true;
		} else {
			return false;
		}
	}	

	/**
	 * Checks if the product page layout is set to "Layout Custom" and returns true if it is, otherwise returns false.
	 * This function is used to determine whether the "Card Sorting", "Pagination", and "Sidebar" controls should be active or not.
	 *
	 * @return bool True if the product page layout is "Layout Custom", false otherwise.
	 */	
	public function is_layout_custom_active_callback()
	{
		$shop_settings_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
		);

		if ( 'product-page-layout-custom' === $shop_settings_layout ) {
			return true;
		} else {
			return false;
		}
	}	

	/**
	 * Checks if the product page layout is set to "Layout 5" and returns true if it is, otherwise returns false.
	 * This function is used to determine whether the "Featured Images" controls should be active or not.
	 *
	 * @return bool True if the product page layout is "Layout 5", false otherwise.
	 */	
	public function is_layout5_active_callback()
	{
		$shop_settings_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
		);

		if ( 'product-page-layout5' === $shop_settings_layout ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the product page layout is set to "Layout 1" and returns true if it is, otherwise returns false.
	 * This function is used to determine whether the "Loop images" control should be active or not.
	 *
	 * @return bool True if the product page layout is "Layout 1", false otherwise.
	 */
	public function loop_images_active_callback()
	{
		$shop_settings_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT),
		);

		if ('product-page-layout5' === $shop_settings_layout) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Sanitizes the product page shop settings layout value.
	 *
	 * This function ensures that the value of the product page shop settings layout control is one of the allowed layouts.
	 *
	 * @param string $value The value to be sanitized.
	 *
	 * @return string The sanitized value.
	 */
	public function sanitize_product_page_shop_settings_layout($value)
	{
		$allowed_values = array('product-page-layout1', 'product-page-layout2', 'product-page-layout3', 'product-page-layout4', 'product-page-layout5', 'product-page-layout6', 'product-page-layout-custom');
		if (!in_array($value, $allowed_values, true)) {
			return 'product-page-layout1';
		}

		return sanitize_text_field($value);
	}
}
