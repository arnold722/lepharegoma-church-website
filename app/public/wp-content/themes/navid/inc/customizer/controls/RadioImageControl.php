<?php
/**
 * Premium Radio Image / Icon Button Control for Navid Lite
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
 * Custom control for icon-based radio buttons.
 */
class Navid_Radio_Image_Control extends \WP_Customize_Control {
    
    public $type = 'navid-radio-image';

    /**
     * Render the control's content in PHP.
     */
    protected function render_content() {
        if ( empty( $this->choices ) ) {
            return;
        }
        
        $name = '_customize-radio-' . $this->id;
        ?>
        <div class="navid-control-wrapper navid-radio-image-control">
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
            </label>
            
            <div class="navid-radio-image-group">
                <?php foreach ( $this->choices as $value => $data ) : ?>
                    <label class="navid-radio-image-label">
                        <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />
                        <span class="navid-radio-image-btn" title="<?php echo esc_attr( $data['name'] ); ?>">
                            <?php echo navid_sanitize_svg( $data['icon'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <span class="navid-radio-image-label-text"><?php echo esc_html( $data['name'] ); ?></span>
                        </span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
