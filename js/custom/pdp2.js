/* Code for PDP2 */
// jQuery(window).bind("load", function() {

jQuery(window).bind("load", function() {

	jQuery(function() {
        jQuery("#tabs.beta-top" ).tabs();
        jQuery("#tabs.beta-bottom" ).tabs();
    });

	// Video CTA
    jQuery("span.youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
    jQuery("span.vimeo").colorbox({iframe:true, innerWidth:640, innerHeight:390});

    jQuery('.revision .click-to-zoom').click(function() {
    	var imgurl = jQuery(this).parent().find('a.group3').attr('href');
    	var coolhtml = '<img src="' + imgurl + '" />';
    	jQuery.colorbox({html:coolhtml, width:"45%", height:"85%"});
    });

    // Questions & Answers
    jQuery('.revision .questions .question .question-text').addClass('arrowup');

    jQuery( ".revision .questions .question .question-text" ).click(function() {

            jQuery('.arrowup').toggleClass('arrowdown');
            jQuery(this).parent().find( ".answers" ).slideToggle( "200" );
            event.preventDefault();
    });

    if (jQuery('.revision .more-views ul li').length <= 1) {
        jQuery('.revision .more-views').remove();
        jQuery('.revision .alt-images').remove();
    }

});

jQuery(window).bind("load", function() {
        jQuery('#tabs.beta-top').tabs();
        jQuery('#tabs.beta-bottom').tabs();

        // Product images
        jQuery("a.gallery").colorbox({rel:'group1',width:700,height:700});

        // jQuery(".super-attribute-select" ).change(function() {
        //   var optval = jQuery(".super-attribute-select" ).val();
        //   var origprice = jQuery('.regular-price .price').data('origprice');
        //   var newprice;

        //   if (optval != 30) {
        //     newprice = origprice * .9;
        //     newprice = newprice.toFixed(2);
        //     jQuery('.regular-price .price').text('$' + newprice);
        //   } else {
        //     jQuery('.regular-price .price').text('$' + origprice);
        //   }

        // });
});

jQuery(window).load(function() {
    jQuery("html").addClass("pinwheel_slider_fouc");
   jQuery(".pinwheel_slider_fouc .pinwheel_slider").css({"display" : "block"});
});
    
jQuery(window).load(function() {
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