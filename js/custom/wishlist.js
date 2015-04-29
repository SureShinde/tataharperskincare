jQuery(document).ready(function() { 
    jQuery('.wishlist-index-index').on('change', 'select.custom_attribute_select', function(event) {

    	jQuery(this).parent().parent().parent().parent().css('opacity','.5');
    	jQuery(this).parent().parent().find('.sub_loading_gif img').show();
    	jQuery(this).parent().parent().parent().parent().css('cursor','progress!important');
    	jQuery(this).parent().parent().parent().parent().find('a, input, .button').css('cursor','progress!important');
		
    	/* item id */
    	var itemid = jQuery(this).parent().parent().parent().parent().attr('id');
    	itemid = itemid.replace("item_","");

    	/* supercode, valindex, qty */
		var supercode = jQuery(this).attr("attrid");
     	var valindex = jQuery(this).children("option:selected").val();
     	var theqty = jQuery(this).parent().parent().find(".add-to-cart-alt .qty").val();

     	var prodid = jQuery(this).attr("prodid");
     	var formkey = jQuery(this).attr("formkey");

   		/* today's date */
     	var today = new Date();
      	var dd = today.getDate();
      	var mm = today.getMonth()+1; // January is 0!
      	var yyyy = today.getFullYear();
      	var thedate = mm + "/" + dd + "/" + (yyyy-2000);

      	/* form url */
      	var theurl = "http://www.tataharperskincare.com/wishlist/index/updateItemOptions/id/" + itemid + "/";

        var passdata = {};

        var dataattrname = "super_attribute[" + supercode + "]";
      	passdata["aw_sarp_subscription_type"] = "-1";
      	passdata[dataattrname] = valindex;
      	passdata["aw_sarp_subscription_start"] = thedate;
      	passdata["qty"] = theqty;

      	var deleteurl = "http://www.tataharperskincare.com/wishlist/index/remove/item/" + itemid + "/";
      	var deletedata = {};
      	
      	jQuery.ajax({
	    	  type: "POST",
			  url: deleteurl,
			  data: deletedata,
			  success: function(){
	          		// window.location.reload();
	      	  },
		      error:function(){
		          	// window.location.reload();
		      }  
		});
		
		var addurl = "http://www.tataharperskincare.com/wishlist/index/add/product/" + prodid + "/form_key/" + formkey + "/";

		var adddata = {};

        var dataattrname = "super_attribute[" + supercode + "]";
      	adddata["aw_sarp_subscription_type"] = "-1";
      	adddata[dataattrname] = valindex;
      	adddata["aw_sarp_subscription_start"] = thedate;
      	adddata["qty"] = theqty;

		jQuery.ajax({
	    	  type: "POST",
			  url: addurl,
			  data: adddata,
			  success: function(){
	          		window.location.reload();
	      	  },
		      error:function(){
		          	window.location.reload();
		      }  
		});
	});
});