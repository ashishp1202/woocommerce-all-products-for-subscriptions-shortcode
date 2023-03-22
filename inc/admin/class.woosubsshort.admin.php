<?php
/**
 * WOODSUBSSHORT_Admin Class
 *
 * Handles the admin functionality.
 *
 * @package WordPress
 * @subpackage Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'WOODSUBSSHORT_Admin' ) ) {

	/**
	 * The WOODSUBSSHORT_Admin Class
	 */
	class WOODSUBSSHORT_Admin {

		var $action = null,
			$filter = null;
	}

	add_action( 'plugins_loaded', function() {
		WOODSUBSSHORT()->admin = new WOODSUBSSHORT_Admin;
	} );
}
