<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package solace
 */

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


	if ($show_boxes_header){ 
		if ( empty($single_hide_title) ){?>
		<header class="boxes-header">
			<div class="cover">
				<div class="image">
					<?php solace_post_thumbnail_single(); ?>
				</div>
				<div class="text">
					<div class="the-title">
						<h1><?php the_title(); ?></h1>
					</div>
					<div class="the-category">
						<p><?php echo esc_html__('Posted in : ', 'solace'); ?></p>
						<div><?php the_category(', '); ?></div>
					</div>
					<div class="info-meta">
						<div class="the-author-image">
							<?php echo get_avatar(get_the_author_meta('ID'), 45); ?>
						</div>
						<div class="the-author">
							<span><?php the_author(); ?></span>
						</div>
						<div class="the-date">
							<time><?php the_time('F j, Y'); ?></time>
						</div>
					</div>
				</div>
			</div>
		</header>
	<?php } 
	}
    
    $class_sidebar = '';
    if ($is_active_sidebar) {
        $class_sidebar = 'sidebar-active';
    }
	?>
	<div class="boxes-content <?php echo esc_html($class_sidebar); ?>">
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
			if (has_tag()) {?>		
				<div class="boxes-tag">
					<div class="the-tags"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
							<path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
						</svg>
						<?php the_tags('', ', ', ''); ?>
					</div>
				</div>
			<?php		
			}
			solace_info_author(); 
			do_action('solace_render_customizer_social_share');

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
		</div>
		<?php 
        if ($is_active_sidebar) {
            get_sidebar();
        }
		?>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->
