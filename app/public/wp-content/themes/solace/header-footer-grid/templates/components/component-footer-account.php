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

use HFG\Core\Components\FooterAccount;

$icon_type   = component_setting( FooterAccount::TOGGLE_ICON_ID );
$icon_custom = component_setting( FooterAccount::TOGGLE_CUSTOM_ID, '' );
$svg_icon    = solace_kses_svg( FooterAccount::get_icon( $icon_type, $icon_custom ) );
$label       = component_setting( FooterAccount::PLACEHOLDER_ID );
$user_gravatar = component_setting( FooterAccount::USE_GRAVATAR );

if (class_exists('WooCommerce')) {
	$link = get_permalink( get_option('woocommerce_myaccount_page_id') );
} else {
	$link = get_edit_profile_url();
}

$amp_state = '';
if ( solace_is_amp() ) {
	$amp_state = ' on="tap:AMP.setState({isDark: !isDark})" ';
}

if (is_user_logged_in()) {
	$classes = 'user-login';
} else {
	$classes = 'user-logout';
}
?>
<div class="sol-account-element <?php echo esc_attr( $classes ); ?>">
	<a class="sol-account-url" aria-label="<?php echo esc_attr__( 'Account', 'solace' ); ?>" href="<?php echo esc_url($link); ?>" <?php echo $amp_state; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php 
		// Check if the user is logged in
		if ( is_user_logged_in() && $user_gravatar ) {
			// Get the current user's information
			$current_user = wp_get_current_user();

			// Retrieve the user's email to fetch the Gravatar
			$email = $current_user->user_email;

			// Generate the Gravatar URL based on the user's email
			$gravatar_url = get_avatar_url($email, ['size' => '30']); // Size of 30px

			// Output the Gravatar image
			echo '<div class="user-gravatar">';
			echo '<img src="' . esc_url($gravatar_url) . '" alt="' . esc_attr($current_user->display_name) . '">';
			echo '</div>';
		} else {
			?>
			<span class="icon"><?php echo $svg_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
			<?php
		}
		?>
		<?php if ( $label !== '' ) { ?>
			<span class="label inherit-ff"><?php echo esc_html( $label ); ?></span>
		<?php } ?>
	</a>
</div>
