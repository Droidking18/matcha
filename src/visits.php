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

