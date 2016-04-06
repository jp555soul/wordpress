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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'z!h>Q#G-O/gs/|su1#ej$6t_+RBt$5CYSLv-X$d)0<euVlDVoc#6beJeI~9U+tGs');
define('SECURE_AUTH_KEY',  '_A?PlxP3Y-pdmxqJ|Yx6(`Kh2)b]N!/Vxhfm53xd/m{QUEppi#D>~gxiBfn(T@lZ');
define('LOGGED_IN_KEY',    'Ol#B96+6)n2Q7@XlbF|,||%_dw_sV)PvHi$JzvFHt~0jhOF6b|Y_Y1[r8LQ;vbSQ');
define('NONCE_KEY',        '{qjStC{[3Q#-kX*VCz[o@zUiSS(|;|x8!_;dU]}[zUuy@WGAIMWl%$K+AiD5E-SO');
define('AUTH_SALT',        'xOX|M:5CCfPU{cm3.ql,>>A* _w`*%Eq68{iBqU8Yd3JEb2U.uXUa}.gXf-y::iZ');
define('SECURE_AUTH_SALT', '&,Mi(0+H+B3*OAsUpk1e?Ex1St(Q&YI,46gEpw)TisnV|U+J-i08 v<)v+dCzx@6');
define('LOGGED_IN_SALT',   '|IXsv*TlT,{6XEPDeVZi-}_ArVu!LI!ckr`+>|~~b;{E1JBBDm2Ky{/kACu#bqU6');
define('NONCE_SALT',       '/of#7}XjszSM6%YGJ #y>):-=^lIU86_dfxDA/F_:CY>n(Fbl2yr-]~v@MyE^+R@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
