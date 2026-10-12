/* global wp, jQuery */
/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

  
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// alert('masuk customizer.js');
	// wp.customize('solace_scroll_to_top', function (value) {
    //     value.bind(function (newval) {
    //         alert('change');
    //         // jQuery('.topbutton::before').css('content', 'url(' + newval + ')');
    //         if ( 'up_arrow1' === newval ) {
	// 			$('.topbutton::before').css('content', 'url(../assets/img/customizer/arrow-bar-upsolace.svg)');
    //         }
	// 		if ( 'up_arrow2' === newval ) {
	// 			$('.topbutton::before').css('content', 'url(../assets/img/customizer/arrow-bold-upsolace.svg)');
    //         }
	// 		if ( 'up_arrow3' === newval ) {
	// 			$('.topbutton::before').css('content', 'url(../assets/img/customizer/arrow-up-circle-fillsolace.svg)');
    //         }
	// 		if ( 'up_arrow4' === newval ) {
	// 			$('.topbutton::before').css('content', 'url(../assets/img/customizer/arrow-up-circlesolace.svg)');
    //         }
	// 		if ( 'up_arrow5' === newval ) {
	// 			$('.topbutton::before').css('content', 'url(../assets/img/customizer/arrow-up-squaresolace.svg)');
    //         }
    //     });
    // });

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute',
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					clip: 'auto',
					position: 'relative',
				} );
				$( '.site-title a, .site-description' ).css( {
					color: to,
				} );
			}
		} );
	} );

}( jQuery ) );

