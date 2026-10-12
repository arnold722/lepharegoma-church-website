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
 * Class Wc_Single_Product
 *
 * This class manages the customization options for the WooCommerce product page.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Single_Product extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the product page customization.
	 */
	private $section = 'solace_wc_single_product';

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
					'title'    => esc_html__('Single Product', 'solace'),
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
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_LABEL_PAGE_LAYOUT),
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Page Layout', 'solace'),
					'section'         => $this->section,
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
					'sanitize_callback' => [$this, 'sanitize_single_product_page_layout'],
				],
				[
					'section'  => $this->section,
					'choices'  => [
						'single-product-layout-left' => [
							'name'  => __('Left', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/layout1.svg',
						],
						'single-product-layout-right'  => [
							'name'  => __('Right', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/layout2.svg',
						],
						'single-product-special1' => [
							'name'  => __('Special 1', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/layout-special1.svg',
						],
						'single-product-special2'  => [
							'name'  => __('Special 2', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/layout-special2.svg',
						],
						'single-product-layout-custom' => [
							'name'  => __('Custom', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/single-product/layout1.svg',
						],						
					],
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_OPTIONS),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Link', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => ['section', 'solace_single_product_gallery_options'],
						'string' => esc_html__('Gallery Options', 'solace'),
					],
					'active_callback' => array($this, 'is_layout_left_and_right_active_callback'),
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);	

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_ELEMENTS),
				[
					'sanitize_callback' => 'sanitize_text_field',
				],
				[
					'label'    => __('Link', 'solace'),
					'section'  => $this->section,
					'type'     => 'solace_link_custom',
					'link'     => [
						'focus'  => ['section', 'solace_single_product_elements'],
						'string' => esc_html__('Product Elements', 'solace'),
					],
					'active_callback' => array($this, 'is_layout_custom_active_callback'),
				],
				'Solace\Customizer\Controls\React\Link_Custom'
			)
		);		
	}

	/**
	 * Sanitizes the single product page layout value.
	 *
	 * This function checks if the provided value is one of the allowed values. If not, it defaults to 'single-product-layout-left'.
	 * It then sanitizes the value using the sanitize_text_field function.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string The sanitized value.
	 */
	public function sanitize_single_product_page_layout($value)
	{
		$allowed_values = array( 'single-product-layout-left', 'single-product-layout-right', 'single-product-special1', 'single-product-special2', 'single-product-layout-custom' );
		if ( ! in_array( $value, $allowed_values, true ) ) {
			return 'single-product-layout-left';
		}

		return sanitize_text_field($value);
	}

	/**
	 * Checks if the current single product page layout is either 'single-product-layout-left' or 'single-product-layout-right'.
	 *
	 * @return bool Returns true if the layout is either 'single-product-layout-left' or 'single-product-layout-right', false otherwise.
	 */	
	public function is_layout_left_and_right_active_callback()
	{
		/**
		 * Retrieves the current single product page layout from the theme customizer.
		 * If the theme customizer value is not set, it defaults to the value defined in Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT).
		 *
		 */		
		$single_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT), 
			Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
		);

		/**
		 * Checks if the current single product page layout is either 'single-product-layout-left' or 'single-product-layout-right'.
		 *
		 */		
		if ( 'single-product-layout-left' === $single_layout || 'single-product-layout-right' === $single_layout || 'single-product-layout-custom' === $single_layout ) {
			return true;
		} else {
			return false;
		}
	}	

	/**
	 * Checks if the current single product page layout is 'single-product-layout-custom'.
	 *
	 * This function retrieves the current single product page layout from the theme customizer.
	 * If the theme customizer value is not set, it defaults to the value defined in Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT).
	 * Then, it checks if the current single product page layout is 'single-product-layout-custom'.
	 *
	 * @return bool Returns true if the layout is 'single-product-layout-custom', false otherwise.
	 */
	public function is_layout_custom_active_callback() {
		$single_layout = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT), 
			Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
		);

		if ( 'single-product-layout-custom' === $single_layout ) {
			return true;
		} else {
			return false;
		}
	}	
}
