<?php 
/*
@author: Gayathri
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
@author: Gayathri
*/ 
//session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "../storescripts/connect_to_mysql.php"; 
?>
<?php
if(isset($_POST["month"])) {
	$month = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["month"]);
$product_list = "";
$sql = mysql_query("SELECT * FROM Order_History where MONTH(order_history.date)=$month");

$ordercount = mysql_num_rows($sql); // count the output amount

if ($ordercount > 0) {
$sql4 = mysql_query("Select ROUND(SUM(total_price),2) as S from order_history");
$row2= mysql_fetch_array($sql4);
$total_sales = $row2["S"];
	while($row = mysql_fetch_array($sql)){ 
             $order_id = $row["order_ID"];
             $book_id = $row["book_ID"];
             $user_id = $row["user_ID"];
             $date = $row["date"];
			 $quantity = $row["quantity"];
			 $totalPrice = $row["total_price"];
			 $product_list .= "Order_ID: $order_id <br>Book_ID: <strong>$book_id</strong><br>User_ID: <strong>$user_id</strong><br>Total Price: $$totalPrice &nbsp;<br /><hr>";
    }
} else {
	$total_sales = 0;
	$product_list = "No sales during the month you specified";
}	

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Monthly Sales Report</title>
<link rel="stylesheet" href="../style/style.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("header.php");?>
  <div id="pageContent"><br />
<div align="left" style="margin-left:24px;">
      <h2>Monthly Sales Report</h2>
      <h3>Total Sales = <?php echo $total_sales; ?></h3>
      <?php echo $product_list; ?>
      <br>
    </div>
  </div>
  <?php include_once("../template_footer.php");?>
</div>
</body>
</html>