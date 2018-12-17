<?php

include ("header.php");
include ("../config/config.php");
include ("backcheck.php");
include ("checkSearch.php");
include ("gps.php");
include ("age.php");
include ("visits.php");

session_start();

if (isset($_SESSION['login'])) {
	$_POST['long'] = $_SESSION['long'];
	$_POST['lat'] = $_SESSION['lat'];
	getLoggedHead();
}
else
	getHead();
if (isset($_SESSION['profile']) && $_SESSION['profile'] == "N")
	exit ("First tell us about yourself.<meta http-equiv='refresh' content='0;url=profile.php' />");

$conn = getDB();
$switch = "no";
if (!isset($_POST['age_low']) && !isset($_POST['age_high']) && !isset($_POST['interest']) && !isset($_POST['loc']) && !isset($_POST['distance']))
	echo "<form onchange='getLocation();' method=POST>
		<input style='width: 69%;' placeholder='Enter a minimum age.' type=text name=age_low required >
		<input style='width: 69%;' placeholder='Enter a maximum age.' type=text name=age_high required><br>
		<input style='width: 69%;' placeholder='Enter one of more interest (tags starting with `#` and seperated by spaces.)' type=text name=interest>
		<input id='loc' type=hidden name=loc>
		<input id='lat' type=hidden name=lat>
		<input id='long' type=hidden name=long>
		<input style='width: 69%;' placeholder='Enter how far they can be. (Max amount of KM away. May be inaccuarate if you don`t share your location.)' type=text name=distance required>
        <input style='width: 69%;' placeholder='Enter gender wanted. that is:  M, F or O'  type=text name=gender required><br>
        <input type='button' value='Share your current location' onclick='getLocation()'>
		<input type=submit>";
else if(checkInterest($_POST['interest'], 1) != false && checkSearch($_POST['age_low'], $_POST['age_high'], $_POST['distance'], $_POST['gender'], $switch) == "true") {
	$int = checkInterest($_POST['interest'], 1);
	$matches = [];
	$sql = "SELECT DISTINCT * FROM users ORDER BY rating DESC";
	foreach ($conn->query($sql) as $key=>$profile) {
		$intmatch = ($profile['interests']);
        $dist = distance($_POST['lat'], $_POST['long'], $profile['lat'], $profile['long']);
        $age = age_calc($profile['dob']);
		if ($_POST['gender'] == $profile['gen'] && $age >= $_POST['age_low'] && $age <= $_POST['age_high'] && $dist <= $_POST['distance'] && interestMatch($int, $intmatch) && visits_check($profile['blocks'], $_SESSION['login']) != NULL && $profile['profile'] == "Y"){
			array_push($matches, $profile);
		}
	}
	echo "<div class='grid-container'>";
	if (sizeof($matches) > 0) {
		foreach($matches as $found) {
			echo "<div class='grid-item'><p style='font-size:medium'>" . $found['login'] . "<br>"  . $found['first_name'] . " " . $found['last_name'] . "<br>Age: " . age_calc($found['dob']) . "<br>They are " . round(distance($_POST['lat'], $_POST['long'], $found['lat'], $found['long'])) . " km away from you.<br>"; 
		if (isset($_SESSION['login']))
			echo "Click <a href='profiles.php?user=" . $found['login'] . "'>here</a> to  meet them!";
		else
			echo "Click <a href='signup.php'>here</a> to signup!";
            echo"<p><br><img style= 'width:100%;'src='data:image/png;base64," . $found['dp'] . "'></div>";
        }
		echo "</div>";
    }
    else
        echo "<p> No matches found for that search :(</p>";

	}
else if (isset($_POST['gender'])) {
	if (checkInterest($_POST['interest'], 1) == false)
		echo "You interests must all start with a '#' and be seperated by spaces.";
    $ret = checkSearch($_POST['age_low'], $_POST['age_high'], $_POST['distance'], $_POST['gender'], $switch);
    if ($switch == "no")
	    echo $ret . "<meta http-equiv='refresh' content='1;url=search.php' />";
    else
        echo $ret;
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script>
function getLocation() {
    if (document.getElementById("lat") == null)
        return;
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
       console.log(data.geobyteslongitude);
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
input{
  height:50px;
}

::-webkit-input-placeholder { /* Chrome/Opera/Safari */
  white-space:pre-line;
  position:relative;
  top:-7px;

}
::-moz-placeholder { /* Firefox 19+ */
     white-space:pre-line;
  position:relative;
  top:-7px;
}
:-ms-input-placeholder { /* IE 10+ */
    white-space:pre-line;
  position:relative;
  top:-7px;
}
:-moz-placeholder { /* Firefox 18- */
     white-space:pre-line;
  position:relative;
  top:-7px;
}
.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  padding: 10px;
}
.grid-item {
  width: 80%;
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  text-align: center;
}
</style>
<body onload="getLocation();"style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script>
 setInterval(function () { $.ajax({
     url: 'online.php',
     success: function(){}
 }); }, 5000);
setInterval(function () { $.ajax({
       url: 'checknot.php?',
       data: { },
       success: function(data){ $("#not").html(data);}
   }); }, 5000);
        setInterval(function () { $.ajax({
       url: 'checkmes.php?',
       data: { },
       success: function(data){ $("#mes").html(data);}
   }); }, 5000);
 </script>

