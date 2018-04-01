<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 12:15 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Role_Based_AddToCart_Price_Settings
 */
class WC_Role_Based_AddToCart_Price_Settings extends VSP_Plugin_Settings {

	/**
	 * WC_Role_Based_AddToCart_Price_Settings constructor.
	 *
	 * @param string $hook_slug
	 */
	public function __construct( $hook_slug = '' ) {
		parent::__construct( $hook_slug );
	}

	/**
	 * Adds Pages To WPSF
	 *
	 * @param array $pages
	 *
	 * @return mixed
	 */
	public function add_pages( $pages = array() ) {
		$page['general'] = array(
			'name'  => 'general',
			'title' => __( 'General', 'wcrbap-hide' ),
			'icon'  => 'fa fa-gear',
		);
		return $page;
	}

	/**
	 * Adds Sections To WPSF
	 *
	 * @param array $sections
	 *
	 * @return array|mixed
	 */
	public function add_sections( $sections = array() ) {
		$sections['general/general'] = array(
			'name'  => 'general',
			'title' => __( 'General', 'wcrbap-hide' ),
			'icon'  => 'fa fa-gear',
		);
		$user_roles                  = wc_rbap_user_roles( true );

		foreach ( wc_rbap_user_roles() as $user_role ) {
			if ( ! isset( $user_roles[ $user_role ] ) ) {
				continue;
			}
			$sections[ 'general/' . $user_role ] = array(
				'name'  => $user_role,
				'title' => $user_roles[ $user_role ],
				'icon'  => 'fa fa-user',
			);
		}

		return $sections;
	}

	/**
	 * Adds Fields To WPSF.
	 *
	 * @param array $fields
	 *
	 * @return array|mixed
	 */
	public function add_fields( $fields = array() ) {
		$fields['general/general'] = array(
			array(
				'id'         => 'enabled_user_roles',
				'options'    => vsp_user_roles_as_options(),
				'type'       => 'select',
				'multiple'   => true,
				'title'      => __( 'Enabled User Roles', 'wcrbap-hide' ),
				'desc_field' => __( 'Select All User roles for whom you want to hide price / addtocart button', 'wcrbap-hide' ),
				'class'      => 'select2',
				'attributes' => array(
					'style' => 'width:50%;',
				),
			),
			array(
				'type'       => 'select',
				'id'         => 'enabled_product_types',
				'options'    => wc_get_product_types(),
				'multiple'   => true,
				'desc_field' => __( 'Select All Produc Types you want to hide price / addtocart button', 'wcrbap-hide' ),
				'title'      => __( 'Enabled Product Types', 'wcrbap-hide' ),
				'class'      => 'select2',
				'attributes' => array(
					'style' => 'width:50%;',
				),
			),
		);

		$types      = wc_get_product_types();
		$user_roles = wc_rbap_user_roles( true );
		foreach ( wc_rbap_user_roles() as $user_role ) {
			if ( ! isset( $user_roles[ $user_role ] ) ) {
				continue;
			}
			$fields[ 'general/' . $user_role ] = array(
				array(
					'type'      => 'tab',
					'tab_style' => 'left',
					'id'        => $user_role,
					'sections'  => array(),
				),
			);
			foreach ( wc_rbap_product_types() as $type ) {
				$_tabs = array(
					'name'   => $type,
					'title'  => ( isset( $types[ $type ] ) ) ? $types[ $type ] : $type,
					'fields' => array(
						array(
							'id'         => 'hide_price',
							'type'       => 'switcher',
							'title'      => __( 'Hide Price ?', 'wcrbap-hide' ),
							'on_label'   => __( 'Yes', 'wcrbap-hide' ),
							'off_label'  => __( 'No', 'wcrbap-hide' ),
							'desc_field' => __( 'Product Price will be hidden if set to Yes', 'wcrbap-hide' ),
						),

						array(
							'id'         => 'hide_button',
							'type'       => 'switcher',
							'title'      => __( 'Hide AddToCart Button ?', 'wcrbap-hide' ),
							'on_label'   => __( 'Yes', 'wcrbap-hide' ),
							'off_label'  => __( 'No', 'wcrbap-hide' ),
							'desc_field' => __( 'Product Add To Cart Button will be hidden if set to Yes', 'wcrbap-hide' ),
						),
					),
				);

				if ( 'variable' === $type ) {
					$_tabs['fields'][] = array(
						'id'         => 'hide_variation',
						'type'       => 'switcher',
						'title'      => __( 'Hide Variation ?', 'wcrbap-hide' ),
						'on_label'   => __( 'Yes', 'wcrbap-hide' ),
						'off_label'  => __( 'No', 'wcrbap-hide' ),
						'desc_field' => __( 'Product Variations will be hidden if set to Yes', 'wcrbap-hide' ),
					);
				}

				$_tabs['fields'][] = array(
					'id'         => $user_role . '_' . $type . '_custom_message',
					'type'       => 'wysiwyg',
					'title'      => __( 'Custom Message', 'wcrbap-hide' ),
					'desc_field' => __( 'Used when product price is hidden.. use <code>[currency]</code> to get current store currency', 'wcrbap-hide' ),
					'settings'   => array(
						'textarea_rows' => 5,
						'tinymce'       => true,
						'media_buttons' => false,
					),
				);

				$fields[ 'general/' . $user_role ][0]['sections'][] = $_tabs;
			}
		}

		return $fields;
	}
}
