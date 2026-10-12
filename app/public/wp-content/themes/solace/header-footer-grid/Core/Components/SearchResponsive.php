<?php
/**
 * Button Component class for Header Footer Grid.
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
 * Class SearchResponsive
 *
 * @package HFG\Core\Components
 */
class SearchResponsive extends Abstract_Component {
	use Core;
	use Theme_Info;

	const COMPONENT_ID        = 'header_search_responsive';
	const PLACEHOLDER_ID      = 'placeholder';
	const TOGGLE_ICON_ID    = 'toggle_icon';
	const TOGGLE_CUSTOM_ID  = 'toggle_icon_custom';
	const SIZE_ID             = 'icon_size';
	const AUTO_ADJUST       = 'auto_adjust_color';
	const COLOR_ID            = 'color';
	const HOVER_COLOR_ID      = 'hover_color';
	const OPEN_TYPE           = 'open_type';
	const FIELD_HEIGHT        = 'field_height';
	const FIELD_FONT_SIZE     = 'field_text_size';
	const FIELD_BG            = 'field_background';
	const FIELD_TEXT_COLOR    = 'field_text_color';
	const FIELD_BORDER_WIDTH  = 'field_border_width';
	const FIELD_BORDER_RADIUS = 'field_border_radius';

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
			'search1' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M15.464 14.1694L12.4911 11.1965C13.3921 10.0171 13.8862 8.58645 13.8864 7.07683C13.8864 5.2576 13.1779 3.54713 11.8913 2.26075C10.6049 0.974375 8.89466 0.265839 7.07521 0.265839C5.25597 0.265839 3.5455 0.974375 2.25912 2.26075C-0.396434 4.91653 -0.396434 9.23758 2.25912 11.8929C3.5455 13.1795 5.25597 13.8881 7.07521 13.8881C8.58482 13.8879 10.0154 13.3937 11.1949 12.4927L14.1677 15.4656C14.3465 15.6446 14.5813 15.7341 14.8158 15.7341C15.0504 15.7341 15.2851 15.6446 15.464 15.4656C15.822 15.1077 15.822 14.5272 15.464 14.1694ZM3.55535 10.5967C1.61459 8.65593 1.61482 5.49796 3.55535 3.55698C4.49551 2.61703 5.74564 2.09917 7.07521 2.09917C8.405 2.09917 9.6549 2.61703 10.5951 3.55698C11.5352 4.49714 12.0531 5.74726 12.0531 7.07683C12.0531 8.40663 11.5352 9.65652 10.5951 10.5967C9.6549 11.5369 8.405 12.0547 7.07521 12.0547C5.74564 12.0547 4.49551 11.5369 3.55535 10.5967Z" fill=""/>
			</svg>',
			'search2' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M18.6399 14.9033C18.1193 14.3827 16.4781 13.171 14.8487 12.2327C14.8311 12.2592 14.8134 12.2857 14.7957 12.3151C16.634 9.35333 16.2722 5.40921 13.6987 2.83568C10.6987 -0.161374 5.83691 -0.161374 2.83691 2.83568C-0.16309 5.83863 -0.160149 10.6974 2.83691 13.6975C5.38691 16.2445 9.27809 16.6298 12.231 14.8475C13.081 16.3239 14.3193 18.0563 14.9046 18.6416C15.934 19.671 17.6104 19.6681 18.6399 18.6387C19.6693 17.6063 19.6693 15.9357 18.6399 14.9033ZM11.6752 11.6739C9.79282 13.5533 6.74576 13.5533 4.86341 11.671C2.984 9.79157 2.98106 6.74451 4.86341 4.86216C6.74282 2.98274 9.79282 2.98274 11.6722 4.86216C13.5546 6.74451 13.5546 9.79451 11.6752 11.6739Z" fill=""/>
			</svg>',
			'search3' => '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M17.7482 15.4662L13.4385 11.014C13.1295 10.6946 12.7433 10.5667 12.5759 10.73C12.408 10.8922 12.0215 10.7646 11.7125 10.4452L11.6508 10.3813C13.5797 7.84441 13.3925 4.21223 11.0762 1.89599C8.54829 -0.631956 4.44953 -0.631956 1.9219 1.89599C-0.606047 4.42394 -0.606047 8.52211 1.9219 11.0501C4.27759 13.4061 7.99561 13.5639 10.5376 11.529L10.5647 11.5572C10.8732 11.8767 10.9881 12.2669 10.8196 12.4293C10.652 12.5918 10.766 12.9823 11.0754 13.3012L15.3827 17.7551C15.6917 18.0736 16.2009 18.0831 16.5206 17.7738L17.7295 16.6042C18.048 16.2956 18.0566 15.7867 17.7482 15.4662ZM9.65374 9.62746C7.91412 11.3674 5.08322 11.3674 3.34386 9.62805C1.60423 7.88842 1.6045 5.05721 3.34386 3.3179C5.08322 1.57827 7.91412 1.57853 9.65316 3.31816C11.3931 5.05753 11.3931 7.88815 9.65374 9.62746Z" fill=""/>
		</svg>',
			'search4' => '<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path d="M16.5991 13.0463C17.32 12.134 17.7142 11.0064 17.7188 9.84375C17.7188 8.8054 17.4108 7.79037 16.834 6.92701C16.2571 6.06365 15.4372 5.39074 14.4778 4.99338C13.5185 4.59602 12.4629 4.49206 11.4445 4.69463C10.4261 4.8972 9.49067 5.39722 8.75644 6.13144C8.02222 6.86567 7.5222 7.80113 7.31963 8.81953C7.11706 9.83793 7.22102 10.8935 7.61838 11.8528C8.01574 12.8122 8.68865 13.6321 9.55201 14.209C10.4154 14.7858 11.4304 15.0938 12.4688 15.0938C13.6314 15.0892 14.759 14.695 15.6713 13.9741L19.2238 17.5265C19.3476 17.646 19.5133 17.7122 19.6854 17.7107C19.8575 17.7092 20.0221 17.6402 20.1437 17.5185C20.2654 17.3968 20.3344 17.2322 20.3359 17.0601C20.3374 16.8881 20.2713 16.7223 20.1517 16.5985L16.5991 13.0463ZM8.53125 9.84375C8.53125 9.06499 8.76218 8.30371 9.19484 7.65619C9.6275 7.00868 10.2425 6.504 10.9619 6.20598C11.6814 5.90796 12.4731 5.82998 13.2369 5.98191C14.0007 6.13384 14.7023 6.50885 15.253 7.05952C15.8037 7.61019 16.1787 8.31178 16.3306 9.07558C16.4825 9.83938 16.4045 10.6311 16.1065 11.3506C15.8085 12.0701 15.3038 12.685 14.6563 13.1177C14.0088 13.5503 13.2475 13.7813 12.4688 13.7813C11.4248 13.7801 10.424 13.3649 9.68579 12.6267C8.94761 11.8885 8.5324 10.8877 8.53125 9.84375Z" fill=""/>
			<path d="M19.6875 1.96875H1.3125C1.13845 1.96875 0.971532 2.03789 0.848461 2.16096C0.72539 2.28403 0.65625 2.45095 0.65625 2.625C0.65625 2.79905 0.72539 2.96597 0.848461 3.08904C0.971532 3.21211 1.13845 3.28125 1.3125 3.28125H19.6875C19.8615 3.28125 20.0285 3.21211 20.1515 3.08904C20.2746 2.96597 20.3438 2.79905 20.3438 2.625C20.3438 2.45095 20.2746 2.28403 20.1515 2.16096C20.0285 2.03789 19.8615 1.96875 19.6875 1.96875Z" fill=""/>
			<path d="M1.3125 11.1562H5.25C5.42405 11.1562 5.59097 11.0871 5.71404 10.964C5.83711 10.841 5.90625 10.674 5.90625 10.5C5.90625 10.326 5.83711 10.159 5.71404 10.036C5.59097 9.91289 5.42405 9.84375 5.25 9.84375H1.3125C1.13845 9.84375 0.971532 9.91289 0.848461 10.036C0.72539 10.159 0.65625 10.326 0.65625 10.5C0.65625 10.674 0.72539 10.841 0.848461 10.964C0.971532 11.0871 1.13845 11.1562 1.3125 11.1562Z" fill=""/>
			<path d="M1.3125 15.0938H5.25C5.42405 15.0938 5.59097 15.0246 5.71404 14.9015C5.83711 14.7785 5.90625 14.6115 5.90625 14.4375C5.90625 14.2635 5.83711 14.0965 5.71404 13.9735C5.59097 13.8504 5.42405 13.7812 5.25 13.7812H1.3125C1.13845 13.7812 0.971532 13.8504 0.848461 13.9735C0.72539 14.0965 0.65625 14.2635 0.65625 14.4375C0.65625 14.6115 0.72539 14.7785 0.848461 14.9015C0.971532 15.0246 1.13845 15.0938 1.3125 15.0938Z" fill=""/>
			<path d="M1.3125 19.0312H15.75C15.924 19.0312 16.091 18.9621 16.214 18.839C16.3371 18.716 16.4062 18.549 16.4062 18.375C16.4062 18.201 16.3371 18.034 16.214 17.911C16.091 17.7879 15.924 17.7188 15.75 17.7188H1.3125C1.13845 17.7188 0.971532 17.7879 0.848461 17.911C0.72539 18.034 0.65625 18.201 0.65625 18.375C0.65625 18.549 0.72539 18.716 0.848461 18.839C0.971532 18.9621 1.13845 19.0312 1.3125 19.0312Z" fill=""/>
			<path d="M1.3125 7.21875H5.25C5.42405 7.21875 5.59097 7.14961 5.71404 7.02654C5.83711 6.90347 5.90625 6.73655 5.90625 6.5625C5.90625 6.38845 5.83711 6.22153 5.71404 6.09846C5.59097 5.97539 5.42405 5.90625 5.25 5.90625H1.3125C1.13845 5.90625 0.971532 5.97539 0.848461 6.09846C0.72539 6.22153 0.65625 6.38845 0.65625 6.5625C0.65625 6.73655 0.72539 6.90347 0.848461 7.02654C0.971532 7.14961 1.13845 7.21875 1.3125 7.21875Z" fill=""/>
		</svg>',
			'search5' => '<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M7.70831 2.16668C4.64774 2.16668 2.16665 4.64777 2.16665 7.70834C2.16665 10.7689 4.64774 13.25 7.70831 13.25C10.7689 13.25 13.25 10.7689 13.25 7.70834C13.25 4.64777 10.7689 2.16668 7.70831 2.16668ZM0.583313 7.70834C0.583313 3.77332 3.77329 0.583344 7.70831 0.583344C11.6434 0.583344 14.8333 3.77332 14.8333 7.70834C14.8333 9.39 14.2507 10.9356 13.2764 12.1543L16.185 15.0655C16.4941 15.3748 16.4938 15.876 16.1845 16.185C15.8752 16.4941 15.3739 16.4939 15.065 16.1846L12.1571 13.2741C10.938 14.2498 9.39132 14.8333 7.70831 14.8333C3.77329 14.8333 0.583313 11.6434 0.583313 7.70834ZM6.91665 3.75001C6.91665 3.31279 7.27108 2.95834 7.70831 2.95834C10.3317 2.95834 12.4583 5.08499 12.4583 7.70834C12.4583 8.14558 12.1039 8.50001 11.6666 8.50001C11.2294 8.50001 10.875 8.14558 10.875 7.70834C10.875 5.95944 9.45718 4.54168 7.70831 4.54168C7.27108 4.54168 6.91665 4.18723 6.91665 3.75001Z" fill=""/>
		</svg>',
		];

		if ( in_array( $icon, array_keys( $available_icons ), true ) ) {
			return $available_icons[ $icon ];
		}

		return $available_icons['search1'];
	}
	/**
	 * Button constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Search Icon', 'solace' ) );
		$this->set_property( 'id', self::COMPONENT_ID );
		$this->set_property( 'width', 1 );
		$this->set_property( 'icon', 'search' );
		$this->set_property( 'is_auto_width', true );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
		add_filter( 'hfg_component_scripts', [ $this, 'register_script' ] );
		add_filter( 'solace_after_css_root', [ $this, 'toggle_css' ] );
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			add_filter( 'solace_elementor_colors', [ $this, 'toggle_elementor_css' ] );
		}
	}

	/**
	 * Register Inline Scripts for component.
	 *
	 * @return string
	 */
	public function register_script() {
		$script_register = Script_Register::get_instance();
		if ( ( $this->is_component_active() || is_customize_preview() ) && $script_register->is_queued( self::COMPONENT_ID ) === false ) {
			$script_register->register_script( self::COMPONENT_ID, $this->toggle_script() );
		}
		return $script_register->inline_scripts();
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
		.toggle-palette .icon {
			display: flex;
			width: var(--iconsize);
			height: var(--iconsize);
			fill: currentColor;
		}
		.toggle-palette .label {
			font-size: 0.85em;
			margin-left: 5px;
		}';

		return Dynamic_Css::minify_css( $css );
	}

	/**
	 * Get JS contents from file to use as inline script.
	 *
	 * @return string
	 */
	public function toggle_script() {
		$auto_adjust   = Mods::get( $this->get_id() . '_' . self::AUTO_ADJUST, 0 );
		$default_state = '"light"';
		if ( $auto_adjust ) {
			$default_state = 'window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches?"dark":"light"';
		}
		return '!function(){const e="solace_user_theme",t="data-solace-theme";let n=' . $default_state . ';"dark"===localStorage.getItem(e)&&(n="dark"),document.documentElement.setAttribute(t,n);document.addEventListener("click",(n=>{n.target.matches(".palette-icon-wrapper, .palette-icon-wrapper *")&&(n=>{n.preventDefault();const a="light"===document.documentElement.getAttribute(t)?"dark":"light";document.documentElement.setAttribute(t,a),localStorage.setItem(e,a)})(n)}))}();';
	}

	/**
	 * Adds the palette variants to elementor
	 *
	 * @param string $css The global colors CSS from elementor.
	 *
	 * @return string
	 */
	public function toggle_elementor_css( $css ) {
		
		if ( ! $this->is_component_active() && ! is_customize_preview() ) {
			return $css;
		}
			
		return $css;
	}

	/**
	 * Methods used to filter CSS global colors
	 *
	 * @param string $css The CSS string.
	 *
	 * @return string
	 */
	public function toggle_css( $css ) {
		if ( ! $this->is_component_active() && ! is_customize_preview() ) {
			return '';
		}

		return '';
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
				'transport'         => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback' => 'wp_filter_nohtml_kses',
				// 'label'             => __( 'Select icon', 'solace' ),
				// 'description'       => __( 'Select icon', 'solace' ),
				'type'              => 'Solace\Customizer\Controls\React\Radio_Buttons',
				'default'           => 'search1',
				'options'           => [
					'is_for' => 'sol_search',
				],
				'section'           => $this->section,
			],
			$custom_icon_args
			)
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::PLACEHOLDER_ID,
				'group'              => self::COMPONENT_ID,
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_builder_id(),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => __( 'Search for...', 'solace' ),
				'label'              => __( 'Placeholder', 'solace' ),
				'type'               => 'text',
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::OPEN_TYPE,
				'group'              => self::COMPONENT_ID,
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_builder_id(),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'canvas',
				'label'              => __( 'Open Behaviour', 'solace' ),
				'type'               => 'select',
				'options'            => [
					'choices' => [
						'canvas'   => __( 'Canvas', 'solace' ),
						'minimal'  => __( 'Minimal', 'solace' ),
						'floating' => __( 'Float Above Header', 'solace' ),
					],
				],
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);

		// SettingsManager::get_instance()->add(
		// 	[
		// 		'id'                => $this->get_id() . '_icon_wrap',
		// 		'group'             => $this->get_id(),
		// 		'tab'               => SettingsManager::TAB_GENERAL,
		// 		'transport'         => 'postMessage',
		// 		'type'              => 'Solace\Customizer\Controls\Heading',
		// 		'sanitize_callback' => 'sanitize_text_field',
		// 		'label'             => __( 'Icon', 'solace' ),
		// 		'section'           => $this->section,
		// 		'options'           => [
		// 			'accordion'        => true,
		// 			'controls_to_wrap' => 3,
		// 			'expanded'         => true,
		// 			'class'            => esc_attr( 'resp-search-icon-accordion-' . $this->get_id() ),
		// 		],
		// 	]
		// );

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Icon Color', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'body ' . $this->default_selector . ' a.nv-search.nv-icon > svg {
							fill: {{value}};
						}',
				],
				'conditional_header'    => true,
			]
		);
		
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::SIZE_ID,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'absint',
				'default'               => 15,
				'label'                 => __( 'Icon Size', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Range',
				'options'               => [
					'input_attrs' => [
						'min'        => 10,
						'max'        => 100,
						'defaultVal' => 15,
					],
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--iconsize',
						'suffix'   => 'px',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'body ' . $this->default_selector . ' a.nv-search.nv-icon > svg {
							width: {{value}}px;
							height: {{value}}px;
						}',
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);


		

		// SettingsManager::get_instance()->add(
		// 	[
		// 		'id'                    => self::HOVER_COLOR_ID,
		// 		'group'                 => self::COMPONENT_ID,
		// 		'tab'                   => SettingsManager::TAB_GENERAL,
		// 		'transport'             => 'postMessage',
		// 		'sanitize_callback'     => 'solace_sanitize_colors',
		// 		'label'                 => __( 'Icon Hover Color', 'solace' ),
		// 		'type'                  => '\Solace\Customizer\Controls\React\Color',
		// 		'section'               => $this->section,
		// 		'live_refresh_selector' => true,
		// 		'live_refresh_css_prop' => [
		// 			'cssVar'   => [
		// 				'vars'     => '--hovercolor',
		// 				'selector' => '.builder-item--' . $this->get_id(),
		// 			],
		// 			'template' =>
		// 				'body ' . $this->default_selector . ' a.nv-search.nv-icon:hover > svg {
		// 					fill: {{value}};
		// 				}',
		// 		],
		// 		'conditional_header'    => true,
		// 	]
		// );

		SettingsManager::get_instance()->add(
			[
				'id'                => $this->get_id() . '_field_wrap',
				'group'             => $this->get_id(),
				'tab'               => SettingsManager::TAB_STYLE,
				'transport'         => 'postMessage',
				'type'              => 'Solace\Customizer\Controls\Heading',
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => __( 'Search Field', 'solace' ),
				'section'           => $this->section,
				'options'           => [
					'accordion'        => true,
					'controls_to_wrap' => 6,
					'expanded'         => false,
					'class'            => esc_attr( 'resp-search-field-accordion-' . $this->get_id() ),
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_HEIGHT,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'section'               => $this->section,
				'label'                 => __( 'Height', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Responsive_Range',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'     => [
						'responsive' => true,
						'vars'       => '--height',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'responsive' => true,
					'template'   =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							height: {{value}}px;
						}',
				],
				'options'               => [
					'input_attrs' => [
						'min'        => 10,
						'max'        => 200,
						'defaultVal' => [
							'mobile'  => 40,
							'tablet'  => 40,
							'desktop' => 40,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
						'units'      => [ 'px' ],
					],
				],
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'default'               => [
					'mobile'  => 40,
					'tablet'  => 40,
					'desktop' => 40,
				],
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_FONT_SIZE,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'section'               => $this->section,
				'label'                 => __( 'Font Size', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Responsive_Range',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'     => [
						'responsive' => true,
						'vars'       => '--formfieldfontsize',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'responsive' => true,
					'template'   =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							font-size: {{value}}px;
							padding-right: calc({{value}}px + 5px);
						}
						body ' . $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg, body ' . $this->default_selector . ' .close-responsive-search svg {
							width: {{value}}px;
							height: {{value}}px;
						}
						body ' . $this->default_selector . ' input[type=submit], body ' . $this->default_selector . ' .nv-search-icon-wrap {
							width: {{value}}px;
						}',
				],
				'options'               => [
					'input_attrs' => [
						'min'        => 10,
						'max'        => 200,
						'defaultVal' => [
							'mobile'  => 14,
							'tablet'  => 14,
							'desktop' => 14,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
						'units'      => [ 'px' ],
					],
				],
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'default'               => [
					'mobile'  => 14,
					'tablet'  => 14,
					'desktop' => 14,
				],
				'conditional_header'    => true,
			]
		);

		$new_skin   = solace_is_new_skin();
		$per_device = $new_skin ? [
			'top'    => 2,
			'right'  => 2,
			'bottom' => 2,
			'left'   => 2,
		] : [
			'top'    => 1,
			'right'  => 1,
			'bottom' => 1,
			'left'   => 1,
		];

		$default_border_width = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => $per_device,
			'tablet'       => $per_device,
			'mobile'       => $per_device,
		];

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BORDER_WIDTH,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				'default'               => $default_border_width,
				'label'                 => __( 'Border Width', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 20,
						'units' => [ 'px' ],
					),
					'default'     => $default_border_width,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'      => [
						'responsive' => true,
						'vars'       => '--formfieldborderwidth',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'responsive'  => true,
					'directional' => true,
					'template'    =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							border-top-width: {{value.top}};
							border-right-width: {{value.right}};
							border-bottom-width: {{value.bottom}};
							border-left-width: {{value.left}};
						}',
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);
		$default_border_radius = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
			'tablet'       => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
			'mobile'       => [
				'top'    => 3,
				'right'  => 3,
				'bottom' => 3,
				'left'   => 3,
			],
		];
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BORDER_RADIUS,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => array( $this, 'sanitize_spacing_array' ),
				'default'               => $default_border_width,
				'label'                 => __( 'Border Radius', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100,
						'units' => [ 'px' ],
					),
					'default'     => $default_border_radius,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'      => [
						'responsive' => true,
						'vars'       => '--formfieldborderradius',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'responsive'  => true,
					'directional' => true,
					'template'    =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							border-top-left-radius: {{value.top}};
							border-top-right-radius: {{value.right}};
							border-bottom-right-radius: {{value.bottom}};
							border-bottom-left-radius: {{value.left}};
						}',
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_BG,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Background Color', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'section'               => $this->section,
				'options'               => [
					'input_attrs' => [
						'allow_gradient' => true,
					],
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--formfieldbgcolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							background: {{value}};
						}',
					'fallback' => '#ffffff',
				],
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FIELD_TEXT_COLOR,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Text and Border', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => [
							'--formfieldcolor',
							'--formfieldbordercolor',
						],
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search], body ' . $this->default_selector . ' input::placeholder {
							color: {{value}};
						}
						body ' . $this->default_selector . ' .nv-nav-search .search-form input[type=search] {
							border-color: {{value}};
						}
						body ' . $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg {
							fill: {{value}};
						}',
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
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' a.nv-search.nv-icon > svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH      => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
				],
				Config::CSS_PROP_HEIGHT     => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
				],
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' a.nv-search.nv-icon:hover > svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' input[type=submit],' . $this->default_selector . ' .nv-search-icon-wrap',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .nv-nav-search .search-form input[type=search]',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_HEIGHT           => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_HEIGHT,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_HEIGHT ),
				],
				Config::CSS_PROP_FONT_SIZE        => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
				Config::CSS_PROP_PADDING_RIGHT    => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						$fs      = $value;
						$style   = '';
						$padding = ( $fs > 45 ? $fs : 45 ) + 5;
						if ( ! empty( $fs ) ) {
							$style = sprintf( 'padding-right:%spx;', $padding );
						}

						return $style;
					},
				],

				Config::CSS_PROP_BORDER_WIDTH     => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_WIDTH,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_WIDTH ),
				],
				Config::CSS_PROP_BORDER_RADIUS    => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_RADIUS,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_RADIUS ),
				],
				Config::CSS_PROP_BACKGROUND_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_BG,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BG ),
				],
				Config::CSS_PROP_BORDER_COLOR     => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .nv-nav-search .search-form input[type=search],' . $this->default_selector . ' input::placeholder',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .nv-search-icon-wrap .nv-icon svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
				],
				Config::CSS_PROP_WIDTH      => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
				Config::CSS_PROP_HEIGHT     => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ' .close-responsive-search svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH  => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
				Config::CSS_PROP_HEIGHT => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
					Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
				],
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Method to add Component css styles.
	 *
	 * @param array $css_array An array containing css rules.
	 *
	 * @return array
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_style( array $css_array = array() ) {
		if ( is_admin_bar_showing() ) {
			wp_add_inline_style( 'solace-style', 'body.admin-bar .floating .nv-nav-search {margin-top: 32px;}' );
		}

		if ( ! solace_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}


		$rules = [
			'--iconsize'              => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
				Dynamic_Selector::META_SUFFIX  => 'px',
			],
			'--color'                 => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
			],
			'--hovercolor'            => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
			'--formfieldfontsize'     => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_FONT_SIZE,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_FONT_SIZE ),
			],
			'--formfieldborderwidth'  => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_WIDTH,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_WIDTH ),
				'directional-prop'                   => Config::CSS_PROP_BORDER_WIDTH,
			],
			'--formfieldborderradius' => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_BORDER_RADIUS,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BORDER_RADIUS ),
				'directional-prop'                   => Config::CSS_PROP_BORDER_RADIUS,
			],
			'--formfieldbgcolor'      => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_BG,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_BG ),
			],
			'--formfieldbordercolor'  => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
			],
			'--formfieldcolor'        => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::FIELD_TEXT_COLOR,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_TEXT_COLOR ),
			],
			'--height'                => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::FIELD_HEIGHT,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT       => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::FIELD_HEIGHT ),
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		return parent::add_style( $css_array );
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		add_filter( 'nv_search_placeholder', [ $this, 'change_placeholder' ] );
		Main::get_instance()->load( 'components/component-search-responsive' );
		remove_filter( 'nv_search_placeholder', [ $this, 'change_placeholder' ] );
	}

	/**
	 * Change the form placeholder.
	 *
	 * @param string $placeholder placeholder string.
	 *
	 * @return string
	 */
	public function change_placeholder( $placeholder ) {
		return get_theme_mod( $this->id . '_placeholder', __( 'Search for...', 'solace' ) );
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
