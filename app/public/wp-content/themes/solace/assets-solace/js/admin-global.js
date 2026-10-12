( function( $ ) {
	// Notice close.
	$( document ).on( 'click', '.notice-solace .notice-dismiss', function() {
		// Hide notice.
		$( '.notice-solace' ).slideUp( 300 );

	} );

	// Define an array of plugin slugs to check
	const pluginSlugs = [
		'solace-extra'
	];	

	// Listen for click events on buttons inside the .notice-actions container
	$(document).on('click', '.notice-actions button.starter-templates', function () {
		const $button = $(this);

		// Disable the button and show loading text
		$button.prop('disabled', true).text('Checking…');

		// Send AJAX request to check multiple plugin statuses
		$.ajax({
			url: adminLocalize.ajaxUrl,
			type: 'POST',
			data: {
				action: 'solace_check_plugin_status',
				solace_nonce: adminLocalize.ajaxNonce,
				plugin_slugs: pluginSlugs
			},
			success(response) {
				// Check if the response format is valid and contains plugin status information
				if (!response.success || !response.data || !response.data.plugins) {
					// If not valid, re-enable the button and show an error message
					$button.prop('disabled', false).text('Failed to check plugins');
			
					// Output the unexpected response for debugging purposes
					console.log('Unexpected response format:', response);
			
					// Exit the function early
					return;
				}
			
				// Extract the plugins object from the response
				const plugins = response.data.plugins;
			
				// Determine if all plugins are active
				const allActive = Object.values(plugins).every(item => item.active === true);
			
				// Determine if there is at least one inactive plugin
				const anyInactive = Object.values(plugins).some(item => item.active === false);
			
				// // If all plugins are active, update the button text accordingly
				// if (allActive) {
				// 	$button.text('All plugins are active');
				// } else if (anyInactive) {
				// 	// If there is at least one inactive plugin, show a different message
				// 	$button.text('Some plugins are inactive');
				// } else {
				// 	// If the status is somehow unknown or unexpected, show a fallback message
				// 	$button.text('Unknown plugin status');
				// }

				// Initialize arrays to keep track of missing and inactive plugins
				const missingPlugins = [];
				const inactivePlugins = [];

				// Loop through each plugin entry
				for (const [slug, plugin] of Object.entries(plugins)) {
					// Check if the plugin is missing (not installed)
					if (plugin.status === 'missing') {
						missingPlugins.push(slug);
					}
					// Check if the plugin is installed but not active
					else if (!plugin.active) {
						inactivePlugins.push(slug);
					}
				}

				// Update the button text based on the plugin status
				if (missingPlugins.length > 0) {
					// Some plugins need to be installed
					$button.text('Installing…');

					// Trigger the plugin installation via AJAX.
					installPluginFromRepository();
				} else if (inactivePlugins.length > 0) {
					// Some plugins need to be activated
					$button.text('Activating…');

					setTimeout(() => {
						activatePlugin();
					}, 1000);
				} else {
					// All plugins are installed and active
					$button.text('All plugins active');
				}
			},
			error(xhr, textStatus, errorThrown) {
				// Handle any AJAX request errors (e.g., network issues, server errors)
			
				// Log the error to the browser console for debugging
				console.log('AJAX request failed:', errorThrown);
			
				// Re-enable the button and show a failure message
				$button.prop('disabled', false).text('Plugin check failed');
			}
		});
	});

	/**
	 * Trigger the plugin installation via AJAX.
	 */
	function installPluginFromRepository() {
		// Disable the install button and update its text to indicate the installation is in progress
		$button = $( '.notice-actions button.starter-templates' );
		$button.prop( 'disabled', true ).text( 'Installing…' );

		$.ajax({
			url: adminLocalize.ajaxUrl,
			type: 'POST',
			data: {
				action: 'solace_install_plugin',
				solace_nonce: adminLocalize.ajaxNonce,
				plugin_slugs: pluginSlugs
			},
			success(response) {
				console.log('Plugin installation response:', response);
	
				if (!response.success || !response.data || !response.data.results) {
					$button.prop('disabled', false).text('Installation failed');
					console.log('Unexpected installation response:', response);

					$( '.notice-solace a.error' ).show();
					$( '.notice-solace a.error' ).text( 'Please install the Solace Extra plugin from the Plugins page.' );
					$( '.notice-solace a.error' ).attr( 'href', adminLocalize.adminUrl + 'plugin-install.php?s=solace%2520extra&tab=search&type=term' );

					return;
				}
	
				const results = response.data.results;
				let successCount = 0;
				let alreadyInstalledCount = 0;
				let failedCount = 0;
	
				for (const slug in results) {
					const result = results[slug];
					if (result.status === 'success') {
						successCount++;
					} else if (result.status === 'already_installed') {
						alreadyInstalledCount++;
					} else {
						failedCount++;
					}
				}
	
				// Build summary message
				let message = '';
				if (successCount > 0 || alreadyInstalledCount > 0) {
					// After installation or if already installed, activate plugin
					$button.text(message.trim());

					setTimeout(() => {
						activatePlugin();
					}, 1000);
				}				
				if (successCount > 0) {
					// message += `${successCount} plugin(s) installed. `;
					message += `Installation successful`;
				}
				if (alreadyInstalledCount > 0) {
					message += `${alreadyInstalledCount} already installed`;
				}
				if (failedCount > 0) {
					message += `${failedCount} failed`;
				}
	
				// Set button text with summary
				$button.text(message.trim());
	
				// Optionally re-enable the button if needed
				if (failedCount > 0) {
					$button.prop('disabled', false);
				}
			},
			error(xhr, textStatus, errorThrown) {
				console.log('AJAX request failed:', errorThrown);
				$button.prop('disabled', false).text('Installation failed.');

				$( '.notice-solace a.error' ).show();
				$( '.notice-solace a.error' ).text( 'Please install the Solace Extra plugin from the Plugins page.' );
				$( '.notice-solace a.error' ).attr( 'href', adminLocalize.adminUrl + 'plugin-install.php?s=solace%2520extra&tab=search&type=term' );

			}
		});
	}

	/**
	 * Trigger the plugin activation via AJAX.
	 */
	function activatePlugin() {
		$button = $('.notice-actions button.starter-templates');

		$.ajax({
			url: adminLocalize.ajaxUrl,
			type: 'POST',
			data: {
				action: 'solace_activate_plugin',
				solace_nonce: adminLocalize.ajaxNonce,
				plugin_slugs: pluginSlugs
			},
			success(response) {
				console.log('Plugin activation response:', response);

				if (!response.success || !response.data || !response.data.results) {
					$button.prop('disabled', false).text('Activation failed');
					console.log('Unexpected activation response:', response);

					$( '.notice-solace a.error' ).show();
					$( '.notice-solace a.error' ).text( 'Please activate the Solace Extra plugin from the Plugins page.' );
					$( '.notice-solace a.error' ).attr( 'href', adminLocalize.adminUrl + 'plugin-install.php?s=solace%2520extra&tab=search&type=term' );

					return;
				}

				const results = response.data.results;
				let activatedCount = 0;
				let alreadyActiveCount = 0;
				let failedCount = 0;

				for (const slug in results) {
					const result = results[slug];
					if (result.status === 'activated') {
						activatedCount++;
					} else if (result.status === 'already_active') {
						alreadyActiveCount++;
					} else {
						failedCount++;
					}
				}

				let message = '';
				if (activatedCount > 0) {
					message += `Visit Starter Templates`;
				}
				if (alreadyActiveCount > 0) {
					message += ` (${alreadyActiveCount} already active)`;
				}
				if (failedCount > 0) {
					// message += `, ${failedCount} failed`;
					message += `Redirection failed`;

					$button.text(message.trim());

					$( '.notice-solace a.error' ).show();
					$( '.notice-solace a.error' ).text( ' Please visit the Solace Extra > Starter Templates menu.' );
					$( '.notice-solace a.error' ).attr( 'href', adminLocalize.adminUrl + 'admin.php?page=solace' );		

					return;
				}

				$button.text(message.trim());

				if (failedCount > 0) {
					$button.prop('disabled', false);
				}

				window.location.href = response.data.redirect_url;
			},
			error(xhr, textStatus, errorThrown) {
				console.log('AJAX Activation failed:', errorThrown);
				$button.prop('disabled', false).text('Activation failed.');

				$( '.notice-solace a.error' ).show();
				$( '.notice-solace a.error' ).text( 'Please activate the Solace Extra plugin from the Plugins page.' );
				$( '.notice-solace a.error' ).attr( 'href', adminLocalize.adminUrl + 'plugin-install.php?s=solace%2520extra&tab=search&type=term' );

			}
		});
	}
}( jQuery ) );
