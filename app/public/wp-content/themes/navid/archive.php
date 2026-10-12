<?php
/**
 * Archive Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>

<div class="archive-header" style="text-align:center; padding: 60px 20px 40px;">
  <div class="container" style="max-width: 800px; margin: 0 auto;">
    <?php if ( is_category() ) : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php single_cat_title(); ?></h1>
      <?php if ( category_description() ) : ?>
        <div class="archive-description"><?php echo wp_kses_post( category_description() ); ?></div>
      <?php endif; ?>
    <?php elseif ( is_tag() ) : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php single_tag_title(); ?></h1>
      <?php if ( tag_description() ) : ?>
        <div class="archive-description"><?php echo wp_kses_post( tag_description() ); ?></div>
      <?php endif; ?>
    <?php elseif ( is_tax() ) : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php single_term_title(); ?></h1>
      <?php if ( term_description() ) : ?>
        <div class="archive-description"><?php echo wp_kses_post( term_description() ); ?></div>
      <?php endif; ?>
    <?php elseif ( is_author() ) : ?>
      <div class="author-archive-card" style="margin-bottom: 30px; text-align: center;">
        <div style="margin-bottom: 16px; display: inline-block; border-radius: 50%; overflow: hidden; border: 3px solid var(--sage-pale, #e0f5ec); box-shadow: 0 4px 15px rgba(0,0,0,0.06);">
          <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 96 ) ); ?>
        </div>
        <h1 class="archive-title" style="margin-bottom: 8px;"><?php the_author(); ?></h1>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
          <div class="archive-description" style="max-width: 650px; margin: 0 auto;"><p><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p></div>
        <?php endif; ?>
      </div>
    <?php elseif ( is_post_type_archive() ) : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php post_type_archive_title(); ?></h1>
    <?php elseif ( is_date() ) : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php the_archive_title(); ?></h1>
    <?php else : ?>
      <h1 class="archive-title" style="margin-bottom: 16px;"><?php the_archive_title(); ?></h1>
    <?php endif; ?>
    

  </div>
</div>

<?php if ( have_posts() ) : ?>
<?php
$sidebar_pos = get_theme_mod( 'navid_archive_sidebar', 'center' );
$has_sidebar = ( 'right' === $sidebar_pos || 'left' === $sidebar_pos );
$layout_class = 'layout-container';
if ( $has_sidebar ) {
    $layout_class .= ' layout-has-sidebar';
    if ( 'left' === $sidebar_pos ) {
        $layout_class .= ' layout-sidebar-left';
    }
}
?>
<?php if ( $has_sidebar ) : ?>
<div class="<?php echo esc_attr( $layout_class ); ?>" style="padding-top: 0;">
  <div class="layout-main">
<?php endif; ?>

    <div class="archive-grid bento-grid <?php if ( ! $has_sidebar ) echo 'container'; ?>" <?php if ( $has_sidebar ) echo 'style="grid-template-columns: repeat(2, 1fr);"'; ?>>
  <?php 
  $count = 0;
  while ( have_posts() ) : the_post(); 
      $count++;
      
      // Only insert inline widgets if 'center' option is selected
      if ( 'center' === $sidebar_pos ) {
          // Insert author widget in the middle column of the first row
          if ( $count === 2 ) :
  ?>
      <!-- Author widget -->
      <div class="widget-author scale-in d2">
        <div class="widget-author-ring">
          <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 200 ) ); ?>
        </div>
        <div>
          <h4><?php the_author(); ?></h4>
          <span class="widget-author-role"><?php esc_html_e( 'Author', 'navid' ); ?></span>
        </div>
        <?php if ( get_the_author_meta( 'description' ) ) : ?>
          <p><?php echo esc_html( wp_trim_words( get_the_author_meta( 'description' ), 20 ) ); ?></p>
        <?php endif; ?>
        <div class="widget-author-socials">
          <?php echo navid_author_socials(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </div>
      </div>
  <?php
          endif;

          // Insert in-feed widget area in the middle column of the second row
          if ( $count === 4 ) :
              if ( is_active_sidebar( 'sidebar-in-feed' ) || is_customize_preview() ) {
                  dynamic_sidebar( 'sidebar-in-feed' );
              } else {
                  // Fallback to Trending widget only if layout is center
  ?>
  <div class="widget-trending scale-in d5">
    <h4><?php esc_html_e( 'Trending Now', 'navid' ); ?></h4>
    <?php
    $trending = get_posts( array( 'posts_per_page' => 4, 'orderby' => 'comment_count', 'order' => 'DESC' ) );
    $tnum = 0;
    foreach ( $trending as $tpost ) :
        $tnum++;
    ?>
    <div class="trending-item">
      <span class="trending-num"><?php echo str_pad( $tnum, 2, '0', STR_PAD_LEFT ); ?></span>
      <div class="trending-info">
        <h5><a href="<?php echo esc_url( get_permalink( $tpost ) ); ?>"><?php echo esc_html( get_the_title( $tpost ) ); ?></a></h5>
        <span><?php echo esc_html( get_the_date( 'M j', $tpost ) ); ?></span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <?php
              }
          endif;

          if ( $count === 6 ) :
              if ( is_active_sidebar( 'sidebar-in-feed-3' ) || is_customize_preview() ) {
                  dynamic_sidebar( 'sidebar-in-feed-3' );
              }
          endif;

          if ( $count === 8 ) :
              if ( is_active_sidebar( 'sidebar-in-feed-4' ) || is_customize_preview() ) {
                  dynamic_sidebar( 'sidebar-in-feed-4' );
              }
          endif;
      } // End sidebar check
  ?>
  <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card anim-up d' . min( $count, 6 ) ); ?>>
    <a href="<?php the_permalink(); ?>">
      <div class="post-card-img-wrap">
        <?php if ( has_post_thumbnail() ) : ?>
          <img class="clip-reveal" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'navid-card' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
        <?php endif; ?>
      </div>
      <div class="post-card-body">
        <?php $term = navid_get_post_term(); ?>
        <?php if ( $term ) : ?>
          <span class="post-card-tag <?php echo esc_attr( navid_get_tag_class( $term ) ); ?>" style="<?php echo esc_attr( navid_get_tag_style( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></span>
        <?php endif; ?>
        <h3 class="post-card-title"><?php the_title(); ?></h3>
        <p class="post-card-snippet"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
        <div class="post-card-meta">
          <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 48 ) ); ?>
          <span><?php the_author(); ?></span>
          <span class="meta-sep"></span>
          <span><?php echo esc_html( get_the_date( 'M j' ) ); ?></span>
        </div>
      </div>
    </a>
  </article>
  <?php do_action( 'navid_after_loop_post', $count ); ?>
  <?php endwhile; ?>
</div>

    <?php navid_pagination(); ?>

<?php if ( $has_sidebar ) : ?>
  </div><!-- .layout-main -->

  <div class="layout-sidebar">
    <?php get_sidebar(); ?>
  </div>
</div><!-- .layout-container -->
<?php endif; ?>

<?php else : ?>
  <div class="error-404" style="min-height:40vh;">
    <h2><?php esc_html_e( 'No posts found.', 'navid' ); ?></h2>
    <p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'navid' ); ?></p>
  </div>
<?php endif; ?>

<?php get_footer(); ?>

