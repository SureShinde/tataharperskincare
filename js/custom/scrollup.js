jQuery(document).ready(function() {
	if((!(jQuery("body").hasClass('checkout-onepage-index'))) && (!(jQuery("body").hasClass('cms-release'))))
	{
		jQuery("html, body").animate({scrollTop: 0});
    	return false;
	}
	else
	{
		// jQuery("html, body").animate({scrollTop: 0});
		// jQuery("button span span").click( function() {
		// 	jQuery("html, body").animate({scrollTop: 0});
		// });
	}
});