function save()
{
	var towrite = $("#runs").val();
	//alert("ciao" + towrite);
	var analysis = $("#analysis").text();

    window.location.href =  'PHP/textualInputFunctions.php/?file='+towrite + "&analysis=" + analysis;

}
