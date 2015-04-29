jQuery(document).ready(function () {
    jQuery('#tabs').tabs();

    jQuery('.product-view').one('mouseenter', function () {
        Socialite.load(jQuery(this)[0]);
    });
});