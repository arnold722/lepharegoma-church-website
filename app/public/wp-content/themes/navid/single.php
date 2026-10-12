<?php
/**
 * Single Post Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();

while ( have_posts() ) : the_post();
?>

<!-- Post Hero Image -->
<?php if ( has_post_thumbnail() ) : ?>
<div class="single-post-hero">
  <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'navid-hero' ) ); ?>" alt="<?php the_title_attribute(); ?>" />
</div>
<?php endif; ?>

<?php
$sidebar_pos = get_theme_mod( 'navid_single_sidebar', 'none' );
$has_sidebar = ( 'right' === $sidebar_pos || 'left' === $sidebar_pos );
$layout_class = 'layout-container';
if ( $has_sidebar ) {
    $layout_class .= ' layout-has-sidebar';
    if ( 'left' === $sidebar_pos ) {
        $layout_class .= ' layout-sidebar-left';
    }
}
if ( ! has_post_thumbnail() ) {
    $layout_class .= ' no-hero-image';
}
?>
<div class="<?php echo esc_attr( $layout_class ); ?>">
  <div class="layout-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'single-content' ); ?>>
  <?php $term = navid_get_post_term(); ?>
  <?php if ( $term ) : ?>
    <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="post-card-tag <?php echo esc_attr( navid_get_tag_class( $term ) ); ?>" style="<?php echo esc_attr( navid_get_tag_style( $term ) ); ?>"><?php echo esc_html( $term->name ); ?></a>
  <?php endif; ?>

  <h1 class="single-title"><?php the_title(); ?></h1>

  <div class="single-meta">
    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-avatar-link" aria-label="<?php echo esc_attr( get_the_author() ); ?>">
      <?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 80 ) ); ?>
    </a>
    <div>
      <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-name"><?php the_author(); ?></a>
      <span class="meta-separator"></span>
      <span><?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
      <span class="meta-separator"></span>
      <span><?php echo esc_html( navid_reading_time() ); ?></span>
    </div>
  </div>

  <div class="single-body">
    <?php
    the_content();

    wp_link_pages( array(
        'before' => '<div class="page-links">',
        'after'  => '</div>',
    ));
    ?>
  </div>

  <!-- Post Tags -->
  <?php if ( has_tag() ) : ?>
  <div class="post-tags-wrap">
    <?php the_tags( '<span class="post-tags-label">' . esc_html__( 'Tags:', 'navid' ) . '</span>', ' ', '' ); ?>
  </div>
  <?php endif; ?>

  <!-- Post Navigation -->
  <nav class="post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'navid' ); ?>">
    <?php
    $prev = get_previous_post();
    $next = get_next_post();
    ?>
    <?php if ( $prev ) : ?>
      <a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="post-nav-prev">
        <span class="post-nav-label">&larr; <?php esc_html_e( 'Previous', 'navid' ); ?></span>
        <span class="post-nav-title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
      </a>
    <?php endif; ?>
    <?php if ( $next ) : ?>
      <a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="post-nav-next">
        <span class="post-nav-label"><?php esc_html_e( 'Next', 'navid' ); ?> &rarr;</span>
        <span class="post-nav-title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
      </a>
    <?php endif; ?>
  </nav>
</article>

<!-- Comments -->
<?php if ( comments_open() || get_comments_number() ) : ?>
<div class="comments-section">
  <?php comments_template(); ?>
</div>
<?php endif; ?>

  </div><!-- .layout-main -->

  <?php if ( 'none' !== $sidebar_pos ) : ?>
  <div class="layout-sidebar">
    <?php get_sidebar(); ?>
  </div>
  <?php endif; ?>
</div><!-- .layout-container -->

<?php endwhile; ?>

<?php get_footer(); ?>

