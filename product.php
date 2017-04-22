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
$sql = mysql_query("SELECT * FROM customer_info WHERE User_ID='$manager' AND password='$password' LIMIT 1");
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php 
 $dynamicList="";
// Check to see the URL variable is set and that it exists in the database
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
    include "storescripts/connect_to_mysql.php"; 
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$sql = mysql_query("SELECT * FROM Book_Inventory WHERE book_ID='$id' LIMIT 1");
	$sql1 = mysql_query("SELECT * FROM review WHERE book_ID='$id' LIMIT 10");
	$productCount = mysql_num_rows($sql); // count the output amount
	 $productCount1 = mysql_num_rows($sql1); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysql_fetch_array($sql)){ 
			 $product_name = $row["book_name"];
			 $price = $row["price"];
			 $details = $row["author"];
			 $category = $row["genre"];
			 //$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
         }
		
    if ($productCount1 > 0) {
		 $dynamicList .=
         '<table width="100%" border="0" cellspacing="0" cellpadding="6">
		 <tr><td>USER ID</td><td>RATING</td><td width="83%" valign="top">REVIEWS</td></tr></table>';
		 while($row1 = mysql_fetch_array($sql1)){
			 $uid = $row1["user_ID"];
			 $reviews = $row1["reviews"];
			 $rating = $row1["rating"];			
			  $dynamicList .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">
			  <tr><td valign="top"> '.$uid.'</td><td valign="top">' . $rating . ' </td><td width="83%" valign="top">' . $reviews . '<br /></td></tr></table>';}
	}else{
		
	}	 
	}else {
		echo "That item does not exist.";
	    exit();
	}
		
} else {
	echo "Data to render this page is missing.";
	exit();
}
mysql_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $product_name; ?></title>
<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
</head>
<body>
<div align="center" id="mainWrapper">
  <?php include_once("template_header.php");?>
  <div id="pageContent">
  <table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td width="19%" valign="top"><img src="inventory_images/<?php echo $id; ?>.jpg" width="142" height="188" alt="<?php echo $product_name; ?>" /><br />
      <a href="inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a></td>
    <td width="81%" valign="top"><h3><?php echo $product_name; ?></h3>
      <p><?php echo "$".$price; ?><br />
        <br />
        <?php echo "$category"; ?> <br />
<br />
        <?php echo $details; ?>
<br />
        </p>
      <form id="form1" name="form1" method="post" action="cart.php">
        <input type="hidden" name="pid" id="pid" value="<?php echo $id; ?>" />
        <input type="submit" name="button" id="button" value="Add to Shopping Cart" />
      </form>
      </td>
         </tr>
         <tr>
         <?php echo $dynamicList; ?>
         </tr>
</table>
  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>
