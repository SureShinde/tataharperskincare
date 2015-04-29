jQuery(window).bind("load", function() {
  
   var url;
    jQuery("span.group3").colorbox({
        rel:'group3',
        transition:"none",
        width:"69%",
        height:"85%",
        title: function() {
            url = jQuery(this).attr("href");
            var title = jQuery(this).attr("title");
            var facebook = '<iframe src="//www.facebook.com/plugins/like.php?href='+url+'&amp;width=120&amp;layout=button_count&amp;action=like&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=280118368808735" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;" class="fb-like" allowTransparency="true"></iframe>';
            var pinterest = '<a href="//www.pinterest.com/pin/create/button/?url='+url+'&media='+url+'&description=Next%20stop%3A%20Pinterest" data-pin-do="buttonPin" data-pin-shape="round" data-pin-height="28" class="pinte_pos"><img src="http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/pinbutton.png" /></a>';
            var addthis = '<div class="addthis_toolbox addthis_default_style addthis_32x32_style"><a class="addthis_button_preferred_1"></a><a class="addthis_button_preferred_2"></a><a class="addthis_button_preferred_3"></a><a class="addthis_button_preferred_4"></a><a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a></div>';
            var addthisstuff = '<div class="shareright"><a id="atbutton"></a></div>';

            return '<span id="cboxTitleLeft">'+title+'</span><span id="cboxGplus"></span>'+facebook+pinterest+addthisstuff;
        },
        onComplete: function() {
            var permalink = jQuery(this).attr("data-permalink");
            gapi.plusone.render("cboxGplus", {"size": "small", "count": "true", "href": permalink});
            
            var addthis_ui_config = { services_compact: 'facebook, myspace, igoogle, netvibes, windows, dashboard, more' }
            var newsharecode = 
            {
                url: "http://www.tataharperskincare.com/tatas-world",
                title: "http://www.tataharperskincare.com/tatas-world",
                description: "",
                width: "560",
                height: "340",
                screenshot: url
            }

            addthis.button("#atbutton", addthis_ui_config, newsharecode);
       }
    });

    jQuery('.generic_box_full').ajaxComplete(function(event, request, settings){

        if(request.responseText.match(/gallery-lightbox/i)){
            window.addthis.ost = 0;
            window.addthis.ready();
            }
        });

});