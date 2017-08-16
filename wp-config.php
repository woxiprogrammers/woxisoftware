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
define('DB_NAME', 'woxisoftware');

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

define('FS_METHOD', 'direct');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*Ug%Ci$-~)7KknVbEiJSyoa:]`MZ#-+$dd4e+f5cqi.l@D8?S-s+!-ql3FQ-NH1A');
define('SECURE_AUTH_KEY',  'UY2ypaN#4hCBwXC=xckp]C#!F||%L2IQ2YQgc+utaDjvK-TKJn[)+Lox.,,Z,qg(');
define('LOGGED_IN_KEY',    '|OrlQE4bcq%29 Fzm*Ps3=luK[R#AwWw^S(t}OeEnl!e]j6CB9dkmizP;Jn,|20@');
define('NONCE_KEY',        ')OW2ViGY$oc^pTr?MwDnWl4=L}I[IXZm~?j5?)U]MgH&{b$cIT!iGu-Nd*vkZZju');
define('AUTH_SALT',        '623OwFR-8S2p-o/nR>CC*k*FO&lQQ|;w<r.Ow+[92,PC:/^f831hhrOQM65yFn#U');
define('SECURE_AUTH_SALT', '^@Td-u&R04/o]2h(1iYF[!zu0frfQ5.uY?U;0%!N!3F~.Hb:PX+Ppm5,ncm nh`/');
define('LOGGED_IN_SALT',   '<K{AOxi&e/f0D~.eZ]h?/5]H-v@:>+h$>Q}W{LcKy~_X*TbSGoxnu/dmAZ@ Rewg');
define('NONCE_SALT',       'v(`K>MzLcl>Ghi|}#VF_L0dd[b1Vc7cG_he+atHh_|`bNb|:C4DZEa[jb!AS}o6W');

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

