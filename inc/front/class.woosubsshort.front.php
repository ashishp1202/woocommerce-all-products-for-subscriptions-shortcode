<?php
/**
 * WOODSUBSSHORT_Front Class
 *
 * Handles the Frontend functionality.
 *
 * @package WordPress
 * @subpackage Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'WOODSUBSSHORT_Front' ) ) {

	/**
	 * The WOODSUBSSHORT_Front Class
	 */
	class WOODSUBSSHORT_Front {

		var $action = null,
		    $filter = null;

		function __construct() {
			add_shortcode( 'wooconvertsubscription_shortcode', array( $this, 'fn_woosubscription_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'action__wp_enqueue_scripts' ) );
		}

		
		function action__wp_enqueue_scripts() {
			wp_enqueue_script( WOODSUBSSHORT_PREFIX . '_front_js', WOODSUBSSHORT_URL . 'assets/js/front.js', array( 'jquery-core' ), '' );
		}

		function fn_woosubscription_shortcode(){			
			if(class_exists('WCS_ATT_Manage_Add')){
				ob_start();
				require_once( 'template.woosubsshort.php' );
				return ob_get_clean();
			}
		}
	}

	add_action( 'plugins_loaded', function() {
		WOODSUBSSHORT()->front = new WOODSUBSSHORT_Front;
	} );
}
