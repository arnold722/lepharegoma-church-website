<?php
/**
 * Top Bar
 *
 * @package Solace\Views
 */

namespace Solace\Views;

/**
 * Class Top_Bar
 */
class Top_Bar extends Base_View {

	/**
	 * Add hooks for the front end.
	 */
	public function init() {
		$this->filter_content();
	}

	/**
	 * Apply filters on the top bar content.
	 */
	private function filter_content() {
		add_filter( 'solace_top_bar_content', 'wptexturize' );
		add_filter( 'solace_top_bar_content', 'convert_smilies' );
		add_filter( 'solace_top_bar_content', 'convert_chars' );
		add_filter( 'solace_top_bar_content', 'wpautop' );
		add_filter( 'solace_top_bar_content', 'shortcode_unautop' );
		add_filter( 'solace_top_bar_content', 'do_shortcode' );
	}
}
