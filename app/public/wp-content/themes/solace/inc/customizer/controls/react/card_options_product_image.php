<?php
/**
 * Card_Options_Product_Image control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class Card_Options_Product_Image
 *
 * @package Solace\Customizer\Controls\React
 */
class Card_Options_Product_Image extends \WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'solace_card_options_product_image_control';
	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array|mixed
	 */
	public $input_attrs = [];

	/**
	 * Additional arguments passed to JS.
	 *
	 * @var array|mixed
	 */
	public $list_images = [];

	/**
	 * Refresh on reset flag.
	 *
	 * @var bool
	 */
	public $refresh_on_reset = false;

	/**
	 * Send to JS.
	 */
	public function json() {
		$json                        = parent::json();
		$json['input_attrs']         = $this->input_attrs;
		$json['list_images']         = $this->list_images;
		$json['refresh_on_reset']    = $this->refresh_on_reset;
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
