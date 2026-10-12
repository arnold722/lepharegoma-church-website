<?php
/**
 * Homepage Section: Hero
 */

$featured_post = isset( $args['featured_post'] ) ? $args['featured_post'] : null;
$hero_source   = get_theme_mod( 'navid_hero_source', 'latest' );

if ( ! get_theme_mod( 'navid_hero_show', true ) ) {
    return;
}

$hero_layout = get_theme_mod( 'navid_hero_layout', 'standard' );
if ( has_action( "navid_render_hero_{$hero_layout}" ) ) {
    do_action( "navid_render_hero_{$hero_layout}" );
} else {

    // Determine Hero variables based on source
    $hero_img = ''; $hero_title = ''; $hero_excerpt = ''; $btn_text = ''; $btn_url = ''; $tag_text = ''; $meta_author = ''; $meta_date = ''; $meta_extra = '';

    if ( 'custom' === $hero_source || ! $featured_post ) {
        $hero_img = get_theme_mod( 'navid_hero_image' );
        if ( empty( $hero_img ) ) {
            $hero_img = get_template_directory_uri() . '/assets/images/hero-navid.jpg';
        }
        $hero_title  = get_theme_mod( 'navid_hero_title', 'The Modern <em>Aesthetic</em>' );
        $hero_excerpt = get_theme_mod( 'navid_hero_excerpt', "Discover the world's most fascinating stories, curated for the modern, curious mind. From thought-provoking features to in-depth cultural commentary, every story is crafted to inspire." );
        $btn_text    = get_theme_mod( 'navid_hero_btn_text', 'Read the Story' );
        $btn_url     = get_theme_mod( 'navid_hero_btn_url', '#' );
        $tag_text    = get_theme_mod( 'navid_hero_custom_tag_text', __( 'FEATURED', 'navid' ) );
        $meta_author = get_bloginfo( 'name' );
        $meta_date   = date_i18n( 'F j, Y' );
        $meta_extra  = __( 'Editorial', 'navid' );
    } else {
        // Post Data
        $hero_img = get_the_post_thumbnail_url( $featured_post, 'navid-hero' );
        if ( empty( $hero_img ) ) {
            $hero_img = get_template_directory_uri() . '/assets/images/hero-navid.jpg';
        }
        $hero_title  = get_the_title( $featured_post );
        $hero_excerpt = wp_trim_words( get_the_excerpt( $featured_post ), 60 );
        $btn_text    = __( 'Read the Story', 'navid' );
        $btn_url     = get_permalink( $featured_post );
        
        $cats = get_the_category( $featured_post->ID );
        $cat_name = ! empty( $cats ) ? $cats[0]->name : 'Featured';
        $tag_text    = $cat_name;
        
        $meta_author = get_the_author_meta( 'display_name', $featured_post->post_author );
        $meta_date   = get_the_date( 'F j, Y', $featured_post );
        $meta_extra  = function_exists( 'navid_reading_time' ) ? navid_reading_time( $featured_post->post_content ) : __( 'Featured', 'navid' );
    }
?>
<section class="hero-section">
  <div class="hero-bg">
    <?php if ( $hero_img ) : ?>
      <img class="hero-bg-img"
           src="<?php echo esc_url( $hero_img ); ?>"
           alt="<?php echo esc_attr( wp_strip_all_tags( $hero_title ) ); ?>" />
    <?php endif; ?>
  </div>
  <?php
  $show_editor_picks = get_theme_mod( 'navid_editor_picks_show', true );
  $picks_count  = get_theme_mod( 'navid_editor_picks_count', 9 );
  $picks_source = get_theme_mod( 'navid_editor_picks_source', 'latest' );
  $picks_cat    = get_theme_mod( 'navid_editor_picks_category', 0 );

  $picks_args = array(
      'posts_per_page'      => $picks_count,
      'ignore_sticky_posts' => true,
  );
  if ( 'category' === $picks_source && ! empty( $picks_cat ) ) {
      $picks_args['cat'] = $picks_cat;
  }
  
  $hero_side = new WP_Query( $picks_args );
  $has_editor_picks = $show_editor_picks && $hero_side->have_posts();
  ?>
  <div class="hero-content hero-grid <?php echo esc_attr( $has_editor_picks ? '' : 'hero-grid-full' ); ?>">
    <div class="hero-main-col">
        <?php if ( get_theme_mod( 'navid_hero_tag_show', true ) && ! empty( $tag_text ) ) : ?>
        <span class="hero-tag">
          <span class="hero-tag-dot"></span>
          <?php echo esc_html( $tag_text ); ?>
        </span>
        <?php endif; ?>
      <h1 class="hero-title"><?php echo wp_kses_post( $hero_title ); ?></h1>
      <p class="hero-excerpt"><?php echo esc_html( $hero_excerpt ); ?></p>
      <div class="hero-bottom">
        <?php if ( $btn_text && $btn_url ) : ?>
        <a href="<?php echo esc_url( $btn_url ); ?>" class="hero-cta">
          <?php echo esc_html( $btn_text ); ?>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="13 6 19 12 13 18"/></svg>
        </a>
        <?php endif; ?>
        <?php if ( get_theme_mod( 'navid_hero_meta_show', true ) ) : ?>
        <span class="hero-meta-inline">
          <span><?php echo esc_html( $meta_author ); ?></span>
          <span class="dot"></span>
          <span><?php echo esc_html( $meta_date ); ?></span>
          <span class="dot"></span>
          <span><?php echo esc_html( $meta_extra ); ?></span>
        </span>
        <?php endif; ?>
      </div>
    </div>

    <?php
    if ( $has_editor_picks ) :
    $hero_side->rewind_posts();
    $ticker_total = $hero_side->post_count;
    ?>
    <div class="hero-sidebar-col">
      <div class="hero-sidebar-inner">
        <div class="hero-sidebar-header">
          <h4 class="hero-sidebar-title"><?php echo esc_html( get_theme_mod( 'navid_editor_picks_title', __( 'Editor\'s Picks', 'navid' ) ) ); ?></h4>
          <div class="hero-ticker-controls">
            <button class="hero-ticker-btn hero-ticker-prev" aria-label="<?php esc_attr_e( 'Previous story', 'navid' ); ?>">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="18 15 12 9 6 15"/></svg>
            </button>
            <button class="hero-ticker-btn hero-ticker-next" aria-label="<?php esc_attr_e( 'Next story', 'navid' ); ?>">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
          </div>
        </div>
        <?php 
        $interval = get_theme_mod( 'navid_editor_picks_autoplay', true ) ? '3500' : '0'; 
        $visible_count = get_theme_mod( 'navid_pro_editor_picks_visible', 3 );
        ?>
        <div class="hero-ticker" data-total="<?php echo esc_attr( $ticker_total ); ?>" data-visible="<?php echo esc_attr( $visible_count ); ?>" data-interval="<?php echo esc_attr( $interval ); ?>">
          <div class="hero-ticker-window">
            <div class="hero-ticker-track">
              <?php
              $slide_idx = 0;
              while ( $hero_side->have_posts() ) : $hero_side->the_post();
                  $side_cat = get_the_category();
                  $side_cat_name = ! empty( $side_cat ) ? $side_cat[0]->name : 'Featured';
                  $side_time = function_exists( 'navid_reading_time' ) ? navid_reading_time( get_the_content() ) : get_the_date('M j');
              ?>
              <a href="<?php the_permalink(); ?>" class="hero-ticker-item<?php echo has_post_thumbnail() ? ' has-thumb' : ''; ?>" data-index="<?php echo esc_attr( $slide_idx ); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="hero-ticker-thumb">
                    <img src="<?php echo esc_url( get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                </div>
                <?php endif; ?>
                <div class="hero-ticker-info">
                  <span class="hero-ticker-cat"><?php echo esc_html( $side_cat_name ); ?></span>
                  <h5 class="hero-ticker-title"><?php echo esc_html( wp_trim_words( get_the_title(), 8 ) ); ?></h5>
                  <span class="hero-ticker-meta"><?php the_author(); ?> &middot; <?php echo esc_html( $side_time ); ?></span>
                </div>
              </a>
              <?php
                      $slide_idx++;
                  endwhile;
                  wp_reset_postdata();
              ?>
            </div>
          </div>
          <div class="hero-ticker-progress">
            <div class="hero-ticker-progress-bar"></div>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php } // End hero layout override check ?>
