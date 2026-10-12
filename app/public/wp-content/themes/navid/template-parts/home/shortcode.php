<?php
/**
 * Homepage Section: Custom Shortcode / Ad Block
 *
 * @package Navid
 */

$shortcode    = get_theme_mod( 'navid_homepage_shortcode', '' );
$full_width   = get_theme_mod( 'navid_homepage_shortcode_fullwidth', false );
$show_section = get_theme_mod( 'navid_homepage_shortcode_show', true );

// If the section is toggled off or no shortcode is entered, do not output anything.
if ( ! $show_section || empty( trim( $shortcode ) ) ) {
    return;
}
?>

<section class="navid-section navid-shortcode-section">
    <?php if ( ! $full_width ) : ?>
        <div class="container">
    <?php endif; ?>

    <div class="navid-shortcode-wrapper" style="text-align: center; width: 100%;">
        <?php echo do_shortcode( wp_kses_post( $shortcode ) ); ?>
    </div>

    <?php if ( ! $full_width ) : ?>
        </div>
    <?php endif; ?>
</section>
