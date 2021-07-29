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
define('DB_NAME', 'twolampf_WPMNS');

/** MySQL database username */
define('DB_USER', 'twolampf_WPMNS');

/** MySQL database password */
define('DB_PASSWORD', '^dw@GJ{V[X4qF6w_R');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define('AUTH_KEY', '8295129439f4e98feb8ecdfbae6cc90d87d6faa0cd244092a8e25d29637bb263');
define('SECURE_AUTH_KEY', 'af5309ba444cccdf08bb75aa1aed8e3a2d1f245033371026106bd3314fb0e583');
define('LOGGED_IN_KEY', '60f8bf18384514d1829c1112880df2658c6ead3e750b9d051af71ad03f37fc4b');
define('NONCE_KEY', '1f08e4328a539e40a556b2943a255a2b9bc1e37ef4ec6a7cd2bcee342e5a11d2');
define('AUTH_SALT', '0c7bdee9f08ecc71cb128c0d4ab66458fad67740708c074b4465b53a3bb38675');
define('SECURE_AUTH_SALT', '9461972377fe27ec6a865f446a9735ff9f11d8d1d6eaa323ecf50a2bbbb55117');
define('LOGGED_IN_SALT', '2df93bce8ba39836ad53a315828223fd763d25d6f4bd039b8fc66c5b36ed6fea');
define('NONCE_SALT', '276577b4fab07df0c78d8d8f6c233250b2c4f7abc64980f2f49de9e01aaef120');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = '1Vl_';
define('WP_CRON_LOCK_TIMEOUT', 120);
define('AUTOSAVE_INTERVAL', 300);
define('WP_POST_REVISIONS', 5);
define('EMPTY_TRASH_DAYS', 7);
define('WP_AUTO_UPDATE_CORE', true);

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
