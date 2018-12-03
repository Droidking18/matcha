<?php

session_start();
include ("../config/config.php");
include ("header.php");
include ("visits.php");

if (isset($_SESSION['login']))
    getLoggedHead();
else
    exit ("Please login first. <meta http-equiv='refresh' content='1;url=login.php?page=1' />");
if ($_SESSION['profile'] == "N")
    exit ("Please enter your other details first. <meta http-equiv='refresh' content='1;url=profile.php?page=1' />");
if (!isset($_GET['user']))
    exit ("Bad link. <meta http-equiv='refresh' content='1;url=index.php?page=1' />");

$conn = getDB();
$stmt = $conn->prepare("SELECT * FROM users WHERE login=?");
$stmt->execute([$_GET['user']]);
$user = $stmt->fetch();
if (!is_array($user))
    exit ("bad link <meta http-equiv='refresh' content='1;url=profile.php?page=1' />");
else { 
    if ($user['rating'] == NULL)
        $rate = 1;
    if (visits_check($user['visits'], $_SESSION['login']) != NULL){
        if ($user['rating'] != NULL)
            $rate = $user['rating'] + 1;
        $conn = getDB();
        $sql = "UPDATE users SET rating = ?, visits = ? WHERE login = ?";
        $statement= $conn->prepare($sql);
        $statement->execute([$rate, visits_check($user['visits'], $_SESSION['login']), $_GET['user']]);
    }
}
print_r ($user);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
  setInterval(function () { $.ajax({
      url: 'online.php',
      success: function(){}
  }); }, 5000);
</script>
