	jQuery(document).ready(function() {
		jQuery("html").addClass("pinwheel_slider_fouc");
	   jQuery(".pinwheel_slider_fouc .pinwheel_slider").css({"display" : "block"});
	});
	
	jQuery(document).ready(function() {
		jQuery("#pinwheel_slider_1").pinwheel({
			animationEasing:"swing",
			carouselSpeed:1000,
			autoPlay: "0",rightButtonTag:   "#pinwheel_slider_1_next", leftButtonTag:   "#pinwheel_slider_1_prev",trackerIndividual:    false,trackerSummation:    false,
            preload: false,
			largeFeatureWidth:450,
			largeFeatureHeight:300,
			smallFeatureWidth:250,
			smallFeatureHeight:200,
			smallFeatureOffset:30,
			topPadding:0,
            sidePadding:40
	});
});