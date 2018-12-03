<?php

session_start();
include ("../config/config.php");

$conn = getDB();
$sql = "SELECT online FROM users WHERE login = \"$_SESSION[person]\"";
foreach ($conn->query($sql) as $online) {
    $last = $online['online'];
}

if (!isset($last) || $last == 0)
    echo ($_SESSION['person']);
else if (mktime() - $last <= 9)
    echo ($_SESSION['person'] . "🔵");
else
    echo ($_SESSION['person'] . " last seen on " . date("j F Y h:i:s A", $last + 36000));
