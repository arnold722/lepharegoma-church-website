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

use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Solace\Core\Dynamic_Css;
use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;

/**
 * Class FooterContact
 *
 * @package HFG\Core\Components
 */
class FooterContact extends Abstract_Component {

	const COMPONENT_ID = 'footer_contact';
	const LINK_ID      = 'link_setting';
	const FOOTER_CONTACT_ID  = 'footer_contact_setting';
	const STYLE_ID     = 'style_setting';
	const FONT_COLOR_ID  = 'font_color_setting';
	const ICON_COLOR_ID  = 'icon_color_setting';
	const ICON_BACKGROUND_ID  = 'icon_background_setting';
	const ICON_SIZE  = 'icon_size';

	/**
	 * Button constructor.
	 *
	 * @param string $panel Builder panel.
	 */
	public function __construct( $panel ) {
		parent::__construct( $panel );
		if ( solace_is_new_skin() ) {
			$this->default_selector = '.builder-item--' . $this->get_id();

			return;
		}
		$this->default_selector = '.builder-item > .item--inner.builder-item--' . $this->get_id() . ' > .component-wrap > a.button.button-primary';
	}

	/**
	 * Button constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Contacts', 'solace' ) );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'component_slug', 'hfg-button' );
		$this->set_property( 'width', 2 );
		$this->set_property( 'section', 'footer_contact' );
		$this->set_property( 'icon', 'admin-links' );
		$this->set_property( 'is_auto_width', true );

		add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
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
		$button_values = Mods::get( $this->get_id() . '_' . self::STYLE_ID, solace_get_button_appearance_default() );
		$css           = '';
		if (
			( isset( $button_values['useShadow'] ) && ! empty( $button_values['useShadow'] ) ) ||
			( isset( $button_values['useShadowHover'] ) && ! empty( $button_values['useShadowHover'] ) )
		) {
			$css = '.footer .builder-item [class*="button_base"] .button {box-shadow: var(--primarybtnshadow, none);} .footer .builder-item [class*="button_base"] .button:hover {box-shadow: var(--primarybtnhovershadow, none);}';
		}
		return Dynamic_Css::minify_css( $css );
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {

		// Contact
		SettingsManager::get_instance()->add(
			[
				'id'                 => self::FOOTER_CONTACT_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'phonesolcommaemailsolcomma123456solcommacontact@example.comsolcommasolcommasolcommaphonesolcommaemail',
				'label'              => __( 'Contact', 'solace' ),
				'type'               => '\Solace\Customizer\Controls\React\FooterContact',
				'section'            => $this->section,
				'use_dynamic_fields' => array( 'string' ),
			]
		);

		// Font color
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FONT_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Font Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'default'               => 'var(--sol-color-link-button-initial)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => 'color',
						'selector' => '.builder-item--' . $this->get_id() . ' .component-wrap .box-contact .box-content .title span, 
						               .builder-item--' . $this->get_id() . ' .component-wrap .box-contact .box-content .content span',
					],
					'selector' => '.builder-item--' . $this->get_id(),
				],
			]
		);

		// Icon Color
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::ICON_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Icon Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'default'               => '#fff',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => 'fill',
						'selector' => '.builder-item--' . $this->get_id() . ' .component-wrap .box-contact .box-icon svg',
					],
					'selector' => '.builder-item--' . $this->get_id(),
				],
			]
		);		

		// Icon Background
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::ICON_BACKGROUND_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Icon Background', 'solace' ),
				'type'                  => 'solace_color_control',
				'default'               => '#0f2e5f',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => 'background-color',
						'selector' => '.builder-item--' . $this->get_id() . ' .component-wrap .box-contact .box-icon',
					],
					'selector' => '.builder-item--' . $this->get_id(),
				],
			]
		);	

		// Icon Size
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::ICON_SIZE,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'     => 'absint',
				'label'                 => __( 'Icon Size', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Range',
				'default'               => 19,
				'options'               => [
					'input_attrs' => [
						'min'        => 12,
						'max'        => 35,
						'defaultVal' => 19,
					],
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => array(
					'cssVar'  => [
						'vars'     => array('width', 'height'),
						'selector' => '.builder-item--' . $this->get_id() . ' .component-wrap-footer-contact .box-contact .box-icon svg',
						'suffix'   => 'px',
					],
					'type'    => 'svg-icon-size',
					'default' => 19,
				),
				'section' => $this->section,
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
		$id = $this->get_id() . '_' . self::STYLE_ID;

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector,
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND      => $id . '.background',
				Config::CSS_PROP_COLOR           => $id . '.text',
				Config::CSS_PROP_BORDER_RADIUS   => [
					Dynamic_Selector::META_KEY => $id . '.borderRadius',
				],
				Config::CSS_PROP_CUSTOM_BTN_TYPE => [
					Dynamic_Selector::META_KEY => $id . '.type',
				],
				Config::CSS_PROP_BORDER_WIDTH    => [
					Dynamic_Selector::META_KEY => $id . '.borderWidth',
				],
			],
		];
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector . ':hover',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND => $id . '.backgroundHover',
				Config::CSS_PROP_COLOR      => $id . '.textHover',
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
		if ( ! solace_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}

		$id    = $this->get_id() . '_' . self::STYLE_ID;
		$value = get_theme_mod( $id );

		$rules = [
			'--primarybtnbg'           => [
				Dynamic_Selector::META_KEY     => $id . '.background',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-link-button-initial)',
			],
			'--primarybtncolor'        => [
				Dynamic_Selector::META_KEY     => $id . '.text',
				Dynamic_Selector::META_DEFAULT => '#fff',
			],
			'--primarybtnhoverbg'      => [
				Dynamic_Selector::META_KEY     => $id . '.backgroundHover',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-link-button-initial)',
			],
			'--primarybtnhovercolor'   => [
				Dynamic_Selector::META_KEY     => $id . '.textHover',
				Dynamic_Selector::META_DEFAULT => '#fff',
			],
			'--primarybtnborderradius' => [
				Dynamic_Selector::META_KEY => $id . '.borderRadius',
				'directional-prop'         => Config::CSS_PROP_BORDER_RADIUS,
			],
		];

		if ( isset( $value['type'] ) && $value['type'] === 'outline' ) {
			$rules['--primarybtnborderwidth'] = [
				Dynamic_Selector::META_KEY => $id . '.borderWidth',
				'directional-prop'         => Config::CSS_PROP_BORDER_WIDTH,
			];
		}

		$button_values                    = $value;
		$rules['--primarybtnshadow']      = [
			Dynamic_Selector::META_KEY     => $id . '.shadowColor',
			Dynamic_Selector::META_DEFAULT => 'none',
			Dynamic_Selector::META_FILTER  => function ( $css_prop, $value, $meta, $device ) use ( $button_values ) {
				if ( ! isset( $button_values['useShadow'] ) || empty( $button_values['useShadow'] ) ) {
					return sprintf( '%s:%s;', $css_prop, 'none' );
				}
				$blur   = intval( $button_values['shadowProperties']['blur'] );
				$width  = intval( $button_values['shadowProperties']['width'] );
				$height = intval( $button_values['shadowProperties']['height'] );

				return sprintf( '%s:%s;', $css_prop, sprintf( '%spx %spx %spx %s;', $width, $height, $blur, $value ) );
			},
		];
		$rules['--primarybtnhovershadow'] = [
			Dynamic_Selector::META_KEY     => $id . '.shadowColorHover',
			Dynamic_Selector::META_DEFAULT => 'none',
			Dynamic_Selector::META_FILTER  => function ( $css_prop, $value, $meta, $device ) use ( $button_values ) {
				if ( ! isset( $button_values['useShadowHover'] ) || empty( $button_values['useShadowHover'] ) ) {
					return sprintf( '%s:%s;', $css_prop, 'none' );
				}
				$blur   = intval( $button_values['shadowPropertiesHover']['blur'] );
				$width  = intval( $button_values['shadowPropertiesHover']['width'] );
				$height = intval( $button_values['shadowPropertiesHover']['height'] );

				return sprintf( '%s:%s;', $css_prop, sprintf( '%spx %spx %spx %s;', $width, $height, $blur, $value ) );
			},
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
		Main::get_instance()->load( 'components/component-footer-contact' );
	}
}
