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

use HFG\Core\Settings;
use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;

/**
 * Class Nav
 *
 * @package HFG\Core\Components
 */
class SecondNav extends Abstract_Component {

	const COMPONENT_ID    = 'secondary-menu';
	const STYLE_ID        = 'style';
	const COLOR_ID        = 'color';
	const HOVER_COLOR_ID  = 'hover_color';
	const ACTIVE_COLOR_ID = 'active_color';
	const SUBMENU_COLOR_ID         = 'submenu_color';
	const SUBMENU_BACKGROUND_ID    = 'background_color';	
	const ITEM_HEIGHT     = 'item_height';
	const SPACING         = 'spacing';
	const FONT_SIZE = 'font-size';
	const DEFAULT_FONT_SIZE = 16;
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
		$this->set_property( 'label', __( 'Menu Two', 'solace' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'width', 6 );
		$this->set_property( 'section', 'secondary_menu_primary' );
		$this->set_property( 'icon', 'tagcloud' );
		$this->set_property( 'has_font_family_control', true );
		$this->set_property( 'has_typeface_control', true );
		$this->set_property( 'default_typography_selector', $this->default_typography_selector . '.builder-item--' . $this->get_id() . ' .nav-ul li > a' );
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
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'style-plain',
				'conditional_header' => $this->get_builder_id() === 'header',
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
				'id'                => 'shortcut-header-two',
				'group'             => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_attr',
				'label'             => __( 'Secondary Menu', 'solace' ),
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
				'conditional_header'    => $this->get_builder_id() === 'header',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--link-color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					[
						'selector' => $this->default_typography_selector,
						'prop'     => 'color',
						'fallback' => 'inherit',
					],
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
		// 			'cssVar' => [
		// 				'vars'     => '--activecolor',
		// 				'selector' => '.builder-item--' . $this->get_id(),
		// 			],
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
				'conditional_header'    => $this->get_builder_id() === 'header',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--link-hover-color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					[
						'selector' => $this->default_typography_selector . ':after',
						'prop'     => 'background-color',
						'fallback' => 'inherit',
					],
					[
						'selector' => '.builder-item--' . $this->get_id() . ' .nav-menu-secondary:not(.style-full-height) .nav-ul li:hover > a',
						'prop'     => 'color',
						'fallback' => 'inherit',
					],
				],
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
				'conditional_header' => $this->get_builder_id() === 'header',
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
				'conditional_header' => $this->get_builder_id() === 'header',
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
			$default_menu_font_family = get_theme_mod( 'secondary-menu_font_family', $get_base_font_theme_mod );
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
			$default_menu_typeface = get_theme_mod( 'secondary-menu_typeface_general', $get_type_face_base_theme_mod );
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
		// 				'vars'       => '--header-menu-two',
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
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-nav-secondary' );
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

		$rules = [
			'--header-menu-two' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FONT_SIZE,
				Dynamic_Selector::META_DEFAULT => '{ "mobile": "' . self::DEFAULT_FONT_SIZE . '", "tablet": "' . self::DEFAULT_FONT_SIZE . '", "desktop": "' . self::DEFAULT_FONT_SIZE . '" }',
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],				
			'--link-color'       => [
				Dynamic_Selector::META_KEY => $this->get_id() . '_' . self::COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
			],
			'--link-hover-color'     => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
			'--activecolor' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
			],
			'--spacing'     => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SPACING ),
			],
			'--height'      => [
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
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id(),
			Dynamic_Selector::KEY_RULES    => $rules,
		];

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

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul#secondary-menu li > a',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul a:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-menu-secondary:not(.style-full-height) .nav-ul#secondary-menu li:hover > a',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul li:not(:last-child)',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_MARGIN_RIGHT => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( '%s:%s;', $css_prop, absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SPACING ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height #secondary-menu.nav-ul > li > a:after',
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
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height .nav-ul li:hover > a:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( 'width: calc(100%% + %s);', absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SPACING ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul > li > a',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_MIN_HEIGHT => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::ITEM_HEIGHT,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
				],
			],
		];

		return parent::add_style( $css_array );
	}
}
