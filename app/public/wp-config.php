<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '<2QTq<#FG@gM.DF%2AfGBki|U~;RbBQ`^5cVD8LU_4sX^Ii[4sjpc>0/]J%clI,K' );
define( 'SECURE_AUTH_KEY',   'OQe9UiXRxV&NSS%8f@>%v|u[4gDh7#mkC=~IM{COk0x,b&KM99B3=.k.ZL%)*Dec' );
define( 'LOGGED_IN_KEY',     '68q%w3,j33XHUTb6_Vl 3#8![lkA;t;tS$8jPSXR~p8B[Hw3}-w|$EH*1$K7yyKW' );
define( 'NONCE_KEY',         'eQ:Y=!578b!/t+S#617;$fyOC`U5|[XrtGGqcTPv#3}q7-pJ&!7W/SLq~|S`eB-E' );
define( 'AUTH_SALT',         'p4 RF.N/_P<>k16.kQY9Nl=HUz)#VBdQ$ftoJrA*KcyLe|x{uDYzPaf^:[1B2rX}' );
define( 'SECURE_AUTH_SALT',  '|Gls|&)Yd/RJXmD6uNA$S&mnT Cfe{R_9^Vs94Gz OW0fn?787K<@/ZuGhD5J;#b' );
define( 'LOGGED_IN_SALT',    'CwF~./O~Io#yRn)`X7|Ac5-bl2d=XXp58QD8S+QKIo4JbI_cL]tHPr}&;n[rsp/:' );
define( 'NONCE_SALT',        'p+-EA,uPJS;E?S6=):IN+1JLR2aXj!jqITY16G(80J_Cf<./BL(_|lVui/7zNPp3' );
define( 'WP_CACHE_KEY_SALT', 'XG3=m~=Kp~VDEHkR~xQR6?>~hT-nSye^]q7W5G=YJ^bw!`4!>#d9>h.9Gv)/Rjc}' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
define('WPFC_CLEAR_CACHE_AFTER_THEME_UPDATE', true);
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
