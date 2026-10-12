<?php

/**
 * HeaderSocial2 Control. Handles data passing from args to JS.
 *
 * @package Solace\Customizer\Controls\React
 */

namespace Solace\Customizer\Controls\React;

/**
 * Class HeaderSocial2
 *
 * @package Solace\Customizer\Controls\React
 */
class HeaderSocial2 extends \WP_Customize_Control
{
    /**
     * Control type.
     *
     * @var string
     */
    public $type = 'solace_header_social2_control';

    /**
     * Additional arguments passed to JS.
     * Disables hover controls
     *
     * @var bool
     */
    public $no_hover = false;
    /**
     * Additional arguments passed to JS.
     * Disables shadow controls
     *
     * @var bool
     */
    public $no_shadow = false;
    /**
     * Default values.
     *
     * @var array
     */
    public $default_vals = [];

    /**
     * Send to JS.
     */
    public function json()
    {
        $json                = parent::json();
        $json['no_hover']    = $this->no_hover;
        $json['no_shadow']   = $this->no_shadow;
        $json['defaultVals'] = $this->default_vals;
        return $json;
    }

    /**
     * Enqueue our scripts and styles
     */
    public function enqueue()
    {
        wp_enqueue_style('solace-header-social2-css', get_template_directory_uri() . '/assets-solace/customizer/css/header-social2.css?v=' . time(), array(), '1.0', 'all');
    }

    /**
     * Render the control in the customizer
     */
    final public function render_content()
    {
?>
        <div class="container-toggle-switch-header-social2">
            <input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr($this->value()); ?>" <?php $this->link();
                                                                                                                                                                                                        checked($this->value()); ?>>
            <label class="toggle-switch-label" for="<?php echo esc_attr($this->id); ?>">
                <span class="toggle-switch-inner"></span>
                <span class="toggle-switch-switch"></span>
            </label>
        </div>
        <span class="title-customize"><?php echo esc_html($this->label); ?></span>
<?php
    }
}
