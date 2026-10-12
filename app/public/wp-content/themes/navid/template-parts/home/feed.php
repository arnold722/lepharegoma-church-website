<?php
/**
 * Homepage Section: Feed / Bento Grid
 */

$featured_post = isset( $args['featured_post'] ) ? $args['featured_post'] : null;

$show_feed = get_theme_mod( 'navid_feed_show', true );
if ( ! $show_feed ) {
    return;
}

$latest = new WP_Query( array(
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'post__not_in'   => $featured_post ? array( $featured_post->ID ) : array(),
));

if ( ! $latest->have_posts() ) {
    return;
}
?>
<section class="bento-section">
  <div class="container">
    <div class="section-bar anim-up">
      <h2 class="latest-stories-title"><?php echo esc_html( get_theme_mod( 'navid_latest_stories_title', __( 'Latest Stories', 'navid' ) ) ); ?></h2>
      <a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="section-bar-link">
        <?php esc_html_e( 'View All', 'navid' ); ?>
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="13 6 19 12 13 18"/></svg>
      </a>
    </div>
  </div>

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

  <div class="bento-grid feed-layout-<?php echo esc_attr( get_theme_mod( 'navid_feed_layout', 'bento' ) ); ?>" <?php if ( $has_sidebar ) echo 'style="grid-template-columns: repeat(2, 1fr);"'; ?>>
    <?php
    $count = 0;
    while ( $latest->have_posts() ) : $latest->the_post();
        $count++;

        // Only insert inline widgets if 'center' option is selected
        if ( 'center' === $sidebar_pos ) {
            // Insert author widget in the middle column of the first row
            if ( $count === 2 ) :
                if ( is_active_sidebar( 'sidebar-in-feed-1' ) ) {
                    dynamic_sidebar( 'sidebar-in-feed-1' );
                } else {
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
            <?php echo navid_author_socials(); ?>
          </div>
        </div>
    <?php
                }
            endif;

            // Insert in-feed widget area in the middle column of the second row
            if ( $count === 4 ) :
                if ( is_active_sidebar( 'sidebar-in-feed' ) ) {
                    dynamic_sidebar( 'sidebar-in-feed' );
                }
            endif;

            if ( $count === 6 ) :
                if ( is_active_sidebar( 'sidebar-in-feed-3' ) ) {
                    dynamic_sidebar( 'sidebar-in-feed-3' );
                }
            endif;

            if ( $count === 8 ) :
                if ( is_active_sidebar( 'sidebar-in-feed-4' ) ) {
                    dynamic_sidebar( 'sidebar-in-feed-4' );
                }
            endif;
        } // End sidebar check
    ?>

    <?php 
        $format = get_post_format();
        $card_classes = 'post-card anim-up d' . min( $count, 6 );
        if ( 'video' === $format ) {
            $card_classes .= ' video-card';
        }
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class( $card_classes ); ?>>
      <a href="<?php the_permalink(); ?>">
        <?php if ( 'quote' === $format ) : ?>
          <div class="opinion-card">
            <div class="opinion-quote">"<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20, '' ) ); ?>"</div>
            <div class="opinion-author">
              <div class="opinion-avatar"><?php echo wp_kses_post( get_avatar( get_the_author_meta( 'ID' ), 64 ) ); ?></div>
              <span class="opinion-name"><?php the_author(); ?></span>
            </div>
          </div>
        <?php elseif ( 'audio' === $format ) : ?>
          <div class="podcast-card">
            <div>
              <?php $term = navid_get_post_term(); ?>
              <span class="post-card-tag <?php echo esc_attr( navid_get_tag_class( $term ) ); ?>" style="<?php echo esc_attr( navid_get_tag_style( $term ) ); ?>"><?php echo $term ? esc_html( $term->name ) : esc_html__( 'Podcast', 'navid' ); ?></span>
              <h3 class="post-card-title" style="margin-top:16px;"><?php the_title(); ?></h3>
              <p class="post-card-snippet"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 15 ) ); ?></p>
            </div>
            <div class="podcast-waveform">
              <div class="waveform-bar"></div>
              <div class="waveform-bar"></div>
              <div class="waveform-bar"></div>
              <div class="waveform-bar"></div>
              <div class="waveform-bar"></div>
            </div>
          </div>
        <?php else : ?>
          <div class="post-card-img-wrap">
            <?php if ( has_post_thumbnail() ) : ?>
              <img class="clip-reveal" src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'navid-card' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
            <?php endif; ?>
            <?php if ( 'video' === $format ) : ?>
              <div class="play-btn">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
              </div>
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
        <?php endif; ?>
      </a>
    </article>
    <?php do_action( 'navid_after_loop_post', $count ); ?>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>

<?php if ( $has_sidebar ) : ?>
  </div><!-- .layout-main -->

  <div class="layout-sidebar">
    <?php get_sidebar(); ?>
  </div>
</div><!-- .layout-container -->
<?php endif; ?>

</section>
