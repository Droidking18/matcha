<?php

session_start();

include("message_check.php");
include ("backcheck.php");
include ("../config/config.php");

//Array ( [gender] => M [gender-pref] => F [dph] => logodovi.png [pho1] => [pho2] => [pho3] => [pho4] => [long] => Longitude location is 27.8962176 [lat] => Longitude location is -26.148864 [dp] => 'base64string.. very long' [ph1] => [ph2] => [ph3] => [ph4] => [interest] => #yes )



$gen = $_POST['gender'];
$lat = $_POST['lat'];
$long = $_POST['long'];
$dob = ($_POST['dob']);
$first_name = ucfirst(strtolower($_POST['first_name']));
$last_name = ucfirst(strtolower($_POST['last_name']));
$gen_pref = $_POST['gender-pref'];
if (isset($_POST['ph1']))
	$pic1 = $_POST['ph1'];
else
	$pic1 = NULL;
if (isset($_POST['ph2']))
	$pic2 = $_POST['ph2'];
else
	$pic2 = NULL;
if (isset($_POST['ph3']))
	$pic3 = $_POST['ph3'];
else
	$pic3 = NULL;
if (isset($_POST['ph4']))
	$pic4 = $_POST['ph4'];
else
	$pic4 = NULL;
$dp = $_POST['dp'];
$interest = checkInterest($_POST['interest']);

if (isset($interest) && isset($long) && isset($lat) && isset($gen) && isset($gen_pref) && checkGen($gen) && checkGen($gen_pref) && isset($dp) && isset($dob) && checkDob($dob)  && isset($first_name) && isset($last_name) && checkName($first_name) && checkName($last_name)) {
    try  {
        $conn = getDB();
        $sql = "UPDATE users SET `interests` = ?, `first_name` = ?, `last_name` = ?, `dp` = ?, `dob` = ?, `image1` = ?, `image2` = ?, `image3` = ?, `image4` = ?, `lat` = ?, `long` = ?, `gen_pref` = ?, gen = ?, profile = ?, notification = ?  WHERE login = ?";
        $statement= $conn->prepare($sql);
        $statement->execute([$interest, $first_name, $last_name, $dp, $dob, $pic1, $pic2, $pic3, $pic4, $lat, $long, $gen_pref, $gen, "Y", "Y", $_SESSION['login']]);
        $_SESSION['name'] = $first_name;
        $_SESSION['lastname'] = $last_name;
        $_SESSION['dob'] = $dob;
        $_SESSION['gen_pref'] = $gen_pref;
        $_SESSION['dp'] = $dp;
        $_SESSION['ph1'] = $pic1;
        $_SESSION['ph2'] = $pic2;
        $_SESSION['ph3'] = $pic3;
        $_SESSION['ph4'] = $pic4;
        $_SESSION['interest'] = checkInterest($interest);
        $_SESSION['lat'] = $lat;
        $_SESSION['long'] = $long;
        $_SESSION['profile'] = "Y";
        $_SESSION['notification'] = "Y";
        $_SESSION['message'] = "Y";
        $_SESSION['interest'] = implode(" ", unserialize(($interest)));
        $_SESSION['gen'] = $gen;
    } catch (exception $e) {
        echo $e->getMessage() . "\n";
        exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=account.php' />"); 
    }
}
else
    echo "something wrong";
exit("Now, that we know about you, you can go start hindering people. Enjoy. <meta http-equiv='refresh' content='3;url=index.php' />");
