(function (api) {

	// Register section constructor for plugin notification section
	api.sectionConstructor['navid-customizer-plugin-notify-section'] = api.Section.extend(
		{

			// No events for this type of section.
			attachEvents: function () {
			},

			// Always make the section active.
			isContextuallyActive: function () {
				return true;
			}
		}
	);

})( wp.customize );

jQuery( document ).ready(
	function () {

		jQuery( '.navid-customizer-notify-dismiss-recommended-action' ).click(
			function () {
				var id = jQuery( this ).attr( 'id' );
				jQuery( this ).parent().hide();
			}
		);

		jQuery( '.navid-customizer-notify-dismiss-button-recommended-plugin' ).click(
			function () {
				var id = jQuery( this ).attr( 'id' );
				jQuery( this ).parent().parent().hide();
			}
		);

		// Handle activate/install button click
		jQuery(document).on('click', '.activate-now, .install-now', function(e) {
			e.preventDefault();
			var $btn = jQuery(this);
			
			if ( $btn.hasClass('updating-message') ) {
				return;
			}
			
			// Show loading state
			$btn.addClass('updating-message').text( navid_customizer_ajax.installing_text );
			$btn.css({'opacity': '0.8', 'pointer-events': 'none'});
			
			// Fire AJAX request
			jQuery.ajax({
				url: navid_customizer_ajax.ajax_url,
				type: 'POST',
				data: {
					action: 'navid_install_activate_plugins',
					_ajax_nonce: navid_customizer_ajax.nonce
				},
				success: function(response) {
					if (response.success) {
						// Success! Reload the customizer to load the new widgets
						window.location.reload();
					} else {
						alert( navid_customizer_ajax.error_text );
						$btn.removeClass('updating-message').text( navid_customizer_ajax.button_text );
						$btn.css({'opacity': '1', 'pointer-events': 'auto'});
					}
				},
				error: function() {
					alert( navid_customizer_ajax.error_text );
					$btn.removeClass('updating-message').text( navid_customizer_ajax.button_text );
					$btn.css({'opacity': '1', 'pointer-events': 'auto'});
				}
			});
		});
	}
);
