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

function get_last_rec($arr) {
    foreach ($not[0][message] as $key => $message) {
        if (preg_match ("/rec/", $key)) {
            $it = $key;
        }
    }
    return ($it);
}

function get_last_sen($arr) {
    foreach ($not[0][message] as $key => $message) {
        if (preg_match ("/sen/", $key)) {
            $it = $key;
        }
    }
    return ($it);
}


