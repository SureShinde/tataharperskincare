jQuery( document ).ready(function() {
  jQuery('a.sort-by').click(function(event) {
  	event.preventDefault();
		jQuery('.sort-by-menu').slideToggle();
	});

  jQuery('li.beauty-and-fashion, .sort-by-menu a.beauty-and-fashion').click(function(event) {
  	event.preventDefault();
  	jQuery('.sort-by-menu').hide();
		jQuery('.gal.main a').hide();
		jQuery('.gal.main a.beauty').show();
		jQuery('html, body').animate({
		    scrollTop: (jQuery('.gal').offset().top)
		},500);
	});

   jQuery('li.lifestyle,.sort-by-menu a.lifestyle').click(function(event) {
  	event.preventDefault();
  	jQuery('.sort-by-menu').hide();
		jQuery('.gal.main a').hide();
		jQuery('.gal.main a.lifestyle').show();
		jQuery('html, body').animate({
		    scrollTop: (jQuery('.gal').offset().top)
		},500);
	});

   jQuery('li.news, .sort-by-menu a.news').click(function(event) {
  	event.preventDefault();
  		jQuery('a.sort-by-menu').hide();
		jQuery('.gal.main a').hide();
		jQuery('.gal.main a.news').show();
		jQuery('html, body').animate({
		    scrollTop: (jQuery('.gal').offset().top)
		},500);	});

   jQuery('li.video, .sort-by-menu a.video').click(function(event) {
  	event.preventDefault();
  	jQuery('.sort-by-menu').hide();
		jQuery('.gal.main a').hide();
		jQuery('.gal.main a.video').show();
		jQuery('html, body').animate({
		    scrollTop: (jQuery('.gal').offset().top)
		},500);
	});


});

