jQuery( window ).ready(function() {

		var blogone = '';
		var blogtwo = '';

		if(jQuery(".blogonecode").length)
			blogone = jQuery('.blogonecode').text();

		if(jQuery(".blogtwocode").length)
			blogtwo = jQuery('.blogtwocode').text();

		if ((blogone.length > 0) || (blogtwo.length > 0))
		{

			var url = "/custom_includes/category-blog.php?"

			if (blogone)
				url = url + "b1=" + blogone + "&";

			if (blogtwo)
				url = url + "b2=" + blogtwo;

			// b1=" + blogone + "&b2=" + blogtwo;

	        jQuery.ajax({
	          url: url,
	        }).done(function(data) {
	        	// alert(data);
	         	jQuery('.related-blog-posts').html(data);
	        });
		}
});


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
            
            coolhtml = jQuery(this).parent().find(".quickview-hidden").first().html();

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