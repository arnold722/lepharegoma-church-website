<?php
    $layout_blog = get_theme_mod( 'solace_blog_archive_layout', '1x3' );
    $layout_blog_columns = get_theme_mod( 'solace_blog_layout_custom_columns', 4 );

    switch ( $layout_blog ) {
        case '3x3':
            $layout_class = 'default';
            break;
        case '2x3':
            $layout_class = 'covers';
            break;
        case '1x3':
            $layout_class = 'grid';
            break;
        case 'custom':
            if ($layout_blog_columns === 1) {
                $layout_class = 'grid';
            } else if ($layout_blog_columns === 2) {
                $layout_class = 'covers';
            } else if ($layout_blog_columns === 3) {
                $layout_class = 'default';
            } else if ($layout_blog_columns === 4) {
                $layout_class = '4';
            } else if ($layout_blog_columns === 5) {
                $layout_class = '5';
            }
            
            break;			
        default:
            $layout_class = 'default';
            break;
    }

    solace_blog_page_title_layout();
    ?>

<main class="main-all main-index ricox <?php echo sanitize_html_class( 'main-layout-blog-' . $layout_class ); ?>">
    <section class="container-all container-index">
        <div class="myrow row1">
            <div class="mycol left">
                <?php
                    global $wp_query;
                    
                    if ( $wp_query->have_posts() ) :

                        /* Start the Loop */
                        while ( $wp_query->have_posts() ) :
                            $wp_query->the_post();
                            get_template_part('template-parts/blog', get_post_format());
                        endwhile;

                        wp_reset_postdata();

                        // the_posts_pagination();
                    $pagination_type = get_theme_mod('solace_blog_post_navigation', 'number');

                    switch ($pagination_type) {
                        case 'arrow':
                            the_posts_navigation(array(
                                'prev_text' => '>',
                                'next_text' => '<',
                            ));
                            break;
                        case 'number':
                            the_posts_pagination(array(
                                'mid_size'  => 2,
                                'prev_text' => '<',
                                'next_text' => '>',
                            ));
                            break;
                        case 'infinite':
                            echo '<div class="infinite-scroll">';
                            the_posts_navigation(array(
                                'prev_text' => '<div class="spinner" style="background: url(' . admin_url('images/loading.gif') . ') no-repeat center center;"></div>',
                                'next_text' => '',
                            ));
                            echo '</div>';
                            echo '<script>
                                jQuery(document).ready(function($) {
                                    var isLoading = false;
                                    var container = $(".infinite-scroll");

                                    function loadMorePosts() {
                                        if (isLoading) return;
                                        isLoading = true;

                                        var link = container.find(".nav-links .nav-previous a").attr("href");
                                        if (!link) return;

                                        $.get(link, function(data) {
                                            var posts = $(data).find("article");
                                            $(".mycol").append(posts);

                                            var newNav = $(data).find(".nav-links .nav-previous");
                                            container.find(".nav-links .nav-previous").remove();
                                            
                                            if (newNav.length) {
                                                container.find(".nav-links").append(newNav);
                                            } else {
                                                container.remove();
                                            }

                                            $(".mycol").append(container);

                                            isLoading = false;
                                        });
                                    }

                                    $(window).scroll(function() {
                                        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100 && !isLoading) {
                                            loadMorePosts();
                                        }

                                        if ($(window).scrollTop() + $(window).height() > $(document).height() - 100 && !isLoading) {
                                            container.find(".spinner").addClass("show");
                                        } else {
                                            container.find(".spinner").removeClass("show");
                                        }
                                    });

                                    container.on("click", ".nav-links .nav-previous a", function(e) {
                                        e.preventDefault();
                                        loadMorePosts();
                                    });
                                });
                            </script>';
                            break;
                        default:
                            the_posts_pagination(array(
                                'mid_size'  => 2,
                                'prev_text' => '<',
                                'next_text' => '>',
                            ));
                            break;
                    }
                    else :

                        get_template_part('template-parts/content', 'none');

                    endif;
                ?>
            </div>
            <?php
            $container_layout = get_theme_mod('solace_container_layout', 'custom');
            if ($container_layout === 'left' || $container_layout === 'right') {
                get_sidebar(); 
            }
            ?>
        </div>
    </section><!-- .container -->
</main><!-- #main -->