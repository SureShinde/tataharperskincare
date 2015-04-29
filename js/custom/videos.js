// AddThis endpoints for all videos
var addthis_ui_config = { services_compact: 'facebook, myspace, igoogle, netvibes, windows, dashboard, more' }

// Player 1 initial config
var addthis_share_config_p1 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "The Supernatural Collection",
    description: "",
    swfurl: "http://www.youtube.com/v/IogBd7RlmKM",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/featured-1.jpg"
}

// Player 2 initial config
var addthis_share_config_p2 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "Regenerating Cleanser",
    description: "",
    swfurl: "http://www.youtube.com/v/IogBd7RlmKM",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/featured-2.jpg"
}

// Player 3 initial config
var addthis_share_config_p3 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "How to De-Stress Naturally",
    description: "",
    swfurl: "http://www.youtube.com/v/IogBd7RlmKM",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/featured-3.jpg"
}

// Player 4 initial config
var addthis_share_config_p4 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "Meet Tata",
    description: "",
    swfurl: "http://www.youtube.com/v/AeucwulVnEM",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/meettata.PNG"
}

// Player 5 initial config
var addthis_share_config_p5 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "Vogue Italia Interviews Tata",
    description: "",
    swfurl: "http://www.youtube.com/v/7pY-u5GlsEU",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/featured-5.jpg"
}

// Player 6 initial config
var addthis_share_config_p6 = 
{
    url: "http://www.tataharperskincare.com/videos",
    title: "Ecoholic Beauty Reviews Tata Harper",
    description: "",
    swfurl: "https://www.youtube.com/v/3y9NT7G66Eo",
    width: "560",
    height: "340",
    screenshot: "http://www.tataharperskincare.com/images/videos/featured-6.jpg"
}


// Set up videos array

var videos = new Array(8);
for (var i = 1; i < 8; i++) {
    videos[i] = [' ', ' ', ' ', ' ', ''];
    for (var j = 1; j < 5; j++) {
        videos[i][j] = [' ', ' ', ''];
    }
}

// List of videos

videos[1][1][1] = 'hPFSclPfeTQ';
videos[1][1][2] = 'Estate Grown Beauty Complex';

videos[2][1][1] = 'IogBd7RlmKM';
videos[2][1][2] = 'Regnerating Cleanser';
videos[2][2][1] = 'IogBd7RlmKM';
videos[2][2][2] = 'Repairative Moisturizer';
videos[2][3][1] = 'IogBd7RlmKM';
videos[2][3][2] = 'Resurfacing Mask';
videos[2][4][1] = 'IogBd7RlmKM';
videos[2][4][2] = 'Restorative Eye Creme';

videos[3][1][1] = '0jF6netb9JY';
videos[3][1][2] = 'How to De-Stress Naturally';
videos[3][2][1] = 'cTVWpK79MbE';
videos[3][2][2] = 'Fight Signs of Aging Naturally';
videos[3][3][1] = '4G_BtFMzqXg';
videos[3][3][2] = 'Healthy, Glowing Skin - Naturally';
videos[3][4][1] = 'a503um7FMSs';
videos[3][4][2] = 'DIY Face Mask with Teen Vogue';

videos[4][1][1] = 'uuXKsiQuBhE';
videos[4][1][2] = 'Carrie\'s Inspiration';
videos[4][2][1] = 'AeucwulVnEM';
videos[4][2][2] = 'Meet Tata';
videos[4][3][1] = 'IogBd7RlmKM';
videos[4][3][2] = 'Juice Recipes with Tata';
videos[4][4][1] = 'IYrTH4t-PUc';
videos[4][4][2] = 'Clare Shares';

videos[5][1][1] = '7pY-u5GlsEU';
videos[5][1][2] = 'Vogue Italia Interviews Tata';
videos[5][2][1] = 'RLGHwMHWIM4';
videos[5][2][2] = 'Tata Harper on NY1 Wellness';
videos[5][3][1] = '1TNYo4S3QhA';
videos[5][3][2] = 'Watch Tata Harper on ExtraTV';
videos[5][4][1] = 'N6r-qqVtvQw';
videos[5][4][2] = 'THNKR';

videos[6][1][1] = '3y9NT7G66Eo';
videos[6][1][2] = 'Echoloic Beauty Reviews Tata Harper';
videos[6][2][1] = 'BiGZPGZwXuo';
videos[6][2][2] = 'Vlogwithkendra';
videos[6][3][1] = 'RBjxmAzNoe4';
videos[6][3][2] = 'Kokolaroo';
videos[6][4][1] = '3y9NT7G66Eo';
videos[6][4][2] = 'Ecoholic Beauty';

// videos[7][1][1] = 'IogBd7RlmKM';
// videos[7][1][2] = 'The Supernatural Collection';
videos[7][1][1] = 'D7__nXPpqvc';
videos[7][1][2] = 'Spring/Summer 2014';
videos[7][2][1] = 'hPFSclPfeTQ';
videos[7][2][2] = 'Estate Grown Beauty Complex';
videos[7][3][1] = '5awcK626Hq8';
videos[7][3][2] = 'Open Lab & Traceability Program ';
videos[7][4][1] = 'kVVaYTvr2sY';
videos[7][4][2] = 'Product Manufacturing';


var lastID = '';
var lastContent = '';

// function called when video is clicked

var beginPlayer = '<iframe id="ytplayer" type="text/html" width="719" height="406" src="https://www.youtube.com/embed/';
var endPlayer = '?autoplay=1&controls=1&modestbranding=1&showinfo=0" frameborder="0" allowfullscreen>';

function playVideo(feature, number) {
    jQuery('html, body').animate({
        scrollTop: jQuery(".player-"+feature).offset().top
    }, 1000);

    if(lastID != '') {
        jQuery(lastID).html(lastContent);
    }
        
    lastID = '.player-'+feature;
    lastContent = jQuery('.player-'+feature).html();

    var imageshareurl = getImageURL(feature, number);
    // alert(imageshareurl);


    var playerHtml = beginPlayer + videos[feature][number][1] + endPlayer;
    var videoTitle = '<p class="featured-title">' + videos[feature][number][2] + '</p>';

    var shareCode = '<div id="share-buttons"><div class="shareleft"><div class="fb-like" data-href="http://www.tataharperskincare.com/videos" data-layout="button" data-action="like" data-show-faces="false" data-share="false"></div></div><div class="shareright"><a id="share-btn-p' + feature + '"></a></div></div>';

    jQuery('.player-'+feature).html(playerHtml);
    jQuery('.player-'+feature).append(videoTitle);
    jQuery('.player-'+feature).append(shareCode);

    var videoswflink = "http://www.youtube.com/v/" + videos[feature][number][1];


    var newsharecode = 
    {
        url: "http://www.tataharperskincare.com/videos",
        title: videos[feature][number][2],
        description: "",
        swfurl: videoswflink,
        width: "560",
        height: "340",
        screenshot: imageshareurl
    }

    switch(feature) {
        case 1:
            addthis.button("#share-btn-p1", addthis_ui_config, newsharecode);
            break;
        case 2:
            addthis.button("#share-btn-p2", addthis_ui_config, newsharecode);
            break;
        case 3:
            addthis.button("#share-btn-p3", addthis_ui_config, newsharecode);
            break;
        case 4:
            addthis.button("#share-btn-p4", addthis_ui_config, newsharecode);
            break;
        case 5:
            addthis.button("#share-btn-p5", addthis_ui_config, newsharecode);
            break; 
        case 6:
            addthis.button("#share-btn-p6", addthis_ui_config, newsharecode);
            break;
    }
    
}

// Carousel for featured products

jQuery(document).ready(function() { 

    // Initialize share buttons on featured players

addthis.button("#share-btn-p1", addthis_ui_config, addthis_share_config_p1);
addthis.button("#share-btn-p2", addthis_ui_config, addthis_share_config_p2);
addthis.button("#share-btn-p3", addthis_ui_config, addthis_share_config_p3);
addthis.button("#share-btn-p4", addthis_ui_config, addthis_share_config_p4);
addthis.button("#share-btn-p5", addthis_ui_config, addthis_share_config_p5);
addthis.button("#share-btn-p6", addthis_ui_config, addthis_share_config_p6);

     jQuery(".shop-the-video .category-products").carouFredSel({
            items: 3,
            direction: "left",
            prev: '#prev1',
            next: '#next1',
            auto: false,
            width: 700
         });
    
     jQuery('.shareright img').remove();
      jQuery('.cms-videos a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = jQuery(this.hash);
          target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            jQuery('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });

});

// Get video image url
function getImageURL(feature, number) {

    if (number == 1) {
        var searchstr = '.player-' + feature + ' img';
    } else {
        var searchstr = '.sub-' + feature + ' > div:nth-child(' + (number-1) + ') img';
    }

    var imageurl = jQuery(searchstr).attr('src');

    imageurl = 'http://www.tataharperskincare.com' + imageurl;

    return imageurl;
}