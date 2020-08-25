<?php
// define variables and initialize with empty values
$nameErr = $lastNameErr = $emailErr = $specialityErr = $phoneErr = $genderErr=$userNameErr=$passwordErr=$nationalityErr=$bioErr="";
$name = $lastName = $email  = $phone = $gender=$userName=$password=$speciality=$bio="";
$nationality = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])) {
	
	if (empty($_POST["name"])) {
        $nameErr = "Please enter the name";
    }
    else {
        $name = $_POST["name"];
    }
	
	if (empty($_POST["userName"])) {
        $userNameErr = "Must set a user name for the doctor";
    }
    else {
        $userName= $_POST["userName"];
    }
	
	if (empty($_POST["password"])) {
        $passwordErr= "Must set a password for the doctor";
    }
    else {
       $password = $_POST["password"];
    }
	
	
	if (empty($_POST["lastName"])) {
        $nameErr = "Full name is required";
    }
    else {
        $lastName = $_POST["lastName"];
    }
	
	 if (empty($_POST["email"]))  {
        $emailErr = "Email is required";
    }
    else {
        $email = $_POST["email"];
    }
 if (empty($_POST["nationality"])) {
       $nationalityErr = "You must select one";
    }
    else {
        $nationality = $_POST["nationality"];
    }
	if (!isset($_POST["gender"])) {
        $genderErr = "You must select";
    }
    else {
        $gender= $_POST["gender"];
    }
	if (!isset($_POST["speciality"])) {
         $specialityErr  = "You must select";
    }
    else {
       $speciality = $_POST["speciality"];
    }
	
	if (empty($_POST["bio"])) {
      $bioErr = "Bio is required";
    }
    else {
       $bio = $_POST["bio"];
    }
	}}
	?>
	
	
	
	
	
	
	