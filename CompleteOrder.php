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
	header("location: Login.php");
	exit();
}

$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]);
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]);
include "storescripts/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM customer_info WHERE user_ID='$manager' AND password='$password' LIMIT 1");
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}

	$user_id =$_SESSION["manager"];
?>
<?php 
$type=$_POST['S_TYPE'];
unset($_SESSION["cart_array"]);
if($type=='STANDARD'){
	$day =7;
}
else if ($type=='EXPRESS'){
	$day =5;
}
else if ($type=='OVERNIGHT'){
	$day =2;
}

?>
 <?php
if (isset($_POST['c_Number'])) {
	$total_num = $_POST['total_num'];
	for($x=1;$x<=$total_num;$x++){
		$quantity =$_POST["quantity_$x"];
		$book_name = $_POST["item_name_$x"];
		$price = $_POST["amount_$x"];	
		$category = $_POST["category_$x"];
$total_price =$quantity*$price ;				
		$sql = mysql_query("INSERT INTO Order_History (book_ID, user_ID, date, quantity, total_price,genre) values ( '$book_name', '$user_id',now(),'$quantity', '$total_price','$category')  ")or die (mysql_error());	}

$Card_type=$_POST['card_type'];
$Card_Name =$_POST['c_holderN'];
$Card_Num=$_POST['c_Number'];
$ExpiryDate =$_POST['expirydate'];
$CVV =$_POST['cvv'];
$R_Name=$_POST['R_name'];
$type=$_POST['S_TYPE'];
$street_address = $_POST["street_address"];  
$city = $_POST["city"];
$state = $_POST["state"];
$zipcode = $_POST["zipcode"];

		$sql1 = mysql_query("INSERT INTO order_address( address, city, state, zip) VALUES ('$street_address','$city','$state','$zipcode') ")or die (mysql_error());	
		
		$checkCard = mysql_query("SELECT * FROM credit_card WHERE card_number=$Card_Num AND CVV=$CVV LIMIT 1");
		$cardCount = mysql_num_rows($checkCard);
		if(!$cardCount) {
		$sql2 = mysql_query("INSERT INTO credit_card(card_number, card_username, card_type, CVV, expiry_date, user_ID) VALUES ('$Card_Num','$Card_Name','$Card_type','$CVV','$ExpiryDate','$user_id') ")or die (mysql_error());	
		}
		$sql3 = mysql_query("INSERT INTO order_info( user_ID, receiver_name, shipping_type, date, total_price, card_number) VALUES ('$user_id','$R_Name','$type',now(),'890','$Card_Num') ")or die (mysql_error());
	
$dynamicList = "";
$sql = mysql_query("SELECT DISTINCT b.book_ID, b.book_name, b.price  FROM 
book_inventory as b WHERE genre IN  
(SELECT genre FROM order_history WHERE user_ID='$manager') 
AND book_name NOT IN
(SELECT book_id FROM order_history WHERE user_ID='$manager')");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
             $id = $row["book_ID"];
			 $product_name = $row["book_name"];			 
			 $price = $row["price"];
			 $dynamicList .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
          <td width="17%" valign="top"><a href="product.php?id=' . $id . '"><img style="border:#666 1px solid;" src="inventory_images/' . $id . '.jpg" alt="' . $product_name . '" width="77" height="102" border="1" /></a></td>
          <td width="83%" valign="top">' . $product_name . '<br />
            $' . $price . '<br />
            <a href="product.php?id=' . $id . '">View Product Details</a></td>
        </tr>
      </table>';
    }
} else {
	$dynamicList = "We have no other products of the genre '$category' in our store yet";
}}
mysql_close();
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
Thank you for placing your order. Your order has been processed and will be delivered in <?php echo $day ?> days.<br/>
<h3>Below are some suggestions for you.</h3>

 <p><?php echo $dynamicList; ?><br />
        </p>
<br /><br/>
</center>
</body>
</div>
<?php include_once("template_footer.php"); ?>
</div>
</html>