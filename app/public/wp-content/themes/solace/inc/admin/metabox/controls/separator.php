<?php
/**
 * Metabox separator.
 *
 * @package Solace\Admin\Metabox\Controls
 */

namespace Solace\Admin\Metabox\Controls;

/**
 * Class Separator
 *
 * @package Solace\Admin\Metabox\Controls
 */
class Separator extends Control_Base {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'separator';

	/**
	 * Render control.
	 *
	 * @return void
	 */
	public function render_content( $post_id ) {
		echo '<hr/>';
	}
}
