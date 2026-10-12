<?php
/**
 * Sidebar Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>
<?php
$is_shop = function_exists( 'is_woocommerce' ) && is_woocommerce();
?>

<aside class="sidebar">
  <?php if ( ! $is_shop && get_theme_mod( 'navid_pro_show_default_author', true ) ) : ?>
  <!-- About the Author -->
  <div class="sidebar-widget widget-author">
    <div class="widget-author-ring">
      <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 200 ) ); ?>
    </div>
    <h4><?php the_author(); ?></h4>
    <span class="widget-author-role"><?php esc_html_e( 'Author', 'navid' ); ?></span>
    <?php if ( get_the_author_meta( 'description' ) ) : ?>
        <p><?php echo esc_html( wp_trim_words( get_the_author_meta( 'description' ), 30 ) ); ?></p>
    <?php endif; ?>
    <div class="widget-author-socials">
      <?php echo navid_author_socials(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
  </div>
  <?php endif; ?>

  <?php
  if ( $is_shop && is_active_sidebar( 'sidebar-shop' ) ) {
      dynamic_sidebar( 'sidebar-shop' );
  } elseif ( is_active_sidebar( 'sidebar-1' ) ) {
      dynamic_sidebar( 'sidebar-1' );
  }
  ?>

  <?php if ( ! $is_shop && get_theme_mod( 'navid_pro_show_default_subscribe', true ) ) : ?>
  <!-- Subscribe -->
  <div class="sidebar-widget subscribe-widget">
    <h3 class="widget-title"><?php esc_html_e( 'Stay in the Loop', 'navid' ); ?></h3>
    <p class="subscribe-desc"><?php esc_html_e( 'Weekly stories, tips, and a healthy dose of cuteness. No spam, ever.', 'navid' ); ?></p>
    <form class="subscribe-form" action="<?php echo esc_url( get_theme_mod( 'navid_newsletter_action', '#' ) ); ?>" method="post">
      <input type="email" name="email" placeholder="<?php esc_attr_e( 'Your email address', 'navid' ); ?>" required>
      <button type="submit" class="subscribe-btn"><?php esc_html_e( 'Subscribe', 'navid' ); ?></button>
    </form>
  </div>
  <?php endif; ?>
</aside>

