<?php
// Enable WP_DEBUG mode
define( 'WP_DEBUG', true );

// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', true );

// Disable display of errors and warnings
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// Use dev versions of core JS and CSS files (only needed if you are modifying these core files)
define( 'SCRIPT_DEBUG', true );

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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'prj_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         'Szh$L#*}5bpq+A#e04I*Z<:S1DqW957SNW /]%6H fl$>6Gqj,6}1.#Q]T(.h[+6' );
define( 'SECURE_AUTH_KEY',  'W_%=vG>oY@;DiRiHbjar~+@dFM2eYB#*v.@==,:IH^S#KrD9N}W;4-$>i6hJ=hKW' );
define( 'LOGGED_IN_KEY',    '&QYOm*Nl0oYE?9*US*~@--&uC|Sih<3RD_Cr*X; 5bcavqk/+_*jVq!of:epaz_ ' );
define( 'NONCE_KEY',        '8}r<y~|e%Heljcf|=?2c1$9bDBM}<vTyL/k]H0Z!69&_nhz)FCQRDYrsNR3CE,4)' );
define( 'AUTH_SALT',        'sA8c$tM9;v&xZCxKP:6/?#s@8FCF{Vy6w)9Wo^T1vvh2hi}1S@+#-nZ#[nG~-TDX' );
define( 'SECURE_AUTH_SALT', 'adya ;]R-,W?c`4<pZ8<7oqD?!pozt#GYg@N8p)uLSOHl|/HyRtPDSestmpPO{E1' );
define( 'LOGGED_IN_SALT',   '|s% /H~679v0$My0_0E&*Um3hE(UV-,k5cFfG_qYXy*eSDj~-yJEVy#bu}k#+7/[' );
define( 'NONCE_SALT',       'wHpD&Q+Fyer =g:[SMa5~Q9yXC#U}Yt2&=K$iCLm7;>x;h=!J%W#VQP{>>ro>#.x' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
