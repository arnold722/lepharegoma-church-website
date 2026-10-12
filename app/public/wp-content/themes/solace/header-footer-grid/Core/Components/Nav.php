<?php
/**
 * Custom Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Core\Dynamic_Css;

/**
 * Class Nav
 *
 * @package HFG\Core\Components
 */
class Nav extends Abstract_Component {
	const COMPONENT_ID             = 'primary-menu';
	const STYLE_ID                 = 'style';
	const COLOR_ID                 = 'color';
	const HOVER_COLOR_ID           = 'hover_color';
	const HOVER_TEXT_COLOR_ID      = 'hover_text_color';
	const ACTIVE_COLOR_ID          = 'active_color';
	const SUBMENU_COLOR_ID         = 'submenu_color';
	const SUBMENU_BACKGROUND_ID    = 'background_color';
	const LAST_ITEM_ID             = 'solace_last_menu_item';
	const NAV_MENU_ID              = 'nv-primary-navigation';
	const ITEM_HEIGHT              = 'item_height';
	const SPACING                  = 'spacing';
	const EXPAND_DROPDOWNS         = 'expand_dropdowns';
	const DROPDOWNS_EXPANDED_CLASS = 'dropdowns-expanded';
	const FONT_SIZE = 'font-size';
	const DEFAULT_FONT_SIZE = 16;
	const MENU_MOBILE_WIDTH        = 'menu_mobile_width';
	Const SUBMENU_BG_COLOR_ID = 'submenu_background_color';
	Const SUBMENU_TEXT_COLOR_ID = 'submenu_text_color';
	Const FONT_FAMILY = 'font_family';
	Const TYPEFACE_GENERAL = 'typeface_general';

	/**
	 * Nav constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Menu One', 'solace' ) );
		$this->set_property( 'component_slug', 'hfg-primary-menu' );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'width', 6 );
		$this->set_property( 'icon', 'tagcloud' );
		$this->set_property( 'section', 'header_menu_primary' );
		$this->set_property( 'has_font_family_control', true );
		$this->set_property( 'has_typeface_control', true );
		$this->set_property( 'default_typography_selector', $this->default_typography_selector . '.builder-item--' . $this->get_id() );
		$this->default_align = 'right';
		add_filter(
			'solace_last_menu_setting_slug_' . $this->get_class_const( 'COMPONENT_ID' ),
			array(
				$this,
				'filter_solace_last_menu_setting_slug',
			)
		);

		add_action(
			'solace_before_render_nav',
			function ( $component_id ) {
				if ( $this->get_id() !== $component_id ) {
					return;
				}
				add_filter( 'solace_first_level_expanded', [ $this, 'expanded_dropdown' ] );
				add_filter( 'nav_menu_submenu_css_class', [ $this, 'filter_menu_item_class' ], 10, 3 );
			}
		);

		add_action(
			'solace_after_render_nav',
			function ( $component_id ) {
				if ( $this->get_id() !== $component_id ) {
					return;
				}
				remove_filter( 'solace_first_level_expanded', [ $this, 'expanded_dropdown' ] );
				remove_filter( 'nav_menu_submenu_css_class', [ $this, 'filter_menu_item_class' ] );
			}
		);

		add_action('wp_enqueue_scripts', [$this, 'load_scripts']);
		add_action( 'init', [ $this, 'run_nav_init' ] );
	}

	/**
	 * Function for expanded carets.
	 *
	 * @return bool
	 */
	public function expanded_dropdown() {
		if ( ! $this->is_component_active() ) {
			return false;
		}
		return (bool) get_theme_mod( $this->get_id() . '_' . self::EXPAND_DROPDOWNS, false );
	}

	/**
	 * Add open class on submenu if 'Expand the first level of dropdowns...' option is on.
	 *
	 * @param array     $classes Submenu classes.
	 * @param \stdClass $args Submenu args.
	 * @param int       $depth Submenu depth.
	 *
	 * @return array
	 */
	public function filter_menu_item_class( $classes, $args, $depth ) {
		if ( ! $this->is_component_active() ) {
			return $classes;
		}
		$expand_dropdowns = get_theme_mod( $this->get_id() . '_' . self::EXPAND_DROPDOWNS, false );
		if ( (bool) $expand_dropdowns === false ) {
			return $classes;
		}
		if ( property_exists( $args, 'menu_class' ) && strpos( $args->menu_class, 'menu-mobile' ) && $depth === 0 ) {
			$classes[] = 'dropdown-open';
		}
		return $classes;
	}

	/**
	 * Way for adding other actions in pro.
	 *
	 * @since 3.4
	 * @access public
	 */
	public function run_nav_init() {
		do_action( 'solace_after_nav_init', $this->get_class_const( 'COMPONENT_ID' ) );
	}

	/**
	 * Filter the setting slug for last menu.
	 *
	 * @param string $slug The setting slug.
	 *
	 * @return string
	 * @since   2.3.7
	 * @access  public
	 */
	public function filter_solace_last_menu_setting_slug( $slug ) {
		if ( $slug !== $this->get_class_const( 'LAST_ITEM_ID' ) ) {
			return $this->get_class_const( 'LAST_ITEM_ID' );
		}

		return $slug;
	}

	/**
	 * Load Component Scripts
	 *
	 * @return void
	 */
	public function load_scripts()
	{
		if ($this->is_component_active() || is_customize_preview()) {
			wp_add_inline_style('solace-style', $this->toggle_style());
		}
	}	

	/**
	 * Get CSS to use as inline script
	 *
	 * @return string
	 */
	public function toggle_style()
	{
		$css           = '';

		$css .= 'div.header-menu-sidebar {width: var(--menu-mobile-width);}';

		return Dynamic_Css::minify_css($css);
	}	

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {
		SettingsManager::get_instance()->add(
			[
				'id'                 => self::STYLE_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_STYLE,
				'transport'          => 'refresh',
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'style-plain',
				'conditional_header' => true,
				'label'              => __( 'Hover Skin Mode', 'solace' ),
				'type'               => '\Solace\Customizer\Controls\React\Radio_Buttons',
				'section'            => $this->section,
				'options'            => [
					'large_buttons' => true,
					'is_for'        => 'menu',
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                => 'shortcut-header-menu-one',
				'group'             => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_attr',
				'label'             => __( 'Menu One', 'solace' ),
				'type'              => '\Solace\Customizer\Controls\Button',
				'options'           => [
					'shortcut'     => true,
					'button_class' => 'nv-top-bar-menu-shortcut',
					'icon_class'   => 'menu',
					'button_text'  => __( 'Select Menu', 'solace' ),
				],
				'section'           => $this->section,
			]
		);		

		$selector = '.builder-item--' . $this->get_id() . ' .nav-menu-primary > .nav-ul ';
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'default'               => '',
				'label'                 => __( 'Text Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--link-color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						$selector . ' li:not(.current_page_item):not(.current-menu-item):not(.woocommerce-mini-cart-item) > a,' . $selector . ' li.solace-mm-heading span {
						color: {{value}};
					}',
				],
			]
		);
		// SettingsManager::get_instance()->add(
		// 	[
		// 		'id'                    => self::ACTIVE_COLOR_ID,
		// 		'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
		// 		'tab'                   => SettingsManager::TAB_STYLE,
		// 		'transport'             => 'postMessage',
		// 		'sanitize_callback'     => 'solace_sanitize_colors',
		// 		'default'               => 'var(--sol-color-button-initial)',
		// 		'label'                 => __( 'Active Item Color', 'solace' ),
		// 		'type'                  => 'solace_color_control',
		// 		'section'               => $this->section,
		// 		'conditional_header'    => true,
		// 		'live_refresh_selector' => true,
		// 		'live_refresh_css_prop' => [
		// 			'cssVar'   => [
		// 				'vars'     => '--activecolor',
		// 				'selector' => '.builder-item--' . $this->get_id(),
		// 			],
		// 			'template' =>
		// 				$selector . ' li.current_page_item > a,' . $selector . ' li.current-menu-item > a {
		// 				color: {{value}} !important;
		// 			}',
		// 		],
		// 	]
		// );
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'default'               => '',
				'label'                 => __( 'Active/Hover Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--link-hover-color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'.builder-item--' . $this->get_id() . ' .nav-menu-primary:not(.style-full-height) > .nav-ul li:not(.woocommerce-mini-cart-item):hover > a {
							 color: {{value}} !important;
						}' .
						$selector . ' li:not(.woocommerce-mini-cart-item) > a:after,' . $selector . ' li > .has-caret > a:after {
							background-color: {{value}} !important;
						}',
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::SUBMENU_BG_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'default'               => 'var(--bgcolorelementor)',
				'label'                 => __( 'Submenu Background', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--submenu-bg',
						'selector' => '.builder-item--' . $this->get_id() . ' .sub-menu',
					],
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::SUBMENU_TEXT_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'default'               => '',
				'label'                 => __( 'Submenu Text Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--submenu-text-color',
						'selector' => '.builder-item--' . $this->get_id() . ' .sub-menu li a',
					],
				],
			]
		);		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::MENU_MOBILE_WIDTH,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'label'                 => __( 'Menu Width Mobile', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Responsive_Range',
				'default'               => '{ "mobile": "85", "tablet": "85", "desktop": "85" }',
				'options'               => [
					'input_attrs' => [
						'min'        => 20,
						'max'        => 100,
						'defaultVal' => '{ "mobile": "85", "tablet": "85", "desktop": "85" }',
						'units'      => [ '%' ],
					],
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => array(
					'cssVar'  => [
						'vars'       => '--menu-mobile-width',
						'responsive' => true,
						'suffix'     => '%',
						'selector'   => 'div.header-menu-sidebar',
					],
				),
				'section'               => $this->section,
			]
		);		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_TEXT_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'default'               => 'var(--sol-color-base-font)',
				'label'                 => __( 'Hover Skin Mode', 'solace' ) . ' ' . __( 'Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--hovertextcolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
				],
				'options'               => [
					'active_callback' => function() {
						return Mods::get( $this->get_id() . '_' . self::STYLE_ID, 'style-plain' ) === 'style-full-height';
					},
				],
			]
		);

		$order_default_components = array(
			'search',
		);
		$components               = array(
			'search' => __( 'Search', 'solace' ),
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			array_push( $order_default_components, 'cart' );
			$components['cart'] = __( 'Cart', 'solace' );
		}

		$components = apply_filters( 'solace_last_menu_item_components', $components );

		/**
		 * Last menu item removed for new users and users who didn't have it set.
		 *
		 * @since 2.5.3
		 */
		$old_last_menu_item = json_decode( get_theme_mod( 'solace_last_menu_item' ) );
		if ( $old_last_menu_item !== false && ! empty( $old_last_menu_item ) ) {
			SettingsManager::get_instance()->add(
				[
					'id'                => $this->get_class_const( 'LAST_ITEM_ID' ),
					'group'             => $this->get_class_const( 'COMPONENT_ID' ),
					'tab'               => SettingsManager::TAB_GENERAL,
					'noformat'          => true,
					'transport'         => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
					'sanitize_callback' => array( $this, 'sanitize_last_menu_item' ),
					'default'           => wp_json_encode( $order_default_components ),
					'label'             => __( 'Last Menu Item', 'solace' ),
					'type'              => 'Solace\Customizer\Controls\Ordering',
					'options'           => [
						'components' => $components,
					],
					'section'           => $this->section,
				]
			);
		}
		SettingsManager::get_instance()->add(
			[
				'id'                => 'shortcut',
				'group'             => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_attr',
				'type'              => '\Solace\Customizer\Controls\Button',
				'options'           => [
					'button_text'  => __( 'Primary Menu', 'solace' ),
					'button_class' => 'nv-top-bar-menu-shortcut',
					'icon_class'   => 'menu',
					'shortcut'     => true,
				],
				'section'           => $this->section,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::SPACING,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_LAYOUT,
				'section'            => $this->section,
				'label'              => __( 'Items Spacing (px)', 'solace' ),
				'type'               => 'Solace\Customizer\Controls\React\Responsive_Range',
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => [ $this, 'sanitize_responsive_int_json' ],
				'default'            => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				'options'            => [
					'input_attrs' => [
						'min'        => 1,
						'max'        => 100,
						'units'      => [ 'px' ],
						'defaultVal' => [
							'mobile'  => 20,
							'tablet'  => 20,
							'desktop' => 20,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
					],
				],
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::ITEM_HEIGHT,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_LAYOUT,
				'label'              => __( 'Items Min Height (px)', 'solace' ),
				'sanitize_callback'  => [ $this, 'sanitize_responsive_int_json' ],
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'default'            => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
				'type'               => 'Solace\Customizer\Controls\React\Responsive_Range',
				'options'            => [
					'input_attrs' => [
						'min'        => 1,
						'max'        => 100,
						'units'      => [ 'px' ],
						'defaultVal' => [
							'mobile'  => 25,
							'tablet'  => 25,
							'desktop' => 25,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
					],
				],
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::EXPAND_DROPDOWNS,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'refresh',
				'sanitize_callback'  => 'absint',
				'default'            => 0,
				'label'              => __( 'Expand first level of dropdowns when menu is in mobile menu content.', 'solace' ),
				'type'               => 'solace_toggle_control',
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);

		$default_menu_font_family = null;
		$get_base_font_theme_mod = get_theme_mod( 
			'solace_body_font_family',
			Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL )
		);
		
		if ( $get_base_font_theme_mod === Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL ) ) {
			$default_menu_font_family = $get_base_font_theme_mod;
		} else {
			$default_menu_font_family = get_theme_mod( 'primary-menu_font_family', $get_base_font_theme_mod );
		}

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FONT_FAMILY,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'label'                 => __( 'Typography', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Font_Family',
				'sanitize_callback'     => 'sanitize_text_field',
				'live_refresh_selector' => $default_menu_font_family,
				'live_refresh_css_prop' => array(
					'cssVar' => [
						'vars'     => '--font-family',
						'selector' => '.builder-item--' . $this->get_id(),
					],
				),
				'section'               => $this->section,
			]
		);		

		$default_menu_typeface = null;
		$get_type_face_base_theme_mod = get_theme_mod( 
			'solace_typeface_general',
			Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL )
		);
		
		if ( $get_type_face_base_theme_mod === Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL ) ) {
			$default_menu_typeface = $get_type_face_base_theme_mod;
		} else {
			$default_menu_typeface = get_theme_mod( 'primary-menu_typeface_general', $get_type_face_base_theme_mod );
		}

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::TYPEFACE_GENERAL,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'label'                 => __( 'Typeface General', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Typography',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => [
							'--text-transform' => 'textTransform',
							'--font-weight'    => 'fontWeight',
							'--font-size'      => [
								'key'        => 'fontSize',
								'responsive' => true,
							],
							'--line-height'    => [
								'key'        => 'lineHeight',
								'responsive' => true,
							],
							'--letter-spacing' => [
								'key'        => 'letterSpacing',
								'suffix'     => 'px',
								'responsive' => true,
							],
						],
						'selector' => '.builder-item--' . $this->get_id(),
					],
				],
				'section'               => $this->section,
				'default'               => $default_menu_typeface,
				'sanitize_callback'     => 'solace_sanitize_typography_control',
				'options'               => [
					'input_attrs'         => array(
						'size_units'             => [ 'em', 'px' ],
						'weight_default'         => $default_menu_typeface['fontWeight'],
						'size_default'           => $default_menu_typeface['fontSize'],
						'line_height_default'    => $default_menu_typeface['lineHeight'],
						'letter_spacing_default' => $default_menu_typeface['letterSpacing'],
					),
					'font_family_control' => $this->get_id() . '_' . self::TYPEFACE_GENERAL,
				],
			]
		);

		// $default_font_size_values = [
		// 	'mobile'  => self::DEFAULT_FONT_SIZE,
		// 	'tablet'  => self::DEFAULT_FONT_SIZE,
		// 	'desktop' => self::DEFAULT_FONT_SIZE,
		// 	'suffix'  => [
		// 		'mobile'  => 'px',
		// 		'tablet'  => 'px',
		// 		'desktop' => 'px',
		// 	],
		// ];		

		// SettingsManager::get_instance()->add(
		// 	[
		// 		'id'                    => self::FONT_SIZE,
		// 		'group'                 => $this->get_id(),
		// 		'tab'                   => SettingsManager::TAB_GENERAL,
		// 		'transport'             => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
		// 		'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
		// 		'label'                 => __( 'Font Size', 'solace' ),
		// 		'type'                  => 'Solace\Customizer\Controls\React\Responsive_Range',
		// 		'default'               => $default_font_size_values,
		// 		'options'               => [
		// 			'input_attrs' => [
		// 				'min'        => 0,
		// 				'max'        => 100,
		// 				'defaultVal' => $default_font_size_values,
		// 				'units'      => [ 'px' ],
		// 			],
		// 		],
		// 		'live_refresh_selector' => true,
		// 		'live_refresh_css_prop' => array(
		// 			'cssVar'  => [
		// 				'vars'       => '--header-menu-one',
		// 				'responsive' => true,
		// 				'suffix'     => 'px',
		// 				'selector'   => '.builder-item--' . $this->get_id(),
		// 			],
		// 		),
		// 		'section'               => $this->section,
		// 	]
		// );
	}

	/**
	 * Sanitize last menu item.
	 *
	 * @param string $value Json value of the control.
	 *
	 * @return string
	 */
	public function sanitize_last_menu_item( $value ) {
		$allowed = array(
			'cart',
			'search',
			'wish_list',
		);

		if ( empty( $value ) ) {
			return wp_json_encode( $allowed );
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return wp_json_encode( $allowed );
			}
		}

		return $value;
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		do_action( 'solace_before_render_nav', $this->get_id() );
		Main::get_instance()->load( 'components/component-nav', '', $this->args );
		do_action( 'solace_after_render_nav', $this->get_id() );
	}

	/**
	 * Add styles to the component.
	 *
	 * @param array $css_array rules array.
	 *
	 * @return array
	 */
	public function add_style( array $css_array = array() ) {
		if ( ! solace_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}

		$selector = '.builder-item--' . $this->get_id();

		$rules = [
			'--header-menu-one' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FONT_SIZE,
				Dynamic_Selector::META_DEFAULT => '{ "mobile": "' . self::DEFAULT_FONT_SIZE . '", "tablet": "' . self::DEFAULT_FONT_SIZE . '", "desktop": "' . self::DEFAULT_FONT_SIZE . '" }',
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],				
			'--link-color'          => [
				Dynamic_Selector::META_KEY => $this->get_id() . '_' . self::COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),			
			],
			'--link-hover-color'     => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
			'--submenu-bg'     => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SUBMENU_BG_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SUBMENU_BG_COLOR_ID ),
			],
			'--submenu-text-color'     => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SUBMENU_TEXT_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SUBMENU_TEXT_COLOR_ID ),
			],
			'--hovertextcolor' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_TEXT_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_TEXT_COLOR_ID ),
			],
			'--activecolor'    => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
			],
			'--spacing'        => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
			],
			'--height'         => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::ITEM_HEIGHT,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
			],
			'--font-family'    => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FONT_FAMILY,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FONT_FAMILY ),
			],
			'--text-transform' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::TYPEFACE_GENERAL . '.textTransform',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::TYPEFACE_GENERAL, 'textTransform' ),
			],		
			'--font-weight'    => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::TYPEFACE_GENERAL . '.fontWeight',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::TYPEFACE_GENERAL, 'fontWeight' ),
				'font'                         => 'mods_' . $this->get_id() . '_' . self::FONT_FAMILY_ID,
			],			
			'--font-size'      => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::TYPEFACE_GENERAL . '.fontSize',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::TYPEFACE_GENERAL, 'fontSize' ),
			],
			'--line-height'    => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::TYPEFACE_GENERAL . '.lineHeight',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::TYPEFACE_GENERAL, 'lineHeight' ),
			],
			'--letter-spacing' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::TYPEFACE_GENERAL . '.letterSpacing',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::TYPEFACE_GENERAL, 'letterSpacing' ),
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		// Sidebar is an ancestor of .builder-item--primary-menu; CSS variables must be set here (or higher) so width: var(--menu-mobile-width) resolves.
		$menu_mobile_width_mod = $this->get_id() . '_' . self::MENU_MOBILE_WIDTH;
		$css_array[]           = [
			Dynamic_Selector::KEY_SELECTOR => 'div.header-menu-sidebar',
			Dynamic_Selector::KEY_RULES    => [
				'--menu-mobile-width' => [
					Dynamic_Selector::META_KEY           => $menu_mobile_width_mod,
					Dynamic_Selector::META_SUFFIX        => '%',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $menu_mobile_width_mod ),
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
			],
		];

		$css_array = apply_filters( 'solace_nav_filter_css', $css_array, $this->get_id() );


		return parent::add_style( $css_array );
	}

	/**
	 * Add legacy style.
	 *
	 * @param array $css_array the styles css array.
	 *
	 * @return array
	 */
	private function add_legacy_style( array $css_array ) {
		$selector = '.builder-item--' . $this->get_id() . ' .nav-menu-primary > .nav-ul ';

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li:not(.woocommerce-mini-cart-item) > a,' . $selector . '.has-caret > a,' . $selector . ' .solace-mm-heading span,' . $selector . ' .has-caret',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . ' li:not(.woocommerce-mini-cart-item) > a:after,' . $selector . ' li > .has-caret > a:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];
		if ( SettingsManager::get_instance()->get( $this->get_id() . '_style' ) !== 'style-full-height' ) {
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => $selector . ' li:not(.woocommerce-mini-cart-item):hover > a,' . $selector . ' li:hover > .has-caret > a,' . $selector . ' li:hover > .has-caret',
				Dynamic_Selector::KEY_RULES    => [
					Config::CSS_PROP_COLOR => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
					],
				],
			];
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => $selector . 'li:hover > .has-caret svg',
				Dynamic_Selector::KEY_RULES    => [
					Config::CSS_PROP_FILL_COLOR => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
					],
				],
			];
		}
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li.current-menu-item > a,' . $selector . 'li.current_page_item > a,' . $selector . 'li.current_page_item > .has-caret > a',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
				],
			],
		];
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li.current-menu-item > .has-caret svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
				],
			],
		];

		$is_rtl = is_rtl();
		$last   = $is_rtl ? 'first' : 'last';

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul > li:not(:' . $last . '-of-type)',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_MARGIN_RIGHT => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( '%s:%s;', $css_prop, absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height .nav-ul li:not(.menu-item-nav-search):not(.menu-item-nav-cart) > a:after',
			Dynamic_Selector::KEY_RULES    => [
				'position' => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						if ( $device !== Dynamic_Selector::DESKTOP ) {
							return '';
						}
						$value = absint( $value );

						return sprintf( 'left:%s;right:%s', - $value / 2 . 'px', - $value / 2 . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height .nav-ul li:not(.menu-item-nav-search):not(.menu-item-nav-cart):hover > a:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( 'width: calc(100%% + %s);', absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul li a, .builder-item--' . $this->get_id() . ' .solace-mm-heading span',
			Dynamic_Selector::KEY_RULES    => [
				'min-height' => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::ITEM_HEIGHT,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
				],
			],
		];

		$menu_mobile_width_mod = $this->get_id() . '_' . self::MENU_MOBILE_WIDTH;
		$css_array[]           = [
			Dynamic_Selector::KEY_SELECTOR => 'div.header-menu-sidebar',
			Dynamic_Selector::KEY_RULES    => [
				'--menu-mobile-width' => [
					Dynamic_Selector::META_KEY           => $menu_mobile_width_mod,
					Dynamic_Selector::META_SUFFIX        => '%',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $menu_mobile_width_mod ),
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
			],
		];

		return parent::add_style( $css_array );
	}
}
