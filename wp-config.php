<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kilovision' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^d1+X xj9bA2h mPncNQfV_=Q#N@!*9DtssZKO`c#)@|M44*[9uJ5rnm/R067K08' );
define( 'SECURE_AUTH_KEY',  '@yB^#[T^DWH70K%w{qr9Jo8]a>BnlC2tt1c.WUZ@#J!O@1*RM_k;>/7+iq?y<&#O' );
define( 'LOGGED_IN_KEY',    'qk_hTx:0&a2740RuthR)FG-0gFKoOA=Q8oaby/1>fGF%AL^ch9E=Er!x,?2YYHe@' );
define( 'NONCE_KEY',        'q7h^[4/exhSceGj@+>=:S2<X=2yu^eeGkKUO}z^+y2E2#+>z=&2nnNVAg5&u0A^S' );
define( 'AUTH_SALT',        'XI1!~SQLV}o&yO$3pP:Xzw(buL!$!%{ ~O|,f*p+bbX0zr0z$_cL/7Y;{z]l4n]}' );
define( 'SECURE_AUTH_SALT', ' R?#Q[-LCPwtD{#{eOAAttDTH@|pc?db_Udes[O<(1= iyf}+{|k91OTAENm<i,v' );
define( 'LOGGED_IN_SALT',   'Mhx5y>RJikdArstMTWdEkmcC_%e}E0mA!~4L(SiAh^fO5D#twttjDu>)`1dfq-ad' );
define( 'NONCE_SALT',       '*M5a_ZQ:2{x/dTX6^OnS%aLjpAGw^GDDd,;z3x]Ee#!MXR}e{GYjYwB(gE(^^D5L' );
define('JWT_AUTH_SECRET_KEY', 'kilovision');
define('JWT_AUTH_CORS_ENABLE', true);

			
			/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'vk';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );



