<?php
/**
 * A section control for documentation.
 *
 * Author:      
 * Created on:  22-12-{2021}
 *
 * @package Solace/solace-pro
 */
namespace Solace\Customizer\Controls\React;

/**
 * Customizer section.
 *
 * @package    WordPress
 * @subpackage Customize
 * @since      4.1.0
 * @see        WP_Customize_Section
 */
class Documentation_Section extends \WP_Customize_Section {
	/**
	 * Type of this section.
	 *
	 * @var string
	 */
	public $type = 'solace_documentation';

	/**
	 * Documentation URL.
	 *
	 * @var string
	 */
	public $url = '';

	/**
	 * Gather the parameters passed to client JavaScript via JSON.
	 *
	 * @return array The array to be exported to the client as JSON.
	 * @since 4.1.0
	 */
	public function json() {
		$json        = parent::json();
		$json['url'] = $this->url;
		return $json;
	}

	/**
	 * Render template.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}"
			data-slug="{{data.id}}"
			class="control-section control-section-{{ data.type }} solace-documentation">
		</li>
		<?php
	}
}
