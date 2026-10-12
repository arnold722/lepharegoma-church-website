<?php
/**
 * Template Name: Content Only Preview
 */

// Issue #3: never serve private content to logged-out visitors. This template
// renders the raw post content for the Site Builder dashboard preview. Only
// users who can edit the requested post may see it, and only for site-builder
// parts (publish or not — the editor needs to preview drafts too).
$preview_id = isset( $_GET['post_id'] ) ? intval( $_GET['post_id'] ) : 0;

if ( ! $preview_id ) {
	echo '<p>No post ID provided.</p>';
	return;
}

if ( ! is_user_logged_in() || ! current_user_can( 'edit_post', $preview_id ) ) {
	status_header( 403 );
	nocache_headers();
	echo '<p>Not allowed.</p>';
	return;
}

$post = get_post( $preview_id );

if ( ! $post ) {
	echo '<p>Post not found.</p>';
	return;
}

// Only Site Builder parts are meant to be previewed through this template.
if ( 'solace-sitebuilder' !== $post->post_type ) {
	status_header( 403 );
	nocache_headers();
	echo '<p>Not allowed.</p>';
	return;
}

// Set up post data
setup_postdata( $post );
// Output the post content only
echo '<div class="post-content">';
echo apply_filters( 'the_content', $post->post_content );
echo '</div>';
// Reset post data
wp_reset_postdata();
?>
