<?php

session_start();
include ("../config/config.php");


$conn = getDB();
$sql = "SELECT online, rating FROM users WHERE login = \"$_GET[user]\"";
foreach ($conn->query($sql) as $online) {
    $last = $online['online'];
}

if (!isset($last) || $last == 0)
    echo ("");
else if (mktime() - $last <= 9)
    echo ("<b><u> 🔵" . "Rating:" . $online['rating'] . ". Currently online.</b></u>");
else
    echo ("<b><u> last seen on " . date("j F Y h:i:s A", $last + 36000) . "</b></u>");
