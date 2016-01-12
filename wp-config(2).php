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
define('DB_NAME', 'u311510689_cerkv');

/** MySQL database username */
define('DB_USER', 'u311510689_cerkv');

/** MySQL database password */
define('DB_PASSWORD', 'cerkva2014');

/** MySQL hostname */
define('DB_HOST', 'mysql.hostinger.com.ua');

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
define('AUTH_KEY',         '^V+_]0:-3+G#e4(m(Ldrp!XrlLoS7GZjAlm]PL|!9k+Y[BIuju$y!%2R^ ipZCw{');
define('SECURE_AUTH_KEY',  '%}gs-SS&l/+Q(U~+ssc4{9Wo3T359b>MxyzQw/m/Xu/fs7Dep9~dW|3! )r-!gvO');
define('LOGGED_IN_KEY',    '/GX<+2SDgEaGc}IJAvOb@Aie4QIo`r38q;-06Ev-$|G+ ekbY)Hp^Hbkf+DFE|Op');
define('NONCE_KEY',        'D#qYe5Dn6iR28;<!2O==Sb4Pp1^?p3*IWgs&G@mrItpo_*/$;xah@QLHHaDT6%xK');
define('AUTH_SALT',        'd+?+kdbV.O~UK6=K}8/91/eA}UuY#oA2.mX,q,]H|~[|QQc|/V4Bd!]zKCEm>6-F');
define('SECURE_AUTH_SALT', '^sE-1VyjC%J3(O<+INZMRd*E7ZH+`5</+t%hRQ=Q#/c*)O9JX0 m^(6Z9cesi-l:');
define('LOGGED_IN_SALT',   'NF!c6-C]jaCkJhh-ywhsUuH)$ @WrG]Kcv3AlrJg@J-JX~&`VUFFds=%RPt,ARDw');
define('NONCE_SALT',       'Lj!+6(|?`|mK&vZ5yS/,@}Q:|y1={-WIH6yqXSuN{]Y+Eev9zx~u/% _`1K1mS^ ');

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
define('WPLANG', 'uk');

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

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );
	
/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
