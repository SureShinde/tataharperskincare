jQuery(document).ready(function() {

jQuery('.rs-sub .cancel').click(function() {

        var uuid = jQuery(this).data('uuid');
        
        var url = "/replenishment/delete/sub/id/" + uuid; // the script where you handle the form input.

        if(confirm("Are you sure you want to cancel this subscription?")) {

            jQuery(this).parent().find('.prod-img').fadeOut('slow');

            jQuery(this).parent().fadeTo('slow', .5);

            jQuery(this).parent().prepend('<img class="loading" src="/skin/frontend/enterprise/default/images/loadingloading.gif" />');

            jQuery.ajax({
               type: "POST",
               url: url,
               success: function(data)
               {
                   var output = data;
                   alert(output); // show response from the php script.
                   location.reload();
               }
             });
        }

    }); 

  jQuery('.checkout-onepage-index').load(function() {
     if (jQuery('#shipping-progress-opcheckout dt').hasClass('complete')) {
      // shipping info - added by AX 8/26/13
      jQuery('.checkout-onepage-index #checkout-shipping-method-load p:first-child').after("<h2 class='shipping_info_title'>Processing Time</h2><p class='shipping_info_description'>Orders will process in one business day. All expedited shipping orders must be placed by 12 noon Eastern Standard Time (EST) to be processed on the same business day. If placed after this, your order will be processed the following business day.</p>");
      }
  });

  if(!(jQuery("li.success-msg:contains('was added to your shopping cart')").length > 0))
  {
      jQuery('#topCartContent').css('display', '');
      jQuery('#topCartContent').addClass('displaynone');
  }
  else
  {
      jQuery('#topCartContent').css('display', '');
      jQuery('#topCartContent').addClass('displaynone');
      //jQuery('#topCartContent').slideDown();
      jQuery('#topCartContent').removeClass('displaynone');
  }
  // Overlay for mystery gift
  // if((jQuery(".checkout-cart-index tr .item-msg:contains('your free mystery gift from')").length > 0))
  // {
  //     jQuery(".checkout-cart-index tr .item-msg:contains('your free mystery gift from')").prev().html('<a href="#">Mystery Gift</a>');
  //     jQuery(".checkout-cart-index tr .item-msg:contains('your free mystery gift from')").parent().prev().html('<td><a href="#" class="product-image"><img src="http://www.tataharperskincare.com/skin/frontend/enterprise/default/images/mystery_gift.jpg" width="75" height="75" /></a></td>');
  //     return false;
  // }

  // if (jQuery('li.success-msg:contains("was added to your shopping cart")').length > 0) {
  //   Enterprise.TopCart.showCart();
  //   }

  jQuery('html').click(function() {
  //Hide the menus if visible
    jQuery('#topCartContent').slideUp();
    jQuery('#topCartContent').addClass('displaynone');
  });

  jQuery("#mini-cart, .subtotal, .actions, .recently-added-cart-items, .inner-wrapper").click(function(e) {
        e.stopPropagation();
  });

  jQuery(".close-btn").click(function(e) {
    jQuery('#topCartContent').slideUp();
    jQuery('#topCartContent').addClass('displaynone');
    e.stopPropagation();
  });

  jQuery("#cartHeader .topcheckout").click(function(e) {
    e.stopPropogation();
  });

  jQuery("#cartHeader").click(function(e){
    e.stopPropagation();

    if (jQuery('#topCartContent').hasClass('displaynone')) {
      jQuery('#topCartContent').slideDown();
      jQuery('#topCartContent').removeClass('displaynone');
    }
    else
    {
      jQuery('#topCartContent').slideUp();
      jQuery('#topCartContent').addClass('displaynone');
    }
  });

      jQuery('body').on('click', '.returnandexchange', function(event) {
        event.preventDefault();
        var one = "<div class='popup returnandexchange'>";
        var two = "<h1>RETURN AND EXCHANGE POLICY</h1><h2>PRODUCTS ELIGIBLE FOR RETURN:</h2><p>Any retail product purchased on Tataharperskincare.com, received within the last 30 days, and more than 1/2 full.   Deluxe Sample Sets are not eligible for return or exchange.  If you wish to return or exchange an item purchased through Tata Harper Online, please follow the steps below.</p><p>1. Please include in your return package your name, email, shipping address, and phone number.If you are making an exchange and the total cost is more than the amount of your return, please include your payment information and the details of your exchange.<p>2. All returns should be addressed to:<br/><br/>Tata Harper Skincare<br/>Returns Department<br/>1135 Wooster Rd<br/>Whiting VT 05778</p><p>3. For your protection and to ensure prompt delivery, we recommend that you send your return via UPS or insured Parcel Post. We're sorry, return shipping fees are not refundable.</p><p>Your return will be processed promptly upon its arrival and all exchanges will be shipped via standard ground shipping. Processing and transit time for exchange packages is usually 7-10 business days from the time the exchange is received. Business days are Monday through Friday, excluding federal holidays within the United States. An email will be sent to confirm receipt and processing of your return or exchange request.</p><p>Please note: Only products purchased at Tata Harper Skincare Online may be returned for refund or exchange.</p><p>If you have questions about returns or exchanges, please contact us by phone at 1-877-321-TATA (8282) or info@tataharper.com</p>";
        var three = "</div>";
        var coolhtml = jQuery(one + two + three);
        jQuery.colorbox({html:coolhtml, width:"500px", height:"420px"});
    });

      jQuery('body').on('click', '.international-ship', function(event) {
        event.preventDefault();
        var one = "<div class='popup international-ship'>";
        var two = "<h1>International Shipping</h1><p>Canada customers receive free shipping with all orders $250 and over. Canadian Customers are responsible for paying 19% tax upon arrival of their package.</p><p>International orders over $550 qualify for free shipping. Customers ordering from the UK, Germany, and France will all be charged an import tax of about 20% upon delivery of their package. Australian orders up to 1,000 AUD (~$785 US) ship duty and tax free. Australian orders above 1,000 AUD will require customers to pay duties.</p><p>We are not able to ship to Italy or Spain at this time.</p>";
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

});