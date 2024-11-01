<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class already exist
if( ! class_exists('App_Bar_Admin')) :

/**
 * Main App Bar Admin
 *
 * @class WP_App_Bar
 * @version	1.0
 */
final class App_Bar_Admin {
 
    /**
	 * @var App_Bar_Admin The single instance of the class
	 * @since 2.1
	 */
	protected static $_instance = null;
 
    /**
     * Main Instance
     *
     * @staticvar   array   $_instance
     * @return      The one true instance
     */
    public static function instance() {
     	if ( ! isset( self::$_instance ) ) {
         	self::$_instance = new self;
    	}
 
        return self::$_instance;
    }

    /**
	 * Cloning is forbidden.
	 * @since  1.0
	 * @access public
	 * @return void
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'app-bar' ), '1.0' );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * @since  1.0
	 * @access public
	 * @return void
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'app-bar' ), '1.0' );
	}

	/**
	 * Magic method to prevent a fatal error when calling a method that doesn't exist.
	 *
	 * @since  1.0
	 * @access public
	 * @return void
	 */
	public function __call( $method = '', $args = array() ) {
		_doing_it_wrong( "App_Bar_Admin::{$method}", __( 'Method does not exist.', 'app-bar' ), '1.0' );
		unset( $method, $args );
		
		return null;
	}
 	
 	/**
	 * @desc	Construct the plugin object
	 */
	public function __construct()
	{
		$this->app_bar_init_hooks();
	}

	public function app_bar_init_hooks() {
		// Hook for adding admin menus
 		add_action('admin_menu', array( $this, 'add_bar_admin_menu_page' ) );
	}

    public function add_bar_admin_menu_page() {
          
     	add_menu_page(
            __( 'Mobile User View', 'app-bar' ),
            __( 'WP App Bar', 'app-bar' ),
            'manage_options',
            'app-bar',
            array( $this, 'app_bar_html' ),
            'dashicons-menu'
        );
    }
 
    public function app_bar_html() {
     	include_once( APP_BAR_INC_PATH . '/admin/html-app-bar.php' );
    }
 	
}

endif;

/**
 * Returns the main instance of WP_App_Bar to prevent the need to use globals.
 *
 * @since  1.0
 * @return WP_Image_Embeds
 */
function App_Bar_Admin() {
	return App_Bar_Admin::instance();
}

// Global for backwards compatibility.
$GLOBALS['app_bar_admin'] = App_Bar_Admin();