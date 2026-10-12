<?php

define('SOLACE_ASSETS_URL', trailingslashit(get_template_directory_uri()) . 'assets/');
define('SOLACE_MAIN_DIR', get_template_directory() . '/');
define( 'SOLACE_THEME_DIR', trailingslashit( get_template_directory() ) );

if (!defined('SOLACE_DEBUG')) {
	define('SOLACE_DEBUG', false);
}

/**
 * solace functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package solace
 */

if (!defined('SOLACE_VERSION')) {
	// Replace the version number of the theme on each release.
	define('SOLACE_VERSION', '2.1.25');
}

require_once 'inc/compatibility/class-solace-starter-content.php';

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function solace_setup()
{
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on solace, use a find and replace
		* to change 'solace' to the name of your theme in all the template files.
		*/
	load_theme_textdomain('solace', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');
	add_theme_support('custom-logo', array(
		'height' => 480,
		'width'  => 720,
	));
	add_theme_support("responsive-embeds");
	add_theme_support("align-wide");
	add_theme_support("wp-block-styles");
	add_theme_support('editor-styles');
	add_editor_style('editor-style.css');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');
	// add_image_size('solace-single2', 923, 450, true);
	add_image_size('solace-single2', 2000, 975, true);
	add_image_size('solace-single-default', 1220, 700, true);
	add_image_size('solace-default-blog', 1214, 715, true);
	add_image_size( 'solace-related-posts', 250, 277, true );
	add_image_size( 'solace-wc-shop-layout3-layout4-layout6', 350, 500, true );


	add_theme_support('custom-logo', array(
		'height' => 480,
		'width'  => 720,
	));

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'solace_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	remove_theme_support('widgets-block-editor');

	// Add support for starter content ( wp preview ).
	if ( class_exists( 'Solace_Starter_Content', false ) ) {
		$solace_starter_content = new Solace_Starter_Content();
		add_theme_support( 'starter-content', $solace_starter_content->get() );
	}
}
add_action('after_setup_theme', 'solace_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function solace_content_width()
{
	$GLOBALS['content_width'] = apply_filters('solace_content_width', 640);
}
add_action('after_setup_theme', 'solace_content_width', 0);

function solace_register_block_patterns()
{
	register_block_pattern(
		'solace/my-example',
		array(
			'title'         => esc_html__('Solace Block Pattern', 'solace'),
			'description'   => _x('Solace block pattern', 'Block pattern description', 'solace'),
			'content'       => '<!-- wp:paragraph --><p>A single paragraph block style</p><!-- /wp:paragraph -->',
			'categories'    => array('text'),
			'keywords'      => array('cta', 'demo', 'example'),
			'viewportWidth' => 800,
		)
	);
	register_block_style('core/cover', [
		'name' => 'my-cover',
		'label' => esc_html__('My custom cover', 'solace'),
	]);
}
add_action('init', 'solace_register_block_patterns');

/**
 * Solace set posts per page […]
 */
// if (!function_exists('solace_set_posts_per_page')) :
// 	function solace_set_posts_per_page( $query ) {
// 		if (
// 			defined( 'REST_REQUEST' ) && REST_REQUEST
// 			&& isset( $_SERVER['REQUEST_URI'] )
// 			&& strpos( $_SERVER['REQUEST_URI'], '/wp-json/elementor/v1/import-export-customization/export' ) !== false
// 		) {
// 			return;
// 		}

// 		if ( is_admin() && !is_customize_preview() ) {
// 			return;
// 		}

// 		if ( class_exists( 'WooCommerce' ) ) {
// 			if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) { 
// 				return;
// 			}
// 		}

// 		if ( class_exists( 'Solace_Extra' ) && function_exists('solace_is_run_in_shortcode') ) {
// 			if ( solace_is_run_in_shortcode() ) {
// 				return;
// 			}
// 		}

// 		if ( is_admin() && is_customize_preview() ) {
// 			return;
// 		}

// 		// Only apply to the main query (not sidebars, widgets, etc.).
// 		if ( ! $query->is_main_query() ) {
// 			return;
// 		}

// 		// Only for post archives (category, tag, author, date). Not blog home.
// 		if ( ! $query->is_archive() ) {
// 			return;
// 		}

// 		$post_type = $query->get( 'post_type' );
// 		if ( $post_type && $post_type !== 'post' ) {
// 			return; // Leave custom post type archives (e.g. products) unchanged.
// 		}

// 		$layout_blog = get_theme_mod('solace_blog_archive_layout', '3x3');
// 		$layout_blog_posts = get_theme_mod('solace_blog_layout_custom_posts', 10);

// 		switch ( $layout_blog ) {
// 			case '3x3':
// 				$posts_per_page = 9;
// 				break;
// 			case '2x3':
// 				$posts_per_page = 6;
// 				break;
// 			case '1x3':
// 				$posts_per_page = 3;
// 				break;
// 			case 'custom':
// 				$posts_per_page = absint($layout_blog_posts);
// 				break;			
// 			default:
// 				$posts_per_page = -1;
// 				break;
// 		}
		
// 		$query->set( 'posts_per_page', $posts_per_page );
// 	}
	
// 	add_action( 'pre_get_posts', 'solace_set_posts_per_page' );
// endif;

function solace_custom_blog_posts_per_page( $posts_per_page ) {
    if ( is_admin() ) {
        return $posts_per_page;
    }

    if ( is_home() || is_archive() || is_search() ) {
        
        if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
            return $posts_per_page;
        }

        $layout_blog = get_theme_mod( 'solace_blog_archive_layout', '3x3' );
        $layout_blog_posts = get_theme_mod( 'solace_blog_layout_custom_posts', 10 );

        switch ( $layout_blog ) {
            case '3x3': return 9;
            case '2x3': return 6;
            case '1x3': return 3;
            case 'custom': return absint( $layout_blog_posts );
            default: return $posts_per_page;
        }
    }

    return $posts_per_page;
}
add_filter( 'option_posts_per_page', 'solace_custom_blog_posts_per_page' );

/**
 * Remove excerpt text […]
 */
if (!function_exists('solace_remove_excerpt_text_more')) :
	function solace_remove_excerpt_text_more($more)
	{
		if (is_admin()) {
			return $more;
		}

		$more = "";
		return $more;
	}
	add_filter('excerpt_more', 'solace_remove_excerpt_text_more');
endif;

/**
 * Enqueues necessary scripts and styles for the admin area.
 *
 * @param string $hook The current admin page hook.
 */
function solace_enqueue_admin( $hook ) {
	// Enqueue styles admin global.
	wp_enqueue_style( 'solace-admin-global-style', get_template_directory_uri() . '/assets-solace/css/admin-global.css?v=' . time(), array(), SOLACE_VERSION );

	// Enqueue script admin global.
	wp_enqueue_script( 'solace-admin-global-script', get_template_directory_uri() . '/assets-solace/js/admin-global.js?v=' . time(), array( 'jquery' ), SOLACE_VERSION, true );

	// Localize admin.
	wp_localize_script(
		'solace-admin-global-script',
		'adminLocalize',
		array(
			'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
			'ajaxNonce' => wp_create_nonce( 'solace-ajax-verification' ),
			'adminUrl'  => esc_url( admin_url() ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'solace_enqueue_admin' );

/**
 * Load Google Fonts for the Solace theme
 * 
 * This function enqueues the DM Sans font family from Google Fonts
 * to be used throughout the theme. The font is loaded with all
 * available weights (100-1000) and styles (normal and italic).
 * 
 * @since 1.0.0
 * @return void
 */
function solace_load_fonts() {
    // Load DM Sans font to front-end and Gutenberg editor
    wp_enqueue_style(
        'solace-dm-sans',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap',
        array(),
        null
    );
}
add_action( 'wp_enqueue_scripts', 'solace_load_fonts' );
add_action( 'enqueue_block_editor_assets', 'solace_load_fonts' );

/**
 * Enqueue styles used by "Additional CSS class(es)" on both frontend and editor.
 *
 * Loads a single stylesheet in both contexts so custom utility classes
 * work consistently in Gutenberg and on the public site.
 */
function solace_enqueue_additional_class_styles() {
	// Unique handle for this stylesheet
	$handle = 'solace-additional-classes';

	// Path to shared CSS for Additional CSS classes
	$src = get_template_directory_uri() . '/assets/css/additional-class.css';

	// Use theme version for cache busting
	wp_enqueue_style( $handle, $src, array(), SOLACE_VERSION );
}

// Frontend
add_action( 'wp_enqueue_scripts', 'solace_enqueue_additional_class_styles' );

// Gutenberg editor
add_action( 'enqueue_block_editor_assets', 'solace_enqueue_additional_class_styles' );

/**
 * Enqueue scripts and styles.
 */
function solace_scripts()
{

	wp_enqueue_style('solace-theme', get_template_directory_uri() . '/assets-solace/css/theme.min.css?v=' . time(), array(), SOLACE_VERSION);
	wp_style_add_data('solace-theme', 'rtl', 'replace');

	wp_enqueue_script('solace-navigation', get_template_directory_uri() . '/js/navigation.js?v=' . time(), array(), SOLACE_VERSION, true);
	
	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}

	$h1 = esc_html(get_theme_mod('solace_h1_font_family_general', 'DM Sans, sans-serif'));
    $h2 = esc_html(get_theme_mod('solace_h2_font_family_general', 'DM Sans, sans-serif'));
    $h3 = esc_html(get_theme_mod('solace_h3_font_family_general', 'DM Sans, sans-serif'));
    $h4 = esc_html(get_theme_mod('solace_h4_font_family_general', 'DM Sans, sans-serif'));
    $h5 = esc_html(get_theme_mod('solace_h5_font_family_general', 'DM Sans, sans-serif'));
    $h6 = esc_html(get_theme_mod('solace_h6_font_family_general', 'DM Sans, sans-serif'));

	$fonts = array(
		'Arial, Helvetica, sans-serif',
		'Arial Black, Gadget, sans-serif',
		'Bookman Old Style, serif',
		'Comic Sans MS, cursive',
		'Courier, monospace',
		'Georgia, serif',
		'Garamond, serif',
		'Impact, Charcoal, sans-serif',
		'Lucida Console, Monaco, monospace',
		'Lucida Sans Unicode, Lucida Grande, sans-serif',
		'MS Sans Serif, Geneva, sans-serif',
		'MS Serif, New York, sans-serif',
		'Palatino Linotype, Book Antiqua, Palatino, serif',
		'Tahoma, Geneva, sans-serif',
		'Times New Roman, Times, serif',
		'Trebuchet MS, Helvetica, sans-serif',
		'Verdana, Geneva, sans-serif',
		'Paratina Linotype',
		'Trebuchet MS',
		// 'Manrope, sans-serif'
	);
	for ($i = 1; $i <= 6; $i++) {
		$heading = 'h' . $i;
		$fontVariable = 'h' . $i;
		
		if (!in_array($$fontVariable, $fonts)) {
			wp_enqueue_style('google-fonts-' . $heading, 'https://fonts.googleapis.com/css?family=' . $$fontVariable . '&display=swap');
		}
	}
}
add_action('wp_enqueue_scripts', 'solace_scripts');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function solace_widgets_init()
{
	register_sidebar(
		array(
			'name'          => esc_html__('Sidebar', 'solace'),
			'id'            => 'sidebar-1',
			'description'   => esc_html__('Add widgets here.', 'solace'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h5 class="widget-title">',
			'after_title'   => '</h5>',
		)
	);
}
// add_action('widgets_init', 'solace_widgets_init');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/component-style/all-widgets.php';
require get_template_directory() . '/inc/customizer/component-style/header-button1.php';
require get_template_directory() . '/inc/customizer/component-style/header-button2.php';
require get_template_directory() . '/inc/customizer/component-style/footer-button1.php';
require get_template_directory() . '/inc/customizer/component-style/footer-button2.php';
require get_template_directory() . '/inc/customizer/component-style/header-row.php';
require get_template_directory() . '/inc/customizer/component-style/footer-row.php';
require get_template_directory() . '/inc/customizer/component-style/menu-icon.php';
require get_template_directory() . '/inc/customizer/page-setting/page-setting.php';
require get_template_directory() . '/inc/customizer/woocommerce/store-notice.php';

/**
 * Customizer.
 */
require get_template_directory() . '/inc/customizer/tab-header/register.php';
require get_template_directory() . '/inc/customizer/tab-footer/register.php';
require get_template_directory() . '/inc/customizer/page-settings/btn-plus-minus.php';
require get_template_directory() . '/inc/customizer/page-settings/customizer.php';
require get_template_directory() . '/inc/customizer/page-settings/callback.php';

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
	// require get_template_directory() . '/inc/woocommerce.php';
	require get_template_directory() . '/inc/wc-custom.php';
}

function solace_custom_meta_box_markup($object)
{
	wp_nonce_field(basename(__FILE__), "meta-box-nonce");

?>
	<div>
	<input name="single-hide-title" type="checkbox" value="1" <?php checked(get_post_meta($object->ID, "single-hide-title", true), 1); ?>>
	<label for="single-hide-title"><?php esc_html_e('Hide Title', 'solace'); ?></label>	
	</div>
<?php
}

function solace_single_hide_title_meta_box()
{
	add_meta_box("single-hide-title", esc_html__("Solace Options", "solace"), "solace_custom_meta_box_markup", array("page", "post"), "side", "high", null);
}

add_action("add_meta_boxes", "solace_single_hide_title_meta_box");

function solace_save_custom_meta_box($post_id, $post, $update)
{
	if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__)))
		return $post_id;

	if (!current_user_can("edit_post", $post_id))
		return $post_id;

	if (defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
		return $post_id;
	
	$allowed_post_types = array("page", "post"); 
	if (!in_array($post->post_type, $allowed_post_types))
		return $post_id;

	$meta_box_text_value = "";
	$meta_box_checkbox_value = "";

	if (isset($_POST["single-hide-title"])) {
		$meta_box_checkbox_value = $_POST["single-hide-title"];
	}
	update_post_meta($post_id, "single-hide-title", sanitize_text_field($meta_box_checkbox_value));
}

add_action("save_post", "solace_save_custom_meta_box", 10, 3);


/**
 * Remove widget block
 *
 * @return void
 */
function solace_remove_block_widget()
{
	unregister_widget("WP_Widget_Block");
}
// add_action('widgets_init', 'solace_remove_block_widget');

require_once 'globals/migrations.php';
require_once 'globals/utilities.php';
require_once 'globals/hooks.php';
require_once 'globals/sanitize-functions.php';
require_once get_template_directory() . '/start.php';
require_once 'inc/compatibility/elementor/color.php';
require_once 'inc/compatibility/elementor/button.php';
require_once 'inc/compatibility/elementor/font.php';
require_once 'inc/notices.php';

/**
 * If the new widget editor is available,
 * we re-assign the widgets to hfg_footer
 */
if (solace_is_new_widget_editor()) {
	/**
	 * Re-assign the widgets to hfg_footer
	 *
	 * @param array  $section_args The section arguments.
	 * @param string $section_id The section ID.
	 * @param string $sidebar_id The sidebar ID.
	 *
	 * @return mixed
	 */
	function solace_customizer_custom_widget_areas($section_args, $section_id, $sidebar_id)
	{
		if (strpos($section_id, 'widgets-footer')) {
			$section_args['panel'] = 'hfg_footer';
		}

		return $section_args;
	}

	add_filter('customizer_widgets_section_args', 'solace_customizer_custom_widget_areas', 10, 3);
}

require_once get_template_directory() . '/header-footer-grid/loader.php';

// Metabox Singular Layout (Post & Page)
require_once get_template_directory() . '/inc/metabox/singular-layout.php';

// Single post element (layout custom)
require get_template_directory() . '/inc/customizer/single/single-custom.php';

function my_theme_custom_colors() {
    add_theme_support(
        'editor-color-palette',
        array(
            
			array(
                'name' => __( 'Base Font', 'solace' ),
                'slug' => 'base-font',
                'color' => 'var(--sol-color-base-font)',
            ),
            array(
                'name' => __( 'Heading', 'solace' ),
                'slug' => 'heading',
                'color' => 'var(--sol-color-heading)',
            ),
            array(
                'name' => __( 'Link Initial', 'solace' ),
                'slug' => 'link-button-initial',
                'color' => 'var(--sol-color-link-button-initial)',
            ),
            array(
                'name' => __( 'Link Hover', 'solace' ),
                'slug' => 'link-button-hover',
                'color' => 'var(--sol-color-link-button-hover)',
            ),
			array(
                'name' => __( 'Button', 'solace' ),
                'slug' => 'button-initial',
                'color' => 'var(--sol-color-button-initial)',
            ),
            array(
                'name' => __( 'Button Hover', 'solace' ),
                'slug' => 'button-hover',
                'color' => 'var(--sol-color-button-hover)',
            ),
            array(
                'name' => __( 'Text Selection Color', 'solace' ),
                'slug' => 'selection-color',
                'color' => 'var(--sol-color-selection-initial)',
            ),
            array(
                'name' => __( 'Text Selection Background', 'solace' ),
                'slug' => 'selection-background',
                'color' => 'var(--sol-color-selection-high)',
            ),
            array(
                'name' => __( 'Border', 'solace' ),
                'slug' => 'border',
                'color' => 'var(--sol-color-border)',
            ),
            array(
                'name' => __( 'Background', 'solace' ),
                'slug' => 'background',
                'color' => 'var(--sol-color-background)',
            ),
            array(
                'name' => __( 'Page Title Color', 'solace' ),
                'slug' => 'page-title-text',
                'color' => 'var(--sol-color-page-title-text)',
            ),
            array(
                'name' => __( 'Page Title Background', 'solace' ),
                'slug' => 'page-title-background',
                'color' => 'var(--sol-color-page-title-background)',
            ),
			array(
                'name' => __( 'Submenu Background', 'solace' ),
                'slug' => 'bg-menu-dropdown',
                'color' => 'var(--sol-color-bg-menu-dropdown)',
            ),
        )
    );
}
add_action( 'after_setup_theme', 'my_theme_custom_colors' );

function solace_activate_elementor_features_on_plugin_activation( $plugin ) {
    if ( $plugin === 'elementor/elementor.php' ) {
        // Aktifkan opsi "Disable Default Colors"
        update_option( 'elementor_disable_color_schemes', 'yes' );

        // Aktifkan opsi "Disable Default Fonts"
        update_option( 'elementor_disable_typography_schemes', 'yes' );
    }
}
add_action( 'activate_plugin', 'solace_activate_elementor_features_on_plugin_activation' );

// Set width style editor
function solace_set_editor_width($args) {
	if ($args === 'fullwidth') {
		echo '<style>
		.wp-block {
			max-width: 100%;
			margin-left: auto;
			margin-right: auto;
		}
		</style>';
	} else if ($args === 'boxed') {
		echo '<style>
		.wp-block {
			max-width: 708px;
			margin-left: auto;
			margin-right: auto;
		}
		</style>';
	} else if ($args === 'left') {
		echo '<style>
		.wp-block {
			max-width: 1280px;
			margin-left: auto;
			margin-right: auto;
		}
		</style>';
	} else if ($args === 'right') {
		echo '<style>
		.wp-block {
			max-width: 1280px;
			margin-left: auto;
			margin-right: auto;
		}
		</style>';
	}
}

// Set width Gutenberg Editor
function sola_width_gutenberg() {
	// Current_screen
	$current_screen = get_current_screen();

	// Container
	$container_list_layout = get_theme_mod( 'solace_container_layout', 'custom' );

    // Single
    $single_list_layout = get_theme_mod( 'solace_post_layout', 'inherit' );
    $metabox_sidebar_layout = get_post_meta(get_the_ID(), 'sol_layout_singular', 'inherit');
	if (empty($metabox_sidebar_layout)) {
		$metabox_sidebar_layout = 'inherit';
	}

    // Page
    $page_hide_title = get_theme_mod( 'solace_page_layout_hide_title', false );
    $page_list_layout = get_theme_mod( 'solace_page_layout', 'inherit' ); 	

	// Post
    if ($current_screen->post_type === 'post') {
		// Single Inherit
		if ($single_list_layout === 'inherit' && $metabox_sidebar_layout === 'inherit') {
			solace_set_editor_width($container_list_layout);
		}

		// Single Single_templates
		if ($single_list_layout !== 'inherit' && $metabox_sidebar_layout === 'inherit') {
			solace_set_editor_width($single_list_layout);
		}

		// Single metabox_templates
		if ($metabox_sidebar_layout !== 'inherit') {
			solace_set_editor_width($metabox_sidebar_layout);
		}
    } elseif ($current_screen->post_type === 'page') {
		// Page Inherit
		if ($page_list_layout === 'inherit' && $metabox_sidebar_layout === 'inherit') {
			solace_set_editor_width($container_list_layout);
		}

		// Page Single_templates
		if ($page_list_layout !== 'inherit' && $metabox_sidebar_layout === 'inherit') {
			solace_set_editor_width($page_list_layout);
		}

		// Page metabox_templates
		if ($metabox_sidebar_layout !== 'inherit') {
			solace_set_editor_width($metabox_sidebar_layout);
		}
    }
}
add_action('admin_head', 'sola_width_gutenberg');

function custom_elementor_admin_styles() {
    ?>
    <style>
        .elementor-control-solace_colors .elementor-repeater-fields:nth-child(1),
        .elementor-control-solace_colors .elementor-repeater-fields:nth-child(5),
        .elementor-control-solace_colors .elementor-repeater-fields:nth-child(12),
        .elementor-control-solace_colors .elementor-repeater-fields:nth-child(13) {
            display: none;
        }

		.elementor-control-system_typography .elementor-repeater-fields:nth-child(5),
		.elementor-control-system_typography .elementor-repeater-fields:nth-child(12),
		.elementor-control-system_typography .elementor-repeater-fields:nth-child(13),
		.elementor-control-system_typography .elementor-repeater-fields:nth-child(14) {
            display: none;
        }

		/* hide global colors in popover */
		[data-global-id="solcolorbasefont"],
		[data-global-id="solcolorbuttoninitial"],
		[data-global-id="solcolorpagetitlebackground"],
		[data-global-id="solcolorbgmenudropdown"],
		[data-global-id="solace_body_font_family"],
		[data-global-id="solace_smaller_font_family"],
		[data-global-id="solace_logotitle_font_family"],
		[data-global-id="solace_button_font_family"] {
			display: none !important;
		}

    </style>
    <?php
}

add_action( 'elementor/editor/before_enqueue_scripts', 'custom_elementor_admin_styles' );


// require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Add inline style.
 */
require get_template_directory() . '/inc/add-inline-style.php';

add_action( 'tgmpa_register', 'solace_register_required_plugins' );

function solace_register_required_plugins() {
    $plugins = array(
        array(
            'name'     => 'Solace Extra',
            'slug'     => 'solace-extra',
            'source'   => 'https://wordpress.org/plugins/solace-extra/',
            'required' => true,
        ),
    );

    $config = array(
        'id'           => 'my-theme-plugins',
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'parent_slug'  => 'themes.php',
        'capability'   => 'edit_theme_options',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => true,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'solace' ),
			'menu_title'                      => __( 'Install Plugins', 'solace' ),
			'installing'                      => __( 'Installing Plugin: %s', 'solace' ),
			'oops'                            => __( 'Something went wrong with the plugin API.', 'solace' ),
			'notice_can_install_required'     => _n_noop( 'Solace Theme requires the following plugin: %1$s.', 'Solace Theme requires the following plugins: %1$s.', 'solace' ),
			'notice_can_install_recommended'  => _n_noop( 'Solace Theme recommends the following plugin: %1$s.', 'Solace Theme recommends the following plugins: %1$s.', 'solace' ),
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'solace' ),
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'solace' ),
			'notice_ask_to_update_maybe'      => _n_noop( 'There is an update available for: %1$s.', 'There are updates available for the following plugins: %1$s.', 'solace' ),
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'solace' ),
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'solace' ),
			'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'solace' ),
			'return'                          => __( 'Return to Required Plugins Installer', 'solace' ),
			'plugin_activated'                => __( 'Plugin activated successfully.', 'solace' ),
			'complete'                        => __( 'All plugins installed and activated successfully. %s', 'solace' ),
			'nag_type'                        => 'updated', 

        ),
    );

    tgmpa( $plugins, $config );
}

// Fix if Header Footer Builder not Shown
remove_theme_mod('solace_new_skin');

$header_contact = get_theme_mod( 'header_contact_header_contact_setting', 'phonesolcommaemailsolcomma123456solcommacontact@example.comsolcommasolcommasolcommaphonesolcommaemail' );
$footer_contact = get_theme_mod( 'footer_contact_footer_contact_setting', 'phonesolcommaemailsolcomma123456solcommacontact@example.comsolcommasolcommasolcommaphonesolcommaemail' );

// Clear Header Contact
if (strpos($header_contact, 'solcomma') === false) {
    remove_theme_mod( 'header_contact_header_contact_setting' );
}

// Clear Footer Contact
if (strpos($footer_contact, 'solcomma') === false) {
    remove_theme_mod( 'footer_contact_footer_contact_setting' );
}


// Woocommerce.
require get_template_directory() . '/inc/customizer/component-style/woocommerce-product-page.php';
require get_template_directory() . '/inc/customizer/component-style/woocommerce-single-product.php';

/**
 * Override WooCommerce Single Product gallery thumbnail resolution to 300px
 */
if ( class_exists( 'WooCommerce' ) ) {
	// change woocommerce thumbnail image size
	add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'solace_woocommerce_image_size_gallery_thumbnail' );
	
	function solace_woocommerce_image_size_gallery_thumbnail( $size ) {
		// Gallery thumbnails: proportional, max width 300px
		return array(
			'width'  => 300,
			'height' => 300,
			'crop'   => 0,
		);
	}
}

// Inheritance customizer.
require get_template_directory() . '/inc/customizer/inheritance/submenu-background.php';

/**
 * Uploads a default logo image to the WordPress Media Library.
 */
function solace_upload_image_logo() {
    // Check if the image has already been uploaded
    $uploaded_image_id = get_option('solace_uploaded_image_id');

    if ($uploaded_image_id) {
        // Image has already been uploaded, no need to upload again
        // echo 'Image already uploaded with attachment ID: ' . $uploaded_image_id;
        return;
    }

    // Include necessary WordPress files for file handling and media upload
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    // Define the image URL
    $image_url = esc_url( SOLACE_ASSETS_URL ) . 'img/solace-default-logo-dark.png';

    // Extract the file name from the URL
    $filename = basename($image_url);

    // Download the file to a temporary location
    $tmp_file = download_url($image_url);

    if (is_wp_error($tmp_file)) {
        // Handle errors during the download process
        return $tmp_file;
    }

    // Prepare the file array for media upload
    $file_array = array(
        'name'     => $filename,
        'tmp_name' => $tmp_file
    );

    // Upload the file to the WordPress Media Library
    $attachment_id = media_handle_sideload($file_array, 0);

    // Delete the temporary file after processing
    if (is_wp_error($attachment_id)) {
        @unlink($tmp_file); // Delete the temp file if there's an error
        return $attachment_id;
    }

    // Store the uploaded attachment ID in WordPress options
    update_option('solace_uploaded_image_id', $attachment_id);

	// Set option logo.
	set_theme_mod( 'custom_logo', $attachment_id );

    // Output success message
    // echo 'Image uploaded successfully with attachment ID: ' . $attachment_id;
}
add_action( 'init', 'solace_upload_image_logo' );

/**
 * Sets the number of columns in the footer layout.
 *
 * This function checks if the layout number has already been set. If not, it updates the option
 * 'solace_check_layout_top_collumns_number' to true and sets the theme mod 'hfg_footer_layout_top_columns_number'
 * to 5.
 *
 * @return void
 */
function solace_set_number_of_collumn() {
    // Check if the image has already been uploaded
    $check_layout = get_option('solace_check_layout_top_collumns_number');

    if ($check_layout) {
        return;
    }

    // Store the uploaded attachment ID in WordPress options
    update_option('solace_check_layout_top_collumns_number', true);

    // Set option logo.
    set_theme_mod( 'hfg_footer_layout_top_columns_number', 5 );
}
add_action( 'init', 'solace_set_number_of_collumn' );

/**
 * Adds a configuration to wp-config.php to clear cache after theme updates using WP Fastest Cache plugin.
 *
 * This function initializes the WP_Filesystem, checks if wp-config.php exists and is writable,
 * and then modifies the content of wp-config.php to define the WPFC_CLEAR_CACHE_AFTER_THEME_UPDATE constant.
 *
 * @return void
*/
function solace_add_wpfc_clear_cache_to_wp_config() {
	global $wp_filesystem;

	// Initialize the WP_Filesystem
	if ( ! function_exists( 'WP_Filesystem' ) ) {
		return;
	}

	WP_Filesystem();

	$wp_config_file = ABSPATH . 'wp-config.php';

	// Check if wp-config.php exists and is writable
	if ( $wp_filesystem->is_writable( $wp_config_file ) ) {
		// Get the content of wp-config.php
		$config_content = $wp_filesystem->get_contents( $wp_config_file );

		// Check if the WPFC_CLEAR_CACHE_AFTER_THEME_UPDATE is already defined
		if ( strpos( $config_content, "define('WPFC_CLEAR_CACHE_AFTER_THEME_UPDATE'" ) === false ) {
			// Modify the content
			$config_content = str_replace(
				"/* That's all, stop editing! Happy publishing. */",
				"define('WPFC_CLEAR_CACHE_AFTER_THEME_UPDATE', true);\n/* That's all, stop editing! Happy publishing. */",
				$config_content
			);

			// Write the updated content back to wp-config.php
			$wp_filesystem->put_contents( $wp_config_file, $config_content, FS_CHMOD_FILE );
		}
	}
}
add_action( 'init', 'solace_add_wpfc_clear_cache_to_wp_config' );

// Purge litespeed.
function solace_purge_litespeed_cache() {
    if ( defined( 'LSCWP_V' ) ) { 
        do_action( 'litespeed_purge_all' );
    }
}
add_action('customize_save_after', 'solace_purge_litespeed_cache');

/**
 * Runs after a theme has been updated, and purges the LiteSpeed cache
 * if the updated theme is 'solace'.
 *
 * @param WP_Upgrader $upgrader_object WordPress upgrader instance.
 * @param array       $options         Array containing type, action, and theme information.
 *
 * @return void
 */
add_action( 'upgrader_process_complete', function ($upgrader_object, $options) {
    if ($options['type'] === 'theme' && $options['action'] === 'update') {
        $updated_themes = $options['themes'] ?? [];

        if (in_array('solace', $updated_themes, true)) {
            // Run the cache purge function after theme update
            solace_purge_litespeed_cache();
			// error_log('[solace] Purging LiteSpeed cache after theme update.');
        }
    }
}, 10, 2);
/**
 * Elementor WooCommerce widgets compatibility stylesheet.
 * Loaded only when Elementor is active and the current page is WooCommerce.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! did_action( 'elementor/loaded' ) || ! function_exists( 'is_woocommerce' ) ) {
		return;
	}
	if ( ! ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) {
		return;
	}
	wp_enqueue_style(
		'solace-elementor-woo-widgets',
		get_stylesheet_directory_uri() . '/elementor-woo-widgets.css',
		array(),
		'1.0.2'
	);
	wp_enqueue_style(
		'solace-elementor-wc-elements',
		get_stylesheet_directory_uri() . '/elementor-wc-elements.css',
		array( 'solace-elementor-woo-widgets', 'woocommerce-general', 'woocommerce-layout' ),
		'1.0.0'
	);
}, 20 );
