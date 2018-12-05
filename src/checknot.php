<?php

session_start();
include ("../config/config.php");


$conn = getDB();
$sql = "SELECT notification FROM users WHERE login = \"$_SESSION[login]\"";
foreach ($conn->query($sql) as $online) {
    $not = $online['notification'];
}

if ($not == "Y")
    echo ("Notifications <font class='blink'>🔺</font><br><font size=1>You have notifications.</font>");
else
    echo ("Notifications<br><font size=1>You have no notifications.</font>");
?>

<style>
 .blink {
   animation: blinker 1s linear infinite;
 }

 @keyframes blinker {
   50% { opacity: 0; }
 }
 </style>
