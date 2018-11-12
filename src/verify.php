<?php
session_start();

include ("../config/config.php");
include ("header.php");
include ("mail.php");
include ("backcheck.php");

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
	if (!checkLogin($_POST['login']) || !checkpass($_POST['password']) || !checkEmail($_POST['email']))
        exit ("You got something wrong, and that only happened becuase you played with my JS. Not cool man, not cool. <meta http-equiv='refresh' content='2;url=login.php' />");
    try {
        if (isset($_POST['notify']))
            $notify = "Y";
        else
            $notify = "N";
		$conn = getDB();
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $id = uniqid('', TRUE) . uniqid('', TRUE);
        $login = htmlspecialchars($_POST["login"]);
        $email = htmlspecialchars($_POST["email"]);
        $sql = "INSERT INTO users (id, login, password, email, notify) VALUES (?, ?, ?, ?, ?)";               
        $statement= $conn->prepare($sql);
        $statement->execute([$id, $login, $hash, $email, $notify]);
                 } catch (exception $e) {
                       echo $e->getMessage() . "\n";
                       exit ("Something went wrong, try again <meta http-equiv='refresh' content='3;url=index.php' />");
         }
	catch (PDOexception $e) { 
		if (preg_match ("/Duplicate/", $e->getMessage()))
			if (preg_match ("/login/", $e->getMessage())){
				echo "Username \"" . $_POST['login'] . "\" has been taken. Try a different one. Redirecting..";
				echo "<meta http-equiv='refresh' content='4;url=login.php' />";
			}
			else if (preg_match ("/email/", $e->getMessage())){
				echo "Email \"" . $_POST['email'] . "\" is associated to an account. Try logging in. Redirecting..";
				echo "<meta http-equiv='refresh' content='4;url=login.php' />";
            }
        exit($e->getMessage());
    }
    mail_ver($id, $email);
	echo "Account registered! Please login... <meta http-equiv='refresh' content='2;url=login.php' />";
}
?>

