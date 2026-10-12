<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page header div.
 *
 * @package Solace
 * @since   1.0.0
 */
?><!DOCTYPE html>
<?php

/**
 * Filters the header classes.
 *
 * @param string $header_classes Header classes.
 *
 * @since 2.3.7
 */

use Solace\Customizer\Options\Layout_Single_Post;

$header_classes = apply_filters( 'nv_header_classes', 'header' );

/**
 * Fires before the page is rendered.
 */
do_action( 'solace_html_start_before' );

?>
<html <?php language_attributes(); ?>>

<head>
	<?php
	/**
	 * Executes actions after the head tag is opened.
	 *
	 * @since 2.11
	 */
	do_action( 'solace_head_start_after' );
	?>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php
	$site_icon_id = get_theme_mod('site_icon');
	if ($site_icon_id) {
		$site_icon_url = wp_get_attachment_url($site_icon_id);
		if ($site_icon_url) {
			echo '<link rel="icon" href="' . esc_url($site_icon_url) . '" sizes="32x32">';
		}
	}
	 ?>
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>

	<?php
	/**
	 * Executes actions before the head tag is closed.
	 *
	 * @since 2.11
	 */
	do_action( 'solace_head_end_before' );
	?>
</head>
<?php 
$solace_global_colors = get_theme_mod( 'solace_global_colors' );
if (!is_bool($solace_global_colors)) {
	if (!empty($solace_global_colors['activePalette'])) {
		$active_palette = $solace_global_colors['activePalette'];
		$button = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-initial'];
		$button_hover = $solace_global_colors['palettes'][$active_palette]['colors']['sol-color-button-hover'];
	}
} else {
	$button = '#1D70DB';
	$button_hover = '#1D70DB';
	$active_palette = 'base';	
}
?>
<body  <?php body_class(); ?> <?php solace_body_attrs(); ?> color-active="<?php echo esc_attr($active_palette); ?>" btn="<?php echo esc_attr($button); ?>" btn-hover="<?php echo esc_attr($button_hover); ?>">

<?php
/**
 * Executes actions after the body tag is opened.
 *
 * @since 2.11
 */
do_action( 'solace_body_start_after' );
?>

<div class="item--inner builder-item--header_search_responsive" data-section="header_search_responsive" data-item-id="header_search_responsive">
	<div class="nv-search-icon-component">
		<div class="menu-item-nav-search solace-nav-search canvas">
			<span class="sol_search_icon solace" style="display: none;">
				<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.464 14.1694L12.4911 11.1965C13.3921 10.0171 13.8862 8.58645 13.8864 7.07683C13.8864 5.2576 13.1779 3.54713 11.8913 2.26075C10.6049 0.974375 8.89466 0.265839 7.07521 0.265839C5.25597 0.265839 3.5455 0.974375 2.25912 2.26075C-0.396434 4.91653 -0.396434 9.23758 2.25912 11.8929C3.5455 13.1795 5.25597 13.8881 7.07521 13.8881C8.58482 13.8879 10.0154 13.3937 11.1949 12.4927L14.1677 15.4656C14.3465 15.6446 14.5813 15.7341 14.8158 15.7341C15.0504 15.7341 15.2851 15.6446 15.464 15.4656C15.822 15.1077 15.822 14.5272 15.464 14.1694ZM3.55535 10.5967C1.61459 8.65593 1.61482 5.49796 3.55535 3.55698C4.49551 2.61703 5.74564 2.09917 7.07521 2.09917C8.405 2.09917 9.6549 2.61703 10.5951 3.55698C11.5352 4.49714 12.0531 5.74726 12.0531 7.07683C12.0531 8.40663 11.5352 9.65652 10.5951 10.5967C9.6549 11.5369 8.405 12.0547 7.07521 12.0547C5.74564 12.0547 4.49551 11.5369 3.55535 10.5967Z" fill=""></path>
				</svg>
			</span>
			<div class="nv-nav-search" aria-label="search">
				<div class="form-wrap container responsive-search">
					<form method="get" class="search-form" action="<?php echo esc_url( home_url() ); ?>">
						<label>
							<span class="screen-reader-text"><?php esc_html_e( 'Search for...', 'solace' ); ?></span>
						</label>
						<input type="search" class="search-field" aria-label="Search" placeholder="Search for..." value="" name="s">
						<button type="submit" class="search-submit nv-submit elementor-button" aria-label="Search">
							<span class="nv-search-icon-wrap">
								<span class="nv-icon nv-search">
									<svg width="15" height="15" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M1216 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"></path>
									</svg>
								</span></span>
						</button>
					</form>
				</div>
				<div class="close-container container responsive-search">
					<button class="close-responsive-search" aria-label="Close">
						<svg width="50" height="50" viewBox="0 0 20 20" fill="#555555">
							<path d="M14.95 6.46L11.41 10l3.54 3.54l-1.41 1.41L10 11.42l-3.53 3.53l-1.42-1.42L8.58 10L5.05 6.47l1.42-1.42L10 8.58l3.54-3.53z"></path>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<?php wp_body_open(); ?>
<div class="wrapper">
	<?php
	/**
	 * Executes actions before the header tag is opened.
	 *
	 * @since 2.7.2
	 */
	do_action( 'solace_before_header_wrapper_hook' );
	?>
	<header class="<?php echo esc_attr( $header_classes ); ?>" <?php echo ( solace_is_amp() ) ? 'next-page-hide' : ''; ?> >
		<a class="solace-skip-link  show-on-focus" href="#mycontent" >
			<?php echo __( 'Skip to content', 'solace' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		</a>
		<?php

		/**
		 * Executes actions before the header ( navigation ) area.
		 *
		 * @since 1.0.0
		 */
		do_action( 'solace_before_header_hook' );

		if ( apply_filters( 'solace_filter_toggle_content_parts', true, 'header' ) === true ) {
			do_action( 'solace_do_header' );
		}

		/**
		 * Executes actions after the header ( navigation ) area.
		 *
		 * @since 1.0.0
		 */
		do_action( 'solace_after_header_hook' );
		?>
	</header>

	<?php
	/**
	 * Executes actions after the header tag is closed.
	 *
	 * @since 2.7.2
	 */
	do_action( 'solace_after_header_wrapper_hook' );
	?>


	<?php
	/**
	 * Executes actions before main tag is opened.
	 *
	 * @since 1.0.4
	 */
	do_action( 'solace_before_primary' );
	?>

<?php
/**
 * Executes actions after main tag is opened.
 *
 * @since 1.0.4
 */
do_action( 'solace_after_primary_start' );

?>

<div id="mycontent"></div>