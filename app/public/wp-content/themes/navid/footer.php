<?php
/**
 * Footer Template
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

</div><!-- #site-content -->

<!-- ═══ PRO FOOTER HOOK ═══════════════════════════ -->
<?php do_action( 'navid_before_footer' ); ?>

<!-- ═══ FOOTER ════════════════════════════════════ -->
<footer class="site-footer">
<?php
$footer_width = get_theme_mod( 'navid_footer_width', 'contained' );
$footer_width_class = ( 'full' === $footer_width ) ? 'container-fluid' : 'container';
?>
  <div class="<?php echo esc_attr( $footer_width_class ); ?>">
    <?php if ( is_active_sidebar( 'footer-1' ) && get_theme_mod( 'navid_footer_layout', 'standard' ) !== 'mega' ) :
      $footer_cols = get_theme_mod( 'navid_footer_columns', '4' );
    ?>
    <div class="footer-widgets-area footer-cols-<?php echo esc_attr( $footer_cols ); ?>">
      <?php dynamic_sidebar( 'footer-1' ); ?>
    </div>
    <?php endif; ?>
    <?php $show_footer_logo = get_theme_mod( 'navid_footer_show_logo', true ); ?>
    <div class="footer-inner<?php if ( ! $show_footer_logo ) echo ' no-footer-logo'; ?>">
      <?php if ( $show_footer_logo ) : ?>
        <span class="footer-logo">
          <?php bloginfo( 'name' ); ?>
        </span>
      <?php endif; ?>
      <?php
      $custom_copyright = get_theme_mod( 'navid_footer_copyright', '' );
      if ( ! empty( $custom_copyright ) ) :
      ?>
        <span class="footer-copy"><?php echo wp_kses_post( $custom_copyright ); ?></span>
      <?php else : ?>
        <span class="footer-copy">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'navid' ); ?></span>
      <?php endif; ?>
      <?php
      wp_nav_menu( array(
          'theme_location' => 'footer',
          'container'      => false,
          'menu_class'     => 'footer-links',
          'fallback_cb'    => false,
          'depth'          => 1,
      ));
      ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

