/*!
	Zoom v1.7.7 - 2013-07-14
	Enlarge images on click or mouseover.
	(c) 2013 Jack Moore - http://www.jacklmoore.com/zoom
	license: http://www.opensource.org/licenses/mit-license.php
*/
(function(o){var t={url:!1,callback:!1,target:!1,duration:120,on:"mouseover",onZoomIn:!1,onZoomOut:!1};o.zoom=function(t,n,e){var i,u,c,m,a,r=o(t).css("position");return o(t).css({position:/(absolute|fixed)/.test(r)?r:"relative",overflow:"hidden"}),e.style.width=e.style.height="",o(e).addClass("zoomImg").css({position:"absolute",top:0,left:0,opacity:0,width:e.width,height:e.height,border:"none",maxWidth:"none"}).appendTo(t),{init:function(){i=o(t).outerWidth(),u=o(t).outerHeight(),c=(e.width-i)/o(n).outerWidth(),m=(e.height-u)/o(n).outerHeight(),a=o(n).offset()},move:function(o){var t=o.pageX-a.left,n=o.pageY-a.top;n=Math.max(Math.min(n,u),0),t=Math.max(Math.min(t,i),0),e.style.left=t*-c+"px",e.style.top=n*-m+"px"}}},o.fn.zoom=function(n){return this.each(function(){var e=o.extend({},t,n||{}),i=e.target||this,u=this,c=document.createElement("img"),m=o(c),a="mousemove.zoom",r=!1;(e.url||(e.url=o(u).find("img").attr("src"),e.url))&&(c.onload=function(){function t(t){l.init(),l.move(t),m.stop().fadeTo(o.support.opacity?e.duration:0,1,o.isFunction(e.onZoomIn)?e.onZoomIn.call(c):!1)}function n(){m.stop().fadeTo(e.duration,0,o.isFunction(e.onZoomOut)?e.onZoomOut.call(c):!1)}var l=o.zoom(i,u,c);"grab"===e.on?o(u).on("mousedown.zoom",function(e){1===e.which&&(o(document).one("mouseup.zoom",function(){n(),o(document).off(a,l.move)}),t(e),o(document).on(a,l.move),e.preventDefault())}):"click"===e.on?o(u).on("click.zoom",function(e){return r?void 0:(r=!0,t(e),o(document).on(a,l.move),o(document).one("click.zoom",function(){n(),r=!1,o(document).off(a,l.move)}),!1)}):"toggle"===e.on?o(u).on("click.zoom",function(o){r?n():t(o),r=!r}):(l.init(),o(u).on("mouseenter.zoom",t).on("mouseleave.zoom",n).on(a,l.move)),o.isFunction(e.callback)&&e.callback.call(c)},c.src=e.url,o(u).one("zoom.destroy",function(){o(u).off(".zoom"),m.remove()}))})},o.fn.zoom.defaults=t})(window.jQuery);
// jQuery(document).ready(function(){
// jQuery('a.color-press').colorbox({
//     'onComplete': function(){ 
//         jQuery('#cboxLoadedContent img').wrap('<span style="display:inline-block"></span>')
//             .css('display', 'block')
//             .parent()
//             .zoom();
//     }
// });
// });