<?php
/**
 * Theme mods wrapper
 *
 * Author:          
 * Created on:      17/08/2018
 *
 * @package Solace\Core
 */

namespace Solace\Core\Settings;
use Solace\Customizer\Options\Layout_Single_Post;

/**
 * Class Admin
 *
 * @package Solace\Core\Settings
 */
class Mods {

	/**
	 * Cached values.
	 *
	 * @var array Values cached.
	 */
	private static $_cached = [];
	/**
	 * No cache mode.
	 *
	 * @var bool Should we avoid cache.
	 */
	public static $no_cache = false;

	/**
	 * Get theme mod.
	 *
	 * @param string $key Key value.
	 * @param mixed  $default Default value.
	 *
	 * @return mixed Mod value.
	 */
	public static function get( $key, $default = false ) {
		$master_default = $default;
		$subkey         = null;
		if ( strpos( $key, '.' ) !== false ) {
			$key_parts      = explode( '.', $key );
			$key            = $key_parts[0];
			$subkey         = $key_parts[1];
			$master_default = false;
		}

		if ( ! isset( self::$_cached[ $key ] ) || self::$no_cache ) {
			$master_default        = $master_default === false ? self::defaults( $key ) : $master_default;
			self::$_cached[ $key ] =
				( $master_default === false ) ?
					get_theme_mod( $key ) :
					get_theme_mod( $key, $master_default );
		}

		if ( $subkey === null ) {
			return self::$_cached[ $key ];
		}
		$value = is_string( self::$_cached[ $key ] ) ? json_decode( self::$_cached[ $key ], true ) : self::$_cached[ $key ];

		return isset( $value[ $subkey ] ) ? $value[ $subkey ] : $default;
	}

	/**
	 * Forced defaults.
	 *
	 * @param string $key Key name.
	 *
	 * @return array|bool|string
	 */
	private static function defaults( $key ) {
		switch ( $key ) {
			case Config::MODS_CONTAINER_WIDTH:
				return '{ "mobile": 748, "tablet": 992, "desktop": 1280 }';
			case Config::MODS_BUTTON_PRIMARY_STYLE:
				return solace_get_button_appearance_default();
			case Config::MODS_BUTTON_SECONDARY_STYLE:
				return solace_get_button_appearance_default( 'secondary' );
			case Config::MODS_BLOG_POST_FEATURED_IMAGE:
				$defaults  = self::get_featured_image_defaults(
					[
						'image_ratio'      => 'solace_singe_image_ratio',
						'image_scale'      => 'solace_single_image_scale',
						'image_size'       => 'solace_single_image_size',
						'image_visibility' => 'solace_single_image_visibility',
					]
				);
				$image_ratio = self::to_json( 'solace_singe_image_ratio' );
				if ( ! empty( $image_ratio ) ) {
					$defaults['imageRatio'] = $image_ratio;
				}

				return $defaults;
			case Config::MODS_BLOG_POST_DESIGN_TITLE:
				$defaults  = self::get_typeface_title_defaults(
					[
						'heading_tag'    => 'solace_body_heading_tag',
					]
				);
				$font_size = self::to_json( 'solace_body_font_size' );
				if ( ! empty( $font_size ) ) {
					$defaults['fontSize'] = $font_size;
				}

				return $defaults;				
			case Config::MODS_BLOG_POST_DESIGN_POST_META:
				$defaults  = self::get_post_meta_defaults(
					[
						'author'    		 => 'solace_body_author',
						'published_date'     => 'solace_body_published_date',
						'comments'    	     => 'solace_body_comments',
						'author_label' 		 => 'solace_body_author_label',
						'show_avatar' 	     => 'solace_body_show_avatar',
						'avatar_size' 	     => 'solace_body_avatar_size',
						'words_per_minute'   => 'solace_body_words_per_minute',
						'show_updated_label' => 'solace_body_show_updated_label',
						'updated_label'      => 'solace_body_updated_label',
					]
				);
				$font_size = self::to_json( 'solace_body_font_size' );
				if ( ! empty( $font_size ) ) {
					$defaults['fontSize'] = $font_size;
				}

				return $defaults;				
			case Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART:
				$defaults  = self::get_card_options_add_to_cart_defaults(
					[
						'auto_hide'      => 'solace_body_auto_hide',
						'bottom_spacing' => 'solace_body_bottom_spacing',
					]
				);
				$font_size = self::to_json( 'solace_body_font_size' );
				if ( ! empty( $font_size ) ) {
					$defaults['fontSize'] = $font_size;
				}

				return $defaults;					
			case Config::MODS_TYPEFACE_GENERAL:
				$defaults  = self::get_typography_defaults(
					[
						'line_height'    => 'solace_body_line_height',
						'letter_spacing' => 'solace_body_letter_spacing',
						'font_weight'    => 'solace_body_font_weight',
						'text_transform' => 'solace_body_text_transform',
					]
				);
				$font_size = self::to_json( 'solace_body_font_size' );
				if ( ! empty( $font_size ) ) {
					$defaults['fontSize'] = $font_size;
				}

				return $defaults;
			case Config::MODS_TYPEFACE_H1:
			case Config::MODS_TYPEFACE_H2:
			case Config::MODS_TYPEFACE_H3:
			case Config::MODS_TYPEFACE_H4:
			case Config::MODS_TYPEFACE_H5:
			case Config::MODS_TYPEFACE_H6:
				$defaults   = self::get_typography_defaults(
					[
						'line_height'    => 'solace_headings_line_height',
						'letter_spacing' => 'solace_headings_letter_spacing',
						'font_weight'    => 'solace_headings_font_weight',
						'text_transform' => 'solace_headings_text_transform',
					]
				);
				$legacy_map = [
					Config::MODS_TYPEFACE_H6 => [
						'font_size'   => 'solace_h6_font_size',
						'line_height' => 'solace_h6_line_height',
					],
					Config::MODS_TYPEFACE_H5 => [
						'font_size'   => 'solace_h5_font_size',
						'line_height' => 'solace_h5_line_height',
					],
					Config::MODS_TYPEFACE_H4 => [
						'font_size'   => 'solace_h4_font_size',
						'line_height' => 'solace_h4_line_height',
					],
					Config::MODS_TYPEFACE_H3 => [
						'font_size'   => 'solace_h3_font_size',
						'line_height' => 'solace_h3_line_height',
					],
					Config::MODS_TYPEFACE_H2 => [
						'font_size'   => 'solace_h2_font_size',
						'line_height' => 'solace_h2_line_height',
					],
					Config::MODS_TYPEFACE_H1 => [
						'font_size'   => 'solace_h1_font_size',
						'line_height' => 'solace_h1_line_height',
					],
				];

				$font_size = self::to_json( $legacy_map[ $key ]['font_size'] );
				if ( ! empty( $font_size ) ) {
					$defaults['fontSize'] = $font_size;
				}
				$line_height = self::to_json( $legacy_map[ $key ]['line_height'] );
				if ( ! empty( $line_height ) ) {
					$defaults['lineHeight'] = $line_height;
				}

				return $defaults;
		}

		return false;
	}

	/**
	 * Helper method to get defaults for featured image.
	 *
	 * @param array $args Legacy mods.
	 *
	 * @return array
	 */
	private static function get_featured_image_defaults( $args ) {

		$image_ratio      = self::to_json( $args['image_ratio'] );
		$image_scale      = self::get( $args['image_scale'] );
		$image_size       = self::get( $args['image_size'] );
		$image_visibility = self::get( $args['image_visibility'] );
		$defaults         = [];

		if ( ! empty( $image_ratio ) ) {
			$defaults['imageRatio'] = $image_ratio;
		}
		if ( ! empty( $image_scale ) ) {
			$defaults['imageScale'] = $image_scale;
		}
		if ( ! empty( $image_size ) ) {
			$defaults['imageSize'] = $image_size;
		}
		if ( ! empty( $image_visibility ) ) {
			$defaults['imageVisibility'] = $image_visibility;
		}

		return $defaults;
	}

	/**
	 * Helper method to get defaults for typography.
	 *
	 * @param array $args Legacy mods.
	 *
	 * @return array
	 */
	private static function get_typeface_title_defaults( $args ) {

		$heading_tag    = self::get( $args['heading_tag'] );
		$defaults       = [];

		if ( ! empty( $heading_tag ) ) {
			$defaults['headingTag'] = $heading_tag;
		}

		return $defaults;
	}

	/**
	 * Helper method to get defaults for typography.
	 *
	 * @param array $args Legacy mods.
	 *
	 * @return array
	 */
	private static function get_post_meta_defaults( $args ) {

		$author             = self::to_json( $args['author'] );
		$published_date     = self::get( $args['published_date'] );
		$comments           = self::get( $args['comments'] );
		$author_label 	    = self::get( $args['author_label'] );
		$show_avatar 		= self::get( $args['show_avatar'] );
		$avatar_size 	    = self::get( $args['avatar_size'] );
		$words_per_minute   = self::get( $args['words_per_minute'] );
		$show_updated_label = self::get( $args['show_updated_label'] );
		$updated_label      = self::get( $args['updated_label'] );
		$defaults           = [];

		if ( ! empty( $author ) ) {
			$defaults['author'] = $author;
		}

		if ( ! empty( $published_date ) ) {
			$defaults['publishedDate'] = $published_date;
		}

		if ( ! empty( $comments ) ) {
			$defaults['imageSize'] = $comments;
		}

		if ( ! empty( $author_label ) ) {
			$defaults['authorLabel'] = $author_label;
		}

		if ( ! empty( $show_avatar ) ) {
			$defaults['showAvatar'] = $show_avatar;
		}

		if ( ! empty( $avatar_size ) ) {
			$defaults['avatarSize'] = $avatar_size;
		}

		if ( ! empty( $words_per_minute ) ) {
			$defaults['wordsPerMinute'] = $words_per_minute;
		}

		if ( ! empty( $show_updated_label ) ) {
			$defaults['showUpdatedLabel'] = $show_updated_label;
		}

		if ( ! empty( $updated_label ) ) {
			$defaults['updatedLabel'] = $updated_label;
		}

		return $defaults;
	}


	/**
	 * Helper method to get defaults for typography.
	 *
	 * @param array $args Legacy mods.
	 *
	 * @return array
	 */
	private static function get_card_options_add_to_cart_defaults( $args ) {

		$auto_hide          = self::to_json( $args['auto_hide'] );
		$bottom_spacing     = self::get( $args['bottom_spacing'] );
		$defaults           = [];

		if ( ! empty( $auto_hide ) ) {
			$defaults['autoHide'] = $auto_hide;
		}

		if ( ! empty( $bottom_spacing ) ) {
			$defaults['bottomSpacing'] = $bottom_spacing;
		}

		return $defaults;
	}	

	/**
	 * Helper method to get defaults for typography.
	 *
	 * @param array $args Legacy mods.
	 *
	 * @return array
	 */
	private static function get_typography_defaults( $args ) {

		$line_height    = self::to_json( $args['line_height'] );
		$letter_spacing = self::get( $args['letter_spacing'] );
		$font_weight    = self::get( $args['font_weight'] );
		$text_transform = self::get( $args['text_transform'] );
		$defaults       = [];
		if ( ! empty( $line_height ) ) {
			$defaults['lineHeight'] = $line_height;
		}
		if ( ! empty( $letter_spacing ) ) {
			$defaults['letterSpacing'] = $letter_spacing;
		}
		if ( ! empty( $font_weight ) ) {
			$defaults['fontWeight'] = $font_weight;
		}
		if ( ! empty( $text_transform ) ) {
			$defaults['textTransform'] = $text_transform;
		}

		return $defaults;
	}

	/**
	 * Setter for the manager.
	 *
	 * @param string $key Key.
	 * @param mixed  $value Value.
	 */
	public static function set( $key, $value ) {
		self::$_cached[ $key ] = $value;
	}

	/**
	 * Get and transform setting to json.
	 *
	 * @param string $key Key name.
	 * @param mixed  $default Default value.
	 * @param bool   $as_array As array or Object.
	 *
	 * @return mixed
	 */
	public static function to_json( $key, $default = false, $as_array = true ) {
		return json_decode( self::get( $key, $default ), $as_array );
	}

	/**
	 * Get alternative mod default.
	 *
	 * @param string $key theme mod key.
	 *
	 * @return string|array|int|false
	 */
	public static function get_alternative_mod_default( $key ) {
		$new                    = solace_is_new_skin();
		$headings_generic_setup = [
			'fontWeight'    => '700',			
			'textTransform' => 'none',
			'letterSpacing' => [
				'mobile'  => 0,
				'tablet'  => 0,
				'desktop' => 0,
			],
		];
		$headings_sufix         = [
			'mobile'  => $new ? 'px' : 'em',
			'tablet'  => $new ? 'px' : 'em',
			'desktop' => $new ? 'px' : 'em',
		];
		$lineheight_sufix = [
			'mobile'  => 'em',
			'tablet'  => 'em',
			'desktop' => 'em',
		];
		switch ( $key ) {
			case Config::MODS_FONT_GENERAL:
				return $new ? 'DM Sans, sans-serif' : false;
			case Config::MODS_FONT_SMALLER:
				return $new ? 'DM Sans, sans-serif' : false;
			case Config::MODS_FONT_LOGOTITLE:
				return $new ? 'DM Sans, sans-serif' : false;
			case Config::MODS_FONT_BUTTON:
				return $new ? 'DM Sans, sans-serif' : false;
			case Config::MODS_TYPEFACE_SMALLER:
				return [
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 12,
						'tablet'  => 12,
						'desktop' => 12,
					],
					'lineHeight'    => [
						'mobile'  => 1.5,
						'tablet'  => 1.5,
						'desktop' => 1.5,
						'suffix'  => $lineheight_sufix,
					],
					'letterSpacing' => [
						'mobile'  => 0,
						'tablet'  => 0,
						'desktop' => 0,
					],
					'fontWeight'    => '400',
					'textTransform' => 'none',
				];
			case Config::MODS_TYPEFACE_LOGOTITLE:
				return [
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 16,
						'tablet'  => 16,
						'desktop' => 16,
					],
					'lineHeight'    => [
						'mobile'  => 1.5,
						'tablet'  => 1.5,
						'desktop' => 1.5,
						'suffix'  => $lineheight_sufix,
					],
					'letterSpacing' => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 0,
						'tablet'  => 0,
						'desktop' => 0,
					],
					'fontWeight'    => '400',
					'textTransform' => 'none',
				];
			case Config::MODS_TYPEFACE_BUTTON:
				return [
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 16,
						'tablet'  => 16,
						'desktop' => 16,
					],
					'lineHeight'    => [
						'mobile'  => 1.5,
						'tablet'  => 1.5,
						'desktop' => 1.5,
						'suffix'  => $lineheight_sufix,
					],
					'letterSpacing' => [
						'mobile'  => 0,
						'tablet'  => 0,
						'desktop' => 0,
					],
					'fontWeight'    => '400',
					'textTransform' => 'none',
				];
				case Config::MODS_BLOG_POST_FEATURED_IMAGE:
					$data = new Layout_Single_Post();
					$default = $data->blog_post_single_featured_image_default();
					return $default;
					// return [
						// 'desktop' => array(
						// 	'imageRatio' 	   => 'original',
						// 	'imageScale' 	   => 'contain',
						// 	'imageSize'  	   => 'full',
						// 	'imageVisibility'  => true,
						// ),
						// 'tablet' => array(
						// 	'imageRatio' 	   => 'original',
						// 	'imageScale' 	   => 'contain',
						// 	'imageSize'  	   => 'full',
						// 	'imageVisibility'  => true,
						// ),			
						// 'mobile' => array(
						// 	'imageRatio' 	   => 'original',
						// 	'imageScale' 	   => 'contain',
						// 	'imageSize'  	   => 'full',
						// 	'imageVisibility'  => true,
						// ),							
						// 'imageRatio'    => [
						// 	'desktop' => 'original',
						// 	'tablet'  => 'original',
						// 	'mobile'  => 'original',
						// ],
						// 'imageScale'    => [
						// 	'desktop' => 'contain',
						// 	'tablet'  => 'contain',
						// 	'mobile'  => 'contain',
						// ],
						// 'imageSize'    => [
						// 	'desktop' => 'full',
						// 	'tablet'  => 'full',
						// 	'mobile'  => 'full',
						// ],
						// 'imageVisibility'    => [
						// 	'desktop' => true,
						// 	'tablet'  => true,
						// 	'mobile'  => true,
						// ],
					// ];				
			case Config::MODS_BLOG_POST_DESIGN_TITLE:
				return [
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 68,
						'tablet'  => 68,
						'desktop' => 68,
					],
					'headingTag'    => 'h1',
				];
			case Config::MODS_BLOG_POST_DESIGN_POST_META:
				return [
					'author'    	=> true,
					'publishedDate' => true,
					'comments' 	    => true,
					'authorLabel' 	=> 'By',
					'showAvatar'    => true,					
					'avatarSize'    => [
						'value' => 50,
						'min'   => 10,
						'max'   => 120,
						'step'  => 1,
					],				
					'wordsPerMinute'    => [
						'value' => 200,
						'min'   => 50,
						'max'   => 500,
						'step'  => 1,
					],				
					'updatedLabel' 	=> 'Updated on',
					'showUpdatedLabel' => true,
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 68,
						'tablet'  => 68,
						'desktop' => 68,
					],
				];
			case Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART:
				return [
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
				];				
			case Config::MODS_TYPEFACE_GENERAL:
				return [
					'fontSize'      => [
						'suffix'  => [
							'mobile'  => 'px',
							'tablet'  => 'px',
							'desktop' => 'px',
						],
						'mobile'  => 16,
						'tablet'  => 16,
						'desktop' => 16,
					],
					'lineHeight'    => [
						'mobile'  => 1.5,
						'tablet'  => 1.5,
						'desktop' => 1.5,
						'suffix'  => $lineheight_sufix,
					],
					'letterSpacing' => [
						'mobile'  => 0,
						'tablet'  => 0,
						'desktop' => 0,
					],
					'fontWeight'    => '400',
					'textTransform' => 'none',
				];
			case Config::MODS_TYPEFACE_H1:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '38' : '1.5',
							'tablet'  => $new ? '50' : '1.5',
							'desktop' => $new ? '68' : '2',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1,
							'tablet'  => 1,
							'desktop' => 1,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_TYPEFACE_H2:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '28' : '1.3',
							'tablet'  => $new ? '38' : '1.3',
							'desktop' => $new ? '50' : '1.75',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1.1,
							'tablet'  => 1.1,
							'desktop' => 1.1,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_TYPEFACE_H3:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '21' : '1.1',
							'tablet'  => $new ? '28' : '1.1',
							'desktop' => $new ? '38' : '1.5',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1.2,
							'tablet'  => 1.2,
							'desktop' => 1.2,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_TYPEFACE_H4:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '18' : '1',
							'tablet'  => $new ? '21' : '1',
							'desktop' => $new ? '28' : '1.25',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1.3,
							'tablet'  => 1.3,
							'desktop' => 1.3,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_TYPEFACE_H5:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '16' : '0.75',
							'tablet'  => $new ? '18' : '0.75',
							'desktop' => $new ? '21' : '1',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1.3,
							'tablet'  => 1.3,
							'desktop' => 1.3,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_TYPEFACE_H6:
				return array_merge(
					$headings_generic_setup,
					array(
						'fontSize'   => [
							'mobile'  => $new ? '14' : '0.75',
							'tablet'  => $new ? '14' : '0.75',
							'desktop' => $new ? '16' : '1',
							'suffix'  => $headings_sufix,
						],
						'lineHeight' => [
							'mobile'  => 1.3,
							'tablet'  => 1.3,
							'desktop' => 1.3,
							'suffix'  => $lineheight_sufix,
						],
					)
				);
			case Config::MODS_BUTTON_PRIMARY_PADDING:
				$device = $new ? [
					'top'    => 13,
					'right'  => 15,
					'bottom' => 13,
					'left'   => 15,
				] : [
					'top'    => 8,
					'right'  => 12,
					'bottom' => 8,
					'left'   => 12,
				];

				return [
					'desktop'      => $device,
					'tablet'       => $device,
					'mobile'       => $device,
					'desktop-unit' => 'px',
					'tablet-unit'  => 'px',
					'mobile-unit'  => 'px',
				];
			case Config::MODS_FORM_FIELDS_PADDING:
				return [
					'top'    => $new ? 10 : 7,
					'bottom' => $new ? 10 : 7,
					'left'   => 12,
					'right'  => 12,
					'unit'   => 'px',
				];
			case Config::MODS_FORM_FIELDS_BORDER_WIDTH:
				return [
					'top'    => $new ? 2 : 1,
					'right'  => $new ? 2 : 1,
					'left'   => $new ? 2 : 1,
					'bottom' => $new ? 2 : 1,
					'unit'   => 'px',
				];
			case Config::MODS_TYPEFACE_CHECKOUT_TITLE:
					return [
						'fontSize'      => [
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
							'mobile'  => 21,
							'tablet'  => 28,
							'desktop' => 38,
						],
						'lineHeight'    => [
							'mobile'  => 1.5,
							'tablet'  => 1.5,
							'desktop' => 1.5,
							'suffix'  => $lineheight_sufix,
						],
						'letterSpacing' => [
							'mobile'  => 0,
							'tablet'  => 0,
							'desktop' => 0,
						],
						'fontWeight'    => '600',
						'textTransform' => 'uppercase',
					];				
			default:
				return false;
		}
	}
}
