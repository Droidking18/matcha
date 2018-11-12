<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (session_status() == 1) {
    session_start();
}
include ("../config/config.php");
include ("backcheck.php");


if (isset($_SESSION['login'])) {
    $conn = getDB();
    if ($_POST['type'] == "password" && !checkPass($_POST['detail']))
	    exit ("No. Thanks. No. <meta http-equiv='refresh' content='2;url=login.php' />");
    if ($_POST['type'] == "password")
	    $_POST['detail'] = password_hash($_POST['detail'], PASSWORD_BCRYPT);
    if ($_POST['type'] == "email" && !checkEmail($_POST['detail']))
	    exit ("No. Thanks. No. <meta http-equiv='refresh' content='2;url=login.php' />");
    if ($_POST['type'] == "login" && !checkLogin($_POST['detail']))
	    exit ("No. Thanks. No. <meta http-equiv='refresh' content='2;url=login.php' />");
    if (password_verify($_POST['password'], $_SESSION['passhash'])) {
             if ($_POST['type'] == "notify" && $_POST['detail'] != "Y" || $_POST['type'] == "notify" && $_POST['detail'] != "N" || $_POST['type'] != "notify") {
                 try {
                     $sql = "UPDATE users SET " . $_POST['type'] . "= ?  WHERE login = ?";
                     $statement= $conn->prepare($sql);
                     $statement->execute([$_POST['detail'], $_SESSION['login']]);
                     if ($_POST['type'] == "login")
                         $_SESSION['login'] = $_POST['detail'];
                     if ($_POST['type'] == "email")
                         $_SESSION['email'] = $_POST['detail'];
                     if ($_POST['type'] == "password")
                         $_SESSION['passhash'] = $_POST['detail'];
                 } catch (exception $e) {
                     echo $e->getMessage() . "\n";
                     exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=account.php' />");
                 }
             }
             if ($_POST['type'] == "email") {
                 try {
                     $sql = "UPDATE users SET emailverify = 'N'  WHERE login = ?";
                     $statement= $conn->prepare($sql);
                     $statement->execute([$_SESSION['login']]);
                     exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=logout.php' />");
                 } catch (exception $e) {
                     echo $e->getMessage() . "\n";
                     exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=account.php' />");
                 }
             }
        }
    else
        exit ("Password entered was incorrect. <meta http-equiv='refresh' content='3;url=account.php' />");
    echo "<meta http-equiv='refresh' content='0;url=index.php' />";
}
