jQuery.getJSON('http://tumblruptime.apigee.com/json?callback=?', function (response) {
    if (!response.methods['/api/read'].up) {
        jQuery('#tumblr_down').text('Tumblr seems to not want to work with me right now. You can still try and view the posts on tataharper.tumblr.com.');
    }
});

var gplus = true;
var gplus_count = true;

(function(d, s, id) {
	 var js, fjs = d.getElementsByTagName(s)[0];
	 if (d.getElementById(id)) return;
	 js = d.createElement(s); js.id = id;
	 js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=280118368808735";
	 fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

(function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();	

