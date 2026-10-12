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
 * Class Wc_Product_Pagination
 *
 * This class manages the customization options for the WooCommerce card.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Product_Pagination extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the card options customization.
	 */
	private $section = 'solace_wc_product_page_pagination';

	/**
	 * Adds customizer controls for the card options.
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
	 * Adds the customization section for the sidebar.
	 *
	 * @return void
	 */
	private function section()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'title'    => esc_html__('Pagination', 'solace'),
				)
			)
		);
	}

	/**
	 * Adds the controls for the sidebar customization.
	 *
	 * @return void
	 */
	private function controls()
	{

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION),
					'sanitize_callback' => 'solace_sanitize_checkbox',
				],
				[
					'label'           => esc_html__('Show pagination', 'solace'),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LABEL_PAGINATION_TYPE),
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Pagination Type', 'solace'),
					'section'         => $this->section,
					'active_callback' => array($this, 'show_pagination_active_callback'),
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE),
				[
					'sanitize_callback' => [$this, 'sanitize_product_page_pagination_type'],
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE),
				],
				[
					'section'  => $this->section,
					'choices'  => [
						'pagination-standard' => [
							'name'  => __('Standard', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/pagination-standard.svg',
						],
						'pagination-infinite' => [
							'name'  => __('Infinite Scroll', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/pagination-infinite.svg',
						],
					],
					'active_callback' => array($this, 'show_pagination_active_callback'),
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR),
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR),
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__('Link color', 'solace'),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--wc-shop-pagination-color',
							'selector' => 'body.woocommerce-shop nav.woocommerce-pagination a',
						),
					],
					'active_callback' => array($this, 'pagination_standard_active_callback'),

				],
				'Solace\Customizer\Controls\React\Color'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR_ACTIVE),
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR_ACTIVE),
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__('Active link color', 'solace'),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--wc-shop-pagination-color-active',
							'selector' => 'body.woocommerce-shop nav.woocommerce-pagination span.current',
						),
					],
					'active_callback' => array($this, 'pagination_standard_active_callback'),
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_BG),
				[
					'sanitize_callback' => 'solace_sanitize_colors',
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_BG),
					'transport'         => 'postMessage',
				],
				[
					'label'                 => esc_html__('Background Color', 'solace'),
					'section'               => $this->section,
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => array(
							'vars'     => '--wc-shop-pagination-bg',
							'selector' => 'body.woocommerce-shop nav.woocommerce-pagination span.current',
						),
					],
					'active_callback' => array($this, 'pagination_standard_active_callback'),
				],
				'Solace\Customizer\Controls\React\Color'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_BORDER_RADIUS),
				[
					'sanitize_callback' => 'absint',
					'transport'         => $this->selective_refresh,
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_BORDER_RADIUS),
				],
				[
					'label'                 => esc_html__('Radius', 'solace'),
					'section'               => $this->section,
					'input_attrs'           => [
						'min'        => 0,
						'max'        => 100,
						'step'       => 1,
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--wc-shop-pagination-border-radius',
							'selector' => 'body.woocommerce-shop nav.woocommerce-pagination span.current',
							'suffix'   => 'px',
						],
					],
					'active_callback' => array($this, 'show_pagination_active_callback'),
				],
				'Solace\Customizer\Controls\React\Range'
			)
		);

		$this->add_control(
			new Control(
				'pagination_top_spacing',
				[
					'sanitize_callback' => 'wp_filter_nohtml_kses',
				],
				[
					'label'           => esc_html__('Pagination Top Spacing', 'solace'),
					'section'         => $this->section,
					'active_callback' => array($this, 'show_pagination_active_callback'),
				],
				'Solace\Customizer\Controls\Only_Label'
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_SPACING),
				[
					'sanitize_callback' => 'absint',
					'transport'         => $this->selective_refresh,
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_SPACING),
				],
				[
					'label'                 => esc_html__('', 'solace'),
					'section'               => $this->section,
					'input_attrs'           => [
						'min'        => 0,
						'max'        => 300,
						'step'       => 1,
					],
					'live_refresh_selector' => true,
					'live_refresh_css_prop' => [
						'cssVar' => [
							'vars'     => '--wc-shop-pagination-spacing',
							'selector' => 'body.woocommerce-shop nav.woocommerce-pagination',
							'suffix'   => 'px',
						],
					],
					'active_callback' => array($this, 'show_pagination_active_callback'),
				],
				'Solace\Customizer\Controls\React\Range'
			)
		);
	}

	/**
	 * Sanitizes the product page pagination type.
	 *
	 * This function validates and sanitizes the product page pagination type.
	 * It checks if the provided value is one of the allowed values. If not, it defaults to 'pagination-standard'.
	 *
	 * @param string $value The value to sanitize.
	 *
	 * @return string The sanitized value.
	 */
	public function sanitize_product_page_pagination_type($value)
	{
		$allowed_values = array('pagination-standard', 'pagination-infinite');
		if (!in_array($value, $allowed_values, true)) {
			return 'pagination-standard';
		}

		return sanitize_text_field($value);
	}

	/**
	 * Checks if the product page pagination should be shown.
	 *
	 * This function checks if the product page pagination should be shown based on the theme mod setting.
	 *
	 * @return bool True if the product page pagination should be shown, false otherwise.
	 */
	public function show_pagination_active_callback()
	{
		$show_pagination = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION)
		);

		if ($show_pagination) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Checks if the product page pagination should be shown in the 'pagination-standard' mode.
	 *
	 * This function checks if the product page pagination should be shown in the 'pagination-standard' mode based on the theme mod setting.
	 *
	 * @return bool True if the product page pagination should be shown in the 'pagination-standard' mode, false otherwise.
	 */	
	public function pagination_standard_active_callback()
	{
		$show_pagination = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION)
		);

		$pagination_type = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE),
		);

		if ('pagination-standard' === $pagination_type && $show_pagination ) {
			return true;
		} else {
			return false;
		}
	}	

}
