<?php

function checkEmail($email)
{
    $re = "/^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,15}$/";
    if(!preg_match($re, "$email"))
	    return false;
    else
    	return true;
}

function checkName($name)
{
    $re = "/^[A-Za-z]+$/";
    if (!preg_match($re, "$name"))
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

function checkInterest($int){
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
    return ($arr);
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
    $decoded = base64_decode($b64, true);
    if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $b64)) 
        return false;
    if (!base64_decode($b64, true)) 
        return false;
    if (base64_encode($decoded) != $b64) 
        return false;
    return true;
}
?>
