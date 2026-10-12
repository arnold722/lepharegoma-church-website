<?php
/**
 * WooCommerce Custom Customizer
 *
 * @link https://woocommerce.com/
 *
 * @package solace
 */

/**
 * WooCommerce setup function.
 *
 * @return void
 */

function solace_customizer_preview_disable_woocommerce_star_rating() {
    // Check if the customizer option is set to false
    if (get_theme_mod('solace_wc_custom_general_star_rating_show') === false) {
        // Ensure hooks are removed during customizer preview
        add_action('wp_head', function() {
            remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
        });
    }
}

function customize_checkout_company_field($fields) {
    $company_field_setting = get_theme_mod('woocommerce_checkout_company_field', 'hidden');

    if ($company_field_setting === 'hidden') {
        $fields['billing']['billing_company']['required'] = false;
        $fields['billing']['billing_company']['class'][] = 'hidden';
    } elseif ($company_field_setting === 'required') {
        $fields['billing']['billing_company']['required'] = true;
        // Remove 'hidden' class if it exists
        if (($key = array_search('hidden', $fields['billing']['billing_company']['class'])) !== false) {
            unset($fields['billing']['billing_company']['class'][$key]);
        }
    } else {
        $fields['billing']['billing_company']['required'] = false;
        // Remove 'hidden' class if it exists
        if (($key = array_search('hidden', $fields['billing']['billing_company']['class'])) !== false) {
            unset($fields['billing']['billing_company']['class'][$key]);
        }
    }

    return $fields;
}



function solace_customizer_css() {
    $rating_color = get_theme_mod('solace_wc_custom_general_star_rating_color', 'var(--sol-color-selection-high)');
    $badge_shape = get_theme_mod('solace_wc_custom_general_product_badges_shape','badge-1');
    $badge_color = get_theme_mod('solace_wc_custom_general_product_badges_color', 'var(--sol-color-page-title-text)');
    $badge_background_color = get_theme_mod('solace_wc_custom_general_product_badges_background_color', 'transparent');
    
    $notice_status = get_theme_mod('solace_wc_custom_general_store_notice_show', false);
    $notice_font_color = get_theme_mod('solace_wc_custom_general_store_notice_font_color', 'var(--sol-color-selection-initial)');
    $notice_bg_color = get_theme_mod('solace_wc_custom_general_store_notice_background_color', 'var(--sol-color-selection-high)');
    
    $cart_title_color = get_theme_mod('solace_wc_custom_general_cart_title_color', 'var(--sol-color-base-font)');
    $cart_title_color_hover = get_theme_mod('solace_wc_custom_general_cart_title_color_hover', 'var(--sol-color-base-font)');
    $cart_description_color = get_theme_mod('solace_wc_custom_general_cart_description_color', 'var(--sol-color-base-font)');
    $cart_price_color = get_theme_mod('solace_wc_custom_general_cart_price_color', 'var(--sol-color-base-font)');
    $cart_button_color = get_theme_mod('solace_wc_custom_general_cart_button_color', 'var(--sol-color-page-title-text)');
    $cart_button_color_hover = get_theme_mod('solace_wc_custom_general_cart_button_color_hover', 'var(--sol-color-page-title-text)');
    $cart_button_color_bg = get_theme_mod('solace_wc_custom_general_cart_button_color_bg', 'var(--sol-color-button-initial)');
    $cart_button_color_bg_hover = get_theme_mod('solace_wc_custom_general_cart_button_color_bg_hover', 'var(--sol-color-button-hover)');
    
    $checkout_title_color = get_theme_mod('solace_wc_custom_general_checkout_title_color', 'var(--sol-color-base-font)');
    $checkout_description_color = get_theme_mod('solace_wc_custom_general_checkout_description_color', 'var(--sol-color-base-font)');
    $checkout_button_color = get_theme_mod('solace_wc_custom_general_checkout_button_color', 'var(--sol-color-page-title-text)');
    $checkout_button_color_hover = get_theme_mod('solace_wc_custom_general_checkout_button_color_hover', 'var(--sol-color-page-title-text)');
    $checkout_button_color_bg = get_theme_mod('solace_wc_custom_general_checkout_button_color_bg', 'var(--sol-color-button-initial)');
    $checkout_button_color_bg_hover = get_theme_mod('solace_wc_custom_general_checkout_button_color_bg_hover', 'var(--sol-color-button-hover)');
    
    $account_title_color = get_theme_mod('solace_wc_custom_general_account_title_color', 'var(--sol-color-base-font)');
    $account_description_color = get_theme_mod('solace_wc_custom_general_account_description_color', 'var(--sol-color-base-font)');
    $account_price_color = get_theme_mod('solace_wc_custom_general_account_price_color', 'var(--sol-color-base-font)');
    $account_button_color = get_theme_mod('solace_wc_custom_general_account_button_color', 'var(--sol-color-page-title-text)');
    $account_button_color_hover = get_theme_mod('solace_wc_custom_general_account_button_color_hover', 'var(--sol-color-page-title-text)');
    $account_button_color_bg = get_theme_mod('solace_wc_custom_general_account_button_color_bg', 'var(--sol-color-button-initial)');
    $account_button_color_bg_hover = get_theme_mod('solace_wc_custom_general_account_button_color_bg_hover', 'var(--sol-color-button-hover)');
    

    $cart_title_font_family = get_theme_mod('solace_wc_custom_general_cart_title_font_family', 'Arial, sans-serif');
    $cart_title_google_font = str_replace(' ', '+', $cart_title_font_family);
    if ($cart_title_font_family && !in_array($cart_title_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-cart-title-fonts',
            "https://fonts.googleapis.com/css2?family={$cart_title_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }

    $cart_title_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontWeight'] ?? '400'),
    ];
    
   
    $cart_description_font_family = get_theme_mod('solace_wc_custom_general_cart_description_font_family', 'Arial, sans-serif');
    $cart_description_google_font = str_replace(' ', '+', $cart_description_font_family);
    if ($cart_description_google_font && !in_array($cart_description_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-cart-description-fonts',
            "https://fonts.googleapis.com/css2?family={$cart_description_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }

    $cart_description_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_cart_description_typeface')['fontWeight'] ?? '400'),
    ];
    
    $cart_price_font_family = get_theme_mod('solace_wc_custom_general_cart_price_font_family', 'Arial, sans-serif');
    $cart_price_google_font = str_replace(' ', '+', $cart_price_font_family);
    if ($cart_price_google_font && !in_array($cart_price_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-cart-price-fonts',
            "https://fonts.googleapis.com/css2?family={$cart_price_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }


    $cart_price_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_cart_price_typeface')['fontWeight'] ?? '400'),
    ];


    $cart_price_line_height = get_theme_mod('solace_wc_custom_general_cart_price_typeface')['lineHeight'] ?? '1.5';
    $cart_price_letter_spacing = get_theme_mod('solace_wc_custom_general_cart_price_typeface')['letterSpacing'] ?? '0px';
    
    $default = get_theme_mod('solace_button_font_family', 'Arial, sans-serif');
    $cart_button_font_family = get_theme_mod('solace_wc_custom_general_cart_button_font_family', $default);
    $cart_button_google_font = str_replace(' ', '+', $cart_button_font_family);
    if ($cart_button_google_font && !in_array($cart_button_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-cart-button-fonts',
            "https://fonts.googleapis.com/css2?family={$cart_button_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }

    $cart_button_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_cart_button_typeface')['fontWeight'] ?? '400'),
    ];

    $checkout_title_font_family = get_theme_mod('solace_wc_custom_general_checkout_title_font_family', 'Arial, sans-serif');
    $checkout_title_google_font = str_replace(' ', '+', $checkout_title_font_family);
    if ($checkout_title_font_family && !in_array($checkout_title_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-checkout-title-fonts',
            "https://fonts.googleapis.com/css2?family={$checkout_title_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }

    $checkout_title_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['mobile'] ?? '21') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['tablet'] ?? '28') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['desktop'] ?? '38') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['textTransform'] ?? 'uppercase'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_checkout_title_typeface')['fontWeight'] ?? '600'),
    ];
   
    $checkout_description_font_family = get_theme_mod('solace_wc_custom_general_checkout_description_font_family', 'Arial, sans-serif');
    $checkout_description_google_font = str_replace(' ', '+', $checkout_description_font_family);
    if ($checkout_description_google_font && !in_array($checkout_description_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-checkout-description-fonts',
            "https://fonts.googleapis.com/css2?family={$checkout_description_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $checkout_description_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_checkout_description_typeface')['fontWeight'] ?? '400'),
    ];
    
    $checkout_button_font_family = get_theme_mod('solace_wc_custom_general_checkout_button_font_family', 'Arial, sans-serif');
    $checkout_button_google_font = str_replace(' ', '+', $checkout_button_font_family);
    if ($checkout_button_google_font && !in_array($checkout_button_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-checkout-button-fonts',
            "https://fonts.googleapis.com/css2?family={$checkout_button_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $checkout_button_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_checkout_button_typeface')['fontWeight'] ?? '400'),
    ];


    $account_title_font_family = get_theme_mod('solace_wc_custom_general_account_title_font_family', 'Arial, sans-serif');
    $account_title_google_font = str_replace(' ', '+', $account_title_font_family);
    if ($account_title_font_family && !in_array($account_title_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-account-title-fonts',
            "https://fonts.googleapis.com/css2?family={$account_title_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $account_title_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_title_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_account_title_typeface')['fontWeight'] ?? '400'),
    ];
   
    $account_description_font_family = get_theme_mod('solace_wc_custom_general_account_description_font_family', 'Arial, sans-serif');
    $account_description_google_font = str_replace(' ', '+', $account_description_font_family);
    if ($account_description_google_font && !in_array($account_description_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-account-description-fonts',
            "https://fonts.googleapis.com/css2?family={$account_description_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $account_description_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_description_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_account_description_typeface')['fontWeight'] ?? '400'),
    ];
    
    $account_price_font_family = get_theme_mod('solace_wc_custom_general_account_price_font_family', 'Arial, sans-serif');
    $account_price_google_font = str_replace(' ', '+', $account_price_font_family);
    if ($account_price_google_font && !in_array($account_price_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-account-price-fonts',
            "https://fonts.googleapis.com/css2?family={$account_price_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $account_price_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_price_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_account_price_typeface')['fontWeight'] ?? '400'),
    ];
    
    $account_button_font_family = get_theme_mod('solace_wc_custom_general_account_button_font_family', 'Arial, sans-serif');
    $account_button_google_font = str_replace(' ', '+', $account_button_font_family);
    if ($account_button_google_font && !in_array($account_button_font_family, ['Arial', 'sans-serif', 'Times New Roman', 'Georgia', 'Tahoma', 'Verdana'])) {
        wp_enqueue_style(
            'solace-account-button-fonts',
            "https://fonts.googleapis.com/css2?family={$account_button_google_font}:wght@300;400;500;600;700&display=swap&v=" . time(),
            [],
            null
        );
    }
    $account_button_styles = [
        'font-size' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['mobile'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['suffix']['mobile'] ?? 'px'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['tablet'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['suffix']['tablet'] ?? 'px'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['desktop'] ?? '16') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontSize']['suffix']['desktop'] ?? 'px'),
        ],
        'line-height' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['mobile'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['suffix']['mobile'] ?? 'em'),
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['tablet'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['suffix']['tablet'] ?? 'em'),
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['desktop'] ?? '1.5') . (get_theme_mod('solace_wc_custom_general_account_button_typeface')['lineHeight']['suffix']['desktop'] ?? 'em'),
        ],
        'letter-spacing' => [
            'mobile' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['letterSpacing']['mobile'] ?? '0') . 'px',
            'tablet' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['letterSpacing']['tablet'] ?? '0') . 'px',
            'desktop' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['letterSpacing']['desktop'] ?? '0') . 'px',
        ],
        'text-transform' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['textTransform'] ?? 'none'),
        'font-weight' => (get_theme_mod('solace_wc_custom_general_account_button_typeface')['fontWeight'] ?? '400'),
    ];

    // body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content label
    // body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content input#wc-block-components-totals-coupon__input-coupon,

    $SELECTOR_CART_TITLE = "body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-cart-items .wc-block-components-product-name,  .woocommerce-cart .cross-sells-product .wc-block-components-product-name, .woocommerce-cart .wc-block-cart table th span, .woocommerce-cart .wc-block-cart .wp-block-woocommerce-cart-cross-sells-block h2, .woocommerce-cart .wc-block-cart .wc-block-cart__totals-title, .woocommerce-cart .wc-block-cart .wc-block-components-totals-item__label, body.woocommerce-cart .wc-block-components-totals-coupon .wc-block-components-panel__button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .is-large.wc-block-cart .wc-block-cart__totals-title, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce .woocommerce-cart-form .shop_table th, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-cart-form .shop_table td.product-name a, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cross-sells h2, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cross-sells ul.products li.product a.woocommerce-loop-product__link>h2, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cart_totals h2, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cart_totals th";
    $SELECTOR_CART_DESCRIPTION = "body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-product-metadata__description>p";
    $SELECTOR_CART_PRICE = "body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-product-price__regular, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-product-price__value, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-sale-badge, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product .wc-block-components-quantity-selector input,body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-cart-items .wc-block-cart-item__total .wc-block-components-formatted-money-amount, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-cart-form .shop_table .product-price .woocommerce-Price-amount, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-cart-form .shop_table .product-subtotal .woocommerce-Price-amount, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cross-sells ul.products li.product .price .woocommerce-Price-amount, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-formatted-money-amount, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-Price-amount.amount";
    $SELECTOR_CART_BUTTON = "body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product button.add_to_cart_button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content button.wc-block-components-button span, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .coupon .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cart_totals .checkout-button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) a.button:not(header a.button):not(footer a.button),body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .button:not(header .button):not(footer .button),body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) table.cart td.actions .button:disabled, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) ul.products li.product .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)):not(.dokan-theme-solace) .woocommerce ul.products li.product .button";

    $SELECTOR_CHECKOUT_TITLE = "body.woocommerce-checkout:not(.elementor-page) h2, body.woocommerce-checkout:not(.elementor-page) form.checkout .nv-customer-details h3, body.woocommerce-checkout:not(.elementor-page) .nv-order-review h3";
    $SELECTOR_CHECKOUT_DESCRIPTION = "body.woocommerce-checkout p.wc-block-components-checkout-step__description, body.woocommerce-checkout .wc-block-checkout__terms span";
    $SELECTOR_CHECKOUT_BUTTON = "body.woocommerce-checkout:not(.elementor-page) button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained .wc-block-components-checkout-place-order-button__text,body.woocommerce-checkout:not(.elementor-page) .woocommerce-billing-fields .checkout_coupon button, body.woocommerce-checkout:not(body.has-solace-checkout-widget) #payment #place_order, body.woocommerce-checkout:not(.elementor-page) .woocommerce-billing-fields form.checkout_coupon button";

    $SELECTOR_ACCOUNT_TITLE = "body.woocommerce-account:not(.elementor-page) .woocommerce th, body.woocommerce-account .woocommerce h2, body.woocommerce-account:not(.elementor-page) .woocommerce p label";
    $SELECTOR_ACCOUNT_DESCRIPTION = "body.woocommerce-account .woocommerce td, body.woocommerce-account .woocommerce p";
    $SELECTOR_ACCOUNT_PRICE = "body.woocommerce-account .woocommerce td.woocommerce-table__product-total.product-total, body.woocommerce-account .woocommerce td span.woocommerce-Price-amount.amount, body.woocommerce-account .woocommerce .woocommerce-orders-table__cell-order-total span.woocommerce-Price-amount.amount";
    $SELECTOR_ACCOUNT_BUTTON = "body.woocommerce-account .woocommerce button, body.woocommerce-account:not(.elementor-default) .woocommerce form.woocommerce-EditAccountForm button[type=submit], body.woocommerce-account:not(.elementor-default) .woocommerce a.button:not(header a.button):not(footer a.button), body.woocommerce-account:not(.elementor-default) .woocommerce .button:not(header .button):not(footer .button)";

    ?>
    <style type="text/css">
        <?php if (get_theme_mod('solace_wc_custom_general_star_rating_show', true) === false) : ?>
            .woocommerce .product .star-rating, .woocommerce .woocommerce-product-rating {
                display: none;
            }
        <?php endif; ?>

        <?php if (get_theme_mod('solace_wc_custom_general_store_notice_show', false)) { ?>
            p.woocommerce-store-notice.demo_store:first-child {
                display: none !important;
            }
            p.woocommerce-store-notice.demo_store, .rico_store_true {
                display: block !important;
            }
        <?php 
        } else {?>
            p.woocommerce-store-notice.demo_store:first-child {
                display: none !important;
            }
            p.woocommerce-store-notice.demo_store,.rico_store_false {
                display: none !important;
            }
        <?php } ?>
        
        body.woocommerce.woocommerce-shop ul.products .star-rating,.rico_custom {
            color: <?php echo $rating_color;?>;
        }

        body.woocommerce.woocommerce-shop ul.products .img-wrap span.onsale {
            color: <?php echo $badge_color;?>;
        }
        :root {
            --sol-cart-title-color: <?php echo $cart_title_color;?>;
            --sol-cart-title-color-hover: <?php echo $cart_title_color_hover;?>;
            --sol-cart-description-color: <?php echo $cart_description_color;?>;
            --sol-cart-price-color: <?php echo $cart_price_color;?>;
            --sol-cart-button-color: <?php echo $cart_button_color;?>;
            --sol-cart-button-color-hover: <?php echo $cart_button_color_hover;?>;
            --sol-cart-button-color-bg: <?php echo $cart_button_color_bg;?>;
            --sol-cart-button-color-bg-hover : <?php echo $cart_button_color_bg_hover;?>;
            --sol-checkout-title-color: <?php echo $checkout_title_color;?>;
            --sol-checkout-description-color: <?php echo $checkout_description_color;?>;
            --sol-checkout-button-color: <?php echo $checkout_button_color;?>;
            --sol-checkout-button-color-hover: <?php echo $checkout_button_color_hover;?>;
            --sol-checkout-button-color-bg: <?php echo $checkout_button_color_bg;?>;
            --sol-checkout-button-color-bg-hover : <?php echo $checkout_button_color_bg_hover;?>;
            --sol-account-title-color: <?php echo $account_title_color;?>;
            --sol-account-description-color: <?php echo $account_description_color;?>;
            --sol-account-price-color: <?php echo $account_price_color;?>;
            --sol-account-button-color: <?php echo $account_button_color;?>;
            --sol-account-button-color-hover: <?php echo $account_button_color_hover;?>;
            --sol-account-button-color-bg:  <?php echo $account_button_color_bg;?>;
            --sol-account-button-color-bg-hover : <?php echo $account_button_color_bg_hover;?>;

            --sol-cart-title-fontsize-mobile : <?php echo $cart_title_styles['font-size']['mobile']; ?>;
            --sol-cart-title-fontsize-tablet : <?php echo $cart_title_styles['font-size']['tablet']; ?>;
            --sol-cart-title-fontsize-desktop : <?php echo $cart_title_styles['font-size']['desktop']; ?>;

            --sol-cart-title-lineheight-mobile : <?php echo $cart_title_styles['line-height']['mobile']; ?>;
            --sol-cart-title-lineheight-tablet : <?php echo $cart_title_styles['line-height']['tablet']; ?>;
            --sol-cart-title-lineheight-desktop : <?php echo $cart_title_styles['line-height']['desktop']; ?>;

            --sol-cart-title-letterspacing-mobile : <?php echo $cart_title_styles['letter-spacing']['mobile']; ?>;
            --sol-cart-title-letterspacing-tablet : <?php echo $cart_title_styles['letter-spacing']['tablet']; ?>;
            --sol-cart-title-letterspacing-desktop : <?php echo $cart_title_styles['letter-spacing']['desktop']; ?>;

            --sol-cart-title-texttransform : <?php echo $cart_title_styles['text-transform']; ?>;
            --sol-cart-title-fontweight : <?php echo $cart_title_styles['font-weight']; ?>;

            --sol-cart-description-fontsize-mobile : <?php echo $cart_description_styles['font-size']['mobile']; ?>;
            --sol-cart-description-fontsize-tablet : <?php echo $cart_description_styles['font-size']['tablet']; ?>;
            --sol-cart-description-fontsize-desktop : <?php echo $cart_description_styles['font-size']['desktop']; ?>;

            --sol-cart-description-lineheight-mobile : <?php echo $cart_description_styles['line-height']['mobile']; ?>;
            --sol-cart-description-lineheight-tablet : <?php echo $cart_description_styles['line-height']['tablet']; ?>;
            --sol-cart-description-lineheight-desktop : <?php echo $cart_description_styles['line-height']['desktop']; ?>;

            --sol-cart-description-letterspacing-mobile : <?php echo $cart_description_styles['letter-spacing']['mobile']; ?>;
            --sol-cart-description-letterspacing-tablet : <?php echo $cart_description_styles['letter-spacing']['tablet']; ?>;
            --sol-cart-description-letterspacing-desktop : <?php echo $cart_description_styles['letter-spacing']['desktop']; ?>;

            --sol-cart-description-texttransform : <?php echo $cart_description_styles['text-transform']; ?>;
            --sol-cart-description-fontweight : <?php echo $cart_description_styles['font-weight']; ?>;

            --sol-cart-price-fontsize-mobile : <?php echo $cart_price_styles['font-size']['mobile']; ?>;
            --sol-cart-price-fontsize-tablet : <?php echo $cart_price_styles['font-size']['tablet']; ?>;
            --sol-cart-price-fontsize-desktop : <?php echo $cart_price_styles['font-size']['desktop']; ?>;

            --sol-cart-price-lineheight-mobile : <?php echo $cart_price_styles['line-height']['mobile']; ?>;
            --sol-cart-price-lineheight-tablet : <?php echo $cart_price_styles['line-height']['tablet']; ?>;
            --sol-cart-price-lineheight-desktop : <?php echo $cart_price_styles['line-height']['desktop']; ?>;

            --sol-cart-price-letterspacing-mobile : <?php echo $cart_price_styles['letter-spacing']['mobile']; ?>;
            --sol-cart-price-letterspacing-tablet : <?php echo $cart_price_styles['letter-spacing']['tablet']; ?>;
            --sol-cart-price-letterspacing-desktop : <?php echo $cart_price_styles['letter-spacing']['desktop']; ?>;

            --sol-cart-price-texttransform : <?php echo $cart_price_styles['text-transform']; ?>;
            --sol-cart-price-fontweight : <?php echo $cart_price_styles['font-weight']; ?>;


            --sol-cart-button-fontsize-mobile : <?php echo $cart_button_styles['font-size']['mobile']; ?>;
            --sol-cart-button-fontsize-tablet : <?php echo $cart_button_styles['font-size']['tablet']; ?>;
            --sol-cart-button-fontsize-desktop : <?php echo $cart_button_styles['font-size']['desktop']; ?>;

            --sol-cart-button-lineheight-mobile : <?php echo $cart_button_styles['line-height']['mobile']; ?>;
            --sol-cart-button-lineheight-tablet : <?php echo $cart_button_styles['line-height']['tablet']; ?>;
            --sol-cart-button-lineheight-desktop : <?php echo $cart_button_styles['line-height']['desktop']; ?>;

            --sol-cart-button-letterspacing-mobile : <?php echo $cart_button_styles['letter-spacing']['mobile']; ?>;
            --sol-cart-button-letterspacing-tablet : <?php echo $cart_button_styles['letter-spacing']['tablet']; ?>;
            --sol-cart-button-letterspacing-desktop : <?php echo $cart_button_styles['letter-spacing']['desktop']; ?>;

            --sol-cart-button-texttransform : <?php echo $cart_button_styles['text-transform']; ?>;
            --sol-cart-button-fontweight : <?php echo $cart_button_styles['font-weight']; ?>;

            
            --sol-checkout-title-fontsize-mobile : <?php echo $checkout_title_styles['font-size']['mobile']; ?>;
            --sol-checkout-title-fontsize-tablet : <?php echo $checkout_title_styles['font-size']['tablet']; ?>;
            --sol-checkout-title-fontsize-desktop : <?php echo $checkout_title_styles['font-size']['desktop']; ?>;

            --sol-checkout-title-lineheight-mobile : <?php echo $checkout_title_styles['line-height']['mobile']; ?>;
            --sol-checkout-title-lineheight-tablet : <?php echo $checkout_title_styles['line-height']['tablet']; ?>;
            --sol-checkout-title-lineheight-desktop : <?php echo $checkout_title_styles['line-height']['desktop']; ?>;

            --sol-checkout-title-letterspacing-mobile : <?php echo $checkout_title_styles['letter-spacing']['mobile']; ?>;
            --sol-checkout-title-letterspacing-tablet : <?php echo $checkout_title_styles['letter-spacing']['tablet']; ?>;
            --sol-checkout-title-letterspacing-desktop : <?php echo $checkout_title_styles['letter-spacing']['desktop']; ?>;

            --sol-checkout-title-texttransform : <?php echo $checkout_title_styles['text-transform']; ?>;
            --sol-checkout-title-fontweight : <?php echo $checkout_title_styles['font-weight']; ?>;


            --sol-checkout-description-fontsize-mobile : <?php echo $checkout_description_styles['font-size']['mobile']; ?>;
            --sol-checkout-description-fontsize-tablet : <?php echo $checkout_description_styles['font-size']['tablet']; ?>;
            --sol-checkout-description-fontsize-desktop : <?php echo $checkout_description_styles['font-size']['desktop']; ?>;

            --sol-checkout-description-lineheight-mobile : <?php echo $checkout_description_styles['line-height']['mobile']; ?>;
            --sol-checkout-description-lineheight-tablet : <?php echo $checkout_description_styles['line-height']['tablet']; ?>;
            --sol-checkout-description-lineheight-desktop : <?php echo $checkout_description_styles['line-height']['desktop']; ?>;

            --sol-checkout-description-letterspacing-mobile : <?php echo $checkout_description_styles['letter-spacing']['mobile']; ?>;
            --sol-checkout-description-letterspacing-tablet : <?php echo $checkout_description_styles['letter-spacing']['tablet']; ?>;
            --sol-checkout-description-letterspacing-desktop : <?php echo $checkout_description_styles['letter-spacing']['desktop']; ?>;

            --sol-checkout-description-texttransform : <?php echo $checkout_description_styles['text-transform']; ?>;
            --sol-checkout-description-fontweight : <?php echo $checkout_description_styles['font-weight']; ?>;


            --sol-checkout-button-fontsize-mobile : <?php echo $checkout_button_styles['font-size']['mobile']; ?>;
            --sol-checkout-button-fontsize-tablet : <?php echo $checkout_button_styles['font-size']['tablet']; ?>;
            --sol-checkout-button-fontsize-desktop : <?php echo $checkout_button_styles['font-size']['desktop']; ?>;

            --sol-checkout-button-lineheight-mobile : <?php echo $checkout_button_styles['line-height']['mobile']; ?>;
            --sol-checkout-button-lineheight-tablet : <?php echo $checkout_button_styles['line-height']['tablet']; ?>;
            --sol-checkout-button-lineheight-desktop : <?php echo $checkout_button_styles['line-height']['desktop']; ?>;

            --sol-checkout-button-letterspacing-mobile : <?php echo $checkout_button_styles['letter-spacing']['mobile']; ?>;
            --sol-checkout-button-letterspacing-tablet : <?php echo $checkout_button_styles['letter-spacing']['tablet']; ?>;
            --sol-checkout-button-letterspacing-desktop : <?php echo $checkout_button_styles['letter-spacing']['desktop']; ?>;

            --sol-checkout-button-texttransform : <?php echo $checkout_button_styles['text-transform']; ?>;
            --sol-checkout-button-fontweight : <?php echo $checkout_button_styles['font-weight']; ?>;


            --sol-account-title-fontsize-mobile : <?php echo $account_title_styles['font-size']['mobile']; ?>;
            --sol-account-title-fontsize-tablet : <?php echo $account_title_styles['font-size']['tablet']; ?>;
            --sol-account-title-fontsize-desktop : <?php echo $account_title_styles['font-size']['desktop']; ?>;

            --sol-account-title-lineheight-mobile : <?php echo $account_title_styles['line-height']['mobile']; ?>;
            --sol-account-title-lineheight-tablet : <?php echo $account_title_styles['line-height']['tablet']; ?>;
            --sol-account-title-lineheight-desktop : <?php echo $account_title_styles['line-height']['desktop']; ?>;

            --sol-account-title-letterspacing-mobile : <?php echo $account_title_styles['letter-spacing']['mobile']; ?>;
            --sol-account-title-letterspacing-tablet : <?php echo $account_title_styles['letter-spacing']['tablet']; ?>;
            --sol-account-title-letterspacing-desktop : <?php echo $account_title_styles['letter-spacing']['desktop']; ?>;

            --sol-account-title-texttransform : <?php echo $account_title_styles['text-transform']; ?>;
            --sol-account-title-fontweight : <?php echo $account_title_styles['font-weight']; ?>;


            --sol-account-description-fontsize-mobile : <?php echo $account_description_styles['font-size']['mobile']; ?>;
            --sol-account-description-fontsize-tablet : <?php echo $account_description_styles['font-size']['tablet']; ?>;
            --sol-account-description-fontsize-desktop : <?php echo $account_description_styles['font-size']['desktop']; ?>;

            --sol-account-description-lineheight-mobile : <?php echo $account_description_styles['line-height']['mobile']; ?>;
            --sol-account-description-lineheight-tablet : <?php echo $account_description_styles['line-height']['tablet']; ?>;
            --sol-account-description-lineheight-desktop : <?php echo $account_description_styles['line-height']['desktop']; ?>;

            --sol-account-description-letterspacing-mobile : <?php echo $account_description_styles['letter-spacing']['mobile']; ?>;
            --sol-account-description-letterspacing-tablet : <?php echo $account_description_styles['letter-spacing']['tablet']; ?>;
            --sol-account-description-letterspacing-desktop : <?php echo $account_description_styles['letter-spacing']['desktop']; ?>;

            --sol-account-description-texttransform : <?php echo $account_description_styles['text-transform']; ?>;
            --sol-account-description-fontweight : <?php echo $account_description_styles['font-weight']; ?>;


            --sol-account-price-fontsize-mobile : <?php echo $account_price_styles['font-size']['mobile']; ?>;
            --sol-account-price-fontsize-tablet : <?php echo $account_price_styles['font-size']['tablet']; ?>;
            --sol-account-price-fontsize-desktop : <?php echo $account_price_styles['font-size']['desktop']; ?>;

            --sol-account-price-lineheight-mobile : <?php echo $account_price_styles['line-height']['mobile']; ?>;
            --sol-account-price-lineheight-tablet : <?php echo $account_price_styles['line-height']['tablet']; ?>;
            --sol-account-price-lineheight-desktop : <?php echo $account_price_styles['line-height']['desktop']; ?>;

            --sol-account-price-letterspacing-mobile : <?php echo $account_price_styles['letter-spacing']['mobile']; ?>;
            --sol-account-price-letterspacing-tablet : <?php echo $account_price_styles['letter-spacing']['tablet']; ?>;
            --sol-account-price-letterspacing-desktop : <?php echo $account_price_styles['letter-spacing']['desktop']; ?>;

            --sol-account-price-texttransform : <?php echo $account_price_styles['text-transform']; ?>;
            --sol-account-price-fontweight : <?php echo $account_price_styles['font-weight']; ?>;


            --sol-account-button-fontsize-mobile : <?php echo $account_button_styles['font-size']['mobile']; ?>;
            --sol-account-button-fontsize-tablet : <?php echo $account_button_styles['font-size']['tablet']; ?>;
            --sol-account-button-fontsize-desktop : <?php echo $account_button_styles['font-size']['desktop']; ?>;

            --sol-account-button-lineheight-mobile : <?php echo $account_button_styles['line-height']['mobile']; ?>;
            --sol-account-button-lineheight-tablet : <?php echo $account_button_styles['line-height']['tablet']; ?>;
            --sol-account-button-lineheight-desktop : <?php echo $account_button_styles['line-height']['desktop']; ?>;

            --sol-account-button-letterspacing-mobile : <?php echo $account_button_styles['letter-spacing']['mobile']; ?>;
            --sol-account-button-letterspacing-tablet : <?php echo $account_button_styles['letter-spacing']['tablet']; ?>;
            --sol-account-button-letterspacing-desktop : <?php echo $account_button_styles['letter-spacing']['desktop']; ?>;

            --sol-account-button-texttransform : <?php echo $account_button_styles['text-transform']; ?>;
            --sol-account-button-fontweight : <?php echo $account_button_styles['font-weight']; ?>;


        }
        

        <?php echo $SELECTOR_CART_TITLE;?> {
            color: var(--sol-cart-title-color);
            font-family: <?php echo $cart_title_font_family; ?>;
            font-size: var(--sol-cart-title-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-cart-title-fontweight);
            line-height: var(--sol-cart-title-lineheight-desktop);
            letter-spacing: var(--sol-cart-title-letterspacing-desktop);
            text-transform: var(--sol-cart-title-texttransform);
        }
        <?php echo $SELECTOR_CART_DESCRIPTION;?> {
            color: var(--sol-cart-description-color);
            font-family: <?php echo $cart_description_font_family; ?>;
            /* width: 100%; */
            font-size: var(--sol-cart-description-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-cart-description-fontweight);
            line-height: var(--sol-cart-description-lineheight-desktop);
            letter-spacing: var(--sol-cart-description-letterspacing-desktop);
            text-transform: var(--sol-cart-description-texttransform);
        }
        <?php echo $SELECTOR_CART_PRICE;?> {
            color: var(--sol-cart-price-color);
            font-family: <?php echo $cart_price_font_family; ?>;
            font-size: var(--sol-cart-price-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-cart-price-fontweight);
            line-height: var(--sol-cart-price-lineheight-desktop);
            letter-spacing: var(--sol-cart-price-letterspacing-desktop);
            text-transform: var(--sol-cart-price-texttransform);
        }
        <?php echo $SELECTOR_CART_BUTTON;?> {
            color: var(--sol-cart-button-color);
            font-family: <?php echo $cart_button_font_family; ?>;
            font-size: var(--sol-cart-button-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-cart-button-fontweight);
            line-height: var(--sol-cart-button-lineheight-desktop);
            letter-spacing: var(--sol-cart-button-letterspacing-desktop);
            text-transform: var(--sol-cart-button-texttransform);
        }
        <?php echo $SELECTOR_CHECKOUT_TITLE;?> {
            color: var(--sol-checkout-title-color);
            font-family: <?php echo $checkout_title_font_family; ?>;
            font-size: var(--sol-checkout-title-fontsize-desktop) !important;  /* Desktop default */
            font-weight: var(--sol-checkout-title-fontweight);
            line-height: var(--sol-checkout-title-lineheight-desktop);
            letter-spacing: var(--sol-checkout-title-letterspacing-desktop);
            text-transform: var(--sol-checkout-title-texttransform);
        }
        <?php echo $SELECTOR_CHECKOUT_DESCRIPTION;?> {
            color: var(--sol-checkout-description-color);
            font-family: <?php echo $checkout_description_font_family; ?>;
            font-size: var(--sol-checkout-description-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-checkout-description-fontweight);
            line-height: var(--sol-checkout-description-lineheight-desktop);
            letter-spacing: var(--sol-checkout-description-letterspacing-desktop);
            text-transform: var(--sol-checkout-description-texttransform);
        }
        <?php echo $SELECTOR_CHECKOUT_BUTTON;?> {
            color: var(--sol-checkout-button-color);
            font-family: <?php echo $checkout_button_font_family; ?>;
            font-size: var(--sol-checkout-button-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-checkout-button-fontweight);
            line-height: var(--sol-checkout-button-lineheight-desktop);
            letter-spacing: var(--sol-checkout-button-letterspacing-desktop);
            text-transform: var(--sol-checkout-button-texttransform);
        }
        <?php echo $SELECTOR_ACCOUNT_TITLE;?> {
            color: var(--sol-account-title-color);
            font-family: <?php echo $account_title_font_family; ?>;
            font-size: var(--sol-account-title-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-account-title-fontweight);
            line-height: var(--sol-account-title-lineheight-desktop);
            letter-spacing: var(--sol-account-title-letterspacing-desktop);
            text-transform: var(--sol-account-title-texttransform);
        }
        <?php echo $SELECTOR_ACCOUNT_DESCRIPTION;?> {
            color: var(--sol-account-description-color);
            font-family: <?php echo $account_description_font_family; ?>;
            font-size: var(--sol-account-description-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-account-description-fontweight);
            line-height: var(--sol-account-description-lineheight-desktop);
            letter-spacing: var(--sol-account-description-letterspacing-desktop);
            text-transform: var(--sol-account-description-texttransform);
        }
        <?php echo $SELECTOR_ACCOUNT_PRICE;?> {
            color: var(--sol-account-price-color);
            font-family: <?php echo $account_price_font_family; ?>;
            font-size: var(--sol-account-price-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-account-price-fontweight);
            line-height: var(--sol-account-price-lineheight-desktop);
            letter-spacing: var(--sol-account-price-letterspacing-desktop);
            text-transform: var(--sol-account-price-texttransform);
        }
        <?php echo $SELECTOR_ACCOUNT_BUTTON;?> {
            color: var(--sol-account-button-color);
            font-family: <?php echo $account_button_font_family; ?>;
            font-size: var(--sol-account-button-fontsize-desktop);  /* Desktop default */
            font-weight: var(--sol-account-button-fontweight);
            line-height: var(--sol-account-button-lineheight-desktop);
            letter-spacing: var(--sol-account-button-letterspacing-desktop);
            text-transform: var(--sol-account-button-texttransform);
        }

        /* Tablet Styles */
        @media (max-width: 1024px) {
            <?php echo $SELECTOR_CART_TITLE;?> {
                font-size: var(--sol-cart-title-fontsize-tablet);
                line-height: var(--sol-cart-title-lineheight-tablet);
                letter-spacing: var(--sol-cart-title-letterspacing-tablet);
            }
            <?php echo $SELECTOR_CART_DESCRIPTION;?> {
                font-size: var(--sol-cart-description-fontsize-tablet);
                line-height: var(--sol-cart-description-lineheight-tablet);
                letter-spacing: var(--sol-cart-description-letterspacing-tablet);
            }
            <?php echo $SELECTOR_CART_PRICE;?> {
                font-size: var(--sol-cart-price-fontsize-tablet);
                line-height: var(--sol-cart-price-lineheight-tablet);
                letter-spacing: var(--sol-cart-price-letterspacing-tablet);
            }
            <?php echo $SELECTOR_CART_BUTTON;?> {
                font-size: var(--sol-cart-button-fontsize-tablet);
                line-height: var(--sol-cart-button-lineheight-tablet);
                letter-spacing: var(--sol-cart-button-letterspacing-tablet);
            }

            <?php echo $SELECTOR_CHECKOUT_TITLE;?> {
                font-size: var(--sol-checkout-title-fontsize-tablet)  !important;
                line-height: var(--sol-checkout-title-lineheight-tablet)  !important;
                letter-spacing: var(--sol-checkout-title-letterspacing-tablet);
            }
            <?php echo $SELECTOR_CHECKOUT_DESCRIPTION;?> {
                font-size: var(--sol-checkout-description-fontsize-tablet);
                line-height: var(--sol-checkout-description-lineheight-tablet);
                letter-spacing: var(--sol-checkout-description-letterspacing-tablet);
            }
            <?php echo $SELECTOR_CHECKOUT_BUTTON;?> {
                font-size: var(--sol-checkout-button-fontsize-tablet);
                line-height: var(--sol-checkout-button-lineheight-tablet);
                letter-spacing: var(--sol-checkout-button-letterspacing-tablet);
            }

            <?php echo $SELECTOR_ACCOUNT_TITLE;?> {
                font-size: var(--sol-account-title-fontsize-tablet);
                line-height: var(--sol-account-title-lineheight-tablet);
                letter-spacing: var(--sol-account-title-letterspacing-tablet);
            }
            <?php echo $SELECTOR_ACCOUNT_DESCRIPTION;?> {
                font-size: var(--sol-account-description-fontsize-tablet);
                line-height: var(--sol-account-description-lineheight-tablet);
                letter-spacing: var(--sol-account-description-letterspacing-tablet);
            }
            <?php echo $SELECTOR_ACCOUNT_PRICE;?> {
                font-size: var(--sol-account-price-fontsize-tablet);
                line-height: var(--sol-account-price-lineheight-tablet);
                letter-spacing: var(--sol-account-price-letterspacing-tablet);
            }
            <?php echo $SELECTOR_ACCOUNT_BUTTON;?> {
                font-size: var(--sol-account-button-fontsize-tablet);
                line-height: var(--sol-account-button-lineheight-tablet);
                letter-spacing: var(--sol-account-button-letterspacing-tablet);
            }
        }

        /* Mobile Styles */
        @media (max-width: 425px) {
            <?php echo $SELECTOR_CART_TITLE;?> {
                font-size: var(--sol-cart-title-fontsize-mobile);
                line-height: var(--sol-cart-title-lineheight-mobile);
                letter-spacing: var(--sol-cart-title-letterspacing-mobile);
            }
            <?php echo $SELECTOR_CART_DESCRIPTION;?> {
                font-size: var(--sol-cart-description-fontsize-mobile);
                line-height: var(--sol-cart-description-lineheight-mobile);
                letter-spacing: var(--sol-cart-description-letterspacing-mobile);
            }
            <?php echo $SELECTOR_CART_PRICE;?> {
                font-size: var(--sol-cart-price-fontsize-mobile);
                line-height: var(--sol-cart-price-lineheight-mobile);
                letter-spacing: var(--sol-cart-price-letterspacing-mobile);
            }
            <?php echo $SELECTOR_CART_BUTTON;?> {
                font-size: var(--sol-cart-button-fontsize-mobile);
                line-height: var(--sol-cart-button-lineheight-mobile);
                letter-spacing: var(--sol-cart-button-letterspacing-mobile);
            }

            <?php echo $SELECTOR_CHECKOUT_TITLE;?> {
                font-size: var(--sol-checkout-title-fontsize-mobile)  !important;
                line-height: var(--sol-checkout-title-lineheight-mobile)  !important;
                letter-spacing: var(--sol-checkout-title-letterspacing-mobile);
            }
            <?php echo $SELECTOR_CHECKOUT_DESCRIPTION;?> {
                font-size: var(--sol-checkout-description-fontsize-mobile);
                line-height: var(--sol-checkout-description-lineheight-mobile);
                letter-spacing: var(--sol-checkout-description-letterspacing-mobile);
            }
            <?php echo $SELECTOR_CHECKOUT_BUTTON;?> {
                font-size: var(--sol-checkout-button-fontsize-mobile);
                line-height: var(--sol-checkout-button-lineheight-mobile);
                letter-spacing: var(--sol-checkout-button-letterspacing-mobile);
            }

            <?php echo $SELECTOR_ACCOUNT_TITLE;?> {
                font-size: var(--sol-account-title-fontsize-mobile);
                line-height: var(--sol-account-title-lineheight-mobile);
                letter-spacing: var(--sol-account-title-letterspacing-mobile);
            }
            <?php echo $SELECTOR_ACCOUNT_DESCRIPTION;?> {
                font-size: var(--sol-account-description-fontsize-mobile);
                line-height: var(--sol-account-description-lineheight-mobile);
                letter-spacing: var(--sol-account-description-letterspacing-mobile);
            }
            <?php echo $SELECTOR_ACCOUNT_PRICE;?> {
                font-size: var(--sol-account-price-fontsize-mobile);
                line-height: var(--sol-account-price-lineheight-mobile);
                letter-spacing: var(--sol-account-price-letterspacing-mobile);
            }
            <?php echo $SELECTOR_ACCOUNT_BUTTON;?> {
                font-size: var(--sol-account-button-fontsize-mobile);
                line-height: var(--sol-account-button-lineheight-mobile);
                letter-spacing: var(--sol-account-button-letterspacing-mobile);
            }
        }

        body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-cart-items .wc-block-components-product-name:hover,body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product .wc-block-components-product-name:hover,
        body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-cart-form .shop_table td.product-name a:hover {
            color: <?php echo $cart_title_color_hover;?>;
        }
        
        
        body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product button.add_to_cart_button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover span:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content button.wc-block-components-button:hover span:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .coupon .button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(body.has-solace-cart-widget) .shop_table .button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(body.has-solace-cart-widget) .cart-collaterals .cart_totals .checkout-button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(body.has-solace-cart-widget) a.button:not(header a.button):not(footer a.button):hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(body.has-solace-cart-widget) table.cart td.actions .button:disabled:hover:not(.elementor-widget-woocommerce-cart *) {
            color: <?php echo "var(--sol-cart-button-color-hover)";?> !important;
        }
        body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product button.add_to_cart_button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content button.wc-block-components-button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .coupon .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cart_totals .checkout-button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart))  .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart))  a.button:not(header a.button):not(footer a.button), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .button:not(header .button):not(footer .button), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)):not(.dokan-theme-solace) .woocommerce ul.products li.product .button, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)):not(.dokan-theme-solace) .woocommerce a.button {
            background-color: <?php echo $cart_button_color_bg;?>;
        }
        body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cross-sells-product button.add_to_cart_button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained:hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .wc-block-components-totals-coupon__content button.wc-block-components-button:hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .coupon .button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .shop_table .button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .cart-collaterals .cart_totals .checkout-button:hover:not(.elementor-widget-woocommerce-cart *), body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart))  .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button:hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart))  a.button:not(header a.button):not(footer a.button):hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .button:not(header .button):not(footer .button):hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)):not(.dokan-theme-solace) .woocommerce ul.products li.product .button:hover, body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)):not(.dokan-theme-solace) .woocommerce a.button:hover {
            background-color: <?php echo $cart_button_color_bg_hover;?>;
        }

        body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained:hover .wc-block-components-checkout-place-order-button__text,body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-billing-fields .checkout_coupon button:hover,body.woocommerce-checkout:not(.elementor-page) .woocommerce-checkout-payment button:hover {
            color: <?php echo "var(--sol-checkout-button-color-hover);"?>;
        }
        body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained,body.woocommerce-checkout:not(.elementor-page) .woocommerce-billing-fields .checkout_coupon button,body.woocommerce-checkout:not(.elementor-page) .woocommerce-checkout-payment button {
            background-color: <?php echo "var(--sol-checkout-button-color-bg);"?>;
        }
        body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained:hover,body.woocommerce-cart:not(:has(.elementor-widget-woocommerce-cart)) .woocommerce-billing-fields .checkout_coupon button:hover,body.woocommerce-checkout:not(.elementor-page) .woocommerce-checkout-payment button:hover {
            background-color: <?php echo "var(--sol-checkout-button-color-bg-hover);"?>;
        }

        body.woocommerce-account .woocommerce button:hover, body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover, body.woocommerce-account:not(.elementor-default) .woocommerce a.button:not(header a.button):not(footer a.button):hover, body.woocommerce-account:not(.elementor-default) .woocommerce .button:not(header .button):not(footer .button):hover {
            color: <?php echo "var(--sol-account-button-color-hover);"?>;
        }
        body.woocommerce-account:not(.elementor-default) .woocommerce button:not(.show-password-input), body.woocommerce-account:not(.elementor-default) .woocommerce form.woocommerce-EditAccountForm button[type=submit], body.woocommerce-account:not(.elementor-default) .woocommerce a.button:not(header a.button):not(footer a.button), body.woocommerce-account:not(.elementor-default) .woocommerce .button:not(header .button):not(footer .button) {
            background-color: <?php echo "var(--sol-account-button-color-bg);"?>;
        }
        body.woocommerce-account .woocommerce button:hover:not(.show-password-input), body.woocommerce-account .woocommerce form.woocommerce-EditAccountForm button[type=submit]:hover, body.woocommerce-account:not(.elementor-default) .woocommerce a.button:not(header a.button):not(footer a.button):hover, body.woocommerce-account:not(.elementor-default) .woocommerce .button:not(header .button):not(footer .button):hover {
            background-color: <?php echo "var(--sol-account-button-color-bg-hover);"?>;
        }

        <?php 

        if ( get_theme_mod( 'solace_wc_custom_general_cart_coupon', true ) === false ) {
            ?>
            .woocommerce-cart .coupon, .wp-block-woocommerce-cart-order-summary-coupon-form-block.wc-block-components-totals-wrapper {
                display: none;
            }
        <?php 
        } else {
            ?>
            .woocommerce-cart .coupon, .wp-block-woocommerce-cart-order-summary-coupon-form-block.wc-block-components-totals-wrapper {
                display: block;
            }
        <?php } ?>

        <?php
        $show_coupon_form = get_theme_mod('solace_wc_custom_general_checkout_coupon', true);

        if (!$show_coupon_form) {
            ?>
            
                .wp-block-woocommerce-checkout-order-summary-coupon-form-block,
                #solace-checkout-coupon {
                    display: none !important;
                }
            
            <?php
        } ?>

        <?php
        $field_option = get_theme_mod('woocommerce_checkout_company_field', 'optional');

        $default = 'optional';
        $field_option = $field_option ?: $default;
        if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__company label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__company {
                display: none;
            }
        <?php endif;
        
        $field_option = get_option('woocommerce_checkout_phone_field');?>
        <?php if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__phone label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__phone {
                display: none;
            }
        <?php endif;

        $field_option = get_option('woocommerce_checkout_address_2_field');?>
        <?php if ( $field_option === 'required' ) : ?>
            .wc-block-components-address-form__address_2 label::after {
                content: none !important;
            }
        <?php elseif ( $field_option === 'hidden' ) : ?>
            .wc-block-components-address-form__address_2,
            .wc-block-components-address-form__address_2-toggle {
                display: none;
            }
        <?php endif; ?>

        .woocommerce-store-notice, p.demo_store {
            color: <?php echo $notice_font_color;?>
        }
        .woocommerce-store-notice, p.demo_store {
            background-color: <?php echo $notice_bg_color;?>
        }
    </style>
    <?php
}
add_action('wp_head', 'solace_customizer_css');

function solace_enqueue_custom_fonts() {
    $font_family = get_theme_mod('solace_wc_custom_general_cart_title_font_family', 'Arial, sans-serif');
    $font_size   = get_theme_mod('solace_wc_custom_general_cart_title_typeface')['fontSize'] ?? '16px';
    $line_height = get_theme_mod('solace_wc_custom_general_cart_title_typeface')['lineHeight'] ?? '1.5';
    $letter_spacing = get_theme_mod('solace_wc_custom_general_cart_title_typeface')['letterSpacing'] ?? '0px';

    $custom_css = "
        .wc-block-components-product-name {
            font-family: {$font_family};
            font-size: {$font_size};
            line-height: {$line_height};
            letter-spacing: {$letter_spacing};
        }
    ";

    wp_add_inline_style('solace-style', $custom_css);
}
// add_action('wp_enqueue_scripts', 'solace_enqueue_custom_fonts');


function solace_custom_product_badge_text() {
    $badge_label = get_theme_mod('solace_wc_custom_general_product_badges_label', 'Sale!');
    $badge_shape = get_theme_mod('solace_wc_custom_general_product_badges_shape','badge-1');


    if (!empty($badge_label)) {
        return '<span class="onsale '.$badge_shape.'">'.$badge_label.'</span>';
    }

    return 'Sale!';
}

add_filter('woocommerce_sale_flash', 'solace_custom_product_badge_text', 10, 3);

function solace_move_woocommerce_controls( $wp_customize ) {
    foreach ( $wp_customize->settings() as $setting ) {
        $control = $wp_customize->get_control( $setting->id );

        if ( $control && $control->section === 'woocommerce_checkout' ) {
            $control->section = 'solace_wc_custom_general_checkout';
        }
        if ( $control && $control->section === 'woocommerce_store_notice' ) {
            $control->section = 'solace_wc_custom_general_store_notice';
            $control->priority = 112;
            
        }
    }
    $store_notice_control = $wp_customize->get_control('woocommerce_demo_store_notice');

    if ( $store_notice_control ) {
        $store_notice_control->priority = 113;
        $store_notice_control->label = 'Text';
    }
}
add_action( 'customize_register', 'solace_move_woocommerce_controls', 20 );

add_action('init', 'solace_toggle_store_notice_based_on_setting');

function solace_toggle_store_notice_based_on_setting() {
    update_option('woocommerce_demo_store', 'yes');
}

add_action('customize_save_after', 'solace_toggle_store_notice_based_on_setting2');

function solace_toggle_store_notice_based_on_setting2() {

    $show_notice = get_theme_mod('solace_wc_custom_general_store_notice_show', false);

    if ($show_notice) {
        update_option('woocommerce_demo_store', 'yes');
    } else {
        update_option('woocommerce_demo_store', 'no');
    }
}


/**
 * Update WooCommerce Store Notice via AJAX.
 * Security patch: Added authorization check to prevent unauthorized access (CVE-2025-68911).
 */
add_action('wp_ajax_update_store_notice', 'update_store_notice');
function update_store_notice() {
    // Check if the current user has permission to modify theme options
    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_send_json_error( 'Unauthorized: You do not have permission to perform this action.', 403 );
        return;
    }

    // Validate input and update the WooCommerce store notice option
    if (isset($_POST['status']) && in_array($_POST['status'], array('yes', 'no'))) {
        update_option('woocommerce_demo_store', sanitize_text_field($_POST['status']));
        wp_send_json_success();
    } else {
        wp_send_json_error( 'Invalid status value.' );
    }

    // Verify nonce to prevent CSRF and unauthorized requests.
    if (
        ! isset( $_POST['solace_nonce'] ) ||
        ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['solace_nonce'] ) ), 'solace-ajax-verification' )
    ) {
        wp_send_json_error(
            array(
                'message' => 'Security check failed. Invalid or missing nonce',
                'status'  => 'error',
            )
        );
    }

    if ( isset( $_POST['status'] ) && in_array( $_POST['status'], array( 'yes', 'no' ), true ) ) {
        update_option( 'woocommerce_demo_store', sanitize_text_field( wp_unslash( $_POST['status'] ) ) );
        wp_send_json_success(
            array(
                'success' => true,
                'status'  => 'success',
            )
        );
    }

    wp_send_json_error(
        array(
            'message' => 'Invalid or missing status value.',
            'status'  => 'error',
        )
    );
}

function solace_enqueue_dokan_style() {
   
    
    wp_add_inline_script( 
        'jquery-core', 
        "
        jQuery(document).ready(function($) {
            if ($('body').hasClass('dokan-store') || $('body').hasClass('dokan-dashboard')) {
                // Apply the enqueued style by force
                $('link#solace-dokan-style').prop('disabled', false);
            } else {
                // Optionally, disable the style if the classes are not present
                $('link#solace-dokan-style').prop('disabled', true);
            }
        });
        "
    );

    if (in_array('dokan-store', get_body_class(), true)) {

        wp_enqueue_style(
            'solace-dokan-style',
            SOLACE_ASSETS_URL . 'css/solace-dokan.css',
            array(),
            SOLACE_VERSION
        );
        wp_enqueue_script(
            'solace-dokan-script',
            get_stylesheet_directory_uri() . '/js/dokan.js&v=' . time(),
            array( 'jquery' )
        );
    }
}

add_action( 'wp_enqueue_scripts', 'solace_enqueue_dokan_style' );

/**
 * Enqueue the WooCommerce sidebar-widget tidy-up stylesheet.
 *
 * Also restores the WooCommerce "star" @font-face. The glyph font is only
 * declared inside inc/woocommerce.php, which is NOT loaded (functions.php
 * requires inc/wc-custom.php instead), so every .star-rating on the site
 * falls back to generic text and looks distorted.
 *
 * Dependencies force this file to print after the theme + WooCommerce CSS.
 *
 * @return void
 */
function solace_enqueue_wc_widgets_tidy_styles() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	$font_path = WC()->plugin_url() . '/assets/fonts/';
	$star_font = '@font-face {
		font-family: "star";
		src: url("' . $font_path . 'star.woff") format("woff"),
			url("' . $font_path . 'star.ttf") format("truetype");
		font-weight: normal;
		font-style: normal;
		font-display: swap;
	}';

	$tidy_style_version = file_exists( get_template_directory() . '/assets/css/wc-widgets-tidy.css' )
		? (string) filemtime( get_template_directory() . '/assets/css/wc-widgets-tidy.css' )
		: SOLACE_VERSION;

	wp_enqueue_style(
		'solace-wc-widgets-tidy',
		get_template_directory_uri() . '/assets/css/wc-widgets-tidy.css',
		array( 'solace-woocommerce', 'woocommerce-general' ),
		$tidy_style_version
	);
	wp_add_inline_style( 'solace-wc-widgets-tidy', $star_font );
}
add_action( 'wp_enqueue_scripts', 'solace_enqueue_wc_widgets_tidy_styles', 20 );

/**
 * Elementor "WordPress Widgets" — used by the Site Builder shop archive sidebar —
 * render without the standard `.widget` wrapper, so the theme's widget tidy
 * styles and WooCommerce's widget styles never match. Wrap them like a real
 * sidebar widget (`<div class="widget …">`) so every `.widget …` rule applies.
 */
add_filter(
	'elementor/widgets/wordpress/widget_args',
	function ( $args, $widget ) {
		if ( ! is_object( $widget ) || ! method_exists( $widget, 'get_widget_instance' ) ) {
			return $args;
		}
		$instance  = $widget->get_widget_instance();
		$classname = $instance && isset( $instance->widget_options['classname'] ) ? $instance->widget_options['classname'] : '';
		if ( ! $classname ) {
			return $args;
		}
		$args['before_widget'] = '<div class="widget ' . esc_attr( $classname ) . '">';
		$args['after_widget']  = '</div>';
		return $args;
	},
	10,
	2
);

/**
 * Add a wrapper div before the WooCommerce products shortcode output.
 *
 * This function hooks into `woocommerce_shortcode_before_products_loop` to
 * add a custom opening `<div>` wrapper with a specific class.
 *
 * @return void
 */
function solace_add_wrapper_before_products() {
    echo '<div class="solace-shortcode-wc">';
}

/**
 * Add a closing wrapper div after the WooCommerce products shortcode output.
 *
 * This function hooks into `woocommerce_shortcode_after_products_loop` to
 * close the custom `<div>` wrapper started by `solace_add_wrapper_before_products`.
 *
 * @return void
 */
function solace_add_wrapper_after_products() {
    echo '</div>';
}

add_action('woocommerce_shortcode_before_products_loop', 'solace_add_wrapper_before_products');

add_action('woocommerce_shortcode_after_products_loop', 'solace_add_wrapper_after_products');

add_action('init', function () {
    $custom_setting = get_option('solace_wc_custom_general_store_notice_show', false);

    if ($custom_setting) {
        update_option('woocommerce_demo_store', 'no'); 
    } else {
        update_option('woocommerce_demo_store', 'yes'); 
    }
});

add_filter( 'woocommerce_checkout_fields', 'solace_filter_checkout_fields', 20 );
function solace_filter_checkout_fields( $fields ) {

    $map = [
        'woocommerce_checkout_company_field'      => [ 'billing_company' ],
        'woocommerce_checkout_main_address_field' => [
            'billing_address_1',
            'billing_address_2',
            'billing_city',
            'billing_state',
            'billing_postcode',
            'billing_country',
        ],
        // 'woocommerce_checkout_address_2_field'    => [ 'billing_address_2' ],
        'woocommerce_checkout_phone_field'        => [ 'billing_phone' ],
    ];

    foreach ( $map as $control_key => $wc_fields ) {
        $status = get_theme_mod( $control_key, 'optional' );

        foreach ($wc_fields as $wc_field_key) {
            if (!isset($fields['billing'][$wc_field_key])) {
                $fields['billing'][$wc_field_key] = [
                    'label'       => ucfirst(str_replace('billing_', '', $wc_field_key)),
                    'required'    => false,
                    'class'       => ['form-row-wide'],
                    'clear'       => true,
                    'type'        => 'text',
                ];
            }

            if ('hidden' === $status) {
                unset($fields['billing'][$wc_field_key]);
            } elseif ('required' === $status) {
                $fields['billing'][$wc_field_key]['required'] = true;
                $fields['billing'][$wc_field_key]['class'][]  = 'validate-required';
            } else {
                $fields['billing'][$wc_field_key]['required'] = false;
                $fields['billing'][$wc_field_key]['class']    = array_diff(
                    $fields['billing'][$wc_field_key]['class'],
                    ['validate-required']
                );
            }
        }

    }

    return $fields;
}


add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    if ( isset( $fields['billing']['billing_company'] ) ) {
        $fields['billing']['billing_company']['priority'] = 25; 
    }

    return $fields;
}, 20 );


add_action( 'wp_head', 'solace_checkout_field_assets' );
function solace_checkout_field_assets() {
    if ( ! is_checkout() ) {
        return;
    }

    $map = [
        'woocommerce_checkout_company_field'      => [ 'billing_company' ],
        'woocommerce_checkout_main_address_field' => [
            'billing_address_1',
            'billing_address_2',
            'billing_city',
            'billing_state',
            'billing_postcode',
            'billing_country',
        ],
        // 'woocommerce_checkout_address_2_field'    => [ 'billing_address_2' ],
        'woocommerce_checkout_phone_field'        => [ 'billing_phone' ],
    ];

    $css = '<style>';
    $js  = 'jQuery(function($){ $(document.body).on("updated_checkout", function(){';

    foreach ( $map as $control_key => $wc_fields ) {
        $status = get_theme_mod( $control_key, 'optional' );
        if ( 'hidden' !== $status ) {
            continue;
        }

        foreach ( $wc_fields as $wc_field_key ) {
            $css .= '#' . esc_attr( $wc_field_key ) . '_field { display:none !important; }';

            $js .= '
                $("#' . esc_js( $wc_field_key ) . '_field").removeClass("validate-required");
                $("#' . esc_js( $wc_field_key ) . '_field .required").remove();
            ';
        }
    }

    $css .= '</style>';
    $js  .= '}); });';

    echo $css;
    echo '<script>' . $js . '</script>';
}

add_filter( 'woocommerce_checkout_fields', 'solace_disable_main_address_validation', 100, 1 );
function solace_disable_main_address_validation( $fields ) {
    $main_address_setting = get_theme_mod( 'woocommerce_checkout_main_address_field', 'optional' );

    if ( 'hidden' === $main_address_setting ) {
        $keys = [ 'billing_address_1', 'billing_address_2', 'billing_city', 'billing_state', 'billing_postcode', 'billing_country' ];

        foreach ( $keys as $key ) {
            if ( isset( $fields['billing'][ $key ] ) ) {
                unset( $fields['billing'][ $key ] );
            }
        }
    }

    return $fields;
}

add_action( 'woocommerce_after_checkout_validation', 'solace_cleanup_main_address_validation', 10, 2 );

function solace_cleanup_main_address_validation( $data, $errors ) {
    $main_address_setting = get_theme_mod( 'woocommerce_checkout_main_address_field', 'optional' );

    if ( 'hidden' === $main_address_setting ) {
        $remove_errors_for = [
            'billing_address_1',
            'billing_address_2',
            'billing_city',
            'billing_state',
            'billing_postcode',
            'billing_country',
        ];

        foreach ( $remove_errors_for as $field ) {
            if ( isset( $errors->errors[ $field ] ) ) {
                unset( $errors->errors[ $field ] );
            }
        }
    }
}

add_action( 'woocommerce_after_checkout_validation', 'solace_skip_shipping_validation', 20, 2 );

function solace_skip_shipping_validation( $data, $errors ) {
    $main_address_status = get_theme_mod( 'woocommerce_checkout_main_address_field', 'optional' );

    if ( $main_address_status === 'hidden' ) {
        if ( isset( $errors->errors['shipping'] ) ) {
            unset( $errors->errors['shipping'] );
        }
    }
}

add_action( 'wp_head', 'hide_billing_required_asterisk_conditionally' );
function hide_billing_required_asterisk_conditionally() {
    $main_address_option = get_theme_mod( 'woocommerce_checkout_main_address_field', 'optional' );
    
    if ( $main_address_option === 'optional' ) {
        ?>
        <style>
            #billing_address_1_field .required,
            #billing_address_2_field .required,
            #billing_city_field .required,
            #billing_state_field .required,
            #billing_postcode_field .required,
            #billing_country_field .required {
                display: none !important;
            }
        </style>
        <?php
    }
}

add_filter( 'body_class', 'detect_all_woocommerce_pages_and_shortcodes', 20 );
function detect_all_woocommerce_pages_and_shortcodes( $classes ) {

    if ( ! function_exists( 'WC' ) ) {
        return $classes;
    }

    $is_wc = false;

    if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
        $is_wc = true;
    }

    if ( function_exists( 'wc_get_page_id' ) && is_page() ) {
        $wc_pages = array(
            wc_get_page_id( 'shop' ),
            wc_get_page_id( 'cart' ),
            wc_get_page_id( 'checkout' ),
            wc_get_page_id( 'myaccount' ),
        );

        if ( in_array( get_queried_object_id(), $wc_pages, true ) ) {
            $is_wc = true;
        }
    }

    if ( is_page() ) {
        $post = get_post();
        if ( $post && has_shortcode( $post->post_content, 'woocommerce_cart' ) ||
             $post && has_shortcode( $post->post_content, 'woocommerce_checkout' ) ||
             $post && has_shortcode( $post->post_content, 'woocommerce_my_account' ) ||
             $post && has_shortcode( $post->post_content, 'products' ) ||
             $post && has_shortcode( $post->post_content, 'product_page' )
        ) {
            $is_wc = true;
        }
    }

    if ( $is_wc ) {
        $classes[] = 'woocommerce-block-theme-has-button-styles';
    }

    return $classes;
}

/**
 * Redefine the mini-cart widget buttons ("View cart" / "Checkout") to add
 * Elementor button classes.
 *
 * WooCommerce wraps these in `function_exists()`, and its definitions load at
 * `after_setup_theme` priority 11 — after the theme has loaded — so defining
 * them here wins.
 */
if ( ! function_exists( 'woocommerce_widget_shopping_cart_button_view_cart' ) ) {
	/**
	 * Output the widget "View cart" button with Elementor button classes.
	 *
	 * @return void
	 */
	function woocommerce_widget_shopping_cart_button_view_cart() {
		$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
		echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward elementor-button elementor-button--default' . esc_attr( $wp_button_class ) . '">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
	}
}

if ( ! function_exists( 'woocommerce_widget_shopping_cart_proceed_to_checkout' ) ) {
	/**
	 * Output the widget "Checkout" button with Elementor button classes.
	 *
	 * @return void
	 */
	function woocommerce_widget_shopping_cart_proceed_to_checkout() {
		$wp_button_class = wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '';
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward elementor-button elementor-button--default' . esc_attr( $wp_button_class ) . '">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
	}
}

/**
 * Product Tags Cloud: mark the currently-viewed product tag with an
 * `is-active` class so CSS can style it like the button hover state.
 *
 * @param string $html Tag cloud HTML.
 * @param array  $args Tag cloud args.
 * @return string
 */
add_filter(
	'wp_tag_cloud',
	function ( $html, $args ) {
		if ( ! is_tax( 'product_tag' ) ) {
			return $html;
		}

		$term = get_queried_object();
		if ( ! $term || empty( $term->term_id ) ) {
			return $html;
		}

		$needle   = 'tag-link-' . (int) $term->term_id;
		$replaced = 0;
		if ( false !== strpos( $html, $needle ) ) {
			$html = str_replace( $needle, $needle . ' is-active', $html, $replaced );
		}

		return $html;
	},
	10,
	2
);

/**
 * WooCommerce brand widgets read `$instance['title']` without a default
 * (class-wc-widget-brand-nav.php, -thumbnails.php, -description.php). An empty
 * instance saved by the customizer triggers "Undefined array key 'title'" plus
 * a str_contains() null deprecation. Backfill a default title on load.
 */
foreach ( array( 'widget_woocommerce_brand_nav', 'widget_wc_brands_brand_thumbnails', 'widget_wc_brands_brand_description' ) as $brand_widget_option ) {
	add_filter( 'option_' . $brand_widget_option,
		static function ( $value ) {
			if ( ! is_array( $value ) ) {
				return $value;
			}

			foreach ( $value as $key => $instance ) {
				if ( '_multiwidget' === $key || ! is_array( $instance ) ) {
					continue;
				}
				if ( ! isset( $instance['title'] ) ) {
					$instance['title'] = '';
					$value[ $key ]     = $instance;
				}
			}

			return $value;
		}
	);
}
/**
 * Brand taxonomy archives must use the WooCommerce archive template.
 *
 * WooCommerce Brands registers taxonomy-product_brand.php (which loads
 * archive-product.php) via template_loader at priority 10, but
 * Solace Extra Pro's override_archive_template runs at 99999 and only
 * exempts product_cat/product_tag/shop — product_brand falls through to
 * the blog archive template. Re-assert the WC brands template afterwards.
 */
add_filter(
	'template_include',
	function ( $template ) {
		if ( function_exists( 'is_tax' ) && is_tax( 'product_brand' ) ) {
			// Let the Solace Extra Shop Product Archive part win when its
			// conditions match this brand archive; only re-assert the plain
			// WooCommerce Brands template when no override applies.
			if ( function_exists( 'solace_extra_pro_resolve_shopproduct_post_id' ) && solace_extra_pro_resolve_shopproduct_post_id() ) {
				return $template;
			}
			$brand_template = WC()->plugin_path() . '/templates/brands/taxonomy-product_brand.php';
			if ( file_exists( $brand_template ) ) {
				return $brand_template;
			}
		}
		return $template;
	},
	100000
);
