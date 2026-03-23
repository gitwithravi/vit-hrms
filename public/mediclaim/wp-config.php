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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lite_hrm_vit' );

/** Database username */
define( 'DB_USER', 'pmad_usr' );

/** Database password */
define( 'DB_PASSWORD', 'MyMint@007##2023' );

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
define( 'AUTH_KEY',         'y).P5H`e:+5.`@5EokyJ+A|:PU1!8H5{|FDDzT@=~#G#GFd!5 xAW*t:#d/IzK*M' );
define( 'SECURE_AUTH_KEY',  '3|+[_A>SVJ,;Y_j%+aM~Ea*8KfgM|c{P=pDXNSM72?#HN>D}j4Jsg</_Lk:>(MP8' );
define( 'LOGGED_IN_KEY',    'TEk7pi>N^Z~T(He_t{Vv!5tanxvt~)c>_*gzS{l3Zg, n(t^=3ctdFN=KoXPvaL:' );
define( 'NONCE_KEY',        '6D<^M+HHjD2Numa]aaJN>9DeI4$-8UGDk#=J`s-pjQC3d#W*k>Z@SBW) u%;m367' );
define( 'AUTH_SALT',        '+?t=z#[`pzl0]Bs4nSVon^}MDuB3!+VpW;L2{4(c%dq(peQO<s9V2B>]7t~Bj!m:' );
define( 'SECURE_AUTH_SALT', '8*.bS-@x6O][l3j<R:2Z<x&V4VC :&~F|~PkpD=^J^y.G_c!WQ- ^9O|_XMCto!}' );
define( 'LOGGED_IN_SALT',   'Aq?/t>/|g^(2ADXoL#S+jwne{Wcal{quh-=&Be4b</D&JF_l67Topv:;?.DuAxQm' );
define( 'NONCE_SALT',       '(.ZK,A(t]]5}yE(-*.x95-H:su]X$35Pz=~>5cKNJE&qG0!lvcz>O:W0OnWS;rRZ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'mediclaim_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
