<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class already exist
if( ! class_exists('App_Bar_Settings')) :

/**
 * Main App Bar Admin
 *
 * @class WP_App_Bar
 * @version	1.0
 */
final class App_Bar_Settings
{
	public $cls = '';
	public $msg = '';

	/**
	 * @var App_Bar_Settings The single instance of the class
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
		_doing_it_wrong( "App_Bar_Settings::{$method}", __( 'Method does not exist.', 'app-bar' ), '1.0' );
		unset( $method, $args );
		
		return null;
	}
 	
 	/**
	 * @desc	Construct the plugin object
	 */
	public function __construct()
	{
		if( ! isset($_POST['action'])) { 
			return false; 
		}

		if(isset( $_POST )) { 
			$p = $this->app_bar_add_slashes( $_POST ); 
		}
		
		switch( $p['action'] ) {
			case "app-bar-settings": 
				$this->app_bar_settings($p);
			break;

			default: break;
		}
	}

	public function app_bar_settings( $p ) {

		$app_bar_features = $p['app-bar-features'];

		if( empty( $app_bar_features ) ) {

			$this->cls 	= 'error';
			$this->msg = __( 'Field should be an empty set.', 'app-bar' );

		} else {

			/*echo '<pre>';
				print_r( $p );
			echo '</pre>';*/
			
			$app_bar_features_settings = serialize( $app_bar_features );

			$app_bar_features_options = get_option( 'app-bar-features' );
			if( $app_bar_features_options ) {
				update_option( 'app-bar-features', $app_bar_features_settings, 'yes' );
			} else {
				add_option( 'app-bar-features', $app_bar_features_settings, '', 'yes' );
			}

			$this->cls 	= 'updated';
			$this->msg = __( 'Settings saved.', 'app-bar' );

		}

	}
	
	public function messages()
	{
		if( ! empty( $this->msg ) ) {
			echo '<div id="setting-error-settings_updated" class="'. $this->cls .' settings-error notice is-dismissible"> 
				<p><strong>'. $this->msg .'</strong></p>

				<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>';		
		}
	}

	private function app_bar_add_slashes( $post )
	{
		foreach( $post as $key => $value ) {
			if( is_array( $value ) ) {
				$p[ $key ] = $this->app_bar_add_slashes( $value );
			} else {
				$p[ $key ] = addslashes( $value );
			}
		}
		
		return $p;
	}

}
endif;

/**
 * Returns the main instance of WP_App_Bar to prevent the need to use globals.
 *
 * @since  1.0
 * @return WP_Image_Embeds
 */
function App_Bar_Settings() {
	return App_Bar_Settings::instance();
}

// Global for backwards compatibility.
$GLOBALS['app_bar_settings'] = App_Bar_Settings();