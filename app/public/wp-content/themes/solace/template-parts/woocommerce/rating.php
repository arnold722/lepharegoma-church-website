<?php
/**
 * Custom Product Rating Template
 *
 * @package Solace
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

$product = get_query_var( 'product' );

if ( ! $product || ! $product instanceof WC_Product ) {
	error_log( 'Product is not valid.' );
	return;
}

$average            = floatval( $product->get_average_rating() );
$rating_percentage  = ( $average / 5 ) * 100;
$woocommerce_fonts_url = plugins_url( 'assets/fonts/star.woff', WC_PLUGIN_FILE );
$star_color         = get_theme_mod( 'solace_wc_custom_general_star_rating_color', '#ffc107' );
?>

<style>
@font-face {
	font-family: 'star';
	src: url('<?php echo esc_url( $woocommerce_fonts_url ); ?>') format('woff');
	font-weight: normal;
	font-style: normal;
}

.custom-star-rating .star-rating {
	overflow: hidden;
	position: relative;
	height: 1em;
	line-height: 1;
	font-size: 1.2em;
	width: 5.4em;
	font-family: 'star';
	display: inline-block;
}

.custom-star-rating .star-rating::before {
	content: "SSSSS";
	position: absolute;
	top: 0;
	left: 0;
	font-family: 'star';
	opacity: 0.25;
}

.custom-star-rating .star-rating span {
	display: block;
	position: absolute;
	top: 0;
	left: 0;
	overflow: hidden;
	white-space: nowrap;
	height: 100%;
}

.custom-star-rating .star-rating span::before {
	content: "SSSSS";
	position: absolute;
	top: 0;
	left: 0;
	color: <?php echo esc_attr( $star_color ); ?>;
	font-family: 'star';
}
</style>

<div class="woocommerce-product-rating custom-star-rating">
	<div class="star-rating" role="img" aria-label="<?php echo esc_attr( sprintf( __( 'Rated %s out of 5', 'solace' ), $average ) ); ?>">
		<span style="width:<?php echo esc_attr( $rating_percentage ); ?>%"></span>
	</div>
</div>
