=== solace ===

Contributors: SolaceWP
Tags: custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready

Requires at least: 5.9
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 2.1.25
License: GNU General Public License v2 or later
License URI: LICENSE

A starter theme called Solace.

== Description ==

Solace is a minimalist, and lightweight WordPress theme for creating beautiful, fast-loading, and accessible websites, as well as a new generation clean design blog theme. This theme is ideal for a fashion blog, lifestyle blog, travel blog, food blog, photography blog, and many other types of websites.

== Installation ==

1. In your admin panel, go to Appearance > Themes and click the Add New button.
2. Click Upload Theme and Choose File, then select the theme's .zip file. Click Install Now.
3. Click Activate to use your new theme right away.

== Frequently Asked Questions ==

= Does this theme support any plugins? =

Solace includes support for WooCommerce.

== Changelog ==

= 2.1.25 - 24 September 2026 =
* [Fix]: Fixed fatal error on the front end — `Trait "HFG\Traits\Core" not found` — caused by the bundled Composer autoloader for the `HFG` namespace not being present in the distributed package. The theme now registers its own case-preserving PSR-4 autoloader for `HFG` classes, so it works without the `vendor` directory.
* [Fix]: Restored the bundled WebFont Loader (`vendor/wptt/webfont-loader`) so the "Host Google Fonts locally" option works out of the box.
* [Fix]: Corrected the `Stable tag` header in `readme.txt`.
* [Cleanup]: Removed a leftover debug `console.log` from the Elementor admin styles function.

= 2.1.24 - 23 September 2026 =
* [Security]: Fixed unauthorized content exposure in the Site Builder template preview — private parts are now served only to logged-in users who can edit the requested post
* [Fix]: Fixed a fatal error on WooCommerce add_section
* [Fix]: Fixed a fatal error when is_checkout is null
* [Fix]: Fixed Customizer disable/enable logic based on active Sitebuilder
* [Fix]: Fixed previous Sitebuilder header/footer template failing to load in Elementor Editor
* [Fix]: Fixed Elementor Pro WooCommerce Cart and Checkout widget styling — theme button, hover, disabled, and title overrides no longer conflict with widget styles
* [Fix]: Fixed Elementor Pro WooCommerce Notices widget conflicting with global list typography
* [Fix]: Fixed Elementor Pro Products widget conflicting with theme button overrides
* [Fix]: Removed Elementor CSS preload that caused header flash of unstyled content (FOUC)
* [Fix]: Fixed WooCommerce default widget styling in the shop sidebar
* [Fix]: Fixed WooCommerce widget brand thumbnail, title, and tag cloud styling
* [Fix]: Fixed product review list numbering and avatar alignment
* [Fix]: Fixed brand taxonomy archive to use the WooCommerce archive template
* [Fix]: Fixed active category/tag font color and product category link font weight
* [Style]: Added global Elementor kit theming for the WooCommerce elements widget
* [Refactor]: Translated remaining Indonesian comments to English

= 2.1.23 - 23 September 2026 =
* [Fix]: Fixed a fatal error on WooCommerce add_section
* [Fix]: Fixed Customizer disable/enable logic based on active Sitebuilder
* [Fix]: Fixed previous Sitebuilder header/footer template failing to load in Elementor Editor

= 2.1.22 - 19 June 2026 =
* [Fix]: Fixed issues Gutenberg Editor
* [Fix]: Fixed issues deprecated with PHP 8.5
* [Fix]: Fixed issues on customizer
* [Fix]: Improved compatibility for WordPress 7
* [Style]: Customizer Style for WordPress 7

= 2.1.21 - 8 June 2026 =
* [Fix]: Fixed issues on Customizer scroll to top feature
* [Fix]: Fixed issues on Customizer live preview
* [Fix]: Fixed issues on customizer font and button override elementor page
* [Fix]: Improved compatibility for WordPress 7
* [Style]: Customizer Style for WordPress 7
* [Style]: Gutenberg Cart Block for WordPress 7

= 2.1.20 - 7 May 2026 =
* [Fix]: Fixed issues on gallery layout 
* [Fix]: Fixed issues responsive menu
* [Fix]: Fixed issues footer layout
* [Fix]: Fixed issues styling conflict with elementor
* [Fix]: Fixed issues page layout on fullwidth and single product 
* [Fix]: Improved compatibility for Atomic

= 2.1.19 - 25 March 2026 =
* [Fix]: Improved styling for customizer section
* [Fix]: Fixed issues on posts_per_page
* [Fix]: Fixed issues styling blog

= 2.1.18 - 23 February 2026 =
* [Fix]: Resolved a PHP Fatal Error on theme preview by adding class existence checks for WooCommerce.
* [Fix]: Improved compatibility for environments with no active plugins.


= 2.1.17 - 19 February 2026 =
* [Fix] : Fixed issues on fullwidth container header & customizer page layout
* [Fix] : Fixed issues on WooCommerce default button 
* [Fix] : Fixed issues on patchstack broken access control
* [Refactor] : Improved the appearance of customizer section 

= 2.1.16 - 24 November 2025 =
* [Fix] : Fixed issues on the shop page for product variants.
* [Fix] : Fixed issues on templates built with Elementor Pro.

= 2.1.15 - 23 October 2025 =
* [Fix] : Added em unit support to the font size option in the Customizer font dropdown control.
* [Fix] : Fixed CSS conflicts in the Customizer font dropdown control with the Hostinger AI, Hostinger Tools, and Hostinger Easy Onboarding plugins.
* [Refactor] : Improved the appearance of the starter content.

= 2.1.14 - 15 October 2025 =
* [Feat] : Added optional/hidden/required options for checkout fields
* [Feat] : Added starter content to the theme
* [Refactor] : Improved UX of the Customizer font dropdown
* [Fix] : Fixed the sidebar layout option issue on the single post layout
* [Refactor] : Optimized the theme size
* [Refactor] : Removed Manrope font TTF files
* [Fix] : Accessibility issues flagged by the WAVE browser extension
* [Fix] : Global button background color and disable script for Elementor preview
* [Fix] : Customizer logo title Line height and letter spacing values issue
* [Refactor] : Removed search feature from component list in Header Builder and Footer Builder
* [Fix] : Clickable issue with contact components in the header and footer builder
* [Fix] : Styling issues in Customizer menus and search settings
* [Feat] : Added new style customization options for Cart, Checkout, and My Account pages

= 2.1.13 - 29 April 2025 =
* [Fix] : Issue with incorrect usage of the _load_textdomain_just_in_time function

= 2.1.12 - 15 April 2025 =
* [Fix] : Starter Templates banner installation issue
* [Feat] : Automatically purge LiteSpeed cache after theme update
* [Fix] : Search form action URL
* [Refactor] : Enqueue assets with Solace versioning

= 2.1.11 - 19 March 2025 =
* [Fix] : Error on the shop page
* [Style] : Featured image for single posts
* [Fix] : LiteSpeed cache purge for featured images in single posts
* [Style] : Adjust thumbnail section padding on Single Post Custom Layout
* [Style] : Section header background on Single Post Layout1 Layout 
* [Fix] : Blog page title display
* [Refactor] : Single post featured image size
* [Fix] : Title color issue
* [Fix] : Blog page title font color option
* [Fix] : Blog page title font color issue
* [Refactor] : Admin notice improvements
* [Refactor] : Toggle setting for sortable components
* [Refactor] : Product sorting behavior
* [Fix] : "Add to Cart" button color on the homepage inherits WooCommerce button style
* [Fix] : Color popover issue

= 2.1.10 - 3 March 2025 =
* [Fix]: Fixed popover divider issue in single post
* [Refactor]: Refactored input component sizing
* [Fix]: Fixed reset settings button issue
* [Fix]: Fixed shop settings row issue
* [Refactor]: Refactored custom breadcrumbs for single product
* [Fix]: Removed unused comment
* [Fix]: Fixed card options popup popover positioning issue
* [Style]: Styled popup popover
* [Fix]: Fixed single post popup popover positioning issue
* [Fix]: Fixed border styling for coupon and set default button value issues
* [Fix]: Fixed custom popup popover positioning issue in single product layout
* [Style]: Styled navigation menu customizer controls
* [Style]: Styled core widget customizer controls

= 2.1.9 - 21 February 2025 =
* [Fix] Layout issues in the shop settings for product categories, product taxonomies, and product tags  
* [Fix] Issues with Customizer buttons  
* [Fix] Issues with Customizer styles  
* [Fix] Font weight issues for headings (H1–H6)  

= 2.1.8 - 14 February 2025 =
* [Fix] Toggle blog description issue
* [Fix] Toggle blog title issue
* [Fix] Archive title issue
* [Refactor] Solace header description
* [Fix] Duplicate archive title
* [Fix] Customizer single product ordering issue
* [Feat] Inherit submenu background

= 2.1.7 - January 13 2025 =
* [Fix] Hide header and footer during Elementor editor mode.
* [Fix] Blog page archive title issue.
* [Fix] Resolved the "Customizer element contact" error with ID.
* [Feat] Updated Google Fonts.
* [Feat] Added new typography options for the Customizer element menu.
* [Fix] Fixed conflict with Gutenberg button styles.
* [Feat] Added new color options for the Customizer element menu.
* [Fix] Addressed issue with the Gutenberg button block not being readable.
* [Fix] Resolved issue where Gutenberg block option styles were not displaying.

= 2.1.6 - December 2024 =
* [Fix] Remove text-align justify from Single Post Content
* [Fix] Menu Icon Element Color issue

= 2.1.5 - December 18 2024 =
* [Fix] Contact widget alignment
* [Fix] Contact widget breakpoints
* [Fix] Style customizer elements builder
* [New Feature] Add wpfc clear cache to wp config
* [Fix] Menu icon mobile issue
* [Fix] Gutenberg cart blocks image not show when mobile
* [Fix] Set image width on order summary
* [Fix] Add related products and cross-sells button colors
* [Fix] Footer margin issue
* [Fix] Styling button disabled, coupon input field, coupon button and revoke from elementor button
* [New Feature] Admin notice banner
* [Fix] Show/hide coupon code in cart
* [Fix] Checkout page, styling button coupon, field and place order
* [Fix] Styling cart page to be the same as the helloelementor default cart
* [Fix] Margin and position on checkout attention for coupons
* [Fix] Set default store notice to visible
* [Fix] Posts navigation issue in Single post
* [Fix] WooCommerce "Proceed to chekout" default padding
* [Fix] WooCommerce Coupon not visible issue

= 1.0 - January 30 2023 =
* Initial release

== Credits ==

*   Based on Underscores https://underscores.me/, (C) 2012-2020 Automattic, Inc., [GPLv2 or later](https://www.gnu.org/licenses/gpl-2.0.html)

*   normalize.css https://necolas.github.io/normalize.css/, (C) 2012-2018 Nicolas Gallagher and Jonathan Neal, [MIT](https://opensource.org/licenses/MIT)

*	jQuery
    Website: https://jquery.com/
    License: MIT License
    License URL: https://opensource.org/license/mit/

*	TinyColor
    Website: https://github.com/bgrins/TinyColor
    License: MIT License
    License URL: https://opensource.org/license/mit/

*	Font Awesome v6.2.0
    Designer: Dave Gandy https://github.com/davegandy
    License: Custom
    License URL: https://github.com/FortAwesome/Font-Awesome#license

*	https://iconscout.com/icons/instagram
    License: Vector Format
    License URL: https://iconscout.com/licenses#iconscout

*   Manrope https://fonts.google.com/specimen/Manrope
	License: Open Font License
	License URL: https://scripts.sil.org/cms/scripts/page.php?site_id=nrsi&id=OFL

*   DM Sans https://fonts.google.com/specimen/DM+Sans
	License: Open Font License
	License URL: https://fonts.google.com/specimen/DM+Sans/license  

== Resources ==

Screenshot resources:

CCO licensed photo by Patrick from the WordPress Photo Directory: https://wordpress.org/photos/photo/45262bf4f9/

