<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Check if class already exist
if( ! class_exists('App_Bar_Action')) :

/**
 * Main App Bar Action
 *
 * @class App_Bar_Action
 * @version	1.0
 */
final class App_Bar_Action {
 
    /**
	 * @var App_Bar_Action The single instance of the class
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
		_doing_it_wrong( "App_Bar_Action::{$method}", __( 'Method does not exist.', 'app-bar' ), '1.0' );
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
		add_action( 'wp_footer', array( $this, 'wp_add_bar_menu' ) );
	}

    /* Display Bar Menu */
	public function wp_add_bar_menu() {

		if ( in_array( 'wp-app-bar/wp-app-bar.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			// Okay great so the plugin is activated
			// Let check if it's enable in Admin area for display


			$app_bar_features_options = unserialize( get_option( 'app-bar-features' ) );
			
			/*
			echo '<pre>';
				print_r( $app_bar_features_options );
			echo '</pre>';
			*/
			
			if( $app_bar_features_options['enable-wp-app-bar'] )  {

				if( wp_is_mobile() ) {
					?>
					
					<!--Custom WP App Bar color-->
					<style>
						.wp-app-bar-wrapper,
						.wp-app-bar-wrapper ul.menu-item,
						.wp-app-bar-wrapper ul.share-item,
						.wp-app-bar-wrapper .search-item {
							background: <?php echo $app_bar_features_options['app-bar-color']; ?>;
						}
					</style>

					<div class="wp-app-bar-wrapper">
						
						<ul class="wp-app-bar-menu">
							<?php
								$detect 	= new Mobile_Detect;
								$sub_class 	= $url_prefix = '';

								// Remove unnecessary fields
								unset( $app_bar_features_options['app-bar-color'] );
								unset( $app_bar_features_options['enable-wp-app-bar'] );

								// remove empty spaces
								$app_bar_features_options = array_filter( $app_bar_features_options );

								if( $app_bar_features_options ) {
									foreach( $app_bar_features_options as $app_bar_features_option ) {

										// Two-Dimensional Array
										if( is_array( $app_bar_features_option ) ) {
											
											foreach( $app_bar_features_option as $key => $value ) {

												switch ( $key ) {
													case 'bars':
														$url_prefix = '#';
														$sub_class 	= 'data-action="has-sub"';
													break;

													case 'envelope-o':
														$url_prefix = 'mailto:';
														$sub_class = '';
													break;

													case 'phone':
														$url_prefix = 'tel:';
														$sub_class = '';
													break;

													case 'comment':
														$url_prefix = 'sms:';
														$sub_class = '';
													break;

													case 'skype':
														$url_prefix = 'skype:';
														$sub_class = '';
													break;

													case 'map-marker':
														// Check for a specific platform with the help of the magic methods:
														if( $detect->isiOS() ){
															$url_prefix = 'http://maps.apple.com/?q=';
														}

														if( $detect->isAndroidOS() ){
															$url_prefix = 'https://maps.google.com/?q=';
														}

														$sub_class = '';
													break;
													
													default:
														$url_prefix = $sub_class = '';
													break;
												}
												
												?>
													<li class="wp-app-bar-menu-item">
														<a href="<?php echo $url_prefix . $value; ?>" <?php echo $sub_class; ?>><i class="fa fa-<?php echo $key; ?>" aria-hidden="true"></i></a>
														
														<?php
															if( 'bars' == $key ) {
																wp_nav_menu( array( 
																	'theme_location' => $value,
																	'menu_class' 	 => 'menu-item animated',
																	'menu_id' 		 => $value,
																	'container' 	 => 'ul'
																) );
															}
														?>
													</li>
												<?php
											}

										}

										// Single-Dimensional Array
										else {

											switch ( $app_bar_features_option ) {
												case 'home':
													$url 		= home_url( '/' );
													$sub_class 	= '';
												break;

												case 'plus':
													$url 		= '#';
													$sub_class 	= 'data-action="bookmark" title="'. get_the_title() .'"';
												break;

												case 'search':
												case 'share-alt':
													$url 		= '#';
													$sub_class 	= 'data-action="has-sub"';
												break;

												default:
													$url = $sub_class = '';
												break;
											}

											?>
												<li class="wp-app-bar-menu-item">
													<a href="<?php echo $url; ?>" <?php echo $sub_class; ?>><i class="fa fa-<?php echo $app_bar_features_option; ?>" aria-hidden="true"></i></a>

													<?php if( 'search' == $app_bar_features_option ) { ?>
														<div class="search-item animated">
															<?php get_search_form(); ?>
														</div>
													<?php } ?>

													<?php if( 'share-alt' == $app_bar_features_option ) {

														if( is_front_page() ) {
															$site_name = get_bloginfo( 'name' );
															$site_link = get_bloginfo( 'url' );
														} else {
															$site_name = get_the_title();
															$site_link = get_permalink();
														}

														// Get media
														$image_id 	= get_post_thumbnail_id();
														$image_url 	= wp_get_attachment_image_src( $image_id );
														$media_url 	= $image_url[0];

														?>
														<ul class="share-item animated">
															<li><a href="http://www.facebook.com/share.php?u=<?php echo esc_url( $site_link ); ?>">Share on Facebook</a></li>
															<li><a href="http://twitter.com/home?status=<?php echo esc_attr( $site_name ) . ' ' . esc_url( $site_link ); ?>">Share on Twitter</a></li>
															<li><a href="https://plus.google.com/share?url=<?php echo esc_url( $site_link ); ?>">Share on Google Plus</a></li>
															<li><a href="http://www.tumblr.com/share/link?url=<?php echo esc_url( $site_link ); ?>">Share on Tumblr</a></li>
															<li><a href="http://reddit.com/submit?url=<?php echo esc_url( $site_link ); ?>&title=<?php echo esc_url( $site_name ); ?>">Share on Reddit</a></li>
															<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url( $site_link ); ?>&media=<?php echo esc_url( $media_url ); ?>">Share on Pinterest</a></li>
															<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( $site_link ); ?>&title=<?php echo esc_url( $site_name ); ?>">Share on LinkedIn</a></li>
															<li><a href="https://web.skype.com/share?url=<?php echo esc_url( $site_link ); ?>&source=<?php echo esc_attr( $site_name ); ?>">Share on Skype</a></li>														
														</ul>
													<?php } ?>
												</li>
											<?php

										}

									}
								}
							?>
						</ul>

					</div>
					
					<?php
				} // End wp_is_mobile()

			} // End check WP App Bar is enable in Settings

		}

	}
}

endif;

/**
 * Returns the main instance of WP_App_Bar to prevent the need to use globals.
 *
 * @since  1.0
 * @return WP_Image_Embeds
 */
function App_Bar_Action() {
	return App_Bar_Action::instance();
}

// Global for backwards compatibility.
$GLOBALS['app_bar_actions'] = App_Bar_Action();