jQuery(document).ready(function(){
		    jQuery("#signup_affiliate_account_form").submit(function(e) {       
		      e.preventDefault();

		      jQuery.ajax({
			     type: 'POST',
		         url: "/custom_includes/affiliate_signup.php",
		         data: jQuery('#signup_affiliate_account_form').serialize(),
		         success: function(){
			        jQuery('#signup_affiliate_account_form').unbind('submit').submit();
			      }
	          });
		    });
	});