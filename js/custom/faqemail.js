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