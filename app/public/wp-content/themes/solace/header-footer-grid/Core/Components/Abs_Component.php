<?php
/**
 * Abstract Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Builder\Abstract_Builder;
use HFG\Core\Css_Generator;
use HFG\Core\Interfaces\Component;
use HFG\Core\Settings;
use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use HFG\Traits\Core;
use Solace\Core\Settings\Config;
use Solace\Core\Styles\Dynamic_Selector;
use Solace\Views\Font_Manager;
use WP_Customize_Manager;

/**
 * Class Abstract_Component
 *
 * @package HFG\Core
 */
abstract class Abs_Component implements Component {
	use Core;

	const ALIGNMENT_ID      = 'component_align';
	const VERTICAL_ALIGN_ID = 'component_vertical_align';
	const PADDING_ID        = 'component_padding';
	const MARGIN_ID         = 'component_margin';
	const FONT_FAMILY_ID    = 'component_font_family';
	const TYPEFACE_ID       = 'component_typeface';
	/**
	 * Current id of the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var null|string
	 */
	public static $current_component = null;
	/**
	 * Check if current component should show CSS when rendered inside customizer.
	 *
	 * @var bool
	 */
	public static $should_show_css = true;
	/**
	 * Default alignament value for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var null|string
	 */
	public $default_align = 'left';
	/**
	 * Current X pos of the component if set.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var mixed|null $current_x
	 */
	public $current_x = null;
	/**
	 * Current Width of the component if set.
	 *
	 * @since   1.0.0
	 * @access  public
	 * @var mixed|null $current_width
	 */
	public $current_width = null;
	/**
	 * The ID of component.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $id
	 */
	protected $id;
	/**
	 * The section name for the component
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $section
	 */
	protected $section;
	/**
	 * The component slug.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $section
	 */
	protected $component_slug = 'hfg-generic-component';

	/**
	 * Should component merge?
	 *
	 * @since  2.5.2
	 * @access protected
	 * @var bool $is_auto_width
	 */
	protected $is_auto_width = false;
	/**
	 * The section icon.
	 *
	 * @access protected
	 * @var string $icon
	 */
	protected $icon = 'welcome-widgets-menus';
	/**
	 * The component preview image.
	 *
	 * @access protected
	 * @var string $preview_image
	 */
	protected $preview_image = null;

	/**
	 * The component default width.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var int $width
	 */
	protected $width = 1;
	/**
	 * The component label
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $label
	 */
	protected $label;
	/**
	 * The component description
	 *
	 * @since   1.0.1
	 * @access  protected
	 * @var string $description
	 */
	protected $description;
	/**
	 * The component priority in customizer
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var int $priority
	 */
	protected $priority = 30;
	/**
	 * The name of the component panel
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var string $panel
	 */
	protected $panel;
	/**
	 * Holds component builder id.
	 *
	 * @var string $builder_id Builder id.
	 */
	private $builder_id;
	/**
	 * Can override the default css selector.
	 * Allows child components to specify their own selector for inherited style rules.
	 *
	 * @since   1.0.0
	 * @access  protected
	 * @var null|string $default_selector
	 */
	protected $default_selector = null;
	/**
	 * Default media selectors for device.
	 *
	 * @since   1.0.1
	 * @access  protected
	 * @var array $media_selectors The device and css media selector pairing.
	 */
	protected $media_selectors = array(
		'mobile'  => ' @media (max-width: 576px)',
		'tablet'  => ' @media (min-width: 576px)',
		'desktop' => ' @media (min-width: 961px)',
	);
	/**
	 * The default typography selector on which to apply the settings.
	 *
	 * @var null
	 */
	protected $default_typography_selector = null;

	/**
	 * Padding settings default values.
	 *
	 * @var array
	 */
	protected $default_padding_value = array(
		'mobile'       => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'tablet'       => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'desktop'      => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Margin settings default values.
	 *
	 * @var array
	 */
	protected $default_margin_value = array(
		'mobile'       => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'tablet'       => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'desktop'      => array(
			'top'    => 0,
			'right'  => 0,
			'bottom' => 0,
			'left'   => 0,
		),
		'mobile-unit'  => 'px',
		'tablet-unit'  => 'px',
		'desktop-unit' => 'px',
	);

	/**
	 * Typography control default values.
	 *
	 * @var array
	 */
	protected $typography_default = array(
		'fontSize'      => array(
			'suffix'  => array(
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			),
			'mobile'  => 1,
			'tablet'  => 1,
			'desktop' => 1,
		),
		'lineHeight'    => array(
			'mobile'  => 1.6,
			'tablet'  => 1.6,
			'desktop' => 1.6,
		),
		'letterSpacing' => array(
			'mobile'  => 0,
			'tablet'  => 0,
			'desktop' => 0,
		),
		'fontWeight'    => '500',
		'textTransform' => 'none',
	);

	/**
	 * Should have font family control.
	 *
	 * @var bool
	 */
	public $has_font_family_control = false;

	/**
	 * Should have typeface control.
	 *
	 * @var bool
	 */
	public $has_typeface_control = false;

	/**
	 * Should have horizontal alignment.
	 *
	 * @var bool
	 */
	public $has_horizontal_alignment = false;

	/**
	 * Component arguments.
	 *
	 * @var array
	 */
	protected $args = [];

	/**
	 * Abstract_Component constructor.
	 *
	 * @param string $panel Builder panel.
	 */
	public function __construct( $panel ) {
		if ( ! $this->is_active() ) {
			return;
		}

		$this->init();
		$this->set_property( 'panel', $panel );
		$this->set_property( 'icon', $this->icon );
		if ( $this->preview_image === null ) {
			$this->set_property( 'preview_image', $this->preview_image );
		}
		if ( $this->section === null ) {
			$this->set_property( 'section', $this->get_id() );
		}
		add_action( 'init', [ $this, 'define_settings' ] );
	}

	/**
	 * Set component arguments.
	 *
	 * @param array $args Component arguments.
	 */
	public function set_args( $args ) {
		$this->args = $args;
	}

	/**
	 * Allow for constant changes in pro.
	 *
	 * @param string $const Name of the constant.
	 *
	 * @return mixed
	 * @since   1.0.0
	 * @access  protected
	 */
	protected function get_class_const( $const ) {
		if ( defined( 'static::' . $const ) ) {
			return constant( 'static::' . $const );
		}

		return '';
	}

	/**
	 * Method to filter component loading if needed.
	 *
	 * @return bool
	 * @since   1.0.1
	 * @access  public
	 */
	public function is_active() {
		return true;
	}

	/**
	 * Method to check that the component is active.
	 *
	 * @return bool
	 */
	protected function is_component_active() {
		$builders = Main::get_instance()->get_builders();
		foreach ( $builders as $builder ) {
			if ( $builder->is_component_active( $this->get_id() ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Method to set protected properties for class.
	 *
	 * @param string $key The property key name.
	 * @param mixed  $value The property value.
	 *
	 * @return bool
	 * @since   1.0.0
	 * @access  protected
	 */
	protected function set_property( $key = '', $value = '' ) {
		if ( ! property_exists( $this, $key ) ) {
			return false;
		}
		$this->$key = $value;

		return true;
	}

	/**
	 * Utility method to return the component ID.
	 *
	 * @return string
	 * @since   1.0.0
	 * @access  public
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Return the settings for the component.
	 *
	 * @return array
	 * @since   1.0.0
	 * @updated 1.0.1
	 * @access  public
	 */
	public function get_settings() {
		return array(
			'name'          => $this->label,
			'description'   => $this->description,
			'id'            => $this->id,
			'width'         => $this->width,
			'section'       => $this->section, // Customizer section to focus when click settings.
			'icon'          => $this->icon,
			'previewImage'  => $this->preview_image,
			'componentSlug' => $this->component_slug,
		);
	}

	/**
	 * Get the section id.
	 *
	 * @return string
	 * @since   1.0.0
	 * @access  public
	 */
	public function get_section_id() {
		return $this->section;
	}

	/**
	 * Method to get protected properties for class.
	 *
	 * @param string $key The property key name.
	 *
	 * @return bool
	 * @since   1.0.0
	 * @access  protected
	 */
	public function get_property( $key = '' ) {
		if ( ! property_exists( $this, $key ) ) {
			return false;
		}

		return $this->$key;
	}

	/**
	 * Define global settings.
	 */
	// PENTING
	public function define_settings() {
		$this->add_settings();

		$padding_selector = '.builder-item--' . $this->get_id();

		if ( $this->default_selector !== null ) {
			$padding_selector = $this->default_selector;
		}

		do_action( 'hfg_component_settings', $this->get_id(), $this->section );
	}

	/**
	 * Get builder where component can be used.
	 *
	 * @return string Assigned builder.
	 */
	public function get_builder_id() {
		return $this->builder_id;
	}

	/**
	 * Called to register component controls.
	 *
	 * @param WP_Customize_Manager $wp_customize The Customize Manager.
	 *
	 * @return WP_Customize_Manager
	 * @since   1.0.0
	 * @updated 1.0.1
	 * @access  public
	 */
	public function customize_register( WP_Customize_Manager $wp_customize ) {

		$description = ( isset( $this->description ) && ! empty( $this->description ) )
			? $this->description
			: '';

		$wp_customize->add_section(
			$this->section,
			array(
				'title'              => $this->label,
				'description'        => $description,
				'description_hidden' => ( $description !== '' ),
				'priority'           => $this->priority,
				'panel'              => $this->panel,
			)
		);

		Settings\Manager::get_instance()->load( $this->get_id(), $wp_customize );

		$wp_customize->selective_refresh->add_partial(
			$this->get_id() . '_partial',
			array(
				'selector'            => '.builder-item--' . $this->get_id() . ':parent',
				'settings'            => Settings\Manager::get_instance()->get_transport_group( $this->get_id() ),
				'render_callback'     => [ $this, 'render' ],
				'container_inclusive' => true,
			)
		);

		return $wp_customize;
	}

	/**
	 * Render component markup.
	 *
	 * @param string $device Current device.
	 */
	public function render( $device = '' ) {
		$args = [];
		if ( ! empty( $device ) && in_array( $device, [ 'desktop', 'tablet', 'mobile' ] ) ) {
			$args['device'] = $device;
		}
		self::$current_component           = $this->get_id();
		Abstract_Builder::$current_builder = $this->get_builder_id();
		Main::get_instance()->load( 'component-wrapper', '', $args );
	}

	/**
	 * Assign component to builder.
	 *
	 * @param string $builder_id Builder unique id.
	 */
	public function assign_builder( $builder_id ) {
		$this->builder_id = $builder_id;
		if ( $this->builder_id === 'footer' ) {
			$this->has_horizontal_alignment = true;
		}
	}
}
