<?php


function mail_ver($id, $email) {
    $msg = "Hi, please click this link to activate your account: 127.0.0.1:8080/camagru/src/mailver.php?id=" . $id ;
    mail($email,"Instaspam verification",$msg);
}

function mail_comm ($login, $comment, $sender, $email, $phid) { 
    $msg = "Hi, " . $login . "! " . ucfirst($sender) . " has commented \"" . $comment  . "\" on your photo (127.0.0.1:8080/camagru/src/action.php?id=" . $phid . ").";
    mail($email, "You got comments", $msg);
}

function mail_like ($login, $sender, $email, $phid) { 
    $msg = "Hi, " . $login . "! " . ucfirst($sender) . " has liked your photo (127.0.0.1:8080/camagru/src/action.php?id=" . $phid . ").";
    mail($email, "You got comments", $msg);
}
?>
