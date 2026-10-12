/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function($) {
    // Page Settings - Container width custom
	wp.customize.bind( 'ready', function() {
		let body = jQuery( 'body' );
		body.addClass( 'solace-wp-version-6-7-plus' );
		body.addClass( 'solace-wp-customizer-controls' );

		wp.customize( 'solace_container_layout', function( setting ) {
			wp.customize.control( 'solace_container_width', function( control ) {
				var visibility = function() {
					if ( 'custom' === setting.get() ) {
						control.container.slideDown( 180 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	});

    // Single Settings - Single width custom
	wp.customize.bind( 'ready', function() {
		wp.customize( 'solace_post_layout', function( setting ) {
			wp.customize.control( 'solace_container_post_width', function( control ) {
				var visibility = function() {
					if ( 'custom' === setting.get() ) {
						control.container.slideDown( 180 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	});

    // Page Settings - Page width custom
	wp.customize.bind( 'ready', function() {
		wp.customize( 'solace_page_layout', function( setting ) {
			wp.customize.control( 'solace_container_page_width', function( control ) {
				var visibility = function() {
					if ( 'custom' === setting.get() ) {
						control.container.slideDown( 180 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	});

    // Page Settings - Blog / Archive
	// wp.customize.bind( 'ready', function() {
	// 	wp.customize( 'solace_container_layout', function( setting ) {
	// 		wp.customize.control( 'solace_blog_archive_layout', function( control ) {
	// 			var visibility = function() {
	// 				console.log(setting.get());
	// 				if ( 'boxed' === setting.get() ) {
	// 					// Set the value of solace_blog_archive_layout to '1x3'
	// 					control.setting.set('1x3');
	// 					$('li#customize-control-solace_blog_archive_layout [data-option="1x3"]').trigger('click');

	// 					setTimeout(function() { 
	// 						// 3x3
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="3x3"] button').prop('disabled', true);
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="3x3"]').addClass('disabled');
	// 						// 2x3
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="2x3"] button').prop('disabled', true);
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="2x3"]').addClass('disabled');
	// 						// custom
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="custom"] button').prop('disabled', true);
	// 						$('li#customize-control-solace_blog_archive_layout label[data-option="custom"]').addClass('disabled');
	// 					}, 500);
	// 				} else {
	// 					$('li#customize-control-solace_blog_archive_layout label button').prop('disabled', false);
	// 					$('li#customize-control-solace_blog_archive_layout label').removeClass('disabled');
	// 				}
	// 			};

	// 			visibility();
	// 			setting.bind( visibility );
	// 		});
	// 	});
	// });	

	// Row Header Top
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_header_layout_top_layout', function( setting ) {
			wp.customize.control( 'hfg_header_layout_top_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});

	// Row Header Main
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_header_layout_main_layout', function( setting ) {
			wp.customize.control( 'hfg_header_layout_main_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});

	// Row Header Bottom
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_header_layout_bottom_layout', function( setting ) {
			wp.customize.control( 'hfg_header_layout_bottom_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});

	// Row Footer Top
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_footer_layout_top_layout', function( setting ) {
			wp.customize.control( 'hfg_footer_layout_top_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});

	// Row Footer Main
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_footer_layout_main_layout', function( setting ) {
			wp.customize.control( 'hfg_footer_layout_main_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});

	// Row Footer Bottom
	wp.customize.bind( 'ready', function() {
		wp.customize( 'hfg_footer_layout_bottom_layout', function( setting ) {
			wp.customize.control( 'hfg_footer_layout_bottom_width', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( 'layout-custom' === setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});
	});	

	// Header Social Icons
	wp.customize.bind( 'ready', function() {
		wp.customize( 'header_social_toggle_icon', function( setting ) {
			wp.customize.control( 'header_social_toggle_color_icon', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( false == setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});

		// Header social icon color pelangi
		$('li#customize-control-header_social_toggle_color_icon .global-color-picker').click(function(){
		let dataColorHeader = $('li#customize-control-header_social_toggle_color_icon button.border-mycolor span').attr('data-color');
			wp.customize('header_social_toggle_color_icon', function (setting) {
				// Function to update visibility of a specific control
				var updateVisibility = function (control) {
					var visibility = function () {
						// Set the value of the control to the value of 'header_social_toggle_color_icon'
						if ( dataColorHeader !== setting.get() ) {
							control.setting.set(setting.get());
							$('li#customize-control-' + control.id + ' .components-dropdown .border-mycolor span').css('background', setting.get());
						}
					};
					// Initial visibility update
					visibility();
					// Bind the visibility function to the setting change
					setting.bind(visibility);
				};
			
				// List of controls to be updated
				var controlsToUpdate = [
					'header_social_icon_color_facebook_setting',
					'header_social_icon_color_youtube_setting',
					'header_social_icon_color_twitter_setting',
					'header_social_icon_color_tiktok_setting',
					'header_social_icon_color_telegram_setting',
					'header_social_icon_color_pinterest_setting',
					'header_social_icon_color_linkedin_setting',
					'header_social_icon_color_instagram_setting',
					'header_social_icon_color_threads_setting',
					'header_social_icon_color_whatsapp_setting'
				];

				// Iterate through each control and apply the visibility update
				controlsToUpdate.forEach(function (controlId) {
					wp.customize.control(controlId, function (control) {
						// Call the updateVisibility function for each control
						updateVisibility(control);
					});
				});
			});
		});
	});

	// Header Toogle Color
	wp.customize.bind('ready', function () {
		wp.customize('header_social_toggle_icon', function (setting) {
			var visibility = function() {
				var body = jQuery('body');
				if ( setting.get() == false ) {
					body.addClass('deactive-header-social-icon');
					body.removeClass('active-header-social-icon');
				} else {
					body.removeClass('deactive-header-social-icon');
					body.addClass('active-header-social-icon');
				}
			};
			visibility();
			setting.bind( visibility );
		});
	});

	// Footer Social Icons
	wp.customize.bind( 'ready', function() {
		wp.customize( 'footer_social_toggle_icon', function( setting ) {
			wp.customize.control( 'footer_social_toggle_color_icon', function( control ) {
				var visibility = function() {
					setTimeout(function() { 
						if ( false == setting.get() ) {
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					}, 500);
				};
				visibility();
				setting.bind( visibility );
			});
		});

		$('li#customize-control-footer_social_toggle_color_icon .global-color-picker').click(function(){
		let dataColorFooter = $('li#customize-control-footer_social_toggle_color_icon button.border-mycolor span').attr('data-color');		
			wp.customize('footer_social_toggle_color_icon', function (setting) {
				// Function to update visibility of a specific control
				var updateVisibility = function (control) {
					var visibility = function () {
						// Set the value of the control to the value of 'footer_social_toggle_color_icon'
						if ( dataColorFooter !== setting.get() ) {
							control.setting.set(setting.get());
							$('li#customize-control-' + control.id + ' .components-dropdown .border-mycolor span').css('background', setting.get());
						}						
					};
					// Initial visibility update
					visibility();
					// Bind the visibility function to the setting change
					setting.bind(visibility);
				};
			
				// List of controls to be updated
				var controlsToUpdate = [
					'footer_social_icon_color_facebook_setting',
					'footer_social_icon_color_youtube_setting',
					'footer_social_icon_color_twitter_setting',
					'footer_social_icon_color_tiktok_setting',
					'footer_social_icon_color_telegram_setting',
					'footer_social_icon_color_pinterest_setting',
					'footer_social_icon_color_linkedin_setting',
					'footer_social_icon_color_instagram_setting',
					'footer_social_icon_color_threads_setting',
					'footer_social_icon_color_whatsapp_setting'					
				];

				// Iterate through each control and apply the visibility update
				controlsToUpdate.forEach(function (controlId) {
					wp.customize.control(controlId, function (control) {
						// Call the updateVisibility function for each control
						updateVisibility(control);
					});
				});
			});		
		});
	});	

	// Footer Toogle Color	
	wp.customize.bind('ready', function () {
		wp.customize('footer_social_toggle_icon', function (setting) {
			var visibility = function() {
				var body = jQuery('body');
				if ( setting.get() == false ) {
					body.addClass('deactive-footer-social-icon');
					body.removeClass('active-footer-social-icon');
				} else {
					body.removeClass('deactive-footer-social-icon');
					body.addClass('active-footer-social-icon');
				}
			};
			visibility();
			setting.bind( visibility );
		});
	});	
	
	// Featured Image
	wp.customize.bind('ready', function () {
		wp.customize('solace_single_post_featured_image', function (setting) {
			var visibility = function() {
				
				let data = setting.get();
				let body = jQuery('body');
				const desktopImageRatio = data['desktop']['imageRatio'];
				const tabletImageRatio  = data['tablet']['imageRatio'];
				const mobileImageRatio  = data['mobile']['imageRatio'];
				
				// Desktop
				if ( 'original' !== desktopImageRatio ) {
					body.addClass('hide-image-scale-in-desktop');
				} else {
					body.removeClass('hide-image-scale-in-desktop');
				}
				
				// Tablet
				if ( 'original' !== tabletImageRatio ) {
					body.addClass('hide-image-scale-in-tablet');
				} else {
					body.removeClass('hide-image-scale-in-tablet');
				}
				
				// Mobile
				if ( 'original' !== mobileImageRatio ) {
					body.addClass('hide-image-scale-in-mobile');
				} else {
					body.removeClass('hide-image-scale-in-mobile');
				}
				
			};
			visibility();
			setting.bind( visibility );
			
		});	
	});	

	// Layout single post element
	wp.customize.bind( 'ready', function() {
		wp.customize( 'solace_post_header_layout', function( setting ) {
			// Box shadow
			wp.customize.control( 'solace_single_post_box_shadow', function( control ) {
				var visibility = function() {
                    if ( 'layout 1' === setting.get() || 'layout 2' === setting.get() || 'layout 3' === setting.get() ) {
                        // control.container.slideUp( 180 );
						$('#customize-control-solace_single_post_box_shadow').css({
							'position': 'absolute', 
							'top': '-99999px'
						});
                    } else {
                        // control.container.slideDown( 180 );
						$('#customize-control-solace_single_post_box_shadow').css({
							'position': 'relative', 
							'top': 'unset'
						});						
                    }
				};
				visibility();
				setting.bind( visibility );
			});

			// Padding
			wp.customize.control( 'solace_single_post_padding', function( control ) {
				var visibility = function() {
                    if ( 'layout 1' === setting.get() || 'layout 2' === setting.get() || 'layout 3' === setting.get() ) {
						$('#customize-control-solace_single_post_padding').css({
							'position': 'absolute', 
							'top': '-99999px'
						});
                    } else {
						$('#customize-control-solace_single_post_padding').css({
							'position': 'relative', 
							'top': 'unset'
						});						
                    }
				};
				visibility();
				setting.bind( visibility );
			});

			// Border Radius
			wp.customize.control( 'solace_single_post_border_radius', function( control ) {
				var visibility = function() {
                    if ( 'layout 1' === setting.get() || 'layout 2' === setting.get() || 'layout 3' === setting.get() ) {
						$('#customize-control-solace_single_post_border_radius').css({
							'position': 'absolute', 
							'top': '-99999px'
						});
                    } else {
						$('#customize-control-solace_single_post_border_radius').css({
							'position': 'relative', 
							'top': 'unset'
						});						
                    }
				};
				visibility();
				setting.bind( visibility );
			});

			// Only available for custom layout
			// wp.customize.control( 'solace_single_only_available_for_custom_layout', function( control ) {
			// 	var visibility = function() {
            //         if ( 'layout 1' === setting.get() || 'layout 2' === setting.get() || 'layout 3' === setting.get() ) {
			// 			$('li#customize-control-solace_single_post_element').addClass('only-custom');
			// 			$('li#customize-control-solace_single_only_available_for_custom_layout').addClass('only-custom');
			// 			$('li#customize-control-solace_single_only_available_for_custom_layout').css({
			// 				'height': 'auto',
			// 				'color': 'var(--sol-customizer-text-color)',
			// 				'display': 'block'
			// 			});
            //         } else {
			// 			$('li#customize-control-solace_single_post_element').removeClass('only-custom');					
			// 			$('li#customize-control-solace_single_only_available_for_custom_layout').removeClass('only-custom');				
			// 			$('li#customize-control-solace_single_only_available_for_custom_layout').css({
			// 				'height': '0',
			// 				'color': 'transparent',
			// 				'display': 'none'
			// 			});
            //         }
			// 	};
			// 	visibility();
			// 	setting.bind( visibility );
			// });			
		});

		// Fix only enable single post element (On load).
		// Initial variable.
		let solacePostHeaderLayout;

		// Get the initial value of the setting.
		wp.customize('solace_post_header_layout', function(value) {
			// Initial value.
			solacePostHeaderLayout = value.get();

			// Updated value.
			value.bind(function(newValue) {
				solacePostHeaderLayout = newValue;
			});
		});
		$(window).on('load', function() {
			const dataSingleTab = $( '#customize-control-solace_blog_single_post .solace-customizer-tab.active' ).attr('data-tab');
			if ( 'general' === dataSingleTab && 'layout 1' === solacePostHeaderLayout || 'layout 2' === solacePostHeaderLayout || 'layout 3' === solacePostHeaderLayout) {
				$('li#customize-control-solace_single_post_element').addClass('only-custom');
				$('li#customize-control-solace_single_only_available_for_custom_layout').addClass('only-custom');
				$('li#customize-control-solace_single_only_available_for_custom_layout').css({
					'height': 'auto',
					'color': 'var(--sol-customizer-text-color)',
					'display': 'block'
				});
			} else {
				$('li#customize-control-solace_single_post_element').removeClass('only-custom');					
				$('li#customize-control-solace_single_only_available_for_custom_layout').removeClass('only-custom');				
				$('li#customize-control-solace_single_only_available_for_custom_layout').css({
					'height': '0',
					'color': 'transparent',
					'display': 'none'
				});
			}
		});
		
		// Fix only enable single post element (update).
		$( '#customize-control-solace_blog_single_post .solace-customizer-tab' ).on('click', function() {			
			const dataSingleTab = $(this).attr('data-tab');
			if ( 'general' === dataSingleTab && 'layout 1' === solacePostHeaderLayout || 'layout 2' === solacePostHeaderLayout || 'layout 3' === solacePostHeaderLayout) {
				$('li#customize-control-solace_single_post_element').addClass('only-custom');
				$('li#customize-control-solace_single_only_available_for_custom_layout').addClass('only-custom');
				$('li#customize-control-solace_single_only_available_for_custom_layout').css({
					'height': 'auto',
					'color': 'var(--sol-customizer-text-color)',
					'display': 'block'
				});
			} else {
				$('li#customize-control-solace_single_post_element').removeClass('only-custom');					
				$('li#customize-control-solace_single_only_available_for_custom_layout').removeClass('only-custom');				
				$('li#customize-control-solace_single_only_available_for_custom_layout').css({
					'height': '0',
					'color': 'transparent',
					'display': 'none'
				});
			}
		});		

		// Link Jumping to tab layout.
		$('li#customize-control-solace_single_only_available_for_custom_layout label').click('click', function(){
			$('li#customize-control-solace_blog_single_post .solace-customizer-tab[data-tab="layout"]').trigger('click');
		});
	});		

	// wp.customize.bind('ready', function () {
	// 	// Fix single post popup card options product image.
	// 	wp.customize('solace_product_page_card_options_product_image', function (setting) {
	// 		var visibility = function() {
	// 			$('.popover-card-options-product-image').trigger( "focus" );
	// 		};
	// 		visibility();
	// 		setting.bind( visibility );
			
	// 	});	
	// });		

	wp.customize.bind('ready', function () {
		// Fix single post popup card options categories.
		wp.customize('solace_product_page_card_options_categories', function (setting) {
			var visibility = function() {
				$('.popover-card-options-categories').trigger( "focus" );
			};
			visibility();
			setting.bind( visibility );
			
		});	
	});		


	wp.customize.bind('ready', function () {
		// Fix single post popup separator.
		wp.customize('solace_single_post_design_separator', function (setting) {
			var visibility = function() {
				$('.popover-radio-popup').trigger( "focus" );
			};
			visibility();
			setting.bind( visibility );
			
		});	
	});	

	wp.customize.bind('ready', function () {
		// Fix single post popup divider.
		$(document).on('click', function(event) {
			// Get elemen on click.
			let clickedElement = event.target;

			const getClass = $(clickedElement).attr('class');
			if ( 
				'components-button link has-icon' === getClass || 
				'components-button active link has-icon' === getClass || 
				'dashicon dashicons dashicons-admin-links' === getClass || 
				'dashicon dashicons dashicons-editor-unlink' === getClass ||
				'components-button reset has-icon' ||
				'dashicon dashicons dashicons-image-rotate'
			) {
				$('.popover-spacing-divider').trigger( "focus" );
			}
		});		
	});		

	// Enable page header.
	wp.customize.bind('ready', function() {
		// Define a function to handle the visibility of controls
		var handleVisibility = function(setting, controlName) {
			wp.customize.control(controlName, function(control) {
				var visibility = function() {
					if (setting.get()) {
						control.container.css({
							'position': 'relative', 
							'top': 'unset'
						});
					} else {
						control.container.css({
							'position': 'absolute', 
							'top': '-99999px'
						});
					}
				};
	
				// Initial visibility check
				visibility();
	
				// Bind visibility function to setting changes
				setting.bind(visibility);
			});
		};
	
		// Monitor the 'solace_blog_page_title_page_header' setting
		wp.customize( 'solace_blog_page_title_page_header', function(setting) {
			// Apply the visibility handler to both controls
			handleVisibility( setting, 'solace_blog_page_title_breadcrumb' );
			handleVisibility( setting, 'solace_blog_page_title_blog_title' );
			handleVisibility( setting, 'solace_blog_page_title_blog_description' );
			handleVisibility( setting, 'solace_blog_page_title_horizontal_alignment' );
			handleVisibility( setting, 'solace_blog_page_title_vertical_spacing' );
		});
	});

	// Back button to section solace_wc_product_page.
	wp.customize.bind('ready', function() {
		// Function to handle section expansion and back button behavior
		function solaceHandleSectionExpansion(section, productPageSection) {
			if (section) {
				section.expanded.bind(function(isExpanded) {
					let status = null;
					if (isExpanded) {
						status = 'opened';
					}
					$('body').on('click', '.customize-section-back', function(event) {
						if (status === 'opened') {
							status = null;
							event.preventDefault();
							productPageSection.focus();
						}
					});
				});
			}
		}

		// Bind ready event for customizer.
		wp.customize.bind('ready', function() {
			const productPageSection = wp.customize.section('solace_wc_product_page');

			// Handle sidebar section.
			solaceHandleSectionExpansion(wp.customize.section('solace_wc_card_options'), productPageSection);

			// Handle sidebar section.
			solaceHandleSectionExpansion(wp.customize.section('solace_wc_product_page_sidebar'), productPageSection);
			
			// Handle pagination section.
			solaceHandleSectionExpansion(wp.customize.section('solace_wc_product_page_pagination'), productPageSection);
		});	
	});

	// Redirect page shop.
	wp.customize.bind('ready', function() {	
		wp.customize.section('solace_wc_product_page', function(section) {
			section.expanded.bind(function(isExpanded) {
				if (isExpanded) {
					const previewUrl = wp.customize.previewer.previewUrl.get()
					if ( ! previewUrl.includes('post_type=product') && previewUrl !== SolaceReactCustomize.wcPageShop ) {
						wp.customize.previewer.previewUrl.set( SolaceReactCustomize.wcPageShop );
					}
				}
			});
		});
	});

	// Back button to section solace_wc_single_product.
	wp.customize.bind('ready', function() {
		// Function to handle section expansion and back button behavior
		function solaceHandleSectionExpansion(section, productPageSection) {
			if (section) {
				section.expanded.bind(function(isExpanded) {
					let status = null;
					if (isExpanded) {
						status = 'opened';
					}
					$('body').on('click', '.customize-section-back', function(event) {
						if (status === 'opened') {
							status = null;
							event.preventDefault();
							productPageSection.focus();
						}
					});
				});
			}
		}

		// Bind ready event for customizer.
		wp.customize.bind('ready', function() {
			const productPageSection = wp.customize.section('solace_wc_single_product');

			// Handle Product elements section.
			solaceHandleSectionExpansion(wp.customize.section('solace_single_product_gallery_options'), productPageSection);

			// Handle Product elements section.
			solaceHandleSectionExpansion(wp.customize.section('solace_single_product_elements'), productPageSection);
		});	
	});	

})(jQuery);
