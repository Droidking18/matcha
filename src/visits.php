<?php

function visits_check($arr, $me) {
    if ($arr == "" || strlen($arr) < 5)
        return (serialize([$me]));
    $visits = unserialize($arr);
    foreach ($visits as $visit) {
        if ($visit == $me)
            return (NULL);
    }
    array_push($visits, $me);
    return (serialize($visits));
}

function likes_check($arr, $me) {
    if ($arr == "" || strlen($arr) < 5)
        return (serialize([$me]));
    $visits = unserialize($arr);
    foreach ($visits as $key => $visit) {
        if ($visit == $me) {
            unset($visits[$key]);
            return (serialize($visits));
        }
    }
    array_push($visits, $me);
    return (serialize($visits));
}
