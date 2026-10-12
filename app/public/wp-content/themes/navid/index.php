<?php
/**
 * Main Template File
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( is_front_page() ) {
    get_template_part( 'front-page' );
} else {
    get_template_part( 'home' );
}
