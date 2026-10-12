<?php
/**
 * Navid Customizer Plugin Notify
 *
 * Handles plugin recommendation system in the Customizer.
 *
 * @package Navid
 * @since 1.0.0
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Plugin recommendation system for Matcha Extra
 */
function navid_register_customizer_notify() {
    // Check if plugin is already active
    $plugin_active = is_plugin_active('matcha-extra/matcha-extra.php');

    // Don't show notice if plugin is already active
    if ($plugin_active) {
        return;
    }

    $config = array(
        'recommended_plugins' => array(
            'matcha-extra' => array(
                'recommended' => true,
                'description' => sprintf(
                    esc_html__('Install and activate %s to add companion widgets, advertisement banners, and extra customizer settings.', 'navid'),
                    '<strong>Matcha Extra</strong>'
                ),
            ),
        ),
        'recommended_actions_title' => esc_html__('Recommended Actions', 'navid'),
        'recommended_plugins_title' => esc_html__('Matcha Extra Plugin', 'navid'),
        'install_button_label' => esc_html__('Install and Activate', 'navid'),
        'activate_button_label' => esc_html__('Activate', 'navid'),
        'dismiss_button' => esc_html__('Dismiss', 'navid')
    );

    Navid_Customizer_Plugin_Notify::init($config);
}
add_action('after_setup_theme', 'navid_register_customizer_notify');

/**
 * Navid Customizer Plugin Notify Class (for plugin recommendations)
 */
class Navid_Customizer_Plugin_Notify {
    private $recommended_plugins;
    private $recommended_plugins_title;
    private $install_button_label;
    private $activate_button_label;
    private static $instance;
    private $config;

    public static function init($config) {
        if (!isset(self::$instance) && !(self::$instance instanceof Navid_Customizer_Plugin_Notify)) {
            self::$instance = new Navid_Customizer_Plugin_Notify();
            if (!empty($config) && is_array($config)) {
                self::$instance->config = $config;
                self::$instance->setup_config();
                self::$instance->setup_actions();
            }
        }
    }

    public function setup_config() {
        global $navid_customizer_notify_recommended_plugins;

        if (isset($this->config['recommended_plugins'])) {
            $navid_customizer_notify_recommended_plugins = $this->config['recommended_plugins'];
        }

        $this->recommended_plugins_title = isset($this->config['recommended_plugins_title']) ? $this->config['recommended_plugins_title'] : '';
        $this->install_button_label = isset($this->config['install_button_label']) ? $this->config['install_button_label'] : '';
        $this->activate_button_label = isset($this->config['activate_button_label']) ? $this->config['activate_button_label'] : '';
    }

    public function setup_actions() {
        add_action('customize_register', array($this, 'plugin_notification_customize_register'));
        add_action('customize_controls_enqueue_scripts', array($this, 'customizer_notify_scripts_for_customizer'), 0);
    }

    public function customizer_notify_scripts_for_customizer() {
        wp_enqueue_style(
            'navid-customizer-plugin-notify-css',
            get_template_directory_uri() . '/inc/customizer-notice/css/navid-customizer-notify.css',
            array(),
            '2.0.0'
        );

        wp_enqueue_script(
            'navid-customizer-plugin-notify-js',
            get_template_directory_uri() . '/inc/customizer-notice/js/navid-customizer-notify.js',
            array('jquery', 'customize-controls'),
            '2.0.0',
            true
        );

        wp_localize_script(
            'navid-customizer-plugin-notify-js',
            'navid_customizer_ajax',
            array(
                'ajax_url'        => admin_url( 'admin-ajax.php' ),
                'nonce'           => wp_create_nonce( 'navid_install_plugins_nonce' ),
                'installing_text' => esc_html__( 'Installing...', 'navid' ),
                'error_text'      => esc_html__( 'An error occurred during installation. Please try manually via Appearance -> Install Plugins.', 'navid' ),
                'button_text'     => esc_html__( 'Install/Activate', 'navid' )
            )
        );
    }

    public function plugin_notification_customize_register($wp_customize) {
        $section_file = get_template_directory() . '/inc/customizer-notice/navid-customizer-notify-section.php';

        if (file_exists($section_file)) {
            require_once $section_file;
        } else {
            return;
        }

        if (class_exists('Navid_Customizer_Plugin_Notify_Section')) {
            $wp_customize->register_section_type('Navid_Customizer_Plugin_Notify_Section');

            $wp_customize->add_section(
                new Navid_Customizer_Plugin_Notify_Section(
                    $wp_customize,
                    'navid-customizer-plugin-notify-section',
                    array(
                        'plugin_text' => $this->recommended_plugins_title,
                        'priority' => 0,
                    )
                )
            );
        }
    }
}
