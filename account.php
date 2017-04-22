<?php 
 
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page else to the admin_login page
session_start();
if(!isset($_SESSION["manager"])){
	header("location: Login.php");
	exit();
}
?>
<?php
if (isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])&& isset($_POST['phone'])&& isset($_POST['street_address'])&& isset($_POST['city'])&& isset($_POST['state'])&& isset($_POST['zipcode'])) {
	$username = mysql_real_escape_string($_POST['username']);
    $password = mysql_real_escape_string($_POST['password']);
	$first_name = mysql_real_escape_string($_POST['first_name']);
	$last_name = mysql_real_escape_string($_POST['last_name']);
	$email = mysql_real_escape_string($_POST['email']);
	$phone_number = mysql_real_escape_string($_POST['phone']);
	$street_address = mysql_real_escape_string($_POST['street_address']);
	$city = mysql_real_escape_string($_POST['city']);
	$state = mysql_real_escape_string($_POST['state']);
	$zipcode = mysql_real_escape_string($_POST['zipcode']);
	// See if that product name is an identical match to another product in the system
	$sqlUpdate = mysql_query("UPDATE customer_info SET first_name='$first_name', last_name='$last_name', email='$email', phone_number='$phone_number', password='$password' WHERE user_ID='$username'");

	$sqlSelect = mysql_query("SELECT * from Customer_address WHERE user_ID='$username'");
	$sqlSelectCount = 	mysql_num_rows($sqlSelect);
	if($sqlSelectCount > 0) {
		$sqlUpdate2 = mysql_query("UPDATE Customer_address SET street_address='$street_address', city='$city', state='$state', zip='$zipcode' WHERE user_ID='$username'");
	}else {
		$sqlInsert = mysql_query("INSERT INTO Customer_address (user_ID, street_address, city, state, zip) VALUES ('$username', '$street_address', '$city', '$state', '$zipcode')");
	}
	
	
	echo 'Details saved <a href="index.php">Home</a> ';
	exit();
}
?>
<?php
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
	 include_once("logout.php");
     exit();
}

//$targetID = $_GET['pid'];
//    $sql = mysql_query("SELECT * FROM customer_info WHERE user_ID='$manager' LIMIT 1");
 //   $productCount = mysql_num_rows($sql); // count the output amount
    if ($existCount > 0) {
	    while($row = mysql_fetch_array($sql)){ 
           $userID = $row["User_ID"];  
			 $password = $row["password"];
			 $first_name = $row["first_name"];
			 $last_name = $row["last_name"];
			 $email = $row["email"];
			 $phone_number = $row["phone_number"];
   }
    } else {
	    echo "Sorry that doesn't exist.";
		exit();
    }
$sql2 = mysql_query("SELECT * FROM Customer_address WHERE User_ID='$manager'");
$existCount2 = mysql_num_rows($sql2); // count the row nums

//$targetID = $_GET['pid'];
//    $sql = mysql_query("SELECT * FROM customer_info WHERE user_ID='$manager' LIMIT 1");
 //   $productCount = mysql_num_rows($sql); // count the output amount
    if ($existCount2 > 0) {
	    while($row = mysql_fetch_array($sql2)){ 
           $street_address = $row["street_address"];  
			 $city = $row["city"];
			 $state = $row["state"];
			 $zipcode = $row["zip"];
   }
    } else {
	        $street_address = "";  
			 $city = "";
			 $state = "";
			 $zipcode = "";
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account summary</title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
   <div id="pageContent" style="height:510px;">
    <div align="left" style="padding-left:20px">
    <h2>Account Information</h2>
    <form id="account_form" name="account" action="account.php" method="post">
    <label>Fisrtname:</label><br /><input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" /><br />
    <label>Lastname:</label><br /><input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>"  /><br />
    <label>Username:</label><br /><input type="hidden" id="username" name="username" value="<?php echo $userID; ?>"  /><strong><em><?php echo $userID; ?></em></strong><br />
    <label>Password:</label><br /><input type="text" id="password" name="password" value="<?php echo $password; ?>"  /><br />
    <label>Email:</label><br /><input type="email" id="username" name="email" value="<?php echo $email; ?>"  /><br />
    <label>Phone:</label><br /><input type="phone" id="username" name="phone" value="<?php echo $phone_number; ?>"  /><br />
    <label>Street address:</label><br /><input type="text" id="street_address" name="street_address" value="<?php echo $street_address; ?>"  /><br />
    <label>City:</label><br /><input type="text" id="city" name="city" value="<?php echo $city; ?>"  /><br />
    <label>State:</label><br /><input type="text" id="state" name="state" value="<?php echo $state; ?>"  /><br />
    <label>Zipcode:</label><br /><input type="text" id="zipcode" name="zipcode" value="<?php echo $zipcode; ?>"  /><br />
    <button style="margin-top:5px;" type="submit" value="submit">Save</button>
    </form>  </div>
    <br> 	
</div>
</body>
 <?php include_once("template_footer.php");?>
</html>
