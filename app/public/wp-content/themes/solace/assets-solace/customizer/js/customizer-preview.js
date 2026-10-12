/**
 * File customize-preview.js.
 *
 * Instantly live-update customizer settings in the preview for improved user experience.
 */

/* =========================================
============ TABLE OF CONTENTS: ============
* General Fonts
========================================= */
(function ($) {

	// =================== (General Fonts) ===================

	
	wp.customize('solace_wc_custom_general_star_rating_show', function(value) {
        value.bind(function(newval) {
            if (newval) {
                $('.woocommerce .star-rating, .woocommerce .woocommerce-product-rating').show(); // Show the star rating
            } else {
                $('.woocommerce .star-rating, .woocommerce .woocommerce-product-rating').hide(); // Hide the star rating
            }
        });
    });

	wp.customize('solace_wc_custom_general_star_rating_color', function(value) {
        value.bind(function(newval) {
            $('.woocommerce .star-rating').css('color', newval); // Change the star rating color
        });
    });

	wp.customize('solace_wc_custom_general_product_badges_color', function(value) {
        value.bind(function(newval) {
            $('.woocommerce ul.products .img-wrap span.onsale').css('color', newval); // Change the star rating color
        });
    });

	wp.customize('solace_wc_custom_general_product_badges_background_color', function(value) {
        value.bind(function(newval) {
            $('.woocommerce ul.products .img-wrap span.onsale').css('background-color', newval); // Change the star rating color
        });
    });

	wp.customize('solace_wc_custom_general_store_notice_font_color', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-store-notice, p.demo_store').css('color', newval); // Change the star rating color
        });
    });

	wp.customize('solace_wc_custom_general_store_notice_background_color', function(value) {
        value.bind(function(newval) {
            $('.woocommerce-store-notice, p.demo_store').css('background-color', newval); // Change the star rating color
        });
    });

	wp.customize('solace_wc_custom_general_store_notice_show', function(value) {
		value.bind(function(newval) {
			if (newval) {
				$('.woocommerce-store-notice.demo_store').show();
			} else {
				$('.woocommerce-store-notice.demo_store').hide();
			}
		});
	});

	wp.customize('solace_wc_custom_general_product_badges_shape', function(value) {
        value.bind(function(newval) {
			var css = '';
			var classToAdd = '';
			switch (newval) {
				case 'badge-2':
					classToAdd = 'badge-2';
					break;
				case 'badge-3':
					classToAdd = 'badge-3';
					break;
				case 'badge-1':
				default:
					classToAdd = 'badge-1';
					break;
			}
			document.querySelectorAll('.woocommerce ul.products .img-wrap span.onsale').forEach(function(el) {
				el.classList.remove('badge-1', 'badge-2', 'badge-3');
				el.classList.add(classToAdd);
			});
			document.querySelectorAll('body.single-product .woocommerce-product-gallery__image .onsale').forEach(function(el) {
				el.classList.remove('badge-1', 'badge-2', 'badge-3');
				el.classList.add(classToAdd);
			});
		});
    });

	wp.customize('solace_wc_custom_general_product_badges_label', function(value) {
		value.bind(function(newval) {
			var badges = document.querySelectorAll('.woocommerce ul.products .img-wrap span.onsale');
			
			badges.forEach(function(badge) {
				badge.textContent = newval;
			});

			var singleProductBadges = document.querySelectorAll('body.single-product .woocommerce-product-gallery__image .onsale');
			
			singleProductBadges.forEach(function(badge) {
				badge.textContent = newval;
			});
		});
	});

	wp.customize('solace_wc_custom_general_cart_coupon', function(value) {
		value.bind(function(newval) {
			var couponForms = document.querySelectorAll('.woocommerce-cart .coupon, .woocommerce-cart .wp-block-woocommerce-cart-order-summary-coupon-form-block.wc-block-components-totals-wrapper');
	
			couponForms.forEach(function(couponForm) {
				if (newval) {
					couponForm.style.display = 'flex';
				} else {
					couponForm.style.display = 'none';
				}
			});
		});
	});

	wp.customize( 'solace_wc_custom_general_store_notice_show', function( value ) {
        value.bind( function( newval ) {
            console.log('Store Notice visibility changed:', newval);

            // Ensure the changed element matches the correct selector.
            var noticeElements = document.querySelectorAll('.woocommerce-shop p.woocommerce-store-notice.demo_store');
            
            noticeElements.forEach(function(noticeElement) {
                if ( newval ) {
                    noticeElement.style.setProperty('display', 'block', 'important');
                } else {
                    noticeElement.style.setProperty('display', 'none', 'important');
                }
            });
        });
    });
		
	// Fix woocommerce pagination border radius.
	wp.customize('solace_product_page_pagination_border_radius', function(value) {
        value.bind(function(newval) {
            $('body.woocommerce-shop nav.woocommerce-pagination ul li span.current').css('borderRadius', newval);
        });
    }); 

	// Site title
	wp.customize('blogname', function(value) {
		value.bind(function(newval) {
			$('.site-title').text(newval);
		});
	});

	// Site tagline
	wp.customize('blogdescription', function(value) {
		value.bind(function(newval) {
			$('.site-description').text(newval);
		});
	});


})(jQuery);


(function ($) {
    wp.customize('solace_wc_custom_general_cart_title_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-title-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_title_color_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-title-color-hover', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_description_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-description-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_description_color_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-description-color-hover', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_price_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-price-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_button_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-button-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_button_color_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-button-color-hover', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_button_color_bg', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-button-color-bg', newval);
        });
    });

    wp.customize('solace_wc_custom_general_cart_button_color_bg_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-cart-button-color-bg-hover', newval);
        });
    });
	// CHECKOUT === 
    wp.customize('solace_wc_custom_general_checkout_title_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-title-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_checkout_description_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-description-color', newval);
        });
    });

	wp.customize('solace_wc_custom_general_checkout_button_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-button-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_checkout_button_color_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-button-color-hover', newval);
        });
    });

    wp.customize('solace_wc_custom_general_checkout_button_color_bg', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-button-color-bg', newval);
        });
    });

    wp.customize('solace_wc_custom_general_checkout_button_color_bg_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-checkout-button-color-bg-hover', newval);
        });
    });
	//ACCOUNT
	wp.customize('solace_wc_custom_general_account_title_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-title-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_account_description_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-description-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_account_price_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-price-color', newval);
        });
    });

	wp.customize('solace_wc_custom_general_account_button_color', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-button-color', newval);
        });
    });

    wp.customize('solace_wc_custom_general_account_button_color_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-button-color-hover', newval);
        });
    });

    wp.customize('solace_wc_custom_general_account_button_color_bg', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-button-color-bg', newval);
        });
    });

    wp.customize('solace_wc_custom_general_account_button_color_bg_hover', function (value) {
        value.bind(function (newval) {
            document.documentElement.style.setProperty('--sol-account-button-color-bg-hover', newval);
        });
    });
})(jQuery);

