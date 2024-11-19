<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u154080756_KiJ0m' );

/** Database username */
define( 'DB_USER', 'u154080756_Y9Lh4' );

/** Database password */
define( 'DB_PASSWORD', '2V9HEncuCS' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'o;5X4J=#dstbrqeLbO:r;=c&)=92AJg@7$}ZF`6^A/uGC)W~=-6}e|JP!&cMa#W7' );
define( 'SECURE_AUTH_KEY',   'MOIDe{ZUBUd6ggYW <=fnV5%r^wVh</$kwq0.l[HSA5<FkW1&yATR8(<6},ln>lj' );
define( 'LOGGED_IN_KEY',     'j}$C.+BD*R<IN]8FrMI]phNz Q_z@9T=A_e0[t6+y9&An;%m();R=cYlqJ.B:+k ' );
define( 'NONCE_KEY',         ';}??6blR3=1fkc`Rg}Lv41S!w?{MVIf:XL`))Y ]CTIW?V_N7G-.}aMiG InlRo+' );
define( 'AUTH_SALT',         'dQy/kXa8PJK#AH;}WjT;g;HF@F%=pk%Udh5NB]w1WE}n39JU(Q-1IJh~(kA,Wtr=' );
define( 'SECURE_AUTH_SALT',  '7G0^, C&okoyS:;n1?_jl:LRHAep;8xeH5dJyOt7b6{_W_)4#TL^Tdd>>MSBZ*Wm' );
define( 'LOGGED_IN_SALT',    'JNNOJBOp&Y]2,nwH{J44-C5:2t7*x9H7hSBy))$sZVy5|S=HE,.du/8t/O9s[,A=' );
define( 'NONCE_SALT',        'aGb{MhH>_/!ON2y2$_F6|O7g^~pIOo-CyxZ3H{wa]N0K=&:8m) o7w=>+2pN9ZLj' );
define( 'WP_CACHE_KEY_SALT', 'EfmTcG:B|T}{5+T*h4/=3l;b6g*bZ*=u~ $R7sM?=HQ]#+Do@Dhf[|6{e:Y+`,pD' );


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

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', '9ae799038a5610daa2726735b8bee762' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
