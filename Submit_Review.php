<?php 
/*
@author: Gayathri Seshadri
*/ 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page else to the admin_login page
session_start();
if(!isset($_SESSION["manager"])){
	header("location: registration.php");
	exit();
}
//$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
include "storescripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM customer_info WHERE User_ID='$manager' AND password='$password' LIMIT 1");
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php 
// Gather this product's full information written in review automatically into the database
if (isset($_POST['book_ID'])) {
	$book_id=$_POST['book_ID'];
	$rating=$_POST['rating'];	
	$Review = $_POST['Review'];
	$user_id =$_SESSION["manager"];
	include "storescripts/connect_to_mysql.php"; 	
		$sql = mysql_query("INSERT INTO review(book_ID, user_ID, reviews, rating) VALUES ('$book_id','$user_id','$Review','$rating')")or die (mysql_error());	
		//echo $quantity .','.$book_name.','.$price ;	
	   
    } else {
	    echo "Sorry that doesn't exist.";
		exit();
    }

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DJ BookStore</title>
<link rel="stylesheet" href="style/style.css" type="text/css"/>

</head>
<body>
<div align="center" id="mainWrapper">
<?php include_once("template_header.php"); ?>
<div id="pageContent">
<br /><br/>
Thank You for submitting your review!
        </p>
<br /><br/>
</center>
</body>
</div>
<?php include_once("template_footer.php"); ?>
</div>
</html>