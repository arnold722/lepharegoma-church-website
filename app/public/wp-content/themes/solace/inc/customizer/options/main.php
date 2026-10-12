<?php
/**
 * Handles main customzier setup like root panels.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Customizer\Options
 */

namespace Solace\Customizer\Options;

use Solace\Core\Settings\Mods;
use Solace\Customizer\Controls\React\Documentation_Section;
use Solace\Customizer\Controls\React\Instructions_Section;
use Solace\Customizer\Base_Customizer;
use Solace\Customizer\Types\Control;
use Solace\Customizer\Types\Panel;
use Solace\Customizer\Types\Section;

/**
 * Main customizer handler.
 */
class Main extends Base_Customizer {
	/**
	 * Add controls.
	 */
	public function add_controls() {
		$this->register_types();
		$this->add_main_panels();
		$this->change_controls();
		$this->add_skin_switcher();
	}

	/**
	 * Register customizer controls type.
	 */
	private function register_types() {
		$this->register_type( 'Solace\Customizer\Controls\Radio_Image', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Range', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Responsive_Number', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Tabs', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Tabs_Custom', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Only_Label', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Heading', 'control' );
		$this->register_type( 'Solace\Customizer\Controls\Checkbox', 'control' );
	}

	/**
	 * Add main panels.
	 */
	private function add_main_panels() {
		$panels = array(
			'sol_general'     => array(
				'priority' => 25,
				'title'    => __( 'General Options', 'solace' ),
			),
			'solace_layout'     => array(
				'priority' => 25,
				'title'    => __( 'Page Settings', 'solace' ),
			),
			'solace_typography' => array(
				'priority' => 35,
				'title'    => __( 'Typography', 'solace' ),
			),
		);

		foreach ( $panels as $panel_id => $panel ) {
			$this->add_panel(
				new Panel(
					$panel_id,
					array(
						'priority' => $panel['priority'],
						'title'    => $panel['title'],
					)
				)
			);
		}
		$this->wpc->add_section(
			new Instructions_Section(
				$this->wpc,
				'solace_typography_quick_links',
				array(
					'priority' => - 100,
					'panel'    => 'solace_typography',
					'type'     => 'hfg_instructions',
					'options'  => array(
						'quickLinks' => array(
							'solace_body_font_family'     => array(
								'label' => esc_html__( 'Change main font', 'solace' ),
								'icon'  => 'dashicons-editor-spellcheck',
							),
							'solace_headings_font_family' => array(
								'label' => esc_html__( 'Change headings font', 'solace' ),
								'icon'  => 'dashicons-heading',
							),
							'solace_h1_accordion_wrap'    => array(
								'label' => esc_html__( 'Change H1 font size', 'solace' ),
								'icon'  => 'dashicons-info-outline',
							),
							'solace_archive_typography_post_title' => array(
								'label' => esc_html__( 'Change archive font size', 'solace' ),
								'icon'  => 'dashicons-sticky',
							),
						),
					),
				)
			)
		);

	}

	/**
	 * Change controls
	 */
	protected function change_controls() {
		$this->change_customizer_object( 'section', 'static_front_page', 'panel', 'solace_layout' );
		if ( solace_is_new_skin() ) {
			// Change default for shop columns WooCommerce option.
			$this->change_customizer_object( 'setting', 'woocommerce_catalog_columns', 'default', 3 );
		}
	}

	/**
	 * Add the skin switcher.
	 *
	 * @return void
	 * @since 3.0.0
	 */
	private function add_skin_switcher() {
		// If we started with the new skin this shouldn't show up at all.
		if ( get_theme_mod( 'solace_had_old_skin' ) === false ) {
			return;
		}

		// If we're not using the new builder. We don't show the switch & section.
		if ( ! solace_is_new_builder() ) {
			return;
		}

		// If the pro version exists but it's incompatible, we don't show the switch.
		if ( defined( 'SOLACE_PRO_VERSION' ) ) {
			if ( ! solace_pro_has_support( 'skinv2' ) ) {
				return;
			}
		}

		$section = 'solace_style_section';

		$this->add_section(
			new Section(
				$section,
				[
					'priority' => 201,
					'title'    => esc_html__( 'Style', 'solace' ),
				]
			)
		);

		$this->add_control(
			new Control(
				'solace_new_skin',
				[
					'transport'         => 'postMessage',
					'sanitize_callback' => 'sanitize_text_field',
					'default'           => 'new',
				],
				[
					'type'    => 'solace_skin_switcher',
					'section' => $section,
				]
			)
		);
	}
}
