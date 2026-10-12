<?php
/**
 * Customizer Heading.
 *
 * @since   1.0.0
 * @package Solace\Customizer\Controls
 */

namespace Solace\Customizer\Controls;

/**
 * Only_Label control
 */
class Only_Label extends \WP_Customize_Control {

	/**
	 * The control type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'only-label';

	/**
	 * Send to _js json.
	 *
	 * @return array
	 */
	public function json() {
		$json         = parent::json();
		$json['id']   = $this->id;

		return $json;
	}

	/**
	 * Render control.
	 */
	protected function content_template() {
		?>
		<div class="only-label-toggle-wrap">
			<label>{{data.label}}</label>
		</div>
		<?php
	}
}
