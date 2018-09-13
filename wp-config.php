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
define('DB_NAME', 'test');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         '|{}(g`pO8z`3_9tV sUE6:s&wxDl,9kMYCLgHCH%Ait@K8_k?cY@(8T-t5<#7xTm');
define('SECURE_AUTH_KEY',  ':tDo_Jbzve?}PliN^LZDFaF6V~=S$M=dFjsFSQm(|4V]n7N#LU:fu}?f$A)Yo+_0');
define('LOGGED_IN_KEY',    '>)bnLb*1_uN0!M-g+WJ]?:+lsS=>X>UAgWT Qk+<S2WXaR(7Zep&.F96OCGecpg=');
define('NONCE_KEY',        ']F&,DV`h +)[,vKU._4`+kU4LqaYdde+HAvo?QNStA{_L=ylb,<LU6Qw}h*<iM_d');
define('AUTH_SALT',        '8_>y]WB<cApxd9g8zqUMWTkhnmADR1CbA#Rt1U?Ug|%hbMZ7x*O}]*wq$>o_C4(B');
define('SECURE_AUTH_SALT', '%XbED(h#<{-.,.#6Rz{.])1Wb|VYS+a TW>O[wB+8H aq4+Ho6HY/T@*9Qp.[ z#');
define('LOGGED_IN_SALT',   'g$N-p*a%Z`4>}&l}5i}5xp,LKGq~(.$Nz0_9Iw?hIcE[(by![%si6-^>3u%szU6K');
define('NONCE_SALT',       'SaGp^+fhm!x)i`.`0Alh!ugcd 8HYT@ifQj[4BR&os7m{!1?!@*z94]$hf5S|q{/');

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
