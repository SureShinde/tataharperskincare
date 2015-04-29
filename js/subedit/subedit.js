jQuery( function() {
	var d = new Date();
	d.setDate(d.getDate() + 1);
	// alert("mindate: " + d);
	jQuery(".datepicker").datepicker(
		{
			minDate: d,
			defaultDate: +1
		});  
});

function validateForm()
{
	var x=document.forms["changeSubscriptionType"]["newbilldate"].value;
	
	if (x==null || x=="")
	{
		alert("Whoops, please choose a billing date!");
		return false;
	}
}