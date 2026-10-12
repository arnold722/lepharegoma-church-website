/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function ($) {
    wp.customize.bind('ready', function () {

        // --------------------------- Header ---------------------------
        // Facebook
        wp.customize('header_social_icon_color_facebook_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.facebook .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Youtube
        wp.customize('header_social_icon_color_youtube_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.youtube .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Twitter
        wp.customize('header_social_icon_color_twitter_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.twitter .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Tiktok
        wp.customize('header_social_icon_color_tiktok_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.tiktok .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Telegram
        wp.customize('header_social_icon_color_telegram_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.telegram .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Pinterest
        wp.customize('header_social_icon_color_pinterest_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.pinterest .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Linkedin
        wp.customize('header_social_icon_color_linkedin_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.linkedin .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Instagram
        wp.customize('header_social_icon_color_instagram_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.instagram .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Threads
        wp.customize('header_social_icon_color_threads_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.threads .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Whatsapp
        wp.customize('header_social_icon_color_whatsapp_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_header_social .repeater.whatsapp .box-info .box-color-custom .gradient').css('background', value);
            });
        });


        // --------------------------- Footer ---------------------------
        // Facebook
        wp.customize('footer_social_icon_color_facebook_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.facebook .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Youtube
        wp.customize('footer_social_icon_color_youtube_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.youtube .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Twitter
        wp.customize('footer_social_icon_color_twitter_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.twitter .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Tiktok
        wp.customize('footer_social_icon_color_tiktok_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.tiktok .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Telegram
        wp.customize('footer_social_icon_color_telegram_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.telegram .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Pinterest
        wp.customize('footer_social_icon_color_pinterest_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.pinterest .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Linkedin
        wp.customize('footer_social_icon_color_linkedin_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.linkedin .box-info .box-color-custom .gradient').css('background', value);
            });
        });
    
        // Instagram
        wp.customize('footer_social_icon_color_instagram_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.instagram .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Threads
        wp.customize('footer_social_icon_color_threads_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.threads .box-info .box-color-custom .gradient').css('background', value);
            });
        });

        // Whatsapp
        wp.customize('footer_social_icon_color_whatsapp_setting', function (setting) {
            setting.bind(function (value) {
                $('.sortable_repeater_footer_social .repeater.whatsapp .box-info .box-color-custom .gradient').css('background', value);
            });
        });
    });

    // Append Primary Menu (Header)
    window.addEventListener('load', function () {

        let primaryMenu = '<label for="primary-menu">Select Menu</label>';
        primaryMenu += '<select id="primary-menu">';
        primaryMenu += $('li#customize-control-nav_menu_locations-primary select').html();
        primaryMenu += '</select>';

        $('li#customize-control-primary-menu_shortcut-header-menu-one').prepend(primaryMenu);
        $('li#customize-control-primary-menu_shortcut-header-menu-one option:first').text('Default');

        // Change
        setTimeout(function () {
            $('li#customize-control-primary-menu_shortcut-header-menu-one select#primary-menu').on('change', function () {
                var value = $(this).val();
                $('li#customize-control-nav_menu_locations-primary select').val(value).trigger('change');
            });
        }, 700);

    });

    // Append Secondary Menu (Header)
    window.addEventListener('load', function () {

        let primaryMenu = '<label for="secondary-menu">Select Menu</label>';
        primaryMenu += '<select id="secondary-menu">';
        primaryMenu += $('li#customize-control-nav_menu_locations-top-bar select').html();
        primaryMenu += '</select>';

        $('li#customize-control-secondary-menu_shortcut-header-two').prepend(primaryMenu);
        $('li#customize-control-secondary-menu_shortcut-header-two option:first').text('Default');

        // Change
        setTimeout(function () {
            $('li#customize-control-secondary-menu_shortcut-header-two select#secondary-menu').on('change', function () {
                var value = $(this).val();
                $('li#customize-control-nav_menu_locations-top-bar select').val(value).trigger('change');
            });
        }, 700);

    });

    // Append Footer Menu (Footer)
    window.addEventListener('load', function () {

        let primaryMenu = '<label for="footer-menu">Select Menu</label>';
        primaryMenu += '<select id="footer-menu">';
        primaryMenu += $('li#customize-control-nav_menu_locations-footer select').html();
        primaryMenu += '</select>';

        $('li#customize-control-footer-menu_shortcut-footer-menu-one').prepend(primaryMenu);
        $('li#customize-control-footer-menu_shortcut-footer-menu-one option:first').text('Default');

        // Change
        setTimeout(function () {
            $('li#customize-control-footer-menu_shortcut-footer-menu-one select#footer-menu').on('change', function () {
                var value = $(this).val();
                $('li#customize-control-nav_menu_locations-footer select').val(value).trigger('change');
            });
        }, 700);

    });

    setTimeout(function () {

        $(document).on('click', function(event) {
            // Check whether the event target has one of the specified classes
            if (
                $(event.target).hasClass('sol-color-base-font') || 
                $(event.target).hasClass('sol-color-heading') ||
                $(event.target).hasClass('sol-color-link-button-initial') ||
                $(event.target).hasClass('sol-color-link-button-hover') ||
                $(event.target).hasClass('sol-color-background') ||
                $(event.target).hasClass('sol-color-page-title-background')
            ) {
                $("body").addClass('box-color-position');
            } else {
                $("body").removeClass('box-color-position');
            }
        });
    }, 700);

    // Dropdown pallete active
    $(document).on("click", function (event) {
        if ($(event.target).hasClass('color')) {
            let index = $(event.target).attr('index');

            // Toggle Dropdown
            // if ($(event.target).hasClass('box-icon')) {
            //     if ($(event.target).parent().hasClass('palettes-wrap-top')) {
            //         console.log(123);
            //     }
            // }

            // Dropdown pallete
            if ($(event.target).parent().parent().hasClass('palettes-wrap-top')) {
                if (index == 0) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(0)").find('.components-dropdown button').trigger('click');
                }

                if (index == 1) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(1)").find('.components-dropdown button').trigger('click');
                }

                if (index == 2) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(2)").find('.components-dropdown button').trigger('click');
                }

                if (index == 3) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(3)").find('.components-dropdown button').trigger('click');
                }

                if (index == 4) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(8)").find('.components-dropdown button').trigger('click');
                }

                if (index == 5) {
                    $(".color-array-wrap.mypalette div.mycolor:eq(10)").find('.components-dropdown button').trigger('click');
                }
            }

            // list pallete
            if ($(event.target).parent().parent().hasClass('solace-global-color-palette-inner')) {
                $(".color-array-wrap.mypalette div.mycolor:eq(" + index + ")").find('.components-dropdown button').trigger('click');
            }
        }
    });


    // --------------------------- Colors ---------------------------
    // window.addEventListener('load', function () {
    //     $('li#customize-control-solace_global_colors .palettes-wrap-top').click(function () {
    //         if ($(this).hasClass('active')) {
    //             $('li#customize-control-solace_global_colors .customize-control-title').trigger('click');
    //         }
    //     });
    // });

    // --------------------------- Font ---------------------------
    setTimeout(function () {
        // Apend dropdown Smaller Fonts
        let getSmallerFontFamily = $('li#customize-control-solace_smaller_font_family .solace-typeface-control').attr('fonts');
        if (getSmallerFontFamily === '') {
            getSmallerFontFamily = 'Default';
        }

        if (getSmallerFontFamily == undefined){
            getSmallerFontFamily = "DM Sans";
        }else {
            // Font Family
            getSmallerFontFamily = getSmallerFontFamily.split(",")[0].trim();
            if (getSmallerFontFamily.length > 6) {
                getSmallerFontFamily = getSmallerFontFamily.split(" ")[0];
            }

            fontArray = getSmallerFontFamily.split(",");
            getSmallerFontFamily = $.trim(fontArray[0]);

        }
        
        let smallerFontSize = $('li#customize-control-solace_typeface_smaller .solace-responsive-sizing input').val();
        let smallerSuffix = 'px';
        wp.customize('solace_typeface_smaller', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                smallerSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || smallerSuffix;
            }
        });
        let getSmallerFont = '<span class="dropdown-smaller-font" fonts="' + getSmallerFontFamily + '">' + getSmallerFontFamily + ' | ' + smallerFontSize + ' ' + smallerSuffix + '</span>';

        $('li#customize-control-solace_smaller_font_family > .customize-control-title').after(getSmallerFont);

        // $('li#customize-control-solace_smaller_font_family  span.dropdown-smaller-font').click(function () {
        //     $('li#customize-control-solace_smaller_font_family .solace-typeface-control').toggle();
        //     $('li#customize-control-solace_typeface_smaller .solace-typeface-control').toggle();
        // });

        $('li#customize-control-solace_smaller_font_family span.dropdown-smaller-font').on('click', function () {
            var isVisible = $('li#customize-control-solace_smaller_font_family .solace-typeface-control').is(':visible');

            $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();

            if (!isVisible) {
                $('li#customize-control-solace_smaller_font_family .solace-typeface-control').show();
                $('li#customize-control-solace_typeface_smaller .solace-typeface-control').show();
            }
        });


        // Apend dropdown Logotitle Fonts
        let getLogotitleFontFamily = $('li#customize-control-solace_logotitle_font_family .solace-typeface-control').attr('fonts');
        if (getLogotitleFontFamily === '') {
            getLogotitleFontFamily = 'Default';
        }

        if (getLogotitleFontFamily == undefined){
            getLogotitleFontFamily = "DM Sans";
        }else {
            // Font Family
            getLogotitleFontFamily = getLogotitleFontFamily.split(",")[0].trim();
            if (getLogotitleFontFamily.length > 6) {
                getLogotitleFontFamily = getLogotitleFontFamily.split(" ")[0];
            }

            fontArray = getLogotitleFontFamily.split(",");
            getLogotitleFontFamily = $.trim(fontArray[0]);

        }
        
        let logotitleFontSize = $('li#customize-control-solace_typeface_logotitle .solace-responsive-sizing input').val();
        let logotitleSuffix = 'px';
        wp.customize('solace_typeface_logotitle', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                logotitleSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || logotitleSuffix;
            }
        });
        let getLogotitleFont = '<span class="dropdown-logotitle-font" fonts="' + getLogotitleFontFamily + '">' + getLogotitleFontFamily + ' | ' + logotitleFontSize + ' ' + logotitleSuffix + '</span>';

        $('li#customize-control-solace_logotitle_font_family > .customize-control-title').after(getLogotitleFont);

        // $('li#customize-control-solace_logotitle_font_family  span.dropdown-logotitle-font').click(function () {
        //     $('li#customize-control-solace_logotitle_font_family .solace-typeface-control').toggle();
        //     $('li#customize-control-solace_typeface_logotitle .solace-typeface-control').toggle();
        // });

        $('li#customize-control-solace_logotitle_font_family span.dropdown-logotitle-font').on('click', function () {
            var isVisible = $('li#customize-control-solace_logotitle_font_family .solace-typeface-control').is(':visible');

            $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();

            if (!isVisible) {
                $('li#customize-control-solace_logotitle_font_family .solace-typeface-control').show();
                $('li#customize-control-solace_typeface_logotitle .solace-typeface-control').show();
            }
        });


        // Apend dropdown Button Fonts
        let getButtonFontFamily = $('li#customize-control-solace_button_font_family .solace-typeface-control').attr('fonts');
        if (getButtonFontFamily === '') {
            getButtonFontFamily = 'Default';
        }

        if (getButtonFontFamily == undefined){
            getButtonFontFamily = "DM Sans";
        }else {
            // Font Family
            getButtonFontFamily = getButtonFontFamily.split(",")[0].trim();
            if (getButtonFontFamily.length > 6) {
                getButtonFontFamily = getButtonFontFamily.split(" ")[0];
            }

            fontArray = getButtonFontFamily.split(",");
            getButtonFontFamily = $.trim(fontArray[0]);

        }
        
        let buttonFontSize = $('li#customize-control-solace_typeface_button .solace-responsive-sizing input').val();
        let buttonSuffix = 'px';
        wp.customize('solace_typeface_button', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                buttonSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || buttonSuffix;
            }
        });
        let getButtonFont = '<span class="dropdown-button-font" fonts="' + getButtonFontFamily + '">' + getButtonFontFamily + ' | ' + buttonFontSize + ' ' + buttonSuffix + '</span>';

        $('li#customize-control-solace_button_font_family > .customize-control-title').after(getButtonFont);

        // $('li#customize-control-solace_button_font_family  span.dropdown-button-font').click(function () {
        //     $('li#customize-control-solace_button_font_family .solace-typeface-control').toggle();
        //     $('li#customize-control-solace_typeface_button .solace-typeface-control').toggle();
        // });
        $('li#customize-control-solace_button_font_family span.dropdown-button-font').on('click', function () {
            var isVisible = $('li#customize-control-solace_button_font_family .solace-typeface-control').is(':visible');

            $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();

            if (!isVisible) {
                $('li#customize-control-solace_button_font_family .solace-typeface-control').show();
                $('li#customize-control-solace_typeface_button .solace-typeface-control').show();
            }
        });


        // Apend dropdown Base Fonts
        let getFontFamily = $('li#customize-control-solace_body_font_family .solace-typeface-control').attr('fonts');
        if (getFontFamily === '') {
            getFontFamily = 'Default';
        }

        if (getFontFamily == undefined){
            getFontFamily = "DM Sans";
        }else {
            // Font Family
            getFontFamily = getFontFamily.split(",")[0].trim();
            if (getFontFamily.length > 6) {
                getFontFamily = getFontFamily.split(" ")[0];
            }

            fontArray = getFontFamily.split(",");
            getFontFamily = $.trim(fontArray[0]);

        }
        
        let fontSize = $('li#customize-control-solace_typeface_general .solace-responsive-sizing input').val();
        let baseSuffix = 'px';
        wp.customize('solace_typeface_general', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                baseSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || baseSuffix;
            }
        });
        let getFont = '<span class="dropdown-base-font" fonts="' + getFontFamily + '">' + getFontFamily + ' | ' + fontSize + ' ' + baseSuffix + '</span>';

        $('li#customize-control-solace_body_font_family > .customize-control-title').after(getFont);

        // $('li#customize-control-solace_body_font_family  span.dropdown-base-font').click(function () {
        //     $('li#customize-control-solace_body_font_family .solace-typeface-control').toggle();
        //     $('li#customize-control-solace_typeface_general .solace-typeface-control').toggle();
        // });

        $('li#customize-control-solace_body_font_family span.dropdown-base-font').on('click', function () {
            var isVisible = $('li#customize-control-solace_body_font_family .solace-typeface-control').is(':visible');

            $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();

            if (!isVisible) {
                $('li#customize-control-solace_body_font_family .solace-typeface-control').show();
                $('li#customize-control-solace_typeface_general .solace-typeface-control').show();
            }
        });


        // Apend heading title
        const headings = [
            'Heading 1 (H1)',
            'Heading 2 (H2)',
            'Heading 3 (H3)',
            'Heading 4 (H4)',
            'Heading 5 (H5)',
            'Heading 6 (H6)'
        ];

        for (let i = 1; i <= headings.length; i++) {
            const heading = `<span class="title">${headings[i - 1]}</span>`;
            $(`li#customize-control-solace_h${i}_accordion_wrap`).prepend(heading);
        }

        // On Update Heading
        function updateHeading(dataSelector, elemenSelector) {
            let data = $(dataSelector).attr('data-heading');
            let elemen = $(elemenSelector);
            data = data.replace(/,/g, '');
            data = data.split("|");

            let label_heading = '';
            let font = '';
            font = data[0];

            // label_heading = font + ' | ' + data[1] + ' ' + data[4] + ' | ' + data[7];
            label_heading = font + ' | ' + data[1] + ' ' + data[4];
            elemen.text(label_heading);

            // desktop
            $('button.preview-desktop, .components-button.desktop').click(function () {
                let attrFonts = $(elemenSelector).attr('fonts');
                if (typeof attrFonts !== 'undefined') {
                    font = attrFonts;
                }

                // label_heading = font + ' | ' + data[1] + ' ' + data[4] + ' | ' + data[7];
                label_heading = font + ' | ' + data[1] + ' ' + data[4];
                elemen.text(label_heading);
            });

            // tablet
            $('button.preview-tablet, .components-button.tablet').click(function () {
                let attrFonts = $(elemenSelector).attr('fonts');
                if (typeof attrFonts !== 'undefined') {
                    font = attrFonts;
                }

                // label_heading = font + ' | ' + data[2] + ' ' + data[5] + ' | ' + data[7];
                label_heading = font + ' | ' + data[2] + ' ' + data[5];
                elemen.text(label_heading);
            });

            // mobile
            $('button.preview-mobile, .components-button.mobile').click(function () {
                let attrFonts = $(elemenSelector).attr('fonts');
                if (typeof attrFonts !== 'undefined') {
                    font = attrFonts;
                }
                
                // label_heading = font + ' | ' + data[3] + ' ' + data[6] + ' | ' + data[7];
                label_heading = font + ' | ' + data[3] + ' ' + data[6];
                elemen.text(label_heading);
            });
        }

        function solaceRegisterFontToggle(headingSelector, familySelector, typefaceSelector) {
            $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();
            $(headingSelector).on('click', function () {
                var $fontFamilyElem = $(familySelector + ' .solace-typeface-control');
                var $typefaceElem   = $(typefaceSelector + ' .solace-typeface-control');
                var isSelfVisible   = $fontFamilyElem.is(':visible');

                $('li[id^="customize-control-solace_"] .solace-typeface-control').hide();

                if (!isSelfVisible) {
                    $fontFamilyElem.show();
                    $typefaceElem.show();
                }
            });
        }

        ['h1','h2','h3','h4','h5','h6'].forEach(function(tag) {
            solaceRegisterFontToggle(
                'li#customize-control-solace_' + tag + '_accordion_wrap .solace-customizer-heading',
                'li#customize-control-solace_' + tag + '_font_family_general',
                'li#customize-control-solace_' + tag + '_typeface_general'
            );
        });

        // Execure on Update Heading
        $(function () {
            const selectors = [
                'li#customize-control-solace_h1_accordion_wrap .show-heading',
                'li#customize-control-solace_h2_accordion_wrap .show-heading',
                'li#customize-control-solace_h3_accordion_wrap .show-heading',
                'li#customize-control-solace_h4_accordion_wrap .show-heading',
                'li#customize-control-solace_h5_accordion_wrap .show-heading',
                'li#customize-control-solace_h6_accordion_wrap .show-heading'
            ];

            function updateAllHeadings() {
                selectors.forEach(selector => {
                    updateHeading(selector, selector);
                });
            }

            updateAllHeadings();

        });
    }, 750);

    // ------------- Base Font -------------
    // Change Base Font (Font-Text) Trigger Dropdown
    wp.customize('solace_body_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_body_font_family .dropdown-base-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_body_font_family .dropdown-base-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_body_font_family .dropdown-base-font').text(newArray);
        });
    });

    // On Update Base Font (base font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_body_font_family .dropdown-base-font');
                let font_family = $('li#customize-control-solace_body_font_family .dropdown-base-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Base Font (base font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_body_font_family .dropdown-base-font');
                let font_family = $('li#customize-control-solace_body_font_family .dropdown-base-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Base Font (base font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_body_font_family .dropdown-base-font');
                let font_family = $('li#customize-control-solace_body_font_family .dropdown-base-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownBaseFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Base Font (Font-Size) Trigger Dropdown
    wp.customize('solace_typeface_general', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_body_font_family .dropdown-base-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Smaller Font -------------
    // Change Smaller Font (Font-Text) Trigger Dropdown
    wp.customize('solace_smaller_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').text(newArray);
        });
    });

    // On Update Smaller Font (smaller font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_smaller', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font');
                let font_family = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Smaller Font (smaller font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_smaller', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font');
                let font_family = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Smaller Font (smaller font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_smaller', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font');
                let font_family = $('li#customize-control-solace_smaller_font_family .dropdown-smaller-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownSmallerFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Smaller Font (Font-Size) Trigger Dropdown
    wp.customize('solace_typeface_smaller', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_smaller_font_family .dropdown-smaller-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownSmallerFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Logotitle Font -------------
    // Change Logotitle Font (Font-Text) Trigger Dropdown
    wp.customize('solace_logotitle_font_family', function (setting) {
        // console.log('✅ solace_logotitle_font_family setting registered');
        
        setting.bind(function (value) {
            // console.log('🔄 value changed:', value);
            
            fontInDropdown = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').text(newArray);

            var fontFamily = value.split(",")[0].trim();
            // console.log('🎨 fontFamily extracted:', fontFamily);
            // console.log('🌍 document.documentElement:', document.documentElement);
            
            document.documentElement.style.setProperty(
                '--logotitlefontfamily',
                fontFamily
            );
            
            // console.log('✅ --logotitlefontfamily set to:', document.documentElement.style.getPropertyValue('--logotitlefontfamily'));

            var fontFamily = value.split(",")[0].trim();
            wp.customize.previewer.send('solace_logotitle_font_update', { fontFamily: fontFamily });

        });
    });

    // On Update Logotitle Font (logotitle font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_logotitle', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font');
                let font_family = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Logotitle Font (logotitle font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_logotitle', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font');
                let font_family = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Logotitle Font (logotitle font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_logotitle', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font');
                let font_family = $('li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownLogotitleFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Logotitle Font (Font-Size) Trigger Dropdown
    wp.customize('solace_typeface_logotitle', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_logotitle_font_family .dropdown-logotitle-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownLogotitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });


    // ------------- Button Font -------------
    // Change Button Font (Font-Text) Trigger Dropdown
    wp.customize('solace_button_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_button_font_family .dropdown-button-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_button_font_family .dropdown-button-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_button_font_family .dropdown-button-font').text(newArray);
        });
    });

    // On Update Button Font (button font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_button', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_button_font_family .dropdown-button-font');
                let font_family = $('li#customize-control-solace_button_font_family .dropdown-button-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Button Font (button font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_button', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_button_font_family .dropdown-button-font');
                let font_family = $('li#customize-control-solace_button_font_family .dropdown-button-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Button Font (button font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_button', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_button_font_family .dropdown-button-font');
                let font_family = $('li#customize-control-solace_button_font_family .dropdown-button-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownButtonFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Button Font (Font-Size) Trigger Dropdown
    wp.customize('solace_typeface_button', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_button_font_family .dropdown-button-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownButtonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // Trigger click font family (h1 ~ h6)
    for (let i = 1; i <= 6; i++) {
        let headingLevel = 'h' + i;
        wp.customize('solace_' + headingLevel + '_font_family_general', function (setting) {
            setting.bind(function (value) {
                let accordionWrap = 'solace_' + headingLevel + '_accordion_wrap';
                fontInDropdown = $('li#customize-control-' + accordionWrap + ' .accordion-heading .show-heading').text();
                let fontString = fontInDropdown;
                let fontArray = fontString.split(" | ");
                mydata = value.split(",");
                mydata = $.trim(mydata[0]);
                if (mydata.length > 6) {
                    mydata = mydata.split(' ')[0];
                }
                fontArray[0] = mydata;
                let newArray = [fontArray.join(" | ")];
                $('li#customize-control-' + accordionWrap + ' .accordion-heading .show-heading').attr('fonts', fontArray[0]);
                $('li#customize-control-' + accordionWrap + ' .accordion-heading .show-heading').text(newArray);
            });
        });
    }

    // ------------- Heading Changes Value -------------
    function fontWeightToName(fontWeightParam) {
        const fontWeight = parseInt(fontWeightParam);
        const weightMap = {
            100: "Thin",
            200: "Extra Light",
            300: "Light",
            400: "Regular",
            500: "Medium",
            600: "Semi Bold",
            700: "Bold",
            800: "Extra Bold",
            900: "Black",
        };

        return weightMap[fontWeight] || "Unknown";
    }

    function updateFontDropdown(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        // newFontDropdown[2] = fontWeightName;
        return newFontDropdown.join(" | ");
    }

    // ------------- Data heading 1 -------------
    wp.customize("solace_h1_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h1_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            let fontWeight = value.fontWeight;
            let fontWeightName = fontWeightToName(fontWeight);

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Data heading 2 -------------
    wp.customize("solace_h2_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h2_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            
            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Data heading 3 -------------
    wp.customize("solace_h3_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h3_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            
            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Data heading 4 -------------
    wp.customize("solace_h4_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h4_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            
            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Data heading 5 -------------
    wp.customize("solace_h5_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h5_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            
            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Data heading 6 -------------
    wp.customize("solace_h6_typeface_general", function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_h6_accordion_wrap .accordion-heading"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;
            
            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdown(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    window.addEventListener('load', function () {
        setTimeout(function () {
            function solace_call_to_header_layout(newval) {
                // console.log(newval);

                // Remove class active
                $('#header_presets_custom button').removeClass('active');

                if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"},{"id":"header_search_responsive"},{"id":"primary-menu"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"header_account"},{"id":"header_cart_icon"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn1').addClass('active');
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"header_search_responsive"},{"id":"primary-menu"}],"c-left":[],"center":[{"id":"logo"}],"c-right":[],"right":[{"id":"header_account"},{"id":"header_cart_icon"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn2').addClass('active');
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"},{"id":"header_search"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"header_account"},{"id":"header_cart_icon"}]},"bottom":{"left":[{"id":"primary-menu"}],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn3').addClass('active');
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"header_search_responsive"},{"id":"nav-icon"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn4').addClass('active');
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"nav-icon"}],"c-left":[],"center":[{"id":"logo"}],"c-right":[],"right":[{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn5').addClass('active');
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"},{"id":"primary-menu"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"button_base"},{"id":"button_base2"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn6').addClass('active');
                    // Button Primary
                    wp.customize.control( 'button_base_text_setting', function( control ) {
                        control.setting.set('SIGN IN');
                    });
                    wp.customize.control( 'button_base_style_btn_id', function( control ) {
                        control.setting.set('button2');
                    });

                    // Button Secondary
                    wp.customize.control( 'button_base2_text_setting', function( control ) {
                        control.setting.set('REGISTER');
                    });
                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[{"id":"primary-menu"}],"c-right":[],"right":[{"id":"button_base"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]}},"mobile":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo"}],"c-left":[],"center":[],"c-right":[],"right":[{"id":"nav-icon"},{"id":"header_search_responsive"}]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[{"id":"primary-menu"}]}}') {
                    $('li#header_presets_custom .btn7').addClass('active');

                    // Button Primary
                    wp.customize.control( 'button_base_text_setting', function( control ) {
                        control.setting.set('BUY NOW');
                    });
                }
            }

            wp.customize('hfg_header_layout_v2', function (value) {
                // Get the control's initial value
                // console.log('Get the controls initial value: ', initialValue);
                solace_call_to_header_layout(value.get());

                // Handler function when control value changes
                value.bind(function (newValue) {
                    // console.log('Handler function when control value changes: ', newValue);
                    solace_call_to_header_layout(newValue);
                });
            });

        }, 750);
    });

    window.addEventListener('load', function () {
        setTimeout(function () {
            function solace_call_to_footer_layout(newval) {
                // console.log('newval::: ' + newval);

                // Remove class active
                $('#footer_presets_custom button').removeClass('active');

                if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo-footer"}],"c-left":[{"id":"footer-menu"}],"center":[{"id":"footer_contact"}],"c-right":[],"right":[]},"bottom":{"left":[],"c-left":[{"id":"copyright_html"}],"center":[],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 1');

                    $('li#footer_presets_custom .btn1').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(0)').trigger('click');

                    $('li#customize-control-hfg_footer_layout_bottom_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_bottom_columns_layout button:eq(0)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn1').trigger('click');
                    }, 200);

                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"footer-menu"}],"c-left":[{"id":"logo-footer"}],"center":[{"id":"footer_contact"}],"c-right":[],"right":[]},"bottom":{"left":[],"c-left":[{"id":"copyright_html"}],"center":[],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 2');

                    $('li#footer_presets_custom .btn2').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(0)').trigger('click');

                    $('li#customize-control-hfg_footer_layout_bottom_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_bottom_columns_layout button:eq(0)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn2').trigger('click');
                    }, 200);

                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo-footer"}],"c-left":[],"center":[{"id":"footer_contact"}],"c-right":[],"right":[]},"bottom":{"left":[{"id":"footer-menu"}],"c-left":[],"center":[{"id":"copyright_html"}],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 3');

                    $('li#footer_presets_custom .btn3').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(0)').trigger('click');

                    $('li#customize-control-hfg_footer_layout_bottom_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_bottom_columns_layout button:eq(0)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn3').trigger('click');
                    }, 200);

                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo-footer"}],"c-left":[{"id":"footer-menu"}],"center":[{"id":"copyright_html"}],"c-right":[],"right":[]},"bottom":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 4');

                    $('li#footer_presets_custom .btn4').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(2)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn4').trigger('click');
                    }, 200);

                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo-footer"}],"c-left":[{"id":"footer_contact"}],"center":[{"id":"button_base3"}],"c-right":[],"right":[]},"bottom":{"left":[{"id":"footer-menu"}],"c-left":[],"center":[{"id":"copyright_html"}],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 5');

                    $('li#footer_presets_custom .btn5').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(1)').trigger('click');

                    $('li#customize-control-hfg_footer_layout_bottom_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_bottom_columns_layout button:eq(0)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn5').trigger('click');
                    }, 200);

                    // Button Primary
                    wp.customize.control( 'button_base3_text_setting', function( control ) {
                        control.setting.set('BUY NOW');
                    });

                } else if (newval === '{"desktop":{"top":{"left":[],"c-left":[],"center":[],"c-right":[],"right":[]},"main":{"left":[{"id":"logo-footer"},{"id":"footer_html"}],"c-left":[{"id":"footer-one-widgets"}],"center":[{"id":"footer-two-widgets"}],"c-right":[{"id":"footer-three-widgets"}],"right":[]},"bottom":{"left":[{"id":"copyright_html"}],"c-left":[],"center":[{"id":"footer-menu"}],"c-right":[],"right":[]},"sidebar":[]}}') {

                    // console.log('preset 6');

                    $('li#footer_presets_custom .btn6').addClass('active');
                    $('li#customize-control-hfg_footer_layout_main_columns_number button:eq(3)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_main_columns_layout button:eq(1)').trigger('click');

                    $('li#customize-control-hfg_footer_layout_bottom_columns_number button:eq(2)').trigger('click');
                    $('li#customize-control-hfg_footer_layout_bottom_columns_layout button:eq(0)').trigger('click');

                    setTimeout(function () {
                        $('li#footer_presets_custom .btn6').trigger('click');
                    }, 200);

                }
            }

            wp.customize('hfg_footer_layout_v2', function (value) {
                // Get the control's initial value
                // console.log('Get the controls initial value: ', value);
                // console.log('Get the controls initial value.get(): ', value.get());
                solace_call_to_footer_layout(value.get());

                // Handler function when control value changes
                value.bind(function (newValue) {
                    // console.log('Handler function when control value changes: ', newValue);
                    solace_call_to_footer_layout(newValue);
                });
            });

        }, 750);
    });

    // ------------- Component Header button1 -------------
    wp.customize('button_base_style_btn_id', function (setting) {
        // Border Width
        wp.customize.control('button_base_button_border_width_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });

        // Button Color
        wp.customize.control('button_base_button_bg_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Button Hover Color
        wp.customize.control('button_base_button_bg_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Border Color
        wp.customize.control('button_base_button_border_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });        

        // Border Hover Color
        wp.customize.control('button_base_button_border_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         
    });

    // ------------- Component Header button2 -------------
    wp.customize('button_base2_style_btn_id', function (setting) {
        // Border Width
        wp.customize.control('button_base2_button_border_width_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });

        // Button Color
        wp.customize.control('button_base2_button_bg_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Button Hover Color
        wp.customize.control('button_base2_button_bg_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Border Color
        wp.customize.control('button_base2_button_border_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });        

        // Border Hover Color
        wp.customize.control('button_base2_button_border_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         
    });    

    // ------------- Component Footer button3 -------------
    wp.customize('button_base3_style_btn_id', function (setting) {
        // Border Width
        wp.customize.control('button_base3_button_border_width_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });

        // Button Color
        wp.customize.control('button_base3_button_bg_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Button Hover Color
        wp.customize.control('button_base3_button_bg_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Border Color
        wp.customize.control('button_base3_button_border_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });        

        // Border Hover Color
        wp.customize.control('button_base3_button_border_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         
    });     

    // ------------- Component Footer button4 -------------
    wp.customize('button_base4_style_btn_id', function (setting) {
        // Border Width
        wp.customize.control('button_base4_button_border_width_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });

        // Button Color
        wp.customize.control('button_base4_button_bg_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Button Hover Color
        wp.customize.control('button_base4_button_bg_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideDown(150);
                } else {
                    control.container.slideUp(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         

        // Border Color
        wp.customize.control('button_base4_button_border_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });        

        // Border Hover Color
        wp.customize.control('button_base4_button_border_hover_color_style_setting', function (control) {
            var visibility = function () {
                if ('button1' === setting.get()) {
                    control.container.slideUp(150);
                } else {
                    control.container.slideDown(150);
                }
            };

            visibility();
            setting.bind(visibility);
        });         
    });    

    // Logo Footer
    window.addEventListener('load', function () {

		var blognameInput = $("#_customize-input-blogname");
		var logoShowTitleControl = $("#customize-control-logo_show_title .solace-white-background-control");
		var logoFooterShowTitleControl = $("#customize-control-logo-footer_show_title .solace-white-background-control");

		if (blognameInput.length > 0 && logoShowTitleControl.length > 0 && logoFooterShowTitleControl.length > 0) {
			blognameInput.insertAfter(logoShowTitleControl);
			var clonedBlognameInput = blognameInput.clone();
			clonedBlognameInput.insertAfter(logoFooterShowTitleControl);
		}

		// Trigger Change Site Title Footer
		$('li#customize-control-logo-footer_show_title input#_customize-input-blogname').on('keyup', function() {
			var titleValue = $(this).val();
			$('li#customize-control-logo_show_title input#_customize-input-blogname').val(titleValue).trigger('change');
		});	

		// Trigger Change Site Title Header
		$('li#customize-control-logo_show_title input#_customize-input-blogname').on('keyup', function() {
			var titleValue = $(this).val();
			$('li#customize-control-logo-footer_show_title input#_customize-input-blogname').val(titleValue).trigger('change');
		});	        
	});

    // Basefont Popover class expanded
    $(document).on('click', 'li#customize-control-solace_body_font_family span.dropdown-base-font', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
    });

    // Header h1 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h1_accordion_wrap', function() {
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // Header h2 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h2_accordion_wrap', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // Header h3 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h3_accordion_wrap', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // Header h4 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h4_accordion_wrap', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // Header h5 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h5_accordion_wrap', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h6_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // Header h6 Popup Popover
    $(document).on('click', 'li#customize-control-solace_h6_accordion_wrap', function() {
        $('li#customize-control-solace_h1_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h2_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h3_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h4_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_h5_accordion_wrap').removeClass('expanded');
        $('li#customize-control-solace_typeface_general > .solace-typeface-control').css('display', 'none');
        $('li#customize-control-solace_body_font_family > .solace-typeface-control').css('display', 'none');
    });    

    // --------------------------- Typography Element Menu One ---------------------------
    setTimeout(function () {
        // Apend dropdown
        let getFontFamily = $('li#customize-control-primary-menu_font_family .solace-typeface-control').attr('fonts');
        if (getFontFamily === '') {
            getFontFamily = 'Default';
        }

        if (getFontFamily == undefined){
            getFontFamily = "DM Sans";
        }else {
            // Font Family
            getFontFamily = getFontFamily.split(",")[0].trim();
            if (getFontFamily.length > 6) {
                getFontFamily = getFontFamily.split(" ")[0];
            }

            fontArray = getFontFamily.split(",");
            getFontFamily = $.trim(fontArray[0]);

        }
        
        let fontSize = $('li#customize-control-primary-menu_typeface_general .solace-responsive-sizing input').val();
        let primaryMenuSuffix = 'px';
        wp.customize('menu_typeface_general', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                primaryMenuSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || primaryMenuSuffix;
            }
        });
        let getFont = '<span class="dropdown-font" fonts="' + getFontFamily + '">' + getFontFamily + ' | ' + fontSize + ' ' + primaryMenuSuffix + '</span>';

        $('li#customize-control-primary-menu_font_family > .customize-control-title').after(getFont);

        $('li#customize-control-primary-menu_font_family  span.dropdown-font').click(function () {
            $('li#customize-control-primary-menu_font_family .solace-typeface-control').toggle();
            $('li#customize-control-primary-menu_typeface_general .solace-typeface-control').toggle();
        });
    }, 750);

    // Change (Font-Text) Trigger Dropdown
    wp.customize('primary-menu_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-primary-menu_font_family .dropdown-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-primary-menu_font_family .dropdown-font').attr('fonts', fontArray[0]);
            $('li#customize-control-primary-menu_font_family .dropdown-font').text(newArray);
        });
    });

    // On Update (desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-primary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-primary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update (tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-primary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-primary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update (mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-primary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-primary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    // Change (Font-Size) Trigger Dropdown
    wp.customize('menu_typeface_general', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-primary-menu_font_family .dropdown-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });    

    // --------------------------- Typography Element Menu Two ---------------------------
    setTimeout(function () {
        // Apend dropdown
        let getFontFamily = $('li#customize-control-secondary-menu_font_family .solace-typeface-control').attr('fonts');
        if (getFontFamily === '') {
            getFontFamily = 'Default';
        }

        if (getFontFamily == undefined){
            getFontFamily = "DM Sans";
        }else {
            // Font Family
            getFontFamily = getFontFamily.split(",")[0].trim();
            if (getFontFamily.length > 6) {
                getFontFamily = getFontFamily.split(" ")[0];
            }

            fontArray = getFontFamily.split(",");
            getFontFamily = $.trim(fontArray[0]);

        }
        
        let fontSize = $('li#customize-control-secondary-menu_typeface_general .solace-responsive-sizing input').val();
        let secondaryMenuSuffix = 'px';
        wp.customize('secondary-menu_typeface_general', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                secondaryMenuSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || secondaryMenuSuffix;
            }
        });
        let getFont = '<span class="dropdown-font" fonts="' + getFontFamily + '">' + getFontFamily + ' | ' + fontSize + ' ' + secondaryMenuSuffix + '</span>';

        $('li#customize-control-secondary-menu_font_family > .customize-control-title').after(getFont);

        $('li#customize-control-secondary-menu_font_family  span.dropdown-font').click(function () {
            $('li#customize-control-secondary-menu_font_family .solace-typeface-control').toggle();
            $('li#customize-control-secondary-menu_typeface_general .solace-typeface-control').toggle();
        });
    }, 750);

    // Change (Font-Text) Trigger Dropdown
    wp.customize('secondary-menu_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-secondary-menu_font_family .dropdown-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-secondary-menu_font_family .dropdown-font').attr('fonts', fontArray[0]);
            $('li#customize-control-secondary-menu_font_family .dropdown-font').text(newArray);
        });
    });

    // On Update (desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-secondary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-secondary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update (tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-secondary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-secondary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update (mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-secondary-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-secondary-menu_font_family .dropdown-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    // Change (Font-Size) Trigger Dropdown
    wp.customize('secondary-menu_typeface_general', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-secondary-menu_font_family .dropdown-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });     

    // --------------------------- Typography Element Footer Menu One ---------------------------
    setTimeout(function () {
        // Apend dropdown
        let getFontFamily = $('li#customize-control-footer-menu_font_family .solace-typeface-control').attr('fonts');
        if (getFontFamily === '') {
            getFontFamily = 'Default';
        }

        if (getFontFamily == undefined){
            getFontFamily = "DM Sans";
        }else {
            // Font Family
            getFontFamily = getFontFamily.split(",")[0].trim();
            if (getFontFamily.length > 6) {
                getFontFamily = getFontFamily.split(" ")[0];
            }

            fontArray = getFontFamily.split(",");
            getFontFamily = $.trim(fontArray[0]);

        }
        
        let fontSize = $('li#customize-control-footer-menu_typeface_general .solace-responsive-sizing input').val();
        let footerMenuSuffix = 'px';
        wp.customize('footer-menu_typeface_general', function (setting) {
            var v = setting.get();
            if (v && v.fontSize && v.fontSize.suffix) {
                footerMenuSuffix = v.fontSize.suffix.desktop || v.fontSize.suffix || footerMenuSuffix;
            }
        });
        let getFont = '<span class="dropdown-font" fonts="' + getFontFamily + '">' + getFontFamily + ' | ' + fontSize + ' ' + footerMenuSuffix + '</span>';

        $('li#customize-control-footer-menu_font_family > .customize-control-title').after(getFont);

        $('li#customize-control-footer-menu_font_family  span.dropdown-font').click(function () {
            $('li#customize-control-footer-menu_font_family .solace-typeface-control').toggle();
            $('li#customize-control-footer-menu_typeface_general .solace-typeface-control').toggle();
        });
    }, 750);

    // Change (Font-Text) Trigger Dropdown
    wp.customize('footer-menu_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-footer-menu_font_family .dropdown-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-footer-menu_font_family .dropdown-font').attr('fonts', fontArray[0]);
            $('li#customize-control-footer-menu_font_family .dropdown-font').text(newArray);
        });
    });

    // On Update (desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-footer-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-footer-menu_font_family .dropdown-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update (tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-footer-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-footer-menu_font_family .dropdown-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update (mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_typeface_general', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-footer-menu_font_family .dropdown-font');
                let font_family = $('li#customize-control-footer-menu_font_family .dropdown-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    // Change (Font-Size) Trigger Dropdown
    wp.customize('footer-menu_typeface_general', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-footer-menu_font_family .dropdown-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownBaseFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });    

})(jQuery);

( function() {
    wp.customize.bind('preview-ready', function() {
        wp.customize.preview.bind('solace_logotitle_font_update', function(data) {
            document.documentElement.style.setProperty(
                '--logotitlefontfamily',
                data.fontFamily
            );
        });
    });
} )();