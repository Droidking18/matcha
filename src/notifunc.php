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
    foreach ($arr[message] as $key => $message) {
        if (preg_match ("/rec/", $key)) {
            $it = $key;
        }
    }
    preg_match_all ("/[0-9]+/", $it, $number);
    preg_match_all ("/[a-z]+/", $it, $word);
    return ($word[0][0] . (string)(int)($number[0][0] + 1));
}

function get_last_sen($arr) {
    foreach ($arr as $key => $message) {
        if (preg_match ("/sen/", $key)) {
            $it = $key;
        }
    }
    preg_match_all ("/[0-9]+/", $it, $number);
    preg_match_all ("/[a-z]+/", $it, $word);
    return ($word[0][0] . (string)(int)($number[0][0] + 1));
}

function send_message($user, $message_user, $) {
    $conn = getDB();
    $exist = -1;
    //$sql = "SELECT messages FROM users WHERE login = \"" . $_SESSION['login'] . "\"";
    $sql = "SELECT messages FROM users WHERE login = 'dkaplan'";
    foreach ($conn->query($sql) as $message) {
        $original = $message['messages'];
    }
    $new = unserialize($original);
    foreach ($new as $key=>$thread) {
        if ($user == $thread['user'])
            $exist = $key;
    }
    if ((string)$exist != "-1") {
        $new[$exist]['message'][get_last_sen($new[$exist]['message'])] = $message_user;
    }
    if ((string)($exist) == "-1") {
        array_push($new, (["message"=>["sen1" => $message_user], "user"=>$user, "id"=>uniqid("", true)]));
        end($new);
        $exist = key($new);
    }
    $arr = (array_keys($new[$exist]['message']));
    foreach ($arr as $key=>$arr_new) {
        if (preg_match("/sen/", $arr_new)) {
            $arr_new = preg_replace("/sen/", "rec", $arr_new);
            $arr[$key] = $arr_new;
        }
        else if (preg_match("/rec/", $arr_new)) {
            $arr_new = preg_replace("/rec/", "sen", $arr_new);
            $arr[$key] = $arr_new;
        }
    }
    //$new[$exist] = array_values($invert[$exist]);
    $invert = array_values($new[$exist]['message']);
    //exit(print_r ($invert));
    foreach($invert as $key => $new_arr) {
        $invert[$arr[$key]] = $new_arr;
        unset($invert[$key]);
    }

    //exit(print_r ($invert));
    $new_invert = $new;
    $new_invert[$exist]['message'] = $invert;
    print_r($new); echo "<br>";
    print_r($new_invert); echo "<br>";
}


$not = ([["message"=>["rec1" => "Welcome, you're now ready to Hinder!", "sen2" => "OK", "rec2" => "no"], "user"=>"Hinder Admins", "id"=>uniqid("", true)]]);
$not = (["message"=>["rec1" => "Welcome, you're now ready to Hinder!", "sen2" => "OK", "rec2" => "no"]]);
//echo get_last_sen($not) . "\n";
//echo get_last_rec($not);
send_message("Hnder Admins", "what");
