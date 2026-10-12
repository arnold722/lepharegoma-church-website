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
 * Class FooterButton
 *
 * @package HFG\Core\Components
 */
class FooterButton extends Abstract_Component
{

	const COMPONENT_ID = 'button_base3';
	const STYLE_BTN_ID = 'style_btn_id';
	const LINK_ID      = 'link_setting';
	const TEXT_ID      = 'text_setting';
	const STYLE_ID     = 'style_setting';
	const FONT_COLOR_ID   = 'font_color_style_setting';
	const FONT_HOVER_COLOR_ID   = 'font_hover_color_style_setting';
	const BUTTON_BG_COLOR_ID = 'button_bg_color_style_setting';
	const BUTTON_BORDER_COLOR_ID = 'button_border_color_style_setting';
	const BUTTON_BORDER_HOVER_COLOR_ID = 'button_border_hover_color_style_setting';
	const BUTTON_BG_HOVER_COLOR_ID = 'button_bg_hover_color_style_setting';
	const BUTTON_FONT_SIZE     = 'button_font_size_style_setting3';
	const BUTTON_SIZE     = 'button_size_style_setting';
	const DEFAULT_FONT_SIZE = 16;	
	const BUTTON_BORDER_RADIUS     = 'button_border_radius_style_setting';
	const BUTTON_BORDER_WIDTH     = 'button_border_width_style_setting';

	/**
	 * Default spacing value
	 *
	 * @var array
	 */
	protected $default_padding_value = array(
		'mobile'       => array(
			'top'    => 8,
			'right'  => 12,
			'bottom' => 8,
			'left'   => 12,
		),
		'tablet'       => array(
			'top'    => 8,
			'right'  => 12,
			'bottom' => 8,
			'left'   => 12,
		),
		'desktop'      => array(
			'top'    => 8,
			'right'  => 12,
			'bottom' => 8,
			'left'   => 12,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Button constructor.
	 *
	 * @param string $panel Builder panel.
	 */
	public function __construct($panel)
	{
		parent::__construct($panel);
		if (solace_is_new_skin()) {
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
	public function init()
	{
		$this->set_property('label', __('Button One', 'solace'));
		$this->set_property('id', $this->get_class_const('COMPONENT_ID'));
		$this->set_property('component_slug', 'hfg-footer-button');
		$this->set_property('width', 2);
		$this->set_property('section', 'footer_button');
		$this->set_property('icon', 'admin-links');
		$this->set_property('is_auto_width', true);

		add_action('wp_enqueue_scripts', [$this, 'load_scripts']);
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
		$button_values = Mods::get($this->get_id() . '_' . self::STYLE_ID, solace_get_button_appearance_default());
		$css           = '.site-footer .builder-item--button_base3 { justify-content: var(--justify) !important; }';
		if (
			(isset($button_values['useShadow']) && !empty($button_values['useShadow'])) ||
			(isset($button_values['useShadowHover']) && !empty($button_values['useShadowHover']))
		) {
			$css = '.header .builder-item [class*="button_base3"] .button {box-shadow: var(--primarybtnshadow, none);} .header .builder-item [class*="button_base3"] .button:hover {box-shadow: var(--primarybtnhovershadow, none);}';
		}

		$css .= '.builder-item--button_base3 .component-wrap .button {font-size: var(--header-btn-font-size3);}';
		$css .= '.builder-item--button_base3 .component-wrap .button {font-family: var(--buttonfontfamily);}';

		return Dynamic_Css::minify_css($css);
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings()
	{
		SettingsManager::get_instance()->add(
			[
				'id'                 => self::STYLE_BTN_ID,
				'group'              => $this->get_class_const('COMPONENT_ID'),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'button1',
				'label'              => __('Button Style', 'solace'),
				'type'               => '\Solace\Customizer\Controls\React\Radio_Buttons',
				'options'            => [
					'is_for'        => 'button_base',
					'large_buttons' => true,
				],
				'section'            => $this->section,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::TEXT_ID,
				'group'              => $this->get_class_const('COMPONENT_ID'),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => __('Button', 'solace'),
				'label'              => __('Label Text', 'solace'),
				'options'            => [
					'input_attrs' => array(
						'placeholder' => __('Button', 'solace'),
					),
				],
				'type'               => 'text',
				'section'            => $this->section,
				'use_dynamic_fields' => array('string'),
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::LINK_ID,
				'group'              => $this->get_class_const('COMPONENT_ID'),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => '',
				'label'              => __('URL', 'solace'),
				'options'            => [
					'input_attrs' => array(
						'placeholder' => __('http://website.com/link', 'solace'),
					),
				],
				'type'               => 'text',
				'section'            => $this->section,
				'use_dynamic_fields' => array('url'),
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FONT_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __('Font Color', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-page-title-text)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'color',
						'selector' => '.builder-item--' . $this->get_id() . ' a.button',
					],
				],
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::FONT_HOVER_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __('Font Hover Color', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-page-title-text)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'color',
						'selector' => '.builder-item--' . $this->get_id() . ':hover a.button',
					],
				],				
			]
		);		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_BG_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __('Button Color', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-button-initial)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'background',
						'selector' => '.builder-item--' . $this->get_id() . ' a.button1',
					],
				],					
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_BORDER_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				// 'label'                 => __('Button Border Color', 'solace'),
				'label'                 => __('Button Border Color', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-button-initial)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'border-color',
						'selector' => '.builder-item--' . $this->get_id() . ' a.button2',
					],
				],					
			]
		);		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_BORDER_HOVER_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				// 'label'                 => __('Button Border Hover Color', 'solace'),
				'label'                 => __('Button Border Hover', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-button-initial)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'border-color',
						'selector' => '.builder-item--' . $this->get_id() . ':hover a.button2',
					],
				],					
			]
		);		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_BG_HOVER_COLOR_ID,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => 'solace_sanitize_colors',
				'label'                 => __('Button Hover Color', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Color',
				'default'               => 'var(--sol-color-button-hover)',
				'section'               => $this->section,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => 'background',
						'selector' => '.builder-item--' . $this->get_id() . ':hover a.button1',
					],
				],					
			]
		);

		$default_font_size_values = [
			'mobile'  => self::DEFAULT_FONT_SIZE,
			'tablet'  => self::DEFAULT_FONT_SIZE,
			'desktop' => self::DEFAULT_FONT_SIZE,
			'suffix'  => [
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			],
		];		

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_FONT_SIZE,
				'group'                 => $this->get_id(),
				'tab'                   => SettingsManager::TAB_GENERAL,
				'transport'             => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'     => array( $this, 'sanitize_responsive_int_json' ),
				'label'                 => __( 'Font Size', 'solace' ),
				'type'                  => 'Solace\Customizer\Controls\React\Responsive_Range',
				'default'               => $default_font_size_values,
				'options'               => [
					'input_attrs' => [
						'min'        => 0,
						'max'        => 100,
						'defaultVal' => $default_font_size_values,
						'units'      => [ 'px' ],
					],
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => array(
					'cssVar'  => [
						'vars'       => '--header-btn-font-size3',
						'responsive' => true,
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id(),
					],
				),
				'section'               => $this->section,
			]
		);		

		// SettingsManager::get_instance()->add(
		// 	[
		// 		'id'                    => self::BUTTON_SIZE,
		// 		'group'              	=> $this->get_class_const('COMPONENT_ID'),
		// 		'tab'                	=> SettingsManager::TAB_GENERAL,
		// 		'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
		// 		'sanitize_callback'     => 'absint',
		// 		'default'               => 100,
		// 		'label'                 => __('Button Size', 'solace'),
		// 		'type'                  => 'Solace\Customizer\Controls\React\Range',
		// 		'options'               => [
		// 			'input_attrs' => [
		// 				'min'        => 70,
		// 				'max'        => 300,
		// 				'defaultVal' => 100,
		// 			],
		// 		],
		// 		'live_refresh_selector' => true,
		// 		'live_refresh_css_prop' => [
		// 			'cssVar'   => [
		// 				'vars'     => 'width',
		// 				'suffix'   => 'px',
		// 				'selector' => '.builder-item--' . $this->get_id() . ' a.button',
		// 			],
		// 			'template' =>
		// 			'body ' . $this->default_selector . ' {
		// 				width: {{value}}px;
		// 				height: {{value}}px;
		// 			}',
		// 		],
		// 		'section'               => $this->section,
		// 	]
		// );

		$default_border_width = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'tablet'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'mobile'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
		];

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
				'id'                    => self::BUTTON_BORDER_WIDTH,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => array($this, 'sanitize_spacing_array'),
				'default'               => $default_border_width,
				'label'                 => __('Border Width', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100,
						'units' => ['px'],
					),
					'default'     => $default_border_width,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'      => [
						'responsive' => true,
						'vars'       => 'border-width',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id() . ' a.button2',
					],
					'responsive'  => true,
					'directional' => true,
					'template'    =>
					'body ' . $this->default_selector . ' a.button2 {
							border-top-width: {{value.top}};
							border-right-width: {{value.right}};
							border-bottom-width: {{value.bottom}};
							border-left-width: {{value.left}};
						}',
				],
				'section'               => $this->section,				
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                    => self::BUTTON_BORDER_RADIUS,
				'group'              	=> $this->get_class_const('COMPONENT_ID'),
				'tab'                	=> SettingsManager::TAB_GENERAL,
				'transport'          	=> 'post' . $this->get_class_const('COMPONENT_ID'),
				'sanitize_callback'     => array($this, 'sanitize_spacing_array'),
				'default'               => $default_border_radius,
				'label'                 => __('Border Radius', 'solace'),
				'type'                  => '\Solace\Customizer\Controls\React\Spacing',
				'options'               => [
					'input_attrs' => array(
						'min'   => 0,
						'max'   => 100,
						'units' => ['px'],
					),
					'default'     => $default_border_radius,
				],
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'      => [
						'responsive' => true,
						'vars'       => 'border-radius',
						'suffix'     => 'px',
						'selector'   => '.builder-item--' . $this->get_id() . ' a.button',
					],
					'responsive'  => true,
					'directional' => true,
					'template'    =>
					'body ' . $this->default_selector . ' a.button {
							border-top-left-top: {{value.top}};
							border-top-right-top: {{value.right}};
							border-bottom-right-top: {{value.bottom}};
							border-bottom-left-top: {{value.left}};
						}',
				],
				'section'               => $this->section,
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
	private function add_legacy_style($css_array)
	{
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


		return parent::add_style($css_array);
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
	public function add_style(array $css_array = array())
	{
		if (!solace_is_new_skin()) {
			return $this->add_legacy_style($css_array);
		}

		$id    = $this->get_id() . '_' . self::STYLE_ID;
		$value = get_theme_mod($id);

		$default_border_width = [
			'desktop-unit' => 'px',
			'tablet-unit'  => 'px',
			'mobile-unit'  => 'px',
			'desktop'      => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'tablet'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
			'mobile'       => [
				'top'    => 1,
				'right'  => 1,
				'bottom' => 1,
				'left'   => 1,
			],
		];

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

		$button_style = esc_html(get_theme_mod('button_base3_style_btn_id', 'button1'));

		$rules = [
			'--header-btn-font-size3' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::BUTTON_FONT_SIZE,
				Dynamic_Selector::META_DEFAULT => '{ "mobile": "' . self::DEFAULT_FONT_SIZE . '", "tablet": "' . self::DEFAULT_FONT_SIZE . '", "desktop": "' . self::DEFAULT_FONT_SIZE . '" }',
				Dynamic_Selector::META_SUFFIX  => 'px',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],			
			'--primarybtncolor'        => [
				Dynamic_Selector::META_KEY     => $id . '.text',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-page-title-text)',
			],	
			'--primarybtnhovercolor'   => [
				Dynamic_Selector::META_KEY     => $id . '.textHover',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-page-title-text)',
			],
			'--primarybtnbg'           => [
				Dynamic_Selector::META_KEY     => $id . '.background',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-button-initial)',
			],
			'--bordercolor'                => [
				Dynamic_Selector::META_KEY     => $id . '.borderColor',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-button-initial)',			
			],
			'--borderhovercolor'                => [
				Dynamic_Selector::META_KEY     => $id . '.borderHoverColor',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-button-initial)',			
			],
			'--primarybtnhoverbg'      => [
				Dynamic_Selector::META_KEY     => $id . '.backgroundHover',
				Dynamic_Selector::META_DEFAULT => 'var(--sol-color-button-hover)',
			],
			'--primarybtnborderradius' => [
				Dynamic_Selector::META_KEY => $id . '.borderRadius',
				'directional-prop'         => Config::CSS_PROP_BORDER_RADIUS,
			],
			'--width'                => [
				Dynamic_Selector::META_KEY           => $id . '.width',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => 76,
			],			
			'--borderwidth'                => [
				Dynamic_Selector::META_KEY 		 	 => $id . '.borderWidth',
				'directional-prop'         			 => Config::CSS_PROP_BORDER_WIDTH,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => $default_border_width,	
			],			
		];		

		if (isset($value['type']) && $value['type'] === 'outline') {
			$rules['--primarybtnborderwidth'] = [
				Dynamic_Selector::META_KEY => $id . '.borderWidth',
				'directional-prop'         => Config::CSS_PROP_BORDER_WIDTH,
			];
		}

		$button_values                    = $value;
		$rules['--primarybtnshadow']      = [
			Dynamic_Selector::META_KEY     => $id . '.shadowColor',
			Dynamic_Selector::META_DEFAULT => 'none',
			Dynamic_Selector::META_FILTER  => function ($css_prop, $value, $meta, $device) use ($button_values) {
				if (!isset($button_values['useShadow']) || empty($button_values['useShadow'])) {
					return sprintf('%s:%s;', $css_prop, 'none');
				}
				$blur   = intval($button_values['shadowProperties']['blur']);
				$width  = intval($button_values['shadowProperties']['width']);
				$height = intval($button_values['shadowProperties']['height']);

				return sprintf('%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value));
			},
		];
		$rules['--primarybtnhovershadow'] = [
			Dynamic_Selector::META_KEY     => $id . '.shadowColorHover',
			Dynamic_Selector::META_DEFAULT => 'none',
			Dynamic_Selector::META_FILTER  => function ($css_prop, $value, $meta, $device) use ($button_values) {
				if (!isset($button_values['useShadowHover']) || empty($button_values['useShadowHover'])) {
					return sprintf('%s:%s;', $css_prop, 'none');
				}
				$blur   = intval($button_values['shadowPropertiesHover']['blur']);
				$width  = intval($button_values['shadowPropertiesHover']['width']);
				$height = intval($button_values['shadowPropertiesHover']['height']);

				return sprintf('%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value));
			},
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $this->default_selector,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		return parent::add_style($css_array);
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component()
	{
		Main::get_instance()->load( 'components/component-button-footer' );
	}
}
