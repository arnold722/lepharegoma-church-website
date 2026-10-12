(function ($) {

    // Close Sidebar Woocommerce
    $('.nv-sidebar-wrap aside .close svg').click(function(){
        $('html').attr('class', '');
        $('.nv-sidebar-wrap aside').removeClass('sidebar-open');
    });

    if ($(".wc-block-components-text-input").hasClass("has-error")) {
        $( ".wc-block-components-totals-coupon__button" ).css("bottom", "33px !important");
    }

    $(window).on('load', function() {
        // Use setTimeout to delay the check and execution.
        setTimeout(function() {
            // Check if elements with classes `woocommerce-product-gallery__trigger` and `flex-viewport` exist
            if ($('.single-product .woocommerce-product-gallery .woocommerce-product-gallery__trigger').length || $('.single-product .woocommerce-product-gallery .flex-viewport').length) {
                // Select the element with class `woocommerce-product-gallery__trigger`
                const triggerElement = $('.single-product .woocommerce-product-gallery .woocommerce-product-gallery__trigger');
                // Move the selected element to be a child of the element with class `flex-viewport`
                $('.single-product .woocommerce-product-gallery .flex-viewport').append(triggerElement);
                $('.single-product .woocommerce-product-gallery__image').append(triggerElement);
            }

            // Check if elements with classes `onsale` and `flex-viewport` exist
            if ($('.single-product .onsale').length || $('.single-product .flex-viewport').length) {
                // Select the element with class `onsale`
                const triggerElement = $('.single-product .onsale');
                // Move the selected element to be a child of the element with class `flex-viewport`
                $('.single-product .flex-viewport').append(triggerElement);
                $('.single-product .woocommerce-product-gallery__image').append(triggerElement);
            }
        }, 200);
    });

})(jQuery);

(function ($) {
    function addElementorButtonClass() {
        $('.woocommerce .button').each(function() {
            if (!$(this).hasClass('elementor-button')) {
                $(this).addClass('elementor-button');
            }
        });
    }

    function observeDOMChanges() {
        const targetNode = document.body; 
        const config = { childList: true, subtree: true };

        const callback = function(mutationsList) {
            for (const mutation of mutationsList) {
                if (mutation.type === 'childList') {
                    addElementorButtonClass(); 
                }
            }
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    }

    function isElementorPreview() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.has('elementor-preview') || document.body.classList.contains('elementor-editor-active');
    }

    $(document).ready(function() {
        addElementorButtonClass(); 

        // if (isElementorPreview()) {
        //     console.log("Elementor Preview Detected");

        //     document.body.classList.add('is-elementor-preview'); 
        //     observeDOMChanges();

        //     // apply color to button in live preview elementor
        //     function updateButtonColor() {
        //         let buttonColor = $('.elementor-button').css('background-color'); 
                
        //         $('.button.add_to_cart_button').not('.solace-extra-add-to-cart .add_to_cart_button').css({
        //             'background-color': buttonColor,
        //             'border-color': buttonColor
        //         });
        //     }
            
        //     updateButtonColor();
        
        //     setInterval(updateButtonColor, 1000);
        // }
    });
    

})(jQuery);



