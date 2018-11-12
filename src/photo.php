<?php

session_start();
include("../config/config.php");
include ("merge.php");


if (!isset($_SESSION['login']) || !isset($_POST['photo']) || $_POST['photo'] == '' || !isset($_POST['filter']))
    exit ("Bad link. <meta http-equiv='refresh' content='0;url=index.php' />");
$merge = makeImage($_POST['filter'], $_POST['photo']);
try {
    $conn = getDB();
    $sql = "INSERT INTO images (login, image, comments, likes) VALUES (?, ?, ?, ?)";
    $statement=$conn->prepare($sql);
    $statement->execute([$_SESSION['login'], $merge, serialize([]), serialize([])]);
    }
catch (PDOexception $e) {
    echo $e->getMessage();
}
exit ("Photo taken. <meta http-equiv='refresh' content='1;url=upload.php' />");
