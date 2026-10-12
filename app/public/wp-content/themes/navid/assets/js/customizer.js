/**
 * Customizer Preview JS
 */
(function($) {
    // Container Width
    wp.customize('navid_content_width', function(value) {
        value.bind(function(newval) {
            $(':root').css('--max-width', newval + 'px');
        });
    });

    // Accent Color (Palette Custom)
    wp.customize('navid_accent_color', function(value) {
        value.bind(function(newval) {
            $(':root').css('--sage', newval);
            $(':root').css('--terracotta', newval);
            // We can't easily recalculate color-mix in JS for all variables, 
            // but the browser will handle it if we just update the base variable.
        });
    });

    // Image Radius
    wp.customize('navid_global_image_radius', function(value) {
        value.bind(function(newval) {
            $('.post-thumbnail, .post-card, .bento-item, .wp-block-image img, .entry-content img, .woocommerce-product-gallery__image img').css('border-radius', newval + 'px');
        });
    });

    // Logo Height
    wp.customize('navid_logo_height', function(value) {
        value.bind(function(newval) {
            $('img.custom-logo, .logo img').attr('style', 'max-height: ' + newval + 'px !important; width: auto !important; height: auto !important;');
            $('.site-header .logo').css('font-size', newval + 'px');
        });
    });

})(jQuery);
