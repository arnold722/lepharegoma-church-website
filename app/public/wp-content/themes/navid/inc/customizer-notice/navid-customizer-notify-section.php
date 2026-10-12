<?php
/**
 * Navid Customizer Plugin Notify Section (for plugin recommendations)
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Navid_Customizer_Plugin_Notify_Section extends WP_Customize_Section {

    public $type = 'navid-customizer-plugin-notify-section';
    public $plugin_text = '';
    
    public function check_active($slug) {
        $plugin_file = $slug . '/' . $slug . '.php';
        if (file_exists(WP_PLUGIN_DIR . '/' . $plugin_file)) {
            if ( ! function_exists( 'is_plugin_active' ) ) {
                include_once ABSPATH . 'wp-admin/includes/plugin.php';
            }
            
            $needs = is_plugin_active($plugin_file) ? 'deactivate' : 'activate';
            
            return array(
                'status' => is_plugin_active($plugin_file),
                'needs' => $needs,
            );
        }
        
        return array(
            'status' => false,
            'needs' => 'install',
        );
    }
    
    public function create_action_link($state, $slug) {
        switch ($state) {
            case 'install':
                return wp_nonce_url(
                    add_query_arg(
                        array(
                            'action' => 'install-plugin',
                            'plugin' => $slug,
                        ),
                        admin_url('update.php')
                    ),
                    'install-plugin_' . $slug
                );
                break;
                
            case 'deactivate':
                return add_query_arg(
                    array(
                        'action' => 'deactivate',
                        'plugin' => rawurlencode($slug . '/' . $slug . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('deactivate-plugin_' . $slug . '/' . $slug . '.php'),
                    ),
                    admin_url('plugins.php')
                );
                break;
                
            case 'activate':
                return add_query_arg(
                    array(
                        'action' => 'activate',
                        'plugin' => rawurlencode($slug . '/' . $slug . '.php'),
                        'plugin_status' => 'all',
                        'paged' => '1',
                        '_wpnonce' => wp_create_nonce('activate-plugin_' . $slug . '/' . $slug . '.php'),
                    ),
                    admin_url('plugins.php')
                );
                break;
        }
    }
    
    public function json() {
        $json = parent::json();

        global $navid_customizer_notify_recommended_plugins;

        $formatted_plugins = array();
        $plugin_counter = 0;
        
        foreach ($navid_customizer_notify_recommended_plugins as $slug => $plugin_opt) {
            if (!$plugin_opt['recommended']) {
                continue;
            }
            
            $active = $this->check_active($slug);
            
            if (!empty($active['needs']) && ($active['needs'] == 'deactivate')) {
                continue;
            }
            
            $plugin_counter++;
            
            $formatted_plugins[$plugin_counter] = array(
                'slug' => $slug,
                'title' => isset($plugin_opt['title']) ? $plugin_opt['title'] : esc_html__( 'Matcha Extra', 'navid' ),
                'description' => $plugin_opt['description'],
                'check' => $active['status'],
                'plugin_slug' => $slug,
                'url' => $this->create_action_link($active['needs'], $slug),
                'button_class' => $active['needs'] == 'install' ? 'install-now button button-primary' : 'activate-now button button-primary',
                'button_label' => $active['needs'] == 'install' ? esc_html__( 'Install and Activate', 'navid' ) : esc_html__( 'Activate', 'navid' ),
                'id' => $slug,
                'index' => $plugin_counter,
                'class' => $active['status'] ? 'active' : '',
            );
        }
        
        $json['recommended_plugins'] = $formatted_plugins;
        $json['plugin_text'] = $this->plugin_text;
        
        return $json;
    }
    
    protected function render_template() {
        ?>
        <# if( data.recommended_plugins && Object.keys(data.recommended_plugins).length > 0 ){ #>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand" aria-owns="sub-accordion-section-{{ data.id }}">
                <h3 class="accordion-section-title">
                    <span class="section-title" data-plugin_text="{{ data.plugin_text }}">
                        {{ data.plugin_text }}
                    </span>
                </h3>
                <div class="navid-theme-recomended-actions_container" id="plugin-filter">
                    <# for (action in data.recommended_plugins) { #>
                        <div class="navid-recommeded-actions-container epsilon-recommended-plugins" data-index="{{ data.recommended_plugins[action].index }}">
                            <# if( !data.recommended_plugins[action].check ){ #>
                                <div class="navid-epsilon-recommeded-actions">
                                    <p class="title">{{ data.recommended_plugins[action].title }}</p>
                                    <span data-action="dismiss" class="dashicons dashicons-no navid-customizer-notify-dismiss-button-recommended-plugin" id="{{ data.recommended_plugins[action].id }}"></span>
                                    <div class="description">{{{ data.recommended_plugins[action].description }}}</div>
                                    <# if( data.recommended_plugins[action].plugin_slug ){ #>
                                        <div class="custom-action">
                                            <p class="plugin-card-{{ data.recommended_plugins[action].plugin_slug }} action_button {{ data.recommended_plugins[action].class }}">
                                                <a data-slug="{{ data.recommended_plugins[action].plugin_slug }}" class="{{ data.recommended_plugins[action].button_class }}" href="{{ data.recommended_plugins[action].url }}">{{ data.recommended_plugins[action].button_label }}</a>
                                            </p>
                                        </div>
                                    <# } #>
                                </div>
                            <# } #>
                        </div>
                    <# } #>
                </div>
            </li>
        <# } #>
        <?php
    }
}
