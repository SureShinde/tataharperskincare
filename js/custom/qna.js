jQuery(document).ready(function() { 
	jQuery(".qna .askquestion").click(function() {
	   var pid = jQuery(this).data('pid');
		var qForm = "<form onsubmit='submitQuestion(); return false;' action='#' method='post' class='question_form' autocomplete='on'> Question:<input type='text' name='text'><br> <input type='hidden' name='prod' value='" + pid + "'><br> <input type='hidden' name='action' value='question'><br> First name: <input type='text' name='fname'><br> Zipcode: <input type='text' name='zip' autocomplete='on'><br> <input class='submitquestion' type='submit'> </form><p class='response'>&nbsp;</p>";

		jQuery.colorbox({html:qForm, width:"400px", height:"400px"});

	});

	jQuery(".qna .answerquestion").click(function() {
	   var qid = jQuery(this).parent().data('qid');
	   // alert('qid: ' + qid);
	   var aForm = "<form onsubmit='submitAnswer(); return false;' action='#' method='post' class='answer_form' autocomplete='on'> Answer:<input type='text' name='text'><br> <input type='hidden' name='qid' value='" + qid + "'><br> <input type='hidden' name='action' value='answer'><br> First name: <input type='text' name='fname'><br> Zipcode: <input type='text' name='zip' autocomplete='on'><br> <input class='submitanswer' type='submit'> </form><p class='response'>&nbsp;</p>";

	   jQuery.colorbox({html:aForm, width:"400px", height:"400px"});

	});
});

function submitQuestion() {
	var url = "/custom_includes/qna.php";

	jQuery.ajax({
       type: "POST",
       url: url,
       data: jQuery("form.question_form").serialize(), // serializes the form's elements.
       success: function(data)
       {
           var output = '<em>' + data + '</em>';
           jQuery('#colorbox .response').html(output); // show response from the php script.
           
           setTimeout(function(){
               jQuery(window).colorbox.close();
            }, 5000);
       }
     });

	jQuery("#form.question_form input").attr('disabled', 'disabled');
    return false; // avoid executing the actual submit of the form.
}

function submitAnswer() {

	var url = "/custom_includes/qna.php";

	jQuery.ajax({
       type: "POST",
       url: url,
       data: jQuery("form.answer_form").serialize(), // serializes the form's elements.
       success: function(data)
       {
           var output = '<em>' + data + '</em>';
           jQuery('#colorbox .response').html(output); // show response from the php script.
           
           setTimeout(function(){
               jQuery(window).colorbox.close();
            }, 5000);
       }
     });

	jQuery("#form.answer_form input").attr('disabled', 'disabled');
    return false; // avoid executing the actual submit of the form.

}