jQuery(document).ready(function() { 
    jQuery('body').on('click', '#cboxContent .autoship-learnmore', function(event) {
        event.preventDefault();
        var display = jQuery("<div class='explainautoship'><img src='/skin/frontend/enterprise/default/images/autoship-popup.jpg' class='moreexpl-img' /><h1 class='green'>Never run out, always save.</h1><p>Our Replenishment Service automatically processes payment and shipping for your favorite products at the time interval of your choice, by keeping your credit card and shipping info on file - so you receive your prouducts when and where you want them, hassle-free. Plus, all replenishment orders are 10% off!</p><img src='/skin/frontend/enterprise/default/images/explainmdiag.jpg' class='aligncenter' style='margin-bottom:20px;' /><h2 class='green textaligncenter'>Safe & Secure</h2><p>Your credit card will only be charged when your orders ship, and your information is kept in a safe place.</p><h2 class='green textaligncenter'>Manage your preferences</h2><p>We want our Replenishment Service to make shopping for skincare quick and easy. You can cancel your Service at anytime by logging into your account <a href='/customer/account/' class='green'>here</a> and canceling your subscription. If you want to adjust your Replenishment cycle settings, our Customer Service team is here to help! Give us a call at our Vermont office and we will gladly make any changes to suit your skincare needs.</p><a href='#' class='go-back buttonfloatleft'>Return to Shop Now</a><a href='/autoship' target='_blank' class='greenbutton_generic buttonfloatright'>Learn More</a><p /></div>");
        jQuery('#cboxLoadedContent').fadeOut('slow', function() {
            if (!jQuery(".explainautoship").is('*'))
            {
                jQuery("#cboxContent").append(display);
            }
        });
    });

    jQuery('body').on('click', '#cboxContent a.go-back', function(event) {
        event.preventDefault();
        jQuery('.explainautoship').fadeOut('slow', function() {
            jQuery("#cboxLoadedContent").show();
            jQuery('.explainautoship').remove();
        });
    });

    jQuery('body').on('click', '#cboxClose', function(event) {
        jQuery('.explainautoship').remove();
    });

    jQuery('body').on('click', '#cboxOverlay', function(event) {
        jQuery('.explainautoship').remove();
    });

    jQuery('body').on('click', '.product-view .autoship-learnmore', function(event) {
        event.preventDefault();
        var coolhtml = jQuery("<div class='explainautoship'><img src='/skin/frontend/enterprise/default/images/autoship-popup.jpg' class='moreexpl-img' /><h1 class='green'>Never run out, always save.</h1><p>Our Replenishment Service automatically processes payment and shipping for your favorite products at the time interval of your choice, by keeping your credit card and shipping info on file - so you receive your prouducts when and where you want them, hassle-free. Plus, all replenishment orders are 10% off!</p><img src='/skin/frontend/enterprise/default/images/explainmdiag.jpg' class='aligncenter' style='margin-bottom:20px;' /><h2 class='green textaligncenter'>Safe & Secure</h2><p>Your credit card will only be charged when your orders ship, and your information is kept in a safe place.</p><h2 class='green textaligncenter'>Manage your preferences</h2><p>We want our Replenishment Service to make shopping for skincare quick and easy. You can cancel your Service at anytime by logging into your account <a href='/customer/account/' class='green'>here</a> and canceling your subscription. If you want to adjust your Replenishment cycle settings, our Customer Service team is here to help! Give us a call at our Vermont office and we will gladly make any changes to suit your skincare needs.</p><a href='/autoship' target='_blank' class='greenbutton_generic buttonfloatright'>Learn More</a><p /></div>");
        jQuery.colorbox({html:coolhtml, width:"550px", height:"520px"});
    });

    jQuery('body').on('click', '.supernaturalsignup', function(event) {
        event.preventDefault();
        var coolhtml = jQuery("<div class='nl_container'><div id='mc_embed_signup'><form action='http://tataharperskincare.us2.list-manage.com/subscribe/post?u=b9c21573823db4c79bb1b430d&amp;id=7b6452a332' method='post' id='mc-embedded-subscribe-form' name='mc-embedded-subscribe-form' class='validate' target='_blank' novalidate><div class='mc-field-group-1'><input type='text' value='' name='NAME' class='required' placeholder='your name*' id='mce-NAME' /></div><div class='mc-field-group-1'><input type='text' value='' name='EMAIL' class='required email' placeholder='email address*' id='mce-EMAIL' /></div><div class='mc-field-group-2'><input type='text' value='' name='STATE' class='required' placeholder='state*' id='mce-STATE' /></div><div class='mc-field-group-3'><input type='text' value='' name='MMERGE2' class='agebox' placeholder='age' id='mce-MMERGE2' /></div><input type='submit' value='' name='subscribe' id='mc-embedded-subscribe' class=''><div id='mce-responses' class='clear'><div class='response' id='mce-error-response' style='display:none'></div><div class='response' id='mce-success-response' style='display:none'></div></div><div class='clear'></div></form></div></div>");
        jQuery.colorbox({html:coolhtml, width:"500px", height:"420px"});
    });

    // Lightbox for home video popup
    jQuery('body').on('click', '.videopopup', function(event) {
        event.preventDefault();
        var coolhtml = jQuery('<iframe width="640" height="360" src="//www.youtube.com/embed/IogBd7RlmKM?autoplay=11" frameborder="0" allowfullscreen></iframe>');
        jQuery.colorbox({html:coolhtml, width:"640px", height:"360px"});
    });
    
    // Lightbox for featured text in top right
    jQuery('body').on('click', '.shippinginfobox', function(event) {
        event.preventDefault();
        var one = "<div class='popup shippinginfoboxdesc clearfix'>";
        var two = "<div class='minwidthright'><h1>US SHIPPING DETAILS</h1><ul><li><em>> 3 FREE</em> samples with every order.</li><li><em>> FREE</em> standard shipping on orders over $40*.</li><li><em>></em> $5 flat rate standard shipping available on orders under $40*.</li></ul><p class='vspacer italic'>All orders ship directly from our headquarters on our Organic farm in Vermont, where we create, formulate, and manufacture our entire line! We're proud to own each step of our products' journey - from seed to serum - all the way until their arrival at your door. Each product is made with the highest attention to quality and detail (and of course with lots of love) - enjoy!</p><p class='small'>*Free shipping &amp; $5 flat rate shipping offer excludes Canada and International orders.</p><p class='small'>11/29 Black Friday Shipping Deal: Free Shipping on all US orders</p><a href='#' class='shipdet-learnmore bottlink'>See all restrictions and other shipping options.</a></div>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
    });
    
    // Fade for button explaining shipping details in code directly above
    // copy this one
    jQuery('body').on('click', '#cboxContent .shipdet-learnmore', function(event) {
        event.preventDefault();
        var one = "<div class='popup shippol'>";
        var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
        jQuery('.popup.shippol').load('/shipping-special .generic_box_full>.std', function(){
            jQuery('.autoship_termsandconditions img').hide();
        });
    });          

    // Today's Offer - See Details
    jQuery('body').on('click', '.todaysoffer_hid .todaysoffer-seedetails', function(event) {
        event.preventDefault();
        var one = "<div class='popup shippinginfoboxdesc clearfix'>";
        var two = "<div class='minwidthright'><h1>US SHIPPING DETAILS</h1><ul><li><em>> 3 FREE</em> samples with every order.</li><li><em>> FREE</em> standard shipping on orders over $40*.</li><li><em>></em> $5 flat rate standard shipping available on orders under $40*.</li></ul><p class='vspacer italic'>All orders ship directly from our headquarters on our Organic farm in Vermont, where we create, formulate, and manufacture our entire line! We're proud to own each step of our products' journey - from seed to serum - all the way until their arrival at your door. Each product is made with the highest attention to quality and detail (and of course with lots of love) - enjoy!</p><p class='small'>*Free shipping &amp; $5 flat rate shipping offer excludes Canada and International orders.</p><p class='small'>11/29 Black Friday Shipping Deal: Free Shipping on all US orders</p><a href='#' class='shipdet-learnmore bottlink'>See all restrictions and other shipping options.</a></div>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
    });   


     // Today's Offer - Right
        jQuery('body').on('click', '.todaysoffer_hid .right', function(event) {
            event.preventDefault();
            var one = "<div class='popup todaysofferdetails'>";
            var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
            var three = "</div>";
            var coolhtml = jQuery(one + two + three);
            jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
            jQuery('.popup.todaysofferdetails').load('/todays-offer-details .generic_box_full>.std', function(){
                jQuery('.autoship_termsandconditions img').hide();
            });
        });   

    // four lightboxes for autoship landing page
    jQuery('body').on('click', '.returnandexchange', function(event) {
        event.preventDefault();
        var one = "<div class='popup returnandexchange'>";
        var two = "<h1>RETURN AND EXCHANGE POLICY</h1><h2>PRODUCTS ELIGIBLE FOR RETURN:</h2><p>Any retail product purchased on Tataharperskincare.com, received within the last 30 days, and more than 1/2 full.   Deluxe Sample Sets are not eligible for return or exchange.  If you wish to return or exchange an item purchased through Tata Harper Online, please follow the steps below.</p><p>1. Please include in your return package your name, email, shipping address, and phone number.If you are making an exchange and the total cost is more than the amount of your return, please include your payment information and the details of your exchange.<p>2. All returns should be addressed to:<br/><br/>Tata Harper Skincare<br/>Returns Department<br/>1135 Wooster Rd<br/>Whiting VT 05778</p><p>3. For your protection and to ensure prompt delivery, we recommend that you send your return via UPS or insured Parcel Post. We're sorry, return shipping fees are not refundable.</p><p>Your return will be processed promptly upon its arrival and all exchanges will be shipped via standard ground shipping. Processing and transit time for exchange packages is usually 7-10 business days from the time the exchange is received. Business days are Monday through Friday, excluding federal holidays within the United States. An email will be sent to confirm receipt and processing of your return or exchange request.</p><p>Please note: Only products purchased at Tata Harper Skincare Online may be returned for refund or exchange.</p><p>If you have questions about returns or exchanges, please contact us by phone at 1-877-321-TATA (8282) or info@tataharper.com</p>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"420px"});
    });

    jQuery('body').on('click', '.shippingpolicy', function(event) {
        event.preventDefault();
        var one = "<div class='popup shippingpolicy'>";
        var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
        jQuery('.popup.shippingpolicy').load('/shipping-special .generic_box_full', function(){
            jQuery('.popup.shippingpolicy img').hide();
        });
    });

    jQuery('body').on('click', '.salestax', function(event) {
        event.preventDefault();
        var one = "<div class='popup salestax'>";
        var two = "<h1>SALES TAX</h1><p>We are required to charge sales tax in the following states: California, New York, South Carolina, and Vermont.</p><p>Duties and Taxes may apply with international shipments.</p>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"420px"});
    });

    jQuery('body').on('click', '.termsandconditions', function(event) {
        event.preventDefault();
        var one = "<div class='popup termsandconditions'>";
        var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"420px"});
        jQuery('.popup.termsandconditions').load('/privacy-policy-terms-conditions .generic_box_full', function(){
            jQuery('.autoship_termsandconditions img').hide();
        });
    });

    jQuery(".autoship_salestax").ajaxStart(function(){
        jQuery(this).show();
    }).ajaxStop(function(){
        jQuery(this).hide();
    });

    jQuery('.cms-press-awards').on('click', 'a.color-press', function(event) {
        event.preventDefault();
        var holo = jQuery(this).attr("href");
        var one = '<img src="'+holo+'" />';
        jQuery.colorbox({html:one, width: "600px", height:"630px"});
    });

    jQuery('.catalog-product-view').on('click', 'a.color-press', function(event) {
        event.preventDefault();
        var link = jQuery(this).attr("href");
        var html = '<img class="prod-press-img" src="'+link+'" />';
        var share = '<!-- AddThis Button BEGIN --><div class="addthis_toolbox addthis_default_style addthis_32x32_style"><a class="addthis_button_preferred_1"></a><a class="addthis_button_preferred_2"></a><a class="addthis_button_preferred_3"></a><a class="addthis_button_preferred_4"></a><a class="addthis_button_compact"></a><a class="addthis_counter addthis_bubble_style"></a></div><script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script><!-- AddThis Button END -->';
        var html = html + '<div class="prod-press-share">' + share + '</div>';
        jQuery.colorbox({html:html, width: "484px", height:"630px;"});

        getPressAdd();

        jQuery('img.prod-press-img')
            .wrap('<span style="display:inline-block"></span>')
            .css('display', 'block')
            .parent()
            .zoom();
    });

    // Lightbox for featured text in top right
    jQuery('body').on('click', '.blog-contest-rules', function(event) {
        event.preventDefault();
        var one = "<div class='popup blogcontestrules'>";
        var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
        jQuery('.blogcontestrules').load('/blog-contest-rules .col-main>.std', function(){
            jQuery('.blogcontestrules img').hide();
        });

    });

});

    jQuery('body').on('click', '.faq', function(event) {
        event.preventDefault();
        var one = "<div class='popup editionsfaq'>";
        var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({className: 'faq-editions', html:coolhtml, width:"960px", height:"523px"});
        jQuery('.popup.editionsfaq').load('/editions-faq .generic_box_full>.std', function(){
            jQuery('.editionsfaq img').hide();
        });
    });


function getPressAdd() {
    var addthis_url = "http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53398a37470e46be";
    if (window.addthis) {
        window.addthis = null;
        window._adr = null;
        window._atc = null;
        window._atd = null;
        window._ate = null;
        window._atr = null;
        window._atw = null
    }
    jQuery.getScript(addthis_url)
}

function egiftTOC() {
    // Popup for e-gift card product details page TOC
    var one = "<div class='popup egift-toc-popup'>";
    var two = "<img src='http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/loadingloading.gif'/>";
    var three = "</div>";
    var coolhtml = jQuery(one + two + three);
    jQuery.colorbox({html:coolhtml, width:"500px", height:"523px"});
    jQuery('.popup.egift-toc-popup').load('/egift-toc .col-main>.std', function(){
        jQuery('.egift-toc img').hide();
    });
}