<?php

use Solace\Customizer\Options\Layout_Single_Post;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package solace
 */

if (!function_exists('solace_posted_on')) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function solace_posted_on()
	{
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if (get_the_time('U') !== get_the_modified_time('U')) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr(get_the_date(DATE_W3C)),
			esc_html(get_the_date()),
			esc_attr(get_the_modified_date(DATE_W3C)),
			esc_html(get_the_modified_date())
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x('Posted on %s', 'post date', 'solace'),
			'<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('solace_posted_by')) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function solace_posted_by()
	{
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x('by %s', 'post author', 'solace'),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if (!function_exists('solace_entry_footer')) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function solace_entry_footer()
	{
		// Hide category and tag text for pages.
		if ('post' === get_post_type()) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list(esc_html__(', ', 'solace'));
			if ($categories_list) {
				/* translators: 1: list of categories. */
				printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'solace') . '</span>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'solace'));
			if ($tags_list) {
				/* translators: 1: list of tags. */
				printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'solace') . '</span>', $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						esc_html__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'solace'),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post(get_the_title())
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					esc_html__('Edit <span class="screen-reader-text">%s</span>', 'solace'),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post(get_the_title())
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if (!function_exists('solace_post_thumbnail')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function solace_post_thumbnail()
	{
		if (post_password_required()) {
			return;
		}

		if (has_post_thumbnail()) :
?>
			<div class="post-thumbnail">
				<span aria-hidden="true" class="overlay"></span>
				<?php the_post_thumbnail('solace-single-default'); ?>
			</div>

		<?php else : ?>
			<div class="post-thumbnail">
				<span aria-hidden="true" class="overlay"></span>
			</div>
		<?php endif;
	}
endif;

if (!function_exists('solace_post_thumbnail_single')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function solace_post_thumbnail_single()
	{

		if (is_single()) :
			if (has_post_thumbnail()) :
?>
				<div class="post-thumbnail">
					<span aria-hidden="true" class="overlay"></span>
					<?php the_post_thumbnail('solace-single-default'); ?>
				</div>

			<?php else : ?>
				<div class="post-thumbnail">
					<span aria-hidden="true" class="overlay"></span>
				</div>
			<?php endif;
		endif;
	}
endif;

if (!function_exists('solace_post_thumbnail_page')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function solace_post_thumbnail_page()
	{
		if (post_password_required() || is_attachment()) {
			return;
		}

		if (is_page()) :
			if (has_post_thumbnail()) :
			?>
				<div class="post-thumbnail">
					<span aria-hidden="true" class="overlay"></span>
					<?php the_post_thumbnail('solace-single-default'); ?>
				</div>

			<?php else : ?>
				<div class="post-thumbnail">
					<span aria-hidden="true" class="overlay"></span>
				</div>
		<?php endif;
		endif;
	}
endif;

if ( ! function_exists( 'solace_the_category' ) ) {
	/**
	 * Add function to display custom category.
	 */ 
	function solace_the_category($icon = false) {
		$categories = get_the_category();
		$output     = '';
		$separator = get_theme_mod(Config::MODS_BLOG_POST_DESIGN_SEPARATOR, 'separator1');
		$svg = '';
		if ($icon) {
			if ( 'separator1' === $separator) {
				$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="2" height="15" viewBox="0 0 2 15" fill="none">
				<line x1="1" y1="15" x2="0.999999" y2="4.37114e-08" stroke="#0E305F" stroke-width="2"/></svg>';
			} else if ( 'separator2' === $separator) {
				$svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>';
			} else if ( 'separator3' === $separator) {
				$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="2" viewBox="0 0 15 2" fill="none">
				<line y1="-1" x2="15" y2="-1" transform="matrix(1 0 0 -1 0 0)" stroke="#0E305F" stroke-width="2"/></svg>';
			} else if ( 'separator4' === $separator) {
				$svg = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
				<line y1="-1" x2="15" y2="-1" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 0.196777 11.3027)" stroke="#0E305F" stroke-width="2"/></svg>';
			}
		}

		if ( ! empty( $categories ) ) {
			$index = 1;
			foreach ( $categories as $category ) {
				if ( count($categories) > 1 ) {
					$output .= $svg;
				}
				$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>';
				$index++;
			}

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo $output;
		}
	}
}

if ( ! function_exists( 'solace_the_comments' ) ) {
	/**
	 * Add function to display comment.
	 *
	 * @param boolean $display_icon Whether to display the icon or not.
	 */
	function solace_the_comments( $display_icon = true ) {

		$link = get_the_permalink();
		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M208 352c114.9 0 208-78.8 208-176S322.9 0 208 0S0 78.8 0 176c0 38.6 14.7 74.3 39.6 103.4c-3.5 9.4-8.7 17.7-14.2 24.7c-4.8 6.2-9.7 11-13.3 14.3c-1.8 1.6-3.3 2.9-4.3 3.7c-.5 .4-.9 .7-1.1 .8l-.2 .2 0 0 0 0C1 327.2-1.4 334.4 .8 340.9S9.1 352 16 352c21.8 0 43.8-5.6 62.1-12.5c9.2-3.5 17.8-7.4 25.3-11.4C134.1 343.3 169.8 352 208 352zM448 176c0 112.3-99.1 196.9-216.5 207C255.8 457.4 336.4 512 432 512c38.2 0 73.9-8.7 104.7-23.9c7.5 4 16 7.9 25.2 11.4c18.3 6.9 40.3 12.5 62.1 12.5c6.9 0 13.1-4.5 15.2-11.1c2.1-6.6-.2-13.8-5.8-17.9l0 0 0 0-.2-.2c-.2-.2-.6-.4-1.1-.8c-1-.8-2.5-2-4.3-3.7c-3.6-3.3-8.5-8.1-13.3-14.3c-5.5-7-10.7-15.4-14.2-24.7c24.9-29 39.6-64.7 39.6-103.4c0-92.8-84.9-168.9-192.6-175.5c.4 5.1 .6 10.3 .6 15.5z"/></svg>';

		if ( 1 === absint( get_comments_number() ) ) {
			$count = '<span class="count">' . absint( get_comments_number() ) . esc_html__( ' Comment', 'solace') . '</span>';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="comment-with-icon" href="' . esc_url( $link ) . '#comments">' . $count . '</a>';
		} else {
			$count = '<span class="count">' . absint( get_comments_number() ) . esc_html__( ' Comments', 'solace') . '</span>';

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="comment-with-icon" href="' . esc_url( $link ) . '#comments">' . $count . '</a>';
		}
	}
}

if ( ! function_exists( 'solace_featured_image' ) ) {
	function solace_featured_image() {

		// Display the thumbnail if available.
		if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {

			$data = new Layout_Single_Post();
			$default = $data->blog_post_single_featured_image_default();

			$data = get_theme_mod( 'solace_single_post_featured_image', $default );
			$image_size_desktop = $data['desktop']['imageSize'];
			$image_size_tablet = $data['tablet']['imageSize'];
			$image_size_mobile = $data['mobile']['imageSize'];
			?>
			<figure class="solace-featured-image">
				<div class="image-container">
					<picture>
						<source media="(min-width: 1024px)" srcset="<?php the_post_thumbnail_url($image_size_desktop); ?>">
						<source media="(min-width: 768px)" srcset="<?php the_post_thumbnail_url($image_size_tablet); ?>">
						<img src="<?php the_post_thumbnail_url($image_size_mobile); ?>" alt="<?php the_title_attribute(); ?>">
						<span class="ratio"></span>
					</picture>					
				</div>
			</figure>
			<?php
		}
	}
}

if ( ! function_exists( 'solace_the_thumbnail_single2' ) ) {
	/**
	 * Add function to display the default Post thumbnail.
	 *
	 * @param string $args       The size of the thumbnail.
	 * @param bool   $background A boolean specifying whether to use a background image.
	 */
	function solace_the_thumbnail_single2( $args ) {

		// Display the thumbnail if available.
		if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {
			// Check if the thumbnail size is '1500x800'.
			if ( '2000x975' === $args ) {
				echo '<div class="box-thumbnail">';
				the_post_thumbnail( 'solace-single2' );
				echo '</div>';
			}
		}
	}
}

if ( ! function_exists( 'solace_the_thumbnail_related_posts' ) ) {
	/**
	 * Add function to display the default Post thumbnail.
	 *
	 * @param string $args       The size of the thumbnail.
	 * @param bool   $background A boolean specifying whether to use a background image.
	 */
	function solace_the_thumbnail_related_posts( $args, $background ) {

		// Display the thumbnail if available.
		if ( has_post_thumbnail() && ! post_password_required() && ! is_attachment() ) {
			// Check if the thumbnail size is '250x277' and background is true.
			if ( '250x277' === $args && $background ) {
				$src = get_the_post_thumbnail_url( get_the_ID(), 'solace-related-posts' );
				?>
				<div class="image has-post-thumbnail">
					<div class="overlay"></div>
					<div class="thumbnail" style="background-image: url(<?php echo esc_url( $src ); ?>);"></div>
				</div>
				<?php
			}
		} else {
			?>
			<div class="image no-post-thumbnail">
				<div class="overlay"></div>
				<div class="thumbnail"></div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'solace_the_author' ) ) {
	/**
	 * Displays the author information with either an icon or an image.
	 *
	 * @param string  $display Determines whether to display the author as an 'image' or an 'icon'.
	 * @param integer $size    The size of the icon or image.
	 */
	function solace_the_author( $display = 'image', $size = 30 ) {
		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );

		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>';

		$image = get_avatar( get_the_author_meta( 'ID' ), $size );

		$author_name = '<span class="name">' . esc_html( get_the_author() ) . '</span>';

		if ( 'icon' === $display ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="author-with-icon" href="' . esc_url( $link ) . '">' . $icon . $author_name . '</a>';
		} elseif ( 'image' === $display ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="author-with-image" href="' . esc_url( $link ) . '">' . $image . $author_name . '</a>';
		}
	}
}

if ( ! function_exists( 'solace_the_author_custom' ) ) {
	/**
	 * Displays the author information with either an icon or an image.
	 *
	 * @param string  $display Determines whether to display the author as an 'image' or an 'icon'.
	 * @param integer $size    The size of the icon or image.
	 */
	function solace_the_author_custom( $display = 'image', $size = 30 ) {
		$defaults_single_post_meta = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);					
		$single_post_meta = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_POST_META, $defaults_single_post_meta );
		$author_label = $single_post_meta['authorLabel'];

		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );

		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>';

		$image = get_avatar( get_the_author_meta( 'ID' ), $size );

		$author_name = '<span class="name">' . esc_html( $author_label . ' ' . get_the_author() ) . '</span>';

		if ( 'icon' === $display ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="author-with-icon" href="' . esc_url( $link ) . '">' . $icon . $author_name . '</a>';
		} elseif ( 'image' === $display ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<a class="author-with-image" href="' . esc_url( $link ) . '">' . $image . $author_name . '</a>';
		}
	}
}

if ( ! function_exists( 'solace_the_tag' ) ) {
	/**
	 * Displays the tag information.
	 *
	 * @param string  $display Determines whether to display the tag as an 'image' or an 'icon'.
	 * @param integer $size    The size of the icon or image.
	 */	
	function solace_the_tag() {

		if ( has_tag() ) {
			?>
			<div class="boxes-tag">
				<div class="the-tags"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
						<path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32z" />
					</svg>
					<?php the_tags('', ', ', ''); ?>
				</div>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'solace_info_author' ) ) {
	/**
	 * Displays the author information with either an icon or an image.
	 *
	 * @param integer $size    The size of the icon or image.
	 */
	function solace_info_author( $size = 68 ) {
		$show_author_box = get_theme_mod( 'solace_single_show_author_box', 'solace' );
		$description = get_the_author_meta('description');
		if ( empty( $show_author_box ) ) {
			return;
		}
		
		$link = get_author_posts_url( get_the_author_meta( 'ID' ) );

		$icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>';

		$image = get_avatar( get_the_author_meta( 'ID' ), $size );

		$author_name = '<span class="name">' . esc_html( get_the_author() ) . '</span>';
		?>
		<div class="box-info-author">
			<div class="box-image">
				<a class="author-with-image" href="<?php echo esc_url( $link ); ?>">
					<?php echo $image; ?>
				</a>
			</div>
			<div class="box-text">
				<a class="author-with-image" href="<?php echo esc_url( $link ); ?>">
					<?php echo $author_name; ?>
				</a>
				<p><?php echo esc_html( get_the_author_meta('description') ); ?></p>
				<a class="view-all-articles" href="<?php echo esc_url( $link ); ?>">
					<?php esc_html_e( 'View All Articles', 'solace' ); ?>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M502.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l370.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z"/></svg>					
				</a>				
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'solace_the_time' ) ) {
	/**
	 * Add function to display date.
	 *
	 * @param boolean $display_icon Whether to display the icon or not.
	 */
	function solace_the_time( $display_icon = true ) {
		$class = '';
		$class = $display_icon ? 'time-with-icon' : 'time-without-icon';
		?>
		<time class="<?php echo esc_attr( $class ); ?>" datetime="<?php echo esc_attr( the_time( 'F j, Y' ) ); ?>">
			<?php if ( $display_icon ) : ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
				</svg>
			<?php endif; ?>
			<span class="time"><?php esc_html( the_time( 'F j, Y' ) ); ?></span>
		</time>
		<?php
	}
}

if ( ! function_exists( 'solace_the_time_custom' ) ) {
	/**
	 * Add function to display date.
	 *
	 * @param boolean $display_icon Whether to display the icon or not.
	 */
	function solace_the_time_custom( $display_icon = true ) {
		$defaults_single_post_meta = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);					
		$single_post_meta = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_POST_META, $defaults_single_post_meta );		
		$updated_label = $single_post_meta['updatedLabel'];		
		$show_pdated_label = $single_post_meta['showUpdatedLabel'];		
		$class = '';
		$class = $display_icon ? 'time-with-icon' : 'time-without-icon';
		?>
		<time class="<?php echo esc_attr( $class ); ?>" datetime="<?php echo esc_attr( the_time( 'F j, Y' ) ); ?>">
			<?php if ( $display_icon ) : ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
					<path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z" />
				</svg>
			<?php endif; ?>
			<span class="time">
				<?php 
				if ( $show_pdated_label ) {
					echo esc_html( $updated_label ); 
				}
				?>
				<?php esc_html( the_time( 'F j, Y' ) ); ?>
			</span>
		</time>
		<?php
	}
}

if ( ! function_exists( 'solace_words_per_minute' ) ) {
	/**
	 * Add function to display date.
	 *
	 */
	function solace_words_per_minute() {
		$defaults_single_post_meta = Mods::get_alternative_mod_default(Config::MODS_BLOG_POST_DESIGN_POST_META);					
		$single_post_meta = get_theme_mod( Config::MODS_BLOG_POST_DESIGN_POST_META, $defaults_single_post_meta );
		$words_per_minute = $single_post_meta['wordsPerMinute']['value'];
		$content = get_the_content();
		$content_word_count = str_word_count(strip_tags($content));
		
		// Calculate the number of pages
		$page_count = round($content_word_count / $words_per_minute);
		
		// Ensure the minimum number of pages is 1
		if ($page_count < 1) {
			$page_count = 1;
		}
		?>
		<span class="count" words-per-minute="<?php echo esc_attr( $words_per_minute ); ?>" content-word-count="<?php echo esc_attr( $content_word_count ); ?>">
			<?php echo absint( $page_count ); ?>
			<?php esc_html_e( 'min read', 'solace' ); ?>
		</span>
		<?php
	}
}

if (!function_exists('solace_post_thumbnail_default_blog')) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function solace_post_thumbnail_default_blog()
	{
		if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
			return;
		}

		?>
		<a class="thumbnail-link-grids" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail(
				'solace-default-blog',
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
		</a>
<?php
	}
endif;

if (!function_exists('wp_body_open')) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
endif;
