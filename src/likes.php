<?php

session_start();
include ("../config/config.php");
include ("header.php");

if (isset($_SESSION['login']))
	getLoggedHead();
$conn = getDB();
 $sql = "SELECT likes FROM images WHERE id = " . $_GET['id'];
 echo "<H1 style='color: white; margin: auto; width: 50%; text-align:center;'> Likes 👍</H1>";
 foreach ($conn->query($sql) as $image)
 {
	 $likes = unserialize($image['likes']);
 }
echo "<table style='width:100%'>";
 	foreach ($likes as $like)
		 echo "<tr> <th>" . $like . "</th> </tr>";
echo "</table>";

?>

<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
