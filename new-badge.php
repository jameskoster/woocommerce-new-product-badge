<?php
/*
Plugin Name: WooCommerce New Product Badge
Plugin URI: http://jameskoster.co.uk/tag/new-badge/
Version: 0.2
Description: Displays a 'new' badge on WooCommerce products published in the last x days.
Author: jameskoster
Tested up to: 3.6
Author URI: http://jameskoster.co.uk
Text Domain: woocommerce-new-badge
Domain Path: /languages/

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	/**
	 * Localisation
	 **/
	load_plugin_textdomain( 'woocommerce-new-badge', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


	/**
	 * New Badge class
	 **/
	if ( ! class_exists( 'WC_nb' ) ) {

		class WC_nb {

			public function __construct() {
				add_action( 'wp_enqueue_scripts', array( $this, 'setup_styles' ) );														// Enqueue the styles
				add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_show_product_loop_new_badge' ), 30 ); 	// The new badge function

				// Init settings
				$this->settings = array(
					array(
						'name' => __( 'New Badge', 'woocommerce-new-badge' ),
						'type' => 'title',
						'id' => 'wc_nb_options'
					),
					array(
						'name' 		=> __( 'Product Newness', 'woocommerce-new-badge' ),
						'desc' 		=> __( "Display the 'New' flash for how many days?", 'woocommerce-new-badge' ),
						'id' 		=> 'wc_nb_newness',
						'type' 		=> 'number',
					),
					array( 'type' => 'sectionend', 'id' => 'wc_nb_options' ),
				);


				// Default options
				add_option( 'wc_nb_newness', '30' );


				// Admin
				add_action( 'woocommerce_settings_image_options_after', array( $this, 'admin_settings' ), 20);
				add_action( 'woocommerce_update_options_catalog', array( $this, 'save_admin_settings' ) );
			}


	        /*-----------------------------------------------------------------------------------*/
			/* Class Functions */
			/*-----------------------------------------------------------------------------------*/

			// Load the settings
			function admin_settings() {
				woocommerce_admin_fields( $this->settings );
			}


			// Save the settings
			function save_admin_settings() {
				woocommerce_update_options( $this->settings );
			}


			// Setup styles
			function setup_styles() {
				if ( apply_filters( 'woocommerce_new_badge_enqueue_styles', true ) ) {
					wp_enqueue_style( 'nb-styles', plugins_url( '/assets/css/style.css', __FILE__ ) );
				}
			}


			/*-----------------------------------------------------------------------------------*/
			/* Frontend Functions */
			/*-----------------------------------------------------------------------------------*/

			// Display the new badge
			function woocommerce_show_product_loop_new_badge() {
				$postdate 		= get_the_time( 'Y-m-d' );			// Post date
				$postdatestamp 	= strtotime( $postdate );			// Timestamped post date
				$newness 		= get_option( 'wc_nb_newness' ); 	// Newness in days as defined by option

				if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
					echo '<span class="wc-new-badge">' . __( 'New', 'woocommerce-new-badge' ) . '</span>';
				}
			}
		}


		$WC_nb = new WC_nb();
	}
}
