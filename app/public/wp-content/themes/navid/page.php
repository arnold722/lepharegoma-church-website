<?php
/**
 * Page Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>

<main class="container" style="padding-top:clamp(40px,5vw,72px);padding-bottom:clamp(40px,5vw,72px);">
  <?php 
  while ( have_posts() ) : the_post(); 
      $is_woo_page = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );
      $max_width = $is_woo_page ? '1200px' : '720px';
  ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="max-width:var(--content-width, <?php echo esc_attr( $max_width ); ?>);margin:0 auto;">
      <h1 class="single-title"><?php the_title(); ?></h1>
      <div class="single-body">
        <?php
        the_content();
        
        wp_link_pages( array(
            'before' => '<div class="page-links">',
            'after'  => '</div>',
        ));
        ?>
      </div>
      
      <?php
      if ( comments_open() || get_comments_number() ) :
          comments_template();
      endif;
      ?>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>

