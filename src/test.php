<?php

session_start();

include ("notifunc.php");

add_to_not("TEST MESSAGE", "TEST SENDER", $_SESSION['login']);
echo "K done";
