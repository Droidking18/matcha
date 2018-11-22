<?php

include ("header.php");
include ("../config/config.php");
session_start();

if (!$_SESSION['login'])
   exit ("Please login first. <meta http-equiv='refresh' content='0;url=login.php' />"); 

if ($_SESSION['notification'] == "Y") { 
    $conn = getDB();
    $sql = "UPDATE users SET notification = ? WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute(["N", $_SESSION['login']]);
    $_SESSION['notification'] = "N";
}

getLoggedHead();
echo "<body background = \"https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg\" style=\"background-size: cover;\">";


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
$sql = "SELECT notifications FROM users WHERE login = \"" . $_SESSION['login'] . "\"";
foreach ($conn->query($sql) as $key=>$notifications) {
    $notification = unserialize($notifications['notifications']);
    foreach ($notification as $notifications) {
        echo "<table style='width:100%; color: white; background: gray; border: 1px solid black; border-radius: 25px;'>";
        echo "<tr> <th>" . $notifications['user'] . "</th> <th> " . htmlspecialchars($notifications['message']) . "</th> <th> <a href=?action=delete&id=" . $notifications['id'] ."><img src=\"http://www.pngmart.com/files/3/Red-Cross-Transparent-PNG.png\" width=20> </th> </tr>";
        echo "</table>";
    }
}
echo "</div>";


?>
