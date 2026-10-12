<?php
/**
 * Config related constants.
 *
 * @package Solace\Core\Settings
 */

namespace Solace\Core\Settings;

/**
 * Class Admin
 *
 * @package Solace\Core\Settings
 */
class Config {
	/**
	 * Link color - deprecated.
	 *
	 * @deprecated
	 */
	const MODS_LINK_COLOR = 'solace_link_color';
	/**
	 * Link hover color - deprecated.
	 *
	 * @deprecated
	 */
	const MODS_LINK_HOVER_COLOR           = 'solace_link_hover_color';
	const MODS_GLOBAL_COLORS              = 'solace_global_colors';
	const MODS_GLOBAL_CUSTOM_COLORS       = 'solace_global_custom_colors';
	const MODS_TEXT_COLOR                 = 'solace_text_color';
	const MODS_CONTAINER_WIDTH            = 'solace_container_width';
	const MODS_CONTAINER_PAGE_WIDTH       = 'solace_container_page_width';
	const MODS_CONTAINER_POST_WIDTH       = 'solace_container_post_width';
	const MODS_SITEWIDE_CONTENT_WIDTH     = 'solace_sitewide_content_width';
	const MODS_OTHERS_CONTENT_WIDTH       = 'solace_other_pages_content_width';
	const MODS_ARCHIVE_CONTENT_WIDTH      = 'solace_blog_archive_content_width';
	const MODS_SINGLE_CONTENT_WIDTH       = 'solace_single_post_content_width';
	const MODS_SHOP_ARCHIVE_CONTENT_WIDTH = 'solace_shop_archive_content_width';
	const MODS_SHOP_SINGLE_CONTENT_WIDTH  = 'solace_single_product_content_width';
	const MODS_ADVANCED_LAYOUT_OPTIONS    = 'solace_advanced_layout_options';
	const MODS_BUTTON_PRIMARY_STYLE       = 'solace_button_appearance';
	const MODS_BUTTON_SECONDARY_STYLE     = 'solace_secondary_button_appearance';
	const MODS_BUTTON_PRIMARY_PADDING     = 'solace_button_padding';
	/**
	 * Background color - deprecated.
	 *
	 * @deprecated
	 */
	const MODS_BACKGROUND_COLOR            = 'background_color';
	const MODS_BUTTON_SECONDARY_PADDING    = 'solace_secondary_button_padding';
	const MODS_TYPEFACE_GENERAL            = 'solace_typeface_general';
	const MODS_TYPEFACE_H1                 = 'solace_h1_typeface_general';
	const MODS_TYPEFACE_H2                 = 'solace_h2_typeface_general';
	const MODS_TYPEFACE_H3                 = 'solace_h3_typeface_general';
	const MODS_TYPEFACE_H4                 = 'solace_h4_typeface_general';
	const MODS_TYPEFACE_H5                 = 'solace_h5_typeface_general';
	const MODS_TYPEFACE_H6                 = 'solace_h6_typeface_general';
	const MODS_TYPEFACE_SMALLER            = 'solace_typeface_smaller';
	const MODS_TYPEFACE_LOGOTITLE          = 'solace_typeface_logotitle';
	const MODS_TYPEFACE_BUTTON             = 'solace_typeface_button';
	const MODS_FONT_SMALLER                = 'solace_smaller_font_family';
	const MODS_FONT_SMALLER_VARIANTS       = 'solace_smaller_font_family_variants';
	const MODS_FONT_LOGOTITLE              = 'solace_logotitle_font_family';
	const MODS_FONT_LOGOTITLE_VARIANTS     = 'solace_logotitle_font_family_variants';
	const MODS_FONT_BUTTON                 = 'solace_button_font_family';
	const MODS_FONT_BUTTON_VARIANTS        = 'solace_button_font_family_variants';
	const MODS_FONT_GENERAL                = 'solace_body_font_family';
	const MODS_FONT_GENERAL_VARIANTS       = 'solace_body_font_family_variants';
	const MODS_FONT_HEADINGS               = 'solace_headings_font_family';
	const MODS_DEFAULT_CONTAINER_STYLE     = 'solace_default_container_style';
	const MODS_SINGLE_POST_CONTAINER_STYLE = 'solace_single_post_container_style';

	const MODS_BUTTON_TYPEFACE           = 'solace_button_typeface';
	const MODS_SECONDARY_BUTTON_TYPEFACE = 'solace_secondary_button_typeface';

	const MODS_TYPEFACE_ARCHIVE_POST_TITLE   = 'solace_archive_typography_post_title';
	const MODS_TYPEFACE_ARCHIVE_POST_EXCERPT = 'solace_archive_typography_post_excerpt';
	const MODS_TYPEFACE_ARCHIVE_POST_META    = 'soalce_archive_typography_post_meta';

	const MODS_TYPEFACE_SINGLE_POST_TITLE         = 'solace_single_post_typography_post_title';
	const MODS_TYPEFACE_SINGLE_POST_META          = 'solace_single_post_typography_post_meta';
	const MODS_TYPEFACE_SINGLE_POST_COMMENT_TITLE = 'solace_single_post_typography_comments_title';

	const MODS_FORM_FIELDS_PADDING          = 'solace_form_fields_padding';
	const MODS_FORM_FIELDS_SPACING          = 'solace_form_fields_spacing';
	const MODS_FORM_FIELDS_BACKGROUND_COLOR = 'solace_form_fields_background_color';
	const MODS_FORM_FIELDS_BORDER_WIDTH     = 'solace_form_fields_border_width';
	const MODS_FORM_FIELDS_BORDER_RADIUS    = 'solace_form_fields_border_radius';
	const MODS_FORM_FIELDS_BORDER_COLOR     = 'solace_form_fields_border_color';
	const MODS_FORM_FIELDS_LABELS_SPACING   = 'solace_label_spacing';
	const MODS_FORM_FIELDS_TYPEFACE         = 'solace_input_typeface';
	const MODS_FORM_FIELDS_COLOR            = 'solace_input_text_color';
	const MODS_FORM_FIELDS_LABELS_TYPEFACE  = 'solace_label_typeface';

	const MODS_ARCHIVE_POST_META_AUTHOR_AVATAR_SIZE = 'solace_author_avatar_size';
	const MODS_SINGLE_POST_META_AUTHOR_AVATAR_SIZE  = 'solace_single_post_avatar_size';
	const MODS_SINGLE_POST_ELEMENTS_SPACING         = 'solace_single_post_elements_spacing';

	const OPTION_LOCAL_GOOGLE_FONTS_HOSTING = 'nv_pro_enable_local_fonts';

	const MODS_TPOGRAPHY_FONT_PAIRS = 'solace_font_pairs';

	/**
	 * This is only used in a dynamic context for all allowed post types
	 */
	const MODS_CONTENT_WIDTH                = 'content_width';
	const MODS_COVER_HEIGHT                 = 'cover_height';
	const MODS_COVER_PADDING                = 'cover_padding';
	const MODS_COVER_BACKGROUND_COLOR       = 'cover_background_color';
	const MODS_COVER_OVERLAY_OPACITY        = 'cover_overlay_opacity';
	const MODS_COVER_TEXT_COLOR             = 'cover_text_color';
	const MODS_COVER_BLEND_MODE             = 'cover_blend_mode';
	const MODS_COVER_TITLE_ALIGNMENT        = 'title_alignment';
	const MODS_COVER_TITLE_POSITION         = 'title_position';
	const MODS_COVER_BOXED_TITLE_PADDING    = 'cover_title_boxed_padding';
	const MODS_COVER_BOXED_TITLE_BACKGROUND = 'cover_title_boxed_background_color';

	// Blog single post.
	const MODS_BLOG_POST_LINK_INITIAL     = 'solace_single_post_link_initial';
	const MODS_BLOG_POST_LINK_HOVER       = 'solace_single_post_link_hover';
	const MODS_BLOG_POST_BG   		      = 'solace_single_post_background';
	const MODS_BLOG_POST_PADDING   	      = 'solace_single_post_padding';
	const MODS_BLOG_POST_BOX_SHADOW       = 'solace_single_post_box_shadow';
	const MODS_BLOG_POST_BORDER_RADIUS    = 'solace_single_post_border_radius';
	const MODS_BLOG_POST_FEATURED_IMAGE   = 'solace_single_post_featured_image';
	const MODS_BLOG_POST_DESIGN_MARGIN    = 'solace_single_post_design_margin';
	const MODS_BLOG_POST_DESIGN_SEPARATOR = 'solace_single_post_design_separator';
	const MODS_BLOG_POST_DESIGN_TITLE     = 'solace_single_post_design_title_typeface';
	const MODS_BLOG_POST_DESIGN_POST_META = 'solace_single_post_design_post_meta';

	// Woocommerce.
	const MODS_PRODUCT_PAGE_LABEL_SHOP_SETTINGS                  = 'solace_product_page_label_shop_settings';
	const MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT                 = 'solace_product_page_shop_settings_layout';
	const MODS_PRODUCT_PAGE_LABEL_COLUMN_AND_ROW                 = 'solace_product_page_label_column_and_row';	
	const MODS_PRODUCT_PAGE_COLUMN_AND_ROW     		             = 'solace_product_page_column_and_row';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS 	                     = 'solace_product_page_card_options';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART             = 'solace_product_page_card_options_add_to_cart';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT	             = 'solace_product_page_card_options_excerpt';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_STAR_RATING             = 'solace_product_page_card_options_star_rating';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES              = 'solace_product_page_card_options_categories';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_PRICE 	                 = 'solace_product_page_card_options_price';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE 	                 = 'solace_product_page_card_options_title';
	const MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE           = 'solace_product_page_card_options_product_image';
	const MODS_PRODUCT_PAGE_LABEL_PAGE_ELEMENTS                  = 'solace_product_page_label_page_elements';
	const MODS_PRODUCT_PAGE_PRODUCT_SORTING                      = 'solace_product_page_product_sorting';
	const MODS_PRODUCT_PAGE_PAGINATION                           = 'solace_product_page_pagination';
	const MODS_PRODUCT_PAGE_sidebar      		                 = 'solace_product_page_sidebar';
	const MODS_PRODUCT_PAGE_LOOP_IMAGES 	                     = 'solace_product_page_loop_images';
	const MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS                = 'solace_product_page_ordering_card_options';
	const MODS_PRODUCT_PAGE_SHOW_SIDEBAR 		                 = 'solace_product_page_show_sidebar';
	const MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT 		                 = 'solace_product_page_sidebar_layout';
	const MODS_PRODUCT_PAGE_LABEL_PAGINATION_TYPE                = 'solace_product_page_label_pagination_type';
	const MODS_PRODUCT_PAGE_SHOW_PAGINATION    		             = 'solace_product_page_show_pagination';
	const MODS_PRODUCT_PAGE_PAGINATION_TYPE    		             = 'solace_product_page_pagination_type';
	const MODS_PRODUCT_PAGE_PAGINATION_COLOR 		             = 'solace_product_page_pagination_color';
	const MODS_PRODUCT_PAGE_PAGINATION_COLOR_ACTIVE              = 'solace_product_page_pagination_color_active';
	const MODS_PRODUCT_PAGE_PAGINATION_BG  			             = 'solace_product_page_pagination_background';
	const MODS_PRODUCT_PAGE_PAGINATION_BORDER_RADIUS             = 'solace_product_page_pagination_border_radius';
	const MODS_PRODUCT_PAGE_PAGINATION_SPACING                   = 'solace_product_page_pagination_spacing';
	const MODS_PRODUCT_PAGE_LABEL_FEATURED_IMAGES                = 'solace_product_page_label_featured_images';
	const MODS_PRODUCT_PAGE_FEATURED_IMAGES1                     = 'solace_product_page_featured_images1';
	const MODS_PRODUCT_PAGE_FEATURED_IMAGES2                     = 'solace_product_page_featured_images2';
	const MODS_PRODUCT_PAGE_FEATURED_IMAGES3                     = 'solace_product_page_featured_images3';
	const MODS_SINGLE_PRODUCT_LABEL_PAGE_LAYOUT                  = 'solace_single_product_label_page_layout';	
	const MODS_SINGLE_PRODUCT_PAGE_LAYOUT                        = 'solace_single_product_page_layout';
	const MODS_SINGLE_PRODUCT_OPTIONS	                         = 'solace_single_product_options';
	const MODS_SINGLE_PRODUCT_ELEMENTS	                         = 'solace_single_product_elements';
	const MODS_SINGLE_PRODUCT_LAYOUT_GALLERY                     = 'solace_single_product_layout_gallery';
	const MODS_SINGLE_PRODUCT_IMAGE_WIDTH                        = 'solace_single_product_image_width';
	const MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX                     = 'solace_single_product_image_lightbox';
	const MODS_SINGLE_PRODUCT_IMAGE_ZOOM                         = 'solace_single_product_image_zoom';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS                   = 'solace_single_product_product_elements';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_BREADCRUMBS       = 'solace_single_product_product_elements_breadcrumbs';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_STAR_RATING       = 'solace_single_product_product_elements_star_rating';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PRICE             = 'solace_single_product_product_elements_price';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_SHORT_DESCRIPTION = 'solace_single_product_product_elements_short_description';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER1          = 'solace_single_product_product_elements_divider_1';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART       = 'solace_single_product_product_elements_add_to_cart';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE             = 'solace_single_product_product_elements_title';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_DIVIDER2          = 'solace_single_product_product_elements_divider_2';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_META              = 'solace_single_product_product_elements_meta';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS   = 'solace_single_product_product_elements_payment_methods';
	const MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO   = 'solace_single_product_product_elements_additional_info';
	const MODS_SINGLE_PRODUCT_PRODUCT_STICKY_CONTAINER   		 = 'solace_single_product_sticky_container';
	const MODS_TYPEFACE_CHECKOUT_TITLE                           = 'solace_typeface_checkout_title';

	const MODS_POST_COMMENTS_PADDING               = 'solace_comments_boxed_padding';
	const MODS_POST_COMMENTS_BACKGROUND_COLOR      = 'solace_comments_boxed_background_color';
	const MODS_POST_COMMENTS_TEXT_COLOR            = 'solace_comments_boxed_text_color';
	const MODS_POST_COMMENTS_FORM_PADDING          = 'solace_comments_form_boxed_padding';
	const MODS_POST_COMMENTS_FORM_BACKGROUND_COLOR = 'solace_comments_form_boxed_background_color';
	const MODS_POST_COMMENTS_FORM_TEXT_COLOR       = 'solace_comments_form_boxed_text_color';

	const CSS_PROP_BORDER_COLOR               = 'border-color';
	const CSS_PROP_BACKGROUND_COLOR           = 'background-color';
	const CSS_PROP_BACKGROUND                 = 'background';
	const CSS_PROP_COLOR                      = 'color';
	const CSS_PROP_MAX_WIDTH                  = 'max-width';
	const CSS_PROP_BORDER_RADIUS_TOP_LEFT     = 'border-top-left-radius';
	const CSS_PROP_BORDER_RADIUS_TOP_RIGHT    = 'border-top-right-radius';
	const CSS_PROP_BORDER_RADIUS_BOTTOM_RIGHT = 'border-bottom-right-radius';
	const CSS_PROP_BORDER_RADIUS_BOTTOM_LEFT  = 'border-bottom-left-radius';
	const CSS_PROP_BORDER_RADIUS              = 'border-radius';
	const CSS_PROP_BORDER_WIDTH               = 'border-width';
	const CSS_PROP_BORDER                     = 'border';
	const CSS_PROP_FLEX_BASIS                 = 'flex-basis';
	const CSS_PROP_PADDING                    = 'padding';
	const CSS_PROP_PADDING_RIGHT              = 'padding-right';
	const CSS_PROP_PADDING_LEFT               = 'padding-left';
	const CSS_PROP_MARGIN                     = 'margin';
	const CSS_PROP_MARGIN_LEFT                = 'margin-left';
	const CSS_PROP_MARGIN_RIGHT               = 'margin-right';
	const CSS_PROP_MARGIN_TOP                 = 'margin-top';
	const CSS_PROP_MARGIN_BOTTOM              = 'margin-bottom';
	const CSS_PROP_RIGHT                      = 'right';
	const CSS_PROP_LEFT                       = 'left';
	const CSS_PROP_WIDTH                      = 'width';
	const CSS_PROP_HEIGHT                     = 'height';
	const CSS_PROP_MIN_HEIGHT                 = 'min-height';
	const CSS_PROP_FONT_SIZE                  = 'font-size';
	const CSS_PROP_FILL_COLOR                 = 'fill';
	const CSS_PROP_LETTER_SPACING             = 'letter-spacing';
	const CSS_PROP_LINE_HEIGHT                = 'line-height';
	const CSS_PROP_FONT_WEIGHT                = 'font-weight';
	const CSS_PROP_TEXT_TRANSFORM             = 'text-transform';
	const CSS_PROP_FONT_FAMILY                = 'font-family';
	const CSS_PROP_BOX_SHADOW                 = 'box-shadow';
	const CSS_PROP_MIX_BLEND_MODE             = 'mix-blend-mode';
	const CSS_PROP_OPACITY                    = 'opacity';
	const CSS_PROP_GRID_TEMPLATE_COLS         = 'grid-template-columns';

	const CSS_PROP_CUSTOM_BTN_TYPE           = 'btn-type';
	const CSS_PROP_CUSTOM_FONT_WEIGHT_FAMILY = 'btn-type';

	const CSS_SELECTOR_BTN_PRIMARY_NORMAL          = 'buttons_primary_normal';
	const CSS_SELECTOR_BTN_PRIMARY_HOVER           = 'buttons_primary_hover';
	const CSS_SELECTOR_BTN_SECONDARY_NORMAL        = 'buttons_secondary_normal';
	const CSS_SELECTOR_BTN_SECONDARY_HOVER         = 'buttons_secondary_hover';
	const CSS_SELECTOR_BTN_SECONDARY_DEFAULT       = 'buttons_secondary_default';
	const CSS_SELECTOR_BTN_SECONDARY_DEFAULT_HOVER = 'buttons_secondary_default_hover';
	const CSS_SELECTOR_BTN_PRIMARY_PADDING         = 'buttons_primary_padding';
	const CSS_SELECTOR_BTN_SECONDARY_PADDING       = 'buttons_secondary_padding';
	const CSS_SELECTOR_TYPEFACE_GENERAL            = 'typeface_general';
	const CSS_SELECTOR_TYPEFACE_H1                 = 'typeface_h1';
	const CSS_SELECTOR_TYPEFACE_H2                 = 'typeface_h2';
	const CSS_SELECTOR_TYPEFACE_H3                 = 'typeface_h3';
	const CSS_SELECTOR_TYPEFACE_H4                 = 'typeface_h4';
	const CSS_SELECTOR_TYPEFACE_H5                 = 'typeface_h5';
	const CSS_SELECTOR_TYPEFACE_H6                 = 'typeface_h6';

	const CSS_SELECTOR_ARCHIVE_POST_TITLE   = 'archive_entry_title';
	const CSS_SELECTOR_ARCHIVE_POST_EXCERPT = 'archive_entry_summary';
	const CSS_SELECTOR_ARCHIVE_POST_META    = 'archive_entry_meta_list';

	const CSS_SELECTOR_SINGLE_POST_TITLE         = 'single_post_entry_title';
	const CSS_SELECTOR_SINGLE_POST_META          = 'single_post_entry_meta_list';
	const CSS_SELECTOR_SINGLE_POST_COMMENT_TITLE = 'single_post_comment_title';

	const CSS_SELECTOR_FORM_INPUTS_WITH_SPACING = 'form_inputs_no_search';
	const CSS_SELECTOR_FORM_INPUTS              = 'form_inputs';
	const CSS_SELECTOR_FORM_INPUTS_LABELS       = 'form_labels';
	const CSS_SELECTOR_FORM_BUTTON              = 'form_buttons';
	const CSS_SELECTOR_FORM_BUTTON_HOVER        = 'form_buttons_hover';
	const CSS_SELECTOR_FORM_SEARCH_INPUTS       = 'search_form_inputs';

	const CONTENT_DEFAULT_PADDING = 30;

	/**
	 * Keys for directional values.
	 *
	 * @var string[]
	 */
	public static $directional_keys = [ 'top', 'right', 'bottom', 'left' ];

	/**
	 * Holds tag->css selector mapper.
	 *
	 * @var array Mapper.
	 */
	public static $css_selectors_map = [
		self::CSS_SELECTOR_TYPEFACE_H1                 => 'h1, .single h1.entry-title',
		self::CSS_SELECTOR_TYPEFACE_H2                 => 'h2',
		self::CSS_SELECTOR_TYPEFACE_H3                 => 'h3, .woocommerce-checkout h3',
		self::CSS_SELECTOR_TYPEFACE_H4                 => 'h4',
		self::CSS_SELECTOR_TYPEFACE_H5                 => 'h5',
		self::CSS_SELECTOR_TYPEFACE_H6                 => 'h6',
		self::CSS_SELECTOR_TYPEFACE_GENERAL            => 'body, .site-title',
		self::CSS_SELECTOR_BTN_PRIMARY_PADDING         => '.button.button-primary, .wp-block-button.is-style-primary .wp-block-button__link,  .wc-block-grid .wp-block-button .wp-block-button__link',
		self::CSS_SELECTOR_BTN_SECONDARY_PADDING       => '.button.button-secondary:not(.secondary-default), .wp-block-button.is-style-secondary .wp-block-button__link',
		self::CSS_SELECTOR_BTN_PRIMARY_NORMAL          => '.button.button-primary,
				button, input[type=button],
				.btn, input[type="submit"],
				/* Buttons in navigation */
				ul[id^="nv-primary-navigation"] li.button.button-primary > a,
				.menu li.button.button-primary > a,  .wp-block-button.is-style-primary .wp-block-button__link,  .wc-block-grid .wp-block-button .wp-block-button__link',
		self::CSS_SELECTOR_BTN_PRIMARY_HOVER           => '.button.button-primary:hover,
				ul[id^="nv-primary-navigation"] li.button.button-primary > a:hover,
				.menu li.button.button-primary > a:hover, .wp-block-button.is-style-primary .wp-block-button__link:hover,  .wc-block-grid .wp-block-button .wp-block-button__link:hover',
		self::CSS_SELECTOR_BTN_SECONDARY_NORMAL        => '.button.button-secondary:not(.secondary-default),  .wp-block-button.is-style-secondary .wp-block-button__link',
		self::CSS_SELECTOR_BTN_SECONDARY_HOVER         => '.button.button-secondary:not(.secondary-default):hover,  .wp-block-button.is-style-secondary .wp-block-button__link:hover',
		self::CSS_SELECTOR_BTN_SECONDARY_DEFAULT       => '.button.button-secondary.secondary-default',
		self::CSS_SELECTOR_BTN_SECONDARY_DEFAULT_HOVER => '.button.button-secondary.secondary-default:hover',
		self::CSS_SELECTOR_ARCHIVE_POST_TITLE          => '.blog .blog-entry-title, .archive .blog-entry-title',
		self::CSS_SELECTOR_ARCHIVE_POST_EXCERPT        => '.blog .entry-summary, .archive .entry-summary, .blog .post-pages-links',
		self::CSS_SELECTOR_ARCHIVE_POST_META           => '.blog .nv-meta-list li, .archive .nv-meta-list li',
		self::CSS_SELECTOR_SINGLE_POST_TITLE           => '.single h1.entry-title',
		self::CSS_SELECTOR_SINGLE_POST_META            => '.single .nv-meta-list li',
		self::CSS_SELECTOR_SINGLE_POST_COMMENT_TITLE   => '.single .comment-reply-title',
		self::CSS_SELECTOR_FORM_INPUTS_WITH_SPACING    => 'form:not([role|="search"]):not(.woocommerce-cart-form):not(.woocommerce-ordering):not(.cart) input:read-write:not(#coupon_code), form textarea, form select, .widget select',
		self::CSS_SELECTOR_FORM_INPUTS                 => 'form input:read-write, form textarea, form select, form select option, form.wp-block-search input.wp-block-search__input, .widget select',
		self::CSS_SELECTOR_FORM_INPUTS_LABELS          => 'form label, .wpforms-container .wpforms-field-label',
		self::CSS_SELECTOR_FORM_BUTTON                 => 'form input[type="submit"], form button:not(.search-submit)[type="submit"], form *[value*="ubmit"], #comments input[type="submit"]',
		self::CSS_SELECTOR_FORM_BUTTON_HOVER           => 'form input[type="submit"]:hover, form button:not(.search-submit)[type="submit"]:hover, form *[value*="ubmit"]:hover, #comments input[type="submit"]:hover',
		self::CSS_SELECTOR_FORM_SEARCH_INPUTS          => 'form.search-form input:read-write',
	];

	/**
	 * The default Font pairings available for all instances.
	 *
	 * Default preview size for fonts is 24px for heading and 16px for body.
	 *
	 * @var array[]
	 */
	public static $typography_default_pairs = [
		[
			'headingFont' => [
				'font'        => 'Inter',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'       => 'Inter',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Playfair Display',
				'fontSource'  => 'Google',
				'previewSize' => '27px',
			],
			'bodyFont'    => [
				'font'        => 'Source Sans Pro',
				'fontSource'  => 'Google',
				'previewSize' => '18px',
			],
		],
		[
			'headingFont' => [
				'font'       => 'Montserrat',
				'fontSource' => 'Google',
			],
			'bodyFont'    => [
				'font'       => 'Open Sans',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'       => 'Nunito',
				'fontSource' => 'Google',
			],
			'bodyFont'    => [
				'font'       => 'Lora',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'       => 'Lato',
				'fontSource' => 'Google',
			],
			'bodyFont'    => [
				'font'       => 'Karla',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Outfit',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'       => 'Spline Sans',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Lora',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'       => 'Ubuntu',
				'fontSource' => 'Google',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Prata',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'        => 'Hanken Grotesk',
				'fontSource'  => 'Google',
				'previewSize' => '17px',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Albert Sans',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'        => 'Albert Sans',
				'fontSource'  => 'Google',
				'previewSize' => '17px',
			],
		],
		[
			'headingFont' => [
				'font'        => 'Fraunces',
				'fontSource'  => 'Google',
				'previewSize' => '25px',
			],
			'bodyFont'    => [
				'font'        => 'Hanken Grotesk',
				'fontSource'  => 'Google',
				'previewSize' => '17px',
			],
		],
	];
}
