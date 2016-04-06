<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'invertedchaos');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'B+=oQ{VXWVJVcP4!KZ0Rr<4y*ph[=F2vgB|YlpBFlJ^<VVAQ06^YQT$BjxnmO5--');
define('SECURE_AUTH_KEY',  'D~MTmeo-C0p,r]KMr?-#u|9#7 s ($~-Ey Z^0WJGKg|03/-Pwi[Ib$s$}HUAqTI');
define('LOGGED_IN_KEY',    'uZ?BoD;IE@gbL%|rcptvPYqklYj&:G5ZEw|-B^+n:V,>-A1%:+q8R2&CD>kM]Lwa');
define('NONCE_KEY',        'xoP=rlEXu]2+8qz7/l%E/7YFg)q%G vZh2K3y2Zi/f02U;|Fe`HzttotERn-fXnr');
define('AUTH_SALT',        '/a-o EsPR~Fd0sV a%eG--Koe;nQUOkq+HS^*:r}H|BZmccmC&2#TcmbdP8T8,>V');
define('SECURE_AUTH_SALT', 'P}aWgR.H5x-n3iG<g3MKo_m(FkqYVh#^d`:^Nifjti1#r*?vLl.l|AC&<-}v1CSP');
define('LOGGED_IN_SALT',   'R}~-~p;C8(o89U__eX2Z%vo#MA7 +]f}Z.7J(3#Vg5DZWd3pDxelj+9w1>d~E#X|');
define('NONCE_SALT',       'oY-XTbc7>sQ7P{; jyoI(BmgYd1>+<I>bu%2dE$+njR`Zx-r_NQ4qEu|8c= 3hp8');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
