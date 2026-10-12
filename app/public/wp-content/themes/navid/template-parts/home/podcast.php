<?php
/**
 * Homepage Section: Podcast Banner
 */

$podcast = new WP_Query( array(
    'posts_per_page' => 1,
    'tax_query' => array(
        array(
            'taxonomy' => 'post_format',
            'field'    => 'slug',
            'terms'    => 'post-format-audio',
        ),
    ),
    'ignore_sticky_posts' => true
));

if ( ! $podcast->have_posts() ) {
    return;
}

while ( $podcast->have_posts() ) : $podcast->the_post();
    $pod_time = function_exists( 'navid_reading_time' ) ? str_replace('read', '', navid_reading_time()) : get_the_date();
    $pod_cats = get_the_category();
    $pod_cat_name = ! empty( $pod_cats ) ? $pod_cats[0]->name : __( 'Featured', 'navid' );
?>
<section class="podcast-banner-section anim-up">
  <div class="container">
    <div class="podcast-banner-inner">
      <div class="podcast-banner-content">
        <div class="podcast-banner-label">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path></svg>
          <?php echo esc_html( $pod_cat_name ); ?>
        </div>
        <h3 class="podcast-banner-blogname"><?php echo esc_html( get_the_author() ); ?></h3>
        <h2 class="podcast-banner-title"><?php the_title(); ?></h2>
        <p class="podcast-banner-excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 25 ) ); ?></p>
        
        <div class="podcast-banner-actions">
          <a href="<?php the_permalink(); ?>" class="podcast-cta">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
            <?php esc_html_e( 'Listen Now', 'navid' ); ?>
          </a>
          <span class="podcast-duration"><?php echo esc_html( $pod_time ); ?></span>
        </div>
      </div>
      
      <div class="podcast-banner-visual">
        <div class="podcast-banner-waveform">
          <?php for($i=0; $i<40; $i++) { echo '<div class="banner-wave-bar" style="animation-delay: -'.(rand(0,20)/10).'s; height: '.(rand(20, 100)).'%"></div>'; } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php 
endwhile;
wp_reset_postdata();
