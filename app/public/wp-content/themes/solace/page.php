<?php

/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package solace
 */

get_header();
if (class_exists('WooCommerce') && (is_cart() || is_checkout() || is_account_page())) {
	solace_content_before_woocommerce_pages();
}

?>
<main class="main-page main-page1 main-singular">
	<section class="container-page">
		<div class="myrow row1">
			<div class="content">
				<?php
                if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) :
                else :
                    while ( have_posts() ) : the_post();
						get_template_part('template-parts/content', 'page');
                    endwhile;
                endif;
                ?>
			</div>
		</div>
	</section>
</main><!-- #main -->

<?php
get_footer();
