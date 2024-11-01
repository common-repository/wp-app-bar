/*
 * WP App Bar scripts
 */

jQuery(document).ready(function( $ ){

	$(".app-bar-features").each(function(){

		$(this).on("change", function(){

			var _this 				  	= $(this),
				app_bar_feature_value 	= $(this).find("option:selected").val(),
				contents				= {
					action: 					'app_bar_settings',
					nonce: 						$("#app_bar_form #wp_app_bar_options_nonce").val(),
					app_bar_feature: 			app_bar_feature_value,
					app_bar_feature_number: 	$(_this).attr('data-number')
				};

			$.post( ajaxurl, contents, function( data ) {

				$(_this).parents('tr').find('.feature-settings').html( data );

			});

			
			
		});

	});
	
});