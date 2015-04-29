/*
 * Contains Today's Offer, What's Fresh, Header Email Signup, Footer Email Signup, and Lightbox Signup
 */

// jQuery(document).ready(function(jQuery) {
  jQuery(window).load(function($) {

    var offer = false;
    var fresh = false;

     jQuery('.todaysoffer').click(function () {
            if (offer == false) {
                hideFresh();
                jQuery('.todaysoffer').addClass( "bg_greensplat" );
                jQuery('.todaysoffer_hid').slideDown('slow');
                offer = true;
            } else {
                hideOffer();
            }
        });

        jQuery('.whatsfresh').click(function () {
            if (fresh == false) {
                hideOffer();
                jQuery('.whatsfresh').addClass( "bg_greensplat" );
                jQuery('.whatsfresh_hid').slideDown('slow');
                fresh = true;
            } else {
                hideFresh();
            }
        });

        function hideOffer() {
            if (offer == true)
            {
                jQuery('.todaysoffer_hid').slideUp('slow');
                jQuery('.todaysoffer').removeClass( "bg_greensplat" );
                offer = false;
            }
        }

        function hideFresh() {
            if (fresh == true)
            {
                jQuery('.whatsfresh_hid').slideUp('slow');
                jQuery('.whatsfresh').removeClass( "bg_greensplat" );
                fresh = false;
            }
    }

     jQuery(".home_signup_lightbox_top #mc-embedded-subscribe").click(function() {

            if (!validateEmailHomeTop())
              return false;

            var url = "/custom_includes/home_email_signup.php"; // the script where you handle the form input.

            jQuery.ajax({
                   type: "POST",
                   url: url,
                   data: jQuery("#home_signup_form_top").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       var output = '<em>' + data + '</em>';
                       jQuery('.home_signup_lightbox_top .response').html(output); // show response from the php script.
                   }
                 });

            jQuery("#home_signup_form_top input").attr('disabled', 'disabled');
            return false; // avoid to execute the actual submit of the form.
        });

        jQuery(".home_signup_lightbox_bottom #mc-embedded-subscribe").click(function() {

            if (!validateEmailHomeBottom())
              return false;

            var url = "/custom_includes/home_email_signup.php"; // the script where you handle the form input.

            jQuery.ajax({
                   type: "POST",
                   url: url,
                   data: jQuery("#home_signup_form_bottom").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       var output = '<em>' + data + '</em>';
                       jQuery('.home_signup_lightbox_bottom .response').html(output); // show response from the php script.
                   }
                 });

            jQuery("#home_signup_form_bottom input").attr('disabled', 'disabled');
            return false; // avoid to execute the actual submit of the form.
        });

        function validateEmailHomeTop() { 
            var email = jQuery('.home_signup_form_top').find('input.email').val();

            var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

            if (re.test(email))
              return true;
            else
            {
                jQuery('.home_signup_lightbox_top .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
                return false;
            }
        } 

        function validateEmailHomeBottom() { 
            var email = jQuery('.home_signup_form_bottom').find('input.email').val();

            var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

            if (re.test(email))
              return true;
            else
            {
                jQuery('.home_signup_lightbox_bottom .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
                return false;
            }
        } 

        // $.cookie('frontend', 'value', { expires: 7, path: '/' });

        if (jQuery.cookie('20080521') != '1') {

            if(!(jQuery( "body" ).hasClass( "cms-manufacturing" ))) {
              //non-holiday version // var coolhtml = "<div class='home_email_popup'><img src='http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox1.jpg' /><span class='tata-harper-founder'>Tata Harper, Founder</span><div class='home_signup_lightbox'> <form id='home_signup_form' action='/custom_includes/home_email_signup.php' method='post' name='home-email-form' class='validate home_signup_form' target='_blank'> <input type='text' value='' name='email' class='required email' placeholder='email address*' /> <input type='submit' value='Submit' name='subscribe' id='mc-embedded-subscribe' class='' /><p class='response'></p></form></div><div class='priv_right'><a href='privacy-policy-terms-conditions/' target='_blank'>Privacy Policy</a></div></div>";
              var coolhtml = "<div class='home_email_popup'><img src='http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox1.jpg' /><div class='home_signup_lightbox'> <form id='home_signup_form' action='/custom_includes/home_email_signup.php' method='post' name='home-email-form' class='validate home_signup_form' target='_blank'> <input type='text' value='' name='email' class='required email' placeholder='email address*' /> <input type='submit' value='subscribe' name='subscribe' id='mc-embedded-subscribe' class='' /></form></div><p class='response'></p><div class='priv_right'><a href='privacy-policy-terms-conditions/' target='_blank'>By subscribing I agree to Tata Harper Terms & Conditions</a></div></div>";
              jQuery.colorbox({html:coolhtml, width:"930px", height:"560px"});

              jQuery.cookie('20080521', '1', {expires: 365});
            }
            
        }

         jQuery(".home_signup_lightbox #mc-embedded-subscribe").click(function() {

            if (!validateEmailHome())
              return false;

            var url = "/custom_includes/home_email_signup.php"; // the script where you handle the form input.
            jQuery('.home_signup_lightbox, .priv_right').hide();
            jQuery('.response').show();
            // jQuery('.home_email_popup img').attr('src', 'http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox2.jpg');

            jQuery.ajax({
                   type: "POST",
                   url: url,
                   data: jQuery("#home_signup_form").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       var output = '<em>' + data + '</em>';
                       jQuery('.response').html(output); // show response from the php script.
                       console.log(output);
                       
                       setTimeout(function(){
                           jQuery(window).colorbox.close();
                        }, 5000);
                   }
                 });

            jQuery("#home_signup_form input").attr('disabled', 'disabled');
            return false; // avoid to execute the actual submit of the form.
        });

        function validateEmailHome() { 
            var email = jQuery('.home_signup_form').find('input.email').val();

            var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

            if (re.test(email))
              return true;
            else
            {
                jQuery('.home_signup_lightbox .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
                return false;
            }
        } 

});