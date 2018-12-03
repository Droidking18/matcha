<?php

include ("header.php");
include ("../config/config.php");
session_start();

if (!isset($_GET['page']) || $_GET['page'] <= 0)
	exit ("<meta http-equiv='refresh' content='0;url=index.php?page=1' />");
if ($_SESSION['profile'] == 'N')
	exit("Hi, ". htmlspecialchars($_SESSION['login']) .  ". Tell us about yourself. <meta http-equiv='refresh' content='2;url=profile.php' />");
if ($_SESSION['login'])
    getLoggedHead();
else
	exit ("Please login first. <meta http-equiv='refresh' content='1;url=login.php' />");


$conn = getDB();
$sql = "SELECT * FROM users";
echo "<H1 style='color: white; margin: auto; width: 50%; text-align:center;'> Find matches 😍</H1>";
echo "<div class='grid-container'>";
foreach ($conn->query($sql) as $key=>$profile)
{
    if ($key < $_GET['page'] * 5 && $key >= $_GET['page'] * 5 - 5)
    {
        echo "<div class='grid-item'> <a href='action.php?id=" . $image['id'] . "'><img class='photo' id='base64image'                 
          src='" .  $image['image'] . "' /></a></div>";
    }
}
?>

<html>
<style>
.grid-container {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  padding: 10px;
}
.grid-item {
  background-color: rgba(255, 255, 255, 0.8);
  border: 1px solid rgba(0, 0, 0, 0.8);
  padding: 20px;
  font-size: 30px;
  text-align: center;
}
.photo {
    height: auto;
    width: 100%;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script>
 setInterval(function () { $.ajax({
     url: 'online.php',
     success: function(){}
 }); }, 5000);
 </script>
<body style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
</body>
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
