<?php

/**
 * Template part for displaying page content in page.php
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

	// Page
	$page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' );
	$metabox_sidebar_layout = get_post_meta(get_the_ID(), 'sol_layout_singular', 'inherit');
	if (empty($metabox_sidebar_layout)) {
		$metabox_sidebar_layout = 'inherit';
	}

	// Sidebar
	$is_active_sidebar = false;

    // Page Inherit
    if ( $page_list_layout === 'inherit' && $metabox_sidebar_layout === 'inherit' ) {
		if ( $container_list_layout === 'left' || $container_list_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Page Page_templates
	if ( $page_list_layout !== 'inherit' && $metabox_sidebar_layout === 'inherit' ) {
		if ( $page_list_layout === 'left' || $page_list_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Page metabox_templates
	if ( $metabox_sidebar_layout !== 'inherit' ) {
		if ( $metabox_sidebar_layout === 'left' || $metabox_sidebar_layout === 'right' ) {
			$is_active_sidebar = true;
		}
    }

	// Check Widget
	if ( ! is_active_sidebar( 'blog-sidebar' ) ) {
		$is_active_sidebar = false;
	}

	$show_boxes_header = "";
	$solace_page_layout = get_theme_mod('solace_page_layout','inherit');
	$hide_title = get_theme_mod( 'solace_page_hide_title', false );
	$header_layout = get_theme_mod( 'solace_page_header_layout', 'normal' );
	$solace_container_hide_title = get_theme_mod('solace_container_hide_title', false );
	$sol_page_layout_hide_title = get_theme_mod('solace_page_layout_hide_title',false );
	
	if ( ! $hide_title ) {
		if  ( $header_layout !== "cover" ){ 
			if ( ( $solace_container_hide_title == false && $sol_page_layout_hide_title==false ) ||
			       $solace_container_hide_title == true && $sol_page_layout_hide_title==false ) { 
					$show_boxes_header = true;?>
				
		<?php }
		}
	}
	if ( $solace_page_layout=='inherit' && $solace_container_hide_title==true ){
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
						<?php solace_post_thumbnail_page(); ?>
					</div>
					<div class="text">
						<div class="the-title">
						
							<h1><?php the_title(); ?></h1>
						</div>
					</div>
				</div>
			</header>
		<?php } 
	}?>

	<?php 
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

			if (comments_open() || get_comments_number()> 0) :
				comments_template();
			endif;
			
			?>
		</div>
		<?php 
        if ($is_active_sidebar) {
            get_sidebar();
        }
		?>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->