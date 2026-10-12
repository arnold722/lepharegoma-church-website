<?php
/**
 * Search Form Template
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label style="flex: 1; display: flex; margin: 0;">
    <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'navid' ); ?></span>
    <input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search&hellip;', 'navid' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" style="width: 100%;" />
  </label>
  <button type="submit" class="search-submit">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="10.5" cy="10.5" r="6.5"/><line x1="15.5" y1="15.5" x2="21" y2="21"/></svg>
    <span class="screen-reader-text"><?php esc_html_e( 'Search', 'navid' ); ?></span>
  </button>
</form>

