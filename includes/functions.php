<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 02:26 PM
 */
global $wc_rbap_hide;
$wc_rbap_hide = null;
if ( ! function_exists( 'wc_rbap_option' ) ) {
	/**
	 * Returns option value from $wc_rbap_hide.
	 *
	 * @param string $key
	 * @param bool   $default
	 *
	 * @return bool
	 */
	function wc_rbap_option( $key = '', $default = false ) {
		global $wc_rbap_hide;

		if ( null === $wc_rbap_hide ) {
			$wc_rbap_hide = get_option( 'wc_rbap_hide', true );
			if ( empty( $wc_rbap_hide ) || ! is_array( $wc_rbap_hide ) ) {
				$wc_rbap_hide = array();
			}
		}

		if ( ! empty( $wc_rbap_hide ) ) {
			if ( isset( $wc_rbap_hide[ $key ] ) ) {
				return $wc_rbap_hide[ $key ];
			}
		}

		return $default;
	}
}

if ( ! function_exists( 'wc_rbap_user_roles' ) ) {
	/**
	 * Returns Active User Roles. as slug=>name.
	 *
	 * @param bool $is_option
	 *
	 * @return array|bool
	 */
	function wc_rbap_user_roles( $is_option = false ) {
		$enabled = wc_rbap_option( 'enabled_user_roles', vsp_user_roles_as_options() );
		if ( $is_option ) {
			return vsp_filter_user_roles( $enabled );
		}

		return $enabled;
	}
}

if ( ! function_exists( 'wc_rbap_product_types' ) ) {
	/**
	 * Returns Enabled Product Types.
	 *
	 * @return array|bool
	 */
	function wc_rbap_product_types() {
		$type = wc_rbap_option( 'enabled_product_types', array_keys( wc_get_product_types() ) );
		if ( ! is_array( $type ) ) {
			return array_keys( wc_get_product_types() );
		}
		return $type;
	}
}

if ( ! function_exists( 'wc_rbap_is_allowed_user' ) ) {
	/**
	 * Checks if given user role is allowed.
	 *
	 * @param null $user_role
	 *
	 * @return bool
	 */
	function wc_rbap_is_allowed_user( $user_role = null ) {
		$user_role = ( is_null( $user_role ) ) ? vsp_get_current_user( true ) : $user_role;

		return ( in_array( $user_role, wc_rbap_user_roles() ) ) ? true : false;
	}
}

if ( ! function_exists( 'wc_rbap_is_allowed_product_type' ) ) {
	/**
	 * Checks if given product type is allowed.
	 *
	 * @param string $product_type
	 *
	 * @return bool
	 */
	function wc_rbap_is_allowed_product_type( $product_type = '' ) {
		return ( in_array( $product_type, wc_rbap_product_types() ) ) ? true : false;
	}
}
