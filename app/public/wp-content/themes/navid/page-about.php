<?php
/**
 * Template Name: About Page
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>

<!-- ═══ ABOUT HERO ════════════════════════════════ -->
<div class="about-hero">
  <h1><?php echo esc_html( get_theme_mod( 'navid_about_hero_title', 'Hi, we’re Navid.' ) ); ?></h1>
  <p><?php echo esc_html( get_theme_mod( 'navid_about_hero_subtitle', 'We believe every story deserves to be told.' ) ); ?></p>
</div>

<!-- ═══ ABOUT CONTENT ═════════════════════════════ -->
<div class="about-grid <?php echo esc_attr( get_theme_mod( 'navid_about_show_image', true ) ? '' : 'no-photo' ); ?>">
  <?php if ( get_theme_mod( 'navid_about_show_image', true ) ) : ?>
  <div class="about-photo">
    <?php if ( has_post_thumbnail() ) : ?>
      <?php the_post_thumbnail( 'navid-hero' ); ?>
    <?php else : ?>
      <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/about-navid.jpg' ); ?>" alt="<?php esc_attr_e( 'About Photo', 'navid' ); ?>" />
    <?php endif; ?>
  </div>
  <?php endif; ?>
  <div class="about-text">
    <?php
    while ( have_posts() ) :
        the_post();
        if ( empty( get_the_content() ) ) :
    ?>
        <h2><?php esc_html_e( 'Hi, I\'m Sarah Mitchell', 'navid' ); ?></h2>
        <p><?php esc_html_e( 'I\'m a writer, dog mom of two (Maple and Biscuit), and the founder of Navid. I started this journal in 2024 after realizing that the most meaningful lessons in my life weren\'t coming from productivity books or TED talks — they were coming from my dogs.', 'navid' ); ?></p>
        <p><?php esc_html_e( 'Maple taught me patience. Biscuit taught me resilience. Together, they taught me that the best moments aren\'t the ones you plan — they\'re the ones you\'re present for.', 'navid' ); ?></p>
        <p><?php esc_html_e( 'Navid is where I share those observations, along with practical guides on pet care, nutrition, training, and living well with the animals who share our homes and our hearts.', 'navid' ); ?></p>
    <?php else : ?>
        <?php the_content(); ?>
    <?php endif; endwhile; ?>
    
    <div class="about-stats">
      <div>
        <div class="about-stat-num"><?php echo esc_html( get_theme_mod('navid_about_stat1_num', '10K+') ); ?></div>
        <div class="about-stat-label"><?php echo esc_html( get_theme_mod('navid_about_stat1_label', 'Daily Readers') ); ?></div>
      </div>
      <div>
        <div class="about-stat-num"><?php echo esc_html( get_theme_mod('navid_about_stat2_num', '50+') ); ?></div>
        <div class="about-stat-label"><?php echo esc_html( get_theme_mod('navid_about_stat2_label', 'Partner Brands') ); ?></div>
      </div>
      <div>
        <div class="about-stat-num"><?php echo esc_html( get_theme_mod('navid_about_stat3_num', '24/7') ); ?></div>
        <div class="about-stat-label"><?php echo esc_html( get_theme_mod('navid_about_stat3_label', 'Expert Support') ); ?></div>
      </div>
    </div>
    <?php if ( get_theme_mod( 'navid_about_show_social', true ) ) : ?>
      <?php
      $social_ig = get_theme_mod( 'navid_about_social_ig', '#' );
      $social_tw = get_theme_mod( 'navid_about_social_tw', '#' );
      $social_yt = get_theme_mod( 'navid_about_social_yt', '#' );
      $social_email = get_theme_mod( 'navid_about_social_email', '#' );
      
      // Basic formatting for email link
      if ( ! empty( $social_email ) && strpos( $social_email, '@' ) !== false && strpos( $social_email, 'mailto:' ) === false ) {
          $social_email = 'mailto:' . $social_email;
      }
      ?>
      <div class="about-socials-large">
        <?php if ( ! empty( $social_ig ) ) : ?>
        <a href="<?php echo esc_url( $social_ig ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'navid' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5"/></svg>
        </a>
        <?php endif; ?>
        
        <?php if ( ! empty( $social_tw ) ) : ?>
        <a href="<?php echo esc_url( $social_tw ); ?>" aria-label="<?php esc_attr_e( 'Twitter', 'navid' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 4s-1.2 1-2.5 1.5A4.5 4.5 0 0 0 12 8v1A10.5 10.5 0 0 1 3 4s-4 9 5 13a11.5 11.5 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.1-.9A7.4 7.4 0 0 0 22 4z"/></svg>
        </a>
        <?php endif; ?>
        
        <?php if ( ! empty( $social_yt ) ) : ?>
        <a href="<?php echo esc_url( $social_yt ); ?>" aria-label="<?php esc_attr_e( 'YouTube', 'navid' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22.5 6.9a2.8 2.8 0 0 0-2-2C18.9 4.5 12 4.5 12 4.5s-6.9 0-8.5.4a2.8 2.8 0 0 0-2 2 29 29 0 0 0-.4 5.3 29 29 0 0 0 .4 5.3 2.8 2.8 0 0 0 2 2c1.6.4 8.5.4 8.5.4s6.9 0 8.5-.4a2.8 2.8 0 0 0 2-2 29 29 0 0 0 .4-5.3 29 29 0 0 0-.4-5.3z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98" fill="currentColor" stroke="none"/></svg>
        </a>
        <?php endif; ?>
        
        <?php if ( ! empty( $social_email ) ) : ?>
        <a href="<?php echo esc_url( $social_email ); ?>" aria-label="<?php esc_attr_e( 'Email', 'navid' ); ?>">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="4" width="20" height="16" rx="2"/><polyline points="22 4 12 13 2 4"/></svg>
        </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<!-- ═══ VALUES ════════════════════════════════════ -->
<?php if ( get_theme_mod( 'navid_about_values_show_about', true ) ) : ?>
<section class="about-values">
  <div class="section-bar anim-up">
    <h2><?php echo esc_html( get_theme_mod( 'navid_about_values_title', __( 'What We Believe', 'navid' ) ) ); ?></h2>
  </div>
  <div class="values-grid">
    <?php
    $default_titles = array( 1 => 'Quality First', 2 => 'Community', 3 => 'Sustainability', 4 => 'Pure Joy' );
    $default_descs = array(
        1 => 'Every product is tested by experts (and our own pets).',
        2 => 'We’re building a family of passionate pet lovers.',
        3 => 'Eco-friendly packaging and ethical sourcing, always.',
        4 => 'Because pets bring out the best in all of us.'
    );
    $icons = array(
        1 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        2 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><line x1="9" y1="9" x2="9.01" y2="9"/><line x1="15" y1="9" x2="15.01" y2="9"/></svg>',
        3 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        4 => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>'
    );
    
    for ( $i = 1; $i <= 4; $i++ ) {
        $v_title = get_theme_mod( 'navid_about_val' . $i . '_title', $default_titles[$i] );
        $v_desc = get_theme_mod( 'navid_about_val' . $i . '_desc', $default_descs[$i] );
        if ( ! empty( $v_title ) ) :
    ?>
    <div class="value-card anim-up d<?php echo $i; ?>">
      <div class="value-icon">
        <a href="#">
          <?php echo $icons[$i]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
        </a>
      </div>
      <h3><?php echo esc_html( $v_title ); ?></h3>
      <p><?php echo esc_html( $v_desc ); ?></p>
    </div>
    <?php 
        endif;
    } 
    ?>
  </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
