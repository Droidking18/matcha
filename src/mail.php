<?php

include ("getURL.php");

function mail_ver($id, $email) {
    $msg = "Hi, please click this link to activate your account: " . getURLmail() . $id ;
    mail($email,"Hinder verification",$msg);
}

function mail_comm ($login, $comment, $sender, $email, $phid) { 
    $msg = "Hi, " . $login . "! " . ucfirst($sender) . " has commented \"" . $comment  . "\" on your photo (" . getURLaction() . $phid . ").";
    mail($email, "Hinder | You got comments", $msg);
}

function mail_like ($login, $sender, $email, $phid) { 
    $msg = "Hi, " . $login . "! " . ucfirst($sender) . " has liked your photo (" . getURLaction() . $phid . ").";
    mail($email, "Hinder | You got comments", $msg);
}
?>
