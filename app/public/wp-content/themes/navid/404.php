<?php
/**
 * 404 Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>

<main class="error-404" style="max-width: 640px; margin: 0 auto; padding: clamp(60px, 8vw, 100px) 20px;">
  <div class="error-image" style="margin-bottom: 32px; display: inline-block;">
    <div style="width: 200px; height: 200px; border-radius: 50%; padding: 6px; border: 2px dashed var(--sage); margin: 0 auto;">
        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/404-navid.jpg' ); ?>" alt="<?php esc_attr_e( 'Confused dog', 'navid' ); ?>" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;" />
    </div>
  </div>
  
  <h1 style="font-size: clamp(60px, 8vw, 90px); color: var(--sage); margin-bottom: 8px;">404</h1>
  <h2 style="margin-bottom: 16px;"><?php esc_html_e( 'Oops! Did we bury that bone too deep?', 'navid' ); ?></h2>
  <p style="font-size: 16px; color: var(--charcoal-muted); margin-bottom: 32px;">
    <?php esc_html_e( 'The page you\'re looking for seems to have run away. Try searching for it below, or fetch your way back home!', 'navid' ); ?>
  </p>
  
  <div class="error-search widget_search" style="margin-bottom: 40px; max-width: 400px; margin-left: auto; margin-right: auto;">
    <?php get_search_form(); ?>
  </div>

  <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="border-color: var(--sage); color: var(--sage);">
        &larr; <?php esc_html_e( 'Fetch the Homepage', 'navid' ); ?>
      </a>
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" style="border-color: var(--charcoal); color: var(--charcoal);">
        <?php esc_html_e( 'Read the Blog', 'navid' ); ?> &rarr;
      </a>
  </div>
</main>

<?php get_footer(); ?>

