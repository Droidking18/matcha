<?php

include ("header.php");
include ("../config/config.php");


$conn = getDB();
$sql = "SELECT dp, first_name, last_name, login, DOB FROM users";
foreach ($conn->query($sql) as $user) {
          $original = $message['messages'];
}
if (!isset($_POST['age_low']) && !isset($_POST['age_high']) && !isset($_POST['interest']) && !isset($_POST['loc']) && !isset($_POST['distance']))
	echo "<form method=POST>
		<input type=text name=age_low>
		<input type=text name=age_high><br>
		<input type=text name=interest>
		<input type=hidden name=loc>
		<input type=text name=distance>
		<input type=submit>";
else if(checks/validate all data here == true)
	perform search and return array of all matching users.

?>
	<div class='grid-item'> <a href='profiles.php?user=<?php echo "hi";//USERNAME//?>'><img height=200 class='photo' id='base64image'
           src=https://c1.staticflickr.com/5/4851/32333455718_46d068a3d9_b.jpg></a></div>
