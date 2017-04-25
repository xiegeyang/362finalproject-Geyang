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
<?php if (!empty($_POST)): 
// Run a select query to get the required seared item
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 
$dynamicList = "";
//$id = htmlspecialchars($_POST["ID"]);
$product_name = htmlspecialchars($_POST["product_name"]);
$product_desc = htmlspecialchars($_POST["product_desc"]);
$sql = mysql_query("SELECT * FROM Book_Inventory where book_name='$product_name' or author='$product_desc'");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
             $id = $row["book_ID"];
			 $product_name = $row["book_name"];
			 
			 $price = $row["price"];
			 //$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
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
	$dynamicList = "We have no products listed with your specifications yet";
}
mysql_close();
?> <?php endif; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
  <?php if (!empty($_POST)): ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td valign="top"><form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
      <p>
        
        <label for="product_name">BOOK NAME</label>
        <input type="text" name="product_name" id="product_name" />
        <label for="product_desc">AUTHOR</label>
        <input type="text" name="product_desc" id="product_desc" />
        <input type="submit" value="SEARCH" />
      </p>   
    </form>
    <?php echo $dynamicList; ?>
<?php else: ?>
  <table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr>
    <td valign="top"><form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
      <p>
         
        <label for="product_name">BOOK NAME</label>
        <input type="text" name="product_name" id="product_name" />
        <label for="product_desc">AUTHOR</label>
        <input type="text" name="product_desc" id="product_desc" />
        <input type="submit" value="SEARCH" />
      </p>   
    </form>
  <?php endif; ?>
      <p><br />
        </p>
      <p><br />
        </p><h3>&nbsp;</h3></td>
    </tr>
</table>

  </div>
  <?php include_once("template_footer.php");?>
</div>
</body>
</html>
