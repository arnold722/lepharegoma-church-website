<?php
if ( class_exists( 'WooCommerce' ) ) {
    add_action( 'wp_head', 'woocommerce_demo_store' );
}
