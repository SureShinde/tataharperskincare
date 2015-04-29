jQuery(document).ready(function() {

	 if (jQuery('body').hasClass('affiliateplusadmin-adminhtml-account-edit')) {
	 	var email = jQuery('input#email').val();
	 	var name = 'email';
	 	var dataObj = {};

	 	dataObj[name] = email;

	 	 jQuery.ajax({
		     type: 'POST',
	         url: "/custom_includes/affiliate_hook.php",
	         data: dataObj,
	         success: function(data){
		        // jQuery('#signup_affiliate_account_form').unbind('submit').submit();
		        var obj = JSON.parse(data);
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Phone #: </strong><p class="extrainfo-value">' + obj.phone + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Address: </strong><p class="extrainfo-value">' + obj.address + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Country: </strong><p class="extrainfo-value">' + obj.country + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">DOB: </strong><p class="extrainfo-value">' + obj.dateofbirth + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Website Name: </strong><p class="extrainfo-value">' + obj.websitename + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Website URL: </strong><p class="extrainfo-value">' + obj.websiteurl + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Website About: </strong><p class="extrainfo-value">' + obj.websiteabout + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Website For: </strong><p class="extrainfo-value">' + obj.websitefor + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Topics: </strong><p class="extrainfo-value">' + obj.topics + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Traffic: </strong><p class="extrainfo-value">' + obj.traffic + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Unique Visitors: </strong><p class="extrainfo-value">' + obj.uniquevisitors + '</p><br />');
		        jQuery(".affiliateplusadmin-adminhtml-account-edit #account_tabs_general_section_content .hor-scroll" ).append('<strong class="extrainfo">Website Type: </strong><p class="extrainfo-value">' + obj.websitetype + '</p><br />');

		       }
          });
	 }
});
