<?php

/**
 * Pro customizer section.
 *
 * @since  1.0.0
 * @access public
 */
class Solace_Header_Render extends WP_Customize_Section
{

	/**
	 * The type of customize section being rendered.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $type = 'solace';

	/**
	 * Custom button text to output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $text_left = '';

	/**
	 * Custom pro button URL.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $text_right = '';

	/**
	 * Add custom parameters to pass to the JS via JSON.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function json()
	{
		$json = parent::json();

		$json['text_left'] = $this->text_left;
		$json['text_right']  = $this->text_right;

		return $json;
	}

	/**
	 * Outputs the Underscore.js template.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	protected function render_template()

	{ ?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section {{ data.id }} control-section control-section-{{ data.type }} cannot-expand">
			<# if ( data.text_left && data.text_right ) { #>
				<span class="left tabs tabs-header-panel" data-position="left" data-toggle="deactive">{{ data.text_left }}</span>
				<span class="right tabs tabs-header-panel active" data-position="right" data-toggle="active">{{ data.text_right }}</span>
				<# } #>
		</li>
<?php }
}
