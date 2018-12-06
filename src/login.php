<?php
session_start();

include("message_check.php");

include ("../config/config.php");
include ("header.php");

if (isset($_SESSION['login']))
    exit ("Youre already logged in. <meta http-equiv='refresh' content='0;url=index.php' />");

getHead();
if (isset($_POST['login']) && isset($_POST['password'])) {
	$conn = getDB();
    $sql = "SELECT * FROM users";
	foreach ($conn->query($sql) as $user)
	{
		if ($user["login"] == $_POST['login'])
            if (password_verify($_POST['password'], $user['password'])) {
                if ($user['emailverify'] == 'Y') {
				$_SESSION['login'] = $_POST['login'];	
		    		$_SESSION['email'] = $user['email'];	
			    	$_SESSION['passhash'] = $user['password'];
			    	$_SESSION['ph1'] = $user['image1'];
			    	$_SESSION['ph2'] = $user['image2'];
			    	$_SESSION['ph3'] = $user['image3'];
			    	$_SESSION['ph4'] = $user['image4'];
			    	$_SESSION['dp'] = $user['dp'];
			    	$_SESSION['rating'] = $user['rating'];
			    	$_SESSION['notification'] = $user['notification'];
			    	$_SESSION['message'] = $user['message'];
			    	$_SESSION['lat'] = $user['lat'];
			    	$_SESSION['long'] = $user['long'];
			    	$_SESSION['profile'] = $user['profile'];
			    	$_SESSION['gen'] = $user['gen'];
			    	$_SESSION['gen_pref'] = $user['gen_pref'];
			    	$_SESSION['name'] = $user['first_name'];
			    	$_SESSION['lastname'] = $user['last_name'];
                    $_SESSION['dob'] = $user['dob'];
                    $_SESSION['likes'] = $user['likes'];
                    $_SESSION['dislikes'] = $user['dislikes'];
                    $_SESSION['blocks'] = $user['blocks'];
                    $_SESSION['interest'] = implode(" ", unserialize(($user['interests'])));
                    exit("Congratulations, you're now logged in. <meta http-equiv='refresh' content='3;url=index.php' />");
                }    
                else
                    echo "Please verify your account. <a href='emailagain.php?user=" . $user['login'] . "'> Click here to send link again</a>";
			}
			else
				echo "Password Incorrect. <meta http-equiv='refresh' content='3;url=login.php' />";
	}
	exit("Login incorrect <meta http-equiv='refresh' content='3;url=login.php' />");
}
?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="css/login.css">
<script>
function passvis() {
    var x = document.getElementById("pw");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
</head>
<body style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
<div class="center">
<center id="login">
<form action="login.php" method="POST">
<br>
<input style="width: 160px;" type="text" name="login" placeholder="Enter login" required><br>
<br><br><br><br>
<div class="center">
<input id="pw" style="width: 160px;" type="password" name="password" placeholder="Enter password" required><font color="white" face="verdana" size="1">Show password</font><input style="color: white" type="checkbox" onclick="passvis()"><br><br>
</div>
<a href="forgot.php"><font size="1" color="white">Forgot password?</font></a><br>
<input class="button" type="submit" value="Submit" style="margin-top: 10px;">
</form>
</center>
</div>
</body>
<footer style ="position: relative; bottom: -70%; color: gray; text-align: center; color: black;"><hr style="border: 2px solid darkgrey;" />dkaplanⓒ</footer>
</html>
