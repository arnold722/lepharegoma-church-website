<?php
/**
 * Style generator based on settings.
 *
 * @package Solace\Core\Styles
 */

namespace Solace\Core\Styles;

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;

/**
 * Class Generator for Gutenberg editor.
 *
 * @package Solace\Core\Styles
 */
class Gutenberg extends Generator {
	use Css_Vars;

	/**
	 * Generator constructor.
	 */
	public function __construct() {
		$this->context = Dynamic_Selector::CONTEXT_GUTENBERG;
		$this->setup_buttons();
		$this->setup_typeface_title();
		$this->setup_post_meta();
		$this->setup_card_options_add_to_cart();
		$this->setup_card_options_excerpt();
		$this->setup_card_options_star_rating();
		$this->setup_card_options_price();
		$this->setup_card_options_categories();
		$this->setup_card_options_title();
		$this->setup_card_options_product_image();
		$this->setup_typography();
		// $this->print_dynamic_styles();
		$this->setup_single_post_featured_image();
		$this->add_editor_color_palette_styles();
	}

	/**
	 * Setup typeface_title subscribers.
	 */
	public function setup_typeface_title() {
		$rules                = $this->get_typeface_title_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Setup typeface_title subscribers.
	 */
	public function setup_post_meta() {
		$rules                = $this->get_post_meta_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Setup card_options_add_to_cart subscribers.
	 */
	public function setup_card_options_add_to_cart() {
		$rules                = $this->get_card_options_add_to_cart_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}	

	/**
	 * Setup card_options_excerpt subscribers.
	 */
	public function setup_card_options_excerpt() {
		$rules                = $this->get_card_options_excerpt_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}	

	/**
	 * Setup card_options_star_rating subscribers.
	 */
	public function setup_card_options_star_rating() {
		$rules                = $this->get_card_options_star_rating_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}	

	/**
	 * Setup card_options_price subscribers.
	 */
	public function setup_card_options_price() {
		$rules                = $this->get_card_options_price_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}	

	/**
	 * Setup card_options_categories subscribers.
	 */
	public function setup_card_options_categories() {
		$rules                = $this->get_card_options_categories_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}		

	/**
	 * Setup card_options_title subscribers.
	 */
	public function setup_card_options_title() {
		$rules                = $this->get_card_options_title_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}		

	/**
	 * Setup card_options_product_image subscribers.
	 */
	public function setup_card_options_product_image() {
		$rules                = $this->get_card_options_product_image_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}	

	/**
	 * Setup typography subscribers.
	 */
	public function setup_typography() {
		if ( ! solace_is_new_skin() ) {
			$this->setup_legacy_typography();

			return;
		}

		$rules                = $this->get_typography_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Setup single post featured image subscribers.
	 */
	public function setup_single_post_featured_image() {
		// if ( ! solace_is_new_skin() ) {
		// 	$this->setup_legacy_typography();

		// 	return;
		// }

		$rules                = $this->get_single_post_featured_image_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Setup button subscribers.
	 */
	public function setup_buttons() {
		if ( ! solace_is_new_skin() ) {
			$this->setup_legacy_buttons();

			return;
		}

		$rules                = $this->get_button_rules();
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => ':root',
			Dynamic_Selector::KEY_RULES    => $rules,
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Adds colors from the editor-color-palette theme support.
	 */
	private function add_editor_color_palette_styles() {
		$is_new_user           = get_option( 'solace_new_user' );
		$imported_starter_site = get_option( 'solace_imported_demo' );
		if ( $is_new_user === 'yes' && $imported_starter_site !== 'yes' ) {
			return;
		}

		$this->_subscribers['.has-solace-button-color-color']            = [
			Config::CSS_PROP_COLOR => [
				Dynamic_Selector::META_KEY       => Config::MODS_BUTTON_PRIMARY_STYLE . '.background',
				Dynamic_Selector::META_IMPORTANT => true,
				Dynamic_Selector::META_DEFAULT   => 'var(--sol-color-link-button-initial)',
				Dynamic_Selector::KEY_CONTEXT    => [
					Dynamic_Selector::CONTEXT_GUTENBERG => true,
				],
			],
		];
		$this->_subscribers['.has-solace-button-color-background-color'] = [
			Config::CSS_PROP_BACKGROUND_COLOR => [
				Dynamic_Selector::META_KEY       => Config::MODS_BUTTON_PRIMARY_STYLE . '.background',
				Dynamic_Selector::META_IMPORTANT => true,
				Dynamic_Selector::META_DEFAULT   => 'var(--sol-color-link-button-initial)',
				Dynamic_Selector::KEY_CONTEXT    => [
					Dynamic_Selector::CONTEXT_GUTENBERG => true,
				],
			],
		];
	}

	/**
	 * Setup legacy buttons selectors.
	 */
	private function setup_legacy_buttons() {
		// Gutenberg
		$this->_subscribers[]  = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-primary .wp-block-button__link, .wc-block-grid .wp-block-button .wp-block-button__link',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => Config::MODS_BUTTON_PRIMARY_STYLE . '.background',
				Config::CSS_PROP_COLOR            => Config::MODS_BUTTON_PRIMARY_STYLE . '.text',
				Config::CSS_PROP_BORDER_RADIUS    => Config::MODS_BUTTON_PRIMARY_STYLE . '.borderRadius',
				Config::CSS_PROP_CUSTOM_BTN_TYPE  => Config::MODS_BUTTON_PRIMARY_STYLE . '.type',
				Config::CSS_PROP_BORDER_WIDTH     => Config::MODS_BUTTON_PRIMARY_STYLE . '.borderWidth',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers[]  = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-primary .wp-block-button__link:hover, .wc-block-grid .wp-block-button .wp-block-button__link:hover',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => Config::MODS_BUTTON_PRIMARY_STYLE . '.backgroundHover',
				Config::CSS_PROP_COLOR            => Config::MODS_BUTTON_PRIMARY_STYLE . '.textHover',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers [] = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-secondary .wp-block-button__link',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => Config::MODS_BUTTON_SECONDARY_STYLE . '.background',
				Config::CSS_PROP_COLOR            => Config::MODS_BUTTON_SECONDARY_STYLE . '.text',
				Config::CSS_PROP_BORDER_RADIUS    => Config::MODS_BUTTON_SECONDARY_STYLE . '.borderRadius',
				Config::CSS_PROP_CUSTOM_BTN_TYPE  => Config::MODS_BUTTON_SECONDARY_STYLE . '.type',
				Config::CSS_PROP_BORDER_WIDTH     => Config::MODS_BUTTON_SECONDARY_STYLE . '.borderWidth',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers[]  = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-secondary .wp-block-button__link:hover',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => Config::MODS_BUTTON_SECONDARY_STYLE . '.backgroundHover',
				Config::CSS_PROP_COLOR            => Config::MODS_BUTTON_SECONDARY_STYLE . '.textHover',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers[]  = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-primary .wp-block-button__link,  .wc-block-grid .wp-block-button .wp-block-button__link',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_PADDING        => [
					Dynamic_Selector::META_KEY           => Config::MODS_BUTTON_PRIMARY_PADDING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
				Config::CSS_PROP_FONT_SIZE      => [
					Dynamic_Selector::META_KEY           => Config::MODS_BUTTON_TYPEFACE . '.fontSize',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'em',
				],
				Config::CSS_PROP_LINE_HEIGHT    => [
					Dynamic_Selector::META_KEY           => Config::MODS_BUTTON_TYPEFACE . '.lineHeight',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => '',
				],
				Config::CSS_PROP_LETTER_SPACING => [
					Dynamic_Selector::META_KEY           => Config::MODS_BUTTON_TYPEFACE . '.letterSpacing',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
				Config::CSS_PROP_FONT_WEIGHT    => [
					Dynamic_Selector::META_KEY => Config::MODS_BUTTON_TYPEFACE . '.fontWeight',
					'font'                     => 'mods_' . Config::MODS_FONT_GENERAL,
				],
				Config::CSS_PROP_TEXT_TRANSFORM => Config::MODS_BUTTON_TYPEFACE . '.textTransform',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers[]  = [
			Dynamic_Selector::KEY_SELECTOR => '.wp-block-button.is-style-secondary .wp-block-button__link',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_PADDING        => [
					Dynamic_Selector::META_KEY           => Config::MODS_BUTTON_SECONDARY_PADDING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
				Config::CSS_PROP_FONT_SIZE      => [
					Dynamic_Selector::META_KEY           => Config::MODS_SECONDARY_BUTTON_TYPEFACE . '.fontSize',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'em',
				],
				Config::CSS_PROP_LINE_HEIGHT    => [
					Dynamic_Selector::META_KEY           => Config::MODS_SECONDARY_BUTTON_TYPEFACE . '.lineHeight',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => '',
				],
				Config::CSS_PROP_LETTER_SPACING => [
					Dynamic_Selector::META_KEY           => Config::MODS_SECONDARY_BUTTON_TYPEFACE . '.letterSpacing',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
				Config::CSS_PROP_FONT_WEIGHT    => [
					Dynamic_Selector::META_KEY => Config::MODS_SECONDARY_BUTTON_TYPEFACE . '.fontWeight',
					'font'                     => 'mods_' . Config::MODS_FONT_GENERAL,
				],
				Config::CSS_PROP_TEXT_TRANSFORM => Config::MODS_SECONDARY_BUTTON_TYPEFACE . '.textTransform',
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
	}

	/**
	 * Setup legacy typography.
	 */
	private function setup_legacy_typography() {
		// Gutenberg Typography.
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => '.editor-post-title__block .editor-post-title__input,
			.wp-block h1, h1.wp-block
			.wp-block h2, h2.wp-block
			.wp-block h3, h3.wp-block
			.wp-block h4, h4.wp-block
			.wp-block h5, h5.wp-block
			.wp-block h6, h6.wp-block',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FONT_FAMILY => Config::MODS_FONT_HEADINGS,
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => '.editor-styles-wrapper',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FONT_FAMILY => [
					Dynamic_Selector::META_KEY     => Config::MODS_FONT_GENERAL,
					Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL ),
				],
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];

		$this->_subscribers[] = [
			Dynamic_Selector::KEY_SELECTOR => '  .wp-block,
			 [data-type="core/paragraph"] p',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FONT_SIZE      => [
					Dynamic_Selector::META_KEY           => Config::MODS_TYPEFACE_GENERAL . '.fontSize',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => 'px',
				],
				Config::CSS_PROP_LINE_HEIGHT    => [
					Dynamic_Selector::META_KEY           => Config::MODS_TYPEFACE_GENERAL . '.lineHeight',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_SUFFIX        => '',
				],
				Config::CSS_PROP_LETTER_SPACING => [
					Dynamic_Selector::META_KEY           => Config::MODS_TYPEFACE_GENERAL . '.letterSpacing',
					Dynamic_Selector::META_IS_RESPONSIVE => true,
				],
				Config::CSS_PROP_FONT_WEIGHT    => [
					Dynamic_Selector::META_KEY => Config::MODS_TYPEFACE_GENERAL . '.fontWeight',
					'font'                     => 'mods_' . Config::MODS_FONT_GENERAL,
				],
				Config::CSS_PROP_TEXT_TRANSFORM => Config::MODS_TYPEFACE_GENERAL . '.textTransform',
				Config::CSS_PROP_FONT_FAMILY    => [
					Dynamic_Selector::META_KEY     => Config::MODS_FONT_GENERAL,
					Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL ),
				],
			],
			Dynamic_Selector::KEY_CONTEXT  => [
				Dynamic_Selector::CONTEXT_GUTENBERG => true,
			],
		];
		foreach (
			[
				'solace_h1_typeface_general' => '
			 .wp-block h1, h1.wp-block,
			 .editor-post-title__block .editor-post-title__input',
				'solace_h2_typeface_general' => ' .wp-block h2, h2.wp-block',
				'solace_h3_typeface_general' => '.wp-block h3, h3.wp-block',
				'solace_h4_typeface_general' => '.wp-block h4, h4.wp-block',
				'solace_h5_typeface_general' => '.wp-block h5, h5.wp-block',
				'solace_h6_typeface_general' => '.wp-block h6, h6.wp-block',
			] as $heading_mod => $heading_selector
		) {

			$this->_subscribers[] = [
				Dynamic_Selector::KEY_RULES    => [
					Config::CSS_PROP_FONT_SIZE      => [
						Dynamic_Selector::META_KEY    => $heading_mod . '.fontSize',
						Dynamic_Selector::META_IS_RESPONSIVE => true,
						Dynamic_Selector::META_SUFFIX => 'em',
					],
					Config::CSS_PROP_LINE_HEIGHT    => [
						Dynamic_Selector::META_KEY    => $heading_mod . '.lineHeight',
						Dynamic_Selector::META_IS_RESPONSIVE => true,
						Dynamic_Selector::META_SUFFIX => '',
					],
					Config::CSS_PROP_LETTER_SPACING => [
						Dynamic_Selector::META_KEY    => $heading_mod . '.letterSpacing',
						Dynamic_Selector::META_SUFFIX => 'px',
						Dynamic_Selector::META_IS_RESPONSIVE => true,
					],
					Config::CSS_PROP_FONT_WEIGHT    => [
						Dynamic_Selector::META_KEY => $heading_mod . '.fontWeight',
						'font'                     => 'mods_' . Config::MODS_FONT_HEADINGS,
					],
					Config::CSS_PROP_TEXT_TRANSFORM => $heading_mod . '.textTransform',
					Config::CSS_PROP_FONT_FAMILY    => Config::MODS_FONT_HEADINGS,
				],
				Dynamic_Selector::KEY_SELECTOR => $heading_selector,
				Dynamic_Selector::KEY_CONTEXT  => [
					Dynamic_Selector::CONTEXT_GUTENBERG => true,
				],
			];
		}
	}
}
