<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package solace
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses solace_header_style()
 */
function solace_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'solace_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'solace_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'solace_custom_header_setup' );

function solace_get_woocommerce_page_title() {
    if (is_shop()) {
        return get_the_title(wc_get_page_id('shop'));
    } elseif (is_cart()) {
        return __('Cart', 'solace');
    } elseif (is_checkout()) {
        return __('Checkout', 'solace');
    } elseif (is_account_page()) {
        return __('My Account', 'solace');
    } else {
        return get_the_title();
    }
}

function solace_content_before_woocommerce_pages() {
	$body_classes = get_body_class();

	if (in_array('woocommerce-page', $body_classes)) {
		return;
	} 
	$sol_page_title = get_theme_mod('solace_blog_page_title_blog_title',true );
	$sol_page_header = get_theme_mod('solace_blog_page_title_page_header',false);
	$sol_page_breadcrumb = get_theme_mod('solace_blog_page_title_breadcrumb',true);
	$sol_page_description = get_theme_mod('solace_blog_page_title_blog_description',true);
	$sol_page_alignment = get_theme_mod('solace_blog_page_title_horizontal_alignment',false);
	$sol_page_font_color = get_theme_mod('solace_blog_page_title_font_color','var(--blog-page-title-font-color)');
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
	if ( $sol_page_header ){ 
			$woocommerce_page_title = solace_get_woocommerce_page_title();
			if (is_cart() || is_checkout() || is_account_page()) {?>
			<style>
				.woocommerce-cart .main-page .container-page .boxes-header .cover,
				.woocommerce-checkout .main-page .container-page .boxes-header .cover,
				.woocommerce-account .main-page .container-page .boxes-header .cover,
				.woocommerce-account .main-page .container-page .boxes-content .archive-header {
					display: none;
				}
				.archive-header {
					background: <?php echo $sol_page_bg_color;?>;
				}
				.shop-container .page-description p,
				.shop-container .woocommerce-breadcrumb {
					display: none;
				}
				.archive-header .solace-breadcrumb,
				.archive-header .solace-blog-title,
				.archive-header .woocommerce-breadcrumb,
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
				
			</style>
			<header class="archive-header <?php echo $sol_page_alignment;?>">
			<?php 
				if ($sol_page_breadcrumb ) { 

					echo !empty( $css_sol_page_breadcrumb )? $css_sol_page_breadcrumb:''?>

					<div class='solace-header solace-breadcrumb'>
						<?php woocommerce_breadcrumb(); ?>
					</div>   
				<?php
				}?>
				<?php if ( $sol_page_title ) : ?>
					<?php echo !empty( $css_sol_page_title ) ? $css_sol_page_title : ''; ?>
					<h1 class="solace-header solace-blog-title">
						<?php echo $woocommerce_page_title; ?>
					</h1>
				<?php endif; ?>

				<?php if ( $sol_page_description && !is_search() && !is_category() ) : ?>
					<?php
						$page_for_posts_id = get_option('page_for_posts');
						$page_for_posts = get_post( $page_for_posts_id );
						echo !empty( $css_sol_page_description ) ? $css_sol_page_description : '';
					?>

					<?php if ( !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() ) : ?>
						<div class="solace-header solace-description">
							<?php echo apply_filters( 'the_content', $shop_page->post_content ); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

			</header>
			<style>
				.solace-header:last-child {
					padding-bottom: 0px; 
				}
			</style>
		<?php }
	} 	
}
add_action('woocommerce_before_cart', 'solace_content_before_woocommerce_pages', 10);
add_action('woocommerce_before_checkout_form', 'solace_content_before_woocommerce_pages', 10);
add_action('woocommerce_before_my_account', 'solace_content_before_woocommerce_pages', 10);


if ( ! function_exists( 'solace_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see solace_custom_header_setup().
	 */
	function solace_header_style() {
		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
				}
			<?php
			// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
