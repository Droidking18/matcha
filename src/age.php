<?php

function age_calc($dob) {
    $dob = strtotime($dob);
    $tdate = time();
    $age = 0;
    while( $tdate > $dob = strtotime('+1 year', $dob))
        ++$age;
    return $age;
}

function interests($int) {
    return implode(unserialize($int));
}
