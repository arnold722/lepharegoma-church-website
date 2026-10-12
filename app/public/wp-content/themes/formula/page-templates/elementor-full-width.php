<?php
/**
 * Template Name: Elementor Full Width
 *
 * A full-width page template without sidebars or theme containers,
 * designed for use with the Elementor page builder.
 * Header and Footer are retained.
 *
 * @package formula
 */

get_header();
?>

	<div id="elementor-content" class="site-content elementor-full-width">
		<?php
while (have_posts()):
    the_post();
    the_content();
endwhile;
?>
	</div><!-- #elementor-content -->

<?php
get_footer();
