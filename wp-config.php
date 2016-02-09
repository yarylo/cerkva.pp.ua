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
define('DB_NAME', 'u311510689_cerkv');

/** MySQL database username */
define('DB_USER', 'u311510689_cerkv');

/** MySQL database password */
define('DB_PASSWORD', 'cerkva2014');
//define('DB_PASSWORD', 'cerkva2014');

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
define('AUTH_KEY',         '43mWBjc3>wQ!*/VSrpeQ{#@&ja#Az9)<m-3T BDZ=}~WUByZkE@%} !gx-0lJ`Ws');
define('SECURE_AUTH_KEY',  'H795>9wYU<nych<]MvolsfdQOqY[&O,(Cg{ZKB=|K`bPCfii:`-+RwW/m=gLZ3qf');
define('LOGGED_IN_KEY',    '+*H-FSZ{`BVTz3]&Mlh-{C-&{5wB]mn.bSO-f-d&nZE%1~zR:+Vm17Kw11OhIp<L');
define('NONCE_KEY',        '.|Vk34kBazNV8L)>GmL,!|0`IjQyw89vI=,*qO1NPl8#-h{l3_},K;) TR iv$3E');
define('AUTH_SALT',        '#c^aQ|#?zF,4=m& VAyTo%bNe1](%V.)o;[axxZXg[hsph21^|73@~d!(fZP-2zC');
define('SECURE_AUTH_SALT', ',Y0H5cdyJ`=rWwBG!Vu7:*-|GCho^lo3;ORPs*S%Ph SZ*ON-L-=Iahg-isl?JA>');
define('LOGGED_IN_SALT',   'QKYq1?m#d.HxM0eZ=JSy6.9rYf1-L$-:<P,D~|{=|JE=$v;`o;M?XwRoP[j@{<Fe');
define('NONCE_SALT',       'J >+uNxO}+doaDE?1+9=Kt-mDYRtA`pwwgC?Za6*)-%GUPN%hq*kvG-8FE?m0y{W');

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
