<?php
/**
 * Template Name: Contact Page
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
?>

<main class="container" style="padding-top:clamp(40px,5vw,72px);padding-bottom:clamp(40px,5vw,72px);">
  <div class="contact-template-wrapper">
    <!-- Header Area -->
    <header class="contact-header" style="text-align:center; margin-bottom: 60px; max-width: 800px; margin-left: auto; margin-right: auto;">
      <h1 class="single-title" style="margin-bottom: 16px;"><?php the_title(); ?></h1>
      <p style="color: var(--charcoal-muted); font-size: 1.1rem; line-height: 1.6;">
        <?php esc_html_e( 'Have a question, a partnership idea, or just want to share a picture of your pet? We\'d love to hear from you!', 'navid' ); ?>
      </p>
    </header>

    <!-- Split Layout -->
    <div class="contact-split-layout" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 60px; max-width: 1000px; margin: 0 auto;">
      
      <!-- Left Side: Content & Info -->
      <div class="contact-info-area">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php if ( ! empty( get_the_content() ) ) : ?>
            <div class="single-body" style="margin-bottom: 40px;">
              <?php the_content(); ?>
            </div>
          <?php else : ?>
            <!-- Fallback Info -->
            <div class="single-body" style="margin-bottom: 40px;">
              <h3><?php esc_html_e( 'Get in Touch', 'navid' ); ?></h3>
              <p><?php esc_html_e( 'We typically reply within 24-48 hours. For customer support inquiries regarding orders, please include your order number.', 'navid' ); ?></p>
            </div>
          <?php endif; ?>
        <?php endwhile; ?>

        <div class="contact-details-blocks" style="display: flex; flex-direction: column; gap: 24px;">
          <?php 
          if ( get_theme_mod( 'navid_contact_show_email', true ) ) :
            $contact_email = get_theme_mod( 'navid_contact_email', 'hello@example.com' );
            if ( ! empty( $contact_email ) ) : 
          ?>
          <div class="contact-block">
            <h4 style="font-family: var(--font-sans); text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; color: var(--sage); margin-bottom: 8px;"><?php esc_html_e( 'Email Us', 'navid' ); ?></h4>
            <p style="font-weight: 500;"><a href="mailto:<?php echo esc_attr( $contact_email ); ?>"><?php echo esc_html( $contact_email ); ?></a></p>
          </div>
          <?php 
            endif;
          endif; 
          ?>
          
          <?php
          if ( get_theme_mod( 'navid_contact_show_social', true ) ) :
            $social_ig = get_theme_mod( 'navid_contact_social_ig', '#' );
            $social_tw = get_theme_mod( 'navid_contact_social_tw', '#' );
            $social_pi = get_theme_mod( 'navid_contact_social_pi', '#' );
            
            if ( ! empty( $social_ig ) || ! empty( $social_tw ) || ! empty( $social_pi ) ) :
          ?>
          <div class="contact-block">
            <h4 style="font-family: var(--font-sans); text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; color: var(--sage); margin-bottom: 8px;"><?php esc_html_e( 'Follow Us', 'navid' ); ?></h4>
            <div class="about-socials-large" style="display: flex; gap: 16px; margin-top: 8px;">
              <?php if ( ! empty( $social_ig ) ) : ?>
              <a href="<?php echo esc_url( $social_ig ); ?>" aria-label="<?php esc_attr_e( 'Instagram', 'navid' ); ?>" style="color: var(--charcoal); transition: color 0.2s;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5"/></svg></a>
              <?php endif; ?>
              
              <?php if ( ! empty( $social_tw ) ) : ?>
              <a href="<?php echo esc_url( $social_tw ); ?>" aria-label="<?php esc_attr_e( 'Twitter', 'navid' ); ?>" style="color: var(--charcoal); transition: color 0.2s;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M22 4s-1.2 1-2.5 1.5A4.5 4.5 0 0 0 12 8v1A10.5 10.5 0 0 1 3 4s-4 9 5 13a11.5 11.5 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.1-.9A7.4 7.4 0 0 0 22 4z"/></svg></a>
              <?php endif; ?>
              
              <?php if ( ! empty( $social_pi ) ) : ?>
              <a href="<?php echo esc_url( $social_pi ); ?>" aria-label="<?php esc_attr_e( 'Pinterest', 'navid' ); ?>" style="color: var(--charcoal); transition: color 0.2s;"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="12" y1="22" x2="12" y2="11"/><path d="M12 2A10 10 0 1 0 22 12a10 10 0 0 0-10-10"/><path d="M12 11a4 4 0 1 0-4-4"/></svg></a>
              <?php endif; ?>
            </div>
          </div>
          <?php 
            endif;
          endif; 
          ?>
        </div>
      </div>

      <!-- Right Side: Form Area -->
      <div class="contact-form-area" style="background: var(--cream); padding: 40px; border-radius: 12px;">
        <h3 style="margin-bottom: 24px; font-family: var(--font-serif);"><?php esc_html_e( 'Send a Message', 'navid' ); ?></h3>
        
        <?php
        // Try to output a WPForms or Contact Form 7 shortcode if we want a fallback
        // For this template, we assume the user will place their shortcode in the editor,
        // BUT if they just use this template, we can provide a styled hardcoded HTML form 
        // that looks good, although it won't submit without a backend.
        // It's better to tell the user to put their shortcode in the content. 
        // However, standard theme practice: if there is a plugin active, we could use it. 
        // We'll build a beautiful static form shell so it looks great, and they can replace it with a shortcode in the widget area if we register one.
        ?>
        
        <?php if ( is_active_sidebar( 'contact-form' ) ) : ?>
          <?php dynamic_sidebar( 'contact-form' ); ?>
        <?php else : ?>
          <!-- Placeholder Form (UI only) -->
          <form class="navid-placeholder-form">
            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;"><?php esc_html_e( 'Name', 'navid' ); ?></label>
              <input type="text" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 4px; font-family: inherit; background: #fff;" required>
            </div>
            <div style="margin-bottom: 16px;">
              <label style="display:block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;"><?php esc_html_e( 'Email', 'navid' ); ?></label>
              <input type="email" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 4px; font-family: inherit; background: #fff;" required>
            </div>
            <div style="margin-bottom: 24px;">
              <label style="display:block; margin-bottom: 8px; font-size: 0.9rem; font-weight: 600;"><?php esc_html_e( 'Message', 'navid' ); ?></label>
              <textarea rows="5" style="width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 4px; font-family: inherit; background: #fff; resize: vertical;" required></textarea>
            </div>
            <button type="submit" class="btn" style="width: 100%; padding: 14px; font-size: 1rem; border-radius: 4px; background: var(--sage); color: #fff; border: none; font-weight: 600; cursor: pointer; transition: background 0.2s;"><?php esc_html_e( 'Send Message', 'navid' ); ?></button>
            <p style="font-size: 0.8rem; color: var(--charcoal-muted); margin-top: 12px; text-align: center;">
              <?php esc_html_e( 'Note: This is a placeholder form. To capture submissions, replace this area with a contact form shortcode widget in Appearance > Widgets > Contact Form Area.', 'navid' ); ?>
            </p>
          </form>
        <?php endif; ?>

      </div>
    </div>
  </div>
</main>

<?php get_footer(); ?>

