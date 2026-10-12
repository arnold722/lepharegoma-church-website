( function( $ ) {
        
    const systemFonts = [
        'Comic Sans MS', 'Georgia', 'Garamond', 'Impact',
        'Times New Roman', 'Arial', 'Verdana', 'Courier',
        'Tahoma', 'Trebuchet MS', 'Lucida Console', 'Lucida Sans Unicode',
        'MS Sans Serif', 'MS Serif', 'Palatino Linotype', 'Bookman Old Style'
    ];

    function fontNameToQuoted(fontName) {
        return fontName
            .split(',')
            .map(f => `"${f.trim()}"`)
            .join(', ') + ', sans-serif';
    }

    function loadGoogleFont(fontName, controlID) {
        if (!fontName) return;
    
        const mainFont = fontName.split(',')[0].trim().replace(/^"|"$/g, '');
        const isSystemFont = systemFonts.includes(mainFont);
    
        const quotedFontName = fontName
            .split(',')
            .map(f => `"${f.trim()}"`)
            .join(', ');
            
        if (!isSystemFont) {
            // console.log('Memuat Google Font: ' + quotedFontName);
    
            const googleFontName = mainFont.replace(/ /g, '+');
            const fontUrl = `https://fonts.googleapis.com/css2?family=${googleFontName}:wght@300;400;700&display=swap`;
            const linkID = controlID + '-google-font';
    
            if ($(`link#${linkID}`).length) {
                $(`link#${linkID}`).attr('href', fontUrl);
            } else {
                $('head').append(`<link id="${linkID}" rel="stylesheet" type="text/css" href="${fontUrl}">`);
            }
        } else {
            // console.log('Using system font: ' + mainFont);
        }
    
    }

    function bindFontCustomizer(controlID, selector) {
        wp.customize(controlID, function (value) {
            value.bind(function (newval) {
                loadGoogleFont(newval, controlID);
                $(selector).css('font-family', fontNameToQuoted(newval));
            });
        });
    }

    // Cart Font-Family
    bindFontCustomizer(
        'solace_wc_custom_general_cart_title_font_family',
        'body.woocommerce-cart:not(.elementor-page) .wc-block-cart-items .wc-block-components-product-name, .woocommerce-cart .cross-sells-product .wc-block-components-product-name, .woocommerce-cart .wc-block-cart table th span, .woocommerce-cart .wc-block-cart .wp-block-woocommerce-cart-cross-sells-block h2, .woocommerce-cart .wc-block-cart .wc-block-cart__totals-title, .woocommerce-cart .wc-block-cart .wc-block-components-totals-item__label, body.woocommerce-cart:not(.elementor-page) .wc-block-components-totals-coupon .wc-block-components-panel__button,body.woocommerce-cart:not(.elementor-page) .is-large.wc-block-cart .wc-block-cart__totals-title, body.woocommerce-cart:not(.elementor-page) .woocommerce .woocommerce-cart-form .shop_table th, body.woocommerce-cart:not(.elementor-page) .woocommerce .woocommerce-cart-form .shop_table td, body.woocommerce-cart:not(.elementor-page) .woocommerce-cart-form .shop_table td.product-name a, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cross-sells h2, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cross-sells ul.products li.product a.woocommerce-loop-product__link>h2, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cart_totals h2, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cart_totals th'
    );

    bindFontCustomizer(
        'solace_wc_custom_general_cart_description_font_family',
        'body.woocommerce-cart:not(.elementor-page) .wc-block-components-product-metadata__description>p'
    );

    bindFontCustomizer(
        'solace_wc_custom_general_cart_price_font_family',
        'body.woocommerce-cart:not(.elementor-page) .wc-block-components-product-price__regular, body.woocommerce-cart:not(.elementor-page) .wc-block-components-product-price__value.is-discounted, body.woocommerce-cart:not(.elementor-page) .wc-block-components-product-price__value, body.woocommerce-cart:not(.elementor-page) .cross-sells-product .wc-block-components-product-price__value, body.woocommerce-cart:not(.elementor-page) .wc-block-components-sale-badge, body.woocommerce-cart:not(.elementor-page) .cross-sells-product .wc-block-components-quantity-selector input, body.woocommerce-cart:not(.elementor-page) .wc-block-cart-items .wc-block-cart-item__total .wc-block-components-formatted-money-amount, body.woocommerce-cart:not(.elementor-page) .woocommerce-cart-form .shop_table .product-price .woocommerce-Price-amount, body.woocommerce-cart:not(.elementor-page) .woocommerce-cart-form .shop_table .product-subtotal .woocommerce-Price-amount, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cross-sells ul.products li.product .price .woocommerce-Price-amount, body.woocommerce-cart:not(.elementor-page) .wc-block-components-formatted-money-amount, body.woocommerce-cart:not(.elementor-page) .woocommerce-Price-amount.amount'
    );

    bindFontCustomizer(
        'solace_wc_custom_general_cart_button_font_family',
        'body.woocommerce-cart:not(.elementor-page) .cross-sells-product button.add_to_cart_button, body.woocommerce-cart:not(.elementor-page) .wp-block-woocommerce-cart-totals-block .wc-block-cart__submit-container a.wc-block-components-button.wp-element-button.wc-block-cart__submit-button.contained span, body.woocommerce-cart:not(.elementor-page) .wc-block-components-totals-coupon__content button.wc-block-components-button span, body.woocommerce-cart:not(.elementor-page) .shop_table .coupon .button, body.woocommerce-cart:not(.elementor-page) .shop_table .button, body.woocommerce-cart:not(.elementor-page) .cart-collaterals .cart_totals .checkout-button, body.woocommerce-cart:not(.elementor-page) .woocommerce table.cart td.actions .coupon .input-text#coupon_code+.button, body.woocommerce-cart:not(.elementor-page) a.button:not(header a.button):not(footer a.button), body.woocommerce-cart:not(.elementor-page) .button:not(header .button):not(footer .button), body.woocommerce-cart:not(.elementor-page) table.cart td.actions .button:disabled, body.woocommerce-cart:not(.elementor-page) ul.products li.product .button, body:not(.dokan-theme-solace) .woocommerce ul.products li.product .button'
    );

    // Checkout Font-Family
    bindFontCustomizer(
        'solace_wc_custom_general_checkout_title_font_family',
        'body.woocommerce-checkout h2, body.woocommerce-checkout form.checkout .nv-customer-details h3,body.woocommerce-checkout .nv-order-review h3'
    );
    bindFontCustomizer(
        'solace_wc_custom_general_checkout_description_font_family',
        'body.woocommerce-checkout p.wc-block-components-checkout-step__description, body.woocommerce-checkout .wc-block-checkout__terms span'
    );
    bindFontCustomizer(
        'solace_wc_custom_general_checkout_button_font_family',
        'body.woocommerce-checkout button.wc-block-components-button.wp-element-button.wc-block-components-checkout-place-order-button.contained .wc-block-components-checkout-place-order-button__text, body.woocommerce-checkout:not(.elementor-page) .woocommerce-billing-fields .checkout_coupon button, body.woocommerce-checkout .woocommerce-checkout-payment button'
    );
    
    // MyAccount Font-Family
    bindFontCustomizer(
        'solace_wc_custom_general_account_title_font_family',
        'body.woocommerce-account .woocommerce th, body.woocommerce-account .woocommerce h2, body.woocommerce-account .woocommerce p label'
    );
    bindFontCustomizer(
        'solace_wc_custom_general_account_description_font_family',
        'body.woocommerce-account .woocommerce td, body.woocommerce-account .woocommerce p'
    );
    bindFontCustomizer(
        'solace_wc_custom_general_account_price_font_family',
        'body.woocommerce-account .woocommerce td.woocommerce-table__product-total.product-total, body.woocommerce-account .woocommerce td span.woocommerce-Price-amount.amount'
    );
    bindFontCustomizer(
        'solace_wc_custom_general_account_button_font_family',
        'body.woocommerce-account .woocommerce button, body.woocommerce-account:not(.elementor-default) .woocommerce form.woocommerce-EditAccountForm button[type=submit], body.woocommerce-account:not(.elementor-default) .woocommerce a.button:not(header a.button):not(footer a.button), body.woocommerce-account:not(.elementor-default) .woocommerce .button:not(header .button):not(footer .button)'
    );
    

} )( jQuery );
