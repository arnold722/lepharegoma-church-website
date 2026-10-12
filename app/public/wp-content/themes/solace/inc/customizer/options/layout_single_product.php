<?php
/**
 * Single post layout section.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Section;

/**
 * Class Layout_Single_Product
 *
 * @package Solace\Customizer\Options
 */
class Layout_Single_Product extends Base_Customizer {

	/**
	 * Add customizer controls.
	 */
	public function add_controls() {
		if ( ! $this->should_load() ) {
			return;
		}

		$this->section_single_product();
		$this->exclusive_products_controls();
	}

	/**
	 * Check if the controls for Single Product should load.
	 */
	private function should_load() {
		return class_exists( 'WooCommerce', false );
	}

	/**
	 * Add single product layout section.
	 */
	private function section_single_product() {
		$this->add_section(
			new Section(
				'solace_single_product_layout',
				array(
					'priority' => 65,
					'title'    => esc_html__( 'Single Product', 'solace' ),
					'panel'    => 'woocommerce',
				)
			)
		);
	}

	/**
	 * Add customizer controls for exclusive products section.
	 */
	private function exclusive_products_controls() {
		$this->add_control(
			new Control(
				'solace_exclusive_products_heading',
				array(
					'sanitize_callback' => 'sanitize_text_field',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'            => esc_html__( 'Exclusive Products', 'solace' ),
					'section'          => 'solace_single_product_layout',
					'priority'         => 200,
					'class'            => 'exclusive-products-accordion',
					'accordion'        => true,
					'controls_to_wrap' => 2,
					'expanded'         => true,
				),
				'Solace\Customizer\Controls\Heading'
			)
		);

		$this->add_control(
			new Control(
				'solace_exclusive_products_title',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'priority' => 210,
					'section'  => 'solace_single_product_layout',
					'label'    => esc_html__( 'Title', 'solace' ),
					'type'     => 'text',
				)
			)
		);

		$product_cat = $this->get_shop_categories();
		$this->add_control(
			new Control(
				'solace_exclusive_products_category',
				array(
					'default'           => '-',
					'sanitize_callback' => array( $this, 'sanitize_categories' ),
				),
				array(
					'label'    => esc_html__( 'Category', 'solace' ),
					'section'  => 'solace_single_product_layout',
					'priority' => 220,
					'type'     => 'select',
					'choices'  => $product_cat,
				)
			)
		);
	}

	/**
	 * Get shop categories.
	 *
	 * @return array
	 */
	private function get_shop_categories() {
		$categories         = array(
			'-'   => esc_html__( 'None', 'solace' ),
			'all' => esc_html__( 'All', 'solace' ),
		);
		$product_categories = get_categories(
			array(
				'taxonomy'   => 'product_cat',
				'hide_empty' => 0,
				'title_li'   => '',
			)
		);
		if ( empty( $product_categories ) ) {
			return $categories;
		}

		foreach ( $product_categories as $category ) {
			$term_id  = $category->term_id;
			$cat_name = $category->name;
			if ( empty( $term_id ) || empty( $cat_name ) ) {
				continue;
			}

			$categories[ $term_id ] = $cat_name;
		}

		return $categories;
	}

	/**
	 * Sanitize categories value.
	 *
	 * @param string $value Value from the control.
	 *
	 * @return string
	 */
	public function sanitize_categories( $value ) {
		$categories = $this->get_shop_categories();
		if ( ! array_key_exists( $value, $categories ) ) {
			return '-';
		}

		return $value;
	}


}
