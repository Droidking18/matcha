<?php

include ("header.php");
include ("../config/config.php");
include ("backcheck.php");
include ("checkSearch.php");
include ("gps.php");
include ("age.php");

session_start();

if (isset($_SESSION['login'])) {
	$_POST['long'] = $_SESSION['long'];
	$_POST['lat'] = $_SESSION['lat'];
	getLoggedHead();
}
else
	getHead();
if (isset($_SESSION['profile']) && $_SESSION['profile'] == "N")
	exit ("First tell us about yourself.<meta http-equiv='refresh' content='0;url=profile.php?page=1' />");

$conn = getDB();
$switch = "no";
if (!isset($_POST['age_low']) && !isset($_POST['age_high']) && !isset($_POST['interest']) && !isset($_POST['loc']) && !isset($_POST['distance']))
	echo "<form method=POST>
		<input style='width: 69%;' placeholder='Enter a minimum age.' type=text name=age_low>
		<input style='width: 69%;' placeholder='Enter a maximum age.' type=text name=age_high><br>
		<input style='width: 69%;' placeholder='Enter one of more interest (tags starting with '#' and seperated by spaces.' type=text name=interest>
		<input id='loc' type=hidden name=loc>
		<input id='lat' type=hidden name=lat>
		<input id='long' type=hidden name=long>
		<input style='width: 69%;' placeholder='Enter how far they can be. (Max amount of KM away.)' type=text name=distance>
		<input style='width: 69%;' placeholder='Enter gender wanted. that is:  M, F or O'  type=text name=gender>
		<input type=submit>";
else if(checkInterest($_POST['interest']) != false && checkSearch($_POST['age_low'], $_POST['age_high'], $_POST['distance'], $_POST['gender'], $switch) == true) {
	$int = checkInterest($_POST['interest']);
	$matches = [];
	$sql = "SELECT DISTINCT * FROM users ORDER BY rating DESC";
	foreach ($conn->query($sql) as $key=>$profile) {
		$dist = distance($_POST['lat'], $_POST['long'], $profile['lat'], $profile['long']);
		$age = age_calc($profile['dob']);
		//echo $dist . "  " . $age . "  " . $_POST['gender'] . $profile['gen'] . "<br>";
		if ($_POST['gender'] == $profile['gen'] && $age >= $_POST['age_low'] && $age <= $_POST['age_high'] && $dist <= $_POST['distance']){
			array_push($matches, $profile);
		}
	}
		echo "<div class='grid-container'>";
		foreach($matches as $found)
		echo "<div class='grid-item'>" . $found['login'] . "<br><img style= 'width:100%;'src='data:image/png;base64," . $found['dp'] . "'></div>";
		echo "</div>";

	}
else if (isset($_POST['gender'])) {
	if (checkInterest($_POST['interest']) == false)
		echo "You interests must all start with a '#' and be seperated by spaces.";
	$ret = checkSearch($_POST['age_low'], $_POST['age_high'], $_POST['distance'], $_POST['gender'], $switch);
	echo $ret;
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
function getLocation() {
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(showPosition,showError);
   } else {
     x.innerHTML = "Geolocation is not supported by this browser.";
   }
 }

 function showPosition(position) {
       document.getElementById("lat").value = (position.coords.latitude);
       document.getElementById("long").value = (position.coords.longitude);
 }

 function showError(error) {
   switch(error.code) {
     case error.PERMISSION_DENIED:
       $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
       var datas = (JSON.stringify(data, null, 2));
       document.getElementById("long").value = (data.geobyteslongitude);
       document.getElementById("lat").value = (data.geobyteslatitude);
       console.log(datas);
       });

       break;
     case error.POSITION_UNAVAILABLE:
	     $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
        var datas = (JSON.stringify(data, null, 2));
        document.getElementById("long").value = (data.geobyteslongitude);
        document.getElementById("lat").value = (data.geobyteslatitude);
        });

       break;
     case error.TIMEOUT:
	     $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
        var datas = (JSON.stringify(data, null, 2));
        document.getElementById("long").value = (data.geobyteslongitude);
        document.getElementById("lat").value = (data.geobyteslatitude);
        });

       break;
     case error.UNKNOWN_ERROR:
	     $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
        var datas = (JSON.stringify(data, null, 2));
        document.getElementById("long").value = (data.geobyteslongitude);
        document.getElementById("lat").value = (data.geobyteslatitude);
        });

       break;
   }
 }
 </script>
<style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  padding: 10px;
}
.grid-item {
  width: 25%;
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  text-align: center;
}
</style>
<body onload="getLocation();" style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
