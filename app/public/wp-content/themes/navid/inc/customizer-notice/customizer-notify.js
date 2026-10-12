/**
 * Navid Customizer Notify Scripts
 */

(function($) {
    'use strict';

    $(document).ready(function() {

        // Add custom class to body for styling
        $('body').addClass('navid-customizer-notify-active');
        
        // Handle button clicks with analytics tracking
        $('.navid-customizer-notify-pro-btn').on('click', function(e) {
            // Track pro button click
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Customizer',
                    'event_label': 'Upgrade to Pro Button'
                });
            }
        });
        
        $('.navid-customizer-notify-demo-btn').on('click', function(e) {
            // Track demo button click
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Customizer',
                    'event_label': 'Pro Demo Button'
                });
            }
        });
        
        $('.navid-customizer-notify-help-btn').on('click', function(e) {
            // Track help button click
            if (typeof gtag !== 'undefined') {
                gtag('event', 'click', {
                    'event_category': 'Customizer',
                    'event_label': 'Ask Help Button'
                });
            }
        });

        // Add hover effects
        $('.navid-customizer-notify-pro-btn, .navid-customizer-notify-demo-btn').hover(
            function() {
                $(this).addClass('navid-btn-hover');
            },
            function() {
                $(this).removeClass('navid-btn-hover');
            }
        );

        // Add click animation
        $('.navid-customizer-notify-pro-btn, .navid-customizer-notify-demo-btn').on('mousedown', function() {
            $(this).addClass('navid-btn-active');
        }).on('mouseup mouseleave', function() {
            $(this).removeClass('navid-btn-active');
        });

        // Position the notify section after theme info
        function positionNotifySection() {
            var $notifySection = $('.control-section-navid-notify-section');
            var $themeSection = $('#accordion-section-themes');

            if ($notifySection.length && $themeSection.length) {
                $notifySection.insertAfter($themeSection);
            }
        }

        // Position on load
        positionNotifySection();

        // Position when customizer is fully loaded
        wp.customize.bind('ready', function() {
            setTimeout(positionNotifySection, 200);
        });

        // Handle section expansion (prevent expansion)
        $(document).on('click', '.control-section-navid-notify-section .accordion-section-title', function(e) {
            // Don't expand the section, just handle button clicks
            if (!$(e.target).is('a')) {
                e.preventDefault();
                e.stopPropagation();
            }
        });

        // Remove arrow icons completely
        function removeArrowIcons() {
            // Remove all possible arrow/expand indicators
            $('.control-section-navid-notify-section .accordion-section-title:after').remove();
            $('#accordion-section-navid-customizer-notify-section .accordion-section-title:after').remove();

            // Hide with CSS as backup
            var customCSS = `
                <style id="navid-notify-arrow-fix">
                #accordion-section-navid-customizer-notify-section .accordion-section-title:after,
                .control-section-navid-notify-section .accordion-section-title:after {
                    display: none !important;
                    content: none !important;
                }
                </style>
            `;

            if (!$('#navid-notify-arrow-fix').length) {
                $('head').append(customCSS);
            }
        }

        // Remove arrows on load and periodically
        removeArrowIcons();
        setTimeout(removeArrowIcons, 500);
        setTimeout(removeArrowIcons, 1000);

    });

})(jQuery);

// Minimal additional CSS
jQuery(document).ready(function($) {
    // Ensure section is visible
    $('.control-section-navid-notify-section').css({
        'display': 'block',
        'visibility': 'visible',
        'opacity': '1'
    });
});
