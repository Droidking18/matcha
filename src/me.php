<?php

session_start();
include ("../config/config.php");
include ("header.php");
include ("visits.php");
include ("age.php");


if (isset($_SESSION['login']))
    getLoggedHead();
else
    exit ("Please login first. <meta http-equiv='refresh' content='1;url=login.php' />");
if ($_SESSION['profile'] == "N")
    exit ("Please enter your other details first. <meta http-equiv='refresh' content='1;url=profile.php' />");
$conn = getDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_SESSION['login']]);
$user = $stmt->fetch();

$noimage = "<div style='display: inline;'> <img width=24% height=auto src='https://vignette.wikia.nocookie.net/citrus/images/6/60/No_Image_Available.png/revision/latest?cb=20170129011325'></div>";
echo "<div style='width: 50%; float:right;'>";
echo "<div > <img width=100% src='data:image/png;base64, " . $user['dp'] .  "'></div>";
echo "<div>";
if (strlen($user['image1']) > 10)
    echo "<div style='display: inline;'> <img width=24% height=auto src='data:image/png;base64, " . $user['image1'] .  "'></div>";
else
    echo $noimage;
if (strlen($user['image2']) > 10)
    echo "<div style='display: inline;'> <img width=24% height=auto src='data:image/png;base64, " . $user['image2'] .  "'></div>";
else
    echo $noimage;
if (strlen($user['image3']) > 10)
    echo "<div style='display: inline;'> <img width=24% height=auto src='data:image/png;base64, " . $user['image3'] .  "'></div>";
else
    echo $noimage;
if (strlen($user['image4']) > 10)
    echo "<div style='display: inline;'> <img width=24% height=auto src='data:image/png;base64, " . $user['image4'] .  "'></div>";
else
    echo $noimage;
echo "</div>";
echo "</div>";

echo "<div>";
echo "<div style='overflow-wrap: break-word;'>";
echo "<p style='text-align: center;'><b><u>$user[first_name] $user[last_name] (aka $user[login]) Rating: $user[rating]</p><p id='on' style='text-align: center;'></p></b></u><ul>";
echo "<li>Gender is ";
if ($user['gen'] == "M")
    echo "male and you are interested in ";
else if ($user['gen'] == "F")
    echo "female and you are interested in ";
else
    echo "other and you are interested in ";
if ($user['gen_pref'] == "M")
    echo "men.";
else if ($user['gen_pref'] == "F")
    echo "women.";
else
    echo "the other.<\li>";
echo "<li>" . age_calc($user['dob']) . " years old. ($user[dob])</li>";
echo "<li>Interests:  " . implode(", ", unserialize($user['interests'])) . "</li>";
echo "<li>You have " .  sizeof(unserialize($user['likes'])) . " like(s).</li>";
echo "<li>You have " .  sizeof(unserialize($user['dislikes'])) . " dislike(s).</li>";
echo "<li>You have " .  sizeof(unserialize($user['blocks'])) . " block(s).</li>";
echo "</div>";

?>
<body onload="initMap()" style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmYL_RYUuIyQfN_Qjvyoh5ShExlX4yaNU&callback=initMap" type="text/javascript"></script>
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

  var map;
  function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: <?php echo $user['lat']; ?>, lng: <?php echo $user['long']; ?>},
    zoom: 15
    });
  }
</script>
<div style="height: 50%"id="map"></div>
<div style="text-align:center; margin-left:auto; margin-right:auto;">
</div>
