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

use HFG\Core\Settings\Manager as SettingsManager;

/**
 * Class HeaderWidget
 *
 * @package HFG\Core\Components
 */
class HeaderWidget extends Abstract_HeaderWidget {
	const COMPONENT_ID = 'header-widgets';

	/**
	 * HeaderWidget constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Widgets', 'solace' ) );

		$this->set_property( 'id', self::COMPONENT_ID );
		$this->set_property( 'width', 3 );

		$this->set_property( 'section', 'sidebar-widgets-header-widgets' );
		if ( solace_is_new_widget_editor() ) {
			if ( strpos( $this->section, 'widgets-header' ) !== false ) {
				$this->set_property( 'section', 'solace_' . $this->section );
			}
		}

		add_filter( 'customize_section_active', array( $this, 'header_widgets_show' ), 15, 2 );
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {
		if ( ! solace_is_new_widget_editor() ) {
			SettingsManager::get_instance()->add_controls_to_tabs(
				self::COMPONENT_ID,
				array(
					SettingsManager::TAB_GENERAL => array(
						'sidebars_widgets-header-widgets' => array(),
					),
				)
			);
		}
	}
}
