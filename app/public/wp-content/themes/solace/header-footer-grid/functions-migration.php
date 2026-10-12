<?php
/**
 * Migration schema from Old header/footer.
 *
 * @version 1.0.0
 * @package HFG
 */

/**
 * Handles migration for skin modes of rows
 */
function solace_hfg_migrate_skin_to_bg_color() {
	$flag = 'solace_migrated_hfg_colors';
	if ( get_theme_mod( $flag ) ) {
		return;
	}

	$defaults = [
		'header'      => [
			'top'     => [
				'bg'           => '#f0f0f0',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'main'    => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'bottom'  => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'sidebar' => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
		],
		'footer'      => [
			'top'     => [
				'bg'           => '#f0f0f0',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'main'    => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'bottom'  => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'sidebar' => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
		],
		'page_header' => [
			'top'    => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
			'bottom' => [
				'bg'           => '#ffffff',
				'other_bg'     => '#24292e',
				'default_skin' => 'light-mode',
			],
		],
	];
	foreach ( $defaults as $builder => $rows ) {
		foreach ( $rows as $row_id => $arg ) {
			$skin = get_theme_mod( 'hfg_' . $builder . '_layout_' . $row_id . '_skin' );
			if ( empty( $skin ) || $skin === $arg['default_skin'] ) {
				continue;
			}

			$mod_key    = 'hfg_' . $builder . '_layout_' . $row_id . '_background';
			$background = get_theme_mod( $mod_key );
			if ( empty( $background ) ) {
				continue;
			}

			if ( $background['type'] !== 'color' || $background['colorValue'] !== $arg['bg'] ) {
				continue;
			}

			$background['colorValue'] = $arg['other_bg'];
			set_theme_mod( $mod_key, $background );
		}
	}
	set_theme_mod( $flag, true );
}


add_action( 'init', 'solace_hfg_migrate_skin_to_bg_color' );
/**
 * Function to self heal theme mods option, in case of corrupted value.
 */
function solace_self_heal_mods() {
	/** @var mixed $all_mods */
	$all_mods = get_theme_mods();
	if ( $all_mods === false ) {
		return;
	}
	if ( is_array( $all_mods ) ) {
		return;
	}
	$theme_slug = get_option( 'stylesheet' );
	delete_option( "theme_mods_$theme_slug" );
}

add_action( 'init', 'solace_self_heal_mods', 1 );

/**
 * Define migration logic for header.
 *
 * @return array Migration schema.
 */
function solace_hfg_header_settings() {
	$empty_row = [
		'left'    => [],
		'c-left'  => [],
		'center'  => [],
		'c-right' => [],
		'right'   => [],
	];
	$builder   = [
		'desktop' => [
			'top'    => $empty_row,
			'main'   => $empty_row,
			'bottom' => $empty_row,
		],
		'mobile'  => [
			'top'     => $empty_row,
			'main'    => $empty_row,
			'bottom'  => $empty_row,
			'sidebar' => [],
		],
	];

	$builder['desktop']['main']['left'][]   = [
		'id' => 'logo',
	];
	$builder['desktop']['main']['center'][] = [
		'id' => 'primary-menu',
	];
	$builder['desktop']['main']['right'][]  = [
		'id' => 'button_base',
	];
	$builder['mobile']['main']['left'][]    = [
		'id' => 'logo',
	];
	$builder['mobile']['main']['right'][]   = [
		'id' => 'nav-icon',
	];
	$builder['mobile']['sidebar'][]         = [
		'id' => 'primary-menu',
	];

	return [
		'builder'    => $builder,
		'components' => [],
	];
}

/**
 * Define migration logic for header.
 *
 * @return array Migration schema.
 */
function solace_hfg_footer_settings() {
	$empty_row = [
		'left'    => [],
		'c-left'  => [],
		'center'  => [],
		'c-right' => [],
		'right'   => [],
	];
	$builder   = [
		'desktop' => [
			'top'    => $empty_row,
			'main'   => $empty_row,
			'bottom' => $empty_row,
		]
	];

	$builder['desktop']['top']['left'][]   = [
		'id' => 'logo-footer',
	];

	$builder['desktop']['top']['left'][]   = [
		'id' => 'footer_html1',
	];

	$builder['desktop']['top']['left'][]   = [
		'id' => 'footer_social',
	];

	$builder['desktop']['top']['center'][]   = [
		'id' => 'footer_html2',
	];

	$builder['desktop']['top']['c-right'][]   = [
		'id' => 'footer_html3',
	];

	$builder['desktop']['top']['right'][]   = [
		'id' => 'footer_html4',
	];	

	$builder['desktop']['bottom']['c-left'][]   = [
		'id' => 'copyright_html',
	];

	return [
		'builder'    => $builder,
		'components' => [],
	];
}

/**
 * Define migration logic for header.
 *
 * @return array Migration schema.
 */
function solace_hfg_legacy_header_settings() {
	$builder    = [
		'desktop' => [
			'top'    => [],
			'main'   => [],
			'bottom' => [],
		],
		'mobile'  => [
			'top'     => [],
			'main'    => [],
			'bottom'  => [],
			'sidebar' => [],
		],
	];
	$components = [];
	if ( (bool) get_theme_mod( 'solace_top_bar_enable', false ) ) {
		$alignament = get_theme_mod( 'solace_top_bar_layout', 'content-menu' );
		if ( $alignament === 'content-menu' ) {
			$builder['desktop']['top']['custom_html']    = [
				'id'    => 'custom_html',
				'width' => 6,
				'x'     => 0,
			];
			$builder['desktop']['top']['secondary-menu'] = [
				'id'    => 'secondary-menu',
				'width' => 6,
				'x'     => 6,
			];

			$components['custom_html']['component_align']    = 'left';
			$components['secondary-menu']['component_align'] = 'right';

		}
		if ( $alignament === 'menu-content' ) {
			$builder['desktop']['top']['secondary-menu']     = [
				'id'    => 'secondary-menu',
				'width' => 6,
				'x'     => 0,
			];
			$builder['desktop']['top']['custom_html']        = [
				'id'    => 'custom_html',
				'width' => 6,
				'x'     => 6,
			];
			$components['custom_html']['component_align']    = 'right';
			$components['secondary-menu']['component_align'] = 'left';
		}
	}

	$layout = get_theme_mod( 'solace_navigation_layout', 'left' );

	if ( $layout === 'left' ) {
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 4,
			'x'        => 0,
			'settings' => [
				'align' => 'left',
			],
		];
		$builder['desktop']['main']['primary-menu']    = [
			'id'       => 'primary-menu',
			'settings' => [
				'align' => 'right',
			],
			'width'    => 8,
			'x'        => 4,
		];
		$components['primary-menu']['component_align'] = 'right';
		$components['logo']['component_align']         = 'left';
	}

	if ( $layout === 'center' ) {
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 12,
			'x'        => 0,
			'settings' => [
				'align' => 'center',
			],
		];
		$builder['desktop']['bottom']['primary-menu']  = [
			'id'       => 'primary-menu',
			'width'    => 12,
			'x'        => 0,
			'settings' => [
				'align' => 'center',
			],
		];
		$components['primary-menu']['component_align'] = 'center';
		$components['logo']['component_align']         = 'center';
	}

	if ( $layout === 'right' ) {
		$builder['desktop']['main']['primary-menu']    = [
			'id'       => 'primary-menu',
			'width'    => 8,
			'settings' => [
				'align' => 'left',
			],
			'x'        => 0,
		];
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 4,
			'settings' => [
				'align' => 'right',
			],
			'x'        => 8,
		];
		$components['primary-menu']['component_align'] = 'left';
		$components['logo']['component_align']         = 'right';
	}
	$builder['mobile']['main']['logo']            = [
		'id'    => 'logo',
		'width' => 8,
		'x'     => 0,
	];
	$builder['mobile']['main']['nav-icon']        = [
		'id'    => 'nav-icon',
		'width' => 4,
		'x'     => 8,
	];
	$builder['mobile']['sidebar']['primary-menu'] = [
		'id'    => 'primary-menu',
		'width' => 8,
		'x'     => 0,
	];
	$components['nav-icon']['component_align']    = 'right';

	return [
		'builder'    => $builder,
		'components' => $components,
	];
}

/**
 * Define migration logic for footer.
 *
 * @return array Migration schema.
 */
function solace_hfg_legacy_footer_settings() {
	$builder    = [
		'desktop' => [
			'top'    => [],
			'main'   => [],
			'bottom' => [],
		]
	];
	$components = [];
	if ( (bool) get_theme_mod( 'solace_top_bar_enable', false ) ) {
		$alignament = get_theme_mod( 'solace_top_bar_layout', 'content-menu' );
		if ( $alignament === 'content-menu' ) {
			$builder['desktop']['top']['custom_html']    = [
				'id'    => 'custom_html',
				'width' => 6,
				'x'     => 0,
			];
			$builder['desktop']['top']['secondary-menu'] = [
				'id'    => 'secondary-menu',
				'width' => 6,
				'x'     => 6,
			];

			$components['custom_html']['component_align']    = 'left';
			$components['secondary-menu']['component_align'] = 'right';

		}
		if ( $alignament === 'menu-content' ) {
			$builder['desktop']['top']['secondary-menu']     = [
				'id'    => 'secondary-menu',
				'width' => 6,
				'x'     => 0,
			];
			$builder['desktop']['top']['custom_html']        = [
				'id'    => 'custom_html',
				'width' => 6,
				'x'     => 6,
			];
			$components['custom_html']['component_align']    = 'right';
			$components['secondary-menu']['component_align'] = 'left';
		}
	}

	$layout = get_theme_mod( 'solace_navigation_layout', 'left' );

	if ( $layout === 'left' ) {
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 4,
			'x'        => 0,
			'settings' => [
				'align' => 'left',
			],
		];
		$builder['desktop']['main']['primary-menu']    = [
			'id'       => 'primary-menu',
			'settings' => [
				'align' => 'right',
			],
			'width'    => 8,
			'x'        => 4,
		];
		$components['primary-menu']['component_align'] = 'right';
		$components['logo']['component_align']         = 'left';
	}

	if ( $layout === 'center' ) {
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 12,
			'x'        => 0,
			'settings' => [
				'align' => 'center',
			],
		];
		$builder['desktop']['bottom']['primary-menu']  = [
			'id'       => 'primary-menu',
			'width'    => 12,
			'x'        => 0,
			'settings' => [
				'align' => 'center',
			],
		];
		$components['primary-menu']['component_align'] = 'center';
		$components['logo']['component_align']         = 'center';
	}

	if ( $layout === 'right' ) {
		$builder['desktop']['main']['primary-menu']    = [
			'id'       => 'primary-menu',
			'width'    => 8,
			'settings' => [
				'align' => 'left',
			],
			'x'        => 0,
		];
		$builder['desktop']['main']['logo']            = [
			'id'       => 'logo',
			'width'    => 4,
			'settings' => [
				'align' => 'right',
			],
			'x'        => 8,
		];
		$components['primary-menu']['component_align'] = 'left';
		$components['logo']['component_align']         = 'right';
	}
	$builder['mobile']['main']['logo']            = [
		'id'    => 'logo',
		'width' => 8,
		'x'     => 0,
	];
	$builder['mobile']['main']['nav-icon']        = [
		'id'    => 'nav-icon',
		'width' => 4,
		'x'     => 8,
	];
	$builder['mobile']['sidebar']['primary-menu'] = [
		'id'    => 'primary-menu',
		'width' => 8,
		'x'     => 0,
	];
	$components['nav-icon']['component_align']    = 'right';

	return [
		'builder'    => $builder,
		'components' => $components,
	];
}

add_filter(
	'hfg_settings_schema',
	function ( $old_schema ) {
		$is_new_builder = solace_is_new_builder();
		$header         = $is_new_builder ? solace_hfg_header_settings() : solace_hfg_legacy_header_settings();
		$footer         = $is_new_builder ? solace_hfg_footer_settings() : solace_hfg_legacy_footer_settings();

		$empty_row   = [
			'left'    => [],
			'c-left'  => [],
			'center'  => [],
			'c-right' => [],
			'right'   => [],
		];
		$page_header = $is_new_builder ?
			[
				'desktop' => [
					'top'    => $empty_row,
					'bottom' => $empty_row,
				],
				'mobile'  => [
					'top'    => $empty_row,
					'bottom' => $empty_row,
				],
			]
			:
			[
				'desktop' => [
					'top'    => [],
					'bottom' => [],
				],
				'mobile'  => [
					'top'    => [],
					'bottom' => [],
				],
			];

		$components = array_merge( $header['components'], $footer['components'] );
		$defaults   = [];
		foreach ( $components as $id => $settings ) {
			foreach ( $settings as $setting_id => $value ) {
				$defaults[ $id . '_' . $setting_id ] = $value;
			}
		}

		if ( $is_new_builder ) {
			return array_merge(
				[
					'hfg_header_layout_v2'      => wp_json_encode( $header['builder'] ),
					'hfg_footer_layout_v2'      => wp_json_encode( $footer['builder'] ),
					'hfg_page_header_layout_v2' => wp_json_encode( $page_header ),
				],
				$defaults
			);
		};

		return array_merge(
			[
				'hfg_header_layout'      => wp_json_encode( $header['builder'] ),
				'hfg_footer_layout'      => wp_json_encode( $footer['builder'] ),
				'hfg_page_header_layout' => wp_json_encode( $page_header ),
			],
			$defaults
		);

	},
	101
);


/**
 * Add class to page header menu.
 *
 * @param array $args Nav menu args.
 *
 * @return array
 */
function solace_add_page_header_menu_classes( $args ) {
	if ( $args['theme_location'] !== 'page-header' ) {
		return $args;
	}

	$args['menu_class'] .= ' nav-ul';

	return $args;
}

add_filter( 'wp_nav_menu_args', 'solace_add_page_header_menu_classes', 10, 4 );
