<?php

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Settings\Customizer_Defaults;

// Check if the WooCommerce plugin is active.
if (! class_exists('WooCommerce')) {
    return;
}

/**
 * Check if the current page is a product page. If not, exit the function.
 */
// if ( ! is_product() ) {
//     return;
// }

/**
 * Adds custom classes to the single product layout based on the selected layout option from the theme customizer settings.
 *
 * This function adds corresponding classes to the single product layout based on the selected layout option from the theme customizer settings.
 *
 * @param string $classes The classes array to which the custom classes will be added.
 */
function solace_add_custom_single_product_layout_classes($classes)
{
    // Get the selected single product layout from the theme customizer settings.
    $single_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
    );

    // Get the setting for enabling/disabling image lightbox on the single product page.
    $image_lightbox = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_LIGHTBOX)
    );

    // Get the setting for enabling/disabling image zoom on the single product page.    
    $image_zoom = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_IMAGE_ZOOM)
    );

    // Add corresponding class based on the selected layout.
    if ('single-product-layout-left' === $single_layout) {
        $classes .= ' solace-product-layout-left';
    } else if ('single-product-layout-right' === $single_layout) {
        $classes .= ' solace-product-layout-right';
    } else if ('single-product-special1' === $single_layout) {
        $classes .= ' solace-product-layout-special1';
    } else if ('single-product-special2' === $single_layout) {
        $classes .= ' solace-product-layout-special2';
    } else if ('single-product-layout-custom' === $single_layout) {
        $classes .= ' solace-product-layout-custom';
    }

    // Add class to disable image lightbox if the setting is turned off.
    if (! $image_lightbox) {
        $classes .= ' solace-single-disable-image-lightbox';
    }

    // Add class to disable image zoom if the setting is turned off.
    if (! $image_zoom) {
        $classes .= ' solace-single-disable-image-zoom';
    }

    return $classes;
}
add_filter('solace_before_shop_classes', 'solace_add_custom_single_product_layout_classes');

/**
 * Filters the WooCommerce template part to conditionally skip loading the single product content template.
 *
 * This function checks if the current page is a single product page and if the selected layout matches
 * a specific custom layout. If so, it prevents the loading of the default single product content template.
 *
 * @param string $template The path to the template file.
 * @param string $slug The slug name for the generic template.
 * @param string $name The name of the specialized template.
 * @return string|null The path to the template file, or null if the template should not be loaded.
 */
function solace_override_single_product_template($template, $slug, $name)
{
    // Get the current single product page layout from the theme customizer settings.
    $single_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
    );

    // Check if the current page is a product page.
    if (is_product()) {

        // Check if the template being loaded is the single product content template and if the custom layout is active.
        if ('content' === $slug && 'single-product' === $name && 'single-product-layout-custom' === $single_layout) {
            // Return null to prevent the template from being loaded.
            return null;
        }
    }

    // Return the original template path if the conditions are not met.
    return $template;
}
// add_filter( 'wc_get_template_part', 'solace_override_single_product_template', 10, 3 );

/**
 * Adjusts the single product layout based on the selected layout option.
 *
 * This function adjusts the single product layout by moving the sale flash and adding a sidebar based on the selected layout option from the theme customizer settings.
 *
 */
function solace_adjust_single_product_layout()
{

    $test = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS)
    );

    // echo '<pre>';
    // print_r($test);
    // echo '</pre>';

    $single_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
    );

    // Move the sale flash to product thumbnails if the layout is 'right'
    if ('single-product-layout-right' === $single_layout) {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 20);
    }

    // Move the sale flash and add sidebar if the layout is 'special1'
    if ('single-product-special1' === $single_layout) {
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
        add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_sale_flash', 20);
        add_action('woocommerce_before_single_product_summary', function () {
            if (is_active_sidebar('shop-sidebar')) {
?>
                <aside id="secondary" class="widget-area">
                    <?php dynamic_sidebar('shop-sidebar'); ?>
                </aside>
<?php
            }
        }, 12);
    }

    if ('single-product-layout-custom' === $single_layout) {
        /**
         * Hook: woocommerce_single_product_summary.
         *
         * @hooked woocommerce_template_single_title - 5
         * @hooked woocommerce_template_single_rating - 10
         * @hooked woocommerce_template_single_price - 10
         * @hooked woocommerce_template_single_excerpt - 20
         * @hooked woocommerce_template_single_add_to_cart - 30
         * @hooked woocommerce_template_single_meta - 40
         * @hooked woocommerce_template_single_sharing - 50
         * @hooked WC_Structured_Data::generate_product_data() - 60
         */

        // Remove the default WooCommerce hooks for the single product summary.
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        // Optionally remove other actions
        // remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        // remove_action('woocommerce_single_product_summary', 'generate_product_data', 60);

        $product_element_add_to_cart = get_theme_mod(
            Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART),
            Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART)
        );        

        if ( isset( $product_element_add_to_cart['title'] ) ) {
            add_filter( 'woocommerce_product_single_add_to_cart_text', function() {
                $product_element_add_to_cart = get_theme_mod(
                    Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART),
                    Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADD_TO_CART)
                );
                
                return $product_element_add_to_cart['title'];
            } );
        }
    
        $prefix = Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS;
        $order_default_components = array(
			$prefix . '-breadcrumbs',
			$prefix . '-title',
			$prefix . '-star-rating',
			$prefix . '-price',
			$prefix . '-short-description',
			$prefix . '-divider-1',
			$prefix . '-add-to-cart',
			$prefix . '-divider-2',
			$prefix . '-meta',
			$prefix . '-payment-methods',
			$prefix . '-additional-info',
        );
    
        $default = wp_json_encode($order_default_components);
    
        $product_elements = get_theme_mod(
            Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS),
            $default
        );
    
        $datas = json_decode($product_elements, true);

        // Loop through the elements and add them back with dynamic priorities.
        foreach ( $datas as $index => $item ) {
            $priority = ($index + 1) * 10; // Set priority dynamically based on the loop index.
            if ( $prefix . '-breadcrumbs' === $item ) {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', $priority );
            } elseif ( $prefix . '-title' === $item ) {
                // Retrieve the heading data from the Customizer settings.
                $heading_data = get_theme_mod(
                    Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE),
                    Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_TITLE)
                );
    
                // Extract the desired heading tag from the Customizer data.
                $title = $heading_data['headingTag'];
    
                // Validate the heading tag to ensure it's one of the allowed values (H1-H6).
                // Convert to lowercase to match the HTML tag format.
                $heading_tag = in_array($title, ['H1', 'H2', 'H3', 'H4', 'H5', 'H6']) ? strtolower($title) : 'h2';
    
                // Add an action to the 'woocommerce_single_product_summary' hook to display the product title.
                // The title will be wrapped in the appropriate heading tag (H1-H6) as specified by the Customizer setting.
                add_action('woocommerce_single_product_summary', function() use ($heading_tag) {
                    // Output the product title with the specified heading tag and appropriate classes.
                    the_title( "<{$heading_tag} class=\"product_title entry-title\">", "</{$heading_tag}>" );
                }, $priority );                
            } elseif ($prefix . '-star-rating' === $item) {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', $priority );
            } elseif ($prefix . '-price' === $item) {
                add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', $priority );
            } elseif ($prefix . '-short-description' === $item) {
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', $priority);
            } elseif ($prefix . '-divider-1' === $item) {
                add_action('woocommerce_single_product_summary', function(){
                   echo "<div class='divider1'></div>";
               }, $priority);
            } elseif ($prefix . '-add-to-cart' === $item) {
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', $priority);
            } elseif ($prefix . '-divider-2' === $item) {
                add_action('woocommerce_single_product_summary', function(){
                    echo "<div class='divider2'></div>";
                }, $priority);                         
            } elseif ($prefix . '-meta' === $item) {
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', $priority);
            } elseif ($prefix . '-payment-methods' === $item) {
                add_action('woocommerce_single_product_summary', function(){
                    $payment_methods = get_theme_mod(
                        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS),
                        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_PAYMENT_METHODS)
                    );
                
                
                    $payment_method_item = $payment_methods['ordering'];
                    echo '<fieldset class="fieldset-payment-methods">';
                        echo '<legend>' . $payment_methods['title'] . '</legend>';
                        echo '<div class="box-payment-methods">';
                        foreach ( $payment_method_item as $index => $item ) {
                            if ( 'Mastercard' === $item || isset( $item['id'] ) && 'Mastercard' === $item['id'] ) {
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M482.9 410.3c0 6.8-4.6 11.7-11.2 11.7-6.8 0-11.2-5.2-11.2-11.7 0-6.5 4.4-11.7 11.2-11.7 6.6 0 11.2 5.2 11.2 11.7zm-310.8-11.7c-7.1 0-11.2 5.2-11.2 11.7 0 6.5 4.1 11.7 11.2 11.7 6.5 0 10.9-4.9 10.9-11.7-.1-6.5-4.4-11.7-10.9-11.7zm117.5-.3c-5.4 0-8.7 3.5-9.5 8.7h19.1c-.9-5.7-4.4-8.7-9.6-8.7zm107.8 .3c-6.8 0-10.9 5.2-10.9 11.7 0 6.5 4.1 11.7 10.9 11.7 6.8 0 11.2-4.9 11.2-11.7 0-6.5-4.4-11.7-11.2-11.7zm105.9 26.1c0 .3 .3 .5 .3 1.1 0 .3-.3 .5-.3 1.1-.3 .3-.3 .5-.5 .8-.3 .3-.5 .5-1.1 .5-.3 .3-.5 .3-1.1 .3-.3 0-.5 0-1.1-.3-.3 0-.5-.3-.8-.5-.3-.3-.5-.5-.5-.8-.3-.5-.3-.8-.3-1.1 0-.5 0-.8 .3-1.1 0-.5 .3-.8 .5-1.1 .3-.3 .5-.3 .8-.5 .5-.3 .8-.3 1.1-.3 .5 0 .8 0 1.1 .3 .5 .3 .8 .3 1.1 .5s.2 .6 .5 1.1zm-2.2 1.4c.5 0 .5-.3 .8-.3 .3-.3 .3-.5 .3-.8 0-.3 0-.5-.3-.8-.3 0-.5-.3-1.1-.3h-1.6v3.5h.8V426h.3l1.1 1.4h.8l-1.1-1.3zM576 81v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V81c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM64 220.6c0 76.5 62.1 138.5 138.5 138.5 27.2 0 53.9-8.2 76.5-23.1-72.9-59.3-72.4-171.2 0-230.5-22.6-15-49.3-23.1-76.5-23.1-76.4-.1-138.5 62-138.5 138.2zm224 108.8c70.5-55 70.2-162.2 0-217.5-70.2 55.3-70.5 162.6 0 217.5zm-142.3 76.3c0-8.7-5.7-14.4-14.7-14.7-4.6 0-9.5 1.4-12.8 6.5-2.4-4.1-6.5-6.5-12.2-6.5-3.8 0-7.6 1.4-10.6 5.4V392h-8.2v36.7h8.2c0-18.9-2.5-30.2 9-30.2 10.2 0 8.2 10.2 8.2 30.2h7.9c0-18.3-2.5-30.2 9-30.2 10.2 0 8.2 10 8.2 30.2h8.2v-23zm44.9-13.7h-7.9v4.4c-2.7-3.3-6.5-5.4-11.7-5.4-10.3 0-18.2 8.2-18.2 19.3 0 11.2 7.9 19.3 18.2 19.3 5.2 0 9-1.9 11.7-5.4v4.6h7.9V392zm40.5 25.6c0-15-22.9-8.2-22.9-15.2 0-5.7 11.9-4.8 18.5-1.1l3.3-6.5c-9.4-6.1-30.2-6-30.2 8.2 0 14.3 22.9 8.3 22.9 15 0 6.3-13.5 5.8-20.7 .8l-3.5 6.3c11.2 7.6 32.6 6 32.6-7.5zm35.4 9.3l-2.2-6.8c-3.8 2.1-12.2 4.4-12.2-4.1v-16.6h13.1V392h-13.1v-11.2h-8.2V392h-7.6v7.3h7.6V416c0 17.6 17.3 14.4 22.6 10.9zm13.3-13.4h27.5c0-16.2-7.4-22.6-17.4-22.6-10.6 0-18.2 7.9-18.2 19.3 0 20.5 22.6 23.9 33.8 14.2l-3.8-6c-7.8 6.4-19.6 5.8-21.9-4.9zm59.1-21.5c-4.6-2-11.6-1.8-15.2 4.4V392h-8.2v36.7h8.2V408c0-11.6 9.5-10.1 12.8-8.4l2.4-7.6zm10.6 18.3c0-11.4 11.6-15.1 20.7-8.4l3.8-6.5c-11.6-9.1-32.7-4.1-32.7 15 0 19.8 22.4 23.8 32.7 15l-3.8-6.5c-9.2 6.5-20.7 2.6-20.7-8.6zm66.7-18.3H408v4.4c-8.3-11-29.9-4.8-29.9 13.9 0 19.2 22.4 24.7 29.9 13.9v4.6h8.2V392zm33.7 0c-2.4-1.2-11-2.9-15.2 4.4V392h-7.9v36.7h7.9V408c0-11 9-10.3 12.8-8.4l2.4-7.6zm40.3-14.9h-7.9v19.3c-8.2-10.9-29.9-5.1-29.9 13.9 0 19.4 22.5 24.6 29.9 13.9v4.6h7.9v-51.7zm7.6-75.1v4.6h.8V302h1.9v-.8h-4.6v.8h1.9zm6.6 123.8c0-.5 0-1.1-.3-1.6-.3-.3-.5-.8-.8-1.1-.3-.3-.8-.5-1.1-.8-.5 0-1.1-.3-1.6-.3-.3 0-.8 .3-1.4 .3-.5 .3-.8 .5-1.1 .8-.5 .3-.8 .8-.8 1.1-.3 .5-.3 1.1-.3 1.6 0 .3 0 .8 .3 1.4 0 .3 .3 .8 .8 1.1 .3 .3 .5 .5 1.1 .8 .5 .3 1.1 .3 1.4 .3 .5 0 1.1 0 1.6-.3 .3-.3 .8-.5 1.1-.8 .3-.3 .5-.8 .8-1.1 .3-.6 .3-1.1 .3-1.4zm3.2-124.7h-1.4l-1.6 3.5-1.6-3.5h-1.4v5.4h.8v-4.1l1.6 3.5h1.1l1.4-3.5v4.1h1.1v-5.4zm4.4-80.5c0-76.2-62.1-138.3-138.5-138.3-27.2 0-53.9 8.2-76.5 23.1 72.1 59.3 73.2 171.5 0 230.5 22.6 15 49.5 23.1 76.5 23.1 76.4 .1 138.5-61.9 138.5-138.4z"/>
                                    </svg>
                                <?php
                            } else if ( 'Visa' === $item || isset( $item['id'] ) && 'Visa' === $item['id'] ) {
                                ?>
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M470.1 231.3s7.6 37.2 9.3 45H446c3.3-8.9 16-43.5 16-43.5-.2 .3 3.3-9.1 5.3-14.9l2.8 13.4zM576 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM152.5 331.2L215.7 176h-42.5l-39.3 106-4.3-21.5-14-71.4c-2.3-9.9-9.4-12.7-18.2-13.1H32.7l-.7 3.1c15.8 4 29.9 9.8 42.2 17.1l35.8 135h42.5zm94.4 .2L272.1 176h-40.2l-25.1 155.4h40.1zm139.9-50.8c.2-17.7-10.6-31.2-33.7-42.3-14.1-7.1-22.7-11.9-22.7-19.2 .2-6.6 7.3-13.4 23.1-13.4 13.1-.3 22.7 2.8 29.9 5.9l3.6 1.7 5.5-33.6c-7.9-3.1-20.5-6.6-36-6.6-39.7 0-67.6 21.2-67.8 51.4-.3 22.3 20 34.7 35.2 42.2 15.5 7.6 20.8 12.6 20.8 19.3-.2 10.4-12.6 15.2-24.1 15.2-16 0-24.6-2.5-37.7-8.3l-5.3-2.5-5.6 34.9c9.4 4.3 26.8 8.1 44.8 8.3 42.2 .1 69.7-20.8 70-53zM528 331.4L495.6 176h-31.1c-9.6 0-16.9 2.8-21 12.9l-59.7 142.5H426s6.9-19.2 8.4-23.3H486c1.2 5.5 4.8 23.3 4.8 23.3H528z"/>
                                    </svg>
                                <?php
                            } else if ( 'Amex' === $item || isset( $item['id'] ) && 'Amex' === $item['id'] ) {
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M0 432c0 26.5 21.5 48 48 48H528c26.5 0 48-21.5 48-48v-1.1H514.3l-31.9-35.1-31.9 35.1H246.8V267.1H181L262.7 82.4h78.6l28.1 63.2V82.4h97.2L483.5 130l17-47.6H576V80c0-26.5-21.5-48-48-48H48C21.5 32 0 53.5 0 80V432zm440.4-21.7L482.6 364l42 46.3H576l-68-72.1 68-72.1H525.4l-42 46.7-41.5-46.7H390.5L458 338.6l-67.4 71.6V377.1h-83V354.9h80.9V322.6H307.6V300.2h83V267.1h-122V410.3H440.4zm96.3-72L576 380.2V296.9l-39.3 41.4zm-36.3-92l36.9-100.6V246.3H576V103H515.8l-32.2 89.3L451.7 103H390.5V246.1L327.3 103H276.1L213.7 246.3h43l11.9-28.7h65.9l12 28.7h82.7V146L466 246.3h34.4zM282 185.4l19.5-46.9 19.4 46.9H282z"/>
                                </svg>
                                <?php
                            } else if ( 'Discover' === $item || isset( $item['id'] ) && 'Discover' === $item['id'] ) {
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M520.4 196.1c0-7.9-5.5-12.1-15.6-12.1h-4.9v24.9h4.7c10.3 0 15.8-4.4 15.8-12.8zM528 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zm-44.1 138.9c22.6 0 52.9-4.1 52.9 24.4 0 12.6-6.6 20.7-18.7 23.2l25.8 34.4h-19.6l-22.2-32.8h-2.2v32.8h-16zm-55.9 .1h45.3v14H444v18.2h28.3V217H444v22.2h29.3V253H428zm-68.7 0l21.9 55.2 22.2-55.2h17.5l-35.5 84.2h-8.6l-35-84.2zm-55.9-3c24.7 0 44.6 20 44.6 44.6 0 24.7-20 44.6-44.6 44.6-24.7 0-44.6-20-44.6-44.6 0-24.7 20-44.6 44.6-44.6zm-49.3 6.1v19c-20.1-20.1-46.8-4.7-46.8 19 0 25 27.5 38.5 46.8 19.2v19c-29.7 14.3-63.3-5.7-63.3-38.2 0-31.2 33.1-53 63.3-38zm-97.2 66.3c11.4 0 22.4-15.3-3.3-24.4-15-5.5-20.2-11.4-20.2-22.7 0-23.2 30.6-31.4 49.7-14.3l-8.4 10.8c-10.4-11.6-24.9-6.2-24.9 2.5 0 4.4 2.7 6.9 12.3 10.3 18.2 6.6 23.6 12.5 23.6 25.6 0 29.5-38.8 37.4-56.6 11.3l10.3-9.9c3.7 7.1 9.9 10.8 17.5 10.8zM55.4 253H32v-82h23.4c26.1 0 44.1 17 44.1 41.1 0 18.5-13.2 40.9-44.1 40.9zm67.5 0h-16v-82h16zM544 433c0 8.2-6.8 15-15 15H128c189.6-35.6 382.7-139.2 416-160zM74.1 191.6c-5.2-4.9-11.6-6.6-21.9-6.6H48v54.2h4.2c10.3 0 17-2 21.9-6.4 5.7-5.2 8.9-12.8 8.9-20.7s-3.2-15.5-8.9-20.5z"/>
                                </svg>
                                <?php
                            } else if ( 'Paypal' === $item || isset( $item['id'] ) && 'Paypal' === $item['id'] ) {
                                ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M186.3 258.2c0 12.2-9.7 21.5-22 21.5-9.2 0-16-5.2-16-15 0-12.2 9.5-22 21.7-22 9.3 0 16.3 5.7 16.3 15.5zM80.5 209.7h-4.7c-1.5 0-3 1-3.2 2.7l-4.3 26.7 8.2-.3c11 0 19.5-1.5 21.5-14.2 2.3-13.4-6.2-14.9-17.5-14.9zm284 0H360c-1.8 0-3 1-3.2 2.7l-4.2 26.7 8-.3c13 0 22-3 22-18-.1-10.6-9.6-11.1-18.1-11.1zM576 80v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V80c0-26.5 21.5-48 48-48h480c26.5 0 48 21.5 48 48zM128.3 215.4c0-21-16.2-28-34.7-28h-40c-2.5 0-5 2-5.2 4.7L32 294.2c-.3 2 1.2 4 3.2 4h19c2.7 0 5.2-2.9 5.5-5.7l4.5-26.6c1-7.2 13.2-4.7 18-4.7 28.6 0 46.1-17 46.1-45.8zm84.2 8.8h-19c-3.8 0-4 5.5-4.2 8.2-5.8-8.5-14.2-10-23.7-10-24.5 0-43.2 21.5-43.2 45.2 0 19.5 12.2 32.2 31.7 32.2 9 0 20.2-4.9 26.5-11.9-.5 1.5-1 4.7-1 6.2 0 2.3 1 4 3.2 4H200c2.7 0 5-2.9 5.5-5.7l10.2-64.3c.3-1.9-1.2-3.9-3.2-3.9zm40.5 97.9l63.7-92.6c.5-.5 .5-1 .5-1.7 0-1.7-1.5-3.5-3.2-3.5h-19.2c-1.7 0-3.5 1-4.5 2.5l-26.5 39-11-37.5c-.8-2.2-3-4-5.5-4h-18.7c-1.7 0-3.2 1.8-3.2 3.5 0 1.2 19.5 56.8 21.2 62.1-2.7 3.8-20.5 28.6-20.5 31.6 0 1.8 1.5 3.2 3.2 3.2h19.2c1.8-.1 3.5-1.1 4.5-2.6zm159.3-106.7c0-21-16.2-28-34.7-28h-39.7c-2.7 0-5.2 2-5.5 4.7l-16.2 102c-.2 2 1.3 4 3.2 4h20.5c2 0 3.5-1.5 4-3.2l4.5-29c1-7.2 13.2-4.7 18-4.7 28.4 0 45.9-17 45.9-45.8zm84.2 8.8h-19c-3.8 0-4 5.5-4.3 8.2-5.5-8.5-14-10-23.7-10-24.5 0-43.2 21.5-43.2 45.2 0 19.5 12.2 32.2 31.7 32.2 9.3 0 20.5-4.9 26.5-11.9-.3 1.5-1 4.7-1 6.2 0 2.3 1 4 3.2 4H484c2.7 0 5-2.9 5.5-5.7l10.2-64.3c.3-1.9-1.2-3.9-3.2-3.9zm47.5-33.3c0-2-1.5-3.5-3.2-3.5h-18.5c-1.5 0-3 1.2-3.2 2.7l-16.2 104-.3 .5c0 1.8 1.5 3.5 3.5 3.5h16.5c2.5 0 5-2.9 5.2-5.7L544 191.2v-.3zm-90 51.8c-12.2 0-21.7 9.7-21.7 22 0 9.7 7 15 16.2 15 12 0 21.7-9.2 21.7-21.5 .1-9.8-6.9-15.5-16.2-15.5z"/>
                                </svg>
                                <?php
                            }
                        }
                        echo '</div>';
                    echo '</fieldset>';
                }, $priority);       
            } elseif ($prefix . '-additional-info' === $item) {
                add_action('woocommerce_single_product_summary', function(){
                    $additional_info = get_theme_mod(
                        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO),
                        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PRODUCT_ELEMENTS_ADDITIONAL_INFO)
                    );
                
                    $additional_info_item = $additional_info['ordering'];

                    // echo '<pre>';
                    // print_r($additional_info);
                    // echo '</pre>';

                    echo '<div class="box-additional_info-methods">';
                        echo '<p class="title-additional-info">' . $additional_info['title'] . '</p>';
                        echo '<ul>';
                            foreach ( $additional_info_item as $index => $item ) {
                                if ( 'Premium Quality' === $item || isset( $item['id'] ) && 'Premium Quality' === $item['id'] ) {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php
                                } else if ( 'Secure Payments' === $item || isset( $item['id'] ) && 'Secure Payments' === $item['id'] ) {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php
                                } else if ( 'Satisfaction Guarantee' === $item || isset( $item['id'] ) && 'Satisfaction Guarantee' === $item['id'] ) {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php
                                } else if ( 'Worldwide Shipping' === $item || isset( $item['id'] ) && 'Worldwide Shipping' === $item['id'] ) {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php
                                } else if ( 'Money Back Guarantee' === $item || isset( $item['id'] ) && 'Money Back Guarantee' === $item['id'] ) {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php
                                } else {
                                    ?>
                                    <li>
                                        <span class="additional-info-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                                            </svg>
                                        </span>
                                        <span class="additional-info-label">
                                            <?php echo isset( $item['id'] ) ? esc_html( $item['id'] ) : esc_html( $item ); ?>
                                        </span>
                                    </li>
                                    <?php 
                                }
                            }
                        echo '</ul>';
                    echo '</div>';
                }, $priority);       
            } 
        }
    }
    
}
// if ( ! is_customize_preview() ) {
//     solace_adjust_single_product_layout();
// }
add_action('template_redirect', 'solace_adjust_single_product_layout');

/**
 * Add specific CSS classes based on the selected product layout gallery.
 *
 * @param string $classes The existing CSS classes.
 * @return string Updated CSS classes with the appropriate layout gallery class added.
 */
function add_product_layout_gallery_classes($classes)
{
    $layout_single = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_PAGE_LAYOUT)
    );

    // Get the selected layout gallery setting from the customizer.
    $layout_gallery = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY)
    );

    if ('single-product-special1' === $layout_single) {
        $classes .= ' layout-special1';
    } else if ('single-product-special2' === $layout_single) {
        $classes .= ' layout-special2';
    } else {
        // Append the corresponding layout gallery class to the existing classes.
        switch ($layout_gallery) {
            case 'single-product-layout-gallery1':
                $classes .= ' layout-gallery1';
                break;
            case 'single-product-layout-gallery2':
                $classes .= ' layout-gallery2';
                break;
            case 'single-product-layout-gallery3':
                $classes .= ' layout-gallery3';
                break;
            case 'single-product-layout-gallery4':
                $classes .= ' layout-gallery4';
                break;
            default:
                $classes .= ' layout-gallery1';
                break;
        }
    }

    return $classes;
}
add_filter('solace_before_shop_classes', 'add_product_layout_gallery_classes');

/**
 * Add custom actions based on the selected product layout gallery.
 */
function add_product_layout_gallery_actions()
{
    // Get the selected layout gallery setting from the customizer.
    $layout_gallery = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY),
        Customizer_Defaults::get_default_value(Config::MODS_SINGLE_PRODUCT_LAYOUT_GALLERY)
    );
}
add_action('template_redirect', 'add_product_layout_gallery_actions');
