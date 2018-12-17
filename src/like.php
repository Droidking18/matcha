<?php

session_start();

include("message_check.php");
include ("../config/config.php");
include ("visits.php");
include ("notifunc.php");

if (!isset($_SESSION['login']))
    exit("Login bruh. <meta http-equiv='refresh' content='2;url=login.php' />");
if ($_SESSION['profile'] == 'N')
    exit("Hi, ". htmlspecialchars($_SESSION['login']) .  ". Tell us about yourself. <meta http-equiv='refresh' content='2;url=profile.php' />");
if (!isset($_GET['user']) || $_GET['user'] == $_SESSION['login'])
    exit("Bad link. <meta http-equiv='refresh' content='1;url=index.php' />");
$conn = getDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
$stmt->execute([$_GET['user']]);
$user = $stmt->fetch();
if (!is_array($user))
    exit ("bad link <meta http-equiv='refresh' content='1;url=profile.php?page=1' />");
else {
    if (visits_check($user['dislikes'], $_SESSION['login']) == NULL){
         exit ("You already dislike this user. first unlike the user to dislike them. <meta http-equiv='refresh' content='2;url=index.php' />");
     }
    if ($user['rating'] == NULL)
        $rate = 2;
    if (strlen(likes_check($user['likes'], $_SESSION['login'])) > strlen($user['likes'])) {
         if ($user['rating'] != NULL) {
            $rate = $user['rating'] + 2;
            add_to_not("You got a new like at " .  date("Y.m.d h:i:s A", strtotime("-2")), $_SESSION['login'], $user['login']);
         }
    }
    else {
         if ($user['rating'] != NULL)
             $rate = $user['rating'] - 2;
    }
         $conn = getDB();
         $sql = "UPDATE users SET rating = ?, likes = ? WHERE login = ?";
         $statement= $conn->prepare($sql);
         $statement->execute([$rate, likes_check($user['likes'], $_SESSION['login']), $_GET['user']]);
         $_SESSION['likes'] = likes_check($user['likes'], $_SESSION['login']);
}
exit("<meta http-equiv='refresh' content='0;url=profiles.php?user=$user[login]' />");
?>

<body style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
