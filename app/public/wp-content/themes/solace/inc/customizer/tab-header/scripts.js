(function ($) {

    /**
     * Inject the notice styling once (kept here so the feature is self-contained
     * and does not depend on the PHP style enqueue order).
     */
    function injectSiteBuilderNoticeStyle() {
        if (document.getElementById('solace-sb-notice-style-header')) {
            return;
        }
        const css =
            // Notice card, styled with the theme customizer color variables.
            'li#header_presets_custom .solace-sb-notice{' +
            'background:var(--sol-builder-header-bg-color);' +
            'border:1px solid var(--sol-customizer-border-color);' +
            'border-left:4px solid var(--sol-builder-active-color);' +
            'border-radius:3px;padding:10px 12px;margin-bottom:12px;' +
            'color:var(--sol-customizer-text-color);}' +
            'li#header_presets_custom .solace-sb-notice .solace-sb-notice__title{display:block;margin-bottom:4px;font-size:17px;font-weight:500;color:var(--sol-customizer-contrast-color);}' +
            'li#header_presets_custom .solace-sb-notice .solace-sb-notice__text{display:block;font-size:14px;line-height:1.5;}' +
            'li#header_presets_custom .solace-sb-notice a{display:inline-block;margin-top:8px;font-weight:600;color:var(--sol-customizer-link-color);}' +
            // Frosted-glass disabled overlay for the Solace tab switcher, the
            // presets box and the builder while the Site Builder overrides the
            // header. The overlay also blocks interaction.
            // The builder is already position:fixed, so it does not need (and must
            // not get) a position override here; only the static elements do.
            'body.solace-sb-header-disabled li#accordion-section-solace_tabs_header,' +
            'body.solace-sb-header-disabled li#header_presets_custom .box-presets-header{position:relative;}' +
            'body.solace-sb-header-disabled li#accordion-section-solace_tabs_header::after,' +
            'body.solace-sb-header-disabled li#header_presets_custom .box-presets-header::after,' +
            'body.solace-sb-header-disabled .solace-builder.header::after{' +
            'content:"";position:absolute;inset:0;z-index:100;' +
            'background:rgba(0, 22, 68, 0.55);' +
            '-webkit-backdrop-filter:blur(2px);backdrop-filter:blur(2px);' +
            'cursor:not-allowed;}' +
            // Keep the notice (and its link) readable above the overlay.
            'body.solace-sb-header-disabled li#header_presets_custom .solace-sb-notice{position:relative;z-index:101;}';
        const style = document.createElement('style');
        style.id = 'solace-sb-notice-style-header';
        style.textContent = css;
        document.head.appendChild(style);
    }

    /**
     * Build the notice element (title, message and a link to the Site Builder
     * dashboard) using safe DOM nodes so localized text is never injected as raw
     * HTML.
     */
    function buildSiteBuilderNotice(data) {
        const $notice = $('<div class="solace-sb-notice"></div>');

        if (data.title) {
            $('<div class="solace-sb-notice__title"></div>').text(data.title).appendTo($notice);
        }

        $('<div class="solace-sb-notice__text"></div>').text(data.message).appendTo($notice);

        if (data.linkUrl) {
            $('<a></a>')
                .attr('href', data.linkUrl)
                .attr('target', '_blank')
                .attr('rel', 'noopener')
                .text(data.linkText || data.linkUrl)
                .appendTo($notice);
        }

        return $notice;
    }

    // Latest Site Builder status reported by the preview for the page currently
    // shown. The notice/disabled state follows the page being previewed, so it
    // respects the Site Builder display conditions (Include/Exclude).
    let headerSiteBuilderActive = false;

    /**
     * Reflect the Site Builder header status: when active, show the notice and
     * disable the header presets and the header builder; when inactive, remove
     * the notice and re-enable everything. Safe to call before or after the
     * preset box has been built.
     *
     * @param {boolean} active Whether the Site Builder overrides the header on
     *                         the page currently previewed.
     */
    function setHeaderSiteBuilderState(active) {
        headerSiteBuilderActive = !!active;

        const $box = $('li#header_presets_custom');

        if (headerSiteBuilderActive) {
            injectSiteBuilderNoticeStyle();

            // The body class scopes the disabled overlay so it keeps working even
            // when the builder is mounted later on panel open.
            document.body.classList.add('solace-sb-header-disabled');

            if ($box.length && !$box.find('.solace-sb-notice').length) {
                buildSiteBuilderNotice(window.solaceHeaderSiteBuilder || {}).prependTo($box.find('.box-presets-header'));
            }
        } else {
            document.body.classList.remove('solace-sb-header-disabled');
            $box.find('.solace-sb-notice').remove();
        }
    }

    // Listen for the Site Builder status reported by the preview frame.
    if (window.wp && window.wp.customize) {
        window.wp.customize.bind('ready', function () {
            const previewer = window.wp.customize.previewer;

            previewer.bind('solace-sitebuilder-status', function (data) {
                setHeaderSiteBuilderState(data && data.header);
            });

            // Ask the preview for the status every time it (re)loads. This avoids
            // a race on a cold load with a ?url= param (e.g. opening the
            // customizer from a single post) where the preview's proactive
            // message could be sent before this listener is wired, and it also
            // keeps the notice in sync while navigating the preview.
            previewer.bind('ready', function () {
                previewer.send('solace-request-sitebuilder-status');
            });
        });
    }

    // Append Presets Header
    window.addEventListener('load', function () {
        // Append presets
        setTimeout(function(){

            const getBoxBeforePresetsHeader = '<li id="header_presets_custom"><div class="box-presets-header">';
            const getBtnPresetsHeader = $('li#customize-control-hfg_solace_header_presets .solace-preset-selector').html();
            const resultsBtnPresetsHeader = getBtnPresetsHeader.replace(/(<button[^>]*)(>)/g, '$1 type="button">');
            const getBoxAfterPresetsHeader = '</div></li>';

            const html = getBoxBeforePresetsHeader + resultsBtnPresetsHeader + getBoxAfterPresetsHeader;

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const buttons = doc.querySelectorAll("button");
            for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.add(`btn${i+1}`);
            }

            const result = doc.body.innerHTML;

            $('ul#sub-accordion-panel-hfg_header').append(result);

            // Trigger presets
            $('li#header_presets_custom ').on('click', '.box-presets-header button', function (event) {
                // Ignore clicks while the preset selector is disabled by Site Builder.
                if ($(this).is(':disabled')) {
                    return;
                }
                let getClass = $(this).attr('class');
                getClass = getClass.replace("btn", "");
                getClass = getClass - 1
                $('#customize-control-hfg_solace_header_presets .solace-preset-selector button:eq(' + getClass + ')').trigger('click');
            });

            // Apply the current Site Builder state now that the preset box exists
            // (the preview may have reported the status before this point).
            setHeaderSiteBuilderState(headerSiteBuilderActive);
        }, 700);

        // Click presets
        $('li#accordion-section-solace_tabs_header .right').click(function(){
            // Elements deactive
            $('li#accordion-section-solace_tabs_header .left').removeClass('active');
            $('li#accordion-section-hfg_header_layout_section').removeClass('active');

            // Presets active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#header_presets_custom').removeClass('deactive');
            $('li#header_presets_custom').addClass('active');
        });

        // Click elements
        $('li#accordion-section-solace_tabs_header .left').click(function(){
            // Presets deactive
            $('li#accordion-section-solace_tabs_header .right').removeClass('active');
            $('li#header_presets_custom').addClass('deactive');

            // Element active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#accordion-section-hfg_header_layout_section').removeClass('deactive');
            $('li#accordion-section-hfg_header_layout_section').addClass('active');
        });
    });

})(jQuery);