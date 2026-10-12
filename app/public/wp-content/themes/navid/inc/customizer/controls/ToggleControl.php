<?php
/**
 * Premium Toggle Switch Control for Navid Lite
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}

/**
 * Custom control for an iOS-style toggle switch.
 */
class Navid_Toggle_Control extends \WP_Customize_Control {
    
    public $type = 'navid-toggle';

    /**
     * Render the control's content in PHP.
     */
    protected function render_content() {
        ?>
        <div class="navid-control-wrapper navid-toggle-control">
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
                
                <div class="navid-toggle-switch">
                    <input type="checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); ?> <?php checked( $this->value() ); ?> />
                    <span class="navid-slider round"></span>
                </div>
            </label>
        </div>
        <?php
    }
}
