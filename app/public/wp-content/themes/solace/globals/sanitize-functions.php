<?php
/**
 *
 * Sanitize functions.
 *
 * Author:          
 * Created on:      20/08/2018
 *
 * @package Solace\Globals
 */

/**
 * Function to sanitize alpha color.
 *
 * @param string $value Hex or RGBA color.
 *
 * @return string
 */
function solace_sanitize_colors( $value ) {
	$is_var = ( strpos( $value, 'var' ) !== false );

	if ( $is_var ) {
		return sanitize_text_field( $value );
	}

	if ( false !== strpos( $value, 'gradient' ) ) {
		return $value;
	}

	// Is this an rgba color or a hex?
	$mode = ( false === strpos( $value, 'rgba' ) ) ? 'hex' : 'rgba';
	if ( 'rgba' === $mode ) {
		return solace_sanitize_rgba( $value );
	} else {
		return sanitize_hex_color( $value );
	}
}

/**
 * Sanitize JavaScript and PHP Tags for WordPress Customizer.
 *
 * This function is used as a sanitize callback for a Customizer option.
 * It removes unwanted JavaScript and PHP tags such as <script>, </script>, <?php, and ?>.
 *
 * @param string $input The input string to be sanitized.
 * @return string Sanitized input string without specified tags.
 */
function solace_sanitize_js_and_php( $input ) {
    // List of tags to remove
    $tags_to_remove = array(
        '/<script\b[^>]*>.*?<\/script\s*>/is',
        '/<\?php.*?\?>/is',
    );

    // Remove unwanted tags using preg_replace
    $input = preg_replace($tags_to_remove, '', $input);

    return $input;
}

/**
 * Sanitize rgba color.
 *
 * @param string $value Color in rgba format.
 *
 * @return string
 */
function solace_sanitize_rgba( $value ) {
	$red   = 'rgba(0,0,0,0)';
	$green = 'rgba(0,0,0,0)';
	$blue  = 'rgba(0,0,0,0)';
	$alpha = 'rgba(0,0,0,0)';   // If empty or an array return transparent

	// By now we know the string is formatted as an rgba color so we need to further sanitize it.
	$value = str_replace( ' ', '', $value );
	sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $alpha . ')';
}

/**
 * Sanitize checkbox output.
 *
 * @param bool $value value to be sanitized.
 *
 * @return bool
 */
function solace_sanitize_checkbox( $value ) {
	return true === (bool) $value;
}

/**
 * Check if a string is in json format
 *
 * @param string $string Input.
 *
 * @return bool
 * @since 1.1.38
 */
function solace_is_json( $string ) {
	return is_string( $string ) && is_array( json_decode( $string, true ) );
}

/**
 * Sanitize values for range inputs.
 *
 * @param string $input Control input.
 *
 * @return string|float Returns json string or float.
 */
function solace_sanitize_range_value( $input ) {
	if ( ! solace_is_json( $input ) ) {
		return floatval( $input );
	}
	$range_value            = json_decode( $input, true );
	$range_value['desktop'] = isset( $range_value['desktop'] ) && is_numeric( $range_value['desktop'] ) ? floatval( $range_value['desktop'] ) : '';
	$range_value['tablet']  = isset( $range_value['tablet'] ) && is_numeric( $range_value['tablet'] ) ? floatval( $range_value['tablet'] ) : '';
	$range_value['mobile']  = isset( $range_value['mobile'] ) && is_numeric( $range_value['mobile'] ) ? floatval( $range_value['mobile'] ) : '';
	return wp_json_encode( $range_value );
}

/**
 * Sanitize font weight values.
 *
 * @param string $value font-weight value.
 *
 * @return string
 */
function solace_sanitize_font_weight( $value ) {
	$allowed = array( '100', '200', '300', '400', '500', '600', '700', '800', '900' );

	if ( ! in_array( (string) $value, $allowed, true ) ) {
		return '300';
	}

	return $value;
}

/**
 * Sanitize font weight values.
 *
 * @param string $value font-weight value.
 *
 * @return string
 */
function solace_sanitize_text_transform( $value ) {
	$allowed = array( 'none', 'capitalize', 'uppercase', 'lowercase' );

	if ( ! in_array( $value, $allowed, true ) ) {
		return 'none';
	}

	return $value;
}

/**
 * Sanitize the background control.
 *
 * @param array $value input value.
 *
 * @return WP_Error | array
 */
function solace_sanitize_background( $value ) {
	if ( ! is_array( $value ) ) {
		return new WP_Error();
	}

	if ( ! isset( $value['type'] ) || ! in_array( $value['type'], array( 'image', 'color' ), true ) ) {
		return new WP_Error();
	}

	if ( ! isset( $value['focusPoint'] ) ) {
		$value['focusPoint'] = [
			'x' => 0.5,
			'y' => 0.5,
		];
	}

	foreach ( $value['focusPoint'] as $coordinate => $val ) {
		if ( is_numeric( $val ) ) {
			continue;
		}

		$val = 0;

		$value['focusPoint'][ $coordinate ] = $val;
	}


	$value['imageUrl']          = esc_url( $value['imageUrl'] );
	$value['colorValue']        = solace_sanitize_colors( $value['colorValue'] );
	$value['overlayColorValue'] = solace_sanitize_colors( $value['overlayColorValue'] );


	$value['overlayOpacity'] = (int) $value['overlayOpacity'];
	if ( $value['overlayOpacity'] > 100 || $value['overlayOpacity'] < 0 ) {
		$value['overlayOpacity'] = 50;
	}

	$value['fixed']       = (bool) $value['fixed'];
	$value['useFeatured'] = (bool) $value['useFeatured'];

	return $value;
}

/**
 * Sanitize the button appearance control.
 *
 * @param array $value the control value.
 *
 * @return array
 */
function solace_sanitize_button_appearance( $value ) {
	return $value;
}

/**
 * Sanitize the typography control.
 *
 * @param array $value the control value.
 *
 * @return array
 */
function solace_sanitize_typography_control( $value ) {
	$keys = [
		'lineHeight',
		'letterSpacing',
		'fontWeight',
		'fontSize',
		'textTransform',
	];

	// Approve Keys.
	foreach ( $value as $key => $values ) {
		if ( ! in_array( $key, $keys, true ) ) {
			unset( $value[ $key ] );
		}
	}

	// Font Weight.
	if ( ! in_array( $value['fontWeight'], [ '100', '200', '300', '400', '500', '600', '700', '800', '900' ], true ) ) {
		$value['fontWeight'] = '300';
	}
	// Text Transform.
	if ( ! in_array( $value['textTransform'], [ 'none', 'uppercase', 'lowercase', 'capitalize' ], true ) ) {
		$value['textTransform'] = 'none';
	}

	// Make sure we deal with arrays.
	foreach ( [ 'letterSpacing', 'lineHeight', 'fontSize' ] as $value_type ) {
		if ( ! is_array( $value[ $value_type ] ) ) {
			$value[ $value_type ] = [];
		}
	}

	return $value;
}

/**
 * Sanitize alignment.
 *
 * @param array $input alignment responsive array.
 *
 * @return array
 */
function solace_sanitize_alignment( $input ) {
	$default = [
		'mobile'  => 'left',
		'tablet'  => 'left',
		'desktop' => 'left',
	];
	$allowed = [ 'left', 'center', 'right', 'justify' ];

	if ( ! is_array( $input ) ) {
		return $default;
	}

	foreach ( $input as $device => $alignment ) {
		if ( ! in_array( $alignment, $allowed ) ) {
			$input[ $device ] = 'left';
		}
	}

	return $input;
}

/**
 * Sanitize featured image settings.
 *
 * @param array $input The input settings to be sanitized.
 *
 * @return array The sanitized featured image settings.
 */
function sanitize_featured_image($input) {
	// Define the default settings.
    $default = array(
        'mobile' => array(
            'Image Ratio' => 'original',
            'Image Scale' => 'full-size',
            'Image Size'  => 'contain',
        ),
        'tablet' => array(
            'Image Ratio' => 'original',
            'Image Scale' => 'full-size',
            'Image Size'  => 'contain',
        ),
        'desktop' => array(
            'Image Ratio' => 'original',
            'Image Scale' => 'full-size',
            'Image Size'  => 'contain',
        ),
    );

	// Define the valid choices for each setting.
    $valid_choices = array(
        'Image Ratio' => array( 'original', 'full', 'width' ),
        'Image Scale' => array( 'full-size', 'top', 'right', 'bottom', 'left' ),
        'Image Size'  => array( 'contain', 'cover', 'auto' ),
    );

	 // Iterate over each device setting.
    foreach ($default as $device => $settings) {
        foreach ($settings as $key => $value) {
            // If the input setting for the current device and key is valid, use it.
            // Otherwise, use the default value.			
            if (isset($input[$device][$key]) && in_array($input[$device][$key], $valid_choices[$key])) {
                $default[$device][$key] = $input[$device][$key];
            }
        }
    }

	// error_log(print_r($default, true)); // Log output data

	// Return the sanitized featured image settings.
    return $default;
}

/**
 * Sanitize position.
 *
 * @param array $input alignment responsive array.
 *
 * @return array
 */
function solace_sanitize_position( $input ) {
	$default = [
		'mobile'  => 'center',
		'tablet'  => 'center',
		'desktop' => 'center',
	];
	$allowed = [ 'flex-start', 'center', 'flex-end' ];

	if ( ! is_array( $input ) ) {
		return $default;
	}

	foreach ( $input as $device => $alignment ) {
		if ( ! in_array( $alignment, $allowed ) ) {
			$input[ $device ] = 'center';
		}
	}

	return $input;
}

/**
 * Sanitize meta order control.
 *
 * @param string $value Control input.
 */
function solace_sanitize_meta_ordering( $value ) {
	$allowed = array(
		'author',
		'category',
		'date',
		'comments',
		'reading',
	);

	if ( empty( $value ) ) {
		return wp_json_encode( $allowed );
	}

	$decoded = json_decode( $value, true );

	foreach ( $decoded as $val ) {
		if ( ! in_array( $val, $allowed, true ) ) {
			return wp_json_encode( $allowed );
		}
	}

	return $value;
}

/**
 * Sanitize meta repeater control.
 *
 * @param string $value Control input.
 */
function solace_sanitize_meta_repeater( $value ) {

	$sanitized_value = [];

	$allowed_slugs = [
		'author',
		'category',
		'date',
		'comments',
		'reading',
	];

	$allowed_properties = [
		'slug',
		'title',
		'visibility',
		'blocked',
		'hide_on_mobile',
		'meta_type',
		'field',
		'format',
		'fallback',
	];

	if ( empty( $value ) ) {
		return wp_json_encode( $sanitized_value );
	}

	$decoded = json_decode( $value, true );

	foreach ( $decoded as $val ) {
		if ( isset( $val->slug ) && ! in_array( $val->slug, $allowed_slugs, true ) ) {
			return wp_json_encode( $sanitized_value );
		}

		foreach ( $val as $property => $value ) {
			if ( ! in_array( $property, $allowed_properties, true ) ) {
				return wp_json_encode( $sanitized_value );
			}
			$val[ $property ] = wp_kses_post( $value );
		}

		$sanitized_value[] = $val;
	}

	return wp_json_encode( $sanitized_value );
}

/**
 * Sanitize blend mode option.
 *
 * @param string $input Control input.
 *
 * @return string
 */
function solace_sanitize_blend_mode( $input ) {
	$blend_mode_options = [ 'normal', 'multiply', 'screen', 'overlay', 'darken', 'lighten', 'color-dodge', 'saturation', 'color', 'difference', 'exclusion', 'hue', 'luminosity' ];
	if ( ! in_array( $input, $blend_mode_options, true ) ) {
		return 'normal';
	}
	return $input;
}

/**
 * Sanitize the container layout value
 *
 * @param string $value value from the control.
 *
 * @return string
 */
function solace_sanitize_container_layout( $value ) {
	$allowed_values = array( 'contained', 'full-width' );
	if ( ! in_array( $value, $allowed_values, true ) ) {
		return 'contained';
	}

	return esc_html( $value );
}

/**
 * Sanitize Button Type option.
 *
 * @param string $value the control value.
 *
 * @return string
 */
function solace_sanitize_button_type( $value ) {
	if ( ! in_array( $value, [ 'primary', 'secondary' ], true ) ) {
		return 'primary';
	}

	return $value;
}

/**
 * Sanitize font variants.
 *
 * @param string[] $value the incoming value.
 *
 * @return string[]
 */
function solace_sanitize_font_variants( $value ) {
	$allowed = [
		'100',
		'200',
		'300',
		'400',
		'500',
		'600',
		'700',
		'800',
		'900',
		'100italic',
		'200italic',
		'300italic',
		'400italic',
		'500italic',
		'600italic',
		'700italic',
		'800italic',
		'900italic',
	];
	if ( ! is_array( $value ) ) {
		return [];
	}

	foreach ( $value as $variant ) {
		if ( in_array( $variant, $allowed, true ) ) {
			continue;
		}
		$key = array_search( $variant, $value );
		unset( $value[ $key ] );
	}

	return $value;
}
