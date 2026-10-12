<?php
/**
 * Navid Theme Dashboard
 *
 * @package Navid
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Navid_Blog_Dashboard' ) ) :

    class Navid_Blog_Dashboard {

        /**
         * Constructor
         */
        public function __construct() {
            add_action( 'admin_menu', array( $this, 'add_theme_page' ) );
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
            add_action( 'admin_head', array( $this, 'admin_menu_highlight' ) );
            add_action( 'admin_notices', array( $this, 'theme_page_notice' ) );
            add_action( 'admin_init', array( $this, 'handle_notice_dismissal' ) );
            add_action( 'wp_ajax_navid_install_activate_plugins', array( $this, 'ajax_install_activate_plugins' ) );
            add_action( 'wp_ajax_navid_install_activate_single_plugin', array( $this, 'ajax_install_activate_single_plugin' ) );
            add_action( 'wp_ajax_navid_get_ocdi_nonce', array( $this, 'ajax_get_ocdi_nonce' ) );
            add_action( 'wp_ajax_navid_save_import_branding', array( $this, 'ajax_save_import_branding' ) );
            add_action( 'pt-ocdi/after_import', array( $this, 'apply_import_branding' ), 99 );
        }


        /**
         * AJAX handler to install and activate recommended plugins (Matcha Extra and OCDI)
         */
        public function ajax_install_activate_plugins() {
            check_ajax_referer( 'navid_install_plugins_nonce' );

            if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
                wp_send_json_error( [ 'message' => __( 'Permission denied.', 'navid' ) ] );
            }

            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            include_once ABSPATH . 'wp-admin/includes/plugin.php';

            if ( ! class_exists( 'Automatic_Upgrader_Skin' ) ) {
                include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';
            }

            $plugins = [
                'one-click-demo-import' => 'one-click-demo-import/one-click-demo-import.php',
                'matcha-extra'          => 'matcha-extra/matcha-extra.php',
            ];

            foreach ( $plugins as $slug => $file ) {
                // If not installed, try to install from repo
                if ( ! file_exists( WP_PLUGIN_DIR . '/' . $file ) ) {
                    $api = plugins_api( 'plugin_information', [ 'slug' => $slug, 'fields' => [ 'sections' => false ] ] );
                    if ( ! is_wp_error( $api ) ) {
                        $upgrader = new Plugin_Upgrader( new Automatic_Upgrader_Skin() );
                        $upgrader->install( $api->download_link );
                    }
                }
                
                // If exists but inactive, activate it
                if ( file_exists( WP_PLUGIN_DIR . '/' . $file ) && ! is_plugin_active( $file ) ) {
                    activate_plugin( $file );
                }
            }

            wp_send_json_success();
        }

        /**
         * AJAX handler to install and/or activate a single plugin from the Recommended tab
         */
        public function ajax_install_activate_single_plugin() {
            check_ajax_referer( 'navid_plugin_action_nonce', 'security' );

            if ( ! current_user_can( 'install_plugins' ) || ! current_user_can( 'activate_plugins' ) ) {
                wp_send_json_error( array( 'message' => __( 'Permission denied.', 'navid' ) ) );
            }

            $slug = ! empty( $_POST['slug'] ) ? sanitize_key( $_POST['slug'] ) : '';
            $file = ! empty( $_POST['file'] ) ? sanitize_text_field( wp_unslash( $_POST['file'] ) ) : '';

            if ( empty( $slug ) || empty( $file ) ) {
                wp_send_json_error( array( 'message' => __( 'Missing plugin parameter.', 'navid' ) ) );
            }

            include_once ABSPATH . 'wp-admin/includes/plugin.php';

            // 1. If already active, return success immediately
            if ( is_plugin_active( $file ) ) {
                wp_send_json_success( array( 'status' => 'active' ) );
            }

            // 2. If already installed locally, activate it
            if ( file_exists( WP_PLUGIN_DIR . '/' . $file ) ) {
                $activated = activate_plugin( $file );
                if ( is_wp_error( $activated ) ) {
                    wp_send_json_error( array( 'message' => $activated->get_error_message() ) );
                }
                wp_send_json_success( array( 'status' => 'active' ) );
            }

            // 3. Otherwise install from WordPress.org
            include_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';

            if ( ! class_exists( 'Automatic_Upgrader_Skin' ) ) {
                include_once ABSPATH . 'wp-admin/includes/class-automatic-upgrader-skin.php';
            }

            $api = plugins_api( 'plugin_information', array( 'slug' => $slug, 'fields' => array( 'sections' => false ) ) );
            if ( is_wp_error( $api ) ) {
                wp_send_json_error( array( 'message' => $api->get_error_message() ) );
            }

            $upgrader = new Plugin_Upgrader( new Automatic_Upgrader_Skin() );
            $install_res = $upgrader->install( $api->download_link );
            if ( is_wp_error( $install_res ) ) {
                wp_send_json_error( array( 'message' => $install_res->get_error_message() ) );
            }

            // Activate after install
            if ( file_exists( WP_PLUGIN_DIR . '/' . $file ) ) {
                $activated = activate_plugin( $file );
                if ( is_wp_error( $activated ) ) {
                    wp_send_json_error( array( 'message' => $activated->get_error_message() ) );
                }
            }

            wp_send_json_success( array( 'status' => 'active' ) );
        }

        /**
         * Return a fresh OCDI nonce so the dashboard JS can call OCDI AJAX directly.
         */
        public function ajax_get_ocdi_nonce() {
            check_ajax_referer( 'navid_import_nonce', 'security' );
            if ( ! current_user_can( 'manage_options' ) ) {
                wp_send_json_error( array( 'message' => __( 'Permission denied.', 'navid' ) ) );
            }
            wp_send_json_success( array(
                'nonce'    => wp_create_nonce( 'ocdi-ajax-verification' ),
                'ajax_url' => admin_url( 'admin-ajax.php' ),
            ) );
        }

        /**
         * AJAX handler to save temporary branding choices before demo import
         */
        public function ajax_save_import_branding() {
            check_ajax_referer( 'navid_import_branding_nonce', 'security' );

            if ( ! current_user_can( 'edit_theme_options' ) ) {
                wp_send_json_error();
            }

            $branding = array(
                'palette'    => ! empty( $_POST['palette'] ) ? sanitize_key( $_POST['palette'] ) : 'sage',
                'typography' => ! empty( $_POST['typography'] ) ? sanitize_key( $_POST['typography'] ) : 'classic',
            );

            update_option( 'navid_temp_import_branding', $branding );
            wp_send_json_success( $branding );
        }

        /**
         * Apply customizer branding after OCDI import finishes
         */
        public function apply_import_branding() {
            $branding = get_option( 'navid_temp_import_branding' );
            if ( ! empty( $branding ) && is_array( $branding ) ) {
                if ( ! empty( $branding['palette'] ) ) {
                    $palette = sanitize_key( $branding['palette'] );
                    set_theme_mod( 'navid_color_palette', $palette );
                    
                    // Map palette to primary accent hex for consistency
                    $accent_map = array(
                        'sage'  => '#728c69',
                        'ocean' => '#2d6a8a',
                        'rose'  => '#b5565d',
                        'amber' => '#c47834',
                        'slate' => '#5a6575',
                        'plum'  => '#7a5c8a',
                    );
                    if ( isset( $accent_map[ $palette ] ) ) {
                        set_theme_mod( 'navid_accent_color', $accent_map[ $palette ] );
                    }
                }
                if ( ! empty( $branding['typography'] ) ) {
                    switch ( $branding['typography'] ) {
                        case 'classic':
                            set_theme_mod( 'navid_heading_font', 'Lora' );
                            set_theme_mod( 'navid_body_font', 'Merriweather' );
                            break;
                        case 'modern':
                            set_theme_mod( 'navid_heading_font', 'Outfit' );
                            set_theme_mod( 'navid_body_font', 'Inter' );
                            break;
                        case 'elegant':
                            set_theme_mod( 'navid_heading_font', 'Playfair Display' );
                            set_theme_mod( 'navid_body_font', 'Source Serif Pro' );
                            break;
                        case 'system':
                            set_theme_mod( 'navid_heading_font', 'System / Uploaded Font' );
                            set_theme_mod( 'navid_body_font', 'Roboto' );
                            break;
                    }
                }
                delete_option( 'navid_temp_import_branding' );
            }

            // Clean up any hardcoded demo home URLs in imported navigation menus
            $this->clean_imported_demo_menu_urls();
        }

        /**
         * Replace hardcoded demo home URLs in imported navigation menus with the current site home URL.
         */
        public function clean_imported_demo_menu_urls() {
            $menu_items = get_posts( array(
                'post_type'      => 'nav_menu_item',
                'post_status'    => 'any',
                'posts_per_page' => -1,
            ) );

            if ( empty( $menu_items ) ) {
                return;
            }

            $home_url  = trailingslashit( home_url() );
            $demo_host = 'navid.wpmatcha.com';

            foreach ( $menu_items as $item ) {
                $url = get_post_meta( $item->ID, '_menu_item_url', true );
                if ( ! empty( $url ) && false !== strpos( $url, $demo_host ) ) {
                    $path = trim( (string) wp_parse_url( $url, PHP_URL_PATH ), '/' );
                    // Check if this was a root home link or known demo root slug
                    if ( in_array( $path, array( '', 'magazine', 'newspaper', 'news', 'bento' ), true ) ) {
                        update_post_meta( $item->ID, '_menu_item_url', esc_url_raw( $home_url ) );
                    }
                }
            }
        }


        /**
         * Handle dismissal of the themes page welcome notice
         */
        public function handle_notice_dismissal() {
            if ( isset( $_GET['navid_dismiss_notice'] ) ) {
                update_user_meta( get_current_user_id(), 'navid_theme_notice_dismissed', true );
                wp_safe_redirect( remove_query_arg( 'navid_dismiss_notice' ) );
                exit;
            }
        }

        /**
         * Display a welcome banner on the native Appearance -> Themes screen
         */
        public function theme_page_notice() {
            global $pagenow;
            // Only show on themes.php grid (not when editing a theme or in customizer)
            if ( 'themes.php' !== $pagenow || isset( $_GET['page'] ) ) {
                return;
            }

            // Do not show if dismissed
            if ( get_user_meta( get_current_user_id(), 'navid_theme_notice_dismissed', true ) ) {
                return;
            }

            $dashboard_url = admin_url( 'themes.php?page=navid-dashboard' );
            $starter_sites_url = admin_url( 'themes.php?page=navid-dashboard&tab=starter-sites' );
            ?>
            <div class="notice notice-info navid-theme-notice is-dismissible" style="border-left-color: #728c69; border-left-width: 3px; padding: 25px 30px; display: flex; align-items: center; justify-content: space-between; background: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.04); border-radius: 4px; margin-top: 15px;">
                <div class="navid-notice-content">
                    <h3 style="margin: 0 0 12px; font-size: 1.4em; color: #1d2327; font-weight: 700;">👋 <?php esc_html_e( 'Welcome to Navid', 'navid' ); ?></h3>
                    <p style="margin: 0 0 20px; font-size: 15px; color: #50575e; max-width: 600px; line-height: 1.5;"><?php esc_html_e( 'Thank you for choosing Navid! Get started immediately by importing a professional starter site, or jump straight into the customizer to start building from scratch.', 'navid' ); ?></p>
                      <div style="display: block; margin-top: 15px;">
                          <a href="<?php echo esc_url( $starter_sites_url ); ?>" class="button button-primary" style="background: #728c69; border-color: #617a59; padding: 6px 16px; height: auto; font-weight: 600; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-right: 12px; text-decoration: none; line-height: 1.5; vertical-align: middle;">
                              <span class="dashicons dashicons-download" style="vertical-align: middle; margin-top: -3px; margin-right: 4px;"></span> 
                              <span style="vertical-align: middle;"><?php esc_html_e( 'Import Starter Site', 'navid' ); ?></span>
                          </a>
                          <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button" style="padding: 6px 16px; height: auto; font-weight: 600; margin-right: 20px; text-decoration: none; line-height: 1.5; vertical-align: middle;">
                              <span class="dashicons dashicons-admin-customizer" style="vertical-align: middle; margin-top: -3px; margin-right: 4px;"></span> 
                              <span style="vertical-align: middle;"><?php esc_html_e( 'Customize', 'navid' ); ?></span>
                          </a>
                          <a href="<?php echo esc_url( $dashboard_url ); ?>" style="text-decoration: none; color: #728c69; font-weight: 600; vertical-align: middle; line-height: 1.5; display: inline-block;"><?php esc_html_e( 'Theme Dashboard &rarr;', 'navid' ); ?></a>
                      </div>
                </div>
                <div class="navid-notice-image" style="max-width: 220px; overflow: hidden; border-radius: 6px; box-shadow: 0 4px 8px rgba(0,0,0,0.08); flex-shrink: 0; margin-left: 20px;">
                    <img src="<?php echo esc_url( get_template_directory_uri() . '/screenshot.png' ); ?>" alt="<?php esc_attr_e( 'Navid Theme', 'navid' ); ?>" style="width: 100%; height: auto; display: block; border: 1px solid rgba(0,0,0,0.05);">
                </div>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // WordPress handles the 'is-dismissible' class natively, but we need to fire our backend logic when it's clicked
                var notice = document.querySelector('.navid-theme-notice');
                if (notice) {
                    notice.addEventListener('click', function(e) {
                        if (e.target.classList.contains('notice-dismiss')) {
                            fetch('<?php echo esc_url( admin_url( 'themes.php?navid_dismiss_notice=1' ) ); ?>', { method: 'GET' });
                        }
                    });
                }
            });
            </script>
            <?php
        }

        /**
         * Register the Dashboard page under Appearance
         */
        public function add_theme_page() {
            add_theme_page(
                esc_html__( 'Navid Dashboard', 'navid' ),     // Page title
                esc_html__( 'Navid Dashboard', 'navid' ),     // Menu title
                'edit_theme_options',                         // Capability
                'navid-dashboard',                            // Menu slug
                array( $this, 'render_dashboard_page' )       // Callback
            );

            // "Starter Sites" shortcut — links to the same dashboard page with tab=starter-sites.
            add_theme_page(
                esc_html__( 'Starter Sites', 'navid' ),
                esc_html__( 'Starter Sites', 'navid' ),
                'edit_theme_options',
                'navid-dashboard&tab=starter-sites',
                array( $this, 'render_dashboard_page' )
            );
        }

        /**
         * Highlight the Navid Theme menu item in the admin menu
         */
        public function admin_menu_highlight() {
            ?>
            <style>
                #adminmenu a[href="themes.php?page=navid-dashboard"] {
                    color: #fff !important;
                    font-weight: 600 !important;
                    background-color: #728c69 !important;
                    border-radius: 4px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                    padding-left: 10px;
                    transition: background-color 0.15s ease-in-out;
                }
                #adminmenu a[href="themes.php?page=navid-dashboard"]:hover,
                #adminmenu a[href="themes.php?page=navid-dashboard"]:focus {
                    background-color: #5c7454 !important;
                    color: #fff !important;
                }
                #adminmenu a[href="themes.php?page=navid-dashboard"]::after {
                    content: '✦';
                    font-size: 14px;
                    margin-left: 6px;
                    vertical-align: middle;
                    color: rgba(255,255,255,0.8);
                }
            </style>
            <?php
        }

        /**
         * Enqueue scoped admin styles for the dashboard
         */
        public function enqueue_styles( $hook ) {
            // Only load on our specific dashboard page
            if ( 'appearance_page_navid-dashboard' !== $hook ) {
                return;
            }

            $css = "
            /* Full width reset for the dashboard */
            #wpcontent { padding-left: 0; }
            .navid-dashboard-app { background: #f0f0f1; min-height: calc(100vh - 32px); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; }
            
            /* Top Navigation Bar */
            .navid-dashboard-header { background: #fff; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; justify-content: flex-start; gap: 50px; padding: 0 40px; height: 70px; position: sticky; top: 32px; z-index: 10; }
            .navid-dashboard-logo { display: flex; align-items: center; gap: 12px; }
            .navid-dashboard-logo h3 { margin: 0; font-size: 22px; font-weight: 800; color: #1d2327; letter-spacing: -0.5px; }
            .navid-dashboard-logo h3 span { font-weight: 400; color: #646970; }
            .navid-version { background: #f0f0f1; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 600; color: #50575e; letter-spacing: 0.5px; }
            
            .navid-dashboard-nav { display: flex; align-items: center; height: 100%; gap: 30px; }
            .navid-dashboard-nav a { display: flex; align-items: center; height: 100%; text-decoration: none; color: #50575e; font-weight: 600; font-size: 15px; border-bottom: 3px solid transparent; transition: all 0.2s; padding: 0 5px; }
            .navid-dashboard-nav a:hover { color: #1d2327; }
            .navid-dashboard-nav a.active { color: #728c69; border-bottom-color: #728c69; }

            /* Main Content Area */
            .navid-dashboard-content { max-width: 1200px; margin: 0 auto; padding: 40px 20px; }
            
            .navid-dashboard-grid { display: grid; grid-template-columns: 2.2fr 1fr; gap: 40px; align-items: start; }
            @media (max-width: 1024px) { .navid-dashboard-grid { grid-template-columns: 1fr; } }
            
            /* Why Upgrade Features */
            .navid-upgrade-features { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
            .navid-feature-box { background: #fff; border: 1px solid #e2e8f0; padding: 25px 20px; border-radius: 12px; text-align: center; transition: transform 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
            .navid-feature-box:hover { transform: translateY(-3px); border-color: #cbd5e1; box-shadow: 0 8px 16px rgba(0,0,0,0.06); }
            .navid-feature-icon { width: 40px; height: 40px; background: rgba(114, 140, 105, 0.1); color: #728c69; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; }
            .navid-feature-box h4 { margin: 0 0 10px; font-size: 1.1em; color: #0f172a; font-weight: 700; }
            .navid-feature-box p { margin: 0; font-size: 0.9em; color: #64748b; line-height: 1.5; }

            /* Minimal Cards */
            .navid-main-col { background: transparent; }
            .navid-sidebar-col { display: flex; flex-direction: column; gap: 20px; }
            .navid-sidebar-card { background: #fff; padding: 30px; text-align: left; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
            .navid-sidebar-card h3 { font-size: 1.1em; color: #0f172a; margin: 0 0 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px; }
            .navid-sidebar-card p { font-size: 0.95em; color: #64748b; margin: 0 0 20px; line-height: 1.6; }
            
            /* Minimal Table */
            .navid-table-wrap { overflow-x: auto; background: #fff; padding: 40px; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
            .navid-comparison-title { font-size: 1.5em; color: #0f172a; margin: 0 0 25px; font-weight: 800; text-align: left; text-transform: uppercase; letter-spacing: 0.05em; }
            .navid-comparison-table { width: 100%; border-collapse: separate; border-spacing: 0; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; }
            .navid-comparison-table th, .navid-comparison-table td { padding: 18px 20px; text-align: left; border-bottom: 1px solid #e2e8f0; color: #475569; font-size: 15px; }
            .navid-comparison-table th { background: #f8fafc; font-weight: 700; font-size: 0.95em; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 2px solid #e2e8f0; }
            .navid-comparison-table tr:last-child td { border-bottom: none; }
            .navid-comparison-table .feature-col { width: 45%; }
            .navid-comparison-table .free-col, .navid-comparison-table .pro-col { width: 27.5%; text-align: center; }
            .navid-comparison-table .pro-col { background: #f8fafc; }
            .navid-comparison-table td.pro-col { font-weight: 600; color: #0f172a; }
            .navid-icon-yes { color: #728c69; font-weight: bold; font-size: 1.4em; }
            .navid-icon-no { color: #cbd5e1; font-weight: bold; font-size: 1.4em; }
            .navid-table-subheader { background: #f1f5f9; font-weight: 700 !important; color: #334155; font-size: 0.85em; text-transform: uppercase; letter-spacing: 0.05em; padding-top: 16px !important; padding-bottom: 12px !important; }
            
            /* CTA & Buttons */
            .navid-cta-wrap { text-align: center; padding: 40px; background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; margin-top: 40px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
            .navid-cta-wrap h3 { font-size: 1.6em; color: #0f172a; margin: 0 0 10px; font-weight: 800; }
            .navid-cta-wrap p { font-size: 1.1em; color: #475569; margin: 0 0 25px; }
            .navid-btn { display: inline-block; padding: 12px 28px; font-size: 0.95em; font-weight: 600; text-decoration: none; transition: all 0.2s; border: none; cursor: pointer; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 6px; }
            .navid-btn-primary { background: #728c69; color: #fff; }
            .navid-btn-primary:hover { background: #5c7454; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(114, 140, 105, 0.2); }
            .navid-btn-secondary { background: #fff; color: #0f172a; margin-right: 15px; border: 1px solid #cbd5e1; }
            .navid-btn-secondary:hover { background: #f8fafc; color: #0f172a; border-color: #94a3b8; }
            .navid-btn-outline { background: transparent; border: 1px solid #cbd5e1; color: #334155; padding: 10px 20px; font-size: 0.85em; width: 100%; text-align: center; box-sizing: border-box; }
            .navid-btn-outline:hover { background: #f8fafc; color: #728c69; border-color: #728c69; }

            /* Starter Sites Gallery */
            .navid-starter-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
            @media (max-width: 768px) { .navid-starter-grid { grid-template-columns: 1fr; } }
            .navid-starter-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; transition: transform 0.2s, box-shadow 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
            .navid-starter-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
            .navid-starter-thumb { overflow: hidden; aspect-ratio: 4/3; background: #f0f0f1; }
            .navid-starter-thumb img { width: 100%; height: 100%; object-fit: cover; object-position: top; display: block; transition: transform 0.4s ease; }
            .navid-starter-card:hover .navid-starter-thumb img { transform: scale(1.03); }
            .navid-starter-info { padding: 20px; }
            .navid-starter-info h4 { margin: 0 0 16px; font-size: 1.1em; font-weight: 700; color: #0f172a; }
            .navid-starter-actions { display: flex; gap: 10px; }
            .navid-starter-actions .navid-btn { padding: 8px 18px; font-size: 0.85em; margin-right: 0; }
            .navid-starter-thumb { position: relative; }
            .navid-thumb-placeholder { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: #f0f0f1; color: #c3c4c7; }
            .navid-thumb-placeholder .dashicons { font-size: 48px; width: 48px; height: 48px; }

            /* Locked Pro Cards */
            /* Removed grayscale filter for locked cards per user request */
            .navid-lock-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.45); display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 6px; color: #fff; font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; }
            .navid-lock-overlay .dashicons { font-size: 28px; width: 28px; height: 28px; }

            /* Badges */
            .navid-free-badge, .navid-pro-badge { position: absolute; top: 12px; right: 12px; padding: 4px 10px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
            .navid-free-badge { background: #728c69; color: #fff; }
            .navid-pro-badge { background: #c78c3e; color: #fff; }
            @keyframes navid-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }

            /* Recommended Tab Styles */
            .navid-rec-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important; border-color: #cbd5e1 !important; }
            .navid-rec-plugin-card:hover { transform: translateY(-3px); border-color: #cbd5e1 !important; box-shadow: 0 6px 18px rgba(0,0,0,0.06) !important; }
            .navid-plugin-action-btn { transition: all 0.2s ease; }
            .navid-plugin-action-btn:hover { background: #5c7454 !important; color: #fff !important; transform: translateY(-1px); }
            @media (max-width: 1200px) {
                .navid-rec-matcha-plugin-grid, .navid-rec-plugin-grid { grid-template-columns: repeat(2, 1fr) !important; }
            }
            @media (max-width: 900px) {
                .navid-rec-theme-grid, .navid-rec-child-grid { grid-template-columns: 1fr !important; }
            }
            @media (max-width: 640px) {
                .navid-rec-theme-grid, .navid-rec-plugin-grid, .navid-rec-matcha-plugin-grid, .navid-rec-child-grid { grid-template-columns: 1fr !important; }
            }
            ";
            
            wp_register_style( 'navid-dashboard-style', false );
            wp_enqueue_style( 'navid-dashboard-style' );
            wp_add_inline_style( 'navid-dashboard-style', $css );
        }

        /**
         * Render the dashboard page content
         */
        public function render_dashboard_page() {
            $theme_version = wp_get_theme()->get('Version');
            $active_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'welcome';
            $pro_active = navid_is_pro_active();
            ?>
            <div class="navid-dashboard-app">
                <div class="navid-dashboard-header">
                    <div class="navid-dashboard-logo">
                        <h3>Navid <span>Theme</span></h3>
                        <span class="navid-version">v<?php echo esc_html( $theme_version ); ?></span>
                        <?php $pro_plugin_installed = defined( 'NAVID_PRO_VERSION' ); ?>
                        <?php if ( $pro_plugin_installed ) : ?>
                            <?php if ( get_option( 'NAVID_PRO_license_status' ) === 'valid' ) : ?>
                                <span style="background:#728c69; color:#fff; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase;"><?php esc_html_e( 'Pro Active', 'navid' ); ?></span>
                            <?php else : ?>
                                <a href="<?php echo esc_url( admin_url( 'admin.php?page=navid-pro' ) ); ?>" style="background:#dc3232; color:#fff; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase; text-decoration:none;"><?php esc_html_e( 'License Invalid', 'navid' ); ?></a>
                            <?php endif; ?>
                        <?php else : ?>
                            <a href="https://wpmatcha.com/wordpress-themes/navid/" target="_blank" style="background:#f0f4ef; color:#728c69; border:1px solid #b5ccaf; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase; text-decoration:none;"><?php esc_html_e( 'Get Pro', 'navid' ); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="navid-dashboard-nav">
                        <a href="?page=navid-dashboard&tab=welcome" class="<?php echo 'welcome' === $active_tab ? 'active' : ''; ?>"><?php esc_html_e( 'Welcome', 'navid' ); ?></a>
                        <a href="?page=navid-dashboard&tab=starter-sites" class="<?php echo 'starter-sites' === $active_tab ? 'active' : ''; ?>"><?php esc_html_e( 'Starter Sites', 'navid' ); ?></a>
                        <a href="?page=navid-dashboard&tab=patterns" class="<?php echo 'patterns' === $active_tab ? 'active' : ''; ?>"><?php esc_html_e( 'Page Layouts', 'navid' ); ?></a>
                        <a href="?page=navid-dashboard&tab=shortcodes" class="<?php echo 'shortcodes' === $active_tab ? 'active' : ''; ?>"><?php esc_html_e( 'Tools & Shortcodes', 'navid' ); ?></a>
                        <a href="?page=navid-dashboard&tab=recommended" class="<?php echo 'recommended' === $active_tab ? 'active' : ''; ?>"><?php esc_html_e( 'Recommended', 'navid' ); ?></a>
                        <a href="https://wpmatcha.com/contact/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Request a Feature ↗', 'navid' ); ?></a>
                    </div>
                </div>

                <div class="navid-dashboard-content">
                    <?php if ( 'patterns' === $active_tab ) : ?>
                        <!-- Page Layouts Tab -->
                        <div class="navid-cta-wrap" style="margin-top:0;">
                            <h3><?php esc_html_e( 'Build Custom Homepages', 'navid' ); ?></h3>
                            <p><?php esc_html_e( 'Want to build a Creator Studio or Business layout? We have designed stunning block patterns for you.', 'navid' ); ?></p>
                            <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:20px; border-radius:8px; display:inline-block; text-align:left; margin-bottom:20px;">
                                <ol style="margin:0; padding-left:20px; font-size:15px; color:#334155; line-height: 1.6;">
                                    <li>Go to <strong>Pages > Add New</strong>.</li>
                                    <li>When the "Choose a Pattern" popup appears, select the <strong>Navid Patterns</strong> category.</li>
                                    <li>Click on the <strong>Creator Studio Homepage</strong> layout to insert it instantly!</li>
                                </ol>
                            </div>
                            <br>
                            <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=page' ) ); ?>" class="navid-btn navid-btn-primary"><?php esc_html_e( 'Create a Page Now', 'navid' ); ?></a>
                        </div>
                    <?php elseif ( 'starter-sites' === $active_tab ) : ?>
                        <!-- Starter Sites Tab -->
                        <?php
                        $ocdi_active    = is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' );
                        $extra_active   = is_plugin_active( 'matcha-extra/matcha-extra.php' );
                        // $pro_active is already set at top of render_dashboard_page()
                        $base_ready     = $ocdi_active && $extra_active;

                        // Demo definitions — hardcoded so they show even without navid-pro active.
                        // Preview images are stored in the theme so they display for both free and pro users.
                        $preview_base = get_template_directory_uri() . '/assets/images/demos/';

                        $starter_demos = array(
                            array(
                                'name'        => 'Standard (Default)',
                                'preview_url' => 'https://navid.wpmatcha.com/',
                                'image_url'   => $preview_base . 'default.jpg',
                                'is_pro'      => false,
                                'import_index'=> 0,
                            ),
                            array(
                                'name'        => 'Magazine (Split)',
                                'preview_url' => 'https://navid.wpmatcha.com/magazine/',
                                'image_url'   => $preview_base . 'magazine.jpg',
                                'is_pro'      => true,
                                'import_index'=> 2,
                            ),
                            array(
                                'name'        => 'Classic Newspaper (Tribune)',
                                'preview_url' => 'https://navid.wpmatcha.com/newspaper/',
                                'image_url'   => $preview_base . 'newspaper.jpg',
                                'is_pro'      => false,
                                'import_index'=> 1,
                            ),
                            array(
                                'name'        => 'News (Grid)',
                                'preview_url' => 'https://navid.wpmatcha.com/news/',
                                'image_url'   => $preview_base . 'news.jpg',
                                'is_pro'      => true,
                                'import_index'=> 3,
                            ),
                            array(
                                'name'        => 'Bento Box',
                                'preview_url' => 'https://navid.wpmatcha.com/bento/',
                                'image_url'   => $preview_base . 'bento.jpg',
                                'is_pro'      => true,
                                'import_index'=> 4,
                            ),
                        );

                        // Grab real preview images from the OCDI filter (works with matcha-extra or navid-pro).
                        $ocdi_demos = apply_filters( 'pt-ocdi/import_files', array() );
                        foreach ( $starter_demos as $k => $starter ) {
                            $import_id = $starter['import_index'];
                            if ( isset( $ocdi_demos[ $import_id ] ) && ! empty( $ocdi_demos[ $import_id ]['import_preview_image_url'] ) ) {
                                $starter_demos[ $k ]['image_url'] = $ocdi_demos[ $import_id ]['import_preview_image_url'];
                            }
                        }
                        ?>

                        <?php if ( $base_ready ) : ?>
                            <!-- Plugins active — show demo gallery -->
                            <div class="navid-starter-grid">
                                <?php foreach ( $starter_demos as $demo ) :
                                    $is_locked = $demo['is_pro'] && ! $pro_active;
                                ?>
                                    <div class="navid-starter-card<?php echo $is_locked ? ' navid-card-locked' : ''; ?>">
                                        <div class="navid-starter-thumb">
                                            <?php if ( ! empty( $demo['image_url'] ) ) : ?>
                                                <img src="<?php echo esc_url( $demo['image_url'] ); ?>" alt="<?php echo esc_attr( $demo['name'] ); ?>" />
                                            <?php else : ?>
                                                <div class="navid-thumb-placeholder">
                                                    <span class="dashicons dashicons-format-image"></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( $is_locked ) : ?>
                                                <div class="navid-lock-overlay">
                                                    <span class="dashicons dashicons-lock"></span>
                                                    <span><?php esc_html_e( 'Pro', 'navid' ); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ( $demo['is_pro'] && $pro_active ) : ?>
                                                <span class="navid-pro-badge"><?php esc_html_e( 'Pro', 'navid' ); ?></span>
                                            <?php elseif ( ! $demo['is_pro'] ) : ?>
                                                <span class="navid-free-badge"><?php esc_html_e( 'Free', 'navid' ); ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="navid-starter-info">
                                            <h4><?php echo esc_html( $demo['name'] ); ?></h4>
                                            <div class="navid-starter-actions">
                                                <?php if ( ! empty( $demo['preview_url'] ) ) : ?>
                                                    <a href="<?php echo esc_url( $demo['preview_url'] ); ?>" class="navid-btn navid-btn-secondary" target="_blank" rel="noopener"><?php esc_html_e( 'Preview', 'navid' ); ?></a>
                                                <?php endif; ?>
                                                <?php if ( $is_locked ) : ?>
                                                    <a href="https://wpmatcha.com/wordpress-themes/navid/" class="navid-btn navid-btn-primary" target="_blank" rel="noopener"><?php esc_html_e( 'Unlock Pro', 'navid' ); ?></a>
                                                <?php elseif ( isset( $ocdi_demos[ $demo['import_index'] ] ) && ! empty( $ocdi_demos[ $demo['import_index'] ]['local_import_file'] ) ) : ?>
                                                    <button type="button" class="navid-btn navid-btn-primary navid-direct-import-btn" data-index="<?php echo esc_attr( $demo['import_index'] ); ?>" data-name="<?php echo esc_attr( $demo['name'] ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'navid_import_nonce' ) ); ?>"><?php esc_html_e( 'Import', 'navid' ); ?></button>
                                                <?php else : ?>
                                                    <span class="navid-btn navid-btn-secondary" style="opacity:0.5;cursor:default;"><?php esc_html_e( 'Coming Soon', 'navid' ); ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php
                            $i18n_import = array(
                                'no_close'    => __( 'Please do not close this window.', 'navid' ),
                                'step1_title' => __( 'Importing content…', 'navid' ),
                                'step1'       => __( 'Step 1 of 3 — Content', 'navid' ),
                                'step2_title' => __( 'Importing customizer settings…', 'navid' ),
                                'step2_sub'   => __( 'Almost there…', 'navid' ),
                                'step2'       => __( 'Step 2 of 3 — Customizer', 'navid' ),
                                'step3_title' => __( 'Running after-import setup…', 'navid' ),
                                'step3_sub'   => __( 'Finishing up…', 'navid' ),
                                'step3'       => __( 'Step 3 of 3 — Finalizing', 'navid' ),
                                'done_title'  => __( 'Import complete!', 'navid' ),
                                'done_sub'    => __( 'Your site is ready. Redirecting…', 'navid' ),
                                'err_content' => __( 'Content import failed.', 'navid' ),
                                'err_nonce'   => __( 'Could not get nonce.', 'navid' ),
                                'err_prefix'  => __( 'Import error: ', 'navid' ),
                                'confirm_pre' => __( 'Import the', 'navid' ),
                                'confirm_suf' => __( 'demo? This will import content, widgets, and customizer settings.', 'navid' ),
                                'home_url'    => home_url( '/' ),
                                'ajax_url'    => admin_url( 'admin-ajax.php' ),
                            );
                            ?>

                            <!-- Pre-Import Branding Wizard Modal (Botiga-style UX) -->
                            <div id="navid-branding-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.65);z-index:999999;align-items:center;justify-content:center;">
                              <div style="background:#fff;border-radius:16px;padding:36px;max-width:640px;width:95%;max-height:90vh;overflow-y:auto;text-align:left;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);position:relative;">
                                <button type="button" id="navid-branding-close" style="position:absolute;top:20px;right:20px;background:none;border:none;font-size:24px;cursor:pointer;color:#64748b;">&times;</button>
                                
                                <span style="display:inline-block;background:#e2e8f0;color:#334155;font-size:11px;font-weight:700;padding:4px 10px;border-radius:99px;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:12px;"><?php esc_html_e( 'Step 1 of 2: Branding Setup', 'navid' ); ?></span>
                                <h3 style="margin:0 0 8px;font-size:22px;color:#0f172a;font-weight:700;">🎨 <?php esc_html_e( 'Customize Your Starter Site', 'navid' ); ?></h3>
                                <p style="color:#64748b;margin:0 0 24px;font-size:14px;line-height:1.5;"><?php esc_html_e( 'Select your default color scheme and typography pairing. We will automatically apply these styles to your imported demo.', 'navid' ); ?></p>

                                <!-- Section 1: Color Palette Swatches -->
                                <div style="margin-bottom:28px;">
                                  <label style="display:block;font-size:14px;font-weight:700;color:#1e293b;margin-bottom:12px;"><?php esc_html_e( '1. Choose Color Palette', 'navid' ); ?></label>
                                  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">
                                    <label class="navid-branding-card" style="border:2px solid #728c69;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fcfdfc;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="sage" checked style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Sage (Default)', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#728c69;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#2a3826;display:inline-block;"></span>
                                      </div>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fff;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="ocean" style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Tech Ocean', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#2d6a8a;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#0f172a;display:inline-block;"></span>
                                      </div>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fff;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="rose" style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Warm Rose', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#b5565d;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#4a1d21;display:inline-block;"></span>
                                      </div>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fff;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="amber" style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Golden Amber', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#c47834;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#45280e;display:inline-block;"></span>
                                      </div>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fff;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="slate" style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Monochrome Slate', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#5a6575;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#1e293b;display:inline-block;"></span>
                                      </div>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:12px;cursor:pointer;display:flex;align-items:center;justify-content:space-between;background:#fff;">
                                      <div>
                                        <input type="radio" name="navid-branding-palette" value="plum" style="margin-right:6px;">
                                        <span style="font-weight:600;font-size:13px;color:#1e293b;"><?php esc_html_e( 'Royal Plum', 'navid' ); ?></span>
                                      </div>
                                      <div style="display:flex;gap:4px;">
                                        <span style="width:16px;height:16px;border-radius:50%;background:#7a5c8a;display:inline-block;"></span>
                                        <span style="width:16px;height:16px;border-radius:50%;background:#2e2036;display:inline-block;"></span>
                                      </div>
                                    </label>
                                  </div>
                                </div>

                                <!-- Section 2: Typography Pairing -->
                                <div style="margin-bottom:32px;">
                                  <label style="display:block;font-size:14px;font-weight:700;color:#1e293b;margin-bottom:12px;"><?php esc_html_e( '2. Choose Typography Pairing', 'navid' ); ?></label>
                                  <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:12px;">
                                    <label class="navid-branding-card" style="border:2px solid #728c69;border-radius:10px;padding:14px;cursor:pointer;background:#fcfdfc;">
                                      <div style="display:flex;align-items:center;margin-bottom:6px;">
                                        <input type="radio" name="navid-branding-typography" value="classic" checked style="margin-right:8px;">
                                        <strong style="font-size:14px;color:#0f172a;font-family:'Lora',serif;"><?php esc_html_e( 'Editorial Serif (Lora + Merriweather)', 'navid' ); ?></strong>
                                      </div>
                                      <p style="margin:0 0 0 24px;font-size:12px;color:#64748b;font-family:'Merriweather',serif;"><?php esc_html_e( 'Classic journalism feel with high legibility.', 'navid' ); ?></p>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:14px;cursor:pointer;background:#fff;">
                                      <div style="display:flex;align-items:center;margin-bottom:6px;">
                                        <input type="radio" name="navid-branding-typography" value="modern" style="margin-right:8px;">
                                        <strong style="font-size:14px;color:#0f172a;font-family:sans-serif;"><?php esc_html_e( 'Modern Tech (Outfit + Inter)', 'navid' ); ?></strong>
                                      </div>
                                      <p style="margin:0 0 0 24px;font-size:12px;color:#64748b;font-family:sans-serif;"><?php esc_html_e( 'Sleek, geometric design for startups and digital products.', 'navid' ); ?></p>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:14px;cursor:pointer;background:#fff;">
                                      <div style="display:flex;align-items:center;margin-bottom:6px;">
                                        <input type="radio" name="navid-branding-typography" value="elegant" style="margin-right:8px;">
                                        <strong style="font-size:14px;color:#0f172a;font-family:serif;"><?php esc_html_e( 'Classic Tribune (Playfair + Source Serif)', 'navid' ); ?></strong>
                                      </div>
                                      <p style="margin:0 0 0 24px;font-size:12px;color:#64748b;font-family:serif;"><?php esc_html_e( 'Traditional newspaper elegance with authoritative headlines.', 'navid' ); ?></p>
                                    </label>
                                    <label class="navid-branding-card" style="border:1px solid #e2e8f0;border-radius:10px;padding:14px;cursor:pointer;background:#fff;">
                                      <div style="display:flex;align-items:center;margin-bottom:6px;">
                                        <input type="radio" name="navid-branding-typography" value="system" style="margin-right:8px;">
                                        <strong style="font-size:14px;color:#0f172a;font-family:system-ui,sans-serif;"><?php esc_html_e( 'High Speed Neutral (System UI + Roboto)', 'navid' ); ?></strong>
                                      </div>
                                      <p style="margin:0 0 0 24px;font-size:12px;color:#64748b;font-family:system-ui,sans-serif;"><?php esc_html_e( 'Zero font load lag with ultra-clean system typography.', 'navid' ); ?></p>
                                    </label>
                                  </div>
                                </div>

                                <!-- Footer Actions -->
                                <div style="display:flex;justify-content:flex-end;gap:12px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                  <button type="button" id="navid-branding-cancel" class="navid-btn navid-btn-outline" style="padding:10px 20px;height:auto;line-height:1.4;"><?php esc_html_e( 'Cancel', 'navid' ); ?></button>
                                  <button type="button" id="navid-branding-submit" class="navid-btn navid-btn-primary" style="padding:10px 24px;height:auto;line-height:1.4;font-size:15px;background:#728c69;">
                                    <span class="dashicons dashicons-rocket" style="vertical-align:middle;margin-top:-2px;margin-right:4px;"></span>
                                    <span style="vertical-align:middle;"><?php esc_html_e( 'Build My Website', 'navid' ); ?></span>
                                  </button>
                                </div>
                              </div>
                            </div>

                            <!-- One-Click Import Modal -->
                            <div id="navid-import-modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.65);z-index:999999;align-items:center;justify-content:center;">
                              <div style="background:#fff;border-radius:10px;padding:40px;max-width:480px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                                <div id="navid-import-icon" style="font-size:40px;margin-bottom:12px;">&#9203;</div>
                                <h3 id="navid-import-title" style="margin:0 0 8px;font-size:20px;color:#1e293b;"><?php esc_html_e( 'Preparing import…', 'navid' ); ?></h3>
                                <p id="navid-import-status" style="color:#64748b;margin:0 0 20px;font-size:14px;"><?php esc_html_e( 'Please do not close this window.', 'navid' ); ?></p>
                                <div style="background:#f1f5f9;border-radius:99px;height:8px;overflow:hidden;margin-bottom:10px;">
                                  <div id="navid-import-bar" style="background:#728c69;height:100%;width:0%;border-radius:99px;transition:width 0.5s ease;"></div>
                                </div>
                                <p id="navid-import-step" style="font-size:12px;color:#94a3b8;margin:0;"></p>
                              </div>
                            </div>

                            <script>
                            (function(){
                                var cfg = <?php echo wp_json_encode( $i18n_import ); ?>;
                                var activeIdx = null;
                                var activeName = null;
                                var activeSec = null;

                                function sp(pct,t,s,st){
                                    document.getElementById('navid-import-bar').style.width=pct+'%';
                                    if(t!==undefined)document.getElementById('navid-import-title').textContent=t;
                                    if(s!==undefined)document.getElementById('navid-import-status').textContent=s;
                                    if(st!==undefined)document.getElementById('navid-import-step').textContent=st;
                                }
                                function showM(){document.getElementById('navid-import-modal').style.display='flex';}
                                function hideM(){document.getElementById('navid-import-modal').style.display='none';}
                                function showBrandingM(){document.getElementById('navid-branding-modal').style.display='flex';}
                                function hideBrandingM(){document.getElementById('navid-branding-modal').style.display='none';}

                                function ajax(action,data){
                                    var fd=new FormData();
                                    fd.append('action',action);
                                    Object.keys(data).forEach(function(k){fd.append(k,data[k]);});
                                    return fetch(cfg.ajax_url,{method:'POST',body:fd}).then(function(r){return r.json();});
                                }

                                function runContent(idx, nonce) {
                                    return ajax('ocdi_import_demo_data', {security: nonce, selected: idx}).then(function(r) {
                                        if (r && r.status === 'newAJAX') {
                                            return runContent(idx, nonce);
                                        }
                                        if (r && (r.status === 'customizerAJAX' || r.status === 'afterAllImportAJAX' || r.message)) {
                                            return r;
                                        }
                                        throw new Error(r && r.message ? r.message : (typeof r === 'string' ? r : cfg.err_content));
                                    });
                                }

                                function runCustomizer(r, idx, nonce) {
                                    if (r && r.status === 'customizerAJAX') {
                                        sp(55, cfg.step2_title, cfg.step2_sub, cfg.step2);
                                        return ajax('ocdi_import_customizer_data', {security: nonce, selected: idx}).then(function(res) {
                                            if (res && (res.status === 'afterAllImportAJAX' || res.message)) {
                                                return res;
                                            }
                                            throw new Error(res && res.message ? res.message : cfg.err_customizer);
                                        });
                                    }
                                    return r;
                                }

                                function runAfterImport(r, idx, nonce) {
                                    if (r && (r.status === 'afterAllImportAJAX' || !r.status)) {
                                        sp(80, cfg.step3_title, cfg.step3_sub, cfg.step3);
                                        return ajax('ocdi_after_import_data', {security: nonce, selected: idx}).then(function(res) {
                                            if (res && (res.message || res.status || typeof res === 'object')) {
                                                return res;
                                            }
                                            throw new Error(res && res.message ? res.message : cfg.err_after);
                                        });
                                    }
                                    return r;
                                }

                                function runImport(idx, nonce){
                                    showM();
                                    sp(10, cfg.step1_title, cfg.no_close, cfg.step1);
                                    runContent(idx, nonce)
                                    .then(function(r) {
                                        return runCustomizer(r, idx, nonce);
                                    })
                                    .then(function(r) {
                                        return runAfterImport(r, idx, nonce);
                                    })
                                    .then(function(){
                                        sp(100, cfg.done_title, cfg.done_sub, '');
                                        document.getElementById('navid-import-icon').innerHTML='&#127881;';
                                        setTimeout(function(){window.location.href=cfg.home_url;},2500);
                                    })
                                    .catch(function(e){
                                        hideM();
                                        alert(cfg.err_prefix + (e.message || String(e)));
                                    });
                                }

                                document.addEventListener('DOMContentLoaded',function(){
                                    // Handle card border highlighting in branding modal
                                    document.querySelectorAll('.navid-branding-card input[type="radio"]').forEach(function(radio){
                                        radio.addEventListener('change',function(){
                                            var name = radio.getAttribute('name');
                                            document.querySelectorAll('input[name="'+name+'"]').forEach(function(r){
                                                var card = r.closest('.navid-branding-card');
                                                if(r.checked){
                                                    card.style.borderColor = '#728c69';
                                                    card.style.borderWidth = '2px';
                                                } else {
                                                    card.style.borderColor = '#e2e8f0';
                                                    card.style.borderWidth = '1px';
                                                }
                                            });
                                        });
                                    });

                                    // Close branding modal
                                    var closeBtn = document.getElementById('navid-branding-close');
                                    var cancelBtn = document.getElementById('navid-branding-cancel');
                                    if(closeBtn) closeBtn.addEventListener('click', hideBrandingM);
                                    if(cancelBtn) cancelBtn.addEventListener('click', hideBrandingM);

                                    // Open branding modal on Import button click
                                    document.querySelectorAll('.navid-direct-import-btn').forEach(function(btn){
                                        btn.addEventListener('click',function(){
                                            activeIdx = btn.getAttribute('data-index');
                                            activeName = btn.getAttribute('data-name');
                                            activeSec = btn.getAttribute('data-nonce');
                                            showBrandingM();
                                        });
                                    });

                                    // Submit branding & launch import
                                    var submitBtn = document.getElementById('navid-branding-submit');
                                    if(submitBtn){
                                        submitBtn.addEventListener('click', function(){
                                            var selPalette = document.querySelector('input[name="navid-branding-palette"]:checked');
                                            var selTypo = document.querySelector('input[name="navid-branding-typography"]:checked');
                                            var paletteVal = selPalette ? selPalette.value : 'sage';
                                            var typoVal = selTypo ? selTypo.value : 'classic';

                                            hideBrandingM();
                                            showM();
                                            sp(5, 'Saving branding styles…', cfg.no_close, 'Applying color palette & typography…');

                                            var fdBranding = new FormData();
                                            fdBranding.append('action', 'navid_save_import_branding');
                                            fdBranding.append('security', '<?php echo esc_js( wp_create_nonce( 'navid_import_branding_nonce' ) ); ?>');
                                            fdBranding.append('palette', paletteVal);
                                            fdBranding.append('typography', typoVal);

                                            fetch(cfg.ajax_url, {method: 'POST', body: fdBranding})
                                            .then(function(r){ return r.json(); })
                                            .then(function(){
                                                var fd = new FormData();
                                                fd.append('action', 'navid_get_ocdi_nonce');
                                                fd.append('security', activeSec);
                                                return fetch(cfg.ajax_url, {method: 'POST', body: fd});
                                            })
                                            .then(function(r){ return r.json(); })
                                            .then(function(r){
                                                if(!r.success) throw new Error(cfg.err_nonce);
                                                runImport(parseInt(activeIdx, 10), r.data.nonce);
                                            }).catch(function(e){
                                                hideM();
                                                alert(cfg.err_prefix + (e.message || String(e)));
                                            });
                                        });
                                    }
                                });
                            })();
                            </script>

                        <?php else : ?>
                            <!-- Plugins not active — show install CTA -->
                            <div class="navid-cta-wrap">
                                <h3><?php esc_html_e( 'Unlock Starter Sites', 'navid' ); ?></h3>
                                <p><?php esc_html_e( 'Install and activate our recommended plugins (Matcha Extra & One Click Demo Import) to access the library of professional starter sites.', 'navid' ); ?></p>
                                <a href="#" class="navid-btn navid-btn-primary navid-install-plugins-btn" data-nonce="<?php echo esc_attr( wp_create_nonce( 'navid_install_plugins_nonce' ) ); ?>">
                                    <span class="text"><?php esc_html_e( 'Install & Activate Plugins', 'navid' ); ?></span>
                                </a>
                            </div>
                            
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var btn = document.querySelector('.navid-install-plugins-btn');
                                if (btn) {
                                    btn.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        if (btn.classList.contains('processing')) return;
                                        btn.classList.add('processing');
                                        
                                        var nonce = btn.getAttribute('data-nonce');
                                        btn.innerHTML = '<?php esc_html_e( 'Processing...', 'navid' ); ?> <span class="dashicons dashicons-update navid-spin" style="animation: navid-spin 2s infinite linear; vertical-align: middle;"></span>';
                                        btn.style.opacity = '0.8';
                                        btn.style.pointerEvents = 'none';

                                        var formData = new FormData();
                                        formData.append('action', 'navid_install_activate_plugins');
                                        formData.append('_ajax_nonce', nonce);

                                        fetch(ajaxurl, { method: 'POST', body: formData })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.success) {
                                                btn.innerHTML = '<?php esc_html_e( 'Redirecting...', 'navid' ); ?>';
                                                window.location.reload();
                                            } else {
                                                alert('<?php esc_html_e( 'Failed to install automatically. Please use the Appearance -> Install Plugins menu.', 'navid' ); ?>');
                                                btn.innerHTML = '<?php esc_html_e( 'Install & Activate Plugins', 'navid' ); ?>';
                                                btn.classList.remove('processing');
                                                btn.style.opacity = '1';
                                                btn.style.pointerEvents = 'auto';
                                            }
                                        }).catch(err => {
                                            alert('<?php esc_html_e( 'A network error occurred.', 'navid' ); ?>');
                                            btn.innerHTML = '<?php esc_html_e( 'Install & Activate Plugins', 'navid' ); ?>';
                                            btn.classList.remove('processing');
                                            btn.style.opacity = '1';
                                            btn.style.pointerEvents = 'auto';
                                        });
                                    });
                                }
                            });
                            </script>

                        <?php endif; ?>


                    <?php elseif ( 'shortcodes' === $active_tab ) : ?>

                        <!-- Tools & Shortcodes Tab -->
                        <div class="navid-dashboard-grid" style="grid-template-columns: 1fr;">
                            <div class="navid-main-col">
                                <div class="navid-table-wrap">
                                    <h2 class="navid-comparison-title"><?php esc_html_e( 'Tools, Widgets & Shortcodes', 'navid' ); ?></h2>
                                    <p style="color: #64748b; font-size: 1.1em; margin-top: -15px; margin-bottom: 30px;">
                                        <?php esc_html_e( 'Discover all the custom widgets and shortcodes included with Navid to build powerful pages.', 'navid' ); ?>
                                    </p>

                                    <?php if ( ! $pro_active ) : ?>
                                    <div style="background: #fff8e6; border-left: 4px solid #f59e0b; padding: 15px 20px; border-radius: 4px; margin-bottom: 30px;">
                                        <p style="margin: 0; color: #92400e; font-weight: 500;">
                                            <strong style="color: #b45309;">Heads up:</strong> Some of these tools are part of <strong>Navid Pro</strong>. <a href="https://wpmatcha.com/wordpress-themes/navid/" target="_blank" style="color: #b45309; text-decoration: underline;">Upgrade to Pro</a> to unlock everything!
                                        </p>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Widgets Section -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                                        <h3 style="font-size: 1.25em; color: #0f172a; margin: 0 0 15px; display: flex; align-items: center; gap: 10px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                            Custom Sidebar Widgets
                                        </h3>
                                        <p style="color: #475569; margin: 0 0 20px; line-height: 1.6;">
                                            Navid comes bundled with a suite of custom widgets. Head over to <strong>Appearance > Widgets</strong> (or use the Customizer) to add these to your sidebars or footer areas.
                                        </p>
                                        
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                                            <!-- Free Widgets -->
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Navid: Author Profile <span style="font-size: 10px; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; color: #475569;">FREE</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Display a stylish author bio card.</p>
                                            </div>
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Navid: Trending Now <span style="font-size: 10px; background: #e2e8f0; padding: 2px 6px; border-radius: 4px; color: #475569;">FREE</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Showcase popular posts elegantly.</p>
                                            </div>
                                            
                                            <!-- Pro Widgets -->
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Table of Contents <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">A sticky sidebar TOC widget.</p>
                                            </div>
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Editorial Team <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Showcase your magazine's authors.</p>
                                            </div>
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Shop My Favorites <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Display affiliate products visually.</p>
                                            </div>
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Trending Now (Pro) <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Advanced layouts for trending posts.</p>
                                            </div>
                                            <div style="background: #fff; padding: 15px; border: 1px solid #e2e8f0; border-radius: 8px;">
                                                <h4 style="margin: 0 0 5px; color: #0f172a; display: flex; align-items: center; justify-content: space-between;">Shop The Look <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span></h4>
                                                <p style="margin: 0; font-size: 0.85em; color: #64748b;">Interactive affiliate hotspot block widget.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mega Menu -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                                        <h3 style="font-size: 1.25em; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 10px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            Mega Menu <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span>
                                        </h3>
                                        <p style="color: #475569; margin: 0 0 20px; line-height: 1.6;">
                                            Navid Pro comes with a built-in, CSS-only Mega Menu for your main navigation. It automatically converts standard dropdowns into a beautiful multi-column layout.
                                        </p>

                                        <h4 style="font-size: 1em; color: #0f172a; margin: 0 0 10px;">How to use it</h4>
                                        <ul style="color: #475569; padding-left: 20px; margin: 0; line-height: 1.6;">
                                            <li>Go to <strong>Appearance &gt; Menus</strong>.</li>
                                            <li>At the top right of the screen, click <strong>Screen Options</strong> and ensure <strong>CSS Classes</strong> is checked.</li>
                                            <li>Click the down arrow on a <strong>top-level menu item</strong> that has sub-items.</li>
                                            <li>In the "CSS Classes (optional)" field, enter exactly: <code>navid-mega-menu</code></li>
                                            <li>Save the menu. That item's dropdown will now render as a gorgeous full-width Mega Menu!</li>
                                        </ul>
                                        
                                        <h4 style="font-size: 1em; color: #0f172a; margin: 15px 0 10px;">Adding an Image to the Mega Menu</h4>
                                        <p style="color: #475569; margin: 0; line-height: 1.6;">
                                            You can easily add an image to any column header in your Mega Menu. Simply paste a standard HTML image tag directly into the <strong>Navigation Label</strong> of a 2nd-level menu item! Example:
                                            <br><code>&lt;img src="https://yoursite.com/image.jpg" alt="Shop"&gt; Shop Now</code>
                                        </p>
                                    </div>

                                    <!-- Shop The Look -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                                        <h3 style="font-size: 1.25em; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 10px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                            Shop The Look <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span>
                                        </h3>
                                        <p style="color: #475569; margin: 0 0 20px; line-height: 1.6;">
                                            Overlay clickable, pulsating hotspots onto any image. Perfect for affiliate marketing, tagging fashion items, or creating interactive room designs.
                                        </p>

                                        <div style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #728c69; padding: 20px; border-radius: 6px; margin-bottom: 25px;">
                                            <h4 style="font-size: 1.05em; color: #0f172a; margin: 0 0 8px;">🔥 Recommended: Use the Native Block</h4>
                                            <p style="color: #475569; margin: 0; line-height: 1.6;">
                                                When editing a post or widget, simply search for the <strong>Shop the Look (Navid Pro)</strong> block. It provides a visual point-and-click interface with X/Y sliders right below the image, making it incredibly easy to place your pins!
                                            </p>
                                        </div>
                                        
                                        <h4 style="font-size: 1em; color: #0f172a; margin: 0 0 10px;">Classic Editor / Shortcode Fallback</h4>
                                        <p style="color: #475569; margin: 0 0 10px; line-height: 1.6;">If you are not using the Block Editor, you can use the shortcode method:</p>
                                        
                                        <div style="background: #1e293b; padding: 15px 20px; border-radius: 8px; font-family: monospace; color: #e2e8f0; margin-bottom: 20px; overflow-x: auto;">
                                            [matcha_shop_look image="https://example.com/image.jpg" spots="25,40,https://affiliate.link.1 | 70,80,https://affiliate.link.2"]
                                        </div>
                                        
                                        <ul style="color: #475569; padding-left: 20px; margin: 0; line-height: 1.6;">
                                            <li><strong>image</strong>: The full URL to your background image.</li>
                                            <li><strong>spots</strong>: A pipe-separated (<code>|</code>) list of hotspots. Format is <code>X-position, Y-position, URL</code>.</li>
                                        </ul>
                                    </div>

                                    <!-- Arbitrary Ads -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                                        <h3 style="font-size: 1.25em; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 10px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                            Custom Ad Placement <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span>
                                        </h3>
                                        <p style="color: #475569; margin: 0 0 20px; line-height: 1.6;">
                                            Place any ad banner created in the "Matcha Ads" system anywhere on your site (inside articles, Elementor sections, etc) using its specific ID.
                                        </p>
                                        
                                        <div style="background: #1e293b; padding: 15px 20px; border-radius: 8px; font-family: monospace; color: #e2e8f0; margin-bottom: 20px; overflow-x: auto;">
                                            [matcha_ad id="123"]
                                        </div>
                                    </div>

                                    <!-- Auto TOC -->
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 30px; margin-bottom: 30px;">
                                        <h3 style="font-size: 1.25em; color: #0f172a; margin: 0 0 10px; display: flex; align-items: center; gap: 10px;">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                            Auto Table of Contents (TOC) <span style="font-size: 10px; background: #728c69; color: #fff; padding: 2px 6px; border-radius: 4px;">PRO</span>
                                        </h3>
                                        <p style="color: #475569; margin: 0 0 20px; line-height: 1.6;">
                                            The sticky Table of Contents is fully automatic! No shortcode is needed. It automatically parses the <code>H2</code> and <code>H3</code> tags in your blog posts and generates a beautiful floating navigation menu. 
                                        </p>
                                        <p style="color: #475569; margin: 0; line-height: 1.6;">
                                            <em>You can easily turn this feature on or off via the Customizer: <strong>Global Settings &gt; Table of Contents (Pro)</strong>.</em>
                                        </p>
                                    </div>

                                </div>
                            </div>
                    <?php elseif ( 'recommended' === $active_tab ) : ?>
                        <?php
                        if ( ! function_exists( 'is_plugin_active' ) ) {
                            require_once ABSPATH . 'wp-admin/includes/plugin.php';
                        }

                        $preview_themes_base = get_template_directory_uri() . '/assets/images/themes/';
                        $current_stylesheet  = get_stylesheet();

                        // 1. Sibling Standalone Themes
                        $wpmatcha_themes = array(
                            array(
                                'slug'        => 'newsum',
                                'name'        => 'NewSum',
                                'tag'         => __( 'Modern News & Tech Magazine', 'navid' ),
                                'tag_bg'      => '#1e293b',
                                'desc'        => __( 'High-impact digital news magazine featuring interactive story highlights, data stream tickers, 30-second executive briefs, and dynamic Bento grids.', 'navid' ),
                                'image'       => $preview_themes_base . 'newsum.png',
                                'demo_url'    => 'https://newsum.wpmatcha.com/',
                                'details_url' => 'https://wpmatcha.com/wordpress-themes/newsum/',
                            ),
                            array(
                                'slug'        => 'blogsum',
                                'name'        => 'BlogSum',
                                'tag'         => __( 'Minimalist Editorial & Writer Blog', 'navid' ),
                                'tag_bg'      => '#728c69',
                                'desc'        => __( 'Clean, distraction-free blog theme built around pure editorial typography, reading flow, and ultra-fast page speeds for essayists and writers.', 'navid' ),
                                'image'       => $preview_themes_base . 'blogsum.png',
                                'demo_url'    => 'https://blogsum.wpmatcha.com/',
                                'details_url' => 'https://wpmatcha.com/wordpress-themes/blogsum/',
                            ),
                            array(
                                'slug'        => 'pawfect',
                                'name'        => 'Pawfect',
                                'tag'         => __( 'Pet Care & Animal Lifestyle', 'navid' ),
                                'tag_bg'      => '#c4603c',
                                'desc'        => __( 'Warm and engaging magazine theme built for pet clinics, animal shelters, lifestyle creators, and WooCommerce pet supply shops.', 'navid' ),
                                'image'       => $preview_themes_base . 'pawfect.png',
                                'demo_url'    => 'https://pawfect.wpmatcha.com/',
                                'details_url' => 'https://wpmatcha.com/wordpress-themes/pawfect/',
                            ),
                        );

                        // 2. Official Navid Child Themes
                        $navid_child_themes = array(
                            array(
                                'slug'        => 'navid-magazine',
                                'name'        => 'Navid Magazine',
                                'tag'         => __( 'Official Child Theme &middot; Luxury Editorial', 'navid' ),
                                'tag_bg'      => '#728c69',
                                'desc'        => __( 'Dark, cinematic reading experience designed for fashion, culture, and luxury magazines. Features centered hamburger navigation, serif titles, and gold accents.', 'navid' ),
                                'image'       => $preview_themes_base . 'navid-magazine.jpg',
                                'demo_url'    => 'https://navid.wpmatcha.com/magazine/',
                                'details_url' => 'https://wpmatcha.com/wordpress-themes/navid/',
                            ),
                            array(
                                'slug'        => 'navid-newspaper',
                                'name'        => 'Navid Newspaper',
                                'tag'         => __( 'Official Child Theme &middot; Daily Press', 'navid' ),
                                'tag_bg'      => '#1d2327',
                                'desc'        => __( 'Traditional daily press child theme with classic multi-column border dividers, breaking news tickers, and structured print news layouts.', 'navid' ),
                                'image'       => $preview_themes_base . 'navid-newspaper.png',
                                'demo_url'    => 'https://navid.wpmatcha.com/newspaper/',
                                'details_url' => 'https://wpmatcha.com/wordpress-themes/navid/',
                            ),
                        );

                        // 3. Plugins by WPMatcha
                        $wpmatcha_plugins = array(
                            array(
                                'slug'        => 'matcha-extra',
                                'file'        => 'matcha-extra/matcha-extra.php',
                                'name'        => 'Matcha Extra',
                                'badge'       => __( 'Theme Companion', 'navid' ),
                                'badge_color' => '#728c69',
                                'desc'        => __( 'Official companion extending Navid and WPMatcha themes with author boxes, trending stories, custom ad engine, and extra widgets.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/matcha-extra.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
                                'is_wporg'    => true,
                            ),
                            array(
                                'slug'        => 'matcha-gallery',
                                'file'        => 'matcha-gallery/matcha-gallery.php',
                                'name'        => 'Matcha Gallery',
                                'badge'       => __( 'AI Photo Wall &amp; Studio', 'navid' ),
                                'badge_color' => '#2563eb',
                                'desc'        => __( 'AI-powered image metadata generation, interactive mosaic photo walls, masonry layouts, picture framing, and smart portfolios for WordPress.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/matcha-gallery.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>',
                                'is_wporg'    => true,
                            ),
                            array(
                                'slug'        => 'salespulse',
                                'file'        => 'salespulse/salespulse.php',
                                'name'        => 'SalesPulse',
                                'badge'       => __( 'Social Proof &amp; FOMO', 'navid' ),
                                'badge_color' => '#e11d48',
                                'desc'        => __( 'Boost conversions with real-time social proof notifications. Show recent sales, live visitor counts, signups &amp; reviews for WooCommerce.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/salespulse.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e11d48" stroke-width="2" stroke-linecap="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>',
                                'is_wporg'    => true,
                            ),
                            array(
                                'slug'        => 'matchasplit',
                                'file'        => 'matchasplit/matchasplit.php',
                                'name'        => 'MatchaSplit',
                                'badge'       => __( 'A/B Split Testing', 'navid' ),
                                'badge_color' => '#0d9488',
                                'desc'        => __( 'Self-hosted, privacy-first A/B testing for WordPress. Split test pages, posts, and Gutenberg blocks with real statistical significance.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/matchasplit.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0d9488" stroke-width="2" stroke-linecap="round"><circle cx="18" cy="18" r="3"></circle><circle cx="6" cy="6" r="3"></circle><path d="M13 6h3a2 2 0 0 1 2 2v7"></path><line x1="6" y1="9" x2="6" y2="21"></line></svg>',
                                'is_wporg'    => false,
                                'external_url'=> 'https://wpmatcha.com/',
                            ),
                            array(
                                'slug'        => 'wpmatcha-demo-tools',
                                'file'        => 'wpmatcha-demo-tools/wpmatcha-demo-tools.php',
                                'name'        => 'WPMatcha Demo Tools',
                                'badge'       => __( 'Publisher Kit', 'navid' ),
                                'badge_color' => '#6366f1',
                                'desc'        => __( 'Interactive theme demo bar, live style switcher, and multisite showcase toolkit built for WordPress site builders and agencies.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/wpmatcha-demo-tools.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>',
                                'is_wporg'    => false,
                                'external_url'=> 'https://wpmatcha.com/',
                            ),
                        );

                        // 4. General Recommended Companion Plugins for Navid
                        $recommended_plugins = array(
                            array(
                                'slug'        => 'one-click-demo-import',
                                'file'        => 'one-click-demo-import/one-click-demo-import.php',
                                'name'        => 'One Click Demo Import',
                                'badge'       => __( 'Starter Sites Tool', 'navid' ),
                                'badge_color' => '#2271b1',
                                'desc'        => __( 'Import Navid pre-built starter sites, sample posts, menus, widgets, and settings with one click.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/one-click-demo-import.png',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2271b1" stroke-width="2" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>',
                            ),
                            array(
                                'slug'        => 'wpforms-lite',
                                'file'        => 'wpforms-lite/wpforms.php',
                                'name'        => 'WPForms',
                                'badge'       => __( 'Forms & Contact', 'navid' ),
                                'badge_color' => '#e07a5f',
                                'desc'        => __( 'Beginner friendly drag & drop WordPress contact form builder. Seamlessly integrated into Navid contact templates.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/wpforms.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#e07a5f" stroke-width="2" stroke-linecap="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>',
                            ),
                            array(
                                'slug'        => 'mailchimp-for-wp',
                                'file'        => 'mailchimp-for-wp/mailchimp-for-wp.php',
                                'name'        => 'Mailchimp for WP',
                                'badge'       => __( 'Newsletter Sync', 'navid' ),
                                'badge_color' => '#d97706',
                                'desc'        => __( 'Easily connect your site’s newsletter subscription forms to your Mailchimp audience to grow your subscriber base.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/mailchimp-for-wp.png',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2" stroke-linecap="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>',
                            ),
                            array(
                                'slug'        => 'woocommerce',
                                'file'        => 'woocommerce/woocommerce.php',
                                'name'        => 'WooCommerce',
                                'badge'       => __( 'eCommerce Ready', 'navid' ),
                                'badge_color' => '#7c3aed',
                                'desc'        => __( 'Sell digital downloads, print publications, merchandise, or subscriptions with full Navid theme styling.', 'navid' ),
                                'icon_img'    => 'assets/images/plugins/woocommerce.svg',
                                'icon'        => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7c3aed" stroke-width="2" stroke-linecap="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>',
                            ),
                        );
                        ?>

                        <div class="navid-rec-wrapper">
                            <!-- Header Banner -->
                            <div class="navid-rec-header" style="background:#fff; border:1px solid #e2e8f0; border-radius:16px; padding:32px 36px; margin-bottom:36px; box-shadow:0 2px 4px rgba(0,0,0,0.02); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px;">
                                <div style="max-width:700px;">
                                    <span style="display:inline-block; background:#eef4ec; color:#5c7454; font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:0.08em; padding:4px 10px; border-radius:4px; margin-bottom:10px;">✨ WPMatcha Ecosystem</span>
                                    <h2 style="font-size:24px; font-weight:800; color:#0f172a; margin:0 0 8px; letter-spacing:-0.02em;"><?php esc_html_e( 'Recommended Products by WPMatcha', 'navid' ); ?></h2>
                                    <p style="font-size:14.5px; color:#64748b; margin:0; line-height:1.6;">
                                        <?php esc_html_e( 'Handcrafted themes, child themes, and companion plugins designed to enhance your publishing speed, reading experience, and monetization.', 'navid' ); ?>
                                    </p>
                                </div>
                                <div>
                                    <a href="https://wpmatcha.com" target="_blank" class="navid-btn navid-btn-primary" style="background:#728c69;"><?php esc_html_e( 'Browse WPMatcha.com ↗', 'navid' ); ?></a>
                                </div>
                            </div>

                            <!-- Section 1: Themes by WPMatcha -->
                            <div style="margin-bottom:48px;">
                                <div style="margin-bottom:20px;">
                                    <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;"><?php esc_html_e( 'Themes by WPMatcha', 'navid' ); ?></h3>
                                    <p style="font-size:14px; color:#64748b; margin:0;"><?php esc_html_e( 'Explore our sibling standalone themes built with the same clean code, speed, and modern magazine design.', 'navid' ); ?></p>
                                </div>

                                <div class="navid-rec-theme-grid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:24px;">
                                    <?php foreach ( $wpmatcha_themes as $item ) :
                                        $theme_obj       = wp_get_theme( $item['slug'] );
                                        $is_active_theme = ( $current_stylesheet === $item['slug'] || get_template() === $item['slug'] );
                                        $theme_installed = $theme_obj->exists();
                                    ?>
                                        <div class="navid-rec-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; box-shadow:0 2px 4px rgba(0,0,0,0.02); display:flex; flex-direction:column; transition:transform 0.2s, box-shadow 0.2s;">
                                            <div style="aspect-ratio:16/10; overflow:hidden; background:#f1f5f9;">
                                                <img src="<?php echo esc_url( $item['image'] ); ?>" alt="<?php echo esc_attr( $item['name'] ); ?>" style="width:100%; height:100%; object-fit:cover; display:block;" />
                                            </div>
                                            <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                                                <div>
                                                    <div style="margin-bottom:10px;">
                                                        <span style="display:inline-block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:<?php echo esc_attr( $item['tag_bg'] ); ?>; background:<?php echo esc_attr( $item['tag_bg'] ); ?>15; padding:3px 9px; border-radius:4px;">
                                                            <?php echo esc_html( $item['tag'] ); ?>
                                                        </span>
                                                    </div>
                                                    <h4 style="font-size:19px; font-weight:800; color:#0f172a; margin:0 0 8px;"><?php echo esc_html( $item['name'] ); ?></h4>
                                                    <p style="font-size:13.5px; color:#64748b; line-height:1.6; margin:0 0 20px;">
                                                        <?php echo esc_html( $item['desc'] ); ?>
                                                    </p>
                                                </div>
                                                <div style="display:flex; gap:10px; margin-top:auto;">
                                                    <a href="<?php echo esc_url( $item['demo_url'] ); ?>" target="_blank" class="navid-btn navid-btn-secondary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px;"><?php esc_html_e( 'Live Demo ↗', 'navid' ); ?></a>
                                                    <?php if ( $is_active_theme ) : ?>
                                                        <span style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px; font-size:12px; font-weight:700; color:#2e7d32; background:#eef7ee; padding:9px 12px; border-radius:6px; box-sizing:border-box;">
                                                            <span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span>
                                                            <?php esc_html_e( 'Active Theme', 'navid' ); ?>
                                                        </span>
                                                    <?php elseif ( $theme_installed ) : ?>
                                                        <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?action=activate&stylesheet=' . urlencode( $item['slug'] ) ), 'switch-theme_' . $item['slug'] ) ); ?>" class="navid-btn navid-btn-primary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px;">
                                                            <?php esc_html_e( 'Activate Theme', 'navid' ); ?>
                                                        </a>
                                                    <?php else : ?>
                                                        <a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-theme&theme=' . urlencode( $item['slug'] ) ), 'install-theme_' . $item['slug'] ) ); ?>" class="navid-btn navid-btn-primary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px; background:#728c69; color:#fff;">
                                                            <span class="dashicons dashicons-download" style="font-size:14px; width:14px; height:14px; vertical-align:middle; margin-top:-2px; margin-right:4px;"></span><?php esc_html_e( 'Install & Activate', 'navid' ); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Section 2: Official Navid Child Themes -->
                            <div style="margin-bottom:48px;">
                                <div style="margin-bottom:20px;">
                                    <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;"><?php esc_html_e( 'Official Navid Child Themes', 'navid' ); ?></h3>
                                    <p style="font-size:14px; color:#64748b; margin:0;"><?php esc_html_e( 'Transform Navid instantly into dedicated luxury magazine or newspaper designs while keeping your settings intact.', 'navid' ); ?></p>
                                </div>

                                <div class="navid-rec-child-grid" style="display:grid; grid-template-columns:repeat(2, 1fr); gap:24px;">
                                    <?php foreach ( $navid_child_themes as $child ) :
                                        $is_active_child = ( $current_stylesheet === $child['slug'] );
                                        $child_installed = wp_get_theme( $child['slug'] )->exists();
                                    ?>
                                        <div class="navid-rec-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:14px; overflow:hidden; box-shadow:0 2px 4px rgba(0,0,0,0.02); display:flex; flex-direction:column; transition:transform 0.2s, box-shadow 0.2s;">
                                            <div style="aspect-ratio:16/10; overflow:hidden; background:#f1f5f9;">
                                                <img src="<?php echo esc_url( $child['image'] ); ?>" alt="<?php echo esc_attr( $child['name'] ); ?>" style="width:100%; height:100%; object-fit:cover; display:block;" />
                                            </div>
                                            <div style="padding:24px; flex-grow:1; display:flex; flex-direction:column; justify-content:space-between;">
                                                <div>
                                                    <div style="margin-bottom:10px;">
                                                        <span style="display:inline-block; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:<?php echo esc_attr( $child['tag_bg'] ); ?>; background:<?php echo esc_attr( $child['tag_bg'] ); ?>15; padding:3px 9px; border-radius:4px;">
                                                            <?php echo esc_html( $child['tag'] ); ?>
                                                        </span>
                                                    </div>
                                                    <h4 style="font-size:19px; font-weight:800; color:#0f172a; margin:0 0 8px;"><?php echo esc_html( $child['name'] ); ?></h4>
                                                    <p style="font-size:13.5px; color:#64748b; line-height:1.6; margin:0 0 20px;">
                                                        <?php echo esc_html( $child['desc'] ); ?>
                                                    </p>
                                                </div>
                                                <div style="display:flex; gap:10px; margin-top:auto;">
                                                    <a href="<?php echo esc_url( $child['demo_url'] ); ?>" target="_blank" class="navid-btn navid-btn-secondary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px;"><?php esc_html_e( 'Live Demo ↗', 'navid' ); ?></a>
                                                    <?php if ( $is_active_child ) : ?>
                                                        <span style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px; font-size:12px; font-weight:700; color:#2e7d32; background:#eef7ee; padding:9px 12px; border-radius:6px; box-sizing:border-box;">
                                                            <span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span>
                                                            <?php esc_html_e( 'Active Theme', 'navid' ); ?>
                                                        </span>
                                                    <?php elseif ( $child_installed ) : ?>
                                                        <a href="<?php echo esc_url( wp_nonce_url( admin_url( 'themes.php?action=activate&stylesheet=' . urlencode( $child['slug'] ) ), 'switch-theme_' . $child['slug'] ) ); ?>" class="navid-btn navid-btn-primary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px;">
                                                            <?php esc_html_e( 'Activate Theme', 'navid' ); ?>
                                                        </a>
                                                    <?php else : ?>
                                                        <a href="<?php echo esc_url( $child['details_url'] ); ?>" target="_blank" class="navid-btn navid-btn-primary" style="flex:1; text-align:center; padding:9px 12px; font-size:12px;">
                                                            <?php esc_html_e( 'Get Child Theme', 'navid' ); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <?php $action_nonce = wp_create_nonce( 'navid_plugin_action_nonce' ); ?>

                            <!-- Section 3: Recommended Companion Plugins for Navid -->
                            <div style="margin-bottom:48px;">
                                <div style="margin-bottom:20px;">
                                    <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;"><?php esc_html_e( 'Recommended Companion Plugins for Navid', 'navid' ); ?></h3>
                                    <p style="font-size:14px; color:#64748b; margin:0;"><?php esc_html_e( 'Popular third-party plugins thoroughly tested with Navid to add forms, newsletters, and store capabilities.', 'navid' ); ?></p>
                                </div>

                                <div class="navid-rec-plugin-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px;">
                                    <?php foreach ( $recommended_plugins as $plugin ) :
                                        $is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin['file'] );
                                        $is_active    = is_plugin_active( $plugin['file'] );
                                    ?>
                                        <div class="navid-rec-plugin-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:22px; box-shadow:0 2px 4px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.2s, box-shadow 0.2s;">
                                            <div>
                                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                                                    <div style="width:42px; height:42px; border-radius:10px; background:#f8fafc; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                                                        <?php if ( ! empty( $plugin['icon_img'] ) ) : ?>
                                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/' . $plugin['icon_img'] ); ?>" alt="<?php echo esc_attr( $plugin['name'] ); ?>" style="width:100%; height:100%; object-fit:contain; border-radius:9px; display:block;" />
                                                        <?php else : ?>
                                                            <?php echo $plugin['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo esc_attr( $plugin['badge_color'] ); ?>; background:<?php echo esc_attr( $plugin['badge_color'] ); ?>15; padding:3px 8px; border-radius:4px;">
                                                        <?php echo esc_html( $plugin['badge'] ); ?>
                                                    </span>
                                                </div>
                                                <h4 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 8px;"><?php echo esc_html( $plugin['name'] ); ?></h4>
                                                <p style="font-size:13px; color:#64748b; line-height:1.55; margin:0 0 16px;">
                                                    <?php echo esc_html( $plugin['desc'] ); ?>
                                                </p>
                                            </div>
                                            <div style="padding-top:12px; border-top:1px solid #f1f5f9; margin-top:auto;">
                                                <?php if ( $is_active ) : ?>
                                                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#2e7d32; background:#eef7ee; padding:7px 12px; border-radius:6px; width:100%; justify-content:center; box-sizing:border-box;">
                                                        <span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span>
                                                        <?php esc_html_e( 'Active &amp; Configured', 'navid' ); ?>
                                                    </span>
                                                <?php elseif ( $is_installed ) : ?>
                                                    <a href="<?php echo esc_url( wp_nonce_url( 'plugins.php?action=activate&plugin=' . $plugin['file'], 'activate-plugin_' . $plugin['file'] ) ); ?>" class="navid-btn navid-btn-primary navid-plugin-action-btn" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-file="<?php echo esc_attr( $plugin['file'] ); ?>" data-nonce="<?php echo esc_attr( $action_nonce ); ?>" style="width:100%; text-align:center; padding:8px 12px; font-size:12px; box-sizing:border-box;">
                                                        <?php esc_html_e( 'Activate Plugin', 'navid' ); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] ), 'install-plugin_' . $plugin['slug'] ) ); ?>" class="navid-btn navid-btn-primary navid-plugin-action-btn" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-file="<?php echo esc_attr( $plugin['file'] ); ?>" data-nonce="<?php echo esc_attr( $action_nonce ); ?>" style="width:100%; text-align:center; padding:8px 12px; font-size:12px; box-sizing:border-box; background:#728c69; color:#fff;">
                                                        <span class="dashicons dashicons-download" style="font-size:14px; width:14px; height:14px; vertical-align:middle; margin-top:-2px; margin-right:4px;"></span><?php esc_html_e( 'Install &amp; Activate', 'navid' ); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Section 4: Plugins by WPMatcha -->
                            <div style="margin-bottom:40px;">
                                <div style="margin-bottom:20px;">
                                    <h3 style="font-size:18px; font-weight:700; color:#0f172a; margin:0 0 4px; text-transform:uppercase; letter-spacing:0.05em;"><?php esc_html_e( 'Plugins by WPMatcha', 'navid' ); ?></h3>
                                    <p style="font-size:14px; color:#64748b; margin:0;"><?php esc_html_e( 'Explore standalone performance plugins and tools engineered by the WPMatcha team.', 'navid' ); ?></p>
                                </div>

                                <div class="navid-rec-matcha-plugin-grid" style="display:grid; grid-template-columns:repeat(4, 1fr); gap:20px;">
                                    <?php
                                    foreach ( $wpmatcha_plugins as $plugin ) :
                                        $is_installed = file_exists( WP_PLUGIN_DIR . '/' . $plugin['file'] );
                                        $is_active    = is_plugin_active( $plugin['file'] );
                                    ?>
                                        <div class="navid-rec-plugin-card" style="background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:22px; box-shadow:0 2px 4px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between; transition:transform 0.2s, box-shadow 0.2s;">
                                            <div>
                                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;">
                                                    <div style="width:42px; height:42px; border-radius:10px; background:#f8fafc; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:center; overflow:hidden; flex-shrink:0;">
                                                        <?php if ( ! empty( $plugin['icon_img'] ) ) : ?>
                                                            <img src="<?php echo esc_url( get_template_directory_uri() . '/' . $plugin['icon_img'] ); ?>" alt="<?php echo esc_attr( $plugin['name'] ); ?>" style="width:100%; height:100%; object-fit:contain; border-radius:9px; display:block;" />
                                                        <?php else : ?>
                                                            <?php echo $plugin['icon']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span style="font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.05em; color:<?php echo esc_attr( $plugin['badge_color'] ); ?>; background:<?php echo esc_attr( $plugin['badge_color'] ); ?>15; padding:3px 8px; border-radius:4px;">
                                                        <?php echo esc_html( $plugin['badge'] ); ?>
                                                    </span>
                                                </div>
                                                <h4 style="font-size:16px; font-weight:700; color:#0f172a; margin:0 0 8px;"><?php echo esc_html( $plugin['name'] ); ?></h4>
                                                <p style="font-size:13px; color:#64748b; line-height:1.55; margin:0 0 16px;">
                                                    <?php echo esc_html( $plugin['desc'] ); ?>
                                                </p>
                                            </div>
                                            <div style="padding-top:12px; border-top:1px solid #f1f5f9; margin-top:auto;">
                                                <?php if ( $is_active ) : ?>
                                                    <span style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#2e7d32; background:#eef7ee; padding:7px 12px; border-radius:6px; width:100%; justify-content:center; box-sizing:border-box;">
                                                        <span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span>
                                                        <?php esc_html_e( 'Active &amp; Configured', 'navid' ); ?>
                                                    </span>
                                                <?php elseif ( $is_installed ) : ?>
                                                    <a href="<?php echo esc_url( wp_nonce_url( 'plugins.php?action=activate&plugin=' . $plugin['file'], 'activate-plugin_' . $plugin['file'] ) ); ?>" class="navid-btn navid-btn-primary navid-plugin-action-btn" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-file="<?php echo esc_attr( $plugin['file'] ); ?>" data-nonce="<?php echo esc_attr( $action_nonce ); ?>" style="width:100%; text-align:center; padding:8px 12px; font-size:12px; box-sizing:border-box;">
                                                        <?php esc_html_e( 'Activate Plugin', 'navid' ); ?>
                                                    </a>
                                                <?php elseif ( ! empty( $plugin['is_wporg'] ) ) : ?>
                                                    <a href="<?php echo esc_url( wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=' . $plugin['slug'] ), 'install-plugin_' . $plugin['slug'] ) ); ?>" class="navid-btn navid-btn-primary navid-plugin-action-btn" data-slug="<?php echo esc_attr( $plugin['slug'] ); ?>" data-file="<?php echo esc_attr( $plugin['file'] ); ?>" data-nonce="<?php echo esc_attr( $action_nonce ); ?>" style="width:100%; text-align:center; padding:8px 12px; font-size:12px; box-sizing:border-box; background:#728c69; color:#fff;">
                                                        <span class="dashicons dashicons-download" style="font-size:14px; width:14px; height:14px; vertical-align:middle; margin-top:-2px; margin-right:4px;"></span><?php esc_html_e( 'Install &amp; Activate', 'navid' ); ?>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="<?php echo esc_url( $plugin['external_url'] ); ?>" target="_blank" class="navid-btn navid-btn-secondary" style="width:100%; text-align:center; padding:8px 12px; font-size:12px; box-sizing:border-box;">
                                                        <?php esc_html_e( 'View Plugin ↗', 'navid' ); ?>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            document.querySelectorAll('.navid-plugin-action-btn').forEach(function(btn) {
                                btn.addEventListener('click', function(e) {
                                    if (e.metaKey || e.ctrlKey || e.shiftKey) return;
                                    e.preventDefault();

                                    if (btn.classList.contains('processing')) return;
                                    btn.classList.add('processing');

                                    var origHtml = btn.innerHTML;
                                    btn.innerHTML = '<?php esc_html_e( 'Processing…', 'navid' ); ?> <span class="dashicons dashicons-update navid-spin" style="animation: navid-spin 1.5s infinite linear; vertical-align: middle;"></span>';
                                    btn.style.opacity = '0.75';
                                    btn.style.pointerEvents = 'none';

                                    var formData = new FormData();
                                    formData.append('action', 'navid_install_activate_single_plugin');
                                    formData.append('security', btn.getAttribute('data-nonce'));
                                    formData.append('slug', btn.getAttribute('data-slug'));
                                    formData.append('file', btn.getAttribute('data-file'));

                                    fetch(ajaxurl, { method: 'POST', body: formData })
                                    .then(function(res) { return res.json(); })
                                    .then(function(data) {
                                        if (data && data.success) {
                                            var container = btn.parentElement;
                                            container.innerHTML = '<span style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:#2e7d32; background:#eef7ee; padding:7px 12px; border-radius:6px; width:100%; justify-content:center; box-sizing:border-box;"><span class="dashicons dashicons-yes-alt" style="font-size:16px; width:16px; height:16px;"></span> <?php esc_html_e( 'Active &amp; Configured', 'navid' ); ?></span>';
                                        } else {
                                            var fallbackHref = btn.getAttribute('href');
                                            if (fallbackHref && fallbackHref !== '#') {
                                                window.location.href = fallbackHref;
                                            } else {
                                                alert((data && data.data && data.data.message) ? data.data.message : '<?php esc_html_e( 'Operation failed. Please try again.', 'navid' ); ?>');
                                                btn.innerHTML = origHtml;
                                                btn.classList.remove('processing');
                                                btn.style.opacity = '1';
                                                btn.style.pointerEvents = 'auto';
                                            }
                                        }
                                    })
                                    .catch(function(err) {
                                        var fallbackHref = btn.getAttribute('href');
                                        if (fallbackHref && fallbackHref !== '#') {
                                            window.location.href = fallbackHref;
                                        } else {
                                            alert('<?php esc_html_e( 'Network error. Please try again.', 'navid' ); ?>');
                                            btn.innerHTML = origHtml;
                                            btn.classList.remove('processing');
                                            btn.style.opacity = '1';
                                            btn.style.pointerEvents = 'auto';
                                        }
                                    });
                                });
                            });
                        });
                        </script>

                    <?php else : ?>

                        <!-- Welcome Tab -->
                        <div class="navid-dashboard-grid">
                            
                            <!-- Left Column: Table & Upgrade -->
                            <div class="navid-main-col">
                            
                            <!-- Why Upgrade Grid -->
                            <div class="navid-upgrade-features">
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'Pro Layouts', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Unlock advanced header styles, hero sections, and custom typography.', 'navid' ); ?></p>
                                </div>
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'WooCommerce Sync', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Deep integration, AJAX cart, quick view, and off-canvas filtering.', 'navid' ); ?></p>
                                </div>
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'Priority Support', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Get VIP 1-on-1 assistance directly from the Navid development team.', 'navid' ); ?></p>
                                </div>
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'Advanced Ad Engine', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Build unlimited responsive ad banners, inject Adsense, and set device visibility rules.', 'navid' ); ?></p>
                                </div>
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'Shop The Look', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Upload images and drop interactive, clickable affiliate hotspots directly on them.', 'navid' ); ?></p>
                                </div>
                                <div class="navid-feature-box">
                                    <div class="navid-feature-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                    </div>
                                    <h4><?php esc_html_e( 'TOC & Interludes', 'navid' ); ?></h4>
                                    <p><?php esc_html_e( 'Insert video break-out blocks and keep readers engaged with an auto Table of Contents.', 'navid' ); ?></p>
                                </div>
                            </div>

                            <div class="navid-table-wrap">
                                <h2 class="navid-comparison-title"><?php esc_html_e( 'Free vs Pro Comparison', 'navid' ); ?></h2>
                                <table class="navid-comparison-table">
                                    <thead>
                                        <tr>
                                            <th class="feature-col"><?php esc_html_e( 'Features', 'navid' ); ?></th>
                                            <th class="free-col"><?php esc_html_e( 'Navid Lite', 'navid' ); ?></th>
                                            <th class="pro-col"><?php esc_html_e( 'Navid Pro', 'navid' ); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Group: Theme Core & Layouts -->
                                        <tr>
                                            <td colspan="3" class="navid-table-subheader"><?php esc_html_e( 'Theme Core & Layouts', 'navid' ); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Core Theme Design & Responsiveness', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-yes">&check;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( '1-Click Demo Import', 'navid' ); ?></td>
                                            <td class="free-col"><?php esc_html_e( 'Basic', 'navid' ); ?></td>
                                            <td class="pro-col"><strong><?php esc_html_e( 'Pro Demos', 'navid' ); ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Multiple Header & Footer Layouts', 'navid' ); ?></td>
                                            <td class="free-col"><?php esc_html_e( 'Basic', 'navid' ); ?></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Sticky Header & Transparent Menus', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>

                                        <!-- Group: Customization & E-Commerce -->
                                        <tr>
                                            <td colspan="3" class="navid-table-subheader"><?php esc_html_e( 'Customization & WooCommerce', 'navid' ); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Advanced Color & Typography Controls', 'navid' ); ?></td>
                                            <td class="free-col"><?php esc_html_e( 'Basic', 'navid' ); ?></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'WooCommerce Deep Integration', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-yes">&check;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Off-Canvas Floating Cart', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Product Quick View & Advanced Filters', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>

                                        <!-- Group: Monetization & Engagement -->
                                        <tr>
                                            <td colspan="3" class="navid-table-subheader"><?php esc_html_e( 'Monetization & Engagement', 'navid' ); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Advanced Ad Engine (7 Zones & Layouts)', 'navid' ); ?></td>
                                            <td class="free-col"><?php esc_html_e( 'Basic', 'navid' ); ?></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Shop The Look (Interactive Hotspots)', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Auto Table of Contents & Interlude Videos', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>

                                        <!-- Group: Support & Add-ons -->
                                        <tr>
                                            <td colspan="3" class="navid-table-subheader"><?php esc_html_e( 'Support & Licensing', 'navid' ); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'Remove Promo / Author Footer Links', 'navid' ); ?></td>
                                            <td class="free-col"><span class="navid-icon-no">&times;</span></td>
                                            <td class="pro-col"><span class="navid-icon-yes">&check;</span></td>
                                        </tr>
                                        <tr>
                                            <td><?php esc_html_e( 'VIP Priority Support & Updates', 'navid' ); ?></td>
                                            <td class="free-col"><?php esc_html_e( 'Forum Only', 'navid' ); ?></td>
                                            <td class="pro-col"><strong><?php esc_html_e( '1-on-1 Support', 'navid' ); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ( isset( $pro_plugin_installed ) && $pro_plugin_installed ) : ?>
                                <?php if ( get_option( 'NAVID_PRO_license_status' ) === 'valid' ) : ?>
                                <!-- Pro is Active - show a success banner instead of upgrade CTA -->
                                <div class="navid-cta-wrap" style="background: linear-gradient(135deg, #f0f5ee 0%, #e8f0e5 100%); border-color: #b5ccaf;">
                                    <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:12px;">
                                        <span style="background:#728c69; color:#fff; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">✓</span>
                                        <h3 style="color:#2d4a26; margin:0;"><?php esc_html_e( 'Navid Pro is Active!', 'navid' ); ?></h3>
                                    </div>
                                    <p style="color:#4a6644;"><?php esc_html_e( 'You have full access to all Pro layouts, starter sites, and premium features. Thank you for your support!', 'navid' ); ?></p>
                                    <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="navid-btn navid-btn-secondary"><?php esc_html_e( 'Open Customizer', 'navid' ); ?></a>
                                    <a href="<?php echo esc_url( admin_url( 'themes.php?page=navid-dashboard&tab=starter-sites' ) ); ?>" class="navid-btn navid-btn-primary"><?php esc_html_e( 'Import a Starter Site', 'navid' ); ?></a>
                                </div>
                                <?php else : ?>
                                <!-- Pro is Active but License Invalid -->
                                <div class="navid-cta-wrap" style="background: linear-gradient(135deg, #fdf4f4 0%, #f9ecec 100%); border-color: #dc3232;">
                                    <div style="display:flex; align-items:center; justify-content:center; gap:12px; margin-bottom:12px;">
                                        <span style="background:#dc3232; color:#fff; border-radius:50%; width:36px; height:36px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; font-weight:bold;">!</span>
                                        <h3 style="color:#b32d2e; margin:0;"><?php esc_html_e( 'Action Required: License Invalid', 'navid' ); ?></h3>
                                    </div>
                                    <p style="color:#b32d2e;"><?php esc_html_e( 'Navid Pro is active, but your license key is missing or expired. Please activate your license to unlock Pro layouts and features.', 'navid' ); ?></p>
                                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=navid-pro' ) ); ?>" class="navid-btn navid-btn-primary" style="background:#dc3232; border-color:#dc3232;"><?php esc_html_e( 'Activate License', 'navid' ); ?></a>
                                </div>
                                <?php endif; ?>
                            <?php else : ?>
                            <div class="navid-cta-wrap">
                                <h3><?php esc_html_e( 'Ready to unlock everything?', 'navid' ); ?></h3>
                                <p><?php esc_html_e( 'Upgrade to Navid Pro and get all advanced layouts, WooCommerce sync, and premium support.', 'navid' ); ?></p>
                                <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="navid-btn navid-btn-secondary"><?php esc_html_e( 'Go to Customizer', 'navid' ); ?></a>
                                <a href="https://wpmatcha.com/wordpress-themes/navid/" target="_blank" class="navid-btn navid-btn-primary"><?php esc_html_e( 'Upgrade to Pro Today', 'navid' ); ?></a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Column: Sidebar Networking -->
                        <div class="navid-sidebar-col">
                            
                            <!-- More by WPMatcha -->
                            <div class="navid-sidebar-card" style="border-left: 4px solid #728c69; background: #fafdf9;">
                                <h3 style="color:#2d4a26;">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    <?php esc_html_e( 'More by WPMatcha', 'navid' ); ?>
                                </h3>
                                <p><?php esc_html_e( 'Discover our other modern magazine themes (NewSum, BlogSum, Pawfect) and companion plugins.', 'navid' ); ?></p>
                                <a href="<?php echo esc_url( admin_url( 'themes.php?page=navid-dashboard&tab=recommended' ) ); ?>" class="navid-btn navid-btn-outline" style="border-color:#728c69; color:#728c69; font-weight:600;"><?php esc_html_e( 'View Recommendations &rarr;', 'navid' ); ?></a>
                            </div>

                            <!-- Rating -->
                            <div class="navid-sidebar-card">
                                <h3><?php esc_html_e( 'Leave a Review', 'navid' ); ?></h3>
                                <p><?php esc_html_e( 'Are you enjoying the Navid theme? We would love it if you could take a minute to leave us a 5-star rating on WordPress.org to help us grow!', 'navid' ); ?></p>
                                <a href="https://wordpress.org/support/theme/navid/reviews/#new-post" target="_blank" class="navid-btn navid-btn-outline"><?php esc_html_e( 'Rate Navid', 'navid' ); ?></a>
                            </div>

                            <!-- Docs -->
                            <div class="navid-sidebar-card">
                                <h3><?php esc_html_e( 'Documentation', 'navid' ); ?></h3>
                                <p><?php esc_html_e( 'Need help setting up your homepage, importing demos, or changing colors? Check out our extensive theme documentation.', 'navid' ); ?></p>
                                <a href="https://wpmatcha.com/wordpress-themes/navid/" target="_blank" class="navid-btn navid-btn-outline"><?php esc_html_e( 'Read Documentation', 'navid' ); ?></a>
                            </div>

                            <!-- Support -->
                            <div class="navid-sidebar-card">
                                <h3><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#728c69" stroke-width="2" stroke-linecap="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> <?php esc_html_e( 'Need Priority Support?', 'navid' ); ?></h3>
                                <p><?php esc_html_e( 'Stuck on something? Navid Pro users receive instant, 1-on-1 priority support direct from our core development team.', 'navid' ); ?></p>
                                <a href="https://wpmatcha.com/contact/" target="_blank" class="navid-btn navid-btn-outline"><?php esc_html_e( 'Get Pro Support', 'navid' ); ?></a>
                            </div>
                        </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php
        }
    }
endif;
