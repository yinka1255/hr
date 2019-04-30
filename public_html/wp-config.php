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
define( 'DB_NAME', 'imperialhr' );

/** MySQL database username */
define( 'DB_USER', 'yinka1255' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Adeniran1255$' );

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
define( 'AUTH_KEY',         'R=!z GNd7D!R32.oh/:yO,EM!DB)2DMp@V&hm_i=?:WaR D/+R3?NxN*{veS=(4M' );
define( 'SECURE_AUTH_KEY',  '(wJVcQy1[AD=Bw1S3@8LD2nRbO&`&/3@w7.3a9-c#)yjD@/$dqi#t4`>ympyveg|' );
define( 'LOGGED_IN_KEY',    'iVXv!G#(E~o{>t l&@NL4o1]Wg 7[O[10e$%|LSb_~Ofxrp;?u*7+XFG77QqgdM9' );
define( 'NONCE_KEY',        'K:pB:Rsekg1y4c0tM0aMOA[LBidNP]ELK2EK8N^sDQZ5xr8kb/:4`O)hOhw|neKK' );
define( 'AUTH_SALT',        'O@(D7JLA>$A,CA%d$+RqV~1:bg]~/WR>?l180-Kyh{O&)t4*$-$!ny.e5hwQ0q= ' );
define( 'SECURE_AUTH_SALT', 'aKs!]W.VAIV<zgTD3vSmE$snRsJ7KxTFob!lc6ZVm}KMr=*tDYMIF@c=~X9Myp#r' );
define( 'LOGGED_IN_SALT',   'uD)^g)xJ7O$;A:Np,*F/zeh/z33H!(}5j&Su >=qq{53~e~!x(UE<mEDx#?Xf(:F' );
define( 'NONCE_SALT',       '<uQ0z_S0PL2eb+x0q^NJ(sXO$C5IgMz?0c+>CopK=(>HlQ2eLA1cas/(eN,6Dk3@' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
