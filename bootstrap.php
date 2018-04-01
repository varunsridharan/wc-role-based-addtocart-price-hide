<?php
/**
 * Created by PhpStorm.
 * User: varun
 * Date: 01-02-2018
 * Time: 11:48 AM
 */

/**
 * Class WC_Role_Based_AddToCart_Price_Hide
 */
final class WC_Role_Based_AddToCart_Price_Hide extends VSP_Framework {
	/**
	 * Text_domain
	 *
	 * @var null
	 */
	public $text_domain = 'wcrbap-hide';

	/**
	 * Version
	 *
	 * @var null
	 */
	public $version = WC_RBAP_V;

	/**
	 * File
	 *
	 * @var null
	 */
	public $file = WC_RBAP_FILE;

	/**
	 * Plugin Slug
	 *
	 * @var null
	 */
	public $slug = WC_RBAP_SLUG;

	/**
	 * DB_slug
	 *
	 * @var null
	 */
	public $db_slug = WC_RBAP_DB;

	/**
	 * Name
	 *
	 * @var null
	 */
	public $name = WC_RBAP_NAME;

	/**
	 * Hook_slug
	 *
	 * @var null
	 */
	public $hook_slug = WC_RBAP_DB;

	/**
	 * settings_fields
	 *
	 * @var null
	 */
	public $settings_fields = null;

	/**
	 * frontend
	 *
	 * @var null
	 */
	protected $frontend = null;

	/**
	 * WC_Role_Based_AddToCart_Price_Hide constructor.
	 */
	public function __construct() {
		parent::__construct( array(
			'addons'        => false,
			'settings_page' => array(
				'menu_parent'      => 'woocommerce',
				'menu_title'       => WC_RBAP_NAME,
				'menu_type'        => 'submenu',
				'menu_slug'        => WC_RBAP_SLUG,
				'menu_capability'  => 'manage_woocommerce',
				'show_reset_all'   => false,
				'framework_title'  => WC_RBAP_NAME,
				'option_name'      => WC_RBAP_DB,
				'style'            => 'simple',
				'ajax_save'        => false,
				'is_single_page'   => false,
				'is_sticky_header' => true,
				'buttons'          => array(
					'save'    => __( 'Save', 'wcrbap-hide' ),
					'restore' => false,
					'reset'   => false,
				),
				'status_page'      => true,
				'show_adds'        => false,
				'show_faqs'        => false,
			),
			'reviewme'      => array(
				'days_after' => 3,
				'slug'       => 'wc-role-based-addtocart-price-hide',
				'type'       => 'plugin', # Use theme if you are using it in a theme
				'site'       => 'wordpress',
				'rating'     => 4,
			),
		) );
	}

	public function load_files() {
		if ( vsp_is_request( 'admin' ) ) {
			vsp_load_file( WC_RBAP_PATH . 'includes/class-settings.php' );
		}

		if ( vsp_is_frontend() ) {
			vsp_load_file( WC_RBAP_PATH . 'includes/frontend.php' );
		}
	}

	public function settings_init_before() {
		$this->settings_fields = new WC_Role_Based_AddToCart_Price_Settings( $this->slug( 'hook' ) );
	}

	public function on_wp_init() {
		if ( vsp_is_frontend() ) {
			$this->frontend = new WC_Role_Based_AddToCart_Price_Hide_Frontend();
		}
	}

	public function register_hooks() {
	}

	public function plugin_init() {
	}

	public function row_links( $plugin_meta, $plugin_file ) {
		if ( WC_RBAP_FILE === $plugin_file ) {
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'http://wordpress.org/plugins/wc-role-based-addtocart-price-hide', __( 'F.A.Q', 'wcrbap-hide' ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'https://github.com/varunsridharan/wc-role-based-addtocart-price-hide', __( 'View On Github', 'wcrbap-hide' ) );
			$plugin_meta[] = sprintf( '<a href="%s">%s</a>', 'https://github.com/varunsridharan/wc-role-based-addtocart-price-hide', __( 'Report Issue', 'wcrbap-hide' ) );
			$plugin_meta[] = sprintf( '&hearts; <a href="%s">%s</a>', 'http://paypal.me/varunsridharan23', __( 'Donate', 'wcrbap-hide' ) );
		}

		return $plugin_meta;
	}

	public function action_links( $action, $file, $plugin_meta, $status ) {
		$menu_link = admin_url( 'admin.php?page=wc-role-based-addtocart-price-hide' );
		$actions[] = sprintf( '<a href="%s">%s</a>', $menu_link, __( 'Settings', 'wcrbap-hide' ) );
		$actions[] = sprintf( '<a href="%s">%s</a>', 'http://varunsridharan.in/plugin-support/', __( 'Contact Author', 'wcrbap-hide' ) );
		$action    = array_merge( $actions, $action );
		return $action;
	}
}
