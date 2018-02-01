<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 02:26 PM
 */


if( ! function_exists('wc_rbap_option') ) {
    function wc_rbap_option($key = '', $default = FALSE) {
        global $wc_rbap_hide;

        if( ! empty($wc_rbap_hide) ) {
            if( isset($wc_rbap_hide[$key]) ) {
                return $wc_rbap_hide[$key];
            }
        }

        return $default;
    }
}

if( ! function_exists('wc_rbap_user_roles') ) {
    function wc_rbap_user_roles($is_option = FALSE) {
        $enabled = wc_rbap_option('enabled_user_roles', vsp_user_roles_as_options());
        if( $is_option ) {
            return vsp_filter_user_roles($enabled);
        }
        return $enabled;
    }
}

if( ! function_exists('wc_rbap_product_types') ) {
    function wc_rbap_product_types() {
        $type = wc_rbap_option('enabled_product_types',array_keys( wc_get_product_types()));
        if(!is_array($type)){
            return array_keys( wc_get_product_types());
        }
        return $type;
    }
}

if( ! function_exists('wc_rbap_is_allowed_user') ) {
    function wc_rbap_is_allowed_user($user_role = NULL) {
        $user_role = ( is_null($user_role) ) ? vsp_get_current_user(TRUE) : $user_role;

        return ( in_array($user_role, wc_rbap_user_roles()) ) ? TRUE : FALSE;
    }
}

if( ! function_exists('wc_rbap_is_allowed_product_type') ) {
    function wc_rbap_is_allowed_product_type($product_type = '') {

        return ( in_array($product_type, wc_rbap_product_types()) ) ? TRUE : FALSE;
    }
}