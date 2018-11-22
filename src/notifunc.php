<?php

include ("../config/config.php");

function add_to_not($message, $sender, $login) {
    $conn = getDB();
    $sql = "SELECT notifications FROM users WHERE login = \"" . $login . "\"";
    foreach ($conn->query($sql) as $notification) {
        $original  = $notification['notifications'];
    }
    $new = unserialize($original);
    $arr_not = (["message" => $message, "user" => $sender, "id" => uniqid('', TRUE)]);
    array_push ($new, $arr_not);
    $sql = "UPDATE users SET notification = ?, notifications = ?  WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute(["Y", serialize($new), $login]);
    $_SESSION['notification'] = "Y";
    return true;
}
