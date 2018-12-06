<?php

include ("header.php");
include ("../config/config.php");
session_start();

include("message_check.php");

if (!$_SESSION['login'])
   exit ("Please login first. <meta http-equiv='refresh' content='0;url=login.php' />"); 

    $conn = getDB();
    $sql = "UPDATE users SET notification = ? WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute(["N", $_SESSION['login']]);
    $_SESSION['notification'] = "N";

getLoggedHead();
 echo "<body style='background-color:gray'>";

if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == "delete"){
    $conn = getDB();
    $new_not = ([]);
    $i = 0;
    $sql = "SELECT notifications FROM users WHERE login = \"" . $_SESSION['login'] . "\"";
    foreach ($conn->query($sql) as $notifications) {
        $notification = unserialize($notifications['notifications']);
    foreach ($notification as $key=>$not) {
        if ($not['id'] != $_GET['id']) {
            $new_not[$i] = $not;
            $i = $i + 1;
        }
    } 
        $new_not = serialize($new_not);
    }
    $sql = "UPDATE users SET notifications=? WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute([$new_not, $_SESSION['login']]);
    exit ("<meta http-equiv='refresh' content='0;url=notification.php' />");

}

$conn = getDB();
echo "<div style=\"width:80%; margin:0 auto;\">";
echo "<H1 style='color: white; margin: auto; width: 50%; text-align:center;'> Notifications 🗯</H1>";
$sql = "SELECT notifications FROM users WHERE login = \"" . $_SESSION['login'] . "\"";
foreach ($conn->query($sql) as $key=>$notifications) {
    $notification = unserialize($notifications['notifications']);
    foreach ($notification as $notifications) {
        echo "<table style='width:100%; color: white; background: black; border: 1px solid black; border-radius: 25px;'>";
        echo "<tr> <th>" . $notifications['user'] . "</th> <th> " . htmlspecialchars($notifications['message']) . "</th> <th> <a href=?action=delete&id=" . $notifications['id'] ."><img src=\"http://www.pngmart.com/files/3/Red-Cross-Transparent-PNG.png\" width=20> </th> </tr>";
        echo "</table>";
    }
}
echo "</div>";


?>
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
