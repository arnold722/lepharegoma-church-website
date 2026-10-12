<?php
/**
 * Homepage Section: Services / Values Grid
 * Shares settings with the About Page values grid.
 *
 * @package Navid
 */

$show_on_home = get_theme_mod( 'navid_about_values_show_home', false );
if ( ! $show_on_home ) {
	return;
}

$section_title = get_theme_mod( 'navid_about_values_title', __( 'What We Believe', 'navid' ) );

$default_titles = array(
	1 => 'Quality First',
	2 => 'Community',
	3 => 'Sustainability',
	4 => 'Pure Joy',
);
$default_descs  = array(
	1 => 'Every product is tested by experts (and our own pets).',
	2 => 'We’re building a family of passionate pet lovers.',
	3 => 'Eco-friendly packaging and ethical sourcing, always.',
	4 => 'Because pets bring out the best in all of us.',
);
$icons          = array(
	1 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
	2 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>',
	3 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
	4 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>',
);
?>

<section class="about-values navid-home-services">
	<?php if ( ! empty( $section_title ) ) : ?>
	<div class="section-bar anim-up">
		<h2><?php echo esc_html( $section_title ); ?></h2>
	</div>
	<?php endif; ?>
	<div class="values-grid">
		<?php
		for ( $i = 1; $i <= 4; $i++ ) {
			$v_title = get_theme_mod( 'navid_about_val' . $i . '_title', $default_titles[ $i ] );
			$v_desc  = get_theme_mod( 'navid_about_val' . $i . '_desc', $default_descs[ $i ] );
			if ( ! empty( $v_title ) ) :
				?>
				<div class="value-card">
					<div class="value-icon">
						<?php echo navid_sanitize_svg( $icons[ $i ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<h3><?php echo esc_html( $v_title ); ?></h3>
					<?php if ( ! empty( $v_desc ) ) : ?>
					<p><?php echo esc_html( $v_desc ); ?></p>
					<?php endif; ?>
				</div>
				<?php
			endif;
		}
		?>
	</div>
</section>
