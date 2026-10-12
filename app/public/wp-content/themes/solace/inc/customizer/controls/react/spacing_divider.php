<?php
/**
 * Spacing_Divider Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Spacing_Divider
 *
 * @package Solace\Customizer\Controls\React
 */
class Spacing_Divider extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_spacing_divider';
	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array
	 */
	public $input_attrs = [];

	/**
	 * Default value.
	 *
	 * @var array
	 */
	public $default = [];

	/**
	 * Send to JS.
	 */
	public function json() {
		$json                = parent::json();
		$json['input_attrs'] = $this->input_attrs;
		$json['default']     = $this->default;
		return $json;
	}

	/**
	 * This method overrides the default render
	 * so that nothing is rendered.
	 * Previously it would try to put an input element where the value was `esc_attr()`
	 * This would trigger notices in PHP
	 * It is not required to have a render as it is being handled by React.
	 */
	final public function render_content() {
		// this is rendered from React
	}
}
