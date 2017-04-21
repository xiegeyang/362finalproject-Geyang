<?php 
/*
@author: Gayathri
*/ 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
session_start();
if (!isset($_SESSION["manager"])) {
    header("location: AdminLogin.php"); 
    exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM Manager WHERE manager_ID='$manager' AND m_password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
	 include_once("logout.php");
     exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Admin Area</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <div id="pageContent"><br />
    <div align="left" style="margin-left:24px;">
     <table width="59%" height="61" border="0">
      <tr>
        <td width="51%"><p><a href="inventory_list.php"><img src="../inventory_images/manage.jpg" width="204" height="164" alt="manage inventory" /></a></p>
          <p style="font-size:16px;"><a href="inventory_list.php">Manage Inventory</a></p></td>
        <td width="49%"><p><a href="month.php"><img src="../inventory_images/manageCategory.jpg" width="229" height="160" alt="manage by category" /></a></p>
          <p style="font-size:16px;"><a href="month.php">Monthly Sales</a></p></td>
      </tr>
    </table> </div>
    <br />
  <br />
  <br />
  </div>
  <?php include_once("../template_footer.php");?>
</div>
</body>
</html>