<?php
/**
 * Customizer checkout controls.
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Section;
use Solace\Customizer\Types\Control;

/**
 * Class Checkout
 *
 * @package Solace\Customizer\Options
 */
class Checkout extends Base_Customizer {

	/**
	 * Init function
	 *
	 * @return bool|void
	 */
	public function init() {
		if ( defined( 'SOLACE_PRO_VERSION' ) ) {
			return false;
		}

		parent::init();
	}

	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->group_controls();
		// $this->change_controls();

	}

	/**
	 * Change the controls added from WooCommerce.
	 */
	public function change_controls() {

		$changes = [
			'woocommerce_checkout_company_field'       => [ 
				'priority' => 25,
				'default' => 'optional',
			],
			'woocommerce_checkout_address_2_field'     => [ 'priority' => 120 ],
			'woocommerce_checkout_phone_field'         => [ 
				'priority' => 130 ,
				'default' => 'optional',
			],
			'woocommerce_checkout_highlight_required_fields' => [
				'priority' => 140,
				'type'     => 'solace_toggle_control',
			],
			'wp_page_for_privacy_policy'               => [ 'priority' => 190 ],
			'woocommerce_terms_page_id'                => [ 'priority' => 200 ],
			'woocommerce_checkout_privacy_policy_text' => [ 'priority' => 210 ],
			'woocommerce_checkout_terms_and_conditions_checkbox_text' => [ 'priority' => 220 ],

		];

		foreach ( $changes as $control_slug => $props ) {
			foreach ( $props as $prop => $new_value ) {
				$this->change_customizer_object( 'control', $control_slug, $prop, $new_value );
			}
		}
	}

	/**
	 * Add control groups to better organize the customizer.
	 */
	private function group_controls() {
		$checkout_section = $this->wpc->get_section( 'woocommerce_checkout' );
		
		if ( null !== $checkout_section ) {
			$this->wpc->add_section( $checkout_section );
		}

		$this->add_control(
			new Control(
				'solace_checkout_settings_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'            => esc_html__( 'Checkout Style', 'solace' ),
					'section'          => 'woocommerce_checkout',
					'priority'         => 0,
					'class'            => 'solace-checkout-accordion',
					'accordion'        => true,
					'controls_to_wrap' => 1,
					'expanded'         => true,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				'solace_woo_checkout_settings_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'            => esc_html__( 'General', 'solace' ),
					'section'          => 'woocommerce_checkout',
					'priority'         => 100,
					'class'            => 'woo-checkout-accordion',
					'accordion'        => true,
					'controls_to_wrap' => 7,
					'expanded'         => true,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);
	}
}
