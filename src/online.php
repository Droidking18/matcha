<?php

include ("../config/config.php");
session_start();

function reportOn() {
    if (!isset($_SESSION['login']))
        return;
    try {
    $conn = getDB();
    $sql = "UPDATE users SET online = ? WHERE login = ?";
    $statement= $conn->prepare($sql);
    $statement->execute([mktime(), $_SESSION['login']]);
    }
    catch (exception $e) {
        exit ($e->getMessage());
    }
}

reportOn();
