<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package solace
 */
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
    // Container
    $container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

    // Single
    $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
    $single_templates = get_theme_mod( 'solace_post_header_layout', 'layout 1' );
	$metabox_sidebar_layout = get_post_meta(get_the_ID(), 'sol_layout_singular', 'inherit');
	if (empty($metabox_sidebar_layout)) {
		$metabox_sidebar_layout = 'inherit';
	}

    // Sidebar
    $is_active_sidebar = false;

    // Single Inherit
    if ( $single_list_layout === 'inherit' && !empty( $single_templates ) && $metabox_sidebar_layout === 'inherit' ) {
		if ( $container_list_layout === 'left' || $container_list_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Single Single_templates
	if ( $single_list_layout !== 'inherit' && !empty( $single_templates ) && $metabox_sidebar_layout === 'inherit' ) {
		if ( $single_list_layout === 'left' || $single_list_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Single metabox_templates
	if ( !empty( $single_templates ) && $metabox_sidebar_layout !== 'inherit' ) {
		if ( $metabox_sidebar_layout === 'left' || $metabox_sidebar_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Check Widget
	if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
		$is_active_sidebar = false;
	}	

	$solace_post_layout = get_theme_mod('solace_post_layout','inherit');
	$sol_container_hide_title = get_theme_mod('solace_container_hide_title',false );
	$solace_post_layout_hide_title = get_theme_mod('solace_post_layout_hide_title',false );
	if ( ( $sol_container_hide_title==false && $solace_post_layout_hide_title==false ) ||
		 ( $sol_container_hide_title==true && $solace_post_layout_hide_title==false ) ){
			$show_boxes_header = true;
	}
	if ( $solace_post_layout=='inherit' && $sol_container_hide_title==true ){
		$show_boxes_header = false;
	}

	global $post_id;
	$post_id = get_the_ID();
	$single_hide_title = get_post_meta($post_id, 'single-hide-title', true);

	?>

	<section class="boxes-ordering">
		<?php 
		$prefix = 'solace_single_post_element';
		$order_default_components = array(
			$prefix . '-featured-image',
			$prefix . '-categories',
			$prefix . '-title',
			$prefix . '-post-meta',
			$prefix . '-content',
			$prefix . '-tags',
			$prefix . '-divider',
		);	
		
		$single_post_element = get_theme_mod( 'solace_single_post_element', wp_json_encode( $order_default_components ) );

		$single_post_element = json_decode($single_post_element, true);

		foreach ($single_post_element as $item) :
			if ( $prefix . '-featured-image' === $item ) {				
				solace_featured_image();
			} else if ( $prefix . '-categories' === $item ) {
				?>
				<div class="the-categories">
					<?php solace_the_category(true); ?>
				</div>
				<?php
			} else if ( $prefix . '-title' === $item ) {
				?>
				<div class="box-title">
					<?php 
					$defaults_heading_tag = Mods::get_alternative_mod_default( Config::MODS_BLOG_POST_DESIGN_TITLE );
					$heading_tag = get_theme_mod( 'solace_single_post_design_title_typeface', $defaults_heading_tag );

					if ( 'H1' === $heading_tag['headingTag'] ) {
						?>
						<h1><?php the_title(); ?></h1>
						<?php
					} else if ( 'H2' === $heading_tag['headingTag'] ) {
						?>
						<h2><?php the_title(); ?></h2>
						<?php
					} else if ( 'H3' === $heading_tag['headingTag'] ) {
						?>
						<h3><?php the_title(); ?></h3>
						<?php
					} else if ( 'H4' === $heading_tag['headingTag'] ) {
						?>
						<h4><?php the_title(); ?></h4>
						<?php
					} else if ( 'H5' === $heading_tag['headingTag'] ) {
						?>
						<h5><?php the_title(); ?></h5>
						<?php
					} else if ( 'H6' === $heading_tag['headingTag'] ) {
						?>
						<h6><?php the_title(); ?></h6>
						<?php
					} else {
						?>
						<h1><?php the_title(); ?></h1>
						<?php	
					}
					?>
				</div>							
				<?php
			} else if ( $prefix . '-post-meta' === $item ) {
				?>
				<div class="box-meta">
					<div class="left">
						<?php solace_the_author_custom('image', 50); ?>
					</div>
					<div class="right">
						<div class="the-time">
							<?php solace_the_time_custom(); ?>
						</div>
						<div class="words-per-minute">
							<?php solace_words_per_minute(); ?>
						</div>						
						<div class="comment">
							<?php solace_the_comments(); ?>
						</div>
					</div>
				</div>
				<?php
			} else if ( $prefix . '-divider' === $item ) {
				?>
				<div class="divider-border">
					<div class="divider"></div>
				</div>
				<?php
			} else if ( $prefix . '-content' === $item ) {
				$class_sidebar = '';
				if ($is_active_sidebar) {
					$class_sidebar = 'sidebar-active';
				}
				?>
					<div class="boxes-content <?php echo esc_html($class_sidebar); ?>">
						<div class="box-the-content">
							<div class="the-content">
								<?php
								the_content(
									sprintf(
										wp_kses(
											/* translators: %s: Name of current post. Only visible to screen readers */
											esc_html__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'solace'),
											array(
												'span' => array(
													'class' => array(),
												),
											)
										),
										wp_kses_post(get_the_title())
									)
								);

								wp_link_pages(
									array(
										'before' => '<div class="page-links">' . esc_html__('Pages:', 'solace'),
										'after'  => '</div>',
									)
								);
								?>
							</div>
							<?php 
							if ($is_active_sidebar) {
								get_sidebar();
							}
							?>
						</div>

						<?php 
						do_action('solace_render_customizer_social_share');
						?>
					</div>
				<?php
			} else if ( $prefix . '-tags' === $item ) {
				solace_the_tag();
			}
		endforeach; 

		solace_info_author(); 

		// If comments are open or we have at least one comment, load up the comment template.
		$show_comment = get_theme_mod( 'solace_single_show_comments', true );
		if ( $show_comment ) {
			if (comments_open() || get_comments_number()) :
				comments_template();
			endif;
		}

		$post_navigation = get_theme_mod( 'solace_show_single_post_navigation', true );
		if ( $post_navigation ) :		
		?>
			<div class="box-posts-navigation">
				<?php
				$previous_post = get_previous_post();
				if ($previous_post) {
					$previous_title = $previous_post->post_title;
					if (strlen($previous_title) > 23) {
						$previous_title = substr($previous_title, 0, 23) . '...';
					}
					$previous_permalink = get_permalink($previous_post);
					$previous_thumbnail = get_the_post_thumbnail($previous_post, array(58, 58));
					echo '<div class="left">';
					echo '<a href="' . esc_url($previous_permalink) . '" title="' . esc_attr($previous_title) . '">';
					echo '<div class="thumbnail">';
					if ($previous_thumbnail) {
						echo $previous_thumbnail;
					} else {
						echo "<div class='thumbnail-box'></div>";
					}
					echo '</div>';

					echo '<div class="text">';
					echo '<span class="previous">' . esc_html__("Previous Post:", "solace") . '</span>';
					echo '<span class="title">' . esc_html($previous_title) . '</span>';
					echo '</div>';
					echo '</a>';
					echo '</div>';
				} else {
					echo '<div class="left">';
					echo '</div>';
				}
				?>

				<?php
				$next_post = get_next_post();
				if ($next_post) {
					$next_title = $next_post->post_title;
					if (strlen($next_title) > 23) {
						$next_title = substr($next_title, 0, 23) . '...';
					}
					$next_permalink = get_permalink($next_post);
					$next_thumbnail = get_the_post_thumbnail($next_post, array(58, 58));

					echo '<div class="right">';
					echo '<a href="' . esc_url($next_permalink) . '" title="' . esc_attr($next_title) . '">';
					echo '<div class="thumbnail">';
					if ($next_thumbnail) {
						echo $next_thumbnail;
					} else {
						echo "<div class='thumbnail-box'></div>";
					}
					echo '</div>';

					echo '<div class="text">';
					echo '<span class="next">' . esc_html__("Next Post:", "solace") . '</span>';
					echo '<span class="title">' . esc_html($next_title) . '</span>';
					echo '</div>';
					echo '</a>';
					echo '</div>';
				} else {
					echo '<div class="right">';
					echo '</div>';
				}
				?>
			</div>
		<?php endif; ?>		
		<?php $related_posts = get_theme_mod( 'solace_show_single_related_posts', true ); ?>		
		<?php if ( $related_posts ): ?>
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
	</section>
</article><!-- #post-<?php the_ID(); ?> -->
