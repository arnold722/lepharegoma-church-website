<?php
/**
 * Easy Digital Downloads Component class for Header Footer Grid.
 *
 * Author:          Uriahs Victor
 * Created on:      06/01/2022 (d/m/y)
 *
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Main;
use HFG\Core\Settings\Manager as SettingsManager;
use Solace\Core\Styles\Dynamic_Selector;


/**
 * Class Yoast_Breadcrumbs
 *
 * @package Solace_Pro\Modules\Header_Footer_Grid\Components
 */
class EddCartIcon extends Abstract_Component {

	const COMPONENT_ID   = 'edd_cart';
	const ICON_SELECTOR  = 'icon_selector';
	const CART_LABEL     = 'cart_label';
	const SIZE_ID        = 'icon_size';
	const LABEL_SIZE_ID  = 'label_size';
	const COLOR_ID       = 'color';
	const HOVER_COLOR_ID = 'hover_color';


	/**
	 * Breadcrumbs constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Easy Digital Downloads Cart', 'solace' ) );
		$this->set_property( 'id', self::COMPONENT_ID );
		$this->set_property( 'width', 1 );
		$this->set_property( 'default_selector', '.builder-item--' . $this->get_id() );
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
				'id'                    => self::SIZE_ID,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_STYLE,
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
					'cssVar'  => [
						'vars'     => '--iconsize',
						'selector' => '.builder-item--' . $this->get_id(),
						'suffix'   => 'px',
					],
					'type'    => 'svg-icon-size',
					'default' => 15,
				],
				'section'               => $this->section,
				'conditional_header'    => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_COLOR_ID,
				'group'                 => self::COMPONENT_ID,
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __( 'Hover Color', 'solace' ),
				'type'                  => 'solace_color_control',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--hovercolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
				],
			]
		);

	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		Main::get_instance()->load( 'components/component-edd-cart-icon' );
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
		$rules = [
			'--iconsize'   => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::SIZE_ID,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::SIZE_ID ),
			],
			'--labelsize'  => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::LABEL_SIZE_ID,
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_DEFAULT => 15,
			],
			'--color'      => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
			],
			'--hovercolor' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector,
		];

		return parent::add_style( $css_array );
	}

	/**
	 * Check if pro features should load.
	 *
	 * @return bool
	 */
	public static function should_load_pro_features() {
		return true;
	}
}

