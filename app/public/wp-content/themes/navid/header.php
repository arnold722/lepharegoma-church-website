<?php
/**
 * Header Template
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>

<?php
$body_classes = array();
$sticky_header = get_theme_mod( 'navid_sticky_header', true );
if ( $sticky_header ) {
    $body_classes[] = 'has-sticky-header';
}
$header_style = get_theme_mod( 'navid_header_style', 'transparent' );
$ad_header_enabled = get_theme_mod( 'navid_ad_header_enable', false );
if ( 'transparent' === $header_style && ( is_front_page() || is_home() ) && ! $ad_header_enabled ) {
    $body_classes[] = 'has-transparent-header';
}
if ( get_theme_mod( 'navid_topbar_show', true ) ) {
    $body_classes[] = 'has-topbar';
}
$header_layout = get_theme_mod( 'navid_header_layout', 'standard' );
if ( 'standard' !== $header_layout ) {
    $body_classes[] = 'header-layout-' . $header_layout;
}

$default_mode = get_theme_mod( 'navid_default_mode', 'light' );
if ( 'dark' === $default_mode ) {
    $body_classes[] = 'dark-mode';
}
?>
<body <?php body_class( $body_classes ); ?> data-default-mode="<?php echo esc_attr( $default_mode ); ?>">
<?php wp_body_open(); ?>

<?php if ( get_theme_mod( 'navid_enable_preloader', false ) ) : ?>
  <div class="navid-preloader" id="navidPreloader">
    <div class="navid-preloader-spinner"></div>
  </div>
<?php endif; ?>

<a class="skip-link screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'navid' ); ?></a>

<!-- Scroll Progress -->
<?php if ( get_theme_mod( 'navid_show_scroll_progress', true ) ) : ?>
<div class="scroll-progress" id="scrollProgress"></div>
<?php endif; ?>

<?php if ( get_theme_mod( 'navid_topbar_show', true ) ) : ?>
<!-- ═══ TOP BAR ════════════════════════════════════ -->
<div class="top-bar">
  <div class="top-bar-inner">
    <?php if ( get_theme_mod( 'navid_topbar_show_date', true ) ) : ?>
      <span class="top-bar-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ) ) ); ?></span>
    <?php endif; ?>
    <span class="top-bar-tagline"><?php
      $topbar_text = get_theme_mod( 'navid_topbar_text', 'Stories worth reading. Perspectives worth sharing.' );
      echo esc_html( $topbar_text ? $topbar_text : get_bloginfo( 'description' ) );
    ?></span>
    <div class="top-bar-social">
      <?php if ( $tw = get_theme_mod( 'navid_topbar_twitter', 'https://twitter.com/wpmatcha' ) ) : ?>
        <a href="<?php echo esc_attr( $tw ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Twitter', 'navid' ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
      <?php endif; ?>
      <?php
      $ig = get_theme_mod( 'navid_topbar_instagram', '' );
      if ( $ig ) : ?>
        <a href="<?php echo esc_attr( $ig ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Instagram', 'navid' ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/></svg>
        </a>
      <?php endif; ?>
      <?php
      $fb = get_theme_mod( 'navid_topbar_facebook', '' );
      if ( $fb ) : ?>
        <a href="<?php echo esc_attr( $fb ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Facebook', 'navid' ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
        </a>
      <?php endif; ?>
      <?php
      $yt = get_theme_mod( 'navid_topbar_youtube', '' );
      if ( $yt ) : ?>
        <a href="<?php echo esc_attr( $yt ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'YouTube', 'navid' ); ?>">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- ═══ HEADER ════════════════════════════════════ -->
<?php
$header_width = get_theme_mod( 'navid_header_width', 'full' );
$header_width_class = ( 'contained' === $header_width ) ? 'container' : 'container-fluid';
?>
<header class="site-header" id="siteHeader">
  <div class="header-inner <?php echo esc_attr( $header_width_class ); ?>">
    <div class="logo-wrapper">
      <?php if ( has_custom_logo() ) : ?>
        <?php 
        // the_custom_logo() outputs an <a> tag itself. We add the .logo class to it if possible, 
        // or just let it render. The theme's CSS targets .logo, so let's wrap it in .logo div
        // actually, theme.css targets .site-header .logo.
        ?>
        <div class="logo">
          <?php the_custom_logo(); ?>
        </div>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
          <?php bloginfo( 'name' ); ?>
        </a>
      <?php endif; ?>
    </div>

    <nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary Navigation', 'navid' ); ?>">
      <?php
      wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'nav-menu',
          'fallback_cb'    => false,
          'depth'          => 3,
      ));
      ?>
      <div class="drawer-footer">
          <div class="drawer-socials">
              <?php 
              $social_ig = get_theme_mod( 'navid_contact_social_ig', '#' );
              $social_tw = get_theme_mod( 'navid_contact_social_tw', '#' );
              $social_pi = get_theme_mod( 'navid_contact_social_pi', '#' );
              if ( ! empty( $social_ig ) || ! empty( $social_tw ) || ! empty( $social_pi ) ) {
                  if ( ! empty( $social_ig ) ) {
                      echo '<a href="' . esc_url( $social_ig ) . '" aria-label="Instagram"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5"/></svg></a>';
                  }
                  if ( ! empty( $social_tw ) ) {
                      echo '<a href="' . esc_url( $social_tw ) . '" aria-label="Twitter"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 4s-1.2 1-2.5 1.5A4.5 4.5 0 0 0 12 8v1A10.5 10.5 0 0 1 3 4s-4 9 5 13a11.5 11.5 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.1-.9A7.4 7.4 0 0 0 22 4z"/></svg></a>';
                  }
                  if ( ! empty( $social_pi ) ) {
                      echo '<a href="' . esc_url( $social_pi ) . '" aria-label="Pinterest"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="22" x2="12" y2="11"/><path d="M12 2A10 10 0 1 0 22 12a10 10 0 0 0-10-10"/><path d="M12 11a4 4 0 1 0-4-4"/></svg></a>';
                  }
              } else {
                  echo navid_author_socials();
              }
              ?>
          </div>
      </div>
    </nav>

    <?php if ( get_theme_mod( 'navid_header_show_search', true ) ) : ?>
    <button class="icon-btn js-search-toggle" aria-label="<?php esc_attr_e( 'Search', 'navid' ); ?>" aria-expanded="false" aria-controls="searchOverlay">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="10.5" cy="10.5" r="6.5"/><line x1="15.5" y1="15.5" x2="21" y2="21"/></svg>
    </button>
    <?php endif; ?>

    <div class="header-actions">
      <?php if ( get_theme_mod( 'navid_header_show_dark_mode', true ) ) : ?>
      <button class="icon-btn js-dark-mode-toggle" aria-label="<?php esc_attr_e( 'Toggle Dark Mode', 'navid' ); ?>">
        <svg class="sun-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" style="display:none;"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
        <svg class="moon-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <?php endif; ?>
      <?php if ( class_exists( 'WooCommerce' ) ) : ?>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="icon-btn matcha-cart-toggle header-cart-icon" aria-label="<?php esc_attr_e( 'View Cart', 'navid' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
          <span class="matcha-cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
        </a>
      <?php endif; ?>
        <?php 
        $subscribe_url = get_theme_mod( 'navid_header_subscribe_url', '#' );
        if ( ! empty( $subscribe_url ) ) : 
          $subscribe_text = get_theme_mod( 'navid_header_subscribe_text', __( 'Subscribe', 'navid' ) );
          $subscribe_target = get_theme_mod( 'navid_header_subscribe_target', true );
          $target_attr = $subscribe_target ? ' target="_blank" rel="noopener noreferrer"' : '';
        ?>
        <a href="<?php echo esc_url( $subscribe_url ); ?>" class="header-subscribe-btn"<?php echo $target_attr; ?>><?php echo esc_html( $subscribe_text ); ?></a>
        <?php endif; ?>
      <button class="icon-btn hamburger" aria-label="<?php esc_attr_e( 'Menu', 'navid' ); ?>">
        <svg class="hamburger-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="6" y1="12" x2="21" y2="12"/><line x1="9" y1="18" x2="21" y2="18"/></svg>
        <svg class="close-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
  </div>
</header>


<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'navid' ); ?>">
  <div class="search-overlay-inner">
    <?php get_search_form(); ?>
    <button class="search-close-btn js-search-close" aria-label="<?php esc_attr_e( 'Close search', 'navid' ); ?>">&times;</button>
  </div>
</div>

<div id="site-content" tabindex="-1">
<?php do_action( 'navid_after_header' ); ?>
