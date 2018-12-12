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
	exit ("First login.<meta http-equiv='refresh' content='0;url=login.php' />");
if (isset($_SESSION['profile']) && $_SESSION['profile'] == "N")
	exit ("First tell us about yourself.<meta http-equiv='refresh' content='0;url=profile.php?page=1' />");

$conn = getDB();

$matches = [];

$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_SESSION['login']]);
$me = $stmt->fetch();
$int = checkInterest($me['interest'], 1);

$sql = "SELECT * FROM users ORDER BY rating DESC";
foreach ($conn->query($sql) as $key=>$profile) {
	$intmatch = ($profile['interests']);
    $dist = distance($me['lat'], $me['long'], $profile['lat'], $profile['long']);
    $age = age_calc($profile['dob']);
	if ($me['gen_pref'] == $profile['gen'] && $age <= age_calc($me['dob']) + 10 && $dist <= 20 && visits_check($profile['blocks'], $_SESSION['login']) != NULL){
		array_push($matches, $profile);
		echo "<script> console.log('hi')</script>";
	}
}
	echo "<div class='grid-container'>";
	if (sizeof($matches) > 0) {
        foreach($matches as $key=>$found) {

			echo "<div  style='display:none' class='grid-item' id='" . $key . "'<p style='font-size:medium'>" . $found['login'] . "<br>"  . $found['first_name'] . " " . $found['last_name'] . "<br>Age: " . age_calc($found['dob']) . "<br>They are " . round(distance($_POST['lat'], $_POST['long'], $found['lat'], $found['long'])) . " km away from you.<br>"; 
		echo "Click <a href='profiles.php?user=" . $found['login'] . "'>here</a> to  meet them!";
		//else
		//	echo "Click <a href='signup.php'>here</a> to signup!";
            echo"<p><br><img style= 'width:100%;'src='data:image/png;base64," . $found['dp'] . "'></div>";
        }
		echo "</div>";
    }
    else
        echo "<p> Sorry there are no matches near you  :(</p>";
    echo "<button onclick='switchie()'>";

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    let i = 0;
    let end = 0;
    if (document.getElementById(0) != null)
        document.getElementById(0).style.display = "block";
    while (document.getElementById(end) != null)
        end++;
    end--;
        console.log(end);
    function switchie() {
        if (document.getElementById(i) == null)
          i = 0;
        document.getElementById(i).style.display = "block";
        if (i == 0)
            document.getElementById(end).style.display = "none";
        else
            document.getElementById(i - 1).style.display = "none";
        i++;
        console.log("i: " + i);
        console.log("end: " + end);
    }
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
  /*display: grid;*/
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
