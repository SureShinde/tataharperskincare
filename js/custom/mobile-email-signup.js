jQuery(document).ready(function() { 
// mobile email signup - start
    jQuery("#home_signup_form #mc-embedded-subscribe").click(function() {
        // alert("mobile click");
        if (!validateEmailHome())
          return false;

        var url = "/custom_includes/home_email_signup.php"; // the script where you handle the form input.

        // jQuery('.home_email_popup img').attr('src', 'http://tataharperskincare.com/skin/frontend/enterprise/default/images/lightboxes/lightbox2.jpg');


        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery("#home_signup_form").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = '<em>' + data + '</em>';
                   // alert(data);
                   jQuery('#home_signup_form .response').html(output); // show response from the php script.
                   // jQuery('#home_signup_form input').hide();
                   
                   // setTimeout(function(){
                   //     jQuery(window).colorbox.close();
                   //  }, 5000);
               }
             });

        jQuery("#home_signup_form input").attr('disabled', 'disabled');

        return false; // avoid to execute the actual submit of the form.
    });
    // mobile email signup - end
});

function validateEmailHome() { 
    var email = jQuery('#home_signup_form').find('input.email').val();

    var re = /[^\s@]+@[^\s@]+\.[^\s@]+/;

    if (re.test(email))
      return true;
    else
    {
        jQuery('#home_signup_form .response').html("<em>Please enter a valid email!</em>"); // show response from the php script.
        return false;
    }
} 