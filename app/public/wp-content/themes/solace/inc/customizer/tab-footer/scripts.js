(function ($) {

    /**
     * Inject the notice styling once (kept here so the feature is self-contained
     * and does not depend on the PHP style enqueue order).
     */
    function injectSiteBuilderNoticeStyle() {
        if (document.getElementById('solace-sb-notice-style-footer')) {
            return;
        }
        const css =
            // Notice card, styled with the theme customizer color variables.
            'li#footer_presets_custom .solace-sb-notice{' +
            'background:var(--sol-builder-header-bg-color);' +
            'border:1px solid var(--sol-customizer-border-color);' +
            'border-left:4px solid var(--sol-builder-active-color);' +
            'border-radius:3px;padding:10px 12px;margin-bottom:12px;' +
            'color:var(--sol-customizer-text-color);}' +
            'li#footer_presets_custom .solace-sb-notice .solace-sb-notice__title{display:block;margin-bottom:4px;font-size:17px;font-weight:500;color:var(--sol-customizer-contrast-color);}' +
            'li#footer_presets_custom .solace-sb-notice .solace-sb-notice__text{display:block;font-size:14px;line-height:1.5;}' +
            'li#footer_presets_custom .solace-sb-notice a{display:inline-block;margin-top:8px;font-weight:600;color:var(--sol-customizer-link-color);}' +
            // Frosted-glass disabled overlay for the Solace tab switcher, the
            // presets box and the builder while the Site Builder overrides the
            // footer. The overlay also blocks interaction.
            // The builder is already position:fixed, so it does not need (and must
            // not get) a position override here; only the static elements do.
            'body.solace-sb-footer-disabled li#accordion-section-solace_tabs_footer,' +
            'body.solace-sb-footer-disabled li#footer_presets_custom .box-presets-footer{position:relative;}' +
            'body.solace-sb-footer-disabled li#accordion-section-solace_tabs_footer::after,' +
            'body.solace-sb-footer-disabled li#footer_presets_custom .box-presets-footer::after,' +
            'body.solace-sb-footer-disabled .solace-builder.footer::after{' +
            'content:"";position:absolute;inset:0;z-index:100;' +
            'background:rgba(0, 22, 68, 0.55);' +
            '-webkit-backdrop-filter:blur(2px);backdrop-filter:blur(2px);' +
            'cursor:not-allowed;}' +
            // Keep the notice (and its link) readable above the overlay.
            'body.solace-sb-footer-disabled li#footer_presets_custom .solace-sb-notice{position:relative;z-index:101;}';
        const style = document.createElement('style');
        style.id = 'solace-sb-notice-style-footer';
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
    let footerSiteBuilderActive = false;

    /**
     * Reflect the Site Builder footer status: when active, show the notice and
     * disable the footer presets and the footer builder; when inactive, remove
     * the notice and re-enable everything. Safe to call before or after the
     * preset box has been built.
     *
     * @param {boolean} active Whether the Site Builder overrides the footer on
     *                         the page currently previewed.
     */
    function setFooterSiteBuilderState(active) {
        footerSiteBuilderActive = !!active;

        const $box = $('li#footer_presets_custom');

        if (footerSiteBuilderActive) {
            injectSiteBuilderNoticeStyle();

            // The body class scopes the disabled overlay so it keeps working even
            // when the builder is mounted later on panel open.
            document.body.classList.add('solace-sb-footer-disabled');

            if ($box.length && !$box.find('.solace-sb-notice').length) {
                buildSiteBuilderNotice(window.solaceFooterSiteBuilder || {}).prependTo($box.find('.box-presets-footer'));
            }
        } else {
            document.body.classList.remove('solace-sb-footer-disabled');
            $box.find('.solace-sb-notice').remove();
        }
    }

    // Listen for the Site Builder status reported by the preview frame.
    if (window.wp && window.wp.customize) {
        window.wp.customize.bind('ready', function () {
            const previewer = window.wp.customize.previewer;

            previewer.bind('solace-sitebuilder-status', function (data) {
                setFooterSiteBuilderState(data && data.footer);
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

    // Append Presets Footer
    window.addEventListener('load', function () {
        // Append presets
        setTimeout(function(){

            const getBoxBeforePresetsFooter = '<li id="footer_presets_custom"><div class="box-presets-footer">';
            const getBtnPresetsFooter = $('li#customize-control-hfg_solace_footer_presets .solace-preset-selector').html();
            const resultsBtnPresetsFooter = getBtnPresetsFooter.replace(/(<button[^>]*)(>)/g, '$1 type="button">');
            const getBoxAfterPresetsFooter = '</div></li>';

            const html = getBoxBeforePresetsFooter + resultsBtnPresetsFooter + getBoxAfterPresetsFooter;

            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");

            const buttons = doc.querySelectorAll("button");
            for (let i = 0; i < buttons.length; i++) {
            buttons[i].classList.add(`btn${i+1}`);
            }

            const result = doc.body.innerHTML;

            $('ul#sub-accordion-panel-hfg_footer').append(result);

            // Trigger presets
            $('li#footer_presets_custom ').on('click', '.box-presets-footer button', function (event) {
                // Ignore clicks while the preset selector is disabled by Site Builder.
                if ($(this).is(':disabled')) {
                    return;
                }
                let getClass = $(this).attr('class');
                getClass = getClass.replace("btn", "");
                getClass = getClass - 1
                $('#customize-control-hfg_solace_footer_presets .solace-preset-selector button:eq(' + getClass + ')').trigger('click');
            });

            // Apply the current Site Builder state now that the preset box exists
            // (the preview may have reported the status before this point).
            setFooterSiteBuilderState(footerSiteBuilderActive);
        }, 700);

        // Click presets
        $('li#accordion-section-solace_tabs_footer .right').click(function(){
            // Elements deactive
            $('li#accordion-section-solace_tabs_footer .left').removeClass('active');
            $('li#accordion-section-hfg_footer_layout_section').removeClass('active');

            // Presets active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#footer_presets_custom').removeClass('deactive');
            $('li#footer_presets_custom').addClass('active');
        });

        // Click elements
        $('li#accordion-section-solace_tabs_footer .left').click(function(){
            // Presets deactive
            $('li#accordion-section-solace_tabs_footer .right').removeClass('active');
            $('li#footer_presets_custom').addClass('deactive');

            // Element active
            $(this).attr('data-toggle', 'active');
            $(this).addClass('active');
            $('li#accordion-section-hfg_footer_layout_section').removeClass('deactive');
            $('li#accordion-section-hfg_footer_layout_section').addClass('active');
        });
    });

})(jQuery);