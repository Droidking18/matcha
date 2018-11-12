<?php


include ("../config/config.php");
include ("backcheck.php");

    if (!$_GET['id'] && !$_POST['id'])
        exit("Bad link.");
    if (!$_GET['action'] && !$_POST['id'] && $_GET['id']) {
        $conn = getDB();
        $sql = "SELECT * FROM Users";
        foreach ($conn->query($sql) as $user) {
            if ($user['id'] == $_GET['id']) {
                $sql = "UPDATE Users SET emailverify = 'Y' WHERE id = '" . $_GET['id'] ."';";
                $conn->exec($sql);
                echo "<meta http-equiv='refresh' content='0;url=login.php' />";
            }
        }
    }
    else if ($_GET['action'] == "fg" && $_GET['id']) {
            echo "<html><head><title>Forgot Password</title><link rel='stylesheet' href='css/login.css'>
                <script>function checkForm(form){
                    if(form.password.value != '') {
                        if(form.password.value.length < 6 || form.password.value.length > 16) {
                            alert('Error: Password must contain 6 and 16 characters!');
                            form.password.focus();
                            return false;
                        }
                        if(form.password.value == form.login.value) {
                            alert('Error: Password must be different from Username!');
                            form.password.focus();
                            return false;
                        }
                        re = /[0-9]/;
                        if(!re.test(form.password.value)) {
                            alert('Error: Password must contain at least one number (0-9)!');
                            form.password.focus();
                            return false;
                        }
                        re = /[a-z]/;
                        if(!re.test(form.password.value)) {
                            alert('Error: Password must contain at least one lowercase letter (a-z)!');
                            form.password.focus();
                            return false;
                        }
                        re = /[A-Z]/;
                        if(!re.test(form.password.value)) {
                            alert('Error: Password must contain at least one uppercase letter (A-Z)!');
                            form.password.focus();
                            return false;
                        }
                    } else {
                        alert('Error: Please check that you\'ve entered and confirmed your password!');
                        form.password.focus();
                        return false;
                    }
                    return true;
                }

                function passvis() {
                var x = document.getElementById('password');
                if (x.type === 'password') {
                    x.type = 'text';
                } else {
                    x.type = 'password';
                }
                }</script></head>
<body background = 'https://wallpapertag.com/wallpaper/full/a/d/8/8613-amazing-dark-background-2560x1600-download-free.jpg' style='background-size: cover;'><div class='center'><center id='login'>
<form action='mailver.php' id='form' method='POST' onsubmit='return checkForm(this);' ><input id='password' style='width: 160px;' type='password' name='password' placeholder='Enter password' required>
<input type='hidden' id='id' name='id' value='" . htmlspecialchars($_GET['id']) . "'><font color='white' face='verdana' size='1'>
Show password</font><input style='color: white' type='checkbox' onclick='passvis()'><br><br><br><br><br><br></div>
<br><br><input class='button center' type='submit' value='Submit'></form></center></body></html>";}
      
      
      
      
      
else if ($_POST['password'] && $_POST['id']) {
	if (!checkPass($_POST['password']))
		exit ("Nahhhhh, think you can break my stuff and get away? Nope <meta http-equiv='refresh' content='0;url=index.php' />");
        $conn = getDB();
        $sql = "SELECT * FROM Users";
        foreach ($conn->query($sql) as $user) {
            if ($user['id'] == $_POST['id']) {
                $sql = "UPDATE Users SET password = ? WHERE id = ?";
                $statement= $conn->prepare($sql);
                $statement->execute([password_hash($_POST['password'], PASSWORD_BCRYPT), $_POST['id']]);
                echo "<meta http-equiv='refresh' content='0;url=login.php' />";
            }
        }
        echo "<meta http-equiv='refresh' content='0;url=login.php' />"; }
