<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package solace
 */

if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
	return;
}

?>

<aside id="secondary" class="widget-area">
	<?php dynamic_sidebar( 'blog-sidebar' ); ?>
</aside><!-- #secondary -->
