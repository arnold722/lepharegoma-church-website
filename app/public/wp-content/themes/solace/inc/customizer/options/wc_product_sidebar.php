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
 * Class Wc_Product_Sidebar
 *
 * This class manages the customization options for the WooCommerce card.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Product_Sidebar extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the card options customization.
	 */
	private $section = 'solace_wc_product_page_sidebar';

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
					'title'    => esc_html__('Sidebar', 'solace'),
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
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR),
					'transport' 	    => 'refresh',
					'sanitize_callback' => 'solace_sanitize_checkbox',
				],
				[
					'label'           => esc_html__('Show sidebar', 'solace'),
					'section'         => $this->section,
					'type'            => 'solace_toggle_control_flex',
				],
			)
		);

		$this->add_control(
			new Control(
				Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT),
				[
					'default'           => Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT),
					'transport' 	    => 'refresh',
					'sanitize_callback' => [$this, 'sanitize_product_page_sidebar_layout'],
				],
				[
					'section'  => $this->section,
					'choices'  => [
						'product-page-sidebar-left' => [
							'name'  => __('Sidebar left', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/sidebar1.svg',
						],
						'product-page-sidebar-right'  => [
							'name'  => __('Sidebar right', 'solace'),
							'image' => SOLACE_ASSETS_URL . 'img/customizer/woocommerce/product-pages/sidebar2.svg',
						],
					],
					'active_callback' => array($this, 'sidebar_layout_active_callback'),
				],
				'\Solace\Customizer\Controls\React\Radio_Image'
			)
		);
	}

	/**
	 * Checks if the sidebar layout option is active.
	 *
	 * This function checks if the "Show sidebar" option is enabled before allowing the user to select a sidebar layout.
	 *
	 * @return bool|int Returns true if the sidebar is enabled and the layout option is valid, otherwise returns false.
	 */	
	public function sidebar_layout_active_callback()
	{
		$get_show_sidebar = get_theme_mod(
			Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR),
			Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR),
		);

		if ( $get_show_sidebar ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	* Sanitizes the product page sidebar layout option.
	*
	* This function checks if the sidebar is enabled before sanitizing the layout option.
	*
	* @return bool|int Returns true if the sidebar is enabled and the layout option is valid, otherwise returns false.
	*/	
	public function sanitize_product_page_sidebar_layout($value)
	{
		$allowed_values = array('product-page-sidebar-left', 'product-page-sidebar-right');
		if (!in_array($value, $allowed_values, true)) {
			return 'product-page-sidebar-left';
		}
	
		return sanitize_text_field($value);
	}	

}
