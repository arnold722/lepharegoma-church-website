<?php
/**
 * Generic Tweaks
 *
 * @package Solace\Views
 */

namespace Solace\Views;

/**
 * Class Tweaks
 */
class Tweaks extends Base_View {
	/**
	 * Add hooks for the front end.
	 */
	public function init() {
		// Remove gallery default style.
		add_filter( 'use_default_gallery_style', '__return_false' );
	}
}
