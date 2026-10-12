<?php
/**
 * Theme Deactivation Feedback Modal
 *
 * Shows a feedback modal when user switches away from Formula theme.
 *
 * @package formula
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue deactivation feedback scripts and styles.
 *
 * @param string $hook Current admin page hook.
 */
function formula_deactivation_feedback_scripts($hook)
{
    // Only load on themes page.
    if ('themes.php' !== $hook) {
        return;
    }

    // Only load if Formula is the active theme.
    $current_theme = wp_get_theme();
    if ('Formula' !== $current_theme->get('Name') && 'formula' !== $current_theme->get_template()) {
        return;
    }

    // Only load for users who can switch themes.
    if (!current_user_can('switch_themes')) {
        return;
    }

    // Enqueue CSS.
    wp_enqueue_style(
        'formula-deactivation-feedback',
        get_template_directory_uri() . '/inc/admin/css/deactivation-feedback.css',
        array(),
        FORMULA_THEME_VERSION
    );

    // Enqueue JS.
    wp_enqueue_script(
        'formula-deactivation-feedback',
        get_template_directory_uri() . '/inc/admin/js/deactivation-feedback.js',
        array('jquery'),
        FORMULA_THEME_VERSION,
        true
    );

    // Localize script.
    wp_localize_script(
        'formula-deactivation-feedback',
        'formulaDeactivation',
        array(
        'nonce' => wp_create_nonce('formula_deactivation_feedback'),
        'ajaxurl' => admin_url('admin-ajax.php'),
        'themeName' => 'Formula',
    )
    );
}
add_action('admin_enqueue_scripts', 'formula_deactivation_feedback_scripts');

/**
 * Output the deactivation feedback modal HTML.
 */
function formula_deactivation_feedback_modal()
{
    // Only on themes page.
    $screen = get_current_screen();
    if (!$screen || 'themes' !== $screen->id) {
        return;
    }

    // Only if Formula is active.
    $current_theme = wp_get_theme();
    if ('Formula' !== $current_theme->get('Name') && 'formula' !== $current_theme->get_template()) {
        return;
    }

    // Only for users who can switch themes.
    if (!current_user_can('switch_themes')) {
        return;
    }
?>
	<div id="formula-deactivation-modal" class="formula-deactivation-overlay" style="display: none;">
		<div class="formula-deactivation-modal">
			<button type="button" class="formula-deactivation-close" aria-label="<?php esc_attr_e('Close', 'formula'); ?>">&times;</button>

			<div class="formula-deactivation-header">
				<div class="formula-deactivation-icon">
					<span class="dashicons dashicons-megaphone"></span>
				</div>
				<h2><?php esc_html_e('Quick Feedback', 'formula'); ?></h2>
				<p><?php esc_html_e('We\'re sorry to see you go! Could you please share why you\'re switching themes?', 'formula'); ?></p>
			</div>

			<form id="formula-deactivation-form" class="formula-deactivation-body">
				<div class="formula-feedback-options">

					<label class="formula-feedback-option">
						<input type="radio" name="deactivation_reason" value="missing_features">
						<span><?php esc_html_e('The theme is missing features I need', 'formula'); ?></span>
					</label>

					<label class="formula-feedback-option">
						<input type="radio" name="deactivation_reason" value="hard_to_customize">
						<span><?php esc_html_e('The theme is difficult to customize', 'formula'); ?></span>
					</label>

					<label class="formula-feedback-option">
						<input type="radio" name="deactivation_reason" value="technical_issues">
						<span><?php esc_html_e('I\'m experiencing technical issues', 'formula'); ?></span>
					</label>

					<label class="formula-feedback-option">
						<input type="radio" name="deactivation_reason" value="temporary">
						<span><?php esc_html_e('Temporary deactivation, I\'ll be back', 'formula'); ?></span>
					</label>

					<label class="formula-feedback-option">
						<input type="radio" name="deactivation_reason" value="other">
						<span><?php esc_html_e('Other', 'formula'); ?></span>
					</label>
				</div>

				<div class="formula-feedback-details" style="display: none;">
					<label for="formula-feedback-text"><?php esc_html_e('Please share more details (optional):', 'formula'); ?></label>
					<textarea id="formula-feedback-text" name="feedback_text" rows="3" placeholder="<?php esc_attr_e('What features are missing? What issues did you face?', 'formula'); ?>"></textarea>
				</div>

				<input type="hidden" id="formula-new-theme-url" name="new_theme_url" value="">
			</form>

			<div class="formula-deactivation-footer">
				<p class="formula-feedback-note">
					<?php
    printf(
        /* translators: %s: developer email address */
        esc_html__('Note: If feedback submission fails, please email us directly at %s', 'formula'),
        '<a href="mailto:support@awplife.com">support@awplife.com</a>'
    );
?>
				</p>
				<div class="formula-deactivation-buttons">
					<button type="button" class="button formula-skip-btn"><?php esc_html_e('Skip & Deactivate', 'formula'); ?></button>
					<button type="button" class="button button-primary formula-submit-btn"><?php esc_html_e('Submit & Deactivate', 'formula'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php
}
add_action('admin_footer', 'formula_deactivation_feedback_modal');

/**
 * AJAX handler for deactivation feedback submission.
 */
function formula_submit_deactivation_feedback()
{
    // Verify nonce.
    if (!isset($_POST['nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'formula_deactivation_feedback')) {
        wp_send_json_error('Security check failed');
    }

    // Check capability.
    if (!current_user_can('switch_themes')) {
        wp_send_json_error('Unauthorized');
    }

    // Get feedback data.
    $reason = isset($_POST['reason']) ? sanitize_text_field(wp_unslash($_POST['reason'])) : '';
    $feedback = isset($_POST['feedback']) ? sanitize_textarea_field(wp_unslash($_POST['feedback'])) : '';
    $site_url = home_url();
    $wp_version = get_bloginfo('version');
    $theme_version = wp_get_theme()->get('Version');

    // Map reason codes to readable text.
    $reason_labels = array(
        'found_better' => 'Found a better theme',
        'missing_features' => 'Missing features needed',
        'hard_to_customize' => 'Difficult to customize',
        'technical_issues' => 'Technical issues',
        'temporary' => 'Temporary deactivation',
        'other' => 'Other reason',
    );

    $reason_text = isset($reason_labels[$reason]) ? $reason_labels[$reason] : $reason;

    // Prepare email content.
    $to = 'support@awplife.com';
    $subject = 'Formula Theme Deactivation Feedback';

    $message = "A user has deactivated the Formula theme.\n\n";
    $message .= "=== Deactivation Details ===\n\n";
    $message .= "Reason: {$reason_text}\n";

    if (!empty($feedback)) {
        $message .= "Additional Feedback: {$feedback}\n";
    }

    $message .= "\n=== Site Information ===\n\n";
    $message .= "Site URL: {$site_url}\n";
    $message .= "WordPress Version: {$wp_version}\n";
    $message .= "Theme Version: {$theme_version}\n";
    $message .= 'Date/Time: ' . current_time('mysql') . "\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');

    // Send email to theme author.
    wp_mail($to, $subject, $message, $headers);

    // Always return success so user can proceed with deactivation.
    wp_send_json_success(array('message' => 'Thank you for your feedback!'));
}
add_action('wp_ajax_formula_deactivation_feedback', 'formula_submit_deactivation_feedback');
