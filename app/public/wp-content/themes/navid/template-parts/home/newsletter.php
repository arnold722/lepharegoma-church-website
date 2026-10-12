<?php
/**
 * Homepage Section: Newsletter CTA
 */
?>
<section class="newsletter-cta">
  <div class="newsletter-card anim-up">
    <div class="newsletter-text">
      <h3><?php echo wp_kses_post( get_theme_mod( 'navid_newsletter_heading', __( 'Stories worth<br><em>remembering</em>.', 'navid' ) ) ); ?></h3>
      <p><?php echo esc_html( get_theme_mod( 'navid_newsletter_desc', __( 'Weekly essays, guides, and fresh perspectives. Join 12,000+ readers.', 'navid' ) ) ); ?></p>
    </div>
    <?php if ( has_action( 'navid_newsletter_form' ) ) : ?>
      <?php do_action( 'navid_newsletter_form' ); ?>
    <?php else : ?>
      <?php 
      $action_url = get_theme_mod( 'navid_newsletter_action', '#' ); 
      
      // If the action looks like a shortcode (has [ and ])
      if ( strpos( $action_url, '[' ) !== false && strpos( $action_url, ']' ) !== false ) : 
          echo do_shortcode( $action_url );
      else :
      ?>
          <form class="newsletter-form" action="<?php echo esc_url( $action_url ); ?>" method="post">
            <input type="email" name="email" placeholder="<?php esc_attr_e( 'email@example.com', 'navid' ); ?>" required />
            <button type="submit" class="btn-subscribe"><?php esc_html_e( 'Subscribe', 'navid' ); ?></button>
          </form>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>
