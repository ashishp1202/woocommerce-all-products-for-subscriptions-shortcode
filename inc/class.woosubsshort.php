<?php
/**
 * WOODSUBSSHORT Class
 *
 * Handles the plugin functionality.
 *
 * @package WordPress
 * @package Plugin name
 * @since 1.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( !class_exists( 'WOODSUBSSHORT' ) ) {

	/**
	 * The main WOODSUBSSHORT class
	 */
	class WOODSUBSSHORT {

		private static $_instance = null;

		var $admin = null,
		    $front = null,
		    $lib   = null;

		public static function instance() {

			if ( is_null( self::$_instance ) )
				self::$_instance = new self();

			return self::$_instance;
		}

		function __construct() {
			add_action( 'plugins_loaded', array( $this, 'action__plugins_loaded' ), 999 );

			add_action("wp_ajax_make_woo_product_as_subscription", array($this,"fn_make_woo_product_as_subscription"));
			add_action("wp_ajax_nopriv_make_woo_product_as_subscription", array($this,"fn_make_woo_product_as_subscription"));
		}

		
		/**
		 * Action: plugins_loaded
		 *
		 * - Plugin load function
		 *
		 * @method action__plugins_loaded
		 *
		 * @return [type] [description]
		*/
		function action__plugins_loaded() {

			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( !is_plugin_active( 'woocommerce-all-products-for-subscriptions/woocommerce-all-products-for-subscriptions.php' ) ) {
				add_action( 'admin_notices', array( $this, 'action__WOODSUBSSHORT_admin_notices_deactive' ) );
				deactivate_plugins( WOODSUBSSHORT_PLUGIN_BASENAME );
				if ( isset( $_GET['activate'] ) ) {
					unset( $_GET['activate'] );
				}
			}
			global $wp_version;

			# Set filter for plugin's languages directory
			$WOODSUBSSHORT_lang_dir = dirname( WOODSUBSSHORT_PLUGIN_BASENAME ) . '/languages/';
			$WOODSUBSSHORT_lang_dir = apply_filters( 'WOODSUBSSHORT_languages_directory', $WOODSUBSSHORT_lang_dir );

			# Traditional WordPress plugin locale filter.
			$get_locale = get_locale();

			if ( $wp_version >= 4.7 ) {
				$get_locale = get_user_locale();
			}

			# Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale',  $get_locale, 'plugin-text-domain' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'plugin-text-domain', $locale );

			# Setup paths to current locale file
			$mofile_global = WP_LANG_DIR . '/plugins/' . basename( WOODSUBSSHORT_DIR ) . '/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				# Look in global /wp-content/languages/plugin-name folder
				load_textdomain( 'plugin-text-domain', $mofile_global );
			} else {
				# Load the default language files
				load_plugin_textdomain( 'plugin-text-domain', false, $WOODSUBSSHORT_lang_dir );
			}
		}

		/**
		 *
		 * Action: admin_notices
		 *
		 * Admin notice of activate pugin.
		 */
		function action__WOODSUBSSHORT_admin_notices_deactive() {
			echo '<div class="error">' .
					sprintf(
						__( '<p><strong><a href="https://woocommerce.com/products/all-products-for-woocommerce-subscriptions/" target="_blank">All Products for WooCommerce Subscriptions</a></strong> is required to use <strong>%s</strong>.</p>', 'woo-product-delite-subcription-shortcode' ),
						'WooCommerce Product Subscriptions Shortcode'
					) .
				'</div>';
		}

		function fn_make_woo_product_as_subscription(){
			session_start();
			
			if(isset($_POST['checkval']) && $_POST['checkval'] === 'checked'){
				if(class_exists('WCS_ATT_Cart')){
					foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						
						$subscription_schemes = WCS_ATT_Product_Schemes::get_subscription_schemes( wc_get_product($cart_item['product_id']) );
						
						if ( ! empty( $cart_item[ 'wcsatt_data' ] ) && !empty($subscription_schemes)) {
							foreach($subscription_schemes as $key=>$subscription_scheme){
								$subscription_duration = $key;
								continue;
							}
							$posted_subscription_scheme_key = null;
	
							$key = 'convert_to_sub';
							WC()->cart->cart_contents[ $cart_item_key ][ $key ] = $subscription_duration;
							
							$posted_subscription_scheme_option = isset( WC()->cart->cart_contents[ $cart_item_key ][ $key ] ) ? wc_clean( WC()->cart->cart_contents[ $cart_item_key ][ $key ] ) : null;
							
							if ( null !== $posted_subscription_scheme_option ) {
								$posted_subscription_scheme_key = WCS_ATT_Product_Schemes::parse_subscription_scheme_key( $posted_subscription_scheme_option );
							}
							
							if ( null !== $posted_subscription_scheme_key ) {
			
								$existing_subscription_scheme_key = isset( $cart_item[ 'wcsatt_data' ][ 'active_subscription_scheme' ] ) ? $cart_item[ 'wcsatt_data' ][ 'active_subscription_scheme' ] : null;
								
								if ( $posted_subscription_scheme_key !== $existing_subscription_scheme_key ) {
									WC()->cart->cart_contents[ $cart_item_key ][ 'wcsatt_data' ][ 'active_subscription_scheme' ] = $posted_subscription_scheme_key;
									$schemes_changed = true;
								}
							}
							
						}
						if ( $schemes_changed ) {
							WCS_ATT_Cart::apply_subscription_schemes( WC()->cart );
						}
						WC()->cart->set_session();
					}
				}
				
				$_SESSION['enable_subscription'] = true;
				wp_send_json(array('response' =>'success', 'message'=>"done"));
			}else{
				$schemes_changed = false;
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
						
					if ( ! empty( $cart_item[ 'wcsatt_data' ] ) ) {
						$posted_subscription_scheme_key = null;

						$key = 'convert_to_sub';
						WC()->cart->cart_contents[ $cart_item_key ][ $key ] = '';
						
						$posted_subscription_scheme_option = isset( WC()->cart->cart_contents[ $cart_item_key ][ $key ] ) ? wc_clean( WC()->cart->cart_contents[ $cart_item_key ][ $key ] ) : null;
						
						if ( null !== $posted_subscription_scheme_option ) {
							$posted_subscription_scheme_key = WCS_ATT_Product_Schemes::parse_subscription_scheme_key( $posted_subscription_scheme_option );
						}
						
						if ( null !== $posted_subscription_scheme_key ) {
		
							$existing_subscription_scheme_key = isset( $cart_item[ 'wcsatt_data' ][ 'active_subscription_scheme' ] ) ? $cart_item[ 'wcsatt_data' ][ 'active_subscription_scheme' ] : null;
							
							if ( $posted_subscription_scheme_key !== $existing_subscription_scheme_key ) {
								WC()->cart->cart_contents[ $cart_item_key ][ 'wcsatt_data' ][ 'active_subscription_scheme' ] = $posted_subscription_scheme_key;
								$schemes_changed = true;
							}
						}
						
					}
					if ( $schemes_changed ) {
						WCS_ATT_Cart::apply_subscription_schemes( WC()->cart );
					}
					WC()->cart->set_session();
				}
				$_SESSION['enable_subscription'] = '';
			}
		}

	}
}

function WOODSUBSSHORT() {
	return WOODSUBSSHORT::instance();
}

WOODSUBSSHORT();
