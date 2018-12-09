<?php
session_start();
include ("../config/config.php");
 $exist = -1;
 $conn = getDB();
 $sql = "SELECT messages, message FROM users WHERE login = \"$_SESSION[login]\"";
 foreach ($conn->query($sql) as $message) {
     $original = $message['messages'];
     $mes = $message['message'];
 }
 $new = unserialize($original);
 foreach ($new as $key=>$thread) {
	 if ($_GET['id'] == $thread['id']) {
	     $exist = $key;
	     break;
	 }
 }
 $messa = "";
foreach ($new[$exist]['message'] as $key => $text)
{
         if (preg_match("/sen/", $key))
              $messa .= "<div style=\"position: relative; display: block; float: left; left: 6%;\" class=\"box sb2\">" .  htmlspecialchars($text)  . "</div>";
         if (preg_match("/rec/", $key))
              $messa .= "<div style=\"position: relative; display: block; float: right; right: 6%;\" class=\"box sb1\">" . htmlspecialchars($text) . "</div>";
}
echo $messa;
