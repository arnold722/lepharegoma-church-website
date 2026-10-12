<?php
// Callback
/**
 * Show blog layout in grid […]
 */
if (!function_exists('solace_callback_blog_layout_custom')) :
	function solace_callback_blog_layout_custom() {
		get_template_part('template-parts/blog-archive/grid');
	}
endif;

function solace_custom_breadcrumbs() {
	$home = 'Home'; 
	$delimiter = ' > '; 
	$before = '<span class="current">'; 
	$after = '</span>'; 
	$blog_title = get_the_title(get_option('page_for_posts')); 
	$delimiter = $delimiter . $blog_title; 
	global $post;
	$homeLink = home_url();
	echo '<a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';   
}

if (!function_exists('solace_blog_page_title_layout')) :
	function solace_blog_page_title_layout() {

		$sol_page_title = get_theme_mod('solace_blog_page_title_blog_title',true);
		$sol_page_header = get_theme_mod('solace_blog_page_title_page_header',false);
		$sol_page_breadcrumb = get_theme_mod('solace_blog_page_title_breadcrumb',true);
		$sol_page_description = get_theme_mod('solace_blog_page_title_blog_description',true);
		$sol_page_alignment = get_theme_mod('solace_blog_page_title_horizontal_alignment',false);
		$sol_page_font_color = get_theme_mod('solace_blog_page_title_font_color','#FFFFFF');
		$sol_page_bg_color = get_theme_mod('solace_blog_page_title_area_background','var(--sol-color-page-title-background)');
		$sol_page_vertical_spacing = get_theme_mod('solace_blog_page_title_vertical_spacing','20');

	
		$css_sol_page_breadcrumb = "";
		$css_sol_page_title = "";
		$css_sol_page_description = "";
		
		if ($sol_page_breadcrumb) {
			$css_sol_page_breadcrumb = '<style>.archive-header .solace-breadcrumb{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if ($sol_page_title) {
			$css_sol_page_title = '<style>.archive-header .solace-blog-title{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if ($sol_page_description) {
			$css_sol_page_description = '<style>.archive-header .solace-description{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if (!$sol_page_title && $sol_page_breadcrumb) {
			$css_sol_page_breadcrumb = '<style>.archive-header .solace-breadcrumb{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if (!$sol_page_description && $sol_page_title) {
			$css_sol_page_title = '<style>.archive-header .solace-blog-title{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if ($sol_page_description && $sol_page_title && !$sol_page_breadcrumb) {
			$css_sol_page_description = '<style>.archive-header .solace-description{ padding-bottom: ' . $sol_page_vertical_spacing . 'px;  }</style>';
		}
		
		if ($sol_page_breadcrumb && $sol_page_title && $sol_page_description) {
			$css_sol_page_description = '<style>.archive-header .solace-description{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		
		if (!$sol_page_breadcrumb && !$sol_page_title && $sol_page_description) {
			$css_sol_page_description = '<style>.archive-header .solace-description{ padding-bottom: ' . $sol_page_vertical_spacing . 'px; }</style>';
		}
		$blog_title = "";
		if ( $sol_page_header ){ ?>
			<?php
				if ((is_home() && !is_front_page()) || is_search() || is_category() || is_tag() || is_author() || is_month() || is_year() ||is_day() || is_attachment() ||  (class_exists('WooCommerce') && is_shop())) {
					if (is_search()) {
						$blog_title =  sprintf(__('Search Results for: %s', 'solace'), get_search_query());
					} elseif (is_category()) {
						$blog_title = sprintf(__('Category: %s', 'solace'), single_cat_title('', false));
					} elseif (is_tag()) {
						$blog_title = sprintf(__('Tag: %s', 'solace'), single_tag_title('', false));
					} elseif (is_author()) {
						the_post(); 
						$blog_title = sprintf(__('Author: %s', 'solace'), get_the_author()) ;
						
						rewind_posts(); 
					} elseif (is_home() && !is_front_page()) {
						$blog_title = get_the_title(get_option('page_for_posts', true)) ;
					} elseif (is_shop()){
						$shop_page_id = wc_get_page_id('shop');
						$shop_page = get_post($shop_page_id);
						if ($shop_page) {
							$blog_title = apply_filters('the_content', $shop_page->post_content);
						}
					} elseif (is_month()) { 
						$blog_title = sprintf(__('Month: %s', 'solace'), get_the_date('F Y')); 
					} elseif (is_year()) {
						$blog_title = sprintf(__('Year: %s', 'solace'), get_the_date('Y'));
					} elseif (is_day()) {
						$blog_title = sprintf(__('Day: %s', 'solace'), get_the_date('F j, Y'));
					} elseif (is_attachment()) {
						$blog_title = sprintf(__('Attachment: %s', 'solace'), get_the_title());
					}

				?>
				<style>
					.archive-header {
						background: <?php echo $sol_page_bg_color;?>;
					}
					.archive-header .solace-breadcrumb,
					.archive-header .solace-blog-title,
					.archive-header .solace-description p,
					.archive-header .solace-blog-title p  {
						color: <?php echo $sol_page_font_color;?>;
					}
					.archive-header .solace-breadcrumb a {
						color: <?php echo 'var(--sol-color-link-button-initial)';?>;
					}
					.archive-header .solace-breadcrumb a:hover {
						color: <?php echo 'var(--sol-color-link-button-hover)';?>;
					}

					.archive-header .solace-header.solace-blog-title,
					.archive-header .solace-header.solace-description h1 {
						color: var(--blog-page-title-font-color);
					}
					
				</style>
				<header class="archive-header callback <?php echo $sol_page_alignment;?>">
					 <?php if ($sol_page_breadcrumb && !is_search() && !is_category() && !is_tag() && !is_author() && !is_month() && !is_year() && !is_day() && !is_attachment() ) { 

								echo !empty( $css_sol_page_breadcrumb )? $css_sol_page_breadcrumb:''?>
								
								<div class='solace-header solace-breadcrumb'>
									<?php solace_custom_breadcrumbs(); ?>

								</div>   
					<?php
					}
					if ( $sol_page_title ){
						echo !empty( $css_sol_page_title )? $css_sol_page_title:''?>
							<h1 class='solace-header solace-blog-title' style='padding-top: 20px;'>
								<?php
								// $blog_title = get_the_title(get_option('page_for_posts'));
								echo $blog_title;?>
							</h1>
					<?php }

					if ( ! is_author() && $sol_page_description ) {
						?>
						<div class='solace-header solace-description'>
							<?php the_archive_description(); ?>
						</div>
						<?php
					}

					if (is_author() && $sol_page_description) {
						$author_bio = get_the_author_meta('description');
						if (!empty($author_bio)) {
							echo !empty($css_sol_page_description) ? $css_sol_page_description : '' ?>
							<div class='solace-header solace-description'>
								<?php echo sprintf(__('<p>Biography: %s</p>', 'solace'), $author_bio); ?>
							</div>
						<?php }
					}

					if ( $sol_page_description  && !is_search() && !is_category() && !is_tag() && !is_month() && !is_year() && !is_day() && !is_attachment() && !is_author()){
						$page_for_posts_id = get_option('page_for_posts');
						$sol_page_title = get_theme_mod('solace_blog_page_title_blog_title',true);
						echo !empty( $css_sol_page_description )? $css_sol_page_description:''?>
						<div class='solace-header solace-description'>
							<style>
								.solace-header.solace-blog-title {
									display: none;
								}
							</style>
							<?php
							$page_for_posts_id = get_option( 'page_for_posts' );
							$title = get_the_title( $page_for_posts_id );
							if ( $page_for_posts_id && $sol_page_title) : ?>
								<h1><?php echo esc_html( $title ); ?></h1>
							<?php endif; ?>
						</div>
					<?php }
					?>
				</header>
				<style>
					.solace-header:last-child {
						padding-bottom: 0px; 
					}
				</style>
			<?php }
		} 	
	}
endif;
?>