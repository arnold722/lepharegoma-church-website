<?php

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Zenithwp
 */

?>

<article class="grids grid1">
	<div class="boxes">
		<!-- Box image -->
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="box-image">
				<div class="the-image">
					<?php solace_post_thumbnail_default_blog(); ?>
				</div>
				<div class="the-category">
					<?php the_category(', '); ?>
				</div>

				<div class="the-author-image">
					<?php echo get_avatar(get_the_author_meta('ID'), 60); ?>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="box-content">
		<?php else: ?>
			<div class="box-content no-thumbnail">
		<?php endif; ?>
			<div class="the-title">
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
			</div>
			<div class="the-excerpt">
				<?php the_excerpt(); ?>
			</div>
			<div class="the-readmore">
				<a href="<?php the_permalink(); ?>">
					<?php esc_html_e('Read More', 'solace'); ?>
				</a>
			</div>
		</div>
		<div class="box-meta">
			<div class="the-author">
				<span><?php the_author(); ?></span>
			</div>
			<div class="the-date">
				<span><?php the_time('F j, Y'); ?></span>
			</div>
		</div>
	</div>
</article>