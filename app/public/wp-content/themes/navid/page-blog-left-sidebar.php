<?php
/**
 * Template Name: Blog - Left Sidebar
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();

$sidebar_pos = 'left';
$has_sidebar = ( 'right' === $sidebar_pos || 'left' === $sidebar_pos );
$layout_class = 'layout-container';
if ( $has_sidebar ) {
    $layout_class .= ' layout-has-sidebar';
    if ( 'left' === $sidebar_pos ) {
        $layout_class .= ' layout-sidebar-left';
    }
}
?>

<main style="padding-top:clamp(40px,5vw,72px);padding-bottom:clamp(40px,5vw,72px);">
    <header class="archive-header">
      <div class="container" style="text-align:center; margin-bottom: 60px;">
        <h1 class="archive-title"><?php the_title(); ?></h1>
        <?php 
        // Display page content if it exists
        $page_content = get_the_content();
        if ( ! empty( $page_content ) ) : 
        ?>
            <div class="archive-description" style="max-width: 800px; margin: 16px auto 0;">
                <?php echo wp_kses_post( wpautop( $page_content ) ); ?>
            </div>
        <?php endif; ?>
        

      </div>
    </header>

    <?php if ( $has_sidebar ) : ?>
    <div class="<?php echo esc_attr( $layout_class ); ?>" style="padding-top: 0;">
      <div class="layout-main">
    <?php endif; ?>

        <div class="bento-grid <?php if ( ! $has_sidebar ) echo 'container'; ?>" <?php if ( $has_sidebar ) echo 'style="grid-template-columns: repeat(2, 1fr);"'; ?>>
            <?php
            $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : ( ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1 );
            $args = array(
                'post_type'      => 'post',
                'post_status'    => 'publish',
                'paged'          => $paged,
                'posts_per_page' => get_option( 'posts_per_page' ),
            );
            
            $blog_query = new WP_Query( $args );

            if ( $blog_query->have_posts() ) :
                $count = 0;
                while ( $blog_query->have_posts() ) :
                    $blog_query->the_post();
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
                    <?php
                endwhile;
            else :
                echo '<p>' . esc_html__( 'No posts found.', 'navid' ) . '</p>';
            endif;
            ?>
        </div>

        <?php
        // Pagination
        $total_pages = $blog_query->max_num_pages;
        if ( $total_pages > 1 ) {
            $current_page = max( 1, get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : absint( get_query_var( 'page' ) ) );
            echo '<div class="pagination">';
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                'format'    => '?paged=%#%',
                'current'   => $current_page,
                'total'     => $total_pages,
                'prev_text' => '&larr; ' . __( 'Previous', 'navid' ),
                'next_text' => __( 'Next', 'navid' ) . ' &rarr;',
            ) );
            echo '</div>';
        }
        wp_reset_postdata();
        ?>

    <?php if ( $has_sidebar ) : ?>
      </div><!-- .layout-main -->

      <aside class="layout-sidebar">
        <?php get_sidebar(); ?>
      </aside>
    </div><!-- .layout-container -->
    <?php endif; ?>
</main>

<?php get_footer(); ?>
