<?php
/**
 * Homepage Section: Categories
 */

$show_categories = get_theme_mod( 'navid_home_categories_show', true );
if ( ! $show_categories ) {
    return;
}

$categories = get_categories( array(
    'orderby'    => 'count',
    'order'      => 'DESC',
    'number'     => absint( get_theme_mod( 'navid_home_categories_count', 6 ) ),
    'hide_empty' => true,
) );

if ( empty( $categories ) ) {
    return;
}
?>
<div class="category-bar-wrapper">
  <div class="section-bar anim-up">
    <h2 class="category-section-title"><?php echo esc_html( get_theme_mod( 'navid_home_categories_title', __( 'Trending Topics', 'navid' ) ) ); ?></h2>
  </div>
  <div class="category-bar anim-up">
    <?php foreach ( $categories as $category ) : 
        // Fetch the latest post from this category to use its thumbnail as the background
        $cat_posts = get_posts( array(
            'posts_per_page'      => 1,
            'cat'                 => $category->term_id,
            'ignore_sticky_posts' => true,
        ) );
        $bg_url = '';
        if ( $cat_posts && has_post_thumbnail( $cat_posts[0]->ID ) ) {
            $bg_url = get_the_post_thumbnail_url( $cat_posts[0]->ID, 'medium_large' );
        }
        if ( empty( $bg_url ) ) {
            // Fallback to theme default image if no posts have thumbnails
            $bg_url = get_template_directory_uri() . '/assets/images/hero-navid.jpg';
        }
    ?>
        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="category-card">
            <div class="category-card-bg" style="background-image: url('<?php echo esc_url( $bg_url ); ?>');"></div>
            <div class="category-card-overlay"></div>
            <div class="category-card-content">
                <h3 class="category-card-name"><?php echo esc_html( $category->name ); ?></h3>
                <span class="category-card-count"><?php echo esc_html( $category->count ) . ' ' . esc_html__( 'Posts', 'navid' ); ?></span>
            </div>
        </a>
    <?php endforeach; ?>
  </div>
</div>
