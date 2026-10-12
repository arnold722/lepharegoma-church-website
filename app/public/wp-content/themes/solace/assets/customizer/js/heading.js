/**
 * Customizer order control.
 *
 * @package Solace\Customizer\Controls
 */
( function ( $ ) {
	'use strict';
	wp.solaceHeadingAccordion = {
		init: function () {
			this.handleToggle();
		},
		handleToggle: function () {
			$( '.customize-control-customizer-heading.accordion .solace-customizer-heading' ).on( 'click', function () {
				var accordion = $( this ).closest( '.accordion' );
				$( accordion ).toggleClass( 'expanded' );
				return false;
			} );
		},
	};

	$( document ).ready(
		function () {
			wp.solaceHeadingAccordion.init();
		}
	);
} )( jQuery );
