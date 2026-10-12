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

use HFG\Core\Components\HeaderButton2;

$text = parse_dynamic_tags( component_setting( HeaderButton2::TEXT_ID ) );
$text = apply_filters( 'solace_translate_single_string', $text, HeaderButton2::TEXT_ID );
$button_style = esc_html(get_theme_mod('button_base2_style_btn_id', 'button1'));
$button_class_border = '';
if ($button_style === 'button1') {
	$button_class_border = 'button1';
} else {
	$button_class_border = 'button2';
}
if ( ! empty( $text ) ) {
	$button_link = parse_dynamic_tags( component_setting( HeaderButton2::LINK_ID ) );
	$button_link = apply_filters( 'solace_translate_single_string', $button_link, HeaderButton2::LINK_ID );

	echo '<div class="component-wrap">';
	echo '<a href="' . esc_url( $button_link ) . '" class="button solace-component-button-customizer button-primary ' . $button_class_border . '">';
	echo wp_kses_post( stripcslashes( $text ) );
	echo '</a>';
	echo '</div>';
}
