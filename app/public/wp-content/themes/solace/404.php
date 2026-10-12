<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package solace
 */

get_header();
?>
<main class="main-404">
	<?php
	if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) :

	else :
		?>
		<section class="container-all container-404">
			<div class="myrow row1">
				<h1><?php echo esc_html__( '404', 'solace' ); ?></h1>
			</div>
			<div class="myrow row2">
				<?php get_search_form(); ?>
			</div>
			<div class="myrow row3">
				<p><?php echo esc_html__( 'Sorry page not found!', 'solace' ); ?></p>
			</div>
		</section><!-- .container -->
	<?php
	endif;
	?>
</main><!-- #main -->

<?php
get_footer();

