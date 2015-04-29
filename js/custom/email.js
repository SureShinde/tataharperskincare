jQuery(document).ready(function() { 
            // bind 'myForm' and provide a simple callback function 
            jQuery('#faqEmailForm').ajaxForm(function() { 
            	jQuery('#faqEmailForm').hide();
            	jQuery('#faqEmail').append("<p class='bold'>Thanks for submitting your comment!");
                //alert("Your comment/question has been received!"); 
            }); 
});

jQuery("table#storesTable").on({
  mouseenter: function(){
    jQuery(this).css("background","yellow");
  },
  mouseleave: function(){
    jQuery(this).css("background","yellow");
  }
}, "tr");  // descendant selector

// Email signup popup on homepage
jQuery(document).ready(function() { 
    if (jQuery.cookie('20080522') != '1') {

        if(!(jQuery( "body" ).hasClass( "cms-manufacturing" ))) {
          //non-holiday version // var coolhtml = "<div class='home_email_popup'><img src='http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox1.jpg' /><span class='tata-harper-founder'>Tata Harper, Founder</span><div class='home_signup_lightbox'> <form id='home_signup_form' action='/custom_includes/home_email_signup.php' method='post' name='home-email-form' class='validate home_signup_form' target='_blank'> <input type='text' value='' name='email' class='required email' placeholder='email address*' /> <input type='submit' value='Submit' name='subscribe' id='mc-embedded-subscribe' class='' /><p class='response'></p></form></div><div class='priv_right'><a href='privacy-policy-terms-conditions/' target='_blank'>Privacy Policy</a></div></div>";
          var coolhtml = "<div class='home_email_popup test'><img src='http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox1.jpg' /><div class='home_signup_lightbox'> <form id='home_signup_form' action='/custom_includes/home_email_signup.php' method='post' name='home-email-form' class='validate home_signup_form' target='_blank'> <input type='text' value='' name='email' class='required email' placeholder='email address*' /> <input type='submit' value='subscribe' name='subscribe' id='mc-embedded-subscribe' class='' /></form></div><p class='response'></p><div class='priv_right'><a href='privacy-policy-terms-conditions/' target='_blank'>By subscribing I agree to Tata Harper Terms & Conditions</a></div></div>";
          jQuery.colorbox({html:coolhtml, width:"930px", height:"560px"});

          jQuery.cookie('20080522', '1', {expires: 365});
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

    jQuery(".video-email-signup #mc-embedded-subscribe").click(function() {

        if (!validateVideoEmail())
          return false;

        var url = "/custom_includes/home_email_signup.php"; // the script where you handle the form input.

        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery("#video-email-signup").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = '<em>' + data + '</em>';
                   jQuery('.get-email-updates .response').html(output); // show response from the php script.
               }
             });

        jQuery("#video-email-signup-form input").attr('disabled', 'disabled');
        return false; // avoid to execute the actual submit of the form.
    });

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

    jQuery("#sweepstakes-form #mc-embedded-subscribe").click(function() {
      if (!validateEmailSweeps())
          return false;

        var url = "../custom_includes/blogcontest_email_signup.php"; // the script where you handle the form input.

        jQuery.ajax({
           type: "POST",
           url: url,
           data: jQuery("#sweepstakes-form").serialize(), // serializes the form's elements.
           success: function(data)
           {
               var output = '<em>' + data + '</em>';
               jQuery('#sweepstakes-form .response').html(output); // show response from the php script.
           }
         });

        // jQuery("#sweepstakes-form input").attr('disabled', 'disabled');

        return false;

    });

    jQuery("#blogcontest_signup_form #mc-embedded-subscribe").click(function() {

        if (!validateEmailBlogContest())
          return false;

        var url = "../custom_includes/blogcontest_email_signup.php"; // the script where you handle the form input.

        // jQuery(".blog_contest_img").html("<img src='http://tataharperskincare.com/skin/frontend/enterprise/default/images/blogcontest/blog_landing_top.jpg' alt='blog_contest_btm' />");
        jQuery('.blog_contest_img img').attr('src', '../skin/frontend/enterprise/default/images/blogcontest/blog_landing_bottom.jpg');
        // jQuery('.blog_contest_img').append("<div class='cta_buttons'></div>");
        // jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/rejuvenating-serum-50ml/'><img src='../skin/frontend/enterprise/default/images/blogcontest/button_left.png' class='button_left' /></a>");
        // jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/shop-best-sellers/'><img src='../skin/frontend/enterprise/default/images/blogcontest/button_middle.png' class='button_middle' /></a>");
        // jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/natural-skincare-try-me-kit'><img src='../skin/frontend/enterprise/default/images/blogcontest/button_right.png' class='button_right' /></a>");
        // jQuery('.byentering').hide();
        postpone(updateAssets);
        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery("#blogcontest_signup_form").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = '<em>' + data + '</em>';
                   jQuery('#blogcontest_signup_form .response').html(output); // show response from the php script.
                   // jQuery('.enteremailhere').hide();
               }
             });

        jQuery("#blogcontest_signup_form input").attr('disabled', 'disabled');

        // jQuery("#blogcontest_signup_form").hide();

        return false; // avoid to execute the actual submit of the form.
    });

    // COUNTDOWN (/program-countdown)
    jQuery("#countdown_signup_form #mc-embedded-subscribe").click(function() {

        if (!validateEmailCountdown()) {
            return false;
        }

         if (!(jQuery('#countdown_signup_form input.agree').is(':checked'))) {
          var coolhtml = "<p>You have to agree with the terms and conditions.</p>";
          jQuery.colorbox({html:coolhtml, width:"300px", height:"70px"});
          return false;
        }

        var url = "../custom_includes/countdown_email_signup.php"; // the script where you handle the form input.

        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery("#countdown_signup_form").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = data;
                   // jQuery('#countdown_signup_form input').hide();
                   // jQuery('#countdown_signup_form .response').html(output); // show response from the php script.
                   var coolhtml = "<p>" + output + "</p>";
                   jQuery.colorbox({html:coolhtml, width:"300px", height:"70px"});
               }
             });

        jQuery("#countdown_signup_form input").attr('disabled', 'disabled');

        // jQuery("#blogcontest_signup_form").hide();
        
        return false; // avoid to execute the actual submit of the form.
    });

    // PLUM MASK PROMO (/plum-mask-promo)
    jQuery("#plummask_signup_form #mc-embedded-subscribe").click(function() {

        if (!validateEmailPlumMask())
          return false;

        var url = "../custom_includes/plummask_email_signup.php"; // the script where you handle the form input.

        jQuery('.plum_mask_img img').attr('src', '../skin/frontend/enterprise/default/images/plummask/plum_mask_landing_bottom.jpg');
        postpone(updateAssets);
        
        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery("#plummask_signup_form").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = '<em>' + data + '</em>';
                   jQuery('#plummask_signup_form .response').html(output); // show response from the php script.
                   jQuery('.enteremailhere').hide();
               }
             });

        jQuery("#plummask_signup_form input").attr('disabled', 'disabled');

        return false; // avoid to execute the actual submit of the form.
    });
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

function validateEmailCountdown() { 
    var email = jQuery('#countdown_signup_form').find('input.email').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        // jQuery('#countdown_signup_form .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        
      var coolhtml = "<p>Please enter a valid email!</p>";
        jQuery.colorbox({html:coolhtml, width:"300px", height:"50px"});
        return false;
    }
} 

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

function validateEmailBlogContest() { 
    var email = jQuery('#blogcontest_signup_form').find('input.email').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        jQuery('#blogcontest_signup_form .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        return false;
    }
} 

function validateEmailSweeps() { 
    var email = jQuery('#sweepstakes-form').find('input.emailbox').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        jQuery('#sweepstakes-form .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        return false;
    }
} 

function validateVideoEmail() { 
    var email = jQuery('#video-email-signup').find('input.email').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        jQuery('.get-email-updates .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        return false;
    }
} 

function validateEmailPlumMask() { 
    var email = jQuery('#plummask_signup_form').find('input.email').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        jQuery('#plummask_signup_form .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        return false;
    }
} 

function postpone( fun )
{
  window.setTimeout(fun,1000);
}

function updateAssets() {
    jQuery('.blog_contest_img').append("<div class='cta_buttons'></div>");
    jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/online-exclusives'><img src='../skin/frontend/enterprise/default/images/blogcontest/button_left.png' class='button_left' /></a>");
    jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/best-sellers '><img src='../skin/frontend/enterprise/default/images/blogcontest/button_middle.png' class='button_middle' /></a>");
    jQuery('.cta_buttons').append("<a href='http://www.tataharperskincare.com/natural-skincare-try-me-kit'><img src='../skin/frontend/enterprise/default/images/blogcontest/button_right.png' class='button_right' /></a>");
    jQuery('.byentering').hide();
}