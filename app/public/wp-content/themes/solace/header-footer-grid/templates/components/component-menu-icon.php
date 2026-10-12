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

use HFG\Core\Components\MenuIcon;

$item_attributes = apply_filters( 'solace_nav_toggle_data_attrs', '' );
$label           = component_setting( MenuIcon::TEXT_ID );
$menu_icon       = component_setting( MenuIcon::MENU_ICON );
$icon_type   = component_setting( MenuIcon::TOGGLE_ICON_ID );
$icon_custom = component_setting( MenuIcon::TOGGLE_CUSTOM_ID, '' );
$svg_icon    = solace_kses_svg( MenuIcon::get_icon( $icon_type, $icon_custom ) );

$class = '';
if ( $menu_icon !== 'default' ) {
	$class = apply_filters( 'solace_menu_icon_classes', 'hamburger ', $menu_icon );
}
?>
<div class="menu-mobile-toggle item-button navbar-toggle-wrapper">
	<button type="button" class="<?php echo esc_attr( $class ); ?> navbar-toggle"
			value="<?php esc_attr_e( 'Navigation Menu', 'solace' ); ?>"
		<?php
		echo ( $item_attributes );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		?>
			aria-label="<?php esc_attr_e( 'Navigation Menu', 'solace' ); ?> ">
		<?php
		if ( ! empty( $label ) ) {
			echo '<span class="nav-toggle-label">' . esc_html( $label ) . '</span>';
		}
		?>
		
		<span class="sol_menu_icon"><?php echo $svg_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		
		<?php
		if ( $menu_icon === 'default' ) {
			?>
			
			<?php
		} else {
			?>
			<span class="hamburger-box">
				<span class="hamburger-inner"></span>
			</span>
			<?php
		}
		?>
		<span class="screen-reader-text"><?php esc_html_e( 'Navigation Menu', 'solace' ); ?></span>
	</button>
</div> <!--.navbar-toggle-wrapper-->


