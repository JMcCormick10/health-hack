//Created By Rahul Malik
 $(document).ready(function() {

    var FromLatitude = document.getElementById("FromLatitude");
	var FromLongitude = document.getElementById("FromLongitude");
	var ToLatitude = document.getElementById("ToLatitude");
	var ToLongitude = document.getElementById("ToLongitude");
	var StartTime = document.getElementById("StartTime");
	var EndTime = document.getElementById("EndTime");
    var CurrentDate;
	$('#CalculateButton').hide();
	$('#EndButton').hide();
    $('#StartButton').click(
     // Handles the start click event
    function () {
        if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showFromPosition);
			
		} else {
			alert("Geolocation is not supported by this browser.");
		}
        
     }
     );
     $('#EndButton').click(
     // Handles the start click event
    function () {
        if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(showEndPosition);
			$(this).prop("disabled",true);
		} else {
			alert("Geolocation is not supported by this browser.");
		}
		
        
     }
     ); 
	 $('#CalculateButton').click(
     // Handles the start click event
    function () {

	var url='Tracking.php?Mode=1&FromLatitude='+FromLatitude.value+'&FromLongitude='+FromLongitude.value+'&ToLatitude='+ToLatitude.value+'&ToLongitude='+ToLongitude.value;
		LoadDoc(url, CalculateDistance);
        
        
     }
     ); 
});
function CalculateDistance(xhttp)
{
		
		if(isNaN(xhttp.responseText))
		{
			alert("You are still at same place.");
	    }
		else
		{
			alert(xhttp.responseText);
			if(confirm(" Do you want to save your current workout."))
			{
				var url='Tracking.php?Mode=2&StartTime='+StartTime.value+'&EndTime='+EndTime.value+'&FromLatitude='+FromLatitude.value+'&FromLongitude='+FromLongitude.value+'&ToLatitude='+ToLatitude.value+'&ToLongitude='+ToLongitude.value;
				LoadDoc(url, SaveDistance);
			}
			
 		}
		window.location.href = "../index.php";

		
}
function SaveDistance()
{
	alert("Saved in Database.");
}

function showFromPosition(position) {
    FromLatitude.value=position.coords.latitude;
    FromLongitude.value=position.coords.longitude; 
	$('#EndButton').show();
	$('#StartButton').hide();
	CurrentDate=new Date();
	StartTime.value=CurrentDate.getHours()+":"+CurrentDate.getMinutes()+":"+CurrentDate.getSeconds();
	
}
function showEndPosition(position) {
    ToLatitude.value=position.coords.latitude;
    ToLongitude.value=position.coords.longitude; 
	CurrentDate=new Date();
	EndTime.value=CurrentDate.getHours()+":"+CurrentDate.getMinutes()+":"+CurrentDate.getSeconds();
	$('#CalculateButton').show();
	$('#EndButton').hide();
}