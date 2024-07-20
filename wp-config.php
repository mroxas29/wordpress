<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'QnFf9uA1;u%E_M)TRD?rEr#]e&k`5+f7X[_i^(-[Ref8xy7$TP+X &O(zX?Dg,Z2' );
define( 'SECURE_AUTH_KEY',  'DvE+<,467&(|Rd E^n@1[6KXOlsT;sih>eQ(GZ5:Ic>jyR=^G|17r!bk}j6Cjgin' );
define( 'LOGGED_IN_KEY',    '[|;9;`&`:MbE`!$S.|2]N>/JI;wz]rBqys?-$Sp31;Zuh[g5qs6`Rk?[q:MYoWIS' );
define( 'NONCE_KEY',        'zy%#:4fV%91k+VxoFT9!INi14gi7BIh12D>7a!Ttkj`d6vLjEy0@PrNS$,0yF-Ir' );
define( 'AUTH_SALT',        '8d4|b::&%wI!C/4|1r`(Z)R8e+cNSkfwQ6>Q8~#b#DExxSp*=VV3jmhcgAN9MJ-]' );
define( 'SECURE_AUTH_SALT', 'BdW%$4rE$ K7WSXF)<~cC:.O;X<#_mDu0RO-EQwrUgw< JPsEQsn*m!zpcRpA9B+' );
define( 'LOGGED_IN_SALT',   'Kh<5O%t0%~dNiyTrLv$:qlV^M}YU~;n^4Ga&6qb#A=p_g`+X<1s|N2?.q7wj8N&&' );
define( 'NONCE_SALT',       '?t&B],a5qj%N{)_o3U/^AujVlM h4`WgH*$6zno45<;gQ#+bDW:5bjFe`|:rV1/Q' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
