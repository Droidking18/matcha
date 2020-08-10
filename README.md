# Camagru

## Synopsis

An instagram like website written with Apache, PHP and MYSQL. Project part of the web branch at WeThinkCode_.
No libraries were allowed (both in front and back).

## Requirements

* PHP
* MAMP
* JS

## Installation 

Clone this repo into MAMP/apache2/htdocs (or whichever webserver you're using) and restart the webserver. Run it by opening the browser to loaclahost:<webserver port>/camagru. To setup the DB go to /setup.php and configure the config correctly in config/config.php. 

## Code breakdown

* BE Technologies

	* PHP


* FE Technologies 

	* HTML 
	* CSS

* App structure

	* config - files used to configure the DB
		* setup.php
		* config.php

	* src - the logic/view for the website

	* account.php - The file responsible for user accounts and editing them
	* action.php - The file responsible for actions on posts
	* backcheck.php - The file responsible for checking data
	* change.php - The file responsible for changing user data
	* comments.php - The file responsible for commenting
	* css - CSS directory
	* emailagain.php - The file responsible for sending emails
	* forgot.php - The file responsible for if user forgot password
	* header.php - The file responsible for my header
	* index.php - The landing page
	* likes.php - The file responsible for likes
	* login.php - The file responsible for login
	* logout.php - The file responsible for logout
	* mail.php - The file responsible for email
	* mailver.php - The file responsible for mail verification 
	* merge.php - The file responsible for merging images
	* photo.php - The file responsible for photos
	* signup.php - The file responsible for signing up 
	* upload.php - The file responsible for uploading data
	* verify.php - The file responsible for verification 

* Testing

	* The following was tested

		* Usage of only php and no frameworks. Config correct and use of PDO's
		* Start webserver
		* Create account
		* Login
		* Webcam
		* Homepage
		* Change user credentials

	* Expected outcomes

		* Code is in PHP. No frameworks.
		* Config is correct
		* PDO's are used
		* Going to the URL will take tyou to the landing page and should be able to register. You should be able to login and only see the account of your user. Changing names should work. 
