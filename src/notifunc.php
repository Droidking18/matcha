<?php

//include ("../config/config.php");



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
    $it = -1;
    foreach ($arr[message] as $key => $message) {
        if (preg_match ("/rec/", $key)) {
            $it = $key;
        }
    }
    preg_match_all ("/[0-9]+/", $it, $number);
    preg_match_all ("/[a-z]+/", $it, $word);
    if ($it == -1)
	    return ("rec1");
    return ($word[0][0] . (string)(int)($number[0][0] + 1));
}

function get_last_sen($arr) {
    $it = -1;
    foreach ($arr as $key => $message) {
        if (preg_match ("/sen/", $key)) {
            $it = $key;
        }
    }
    preg_match_all ("/[0-9]+/", $it, $number);
    preg_match_all ("/[a-z]+/", $it, $word);
    if ($it == -1)
	    return ("sen1");
    return ($word[0][0] . (string)(int)($number[0][0] + 1));
}

function send_message($user, $message_user, $inverted) {
    $conn = getDB();
    $exist = -1;
    $sql = "SELECT messages FROM users WHERE login = \"" . $_SESSION['login'] . "\"";
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

    /****************** new *****************************/
    $existsinvert = -1;
    $sql = "SELECT messages FROM users WHERE login = \"" . $new[$exist]['user'] . "\"";
    foreach ($conn->query($sql) as $inverted_mess) {
         $inv = $inverted_mess['messages'];
    }
    $invs = unserialize($inv);
    foreach ($invs as $keyin=>$checkexistsinvert) {
	    if ($checkexistsinvert['user'] == $_SESSION['login']) {
		    $existsinvert = $keyin;
	    }
    }
    if ($existsinvert == -1)
	    $existsinvert = $keyin + 1;
    if (!isset($keyin))
	    $existsinvert = 0;
    /****************** new *****************************/

    $invert = array_values($new[$exist]['message']);
    foreach($invert as $key => $new_arr) {
        $invert[$arr[$key]] = $new_arr;
        unset($invert[$key]);
    }
    $new_invert = $invs;
    echo ("<br>$existsinvert");
    $new_invert[$existsinvert]['message'] = $invert;
    $new_invert[$existsinvert]['user'] = $_SESSION['login'];
    if (!isset($new_invert[$existsinvert]['id']))
	    $new_invert[$existsinvert]['id'] = uniqid('', true);
    //(print_r($new));
    //echo $inv;
    //echo $new[$exist]['user'] . $existsinvert;
    //(print_r($invs));
    //(print_r($invs));
    //exit (print_r($new_invert));
    if ($inverted == 0)
        return (serialize($new));
    else
        return (serialize($new_invert));
}
