<?php

function checkEmail($email)
{
    $re = "/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,15}$/";
    if(!preg_match($re, "$email"))
	    return false;
    else
    	return true;
}

function checkLogin($login)
{
	$re = "/^\w+$/";
	if(!preg_match($re, "$login"))
		return false;
	else
		return true;
}

function checkPass($pass)
{
	if (!isset($pass) || strlen($pass) < 6 || strlen($pass) > 16)
                 return false;
	$re = "/[0-9]/";
	if(!preg_match($re, $pass))
		return false;
	$re = "/[a-z]/";
	if(!preg_match($re, $pass))
		return false;
	$re = "/[A-Z]/";
	if(!preg_match($re, $pass))
		return false;
	return true;
}

function checkInterest($int, $noneallowed){
    if ($noneallowed == 1 && strlen($int) < 2)
        return (" ");
    $re = "/^\s+$/";
    if (preg_match ($re, $int) || strlen($int) < 2)
        return (false);
    $re = "/^\w+$/";
    $arr =  (array_values(array_filter(explode(" ", $int))));
    $j = 0;
    while ($j < sizeof($arr)) {
        $str =  substr($arr[$j], 1);
        if (!preg_match($re, $str))
            return (false);
        $j++;
    }
    $first = array_map(function ($str) { return ($str[0]); } , $arr);
    $i = 0;
    while ($i < sizeof($first)) {
        if ($first[$i] != '#')
            return (false);
        $i++;
    }
    return (serialize($arr));
}

function checkGen ($gen)
{
    if ($gen == "M" || $gen == "F" || $gen == "O")
        return true;
    else
        return false;
}

function checkLoc ($lat, $long) {
    if (is_float($lat) && is_float($long))
        return (true);
    else
        return (false);
}

function checkBase64 ($b64) {
    if ( base64_encode(base64_decode($data, true)) === $data){
    return true;
    } else {
    return false;
    }
}

function checkDob($date) { 
    $sec = strtotime ($date);
    if ($sec > -1325462380 && $sec < 946684820)
        return true;
    else
        return false;
}

function checkName($name) { 
    $re = "/^[A-Za-z]+$/";
    if (preg_match($re, $name) && strlen($name) < 20 && strlen($name) > 1)
        return true;
    else
        return false;
}

?>
