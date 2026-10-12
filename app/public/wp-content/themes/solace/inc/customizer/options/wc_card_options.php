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

/**
 * Class Wc_Card_Options
 *
 * This class manages the customization options for the WooCommerce card.
 *
 * @package Solace\Customizer\Options
 */
class Wc_Card_Options extends Base_Customizer
{

	/**
	 * Holds the section name.
	 *
	 * @var string $section The section ID for the card options customization.
	 */
	private $section = 'solace_wc_card_options';

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
	 * Adds the customization section for the card options.
	 *
	 * @return void
	 */
	private function section()
	{
		$this->add_section(
			new Section(
				$this->section,
				array(
					'title'    => esc_html__('Card Options', 'solace'),
				)
			)
		);
	}

	/**
	 * Adds the controls for the card options customization.
	 *
	 * @return void
	 */	
	private function controls()
	{
		$prefix = Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS;
		$order_default_components = array(
			$prefix . '-product-image',
			$prefix . '-title',
			$prefix . '-price',
			$prefix . '-star-rating',
			$prefix . '-categories',
			$prefix . '-excerpt',
			$prefix . '-add-to-cart',
		);

		$components = array(
			$prefix . '-product-image' => __( 'Product Image', 'solace' ),
			$prefix . '-title'         => __( 'Title', 'solace' ),
			$prefix . '-price'         => __( 'Price', 'solace' ),
			$prefix . '-star-rating'   => __( 'Star Rating', 'solace' ),
			$prefix . '-categories'    => __( 'Categories', 'solace' ),
			$prefix . '-excerpt'       => __( 'Excerpt', 'solace' ),
			$prefix . '-add-to-cart'   => __( 'Add to cart', 'solace' ),
		);		

		$this->add_control(
			new Control(
				Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS,
				[
					'sanitize_callback' => [ $this, 'sanitize_ordering_card_options' ],
					'default'           => wp_json_encode( $order_default_components ),
				],
				[
					'label'      => esc_html__( 'Card options', 'solace' ),
					'section'    => $this->section,
					'components' => $components,
				],
				'\Solace\Customizer\Controls\React\New_Ordering'
			)
		);
	}

	/**
	 * Sanitizes the ordering card options.
	 *
	 * This function sanitizes the ordering card options by ensuring that only allowed components are included.
	 * It returns the sanitized array of components or the default allowed components if the input is empty or contains unallowed components.
	 *
	 * @param string $value The input array of components to be sanitized.
	 * @return string The sanitized array of components as a JSON-encoded string.
	 */	
	public function sanitize_ordering_card_options( $value ) {

		$prefix = Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS;

		$elements = array(
			'product-image', 'title', 'price', 'star-rating',
			'categories', 'excerpt', 'add-to-cart',
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
