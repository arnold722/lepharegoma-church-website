<?php
/**
 * Sync to Premium Panel.
 *
 * @package formula
 */
?>
<div id="sync-to-premium-panel" class="panel-left">
	<div class="formula-sync-tab">
		<!-- Hero Section -->
		<div class="formula-sync-hero">
			<div class="formula-sync-hero-icon">
				<span class="dashicons dashicons-update"></span>
			</div>
			<h2><?php esc_html_e('Sync to Premium', 'formula'); ?></h2>
			<p><?php esc_html_e('Seamlessly transfer all your free theme settings to Formula Premium in one click.', 'formula'); ?></p>
		</div>

		<!-- Info Cards Row -->
		<div class="formula-sync-info-row">
			<!-- What Gets Synced -->
			<div class="formula-sync-info-card">
				<div class="formula-sync-info-icon">
					<span class="dashicons dashicons-yes-alt"></span>
				</div>
				<h3><?php esc_html_e('What gets synced?', 'formula'); ?></h3>
				<ul>
					<li><?php esc_html_e('Theme colors & custom skin', 'formula'); ?></li>
					<li><?php esc_html_e('Header & footer layouts', 'formula'); ?></li>
					<li><?php esc_html_e('Typography settings', 'formula'); ?></li>
					<li><?php esc_html_e('Menu configurations', 'formula'); ?></li>
					<li><?php esc_html_e('Widget placements', 'formula'); ?></li>
					<li><?php esc_html_e('All Customizer options', 'formula'); ?></li>
				</ul>
			</div>

			<!-- How It Works -->
			<div class="formula-sync-info-card">
				<div class="formula-sync-info-icon formula-sync-info-icon-steps">
					<span class="dashicons dashicons-editor-ol"></span>
				</div>
				<h3><?php esc_html_e('How to use', 'formula'); ?></h3>
				<ol>
					<li>
						<strong><?php esc_html_e('Purchase Formula Premium', 'formula'); ?></strong>
						<span><?php esc_html_e('Get the premium version from our website.', 'formula'); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e('Install (don\'t activate yet)', 'formula'); ?></strong>
						<span><?php esc_html_e('Upload the premium theme but keep the free version active.', 'formula'); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e('Click Sync to Premium', 'formula'); ?></strong>
						<span><?php esc_html_e('Use the button below to transfer your settings.', 'formula'); ?></span>
					</li>
					<li>
						<strong><?php esc_html_e('Activate Premium', 'formula'); ?></strong>
						<span><?php esc_html_e('Switch to the premium theme — all settings intact!', 'formula'); ?></span>
					</li>
				</ol>
			</div>
		</div>

		<!-- CTA Section -->
		<div class="formula-sync-cta">
			<a class="formula-sync-cta-btn" href="<?php echo esc_url(admin_url('customize.php?autofocus[section]=upgrade_premium')); ?>" target="_blank">
				<span class="dashicons dashicons-update"></span>
				<?php esc_html_e('Open Sync in Customizer', 'formula'); ?>
			</a>
			<p class="formula-sync-cta-note">
				<span class="dashicons dashicons-info-outline"></span>
				<?php esc_html_e('This will open the Customizer and take you directly to the Sync button.', 'formula'); ?>
			</p>
		</div>

		<!-- Upgrade Link -->
		<div class="formula-sync-upgrade">
			<p>
				<?php
printf(
	/* translators: %s: upgrade link */
	esc_html__('Don\'t have Formula Premium yet? %s', 'formula'),
	'<a href="' . esc_url('https://awplife.com/wordpress-themes/formula-premium/') . '" target="_blank">' . esc_html__('Upgrade Now →', 'formula') . '</a>'
);
?>
			</p>
		</div>
	</div>
</div>
