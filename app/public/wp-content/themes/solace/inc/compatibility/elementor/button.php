<?php
// use Elementor;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Repeater;
use Elementor\Plugin;

function get_elementor_kit_id(): int {
    if ( class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->kits_manager ) ) {
        $kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();
        if ( $kit_id ) {
            return (int) $kit_id;
        }
    }

    $kit_id = (int) get_option( 'elementor_active_kit', 3 );
    return $kit_id > 0 ? $kit_id : 3;
}

function build_default_button_selector(): string {
    $kit_id = get_elementor_kit_id();

    return "
		body .button:not(header .button):not(footer .button):not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
		body .button-primary:not(header .button-primary):not(footer .button-primary),
		body .button-secondary:not(header .button-secondary):not(footer .button-secondary),body .button-link,
		body .comments-area .form-submit .submit,
		input[type='submit']:not(.solace-mc-embedded-subscribe),
		body.single a.wp-block-button__link,
		body .solaceform-form-button,
        body.elementor-kit-{$kit_id} .elementor-button:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
		.SELECTOR_DEFAULT_BUTTON_BG
    ";
}

add_action( 'init', function() {
    if ( ! defined( 'SELECTOR_DEFAULT_BUTTON_BG' ) ) {
        define( 'SELECTOR_DEFAULT_BUTTON_BG', build_default_button_selector() );
    }
}, 20 );

define('SELECTOR_DEFAULT_BUTTON_TEXT',"
	body .button:not(header .button):not(footer .button):not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body .button-primary:not(header .button-primary):not(footer .button-primary),
	body .button-secondary:not(header .button-secondary):not(footer .button-secondary),
	body .button-link,
	body .comments-area .form-submit .submit,
	body.single a.wp-block-button__link,
	body footer .solace-mc-embedded-subscribe.elementor-button,
	body .solaceform-form-button,
	body .elementor-button:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	.SELECTOR_DEFAULT_BUTTON_TEXT
");

define('SELECTOR_DEFAULT_BUTTON_TEXT_HOVER',"
	body .button:not(header .button):not(footer .button):hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body .button-primary:not(header .button-primary):not(footer .button-primary):hover,
	body .button-secondary:not(header .button-secondary):not(footer .button-secondary):hover,
	body .button-link:hover,
	body .comments-area .form-submit .submit:hover,
	body.single a.wp-block-button__link:hover,
	body .solaceform-form-button:hover,
	body footer .solace-mc-embedded-subscribe.elementor-button:hover,
	:where(body:not(.woocommerce-block-theme-has-button-styles)):where(:not(.edit-post-visual-editor)) .woocommerce button.button:hover,
	body .elementor-button:hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	.SELECTOR_DEFAULT_BUTTON_TEXT_HOVER
");

// define('SELECTOR_DEFAULT_BUTTON_BG',"
// 	body .button:not(header .button):not(footer .button),
// 	body .button-primary:not(header .button-primary):not(footer .button-primary),
// 	body .button-secondary:not(header .button-secondary):not(footer .button-secondary),body .button-link,
// 	body .comments-area .form-submit .submit,
// 	input[type='submit']:not(.solace-mc-embedded-subscribe),
// 	body.single a.wp-block-button__link,
// 	body .solaceform-form-button,
// 	body .elementor-button,
// 	.SELECTOR_DEFAULT_BUTTON_BG
// ");

// define('SELECTOR_DEFAULT_BUTTON_BG_HOVER',"
// 	body .button:not(header .button):not(footer .button):hover,
// 	body .button-primary:not(header .button-primary):not(footer .button-primary):hover,
// 	body .button-secondary:not(header .button-secondary):not(footer .button-secondary):hover,
// 	body .button-link:hover,
// 	body .comments-area .form-submit .submit:hover,
// 	input[type='submit']:not(.solace-mc-embedded-subscribe):hover,
// 	body.single a.wp-block-button__link:hover,
// 	body .solaceform-form-button:hover,
// 	.SELECTOR_DEFAULT_BUTTON_BG_HOVER
// ");
define('SELECTOR_DEFAULT_BUTTON_BG_HOVER',"
	body:not(.single-solace-sitebuilder) .button:not(header .button):not(footer .button):hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body:not(.single-solace-sitebuilder) .button-primary:not(header .button-primary):not(footer .button-primary):hover,
	body:not(.single-solace-sitebuilder) .button-secondary:not(header .button-secondary):not(footer .button-secondary):hover,
	body:not(.single-solace-sitebuilder) .button-link:hover,
	body:not(.single-solace-sitebuilder) .comments-area .form-submit .submit:hover,
	body:not(.single-solace-sitebuilder) input[type='submit']:not(.solace-mc-embedded-subscribe):hover,
	body:not(.single-solace-sitebuilder).single a.wp-block-button__link:hover,
	body:not(.single-solace-sitebuilder) .solaceform-form-button:hover,
	body:not(.single-solace-sitebuilder) .elementor-button:hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body:not(.single-solace-sitebuilder) .SELECTOR_DEFAULT_BUTTON_BG_HOVER
");

define('SELECTOR_WC_BUTTON_TEXT',"
	body .add_to_cart_button,
	body.woocommerce a.button:not(header a.button):not(footer a.button):not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body:not(.dokan-theme-solace) .woocommerce a.button,
	body .woocommerce a.button.alt,
	body.woocommerce-cart:not(.elementor-page) table.cart td.actions .button:disabled,
	body.woocommerce ul.products li.product .button,
	body:not(.dokan-theme-solace) .woocommerce ul.products li.product .button,
	body .woocommerce div.product form.cart .button,
	body .woocommerce .woocommerce-message .button,
	body:not(.woocommerce-cart) .woocommerce .cart .button,
	body .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button,
	body .woocommerce-page .woocommerce-info a:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body:not(.elementor-page) .woocommerce button.button,
	body .woocommerce button.button.alt:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body .woocommerce-account a.button.wc-forward,
	.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button.alt,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button span,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button.ajax_add_to_cart,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button,
	body.woocommerce-account:not(.elementor-default) .woocommerce form.woocommerce-EditAccountForm button[type=submit],
	:where(body:not(.woocommerce-block-theme-has-button-styles):not(.elementor-page) .woocommerce a.button.alt,
	.wp-block-add-to-cart-form form button.single_add_to_cart_button.button.alt,
	button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained span,
	.woocommerce #review_form #respond input#submit,
	.woocommerce-page a.wp-block-button__link,
	.wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span,
	.widget-search .search-submit:not(.header .widget-search .search-submit),
	.selector_wc_button_text");

define('SELECTOR_WC_BUTTON_TEXT_HOVER',"
	body:not(.dokan-theme-solace) .woocommerce ul.products li.product .button:hover,
	body:not(.dokan-theme-solace) .woocommerce a.button:hover,
	:where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce button.button.alt:hover,
	:where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce a.button.alt:hover,
	.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button.alt:hover,
	body .add_to_cart_button:hover,
	body.woocommerce a.button:not(header a.button):not(footer a.button):hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body.woocommerce ul.products li.product .button:hover,
	body .woocommerce div.product form.cart .button:hover,
	body .woocommerce .woocommerce-message .button:hover,
	body.woocommerce-cart:not(.elementor-page) table.cart td.actions .button:disabled:hover,
	body .woocommerce .cart .button:hover,
	body .woocommerce-page .woocommerce-info a,
	body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover,
	body .woocommerce-account a.button.wc-forward,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button:hover,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button:hover span,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button.ajax_add_to_cart:hover,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button:hover,
	body .woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit],
	.solace-shortcode-wc ul.products li.product .nv-card-content-wrapper a.button:hover,
	body .cross-sells ul.products li.product .button.add_to_cart_button:hover,
	body .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button:hover,
	.wp-block-add-to-cart-form form button.single_add_to_cart_button.button.alt:hover,
	button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained span:hover,
	.woocommerce #review_form #respond input#submit:hover,
	.woocommerce-page a.wp-block-button__link:hover,
	.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) a.button:not(header a.button):not(footer a.button):hover,
	.wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover span,
	.wp-block-woocommerce-cart-totals-block .wp-block-woocommerce-proceed-to-checkout-block .wc-block-components-button__text:hover,
	.selector_wc_button_text_hover");

define('SELECTOR_WC_BUTTON_BG',"
	body:not(.is-elementor-preview) .add_to_cart_button,
	body:not(.dokan-theme-solace) .woocommerce ul.products li.product .button,
	body:not(.dokan-theme-solace) .woocommerce a.button,
	:where(body:not(.woocommerce-block-theme-has-button-styles):not(.elementor-page)) .woocommerce a.button.alt,
	body .woocommerce div.product form.cart .button,
	body .woocommerce .woocommerce-message .button,
	body:not(.woocommerce-cart) .woocommerce .cart .button,
	body.woocommerce a.button:not(header a.button):not(footer a.button),
	body .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button,
	body .woocommerce-page .woocommerce-info a,
	body:not(.elementor-page) .woocommerce button.button,
	body .woocommerce button.button.alt,
	body .woocommerce-account a.button.wc-forward,
	.woocommerce:where(body:not(.woocommerce-block-theme-has-button-styles)) button.button.alt,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button.ajax_add_to_cart,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button,
	:where(body:not(.woocommerce-block-theme-has-button-styles):not(.elementor-page)) .woocommerce a.button.alt,
	body .woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit],
	body.woocommerce ul.products li.product .button,
	.wp-block-add-to-cart-form form button.single_add_to_cart_button.button.alt,
	button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained,
	.woocommerce #review_form #respond input#submit,
	.woocommerce-page a.wp-block-button__link,
	.wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained,
	.widget-search .search-submit:not(.header .widget-search .search-submit),
	body.woocommerce .elementor-button:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	.selector_wc_button_bg");

define('SELECTOR_WC_BUTTON_BG_HOVER',"
	body .add_to_cart_button:hover,
	body:not(.dokan-theme-solace) .woocommerce ul.products li.product .button:hover,
	:where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce a.button.alt:hover,
	.woocommerce button.button:disabled:hover, 
	.woocommerce button.button:disabled[disabled]:hover,
	body.woocommerce ul.products li.product .button:hover,
	.solace-shortcode-wc ul.products li.product .nv-card-content-wrapper a.button:hover,
	body .woocommerce div.product form.cart .button:hover,
	body .woocommerce .woocommerce-message .button:hover,
	body .woocommerce .cart .button:hover,
	body.woocommerce a.button:not(header a.button):not(footer a.button):hover,
	body:not(.dokan-theme-solace) .woocommerce a.button:hover, .woocommerce a.button.alt:hover,
	body .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button:hover,
	body .woocommerce-page .woocommerce-info a:hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body .woocommerce button.button:hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *), .woocommerce button.button.alt:hover:not(.elementor-widget-woocommerce-cart *):not(.elementor-widget-woocommerce-checkout-page *):not(.elementor-widget-woocommerce-products *),
	body .woocommerce-account a.button.wc-forward:hover,
	body .wc-block-components-totals-coupon__content button.wc-block-components-button:hover,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button.ajax_add_to_cart:hover,
	body .wp-block-woocommerce-cart .wp-block-button__link.add_to_cart_button:hover,
	:where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce a.button.alt:hover,
	body .woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover,
	body.woocommerce-cart:not(.elementor-page) .wc-proceed-to-checkout a.checkout-button:hover,
	.wp-block-add-to-cart-form form button.single_add_to_cart_button.button.alt:hover,
	button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained:hover,
	.woocommerce #review_form #respond input#submit:hover,
	.woocommerce-page a.wp-block-button__link:hover,
	.wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover,
	.selector_wc_button_bg_hover");


function solace_button_elementor_after_save( $elementor_element, $data ) {

	$current = \Elementor\Plugin::$instance->kits_manager->get_current_settings();

	$button_border_radius = $current['button_border_radius'];

	if (isset($button_border_radius['top'])) {
		$top_radius = $button_border_radius['top'];
	}

	if (isset($button_border_radius['right'])) {
		$right_radius = $button_border_radius['right'];
	}

	if (isset($button_border_radius['bottom'])) {
		$bottom_radius = $button_border_radius['bottom'];
	}

	if (isset($button_border_radius['left'])) {
		$left_radius = $button_border_radius['left'];
	}

	if (isset($top_radius)) {
		set_theme_mod('button_top_radius', $top_radius);
	}

	if (isset($right_radius)) {
		set_theme_mod('button_right_radius', $right_radius);
	}

	if (isset($bottom_radius)) {
		set_theme_mod('button_bottom_radius', $bottom_radius);
	}

	if (isset($left_radius)) {
		set_theme_mod('button_left_radius', $left_radius);
	}
}

add_action( 'elementor/document/after_save', 'solace_button_elementor_after_save', 10, 2 );

/**
 * Apply Elementor button styles.
 */
function solace_apply_elementor_button_styles() {

    // If plugin elementor deactive.
    if ( ! class_exists( 'Elementor\Plugin' ) ) {
        return;
    }

    $elementor_active_kit = get_option( 'elementor_active_kit' );

	// Retrieve the Elementor page settings meta data.
	$meta = get_post_meta( $elementor_active_kit, '_elementor_page_settings', true );
	$body_classes = get_body_class();

	if (in_array('dokan-store', $body_classes) || in_array('dokan-dashboard', $body_classes)) {
		$meta = false;
	} 

	// echo '<pre>';
	// print_r($meta);
	// echo '</pre>';

	if ( $meta ) {

		// Construct the CSS style for button border radius.
		$style = '';
		$selector = "
		.solace-shortcode-wc ul.products li.product .nv-card-content-wrapper a.button,
		.elementor-shortcode ul.products li.product .nv-card-content-wrapper a.button,
		body .solace-mc-embedded-subscribe, 
		.builder-item--button_base .button,
		.builder-item--button_base2 .button,
		.builder-item--button_base3 .button,
		.builder-item--button_base4 .button,
		body .search-form .search-submit,
		body .menu-item-nav-search.canvas .nv-nav-search .close-container button svg,
		body .main-all .container-all .row1 .left .boxes .box-image .the-category,
		body .wp-block-search .wp-block-search__button,
		body .comments-area form input[type=submit],
		body .site-footer .nv-html-content #mc-embedded-subscribe,
		body div.builder-item--nav-icon button,
		body #review_form #respond input#submit";

		$selector_hover = "
		
		.elementor-shortcode ul.products li.product .nv-card-content-wrapper a.button:hover,
		body .solace-mc-embedded-subscribe:hover,
		.builder-item--button_base .button:hover,
		.builder-item--button_base2 .button:hover,
		.builder-item--button_base3 .button:hover,
		.builder-item--button_base4 .button:hover,
		
		body .search-form .search-submit:hover,
		body .menu-item-nav-search.canvas .nv-nav-search .close-container button:hover svg,
		body .main-all .container-all .row1 .left .boxes .box-image .the-category:hover,
		body .wp-block-search .wp-block-search__button:hover,
		body .comments-area form input[type=submit]:hover,
		body .site-footer .nv-html-content #mc-embedded-subscribe:hover,
		body div.builder-item--nav-icon button:hover,
		
		body #review_form #respond input#submit:hover
		";		

		$selector_only = " body.woocommerce-shop nav.woocommerce-pagination ul li span.current";

		// Typography font family.
		if ( isset( $meta['button_typography_font_family'] ) ) {

			$font_family = $meta['button_typography_font_family'];

			$style .= $selector . "{";
			$style .= "font-family: {$font_family};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}	

		// Typography font size.
		if ( 
			isset( $meta['button_typography_font_size'] ) &&
			isset( $meta['button_typography_font_size']['unit'] ) &&
			isset( $meta['button_typography_font_size']['size'] )
		) {

			$font_unit = $meta['button_typography_font_size']['unit'];
			$font_size = $meta['button_typography_font_size']['size'];

			$style .= $selector . "{";
			$style .= "font-size: {$font_size}$font_unit;";
			$style .= "}";


			if ( 
				isset( $meta['button_typography_font_size_tablet'] ) &&
				isset( $meta['button_typography_font_size_tablet']['unit'] ) &&
				isset( $meta['button_typography_font_size_tablet']['size'] )
			) {
				$font_unit = $meta['button_typography_font_size_tablet']['unit'];
				$font_size = $meta['button_typography_font_size_tablet']['size'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector . "{";
				$style .= "font-size: {$font_size}$font_unit;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_typography_font_size_mobile'] ) &&
				isset( $meta['button_typography_font_size_mobile']['unit'] ) &&
				isset( $meta['button_typography_font_size_mobile']['size'] )
			) {
				$font_unit = $meta['button_typography_font_size_mobile']['unit'];
				$font_size = $meta['button_typography_font_size_mobile']['size'];

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector . "{";
				$style .= "font-size: {$font_size}$font_unit;";
				$style .= "}";
				$style .= "}";
			}			

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style Typography weight
		if ( isset( $meta['button_typography_font_weight'] ) ) {

			$button_font_weight = $meta['button_typography_font_weight'];

			$style .= $selector . "{";
			$style .= "font-weight: {$button_font_weight};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style Typography transform.
		if ( isset( $meta['button_typography_text_transform'] ) ) {

			$button_text_transform = $meta['button_typography_text_transform'];

			$style .= $selector . "{";
			$style .= "text-transform: {$button_text_transform};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style Typography style.
		if ( isset( $meta['button_typography_font_style'] ) ) {

			$button_font_style = $meta['button_typography_font_style'];

			$style .= $selector . "{";
			$style .= "font-style: {$button_font_style};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style Typography decoration.
		if ( isset( $meta['button_typography_text_decoration'] ) ) {

			$button_text_decoration = $meta['button_typography_text_decoration'];

			$style .= $selector . "{";
			$style .= "text-decoration: {$button_text_decoration};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}

		// Typography line height.
		if ( 
			isset( $meta['button_typography_line_height'] ) &&
			isset( $meta['button_typography_line_height']['unit'] ) &&
			isset( $meta['button_typography_line_height']['size'] )
		) {

			$unit = $meta['button_typography_line_height']['unit'];
			$line_height = $meta['button_typography_line_height']['size'];

			$style .= $selector . "{";
			$style .= "line-height: {$line_height}$unit;";
			$style .= "}";

			if ( 
				isset( $meta['button_typography_line_height_tablet'] ) &&
				isset( $meta['button_typography_line_height_tablet']['unit'] ) &&
				isset( $meta['button_typography_line_height_tablet']['size'] )
			) {
				$unit = $meta['button_typography_line_height_tablet']['unit'];
				$line_height = $meta['button_typography_line_height_tablet']['size'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector . "{";
				$style .= "line-height: {$line_height}$unit;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_typography_line_height_mobile'] ) &&
				isset( $meta['button_typography_line_height_mobile']['unit'] ) &&
				isset( $meta['button_typography_line_height_mobile']['size'] )
			) {
				$unit = $meta['button_typography_line_height_mobile']['unit'];
				$line_height = $meta['button_typography_line_height_mobile']['size'];

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector . "{";
				$style .= "line-height: {$line_height}$unit;";
				$style .= "}";
				$style .= "}";
			}			

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Typography letter spacing.
		if ( 
			isset( $meta['button_typography_letter_spacing'] ) &&
			isset( $meta['button_typography_letter_spacing']['unit'] ) &&
			isset( $meta['button_typography_letter_spacing']['size'] )
		) {

			$unit = $meta['button_typography_letter_spacing']['unit'];
			$letter_spacing = $meta['button_typography_letter_spacing']['size'];

			$style .= $selector . "{";
			$style .= "letter-spacing: {$letter_spacing}$unit;";
			$style .= "}";

			if ( 
				isset( $meta['button_typography_letter_spacing_tablet'] ) &&
				isset( $meta['button_typography_letter_spacing_tablet']['unit'] ) &&
				isset( $meta['button_typography_letter_spacing_tablet']['size'] )
			) {
				$unit = $meta['button_typography_letter_spacing_tablet']['unit'];
				$letter_spacing = $meta['button_typography_letter_spacing_tablet']['size'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector . "{";
				$style .= "letter-spacing: {$letter_spacing}$unit;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_typography_letter_spacing_mobile'] ) &&
				isset( $meta['button_typography_letter_spacing_mobile']['unit'] ) &&
				isset( $meta['button_typography_letter_spacing_mobile']['size'] )
			) {
				$unit = $meta['button_typography_letter_spacing_mobile']['unit'];
				$letter_spacing = $meta['button_typography_letter_spacing_mobile']['size'];

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector . "{";
				$style .= "letter-spacing: {$letter_spacing}$unit;";
				$style .= "}";
				$style .= "}";
			}			

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}				

		// Typography word spacing.
		if ( 
			isset( $meta['button_typography_word_spacing'] ) &&
			isset( $meta['button_typography_word_spacing']['unit'] ) &&
			isset( $meta['button_typography_word_spacing']['size'] )
		) {

			$unit = $meta['button_typography_word_spacing']['unit'];
			$word_spacing = $meta['button_typography_word_spacing']['size'];

			$style .= $selector . "{";
			$style .= "word-spacing: {$word_spacing}$unit;";
			$style .= "}";

			if ( 
				isset( $meta['button_typography_word_spacing_tablet'] ) &&
				isset( $meta['button_typography_word_spacing_tablet']['unit'] ) &&
				isset( $meta['button_typography_word_spacing_tablet']['size'] )
			) {
				$unit = $meta['button_typography_word_spacing_tablet']['unit'];
				$word_spacing = $meta['button_typography_word_spacing_tablet']['size'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector . "{";
				$style .= "word-spacing: {$word_spacing}$unit;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_typography_word_spacing_mobile'] ) &&
				isset( $meta['button_typography_word_spacing_mobile']['unit'] ) &&
				isset( $meta['button_typography_word_spacing_mobile']['size'] )
			) {
				$unit = $meta['button_typography_word_spacing_mobile']['unit'];
				$word_spacing = $meta['button_typography_word_spacing_mobile']['size'];

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector . "{";
				$style .= "word-spacing: {$word_spacing}$unit;";
				$style .= "}";
				$style .= "}";
			}			

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style button text shadow.
		if ( 
			isset( $meta['button_text_shadow_text_shadow_type'] ) && 
			isset( $meta['button_text_shadow_text_shadow'] )
		) {

			$text_shadow_horizontal = $meta['button_text_shadow_text_shadow']['horizontal'];
			$text_shadow_vertical = $meta['button_text_shadow_text_shadow']['vertical'];
			$text_shadow_blur = $meta['button_text_shadow_text_shadow']['blur'];
			$text_shadow_color = $meta['button_text_shadow_text_shadow']['color'];

			$style .= $selector . "{";
			$style .= "text-shadow: {$text_shadow_horizontal}px {$text_shadow_vertical}px {$text_shadow_blur}px {$text_shadow_color};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style button text color.
		if ( isset( $meta['button_text_color'] ) ) {

			$text_color = $meta['button_text_color'];

			$style .= $selector . "{";
			$style .= "color: {$text_color}";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}	

		// Style button hover text color.
		if ( isset( $meta['button_hover_text_color'] ) ) {

			$hover_text_color = $meta['button_hover_text_color'];
			$style .= $selector_hover . "{";
			$style .= "color: {$hover_text_color};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}	
	
		// Style button background color.
		if ( isset( $meta['button_background_color'] ) ) {

			$bg = $meta['button_background_color'];
			$style .= $selector . "{";
			$style .= "background: {$bg};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style button hover background color.
		if ( isset( $meta['button_hover_background_color'] ) ) {

			$bg = $meta['button_hover_background_color'];
			$style .= $selector_hover . "{";
			$style .= "background: {$bg};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}			

		// Style button border.
		if ( 
			isset( $meta['button_border_border'] ) && 
			isset( $meta['button_border_width']['unit'] ) && 
			isset( $meta['button_border_width']['top'] ) && 
			isset( $meta['button_border_width']['right'] ) && 
			isset( $meta['button_border_width']['bottom'] ) && 
			isset( $meta['button_border_width']['left'] ) &&
			isset( $meta['button_border_color'] ) 
		) {

			$button_border_border = $meta['button_border_border'];
			$button_border_border_unit = $meta['button_border_width']['unit'];
			$button_border_border_top = $meta['button_border_width']['top'];
			$button_border_border_right = $meta['button_border_width']['right'];
			$button_border_border_bottom = $meta['button_border_width']['bottom'];
			$button_border_border_left = $meta['button_border_width']['left'];
			$button_border_color = $meta['button_border_color'];

			$style .= $selector . "{";
			$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "}";

			if ( 
				isset( $meta['button_border_width_tablet']['unit'] ) && 
				isset( $meta['button_border_width_tablet']['top'] ) && 
				isset( $meta['button_border_width_tablet']['right'] ) && 
				isset( $meta['button_border_width_tablet']['bottom'] ) && 
				isset( $meta['button_border_width_tablet']['left'] )
			) {
				$button_border_border = $meta['button_border_border'];
				$button_border_border_unit = $meta['button_border_width_tablet']['unit'];
				$button_border_border_top = $meta['button_border_width_tablet']['top'];
				$button_border_border_right = $meta['button_border_width_tablet']['right'];
				$button_border_border_bottom = $meta['button_border_width_tablet']['bottom'];
				$button_border_border_left = $meta['button_border_width_tablet']['left'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector . "{";
				$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_border_width_mobile']['unit'] ) && 
				isset( $meta['button_border_width_mobile']['top'] ) && 
				isset( $meta['button_border_width_mobile']['right'] ) && 
				isset( $meta['button_border_width_mobile']['bottom'] ) && 
				isset( $meta['button_border_width_mobile']['left'] ) 
			) {
				$button_border_border = $meta['button_border_border'];
				$button_border_border_unit = $meta['button_border_width_mobile']['unit'];
				$button_border_border_top = $meta['button_border_width_mobile']['top'];
				$button_border_border_right = $meta['button_border_width_mobile']['right'];
				$button_border_border_bottom = $meta['button_border_width_mobile']['bottom'];
				$button_border_border_left = $meta['button_border_width_mobile']['left'];				

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector . "{";
				$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "}";
				$style .= "}";
			}

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}

		// Style button hover border.
		if ( 
			isset( $meta['button_hover_border_border'] ) && 
			isset( $meta['button_hover_border_width']['unit'] ) && 
			isset( $meta['button_hover_border_width']['top'] ) && 
			isset( $meta['button_hover_border_width']['right'] ) && 
			isset( $meta['button_hover_border_width']['bottom'] ) && 
			isset( $meta['button_hover_border_width']['left'] ) &&
			isset( $meta['button_hover_border_color'] ) 
		) {

			$button_border_border = $meta['button_hover_border_border'];
			$button_border_border_unit = $meta['button_hover_border_width']['unit'];
			$button_border_border_top = $meta['button_hover_border_width']['top'];
			$button_border_border_right = $meta['button_hover_border_width']['right'];
			$button_border_border_bottom = $meta['button_hover_border_width']['bottom'];
			$button_border_border_left = $meta['button_hover_border_width']['left'];
			$button_border_color = $meta['button_hover_border_color'];

			$style .= $selector_hover . "{";
			$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
			$style .= "}";

			if ( 
				isset( $meta['button_hover_border_width_tablet']['unit'] ) && 
				isset( $meta['button_hover_border_width_tablet']['top'] ) && 
				isset( $meta['button_hover_border_width_tablet']['right'] ) && 
				isset( $meta['button_hover_border_width_tablet']['bottom'] ) && 
				isset( $meta['button_hover_border_width_tablet']['left'] )
			) {
				$button_border_border = $meta['button_hover_border_border'];
				$button_border_border_unit = $meta['button_hover_border_width_tablet']['unit'];
				$button_border_border_top = $meta['button_hover_border_width_tablet']['top'];
				$button_border_border_right = $meta['button_hover_border_width_tablet']['right'];
				$button_border_border_bottom = $meta['button_hover_border_width_tablet']['bottom'];
				$button_border_border_left = $meta['button_hover_border_width_tablet']['left'];

				$style .= "@media only screen and (max-width: 1024px) {";
				$style .= $selector_hover . "{";
				$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "}";
				$style .= "}";
			}

			if ( 
				isset( $meta['button_hover_border_width_mobile']['unit'] ) && 
				isset( $meta['button_hover_border_width_mobile']['top'] ) && 
				isset( $meta['button_hover_border_width_mobile']['right'] ) && 
				isset( $meta['button_hover_border_width_mobile']['bottom'] ) && 
				isset( $meta['button_hover_border_width_mobile']['left'] ) 
			) {
				$button_border_border = $meta['button_hover_border_border'];
				$button_border_border_unit = $meta['button_hover_border_width_mobile']['unit'];
				$button_border_border_top = $meta['button_hover_border_width_mobile']['top'];
				$button_border_border_right = $meta['button_hover_border_width_mobile']['right'];
				$button_border_border_bottom = $meta['button_hover_border_width_mobile']['bottom'];
				$button_border_border_left = $meta['button_hover_border_width_mobile']['left'];				

				$style .= "@media only screen and (max-width: 767px) {";
				$style .= $selector_hover . "{";
				$style .= "border-top: {$button_border_border_top}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-right: {$button_border_border_right}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-bottom: {$button_border_border_bottom}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "border-left: {$button_border_border_left}{$button_border_border_unit} {$button_border_border} $button_border_color;";
				$style .= "}";
				$style .= "}";
			}

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style button border radius.
		if ( 
			isset( $meta['button_border_radius'] ) && 
			isset( $meta['button_border_radius']['unit'] ) && 
			isset( $meta['button_border_radius']['top'] ) && 
			isset( $meta['button_border_radius']['right'] ) && 
			isset( $meta['button_border_radius']['bottom'] ) && 
			isset( $meta['button_border_radius']['left'] ) 
		) {

			$border_radius_unit = $meta['button_border_radius']['unit'];
			$border_radius_top = $meta['button_border_radius']['top'];
			$border_radius_right = $meta['button_border_radius']['right'];
			$border_radius_bottom = $meta['button_border_radius']['bottom'];
			$border_radius_left = $meta['button_border_radius']['left'];

			$style .= $selector . "{";
			$style .= "border-top-left-radius: {$border_radius_top}{$border_radius_unit};";
			$style .= "border-top-right-radius: {$border_radius_right}{$border_radius_unit};";
			$style .= "border-bottom-right-radius: {$border_radius_bottom}{$border_radius_unit};";
			$style .= "border-bottom-left-radius: {$border_radius_left}{$border_radius_unit};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}

		// Style button hover border radius.
		if ( 
			isset( $meta['button_hover_border_radius'] ) && 
			isset( $meta['button_hover_border_radius']['unit'] ) && 
			isset( $meta['button_hover_border_radius']['top'] ) && 
			isset( $meta['button_hover_border_radius']['right'] ) && 
			isset( $meta['button_hover_border_radius']['bottom'] ) && 
			isset( $meta['button_hover_border_radius']['left'] ) 
		) {

			$border_radius_unit = $meta['button_hover_border_radius']['unit'];
			$border_radius_top = $meta['button_hover_border_radius']['top'];
			$border_radius_right = $meta['button_hover_border_radius']['right'];
			$border_radius_bottom = $meta['button_hover_border_radius']['bottom'];
			$border_radius_left = $meta['button_hover_border_radius']['left'];

			$style .= $selector_hover . "{";
			$style .= "border-top-left-radius: {$border_radius_top}{$border_radius_unit};";
			$style .= "border-top-right-radius: {$border_radius_right}{$border_radius_unit};";
			$style .= "border-bottom-right-radius: {$border_radius_bottom}{$border_radius_unit};";
			$style .= "border-bottom-left-radius: {$border_radius_left}{$border_radius_unit};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}

		// Style button padding.
		if ( 
			isset( $meta['button_padding'] ) &&
			isset( $meta['button_padding']['unit'] ) &&
			isset( $meta['button_padding']['top'] ) &&
			isset( $meta['button_padding']['right'] ) &&
			isset( $meta['button_padding']['bottom'] ) &&
			isset( $meta['button_padding']['left'] ) &&
			isset( $meta['button_padding']['isLinked'] )
		) {

			$button_unit = $meta['button_padding']['unit'];
			$button_top = $meta['button_padding']['top'];
			$button_right = $meta['button_padding']['right'];
			$button_bottom = $meta['button_padding']['bottom'];
			$button_left = $meta['button_padding']['left'];
			$button_is_linked = $meta['button_padding']['isLinked'];

			$style .= $selector . "{";
			$style .= "padding-top: {$button_top}{$button_unit};";
			$style .= "padding-right: {$button_right}{$button_unit};";
			$style .= "padding-bottom: {$button_bottom}{$button_unit};";
			$style .= "padding-left: {$button_left}{$button_unit};";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}

		// Style button padding tablet.
		if ( 
			isset( $meta['button_padding_tablet'] ) &&
			isset( $meta['button_padding_tablet']['unit'] ) &&
			isset( $meta['button_padding_tablet']['top'] ) &&
			isset( $meta['button_padding_tablet']['right'] ) &&
			isset( $meta['button_padding_tablet']['bottom'] ) &&
			isset( $meta['button_padding_tablet']['left'] ) &&
			isset( $meta['button_padding_tablet']['isLinked'] )
		) {

			$button_unit = $meta['button_padding_tablet']['unit'];
			$button_top = $meta['button_padding_tablet']['top'];
			$button_right = $meta['button_padding_tablet']['right'];
			$button_bottom = $meta['button_padding_tablet']['bottom'];
			$button_left = $meta['button_padding_tablet']['left'];
			$button_is_linked = $meta['button_padding_tablet']['isLinked'];

			$style .= "@media only screen and (max-width: 1024px) {";
			$style .= $selector . "{";
			$style .= "padding-top: {$button_top}{$button_unit};";
			$style .= "padding-right: {$button_right}{$button_unit};";
			$style .= "padding-bottom: {$button_bottom}{$button_unit};";
			$style .= "padding-left: {$button_left}{$button_unit};";
			$style .= "}";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}
	
		// Style button padding mobile.
		if ( 
			isset( $meta['button_padding_mobile'] ) &&
			isset( $meta['button_padding_mobile']['unit'] ) &&
			isset( $meta['button_padding_mobile']['top'] ) &&
			isset( $meta['button_padding_mobile']['right'] ) &&
			isset( $meta['button_padding_mobile']['bottom'] ) &&
			isset( $meta['button_padding_mobile']['left'] ) &&
			isset( $meta['button_padding_mobile']['isLinked'] )
		) {

			$button_unit = $meta['button_padding_mobile']['unit'];
			$button_top = $meta['button_padding_mobile']['top'];
			$button_right = $meta['button_padding_mobile']['right'];
			$button_bottom = $meta['button_padding_mobile']['bottom'];
			$button_left = $meta['button_padding_mobile']['left'];
			$button_is_linked = $meta['button_padding_mobile']['isLinked'];

			$style .= "@media only screen and (max-width: 767px) {";
			$style .= $selector . "{";
			$style .= "padding-top: {$button_top}{$button_unit};";
			$style .= "padding-right: {$button_right}{$button_unit};";
			$style .= "padding-bottom: {$button_bottom}{$button_unit};";
			$style .= "padding-left: {$button_left}{$button_unit};";
			$style .= "}";
			$style .= "}";

			// Add the inline style to the 'solace-theme'.
			wp_add_inline_style( 'solace-theme', $style );
		}		

		// Style button color.
		if ( isset( $meta['__globals__']['button_text_color'] ) ) {
			$button_text_color = $meta['__globals__']['button_text_color'];
			$button_text_color = str_replace( 'globals/colors?id=', '', $button_text_color );

			// Display the color value if the target ID was found, otherwise show a not found message.
			if ($button_text_color) {
				// Pattern to match selectors to remove
				$pattern = '/\.builder-item--button_base(2|3|4)? \.button,? ?/';

				// Remove matched selectors
				$without_item_button_base = preg_replace($pattern, '', $selector);				

				$style .= $without_item_button_base . "{";
					$style .= "color: var(--e-global-color-$button_text_color) !important;";
					$style .= "fill: var(--e-global-color-$button_text_color) !important;";
				$style .= "}";

				// Add the inline style to the 'solace-theme'.
				wp_add_inline_style( 'solace-theme', $style );				
			}
		}		

		// Style button hover color.
		if ( isset( $meta['__globals__']['button_hover_text_color'] ) ) {
			$button_hover_text_color = $meta['__globals__']['button_hover_text_color'];
			$button_hover_text_color = str_replace( 'globals/colors?id=', '', $button_hover_text_color );

			// Display the color value if the target ID was found, otherwise show a not found message.
			if ($button_hover_text_color) {

				// Pattern to match selectors to remove
				$pattern = '/\.builder-item--button_base(2|3|4)? \.button(:hover)?,? ?/';

				// Remove matched selectors
				$without_item_button_base = preg_replace($pattern, '', $selector_hover);				

				$style .= $without_item_button_base . "{";
					$style .= "color: var(--e-global-color-$button_hover_text_color) !important;";
					$style .= "fill: var(--e-global-color-$button_hover_text_color) !important;";
				$style .= "}";

				// Add the inline style to the 'solace-theme'.
				wp_add_inline_style( 'solace-theme', $style );				
			}
		}		

		// Style button background.
		if ( isset( $meta['__globals__']['button_background_color'] ) ) {
			$button_background_color = $meta['__globals__']['button_background_color'];
			$button_background_color = str_replace( 'globals/colors?id=', '', $button_background_color );

			// Display the color value if the target ID was found, otherwise show a not found message.
			if ($button_background_color) {
				// Pattern to match selectors to remove
				$pattern = '/\.builder-item--button_base(2|3|4)? \.button,? ?/';

				// Remove matched selectors
				$without_item_button_base = preg_replace($pattern, '', $selector);

				$style .= $without_item_button_base . "{";
					$style .= "background: var(--e-global-color-$button_background_color) !important;";
				$style .= "}";

				// Add the inline style to the 'solace-theme'.
				wp_add_inline_style( 'solace-theme', $style );				
			}
		}
	
		// Style button hover background.
		if ( isset( $meta['__globals__']['button_hover_background_color'] ) ) {
			$button_hover_background_color = $meta['__globals__']['button_hover_background_color'];
			$button_hover_background_color = str_replace( 'globals/colors?id=', '', $button_hover_background_color );

			// Display the color value if the target ID was found, otherwise show a not found message.
			if ($button_hover_background_color) {

				// Pattern to match selectors to remove
				$pattern = '/\.builder-item--button_base(2|3|4)? \.button(:hover)?,? ?/';

				// Remove matched selectors
				$without_item_button_base = preg_replace($pattern, '', $selector_hover);	
				
				$style .= $without_item_button_base . "{";
					$style .= "background: var(--e-global-color-$button_hover_background_color) !important;";
				$style .= "}";

				// Add the inline style to the 'solace-theme'.
				wp_add_inline_style( 'solace-theme', $style );				
			}
		}
	}

    // Fix button site settings global to partial edit customizer.
    $style = "
        body.customize-partial-edit-shortcuts-shown span.customize-partial-edit-shortcut button.customize-partial-edit-shortcut-button {
            box-shadow: unset;
            border-radius: 100%;
            border: none;
            padding: 0;
        }
    ";

    // Add the inline style to the 'solace-theme'.
    wp_add_inline_style( 'solace-theme', $style );
}
// add_action('wp_enqueue_scripts', 'solace_apply_elementor_button_styles');


/**
 * Apply Elementor button styles.
 */
function solace_apply_elementor_woocommerce_button_styles() {

    // If plugin elementor deactive.
    if ( ! class_exists( 'Elementor\Plugin' ) ) {
        return;
    }

	// Retrieve the Elementor page settings meta data.
	$current_settings = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$meta = $current_settings;
	// error_log('<pre>');
	// error_log(print_r($meta, true));
	// error_log('</pre>');

	$body_classes = get_body_class();

	if (in_array('dokan-store', $body_classes) || in_array('dokan-dashboard', $body_classes)) {
		$meta = false;
	} 

	if ( $meta ) {
		$style = '';
		
		// Style button text color.
		if ( isset( $meta['button_text_color'] )  && !empty( $meta['button_text_color']) ) {

			$text_color = $meta['button_text_color'];

			$style .= ":root {";
			$style .= "--solel-color-button-text: {$text_color};";
			$style .= "}";

			$style .= SELECTOR_WC_BUTTON_TEXT . " {";
			$style .= "color: var(--solel-color-button-text);";
			$style .= "}";

			// wp_add_inline_style( 'solace-theme', $style );
		} else {
			$style .= SELECTOR_WC_BUTTON_TEXT . "{";
			$style .= "color: var(--sol-color-page-title-text);";
			$style .= "}";
			// wp_add_inline_style( 'solace-theme', $style );
		}
		// Style button hover text color.
		if ( isset( $meta['button_hover_text_color'] )  && !empty( $meta['button_hover_text_color']) ) {

			$hover_text_color = $meta['button_hover_text_color'];
			$style .= ":root {";
			$style .= "--solel-color-button-text-hover: {$hover_text_color};";
			$style .= "}";
			$style .= SELECTOR_WC_BUTTON_TEXT_HOVER . "{";
			$style .= "color: var(--solel-color-button-text-hover);";
			$style .= "}";
			// Add the inline style to the 'solace-theme'.
			// wp_add_inline_style( 'solace-theme', $style );
		}	
		// Style button background color.
		if ( isset( $meta['__globals__']['button_background_color'] )  && !empty( $meta['__globals__']['button_background_color']) ) {
			$button_background_color = $meta['__globals__']['button_background_color'];
			$button_background_color = str_replace( 'globals/colors?id=', '', $button_background_color );
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "background-color: var(--e-global-color-$button_background_color);";
			$style .= "}";
		} else { 
			$bg = $meta['button_background_color'];
			$style .= ":root {";
			$style .= "--solel-color-button-initial: {$bg};";
			$style .= "}";
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "background: var(--solel-color-button-initial);";
			$style .= "}";

			// wp_add_inline_style( 'solace-theme', $style );
		} 
		
		// Style button hover background color.
		if ( isset( $meta['button_hover_background_color'] ) && !empty( $meta['button_hover_background_color']) ) {

			$bg = $meta['button_hover_background_color'];
			$style .= ":root {";
			$style .= "--solel-color-button-hover: {$bg};";
			$style .= "}";
			$style .= SELECTOR_WC_BUTTON_BG_HOVER . "{";
			$style .= "background: var(--solel-color-button-hover);";
			$style .= "}";

			// wp_add_inline_style( 'solace-theme', $style );
		} else {
			$style .= SELECTOR_WC_BUTTON_BG_HOVER . "{";
			$style .= "background: var(--sol-color-button-hover);";
			$style .= "}";
			// wp_add_inline_style( 'solace-theme', $style );
		}

		// BORDER RADIUS FROM ELEMENTOR BUTTON

		if ( isset( $meta['button_border_radius'] ) && !empty( $meta['button_border_radius']) ) {
			$unit 	= $meta['button_border_radius']['unit'];
			$top 	= $meta['button_border_radius']['top'];
			$right 	= $meta['button_border_radius']['right'];
			$bottom = $meta['button_border_radius']['bottom'];
			$left 	= $meta['button_border_radius']['left'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "border-radius: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_radius'] ) && !empty( $meta['button_hover_border_radius']) ) {
			$unit 	= $meta['button_hover_border_radius']['unit'];
			$top 	= $meta['button_hover_border_radius']['top'];
			$right 	= $meta['button_hover_border_radius']['right'];
			$bottom = $meta['button_hover_border_radius']['bottom'];
			$left 	= $meta['button_hover_border_radius']['left'];
			$style .= SELECTOR_WC_BUTTON_BG_HOVER . "{";
			$style .= "border-radius: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		

		// PADDING FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_padding'] ) && !empty( $meta['button_padding']) ) {
			$unit 	= $meta['button_padding']['unit'];
			$top 	= $meta['button_padding']['top'];
			$right 	= $meta['button_padding']['right'];
			$bottom = $meta['button_padding']['bottom'];
			$left 	= $meta['button_padding']['left'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "padding: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		}else {
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "padding: 12px 24px;";
			$style .= "}";
			$style .= ".wc-block-components-totals-coupon__button span.wc-block-components-button__text{";
			$style .= "padding: 0";
			$style .= "}";
		}

		// BORDER FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_width'] ) && !empty( $meta['button_border_width']) ) {
			$unit 	= $meta['button_border_width']['unit'];
			$top 	= $meta['button_border_width']['top'];
			$right 	= $meta['button_border_width']['right'];
			$bottom = $meta['button_border_width']['bottom'];
			$left 	= $meta['button_border_width']['left'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "border-width: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_width'] ) && !empty( $meta['button_hover_border_width']) ) {
			$unit 	= $meta['button_hover_border_width']['unit'];
			$top 	= $meta['button_hover_border_width']['top'];
			$right 	= $meta['button_hover_border_width']['right'];
			$bottom = $meta['button_hover_border_width']['bottom'];
			$left 	= $meta['button_hover_border_width']['left'];
			$style .= SELECTOR_WC_BUTTON_BG_HOVER . "{";
			$style .= "border-width: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		

		// BORDER COLOR FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_color'] ) && !empty( $meta['button_border_color']) ) {
			$color 	= $meta['button_border_color'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "border-color: {$color};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_color'] ) && !empty( $meta['button_hover_border_color']) ) {
			$color 	= $meta['button_hover_border_color'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "border-color: {$color};";
			$style .= "}";
		} 		

		// BORDER STYLE FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_border'] ) && !empty( $meta['button_border_border']) ) {
			$type 	= $meta['button_border_border'];
			$style .= SELECTOR_WC_BUTTON_BG . "{";
			$style .= "border-style: {$type};";
			$style .= "}";
		}
		if ( isset( $meta['button_hover_border_border'] ) && !empty( $meta['button_hover_border_border']) ) {
			$type 	= $meta['button_hover_border_border'];
			$style .= SELECTOR_WC_BUTTON_BG_HOVER . "{";
			$style .= "border-style: {$type};";
		}

		$gaya = '';
		// TYPOGRAPHY FROM ELEMENTOR BUTTON
		if ( isset( $meta['__globals__']['button_typography_typography'] ) && !empty( $meta['__globals__']['button_typography_typography']) ) {
			$button_typography = $meta['__globals__']['button_typography_typography'];
			$typography_id = str_replace('globals/typography?id=', '', $button_typography);
			
			$global_typography = null;

			if (isset($current_settings['system_typography']) && is_array($current_settings['system_typography'])) {

				foreach ($current_settings['system_typography'] as $typography) {
					if (isset($typography['_id']) && $typography['_id'] === $typography_id) {
						$global_typography = $typography;
						break;
					}
				}
				$gaya .= SELECTOR_WC_BUTTON_TEXT . " {";
			
				// Font Family
				if ( isset( $global_typography['typography_font_family'] ) ) {
					$gaya .= "font-family: '{$global_typography['typography_font_family']}';";
				}

				// Font Size (Desktop)
				if ( isset( $global_typography['typography_font_size']['size'] ) ) {
					$unit = isset( $global_typography['typography_font_size']['unit'] ) ? $global_typography['typography_font_size']['unit'] : 'px';
					$gaya .= "font-size: {$global_typography['typography_font_size']['size']}{$unit};";
				}

				// Font Weight
				if ( isset( $global_typography['typography_font_weight'] ) ) {
					$gaya .= "font-weight: {$global_typography['typography_font_weight']};";
				}

				// Line Height (Desktop)
				if ( isset( $global_typography['typography_line_height']['size'] ) ) {
					$unit = isset( $global_typography['typography_line_height']['unit'] ) ? $global_typography['typography_line_height']['unit'] : 'em';
					$gaya .= "line-height: {$global_typography['typography_line_height']['size']}{$unit};";
				}

				$gaya .= "}";
			} 

		} else {

			$gaya .= SELECTOR_WC_BUTTON_TEXT . " {";

			// Font Family
			if ( isset( $meta['button_typography_font_family'] ) ) {
				$gaya .= "font-family: '{$meta['button_typography_font_family']}';";
			}

			// Font Size (Desktop)
			if ( isset( $meta['button_typography_font_size']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size']['unit'] ) ? $meta['button_typography_font_size']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size']['size']}{$unit};";
			}

			// Font Weight
			if ( isset( $meta['button_typography_font_weight'] ) ) {
				$gaya .= "font-weight: {$meta['button_typography_font_weight']};";
			}

			// Font Style
			if ( isset( $meta['button_typography_font_style'] ) ) {
				$gaya .= "font-style: {$meta['button_typography_font_style']};";
			}

			// Font Transform
			if ( isset( $meta['button_typography_text_transform'] ) ) {
				$gaya .= "text-transform: {$meta['button_typography_text_transform']};";
			}

			// Font Decoration
			if ( isset( $meta['button_typography_text_decoration'] ) ) {
				$gaya .= "text-decoration: {$meta['button_typography_text_decoration']};";
			}

			// Line Height (Desktop)
			if ( isset( $meta['button_typography_line_height']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height']['unit'] ) ? $meta['button_typography_line_height']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height']['size']}{$unit};";
			}

			// Letter Spacing (Desktop)
			if ( isset( $meta['button_typography_letter_spacing']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing']['unit'] ) ? $meta['button_typography_letter_spacing']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing']['size']}{$unit};";
			}

			// Word Spacing (Desktop)
			if ( isset( $meta['button_typography_word_spacing']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing']['unit'] ) ? $meta['button_typography_word_spacing']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing']['size']}{$unit};";
			}

			$gaya .= "}";

		} 

		// Tablet style
		if ( isset( $meta['button_typography_font_size_tablet']['size'] ) || isset( $meta['button_typography_line_height_tablet']['size'] ) ) {
			$gaya .= "@media (max-width: 1024px) {";
			$gaya .= SELECTOR_WC_BUTTON_TEXT . " {";

			// Font Size (Tablet)
			if ( isset( $meta['button_typography_font_size_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size_tablet']['unit'] ) ? $meta['button_typography_font_size_tablet']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size_tablet']['size']}{$unit};";
			}

			// Line Height (Tablet)
			if ( isset( $meta['button_typography_line_height_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height_tablet']['unit'] ) ? $meta['button_typography_line_height_tablet']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height_tablet']['size']}{$unit};";
			}

			// Letter Spacing (Tablet)
			if ( isset( $meta['button_typography_letter_spacing_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing_tablet']['unit'] ) ? $meta['button_typography_letter_spacing_tablet']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing_tablet']['size']}{$unit};";
			}

			// Word Spacing (Tablet)
			if ( isset( $meta['button_typography_word_spacing_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing_tablet']['unit'] ) ? $meta['button_typography_word_spacing_tablet']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing_tablet']['size']}{$unit};";
			}

			$gaya .= "}";
			$gaya .= "}";
		}

		// Mobile gayas
		if ( isset( $meta['button_typography_font_size_mobile']['size'] ) || isset( $meta['button_typography_line_height_mobile']['size'] ) ) {
			$gaya .= "@media (max-width: 768px) {";
			$gaya .= SELECTOR_WC_BUTTON_TEXT . " {";

			// Font Size (Mobile)
			if ( isset( $meta['button_typography_font_size_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size_mobile']['unit'] ) ? $meta['button_typography_font_size_mobile']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size_mobile']['size']}{$unit};";
			}

			// Line Height (Mobile)
			if ( isset( $meta['button_typography_line_height_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height_mobile']['unit'] ) ? $meta['button_typography_line_height_mobile']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height_mobile']['size']}{$unit};";
			}

			// Letter Spacing (Mobile)
			if ( isset( $meta['button_typography_letter_spacing_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing_mobile']['unit'] ) ? $meta['button_typography_letter_spacing_mobile']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing_mobile']['size']}{$unit};";
			}

			// Word Spacing (Mobile)
			if ( isset( $meta['button_typography_word_spacing_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing_mobile']['unit'] ) ? $meta['button_typography_word_spacing_mobile']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing_mobile']['size']}{$unit};";
			}

			$gaya .= "}";
			$gaya .= "}";
		}

		// Shadow Effects (Text Shadow)
		if ( isset( $meta['button_text_shadow_text_shadow_type'] ) && $meta['button_text_shadow_text_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_text_shadow_text_shadow'] ) ) {
				$shadow = $meta['button_text_shadow_text_shadow'];
				$gaya .= SELECTOR_WC_BUTTON_TEXT . " {";
				$gaya .= "text-shadow: {$shadow['horizontal']}px {$shadow['vertical']}px {$shadow['blur']}px {$shadow['color']};";
				$gaya .= "}";
			}
		}
		
		// Shadow Effects (Box Shadow)
		if ( isset( $meta['button_box_shadow_box_shadow_type'] ) && $meta['button_box_shadow_box_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_box_shadow_box_shadow'] ) ) {
				$box_shadow = $meta['button_box_shadow_box_shadow'];
				$box_shadow_position = isset( $meta['button_box_shadow_box_shadow_position'] ) ? $meta['button_box_shadow_box_shadow_position'] : '';
				$gaya .= SELECTOR_WC_BUTTON_BG . " {";
				$gaya .= "box-shadow: {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				if ( $box_shadow_position === 'inset' ) {
					$gaya .= "box-shadow: inset {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				}
				$gaya .= "}";
			}
		}

		if ( isset( $meta['button_hover_box_shadow_box_shadow_type'] ) && $meta['button_hover_box_shadow_box_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_hover_box_shadow_box_shadow'] ) ) {
				$box_shadow = $meta['button_hover_box_shadow_box_shadow'];
				$box_shadow_position = isset( $meta['button_hover_box_shadow_box_shadow_position'] ) ? $meta['button_hover_box_shadow_box_shadow_position'] : '';
				$gaya .= SELECTOR_WC_BUTTON_BG_HOVER . " {";
				$gaya .= "box-shadow: {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				if ( $box_shadow_position === 'inset' ) {
					$gaya .= "box-shadow: inset {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				}
				$gaya .= "}";
			}
		}
		
		wp_add_inline_style( 'solace-elementor-woocommerce', $gaya );
		wp_add_inline_style( 'solace-elementor-woocommerce-default', $style );
		
	}
}

function solace_apply_customizer_woocommerce_button_styles() {
	$style = "";

	// SET BUTTON FONT WITH GENERAL OPTIONS BUTTON
	$style .= SELECTOR_WC_BUTTON_TEXT . " {";
	$style .= "font-family: var(--buttonfontfamily);}";
	
	// Button Background Selector
	$button_bg_styles = "";
	$solace_wc_custom_general_buttons_bg_color = get_theme_mod('solace_wc_custom_general_buttons_bg_color', 'var(--sol-color-link-button-initial)');
	if (!empty($solace_wc_custom_general_buttons_bg_color)) {
		$button_bg_styles .= "background-color: {$solace_wc_custom_general_buttons_bg_color};";
	}
	$solace_wc_custom_general_buttons_border_style = get_theme_mod('solace_wc_custom_general_buttons_border_style', 'none');
	if (!empty($solace_wc_custom_general_buttons_border_style)) {
		$button_bg_styles .= "border-style: {$solace_wc_custom_general_buttons_border_style};";
	}
	// $solace_wc_custom_general_buttons_border_width = get_theme_mod('solace_wc_custom_general_buttons_border_width', '2');
	// if (!empty($solace_wc_custom_general_buttons_border_width)) {
	// 	$button_bg_styles .= "border-width: {$solace_wc_custom_general_buttons_border_width}px;";
	// }
	$solace_wc_custom_general_buttons_border_color = get_theme_mod('solace_wc_custom_general_buttons_border_color', '#ffffff');
	if (!empty($solace_wc_custom_general_buttons_border_color)) {
		$button_bg_styles .= "border-color: {$solace_wc_custom_general_buttons_border_color};";
	}
	if (!empty($button_bg_styles)) {
		$style .= SELECTOR_WC_BUTTON_BG . " {" . $button_bg_styles . "}";
	}

	// Button Background Hover Selector
	$button_bg_hover_styles = "";
	$solace_wc_custom_general_buttons_bg_color_hover = get_theme_mod('solace_wc_custom_general_buttons_bg_color_hover', 'var(--sol-color-link-button-initial)');
	if (!empty($solace_wc_custom_general_buttons_bg_color_hover)) {
		$button_bg_hover_styles .= "background-color: {$solace_wc_custom_general_buttons_bg_color_hover};";
	}
	$solace_wc_custom_general_buttons_border_color_hover = get_theme_mod('solace_wc_custom_general_buttons_border_color_hover', '#000');
	if (!empty($solace_wc_custom_general_buttons_border_color_hover)) {
		$button_bg_hover_styles .= "border-color: {$solace_wc_custom_general_buttons_border_color_hover};";
	}
	if (!empty($button_bg_hover_styles)) {
		$style .= SELECTOR_WC_BUTTON_BG_HOVER . " {" . $button_bg_hover_styles . "}";
	}

	// Button Text Selector
	$button_text_styles = "";
	$solace_wc_custom_general_buttons_text_color = get_theme_mod('solace_wc_custom_general_buttons_text_color', '#ffffff');
	if (!empty($solace_wc_custom_general_buttons_text_color)) {
		$button_text_styles .= "color: {$solace_wc_custom_general_buttons_text_color};";
	}
	if (!empty($button_text_styles)) {
		$style .= SELECTOR_WC_BUTTON_TEXT . " {" . $button_text_styles . "}";
	}

	// Button Text Hover Selector
	$button_text_hover_styles = "";
	$solace_wc_custom_general_buttons_text_color_hover = get_theme_mod('solace_wc_custom_general_buttons_text_color_hover', '#ffffff');
	if (!empty($solace_wc_custom_general_buttons_text_color_hover)) {
		$button_text_hover_styles .= "color: {$solace_wc_custom_general_buttons_text_color_hover};";
	}
	if (!empty($button_text_hover_styles)) {
		$style .= SELECTOR_WC_BUTTON_TEXT_HOVER . " {" . $button_text_hover_styles . "}";
	}

	// Apply styles
	wp_add_inline_style('solace-customizer-woocommerce', $style);


	$border_width_data = get_theme_mod('solace_wc_custom_general_buttons_border_width', '2');

	if (!empty($border_width_data) && is_array($border_width_data)) {

		// Desktop styles
		$desktop_border_width = isset($border_width_data['desktop']) ? $border_width_data['desktop'] : 1;
		$desktop_unit = isset($border_width_data['desktop-unit']) ? $border_width_data['desktop-unit'] : 'px';
		$desktop_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_border_width['top'] ?? '1', $desktop_unit,
			$desktop_border_width['right'] ?? '1', $desktop_unit,
			$desktop_border_width['bottom'] ?? '1', $desktop_unit,
			$desktop_border_width['left'] ?? '1', $desktop_unit
		);

		// Tablet styles
		$tablet_border_width = isset($border_width_data['tablet']) ? $border_width_data['tablet'] : [];
		$tablet_unit = isset($border_width_data['tablet-unit']) ? $border_width_data['tablet-unit'] : 'px';
		$tablet_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_border_width['top'] ?? '1', $tablet_unit,
			$tablet_border_width['right'] ?? '1', $tablet_unit,
			$tablet_border_width['bottom'] ?? '1', $tablet_unit,
			$tablet_border_width['left'] ?? '1', $tablet_unit
		);

		// Mobile styles
		$mobile_border_width = isset($border_width_data['mobile']) ? $border_width_data['mobile'] : [];
		$mobile_unit = isset($border_width_data['mobile-unit']) ? $border_width_data['mobile-unit'] : 'px';
		$mobile_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_border_width['top'] ?? '1', $mobile_unit,
			$mobile_border_width['right'] ?? '1', $mobile_unit,
			$mobile_border_width['bottom'] ?? '1', $mobile_unit,
			$mobile_border_width['left'] ?? '1', $mobile_unit
		);

		// Generate CSS
		$style = "";

		// Apply desktop styles
		if (!empty($desktop_border_width_value)) {
			$style .= "
				@media (min-width: 1025px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-width: {$desktop_border_width_value};
					}
				}
			";
		}

		// Apply tablet styles
		if (!empty($tablet_border_width_value)) {
			$style .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-width: {$tablet_border_width_value};
					}
				}
			";
		}

		// Apply mobile styles
		if (!empty($mobile_border_width_value)) {
			$style .= "
				@media (max-width: 767px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-width: {$mobile_border_width_value};
					}
				}
			";
		}

		// Apply the custom styles
		wp_add_inline_style('solace-customizer-woocommerce', $style);
	}


	$border_radius_data = get_theme_mod('solace_wc_custom_general_buttons_border_radius');

	if (!empty($border_radius_data) && is_array($border_radius_data)) {
		// Desktop styles
		$desktop_radius = isset($border_radius_data['desktop']) ? $border_radius_data['desktop'] : [];
		$desktop_unit = isset($border_radius_data['desktop-unit']) ? $border_radius_data['desktop-unit'] : 'px';
		$desktop_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_radius['top'] ?? '0', $desktop_unit,
			$desktop_radius['right'] ?? '0', $desktop_unit,
			$desktop_radius['bottom'] ?? '0', $desktop_unit,
			$desktop_radius['left'] ?? '0', $desktop_unit
		);
	
		// Tablet styles
		$tablet_radius = isset($border_radius_data['tablet']) ? $border_radius_data['tablet'] : [];
		$tablet_unit = isset($border_radius_data['tablet-unit']) ? $border_radius_data['tablet-unit'] : 'px';
		$tablet_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_radius['top'] ?? '0', $tablet_unit,
			$tablet_radius['right'] ?? '0', $tablet_unit,
			$tablet_radius['bottom'] ?? '0', $tablet_unit,
			$tablet_radius['left'] ?? '0', $tablet_unit
		);
	
		// Mobile styles
		$mobile_radius = isset($border_radius_data['mobile']) ? $border_radius_data['mobile'] : [];
		$mobile_unit = isset($border_radius_data['mobile-unit']) ? $border_radius_data['mobile-unit'] : 'px';
		$mobile_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_radius['top'] ?? '0', $mobile_unit,
			$mobile_radius['right'] ?? '0', $mobile_unit,
			$mobile_radius['bottom'] ?? '0', $mobile_unit,
			$mobile_radius['left'] ?? '0', $mobile_unit
		);
	
		// Generate CSS
		$style = "";
		if (!empty($desktop_border_radius)) {
			$style .= "
				@media (min-width: 1025px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-radius: {$desktop_border_radius};
					}
				}
			";
		}
		if (!empty($tablet_border_radius)) {
			$style .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-radius: {$tablet_border_radius};
					}
				}
			";
		}
		if (!empty($mobile_border_radius)) {
			$style .= "
				@media (max-width: 767px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						border-radius: {$mobile_border_radius};
					}
				}
			";
		}
	
		wp_add_inline_style('solace-customizer-woocommerce', $style);
	}
	$padding_data = get_theme_mod('solace_wc_custom_general_buttons_padding');

	if (!empty($padding_data) && is_array($padding_data)) {
		// error_log('masuk button padding');
		// Desktop styles
		$desktop_padding = isset($padding_data['desktop']) ? $padding_data['desktop'] : [];
		$desktop_unit = isset($padding_data['desktop-unit']) ? $padding_data['desktop-unit'] : 'px';
		$desktop_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_padding['top'] ?? '0', $desktop_unit,
			$desktop_padding['right'] ?? '0', $desktop_unit,
			$desktop_padding['bottom'] ?? '0', $desktop_unit,
			$desktop_padding['left'] ?? '0', $desktop_unit
		);

		// Tablet styles
		$tablet_padding = isset($padding_data['tablet']) ? $padding_data['tablet'] : [];
		$tablet_unit = isset($padding_data['tablet-unit']) ? $padding_data['tablet-unit'] : 'px';
		$tablet_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_padding['top'] ?? '0', $tablet_unit,
			$tablet_padding['right'] ?? '0', $tablet_unit,
			$tablet_padding['bottom'] ?? '0', $tablet_unit,
			$tablet_padding['left'] ?? '0', $tablet_unit
		);

		// Mobile styles
		$mobile_padding = isset($padding_data['mobile']) ? $padding_data['mobile'] : [];
		$mobile_unit = isset($padding_data['mobile-unit']) ? $padding_data['mobile-unit'] : 'px';
		$mobile_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_padding['top'] ?? '0', $mobile_unit,
			$mobile_padding['right'] ?? '0', $mobile_unit,
			$mobile_padding['bottom'] ?? '0', $mobile_unit,
			$mobile_padding['left'] ?? '0', $mobile_unit
		);

		// Generate CSS
		$style = "";
		if (!empty($desktop_padding_values)) {
			$style .= "
				@media (min-width: 1025px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						padding: {$desktop_padding_values};
					}
				}
			";
		}
		if (!empty($tablet_padding_values)) {
			$style .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						padding: {$tablet_padding_values};
					}
				}
			";
		}
		if (!empty($mobile_padding_values)) {
			$style .= "
				@media (max-width: 767px) {
					" . SELECTOR_WC_BUTTON_BG . " {
						padding: {$mobile_padding_values};
					}
				}
			";
		}

		wp_add_inline_style('solace-customizer-woocommerce', $style);
	}else {
		$style .= ".wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained {";
		$style .= "padding: 12px 24px";
		$style .= "}";
		// error_log('masuk default button padding:');
		wp_add_inline_style('solace-customizer-woocommerce', $style);
	}
}

function solace_apply_customizer_default_button_styles() {

	$style = "";
	$style .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";
	$style .= "font-family: var(--buttonfontfamily);}";
	$button_bg_styles = "";
	$solace_custom_general_buttons_bg_color = get_theme_mod('solace_wc_custom_general_buttons_bg_color', 'var(--sol-color-link-button-initial)');

	if (!empty($solace_custom_general_buttons_bg_color)) {
		$button_bg_styles .= "background-color: {$solace_custom_general_buttons_bg_color} !important;";
	}

	$border_width_data = get_theme_mod('solace_wc_custom_general_buttons_border_width', '2');
	
	if (!empty($border_width_data) && is_array($border_width_data)) {
	
		// Desktop styles
		$desktop_border_width = isset($border_width_data['desktop']) ? $border_width_data['desktop'] : 1;
		$desktop_unit = isset($border_width_data['desktop-unit']) ? $border_width_data['desktop-unit'] : 'px';
		$desktop_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_border_width['top'] ?? '1', $desktop_unit,
			$desktop_border_width['right'] ?? '1', $desktop_unit,
			$desktop_border_width['bottom'] ?? '1', $desktop_unit,
			$desktop_border_width['left'] ?? '1', $desktop_unit
		);

		// Tablet styles
		$tablet_border_width = isset($border_width_data['tablet']) ? $border_width_data['tablet'] : [];
		$tablet_unit = isset($border_width_data['tablet-unit']) ? $border_width_data['tablet-unit'] : 'px';
		$tablet_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_border_width['top'] ?? '1', $tablet_unit,
			$tablet_border_width['right'] ?? '1', $tablet_unit,
			$tablet_border_width['bottom'] ?? '1', $tablet_unit,
			$tablet_border_width['left'] ?? '1', $tablet_unit
		);

		// Mobile styles
		$mobile_border_width = isset($border_width_data['mobile']) ? $border_width_data['mobile'] : [];
		$mobile_unit = isset($border_width_data['mobile-unit']) ? $border_width_data['mobile-unit'] : 'px';
		$mobile_border_width_value = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_border_width['top'] ?? '1', $mobile_unit,
			$mobile_border_width['right'] ?? '1', $mobile_unit,
			$mobile_border_width['bottom'] ?? '1', $mobile_unit,
			$mobile_border_width['left'] ?? '1', $mobile_unit
		);

		// Generate CSS
		$border_width_css = "";

		// Apply desktop styles
		if (!empty($desktop_border_width_value)) {
			$border_width_css .= "
				@media (min-width: 1025px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-width: {$desktop_border_width_value};
					}
				}
			";
		}

		// Apply tablet styles
		if (!empty($tablet_border_width_value)) {
			$border_width_css .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-width: {$tablet_border_width_value};
					}
				}
			";
		}

		// Apply mobile styles
		if (!empty($mobile_border_width_value)) {
			$border_width_css .= "
				@media (max-width: 767px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-width: {$mobile_border_width_value};
					}
				}
			";
		}

		// Apply the custom styles
		wp_add_inline_style('solace-customizer-default', $border_width_css);
	}

	if (!empty($border_width_data)) {
		$solace_custom_general_buttons_border_style = get_theme_mod('solace_wc_custom_general_buttons_border_style', 'none');
		if (!empty($solace_custom_general_buttons_border_style)) {
			$button_bg_styles .= "border-style: {$solace_custom_general_buttons_border_style} !important;";
		}
		$solace_custom_general_buttons_border_color = get_theme_mod('solace_wc_custom_general_buttons_border_color', '#ffffff');
		if (!empty($solace_custom_general_buttons_border_color)) {
			$button_bg_styles .= "border-color: {$solace_custom_general_buttons_border_color};";
		}
	}
	if (!empty($button_bg_styles)) {
		$style .= SELECTOR_DEFAULT_BUTTON_BG . " {" . $button_bg_styles . "}";
		// $style .= ":root {";
		// $style .= "--sol-color-link-button-initial: {$solace_custom_general_buttons_bg_color};";
		// $style .= "--sol-color-button-initial: {$solace_custom_general_buttons_bg_color};";
		// $style .= "}";
	}

	// Button Background Hover Selector
	$button_bg_hover_styles = "";
	$solace_custom_general_buttons_bg_color_hover = get_theme_mod('solace_wc_custom_general_buttons_bg_color_hover', 'var(--sol-color-link-button-hover)');
	if (!empty($solace_custom_general_buttons_bg_color_hover)) {
		$button_bg_hover_styles .= "background-color: {$solace_custom_general_buttons_bg_color_hover} !important;";
	}
	$solace_custom_general_buttons_border_color_hover = get_theme_mod('solace_wc_custom_general_buttons_border_color_hover', '#000');
	if (!empty($solace_custom_general_buttons_border_color_hover)) {
		$button_bg_hover_styles .= "border-color: {$solace_custom_general_buttons_border_color_hover};";
	}
	if (!empty($button_bg_hover_styles)) {
		$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . " {" . $button_bg_hover_styles . "}";
		// $style .= ":root {";
		// $style .= "--sol-color-link-button-hover: {$solace_custom_general_buttons_bg_color_hover};";
		// $style .= "--sol-color-button-hover: {$solace_custom_general_buttons_bg_color_hover};";
		// $style .= "}";
	}

	// Button Text Selector
	$button_text_styles = "";
	$solace_custom_general_buttons_text_color = get_theme_mod('solace_wc_custom_general_buttons_text_color', '#ffffff');
	if (!empty($solace_custom_general_buttons_text_color)) {
		$button_text_styles .= "color: {$solace_custom_general_buttons_text_color} !important;";
	}
	if (!empty($button_text_styles)) {
		// $style .= SELECTOR_DEFAULT_BUTTON_TEXT . " {" . $button_text_styles . "}";
		$style .= SELECTOR_DEFAULT_BUTTON_TEXT . " {color: {$solace_custom_general_buttons_text_color} !important;}";
		$style .= ":root {";
		$style .= "--solel-color-button-text: {$solace_custom_general_buttons_text_color};";
		$style .= "}";
		$style .= ".wp-block-button.is-style-outline a.wp-block-button__link:not(.has-text-color) {";
		$style .= "border-color: var(--solel-color-button-text);";
		$style .= "color: var(--solel-color-button-text);";
		$style .= "}";
	}

	// Button Text Hover Selector
	$button_text_hover_styles = "";
	$solace_custom_general_buttons_text_color_hover = get_theme_mod('solace_wc_custom_general_buttons_text_color_hover', '#ffffff');
	if (!empty($solace_custom_general_buttons_text_color_hover)) {
		$button_text_hover_styles .= "color: {$solace_custom_general_buttons_text_color_hover} !important;";
	}
	if (!empty($button_text_hover_styles)) {
		$style .= SELECTOR_DEFAULT_BUTTON_TEXT_HOVER . " {" . $button_text_hover_styles . "}";
		$style .= ":root {";
		$style .= "--solel-color-button-text-hover: {$solace_custom_general_buttons_text_color_hover};";
		$style .= "}";
		$style .= ".wp-block-button.is-style-outline a.wp-block-button__link:not(.has-text-color):hover {";
		$style .= "border-color: var(--solel-color-button-text-hover);";
		$style .= "color: var(--solel-color-button-text-hover);";
		$style .= "}";
	}

	// Apply styles
	wp_add_inline_style('solace-customizer-default', $style);

	$border_radius_data = get_theme_mod('solace_wc_custom_general_buttons_border_radius');

	if (!empty($border_radius_data) && is_array($border_radius_data)) {
		// Desktop styles
		$desktop_radius = isset($border_radius_data['desktop']) ? $border_radius_data['desktop'] : [];
		$desktop_unit = isset($border_radius_data['desktop-unit']) ? $border_radius_data['desktop-unit'] : 'px';
		$desktop_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_radius['top'] ?? '3', $desktop_unit,
			$desktop_radius['right'] ?? '3', $desktop_unit,
			$desktop_radius['bottom'] ?? '3', $desktop_unit,
			$desktop_radius['left'] ?? '3', $desktop_unit
		);
	
		// Tablet styles
		$tablet_radius = isset($border_radius_data['tablet']) ? $border_radius_data['tablet'] : [];
		$tablet_unit = isset($border_radius_data['tablet-unit']) ? $border_radius_data['tablet-unit'] : 'px';
		$tablet_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_radius['top'] ?? '3', $tablet_unit,
			$tablet_radius['right'] ?? '3', $tablet_unit,
			$tablet_radius['bottom'] ?? '3', $tablet_unit,
			$tablet_radius['left'] ?? '3', $tablet_unit
		);
	
		// Mobile styles
		$mobile_radius = isset($border_radius_data['mobile']) ? $border_radius_data['mobile'] : [];
		$mobile_unit = isset($border_radius_data['mobile-unit']) ? $border_radius_data['mobile-unit'] : 'px';
		$mobile_border_radius = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_radius['top'] ?? '3', $mobile_unit,
			$mobile_radius['right'] ?? '3', $mobile_unit,
			$mobile_radius['bottom'] ?? '3', $mobile_unit,
			$mobile_radius['left'] ?? '3', $mobile_unit
		);
	
		// Generate CSS
		$style = "";
		if (!empty($desktop_border_radius)) {
			$style .= "
				@media (min-width: 1025px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-radius: {$desktop_border_radius};
					}
				}
			";
		}
		if (!empty($tablet_border_radius)) {
			$style .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-radius: {$tablet_border_radius};
					}
				}
			";
		}
		if (!empty($mobile_border_radius)) {
			$style .= "
				@media (max-width: 767px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						border-radius: {$mobile_border_radius};
					}
				}
			";
		}
	
		wp_add_inline_style('solace-customizer-default', $style);
	}
	$padding_data = get_theme_mod('solace_wc_custom_general_buttons_padding');

	if (!empty($padding_data) && is_array($padding_data)) {
		// error_log('masuk button padding');
		// Desktop styles
		$desktop_padding = isset($padding_data['desktop']) ? $padding_data['desktop'] : [];
		$desktop_unit = isset($padding_data['desktop-unit']) ? $padding_data['desktop-unit'] : 'px';
		$desktop_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$desktop_padding['top'] ?? '12', $desktop_unit,
			$desktop_padding['right'] ?? '24', $desktop_unit,
			$desktop_padding['bottom'] ?? '12', $desktop_unit,
			$desktop_padding['left'] ?? '24', $desktop_unit
		);

		// Tablet styles
		$tablet_padding = isset($padding_data['tablet']) ? $padding_data['tablet'] : [];
		$tablet_unit = isset($padding_data['tablet-unit']) ? $padding_data['tablet-unit'] : 'px';
		$tablet_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$tablet_padding['top'] ?? '12', $tablet_unit,
			$tablet_padding['right'] ?? '24', $tablet_unit,
			$tablet_padding['bottom'] ?? '12', $tablet_unit,
			$tablet_padding['left'] ?? '24', $tablet_unit
		);

		// Mobile styles
		$mobile_padding = isset($padding_data['mobile']) ? $padding_data['mobile'] : [];
		$mobile_unit = isset($padding_data['mobile-unit']) ? $padding_data['mobile-unit'] : 'px';
		$mobile_padding_values = sprintf(
			"%s%s %s%s %s%s %s%s",
			$mobile_padding['top'] ?? '12', $mobile_unit,
			$mobile_padding['right'] ?? '24', $mobile_unit,
			$mobile_padding['bottom'] ?? '12', $mobile_unit,
			$mobile_padding['left'] ?? '24', $mobile_unit
		);

		// Generate CSS
		$style = "";
		if (!empty($desktop_padding_values)) {
			$style .= "
				@media (min-width: 1025px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						padding: {$desktop_padding_values};
					}
				}
			";
		}
		if (!empty($tablet_padding_values)) {
			$style .= "
				@media (min-width: 768px) and (max-width: 1024px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						padding: {$tablet_padding_values};
					}
				}
			";
		}
		if (!empty($mobile_padding_values)) {
			$style .= "
				@media (max-width: 767px) {
					" . SELECTOR_DEFAULT_BUTTON_BG . " {
						padding: {$mobile_padding_values};
					}
				}
			";
		}

		wp_add_inline_style('solace-customizer-default', $style);
	}else {
		$style .= SELECTOR_DEFAULT_BUTTON_BG .", body .wp-block-button__link {";
		$style .= "padding: 12px 24px";
		$style .= "}";
		// error_log('masuk default gutenberg button padding');
		wp_add_inline_style('solace-customizer-default', $style);
	}


	
}

function solace_apply_elementor_default_button_styles() {
	// If plugin elementor deactive.
    if ( ! class_exists( 'Elementor\Plugin' ) ) {
        return;
    }

	// Retrieve the Elementor page settings meta data.
	$current_settings = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$meta = $current_settings;
	$active_kit_id = \Elementor\Plugin::$instance->kits_manager->get_active_id();

	if (isset($meta['__globals__']['button_background_color']) && !empty($meta['__globals__']['button_background_color'])) {

		$meta['button_background_color'] = null;

	}
	if (isset($meta['__globals__']['button_text_color']) && !empty($meta['__globals__']['button_text_color'])) {

		$meta['button_text_color'] = null;

	}

	$body_classes = get_body_class();

	if (in_array('dokan-store', $body_classes) || in_array('dokan-dashboard', $body_classes)) {
		$meta = false;
	} 

	if ( $meta ) {
		$style = '';

		// Style button text color.
		if ( isset( $meta['button_text_color'] )  && !empty( $meta['button_text_color']) ) {

			$text_color = $meta['button_text_color'];

			$style .= ":root {";
			$style .= "--solel-color-button-text: {$text_color};";
			$style .= "}";

			$style .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";
			$style .= "color: var(--solel-color-button-text);";
			$style .= "}";

			// wp_add_inline_style( 'solace-theme', $style );
		} else {
			$style .= SELECTOR_DEFAULT_BUTTON_TEXT . "{";
			$style .= "color: var(--sol-color-page-title-text);";
			$style .= "}";
			// wp_add_inline_style( 'solace-theme', $style );
		}
		// Style button hover text color.
		if ( isset( $meta['button_hover_text_color'] )  && !empty( $meta['button_hover_text_color']) ) {

			$hover_text_color = $meta['button_hover_text_color'];
			$style .= ":root {";
			$style .= "--solel-color-button-text-hover: {$hover_text_color};";
			$style .= "}";
			$style .= SELECTOR_DEFAULT_BUTTON_TEXT_HOVER . "{";
			$style .= "color: var(--solel-color-button-text-hover);";
			$style .= "}";
			// Add the inline style to the 'solace-theme'.
			// wp_add_inline_style( 'solace-theme', $style );
		}	
		// Style button background color.

		if ( ! isset( $_GET['elementor-preview'] ) ) {
			// error_log ('masuk elementor-preview button bg color');
			if ( isset( $meta['button_background_color'] ) && !empty( $meta['button_background_color']) ) {

				$bg = $meta['button_background_color'];
				$style .= ":root {";
				$style .= "--solel-color-button-initial: {$bg};";
				$style .= "}";
				
					$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
					// $style .= "background: var(--solel-color-button-initial);";
					$style .= "background: {$bg};";
					$style .= "}";
				

				// wp_add_inline_style( 'solace-theme', $style );
			} else {
				$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
				$style .= "background: var(--sol-color-button-initial);";
				$style .= "}";
				// wp_add_inline_style( 'solace-theme', $style );
			}
		}

		// Style button hover background color.
		if ( isset( $meta['button_hover_background_color'] ) && !empty( $meta['button_hover_background_color']) ) {

			$bg = $meta['button_hover_background_color'];
			$style .= ":root {";
			$style .= "--solel-color-button-hover: {$bg};";
			$style .= "}";
			$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . "{";
			$style .= "background: var(--solel-color-button-hover);";
			$style .= "}";

			// wp_add_inline_style( 'solace-theme', $style );
		} else {
			$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . "{";
			$style .= "background: var(--sol-color-button-hover);";
			$style .= "}";
			// wp_add_inline_style( 'solace-theme', $style );
		}

		// BORDER RADIUS FROM ELEMENTOR BUTTON

		if ( isset( $meta['button_border_radius'] ) && !empty( $meta['button_border_radius']) ) {
			$unit 	= $meta['button_border_radius']['unit'];
			$top 	= $meta['button_border_radius']['top'];
			$right 	= $meta['button_border_radius']['right'];
			$bottom = $meta['button_border_radius']['bottom'];
			$left 	= $meta['button_border_radius']['left'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "border-radius: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_radius'] ) && !empty( $meta['button_hover_border_radius']) ) {
			$unit 	= $meta['button_hover_border_radius']['unit'];
			$top 	= $meta['button_hover_border_radius']['top'];
			$right 	= $meta['button_hover_border_radius']['right'];
			$bottom = $meta['button_hover_border_radius']['bottom'];
			$left 	= $meta['button_hover_border_radius']['left'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . "{";
			$style .= "border-radius: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		

		// PADDING FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_padding'] ) && !empty( $meta['button_padding']) ) {
			$unit 	= $meta['button_padding']['unit'];
			$top 	= $meta['button_padding']['top'];
			$right 	= $meta['button_padding']['right'];
			$bottom = $meta['button_padding']['bottom'];
			$left 	= $meta['button_padding']['left'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "padding: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		}else {
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "padding: 12px 24px;";
			$style .= "}";
			$style .= ".wc-block-components-totals-coupon__button span.wc-block-components-button__text{";
			$style .= "padding: 0";
			$style .= "}";
		}

		// BORDER FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_width'] ) && !empty( $meta['button_border_width']) ) {
			$unit 	= $meta['button_border_width']['unit'];
			$top 	= $meta['button_border_width']['top'];
			$right 	= $meta['button_border_width']['right'];
			$bottom = $meta['button_border_width']['bottom'];
			$left 	= $meta['button_border_width']['left'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "border-width: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_width'] ) && !empty( $meta['button_hover_border_width']) ) {
			$unit 	= $meta['button_hover_border_width']['unit'];
			$top 	= $meta['button_hover_border_width']['top'];
			$right 	= $meta['button_hover_border_width']['right'];
			$bottom = $meta['button_hover_border_width']['bottom'];
			$left 	= $meta['button_hover_border_width']['left'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . "{";
			$style .= "border-width: {$top}{$unit} {$right}{$unit} {$bottom}{$unit} {$left}{$unit};";
			$style .= "}";
		} 		

		// BORDER COLOR FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_color'] ) && !empty( $meta['button_border_color']) ) {
			$color 	= $meta['button_border_color'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "border-color: {$color};";
			$style .= "}";
		} 		
		if ( isset( $meta['button_hover_border_color'] ) && !empty( $meta['button_hover_border_color']) ) {
			$color 	= $meta['button_hover_border_color'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "border-color: {$color};";
			$style .= "}";
		} 		

		// BORDER STYLE FROM ELEMENTOR BUTTON
		if ( isset( $meta['button_border_border'] ) && !empty( $meta['button_border_border']) ) {
			$type 	= $meta['button_border_border'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG . "{";
			$style .= "border-style: {$type};";
			$style .= "}";
		}
		if ( isset( $meta['button_hover_border_border'] ) && !empty( $meta['button_hover_border_border']) ) {
			$type 	= $meta['button_hover_border_border'];
			$style .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . "{";
			$style .= "border-style: {$type};";
		}

		$gaya = '';
		// TYPOGRAPHY FROM ELEMENTOR BUTTON
		if ( isset( $meta['__globals__']['button_typography_typography'] ) && !empty( $meta['__globals__']['button_typography_typography']) ) {
			$button_typography = $meta['__globals__']['button_typography_typography'];
			$typography_id = str_replace('globals/typography?id=', '', $button_typography);
			
			$global_typography = null;

			if (isset($current_settings['system_typography']) && is_array($current_settings['system_typography'])) {

				foreach ($current_settings['system_typography'] as $typography) {
					if (isset($typography['_id']) && $typography['_id'] === $typography_id) {
						$global_typography = $typography;
						break;
					}
				}
				$gaya .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";
			
				// Font Family
				if ( isset( $global_typography['typography_font_family'] ) ) {
					$gaya .= "font-family: '{$global_typography['typography_font_family']}';";
				}

				// Font Size (Desktop)
				if ( isset( $global_typography['typography_font_size']['size'] ) ) {
					$unit = isset( $global_typography['typography_font_size']['unit'] ) ? $global_typography['typography_font_size']['unit'] : 'px';
					$gaya .= "font-size: {$global_typography['typography_font_size']['size']}{$unit};";
				}

				// Font Weight
				if ( isset( $global_typography['typography_font_weight'] ) ) {
					$gaya .= "font-weight: {$global_typography['typography_font_weight']};";
				}

				// Line Height (Desktop)
				if ( isset( $global_typography['typography_line_height']['size'] ) ) {
					$unit = isset( $global_typography['typography_line_height']['unit'] ) ? $global_typography['typography_line_height']['unit'] : 'em';
					$gaya .= "line-height: {$global_typography['typography_line_height']['size']}{$unit};";
				}

				$gaya .= "}";
			} 

		} else {

			$gaya .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";

			// Font Family
			if ( isset( $meta['button_typography_font_family'] ) ) {
				$gaya .= "font-family: '{$meta['button_typography_font_family']}';";
			}

			// Font Size (Desktop)
			if ( isset( $meta['button_typography_font_size']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size']['unit'] ) ? $meta['button_typography_font_size']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size']['size']}{$unit};";
			}

			// Font Weight
			if ( isset( $meta['button_typography_font_weight'] ) ) {
				$gaya .= "font-weight: {$meta['button_typography_font_weight']};";
			}

			// Font Style
			if ( isset( $meta['button_typography_font_style'] ) ) {
				$gaya .= "font-style: {$meta['button_typography_font_style']};";
			}

			// Font Transform
			if ( isset( $meta['button_typography_text_transform'] ) ) {
				$gaya .= "text-transform: {$meta['button_typography_text_transform']};";
			}

			// Font Decoration
			if ( isset( $meta['button_typography_text_decoration'] ) ) {
				$gaya .= "text-decoration: {$meta['button_typography_text_decoration']};";
			}

			// Line Height (Desktop)
			if ( isset( $meta['button_typography_line_height']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height']['unit'] ) ? $meta['button_typography_line_height']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height']['size']}{$unit};";
			}

			// Letter Spacing (Desktop)
			if ( isset( $meta['button_typography_letter_spacing']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing']['unit'] ) ? $meta['button_typography_letter_spacing']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing']['size']}{$unit};";
			}

			// Word Spacing (Desktop)
			if ( isset( $meta['button_typography_word_spacing']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing']['unit'] ) ? $meta['button_typography_word_spacing']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing']['size']}{$unit};";
			}

			$gaya .= "}";

		} 

		// Tablet style
		if ( isset( $meta['button_typography_font_size_tablet']['size'] ) || isset( $meta['button_typography_line_height_tablet']['size'] ) ) {
			$gaya .= "@media (max-width: 1024px) {";
			$gaya .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";

			// Font Size (Tablet)
			if ( isset( $meta['button_typography_font_size_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size_tablet']['unit'] ) ? $meta['button_typography_font_size_tablet']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size_tablet']['size']}{$unit};";
			}

			// Line Height (Tablet)
			if ( isset( $meta['button_typography_line_height_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height_tablet']['unit'] ) ? $meta['button_typography_line_height_tablet']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height_tablet']['size']}{$unit};";
			}

			// Letter Spacing (Tablet)
			if ( isset( $meta['button_typography_letter_spacing_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing_tablet']['unit'] ) ? $meta['button_typography_letter_spacing_tablet']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing_tablet']['size']}{$unit};";
			}

			// Word Spacing (Tablet)
			if ( isset( $meta['button_typography_word_spacing_tablet']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing_tablet']['unit'] ) ? $meta['button_typography_word_spacing_tablet']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing_tablet']['size']}{$unit};";
			}

			$gaya .= "}";
			$gaya .= "}";
		}

		// Mobile gayas
		if ( isset( $meta['button_typography_font_size_mobile']['size'] ) || isset( $meta['button_typography_line_height_mobile']['size'] ) ) {
			$gaya .= "@media (max-width: 768px) {";
			$gaya .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";

			// Font Size (Mobile)
			if ( isset( $meta['button_typography_font_size_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_font_size_mobile']['unit'] ) ? $meta['button_typography_font_size_mobile']['unit'] : 'px';
				$gaya .= "font-size: {$meta['button_typography_font_size_mobile']['size']}{$unit};";
			}

			// Line Height (Mobile)
			if ( isset( $meta['button_typography_line_height_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_line_height_mobile']['unit'] ) ? $meta['button_typography_line_height_mobile']['unit'] : 'em';
				$gaya .= "line-height: {$meta['button_typography_line_height_mobile']['size']}{$unit};";
			}

			// Letter Spacing (Mobile)
			if ( isset( $meta['button_typography_letter_spacing_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_letter_spacing_mobile']['unit'] ) ? $meta['button_typography_letter_spacing_mobile']['unit'] : 'px';
				$gaya .= "letter-spacing: {$meta['button_typography_letter_spacing_mobile']['size']}{$unit};";
			}

			// Word Spacing (Mobile)
			if ( isset( $meta['button_typography_word_spacing_mobile']['size'] ) ) {
				$unit = isset( $meta['button_typography_word_spacing_mobile']['unit'] ) ? $meta['button_typography_word_spacing_mobile']['unit'] : 'px';
				$gaya .= "word-spacing: {$meta['button_typography_word_spacing_mobile']['size']}{$unit};";
			}

			$gaya .= "}";
			$gaya .= "}";
		}

		// Shadow Effects (Text Shadow)
		if ( isset( $meta['button_text_shadow_text_shadow_type'] ) && $meta['button_text_shadow_text_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_text_shadow_text_shadow'] ) ) {
				$shadow = $meta['button_text_shadow_text_shadow'];
				$gaya .= SELECTOR_DEFAULT_BUTTON_TEXT . " {";
				$gaya .= "text-shadow: {$shadow['horizontal']}px {$shadow['vertical']}px {$shadow['blur']}px {$shadow['color']};";
				$gaya .= "}";
			}
		}
		
		// Shadow Effects (Box Shadow)
		if ( isset( $meta['button_box_shadow_box_shadow_type'] ) && $meta['button_box_shadow_box_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_box_shadow_box_shadow'] ) ) {
				$box_shadow = $meta['button_box_shadow_box_shadow'];
				$box_shadow_position = isset( $meta['button_box_shadow_box_shadow_position'] ) ? $meta['button_box_shadow_box_shadow_position'] : '';
				$gaya .= SELECTOR_DEFAULT_BUTTON_BG . " {";
				$gaya .= "box-shadow: {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				if ( $box_shadow_position === 'inset' ) {
					$gaya .= "box-shadow: inset {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				}
				$gaya .= "}";
			}
		}

		if ( isset( $meta['button_hover_box_shadow_box_shadow_type'] ) && $meta['button_hover_box_shadow_box_shadow_type'] === 'yes' ) {
			if ( isset( $meta['button_hover_box_shadow_box_shadow'] ) ) {
				$box_shadow = $meta['button_hover_box_shadow_box_shadow'];
				$box_shadow_position = isset( $meta['button_hover_box_shadow_box_shadow_position'] ) ? $meta['button_hover_box_shadow_box_shadow_position'] : '';
				$gaya .= SELECTOR_DEFAULT_BUTTON_BG_HOVER . " {";
				$gaya .= "box-shadow: {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				if ( $box_shadow_position === 'inset' ) {
					$gaya .= "box-shadow: inset {$box_shadow['horizontal']}px {$box_shadow['vertical']}px {$box_shadow['blur']}px {$box_shadow['spread']}px {$box_shadow['color']};";
				}
				$gaya .= "}";
			}
		}
		// error_log('gaya: '.$gaya);
		wp_add_inline_style( 'solace-elementor-woocommerce', $gaya );

		wp_add_inline_style( 'solace-elementor-woocommerce', $style );
	}
}


function solace_apply_default_button_styles() {
	// error_log('masuk default button style');
	// If plugin elementor deactive.
    if ( ! class_exists( 'Elementor\Plugin' ) ) {
        return;
    }
	$button_default_header_footer = '';
	// Retrieve the Elementor page settings meta data.
	$current_settings = \Elementor\Plugin::$instance->kits_manager->get_current_settings();
	$meta = $current_settings;

	if (isset($meta['__globals__']['button_background_color']) && !empty($meta['__globals__']['button_background_color'])) {

		$meta['button_background_color'] = null;

	}
	if (isset($meta['__globals__']['button_text_color']) && !empty($meta['__globals__']['button_text_color'])) {

		$meta['button_text_color'] = null;

	}
	// error_log('GlobalTC: '. $meta['__globals__']['button_text_color']);
	// error_log('SolidTC: '.$meta['button_text_color']);
	// error_log('GlobalBG: '. $meta['__globals__']['button_background_color']);
	// error_log('SolidBG: '.$meta['button_background_color']);

	if ( isset( $meta['__globals__']['button_text_color'] ) ) {
		$button_text_color = $meta['__globals__']['button_text_color'];
		$button_text_color = str_replace( 'globals/colors?id=', '', $button_text_color );
		$button_default_header_footer .= "body button.search-submit.nv-submit {";
		$button_default_header_footer .= "color: var(--e-global-color-$button_text_color) !important;";
		$button_default_header_footer .= "}";
	}

	if ( isset( $meta['button_text_color'] ) && !empty( $meta['button_text_color']) ) {

		$tc = $meta['button_text_color'];

		$button_default_header_footer .= "body button.search-submit.nv-submit {";
		$button_default_header_footer .= "color: {$tc};";
		$button_default_header_footer .= "}";

	}

	if ( isset( $meta['__globals__']['button_hover_text_color'] ) ) {
		$button_hover_text_color = $meta['__globals__']['button_hover_text_color'];
		$button_hover_text_color = str_replace( 'globals/colors?id=', '', $button_hover_text_color );
		$button_default_header_footer .= "body button.search-submit.nv-submit:hover {";
		$button_default_header_footer .= "color: var(--e-global-color-$button_hover_text_color) !important;";
		$button_default_header_footer .= "}";
	}

	if ( isset( $meta['button_hover_text_color'] )  && !empty( $meta['button_hover_text_color']) ) {
		$tc_hover = $meta['button_hover_text_color'];
		$button_default_header_footer .= "body button.search-submit.nv-submit:hover {";
		$button_default_header_footer .= "color: {$tc_hover};";
		$button_default_header_footer .= "}";
	}

	if ( isset( $meta['__globals__']['button_background_color'] ) ) {
		$button_background_color = $meta['__globals__']['button_background_color'];
		$button_background_color = str_replace( 'globals/colors?id=', '', $button_background_color );
		$button_default_header_footer .= "body button.search-submit.nv-submit {";
		$button_default_header_footer .= "background-color: var(--e-global-color-$button_background_color) !important;";
		$button_default_header_footer .= "}";
	}

	if ( isset( $meta['button_background_color'] ) && !empty( $meta['button_background_color']) ) {

		$bg = $meta['button_background_color'];

		$button_default_header_footer .= "body button.search-submit.nv-submit {";
		$button_default_header_footer .= "background-color: {$bg};";
		$button_default_header_footer .= "}";

	}

	if ( isset( $meta['__globals__']['button_hover_background_color'] ) ) {
		$button_hover_background_color = $meta['__globals__']['button_hover_background_color'];
		$button_hover_background_color = str_replace( 'globals/colors?id=', '', $button_hover_background_color );
		$button_default_header_footer .= "body button.search-submit.nv-submit:hover {";
		$button_default_header_footer .= "background-color: var(--e-global-color-$button_hover_background_color) !important;";
		$button_default_header_footer .= "}";
	}

	if ( isset( $meta['button_hover_background_color'] )  && !empty( $meta['button_hover_background_color']) ) {
		$button_hover_background_color = $meta['button_hover_background_color'];
		$button_default_header_footer .= "body button.search-submit.nv-submit:hover {";
		$button_default_header_footer .= "background-color: {$button_hover_background_color};";
		$button_default_header_footer .= "}";
	}

	wp_add_inline_style('solace-theme', $button_default_header_footer);

} 

function solace_is_elementor_page() {
    if (!did_action('wp')) {
        return false;
    }

    global $post;
    
    if (empty($post) || empty($post->ID)) {
        return false;
    }

    $is_elementor = get_post_meta($post->ID, '_elementor_edit_mode', true) === 'builder';

    return $is_elementor;
}

function solace_is_elementor_page_customizer() {
    return is_customize_preview() && solace_is_elementor_page();
}

add_action('wp_enqueue_scripts', 'solace_apply_default_button_styles');

add_action('wp_enqueue_scripts', function () {

	if (is_customize_preview()) {
		// Customizer Preview Logic
		$use_custom_buttons = get_theme_mod('solace_wc_custom_general_buttons_elementor', false);
		if ($use_custom_buttons === true) {
			wp_register_style('solace-customizer-woocommerce', false);
			wp_enqueue_style('solace-customizer-woocommerce');
			
			// Apply Customizer-specific styles
			solace_apply_customizer_woocommerce_button_styles();
			
			wp_register_style('solace-customizer-default', false);
			wp_enqueue_style('solace-customizer-default');
			solace_apply_customizer_default_button_styles();

		} else {
			if (class_exists('\Elementor\Plugin')) {
				error_log('[Solace Debug] Elementor\Plugin class exists, enqueuing frontend styles');
				\Elementor\Plugin::$instance->frontend->enqueue_styles();
			} 

			wp_register_style('solace-elementor-woocommerce', false);
			wp_enqueue_style('solace-elementor-woocommerce');

			// Apply Elementor-specific styles
			solace_apply_elementor_woocommerce_button_styles();

			wp_register_style('solace-customizer-default', false);
			wp_enqueue_style('solace-customizer-default');
			solace_apply_elementor_default_button_styles();
		}
	} else {
		// Frontend Logic
		if (get_theme_mod('solace_wc_custom_general_buttons_elementor', false) === true) {
			wp_register_style('solace-customizer-woocommerce', false);
			wp_enqueue_style('solace-customizer-woocommerce');
			wp_register_style('solace-customizer-default', false);
			wp_enqueue_style('solace-customizer-default');

			solace_apply_customizer_woocommerce_button_styles();
			solace_apply_customizer_default_button_styles();

		} else {
			if (class_exists('\Elementor\Plugin')) {
				\Elementor\Plugin::$instance->frontend->enqueue_styles();
			}

			wp_register_style('solace-elementor-woocommerce', false);
			wp_enqueue_style('solace-elementor-woocommerce');
			wp_register_style('solace-customizer-default', false);
			wp_enqueue_style('solace-customizer-default');

			solace_apply_elementor_woocommerce_button_styles();
			solace_apply_elementor_default_button_styles();
		}
	}
},99);


// set default value after theme installed
function solace_set_default_customizer_options() {
    $defaults = array(
        'solace_wc_custom_general_buttons_elementor'       => false,
        'solace_wc_custom_general_buttons_text_color'      => '#FFFFFF',
        'solace_wc_custom_general_buttons_text_color_hover'=> '#FFFFFF',
        'solace_wc_custom_general_buttons_bg_color'        => '#3662FF',
        'solace_wc_custom_general_buttons_bg_color_hover'  => '#000F4D',
        'solace_wc_custom_general_buttons_border_style'    => 'none',
        'solace_wc_custom_general_buttons_border_color'    => '#000F4D',
        'solace_wc_custom_general_buttons_border_color_hover' => '#ff8c00',
        'solace_wc_custom_general_buttons_border_width'    => array(
            'mobile' => array('top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1),
            'tablet' => array('top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1),
            'desktop' => array('top' => 2, 'right' => 2, 'bottom' => 2, 'left' => 2),
            'mobile-unit' => 'px', 'tablet-unit' => 'px', 'desktop-unit' => 'px',
        ),
        'solace_wc_custom_general_buttons_border_radius' => array(
            'mobile' => array('top' => 3, 'right' => 3, 'bottom' => 3, 'left' => 3),
            'tablet' => array('top' => 3, 'right' => 3, 'bottom' => 3, 'left' => 3),
            'desktop' => array('top' => 3, 'right' => 3, 'bottom' => 3, 'left' => 3),
            'mobile-unit' => 'px', 'tablet-unit' => 'px', 'desktop-unit' => 'px',
        ),
        'solace_wc_custom_general_buttons_padding' => array(
            'mobile' => array('top' => 6, 'right' => 12, 'bottom' => 6, 'left' => 12),
            'tablet' => array('top' => 6, 'right' => 12, 'bottom' => 6, 'left' => 12),
            'desktop' => array('top' => 12, 'right' => 24, 'bottom' => 12, 'left' => 24),
            'mobile-unit' => 'px', 'tablet-unit' => 'px', 'desktop-unit' => 'px',
        ),
    );

    foreach ($defaults as $key => $value) {
        if (get_theme_mod($key, null) === null) {
            set_theme_mod($key, $value);
        }
    }
}
add_action('after_setup_theme', 'solace_set_default_customizer_options');

