<?php

use Solace\Core\Settings\Config;
use Solace\Core\Settings\Mods;
use Solace\Core\Settings\Customizer_Defaults;

// Check if the WooCommerce plugin is active.
if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

/**
 * Check if the current page is a shop page. If not, exit the function.
 */
// if ( ! is_shop() ) {
//     return;
// }

/**
 * Adds a sidebar to the WooCommerce product page based on theme mod settings.
 *
 * This function checks if the sidebar should be shown on the product page and if so, adds the appropriate sidebar layout.
 * 
 * @since 1.0.0
 *
 * @return void
 */
function solace_woocommerce_product_page_sidebar() {
    $show_sidebar = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_SIDEBAR)
    );
    
    $sidebar_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SIDEBAR_LAYOUT)
    );

    if ( $show_sidebar ) {
        if ( 'product-page-sidebar-left' === $sidebar_layout ) {
            add_action('woocommerce_before_shop_loop', function(){
                echo "<div class='solace-show-sidebar solace-sidebar-left'>";
                if ( is_active_sidebar( 'shop-sidebar' ) ) {
                    ?>
                    <aside id="secondary" class="widget-area">
                        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                    </aside>
                    <?php
                }
            });
        } else {
            add_action('woocommerce_before_shop_loop', function(){
                echo "<div class='solace-show-sidebar solace-sidebar-right'>";
                if ( is_active_sidebar( 'shop-sidebar' ) ) {
                    ?>
                    <aside id="secondary" class="widget-area">
                        <?php dynamic_sidebar( 'shop-sidebar' ); ?>
                    </aside>
                    <?php
                }
            });
        }

        add_action('woocommerce_after_shop_loop', function(){
            echo "</div>";
        });
    }

    // Pagination infinite scroll.
    add_action('woocommerce_after_shop_loop', function(){
        if ( is_shop() ) {
            $pagination_type = get_theme_mod(
                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE), 
                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE)
            );
    
            // Check if the pagination type is 'pagination-infinite'.
            if ( 'pagination-infinite' === $pagination_type) {
                // Access the global WordPress query object.
                global $wp_query;
                ?>
                <div class="spinner" style="background: url(' <?php echo esc_url( admin_url('images/loading.gif') ); ?>') no-repeat center center;"></div>
                <script>
                    jQuery(document).ready(function($) {
                        let isLoading = false;
                        let total_pages = <?php echo absint( $wp_query->max_num_pages ); ?>;
                        let page = 1;
                        const container = $(".woocommerce-shop");

                        // Function to load more products.
                        function solaceLoadMorePosts() {
                            // If already loading, do nothing.
                            if ( isLoading ) {
                                return;
                            }

                            // If on the last page, do nothing.
                            if ( page === total_pages ) {
                                return;
                            }

                            // Mark that loading is in progress.
                            isLoading = true;

                            // Show the loading spinner.
                            $(".woocommerce-shop .spinner").show();

                            // Get the URL for the next page.
                            const link = container.find("nav.woocommerce-pagination ul li a.next").attr("href");

                            // If no URL is found, exit the function.
                            if ( ! link ) {
                                return;
                            }

                            // Perform AJAX request to load more products.
                            $.ajax({
                                url: link,
                                type: "GET",
                                success: function(response) {
                                    // Extract the HTML of new products.
                                    const newProducts = $(response).find(".shop-container ul.products").html();

                                    // Append new products to the existing container.
                                    if ( newProducts ) {
                                        $(".shop-container ul.products").append(newProducts);
                                    }

                                    // Mark that loading is complete.
                                    isLoading = false;

                                    // Hide the loading spinner.
                                    $(".woocommerce-shop .spinner").hide();

                                    // Increment the page number.
                                    page++;
                                },
                                error: function() {
                                    // Mark that loading is complete in case of an error.
                                    isLoading = false;

                                    // Hide the loading spinner.
                                    $(".woocommerce-shop .spinner").hide();
                                }
                            });                               

                        }

                        // Add scroll event listener.
                        $(window).scroll(function() {
                            // If nearing the bottom of the page, load more products.
                            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                                solaceLoadMorePosts();
                            }
                        });
                    });
                </script>
                <?php
            }
        }
    });
}

// Hook function to customize preview init to handle selective refresh
add_action('customize_preview_init', 'solace_woocommerce_product_page_sidebar');

// Ensure the sidebar is added on frontend as well
if ( ! is_customize_preview() ) {
    solace_woocommerce_product_page_sidebar();
}

/**
 * Retrieves the total number of sales for a given product ID.
 *
 * This function retrieves the total number of sales for a specific product ID using the WooCommerce API.
 * If the product is found, the function returns the total number of sales. If the product is not found, the function returns 0.
 *
 * @param int $product_id The ID of the product for which the total number of sales should be retrieved.
 * @return int The total number of sales for the specified product ID.
 */
function solace_get_product_sales_count( $product_id ) {
    $product = wc_get_product( $product_id );
    if ( $product ) {
        return $product->get_total_sales();
    }
    return 0;
}

/**
 * Customizes the appearance of the shop page based on the theme customizer settings.
 *
 * This function adds custom actions to display variations, total orders, and additional content on the shop page.
 * It also handles the sidebar layout, pagination, and product sorting based on the customizer settings.
 *
 * @since 1.0.0
 * @return void
 */
function solace_page_shop_custom_content() {
    // Get the current shop layout setting from the Customizer.
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
    );

    // Check if the current page is the shop page.
    if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) { 
        // Check if the shop layout is set to 'product-page-layout2'.
        if ( 'product-page-layout2' === $shop_layout ) {
            // Add a custom action to display variations and total orders after the product title in the shop loop.
            add_action( 'woocommerce_after_shop_loop_item_title', function() {
                global $product;

                // Check if the current product is a variable product.
                if ( $product && $product->is_type( 'variable' ) ) {
                    $variations = $product->get_available_variations();
                }
            }, 11 );
        } else if ( 'product-page-layout3' === $shop_layout ) {
            // Add a custom action to display variations and total orders after the product title in the shop loop.
            add_action( 'woocommerce_shop_loop_item_title', function() {
                global $product;

                // Check if the current product is a variable product.
                if ( $product && $product->is_type( 'variable' ) ) {
                    $variations = $product->get_available_variations();
                }
            }, 9 );

            add_action( 'woocommerce_after_shop_loop_item_title', function() {
                global $product;
                $average_rating = $product->get_average_rating();
                if ( ! $average_rating) {
                    echo "<div class='box-rating hide'>";
                } else {
                    echo "<div class='box-rating'>";
                }
            }, 4 );           
            
            add_action( 'woocommerce_after_shop_loop_item_title', function() {
                global $product;
                $total_sales = solace_get_product_sales_count( $product->get_id() );
                $average_rating = $product->get_average_rating();
                if ( ! $average_rating) {
                    echo '<div class="star-rating custom" role="img" aria-label="Rated 5.00 out of 5"><span style="width:100%">Rated <strong class="rating">5.00</strong> out of 5</span></div>';
                }
                echo "<div class='spacing'></div>";
                echo "<p class='solacetotal-sales'>" . esc_html__('Order', 'solace') . "(" . $total_sales . ")</p>";
                echo "</div>";
            }, 6 );            
        } else if ( 'product-page-layout4' === $shop_layout ) {
            add_action( 'woocommerce_shop_loop_item_title', function() {
                echo "<div class='content'>";
                echo "<div class='box-title'>";
            }, 9 );
            
            add_action( 'woocommerce_before_shop_loop_item_title', function() {
                global $product;

                // Check if the product is on sale.
                if ( $product->is_on_sale() ) {
                    // Get the regular price of the product.
                    $regular_price = $product->get_regular_price();
                    // Get the sale price of the product.
                    $sale_price = $product->get_sale_price();
                    
                    // Ensure the regular price is greater than 0 to avoid division by zero
                    if ( $regular_price > 0 ) {
                        // Calculate the percentage discount
                        $percentage = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
                        // Display the discount percentage
                        echo '<span class="onsale custom">';
                        echo '-' . absint( $percentage ) . '%';
                        echo '</span>';
                    }
                }
            }, 10 );

            add_action( 'woocommerce_shop_loop_item_title', function() {
                global $product;

                if ( $price_html = $product->get_price_html() ) {
                    echo '<span class="price">' . $price_html . '</span>';
                }
                echo "</div>";
            }, 11 );

            add_action( 'woocommerce_shop_loop_item_title', function() {
                global $product;
                
                // Get the current product ID.
                $product_id = $product->get_id();
                
                // Get the categories associated with the current product.
                $product_categories = wp_get_post_terms( $product_id, 'product_cat' );
                
                // Check if there are categories and no errors.
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    echo '<div class="product-categories">';
                    
                    // Loop through each category and display its name.
                    foreach ( $product_categories as $category ) {
                        echo '<span class="product-category">' . esc_html( $category->name ) . '</span>';
                    }
                    echo '</div>';
                }

                // Get the short description of the current product.
                $short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
                
                // Check if there is a short description.
                if ( $short_description ) {
                    echo '<div class="product-short-description">' . wp_kses_post( $short_description ) . '</div>';
                }                
            }, 11 );

            add_action( 'woocommerce_after_shop_loop_item_title', function() {
                woocommerce_template_loop_add_to_cart();
                echo "</div>";
            }, 99 );
        } else if ( 'product-page-layout5' === $shop_layout ) { 
            $loop_images = get_theme_mod(
                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_LOOP_IMAGES), 
                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_LOOP_IMAGES)
            );

            $featured_images1 = get_theme_mod(
                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1), 
                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1)
            );

            $featured_images1 = json_decode( $featured_images1, true );

            if ( is_array( $featured_images1 ) && isset( $featured_images1['light'] ) ) {
                $featured_images1 = $featured_images1['light'];
            } else {
                $featured_images1 = false;
            }            

            $featured_images2 = get_theme_mod(
                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2), 
                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2)
            );

            $featured_images2 = json_decode( $featured_images2, true );

            if ( is_array( $featured_images2 ) && isset( $featured_images2['light'] ) ) {
                $featured_images2 = $featured_images2['light'];
            } else {
                $featured_images2 = false;
            }             

            $featured_images3 = get_theme_mod(
                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3), 
                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3)
            );

            $featured_images3 = json_decode( $featured_images3, true );

            if ( is_array( $featured_images3 ) && isset( $featured_images3['light'] ) ) {
                $featured_images3 = $featured_images3['light'];
            } else {
                $featured_images3 = false;
            }              
          
            // Display featured image.
            function solace_display_featured_image(array $config_keys, $looping = false) {
                foreach ($config_keys as $config_key) {
                    $featured_image = get_theme_mod(
                        Customizer_Defaults::get_control_name($config_key), 
                        Customizer_Defaults::get_default_value($config_key)
                    );                        
                    $featured_image = json_decode($featured_image, true);                        
                    $featured_image = isset($featured_image['light']) ? $featured_image['light'] : false;
            
                    if ($featured_image) {
                        $image_url = wp_get_attachment_url($featured_image);

                        $featured_images_mods = [
                            1 => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1,
                            2 => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2,
                            3 => Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3,
                        ];

                        $loop_images = get_theme_mod(
                            Customizer_Defaults::get_control_name( Config::MODS_PRODUCT_PAGE_LOOP_IMAGES ), 
                            Customizer_Defaults::get_default_value( Config::MODS_PRODUCT_PAGE_LOOP_IMAGES )
                        );                        
                        
                        if ( ! $loop_images && $looping && isset( $featured_images_mods[$looping] ) ) {
                            $featured_images = get_theme_mod(
                                Customizer_Defaults::get_control_name( $featured_images_mods[$looping] ), 
                                Customizer_Defaults::get_default_value( $featured_images_mods[$looping] )
                            );
                        
                            $featured_images = json_decode( $featured_images, true );
                        
                            if ( is_array( $featured_images ) && isset( $featured_images['light'] ) && 0 !== $featured_images['light'] ) {
                                echo "<div class='image image$looping image-is-available' style='background-image: url($image_url)'></div>";
                            } else {
                                echo "<div class='image image-is-not-available' style='background-image: url($image_url)'></div>";
                            }
                        } else {
                            echo "<div class='image' style='background-image: url($image_url)'></div>";
                        }  

                        return; // Stop once the first valid image is found
                    }
                }
            }          
            
            // Layout special1 without featuread images.
            function solace_layout_special1_without_featured_images() {
                add_action( 'woocommerce_shop_loop', function() {
                    global $wp_query;
                    $index = $wp_query->current_post + 1; // Get the current product index in the loop.
                    $total = $wp_query->post_count; // Get the total number of products in the loop.

                    if ( 1 === $index ) {
                        echo '<div class="box-full-4-columns is_false">';
                        echo '<div class="box-left">';
                    }

                    // Display the WooCommerce product template part.
                    get_template_part( 'template-parts/woocommerce/content', 'product' );

                    if ( $total === $index ) {
                        echo '</div>';
                        echo '</div>';
                    }
                });
            }

            // Layout special1 with featuread images.            
            function solace_layout_special1_with_featured_images() {
                add_action( 'woocommerce_shop_loop', function() {
                    global $wp_query;
                    $index = $wp_query->current_post + 1; // Get the current product index in the loop.
                    $total = $wp_query->post_count; // Get the total number of products in the loop
                    
                    // Display opening divs for 'box-solace' and 'box-left' if this is the first product in the set.
                    if ( 1 === $index ) {
                        // echo '11111';
                        echo '<div class="box-solace">';
                        echo '<div class="box-left">';
                    }
                    
                    // Display the WooCommerce product template part.
                    get_template_part( 'template-parts/woocommerce/content', 'product' );
                    
                    // Close 'box-left' and open 'box-right' if this is the 4th product or a multiple of 4.
                    if ( $index % 4 === 0 ) {
                        echo '</div>'; // Close 'box-left'
                        echo '<div class="box-right">';
                        
                        // Array of configuration keys in order of priority.
                        $config_keys = [
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1,
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2,
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3
                        ];

                        if ( 4 === $index ) {
                            $featured_images1 = get_theme_mod(
                                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1), 
                                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1)
                            );
                
                            $featured_images1 = json_decode( $featured_images1, true );

                            if ( is_array( $featured_images1 ) && isset( $featured_images1['light'] ) && 0 !== $featured_images1['light'] ) {
                                solace_display_featured_image(array( Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1), 1 );
                            } else {
                                solace_display_featured_image($config_keys, 1);
                            }  
                        }

                        if ( 8 === $index ) {
                            $featured_images2 = get_theme_mod(
                                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2), 
                                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2)
                            );
                
                            $featured_images2 = json_decode( $featured_images2, true );

                            if ( is_array( $featured_images2 ) && isset( $featured_images2['light'] ) && 0 !== $featured_images2['light'] ) {
                                solace_display_featured_image(array( Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2), 2 );
                            } else {
                                solace_display_featured_image($config_keys, 2);
                            }   
                        }

                        if ( 12 === $index ) {
                            $featured_images3 = get_theme_mod(
                                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3), 
                                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3)
                            );
                
                            $featured_images3 = json_decode( $featured_images3, true );

                            if ( is_array( $featured_images3 ) && isset( $featured_images3['light'] ) && 0 !== $featured_images3['light'] ) {
                                solace_display_featured_image(array( Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3), 3 );
                            } else {
                                solace_display_featured_image($config_keys, 3);
                            } 
                        }

                        echo '</div>'; // Close 'box-right'
                        
                        // If this is not the last product, open a new 'box-left'.
                        if ( $index !== $total ) {
                            // echo '22222';
                            echo '</div>'; // Close 'box-solace'
                            echo '<div class="box-solace">';
                            echo '<div class="box-left">';
                        } else {
                            echo '</div>'; // Close 'box-solace' if it is the last product.
                        }
                    }
                    
                    // If this is the last product and the total is not a multiple of 4, close the 'box-left' and open 'box-right'.
                    if ( $index === $total && $total % 4 !== 0 ) {
                        echo '</div>'; // Close 'box-left'
                        echo '<div class="box-right">';

                        // Array of configuration keys in order of priority.
                        $config_keys = [
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES1,
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2,
                            Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES3
                        ];

                        $featured_images2 = get_theme_mod(
                            Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2), 
                            Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2)
                        );
            
                        $featured_images2 = json_decode( $featured_images2, true );

                        if ( is_array( $featured_images2 ) && isset( $featured_images2['light'] ) && 0 !== $featured_images2['light'] ) {
                            solace_display_featured_image(array( Config::MODS_PRODUCT_PAGE_FEATURED_IMAGES2), 2 );
                        } else {
                            solace_display_featured_image($config_keys, 2);
                        } 
                        
                        echo '</div>'; // Close 'box-right'
                        echo '</div>'; // Close 'box-solace'
                    }
                });
            }

            if ( ! $featured_images1 && ! $featured_images2 && ! $featured_images3 ) {
                solace_layout_special1_without_featured_images();
            } else {
                solace_layout_special1_with_featured_images();
            }

        } else if ( 'product-page-layout-custom' === $shop_layout ) {
            remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
        
            remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
            remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
            remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
        
            remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
            remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
            remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );
        
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
            remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

            add_action( 'woocommerce_shop_loop', function() {
                global $product;

                // Ensure visibility.
                if ( empty( $product ) || ! $product->is_visible() ) {
                    return;
                }
                $prefix = Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS;
                $order_default_components = array(
                    $prefix . '-product-image',
                    $prefix . '-title',
                    $prefix . '-price',
                    $prefix . '-star-rating',
                    $prefix . '-categories',
                    $prefix . '-excerpt',
                    $prefix . '-add-to-cart',
                );                

                $default = wp_json_encode( $order_default_components );
                ?>
                <li <?php wc_product_class( '', $product ); ?>>
                <?php
                    $card_options = get_theme_mod(
                        Customizer_Defaults::get_control_name( Config::MODS_PRODUCT_PAGE_ORDERING_CARD_OPTIONS ),
                        $default
                    );

                    $datas = json_decode($card_options, true);

                    add_filter( 'single_product_archive_thumbnail_size', function() {
                        $product_image = get_theme_mod(
                            Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE), 
                            Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_PRODUCT_IMAGE)
                        );
                        $image_ratio = $product_image['imageRatio'];
                        if ( 'imageRatio1' === $image_ratio ) {
                            return 'woocommerce_thumbnail';
                        } else if ( 'imageRatio2' === $image_ratio ) {
                            $imageSizePredefined = $product_image['imageSizePredefined'];
                            return $imageSizePredefined;
                        } else if ( 'imageRatio3' === $image_ratio ) {
                            $imageSizeCustom = $product_image['imageSizeCustom'];
                            return array($imageSizeCustom, $imageSizeCustom);
                        } else {
                            return 'woocommerce_thumbnail';
                        }
                    } );

                    foreach ($datas as $item) :
                        if ( $prefix . '-product-image' === $item ) {
                            echo "<a href='" . esc_url( get_the_permalink() ) . "'>";
                            woocommerce_template_loop_product_thumbnail();
                            echo "</a>";
                        } else if ( $prefix . '-title' === $item ) {
                            $card_options = get_theme_mod(
                                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE), 
                                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_TITLE)
                            );
                            $card_options_title = $card_options['headingTag'];
                            
                            $heading_tag = in_array($card_options_title, ['H1', 'H2', 'H3', 'H4', 'H5', 'H6']) ? $card_options_title : 'h2';
                            echo sprintf(
                                '<%1$s class="%2$s">%3$s</%1$s>', 
                                esc_html($heading_tag),
                                esc_attr(apply_filters('woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title')),
                                get_the_title()
                            ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        } else if ( $prefix . '-price' === $item ) {
                            woocommerce_template_loop_price();
                        } else if ( $prefix . '-star-rating' === $item ) {
                            woocommerce_template_loop_rating();
                        } else if ( $prefix . '-categories' === $item || 'the-categories' === $item ) {
                            global $product;

                            // Get the current product ID.
                            $product_id = $product->get_id();
                            
                            // Get the categories associated with the current product.
                            $product_categories = wp_get_post_terms( $product_id, 'product_cat' );
                            
                            // Check if there are categories and no errors.
                            if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                                $separator = get_theme_mod(
                                    Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES), 
                                    Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_CATEGORIES)
                                );        
                                $separator = $separator['separator'];
                                    
                                $svg = '';
                                if ( 'separator1' === $separator) {
                                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="2" height="15" viewBox="0 0 2 15" fill="none">
                                    <line x1="1" y1="15" x2="0.999999" y2="4.37114e-08" stroke="#0E305F" stroke-width="2"/></svg>';
                                } else if ( 'separator2' === $separator) {
                                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>';
                                } else if ( 'separator3' === $separator) {
                                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="2" viewBox="0 0 15 2" fill="none">
                                    <line y1="-1" x2="15" y2="-1" transform="matrix(1 0 0 -1 0 0)" stroke="#0E305F" stroke-width="2"/></svg>';
                                } else if ( 'separator4' === $separator) {
                                    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
                                    <line y1="-1" x2="15" y2="-1" transform="matrix(0.707107 -0.707107 -0.707107 -0.707107 0.196777 11.3027)" stroke="#0E305F" stroke-width="2"/></svg>';
                                }

                                echo '<div class="product-categories">';
                                // Loop through each category and display its name with a link.
                                foreach ( $product_categories as $category ) {
                                    $category_link = get_term_link( $category );
                                    if ( ! is_wp_error( $category_link ) ) {
                                        echo $svg;
                                        echo '<a href="' . esc_url( $category_link ) . '">' . esc_html( $category->name ) . '</a>';
                                        echo '</a>';
                                    }
                                }
                                echo '</div>';
                            }
                        } else if ( $prefix . '-excerpt' === $item ) {
                            global $product;
                            // Get the short description of the current product.
                            $short_description = apply_filters( 'woocommerce_short_description', $product->get_short_description() );

                            // Get the short description of the current product.
                            $card_options_excerpt = get_theme_mod(
                                Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT), 
                                Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_EXCERPT)
                            );

                            // Check if there is a short description.
                            if ( $short_description ) {
                                $short_description = wp_strip_all_tags( $short_description );

                                // Limit the length to -- characters.
                                $short_description = mb_strimwidth( $short_description, 0, $card_options_excerpt['length']['desktop'], '' );   

                                echo '<div class="product-short-description"><p>' . wp_kses_post( $short_description ) . '</p></div>';
                            }                
                        } else if ( $prefix . '-add-to-cart' === $item ) {
                            woocommerce_template_loop_add_to_cart();
                        }
                    endforeach; 

                echo "</li>";
            });
        }
    }
}
// Hook function to customize preview init to handle selective refresh.
add_action('customize_preview_init', 'solace_page_shop_custom_content');

// Ensure the function runs on the frontend as well.
add_action('template_redirect', 'solace_page_shop_custom_content');

/**
 * Filter callback to conditionally prevent loading specific template parts
 * based on the current shop layout settings.
 *
 * @param string $template The template file path.
 * @param string $slug The slug of the template part.
 * @param string $name The name of the template part.
 * 
 * @return void
 */
function solace_prevent_loading_template_for_product_page_layout( $template, $slug, $name ) {
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name( Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT ),
        Customizer_Defaults::get_default_value( Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT )
    );

    if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) { 
        // Prevent loading the template part if the conditions are met.
        if ( 'content' === $slug && 'product' === $name && 'product-page-layout5' === $shop_layout || 'product-page-layout-custom' === $shop_layout ) {
            return;
        }

    }
    return $template; // Ensure the original template is returned if conditions are not met.
}
add_filter( 'wc_get_template_part', 'solace_prevent_loading_template_for_product_page_layout', 10, 3 );

/**
 * Modify the WooCommerce shop page query to limit the number of products displayed.
 *
 * @param WP_Query $query The current query object.
 */
function solace_custom_woocommerce_shop_page_product_limit( $query ) {
    // Get the current shop layout setting from the Customizer.
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
    );    
 
    // Check if its layout 5.
    if ( 'product-page-layout5' === $shop_layout ) { 
        // Check if it's not the admin area, it's the main query, and it's the shop page
        if ( ! is_admin() && $query->is_main_query() && is_shop() ) {
            // Set the number of products per page to 12
            $query->set( 'posts_per_page', 12 );
        }
    }
}
add_action( 'pre_get_posts', 'solace_custom_woocommerce_shop_page_product_limit' );

/**
 * Adjust WooCommerce product thumbnail size for specific shop layouts.
 *
 * This function customizes the thumbnail size for products on the shop page
 * based on the selected layout from the theme customizer settings.
 *
 * @param string $size The current image size.
 * @return string The modified image size.
 */
function solace_custom_shop_thumbnail_size( $size ) {
    // Check if the current page is the shop page
    if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) {     
        // Get the shop layout setting from the theme customizer
        $shop_layout = get_theme_mod(
            Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
            Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
        );
        
        // If the shop layout is 'product-page-layout3', 'product-page-layout4', 'product-page-layout6' set a custom size
        if ( 'product-page-layout3' === $shop_layout || 'product-page-layout4' === $shop_layout || 'product-page-layout6' === $shop_layout ) {
            $size = 'solace-wc-shop-layout3-layout4-layout6';
        }
    }
    return $size;
}
// Apply the custom thumbnail size to the shop page
add_filter( 'single_product_archive_thumbnail_size', 'solace_custom_shop_thumbnail_size' );

/**
 * Add custom layout classes to the shop page based on the theme customizer settings.
 *
 * @param string $classes The current classes.
 * @return string The modified classes.
 */
function solace_add_shop_layout_classes($classes) {
    // Get the shop layout setting from the customizer, with a default value as fallback
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
    );

    // Check if the current page is the shop page
    if ( is_shop() || is_product_category() || is_product_taxonomy() || is_product_tag() ) {        
        // Append the appropriate class based on the selected shop layout
        if ( 'product-page-layout1' === $shop_layout ) {
            $classes .= ' solace-shop-layout1';
        } else if ( 'product-page-layout2' === $shop_layout ) {
            $classes .= ' solace-shop-layout2';
        } else if ( 'product-page-layout3' === $shop_layout ) {
            $classes .= ' solace-shop-layout3';
        } else if ( 'product-page-layout4' === $shop_layout ) {
            $classes .= ' solace-shop-layout4';
        } else if ( 'product-page-layout5' === $shop_layout ) {
            $classes .= ' solace-shop-layout5';
        } else if ( 'product-page-layout6' === $shop_layout ) {
            $classes .= ' solace-shop-layout6';
        } else if ( 'product-page-layout-custom' === $shop_layout ) {
            $classes .= ' solace-shop-layout-custom';
        }
    }

    return $classes;
}
add_filter('solace_before_shop_classes', 'solace_add_shop_layout_classes');

/**
 * Updates the WooCommerce catalog columns and rows based on theme mod settings.
 *
 * This function retrieves the customizer settings for the number of columns and rows on the product page.
 * It then updates the corresponding WooCommerce options with the retrieved values.
 *
 * @since 1.0.0
 *
 * @return void
 */
function solace_column_and_row() {
    // Get the control name for the customizer setting.
    $control_name = Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW);

    // Get the default value for the customizer setting.
    $default_value = Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_COLUMN_AND_ROW);

    // Retrieve the customizer setting value.
    $customizer_columns_and_row = get_theme_mod($control_name, $default_value);

    // Check if the retrieved value is an array and contains the required keys.
    if (is_array($customizer_columns_and_row) && isset($customizer_columns_and_row['valueColumn'], $customizer_columns_and_row['valueRow'])) {
        // Extract the number of columns and rows from the customizer setting value.
        $customizer_columns = $customizer_columns_and_row['valueColumn'];
        $customizer_rows = $customizer_columns_and_row['valueRow'];

        // If the number of columns is set, update the WooCommerce catalog columns option.
        if (isset($customizer_columns) && $customizer_columns) {
            update_option('woocommerce_catalog_columns', absint($customizer_columns));
        }

        // If the number of rows is set, update the WooCommerce catalog rows option.
        if (isset($customizer_rows) && $customizer_rows) {
            update_option('woocommerce_catalog_rows', absint($customizer_rows));
        }
    }
}

// Hook function to customize preview init to handle selective refresh
add_action('customize_preview_init', 'solace_column_and_row');

// Ensure the sidebar is added on frontend as well
if ( ! is_customize_preview() ) {
    solace_column_and_row();
}

/**
 * Adds custom CSS to hide or show WooCommerce pagination on product pages based on theme mod settings.
 *
 * @since 1.0.0
 *
 * @return void
 */
function solace_style_woocommerce_product_page()
{
    $show_pagination = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOW_PAGINATION)
    );

    $pagination_type = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PAGINATION_TYPE)
    );

    if ( ! $show_pagination) {
        $style = "body.woocommerce-shop .shop-container nav.woocommerce-pagination {display: none;}";
        wp_add_inline_style( 'solace-theme', $style );
    }

    if ( 'pagination-infinite' === $pagination_type ) {
        $style = "body.woocommerce-shop .shop-container nav.woocommerce-pagination {display: none;}";
        wp_add_inline_style( 'solace-theme', $style );
    }

}
add_action('wp_enqueue_scripts', 'solace_style_woocommerce_product_page');

/**
 * Adds custom CSS card options.
 *
 * @since 1.0.0
 *
 * @return void
 */
function solace_style_woocommerce_product_card_options() {
    // Get the shop layout setting from the customizer, with a default value as fallback
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
    );

    $card_options_cart = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_CARD_OPTIONS_ADD_TO_CART)
    );

    if ( 'product-page-layout-custom' === $shop_layout) {
        if ( $card_options_cart['autoHide']) {
            // Auto hide.
            $style = "body.woocommerce-shop div.solace-shop-layout-custom ul.products li.product a.button.add_to_cart_button {visibility: hidden;}";
            $style .= "body.woocommerce-shop div.solace-shop-layout-custom ul.products li.product:hover a.button.add_to_cart_button {visibility: visible;}";
            wp_add_inline_style( 'solace-theme', $style );
        }

    }

}
add_action('wp_enqueue_scripts', 'solace_style_woocommerce_product_card_options');

/**
 * Adds custom CSS to hide or show WooCommerce pagination on product pages based on theme mod settings.
 *
 * This function retrieves the customizer settings for hiding or showing the WooCommerce pagination on the product page.
 * It then adds inline CSS to the 'solace-theme' stylesheet to hide or show the pagination based on the settings.
 * 
 * @since 1.0.0
 * @return void
 */
function solace_product_sorting() {
    // Get the shop layout setting from the customizer, with a default value as fallback
    $shop_layout = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
    );    

    $product_sorting = get_theme_mod(
        Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING), 
        Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_PRODUCT_SORTING)
    );    

    if ( ! $product_sorting) {
        $style = "body.woocommerce-shop .shop-container .nv-woo-filters, body.woocommerce-page .shop-container .nv-woo-filters {display: none;}";
        wp_add_inline_style( 'solace-theme', $style );
    }
}
add_action('wp_enqueue_scripts', 'solace_product_sorting');

// $data = get_theme_mod(
//     Customizer_Defaults::get_control_name(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT), 
//     Customizer_Defaults::get_default_value(Config::MODS_PRODUCT_PAGE_SHOP_SETTINGS_LAYOUT)
// );

// remove_theme_mods();

// echo '<pre>';
// print_r($data);
// echo '</pre>';