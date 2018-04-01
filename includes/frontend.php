<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 03:21 PM
 */

/**
 * Class WC_Role_Based_AddToCart_Price_Hide_Frontend
 */
class WC_Role_Based_AddToCart_Price_Hide_Frontend {
	/**
	 * WC_Role_Based_AddToCart_Price_Hide_Frontend constructor.
	 */
	public function __construct() {
		if ( vsp_is_admin() === false && vsp_is_ajax() === false ) {
			$this->handle_hook_remove_button();
			add_filter( 'woocommerce_get_price_html', array( $this, 'remove_price' ), 99, 99 );
		}
	}

	/**
	 * Register AddToCart Button Hook.
	 */
	public function handle_hook_remove_button() {
		$user_pref     = $this->get_user_pref();
		$product_types = wc_rbap_product_types();

		foreach ( $product_types as $type ) {
			if ( isset( $user_pref[ $type ] ) ) {
				if ( 'variable' === $type && ! isset( $user_pref[ $type ]['hide_variation'] ) ) {
					remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
				} elseif ( isset( $user_pref[ $type ]['hide_button'] ) && $user_pref[ $type ]['hide_button'] == true ) {
					remove_action( 'woocommerce_' . $type . '_add_to_cart', 'woocommerce_' . $type . '_add_to_cart', 30 );
				}
			}
		}

	}

	/**
	 * Returns Config Based on Current User Role.
	 *
	 * @return bool|array
	 */
	protected function get_user_pref() {
		$user_role = vsp_get_current_user( true );
		return wc_rbap_option( $user_role );
	}

	/**
	 * Removes Price From Display.
	 *
	 * @param string       $price_html
	 * @param object|array $product
	 *
	 * @return string
	 */
	public function remove_price( $price_html = '', $product = array() ) {
		$product_type = VSP_WC_Product::product_type( $product );
		$product_type = ( 'variation' === $product_type ) ? 'variable' : $product_type;

		if ( wc_rbap_is_allowed_user() === true && wc_rbap_is_allowed_product_type( $product_type ) === true ) {
			if ( method_exists( $this, 'handle_' . $product_type . '_price' ) ) {
				return $this->{'handle_' . $product_type . '_price'}( $price_html, $product );
			} elseif ( method_exists( $this, 'handle_product_price' ) ) {
				return $this->{'handle_product_price'}( $price_html, $product, $product_type );
			}
		}

		return $price_html;
	}

	/**
	 * Handles Product Price.
	 *
	 * @param      $price
	 * @param      $product
	 * @param null $product_type
	 *
	 * @return mixed|string
	 */
	public function handle_product_price( $price, $product, $product_type = null ) {
		$user_role = vsp_get_current_user( true );
		$user_pref = $this->get_user_pref();

		if ( isset( $user_pref[ $product_type ] ) ) {
			if ( isset( $user_pref[ $product_type ]['hide_price'] ) && true === $user_pref[ $product_type ]['hide_price'] ) {
				$price = '';
			}

			if ( ! empty( $user_pref[ $product_type ][ $user_role . '_' . $product_type . '_custom_message' ] ) ) {
				$price = $this->render_price_message( $user_pref[ $product_type ][ $user_role . '_' . $product_type . '_custom_message' ] );
			}
		}

		return $price;
	}

	/**
	 * Renders Hidden Message.
	 *
	 * @param $message
	 *
	 * @return mixed
	 */
	protected function render_price_message( $message ) {
		$shortcodes = apply_filters( 'wc_rbap_hide_shortcodes', array( '[currency]' => get_woocommerce_currency_symbol() ) );
		return str_replace( array_keys( $shortcodes ), array_values( $shortcodes ), $message );
	}
}
