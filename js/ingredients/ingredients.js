jQuery(document).ready(function () {
    
    // load image and description
    jQuery(".ingredients").click(function(event) {
    	
    	// get data
    	event.preventDefault();
    	var image = jQuery(this).find("a.ingredients-link").attr("href");
    	var description = jQuery(this).find("a.ingredients-link").attr("title");
    	var total = jQuery(this).find("a.ingredients-link").data("total");
 		var current = jQuery(this).find("a.ingredients-link").data("current");

 		var html = "<span class='button b-close'><span>X</span></span><img data-total='" + total + "' data-current='" + current + "' src='" + image + "' />" + "<p>" + description + "</p><a id='prevIng' href='#' onClick=\"moveIng(this, 'previous');return false;\">Previous</a><br /><a id='nextIng' href='#' onClick=\"moveIng(this, 'next');return false;\">Next</a>";

 		// create popup
 		var content = jQuery("#bpopup");
 		jQuery("#bpopup").bPopup({
 			modalClose: true,
 			position: [350,110],
			positionStyle: 'fixed',
 			onOpen: function() {
 				content.html(html);
 			},
 			onClose: function() {
 				content.empty();
 			}
 		});

    });
});

function getIngNum(current, total, direction)
{
	var queryIng = 0;

	if (direction == "previous")
	{
		if (current != 1)
		{
			queryIng = current - 1;
		}
		else
		{
			queryIng = total;
		}
	}
	else if (direction == "next")
	{
		if (current != total)
		{
			queryIng = current + 1;
		}
		else
		{
			queryIng = 1;
		}
	}

	return queryIng;
}

function moveIng(currentElement, direction) {
	var total = jQuery(currentElement).parent().find("img").data("total");
	var current = jQuery(currentElement).parent().find("img").data("current");
	var ingNum = getIngNum(current, total, direction);
	displayIng(ingNum);
}

function displayIng(ingNum)
{
	var image = jQuery('*[data-current="' + ingNum + '"]').attr("href");
	var description = jQuery('*[data-current="' + ingNum + '"]').attr("title");
	var total = jQuery('*[data-current="' + ingNum + '"]').data("total");
	var current = jQuery('*[data-current="' + ingNum + '"]').data("current");

	var html = "<span class='button b-close'><span>X</span></span><img data-total='" + total + "' data-current='" + current + "' src='" + image + "' />" + "<p>" + description + "</p><a id='prevIng' href='#' onClick=\"moveIng(this, 'previous');return false;\">Previous</a><br /><a id='nextIng' href='#' onClick=\"moveIng(this, 'next');return false;\">Next</a>";

	var content = jQuery("#bpopup");
	content.html(html);
}