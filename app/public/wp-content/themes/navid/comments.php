<?php
/**
 * Comments Template
 *
 * @package Navid
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="comments-section">
  <?php if ( have_comments() ) : ?>
    <h2 class="comments-title">
      <?php
      $comment_count = get_comments_number();
      printf(
          esc_html( _nx( '%1$s Comment', '%1$s Comments', $comment_count, 'comments title', 'navid' ) ),
          number_format_i18n( $comment_count )
      );
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments( array(
          'style'       => 'ol',
          'short_ping'  => true,
          'avatar_size' => 72,
          'callback'    => 'navid_comment_template',
      ));
      ?>
    </ol>

    <?php the_comments_navigation(); ?>
  <?php endif; ?>

  <?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
    <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'navid' ); ?></p>
  <?php endif; ?>

  <?php
  comment_form( array(
      'title_reply'          => __( 'Leave a Comment', 'navid' ),
      'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
      'title_reply_after'    => '</h3>',
      'class_form'           => 'comment-form',
      'comment_notes_before' => '',
  ));
  ?>
</div>

<?php
/**
 * Custom comment template
 */
function navid_comment_template( $comment, $args, $depth ) {
    $tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
    ?>
    <<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'comment-item' ); ?>>
      <div class="comment-meta">
        <?php echo wp_kses_post( get_avatar( $comment, 72 ) ); ?>
        <div>
          <span class="comment-author"><?php echo wp_kses_post( get_comment_author_link() ); ?></span>
          <span class="comment-date"><?php printf( esc_html__( '%1$s at %2$s', 'navid' ), esc_html( get_comment_date( '', $comment ) ), esc_html( get_comment_time() ) ); ?></span>
        </div>
      </div>
      <div class="comment-body">
        <?php comment_text(); ?>
      </div>
      <?php comment_reply_link( array_merge( $args, array(
          'depth'     => $depth,
          'max_depth' => $args['max_depth'],
      ))); ?>
    <?php
}

