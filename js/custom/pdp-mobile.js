jQuery(window).bind("load", function() {

        jQuery(".super-attribute-select").change(function() {
          var optval = jQuery(".super-attribute-select" ).val();
          var origprice = jQuery('.regular-price .price').data('origprice');
          var newprice;

          if (optval != 30) {
            newprice = origprice * .9;
            newprice = newprice.toFixed(2);
            jQuery('.regular-price .price').text('$' + newprice);
          } else {
            jQuery('.regular-price .price').text('$' + origprice);
          }

        });
});