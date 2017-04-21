<?php 
/*
@author: Gayathri Seshadri
*/ 
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
if (isset($_POST["username"]) && isset($_POST["password"])) {

	$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["username"]); 
    $password = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["password"]);
    // Connect to the MySQL database
include "../storescripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM Manager WHERE manager_ID='$manager' AND m_password='$password' LIMIT 1"); // query the person
    $existCount = mysql_num_rows($sql); // count the row nums
    if ($existCount == 1) { // evaluate the count
		 $_SESSION["manager"] = $manager;
		 $_SESSION["password"] = $password;
		 header("location: index.php");
         exit();
    } else {
		echo 'That information is incorrect, try again <a href="index.php">Click Here</a>';
		exit();
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Home Page</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <div id="pageContent">
   <div id="pageContent" style="height:450px;">
    <div align="left" style="padding-left:20px">
    <h2>Welcome, Please login to continue!!</h2>
    <form id="login_form" name="login" action="AdminLogin.php" method="post">
    <label>Username:</label><br /><input type="text" id="username" name="username" /><br />
    <label>Password:</label><br /><input type="password" id="password" name="password" /><br />
    <button style="margin-top:5px;" type="submit" value="submit">Login</button>
    </form>  </div>
    <br>	
</div>
</body>
 <?php include_once("../template_footer.php");?>
</html>