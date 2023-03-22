<?php
/**
 * Plugin Name: WooCommerce Product Subscriptions Shortcode
 * Plugin URL: https://wordpress.org/plugin-url/
 * Description: WooCommerce Product Subscriptions Shortcode plugin provide option to place shortcode to make existing subscription.
 * Version: 1.0
 * Author: Archie Moreno
 * Author URI: archiemoreno.com
 * Developer: Archie Moreno
 * Developer E-Mail: archiemoreno@gmail.com
 * Text Domain: woo-product-delite-subcription-shortcode
 * Domain Path: /languages
 *
 * Copyright: 
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Basic plugin definitions
 *
 * @package WooCommerce Product Subscriptions Shortcode
 * @since 1.0
 */

if ( !defined( 'WOODSUBSSHORT_VERSION' ) ) {
	define( 'WOODSUBSSHORT_VERSION', '1.2' ); // Version of plugin
}

if ( !defined( 'WOODSUBSSHORT_FILE' ) ) {
	define( 'WOODSUBSSHORT_FILE', __FILE__ ); // Plugin File
}

if ( !defined( 'WOODSUBSSHORT_DIR' ) ) {
	define( 'WOODSUBSSHORT_DIR', dirname( __FILE__ ) ); // Plugin dir
}

if ( !defined( 'WOODSUBSSHORT_URL' ) ) {
	define( 'WOODSUBSSHORT_URL', plugin_dir_url( __FILE__ ) ); // Plugin url
}

if ( !defined( 'WOODSUBSSHORT_PLUGIN_BASENAME' ) ) {
	define( 'WOODSUBSSHORT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) ); // Plugin base name
}

if ( !defined( 'WOODSUBSSHORT_PREFIX' ) ) {
	define( 'WOODSUBSSHORT_PREFIX', 'woosubsshort' ); // Plugin prefix
}

/**
 * Initialize the main class
 */
if ( !function_exists( 'WOODSUBSSHORT' ) ) {

	if ( is_admin() ) {
		require_once( WOODSUBSSHORT_DIR . '/inc/admin/class.' . WOODSUBSSHORT_PREFIX . '.admin.php' );
	} else {
		require_once( WOODSUBSSHORT_DIR . '/inc/front/class.' . WOODSUBSSHORT_PREFIX . '.front.php' );
	}
	//Initialize all the things.
	require_once( WOODSUBSSHORT_DIR . '/inc/class.' . WOODSUBSSHORT_PREFIX . '.php' );
}
