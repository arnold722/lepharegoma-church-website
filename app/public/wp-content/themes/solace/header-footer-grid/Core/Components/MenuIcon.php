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

use HFG\Core\Script_Register;
use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Solace\Core\Dynamic_Css;
use HFG\Traits\Core;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Core\Theme_Info;

/**
 * Class MenuIcon
 *
 * @package HFG\Core\Components
 */
class MenuIcon extends Abstract_Component {
	use Core;
	use Theme_Info;
	const COMPONENT_ID      = 'header_menu_icon';
	const SIDEBAR_TOGGLE    = 'sidebar';
	const TEXT_ID           = 'menu_label';
	const COLOR_ID            = 'color';
	const SIZE_ID             = 'icon_size';

	const TOGGLE_ICON_ID    = 'toggle_icon';
	const TOGGLE_CUSTOM_ID  = 'toggle_icon_custom';
	const BUTTON_APPEARANCE = 'button_appearance';
	const COMPONENT_SLUG    = 'nav-icon';
	const QUICK_LINKS_ID    = 'quick-links';
	const LABEL_MARGIN_ID   = 'label_margin';
	const MENU_ICON         = 'menu_icon';

	/**
	 * Padding settings default values.
	 *
	 * @var array
	 */
	protected $default_padding_value = array(

		'mobile'       => array(
			'top'    => 10,
			'right'  => 15,
			'bottom' => 10,
			'left'   => 15,
		),
		'tablet'       => array(
			'top'    => 10,
			'right'  => 15,
			'bottom' => 10,
			'left'   => 15,
		),
		'desktop'      => array(
			'top'    => 10,
			'right'  => 15,
			'bottom' => 10,
			'left'   => 15,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Label margin settings default values.
	 *
	 * @var array
	 */
	protected $default_label_margin_value = array(
		'mobile'       => array(
			'top'    => 0,
			'right'  => 5,
			'bottom' => 0,
			'left'   => 0,
		),
		'tablet'       => array(
			'top'    => 0,
			'right'  => 5,
			'bottom' => 0,
			'left'   => 0,
		),
		'desktop'      => array(
			'top'    => 0,
			'right'  => 5,
			'bottom' => 0,
			'left'   => 0,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Close button target CSS selector.
	 *
	 * @var string
	 */
	private $close_button = '.header-menu-sidebar .close-sidebar-panel .navbar-toggle';

	/**
	 * MenuIcon constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Menu Icon', 'solace' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_SLUG' ) );
		// $this->set_property( 'id', self::COMPONENT_ID );

		$this->set_property( 'component_slug', self::COMPONENT_SLUG );
		$this->set_property( 'width', 1 );
		$this->set_property( 'icon', 'menu' );
		$this->set_property( 'section', self::COMPONENT_ID );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() . ' .navbar-toggle' );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );

		// add_filter( 'solace_menu_icon_classes', array( $this, 'add_menu_icon_classes' ), 10, 2 );
	}

	/**
	 * Return a svg icon for the provided string.
	 *
	 * @param string $icon The icon string.
	 *
	 * @return string
	 */
	public static function get_icon( $icon, $icon_custom = '' ) {
		if ( $icon === 'custom' ) {
			return $icon_custom;
		}

		$available_icons = [
			'menu1' => '<svg  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 50 50" width="50px" height="50px"><path  d="M 0 7.5 L 0 12.5 L 50 12.5 L 50 7.5 Z M 0 22.5 L 0 27.5 L 50 27.5 L 50 22.5 Z M 0 37.5 L 0 42.5 L 50 42.5 L 50 37.5 Z"/></svg>',
			'menu2' => '<svg  xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 72 72" width="64px" height="64px"><path  d="M56 48c2.209 0 4 1.791 4 4 0 2.209-1.791 4-4 4-1.202 0-38.798 0-40 0-2.209 0-4-1.791-4-4 0-2.209 1.791-4 4-4C17.202 48 54.798 48 56 48zM56 32c2.209 0 4 1.791 4 4 0 2.209-1.791 4-4 4-1.202 0-38.798 0-40 0-2.209 0-4-1.791-4-4 0-2.209 1.791-4 4-4C17.202 32 54.798 32 56 32zM56 16c2.209 0 4 1.791 4 4 0 2.209-1.791 4-4 4-1.202 0-38.798 0-40 0-2.209 0-4-1.791-4-4 0-2.209 1.791-4 4-4C17.202 16 54.798 16 56 16z"/></svg>',
			'menu3' => '<svg  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="menu"><path  d="M12,7a2,2,0,1,0-2-2A2,2,0,0,0,12,7Zm0,10a2,2,0,1,0,2,2A2,2,0,0,0,12,17Zm0-7a2,2,0,1,0,2,2A2,2,0,0,0,12,10Z"></path></svg>',
			'menu4' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"  viewBox="0 0 24 24" id="menu-strawberry"><path  fill-rule="evenodd" d="M4 5C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H4ZM5 12C5 11.4477 5.44772 11 6 11L18 11C18.5523 11 19 11.4477 19 12C19 12.5523 18.5523 13 18 13L6 13C5.44772 13 5 12.5523 5 12ZM7 18C7 17.4477 7.44772 17 8 17H16C16.5523 17 17 17.4477 17 18C17 18.5523 16.5523 19 16 19H8C7.44772 19 7 18.5523 7 18Z" clip-rule="evenodd"></path></svg>',
			'menu5' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="menu"><path fill="" d="M18.97 32a4.57 4.57 0 1 1-4.57-4.57A4.575 4.575 0 0 1 18.97 32ZM14.4 14.07a4.57 4.57 0 1 0 4.57 4.57 4.575 4.575 0 0 0-4.57-4.57Zm0 26.72a4.57 4.57 0 1 0 4.57 4.57 4.575 4.575 0 0 0-4.57-4.57Zm9.146-20.647h29.122a1.5 1.5 0 0 0 0-3H23.546a1.5 1.5 0 0 0 0 3ZM52.668 30.5H23.546a1.5 1.5 0 0 0 0 3h29.122a1.5 1.5 0 1 0 0-3Zm0 13.357H23.546a1.5 1.5 0 0 0 0 3h29.122a1.5 1.5 0 0 0 0-3Z"></path></svg>',
		];

		if ( in_array( $icon, array_keys( $available_icons ), true ) ) {
			return $available_icons[ $icon ];
		}

		return $available_icons['menu1'];
	}

	/**
	 * Load Component Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		if ( $this->is_component_active() || is_customize_preview() ) {
			wp_add_inline_style( 'solace-style', $this->toggle_style() );
		}
	}

	/**
	 * Get CSS to use as inline script
	 *
	 * @return string
	 */
	public function toggle_style() {
		$css = '.toggle-palette a {
			display: flex;
			align-items: center;
		}
		.sol_menu_icon {
			display: flex;
		}
		.sol_menu_icon svg {
			width: var(--iconsize);
			height: var(--iconsize);
			fill: currentColor;
			width: 20px;
		}
		.toggle-palette .label {
			font-size: 0.85em;
			margin-left: 5px;
		} 
		.builder-item--nav-icon button,
		body div.builder-item--nav-icon button.navbar-toggle {
			background: var(--primarybtnbg) !important;
			color: var(--primarybtncolor) !important;
			border-style: solid;
			border-width: var(--borderwidth, 1px);
		}
		.builder-item--nav-icon button:hover {
			// background: transparent !important;
			opacity: .8;
			color: var(--primarybtncolor) !important;
		}
		.builder-item--nav-icon button:hover svg {
			fill: var(--color) !important;
		}';

		return Dynamic_Css::minify_css( $css );
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {

		$custom_icon_args = $this->should_load_pro_features() ? [
			'settings'       => [
				'default' => self::COMPONENT_ID . '_' . self::TOGGLE_ICON_ID,
				'custom'  => self::COMPONENT_ID . '_' . self::TOGGLE_CUSTOM_ID,
			],
			'setting_custom' => [
				'transport'         => 'post' . self::COMPONENT_ID,
				'sanitize_callback' => 'solace_kses_svg',
				'default'           => '',
			],
		] : [];
		

		SettingsManager::get_instance()->add(
			array_merge(
			[
				'id'                => self::TOGGLE_ICON_ID,
				'group'             => $this->get_id(),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'post' . $this->get_class_const( 'COMPONENT_SLUG' ),
				'sanitize_callback' => 'wp_filter_nohtml_kses',
				'type'              => 'Solace\Customizer\Controls\React\Radio_Buttons',
				'default'           => 'menu1',
				'options'           => [
					'is_for' => 'sol_menu',
				],
				'section'           => $this->section,
			],
			$custom_icon_args
			)
		);


		SettingsManager::get_instance()->add(
			[
				'id'                    => self::TEXT_ID,
				'group'                 => $this->get_id(),
				'transport'             => 'postMessage',
				'tab'                   => SettingsManager::TAB_GENERAL,
				'sanitize_callback'     => 'wp_filter_nohtml_kses',
				'default'               => '',
				'label'                 => __( 'Menu label', 'solace' ),
				'type'                  => 'text',
				'section'               => $this->section,
				'live_refresh_selector' => $this->default_selector . ' .nav-toggle-label',
				'live_refresh_css_prop' => array(
					'parent'     => $this->default_selector,
					'wrap_class' => 'nav-toggle-label',
					'html_tag'   => 'span',
				),
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::LABEL_MARGIN_ID,
				'group'                 => $this->get_id(),
				'transport'             => 'postMessage',
				'tab'                   => SettingsManager::TAB_LAYOUT,
				'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				'label'                 => __( 'Margin', 'solace' ) . ' (' . __( 'Label', 'solace' ) . ')',
				'type'                  => '\Solace\Customizer\Controls\React\Spacing',
				'default'               => $this->default_label_margin_value,
				'live_refresh_selector' => '.builder-item--' . $this->get_id(),
				'live_refresh_css_prop' => array(
					'cssVar' => [
						'vars'       => '--label-margin',
						'responsive' => true,
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'prop'   => 'margin',
				),
				'section'               => $this->section,
				'conditional_header'    => $this->get_builder_id() === 'header',
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::MENU_ICON,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'refresh',
				'sanitize_callback'     => 'wp_filter_nohtml_kses',
				'label'                 => __( 'Icon', 'solace' ),
				'description'           => __( 'Icon', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Inline_Select',
				'default'               => 'default',
				'options'               => [
					'options' => [
						'default' => 'Default',
						'arrow'   => 'Arrow',
						'donner'  => 'Donner',
						'dots'    => 'Dots',
						'minus'   => 'Minus',
						'vortex'  => 'Vortex',
						'squeeze' => 'Squeeze',
					],
					'default' => 'default',
				],
				'section'               => $this->section,
				'live_refresh_selector' => $this->default_selector,
				'conditional_header'    => true,
			]
		);

		$new_skin = solace_is_new_skin();
		$mod_key  = self::BUTTON_APPEARANCE;
		$default  = $new_skin ? [
			'type'         => 'outline',
			'text'		   => 'var(--sol-color-link-button-initial)',
			'borderRadius' => [
				'top'    => 0,
				'left'   => 0,
				'bottom' => 0,
				'right'  => 0,
			],
		] : [ 'type' => 'outline' ];

		SettingsManager::get_instance()->add(
			[
				'id'                    => $mod_key,
				'group'                 => $this->get_id(),
				'transport'             => 'postMessage',
				'tab'                   => SettingsManager::TAB_GENERAL,
				'sanitize_callback'     => 'solace_sanitize_button_appearance',
				'default'               => $default,
				'label'                 => __( 'Appearance', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Button_Appearance',
				'section'               => $this->section,
				'options'               => [
					'no_hover'     => true,
					'no_shadow'    => true,
					'default_vals' => $default,
				],
				'live_refresh_selector' => $this->default_selector,
				'live_refresh_css_prop' => [
					'cssVar'             => [
						'vars'     => [
							'--bgcolor'      => 'background',
							'--color'        => 'text',
							'--borderradius' => [
								'key'    => 'borderRadius',
								'suffix' => 'px',
							],
							'--borderwidth'  => [
								'key'    => 'borderWidth',
								'suffix' => 'px',
							],
						],
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'additional_buttons' => $this->get_class_const( 'COMPONENT_ID' ) !== 'header_menu_icon' ? [] : [
						[
							'button' => $this->close_button,
							'text'   => '.icon-bar',
						],
					],
				],
				'conditional_header'    => true,
			]
		);
	}


	/**
	 * Add legacy style.
	 *
	 * @param array $css_array css array.
	 *
	 * @return array
	 */
	private function add_legacy_style( $css_array ) {
		$id          = $this->get_id() . '_' . self::BUTTON_APPEARANCE;
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ', ' . $this->close_button,
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => $id . '.background',
				Config::CSS_PROP_COLOR            => $id . '.text',
				Config::CSS_PROP_BORDER_RADIUS    => $id . '.borderRadius',
				Config::CSS_PROP_CUSTOM_BTN_TYPE  => $id . '.type',
				Config::CSS_PROP_BORDER_WIDTH     => $id . '.borderWidth',
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .icon-bar, ' . $this->close_button . ' .icon-bar',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => $id . '.text',
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Add CSS style for the component.
	 *
	 * @param array $css_array the css style array.
	 *
	 * @return array
	 */
	public function add_style( array $css_array = array() ) {
		if ( ! solace_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}

		$id = $this->get_id() . '_' . self::BUTTON_APPEARANCE;

		$rules = [
			'--bgcolor'      => $id . '.background',
			'--color'        => $id . '.text',
			'--borderradius' => [
				Dynamic_Selector::META_KEY => $id . '.borderRadius',
				'directional-prop'         => Config::CSS_PROP_BORDER_RADIUS,
			],
			'--borderwidth'  => [
				Dynamic_Selector::META_KEY => $id . '.borderWidth',
				'directional-prop'         => Config::CSS_PROP_BORDER_WIDTH,
			],
		];

		$value = SettingsManager::get_instance()->get( $id );


		if ( isset( $value['type'] ) && $value['type'] !== 'outline' ) {
			$rules ['--borderwidth']['override'] = 0;
		}

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ',' . $this->close_button,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id(),
			Dynamic_Selector::KEY_RULES    => [
				'--label-margin' => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::LABEL_MARGIN_ID,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => $this->default_label_margin_value,
					Dynamic_Selector::META_SUFFIX        => 'responsive_unit',
					'directional-prop'                   => Config::CSS_PROP_MARGIN,
				],
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Render method.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-menu-icon' );
	}

	/**
	 * Check if pro features should load.
	 *
	 * @return bool
	 */
	public function should_load_pro_features() {
		return $this->has_valid_addons();
	}
}
