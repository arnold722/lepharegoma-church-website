<?php
/**
 * CSS Variables trait
 */

namespace Solace\Core\Styles;

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Settings\Customizer_Defaults;

/**
 * Trait Css_Vars
 *
 * @since 3.0.0
 */
trait Css_Vars {
	/**
	 * Get container rules.
	 *
	 * @return array[]
	 */
	public function get_container_rules() {
		return [
			'--container' => [
				Dynamic_Selector::META_KEY           => Config::MODS_CONTAINER_WIDTH,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => '{ "mobile": 748, "tablet": 992, "desktop": 1280 }',
			],
			'--container-page' => [
				Dynamic_Selector::META_KEY           => Config::MODS_CONTAINER_PAGE_WIDTH,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => '{ "mobile": 748, "tablet": 992, "desktop": 1280 }',
			],
			'--container-post' => [
				Dynamic_Selector::META_KEY           => Config::MODS_CONTAINER_POST_WIDTH,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => '{ "mobile": 748, "tablet": 992, "desktop": 1280 }',
			],
		];
	}

	/**
	 * Get button rules.
	 *
	 * @return array
	 */
	public function get_button_rules() {
		$mod_key_primary   = Config::MODS_BUTTON_PRIMARY_STYLE;
		$default_primary   = solace_get_button_appearance_default();
		$mod_key_secondary = Config::MODS_BUTTON_SECONDARY_STYLE;
		$default_secondary = solace_get_button_appearance_default( 'secondary' );

		$rules = [
			'--primarybtnbg'             => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.background',
			],
			'--secondarybtnbg'           => [
				Dynamic_Selector::META_KEY => $mod_key_secondary . '.background',
			],
			'--primarybtnhoverbg'        => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.backgroundHover',
			],
			'--secondarybtnhoverbg'      => [
				Dynamic_Selector::META_KEY => $mod_key_secondary . '.backgroundHover',
			],
			'--primarybtncolor'          => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.text',
			],
			'--secondarybtncolor'        => [
				Dynamic_Selector::META_KEY => $mod_key_secondary . '.text',
			],
			'--primarybtnhovercolor'     => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.textHover',
			],
			'--secondarybtnhovercolor'   => [
				Dynamic_Selector::META_KEY => $mod_key_secondary . '.textHover',
			],
			'--primarybtnborderradius'   => [
				Dynamic_Selector::META_KEY    => $mod_key_primary . '.borderRadius',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_BORDER_RADIUS,
			],
			'--secondarybtnborderradius' => [
				Dynamic_Selector::META_KEY    => $mod_key_secondary . '.borderRadius',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_BORDER_RADIUS,
			],
			'--bordercolor'          => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.borderColor',
			],			
			'--borderhovercolor'          => [
				Dynamic_Selector::META_KEY => $mod_key_primary . '.borderHoverColor',
			],			
			'--width' => [
				Dynamic_Selector::META_KEY    => $mod_key_secondary . '.width',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_WIDTH,
			],
			'--borderwidth' => [
				Dynamic_Selector::META_KEY    => $mod_key_primary . '.borderWidth',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_BORDER_WIDTH,
			],
		];

		$primary_values   = get_theme_mod( $mod_key_primary, $default_primary );
		$secondary_values = get_theme_mod( $mod_key_secondary, $default_secondary );

		// Button Shadow Primary
		if ( isset( $primary_values['useShadow'] ) && ! empty( $primary_values['useShadow'] ) ) {
			$rules['--primarybtnshadow'] = [
				Dynamic_Selector::META_KEY    => $mod_key_primary . '.shadowColor',
				Dynamic_Selector::META_DEFAULT       => 'none',
				Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) use ($primary_values) {
					$blur   = intval($primary_values['shadowProperties']['blur']);
					$width  = intval($primary_values['shadowProperties']['width']);
					$height = intval($primary_values['shadowProperties']['height']);

					return sprintf( '%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value ) );
				}
			];
		}

		// Button Shadow Primary Hover
		if ( isset( $primary_values['useShadowHover'] ) && ! empty( $primary_values['useShadowHover'] ) ) {
			$rules['--primarybtnhovershadow'] = [
				Dynamic_Selector::META_KEY    => $mod_key_primary . '.shadowColorHover',
				Dynamic_Selector::META_DEFAULT       => 'none',
				Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) use ($primary_values) {
					$blur   = intval($primary_values['shadowPropertiesHover']['blur']);
					$width  = intval($primary_values['shadowPropertiesHover']['width']);
					$height = intval($primary_values['shadowPropertiesHover']['height']);

					return sprintf( '%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value ) );
				}
			];
		}

		// Button Shadow Secondary
		if ( isset( $secondary_values['useShadow'] ) && ! empty( $secondary_values['useShadow'] ) ) {
			$rules['--secondarybtnshadow'] = [
				Dynamic_Selector::META_KEY    => $mod_key_secondary . '.shadowColor',
				Dynamic_Selector::META_DEFAULT       => 'none',
				Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) use ($secondary_values) {
					$blur   = intval($secondary_values['shadowProperties']['blur']);
					$width  = intval($secondary_values['shadowProperties']['width']);
					$height = intval($secondary_values['shadowProperties']['height']);

					return sprintf( '%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value ) );
				}
			];
		}

		// Button Shadow Secondary Hover
		if ( isset( $secondary_values['useShadowHover'] ) && ! empty( $secondary_values['useShadowHover'] ) ) {
			$rules['--secondarybtnhovershadow'] = [
				Dynamic_Selector::META_KEY    => $mod_key_secondary . '.shadowColorHover',
				Dynamic_Selector::META_DEFAULT       => 'none',
				Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) use ($secondary_values) {
					$blur   = intval($secondary_values['shadowPropertiesHover']['blur']);
					$width  = intval($secondary_values['shadowPropertiesHover']['width']);
					$height = intval($secondary_values['shadowPropertiesHover']['height']);

					return sprintf( '%s:%s;', $css_prop, sprintf('%spx %spx %spx %s;', $width, $height, $blur, $value ) );
				}
			];
		}

		// Border Width
		if ( isset( $primary_values['type'] ) && $primary_values['type'] === 'outline' ) {
			$rules['--primarybtnborderwidth'] = [
				Dynamic_Selector::META_KEY    => $mod_key_primary . '.borderWidth',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_BORDER_WIDTH,
			];
		}
		if ( isset( $secondary_values['type'] ) && $secondary_values['type'] === 'outline' ) {
			$rules['--secondarybtnborderwidth'] = [
				Dynamic_Selector::META_KEY    => $mod_key_secondary . '.borderWidth',
				Dynamic_Selector::META_SUFFIX => 'px',
				'directional-prop'            => Config::CSS_PROP_BORDER_WIDTH,
			];
		}

		$mod_key_primary       = Config::MODS_BUTTON_PRIMARY_PADDING;
		$default_primary       = Mods::get_alternative_mod_default( Config::MODS_BUTTON_PRIMARY_PADDING );

		$rules['--btnpadding'] = [
			Dynamic_Selector::META_KEY           => $mod_key_primary,
			Dynamic_Selector::META_DEFAULT       => $default_primary,
			Dynamic_Selector::META_IS_RESPONSIVE => true,
			Dynamic_Selector::META_SUFFIX => 'responsive_unit',
			Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
				$mod_key_primary = Config::MODS_BUTTON_PRIMARY_STYLE;
				$default_primary = solace_get_button_appearance_default();

				$mod_key_secondary = Config::MODS_BUTTON_SECONDARY_STYLE;
				$default_secondary = solace_get_button_appearance_default( 'secondary' );

				$values   = [
					'primary'   => get_theme_mod( $mod_key_primary, $default_primary ),
					'secondary' => get_theme_mod( $mod_key_secondary, $default_secondary ),
				];
				$paddings = [
					'primary'   => $value,
					'secondary' => $value,
				];
				foreach ( $values as $btn_type => $appearance_values ) {
					if ( ! isset( $appearance_values['type'] ) || $appearance_values['type'] !== 'outline' ) {
						continue;
					}
					$border_width = $appearance_values['borderWidth'];

					foreach ( $paddings[ $btn_type ] as $direction => $padding_value ) {
						if ( ! isset( $border_width[ $direction ] ) || absint( $border_width[ $direction ] ) === 0 ) {
							continue;
						}
						if(  ! is_numeric( $padding_value ) ){
							continue;
						}
						$paddings[ $btn_type ][ $direction ] = $padding_value - $border_width[ $direction ];
					}
				}
				$final_value_default   = Css_Prop::transform_directional_prop( $meta, $device, $value, '--btnpadding', Config::CSS_PROP_PADDING );
				$final_value_primary   = Css_Prop::transform_directional_prop( $meta, $device, $paddings['primary'], '--primarybtnpadding', Config::CSS_PROP_PADDING );
				$final_value_secondary = Css_Prop::transform_directional_prop( $meta, $device, $paddings['secondary'], '--secondarybtnpadding', Config::CSS_PROP_PADDING );

				return $final_value_default . $final_value_primary . $final_value_secondary;
			},
			'directional-prop'                   => Config::CSS_PROP_PADDING,
		];

		$mod_key_primary             = Config::MODS_BUTTON_TYPEFACE;
		$rules['--btnfs']            = [
			Dynamic_Selector::META_KEY           => $mod_key_primary . '.fontSize',
			Dynamic_Selector::META_IS_RESPONSIVE => true,
		];
		$rules['--btnlineheight']    = [
			Dynamic_Selector::META_KEY           => $mod_key_primary . '.lineHeight',
			Dynamic_Selector::META_IS_RESPONSIVE => true,
		];
		$rules['--btnletterspacing'] = [
			Dynamic_Selector::META_KEY           => $mod_key_primary . '.letterSpacing',
			Dynamic_Selector::META_IS_RESPONSIVE => true,
			Dynamic_Selector::META_SUFFIX        => 'px',
		];
		$rules['--btntexttransform'] = [
			Dynamic_Selector::META_KEY           => $mod_key_primary . '.textTransform',
			Dynamic_Selector::META_IS_RESPONSIVE => false,
		];
		$rules['--btnfontweight']    = [
			Dynamic_Selector::META_KEY => $mod_key_primary . '.fontWeight',
		];

		return $rules;
	}

	/**
	 * Get typeface title rules.
	 *
	 * @retun array
	 */
	public function get_typeface_title_rules() {
		$default = Mods::get_alternative_mod_default( Config::MODS_BLOG_POST_DESIGN_TITLE );
		$mod_key = Config::MODS_BLOG_POST_DESIGN_TITLE;

		$rules = [
			'--single-title-fontsize'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--single-title-heading'     => [
				Dynamic_Selector::META_KEY     => $mod_key . '.headingTag',
				Dynamic_Selector::META_DEFAULT => $default['headingTag'],
				// 'font'                         => 'mods_' . Config::MODS_FONT_HEADINGS,
			],
		];

		return $rules;
	}

	/**
	 * Get card_options_add_to_cart rules.
	 *
	 * @retun array
	 */
	public function get_card_options_add_to_cart_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART;

		$rules = [
			'--wc-card-options-auto-hide'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.autoHide',
				Dynamic_Selector::META_DEFAULT       => $default['autoHide'],
			],				
			'--wc-card-options-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}	

	/**
	 * Get card_options_excerpt rules.
	 *
	 * @retun array
	 */
	public function get_card_options_excerpt_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT;

		$rules = [
			'--wc-card-options-excerpt-length'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.length',
				Dynamic_Selector::META_DEFAULT       => $default['length'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
			'--wc-card-options-excerpt-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}	

	/**
	 * Get card_options_star_rating rules.
	 *
	 * @retun array
	 */
	public function get_card_options_star_rating_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING;

		$rules = [
			'--wc-card-options-star-rating-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}	

	/**
	 * Get card_options_price rules.
	 *
	 * @retun array
	 */
	public function get_card_options_price_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE;

		$rules = [
			'--wc-card-options-price-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}	

	/**
	 * Get card_options_categories rules.
	 *
	 * @retun array
	 */
	public function get_card_options_categories_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES;

		$rules = [
			'--wc-card-options-categories-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}		

	/**
	 * Get card_options_title rules.
	 *
	 * @retun array
	 */
	public function get_card_options_title_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE;

		$rules = [
			'--wc-card-options-title-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}		

	/**
	 * Get card_options_product_image rules.
	 *
	 * @retun array
	 */
	public function get_card_options_product_image_rules() {
		$default = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE);
		$mod_key = Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE;

		$rules = [
			'--wc-card-options-product-image-spacing'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.bottomSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['bottomSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],			
		];

		return $rules;
	}		

	/**
	 * Get post meta rules.
	 *
	 * @retun array
	 */
	public function get_post_meta_rules() {
		$default = Mods::get_alternative_mod_default( Config::MODS_BLOG_POST_DESIGN_POST_META );
		$mod_key = Config::MODS_BLOG_POST_DESIGN_POST_META;

		$rules = [
			'--single-post-meta-author'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.author',
				Dynamic_Selector::META_DEFAULT       => $default['author'],
			],			
			'--single-post-meta-published-date'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.publishedDate',
				Dynamic_Selector::META_DEFAULT       => $default['publishedDate'],
			],			
			'--single-post-meta-comments'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.comments',
				Dynamic_Selector::META_DEFAULT       => $default['comments'],
			],			
			'--single-post-meta-author-label'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.authorLabel',
				Dynamic_Selector::META_DEFAULT       => $default['authorLabel'],
			],			
			'--single-post-meta-show-avatar'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.showAvatar',
				Dynamic_Selector::META_DEFAULT       => $default['showAvatar'],
			],			
			'--single-post-meta-avatar-size'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.avatarSize',
				Dynamic_Selector::META_DEFAULT       => $default['avatarSize'],
			],			
			'--single-post-meta-words-per-minute'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.wordsPerMinute',
				Dynamic_Selector::META_DEFAULT       => $default['wordsPerMinute'],
			],			
			'--single-post-meta-updated-label'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.updatedLabel',
				Dynamic_Selector::META_DEFAULT       => $default['updatedLabel'],
			],			
			'--single-post-meta-show-updated-label'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.showUpdatedLabel',
				Dynamic_Selector::META_DEFAULT       => $default['showUpdatedLabel'],
			],			
		];

		return $rules;
	}

	/**
	 * Get the common typography rules
	 *
	 * @retun array
	 */
	public function get_typography_rules() {
		
		$smaller_default 	= Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_SMALLER );
		$logotitle_default 	= Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_LOGOTITLE );
		$button_default 	= Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_BUTTON );
		$default 			= Mods::get_alternative_mod_default( Config::MODS_TYPEFACE_GENERAL );

		$smaller_key 		= Config::MODS_TYPEFACE_SMALLER;
		$logotitle_key 		= Config::MODS_TYPEFACE_LOGOTITLE;
		$button_key 		= Config::MODS_TYPEFACE_BUTTON;
		$mod_key 			= Config::MODS_TYPEFACE_GENERAL;

		$rules = [
			'--smallerfontfamily'     => [
				Dynamic_Selector::META_KEY     => Config::MODS_FONT_SMALLER,
				Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_SMALLER ),
			],
			'--smallerfontsize'       => [
				Dynamic_Selector::META_KEY           => $smaller_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $smaller_default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--smallerlineheight'     => [
				Dynamic_Selector::META_KEY           => $smaller_key . '.lineHeight',
				Dynamic_Selector::META_DEFAULT       => $smaller_default['lineHeight'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => '',
			],
			'--smallerletterspacing'  => [
				Dynamic_Selector::META_KEY           => $smaller_key . '.letterSpacing',
				Dynamic_Selector::META_DEFAULT       => $smaller_default['letterSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--smallerfontweight'     => [
				Dynamic_Selector::META_KEY     => $smaller_key . '.fontWeight',
				Dynamic_Selector::META_DEFAULT => $smaller_default['fontWeight'],
				'font'                         => 'mods_' . Config::MODS_FONT_SMALLER,
			],
			'--smallertexttransform'  => [
				Dynamic_Selector::META_KEY => $smaller_key . '.textTransform',
			],

			'--logotitlefontfamily'     => [
				Dynamic_Selector::META_KEY     => Config::MODS_FONT_LOGOTITLE,
				Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_LOGOTITLE ),
			],
			'--logotitlefontsize'       => [
				Dynamic_Selector::META_KEY           => $logotitle_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $logotitle_default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--logotitlelineheight'     => [
				Dynamic_Selector::META_KEY           => $logotitle_key . '.lineHeight',
				Dynamic_Selector::META_DEFAULT       => $logotitle_default['lineHeight'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => '',
			],
			'--logotitleletterspacing'  => [
				Dynamic_Selector::META_KEY           => $logotitle_key . '.letterSpacing',
				Dynamic_Selector::META_DEFAULT       => $logotitle_default['letterSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--logotitlefontweight'     => [
				Dynamic_Selector::META_KEY     => $logotitle_key . '.fontWeight',
				Dynamic_Selector::META_DEFAULT => $logotitle_default['fontWeight'],
				'font'                         => 'mods_' . Config::MODS_FONT_LOGOTITLE,
			],
			'--logotitletexttransform'  => [
				Dynamic_Selector::META_KEY => $logotitle_key . '.textTransform',
			],

			'--buttonfontfamily'     => [
				Dynamic_Selector::META_KEY     => Config::MODS_FONT_BUTTON,
				Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_BUTTON ),
			],
			'--buttonfontsize'       => [
				Dynamic_Selector::META_KEY           => $button_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $button_default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--buttonlineheight'     => [
				Dynamic_Selector::META_KEY           => $button_key . '.lineHeight',
				Dynamic_Selector::META_DEFAULT       => $button_default['lineHeight'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => '',
			],
			'--buttonletterspacing'  => [
				Dynamic_Selector::META_KEY           => $button_key . '.letterSpacing',
				Dynamic_Selector::META_DEFAULT       => $button_default['letterSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--buttonfontweight'     => [
				Dynamic_Selector::META_KEY     		=> $button_key . '.fontWeight',
				Dynamic_Selector::META_DEFAULT 		=> $button_default['fontWeight'],
				'font'                         		=> 'mods_' . Config::MODS_FONT_BUTTON,
			],
			'--buttontexttransform'  => [
				Dynamic_Selector::META_KEY => $button_key . '.textTransform',
			],
			
		
			'--bodyfontfamily'     => [
				Dynamic_Selector::META_KEY     => Config::MODS_FONT_GENERAL,
				Dynamic_Selector::META_DEFAULT => Mods::get_alternative_mod_default( Config::MODS_FONT_GENERAL ),
			],
			'--bodyfontsize'       => [
				Dynamic_Selector::META_KEY           => $mod_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--bodylineheight'     => [
				Dynamic_Selector::META_KEY           => $mod_key . '.lineHeight',
				Dynamic_Selector::META_DEFAULT       => $default['lineHeight'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => '',
			],
			'--bodyletterspacing'  => [
				Dynamic_Selector::META_KEY           => $mod_key . '.letterSpacing',
				Dynamic_Selector::META_DEFAULT       => $default['letterSpacing'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			],
			'--bodyfontweight'     => [
				Dynamic_Selector::META_KEY     => $mod_key . '.fontWeight',
				Dynamic_Selector::META_DEFAULT => $default['fontWeight'],
				'font'                         => 'mods_' . Config::MODS_FONT_HEADINGS,
			],
			'--bodytexttransform'  => [
				Dynamic_Selector::META_KEY => $mod_key . '.textTransform',
			],
			'--headingsfontfamily' => [
				Dynamic_Selector::META_KEY => Config::MODS_FONT_HEADINGS,
			],
		];
		foreach ( solace_get_headings_selectors() as $id => $heading_selector ) {
			$composed_key = sprintf( 'solace_%s_typeface_general', $id );
			$mod_key      = $composed_key;
			$default      = Mods::get_alternative_mod_default( $composed_key );

			$rules[ '--' . $id . 'fontsize' ] = [
				Dynamic_Selector::META_KEY           => $mod_key . '.fontSize',
				Dynamic_Selector::META_DEFAULT       => $default['fontSize'],
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
			];

			$rules[ '--' . $id . 'fontweight' ] = [
				Dynamic_Selector::META_KEY     => $mod_key . '.fontWeight',
				Dynamic_Selector::META_DEFAULT => $default['fontWeight'],
				'font'                         => 'mods_' . Config::MODS_FONT_HEADINGS,
			];

			$rules[ '--' . $id . 'lineheight' ] = [
				Dynamic_Selector::META_KEY           => $mod_key . '.lineHeight',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT       => $default['lineHeight'],
				Dynamic_Selector::META_SUFFIX        => '',
			];

			$rules[ '--' . $id . 'letterspacing' ] = [
				Dynamic_Selector::META_KEY           => $mod_key . '.letterSpacing',
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_DEFAULT       => $default['letterSpacing'],
				Dynamic_Selector::META_SUFFIX        => 'px',
			];

			$rules[ '--' . $id . 'texttransform' ] = [
				Dynamic_Selector::META_KEY     => $mod_key . '.textTransform',
				Dynamic_Selector::META_DEFAULT => $default['textTransform'],
			];
		}

		return $rules;
	}

	/**
	 * Get featured image rules.
	 *
	 * @retun array
	 */
	public function get_single_post_featured_image_rules() {

		$default = Mods::get_alternative_mod_default( Config::MODS_BLOG_POST_FEATURED_IMAGE );
		$mod_key = Config::MODS_BLOG_POST_FEATURED_IMAGE;

		$rules = [
			'--singleimageRatio'     => [
				Dynamic_Selector::META_KEY     => $mod_key,
				Dynamic_Selector::META_DEFAULT => $default,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],
			'--singleimageScale'     => [
				Dynamic_Selector::META_KEY     => $mod_key,
				Dynamic_Selector::META_DEFAULT => $default,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],
			'--singleimageSize'     => [
				Dynamic_Selector::META_KEY     => $mod_key,
				Dynamic_Selector::META_DEFAULT => $default,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],
			'--singleimageVisibility'     => [
				Dynamic_Selector::META_KEY     => $mod_key,
				Dynamic_Selector::META_DEFAULT => $default,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
			],
		];

		return $rules;

	}

}
