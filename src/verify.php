<?php
session_start();

include("message_check.php");

include ("../config/config.php");
include ("header.php");
include ("mail.php");
include ("backcheck.php");


//Array ( [login] => root [password] => bigsuccDD32 [email] => dovikaplan@gmail.com [gender] => M [gender-pref] => M [photo] => [long] => Longitude location is 31.017000 [lat] => Longitude location is -29.850000 [ph1] => [ph2] => [ph3] => [ph4] => [dp] => )
//exit(print_r($_POST));

if (isset($_POST['login']) && isset($_POST['password']) && isset($_POST['email'])) {
	if (!checkLogin($_POST['login']) || !checkpass($_POST['password']) || !checkEmail($_POST['email']) || !CheckName($_POST['name']) || !CheckName($_POST['lname']))
        exit ("You got something wrong, and that only happened becuase you played with my JS. Not cool man, not cool. <meta http-equiv='refresh' content='2;url=login.php' />");
    try {
        $conn = getDB();
        $not = serialize([["message"=>["rec1" => "Welcome, you're now ready to Hinder!"], "user"=>"Hinder Admins", "id"=>uniqid("", true)]]);
        $mess = serialize([["message"=>"Welcome, you're now ready to Hinder!", "user"=>"Hinder Admins", "id"=>uniqid("", true)]]);
        $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $id = uniqid('', TRUE) . uniqid('', TRUE);
        $login = htmlspecialchars($_POST["login"]);
		$email = htmlspecialchars($_POST["email"]);
		$name = $_POST['name'];
		$lname = $_POST['lname'];
        $sql = "INSERT INTO users (id, login, password, email, notification, notifications, profile, dp, message, messages, online, visits, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $statement= $conn->prepare($sql);
        $statement->execute([$id, $login, $hash, $email, "Y", $mess ,"N", "none", "Y", $not, mktime(), serialize([]), $name, $lname]);
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

