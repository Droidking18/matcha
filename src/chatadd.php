<?php

include("notifunc.php");
include ("../config/config.php");
include ("visits.php");

session_start();

$conn = getDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_SESSION['login']]);
$me = $stmt->fetch();
$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_GET['user']]);
$them = $stmt->fetch();

if (!(visits_check($me['likes'], $them['login']) == NULL && visits_check($them['likes'], $me['login'] == NULL)))
    exit ("Only matches can talk <meta http-equiv='refresh' content='1;url=index.php' />"); 
	

if (!isset($_SESSION['login']))
    exit ("Login please. exit <meta http-equiv='refresh' content='1;url=login.php' />"); 
if (!isset($_GET['user']) || !isset($_POST['message']))
    exit ("Bad link. exit <meta http-equiv='refresh' content='1;url=index.php' />"); 
$sen = send_message($_GET['user'], $_POST['message'], 0);
$rec = send_message($_GET['user'], $_POST['message'], 1);
$conn = getDB();
$sql = "UPDATE users SET messages = ? WHERE login = ?";
$statement= $conn->prepare($sql);
$statement->execute([$sen, $_SESSION['login']]);
$sql = "UPDATE users SET messages = ?, message = ?  WHERE login = ?";
$statement= $conn->prepare($sql);
$statement->execute([$rec, "Y", $_GET['user']]);
exit ("<meta http-equiv='refresh' content='0;url=message.php'/>");
