<?php
/**
 * Customizer partial type enforcing.
 *
 * @package Solace\Customizer\Types
 */

namespace Solace\Customizer\Types;

/**
 * Class Partial
 *
 * @package Solace\Customizer\Types
 */
class Partial {
	/**
	 * ID of control that will be attached to. Also ID of the partial itself.
	 *
	 * @var string the control ID.
	 */
	public $id;

	/**
	 * Args for the partial.
	 *
	 * @var array args passed into partial.
	 */
	public $args = array();

	/**
	 * Constructor.
	 *
	 * @param string $id the control id.
	 * @param array  $args       the partial args.
	 */
	public function __construct( $id, $args ) {
		$this->id   = $id;
		$this->args = $args;
	}
}
