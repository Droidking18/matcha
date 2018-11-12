<?php
session_start();

if (isset($_SESSION['login']))
    exit ("Youre already logged in. <meta http-equiv='refresh' content='0;url=index.php' />");

include ("../config/config.php");
include ("header.php");

getHead();
?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="css/login.css">
<script>
function checkForm(form)
{
    re = /^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,15}$/;
    if(!re.test(form.email.value)) {  
      alert("Error: Email is invalid.");
      form.email.focus();
      return false;
    }
    if(form.login.value == "") {
      alert("Error: Username cannot be blank!");
      form.login.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.login.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.login.focus();
      return false;
    }
    if(form.password.value != "") {
      if(form.password.value.length < 6 || form.password.value.length > 16) {
        alert("Error: Password must contain 6 and 16 characters!");
        form.password.focus();
        return false;
      }
      if(form.password.value == form.login.value) {
        alert("Error: Password must be different from Username!");
        form.password.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.password.value)) {
        alert("Error: Password must contain at least one number (0-9)!");
        form.password.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password.value)) {
        alert("Error: Password must contain at least one lowercase letter (a-z)!");
        form.password.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password.value)) {
        alert("Error: Password must contain at least one uppercase letter (A-Z)!");
        form.password.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password.focus();
      return false;
    }
    return true;
  }

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
<form action="verify.php" id="form" method="POST" onsubmit="return checkForm(this);" >
<br>
<div class="center">
<input id="login" style="width: 160px;" type="text" name="login" placeholder="Enter login" required><br><br><br>
<br>
<input id="pw" style="width: 160px;" type="password" name="password" placeholder="Enter password" required><font color="white" face="verdana" size="1">
Show password</font><input style="color: white" type="checkbox" onclick="passvis()"><br><br>
<br>
<input id="email" style="width: 160px;" type="text" name="email" placeholder="Enter email" required>
<input id="notify" style="width: 160px; center" value="Y" type="checkbox" name="notify" checked><font size=1 style="color: white;">Tick for email notifications.</font><br><br>
<input class="button" type="submit" value="Submit">
</div>
</form>
</center>
<div>
</body>
<footer style ="position: fixed; bottom: -400; color: gray; text-align: center;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
