<?php
//session_start();
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'bigsucc');
define('DB_DATABASE', 'db_matcha');
define("BASE_URL", "127.0.0.1/matcha/");


function createInitialDatabase() {
		$dbhost = DB_SERVER;
		$dbname = DB_DATABASE;

		try {
			$conn = new PDO("mysql:host=$dbhost", DB_USERNAME, DB_PASSWORD);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
			$conn->exec($sql);
			echo "Database created successfully<br/>";
		} catch (PDOException $e) {
			echo "Database creation failed: " . $e->getMessage() . "<br/>";
		}
	}

function getDB() {
	$dbhost=DB_SERVER;
	$dbuser=DB_USERNAME;
	$dbpass=DB_PASSWORD;
	$dbname=DB_DATABASE;
	try {
		$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass); 
		$dbConnection->exec("set names utf8");
		$dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $dbConnection;
		}
		catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

function createTableDatabase($conn) {
	$sql="CREATE TABLE IF NOT EXISTS `users` (
	`id` VARCHAR(100) PRIMARY KEY UNIQUE,
	`login` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `first_name` VARCHAR(16) NOT NULL DEFAULT 'NONE',
    `last_name` VARCHAR(16) NOT NULL DEFAULT 'NONE',
    `email` VARCHAR(50) NOT NULL UNIQUE,
	`dp` LONGTEXT NOT NULL,
	`dob` DATE,
    `image1` LONGTEXT,
    `image2` LONGTEXT,
    `image3` LONGTEXT,
	`image4` LONGTEXT,
	`interests` LONGTEXT,
	`visits` LONGTEXT,
	`likes` LONGTEXT,
	`dislikes` LONGTEXT,
	`blocks` LONGTEXT,
	`lat` VARCHAR(20),
	`long` VARCHAR(20),
    `emailverify` ENUM('N', 'Y') NOT NULL,
    `gen_pref` ENUM('F', 'M', 'O') NOT NULL,
	`gen` ENUM('F', 'M', 'O') NOT NULL,
	`rating` INT,
    `notification` ENUM('N', 'Y') NOT NULL,
    `message` ENUM('N', 'Y') NOT NULL,
    `notifications` LONGTEXT NOT NULL,
    `messages` LONGTEXT NOT NULL,
    `online` VARCHAR(16) NOT NULL,
    `profile` ENUM('N', 'Y') NOT NULL);";
	$conn->exec($sql);
    echo "Table users created";
    /*$sql="CREATE TABLE IF NOT EXISTS `images` (
	  `id` INT AUTO_INCREMENT PRIMARY KEY,
        `login` VARCHAR(50) NOT NULL,
        `comments` LONGTEXT,
        `likes` LONGTEXT,
        `image` LONGTEXT NOT NULL);";
    $conn->exec($sql);
    echo " and image table created";*/
}
?>
