<?php

add_action( 'wp_ajax_app_bar_settings', 'app_bar_settings_callback' );
add_action( 'wp_ajax_nopriv_app_bar_settings', 'app_bar_settings_callback' );
/*
 *	@desc	Process theme contact
 */
function app_bar_settings_callback() {

	$html_text_field 		= '';
	$app_bar_feature 		= $_POST['app_bar_feature'];
	$app_bar_feature_number = $_POST['app_bar_feature_number'];

	switch( $app_bar_feature ) {
		case "bars";

			$menus = get_registered_nav_menus();
			if( $menus ) {

				$html_text_field = '<select name="app-bar-features['. $app_bar_feature_number .'][bars]">';
					foreach ( $menus as $location => $description ) {
						$html_text_field .= '<option value="'. $location .'">'. $description .'</option>'; // $location . ': ' . $description;
					}
				$html_text_field .= '</select>';
			}

		break;

		case "phone";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][phone]" placeholder="Enter your phone number" />';
		break;

		case "comment";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][comment]" placeholder="Enter your phone number" />';
		break;

		case "skype";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][skype]" placeholder="Enter your skype username" />';
		break;

		case "envelope-o";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][envelope-o]" placeholder="Enter your email address" />';
		break;

		case "map-marker";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][map-marker]" placeholder="Enter your address" />';
		break;

		case "instagram";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][instagram]" placeholder="http://" />';
		break;

		case "facebook";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][facebook]" placeholder="http://" />';
		break;

		case "twitter";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][twitter]" placeholder="http://" />';
		break;

		case "youtube";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][youtube]" placeholder="Enter youtube username." />';
		break;

		case "pinterest-p";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][pinterest-p]" placeholder="http://" />';
		break;

		case "soundcloud";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][soundcloud]" placeholder="http://" />';
		break;

		case "google-plus";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][google-plus]" placeholder="http://" />';
		break;

		case "yelp";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][yelp]" placeholder="http://" />';
		break;

		case "tripadvisor";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][tripadvisor]" placeholder="http://" />';
		break;

		case "cutlery";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][cutlery]" placeholder="http://" />';
		break;

		case "android";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][android]" placeholder="http://" />';
		break;

		case "apple";
			$html_text_field = '<input type="text" name="app-bar-features['. $app_bar_feature_number .'][apple]" placeholder="http://" />';
		break;

		default:
			$html_text_field = '';
		break;
	}

	echo $html_text_field;

	// return proper result
	die();

}