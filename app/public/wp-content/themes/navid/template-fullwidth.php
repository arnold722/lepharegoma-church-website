<?php
/**
 * Template Name: Full Width Template
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
  ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="max-width:var(--max-width);margin:0 auto;">
      <h1 class="single-title" style="max-width:720px;margin-left:auto;margin-right:auto;text-align:center;"><?php the_title(); ?></h1>
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
      if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) :
          echo '<div style="max-width:720px;margin:0 auto;">';
          comments_template();
          echo '</div>';
      endif;
      ?>
    </article>
  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
