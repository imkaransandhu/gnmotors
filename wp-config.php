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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'gnmotors' );

/** Database username */
define( 'DB_USER', 'admin' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

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
define( 'AUTH_KEY',         ':hYAtG?uq|?.(S=n}IJQhp=+D?b^c0-Kh8duiLj6Fqz;*b#$o|/wdN<_?#;g|UJx' );
define( 'SECURE_AUTH_KEY',  'N_W>EI3Td~Ui_5K#vc]>6T6Z&y;:0Ky7AJIR}y(XDy/3E~STsG0u[wHj$u]bi{iz' );
define( 'LOGGED_IN_KEY',    'BnrvcQF}U~V7vii%V )7%W):ZNaQ4xEta_TlwG!jD)+6qnj(X fi-JD!kiIq9d9d' );
define( 'NONCE_KEY',        ')Bi:~f;e*XVR-t.nW4Uk.x5Q7Uu=WwnE:;MFsQg7^h^=;%S!h9ct/g48)`lD0G&^' );
define( 'AUTH_SALT',        '/2[CDRm;W):>0KMymAH1;)Uy8Or/,^.7xicYSks|m1{=<!/:pF?N54N{<$R=6R?%' );
define( 'SECURE_AUTH_SALT', 'Lhoqwwywrp)RPKaWyU9u]ExcnDfsF[b6>/Qp]Zh]ebwID;mCKRcZ2NqlPyf|BO l' );
define( 'LOGGED_IN_SALT',   '+-<G=(a34nPK=&2Nq[pt&a&+e4It91JW%C6kc3=@Lj*T.0xT|nFJTBl8z.a) :R_' );
define( 'NONCE_SALT',       '!/}iZoeG=ONV(EUqZYCbHKsgaw;ECSjzK.2 N)usJK};n.Hy~#x_]vXCkN_R9wzs' );

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
