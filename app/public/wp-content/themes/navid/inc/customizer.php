<?php
/**
 * Customizer Settings & Functions
 */


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper: returns true when Matcha Pro is active AND the license key is valid.
 * Falls back to plugin-active-only check for dev environments.
 */
if ( ! function_exists( 'navid_pro_is_active' ) ) {
    function navid_pro_is_active() {
        if ( ! function_exists( 'is_plugin_active' ) ) {
            include_once ABSPATH . 'wp-admin/includes/plugin.php';
        }
        if ( ! navid_is_pro_active() ) {
            return false;
        }
        // Also check license validity if the LicenseManager class exists.
        $license_status = get_option( 'matcha_pro_license_status', '' );
        if ( $license_status && 'valid' !== $license_status ) {
            return false;
        }
        return true;
    }
}

/**
 * Custom Palette Swatch Control for Customizer
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
    class Navid_Palette_Control extends WP_Customize_Control {
        public $type = 'navid_palette';
        public $palettes = array();

        public function render_content() {
            if ( empty( $this->palettes ) ) {
                return;
            }
            ?>
            <div class="navid-control-wrapper navid-palette-control-wrapper">
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <?php if ( ! empty( $this->description ) ) : ?>
                    <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
                <?php endif; ?>
                
                <div class="navid-palette-swatches">
                <?php foreach ( $this->palettes as $key => $data ) : ?>
                    <label class="navid-palette-option" title="<?php echo esc_attr( $data['label'] ); ?>">
                        <input type="radio" name="<?php echo esc_attr( '_customize-radio-' . $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $key ); ?> />
                        <span class="navid-palette-color" style="background:<?php echo esc_attr( $data['color'] ); ?>;"></span>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }
}

if ( class_exists( 'WP_Customize_Control' ) ) {
    class Navid_Heading_Control extends WP_Customize_Control {
        public $type = 'navid_heading';
        public function render_content() {
            echo '<h3 style="margin-top: 30px; margin-bottom: 5px; padding-bottom: 5px; border-bottom: 1px solid #ddd; color: #1d2327;">' . esc_html( $this->label ) . '</h3>';
            if ( ! empty( $this->description ) ) {
                echo '<span class="description customize-control-description" style="margin-bottom:15px; display:block;">' . esc_html( $this->description ) . '</span>';
            }
        }
    }
}

if ( class_exists( 'WP_Customize_Section' ) ) {
    class Navid_Buttonset_Control extends WP_Customize_Control {
        public $type = 'navid-buttonset';

        public function render_content() {
            if ( empty( $this->choices ) ) return;
            $name = '_customize-radio-' . $this->id;
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php if ( ! empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo $this->description; ?></span>
            <?php endif; ?>
            <div class="navid-buttonset">
                <?php foreach ( $this->choices as $value => $label ) : ?>
                    <input type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $name ) . '-' . esc_attr( $value ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                    <label for="<?php echo esc_attr( $name ) . '-' . esc_attr( $value ); ?>"><?php echo wp_kses_post( $label ); ?></label>
                <?php endforeach; ?>
            </div>
            <style>
                .navid-buttonset { display: flex; background: #f0f0f1; border-radius: 6px; padding: 3px; margin-top: 8px; border: 1px solid #dcdcde; align-items: center; justify-content: space-between; }
                .navid-buttonset input[type="radio"] { display: none; }
                .navid-buttonset label { flex: 1; text-align: center; padding: 6px 4px; margin: 0; cursor: pointer; font-size: 12px; color: #50575e; transition: all 0.2s ease; border-radius: 4px; display: flex; align-items: center; justify-content: center; gap: 4px; font-weight: 500; }
                .navid-buttonset label:hover { color: #1d2327; }
                .navid-buttonset input[type="radio"]:checked + label { background: #fff; color: #2271b1; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
                .navid-buttonset svg { width: 14px; height: 14px; fill: currentColor; opacity: 0.8; }
            </style>
            <?php
        }
    }

    class Navid_Customize_Upsell_Section extends WP_Customize_Section {
        public $type = 'navid_upsell_section';
        public $upsell_text = '';
        public $upsell_url = '';

        public function json() {
            $json = parent::json();
            $json['upsell_text'] = $this->upsell_text;
            $json['upsell_url']  = esc_url( $this->upsell_url );
            return $json;
        }

        protected function render_template() {
            ?>
            <li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }} cannot-expand" style="padding: 20px 20px 0; border-top: none; background: transparent; margin-bottom: 20px;">
                <div class="navid-customizer-upsell" style="padding: 16px; background: #fff; border-left: 4px solid var(--sage, #728c69); box-shadow: 0 1px 3px rgba(0,0,0,0.05); border-radius: 3px;">
                    <span style="display:block; font-size:13px; color:#3c434a; line-height: 1.5;">
                        {{ data.title }}
                        <# if ( data.upsell_text && data.upsell_url ) { #>
                            <a href="{{ data.upsell_url }}" target="_blank" style="display:block; margin-top:8px; text-decoration:none; color:var(--sage, #728c69); font-weight:600;">
                                {{ data.upsell_text }} &rarr;
                            </a>
                        <# } #>
                    </span>
                </div>
            </li>
            <?php
        }
    }
}

if ( class_exists( 'WP_Customize_Control' ) ) {
    class Navid_Customize_Upsell_Control extends WP_Customize_Control {
        public $type = 'navid-upsell';
        public $upsell_text = '';
        public $upsell_url = '';

        public function render_content() {
            ?>
            <div class="navid-customizer-upsell" style="margin-top: 24px; padding: 16px; background: #fff; border-left: 4px solid var(--sage, #728c69); box-shadow: 0 1px 3px rgba(0,0,0,0.05); border-radius: 3px;">
                <span style="display:block; font-size:13px; color:#3c434a; line-height: 1.5;">
                    <?php echo esc_html( $this->label ); ?>
                    <?php if ( ! empty( $this->description ) ) : ?>
                        <br><span class="description" style="margin-top:4px; display:block; font-style:italic; font-size:12px; color:#646970;"><?php echo wp_kses_post( $this->description ); ?></span>
                    <?php endif; ?>
                    <?php if ( $this->upsell_text && $this->upsell_url ) : ?>
                        <a href="<?php echo esc_url( $this->upsell_url ); ?>" target="_blank" style="display:block; margin-top:8px; text-decoration:none; color:var(--sage, #728c69); font-weight:600;">
                            <?php echo esc_html( $this->upsell_text ); ?> &rarr;
                        </a>
                    <?php endif; ?>
                </span>
            </div>
            <?php
        }
    }

    class Navid_Message_Control extends WP_Customize_Control {
        public $type = 'navid_message';
        public function render_content() {
            ?>
            <div class="navid-customizer-message" style="padding:12px;background:#fff8e5;border-left:4px solid #f0b849;border-radius:3px;margin-bottom:16px;box-shadow:0 1px 2px rgba(0,0,0,0.05);">
                <span class="customize-control-title" style="margin-bottom:6px;color:#d63638;font-weight:600;display:flex;align-items:center;gap:6px;">
                    <span class="dashicons dashicons-warning" style="font-size:16px;width:16px;height:16px;"></span>
                    <?php echo esc_html( $this->label ); ?>
                </span>
                <p style="margin:0;font-size:12px;line-height:1.4;color:#50575e;"><?php echo wp_kses_post( $this->description ); ?></p>
            </div>
            <?php
        }
    }
}

/**
 * Customizer Active Callbacks
 */
function navid_is_ad_header_enabled( $control ) {
    $s = $control->manager->get_setting( 'navid_ad_header_enable' );
    return $s ? (bool) $s->value() : false;
}

function navid_is_ad_before_enabled( $control ) {
    $s = $control->manager->get_setting( 'navid_ad_before_enable' );
    return $s ? (bool) $s->value() : false;
}
function navid_is_ad_after_enabled( $control ) {
    $s = $control->manager->get_setting( 'navid_ad_after_enable' );
    return $s ? (bool) $s->value() : false;
}

/**
 * Customizer Settings
 */
function navid_customize_register( $wp_customize ) {

    // --- Active Callbacks ---
    if ( ! function_exists( 'navid_is_hero_standard' ) ) {
        function navid_is_hero_standard( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            return $s ? $s->value() === 'standard' : true;
        }
    }
    if ( ! function_exists( 'navid_is_hero_split' ) ) {
        function navid_is_hero_split( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            return $s ? $s->value() === 'split' : false;
        }
    }
    if ( ! function_exists( 'navid_is_hero_custom_source' ) ) {
        function navid_is_hero_custom_source( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_source' );
            return $s ? $s->value() === 'custom' : false;
        }
    }
    if ( ! function_exists( 'navid_is_editor_picks_toggle' ) ) {
        function navid_is_editor_picks_toggle( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            return $s ? $s->value() === 'standard' : true;
        }
    }
    if ( ! function_exists( 'navid_is_editor_picks_custom_cat' ) ) {
        function navid_is_editor_picks_custom_cat( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            $layout = $s ? $s->value() : 'standard';
            if ( $layout !== 'standard' && $layout !== 'grid' && $layout !== 'newspaper' ) return false;
            
            $picks_show = $control->manager->get_setting( 'navid_editor_picks_show' );
            if ( $layout === 'standard' && $picks_show && ! $picks_show->value() ) return false;
            
            $source = $control->manager->get_setting( 'navid_editor_picks_source' );
            return $source ? $source->value() === 'category' : false;
        }
    }
    if ( ! function_exists( 'navid_is_editor_picks_shown' ) ) {
        function navid_is_editor_picks_shown( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            $layout = $s ? $s->value() : 'standard';
            if ( $layout === 'grid' || $layout === 'newspaper' ) return true;
            if ( $layout !== 'standard' ) return false;
            
            $picks_show = $control->manager->get_setting( 'navid_editor_picks_show' );
            return $picks_show ? (bool) $picks_show->value() : true;
        }
    }
    if ( ! function_exists( 'navid_is_editor_picks_title' ) ) {
        function navid_is_editor_picks_title( $control ) {
            $s = $control->manager->get_setting( 'navid_hero_layout' );
            $layout = $s ? $s->value() : 'standard';
            if ( $layout !== 'standard' ) return false;
            
            $picks_show = $control->manager->get_setting( 'navid_editor_picks_show' );
            return $picks_show ? (bool) $picks_show->value() : true;
        }
    }
    if ( ! function_exists( 'navid_is_hero_bento_or_grid' ) ) {
        function navid_is_hero_bento_or_grid( $control ) {
            $setting = $control->manager->get_setting( 'navid_hero_layout' );
            $layout = $setting ? $setting->value() : 'standard';
            return in_array( $layout, array( 'bento', 'grid' ), true );
        }
    }
    // Require custom controls
    require_once get_theme_file_path( '/inc/customizer/controls/ToggleControl.php' );
    require_once get_theme_file_path( '/inc/customizer/controls/RadioImageControl.php' );

    // ── Register Panels ───────────────────────────────────────
    $wp_customize->add_panel( 'navid_global_panel', array(
        'title'       => __( 'Global Settings', 'navid' ),
        'priority'    => 20,
    ) );
    $wp_customize->add_panel( 'navid_header_footer_panel', array(
        'title'       => __( 'Header & Marketing', 'navid' ),
        'priority'    => 21,
    ) );
    $wp_customize->add_panel( 'navid_homepage_panel', array(
        'title'       => __( 'Homepage Settings', 'navid' ),
        'description' => sprintf(
            /* translators: %s: Link to Pro version */
            __( '✨ <strong>Pro Feature:</strong> Want to drag-and-drop to reorder these sections? <a href="%s" target="_blank">Unlock the Homepage Layout Manager in Navid Pro</a>.', 'navid' ),
            esc_url( 'https://wpmatcha.com' )
        ),
        'priority'    => 22,
    ) );
    $wp_customize->add_panel( 'navid_templates_panel', array(
        'title'       => __( 'Blog & Page Templates', 'navid' ),
        'priority'    => 23,
    ) );
    // Move Native Sections
    $wp_customize->get_section( 'colors' )->panel = 'navid_global_panel';

    // ══════════════════════════════════════════════════════════════
    // ✨ QUICK START PRESETS — visible to ALL users (free & pro)
    //    Free presets: Standard, Classic Newspaper — fully clickable
    //    Pro presets:  Magazine, News, Bento — show locked state
    // ══════════════════════════════════════════════════════════════
    if ( ! navid_is_pro_active() ) {
        // Only register here when navid-pro is NOT active.
        
        // Homepage Layout Manager Upsell at bottom of Panel
        $wp_customize->register_section_type( 'Navid_Customize_Upsell_Section' );
        $wp_customize->add_section( new Navid_Customize_Upsell_Section( $wp_customize, 'navid_layout_upsell_section', array(
            'title'       => __( 'Want to reorder these homepage sections with drag-and-drop?', 'navid' ),
            'panel'       => 'navid_homepage_panel',
            'priority'    => 999,
            'upsell_text' => __( 'Unlock Drag & Drop Homepage Sections in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com',
        ) ) );
        
        // Dummy control to ensure the section is not hidden by WP Customizer JS
        $wp_customize->add_setting( 'navid_layout_upsell_dummy', array(
            'sanitize_callback' => 'sanitize_text_field',
        ) );
        $wp_customize->add_control( 'navid_layout_upsell_dummy', array(
            'section' => 'navid_layout_upsell_section',
            'type'    => 'hidden',
        ) );

        // White-Label Branding Upsell at bottom of Panel
        $wp_customize->add_section( new Navid_Customize_Upsell_Section( $wp_customize, 'navid_whitelabel_upsell_section', array(
            'title'       => __( 'Want to rebrand this theme?', 'navid' ),
            'panel'       => 'navid_global_panel',
            'priority'    => 999,
            'upsell_text' => __( 'Unlock White-Label Branding in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
        ) ) );
        $wp_customize->add_setting( 'navid_whitelabel_upsell_dummy', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'navid_whitelabel_upsell_dummy', array(
            'section' => 'navid_whitelabel_upsell_section',
            'type'    => 'hidden',
        ) );

        // Quick Start Presets Upsell

        $wp_customize->add_section( 'navid_global_presets_section', array(
            'title'    => __( '✨ Quick Start Presets', 'navid' ),
            'priority' => 1,
        ) );

        $wp_customize->add_setting( 'navid_global_preset', array(
            'default'           => 'standard',
            'sanitize_callback' => 'sanitize_key',
        ) );

        if ( class_exists( 'Navid_Radio_Image_Control' ) ) {
            $locked_presets = apply_filters( 'navid_locked_presets', array( 'magazine', 'news', 'bento' ) );
            $is_mag_locked  = in_array( 'magazine', $locked_presets, true );
            $is_pro_active  = navid_is_pro_active();
            
            // If child theme unlocked magazine (not Pro), add Lite version and force Pro version locked for upsell
            $show_lite_upsell = ( ! $is_mag_locked && ! $is_pro_active );
            
            if ( $show_lite_upsell ) {
                $is_mag_locked = true;
            }

            $choices = array(
                'standard'  => array(
                    'name' => __( 'Standard (Default)', 'navid' ),
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                ),
                'newspaper' => array(
                    'name' => __( 'Classic Newspaper (Tribune)', 'navid' ),
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 8h18M8 21V8M16 21V8"/></svg>',
                ),
            );

            if ( $show_lite_upsell ) {
                $choices['magazine_lite'] = array(
                    'name' => __( 'Magazine (Lite)', 'navid' ),
                    'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 3v18"/></svg>',
                );
            }

            $choices['magazine'] = array(
                'name' => $is_mag_locked ? __( 'Magazine (Split) 🔒', 'navid' ) : __( 'Magazine (Split)', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M12 3v18"/></svg>',
            );
            $choices['news'] = array(
                'name' => __( 'News (Grid) 🔒', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="8" height="8" rx="1"/><rect x="13" y="13" width="8" height="8" rx="1"/></svg>',
            );
            $choices['bento'] = array(
                'name' => __( 'Bento Box 🔒', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="8" height="8" rx="1"/><rect x="13" y="3" width="8" height="8" rx="1"/><rect x="3" y="13" width="18" height="8" rx="1"/></svg>',
            );

            $wp_customize->add_control( new Navid_Radio_Image_Control( $wp_customize, 'navid_global_preset', array(
                'label'       => __( 'Select a Theme Style', 'navid' ),
                'description' => __( 'Clicking a preset will instantly configure your Hero, Feed, Sidebar, and Typography.', 'navid' ),
                'section'     => 'navid_global_presets_section',
                'choices'     => $choices,
                'priority'    => 5,
            ) ) );
        }

        // Inline CSS + JS: locked Pro presets + always-visible upgrade notice + free preset switching.
        add_action( 'customize_controls_print_footer_scripts', function() {
            $locked_presets = apply_filters( 'navid_locked_presets', array( 'magazine', 'news', 'bento' ) );
            $is_mag_locked  = in_array( 'magazine', $locked_presets, true );
            $is_pro_active  = navid_is_pro_active();
            
            $show_lite_upsell = ( ! $is_mag_locked && ! $is_pro_active );
            if ( $show_lite_upsell ) {
                $locked_presets[] = 'magazine'; // Force locked for CSS/JS
            }
            
            $css_selectors = array();
            foreach ( $locked_presets as $preset ) {
                $css_selectors[] = '#customize-control-navid_global_preset .navid-radio-image-option[data-value="' . esc_attr( $preset ) . '"]';
            }
            ?>
            <style>
            <?php if ( ! empty( $css_selectors ) ) : ?>
            /* ── Locked Pro preset cards ── */
            <?php echo implode( ",\n            ", $css_selectors ); ?> {
                opacity: 0.4;
                cursor: not-allowed;
                pointer-events: none;
                user-select: none;
            }
            <?php endif; ?>
            /* ── Static Pro upgrade notice ── */
            #navid-preset-pro-notice {
                margin-top: 10px;
                padding: 10px 12px;
                border-left: 3px solid #c78c3e;
                background: #fdfaf5;
                font-size: 12px;
                line-height: 1.6;
            }
            #navid-preset-pro-notice strong {
                display: block;
                color: #3c3c3c;
                margin-bottom: 3px;
            }
            #navid-preset-pro-notice a {
                color: #c78c3e;
                text-decoration: none;
                font-weight: 600;
            }
            #navid-preset-pro-notice a:hover { text-decoration: underline; }
            </style>
            <script>
            (function($) {
                var proPresets = <?php echo wp_json_encode( array_values( $locked_presets ) ); ?>;

                // Free preset settings map (mirrors customizer-presets.js for free layouts only).
                var freePresetMap = {
                    'standard': {
                        'navid_hero_layout'           : 'standard',
                        'navid_feed_layout'           : 'bento',
                        'navid_archive_sidebar'       : 'center',
                        'navid_global_image_radius'   : 0,
                        'navid_header_style'          : 'transparent'
                    },
                    'newspaper': {
                        'navid_hero_layout'           : 'newspaper',
                        'navid_feed_layout'           : 'newspaper',
                        'navid_archive_sidebar'       : 'right',
                        'navid_global_image_radius'   : 0,
                        'navid_header_style'          : 'solid'
                    }
                    <?php if ( $show_lite_upsell ) : ?>,
                    'magazine_lite': {
                        'navid_hero_layout'           : 'split',
                        'navid_feed_layout'           : 'bento',
                        'navid_archive_sidebar'       : 'right',
                        'navid_global_image_radius'   : 0,
                        'navid_header_style'          : 'solid'
                    }
                    <?php endif; ?>
                };

                wp.customize.bind('ready', function() {

                    // 1. Inject static upgrade notice below the preset control.
                    var control = document.getElementById('customize-control-navid_global_preset');
                    if (control) {
                        var notice = document.createElement('div');
                        notice.id  = 'navid-preset-pro-notice';
                        notice.innerHTML =
                            '<strong><?php echo esc_js( __( '🔒 Some layouts require Navid Pro', 'navid' ) ); ?></strong>' +
                            '<?php echo esc_js( __( 'Upgrade to unlock all Pro layouts with one-click import.', 'navid' ) ); ?> ' +
                            '<a href="https://wpmatcha.com/wordpress-themes/navid/" target="_blank" rel="noopener">' +
                            '<?php echo esc_js( __( 'Upgrade to Pro →', 'navid' ) ); ?>' +
                            '</a>';
                        control.appendChild(notice);
                    }

                    // 2. Guard: if a Pro preset is somehow selected, revert immediately.
                    var setting = wp.customize('navid_global_preset');
                    if (!setting) return;

                    setting.bind(function(newVal) {
                        if (proPresets.indexOf(newVal) !== -1) {
                            // Silently revert — no popup.
                            var prev = setting.get();
                            setting.set( (freePresetMap[prev] ? prev : 'standard') );
                        }
                    });

                    // 3. Apply free preset settings to live preview when a free preset is clicked.
                    setting.bind(function(newVal) {
                        if (!freePresetMap[newVal]) return;
                        $.each(freePresetMap[newVal], function(settingId, settingValue) {
                            var s = wp.customize(settingId);
                            if (s) { s.set(settingValue); }
                        });
                    });

                });
            }(jQuery));
            </script>
            <?php
        } );
    }


    // ── Front Page Display Options Section ────────────
    $wp_customize->add_section( 'navid_static_frontpage_section', array(
        'title'    => __( 'Front Page Display Options', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 0, // Put it at the very top of Homepage Settings panel
    ) );

    // Info Message Control explaining current status
    $wp_customize->add_setting( 'navid_frontpage_display_info', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    $is_static_page = ( 'page' === get_option( 'show_on_front' ) );
    $frontpage_info_desc = $is_static_page
        ? __( 'Your site is set to display a <strong>Static Page</strong> as the front page. Navid automatically displays all dynamic magazine sections (Hero Bento, Feed, Categories, etc.) by default while cleanly embedding your static page content.', 'navid' )
        : __( 'Your site is set to display <strong>Your Latest Posts</strong>. All dynamic magazine sections below are active on your front page.', 'navid' );

    $wp_customize->add_control( new Navid_Message_Control( $wp_customize, 'navid_frontpage_display_info', array(
        'label'       => __( 'Homepage Mode Status', 'navid' ),
        'description' => $frontpage_info_desc,
        'section'     => 'navid_static_frontpage_section',
        'priority'    => 1,
    ) ) );

    // Toggle: Show magazine sections on static front page
    $wp_customize->add_setting( 'navid_frontpage_sections_on_static', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_frontpage_sections_on_static', array(
        'label'       => __( 'Show Magazine Sections on Static Page', 'navid' ),
        'description' => __( 'When enabled, all dynamic editorial sections (Hero Bento, Feed, Categories, Trending, etc.) remain active when a static page is set as your homepage.', 'navid' ),
        'section'     => 'navid_static_frontpage_section',
        'priority'    => 5,
    ) ) );

    // Select: Static page content position
    $wp_customize->add_setting( 'navid_frontpage_static_page_content_position', array(
        'default'           => 'below_hero',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_frontpage_static_page_content_position', array(
        'label'           => __( 'Static Page Content Position', 'navid' ),
        'description'     => __( 'Choose where the editor content (blocks/text) of your static page appears relative to the magazine sections.', 'navid' ),
        'section'         => 'navid_static_frontpage_section',
        'type'            => 'select',
        'choices'         => array(
            'below_hero'     => __( 'Directly Below Hero Section (Recommended)', 'navid' ),
            'above_hero'     => __( 'Top of Page (Above Hero)', 'navid' ),
            'below_sections' => __( 'Bottom of Page (Above Newsletter CTA)', 'navid' ),
            'hide'           => __( 'Do Not Display (Sections Only)', 'navid' ),
        ),
        'priority'        => 10,
        'active_callback' => function() {
            return ( 'page' === get_option( 'show_on_front' ) && (bool) get_theme_mod( 'navid_frontpage_sections_on_static', true ) );
        },
    ) );



    $wp_customize->add_section( 'navid_hero_section', array(
        'title'    => __( 'Hero Section', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 30,
    ) );

    // ── Layout settings used by Quick Start Presets (free version) ────────────
    // No visible control — registered so the preset JS can call .set() on them
    // and trigger a live preview refresh via the transport => 'refresh'.
    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_hero_layout', array(
            'default'           => 'standard',
            'sanitize_callback' => 'sanitize_key',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_setting( 'navid_feed_layout', array(
            'default'           => 'bento',
            'sanitize_callback' => 'sanitize_key',
            'transport'         => 'refresh',
        ) );
        $wp_customize->add_setting( 'navid_archive_sidebar', array(
            'default'           => 'center',
            'sanitize_callback' => 'sanitize_key',
            'transport'         => 'refresh',
        ) );
    }


    $wp_customize->add_setting( 'navid_hero_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_hero_show', array(
        'label'   => __( 'Show Hero Section on Homepage', 'navid' ),
        'section' => 'navid_hero_section',
    ) ) );

    // Hero layout setting available in Navid Pro — only show upsell to free users
    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_hero_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_hero_upsell', array(
            'label'       => __( 'Need more Hero layouts?', 'navid' ),
            'section'     => 'navid_hero_section',
            'upsell_text' => __( 'Unlock Split Screen, Grid, Bento Layouts & Editor\'s Picks Options in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 10,
        ) ) );
    }

    // Hero Source Heading
    $wp_customize->add_setting( 'navid_hero_general_heading', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( new Navid_Heading_Control( $wp_customize, 'navid_hero_general_heading', array(
        'label'   => __( 'General Settings', 'navid' ),
        'section' => 'navid_hero_section',
    ) ) );

    // Hero Source
    $wp_customize->add_setting( 'navid_hero_source', array(
        'default'           => 'latest',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_hero_source', array(
        'label'   => __( 'Hero Content Source', 'navid' ),
        'section' => 'navid_hero_section',
        'type'    => 'select',
        'choices' => array(
            'custom' => __( 'Custom Content (Below)', 'navid' ),
            'latest' => __( 'Latest Blog Post', 'navid' ),
            'sticky' => __( 'Latest Sticky Post', 'navid' ),
        ),
    ) );

    // Hero Image
    $wp_customize->add_setting( 'navid_hero_image', array(
        'default'           => get_template_directory_uri() . '/assets/images/hero-navid.jpg',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'navid_hero_image', array(
        'label'    => __( 'Background Image (Panel 1)', 'navid' ),
        'section'  => 'navid_hero_section',
        'active_callback' => 'navid_is_hero_custom_source',
    ) ) );

    // --- Panel 2 (Split Only) Settings available in Navid Pro ---

    // Text Content Heading
    $wp_customize->add_setting( 'navid_hero_text_heading', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( new Navid_Heading_Control( $wp_customize, 'navid_hero_text_heading', array(
        'label'   => __( 'Text & Content', 'navid' ),
        'section' => 'navid_hero_section',
        'active_callback' => 'navid_is_hero_custom_source',
    ) ) );

    // Show Hero Tag Toggle
    $wp_customize->add_setting( 'navid_hero_tag_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_hero_tag_show', array(
        'label'   => __( 'Show Hero Tag', 'navid' ),
        'section' => 'navid_hero_section',
        'priority'=> 13,
    ) ) );

    // Hero Custom Tag Text
    $wp_customize->add_setting( 'navid_hero_custom_tag_text', array(
        'default'           => __( 'FEATURED', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_hero_custom_tag_text', array(
        'label'           => __( 'Hero Custom Tag', 'navid' ),
        'description'     => __( 'Edit the tag text when Hero Content Source is Custom Content.', 'navid' ),
        'section'         => 'navid_hero_section',
        'type'            => 'text',
        'priority'        => 14,
        'active_callback' => 'navid_is_hero_custom_source',
    ) );

    // Hero Title
    $wp_customize->add_setting( 'navid_hero_title', array(
        'default'           => 'The Modern <em>Aesthetic</em>',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'navid_hero_title', array(
        'label'   => __( 'Hero Title (Panel 1)', 'navid' ),
        'section' => 'navid_hero_section',
        'type'    => 'text',
        'priority'=> 15,
        'description' => __( 'Use <em> for italics.', 'navid' ),
        'active_callback' => 'navid_is_hero_custom_source',
    ) );


    // Hero Excerpt
    $wp_customize->add_setting( 'navid_hero_excerpt', array(
        'default'           => "Discover the world's most fascinating stories, curated for the modern, curious mind.",
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_hero_excerpt', array(
        'label'   => __( 'Hero Excerpt', 'navid' ),
        'section' => 'navid_hero_section',
        'type'    => 'text',
        'priority'=> 16,
        'active_callback' => 'navid_is_hero_custom_source',
    ) );

    // Button Text
    $wp_customize->add_setting( 'navid_hero_btn_text', array(
        'default'           => 'Read the Story',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_hero_btn_text', array(
        'label'   => __( 'Button Text (Panel 1)', 'navid' ),
        'section' => 'navid_hero_section',
        'type'    => 'text',
        'active_callback' => 'navid_is_hero_custom_source',
    ) );

    // Button URL
    $wp_customize->add_setting( 'navid_hero_btn_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'navid_hero_btn_url', array(
        'label'   => __( 'Button Link (Panel 1)', 'navid' ),
        'section' => 'navid_hero_section',
        'type'    => 'url',
        'active_callback' => 'navid_is_hero_custom_source',
    ) );


    // Show Hero Meta (author, date, category)
    $wp_customize->add_setting( 'navid_hero_meta_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_hero_meta_show', array(
        'label'   => __( 'Show Hero Meta (Author, Date, Category)', 'navid' ),
        'section' => 'navid_hero_section',
    ) ) );

    // Sidebar / Editor's Picks Heading
    $wp_customize->add_setting( 'navid_hero_sidebar_heading', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( new Navid_Heading_Control( $wp_customize, 'navid_hero_sidebar_heading', array(
        'label'    => __( 'Sidebar (Editor\'s Picks)', 'navid' ),
        'section'  => 'navid_hero_section',
        'priority' => 100,
    ) ) );

    // Show Editor's Picks
    $wp_customize->add_setting( 'navid_editor_picks_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_editor_picks_show', array(
        'label'           => __( 'Show Editor\'s Picks', 'navid' ),
        'section'         => 'navid_hero_section',
        'priority'        => 101,
        'active_callback' => 'navid_is_editor_picks_toggle',
    ) ) );

    // Editor's Picks Title
    $wp_customize->add_setting( 'navid_editor_picks_title', array(
        'default'           => __( 'Editor\'s Picks', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_editor_picks_title', array(
        'label'           => __( 'Editor\'s Picks Title', 'navid' ),
        'section'         => 'navid_hero_section',
        'type'            => 'text',
        'priority'        => 102,
        'active_callback' => 'navid_is_editor_picks_title',
    ) );

    // Editor's Picks Source
    $wp_customize->add_setting( 'navid_editor_picks_source', array(
        'default'           => 'latest',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_editor_picks_source', array(
        'label'           => __( 'Editor\'s Picks Source', 'navid' ),
        'section'         => 'navid_hero_section',
        'type'            => 'select',
        'choices'         => array(
            'latest'   => __( 'Latest Posts', 'navid' ),
            'category' => __( 'Specific Category', 'navid' ),
        ),
        'priority'        => 103,
        'active_callback' => 'navid_is_editor_picks_shown',
    ) );

    // Editor's Picks Category
    $wp_customize->add_setting( 'navid_editor_picks_category', array(
        'default'           => 0,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_editor_picks_category', array(
        'label'           => __( 'Editor\'s Picks Category', 'navid' ),
        'section'         => 'navid_hero_section',
        'type'            => 'dropdown-categories',
        'priority'        => 104,
        'active_callback' => 'navid_is_editor_picks_custom_cat',
    ) );

    // Editor's Picks Count
    $wp_customize->add_setting( 'navid_editor_picks_count', array(
        'default'           => 9,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_editor_picks_count', array(
        'label'           => __( 'Number of Posts', 'navid' ),
        'section'         => 'navid_hero_section',
        'type'            => 'number',
        'input_attrs'     => array( 'min' => 3, 'max' => 20 ),
        'priority'        => 105,
        'active_callback' => 'navid_is_editor_picks_shown',
    ) );

    // Editor's Picks Auto-play
    $wp_customize->add_setting( 'navid_editor_picks_autoplay', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_editor_picks_autoplay', array(
        'label'           => __( 'Auto-play Slider', 'navid' ),
        'section'         => 'navid_hero_section',
        'priority'        => 107,
        'active_callback' => 'navid_is_editor_picks_shown',
    ) ) );

    // ── Latest Stories Section ──────────────────────────────────
    $wp_customize->add_section( 'navid_feed_section', array(
        'title'    => __( 'Latest Stories (Feed)', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 38,
    ) );

    $wp_customize->add_setting( 'navid_feed_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_feed_show', array(
        'label'   => __( 'Show Latest Stories Section', 'navid' ),
        'section' => 'navid_feed_section',
    ) ) );

    $wp_customize->add_setting( 'navid_latest_stories_title', array(
        'default'           => 'Latest Stories',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_latest_stories_title', array(
        'label'           => __( 'Section Title', 'navid' ),
        'section'         => 'navid_feed_section',
        'type'            => 'text',
        'active_callback' => function( $control ) {
            $s = $control->manager->get_setting( 'navid_feed_show' );
            return $s ? (bool) $s->value() : true;
        },
    ) );

    // ── Home Categories Section ──────────────────────────────────
    $wp_customize->add_section( 'navid_home_categories_section', array(
        'title'    => __( 'Home Categories', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 31,
    ) );

    $wp_customize->add_setting( 'navid_home_categories_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_home_categories_show', array(
        'label'   => __( 'Show Category Cards', 'navid' ),
        'section' => 'navid_home_categories_section',
    ) ) );

    $wp_customize->add_setting( 'navid_home_categories_title', array(
        'default'           => __( 'Trending Topics', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_home_categories_title', array(
        'label'   => __( 'Section Title', 'navid' ),
        'section' => 'navid_home_categories_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_home_categories_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_home_categories_count', array(
        'label'       => __( 'Number of Categories', 'navid' ),
        'section'     => 'navid_home_categories_section',
        'type'        => 'number',
        'input_attrs' => array( 'min' => 2, 'max' => 12 ),
    ) );

    // ── Interlude Section ──────────────────────────────────────
    $wp_customize->add_section( 'navid_interlude_section', array(
        'title'    => __( 'Interlude Quote', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'navid_quote_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_quote_show', array(
        'label'   => __( 'Show Interlude Quote', 'navid' ),
        'section' => 'navid_interlude_section',
    ) ) );

    $wp_customize->add_setting( 'navid_quote_text', array(
        'default'           => __( 'The universe is full of magical things patiently waiting for our wits to grow sharper.', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_quote_text', array(
        'label'   => __( 'Quote Text', 'navid' ),
        'section' => 'navid_interlude_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_quote_author', array(
        'default'           => __( 'Eden Phillpotts', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_quote_author', array(
        'label'   => __( 'Quote Author', 'navid' ),
        'section' => 'navid_interlude_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_quote_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navid_quote_bg_color', array(
        'label'   => __( 'Background Color', 'navid' ),
        'section' => 'navid_interlude_section',
    ) ) );

    $wp_customize->add_setting( 'navid_quote_bg_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'navid_quote_bg_image', array(
        'label'   => __( 'Background Image', 'navid' ),
        'section' => 'navid_interlude_section',
    ) ) );

    if ( ! navid_pro_is_active() ) {
        $wp_customize->add_setting( 'navid_quote_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_quote_upsell', array(
            'label'       => __( 'Want an eye-catching video background?', 'navid' ),
            'section'     => 'navid_interlude_section',
            'upsell_text' => __( 'Unlock YouTube & MP4 Video Backgrounds in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 10,
        ) ) );
    }

    // ── Featured Grid (2-up) Section ───────────────────────────────
    $wp_customize->add_section( 'navid_featured_grid_section', array(
        'title'    => __( 'Featured Grid (2-Up)', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 33,
    ) );

    $wp_customize->add_setting( 'navid_featured_grid_show', array( 'default' => true, 'sanitize_callback' => 'navid_sanitize_checkbox' ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_featured_grid_show', array( 'label' => __( 'Show Section', 'navid' ), 'section' => 'navid_featured_grid_section' ) ) );

    $wp_customize->add_setting( 'navid_featured_grid_title', array( 'default' => __( 'Editor\'s Picks', 'navid' ), 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_featured_grid_title', array( 'label' => __( 'Section Title', 'navid' ), 'section' => 'navid_featured_grid_section', 'type' => 'text' ) );

    // ── More Stories (Masonry) Section ───────────────────────────────
    $wp_customize->add_section( 'navid_masonry_section', array(
        'title'    => __( 'More Stories (Masonry)', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 34,
    ) );

    $wp_customize->add_setting( 'navid_masonry_show', array( 'default' => true, 'sanitize_callback' => 'navid_sanitize_checkbox' ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_masonry_show', array( 'label' => __( 'Show Section', 'navid' ), 'section' => 'navid_masonry_section' ) ) );

    $wp_customize->add_setting( 'navid_masonry_title', array( 'default' => __( 'More Stories', 'navid' ), 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_masonry_title', array( 'label' => __( 'Section Title', 'navid' ), 'section' => 'navid_masonry_section', 'type' => 'text' ) );

    // ── Marquee Strip Section ──────────────────────────────────
    $wp_customize->add_section( 'navid_marquee_section', array(
        'title'    => __( 'Marquee Strip', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 36,
    ) );

    $wp_customize->add_setting( 'navid_marquee_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_marquee_show', array(
        'label'   => __( 'Show Marquee Strip', 'navid' ),
        'section' => 'navid_marquee_section',
    ) ) );

    $wp_customize->add_setting( 'navid_marquee_source', array(
        'default'           => 'categories',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_marquee_source', array(
        'label'   => __( 'Marquee Content Source', 'navid' ),
        'section' => 'navid_marquee_section',
        'type'    => 'select',
        'choices' => array(
            'categories' => __( 'Top Categories', 'navid' ),
            'custom'     => __( 'Custom Text', 'navid' ),
        ),
    ) );

    $wp_customize->add_setting( 'navid_marquee_text', array(
        'default'           => 'LIFESTYLE • TECHNOLOGY • BUSINESS • CULTURE • DESIGN • WELLNESS',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_marquee_text', array(
        'label'   => __( 'Custom Marquee Text', 'navid' ),
        'section' => 'navid_marquee_section',
        'type'    => 'text',
        'description' => __( 'Use • or | to separate items visually.', 'navid' ),
    ) );

    $wp_customize->add_setting( 'navid_marquee_count', array(
        'default'           => 10,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_marquee_count', array(
        'label'   => __( 'Number of Categories (If Source is Categories)', 'navid' ),
        'section' => 'navid_marquee_section',
        'type'    => 'number',
        'input_attrs' => array( 'min' => 1, 'max' => 30 ),
    ) );

    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_marquee_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_marquee_upsell', array(
            'label'       => __( 'Need More Marquee Options?', 'navid' ),
            'section'     => 'navid_marquee_section',
            'upsell_text' => __( 'Unlock Speed Controls, Categories & WooCommerce in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 99,
        ) ) );
    }

    // ── Layout Options Section ───────────────────────────────
    $wp_customize->add_section( 'navid_layout_section', array(
        'title'       => __( 'Site Layout', 'navid' ),
        'panel'       => 'navid_global_panel',
        'priority'    => 20,
    ) );

    $wp_customize->add_setting( 'navid_content_width', array(
        'default'           => 1280,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'navid_content_width', array(
        'label'       => __( 'Container Max Width (px)', 'navid' ),
        'description' => __( 'The maximum width of the main site container.', 'navid' ),
        'section'     => 'navid_layout_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 1000,
            'max'  => 1600,
            'step' => 10,
        ),
        'priority'    => 2,
    ) );

    // No redundant setting here. Moved content_width below.
    
    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_layout_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_layout_upsell', array(
            'label'       => __( 'Want AJAX Load More & Infinite Scroll?', 'navid' ),
            'section'     => 'navid_layout_section',
            'upsell_text' => __( 'Unlock AJAX Load More & Infinite Scroll in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 1,
        ) ) );
    }

    $wp_customize->add_setting( 'navid_global_image_radius', array( 'default' => 0, 'sanitize_callback' => 'absint' ) );
    $wp_customize->add_control( 'navid_global_image_radius', array(
        'label'       => __( 'Global Image Radius (px)', 'navid' ),
        'description' => __( 'Applies rounded corners to all images across the site.', 'navid' ),
        'section'     => 'navid_layout_section',
        'type'        => 'number',
        'priority'    => 5,
    ) );

    // Single Post Sidebar
    $wp_customize->add_setting( 'navid_single_sidebar', array(
        'default'           => 'none',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( new Navid_Radio_Image_Control( $wp_customize, 'navid_single_sidebar', array(
        'label'   => __( 'Single Post Sidebar', 'navid' ),
        'section' => 'navid_single_section',
        'choices' => array(
            'none'  => array(
                'name' => __( 'No Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>',
            ),
            'left'  => array(
                'name' => __( 'Left Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>',
            ),
            'right' => array(
                'name' => __( 'Right Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M15 3v18"/></svg>',
            ),
        ),
    ) ) );

    // Archive Sidebar
    $wp_customize->add_setting( 'navid_archive_sidebar', array(
        'default'           => 'center',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( new Navid_Radio_Image_Control( $wp_customize, 'navid_archive_sidebar', array(
        'label'   => __( 'Archive & Blog Sidebar', 'navid' ),
        'section' => 'navid_blog_section',
        'choices' => array(
            'center' => array(
                'name' => __( 'Center Widgets (Grid)', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>',
            ),
            'none'  => array(
                'name' => __( 'No Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>',
            ),
            'left'  => array(
                'name' => __( 'Left Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 3v18"/></svg>',
            ),
            'right' => array(
                'name' => __( 'Right Sidebar', 'navid' ),
                'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M15 3v18"/></svg>',
            ),
        ),
    ) ) );

    // ── Colors Section ──────────────────────────────────────
    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_colors_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_colors_upsell', array(
            'label'       => __( 'Need Advanced Dark Mode Colors?', 'navid' ),
            'section'     => 'colors',
            'upsell_text' => __( 'Unlock Dark Mode Customization & Gradients in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 1,
        ) ) );
    }
    
    $wp_customize->add_setting( 'navid_default_mode', array(
        'default'           => 'light',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_default_mode', array(
        'label'    => __( 'Default Theme Mode', 'navid' ),
        'section'  => 'colors',
        'type'     => 'select',
        'priority' => 1,
        'choices'  => array(
            'light' => __( 'Light Mode', 'navid' ),
            'dark'  => __( 'Dark Mode', 'navid' ),
            'auto'  => __( 'Auto (OS Preference)', 'navid' ),
        ),
    ) );

    $wp_customize->add_setting( 'navid_color_palette', array(
        'default'           => 'rose',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( new Navid_Palette_Control( $wp_customize, 'navid_color_palette', array(
        'label'    => __( 'Color Palette', 'navid' ),
        'section'  => 'colors',
        'priority' => 1,
        'palettes' => array(
            'sage'       => array( 'color' => '#728c69', 'label' => __( 'Sage', 'navid' ) ),
            'ocean'      => array( 'color' => '#2d6a8a', 'label' => __( 'Ocean', 'navid' ) ),
            'rose'       => array( 'color' => '#b5565d', 'label' => __( 'Rose', 'navid' ) ),
            'amber'      => array( 'color' => '#c47834', 'label' => __( 'Amber', 'navid' ) ),
            'slate'      => array( 'color' => '#5a6575', 'label' => __( 'Slate', 'navid' ) ),
            'plum'       => array( 'color' => '#7a5c8a', 'label' => __( 'Plum', 'navid' ) ),
            'terracotta' => array( 'color' => '#c9a96e', 'label' => __( 'Terracotta', 'navid' ) ),
            'custom'     => array( 'color' => 'linear-gradient(135deg,#ff6b6b,#feca57,#48dbfb,#ff9ff3)', 'label' => __( 'Custom', 'navid' ) ),
        ),
    ) ) );

    $wp_customize->add_setting( 'navid_accent_color', array(
        'default'           => '#b5565d',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navid_accent_color', array(
        'label'       => __( 'Custom Accent Color', 'navid' ),
        'description' => __( 'Only used when "Custom" palette is selected above.', 'navid' ),
        'section'     => 'colors',
        'priority'    => 2,
    ) ) );

    // ── Top Bar Section ──────────────────────────────────────
    $wp_customize->add_section( 'navid_topbar_section', array(
        'title'    => __( 'Top Bar', 'navid' ),
        'panel'    => 'navid_header_footer_panel',
        'priority' => 25,
    ) );

    $wp_customize->add_setting( 'navid_topbar_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_topbar_show', array(
        'label'   => __( 'Show Top Bar', 'navid' ),
        'section' => 'navid_topbar_section',
    ) ) );

    $wp_customize->add_setting( 'navid_topbar_text', array(
        'default'           => 'Stories worth reading. Perspectives worth sharing.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_topbar_text', array(
        'label'       => __( 'Tagline Text', 'navid' ),
        'description' => __( 'Leave empty to show the site tagline.', 'navid' ),
        'section'     => 'navid_topbar_section',
        'type'        => 'text',
    ) );

    $wp_customize->add_setting( 'navid_topbar_twitter', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_topbar_twitter', array(
        'label'   => __( 'X (Twitter) URL', 'navid' ),
        'section' => 'navid_topbar_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_topbar_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_topbar_instagram', array(
        'label'   => __( 'Instagram URL', 'navid' ),
        'section' => 'navid_topbar_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_topbar_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_topbar_facebook', array(
        'label'   => __( 'Facebook URL', 'navid' ),
        'section' => 'navid_topbar_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_topbar_youtube', array(
        'default'           => '#',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_topbar_youtube', array(
        'label'   => __( 'YouTube URL', 'navid' ),
        'section' => 'navid_topbar_section',
        'type'    => 'text',
    ) );

    $wp_customize->add_setting( 'navid_topbar_show_date', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_topbar_show_date', array(
        'label'   => __( 'Show Date', 'navid' ),
        'section' => 'navid_topbar_section',
    ) ) );

    // ── About Page Section ──────────────────────────────────
    $wp_customize->add_section( 'navid_about_section', array(
        'title'       => __( 'About Page & Home Services', 'navid' ),
        'description' => __( 'Configure your About Page hero, stats, and the Values/Services grid. Note: To edit the main photo and text paragraphs on the About page, please go to Pages > About and use the standard WordPress editor.', 'navid' ),
        'panel'       => 'navid_templates_panel',
        'priority'    => 45,
    ) );

    // About Photo
    $wp_customize->add_setting( 'navid_about_show_image', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_about_show_image', array(
        'label'       => __( 'Show Photo Area?', 'navid' ),
        'section'     => 'navid_about_section',
        'priority'    => 1,
    ) ) );

    $wp_customize->add_setting( 'navid_about_values_show_about', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_about_values_show_about', array(
        'label'       => __( 'Show Values/Services Grid on About Page?', 'navid' ),
        'section'     => 'navid_about_section',
        'priority'    => 1,
    ) ) );

    $wp_customize->add_setting( 'navid_about_values_show_home', array(
        'default'           => false,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_about_values_show_home', array(
        'label'       => __( 'Show Values/Services Grid on Homepage?', 'navid' ),
        'description' => __( 'Enable to display the Values/Services grid on your homepage.', 'navid' ),
        'section'     => 'navid_about_section',
        'priority'    => 2,
    ) ) );

    // Hero Text
    $wp_customize->add_setting( 'navid_about_hero_title', array( 'default' => 'Hi, we’re Navid.', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_hero_title', array( 'label' => __( 'Hero Title', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'navid_about_hero_subtitle', array( 'default' => 'We believe every reader deserves the absolute best stories.', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_hero_subtitle', array( 'label' => __( 'Hero Subtitle', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    // Stats
    $wp_customize->add_setting( 'navid_about_stat1_num', array( 'default' => '10K+', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat1_num', array( 'label' => __( 'Stat 1 Number', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'navid_about_stat1_label', array( 'default' => 'Active Readers', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat1_label', array( 'label' => __( 'Stat 1 Label', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'navid_about_stat2_num', array( 'default' => '50+', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat2_num', array( 'label' => __( 'Stat 2 Number', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'navid_about_stat2_label', array( 'default' => 'Partner Brands', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat2_label', array( 'label' => __( 'Stat 2 Label', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'navid_about_stat3_num', array( 'default' => '24/7', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat3_num', array( 'label' => __( 'Stat 3 Number', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );
    $wp_customize->add_setting( 'navid_about_stat3_label', array( 'default' => 'Expert Support', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_stat3_label', array( 'label' => __( 'Stat 3 Label', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    // Social Links
    $wp_customize->add_setting( 'navid_about_show_social', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_about_show_social', array(
        'label'       => __( 'Show Social Icons?', 'navid' ),
        'section'     => 'navid_about_section',
    ) ) );

    $wp_customize->add_setting( 'navid_about_social_ig', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_about_social_ig', array( 'label' => __( 'Instagram URL', 'navid' ), 'section' => 'navid_about_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'navid_about_social_tw', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_about_social_tw', array( 'label' => __( 'Twitter URL', 'navid' ), 'section' => 'navid_about_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'navid_about_social_yt', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_about_social_yt', array( 'label' => __( 'YouTube URL', 'navid' ), 'section' => 'navid_about_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'navid_about_social_email', array( 'default' => '#', 'sanitize_callback' => 'sanitize_email' ) );
    $wp_customize->add_control( 'navid_about_social_email', array( 'label' => __( 'Email Address (or mailto: link)', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    // Values Title
    $wp_customize->add_setting( 'navid_about_values_title', array( 'default' => 'What We Believe', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_about_values_title', array( 'label' => __( 'Values Title', 'navid' ), 'section' => 'navid_about_section', 'type' => 'text' ) );

    // Values
    for ( $i = 1; $i <= 4; $i++ ) {
        $default_titles = array( 1 => 'Quality First', 2 => 'Community', 3 => 'Sustainability', 4 => 'Pure Joy' );
        $default_descs = array(
            1 => 'Every story is crafted by experts and industry veterans.',
            2 => 'We’re building a community of passionate thinkers.',
            3 => 'Eco-friendly packaging and ethical sourcing, always.',
            4 => 'Because great ideas bring out the best in all of us.'
        );

        $wp_customize->add_setting( 'navid_about_val' . $i . '_title', array( 'default' => $default_titles[$i], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'navid_about_val' . $i . '_title', array( 'label' => sprintf( __( 'Value %d Title', 'navid' ), $i ), 'section' => 'navid_about_section', 'type' => 'text' ) );

        $wp_customize->add_setting( 'navid_about_val' . $i . '_desc', array( 'default' => $default_descs[$i], 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( 'navid_about_val' . $i . '_desc', array( 'label' => sprintf( __( 'Value %d Description', 'navid' ), $i ), 'section' => 'navid_about_section', 'type' => 'text' ) );
    }

    // ── Selective Refresh Partials (Edit Shortcuts) ─────────
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'navid_about_stat1_num', array(
            'selector'        => '.about-stats',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_about_show_social', array(
            'selector'        => '.about-socials-large',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_topbar_show', array(
            'selector'        => '.top-bar',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_topbar_text', array(
            'selector'        => '.top-bar-tagline',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_show', array(
            'selector' => '.hero-section, .hero-split, .hero-newspaper-wrapper',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_source', array(
            'selector' => '.hero-section, .hero-split, .hero-newspaper-wrapper',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_image', array(
            'selector' => '.hero-bg',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_title', array(
            'selector' => '.hero-title',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_excerpt', array(
            'selector' => '.hero-excerpt',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_btn_text', array(
            'selector' => '.hero-cta',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_editor_picks_show', array(
            'selector' => '.hero-sidebar-col',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_editor_picks_title', array(
            'selector' => '.hero-sidebar-title',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_editor_picks_source', array(
            'selector' => '.hero-news-grid-stack, .hero-sidebar-col',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_latest_stories_title', array(
            'selector' => '.latest-stories-title',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_hero_layout', array(
            'selector' => '.hero-section, .hero-split, .hero-newspaper-wrapper',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_pro_hero_side_padding', array(
            'selector' => '.hero-section',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_hero_title_2', array(
            'selector' => '.hero-split-title',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_marquee_show', array(
            'selector' => '#marquee-wrapper',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_newsletter_heading', array(
            'selector' => '.newsletter-text h3',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_newsletter_desc', array(
            'selector' => '.newsletter-text p',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_quote_text', array(
            'selector' => '.interlude-quote',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_quote_author', array(
            'selector' => '.interlude-attr',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_header_style', array(
            'selector' => '.site-header',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'custom_logo', array(
            'selector' => '.logo',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_logo_height', array(
            'selector' => '.logo',
            'render_callback' => '__return_false',
        ) );
        
        // Template Shortcuts
        $wp_customize->selective_refresh->add_partial( 'navid_about_hero_title', array(
            'selector' => '.about-hero h1',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_about_values_title', array(
            'selector' => '.about-values .section-bar h2',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_contact_email', array(
            'selector' => '.contact-details-blocks',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_footer_show_logo', array(
            'selector' => '.footer-inner',
            'render_callback' => '__return_false',
        ) );
        $wp_customize->selective_refresh->add_partial( 'navid_footer_copyright', array(
            'selector' => '.footer-copy',
            'render_callback' => '__return_false',
        ) );
    }

    // ── Contact Page Section ────────────────────────────────
    $wp_customize->add_section( 'navid_contact_section', array(
        'title'    => __( 'Contact Page Settings', 'navid' ),
        'panel'    => 'navid_templates_panel',
        'priority' => 46,
    ) );

    // Email Settings
    $wp_customize->add_setting( 'navid_contact_show_email', array( 'default' => true, 'sanitize_callback' => 'navid_sanitize_checkbox' ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_contact_show_email', array( 'label' => __( 'Show Email Section', 'navid' ), 'section' => 'navid_contact_section' ) ) );

    $wp_customize->add_setting( 'navid_contact_email', array( 'default' => 'hello@example.com', 'sanitize_callback' => 'sanitize_email' ) );
    $wp_customize->add_control( 'navid_contact_email', array( 'label' => __( 'Contact Email', 'navid' ), 'section' => 'navid_contact_section', 'type' => 'email' ) );

    // Social Links Settings
    $wp_customize->add_setting( 'navid_contact_show_social', array( 'default' => true, 'sanitize_callback' => 'navid_sanitize_checkbox' ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_contact_show_social', array( 'label' => __( 'Show Social Media Section', 'navid' ), 'section' => 'navid_contact_section' ) ) );

    $wp_customize->add_setting( 'navid_contact_social_ig', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_contact_social_ig', array( 'label' => __( 'Instagram URL', 'navid' ), 'section' => 'navid_contact_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'navid_contact_social_tw', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_contact_social_tw', array( 'label' => __( 'Twitter/X URL', 'navid' ), 'section' => 'navid_contact_section', 'type' => 'url' ) );

    $wp_customize->add_setting( 'navid_contact_social_pi', array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'navid_contact_social_pi', array( 'label' => __( 'Pinterest URL', 'navid' ), 'section' => 'navid_contact_section', 'type' => 'url' ) );

    // ── Newsletter Section ──────────────────────────────────
    $wp_customize->add_section( 'navid_newsletter_section', array(
        'title'    => __( 'Newsletter CTA', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 47,
    ) );

    $wp_customize->add_setting( 'navid_newsletter_heading', array( 'default' => 'Stories worth<br><em>reading and sharing</em> with the world.', 'sanitize_callback' => 'wp_kses_post' ) );
    $wp_customize->add_control( 'navid_newsletter_heading', array( 'label' => __( 'Heading', 'navid' ), 'section' => 'navid_newsletter_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'navid_newsletter_desc', array( 'default' => 'Weekly essays, guides, and a healthy dose of inspiration. Join 12,000+ readers.', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_newsletter_desc', array( 'label' => __( 'Description', 'navid' ), 'section' => 'navid_newsletter_section', 'type' => 'text' ) );

    $wp_customize->add_setting( 'navid_newsletter_action', array( 'default' => '#', 'sanitize_callback' => 'navid_sanitize_newsletter_action' ) );
    $wp_customize->add_control( 'navid_newsletter_action', array( 
        'label' => __( 'Form Action URL or Shortcode', 'navid' ), 
        'section' => 'navid_newsletter_section', 
        'type' => 'textarea', 
    ) );
    
    $wp_customize->add_setting( 'navid_newsletter_help', array( 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( new Navid_Message_Control( $wp_customize, 'navid_newsletter_help', array(
        'label'       => '',
        'description' => __( '<strong>How to connect your newsletter:</strong><br>1. Paste your exact Mailchimp Action URL.<br>2. Paste a plugin shortcode (e.g. <code>[mc4wp_form]</code>).<br>3. Or simply paste a full Mailchimp Embedded Form HTML block and we will instantly extract the URL for you.', 'navid' ),
        'section'     => 'navid_newsletter_section',
    ) ) );
    
    if ( class_exists( 'Navid_Customize_Upsell_Control' ) && ! defined( 'NAVID_PRO_VERSION' ) ) {
        $wp_customize->add_setting( 'navid_newsletter_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_newsletter_upsell', array(
            'label'       => __( 'Want Native AJAX Integration?', 'navid' ),
            'description' => __( 'Tired of messy shortcodes and bulky plugins? Unlock ultra-fast, native AJAX Mailchimp integration built directly into the theme with Navid Pro.', 'navid' ),
            'section'     => 'navid_newsletter_section',
            'upsell_text' => __( 'Upgrade to Navid Pro &rarr;', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/navid-pro/',
        ) ) );
    }




    // ═══ TYPOGRAPHY PANEL ═══════════════════════════
    $wp_customize->add_section( 'navid_typography_section', array(
        'title'       => __( 'Typography Options', 'navid' ),
        'panel'       => 'navid_global_panel',
        'priority'    => 28,
    ) );

    if ( ! navid_is_pro_active() ) {
        $wp_customize->add_setting( 'navid_typography_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_typography_upsell', array(
            'label'       => __( 'Want Custom Google Fonts & Global Buttons?', 'navid' ),
            'section'     => 'navid_typography_section',
            'upsell_text' => __( 'Unlock Google Fonts & Global Buttons in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 1,
        ) ) );
    }

    // Heading Font Family
    $wp_customize->add_setting( 'navid_heading_font', array(
        'default'           => 'Playfair Display',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( 'navid_heading_font', array(
        'label'   => __( 'Heading Font Family', 'navid' ),
        'section' => 'navid_typography_section',
        'type'    => 'select',
        'choices' => array(
            'Playfair Display' => 'Playfair Display',
            'Georgia'          => 'Georgia',
            'Lora'             => 'Lora',
            'Merriweather'     => 'Merriweather',
            'Libre Baskerville' => 'Libre Baskerville',
            'Cormorant Garamond' => 'Cormorant Garamond',
            'DM Serif Display' => 'DM Serif Display',
            'Noto Serif'       => 'Noto Serif',
            'Source Serif Pro'  => 'Source Serif Pro',
            'System / Uploaded Font' => 'System / Uploaded Font',
        ),
    ) );

    $wp_customize->add_setting( 'navid_custom_heading_font', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_custom_heading_font', array(
        'label'       => __( 'Custom Heading Font Name', 'navid' ),
        'description' => __( 'If using a custom uploaded font, type its exact family name here.', 'navid' ),
        'section'     => 'navid_typography_section',
        'type'        => 'text',
    ) );

    // Body Font Family
    $wp_customize->add_setting( 'navid_body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( 'navid_body_font', array(
        'label'   => __( 'Body Font Family', 'navid' ),
        'section' => 'navid_typography_section',
        'type'    => 'select',
        'choices' => array(
            'Inter'       => 'Inter',
            'Georgia'     => 'Georgia',
            'Roboto'      => 'Roboto',
            'Open Sans'   => 'Open Sans',
            'Nunito Sans' => 'Nunito Sans',
            'Work Sans'   => 'Work Sans',
            'DM Sans'     => 'DM Sans',
            'Outfit'      => 'Outfit',
            'Plus Jakarta Sans' => 'Plus Jakarta Sans',
            'System / Uploaded Font' => 'System / Uploaded Font',
        ),
    ) );

    $wp_customize->add_setting( 'navid_custom_body_font', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_custom_body_font', array(
        'label'       => __( 'Custom Body Font Name', 'navid' ),
        'description' => __( 'If using a custom uploaded font, type its exact family name here.', 'navid' ),
        'section'     => 'navid_typography_section',
        'type'        => 'text',
    ) );

    // Heading Font Size Scale
    $wp_customize->add_setting( 'navid_heading_scale', array(
        'default'           => 100,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_heading_scale', array(
        'label'       => __( 'Heading Font Size (%)', 'navid' ),
        'description' => __( 'Scale all headings proportionally. 100% = default.', 'navid' ),
        'section'     => 'navid_typography_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 80,
            'max'  => 130,
            'step' => 5,
        ),
    ) );

    // Body Font Size
    $wp_customize->add_setting( 'navid_body_font_size', array(
        'default'           => 16,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_body_font_size', array(
        'label'       => __( 'Body Font Size (px)', 'navid' ),
        'section'     => 'navid_typography_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 14,
            'max'  => 20,
            'step' => 1,
        ),
    ) );

    // Drop Cap
    $wp_customize->add_setting( 'navid_enable_dropcap', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_enable_dropcap', array(
        'label'       => __( 'Enable Drop Cap', 'navid' ),
        'description' => __( 'Shows a large stylized first letter on single posts and about pages.', 'navid' ),
        'section'     => 'navid_typography_section',
    ) ) );

    // ═══ HERO ADDITIONS ════════════════════════════
    // Overlay Opacity
    // Overlay Style
    $wp_customize->add_setting( 'navid_hero_overlay_style', array(
        'default'           => 'full',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( new Navid_Buttonset_Control( $wp_customize, 'navid_hero_overlay_style', array(
        'label'   => __( 'Overlay Style', 'navid' ),
        'section' => 'navid_hero_section',
        'choices' => array(
            'cinematic' => '<svg viewBox="0 0 24 24"><path d="M12 2v4c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm3.17 3.54c-.39-.39-1.02-.39-1.41 0s-.39 1.02 0 1.41l2.83 2.83c.39.39 1.02.39 1.41 0s.39-1.02 0-1.41l-2.83-2.83zM22 11h-4c-.55 0-1 .45-1 1s.45 1 1 1h4c.55 0 1-.45 1-1s-.45-1-1-1zm-3.54 3.17c-.39-.39-1.02-.39-1.41 0l-2.83 2.83c-.39.39-.39 1.02 0 1.41s1.02.39 1.41 0l2.83-2.83c.39-.39.39-1.02 0-1.41zM12 22v-4c0-.55.45-1 1-1s1 .45 1 1v4c0 .55-.45 1-1 1s-1-.45-1-1zm-3.17-3.54c.39.39 1.02.39 1.41 0s.39-1.02 0-1.41l-2.83-2.83c-.39-.39-1.02-.39-1.41 0s-.39 1.02 0 1.41l2.83 2.83zM2 13h4c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm3.54-3.17c.39.39 1.02.39 1.41 0l2.83-2.83c.39-.39.39-1.02 0-1.41s-1.02-.39-1.41 0L3.54 8.41c-.39.39-.39 1.02 0 1.41zM12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4z"/></svg> Auto',
            'full'      => '<svg viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" fill="currentColor"/></svg> Full',
            'bottom'    => '<svg viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><rect width="18" height="9" x="3" y="12" fill="currentColor"/></svg> Bottom',
            'top'       => '<svg viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="3" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><rect width="18" height="9" x="3" y="3" fill="currentColor"/></svg> Top',
        ),
    ) ) );

    $wp_customize->add_setting( 'navid_hero_overlay_opacity', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_hero_overlay_opacity', array(
        'label'       => __( 'Hero Overlay Darkness (%)', 'navid' ),
        'description' => __( 'Adjust the dark overlay on the hero image. Higher = darker.', 'navid' ),
        'section'     => 'navid_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 30,
            'max'  => 100,
            'step' => 5,
        ),
    ) );

    // Hero Min Height
    $wp_customize->add_setting( 'navid_hero_height', array(
        'default'           => 78,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_hero_height', array(
        'label'       => __( 'Hero Min Height (vh)', 'navid' ),
        'description' => __( 'Minimum height as a percentage of viewport height.', 'navid' ),
        'section'     => 'navid_hero_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 50,
            'max'  => 100,
            'step' => 2,
        ),
    ) );

    // ═══ GENERAL / LAYOUT PANEL ═══════════════════
    $wp_customize->add_section( 'navid_general_section', array(
        'title'    => __( 'General Settings', 'navid' ),
        'panel'    => 'navid_global_panel',
        'priority' => 25,
    ) );

    // Layout Density
    $wp_customize->add_setting( 'navid_layout_density', array(
        'default'           => 'standard',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( 'navid_layout_density', array(
        'label'   => __( 'Layout Density (Section Spacing)', 'navid' ),
        'section' => 'navid_layout_section',
        'type'    => 'select',
        'choices' => array(
            'compact'  => __( 'Compact', 'navid' ),
            'standard' => __( 'Standard', 'navid' ),
            'relaxed'  => __( 'Relaxed', 'navid' ),
            'custom'   => __( 'Custom (Pro)', 'navid' ),
        ),
        'priority' => 5,
    ) );

    if ( class_exists( 'Navid_Customize_Upsell_Control' ) && ! defined( 'NAVID_PRO_VERSION' ) ) {
        $wp_customize->add_setting( 'navid_layout_density_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_layout_density_upsell', array(
            'label'       => __( 'Pro Feature', 'navid' ),
            'description' => __( 'Unlock exact custom spacing and scale control with Navid Pro.', 'navid' ),
            'upsell_text' => __( 'Upgrade to Navid Pro &rarr;', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/',
            'section'     => 'navid_layout_section',
            'priority'    => 6,
            'active_callback' => function( $control ) {
                $s = $control->manager->get_setting( 'navid_layout_density' );
                return $s ? $s->value() === 'custom' : false;
            }
        ) ) );
    }

    // 🟩🟩🟩 FOOTER SETTINGS 🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩
    $wp_customize->add_section( 'navid_footer_section', array(
        'title'    => __( 'Footer Settings', 'navid' ),
        'priority' => 22.5,
    ) );

    // Footer Show Logo
    $wp_customize->add_setting( 'navid_footer_show_logo', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'navid_footer_show_logo', array(
        'label'   => __( 'Show Footer Logo / Site Title', 'navid' ),
        'section' => 'navid_footer_section',
        'type'    => 'checkbox',
    ) );

    // Footer Copyright
    $wp_customize->add_setting( 'navid_footer_copyright', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'navid_footer_copyright', array(
        'label'       => __( 'Footer Copyright Text', 'navid' ),
        'description' => __( 'Leave empty for default: © {year} {site name}', 'navid' ),
        'section'     => 'navid_footer_section',
        'type'        => 'text',
    ) );

    // Footer Columns
    $wp_customize->add_setting( 'navid_footer_columns', array(
        'default'           => '4',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( 'navid_footer_columns', array(
        'label'   => __( 'Footer Widget Columns', 'navid' ),
        'section' => 'navid_footer_section',
        'type'    => 'select',
        'choices' => array(
            '1' => __( '1 Column (Centered / Full)', 'navid' ),
            '2' => __( '2 Columns', 'navid' ),
            '3' => __( '3 Columns', 'navid' ),
            '4' => __( '4 Columns', 'navid' ),
        ),
    ) );

    // Footer Width
    $wp_customize->add_setting( 'navid_footer_width', array(
        'default'           => 'full',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_footer_width', array(
        'label'       => __( 'Footer Width', 'navid' ),
        'section'     => 'navid_footer_section',
        'type'        => 'radio',
        'choices'     => array(
            'full'      => __( 'Full Width', 'navid' ),
            'contained' => __( 'Contained', 'navid' ),
        ),
    ) );

    // Footer Upsell
    if ( ! class_exists( 'WPMatcha\\Pro\\Themes\\Navid\\Module' ) ) {
        $wp_customize->add_setting( 'navid_footer_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_footer_upsell', array(
            'label'       => __( 'Want a Mega Footer?', 'navid' ),
            'section'     => 'navid_footer_section',
            'upsell_text' => __( 'Unlock the advanced Mega Footer layout in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 99,
        ) ) );
    }

    // Preloader Toggle
    $wp_customize->add_setting( 'navid_enable_preloader', array(
        'default'           => false,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_enable_preloader', array(
        'label'   => __( 'Enable Page Preloader', 'navid' ),
        'section' => 'navid_general_section',
    ) ) );

    // Scroll Progress Toggle
    $wp_customize->add_setting( 'navid_show_scroll_progress', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_show_scroll_progress', array(
        'label'   => __( 'Show Reading Progress Bar', 'navid' ),
        'section' => 'navid_general_section',
    ) ) );

    // ═══ HEADER PANEL ═════════════════════════════
    $wp_customize->add_section( 'navid_header_section', array(
        'title'    => __( 'Header Settings', 'navid' ),
        'panel'    => 'navid_header_footer_panel',
        'priority' => 29,
    ) );

    // Header layout setting available in Navid Pro
    if ( ! navid_pro_is_active() ) {
        $wp_customize->add_setting( 'navid_header_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_header_upsell', array(
            'label'       => __( 'Need Centered or Stacked headers?', 'navid' ),
            'section'     => 'navid_header_section',
            'upsell_text' => __( 'Unlock Centered & Stacked Headers in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 5,
        ) ) );
    }

    // Header Width
    $wp_customize->add_setting( 'navid_header_width', array(
        'default'           => 'full',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_header_width', array(
        'label'       => __( 'Header Width', 'navid' ),
        'section'     => 'navid_header_section',
        'type'        => 'radio',
        'choices'     => array(
            'full'      => __( 'Full Width', 'navid' ),
            'contained' => __( 'Contained', 'navid' ),
        ),
        'priority'    => 6,
    ) );

    // Sticky Header
    $wp_customize->add_setting( 'navid_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'navid_sticky_header', array(
        'label'   => __( 'Enable Sticky Header', 'navid' ),
        'section' => 'navid_header_section',
        'type'    => 'checkbox',
    ) );

    // Header Style — Transparent vs Solid (available in both free & Pro)
    $wp_customize->add_setting( 'navid_header_style', array(
        'default'           => 'transparent',
        'sanitize_callback' => 'sanitize_key',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( 'navid_header_style', array(
        'label'       => __( 'Header Style (Homepage)', 'navid' ),
        'description' => __( 'Transparent overlays the header on the hero image. Solid always shows the header background. Applies to the homepage only.', 'navid' ),
        'section'     => 'navid_header_section',
        'type'        => 'radio',
        'choices'     => array(
            'transparent' => __( 'Transparent (overlays hero)', 'navid' ),
            'solid'       => __( 'Solid (always visible)', 'navid' ),
        ),
    ) );


    $wp_customize->add_setting( 'navid_logo_height', array(
        'default'           => 50,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ) );
    $wp_customize->add_control( 'navid_logo_height', array(
        'label'       => __( 'Logo Max Height (px)', 'navid' ),
        'section'     => 'navid_header_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 16,
            'max'  => 120,
            'step' => 2,
        ),
    ) );

    // Hide/Show Theme Mode Icon
    $wp_customize->add_setting( 'navid_header_show_dark_mode', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_header_show_dark_mode', array(
        'label'   => __( 'Show Theme Mode (Dark/Light) Icon', 'navid' ),
        'section' => 'navid_header_section',
    ) ) );

    // Hide/Show Search Icon
    $wp_customize->add_setting( 'navid_header_show_search', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_header_show_search', array(
        'label'   => __( 'Show Search Icon', 'navid' ),
        'section' => 'navid_header_section',
    ) ) );

    // Subscribe Button Settings
    $wp_customize->add_setting( 'navid_header_subscribe_text', array(
        'default'           => __( 'Subscribe', 'navid' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_header_subscribe_text', array(
        'label'   => __( 'Subscribe Button Text', 'navid' ),
        'section' => 'navid_header_section',
        'type'    => 'text',
    ) );
    $wp_customize->add_setting( 'navid_header_subscribe_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'navid_header_subscribe_url', array(
        'label'       => __( 'Subscribe Button URL', 'navid' ),
        'description' => __( 'Leave empty to hide the button.', 'navid' ),
        'section'     => 'navid_header_section',
        'type'        => 'url',
    ) );
    
    $wp_customize->add_setting( 'navid_header_subscribe_target', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'navid_header_subscribe_target', array(
        'label'       => __( 'Open link in a new tab', 'navid' ),
        'section'     => 'navid_header_section',
        'type'        => 'checkbox',
    ) );

    // ═══ BLOG / ARCHIVE PANEL ═════════════════════
    $wp_customize->add_section( 'navid_blog_section', array(
        'title'    => __( 'Blog Settings', 'navid' ),
        'panel'    => 'navid_templates_panel',
        'priority' => 35,
    ) );

    // Excerpt Length
    $wp_customize->add_setting( 'navid_excerpt_length', array(
        'default'           => 25,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_excerpt_length', array(
        'label'       => __( 'Excerpt Length (words)', 'navid' ),
        'section'     => 'navid_blog_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 50,
            'step' => 5,
        ),
    ) );

    // Grid Columns
    $wp_customize->add_setting( 'navid_grid_columns', array(
        'default'           => '3',
        'sanitize_callback' => 'navid_sanitize_select',
    ) );
    $wp_customize->add_control( 'navid_grid_columns', array(
        'label'   => __( 'Blog Grid Columns', 'navid' ),
        'section' => 'navid_blog_section',
        'type'    => 'select',
        'choices' => array(
            '2' => __( '2 Columns', 'navid' ),
            '3' => __( '3 Columns', 'navid' ),
        ),
    ) );

    // ═══ SINGLE POST PANEL ═════════════════════
    $wp_customize->add_section( 'navid_single_section', array(
        'title'    => __( 'Single Post Settings', 'navid' ),
        'panel'    => 'navid_templates_panel',
        'priority' => 36,
    ) );

    // Single Post Content Width
    $wp_customize->add_setting( 'navid_single_content_width', array(
        'default'           => 800,
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'navid_single_content_width', array(
        'label'       => __( 'Content Max Width (px)', 'navid' ),
        'description' => __( 'Narrower widths (700-800px) improve readability.', 'navid' ),
        'section'     => 'navid_single_section',
        'type'        => 'range',
        'input_attrs' => array(
            'min'  => 500,
            'max'  => 1200,
            'step' => 10,
        ),
    ) );

    // Dummy settings for Edit Shortcuts (Pencil Icons)
    $wp_customize->add_setting( 'navid_blog_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_blog_shortcut', array( 'type' => 'hidden', 'section' => 'navid_blog_section' ) );

    // Blog Upsell
    if ( ! class_exists( 'WPMatcha\\Pro\\Themes\\Navid\\Module' ) ) {
        $wp_customize->add_setting( 'navid_blog_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_blog_upsell', array(
            'label'       => __( 'Need Advanced Feed Layouts?', 'navid' ),
            'section'     => 'navid_blog_section',
            'upsell_text' => __( 'Unlock Auto-Load Next Post, Bento Box Feeds & Share Bar in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 99,
        ) ) );
    }

    $wp_customize->add_setting( 'navid_single_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_single_shortcut', array( 'type' => 'hidden', 'section' => 'navid_single_section' ) );

    $wp_customize->add_setting( 'navid_hero_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_hero_shortcut', array( 'type' => 'hidden', 'section' => 'navid_hero_section' ) );

    // Move default WordPress sections to the bottom
    if ( $wp_customize->get_section( 'title_tagline' ) ) {
        $wp_customize->get_section( 'title_tagline' )->priority = 100;
    }
    if ( $wp_customize->get_section( 'header_image' ) ) {
        $wp_customize->get_section( 'header_image' )->priority = 101;
    }
    if ( $wp_customize->get_section( 'background_image' ) ) {
        $wp_customize->get_section( 'background_image' )->priority = 102;
    }
    if ( $wp_customize->get_panel( 'nav_menus' ) ) {
        $wp_customize->get_panel( 'nav_menus' )->priority = 103;
    }
    if ( $wp_customize->get_panel( 'widgets' ) ) {
        $wp_customize->get_panel( 'widgets' )->priority = 104;
    }
    if ( $wp_customize->get_section( 'static_front_page' ) ) {
        $wp_customize->get_section( 'static_front_page' )->priority = 105;
    }
    if ( $wp_customize->get_section( 'custom_css' ) ) {
        $wp_customize->get_section( 'custom_css' )->priority = 106;
    }

    $wp_customize->add_setting( 'navid_home_categories_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_home_categories_shortcut', array( 'type' => 'hidden', 'section' => 'navid_home_categories_section' ) );

    $wp_customize->add_setting( 'navid_featured_grid_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_featured_grid_shortcut', array( 'type' => 'hidden', 'section' => 'navid_featured_grid_section' ) );

    $wp_customize->add_setting( 'navid_masonry_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_masonry_shortcut', array( 'type' => 'hidden', 'section' => 'navid_masonry_section' ) );

    $wp_customize->add_setting( 'navid_marquee_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_marquee_shortcut', array( 'type' => 'hidden', 'section' => 'navid_marquee_section' ) );

    $wp_customize->add_setting( 'navid_quote_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_quote_shortcut', array( 'type' => 'hidden', 'section' => 'navid_interlude_section' ) );

    $wp_customize->add_setting( 'navid_newsletter_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_newsletter_shortcut', array( 'type' => 'hidden', 'section' => 'navid_newsletter_section' ) );

    $wp_customize->add_setting( 'navid_footer_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_footer_shortcut', array( 'type' => 'hidden', 'section' => 'navid_footer_section' ) );

    $wp_customize->add_setting( 'navid_social_proof_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_social_proof_shortcut', array( 'type' => 'hidden', 'section' => 'navid_social_proof_section' ) );

    $wp_customize->add_setting( 'navid_services_shortcut', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'navid_services_shortcut', array( 'type' => 'hidden', 'section' => 'navid_about_section' ) );

    // ── Selective Refresh ─────────────────────────────────────────
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'navid_home_categories_title', array(
            'selector'        => '.category-section-title',
            'render_callback' => function() {
                return esc_html( get_theme_mod( 'navid_home_categories_title', __( 'Trending Topics', 'navid' ) ) );
            },
        ) );
        
        // Blog Archive Shortcut
        $wp_customize->selective_refresh->add_partial( 'navid_blog_shortcut', array(
            'selector'        => '.archive-header',
            'render_callback' => '__return_false',
        ) );

        // Single Post Shortcut
        $wp_customize->selective_refresh->add_partial( 'navid_single_shortcut', array(
            'selector'        => '.single-title',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_hero_shortcut', array(
            'selector'        => '.hero-section',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_home_categories_shortcut', array(
            'selector'        => '.category-bar-wrapper',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_featured_grid_shortcut', array(
            'selector'        => '.featured-grid-section',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_masonry_shortcut', array(
            'selector'        => '.posts-grid-section',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_marquee_shortcut', array(
            'selector'        => '.marquee-strip',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_quote_shortcut', array(
            'selector'        => '.interlude',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_newsletter_shortcut', array(
            'selector'        => '.newsletter-cta',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_footer_shortcut', array(
            'selector'        => '.site-footer',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_social_proof_shortcut', array(
            'selector'        => '.navid-social-proof-bar',
            'render_callback' => '__return_false',
        ) );

        $wp_customize->selective_refresh->add_partial( 'navid_services_shortcut', array(
            'selector'        => '.navid-home-services',
            'render_callback' => '__return_false',
        ) );
    }

    // --- CUSTOM CTA / SPLIT SECTION (FREEMIUM BASE) ---
    $wp_customize->add_section( 'navid_custom_banner_section', array(
        'title'    => __( 'Custom CTA / Split Section', 'navid' ),
        'panel'    => 'navid_homepage_panel',
        'priority' => 32, // Fit it naturally in the homepage panel
    ) );

    $wp_customize->add_setting( 'navid_custom_banner_layout', array(
        'default'           => 'split_left',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_layout', array(
        'label'   => __( 'Layout Style', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'select',
        'choices' => array(
            'split_left'  => __( 'Split Screen (Image Left)', 'navid' ),
            'split_right' => __( 'Split Screen (Image Right)', 'navid' ),
            'grid_3'      => __( '3-Column Grid (Pro Only)', 'navid' ),
            'overlay'     => __( 'Full-Width Overlay (Pro Only)', 'navid' ),
        ),
        'priority' => 1,
    ) );

    if ( ! navid_pro_is_active() ) {
        $wp_customize->add_setting( 'navid_hero_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_hero_upsell', array(
            'section'     => 'navid_hero_section',
            'upsell_text' => __( 'Unlock Hero Alignment & Extra Layouts in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 1,
        ) ) );

        $wp_customize->add_setting( 'navid_custom_banner_upsell', array( 'sanitize_callback' => 'sanitize_text_field' ) );
        $wp_customize->add_control( new Navid_Customize_Upsell_Control( $wp_customize, 'navid_custom_banner_upsell', array(
            'section'     => 'navid_custom_banner_section',
            'upsell_text' => __( 'Unlock 3-Column Grid & Full-Width Overlay Layouts in Pro', 'navid' ),
            'upsell_url'  => 'https://wpmatcha.com/wordpress-themes/navid/',
            'priority'    => 2,
        ) ) );
    }

    $wp_customize->add_setting( 'navid_custom_banner_section_title', array(
        'default'           => 'Featured',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_section_title', array(
        'label'       => __( 'Section Heading', 'navid' ),
        'description' => __( 'Optional top-level heading (like "Trending Topics")', 'navid' ),
        'section'     => 'navid_custom_banner_section',
        'type'        => 'text',
    ) );

    // Add selective refresh for the section title so the customizer pencil icon appears
    if ( isset( $wp_customize->selective_refresh ) ) {
        $wp_customize->selective_refresh->add_partial( 'navid_custom_banner_section_title', array(
            'selector'            => '.navid-custom-cta .section-bar',
            'container_inclusive' => false,
            'render_callback'     => function() {
                $title = get_theme_mod( 'navid_custom_banner_section_title', 'Featured' );
                return ! empty( $title ) ? '<h2>' . esc_html( $title ) . '</h2>' : '';
            },
        ) );
    }

    $wp_customize->add_setting( 'navid_custom_banner_bg_color', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'navid_custom_banner_bg_color', array(
        'label'       => __( 'Section Background Color', 'navid' ),
        'description' => __( 'Leave blank to use theme default transparent background.', 'navid' ),
        'section'     => 'navid_custom_banner_section',
        'priority' => 2,
    ) ) );

    // --- COLUMN 1 (Main) ---
    $wp_customize->add_setting( 'navid_custom_banner_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'navid_custom_banner_image', array(
        'label'    => __( 'Col 1: Background / Split Image', 'navid' ),
        'section'  => 'navid_custom_banner_section',
        'priority' => 10,
    ) ) );

    $wp_customize->add_setting( 'navid_custom_banner_title', array(
        'default'           => 'Important Disclosure',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_title', array(
        'label'   => __( 'Col 1: Title', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'text',
        'priority' => 11,
    ) );

    $wp_customize->add_setting( 'navid_custom_banner_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_text', array(
        'label'   => __( 'Col 1: Text Content / Hover Description', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'textarea',
        'priority' => 12,
    ) );

    $wp_customize->add_setting( 'navid_custom_banner_btn_text', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_btn_text', array(
        'label'   => __( 'Col 1: Button Text', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'text',
        'priority' => 13,
    ) );

    $wp_customize->add_setting( 'navid_custom_banner_btn_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_btn_url', array(
        'label'   => __( 'Col 1: Button URL', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'url',
        'priority' => 14,
    ) );

    $wp_customize->add_setting( 'navid_custom_banner_btn_target', array(
        'default'           => '_blank',
        'sanitize_callback' => 'sanitize_key',
    ) );
    $wp_customize->add_control( 'navid_custom_banner_btn_target', array(
        'label'   => __( 'Col 1: Button Link Target', 'navid' ),
        'section' => 'navid_custom_banner_section',
        'type'    => 'select',
        'choices' => array(
            '_blank' => __( 'New Tab', 'navid' ),
            '_self'  => __( 'Same Tab', 'navid' ),
        ),
        'priority' => 15,
    ) );

    // ==========================================
    // 7. SHORTCODE / AD BLOCK SECTION
    // ==========================================
    $wp_customize->add_section( 'navid_shortcode_section', array(
        'title'    => __( 'Shortcode / Ad Block', 'navid' ),
        'priority' => 38,
        'panel'    => 'navid_homepage_panel',
    ) );

    $wp_customize->add_setting( 'navid_homepage_shortcode_show', array(
        'default'           => true,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'navid_homepage_shortcode_show', array(
        'label'       => __( 'Show Shortcode Section?', 'navid' ),
        'section'     => 'navid_shortcode_section',
        'type'        => 'checkbox',
        'priority'    => 5,
    ) );

    $wp_customize->add_setting( 'navid_homepage_shortcode', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'navid_homepage_shortcode', array(
        'label'       => __( 'Custom Shortcode', 'navid' ),
        'description' => __( 'Paste any shortcode here (e.g., [matcha_ad id="1"] or a Mailchimp form). It will render on the homepage.', 'navid' ),
        'section'     => 'navid_shortcode_section',
        'type'        => 'text',
        'priority'    => 10,
    ) );

    $wp_customize->add_setting( 'navid_homepage_shortcode_fullwidth', array(
        'default'           => false,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( 'navid_homepage_shortcode_fullwidth', array(
        'label'       => __( 'Make Full Width?', 'navid' ),
        'description' => __( 'Check this if your shortcode provides its own container and needs to span edge-to-edge.', 'navid' ),
        'section'     => 'navid_shortcode_section',
        'type'        => 'checkbox',
        'priority'    => 20,
    ) );

    // ==========================================
    // 8. SOCIAL PROOF / BRAND LOGOS
    // ==========================================
    $wp_customize->add_section( 'navid_social_proof_section', array(
        'title'       => __( 'Social Proof / Brand Logos', 'navid' ),
        'description' => __( 'Upload up to 4 brand logos to display in the Social Proof bar on the homepage. If no logos are uploaded, it automatically falls back to your About Page stat counters.', 'navid' ),
        'priority'    => 39,
        'panel'       => 'navid_homepage_panel',
    ) );

    $wp_customize->add_setting( 'navid_social_proof_show', array(
        'default'           => false,
        'sanitize_callback' => 'navid_sanitize_checkbox',
    ) );
    $wp_customize->add_control( new Navid_Toggle_Control( $wp_customize, 'navid_social_proof_show', array(
        'label'       => __( 'Show Social Proof Bar?', 'navid' ),
        'description' => __( 'Enable to display the Social Proof / Brand Logos bar on your homepage.', 'navid' ),
        'section'     => 'navid_social_proof_section',
        'priority'    => 5,
    ) ) );

    $wp_customize->add_setting( 'navid_social_proof_title', array(
        'default'           => 'Our Partners',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'navid_social_proof_title', array(
        'label'       => __( 'Section Heading', 'navid' ),
        'description' => __( 'Optional top-level heading above the brand logos.', 'navid' ),
        'section'     => 'navid_social_proof_section',
        'type'        => 'text',
        'priority'    => 8,
    ) );

    for ( $i = 1; $i <= 4; $i++ ) {
        $wp_customize->add_setting( 'navid_social_proof_logo_' . $i, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'navid_social_proof_logo_' . $i, array(
            'label'    => sprintf( __( 'Brand Logo %d', 'navid' ), $i ),
            'section'  => 'navid_social_proof_section',
            'priority' => $i * 10,
        ) ) );
    }

}
add_action( 'customize_register', 'navid_customize_register' );

/**
 * Sanitize select/radio inputs
 */
function navid_sanitize_select( $input, $setting ) {
    $input = sanitize_text_field( $input );
    $control = $setting->manager->get_control( $setting->id );
    if ( $control && isset( $control->choices ) && is_array( $control->choices ) ) {
        return ( array_key_exists( $input, $control->choices ) ? $input : $setting->default );
    }
    return $input;
}

/**
 * Dynamic CSS output based on customizer settings
 */
function navid_dynamic_css() {
    $heading_font   = get_theme_mod( 'navid_heading_font', 'Playfair Display' );
    $body_font      = get_theme_mod( 'navid_body_font', 'Inter' );
    $custom_heading = get_theme_mod( 'navid_custom_heading_font', '' );
    $custom_body    = get_theme_mod( 'navid_custom_body_font', '' );
    
    $heading_scale  = get_theme_mod( 'navid_heading_scale', 100 );
    $body_font_size = get_theme_mod( 'navid_body_font_size', 16 );
    $content_width  = get_theme_mod( 'navid_content_width', 1280 );
    $hero_opacity   = get_theme_mod( 'navid_hero_overlay_opacity', 85 );
    $hero_height    = get_theme_mod( 'navid_hero_height', 78 );
    $logo_height    = get_theme_mod( 'navid_logo_height', 50 );
    $sticky_header  = get_theme_mod( 'navid_sticky_header', true );

    $scale_factor = $heading_scale / 100;
    $hero_opacity_dec = $hero_opacity / 100;
    $hero_overlay_style = get_theme_mod( 'navid_hero_overlay_style', 'cinematic' );

    $css = ':root {';
    
    // Heading Font
    if ( 'System / Uploaded Font' === $heading_font ) {
        if ( ! empty( $custom_heading ) ) {
            $css .= '--font-serif: "' . esc_attr( $custom_heading ) . '", serif;';
        }
    } else {
        $css .= '--font-serif: "' . esc_attr( $heading_font ) . '", serif;';
    }

    // Body Font
    if ( 'System / Uploaded Font' === $body_font ) {
        if ( ! empty( $custom_body ) ) {
            $css .= '--font-sans: "' . esc_attr( $custom_body ) . '", sans-serif;';
        }
    } else {
        $css .= '--font-sans: "' . esc_attr( $body_font ) . '", sans-serif;';
    }

    $css .= '--max-width: ' . absint( $content_width ) . 'px;';
    $css .= '}';

    // Single Post Content Width
    $single_width = get_theme_mod( 'navid_single_content_width', 800 );
    if ( 800 !== $single_width ) {
        $css .= '.single-content { max-width: ' . absint( $single_width ) . 'px !important; margin-left: auto; margin-right: auto; }';
    }

    // Blog Grid Columns
    $grid_cols = get_theme_mod( 'navid_grid_columns', '3' );
    if ( '2' === $grid_cols ) {
        $css .= '@media (min-width: 1024px) { .archive-grid, .bento-grid { grid-template-columns: repeat(2, 1fr) !important; } }';
    } elseif ( '3' === $grid_cols ) {
        $css .= '@media (min-width: 1024px) { .archive-grid, .bento-grid { grid-template-columns: repeat(3, 1fr) !important; } }';
    }

    // Body font size
    if ( 16 !== $body_font_size ) {
        $css .= 'body { font-size: ' . absint( $body_font_size ) . 'px; }';
    }

    // Heading scale
    if ( 100 !== $heading_scale ) {
        $css .= 'h1 { font-size: calc(clamp(28px, 5vw, 48px) * ' . esc_attr( $scale_factor ) . '); }';
        $css .= 'h2 { font-size: calc(clamp(22px, 3.5vw, 36px) * ' . esc_attr( $scale_factor ) . '); }';
        $css .= 'h3 { font-size: calc(clamp(18px, 2.5vw, 28px) * ' . esc_attr( $scale_factor ) . '); }';
        $css .= '.hero-title { font-size: calc(clamp(48px, 6.5vw, 88px) * ' . esc_attr( $scale_factor ) . '); }';
    }

    // Hero overlay
    if ( 'full' === $hero_overlay_style ) {
        $css .= '.hero-bg::after { background: rgba(0, 0, 0, 1) !important; opacity: ' . esc_attr( $hero_opacity_dec ) . ' !important; }';
    } elseif ( 'bottom' === $hero_overlay_style ) {
        $css .= '.hero-bg::after { background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 1) 100%) !important; opacity: ' . esc_attr( $hero_opacity_dec ) . ' !important; }';
    } elseif ( 'top' === $hero_overlay_style ) {
        $css .= '.hero-bg::after { background: linear-gradient(0deg, transparent 0%, rgba(0, 0, 0, 1) 100%) !important; opacity: ' . esc_attr( $hero_opacity_dec ) . ' !important; }';
    } else {
        $css .= '.hero-bg::after { opacity: ' . esc_attr( $hero_opacity_dec ) . ' !important; }';
    }

    // Hero height
    if ( 78 !== $hero_height ) {
        $css .= '.hero-section { min-height: clamp(540px, ' . absint( $hero_height ) . 'vh, 820px); }';
    }

    // Logo height
    $css .= 'img.custom-logo { max-height: ' . absint( $logo_height ) . 'px !important; width: auto !important; height: auto !important; max-width: 100% !important; }';
    $css .= '.site-header .logo { font-size: ' . absint( $logo_height ) . 'px; }';

    // Sticky header
    if ( ! $sticky_header ) {
        $css .= '.site-header { position: relative; }';
    }

    if ( ! empty( $css ) ) {
        wp_add_inline_style( 'navid-style', $css );
    }
}
add_action( 'wp_enqueue_scripts', 'navid_dynamic_css', 20 );

/**
 * Checkbox sanitization callback
 */
function navid_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}


/**
 * Add dropdown toggle buttons to navigation menus.
 */
function navid_nav_menu_dropdown_button( $item_output, $item, $depth, $args ) {
    if ( in_array( 'menu-item-has-children', $item->classes ) ) {
        $button = '<button class="dropdown-toggle" aria-expanded="false" aria-label="' . esc_attr__( 'Toggle drop-down', 'navid' ) . '"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg></button>';
        $item_output = str_replace( '</a>', '</a>' . $button, $item_output );
    }
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'navid_nav_menu_dropdown_button', 10, 4 );

/**
 * Sanitize ad code — allows scripts and iframes for ad networks
 */
function navid_sanitize_ad_code( $input ) {
    return current_user_can( 'unfiltered_html' ) ? $input : wp_kses_post( $input );
}

/**
 * Sanitize newsletter action URL by extracting it from HTML embed code if present.
 */
function navid_sanitize_newsletter_action( $input ) {
    // If it looks like a shortcode, return it sanitized as text (allowing brackets)
    if ( strpos( $input, '[' ) !== false && strpos( $input, ']' ) !== false ) {
        return sanitize_text_field( $input );
    }
    // If it looks like HTML, try to extract the action attribute
    if ( strpos( $input, '<form' ) !== false ) {
        if ( preg_match( '/action=["\']([^"\']+)["\']/i', $input, $matches ) ) {
            return esc_url_raw( $matches[1] );
        }
    }
    // Otherwise, assume it's a direct URL
    return esc_url_raw( $input );
}

/**
 * Customizer UI Styles — Professional controls
 */
function navid_customizer_styles() {
    ?>
    <style>
        /* Separate custom panels from default WordPress panels */
        #accordion-section-title_tagline {
            margin-top: 24px !important;
            border-top: 1px solid #dcdcde !important;
        }

        /* 🎨 NAVID CUSTOMIZER UI 🎨 */
        .customize-control { margin-bottom: 14px; }
        .customize-control-range { position: relative; }
        .customize-control-range input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: #ddd;
            outline: none;
            margin: 10px 0;
        }
        .customize-control-range input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #007cba;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }
        .customize-control-range input[type="range"]::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #007cba;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
        }
        
        /* Section descriptions */
        .customize-section-description {
            font-size: 12px;
            color: #666;
            padding: 12px 16px;
            background: #f9f9f9;
            border-bottom: 1px solid #eee;
            margin: -12px -12px 12px;
        }

        /* Control descriptions */
        .customize-control .description {
            font-style: normal;
            font-size: 11px;
            color: #888;
            margin-top: 4px;
        }

        /* Checkbox group headers */
        .customize-control-checkbox label {
            font-weight: 600;
        }

        /* Textareas */
        .customize-control textarea {
            font-family: monospace;
            font-size: 12px;
            min-height: 80px;
        }

        /* Premium Toggle Switch */
        .customize-control-title {
            margin-bottom: 6px;
            display: block;
        }
        
        .navid-control-wrapper {
            margin-bottom: 24px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e2e4e7;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
        }
        .navid-control-wrapper .customize-control-title {
            font-size: 13px;
            font-weight: 600;
            color: #1d2327;
            margin-bottom: 8px;
            display: block;
        }
        .navid-toggle-switch {
            position: relative;
            display: inline-block;
            width: 36px;
            height: 20px;
        }
        .navid-toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .navid-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e2e4e7;
            transition: .3s;
        }
        .navid-slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            transition: .3s;
        }
        .navid-toggle-switch input:checked + .navid-slider {
            background-color: #1d2327;
        }
        .navid-toggle-switch input:checked + .navid-slider:before {
            transform: translateX(16px);
        }
        .navid-slider.round {
            border-radius: 20px;
        }
        .navid-slider.round:before {
            border-radius: 50%;
        }

        /* Premium Form Inputs (Select, Text, Number) */
        .customize-control select,
        .customize-control input[type="text"],
        .customize-control input[type="number"],
        .customize-control input[type="url"],
        .customize-control textarea {
            width: 100%;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #dcdcde;
            background-color: #fff;
            color: #2c3338;
            font-size: 13px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02) inset;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .customize-control select:focus,
        .customize-control input[type="text"]:focus,
        .customize-control input[type="number"]:focus,
        .customize-control input[type="url"]:focus,
        .customize-control textarea:focus {
            border-color: #2271b1;
            box-shadow: 0 0 0 1px #2271b1;
            outline: none;
        }

        /* Premium Range Slider (If added later) */
        .customize-control input[type="range"] {
            -webkit-appearance: none;
            width: 100%;
            height: 4px;
            border-radius: 2px;
            background: #e2e4e7;
            outline: none;
            margin: 15px 0;
        }
        .customize-control input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #2271b1;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            transition: transform 0.1s;
        }
        /* Premium Radio Image Control */
        .navid-radio-image-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-top: 10px;
        }
        .navid-radio-image-label {
            flex: 1;
            cursor: pointer;
        }
        .navid-radio-image-label input[type="radio"] {
            display: none;
        }
        .navid-radio-image-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px 4px;
            border: 2px solid #e2e4e7;
            border-radius: 6px;
            background: #fff;
            color: #646970;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
            text-align: center;
        }
        .navid-radio-image-btn svg {
            width: 20px;
            height: 20px;
            margin-bottom: 6px;
        }
        .navid-radio-image-label-text {
            font-size: 10px;
            line-height: 1.2;
            font-weight: 500;
        }
        .navid-radio-image-label input[type="radio"]:checked + .navid-radio-image-btn {
            border-color: #2271b1;
            background: #f0f6fc;
            color: #2271b1;
        }
        .navid-radio-image-label:hover .navid-radio-image-btn {
            border-color: #c3c4c7;
        }

        /* Enhanced Color Palette */
        .navid-palette-swatches {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }
        .navid-palette-option {
            cursor: pointer;
            display: inline-block;
        }
        .navid-palette-option input[type="radio"] {
            display: none;
        }
        .navid-palette-color {
            display: block;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid transparent;
            box-shadow: 0 0 0 1px #e2e4e7, 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            position: relative;
        }
        .navid-palette-option input[type="radio"]:checked + .navid-palette-color {
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #2271b1;
            transform: scale(1.05);
        }
        .navid-palette-option:hover .navid-palette-color {
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px #8c8f94;
        }
        
        /* Global Customizer Compact Mode */
        #customize-theme-controls .customize-control { margin-bottom: 16px !important; }
        #customize-theme-controls .customize-control-title { 
            font-size: 12px !important; 
            margin-bottom: 6px !important; 
        }
        #customize-theme-controls .customize-control input[type="text"],
        #customize-theme-controls .customize-control input[type="number"],
        #customize-theme-controls .customize-control select,
        #customize-theme-controls .customize-control textarea {
            min-height: 28px !important;
            font-size: 12px !important;
            padding: 0 8px !important;
        }
        
        /* Tooltip Icon Styling */
        #customize-theme-controls .customize-control {
            position: relative;
            overflow: visible !important; /* Prevent clipping of tooltips */
        }
        .navid-description-hidden {
            display: none !important;
        }
        /* Protect upsell and message controls from tooltip system */
        .customize-control-navid-upsell .navid-tooltip-icon,
        .customize-control-navid_message .navid-tooltip-icon {
            display: none !important;
        }
        .customize-control-navid-upsell .description,
        .customize-control-navid_message .description,
        .navid-upsell-wrapper .description,
        .navid-customizer-message .description {
            display: block !important;
        }
        .navid-tooltip-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: #e2e4e7;
            color: #50575e;
            border-radius: 50%;
            font-size: 11px;
            font-weight: bold;
            cursor: help;
            font-style: italic;
            font-family: serif;
            transition: all 0.2s;
            margin-left: 8px;
            flex-shrink: 0;
            position: relative; /* For the tooltip box */
        }
        .navid-tooltip-icon:hover {
            background: #2271b1;
            color: #fff;
        }
        .navid-tooltip-icon::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 140%;
            right: -8px;
            width: max-content;
            max-width: 220px;
            background: #1d2327;
            color: #fff;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 11px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
            font-style: normal;
            font-weight: 500;
            line-height: 1.4;
            white-space: normal;
            z-index: 999999;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s, bottom 0.2s;
            pointer-events: none; /* Crucial to prevent blinking */
            text-align: left;
            text-transform: none;
        }
        .navid-tooltip-icon:hover::after {
            opacity: 1;
            visibility: visible;
            bottom: 160%;
        }

        /* Toggle switches compact */
        .navid-toggle-switch {
            width: 32px;
            height: 18px;
        }
        .navid-slider:before {
            height: 12px;
            width: 12px;
            left: 3px;
            bottom: 3px;
        }
        .navid-toggle-switch input:checked + .navid-slider:before {
            transform: translateX(14px);
        }
        .navid-toggle-label {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .navid-toggle-label .customize-control-title {
            margin-bottom: 0 !important;
        }
        
    </style>
    <?php
}
add_action( 'customize_controls_print_styles', 'navid_customizer_styles' );

/**
 * Customizer Tooltip & Range Slider JS
 */
function navid_customizer_scripts() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        function processCustomizerControls() {
            // 1. Process Range Sliders
            $('input[type="range"]:not(.navid-range-processed)').each(function() {
                var $input = $(this);
                $input.addClass('navid-range-processed');
                var $display = $('<span class="navid-range-value" style="display:inline-block;background:#007cba;color:#fff;border-radius:3px;padding:2px 8px;font-size:11px;font-weight:600;margin-left:8px;min-width:36px;text-align:center;"></span>');
                
                var $label = $input.closest('.customize-control').find('label');
                var $title = $label.find('.customize-control-title');
                
                if ($title.length) {
                    $title.append($display);
                } else {
                    $label.append($display);
                }
                
                $display.text($input.val());
                $input.on('input', function() {
                    $display.text($(this).val());
                });
            });

            // 2. Process Descriptions into Tooltip Icons
            $('.customize-control .description:not(.navid-tooltip-processed)').each(function() {
                var $desc = $(this);
                
                // Skip upsells and notices — check BEFORE marking processed
                if ($desc.closest('.navid-upsell-wrapper, .navid-customizer-message, .navid-customizer-upsell').length > 0) {
                    $desc.addClass('navid-tooltip-processed');
                    return;
                }
                
                // Skip if parent control type is navid-upsell or navid_message
                var $control = $desc.closest('.customize-control');
                if ($control.hasClass('customize-control-navid-upsell') || $control.hasClass('customize-control-navid_message')) {
                    $desc.addClass('navid-tooltip-processed');
                    return;
                }
                
                $desc.addClass('navid-tooltip-processed');
                
                var text = $desc.text().trim();
                if (text === '') return;
                
                var $title = $desc.closest('.customize-control').find('.customize-control-title').first();

                if ($title.length && !$title.find('.navid-tooltip-icon').length) {
                    $title.css({
                        'display': 'flex',
                        'justify-content': 'space-between',
                        'align-items': 'center'
                    });
                    var $icon = $('<span class="navid-tooltip-icon" data-tooltip="' + text.replace(/"/g, '&quot;') + '">i</span>');
                    $title.append($icon);
                    $desc.addClass('navid-description-hidden');
                }
            });
        }

        // Run on initial load
        processCustomizerControls();

        // Watch for dynamically loaded panels
        var tooltipTimer;
        var observer = new MutationObserver(function() {
            clearTimeout(tooltipTimer);
            tooltipTimer = setTimeout(processCustomizerControls, 100);
        });
        observer.observe(document.getElementById('customize-theme-controls'), { childList: true, subtree: true });
        
        // Also run when Customizer is ready
        if (typeof wp !== 'undefined' && wp.customize) {
            wp.customize.bind('ready', function() {
                processCustomizerControls();
            });
        }
    });
    </script>
    <?php
}
add_action( 'customize_controls_print_footer_scripts', 'navid_customizer_scripts' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function navid_customize_preview_js() {
	wp_enqueue_script( 'navid-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), NAVID_VERSION, true );
}
add_action( 'customize_preview_init', 'navid_customize_preview_js' );

/**
 * Fix Customizer Edit Shortcut Icons Position
 */
function navid_customize_preview_styles() {
    ?>
    <style>
        .customize-partial-edit-shortcut, .widget .customize-partial-edit-shortcut {
            margin: -1px 0 0 35px !important;
        }
    </style>
    <?php
}
add_action( 'customize_preview_init', function() {
    add_action( 'wp_head', 'navid_customize_preview_styles', 999 );
} );
