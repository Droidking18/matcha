<?php

session_start();

//Array ( [gender] => M [gender-pref] => F [dph] => logodovi.png [pho1] => [pho2] => [pho3] => [pho4] => [long] => Longitude location is 27.8962176 [lat] => Longitude location is -26.148864 [dp] => 'base64string.. very long' [ph1] => [ph2] => [ph3] => [ph4] => [interest] => #yes )


$gen = $_POST['gender'];
$lat = $_POST['lat'];
$long = $_POST['long'];
$gen_pref = $_POST['gender-pref'];
if (isset($_POST['ph1']))
	$pic1 = $_POST['ph1'];
else
	$pic1 = "none";
if (isset($_POST['ph2']))
	$pic2 = $_POST['ph2'];
else
	$pic2 = "none";
if (isset($_POST['ph3']))
	$pic3 = $_POST['ph3'];
else
	$pic3 = "none";
if (isset($_POST['ph4']))
	$pic4 = $_POST['ph4'];
else
	$pic4 = "none";
$dp = $_POST['dp'];
$interest = $_POST['interest'];

if (isset($interest) && isset($long) && isset($gen) && isset($gen_pref) && isset($dp))


