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
define('DB_NAME', 'wordpress');

/** Database username */
define('DB_USER', 'root');

/** Database password */
define('DB_PASSWORD', '');

/** Database hostname */
define('DB_HOST', 'localhost');

/** Database charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The database collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

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
define('AUTH_KEY',         'DLDpy5/moH/KGw]Ve@RxZdgdOf)6EGK1>|R/n;xFOm)6LU4~OJCasPzL[w-PmCci');
define('SECURE_AUTH_KEY',  '4y,MpbQ1@:GWV6;S,Of]KqHCuwp/yex3V%WsFt9gX%Tq}BFnJ(>m?9n>UZ.?|:|M');
define('LOGGED_IN_KEY',    'Mn-A=n^!utAwMww)xk ub,$h@jk@&,]!R.fXzpCBfQ_^GKH36F*Y]>7B,b+L~/_w');
define('NONCE_KEY',        'O##UAX{L2N:_S1|vMpAV;ydA#z >uv8<~_M({cdgIUIWbmvioQe_vCLBm$>V *[b');
define('AUTH_SALT',        '%Mk(Iav|1Y/Z/8rcH5WwuE.,@2[t-yl.x8`aga67YsKY.4lwMLu|rnun@g>5jGD_');
define('SECURE_AUTH_SALT', '&CwVPw[RIR]ZHO;o} ftaE=!>I`$qK]}ynyA~w >Z.0Pxx>=+1D~thCYEyn3(?!R');
define('LOGGED_IN_SALT',   '@.e!R;;bQ-!-];vP6!Sp|RYf{;o)Qc2-j<G#SU* 1(,+Bt02KCx`(AGRJ+cT]-i{');
define('NONCE_SALT',       '6goF*Ep8{L_{K&}`@fFSzIuJ<;+p@IFEc<_nU0i?l@R<z@)6Yg8#}>`ktQO@My5X');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', true);


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
