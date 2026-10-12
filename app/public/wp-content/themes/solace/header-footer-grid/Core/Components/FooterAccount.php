<?php
/**
 * Frontend Account Component class for Header Footer Grid.
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
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Core\Theme_Info;

/**
 * Class Account
 *
 * @package HFG\Core\Components
 */
class FooterAccount extends Abstract_Component {
	use Theme_Info;

	const COMPONENT_ID      = 'footer_account';
	const TOGGLE_ICON_ID    = 'toggle_icon';
	const TOGGLE_CUSTOM_ID  = 'toggle_icon_custom';
	const PLACEHOLDER_ID    = 'placeholder_account';
	const AUTO_ADJUST       = 'auto_adjust_color';
	const SIZE_ID           = 'icon_size_account';
	const COLOR_ID          = 'color';
	const HOVER_COLOR_ID    = 'hover_color';
	const DEFAULT_ICON_SIZE = 16;
	const USE_GRAVATAR = 'footer_account_use_gravatar';

	/**
	 * The section icon.
	 *
	 * @access protected
	 * @var string $icon
	 */
	protected $icon = 'buddicons-topics';
	/**
	 * The component default width.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var int $width
	 */
	protected $width = 1;
	/**
	 * The component slug.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $section
	 */
	protected $component_slug = 'hfg-account-icon';

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
			'account1' => '<svg aria-hidden="true" fill="currentColor" width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17">
			<path d="M13.239 12.095C11.022 11.287 10.313 10.606 10.313 9.146C10.313 8.27 11.04 7.702 11.287 6.952C11.5069 6.202 11.6773 5.43836 11.797 4.666C11.9037 4.14208 11.9808 3.61258 12.028 3.08C12.107 2.22 11.532 0 8.454 0C5.376 0 4.8 2.22 4.881 3.08C4.92846 3.61255 5.00558 4.14204 5.112 4.666C5.23081 5.43836 5.40051 6.20202 5.62 6.952C5.868 7.7 6.6 8.27 6.6 9.146C6.6 10.606 5.891 11.287 3.674 12.095C1.457 12.903 0 13.7 0 14.266V16.908H16.908V14.266C16.908 13.7 15.463 12.905 13.239 12.095Z" />
			</svg>',
			'account2' => '<svg aria-hidden="true" fill="currentColor" width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 22 22">
			<path d="M11.0189 4.40716C10.1956 4.40716 9.39079 4.65129 8.70621 5.10869C8.02163 5.56608 7.48805 6.21619 7.17293 6.97682C6.85781 7.73745 6.77531 8.57444 6.93586 9.38196C7.09641 10.1895 7.4928 10.9312 8.07491 11.5135C8.65701 12.0957 9.39869 12.4923 10.2062 12.6531C11.0136 12.8138 11.8507 12.7315 12.6114 12.4166C13.3721 12.1016 14.0223 11.5682 14.4799 10.8837C14.9374 10.1993 15.1817 9.39449 15.1819 8.57116C15.1817 7.46715 14.743 6.40843 13.9623 5.62777C13.1817 4.84712 12.123 4.40843 11.0189 4.40816V4.40716ZM11.0189 10.6522C10.6071 10.6522 10.2045 10.53 9.86214 10.3012C9.51974 10.0724 9.25288 9.74717 9.09533 9.36668C8.93778 8.98619 8.89661 8.56751 8.97702 8.16362C9.05744 7.75972 9.25583 7.38875 9.5471 7.09761C9.83838 6.80648 10.2094 6.60827 10.6134 6.52805C11.0173 6.44783 11.436 6.4892 11.8164 6.64693C12.1968 6.80467 12.5219 7.07168 12.7506 7.41419C12.9792 7.75671 13.1011 8.15934 13.1009 8.57116C13.1009 9.12334 12.8816 9.65291 12.4911 10.0434C12.1007 10.4338 11.5711 10.6532 11.0189 10.6532V10.6522ZM11.0189 0.243164C8.89161 0.243164 6.81205 0.873992 5.04323 2.05588C3.27442 3.23776 1.89579 4.91762 1.0817 6.88302C0.2676 8.84842 0.0545952 11.0111 0.469618 13.0976C0.88464 15.184 1.90905 17.1006 3.4133 18.6048C4.91756 20.1091 6.83409 21.1335 8.92055 21.5485C11.007 21.9635 13.1697 21.7505 15.1351 20.9364C17.1005 20.1223 18.7803 18.7437 19.9622 16.9749C21.1441 15.2061 21.7749 13.1265 21.7749 10.9992C21.7751 9.58668 21.4969 8.188 20.9564 6.88302C20.4159 5.57804 19.6236 4.39232 18.6248 3.39358C17.626 2.39485 16.4402 1.60267 15.1352 1.06229C13.8301 0.521901 12.4314 0.243901 11.0189 0.244164V0.243164ZM11.0189 19.6732C8.94677 19.6737 6.94365 18.9282 5.37594 17.5732C5.70306 17.0647 6.14865 16.6432 6.67449 16.3449C7.20032 16.0465 7.79069 15.8802 8.39494 15.8602C9.24361 16.1304 10.1283 16.2707 11.0189 16.2762C11.9098 16.2728 12.7948 16.1325 13.6429 15.8602C14.2473 15.8812 14.8377 16.0481 15.3636 16.3468C15.8895 16.6454 16.3353 17.0669 16.6629 17.5752C15.0948 18.9301 13.0913 19.6742 11.0189 19.6732ZM18.0749 16.0262C17.5385 15.3268 16.8484 14.7601 16.0581 14.3698C15.2678 13.9795 14.3984 13.7761 13.5169 13.7752C12.6991 13.9948 11.8618 14.1342 11.0169 14.1912C10.1721 14.1337 9.33485 13.9944 8.51694 13.7752C7.63638 13.7777 6.76809 13.9819 5.97869 14.3721C5.18929 14.7623 4.49974 15.3281 3.96294 16.0262C3.17057 14.9145 2.65188 13.6315 2.44912 12.2815C2.24635 10.9315 2.36523 9.55274 2.79609 8.25738C3.22694 6.96202 3.95758 5.78672 4.92854 4.82712C5.89951 3.86753 7.08334 3.15078 8.38368 2.73522C9.68403 2.31966 11.0641 2.21702 12.4116 2.43568C13.7591 2.65433 15.036 3.18809 16.1382 3.99351C17.2404 4.79893 18.1369 5.85324 18.7546 7.07061C19.3723 8.28799 19.6938 9.63403 19.6929 10.9992C19.6935 12.8026 19.1275 14.5617 18.0749 16.0262Z" />
			</svg>',
			'account3' => '<svg aria-hidden="true" fill="currentColor" width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
			<path d="M7.494.031a4.238 4.238 0 0 0-2.032.754c-.313.226-.74.678-.972 1.031-.567.864-.867 1.899-.948 3.284-.109 1.831.311 3.47 1.247 4.875l.162.242-.386.093c-1.111.27-2.118.799-2.795 1.466C.656 12.874.086 14.381.011 16.428c-.021.561.004.753.126.979.097.18.272.312.493.37.163.043.758.046 7.487.039l7.31-.009.145-.065a.842.842 0 0 0 .414-.416c.062-.136.065-.171.063-.808a7.952 7.952 0 0 0-.051-1.02c-.243-1.777-.878-3.061-1.959-3.962-.688-.574-1.572-1-2.564-1.236a5.593 5.593 0 0 1-.333-.084 3.463 3.463 0 0 1 .205-.329c.786-1.184 1.203-2.645 1.204-4.22.002-2.606-.879-4.433-2.525-5.236-.718-.35-1.629-.494-2.532-.4m1.247 2.051c.409.113.833.386 1.072.692.495.632.728 1.541.728 2.846 0 .773-.073 1.284-.272 1.917-.47 1.49-1.576 2.59-2.424 2.411-1.02-.215-1.991-1.651-2.248-3.321-.13-.843-.068-2.033.145-2.774.161-.558.357-.913.692-1.25.198-.199.288-.267.482-.36.219-.105.448-.179.663-.213.192-.03.993.006 1.162.052m.637 9.934c2.677.163 4.008 1.044 4.492 2.972.037.148.081.359.097.468l.045.29.016.092H2.061l.02-.177c.031-.286.128-.722.228-1.029.313-.956.887-1.621 1.763-2.041.536-.258 1.27-.444 2.119-.537.787-.086 2.137-.103 3.187-.038" fill-rule="evenodd" />
			</svg>',
			'account4' => '<svg aria-hidden="true" fill="currentColor" width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
			<path d="M17.778 17.778H2.222V2.222H17.778M17.778 0H2.222C1.63269 0 1.06751 0.234103 0.650809 0.650809C0.234103 1.06751 0 1.63269 0 2.222V17.778C0 18.3673 0.234103 18.9325 0.650809 19.3492C1.06751 19.7659 1.63269 20 2.222 20H17.778C18.3673 20 18.9325 19.7659 19.3492 19.3492C19.7659 18.9325 20 18.3673 20 17.778V2.222C20 1.63269 19.7659 1.06751 19.3492 0.650809C18.9325 0.234103 18.3673 0 17.778 0ZM15 14.722C15 13.055 11.667 12.222 10 12.222C8.333 12.222 5 13.055 5 14.722V15.555H15M10 10.277C10.4945 10.277 10.9778 10.1304 11.3889 9.85567C11.8 9.58097 12.1205 9.19052 12.3097 8.73371C12.4989 8.27689 12.5484 7.77423 12.452 7.28927C12.3555 6.80432 12.1174 6.35886 11.7678 6.00923C11.4181 5.6596 10.9727 5.4215 10.4877 5.32504C10.0028 5.22857 9.50011 5.27808 9.04329 5.4673C8.58648 5.65652 8.19603 5.97695 7.92133 6.38807C7.64662 6.7992 7.5 7.28255 7.5 7.777C7.5 8.44004 7.76339 9.07593 8.23223 9.54477C8.70107 10.0136 9.33696 10.277 10 10.277Z" />
			</svg>',
			'account5' => '<svg aria-hidden="true" fill="currentColor" width="100%" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18">
			<path d="M12.375 1.08799e-07C11.549 -0.000162347 10.733 0.181609 9.98517 0.532397C9.23731 0.883185 8.57589 1.39438 8.04791 2.02966C7.51993 2.66493 7.13834 3.4087 6.93027 4.2081C6.7222 5.00751 6.69274 5.84293 6.844 6.655L0 13.5V16.875C0 17.1734 0.118526 17.4595 0.329505 17.6705C0.540483 17.8815 0.826631 18 1.125 18H2.25V16.875H4.5V14.625H6.75V12.375H9L10.46 10.915C11.2319 11.194 12.0554 11.3007 12.8729 11.2277C13.6904 11.1546 14.482 10.9035 15.1922 10.4921C15.9023 10.0806 16.5138 9.51875 16.9838 8.84587C17.4537 8.173 17.7707 7.40543 17.9126 6.59704C18.0544 5.78864 18.0176 4.959 17.8048 4.16634C17.5919 3.37367 17.2082 2.63718 16.6806 2.00855C16.1529 1.37992 15.494 0.874377 14.7502 0.527397C14.0065 0.180418 13.1957 0.000408321 12.375 1.08799e-07ZM14.06 5.628C13.7262 5.6278 13.3999 5.52863 13.1225 5.34303C12.845 5.15743 12.6288 4.89374 12.5012 4.58528C12.3736 4.27682 12.3403 3.93745 12.4056 3.61007C12.4708 3.2827 12.6316 2.98202 12.8678 2.74605C13.1039 2.51008 13.4046 2.34941 13.7321 2.28436C14.0595 2.21931 14.3988 2.2528 14.7072 2.38059C15.0156 2.50838 15.2792 2.72473 15.4646 3.0023C15.65 3.27987 15.749 3.60619 15.749 3.94C15.749 4.16176 15.7053 4.38134 15.6204 4.5862C15.5355 4.79106 15.4111 4.97719 15.2542 5.13395C15.0974 5.29071 14.9112 5.41502 14.7063 5.4998C14.5014 5.58457 14.2818 5.62813 14.06 5.628Z" />
			</svg>',
		];

		if ( in_array( $icon, array_keys( $available_icons ), true ) ) {
			return $available_icons[ $icon ];
		}

		return $available_icons['account1'];
	}

	/**
	 * Account constructor
	 *
	 * @return void
	 */
	public function init() {
		$this->set_property( 'label', __( 'Account', 'solace' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() );
		$this->set_property( 'is_auto_width', true );

		add_filter( 'solace_after_css_root', [ $this, 'toggle_css' ] );
		if ( defined( 'ELEMENTOR_VERSION' ) ) {
			add_filter( 'solace_elementor_colors', [ $this, 'toggle_elementor_css' ] );
		}
		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
		add_filter( 'hfg_component_scripts', [ $this, 'register_script' ] );

		add_filter(
			'language_attributes',
			function ( $output ) {
				if ( solace_is_amp() ) {
					return $output . " [class]=\"isDark ? 'solace-dark-theme' : 'solace-light-theme'\" class=\"solace-dark-theme\" ";
				}

				return $output;
			}
		);
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
		$css = '.hfg_footer .sol-account-element a {
			display: flex;
			align-items: center;
			color: var(--color);
			justify-content: var(--justify);
		}
		.hfg_footer .sol-account-element a:hover {
			color: var(--hovercolor);
		}
		.hfg_footer .sol-account-element .icon {
			display: flex;
			width: var(--iconsize);
			height: var(--iconsize);
		}
		.hfg_footer .sol-account-element .label {
			font-size: var(--iconsize);
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
	 * Account register settings controls
	 *
	 * @return void
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
			[
				'id'                 => self::USE_GRAVATAR,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'absint',
				'default'            => 1,
				'label'              => __( 'Use Gravatar', 'solace' ),
				'type'               => 'solace_toggle_control_flex',
				'section'            => $this->section,
			]
		);		

		SettingsManager::get_instance()->add(
			array_merge(
				[
					'id'                => self::TOGGLE_ICON_ID,
					'group'             => $this->get_id(),
					'tab'               => SettingsManager::TAB_GENERAL,
					'transport'         => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
					'sanitize_callback' => 'wp_filter_nohtml_kses',
					'label'             => __( 'Select icon', 'solace' ),
					'description'       => __( 'Select icon', 'solace' ),
					'type'              => 'Solace\Customizer\Controls\React\Radio_Buttons',
					'default'           => 'account1',
					'options'           => [
						'is_for' => 'account',
					],
					'section'           => $this->section,
				],
				$custom_icon_args
			)
		);

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
				'id'                    => self::HOVER_COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Icon Hover Color', 'solace' ),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--hovercolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'body ' . $this->default_selector . ' a.nv-search.nv-icon:hover > svg {
							fill: {{value}};
						}',
				],
				'conditional_header'    => true,
			]
		);

		$default_size_values = [
			'mobile'  => self::DEFAULT_ICON_SIZE,
			'tablet'  => self::DEFAULT_ICON_SIZE,
			'desktop' => self::DEFAULT_ICON_SIZE,
			'suffix'  => [
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			],
		];

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::SIZE_ID,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'label'                 => __( 'Icon Size', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Responsive_Range',
				'default'               => $default_size_values,
				'options'               => [
					'input_attrs' => [
						'min'        => 8,
						'max'        => 120,
						'defaultVal' => $default_size_values,
						'units'      => [ 'px' ],
					],
				],
				'live_refresh_selector' => $this->default_selector . ' div.component-wrap .palette-icon-wrapper svg',
				'live_refresh_css_prop' => array(
					'cssVar'  => [
						'vars'       => '--iconsize',
						'responsive' => true,
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
					'type'    => 'svg-icon-size',
					'default' => self::DEFAULT_ICON_SIZE,
				),
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::PLACEHOLDER_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => '',
				'label'              => __( 'Label', 'solace' ),
				'options'            => [
					'input_attrs' => array(
						'placeholder' => __( 'Leave blank for no label ...', 'solace' ),
					),
				],
				'type'               => 'text',
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);
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
		if ( solace_is_new_skin() ) {
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id(),
				Dynamic_Selector::KEY_RULES    => [
					'--iconsize' => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
						Dynamic_Selector::META_DEFAULT => '{ "mobile": "' . self::DEFAULT_ICON_SIZE . '", "tablet": "' . self::DEFAULT_ICON_SIZE . '", "desktop": "' . self::DEFAULT_ICON_SIZE . '" }',
						Dynamic_Selector::META_SUFFIX  => 'px',
						Dynamic_Selector::META_IS_RESPONSIVE => true,
					],
					'--color' => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
					],
					'--hovercolor' => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
					],
				],
			];

			return parent::add_style( $css_array );
		}

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .hfg_footer .sol-account-element a.sol-account-url span.icon',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH  => [
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT       => '{ "mobile": "' . self::DEFAULT_ICON_SIZE . '", "tablet": "' . self::DEFAULT_ICON_SIZE . '", "desktop": "' . self::DEFAULT_ICON_SIZE . '" }',
				],
				Config::CSS_PROP_HEIGHT => [
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SIZE_ID,
					Dynamic_Selector::META_DEFAULT       => '{ "mobile": "' . self::DEFAULT_ICON_SIZE . '", "tablet": "' . self::DEFAULT_ICON_SIZE . '", "desktop": "' . self::DEFAULT_ICON_SIZE . '" }',
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .hfg_footer .sol-account-element a.sol-account-url',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .hfg_footer .sol-account-element a.sol-account-url:hover',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Render the component
	 *
	 * @return void
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-footer-account' );
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
