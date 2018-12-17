<?php

session_start();

include("message_check.php");
include ("backcheck.php");
include ("../config/config.php");

$conn = getDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_SESSION['login']]);
$me = $stmt->fetch();


if (isset($_POST['passwordcon']))
	if (!password_verify($_POST['passwordcon'], $me['password']))
		exit ("Wrong password entered. <meta http-equiv='refresh' content='3;url=account.php' />");
if (isset($_POST['login']) && isset($_POST['email']) && isset($_POST['passwordcon']) && isset($_POST['password'])) {
	 if (checkPass($_POST['password']) && checkLogin($_POST['login']) && checkEmail($_POST['email'])) {
		 $pass =  password_hash($_POST['password'], PASSWORD_BCRYPT);
		 $email = $_POST['email'];
		 $login = $_POST['login'];
		 $sql = "UPDATE users SET `email` = ?, `login` = ?, `password` = ?  WHERE login = ?";
	         $statement= $conn->prepare($sql);
	         $statement->execute([$_POST['email'], $_POST['login'], $pass, $_SESSION['login']]);
	         $_SESSION['login'] = $login;
	         $_SESSION['password'] = $pass;
	         $_SESSION['email'] = $email;
	 }
	 else
		 echo "Bad data entered.";
}
$first_name = ucfirst(strtolower($_POST['first_name']));
$last_name = ucfirst(strtolower($_POST['last_name']));
$gen_pref = $_POST['gender-pref'];
$gen = $_POST['gender'];
if (isset($_POST['ph1']) && strlen($_POST['ph1']) > 16) {
    $pic1 = $_POST['ph1'];
    $_SESSION['ph1'] = $pic1;
}
else
	$pic1 = $_SESSION['ph1'];
if (isset($_POST['ph2']) && strlen($_POST['ph2']) > 16) {
    $pic2 = $_POST['ph2'];
    $_SESSION['ph2'] = $pic2;
}
else
	$pic2 = $_SESSION['ph2'];
if (isset($_POST['ph3']) && strlen($_POST['ph3']) > 16) {
    $pic3 = $_POST['ph3'];
    $_SESSION['ph3'] = $pic3;
}
else
	$pic3 = $_SESSION['ph3'];
if (isset($_POST['ph4']) && strlen($_POST['ph4']) > 16) {
    $pic4 = $_POST['ph4'];
    $_SESSION['ph4'] = $pic4;
}
else
	$pic4 = $_SESSION['ph4'];
if (isset($_POST['dp']) && strlen($_POST['dp']) > 16) {
    $dp = $_POST['dp'];
    $_SESSION['dp'] = $dp;
}
else
    $dp = $_SESSION['dp'];
$interest = checkInterest($_POST['interest'], 0);
$lat = $_POST['lat'];
$long = $_POST['long'];
$dob = $_POST['dob'];



if (isset($interest) && isset($long) && isset($lat) && isset($gen) && isset($gen_pref) && checkGen($gen) && checkGen($gen_pref) && isset($dp) && isset($dob) && checkDob($dob)  && isset($first_name) && isset($last_name) && checkName($first_name) && checkName($last_name)) {
    try  {
        $conn = getDB();
        $sql = "UPDATE users SET `interests` = ?, `first_name` = ?, `last_name` = ?, `dp` = ?, `dob` = ?, `image1` = ?, `image2` = ?, `image3` = ?, `image4` = ?, `lat` = ?, `long` = ?, `gen_pref` = ?, gen = ?, profile = ?, notification = ?  WHERE login = ?";
        $statement= $conn->prepare($sql);
        $statement->execute([$interest, $first_name, $last_name, $dp, $dob, $pic1, $pic2, $pic3, $pic4, $lat, $long, $gen_pref, $gen, "Y", "N", $_SESSION['login']]);
        $_SESSION['name'] = $first_name;
        $_SESSION['lastname'] = $last_name;
        $_SESSION['dob'] = $dob;
        $_SESSION['gen_pref'] = $gen_pref;
        $_SESSION['dp'] = $dp;
        $_SESSION['ph1'] = $pic1;
        $_SESSION['ph2'] = $pic2;
        $_SESSION['ph3'] = $pic3;
        $_SESSION['ph4'] = $pic4;
        $_SESSION['interest'] = checkInterest($interest, 0);
        $_SESSION['lat'] = $lat;
        $_SESSION['long'] = $long;
        $_SESSION['profile'] = "Y";
        $_SESSION['interest'] = implode(" ", unserialize(($interest)));
        $_SESSION['gen'] = $gen;
    } catch (exception $e) {
        echo $e->getMessage() . "\n";
        exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=account.php' />"); 
    }
}
else {
	exit ("Sorry, something went wrong. <meta http-equiv='refresh' content='30;url=account.php' />");
}
exit("Now, that we know about you, you can go start hindering people. Enjoy. <meta http-equiv='refresh' content='3;url=index.php' />");
