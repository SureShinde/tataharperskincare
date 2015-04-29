jQuery(document).ready(function() { 

    // Display Quickview
    jQuery('.prod-grid-shopby, .products-grid').on('click', 'a.qvbuttonlink', function(event) {
        event.preventDefault();

        var prodTitle = jQuery(this).parent().parent().find('h2.prodtitle a').attr('title');
        if (prodTitle != "E-Gift Card") {

          jQuery('.explainautoship').remove();

          var coolhtml;

          if (jQuery("body").hasClass("cms-tatas-natural-beauty-gift-guide")) {

              coolhtml = jQuery(this).parent().parent().find(".quickview-hidden").first().html();

          } else {
            
            // coolhtml = jQuery(this).parent().parent().find(".quickview-hidden").first().html();
            coolhtml = jQuery(this).parent().find(".quickview-hidden").first().html();

            // coolhtml = jQuery(this).parent().find(".quickview-hidden").first().html();

            // var sku = jQuery(this).closest('li').data('sku');

            // url = '/custom_includes/quickview.php';
            // var coolhtml;

            //  jQuery.ajax({
            //    type: "POST",
            //    url: url,
            //    data: {sku: sku}, // serializes the form's elements.
            //    success: function(data)
            //    {
            //        coolhtml = data;
            //    }
            //  });

              jQuery.colorbox({html:coolhtml, width:"760px", height:"420px"});


          }

          // change quickview add to cart button text to "Pre-Order" if applicable
          var preorder = jQuery('<span class="regular-price" price pre-order>Pre-Order</span>');

          if (jQuery('#cboxContent div.price-box:contains("Pre-Order")').length > 0)
          {
              jQuery("#cboxContent button#add-to-cart span span").text('PRE-ORDER');
          }




        }
        
    });

    // change shop-all-skincare page add-to-cart button text to "Pre-Order" for individual products if applicable
    jQuery('.cms-shop-all-skincare .prod-grid-shopby').each(function(){
        if (jQuery(this).find('div.price-box:contains("Pre-Order")').length > 0)
        {
            jQuery(this).find('button:first span span').text('PRE-ORDER');
        }
    });
});

// used in quick view - add to cart
function getFullLoc(url){
  var qty = jQuery('#cboxContent input.qty').val();
  url = url + "qty/" + qty;
  var params = 0;
  if (jQuery("#cboxContent select.custom_attribute_select").is('*'))
  {
     var supercode = jQuery("#cboxContent select.custom_attribute_select").attr("attrid");
     var valindex = jQuery("#cboxContent select.custom_attribute_select option:selected").val();
     url = url + "/?super_attribute[" + supercode + "]=" + valindex;
     params++;
  }
  // if product has AW SARP subscriptions enabled, add query parameters for subscription data
  if (jQuery("#cboxContent select.qv_recurring").is('*'))
  {
     var subtype = jQuery("#cboxContent select.qv_recurring").val();
     if (params == 0)
     {
        url = url + "/?aw_sarp_subscription_type=" + subtype;
     }  
     else
     {
        url = url + "&aw_sarp_subscription_type=" + subtype;
     }
     params++;

     if (jQuery("#cboxContent input#datepicker").is('*'))
     {
        var startdate = jQuery("#cboxContent input#datepicker").val();

        if (params == 0)
        {
            url = url + "/?aw_sarp_subscription_start=" + startdate;
        }
        else
        {
            url = url + "&aw_sarp_subscription_start=" + startdate;
        }
     }
     
  }
  return url;
}

// used for quick view add to wishlist button
function getFullWishLoc(url){
  // if product is configurable, add query parameter for configurable option
  if (jQuery("#cboxContent select.custom_attribute_select").is('*'))
  {
     var supercode = jQuery("#cboxContent select.custom_attribute_select").attr("attrid");
     var valindex = jQuery("#cboxContent select.custom_attribute_select option:selected").val();
     url = url + "/?super_attribute[" + supercode + "]=" + valindex;
  }
  return url;
}

// used in list all page
function getFullLocListAll(url){

  if (jQuery("select.killbill").is('*'))
  {
     var supercode = jQuery("select.killbill").attr("attrid");
     var valindex = jQuery("select.killbill option:selected").val();
     url = url + "?super_attribute[" + supercode + "]=" + valindex;
     jQuery("select.killbill").removeClass("killbill");
  }
  return url;
}

// displays quick view button on product image hover
jQuery(document).ready(function() { 
    var qvbutton = jQuery('<a href="#" class="qvbuttonlink remove"><img src="/skin/frontend/enterprise/default/images/quickviewbutton.png" class="qvbutton" /></a>');
    jQuery('.prod-grid-shopby img, .products-grid img').hover(
        function(){
            jQuery(this).parent().parent().append(qvbutton);
        },
        function(){
        });

    jQuery('.prod-grid-shopby, .products-grid').hover(
        function(){ 
        },
        function(){
            jQuery(this).find('a.qvbuttonlink.remove').remove();
        });
});

// AW Sarp
jQuery(document).ready(function() { 
    jQuery('.cms-page-view').on('change', 'select.qv_recurring', function(event) {
          /* 
           * Adds datepicker to lightbox
          */
          var code = jQuery(this).children('option:selected').val();
          var poffset = parseInt(jQuery(this).children('option:selected').attr("poffset"), 10);

          // calculate offset - mindate for datepicker
          var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1; //January is 0!
          var yyyy = today.getFullYear();
          if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'/'+dd+'/'+yyyy;
          var startdate = new Date(today);
          
          startdate.setDate(startdate.getDate() + poffset);
          var dd = startdate.getDate();
          var mm = startdate.getMonth()+1; //January is 0!
          var yyyy = startdate.getFullYear();
          if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} startdatetext = mm+'/'+dd+'/'+yyyy;

          var dpick = jQuery("<div id='datepicker_wrapper'><p>Ship Date: <input type='text' readonly='readonly' id='datepicker' value='" + startdatetext + "'></input></p></div>");

          // if #datepicker exists, remove it from page

          if (jQuery("#datepicker_wrapper").is('*'))
          {
              jQuery("#datepicker_wrapper").remove();
          }

          // if code != "-1", add #datepicker to page
          if ((code != "-1") && (1==4)) // disabled per THS' request on 5.26.13
          {
              jQuery(this).parent().find('.autoship-learnmore').after(dpick);
              jQuery("#datepicker").datepicker({minDate:startdate});
          }
          /*
           * Updates price field
          */
          var subprice = jQuery(this).children('option:selected').attr("sp");
          var regprice = jQuery(this).children('option:selected').attr("regprice");
          var firstperiod = jQuery(this).children('option:selected').attr("fpp");
          if (code != "-1")
          {
              if (firstperiod)
              {
                  jQuery(this).parent().parent().find('.price-box span.price').text("$" + firstperiod);
                  jQuery(this).parent().parent().find('.price-box span.price').append("<span class='addl-price'>$" + subprice + " each following billing period</span>");
              }
              else
              {
                  jQuery(this).parent().parent().find('.price-box span.price').text("$" + subprice);
              }
          }
          else
          {
              jQuery(this).parent().parent().find('.price-box span.price').text("$" + regprice);
          }

    });
});