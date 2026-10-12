<?php
/**
 * Upgrade to pro options
 */
function formula_upgrade_pro_options($wp_customize)
{

	$wp_customize->add_section(
		'upgrade_premium',
		array(
		'title' => __('Upgrade to Pro', 'formula'),
		'priority' => 1,
	)
	);

	class formula_Pro_Button_Customize_Control extends WP_Customize_Control
	{
		public $type = 'upgrade_premium';

		function render_content()
		{
?>
			<div class="formula-customizer-about">
				<!-- Premium Features Showcase -->
				<div class="formula-about-hero formula-pro-features-hero">
					<h3><?php esc_html_e('🚀 Go Premium', 'formula'); ?></h3>
					<p><?php esc_html_e('Unlock the full power of Formula with exclusive premium features.', 'formula'); ?></p>
				</div>

				<!-- Features Grid -->
				<div class="formula-pro-features-grid">
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-desktop"></span>
						<strong><?php esc_html_e('Dark & Light Mode', 'formula'); ?></strong>
						<span><?php esc_html_e('Built-in theme mode switcher.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-cart"></span>
						<strong><?php esc_html_e('WooCommerce Ready', 'formula'); ?></strong>
						<span><?php esc_html_e('Full shop integration.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-images-alt2"></span>
						<strong><?php esc_html_e('Slider Sections', 'formula'); ?></strong>
						<span><?php esc_html_e('Multiple homepage sliders.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-portfolio"></span>
						<strong><?php esc_html_e('Portfolio & Gallery', 'formula'); ?></strong>
						<span><?php esc_html_e('Showcase your work beautifully.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-editor-textcolor"></span>
						<strong><?php esc_html_e('Custom Typography', 'formula'); ?></strong>
						<span><?php esc_html_e('800+ Google Fonts.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-groups"></span>
						<strong><?php esc_html_e('Team Section', 'formula'); ?></strong>
						<span><?php esc_html_e('Display team members.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-testimonial"></span>
						<strong><?php esc_html_e('Testimonials', 'formula'); ?></strong>
						<span><?php esc_html_e('Client reviews carousel.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-megaphone"></span>
						<strong><?php esc_html_e('Call to Action', 'formula'); ?></strong>
						<span><?php esc_html_e('Conversion-focused CTAs.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-admin-customizer"></span>
						<strong><?php esc_html_e('Top Bar', 'formula'); ?></strong>
						<span><?php esc_html_e('Contact info & social links.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-download"></span>
						<strong><?php esc_html_e('One-Click Demo', 'formula'); ?></strong>
						<span><?php esc_html_e('Import demos instantly.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-chart-bar"></span>
						<strong><?php esc_html_e('Fun Facts Counter', 'formula'); ?></strong>
						<span><?php esc_html_e('Animated statistics.', 'formula'); ?></span>
					</div>
					<div class="formula-pro-feature">
						<span class="dashicons dashicons-layout"></span>
						<strong><?php esc_html_e('10+ Page Templates', 'formula'); ?></strong>
						<span><?php esc_html_e('Blog, portfolio, contact & more.', 'formula'); ?></span>
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="formula-about-actions">
					<a class="formula-btn formula-btn-upgrade" href="<?php echo esc_url('https://awplife.com/wordpress-themes/formula-premium/'); ?>" target="_blank">
						<span class="dashicons dashicons-star-filled"></span>
						<?php esc_html_e('Upgrade to Pro', 'formula'); ?>
					</a>

					<a class="formula-btn formula-btn-secondary" href="<?php echo esc_url('https://awplife.com/wordpress-themes/formula-premium/#pricing-section'); ?>" target="_blank">
						<span class="dashicons dashicons-editor-table"></span>
						<?php esc_html_e('Free vs Pro', 'formula'); ?>
					</a>

					<button type="button" class="formula-btn formula-btn-sync" id="formula-sync-btn">
						<span class="dashicons dashicons-update"></span>
						<?php esc_html_e('Sync to Premium', 'formula'); ?>
					</button>
					<p class="formula-sync-hint">
						<span class="dashicons dashicons-info-outline"></span>
						<?php esc_html_e('Use this after purchasing Formula Premium. It transfers all your current free theme settings (colors, layouts, fonts, etc.) to the premium version automatically — so you don\'t lose any customization.', 'formula'); ?>
					</p>
				</div>

				<!-- Quick Links -->
				<div class="formula-about-links">
					<a href="<?php echo esc_url('https://awplife.com/contact'); ?>" target="_blank">
						<span class="dashicons dashicons-sos"></span> <?php esc_html_e('Support', 'formula'); ?>
					</a>
					<a href="<?php echo esc_url('https://wordpress.org/themes/formula/'); ?>" target="_blank">
						<span class="dashicons dashicons-heart"></span> <?php esc_html_e('Rate Us', 'formula'); ?>
					</a>
				</div>
			</div>
			<?php
		}
	}

	$wp_customize->add_setting(
		'pro_info_buttons',
		array(
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'formula_sanitize_text',
	)
	);

	$wp_customize->add_control(
		new formula_Pro_Button_Customize_Control(
		$wp_customize,
		'pro_info_buttons',
		array(
		'section' => 'upgrade_premium',
	)
		)
	);

	// Enqueue Sync Script
	if (!function_exists('formula_enqueue_sync_script')) {
		function formula_enqueue_sync_script()
		{
			wp_enqueue_script('formula-sync-settings', get_template_directory_uri() . '/inc/customizer/assets/js/sync-settings.js', array('jquery'), '1.0', true);

			wp_localize_script('formula-sync-settings', 'formulaSync', array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('formula_sync_nonce'),
				'syncing_text' => __('Syncing...', 'formula')
			));
		}
		add_action('customize_controls_enqueue_scripts', 'formula_enqueue_sync_script');
	}
}
add_action('customize_register', 'formula_upgrade_pro_options');
