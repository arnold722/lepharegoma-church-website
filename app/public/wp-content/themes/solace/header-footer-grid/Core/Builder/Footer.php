<?php

/**
 * Footer class for Footer Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Builder;

use HFG\Core\Customizer\Header_Presets;
use HFG\Main;
use Solace\Core\Dynamic_Css;
use Solace\Core\Settings\Mods;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Core\Theme_Info;
use Solace\Customizer\Controls\React\Presets_Footer;

use HFG\Core\Settings\Manager as SettingsManager;

use WP_Customize_Control;
use WP_Customize_Manager;

/**
 * Class Footer
 *
 * @package HFG\Core\Builder
 */
class Footer extends Abstract_Builder
{
	use Theme_Info;

	/**
	 * Builder name.
	 */
	const BUILDER_NAME = 'footer';

	/**
	 * Settings ids.
	 */
	const BACKGROUND_HEADING = 'background_heading';
	const ADVANCED_STYLE     = 'advanced_style';
	const BACKGROUND_SETTING = 'background';

	/**
	 * Default color for global footer background
	 *
	 * @var string Background default color.
	 */
	protected $default_background = 'var(--sol-color-background)';

	/**
	 * Footer init.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init()
	{
		$this->set_property('title', __('Footer Builder', 'solace'));
		$this->set_property( 'columns_layout', true );
		$this->set_property(
			'description',
			apply_filters(
				'hfg_footer_panel_description',
				sprintf(
					/* translators: %s link to documentation */
					esc_html__('Design your %1$s by dragging, dropping and resizing all the elements in real-time.', 'solace'),
					/* translators: %s builder type */
					$this->get_property('title'),
				)
			)
		);
		$migrated_hfg = solace_is_new_builder();

		$this->devices = [
			'desktop' => __('Footer', 'solace'),
		];

		add_filter('hfg_footer_wrapper_class', [$this, 'add_class_to_footer_wrapper']);
		// add_action( 'wp_enqueue_scripts', [ $this, 'load_scripts' ] );
	}

	/**
	 * Load Component Scripts
	 *
	 * @return void
	 */
	public function load_scripts()
	{
		wp_add_inline_style( 'solace-style', $this->toggle_style() );
	}

	/**
	 * Get CSS to use as inline script
	 *
	 * @return string
	 */
	public function toggle_style()
	{
		$css = '';

		$css .= $this->generate_background_css('hfg_footer_layout_top_background', 'body.elementor-page footer .footer-top');
		$css .= $this->generate_background_css('hfg_footer_layout_main_background', 'body.elementor-page footer .footer-main');
		$css .= $this->generate_background_css('hfg_footer_layout_bottom_background', 'body.elementor-page footer .footer-bottom');
	
		return Dynamic_Css::minify_css($css);
	}
	
	private function generate_background_css($theme_mod, $selector)
	{
		$row_background = get_theme_mod($theme_mod);
	
		if (is_array($row_background) && $row_background['type'] === 'color' && isset($row_background['toggleElementor']) && $row_background['toggleElementor']) {
			$css = $selector . ' { background: var(--bgcolorelementor); }';
			return $css;
		}
	
		return '';
	}	

	/**
	 * Called to register component controls.
	 *
	 * @param WP_Customize_Manager $wp_customize The Customize Manager.
	 *
	 * @return WP_Customize_Manager
	 * @since   1.0.0
	 * @access  public
	 */
	public function customize_register(WP_Customize_Manager $wp_customize)
	{
		if (!solace_is_new_builder()) {
			return parent::customize_register($wp_customize);
		}

		$section = $wp_customize->get_section('solace_pro_global_footer_settings');
		if (!empty($section)) {
			$section->priority = 201;
		}

		$wp_customize->add_section(
			'solace_footer_presets',
			[
				'title'    => __('Footer Presets', 'solace'),
				'priority' => 200,
				'panel'    => 'hfg_footer',
			]
		);

		$wp_customize->add_setting(
			'hfg_solace_footer_presets',
			[
				'sanitize_callback' => 'sanitize_text_field',
				'label'             => __('Footer Presets', 'solace'),
			]
		);

		$wp_customize->add_control(
			new Presets_Footer(
				$wp_customize,
				'hfg_solace_footer_presets',
				[
					'section'   => 'solace_footer_presets',
					'transport' => 'postMessage',
					'priority'  => 30,
					'presets'   => $this->get_footer_presets(),
					'builder'   => $this->layout_control_id,
				]
			)
		);

		$wp_customize->add_section(
			'solace_pro_global_footer_settings',
			[
				'title'    => __('Global Footer Settings', 'solace'),
				'priority' => 200,
				'panel'    => 'hfg_footer',
			]
		);

		$this->customize_global_footer();

		SettingsManager::get_instance()->load('solace_pro_global_footer_settings', $wp_customize);

		$tabs = $wp_customize->get_control('solace_pro_global_footer_settings_tabs');
		$this->move_pro_controls($wp_customize, $tabs);

		return parent::customize_register($wp_customize);
	}

	/**
	 * Moves the controls from pro in the specific tabs so that they
	 * merge well with the Solace global footer setting
	 *
	 * @param WP_Customize_Manager $wp_customize The Customize Manager.
	 * @param WP_Customize_Control $global_settings_tabs The Tabs Control.
	 */
	private function move_pro_controls(WP_Customize_Manager $wp_customize, WP_Customize_Control $global_settings_tabs)
	{
		if (!property_exists($global_settings_tabs, 'controls') || !property_exists($global_settings_tabs, 'tabs')) {
			return;
		}

		if ($wp_customize->get_control('solace_transparent_footer') !== null) {
			$global_settings_tabs->controls['style']['solace_transparent_footer'] = [];
		}

		if ($wp_customize->get_control('solace_transparent_only_on_home') !== null) {
			$wp_customize->get_control('solace_transparent_only_on_home')->priority   = 10;
			$global_settings_tabs->controls['style']['solace_transparent_only_on_home'] = [];
		}

		if ($wp_customize->get_control('solace_global_footer') !== null) {
			$global_settings_tabs->tabs['general']                           = [
				'label' => esc_html__('General', 'solace'),
				'icon'  => 'admin-generic',
			];
			$global_settings_tabs->controls['general']['solace_global_footer'] = [];
		}

		if ($wp_customize->get_control('solace_footer_conditional_selector') !== null) {
			$global_settings_tabs->controls['general']['solace_footer_conditional_selector'] = [];
		}

		// sorts the tabs so the general tab is showed first
		ksort($global_settings_tabs->tabs);
	}

	/**
	 * Registers controls for global footer background
	 */
	private function customize_global_footer()
	{
		$section_id = 'solace_pro_global_footer_settings';

		SettingsManager::get_instance()->add(
			[
				'id'        => self::BACKGROUND_HEADING,
				'group'     => $section_id,
				'label'     => esc_html__('Background', 'solace'),
				'section'   => $section_id,
				'tab'       => 'style',
				'priority'  => 15,
				'transport' => 'postMessage',
				'type'      => 'Solace\Customizer\Controls\Heading',
				'options'   => [
					'accordion'        => true,
					'controls_to_wrap' => 20,
					'expanded'         => true,
					'class'            => 'background-accordion',
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::ADVANCED_STYLE,
				'group'              => $section_id,
				'label'              => esc_html__('Enable Advanced Options', 'solace'),
				'section'            => $section_id,
				'tab'                => 'style',
				'type'               => 'solace_toggle_control',
				'priority'           => 25,
				'transport'          => 'refresh',
				'sanitize_callback'  => 'solace_sanitize_checkbox',
				'default'            => true,
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BACKGROUND_SETTING,
				'group'                 => $section_id,
				'section'               => $section_id,
				'tab'                   => 'style',
				'label'                 => esc_html__('Global', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Background',
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => 'backgroundControl',
						'selector' => '.global-styled',
					],
				],
				'options'               => [
					'priority'        => 30,
					'active_callback' => [$this, 'has_global_background'],
				],
				'default'               => [
					'type'       => 'color',
					'colorValue' => $this->default_background,
				],
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'solace_sanitize_background',
				'conditional_header'    => true,
			]
		);

		foreach ($this->get_rows() as $row => $row_data) {
			if ($row === 'sidebar') {
				continue;
			}

			SettingsManager::get_instance()->add(
				[
					'id'                => $row . '_shortcut',
					'group'             => $section_id,
					'section'           => $section_id,
					'tab'               => 'style',
					'transport'         => 'postMessage',
					'sanitize_callback' => 'esc_attr',
					'type'              => '\Solace\Customizer\Controls\Button',
					'priority'          => 35,
					'options'           => [
						'button_text'      => $row_data['title'],
						'button_class'     => 'button_background',
						'icon_class'       => 'edit',
						'shortcut'         => true,
						'is_button'        => false,
						'control_to_focus' => 'hfg_footer_layout_' . $row . '_background',
						'active_callback'  => [$this, 'has_not_global_background'],
					],
				]
			);

			SettingsManager::get_instance()->add(
				[
					'id'                => $row . '_shortcut',
					'group'             => $section_id,
					'section'           => 'hfg_footer_layout_' . $row,
					'label'              => __( 'Hide Row', 'solace' ),
					'type'               => 'solace_toggle_control',
					'priority'           => 25,
					'transport'          => 'refresh',
					'sanitize_callback'  => 'solace_sanitize_checkbox',
					'default'            => false,
					'conditional_header' => true,
				]
			);
		}
	}

	/**
	 * Adds a class to the footer wrapper.
	 *
	 * @param string $classes Existing classes.
	 * @return string Updated classes.
	 */
	public function add_class_to_footer_wrapper($classes)
	{
		return $classes . ($this->has_global_background() ? ' global-styled' : '');
	}

	/**
	 * Returns true if individual options from footer background are disabled
	 *
	 * @return bool
	 */
	public function has_global_background()
	{
		return !get_theme_mod('solace_pro_global_footer_settings_advanced_style', true);
	}

	/**
	 * Returns true if individual options from footer background are active
	 *
	 * @return bool
	 */
	public function has_not_global_background()
	{
		return !$this->has_global_background();
	}

	/**
	 * Method called via hook.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function load_template()
	{
		Main::get_instance()->load('footer-wrapper');
	}

	/**
	 * Get builder id.
	 *
	 * @return string Builder id.
	 */
	public function get_id()
	{
		return self::BUILDER_NAME;
	}

	/**
	 * Render builder row.
	 *
	 * @param string $device_id The device id.
	 * @param string $row_id The row id.
	 * @param array  $row_details Row data.
	 */
	public function render_row( $device_id, $row_id, $row_details ) {
		Main::get_instance()->load( 'footer-row-wrapper' );
	}

	/**
	 * Method to add global footer css styles.
	 *
	 * @param array $css_array An array containing css rules.
	 * @return array
	 */
	public function add_style(array $css_array = array())
	{
		$background = get_theme_mod(
			'solace_pro_global_footer_settings_background',
			[
				'type'       => 'color',
				'colorValue' => 'var(--sol-color-background)',
			]
		);

		$rules         = [];
		$control_id    = 'solace_pro_global_footer_settings_background';
		$selector      = '.global-styled';
		$default_color = 'var(--sol-color-background)';

		if ($background['type'] === 'color' && !empty($background['colorValue'])) {
			$rules = array_merge(
				$rules,
				[
					'--bgcolor' => [
						Dynamic_Selector::META_KEY     => $control_id . '.colorValue',
						Dynamic_Selector::META_DEFAULT => $default_color,
					],
				]
			);
		}

		if ($background['type'] === 'image') {
			$rules = array_merge(
				$rules,
				[
					'--overlaycolor'     => [
						Dynamic_Selector::META_KEY => $control_id . '.overlayColorValue',
					],
					'--bgimage'          => [
						Dynamic_Selector::META_KEY    => $control_id,
						Dynamic_Selector::META_FILTER => function ($css_prop, $value, $meta, $device) {
							$image = $this->get_row_featured_image($value['imageUrl'], $value['useFeatured'], $meta);
							return sprintf('%s:%s;', $css_prop, $image);
						},
					],
					'--bgposition'       => [
						Dynamic_Selector::META_KEY    => $control_id,
						Dynamic_Selector::META_FILTER => function ($css_prop, $value, $meta, $device) {
							if (!$this->is_valid_focus_point($value['focusPoint'])) {
								return '';
							}

							$parsed_position = round($value['focusPoint']['x'] * 100) . '% ' . round($value['focusPoint']['y'] * 100) . '%;';

							return sprintf('%s:%s;', $css_prop, $parsed_position);
						},
					],
					'--bgattachment'     => [
						Dynamic_Selector::META_KEY    => $control_id,
						Dynamic_Selector::META_FILTER => function ($css_prop, $value, $meta, $device) {
							if (!isset($value['fixed']) || $value['fixed'] !== true) {
								return '';
							}

							return sprintf('%s:fixed;', $css_prop);
						},
					],
					'--bgoverlayopacity' => [
						Dynamic_Selector::META_KEY    => $control_id,
						Dynamic_Selector::META_FILTER => function ($css_prop, $value, $meta, $device) {
							if (!isset($value['overlayOpacity'])) {
								return '';
							}

							return sprintf('%s:%s;', $css_prop, $value['overlayOpacity'] / 100);
						},
					],
				]
			);
		}

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		return parent::add_style($css_array);
	}

	/**
	 * Return  the builder rows.
	 *
	 * @return array
	 * @since   1.0.0
	 * @updated 1.0.1
	 * @access  protected
	 */
	protected function get_rows()
	{
		return [
			'top'     => array(
				'title'       => esc_html__('Footer Top', 'solace'),
				'description' => $this->get_property('description'),
			),
			'main'    => array(
				'title'       => esc_html__('Footer Main', 'solace'),
				'description' => $this->get_property('description'),
			),
			'bottom'  => array(
				'title'       => esc_html__('Footer Bottom', 'solace'),
				'description' => $this->get_property('description'),
			),
			// 'sidebar' => array(
			// 	'title'       => esc_html__( 'Mobile Sidebar', 'solace' ),
			// 	'description' => $this->get_property( 'description' ),
			// ),
		];
	}


	/**
	 * Get the footer presets.
	 *
	 * @return array
	 */
	private function get_footer_presets()
	{
		$presets = [
			[
				'label' => 'Preset 1',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer1.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"logo-footer\"}],\"c-left\":[{\"id\":\"footer-menu\"}],\"center\":[{\"id\":\"footer_contact\"}],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[],\"c-left\":[{\"id\":\"copyright_html\"}],\"center\":[],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],
			[
				'label' => 'Preset 2',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer2.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"footer-menu\"}],\"c-left\":[{\"id\":\"logo-footer\"}],\"center\":[{\"id\":\"footer_contact\"}],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[],\"c-left\":[{\"id\":\"copyright_html\"}],\"center\":[],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],
			[
				'label' => 'Preset 4',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer4.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"logo-footer\"}],\"c-left\":[],\"center\":[{\"id\":\"footer_contact\"}],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[{\"id\":\"footer-menu\"}],\"c-left\":[],\"center\":[{\"id\":\"copyright_html\"}],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],
			[
				'label' => 'Preset 5',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer5.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"logo-footer\"}],\"c-left\":[{\"id\":\"footer-menu\"}],\"center\":[{\"id\":\"copyright_html\"}],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],
			[
				'label' => 'Preset 6',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer6.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"logo-footer\"}],\"c-left\":[{\"id\":\"footer_contact\"}],\"center\":[{\"id\":\"button_base3\"}],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[{\"id\":\"footer-menu\"}],\"c-left\":[],\"center\":[{\"id\":\"copyright_html\"}],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],
			[
				'label' => 'Preset 7',
				'image' => SOLACE_ASSETS_URL . 'img/footer-presets/footer7.png',
				'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"logo-footer\"},{\"id\":\"footer_html\"}],\"c-left\":[{\"id\":\"footer-one-widgets\"}],\"center\":[{\"id\":\"footer-two-widgets\"}],\"c-right\":[{\"id\":\"footer-three-widgets\"}],\"right\":[]},\"bottom\":{\"left\":[{\"id\":\"copyright_html\"}],\"c-left\":[],\"center\":[{\"id\":\"footer-menu\"}],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			],			
			// [
			// 	'label' => 'Demo 1',
			// 	'image' => SOLACE_ASSETS_URL . 'img/footer-presets/demo1.png',
			// 	'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[{\"id\":\"footer_html\"}, {\"id\":\"footer_account\"}, {\"id\":\"footer_cart_icon\"}],\"c-left\":[{\"id\":\"footer-one-widgets\"}, {\"id\":\"footer-two-widgets\"}, {\"id\":\"footer-three-widgets\"}, {\"id\":\"footer-four-widgets\"}],\"center\":[{\"id\":\"footer_search\"}, {\"id\":\"footer_social\"}],\"c-right\":[{\"id\":\"footer-menu\"}, {\"id\":\"logo-footer\"}],\"right\":[{\"id\":\"footer_button_base\"}, {\"id\":\"footer_contact\"}, {\"id\":\"copyright_html\"}]},\"main\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			// ],
			// [
			// 	'label' => 'Demo 2',
			// 	'image' => SOLACE_ASSETS_URL . 'img/footer-presets/demo2.png',
			// 	'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[{\"id\":\"footer_html\"}, {\"id\":\"footer_account\"}, {\"id\":\"footer_cart_icon\"}],\"c-left\":[{\"id\":\"footer-one-widgets\"}, {\"id\":\"footer-two-widgets\"}, {\"id\":\"footer-three-widgets\"}, {\"id\":\"footer-four-widgets\"}],\"center\":[{\"id\":\"footer_search\"}, {\"id\":\"footer_social\"}],\"c-right\":[{\"id\":\"footer-menu\"}, {\"id\":\"logo-footer\"}],\"right\":[{\"id\":\"footer_button_base\"}, {\"id\":\"footer_contact\"}, {\"id\":\"copyright_html\"}]},\"bottom\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"sidebar\":[]}}"}',
			// ],
			// [
			// 	'label' => 'Demo 3',
			// 	'image' => SOLACE_ASSETS_URL . 'img/footer-presets/demo3.png',
			// 	'setup' => '{"hfg_footer_layout_v2":"{\"desktop\":{\"top\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"main\":{\"left\":[],\"c-left\":[],\"center\":[],\"c-right\":[],\"right\":[]},\"bottom\":{\"left\":[{\"id\":\"footer_html\"}, {\"id\":\"footer_account\"}, {\"id\":\"footer_cart_icon\"}],\"c-left\":[{\"id\":\"footer-one-widgets\"}, {\"id\":\"footer-two-widgets\"}, {\"id\":\"footer-three-widgets\"}, {\"id\":\"footer-four-widgets\"}],\"center\":[{\"id\":\"footer_search\"}, {\"id\":\"footer_social\"}],\"c-right\":[{\"id\":\"footer-menu\"}, {\"id\":\"logo-footer\"}],\"right\":[{\"id\":\"footer_button_base\"}, {\"id\":\"footer_contact\"}, {\"id\":\"copyright_html\"}]},\"sidebar\":[]}}"}',
			// ],
		];

		return apply_filters('solace_footer_presets_v2', $presets);
	}
}
