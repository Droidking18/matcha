<?php

include ("../config/config.php");
session_start();

function reportOn() {
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
