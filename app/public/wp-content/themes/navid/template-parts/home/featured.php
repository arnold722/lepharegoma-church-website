<?php
/**
 * Homepage Section: Featured (Editor's Picks)
 */

$show_featured_grid = get_theme_mod( 'navid_featured_grid_show', true );
if ( ! $show_featured_grid ) {
    return;
}

$featured_post = isset( $args['featured_post'] ) ? $args['featured_post'] : null;

$editors = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 2,
    'meta_key'       => '_editors_pick',
    'meta_value'     => '1',
    'post__not_in'   => $featured_post ? array( $featured_post->ID ) : array(),
));

// Fallback: if no editor picks meta, just get 2 recent posts
if ( ! $editors->have_posts() ) {
    $editors = new WP_Query( array(
        'post_type'      => 'post',
        'posts_per_page' => 2,
        'offset'         => 6,
        'post__not_in'   => $featured_post ? array( $featured_post->ID ) : array(),
    ));
}

if ( ! $editors->have_posts() ) {
    return;
}
?>
<section class="featured-grid-section">
  <div class="container">
    <div class="section-bar anim-up">
      <h2><?php echo esc_html( get_theme_mod( 'navid_featured_grid_title', __( "Editor's Picks", 'navid' ) ) ); ?></h2>
    </div>
  </div>
  <div class="featured-2up">
    <?php while ( $editors->have_posts() ) : $editors->the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card anim-up' ); ?>>
      <a href="<?php the_permalink(); ?>">
        <div class="post-card-img-wrap">
          <?php if ( has_post_thumbnail() ) : ?>
            <img class="clip-reveal" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'navid-featured' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
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
    <?php endwhile; wp_reset_postdata(); ?>
  </div>
</section>
