<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package solace
 */

get_header();

$post_header_layout = get_theme_mod('solace_post_header_layout', 'layout 1');
$related_posts      = get_theme_mod( 'solace_show_single_related_posts', true );
$part_single = '';
if ($post_header_layout === 'layout 1') {
	$part_single = 'single1';
} else if ($post_header_layout === 'layout 2') {
	$part_single = 'single2';
} else if ($post_header_layout === 'layout 3') {
	$part_single = 'single3';
} else if ($post_header_layout === 'custom') {
	$part_single = 'single-custom';
} else {
	$part_single = 'single1';
}
?>

<main class="main-single <?php echo 'main-' . esc_html($part_single); ?> main-singular">
	<section class="container-single">
		<div class="myrow row1">
			<div class="mycol">
				<?php
                if ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'single' ) ) :
                else :
                    while ( have_posts() ) : the_post();
                        get_template_part("template-parts/single/$part_single", get_post_type());
                    endwhile;
                endif;
                ?>
				<?php $related_posts = get_theme_mod( 'solace_show_single_related_posts', true ); ?>		
				<?php if ( $related_posts && 'single-custom' !== $part_single ): ?>
					<div class="related-posts">
						<h3><?php echo esc_html__('Related Posts', 'solace'); ?></h3>
						<ul>
							<?php
							$args_post = array(
								'posts_per_page' => 3,
								'post__not_in' => array(get_the_ID()),
								'ignore_sticky_posts' => 1
							);
							$query = new WP_Query($args_post); ?>
							<?php if ($query->have_posts()) : ?>
								<?php while ($query->have_posts()) : $query->the_post(); ?>
									<li>
										<?php solace_the_thumbnail_related_posts('250x277', true); ?>
										<?php 
										if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {
											echo '<div class="content">';
										} else {
											echo '<div class="content no-thumbnail">';
										}
										?>
											<div class="the-categories">
												<?php solace_the_category(); ?>
											</div>
											<h4 class="title">
												<a href="<?php the_permalink(); ?>">
													<?php 
													$title = get_the_title();
													if (strlen($title) > 16) {
														$title = substr($title, 0, 16) . '...';
													}
													echo esc_html($title);
													?>
												</a>
											</h4>
											<div class="date">
												<?php solace_the_time(); ?>
											</div>
										</div>
									</li>
								<?php endwhile; ?>
								<?php wp_reset_postdata(); ?>
							<?php else : ?>
								<p><?php esc_html_e('Post not found!', 'solace'); ?></p>
							<?php endif; ?>
						</ul>
					</div>
				<?php endif; ?>				
			</div>
		</div>
	</section>
</main><!-- #main -->
<?php
get_footer();
