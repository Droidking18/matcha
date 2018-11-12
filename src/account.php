<?php
session_start();

include ("header.php");
if (!isset($_SESSION['login']))
	exit ("<meta http-equiv='refresh' content='0;url=signup.php' />");
getLoggedHead();

?>
<html>
<head>
<script>
function checkForm(form, login)
{
    if (form.type.value == "notify"){
	if (!(form.password2.value == "Y" && !(form.password2.value == "N"))) {
		alert("Error: email notification must be set as 'Y' or 'N'.");
		form.password2.focus();
		return false;
	}
    }
    if (form.type.value == "email"){
    re = /^[a-zA-Z0-9_\-\.]+@[a-zA-Z0-9_\-\.]+\.[a-zA-Z]{2,5}$/;
    if(!re.test(form.password2.value)) {
      alert ("Error: Email invalid");
      form.password2.focus();
      return false;
    }
    }
    if (form.type.value == "login"){
    if(form.password2.value == "") {
      alert("Error: Username cannot be blank!");
      form.password2.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.password2.value)) {
      alert("Error: Username must contain only letters, numbers and underscores!");
      form.password2.focus();
      return false;
    }
    }
    if (form.type.value == "password"){
    if(form.password2.value != "") {
      if(form.password2.value.length < 6 || form.password2.value.length > 16) {
        alert("Error: Password must contain 6 and 16 characters!");
        form.password2.focus();
        return false;
      }
      if(form.password2.value == login) {
        alert("Error: Password must be different from Username!");
        form.password2.focus();
        return false;
      }
      re = /[0-9]/;
      if(!re.test(form.password2.value)) {
        alert("Error: Password must contain at least one number (0-9)!");
        form.password2.focus();
        return false;
      }
      re = /[a-z]/;
      if(!re.test(form.password2.value)) {
        alert("Error: Password must contain at least one lowercase letter (a-z)!");
        form.password2.focus();
        return false;
      }
      re = /[A-Z]/;
      if(!re.test(form.password2.value)) {
        alert("Error: Password must contain at least one uppercase letter (A-Z)!");
        form.password2.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.password2.focus();
      return false;
    }
    return true;
    }
}

function passvis() {
    var p1 = document.getElementById("password");
    var p2 = document.getElementById("password");
    if (arguments[0] == "0") {
        password2.type = "text";
    } else {
        password2.type = "password";
    }
}
</script>
<body background = "https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg" style="background-size: cover;">
<font color="white" style="text-align: center;">
<center>
Your email address is: "<?php echo htmlspecialchars($_SESSION['email']); ?>". <br>
Your login is: "<?php echo htmlspecialchars($_SESSION['login']); ?>". <br><br>
To change email address, login or password, enter your current password<br>followed by your new detail, and the appropriate box ticked. If you want to change email notification, only Y or N is accepted<br><br>
<form id="form" action="change.php" method="POST" onsubmit="return checkForm(this, '<?php echo htmlspecialchars($_SESSION['login']); ?>');">
    Enter your password:<br>
    <input type="password" name="password" id="password" required><br>
    Enter your new detail and specify the type:<br>
    <input type="password" name="detail" id="password2" required><br>
    <input type="radio" name="type" value="password" required onclick="passvis('1')"> Password
    <input type="radio" name="type" value="email" required onclick="passvis('0')"> Email
    <input type="radio" name="type" value="login" required onclick="passvis('0')"> Username
    <input type="radio" name="type" value="notify" required onclick="passvis('0')"> Email Notifications<br>
    <input type="submit" value="Submit"> 
</center>
</form>
</font>
</body>
<footer style ="color: gray; text-align: center; margin-top: 10em;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>

