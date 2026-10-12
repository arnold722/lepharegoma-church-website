<?php
/**
 * Default settings traits, shared with other classes.
 *
 * @package Solace\Customizer\Defaults
 */

namespace Solace\Customizer\Defaults;

/**
 * Trait Layout
 *
 * @package Solace\Customizer\Defaults
 */
trait Layout {
	/**
	 * Get the sidebar layout alignment
	 *
	 * @param string $control_id the control id.
	 *
	 * @return string
	 */
	private function sidebar_layout_alignment_default( $control_id ) {
		if ( solace_is_new_skin() ) {
			$full_width = [
				'solace_blog_archive_sidebar_layout',
				'solace_other_pages_sidebar_layout',
				'solace_single_product_sidebar_layout',
			];
			$full_width = apply_filters( 'solace_sidebar_layout_alignment_defaults', $full_width );
			if ( in_array( $control_id, $full_width, true ) ) {
				return 'full-width';
			}

			return 'right';
		}

		if ( $control_id === 'solace_single_product_sidebar_layout' ) {
			return 'full-width';
		}

		return 'right';
	}

	/**
	 * Get the sidebar layout width.
	 *
	 * @param string $control_id the control id.
	 *
	 * @return int
	 */
	private function sidebar_layout_width_default( $control_id ) {
		if ( solace_is_new_skin() ) {
			$full_width = [
				'solace_blog_archive_content_width',
				'solace_other_pages_content_width',
				'solace_single_product_content_width',
			];
			$full_width = apply_filters( 'solace_sidebar_full_width_defaults', $full_width );
			if ( in_array( $control_id, $full_width, true ) ) {
				return 100;
			}
		}

		// 70 is default on both new & old.
		return 70;
	}

	/**
	 * Get grid colum default.
	 *
	 * @return string
	 */
	private function grid_columns_default() {
		return solace_is_new_skin() ? '{"desktop":3,"tablet":2,"mobile":1}' : '{"desktop":1,"tablet":1,"mobile":1}';
	}

	/**
	 * Check if the shop sidebar is off-canvas.
	 *
	 * @return bool
	 */
	private function shop_sidebar_is_off_canvas() {
		if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
			return false;
		}

		$body_classes = apply_filters( 'body_class', [], [] ); // @see https://developer.wordpress.org/reference/hooks/body_class/
		return is_array( $body_classes ) && in_array( 'solace-off-canvas', $body_classes );
	}

	/**
	 * Get meta default data
	 *
	 * @deprecated 3.4.5 Use solace_get_default_meta_value( $field, $default ) instead.
	 *
	 * @return array
	 */
	public static function get_meta_default_data( $field, $default ) {
		return solace_get_default_meta_value( $field, $default );
	}
}
