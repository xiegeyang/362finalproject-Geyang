<?php 
/*
@author: Divya Jeyachandran
*/ 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page else to the admin_login page
session_start();
if(!isset($_SESSION["manager"])){
	header("location: AdminLogin.php");
	exit();
}
//$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
include "../storescripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM Manager WHERE manager_ID='$manager' AND m_password='$password' LIMIT 1");
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>

<?php 
/*
@author: Divya Jeyachandran
*/ 
//session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Inventory List</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <div id="pageContent"><br />
<div align="left" style="margin-left:24px;">
      <form action="monthly_sales.php" method="post">
<label>Enter the month number:</label><br /><input type="number" id="month" min="1" max="12" name="month" /><br />
<button style="margin-top:5px;" type="submit" value="submit">Get Sales Report</button>
</form>
    </div>
  </div>
  <?php include_once("../template_footer.php");?>
</div>
</body>
</html>

