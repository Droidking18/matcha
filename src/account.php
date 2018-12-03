<?php
session_start();

include("message_check.php");

if (!isset($_SESSION['login']))
    exit ("You're not logged in. <meta http-equiv='refresh' content='0;url=login.php' />");

if ($_SESSION['profile'] == "N")
    exit ("Set your profile first <meta http-equiv='refresh' content='0;url=profile.php' />");


include ("../config/config.php");
include ("header.php");

getLoggedHead();
?>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="css/login.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition,showError);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
      document.getElementById("lat").value = (position.coords.latitude);
      document.getElementById("long").value = (position.coords.longitude);
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
      var datas = (JSON.stringify(data, null, 2));
      document.getElementById("long").value = (data.geobyteslongitude);
      document.getElementById("lat").value = (data.geobyteslatitude);
      });

      break;
    case error.POSITION_UNAVAILABLE:
      break;
    case error.TIMEOUT:
      break;
    case error.UNKNOWN_ERROR:
      break;
  }
}

function checkForm(form)
{
	arr = document.getElementById("interest").value.split(' ');
	console.log(arr);
	var j = 0;
	while (j < arr.length)
	{
		arr2 = arr[j].slice(1, arr[j].length);
			console.log(arr2);
		re = /^\w+$/;
		if (!re.test(arr2)){
			alert("Error: interests format is incorrect. Must be interests seperated by spaces and must all start with '#'");
             		form.interest.focus();
             		return false;
         }

		j++;
	}
	first = arr.map(([v])=> v);
	console.log(first);
	for (var i = 0; i < first.length; i++) {
		console.log(i + first[i])
    	if (first[i] != '#') {
		alert ("Interests must all start with #");
		form.interest.focus();
		return false;
	}
      }
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
      files = document.forms['form']['photo'].files.length;
      if (document.forms['form']['photo'].files.length > 4) {
          alert ("ERROR: You have " + files + " files. 4 is the max.");
          form.photo.focus();
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


function eventListen() {
if (window.File && window.FileReader && window.FileList && window.Blob) {
   document.getElementById('dph').addEventListener('change', handleFileSelect, false);
 } else {
   alert('The File APIs are not fully supported in this browser.');
 }}


 function handleFileSelect(evt) {
   var arr = (document.getElementById('dph').value).split(".");
   var ext = arr[arr.length - 1];
   var f = evt.target.files[0];
   var reader = new FileReader();
   reader.onload = (function(theFile) {
     return function(e) {
       var binaryData = e.target.result;
       var base64String = (window.btoa(binaryData));
       document.getElementById('dp').value = base64String;
     };
   })(f);
   reader.readAsBinaryString(f);
 }

function eventListen1() {
if (window.File && window.FileReader && window.FileList && window.Blob) {
   document.getElementById('photo1').addEventListener('change', handleFileSelect1, false);
 } else {
   alert('The File APIs are not fully supported in this browser.');
 }}


 function handleFileSelect1(evt) {
   var arr = (document.getElementById('photo1').value).split(".");
   var ext = arr[arr.length - 1];
   var f = evt.target.files[0];
   var reader = new FileReader();
   reader.onload = (function(theFile) {
     return function(e) {
       var binaryData = e.target.result;
       var base64String = (window.btoa(binaryData));
       document.getElementById('ph1').value = base64String;
       console.log (base64String);
     };
   })(f);
   reader.readAsBinaryString(f);
 }


function eventListen2() {
if (window.File && window.FileReader && window.FileList && window.Blob) {
   document.getElementById('photo2').addEventListener('change', handleFileSelect1, false);
 } else {
   alert('The File APIs are not fully supported in this browser.');
 }}


 function handleFileSelect2(evt) {
   var arr = (document.getElementById('photo2').value).split(".");
   var ext = arr[arr.length - 1];
   var f = evt.target.files[0];
   var reader = new FileReader();
   reader.onload = (function(theFile) {
     return function(e) {
       var binaryData = e.target.result;
       var base64String = (window.btoa(binaryData));
       document.getElementById('ph2').value = base64String;
       console.log (base64String);
     };
   })(f);
   reader.readAsBinaryString(f);
 }


function eventListen3() {
if (window.File && window.FileReader && window.FileList && window.Blob) {
   document.getElementById('photo3').addEventListener('change', handleFileSelect1, false);
 } else {
   alert('The File APIs are not fully supported in this browser.');
 }}


 function handleFileSelect3(evt) {
   var arr = (document.getElementById('photo3').value).split(".");
   var ext = arr[arr.length - 1];
   var f = evt.target.files[0];
   var reader = new FileReader();
   reader.onload = (function(theFile) {
     return function(e) {
       var binaryData = e.target.result;
       var base64String = (window.btoa(binaryData));
       document.getElementById('ph3').value = base64String;
       console.log (base64String);
     };
   })(f);
   reader.readAsBinaryString(f);
 }


function eventListen4() {
if (window.File && window.FileReader && window.FileList && window.Blob) {
   document.getElementById('photo4').addEventListener('change', handleFileSelect1, false);
 } else {
   alert('The File APIs are not fully supported in this browser.');
 }}


 function handleFileSelect4(evt) {
   var arr = (document.getElementById('photo4').value).split(".");
   var ext = arr[arr.length - 1];
   var f = evt.target.files[0];
   var reader = new FileReader();
   reader.onload = (function(theFile) {
     return function(e) {
       var binaryData = e.target.result;
       var base64String = (window.btoa(binaryData));
       document.getElementById('ph4').value = base64String;
       console.log (base64String);
     };
   })(f);
   reader.readAsBinaryString(f);
 }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script>
 setInterval(function () { $.ajax({
     url: 'online.php',
     success: function(){}
 }); }, 5000);
 </script>
</head>
<body onload="eventListen(); eventListen1(); eventListen2(); eventListen3(); eventListen4(); getLocation();" style="background-color:grey;" style="background-size: cover;" style="background-size: cover;">
<!--<div style="display:flex;justify-content:center;align-items:middle;">-->
<div style="width: 100%">
<form action="verifyprofile.php" id="form" method="POST" onsubmit="return checkForm(this);" >
<font color=white size=1> What's your name? </font>
<input type="text" name="first_name" style="width:160;" value=<?php echo $_SESSION['name'] ?>> <br> <br>
<font color=white size=1> What's your last name? </font>
<input type="text" name="last_name" style="width:160;" value=<?php echo $_SESSION['lastname'] ?> > <br> <br>
<font color=white size=1> What's your birthday? </font>
<input type="date" name="dob" min="1928-01-01" max="2000-01-01" style="width: 160;" value=<?php echo $_SESSION['dob'] ?>> <br> <br> 
<font color=white size=1> Please enter your interests started with '#' e.g. "#gamer #pinappleonpizza #h ..." </font> <br>
<input style = "width: 25%;" type="text" id="interest" name="interest" value=<?php echo $_SESSION['interest'] ?> required><br><br>
<font color=white size=1> What's your gender?</font>
<select name="gender" id="gender" value=<?php echo $_SESSION['gen'] ?>>
  <option value="M" <?php if ($_SESSION['gen'] == "M") echo "selected"; ?>>Male</option>
  <option value="F" <?php if ($_SESSION['gen'] == "F") echo "selected"; ?>>Female</option>
  <option value="O" <?php if ($_SESSION['gen'] == "O") echo "selected"; ?>>Non-binary</option>
</select> <br> <br> <font color=white size=1> What's your sexual preference? </font>
<select name="gender-pref" id="gen_pref">
  <option value="M" <?php if ($_SESSION['gen_pref'] == "M") echo "selected"; ?>>Male</option>
  <option value="F" <?php if ($_SESSION['gen_pref'] == "F") echo "selected"; ?>>Female</option>
  <option value="O" <?php if ($_SESSION['gen_pref'] == "O") echo "selected"; ?>>Non-binary</option>
</select> <br> <br>
<font color="white" size =1>Your Display pic is:</font> <img style="height: 30" id='base64image' src= "data:image/png;base64, <?php echo $_SESSION['dp'] ?>"/><br><br>
<input type="file" name="dph" accept="image/png" id="dph" color="white" required> <font size=1 color="white"> Upload a profile picture of yourself. (required)</font> <br><br>
<?php if ($_SESSION['ph1']) echo "<font color='white' size=1>Your Display pic is:</font> <img style='height: 30' id='base64image' src= 'data:image/png;base64," .  $_SESSION['ph1'] . "'/>"; else echo "<font size = 1 color ='white'> No image set for image 2. </font>" ?> <br><br>
<input type="file" name="pho1" accept="image/png" id="photo1" color="white"> <font size=1 color="white"> Upload some images of yourself. (not required)</font> <br><br>
<?php if ($_SESSION['ph2']) echo "<font color='white' size=1>Your Display pic is:</font> <img style='height: 30' id='base64image' src= 'data:image/png;base64," .  $_SESSION['ph2'] . "'/>"; else echo "<font size = 1 color ='white'> No image set for image 3. </font>" ?> <br><br>
<input type="file" name="pho2" accept="image/png" id="photo2" color="white"> <font size=1 color="white"> Upload some images of yourself. (not required)</font> <br><br>
<?php if ($_SESSION['ph3']) echo "<font color='white' size=1>Your Display pic is:</font> <img style='height: 30' id='base64image' src= 'data:image/png;base64," .  $_SESSION['ph3'] . "'/>"; else echo "<font size = 1 color ='white'> No image set for image 4. </font>" ?> <br><br>
<input type="file" name="pho3" accept="image/png" id="photo3" color="white"> <font size=1 color="white"> Upload some images of yourself. (not required)</font> <br><br>
<?php if ($_SESSION['ph4']) echo "<font color='white' size=1>Your Display pic is:</font> <img style='height: 30' id='base64image' src= 'data:image/png;base64," .  $_SESSION['ph4'] . "'/>"; else echo "<font size = 1 color ='white'> No image set for image 5. </font>" ?> <br><br>
<input type="file" name="pho4" accept="image/png" id="photo4" color="white"> <font size=1 color="white"> Upload some images of yourself. (not required)</font> <br><br>
<!-- <button onclick="getLocation()">Get location</button> <br> <br> -->
<input type="hidden" name="long" id="long" required>
<input type="hidden" name="lat" id="lat" required>
<input type="hidden" name="dp" id="dp" required>
<input type="hidden" name="ph1" id="ph1" required>
<input type="hidden" name="ph2" id="ph2" required>
<input type="hidden" name="ph3" id="ph3" required>
<input type="hidden" name="ph4" id="ph4" required>
<input class="button" onclick="getLocation()" type="submit" value="Submit">
</form>
</div>
</body>
<footer style ="color: gray; text-align: center;"><hr style="border: 2px solid gray;" />dkaplanⓒ</footer>
</html>
