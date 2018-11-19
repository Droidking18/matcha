<?php
session_start();

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
			    	$_SESSION['pic1'] = $user['image1'];
			    	$_SESSION['pic2'] = $user['image2'];
			    	$_SESSION['pic3'] = $user['image3'];
			    	$_SESSION['pic4'] = $user['image4'];
			    	$_SESSION['dp'] = $user['dp'];
			    	$_SESSION['rating'] = $user['rating'];
			    	$_SESSION['notification'] = $user['notification'];
			    	$_SESSION['lat'] = $user['lat'];
			    	$_SESSION['long'] = $user['long'];
			    	$_SESSION['profile'] = $user['profile'];
			    	$_SESSION['gen'] = $user['gen'];
			    	$_SESSION['gen_pref'] = $user['gen_pref'];
			    	$_SESSION['first_name'] = $user['first_name'];
			    	$_SESSION['last_name'] = $user['last_name'];
			    	$_SESSION['dob'] = $user['dob'];
                    exit("Congratulations, you're now logged in. <meta http-equiv='refresh' content='3;url=index.php' />");
                }    
                else
                    echo "Please verify your account. <a href='emailagain.php?user=" . $user['login'] . "'> Click here to send link again</a>";
			}
			else
				echo "Password Incorrect. <meta http-equiv='refresh' content='3;url=login.php' />";
	}
	exit();
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
<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
<div class="center">
<center id="login">
<form action="login.php" method="POST">
<br>
<input style="width: 160px;" type="text" name="login" placeholder="Enter login" required><br>
<br><br><br><br>
<div class="center">
<input id="pw" style="width: 160px;" type="password" name="password" placeholder="Enter password" required><font color="white" face="verdana" size="1">Show password</font><input style="color: white" type="checkbox" onclick="passvis()"><br><br>
</div>
<a href="forgot.php"><font size="1" color="gray">Forgot password?</font></a><br>
<input class="button" type="submit" value="Submit" style="margin-top: 10px;">
</form>
</center>
</div>
</body>
<footer style ="position: fixed; bottom: 100; color: gray; text-align: center;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
