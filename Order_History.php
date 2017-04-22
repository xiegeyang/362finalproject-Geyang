<?php  
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page else to the admin_login page
session_start();
if(!isset($_SESSION["manager"])){
	header("location: Login.php");
	exit();
}
//$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]);
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
include "storescripts/connect_to_mysql.php"; 
if($manager == "guest"){
	echo 'Sorry!! You dont have access to this page <a href="index.php">Home</a> ';
	exit();
}
$sql = mysql_query("SELECT * FROM customer_info WHERE User_ID='$manager' AND password='$password' LIMIT 1");
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PNW BookStore</title>
<link rel="stylesheet" href="style/style.css" type="text/css"/>

</head>
<body>
<div align="center" id="mainWrapper">
<?php include_once("template_header.php"); ?>
<div id="pageContent">
<br /><br/>
Your Order history is
 <p><?php 
/* show tables */
	$result2 = mysql_query("SELECT book_ID, quantity, date, genre FROM order_history where user_id='$manager'") or die('You have not purchased any books yet');
	if(mysql_num_rows($result2)) {
		echo '<table cellpadding="0" cellspacing="0" class="db-table">';
		echo '<tr>
    <th>BOOK NAME</th>
    <th>QUANTITY</th>
    <th>DATE AND TIME</th>
    <th>GENRE</th>
    <th>WRITE A REVIEW</th>
  </tr>';

		while($row2 = mysql_fetch_row($result2)) {
			echo '<tr>';
			foreach($row2 as $key=>$value) {
				echo '<td>',$value,'</td>';
				if($key=="book_ID")
				{$id= $value;}			
				
			
			}echo'<td>  <a href="Review.php?id=' . $id . '">Review</a></td>';
			echo '</tr>';
		}
		echo '</table><br />';
	}
?>
        </p>
<br /><br/>
</center>
</body>
</div>
<?php include_once("template_footer.php"); ?>
</div>
</html>
