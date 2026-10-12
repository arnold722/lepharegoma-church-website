/**
 * Customizer preview helper for the Solace Extra Site Builder notice.
 *
 * The Site Builder header/footer only overrides the theme on the pages that
 * match its conditions. That decision is made on the frontend by the plugin:
 * the theme renders its own header (#header-grid) / footer (#footer-grid) only
 * when the Site Builder did NOT take over the current page.
 *
 * So, for the page currently shown in the preview, the Site Builder is active
 * for the header when #header-grid is absent, and for the footer when
 * #footer-grid is absent. We report that to the controls pane so the notice and
 * the disabled state always reflect the page being previewed (and update as the
 * user navigates the preview).
 */
( function( api ) {
	'use strict';

	if ( ! api ) {
		return;
	}

	function detectStatus() {
		return {
			header: ! document.getElementById( 'header-grid' ),
			footer: ! document.getElementById( 'footer-grid' )
		};
	}

	api.bind( 'preview-ready', function() {
		var sendStatus = function() {
			api.preview.send( 'solace-sitebuilder-status', detectStatus() );
		};

		// Send proactively for the current page, and reply to controls requests.
		sendStatus();
		api.preview.bind( 'solace-request-sitebuilder-status', sendStatus );
	} );
} )( window.wp && window.wp.customize );
