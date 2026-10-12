<?php
/**
 * Template Name: Elementor Canvas
 *
 * A blank canvas template with no header, footer, or sidebars.
 * Ideal for landing pages built entirely with Elementor.
 *
 * @package formula
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>
<body <?php body_class('elementor-canvas'); ?>>
	<?php wp_body_open(); ?>

	<div id="elementor-content" class="elementor-canvas-content">
		<?php
while (have_posts()):
    the_post();
    the_content();
endwhile;
?>
	</div><!-- #elementor-content -->

	<?php wp_footer(); ?>
</body>
</html>
