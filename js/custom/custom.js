jQuery(document).ready(function($) {

	// jQuery('.product-gift-certificate ')

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

    // Giveaway page onfocus clear
    jQuery('#sweepstakes-form input[type="text"], #sweepstakes-form input[type="email"]').on('click focusin', function() {
        this.value = '';
    });

    /* Program countdown */
    if (jQuery('body').hasClass('cms-program-countdown')) {
        var launch = moment([2014, 4, 1]);
        var now = moment();
        var count = launch.diff(now, 'days') + 1; // 86400000

        if (count < 0) {
            count = 0;
        }
        
        jQuery('.days-countdown .num-days').html(count);
    }

    /* PDP v2 */

    // scroll to reviews section
    jQuery(".revision .avgcustrating").click(function() {
        jQuery('html, body').animate({
            scrollTop: jQuery(".ratings_reviews").offset().top
        }, 2000);
    });

    // change "No subscription" to "Purchase just once"
    jQuery('.revision .sarp-subscription select option:first').text('Purchase just once');

    // watch video hover
    jQuery('.revision .videoinline p').hover(function() {
        jQuery('.revision .videoinline p, .revision .videoinline span').css("color","#79bb3f");
        jQuery('.revision .videoinline img').attr("src","/skin/frontend/enterprise/default/images/pdp2/camicon-green.png");
    }, function(){
        jQuery('.revision .videoinline p, .revision .videoinline span').css("color","#555555");
        jQuery('.revision .videoinline img').attr("src","/skin/frontend/enterprise/default/images/camicon.jpg");
    });

    /* Today's Offer & What's Fresh */

    var timer;
    
    var offer = false;
    var fresh = false;

    $('.product-gift-card input#send_friend').prop('checked',true);
    $('.product-gift-card #giftvoucher-receiver').show();
    $('.product-gift-certificate input#send_friend').hide();
    $('.product-gift-certificate #giftvoucher-receiver').hide();
    $(".product-gift-certificate label[for='send_friend']").hide();

    $('.product-gift-card .product-shop').prepend('<p class="egift-toc" onClick="egiftTOC()">By clicking Add to Cart you agree to our e-gift card Terms & Conditions <span class="egift-toc-here">here</span>...</p>');

    $('.todaysoffer').click(function () {
        if (offer == false) {
            hideFresh();
            $('.todaysoffer').addClass( "bg_greensplat" );
            $('.todaysoffer_hid').slideDown('slow');
            offer = true;
        } else {
            hideOffer();
        }
    });

    $('.whatsfresh').click(function () {
        if (fresh == false) {
            hideOffer();
            $('.whatsfresh').addClass( "bg_greensplat" );
            $('.whatsfresh_hid').slideDown('slow');
            fresh = true;
        } else {
            hideFresh();
        }
    });

    function hideOffer() {
        if (offer == true)
        {
            jQuery('.todaysoffer_hid').slideUp('slow');
            jQuery('.todaysoffer').removeClass( "bg_greensplat" );
            offer = false;
        }
    }

    function hideFresh() {
        if (fresh == true)
        {
            jQuery('.whatsfresh_hid').slideUp('slow');
            jQuery('.whatsfresh').removeClass( "bg_greensplat" );
            fresh = false;
        }
    }

    // More Tabs - PD Page
    jQuery(function($) {
        $( ".ratings_reviews #tabs" ).tabs();
    });

    //PDP - toggle new review
    jQuery( "#clickme" ).click(function() {
      jQuery( ".revision .new_review #review-form" ).slideToggle( "slow", function() {
      });
    });

    //PDP - load thumbs as lightboxes


    /* Gift card - check balance */

    jQuery(".gift-card-check-balance").click(function() {

        // if (!validateEmailHome())
        //   return false;

        var url = "/custom_includes/check_giftcard_balance.php"; // the script where you handle the form input.

        jQuery.ajax({
               type: "POST",
               url: url,
               data: jQuery(".gift-card-balance-form").serialize(), // serializes the form's elements.
               success: function(data)
               {
                   var output = '<em>' + data + '</em>';
                   jQuery('.gift-card-balance').html(output); // show response from the php script.
               }
             });

        return false; // avoid to execute the actual submit of the form.
    });

    jQuery('.cms-gift-cards .gift-card-balance-form .gift-card-code').on('click focusin', function() {
        this.value = '';
    });
    
    jQuery(document).bind('cbox_complete', function(){

        jQuery('.cms-tatas-world #cboxLoadedContent').append( '<button type="button" id="" class="secondnext" style="display: block;">next</button>' );
        jQuery('.cms-tatas-world #cboxLoadedContent').append( '<button type="button" id="" class="secondprev" style="display: block;">previous</button>' );

        jQuery('.cms-tatas-world .secondnext').click(function() {
            jQuery.colorbox.next()
        });
        jQuery('.cms-tatas-world .secondprev').click(function() {
            jQuery.colorbox.prev()
        });
    });

});