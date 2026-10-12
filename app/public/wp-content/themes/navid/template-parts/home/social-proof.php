<?php
/**
 * Homepage Section: Social Proof / Brand Logos Bar
 * Displays uploaded brand logos or falls back to About Page stat counters.
 *
 * @package Navid
 */

$show_social_proof = get_theme_mod( 'navid_social_proof_show', false );
if ( ! $show_social_proof ) {
	return;
}

$logos = array();
for ( $i = 1; $i <= 4; $i++ ) {
	$logo_url = get_theme_mod( 'navid_social_proof_logo_' . $i, '' );
	if ( ! empty( $logo_url ) ) {
		$logos[] = $logo_url;
	}
}
$sp_title = get_theme_mod( 'navid_social_proof_title', __( 'Our Partners', 'navid' ) );
?>

<div class="navid-social-proof-bar">
	<div class="container">
		<?php if ( ! empty( $sp_title ) ) : ?>
			<div class="section-bar anim-up">
				<h2><?php echo esc_html( $sp_title ); ?></h2>
			</div>
		<?php endif; ?>
		<?php if ( ! empty( $logos ) ) : ?>
			<div class="brand-logos-grid anim-up">
				<?php foreach ( $logos as $logo ) : ?>
					<div class="brand-logo-item">
						<img src="<?php echo esc_url( $logo ); ?>" alt="<?php esc_attr_e( 'Partner Brand Logo', 'navid' ); ?>" loading="lazy" />
					</div>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<div class="about-stats social-proof-stats anim-up">
				<div class="about-stat-item">
					<div class="about-stat-num"><?php echo esc_html( get_theme_mod( 'navid_about_stat1_num', '10K+' ) ); ?></div>
					<div class="about-stat-label"><?php echo esc_html( get_theme_mod( 'navid_about_stat1_label', 'Daily Readers' ) ); ?></div>
				</div>
				<div class="about-stat-item">
					<div class="about-stat-num"><?php echo esc_html( get_theme_mod( 'navid_about_stat2_num', '50+' ) ); ?></div>
					<div class="about-stat-label"><?php echo esc_html( get_theme_mod( 'navid_about_stat2_label', 'Partner Brands' ) ); ?></div>
				</div>
				<div class="about-stat-item">
					<div class="about-stat-num"><?php echo esc_html( get_theme_mod( 'navid_about_stat3_num', '24/7' ) ); ?></div>
					<div class="about-stat-label"><?php echo esc_html( get_theme_mod( 'navid_about_stat3_label', 'Expert Support' ) ); ?></div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
