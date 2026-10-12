<?php

namespace Solace\Core\Settings;

use Solace\Core\Settings\Config;

class Customizer_Defaults {

	private static $settings = [
		Config::MODS_PRODUCT_PAGE_LABEL_SHOP_SETTINGS => [
			'name'  => Config::MODS_PRODUCT_PAGE_LABEL_SHOP_SETTINGS,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT => [
			'name'  => Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT,
			'value' => 'product-page-layout1',
		],
		Config::MODS_PRODUCT_PAGE_LABEL_COLUMN_AND_ROW => [
			'name'  => Config::MODS_PRODUCT_PAGE_LABEL_COLUMN_AND_ROW,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW => [
			'name'  => Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW,
			'value' => [
				'minColumn'    => 1,
				'valueColumn'  => 3,
				'maxColumn'    => 5,
				'stepColumn'   => 1,
				'minRow'       => 1,
				'valueRow'     => 4,
				'maxRow'       => 10,
				'stepRow'      => 1			
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART,
			'value' => [
				'autoHide'        => false,
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT,
			'value' => [
				'length'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 40,
					'tablet'  => 40,
					'desktop' => 40,
				],
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES,
			'value' => [
				'separator'        => 'separator1',
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE,
			'value' => [
				'headingTag'	 => 'H5',
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 8,
					'tablet'  => 8,
					'desktop' => 8,
				],
			],
		],		
		Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE => [
			'name'  => Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE,
			'value' => [
				'imageRatio'          => 'imageRatio1',
				'imageSizeOriginal'   => 'Woocommerce Thumbnail (300x300)',
				'imageSizePredefined' => 'woocommerce_thumbnail',
				'imageSizeCustom'     => 400,
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_PRODUCT_PAGE_LABEL_PAGE_ELEMENTS => [
			'name'  => Config::MODS_PRODUCT_PAGE_LABEL_PAGE_ELEMENTS,
			'value' => null,
		],		
		Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING => [
			'name'  => Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING,
			'value' => true,
		],		
		Config::MODS_PRODUCT_PAGE_PAGINATION => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION,
			'value' => null,
		],		
		Config::MODS_PRODUCT_PAGE_sidebar => [
			'name'  => Config::MODS_PRODUCT_PAGE_sidebar,
			'value' => null,
		],		
		Config::MODS_PRODUCT_PAGE_LOOP_IMAGES => [
			'name'  => Config::MODS_PRODUCT_PAGE_LOOP_IMAGES,
			'value' => true,
		],
		Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS => [
			'name'  => Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR => [
			'name'  => Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR,
			'value' => false,
		],
		Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT => [
			'name'  => Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT,
			'value' => 'product-page-sidebar-left',
		],
		Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION => [
			'name'  => Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION,
			'value' => true,
		],
		Config::MODS_PRODUCT_PAGE_LABEL_PAGINATION_TYPE => [
			'name'  => Config::MODS_PRODUCT_PAGE_LABEL_PAGINATION_TYPE,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE,
			'value' => 'pagination-standard',
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR,
			'value' => 'var(--sol-color-link-button-initial)',
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR_ACTIVE => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_COLOR_ACTIVE,
			'value' => 'var(--sol-color-background)',
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_BG => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_BG,
			'value' => 'var(--sol-color-button-initial)',
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_BORDER_RADIUS => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_BORDER_RADIUS,
			'value' => 4,
		],
		Config::MODS_PRODUCT_PAGE_PAGINATION_SPACING => [
			'name'  => Config::MODS_PRODUCT_PAGE_PAGINATION_SPACING,
			'value' => 10,
		],
		Config::MODS_PRODUCT_PAGE_LABEL_FEATURED_IMAGES => [
			'name'  => Config::MODS_PRODUCT_PAGE_LABEL_FEATURED_IMAGES,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1 => [
			'name'  => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2 => [
			'name'  => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2,
			'value' => null,
		],
		Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3 => [
			'name'  => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3,
			'value' => null,
		],
		Config::MODS_SINGLE_PRODUCT_LABEL_PAGE_LAYOUT => [
			'name'  => Config::MODS_SINGLE_PRODUCT_LABEL_PAGE_LAYOUT,
			'value' => null,
		],
		Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT,
			'value' => 'single-product-layout-left',
		],
		Config::MODS_SINGLE_PRODUCT_OPTIONS => [
			'name'  => Config::MODS_SINGLE_PRODUCT_OPTIONS,
			'value' => null,
		],
		Config::MODS_SINGLE_PRODUCT_ELEMENTS => [
			'name'  => Config::MODS_SINGLE_PRODUCT_ELEMENTS,
			'value' => null,
		],
		Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY => [
			'name'  => Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY,
			'value' => 'single-product-layout-gallery1',
		],
		Config::MODS_SINGLE_PRODUCT_IMAGE_WIDTH => [
			'name'  => Config::MODS_SINGLE_PRODUCT_IMAGE_WIDTH,
			'value' => 150,
		],
		Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX => [
			'name'  => Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX,
			'value' => true,
		],
		Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM => [
			'name'  => Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM,
			'value' => true,
		],
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS,
			'value' => null,
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_BREADCRUMBS => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_BREADCRUMBS,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE,
			'value' => [
				'headingTag'	  => 'H1',
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],			
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_STAR_RATING => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_STAR_RATING,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PRICE => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PRICE,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_SHORT_DESCRIPTION => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_SHORT_DESCRIPTION,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER1 => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER1,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],			
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART,
			'value' => [
				'title'	  	    => 'Add to cart',
				'buttonWidth'   => [
					'suffix'  	  => [
						'mobile'  => '%',
						'tablet'  => '%',
						'desktop' => '%',
					],
					'mobile'  => 89,
					'tablet'  => 89,
					'desktop' => 89,
				],
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER2 => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER2,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_META => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_META,
			'value' => [
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS,
			'value' => [
				'title'   => 'Guaranteed Safe Checkout',
				'ordering'   => [
					'Mastercard', 
					'Visa', 
					'Amex', 
					'Discover', 
					'Paypal', 
				],
				'iconSize'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 30,
					'tablet'  => 30,
					'desktop' => 30,
				],
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO,
			'value' => [
				'title'   => 'Extra Features',
				'ordering'   => [
					'Premium Quality', 
					'Secure Payments', 
					'Satisfaction Guarantee', 
					'Worldwide Shipping', 
					'Money Back Guarantee', 
				],
				'bottomSpacing'   => [
					'suffix'  	  => [
						'mobile'  => 'px',
						'tablet'  => 'px',
						'desktop' => 'px',
					],
					'mobile'  => 16,
					'tablet'  => 16,
					'desktop' => 16,
				],
			],
		],		
		Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER => [
			'name'  => Config::MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER,
			'value' => true,
		],		
	];

	// Get control name by key.
	public static function get_control_name($key) {
		return self::$settings[$key]['name'] ?? null;
	}

	// Get default value by key.
	public static function get_default_value($key) {
		return self::$settings[$key]['value'] ?? null;
	}

	// Get all controls with default values.
	public static function get_all_controls_with_defaults() {
		$controls = [];
		foreach (self::$settings as $key => $setting) {
			$controls[$setting['name']] = $setting['value'];
		}
		return $controls;
	}

}
