<?php
/**
 * Template used for footer rendering.
 *
 * Name:    Hooter Footer Grid
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG;

use HFG\Core\Builder\Footer as FooterBuilder;
// Check if custom footer is active and display it if it is

// When a Site Builder part is open in the Elementor editor/preview, suppress the
// footer entirely so only the part being edited shows on the canvas.
if ( function_exists( 'solace_get_editing_header_or_footer_part_id' ) && solace_get_editing_header_or_footer_part_id() ) {
    return;
}

$custom_footer_content = false;

if (function_exists('solace_display_custom_footer')) {
    $footer_conditions = get_solace_footer_conditions();
    if (!empty($footer_conditions) ) {
        $custom_footer_content = solace_display_custom_footer(); // set to true if content displayed
    }
}

if ($custom_footer_content==false) {
    $classes = apply_filters('hfg_footer_wrapper_class', '');
    ?>
        <footer class="<?php echo esc_attr( apply_filters( 'solace_footer_wrap_classes', 'site-footer' ) ); ?>" id="site-footer" <?php echo ( solace_is_amp() ) ? 'next-page-hide' : ''; ?> >
            <div id="footer-grid" class="<?php echo esc_attr(get_builder(FooterBuilder::BUILDER_NAME)->get_property('panel')) . esc_attr($classes); ?>">
                <?php render_builder(FooterBuilder::BUILDER_NAME); ?>
            </div>
        </footer>
    <?php
}