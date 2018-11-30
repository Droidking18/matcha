<?php
function getHead () {
echo
"<html>
<title> MATCHA </title>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<style>
* {box-sizing: border-box;}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  padding: 20px 10px;
  background-color: black;
}

.header a {
  float: left;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}
</style>
</head>
<body>

<div class='header'>
  <a href='https://www.reddit.com/r/PHP/comments/1fy71s/why_do_so_many_developers_hate_php/' class='logo'>
  <img src='https://preview.ibb.co/nBWeEf/logodovi.png' size=800' height='50' ></a>
  <div class='header-right'>
    <a href='login.php'>Login</a>
    <a href='signup.php'>Signup</a>
  </div>
</div>
</body>
</html>";}

function getLoggedHead () {
echo
"<html>
<head>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<style>
* {box-sizing: border-box;}

body, html {
  height: 100%;
  width: 100%;
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.header {
  overflow: hidden;
  padding: 20px 10px;
  /*position: relative;*/
  background-color: black;
}

.header a {
  float: left;
  color: white;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px;
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
}

.welcome {
    /*position: absolute;*/
    height: 100%;
    width: 100%;
}

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
  }
  .header-right {
    float: none;
  }
}
</style>
</head>
<body>
<title> MATCHA </title> 
<div class='header'>
  <a href='https://www.reddit.com/r/PHP/comments/1fy71s/why_do_so_many_developers_hate_php/' class='logo'>
  <img src='https://preview.ibb.co/nBWeEf/logodovi.png' height='50' ></a>"
  . "<center class='welcome' style='display: inline; font-size: 20px; color: gray;'>           Welcome, " . htmlspecialchars($_SESSION['login']) . "! </center>" .
  "<div class='header-right'>
	<a class='active' href='index.php'>Home</a>
    <a href='account.php'>Account</a>
    <a href='notification.php'>";
if ($_SESSION['notification'] == "Y")
    echo "Notifications🔴 <br> <font size=1> You have notifications. </font>";
else
    echo "Notifications<br> <font size=1> You have no new notifications. </font>";
    echo  "</a>";
    echo "<a href='message.php'>";
if ($_SESSION['message'] == "Y")
    echo "Messages🔴 <br> <font size=1> You have messages. </font>";
else
    echo "Messages<br> <font size=1> You have no new messages. </font>";
    echo  "</a>
    <a href='logout.php'>Logout</a>
  </div>
</div>
</body>
</html>";}
