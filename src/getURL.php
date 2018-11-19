<?php

function getURLmail() {
    $URL = ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    $arr = (explode("/", $URL));
    $arr = array_slice($arr, 0, sizeof($arr) - 1);
    return (implode ("/", $arr) . "/mailver.php?id=");
}

function getURLaction() {
    $URL = ("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
    $arr = (explode("/", $URL));
    $arr = array_slice($arr, 0, sizeof($arr) - 1);
    return (implode ("/", $arr) . "/action.php?id=");
}
