<?php
/**
 * Starter Content Compatibility.
 */

/**
 * Class Solace_Starter_Content
 */
class Solace_Starter_Content {
	public const HOME_SLUG          = 'home';
	public const Trusted_SLUG       = '#trusted';
	public const Why_choose_us_SLUG = '#why-choose-us';
	public const Template_SLUG      = '#template';
	public const Testimonials_SLUG  = '#testimonials';
	public const Faq_SLUG  	   	    = '#faq';
	public const Business_SLUG  	= '#business';

	/**
	 * Return starter content definition.
	 *
	 * @return mixed|void
	 * @since 4.0.0
	 */
	public function get() {

		$nav_items_header = array(
			'home'     	    => array(
				'type'      => 'post_type',
				'object'    => 'page',
				'object_id' => '{{' . self::HOME_SLUG . '}}',
			),
			'trusted' 	    => array(
				'title'     => __( 'Trusted', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Trusted_SLUG,
			),			
			'why-choose-us' => array(
				'title'     => __( 'Why Choose Us', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Why_choose_us_SLUG,
			),
			'template'      => array(
				'title'     => __( 'Template', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Template_SLUG,
			),
			'testimonials'  => array(
				'title'     => __( 'Testimonials', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Testimonials_SLUG,
			),
			'faq'           => array(
				'title'     => __( 'FAQ', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Faq_SLUG,
			),
			'business'      => array(
				'title'     => __( 'Business', 'solace' ),
				'type'      => 'custom',
				'url'       => self::Business_SLUG,
			),
		);

		$content = array(
			'attachments' => array(
				'logo' => array(
					'post_title' => _x( 'Logo', 'Theme starter content', 'solace' ),
					'file'       => 'assets/img/starter-content/logo.png',
				),
			),
			'theme_mods'  => array(
				'custom_logo' => '{{logo}}',
			),

			'nav_menus'   => array(
				'primary'     => array(
					'name'  => esc_html__( 'Primary', 'solace' ),
					'items' => $nav_items_header,
				),
			),
			'options'     => array(
				'page_on_front' => '{{' . self::HOME_SLUG . '}}',
				'show_on_front' => 'page',
			),
			'posts'       => array(
				self::HOME_SLUG => require SOLACE_THEME_DIR . 'inc/compatibility/starter-content/home.php', // PHPCS:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
			),
		);

		return apply_filters( 'solace_starter_content', $content );
	}
}
