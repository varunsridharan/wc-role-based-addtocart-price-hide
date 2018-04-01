<?php
/**
 * Plugin Name:WC Role Based AddToCart / Price Hide
 * Plugin URI:http://wordpress.org/plugins/wc-role-based-addtocart-price-hide
 * Description:Hide Product Add To Cart / Price Based on User Role
 * Version:1.1
 * Author:Varun Sridharan
 * Author URI:http://varunsridharan.in
 * License:GPL-2.0+
 * License URI:http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:wcrbap-hide
 * Domain Path:/languages
 */

define( 'WC_RBAP_NAME', __( 'WC Role Based AddToCart / Price Hide', 'wcrbap-hide' ) ); # Plugin Name
define( 'WC_RBAP_TXT', 'wcrbap-hide' ); #plugin lang Domain
define( 'WC_RBAP_SLUG', 'wc-role-based-addtocart-price-hide' ); # Plugin Slug
define( 'WC_RBAP_DB', 'wc_rbap_hide' );
define( 'WC_RBAP_PATH', plugin_dir_path( __FILE__ ) ); # Plugin DIR
define( 'WC_RBAP_URL', plugins_url( '', __FILE__ ) . '/' );  # Plugin URL
define( 'WC_RBAP_V', '1.1' ); # Plugin Version
defined( 'WC_RBAP_FILE' ) or define( 'WC_RBAP_FILE', plugin_basename( __FILE__ ) );
require_once( WC_RBAP_PATH . 'vsp-framework/vsp-init.php' );

if ( function_exists( 'vsp_maybe_load' ) ) {
	vsp_maybe_load( WC_RBAP_PATH, array(
		'lib' => array( 'wpsf' ),
	), 'wc_rbap_load_plugin' );
}

if ( ! function_exists( 'wc_rbap_load_plugin' ) ) {
	function wc_rbap_load_plugin() {
		require_once( WC_RBAP_PATH . 'bootstrap.php' );
		require_once( WC_RBAP_PATH . 'includes/functions.php' );
		WC_Role_Based_AddToCart_Price_Hide::instance();
	}
}
