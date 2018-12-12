<?php

session_start();
include ("../config/config.php");

if (!isset($_SESSION['login']))
    exit("");
$conn = getDB();
$sql = "SELECT message FROM users WHERE login = \"$_SESSION[login]\"";
foreach ($conn->query($sql) as $online) {
    $not = $online['message'];
}

if ($not == "Y")
    echo ("Messages <font class='blink'>❣️</font><br><font size=1>You have messages.</font>");
else
    echo ("Messages<br><font size=1>You have no messages.</font>");

?>

<style>
.blink {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% { opacity: 0; }
}
</style>
