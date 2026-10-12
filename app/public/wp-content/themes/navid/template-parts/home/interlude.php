<?php
/**
 * Homepage Section: Interlude Quote
 */

$show_interlude = get_theme_mod( 'navid_quote_show', true );
if ( ! $show_interlude ) {
    return;
}

$bg_color = get_theme_mod( 'navid_quote_bg_color', '' );
$bg_img   = get_theme_mod( 'navid_quote_bg_image', '' );
$style_attr = '';
if ( $bg_color ) {
    $style_attr .= 'background-color: ' . esc_attr( $bg_color ) . '; ';
}
?>
<section class="interlude" style="<?php echo esc_attr( $style_attr ); ?>">
  <div class="interlude-bg">
    <?php
    if ( has_action( 'navid_render_quote_video' ) ) {
        do_action( 'navid_render_quote_video' );
    } elseif ( $bg_img ) {
        echo '<img class="parallax-img" data-parallax="0.08" src="' . esc_url( $bg_img ) . '" alt="" loading="lazy" />';
    }
    ?>
  </div>
  <div class="interlude-content anim-up">
    <p class="interlude-quote"><?php echo esc_html( get_theme_mod( 'navid_quote_text', __( 'The universe is full of magical things patiently waiting for our wits to grow sharper.', 'navid' ) ) ); ?></p>
    <p class="interlude-attr"><?php echo esc_html( get_theme_mod( 'navid_quote_author', __( 'Eden Phillpotts', 'navid' ) ) ); ?></p>
  </div>
</section>
