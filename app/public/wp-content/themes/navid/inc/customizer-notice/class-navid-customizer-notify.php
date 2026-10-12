<?php
/**
 * Navid Customizer Notify
 *
 * @package Navid
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Navid Customizer Notify Class
 */
if (!class_exists('Navid_Customizer_Notify')) {

    class Navid_Customizer_Notify {

        /**
         * Constructor
         */
        public function __construct() {
            add_action('customize_register', array($this, 'navid_customizer_notify_register'));
            add_action('customize_controls_enqueue_scripts', array($this, 'navid_customizer_notify_scripts'));
            add_action('customize_controls_print_styles', array($this, 'navid_customizer_notify_styles'));
        }

        /**
         * Register the customizer notify section
         */
        public function navid_customizer_notify_register($wp_customize) {
            
            // Include the notify section class
            require_once get_template_directory() . '/inc/customizer-notice/class-navid-customizer-notify-section.php';

            // Register the section type
            $wp_customize->register_section_type('Navid_Customizer_Notify_Section');

            // Detect Pro plugin state
            $pro_plugin_active  = navid_is_pro_active();

            if ( $pro_plugin_active ) {
                // Pro is active — show "Pro Active" + link to manage license
                $section_title = esc_html__( 'Navid Pro ✓', 'navid' );
                $pro_btn_text  = esc_html__( 'Manage License', 'navid' );
                $pro_btn_url   = admin_url( 'themes.php?page=navid-dashboard' );
                $demo_btn_text = esc_html__( 'Pro Demo', 'navid' );
                $demo_btn_url  = 'https://navid.wpmatcha.com/';
            } else {
                // Free — show upgrade prompt
                $section_title = esc_html__( 'Navid Pro', 'navid' );
                $pro_btn_text  = esc_html__( 'Upgrade to Pro', 'navid' );
                $pro_btn_url   = 'https://wpmatcha.com/wordpress-themes/navid/';
                $demo_btn_text = esc_html__( 'Pro Demo', 'navid' );
                $demo_btn_url  = 'https://navid.wpmatcha.com/';
            }

            // Add the notify section
            $wp_customize->add_section(
                new Navid_Customizer_Notify_Section(
                    $wp_customize,
                    'navid-customizer-notify-section',
                    array(
                        'title'      => $section_title,
                        'pro_text'   => $pro_btn_text,
                        'pro_url'    => $pro_btn_url,
                        'demo_text'  => $demo_btn_text,
                        'demo_url'   => $demo_btn_url,
                        'priority'   => 1,
                    )
                )
            );
        }

        /**
         * Enqueue customizer notify scripts
         */
        public function navid_customizer_notify_scripts() {
            wp_enqueue_script(
                'navid-customizer-notify',
                get_template_directory_uri() . '/inc/customizer-notice/customizer-notify.js',
                array('jquery', 'customize-controls'),
                NAVID_VERSION,
                true
            );
        }

        /**
         * Print customizer notify styles
         */
        public function navid_customizer_notify_styles() {
            ?>
            <style type="text/css" id="navid-customizer-notify-styles-v2">
                <?php include get_template_directory() . '/inc/customizer-notice/customizer-notify.css'; ?>
            </style>
            <?php
        }
    }

    // Initialize the class
    new Navid_Customizer_Notify();
}
?>
