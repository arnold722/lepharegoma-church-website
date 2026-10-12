<?php

/**
 * Card customization options.
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
 * Class Wc_Single_Product_Gallery
 *
 * This class manages the customization options for the WooCommerce card.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Single_Product_Gallery extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the Gallery Options customization.
	 */
	private $section = 'solace_single_product_gallery_options';

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
	 * Adds the customization section for the Gallery Options.
	 *
	 * @return void
	 */
	private function section()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'title'    => esc_html__('Gallery Options', 'solace'),
				)
			)
		);
	}

	/**
	 * Adds the controls for the Gallery Options customization.
	 *
	 * @return void
	 */	
	private function controls()
	{

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY),
					'sanitize_callback' => [$this, 'sanitize_single_product_layout_gallery'],
				],
				[
					'section'  => $this->section,
					'choices'  => [
						'single-product-layout-gallery1' => [
							'name'  => __('Layout 1', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/gallery1.svg',
						],
						'single-product-layout-gallery2'  => [
							'name'  => __('Layout 2', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/gallery2.svg',
						],
						'single-product-layout-gallery3'  => [
							'name'  => __('Layout 3', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/gallery3.svg',
						],
						'single-product-layout-gallery4'  => [
							'name'  => __('Layout 4', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/gallery4.svg',
						],
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		// $this->add_control(
		// 	new Control(
		// 		Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_IMAGE_WIDTH),
		// 		array(
		// 			'sanitize_callback' => 'solace_sanitize_range_value',
		// 			'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_WIDTH),
		// 		),
		// 		array(
		// 			'label'       => esc_html__('Image width', 'solace'),
		// 			'section'  => $this->section,
		// 			'type'        => 'solace_range_control',
		// 			'input_attrs' => [
		// 				'min'        => 1,
		// 				'max'        => 300,
		// 				'defaultVal' => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_WIDTH),
		// 			],
		// 		),
		// 		'Solace\Customizer\Controls\React\Range'
		// 	)
		// );

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX),
				array(
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				),
				array(
					'label'           => __( 'Product Image Lightbox', 'solace' ),
					'section'  => $this->section,
					'type'			  => 'solace_toggle_control_flex',
				),
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM),
				array(
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				),
				array(
					'label'           => __( 'Product Image Zoom', 'solace' ),
					'section'  => $this->section,
					'type'			  => 'solace_toggle_control_flex',
				),
			)
		);		

	}

	/**
	 * Sanitizes the value for the single product layout gallery options control.
	 *
	 * This function ensures that the value is one of the allowed values and sanitizes it using `sanitize_text_field()`.
	 *
	 * @param string $value The value to be sanitized.
	 * @return string The sanitized value.
	 */	
	public function sanitize_single_product_layout_gallery($value)
	{
		$allowed_values = array( 'single-product-layout-gallery1', 'single-product-layout-gallery2', 'single-product-layout-gallery3', 'single-product-layout-gallery4' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'single-product-layout-gallery1';
		}

		return sanitize_text_field($value);
	}
}
