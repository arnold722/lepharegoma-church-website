(function ($) {
    setTimeout(function () {
        
        // Apend dropdown WooCommerce Cart Title Fonts
        let getCarttitleFontFamily = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .solace-typeface-control').attr('fonts');
        if (getCarttitleFontFamily === '') {
            getCarttitleFontFamily = 'DM Sans';
        }

        if (getCarttitleFontFamily == undefined){
            getCarttitleFontFamily = "DM Sans";
        }else {
            // Font Family
            getCarttitleFontFamily = getCarttitleFontFamily.split(",")[0].trim();
            if (getCarttitleFontFamily.length > 6) {
                getCarttitleFontFamily = getCarttitleFontFamily.split(" ")[0];
            }

            fontArray = getCarttitleFontFamily.split(",");
            getCarttitleFontFamily = $.trim(fontArray[0]);

        }
        
        let carttitleFontSize = $('li#customize-control-solace_wc_custom_general_cart_title_typeface .solace-responsive-sizing input').val();
        let getCarttitleFont = '<span class="dropdown-cart-title-font" fonts="' + getCarttitleFontFamily + '">' + getCarttitleFontFamily + ' | ' + carttitleFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_cart_title_font_family > .customize-control-title').after(getCarttitleFont);

        // Apend dropdown WooCommerce Cart Description Fonts
        let getCartdescriptionFontFamily = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .solace-typeface-control').attr('fonts');
        if (getCartdescriptionFontFamily === '') {
            getCartdescriptionFontFamily = 'DM Sans';
        }

        if (getCartdescriptionFontFamily == undefined){
            getCartdescriptionFontFamily = "DM Sans";
        }else {
            // Font Family
            getCartdescriptionFontFamily = getCartdescriptionFontFamily.split(",")[0].trim();
            if (getCartdescriptionFontFamily.length > 6) {
                getCartdescriptionFontFamily = getCartdescriptionFontFamily.split(" ")[0];
            }

            fontArray = getCartdescriptionFontFamily.split(",");
            getCartdescriptionFontFamily = $.trim(fontArray[0]);

        }
        
        let cartdescriptionFontSize = $('li#customize-control-solace_wc_custom_general_cart_description_typeface .solace-responsive-sizing input').val();
        let getCartdescriptionFont = '<span class="dropdown-cart-description-font" fonts="' + getCartdescriptionFontFamily + '">' + getCartdescriptionFontFamily + ' | ' + cartdescriptionFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_cart_description_font_family > .customize-control-title').after(getCartdescriptionFont);

        // Apend dropdown WooCommerce Cart Price Fonts
        let getCartpriceFontFamily = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .solace-typeface-control').attr('fonts');
        if (getCartpriceFontFamily === '') {
            getCartpriceFontFamily = 'DM Sans';
        }

        if (getCartpriceFontFamily == undefined){
            getCartpriceFontFamily = "DM Sans";
        }else {
            // Font Family
            getCartpriceFontFamily = getCartpriceFontFamily.split(",")[0].trim();
            if (getCartpriceFontFamily.length > 6) {
                getCartpriceFontFamily = getCartpriceFontFamily.split(" ")[0];
            }

            fontArray = getCartpriceFontFamily.split(",");
            getCartpriceFontFamily = $.trim(fontArray[0]);

        }
        
        let cartpriceFontSize = $('li#customize-control-solace_wc_custom_general_cart_price_typeface .solace-responsive-sizing input').val();
        let getCartpriceFont = '<span class="dropdown-cart-price-font" fonts="' + getCartpriceFontFamily + '">' + getCartpriceFontFamily + ' | ' + cartpriceFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_cart_price_font_family > .customize-control-title').after(getCartpriceFont);

        // Apend dropdown WooCommerce Cart Button Fonts
        let getCartbuttonFontFamily = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .solace-typeface-control').attr('fonts');
        if (getCartbuttonFontFamily === '') {
            getCartbuttonFontFamily = 'DM Sans';
        }

        if (getCartbuttonFontFamily == undefined){
            getCartbuttonFontFamily = "DM Sans";
        }else {
            // Font Family
            getCartbuttonFontFamily = getCartbuttonFontFamily.split(",")[0].trim();
            if (getCartbuttonFontFamily.length > 6) {
                getCartbuttonFontFamily = getCartbuttonFontFamily.split(" ")[0];
            }

            fontArray = getCartbuttonFontFamily.split(",");
            getCartbuttonFontFamily = $.trim(fontArray[0]);

        }
        
        let cartbuttonFontSize = $('li#customize-control-solace_wc_custom_general_cart_button_typeface .solace-responsive-sizing input').val();
        let getCartbuttonFont = '<span class="dropdown-cart-button-font" fonts="' + getCartbuttonFontFamily + '">' + getCartbuttonFontFamily + ' | ' + cartbuttonFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_cart_button_font_family > .customize-control-title').after(getCartbuttonFont);

    }, 750);

    // ------------- Carttitle Font -------------
    // Change Carttitle Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_title_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').text(newArray);
        });
    });

    // On Update Carttitle Font (carttitle font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_cart_title_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Carttitle Font (carttitle font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_cart_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Carttitle Font (carttitle font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_cart_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCarttitleFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Carttitle Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_title_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_cart_title_font_family .dropdown-cart-title-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCarttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });


    // ------------- Cartdescription Font -------------
    // Change Cartdescription Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_description_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').text(newArray);
        });
    });

    // On Update Cartdescription Font (cartdescription font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_cart_description_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Cartdescription Font (cartdescription font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_cart_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Cartdescription Font (cartdescription font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_cart_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCartdescriptionFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Cartdescription Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_description_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_cart_description_font_family .dropdown-cart-description-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCartdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Cartprice Font -------------
    // Change Cartprice Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_price_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').text(newArray);
        });
    });

    // On Update Cartprice Font (cartprice font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_cart_price_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Cartprice Font (cartprice font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_cart_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Cartprice Font (cartprice font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_cart_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCartpriceFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Cartprice Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_price_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_cart_price_font_family .dropdown-cart-price-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCartpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Cartbutton Font -------------
    // Change Cartbutton Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_button_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').text(newArray);
        });
    });

    // On Update Cartbutton Font (cartbutton font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_cart_button_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Cartbutton Font (cartbutton font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_cart_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Cartbutton Font (cartbutton font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_cart_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCartbuttonFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Cartbutton Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_cart_button_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_cart_button_font_family .dropdown-cart-button-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCartbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

})(jQuery);


// =============== WOOCOMMERCE CHECKOUT SECTION FONT =================
(function ($) {
    setTimeout(function () {
        
        // Apend dropdown WooCommerce Checkout Title Fonts
        let getCheckouttitleFontFamily = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .solace-typeface-control').attr('fonts');
        if (getCheckouttitleFontFamily === '') {
            getCheckouttitleFontFamily = 'Default';
        }

        if (getCheckouttitleFontFamily == undefined){
            getCheckouttitleFontFamily = "DM Sans";
        }else {
            // Font Family
            getCheckouttitleFontFamily = getCheckouttitleFontFamily.split(",")[0].trim();
            if (getCheckouttitleFontFamily.length > 6) {
                getCheckouttitleFontFamily = getCheckouttitleFontFamily.split(" ")[0];
            }

            fontArray = getCheckouttitleFontFamily.split(",");
            getCheckouttitleFontFamily = $.trim(fontArray[0]);

        }
        
        let checkouttitleFontSize = $('li#customize-control-solace_wc_custom_general_checkout_title_typeface .solace-responsive-sizing input').val();
        let getCheckouttitleFont = '<span class="dropdown-checkout-title-font" fonts="' + getCheckouttitleFontFamily + '">' + getCheckouttitleFontFamily + ' | ' + checkouttitleFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_checkout_title_font_family > .customize-control-title').after(getCheckouttitleFont);

        // Apend dropdown WooCommerce Checkout Description Fonts
        let getCheckoutdescriptionFontFamily = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .solace-typeface-control').attr('fonts');
        if (getCheckoutdescriptionFontFamily === '') {
            getCheckoutdescriptionFontFamily = 'Default';
        }

        if (getCheckoutdescriptionFontFamily == undefined){
            getCheckoutdescriptionFontFamily = "DM Sans";
        }else {
            // Font Family
            getCheckoutdescriptionFontFamily = getCheckoutdescriptionFontFamily.split(",")[0].trim();
            if (getCheckoutdescriptionFontFamily.length > 6) {
                getCheckoutdescriptionFontFamily = getCheckoutdescriptionFontFamily.split(" ")[0];
            }

            fontArray = getCheckoutdescriptionFontFamily.split(",");
            getCheckoutdescriptionFontFamily = $.trim(fontArray[0]);

        }
        
        let checkoutdescriptionFontSize = $('li#customize-control-solace_wc_custom_general_checkout_description_typeface .solace-responsive-sizing input').val();
        let getCheckoutdescriptionFont = '<span class="dropdown-checkout-description-font" fonts="' + getCheckoutdescriptionFontFamily + '">' + getCheckoutdescriptionFontFamily + ' | ' + checkoutdescriptionFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_checkout_description_font_family > .customize-control-title').after(getCheckoutdescriptionFont);

        // Apend dropdown WooCommerce Checkout Price Fonts
        let getCheckoutpriceFontFamily = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .solace-typeface-control').attr('fonts');
        if (getCheckoutpriceFontFamily === '') {
            getCheckoutpriceFontFamily = 'Default';
        }

        if (getCheckoutpriceFontFamily == undefined){
            getCheckoutpriceFontFamily = "DM Sans";
        }else {
            // Font Family
            getCheckoutpriceFontFamily = getCheckoutpriceFontFamily.split(",")[0].trim();
            if (getCheckoutpriceFontFamily.length > 6) {
                getCheckoutpriceFontFamily = getCheckoutpriceFontFamily.split(" ")[0];
            }

            fontArray = getCheckoutpriceFontFamily.split(",");
            getCheckoutpriceFontFamily = $.trim(fontArray[0]);

        }
        
        let checkoutpriceFontSize = $('li#customize-control-solace_wc_custom_general_checkout_price_typeface .solace-responsive-sizing input').val();
        let getCheckoutpriceFont = '<span class="dropdown-checkout-price-font" fonts="' + getCheckoutpriceFontFamily + '">' + getCheckoutpriceFontFamily + ' | ' + checkoutpriceFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_checkout_price_font_family > .customize-control-title').after(getCheckoutpriceFont);

        // Apend dropdown WooCommerce Checkout Button Fonts
        let getCheckoutbuttonFontFamily = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .solace-typeface-control').attr('fonts');
        if (getCheckoutbuttonFontFamily === '') {
            getCheckoutbuttonFontFamily = 'Default';
        }

        if (getCheckoutbuttonFontFamily == undefined){
            getCheckoutbuttonFontFamily = "DM Sans";
        }else {
            // Font Family
            getCheckoutbuttonFontFamily = getCheckoutbuttonFontFamily.split(",")[0].trim();
            if (getCheckoutbuttonFontFamily.length > 6) {
                getCheckoutbuttonFontFamily = getCheckoutbuttonFontFamily.split(" ")[0];
            }

            fontArray = getCheckoutbuttonFontFamily.split(",");
            getCheckoutbuttonFontFamily = $.trim(fontArray[0]);

        }
        
        let checkoutbuttonFontSize = $('li#customize-control-solace_wc_custom_general_checkout_button_typeface .solace-responsive-sizing input').val();
        let getCheckoutbuttonFont = '<span class="dropdown-checkout-button-font" fonts="' + getCheckoutbuttonFontFamily + '">' + getCheckoutbuttonFontFamily + ' | ' + checkoutbuttonFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_checkout_button_font_family > .customize-control-title').after(getCheckoutbuttonFont);

    }, 750);

    // ------------- Checkouttitle Font -------------
    // Change Checkouttitle Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_title_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').text(newArray);
        });
    });

    // On Update Checkouttitle Font (checkouttitle font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_checkout_title_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Checkouttitle Font (checkouttitle font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_checkout_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Checkouttitle Font (checkouttitle font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_checkout_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCheckouttitleFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Checkouttitle Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_title_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_checkout_title_font_family .dropdown-checkout-title-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCheckouttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });


    // ------------- Checkoutdescription Font -------------
    // Change Checkoutdescription Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_description_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').text(newArray);
        });
    });

    // On Update Checkoutdescription Font (checkoutdescription font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_checkout_description_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Checkoutdescription Font (checkoutdescription font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_checkout_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Checkoutdescription Font (checkoutdescription font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_checkout_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCheckoutdescriptionFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Checkoutdescription Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_description_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_checkout_description_font_family .dropdown-checkout-description-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCheckoutdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Checkoutprice Font -------------
    // Change Checkoutprice Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_price_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').text(newArray);
        });
    });

    // On Update Checkoutprice Font (checkoutprice font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_checkout_price_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Checkoutprice Font (checkoutprice font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_checkout_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Checkoutprice Font (checkoutprice font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_checkout_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCheckoutpriceFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Checkoutprice Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_price_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_checkout_price_font_family .dropdown-checkout-price-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCheckoutpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Checkoutbutton Font -------------
    // Change Checkoutbutton Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_button_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').text(newArray);
        });
    });

    // On Update Checkoutbutton Font (checkoutbutton font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_checkout_button_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Checkoutbutton Font (checkoutbutton font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_checkout_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Checkoutbutton Font (checkoutbutton font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_checkout_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownCheckoutbuttonFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Checkoutbutton Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_checkout_button_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_checkout_button_font_family .dropdown-checkout-button-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownCheckoutbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

})(jQuery);



// =============== WOOCOMMERCE ACCOUNT SECTION FONT =================
(function ($) {
    setTimeout(function () {
        
        // Apend dropdown WooCommerce Account Title Fonts
        let getAccounttitleFontFamily = $('li#customize-control-solace_wc_custom_general_account_title_font_family .solace-typeface-control').attr('fonts');
        if (getAccounttitleFontFamily === '') {
            getAccounttitleFontFamily = 'Default';
        }

        if (getAccounttitleFontFamily == undefined){
            getAccounttitleFontFamily = "DM Sans";
        }else {
            // Font Family
            getAccounttitleFontFamily = getAccounttitleFontFamily.split(",")[0].trim();
            if (getAccounttitleFontFamily.length > 6) {
                getAccounttitleFontFamily = getAccounttitleFontFamily.split(" ")[0];
            }

            fontArray = getAccounttitleFontFamily.split(",");
            getAccounttitleFontFamily = $.trim(fontArray[0]);

        }
        
        let accounttitleFontSize = $('li#customize-control-solace_wc_custom_general_account_title_typeface .solace-responsive-sizing input').val();
        let getAccounttitleFont = '<span class="dropdown-account-title-font" fonts="' + getAccounttitleFontFamily + '">' + getAccounttitleFontFamily + ' | ' + accounttitleFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_account_title_font_family > .customize-control-title').after(getAccounttitleFont);

        // Apend dropdown WooCommerce Account Description Fonts
        let getAccountdescriptionFontFamily = $('li#customize-control-solace_wc_custom_general_account_description_font_family .solace-typeface-control').attr('fonts');
        if (getAccountdescriptionFontFamily === '') {
            getAccountdescriptionFontFamily = 'Default';
        }

        if (getAccountdescriptionFontFamily == undefined){
            getAccountdescriptionFontFamily = "DM Sans";
        }else {
            // Font Family
            getAccountdescriptionFontFamily = getAccountdescriptionFontFamily.split(",")[0].trim();
            if (getAccountdescriptionFontFamily.length > 6) {
                getAccountdescriptionFontFamily = getAccountdescriptionFontFamily.split(" ")[0];
            }

            fontArray = getAccountdescriptionFontFamily.split(",");
            getAccountdescriptionFontFamily = $.trim(fontArray[0]);

        }
        
        let accountdescriptionFontSize = $('li#customize-control-solace_wc_custom_general_account_description_typeface .solace-responsive-sizing input').val();
        let getAccountdescriptionFont = '<span class="dropdown-account-description-font" fonts="' + getAccountdescriptionFontFamily + '">' + getAccountdescriptionFontFamily + ' | ' + accountdescriptionFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_account_description_font_family > .customize-control-title').after(getAccountdescriptionFont);

        // Apend dropdown WooCommerce Account Price Fonts
        let getAccountpriceFontFamily = $('li#customize-control-solace_wc_custom_general_account_price_font_family .solace-typeface-control').attr('fonts');
        if (getAccountpriceFontFamily === '') {
            getAccountpriceFontFamily = 'Default';
        }

        if (getAccountpriceFontFamily == undefined){
            getAccountpriceFontFamily = "DM Sans";
        }else {
            // Font Family
            getAccountpriceFontFamily = getAccountpriceFontFamily.split(",")[0].trim();
            if (getAccountpriceFontFamily.length > 6) {
                getAccountpriceFontFamily = getAccountpriceFontFamily.split(" ")[0];
            }

            fontArray = getAccountpriceFontFamily.split(",");
            getAccountpriceFontFamily = $.trim(fontArray[0]);

        }
        
        let accountpriceFontSize = $('li#customize-control-solace_wc_custom_general_account_price_typeface .solace-responsive-sizing input').val();
        let getAccountpriceFont = '<span class="dropdown-account-price-font" fonts="' + getAccountpriceFontFamily + '">' + getAccountpriceFontFamily + ' | ' + accountpriceFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_account_price_font_family > .customize-control-title').after(getAccountpriceFont);

        // Apend dropdown WooCommerce Account Button Fonts
        let getAccountbuttonFontFamily = $('li#customize-control-solace_wc_custom_general_account_button_font_family .solace-typeface-control').attr('fonts');
        if (getAccountbuttonFontFamily === '') {
            getAccountbuttonFontFamily = 'Default';
        }

        if (getAccountbuttonFontFamily == undefined){
            getAccountbuttonFontFamily = "DM Sans";
        }else {
            // Font Family
            getAccountbuttonFontFamily = getAccountbuttonFontFamily.split(",")[0].trim();
            if (getAccountbuttonFontFamily.length > 6) {
                getAccountbuttonFontFamily = getAccountbuttonFontFamily.split(" ")[0];
            }

            fontArray = getAccountbuttonFontFamily.split(",");
            getAccountbuttonFontFamily = $.trim(fontArray[0]);

        }
        
        let accountbuttonFontSize = $('li#customize-control-solace_wc_custom_general_account_button_typeface .solace-responsive-sizing input').val();
        let getAccountbuttonFont = '<span class="dropdown-account-button-font" fonts="' + getAccountbuttonFontFamily + '">' + getAccountbuttonFontFamily + ' | ' + accountbuttonFontSize + ' px' + '</span>';

        $('li#customize-control-solace_wc_custom_general_account_button_font_family > .customize-control-title').after(getAccountbuttonFont);

    }, 750);

    // ------------- Accounttitle Font -------------
    // Change Accounttitle Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_title_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').text(newArray);
        });
    });

    // On Update Accounttitle Font (accounttitle font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_account_title_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Accounttitle Font (accounttitle font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_account_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Accounttitle Font (accounttitle font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_account_title_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownAccounttitleFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Accounttitle Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_title_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_account_title_font_family .dropdown-account-title-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownAccounttitleFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });


    // ------------- Accountdescription Font -------------
    // Change Accountdescription Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_description_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').text(newArray);
        });
    });

    // On Update Accountdescription Font (accountdescription font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_account_description_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Accountdescription Font (accountdescription font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_account_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Accountdescription Font (accountdescription font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_account_description_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownAccountdescriptionFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Accountdescription Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_description_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_account_description_font_family .dropdown-account-description-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownAccountdescriptionFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Accountprice Font -------------
    // Change Accountprice Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_price_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').text(newArray);
        });
    });

    // On Update Accountprice Font (accountprice font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_account_price_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Accountprice Font (accountprice font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_account_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Accountprice Font (accountprice font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_account_price_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownAccountpriceFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Accountprice Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_price_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_account_price_font_family .dropdown-account-price-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownAccountpriceFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    // ------------- Accountbutton Font -------------
    // Change Accountbutton Font (Font-Text) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_button_font_family', function (setting) {
        setting.bind(function (value) {
            fontInDropdown = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').text();
            let fontString = fontInDropdown;
            let fontArray = fontString.split(" | ");
            mydata = value.split(",");
            mydata = $.trim(mydata[0]);
            if (mydata.length > 6) {
                mydata = mydata.split(' ')[0];
            }
            fontArray[0] = mydata;
            let newArray = [fontArray.join(" | ")];
            $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').attr('fonts', fontArray[0]);
            $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').text(newArray);
        });
    });

    // On Update Accountbutton Font (accountbutton font desktop)
    setTimeout(function () {
        $('button.preview-desktop, .components-button.desktop').click(function () {
            wp.customize('solace_wc_custom_general_account_button_typeface', function (setting) {
                let value = setting.get();
                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').attr('fonts');
                let font_size_desktop = value.fontSize.desktop;
                let font_size_suffix_desktop = value.fontSize.suffix.desktop;

                font_Dropdown.text(font_family + ' | ' + font_size_desktop + ' ' + font_size_suffix_desktop);
            });
        });

        // On Update Accountbutton Font (accountbutton font tablet)
        $('button.preview-tablet, .components-button.tablet').click(function () {
            wp.customize('solace_wc_custom_general_account_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').attr('fonts');
                let font_size_tablet = value.fontSize.tablet;
                let font_size_suffix_tablet = value.fontSize.suffix.tablet;

                font_Dropdown.text(font_family + ' | ' + font_size_tablet + ' ' + font_size_suffix_tablet);
            });
        });

        // On Update Accountbutton Font (accountbutton font mobile)
        $('button.preview-mobile, .components-button.mobile').click(function () {
            wp.customize('solace_wc_custom_general_account_button_typeface', function (setting) {
                let value = setting.get();

                let font_Dropdown = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font');
                let font_family = $('li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font').attr('fonts');
                let font_size_mobile = value.fontSize.mobile;
                let font_size_suffix_mobile = value.fontSize.suffix.mobile;

                font_Dropdown.text(font_family + ' | ' + font_size_mobile + ' ' + font_size_suffix_mobile);
            });
        });    
    }, 750);

    function updateFontDropdownAccountbuttonFont(fontDropdown, fontSize, fontSizeSuffix) {
        const newFontDropdown = fontDropdown.split(" | ");
        newFontDropdown[1] = `${fontSize} ${fontSizeSuffix}`;
        return newFontDropdown.join(" | ");
    }

    // Change Accountbutton Font (Font-Size) Trigger Dropdown
    wp.customize('solace_wc_custom_general_account_button_typeface', function (setting) {
        setting.bind(function (value) {
            const getMode = document.querySelector(".wp-full-overlay");
            const fontDropdownElement = $(
                "li#customize-control-solace_wc_custom_general_account_button_font_family .dropdown-account-button-font"
            );
            let fontDropdown = fontDropdownElement.text();
            let fontSize = value.fontSize;
            let fontSizeSuffix = value.fontSize.suffix;

            if (getMode.classList.contains("preview-desktop")) {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
            } else if (getMode.classList.contains("preview-tablet")) {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
            } else if (getMode.classList.contains("preview-mobile")) {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
            }

            fontDropdownElement.text(fontDropdown);

            // Klik device
            $(".devices .preview-desktop, .components-button.desktop").click(function () {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.desktop,
                    fontSizeSuffix.desktop
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-tablet, .components-button.tablet").click(function () {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.tablet,
                    fontSizeSuffix.tablet
                );
                fontDropdownElement.text(fontDropdown);
            });

            $(".devices .preview-mobile, .components-button.mobile").click(function () {
                fontDropdown = updateFontDropdownAccountbuttonFont(
                    fontDropdown,
                    fontSize.mobile,
                    fontSizeSuffix.mobile
                );
                fontDropdownElement.text(fontDropdown);
            });
        });
    });

    $('body').on('click', 'span[class^="dropdown-"][class$="-font"]', function () {
        const $li = $(this).closest('li[id^="customize-control-solace_wc_custom_general_"]');
        const id = $li.attr('id'); 

        if (typeof id === 'undefined') return;

        const match = id.match(/customize-control-solace_wc_custom_general_([^_]+)_(\w+)_font_family/);
        if (!match) return;

        const section = match[1]; // cart, checkout, etc.
        const group = match[2];   // title, description, etc.

        const fontFamilySelector = `#customize-control-solace_wc_custom_general_${section}_${group}_font_family .solace-typeface-control`;
        const typefaceSelector   = `#customize-control-solace_wc_custom_general_${section}_${group}_typeface .solace-typeface-control`;

        const $fontFamilyElem = $(fontFamilySelector);
        const $typefaceElem   = $(typefaceSelector);

        const isSelfVisible = $fontFamilyElem.css('display') === 'block' || $typefaceElem.css('display') === 'block';

        if (isSelfVisible) {
            setTimeout(() => {
                $fontFamilyElem.slideUp();
            }, 300);
            $typefaceElem.slideUp(); // hide
        } else {
            $('li[id^="customize-control-solace_wc_custom_general_"] .solace-typeface-control').hide();
            $fontFamilyElem.show();
            $typefaceElem.slideDown(); // show
        }
    });

})(jQuery);