<?php 
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page
session_start();
if (isset($_SESSION["manager"])) {
    header("location: index.php"); 
    exit();
}
?>
<?php
// This block get the posted username and password values if there is no previous session.
// Validates the credentials and redirects to index page.
if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["first_name"]) && isset($_POST["last_name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["confirm_password"])) {
if(!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["confirm_password"])){
	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); 
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
    $first_name = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["first_name"]);
    $last_name = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["last_name"]);
    $email = preg_replace('#[^A-Za-z0-9@.]#i', '', $_POST["email"]);
    $phone = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["phone"]);
    $confirm_password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["confirm_password"]);
    
    if($password == $confirm_password) {
    	include "storescripts/connect_to_mysql.php"; 
    	$sql = mysql_query("INSERT INTO customer_info (user_ID, password, first_name, last_name, email, phone_number) VALUES ('$manager', '$password', '$first_name' , '$last_name', '$email', '$phone') "); // insert the person
		 //$_SESSION["id"] = $id;
		 $_SESSION["manager"] = $manager;
		 $_SESSION["password"] = $password;
		 header("location: index.php");
		 
         exit(); 
    } else {
    	echo 'Your password did not match, try again <a href="registration.php">Click Here</a>';
		exit();
    }
}else {
	echo 'Please enter all the fields, try again <a href="registration.php">Click Here</a>';
		exit();
}
    } 

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Home Page</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
   <div id="pageContent" style="height:450px;">
    <div align="left" style="padding-left:20px">
    <h2>Welcome, Please register to continue!!</h2>
    <form id="registration_form" name="register" action="registration.php" method="post">
    <label>Fisrtname:</label><br /><input type="text" id="first_name" name="first_name" /><br />
    <label>Lastname:</label><br /><input type="text" id="last_name" name="last_name" /><br />
    <label>Username:</label><br /><input type="text" id="username" name="username" /><br />
    <label>Password:</label><br /><input type="password" id="password" name="password" /><br />
    <label>Confirm Password:</label><br /><input type="password" id="username" name="confirm_password" /><br />
    <label>Email:</label><br /><input type="text" id="username" name="email" /><br />
    <label>Phone:</label><br /><input type="phone" id="username" name="phone" /><br />
    <button style="margin-top:5px;" type="submit" value="submit">Register</button>
    </form>  </div>
    <br> 	
</div>
</body>
 <?php include_once("template_footer.php");?>
</html>
