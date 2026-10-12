<?php
/**
 * Template used for header rendering.
 *
 * Name:    Header header Grid
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG;

use HFG\Core\Builder\Header as HeaderBuilder;
// Check if custom header is active and display it if it is

// When a Site Builder part is open in the Elementor editor/preview, suppress the
// header entirely so only the part being edited shows on the canvas.
if ( function_exists( 'solace_get_editing_header_or_footer_part_id' ) && solace_get_editing_header_or_footer_part_id() ) {
    return;
}

$custom_header_content = false;

if (function_exists('solace_display_custom_header')) {
    $header_conditions = get_solace_header_conditions();
    if (!empty($header_conditions) ) {
        $custom_header_content = solace_display_custom_header(); // set to true if content displayed
    }
}

if ($custom_header_content==false) {
    $classes = apply_filters('hfg_header_wrapper_class', '');
    ?>
    <div id="header-grid" class="<?php echo esc_attr(get_builder(headerBuilder::BUILDER_NAME)->get_property('panel')) . esc_attr($classes); ?> site-header">
        <?php render_builder(headerBuilder::BUILDER_NAME); ?>
    </div>
    <?php
}