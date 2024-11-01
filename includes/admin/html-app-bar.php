<div class="wp-app-bar-settings">
	<div class="wrap">
		<h1><?php _e( 'WP App Bar', 'app-bar' ); ?></h1>

		<?php
			global $app_bar_settings;

			$app_bar_settings->messages();


			// Get App Bar options
			$app_bar_features_options = unserialize( get_option( 'app-bar-features' ) );
		?>

		<form method="post" novalidate="novalidate" id="app_bar_form">
			<input type="hidden" name="action" value="app-bar-settings">
		 	<?php wp_nonce_field( 'wp_app_bar_options_action', 'wp_app_bar_options_nonce' ); ?>

			<table class="form-table">
				<tbody>
					<tr>
						<td colspan="3" class="pl0">
							<label><input type="checkbox" name="app-bar-features[enable-wp-app-bar]" value="on" <?php checked( $app_bar_features_options['enable-wp-app-bar'], 'on' ); ?> /> Enable </label>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="pl0">
							<label for="app_bar_color"><strong>App Bar Color</strong></label>
							<p><input type="text" name="app-bar-features[app-bar-color]" id="app_bar_color" value="<?php echo $app_bar_features_options['app-bar-color']; ?>" /></p>
						</td>
					</tr>
					
					<tr>
						<td width="2%">&nbsp;</td>
						<td width="20%"><h4>Choose App Bar Features</h4></td>
						<td width="78%"><h4>Feature Settings</h4></td>
					</tr>

					<!-- Display up to five bar -->
					<?php
					if( $app_bar_features_options ) {
						
						// Remove unnecessary fields
						unset( $app_bar_features_options['app-bar-color'] );
						unset( $app_bar_features_options['enable-wp-app-bar'] );

						foreach( $app_bar_features_options as $app_bar_features_option ) {

							$active_key 	= $app_bar_features_option;
							$active_value 	= $app_bar_features_option;

							if( is_array( $app_bar_features_option ) ) {
								foreach( $app_bar_features_option as $key => $value ) {
									$active_key 	= $key;
									$active_value	= $value;
								}
							}

							$keys[] 	= $active_key;
							$values[] 	= $active_value;

						}
					}

					for( $i = 0; $i < 5; $i++ ) {
						$active_key_id 	= $i;
						?>
						
						<tr>
							<td><?php echo $i + 1; ?></td>
							<td>
								<select name="app-bar-features[<?php echo $i; ?>]" class="app-bar-features" data-number="<?php echo $i; ?>">
									<option value="">Select</option>
									<option value="home" <?php selected( $keys[$active_key_id], 'home' ); ?>>Home</option>
									<option value="search" <?php selected( $keys[$active_key_id], 'search' ); ?>>Search </option>
									<option value="bars" <?php selected( $keys[$active_key_id], 'bars' ); ?>>Custom Menu</option>
									<option value="share-alt" <?php selected( $keys[$active_key_id], 'share-alt' ); ?>>Share</option>
									<option value="plus" <?php selected( $keys[$active_key_id], 'plus' ); ?>>Add to home screen</option>
									<option value="phone" <?php selected( $keys[$active_key_id], 'phone' ); ?>>Phone</option>
									<option value="comment" <?php selected( $keys[$active_key_id], 'comment' ); ?>>SMS</option>
									<option value="skype" <?php selected( $keys[$active_key_id], 'skype' ); ?>>Skype</option>
									<option value="envelope-o" <?php selected( $keys[$active_key_id], 'envelope-o' ); ?>>Email</option>
									<option value="map-marker" <?php selected( $keys[$active_key_id], 'map-marker' ); ?>>Directions</option>
									<option value="instagram" <?php selected( $keys[$active_key_id], 'instagram' ); ?>>Instagram </option>
									<option value="facebook" <?php selected( $keys[$active_key_id], 'facebook' ); ?>>Facebook</option>
									<option value="twitter" <?php selected( $keys[$active_key_id], 'twitter' ); ?>>Twitter</option>
									<option value="youtube" <?php selected( $keys[$active_key_id], 'youtube' ); ?>>Youtube</option>
									<option value="pinterest-p" <?php selected( $keys[$active_key_id], 'pinterest-p' ); ?>>Pinterest</option>
									<option value="soundcloud" <?php selected( $keys[$active_key_id], 'soundcloud' ); ?>>Soundcloud</option>
									<option value="google-plus" <?php selected( $keys[$active_key_id], 'google-plus' ); ?>>Google+</option>
									<option value="yelp" <?php selected( $keys[$active_key_id], 'yelp' ); ?>>Yelp</option>
									<option value="tripadvisor" <?php selected( $keys[$active_key_id], 'tripadvisor' ); ?>>Tripadvisor</option>
									<option value="cutlery" <?php selected( $keys[$active_key_id], 'cutlery' ); ?>>Menu</option>
									<option value="android" <?php selected( $keys[$active_key_id], 'android' ); ?>>Android</option>
									<option value="apple" <?php selected( $keys[$active_key_id], 'apple' ); ?>>Apple</option>
								</select>
							</td>
							<td class="feature-settings">
								<?php
									switch ( $keys[$active_key_id] ) {
										case "bars";

											$menus = get_registered_nav_menus();
											if( $menus ) {

												$html_text_field = '<select name="app-bar-features['. $i .'][bars]">';
													foreach ( $menus as $location => $description ) {
														$html_text_field .= '<option value="'. $location .'" '. selected( $values[$active_key_id], $location, false ) .'>'. $description .'</option>'; // $location . ': ' . $description;
													}
												$html_text_field .= '</select>';
											}
											
										break;

										case "phone";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][phone]" value="'. $values[$active_key_id] .'" />';
										break;

										case "comment";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][comment]" value="'. $values[$active_key_id] .'" />';
										break;

										case "skype";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][skype]" value="'. $values[$active_key_id] .'" />';
										break;

										case "envelope-o";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][envelope-o]" value="'. $values[$active_key_id] .'" />';
										break;

										case "map-marker";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][map-marker]" value="'. $values[$active_key_id] .'" />';
										break;

										case "instagram";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][instagram]" value="'. $values[$active_key_id] .'" />';
										break;

										case "facebook";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][facebook]" value="'. $values[$active_key_id] .'" />';
										break;

										case "twitter";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][twitter]" value="'. $values[$active_key_id] .'" />';
										break;

										case "youtube";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][youtube]" value="'. $values[$active_key_id] .'" />';
										break;

										case "pinterest-p";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][pinterest-p]" value="'. $values[$active_key_id] .'" />';
										break;

										case "soundcloud";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][soundcloud]" value="'. $values[$active_key_id] .'" />';
										break;

										case "google-plus";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][google-plus]" value="'. $values[$active_key_id] .'" />';
										break;

										case "yelp";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][yelp]" value="'. $values[$active_key_id] .'" />';
										break;

										case "tripadvisor";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][tripadvisor]" value="'. $values[$active_key_id] .'" />';
										break;

										case "cutlery";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][cutlery]" value="'. $values[$active_key_id] .'" />';
										break;
										
										case "android";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][android]" value="'. $values[$active_key_id] .'" />';
										break;

										case "apple";
											$html_text_field = '<input type="text" name="app-bar-features['. $i .'][apple]" value="'. $values[$active_key_id] .'" />';
										break;

										default:
											$html_text_field = '';
										break;
									}

									echo $html_text_field;
								?>
							</td>
						</tr>

					<?php } ?>

				</tbody>
			</table>


			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Settings">
			</p>
		</form>

	</div>
</div>