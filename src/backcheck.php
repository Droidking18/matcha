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

?>
