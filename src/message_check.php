<?php

function check_new_messages() {
     $conn = getDB();
     $sql = "SELECT message FROM users WHERE login=\"$_SESSION[login]\"";
     foreach ($conn->query($sql) as $notification) {
         if ($message['message'] == "Y")
             $_SESSION['message'] == "Y";
         if ($message['message'] == "N")
             $_SESSION['message'] == "N";
     }
}

?>
