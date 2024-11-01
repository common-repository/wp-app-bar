jQuery(document).ready(function($) {

	$(".wp-app-bar-menu a").each(function(){

		$(this).click(function(e){

			var href 	= $(this).attr('href'),
				action 	= $(this).attr('data-action');

			if( 'has-sub' == action ) {

				// Hide any displayed Sub
				$(this).parent('li').siblings('li').find('.fadeInUp').removeClass('fadeInUp block');

				if( $(this).next().hasClass('block') ) {
					$(this).next().removeClass('fadeInUp block');
				} else {
					$(this).next().addClass( 'fadeInUp block' );
				}

			} else if( 'bookmark' == action ) {

				// Show Bookmark button
				var addtohome = addToHomescreen({
				   autostart: false
				});
				
				addtohome.show();

			} else {
				window.location = href;
			}

			e.preventDefault();
		});

	});

});