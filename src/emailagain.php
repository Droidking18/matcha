<?php

include ("mail.php");
include ("../config/config.php");

    if (!$_GET['user'])
        exit("Bad link.");
    $conn = getDB();
    $sql = "SELECT * FROM Users WHERE login = '" . $_GET['user'] . "';";
    foreach ($conn->query($sql) as $user) {
       mail_ver($user['id'], $user['email']);}
    echo "<meta http-equiv='refresh' content='0;url=login.php' />";

