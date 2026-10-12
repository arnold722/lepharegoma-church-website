<?php
/**
 * Template used for component rendering wrapper.
 *
 * Name:    Header Footer Grid
 *
 * @version 1.0.0
 * @package HFG
 */
namespace HFG;

use HFG\Core\Components\CartIconFooter;

$icon_type         = CartIconFooter::should_load_pro_features() ? component_setting( CartIconFooter::ICON_SELECTOR, 'cart-icon-style1' ) : 'cart-icon-style1';
$icon_custom       = CartIconFooter::should_load_pro_features() ? component_setting( CartIconFooter::ICON_CUSTOM, '' ) : '';
$cart_style        = CartIconFooter::should_load_pro_features() ? component_setting( CartIconFooter::MINI_CART_STYLE, 'dropdown' ) : 'dropdown';
$custom_html       = CartIconFooter::should_load_pro_features() ? component_setting( CartIconFooter::AFTER_CART_HTML ) : '';
$expand_enabled    = CartIconFooter::should_load_pro_features() ? component_setting( CartIconFooter::CART_FOCUS, 1 ) : true;
$cart_label        = CartIconFooter::should_load_pro_features() ? parse_dynamic_tags( component_setting( CartIconFooter::CART_LABEL ) ) : '';
$allowed_post_tags = wp_kses_allowed_html( 'header_footer_grid' );
$cart_is_empty     = WC()->cart->get_cart_contents_count() === 0;

// LOAD ICON CHOOSEN FROM CUSTOMIZER
$icon_type   = component_setting( CartIconFooter::TOGGLE_ICON_ID );
$icon_custom = component_setting( CartIconFooter::TOGGLE_CUSTOM_ID, '' );
$svg_icon    = solace_kses_svg( CartIconFooter::get_icon( $icon_type, $icon_custom ) );



$off_canvas_closing_button = '';
$mini_cart_classes         = [ 'nv-nav-cart', 'widget' ];
if ( $cart_style === 'off-canvas' ) {
	$mini_cart_classes         = solace_is_new_skin() ? [ 'nv-nav-cart', 'cart-off-canvas', 'widget' ] : [ 'cart-off-canvas', 'col-sm-12' ];
	$off_canvas_closing_button = '<div class="cart-off-canvas-button-wrapper"><a href="#" class="nv-close-cart-sidebar button button-secondary secondary-default">' . __( 'Close', 'solace' ) . '</a></div>';
}
if ( (bool) $expand_enabled === false ) {
	$mini_cart_classes[] = 'expand-disable';
}
?>

<div class="component-wrap">
	<div class="responsive-nav-cart menu-item-nav-cart
	<?php
	echo esc_attr( $cart_style );
	echo $cart_is_empty ? ' cart-is-empty' : '';
	?>
	">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon-wrapper">
			<?php
			if ( ! empty( $cart_label ) ) {
				echo '<span class="cart-icon-label inherit-ff">';
				echo wp_kses_post( $cart_label );
				echo '</span>';
			}
			?>
			<?php //solace_cart_icon( true, 15, $icon_type, $icon_custom ); ?>
			<span class="sol_cart_icon"><?php echo $svg_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<span class="screen-reader-text">
				<?php esc_html_e( 'Cart', 'solace' ); ?>
			</span>
			<span class="cart-count">
				<?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?>
			</span>
			<?php do_action( 'solace_cart_icon_after_cart_total' ); ?>
		</a>
		<?php if ( $cart_style !== 'link' && ! is_cart() && ! is_checkout() ) { ?>
		<div class="<?php echo esc_attr( implode( ' ', $mini_cart_classes ) ); ?>">

			<?php
			/**
			 * Executes actions before the cart popup content.
			 *
			 * @since 2.9.3
			 */
			do_action( 'solace_before_cart_popup' );

			echo wp_kses_post( $off_canvas_closing_button );

			the_widget(
				'WC_Widget_Cart',
				array(
					'title'         => ' ',
					'hide_if_empty' => true,
				),
				array(
					'before_title' => '',
					'after_title'  => '',
				)
			);

			if ( ! empty( $custom_html ) ) {
				echo '<div class="after-cart-html">';
				echo wp_kses( balanceTags( apply_filters( 'solace_post_content', $custom_html ), true ), $allowed_post_tags );
				echo '</div>';
			}

			/**
			 * Executes actions after the cart popup content.
			 *
			 * @since 2.9.3
			 */
			do_action( 'solace_after_cart_popup' );
			?>
		</div>
		<?php } ?>
	</div>
</div>


