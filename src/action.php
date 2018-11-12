<?php

session_start();
include("header.php");
include ("../config/config.php");
include ("mail.php");

if (!isset($_SESSION['login']))
	exit ("Log in to like or comment. <meta http-equiv='refresh' content='2;url=index.php' />");
else
	getLoggedHead();

if (isset($_GET['action']))
{
    if ($_GET['action'] != "delete")
        exit ("GET LOST. excuse the pun, also it was intended. <meta http-equiv='refresh' content='2;url=index.php' />");
    $conn = getDB();
    $sql = "SELECT * FROM images WHERE id='" . $_GET['id'] . "';";
    foreach ($conn->query($sql) as $key=>$image)
    {
        if ($_SESSION['login'] != $image['login'] && $_SESSION['login'] != "GODMODE")
            exit ("YOU ARE NOT AUTHORIZED TO BE HERE. IF YOU DON'T LIKE THE IMAGE REPORT IT TO SOMEONE WHO CARES <meta http-equiv='refresh' content='2;url=index.php' />");
        else
        {
            $sql = "DELETE FROM `images` WHERE `id` = ?";
            $statement = $conn->prepare($sql);
            $statement->execute([$_GET['id']]);
            exit("Photo deleted <meta http-equiv='refresh' content='1;url=index.php' />");
        }
    }
}

if (isset($_POST['comment'])) {
	$comm = (["comment"=>$_POST['comment'], "login"=>$_SESSION['login']]);
	$conn = getDB();
 	$sql = "SELECT * FROM images WHERE id='" . $_GET['id'] . "';";
	foreach ($conn->query($sql) as $key=>$image)
	{
		$old_comm = unserialize($image['comments']);
		array_push ($old_comm, $comm);
		$new_comm = serialize ($old_comm);
		try {
                      $sql = "UPDATE images SET comments = ?  WHERE id = ?";
                      $statement= $conn->prepare($sql);
                      $statement->execute([$new_comm, $image['id']]);
                } catch (exception $e) {
                      echo $e->getMessage() . "\n";
                      exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=index.php' />");
		}	
    }
    $sql = "select images.id, images.login, users.email, users.notify from images inner join users on users.login=images.login where images.id=" . $image['id'] . ";";
    foreach ($conn->query($sql) as $key=>$image)
    {
        if ($image['notify'] == "Y")
            mail_comm($image['login'], $_POST['comment'] ,$_SESSION['login'], $image['email'], $image['id']);
    }
}

else if (isset($_POST['like'])) {
	$like = $_SESSION['login'];
        $conn = getDB();
        $sql = "SELECT * FROM images WHERE id='" . $_GET['id'] . "';";
        foreach ($conn->query($sql) as $key=>$image)
        {
                $old_like = unserialize($image['likes']);
                array_push ($old_like, $like);
                $new_like = serialize ($old_like);
                try {
                      $sql = "UPDATE images SET likes = ?  WHERE id = ?";
                      $statement= $conn->prepare($sql);
                      $statement->execute([$new_like, $image['id']]);
                } catch (exception $e) {
                      echo $e->getMessage() . "\n";
                      exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=index.php' />");
                }
        }
        $sql = "select images.id, images.login, users.email, users.notify from images inner join users on users.login=images.login where images.id=" . $image['id'] . ";";
        foreach ($conn->query($sql) as $key=>$image)
        {
            if ($image['notify'] == "Y")
                mail_like($image['login'], $_SESSION['login'], $image['email'], $image['id']);
        }
}


$conn = getDB();
$sql = "SELECT * FROM images WHERE id='" . $_GET['id'] . "';";
 foreach ($conn->query($sql) as $key=>$image)
 {
	 echo "<img style='display:block; width:40%; margin: auto;' id='base64image' src='" . $image['image'] . "'/><div style='text-align: center; color: white;'>";
	echo "This photo was uploaded by " . $image['login'] . ".<br>"; 
	if (unserialize($image['comments']) == NULL)
		 echo "There are no comments yet.<br>";
	else
		 echo "<a href='comments.php?id=" . $_GET['id'] .  "'>View comments on this photo</a><br>";
	if (unserialize($image['likes']) == NULL)
		 echo "There are no likes yet.<br>";
	else
		 echo "<a href='likes.php?id=" . $_GET['id'] .  "'>View likes on this photo</a><br>";
    if ($image['login'] == $_SESSION['login'] || $_SESSION['login'] == "GODMODE")
        echo "<a href='action.php?id=" . $_GET['id']  . "&action=delete'>Delete photo</a><br>";
    echo "</div>";
}

?>

<html>
<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
</body>
<center style="color: white;">
<form method="POST">
  <b><u>Add comment</u></b><br>
  <input type="text" name="comment"><br>
  <input type="submit" value="comment">
</form>
<form method="POST">
  <br>
  <input type="submit" value="like" name="like">
</form>
</center>
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
