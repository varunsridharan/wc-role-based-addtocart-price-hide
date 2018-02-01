<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 03:21 PM
 */

class WC_Role_Based_AddToCart_Price_Hide_Frontend {
    public function __construct() {
        if( vsp_is_admin() === FALSE && vsp_is_ajax() === FALSE ) {
            $this->handle_hook_remove_button();
            add_filter('woocommerce_get_price_html', array( $this, 'remove_price' ), 99, 99);
        }
    }

    public function handle_hook_remove_button() {
        $user_pref = $this->get_user_pref();
        $product_types = wc_rbap_product_types();

        foreach( $product_types as $type ) {
            if( isset($user_pref[$type]) ) {
                if( $type == 'variable' && ! isset($user_pref[$type]['hide_variation']) ) {
                    remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
                } else if( isset($user_pref[$type]['hide_button']) && $user_pref[$type]['hide_button'] == TRUE ) {
                    remove_action('woocommerce_' . $type . '_add_to_cart', 'woocommerce_' . $type . '_add_to_cart', 30);
                }
            }
        }

    }

    protected function get_user_pref() {
        $user_role = vsp_get_current_user(TRUE);
        return wc_rbap_option($user_role);
    }

    public function remove_price($price_html = '', $product = '') {
        $product_type = VSP_WC_Product_Compatibility::product_type($product);
        $product_type = ( $product_type == 'variation' ) ? 'variable' : $product_type;
        $user_role = vsp_get_current_user(TRUE);

        if( wc_rbap_is_allowed_user() === TRUE && wc_rbap_is_allowed_product_type($product_type) === TRUE ) {
            if( method_exists($this, 'handle_' . $product_type . '_price') ) {
                return $this->{'handle_' . $product_type . '_price'}($price_html, $product);
            } else if( method_exists($this, 'handle_product_price') ) {
                return $this->{'handle_product_price'}($price_html, $product, $product_type);
            }

        }

        return $price_html;
    }

    public function handle_product_price($price, $product, $product_type = NULL) {
        $user_role = vsp_get_current_user(TRUE);
        $user_pref = $this->get_user_pref();

        if( isset($user_pref[$product_type]) ) {
            if( isset($user_pref[$product_type]['hide_price']) && $user_pref[$product_type]['hide_price'] == TRUE ) {
                $price = '';
            }

            if( ! empty($user_pref[$product_type][$user_role . '_' . $product_type . '_custom_message']) ) {
                $price = $this->render_price_message($user_pref[$product_type][$user_role . '_' . $product_type . '_custom_message']);
            }
        }

        return $price;
    }

    protected function render_price_message($message) {
        $shortcodes = apply_filters('wc_rbap_hide_shortcodes', array( '[currency]' => get_woocommerce_currency_symbol() ));
        return str_replace(array_keys($shortcodes), array_values($shortcodes), $message);
    }
}