<?php
/**
 * Plugin Name: WP App Bar
 * Plugin URI: http://wpdevshed.com/
 * Description: WP App Bar adds a row of simple app like buttons across the bottom of all pages on your mobile site so you can offer visitors quick access to features such as calling, directions or mobile friendly share functions.
 * Version: 1.5
 * Author: WP Dev Shed
 * Author URI: http://wpdevshed.com/
 * Requires at least: 4.1
 * Tested up to: 4.4
 * License: GPL2
 *
 * Text Domain: app-bar
 * Domain Path: /languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class already exist
if( ! class_exists('WP_App_Bar')) :

/**
 * Main WP App Bar
 *
 * @class WP_App_Bar
 * @version	1.0
 */
final class WP_App_Bar {
	
	/**
	 * @var WP_App_Bar The single instance of the class
	 * @since 2.1
	 */
	protected static $_instance = null;
	
	/**
	 * Main WP_App_Bar Instance
	 *
	 * Ensures only one instance of WP_App_Bar is loaded or can be loaded.
	 *
	 * @since 2.1
	 * @static
	 * @see WC()
	 * @return WP_App_Bar - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
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
		_doing_it_wrong( "WP_Image_Embeds::{$method}", __( 'Method does not exist.', 'app-bar' ), '1.0' );
		unset( $method, $args );
		
		return null;
	}
	
	/**
	 * @desc	Construct the plugin object
	 */
	public function __construct()
	{
		$this->app_bar_define_constants();
		$this->app_bar_includes();
		$this->app_bar_init_hooks();
	}
	
	/**
	 * Define Constants
	 */
	private function app_bar_define_constants() {
		$this->app_bar_define( 'APP_BAR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
		$this->app_bar_define( 'APP_BAR_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		$this->app_bar_define( 'APP_BAR_CSS_DIR', APP_BAR_PLUGIN_URL .'assets/css' );
		$this->app_bar_define( 'APP_BAR_JS_DIR', APP_BAR_PLUGIN_URL .'assets/js' );
		$this->app_bar_define( 'APP_BAR_INC_PATH', APP_BAR_PLUGIN_PATH .'includes' );
	}
	
	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function app_bar_define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
	
	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function app_bar_includes() {
		include_once( 'includes/class-app-bar-actions.php' );
		include_once( 'includes/class-app-bar-settings.php' );

		// detect mobile agent
		include_once( 'includes/class-mobile-detect.php' );
			
		// Admin
		include_once( 'includes/admin/class-app-bar-actions.php' );
		include_once( 'includes/admin/ajax-app-bar.php' );
	}
	
	
	/**
	 * Hook into actions and filters
	 * @since  1.0
	 */
	private function app_bar_init_hooks() {
		// Init classes

		// Actions
		add_action( 'init', array( $this, 'app_bar_init' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'app_bar_enqueue_styles_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'app_bar_admin_enqueue_styles_scripts' ) );
	}
	
	
	public function app_bar_init() {

		/* Front-end */
		// Style
		wp_register_style( 'app-bar-style', APP_BAR_CSS_DIR . '/app-bar.css', false, '1.0', 'all' );
		wp_register_style( 'app-bar-font-awesome-style', APP_BAR_CSS_DIR . '/font-awesome.min.css', false, '4.6.1', 'all' );
		wp_register_style( 'app-bar-animate-style', APP_BAR_CSS_DIR . '/animate.css', false, '3.5.1', 'all' );

		// ATH
		wp_register_style( 'app-bar-addtohomescreen-style', APP_BAR_CSS_DIR . '/addtohomescreen.css', false, '06122016', 'all' );
		
		// Scripts
		wp_register_script( 'app-bar-script', APP_BAR_JS_DIR . '/scripts.js' , ('jquery'), '08062016', true );

		wp_register_script( 'app-bar-ath-script', APP_BAR_JS_DIR . '/addtohomescreen.min.js' , ('jquery'), '06122016', true );


		/* Admin */

		// Style
		wp_register_style( 'app-bar-admin-style', APP_BAR_CSS_DIR . '/admin/style.css', false, '1.0', 'all' );

		// Scripts
		wp_register_script( 'app-bar-admin-script', APP_BAR_JS_DIR . '/admin/scripts.js' , ('jquery'), '08062016', true );
		wp_register_script( 'app-bar-admin-ajax-script', APP_BAR_JS_DIR . '/admin/ajax-app-bar.js' , ('jquery'), '06112016', true );
		
		
	}
	
	public function app_bar_enqueue_styles_scripts() {
		
		// Style
		wp_enqueue_style( 'app-bar-style' );
		wp_enqueue_style( 'app-bar-font-awesome-style' );
		wp_enqueue_style( 'app-bar-animate-style' );

		wp_enqueue_style( 'app-bar-addtohomescreen-style' );
		
		// Scripts
		wp_enqueue_script( 'app-bar-ath-script' );
		
		wp_enqueue_script( 'app-bar-script' );

	}
	
	public function app_bar_admin_enqueue_styles_scripts() {

		// Style
		wp_enqueue_style( 'app-bar-admin-style' );
		wp_enqueue_style('wp-color-picker');
		
		// Scripts
		wp_enqueue_script( 'app-bar-admin-script' );
		wp_enqueue_script( 'app-bar-admin-ajax-script' );
		wp_enqueue_script( 'iris' );
	}

}
	
endif;

/**
 * Returns the main instance of WP_App_Bar to prevent the need to use globals.
 *
 * @since  1.0
 * @return WP_Image_Embeds
 */
function App_Bar() {
	return WP_App_Bar::instance();
}

// Global for backwards compatibility.
$GLOBALS['app_bar'] = App_Bar();