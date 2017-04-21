<?php 
/*
@author: Gayathri Seshadri
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
     exit();
}
?>
<?php 
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
// Parse the form data and add inventory item to the system
if (isset($_POST['product_name'])) {
	$pid = mysql_real_escape_string($_POST['thisID']);
    $product_name = mysql_real_escape_string($_POST['product_name']);
	$price = mysql_real_escape_string($_POST['price']);
	$category = mysql_real_escape_string($_POST['category']);
	//$subcategory = mysql_real_escape_string($_POST['subcategory']);
	$details = mysql_real_escape_string($_POST['details']);
	// See if that product name is an identical match to another product in the system
	$sql = mysql_query("UPDATE book_inventory SET book_name='$product_name', price='$price', author='$details', genre='$category' WHERE book_ID='$pid'");
	if ($_FILES['fileField']['tmp_name'] != "") {
	    // Place image in the folder 
	    $newname = "$pid.jpg";
	    move_uploaded_file($_FILES['fileField']['tmp_name'], "../inventory_images/$newname");
	}
	header("location: inventory_list.php"); 
    exit();
}
?>
<?php 
// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_GET['pid'])) {
	$targetID = $_GET['pid'];
    $sql = mysql_query("SELECT * FROM book_inventory WHERE book_ID='$targetID' LIMIT 1");
    $productCount = mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
	    while($row = mysql_fetch_array($sql)){ 
             
			 $product_name = $row["book_name"];
			 $price = $row["price"];
			 $category = $row["genre"];
			 $details = $row["author"];
   }
    } else {
	    echo "Sorry that doesn't exist.";
		exit();
    }
}
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
    <div align="right" style="margin-right:32px;"><a href="inventory_list.php#inventoryForm">+ Add New Inventory Item</a></div>
<div align="left" style="margin-left:24px;">
           
    </div>
    <hr />
    <a name="inventoryForm" id="inventoryForm"></a>
    <h3>
    &darr; Edit Inventory Item Form &darr;
    </h3>
    <form action="inventory_edit.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
    <table width="90%" border="0" cellspacing="0" cellpadding="6">
      <tr>
        <td width="20%" align="right">Product Name</td>
        <td width="80%"><label>
          <input name="product_name" type="text" id="product_name" size="64" value="<?php echo $product_name; ?>" />
        </label></td>
      </tr>
      <tr>
        <td align="right">Product Price</td>
        <td><label>
          $
          <input name="price" type="text" id="price" size="12" value="<?php echo $price; ?>" />
        </label></td>
      </tr>
      
      <tr>
        <td align="right">Category</td>
        <td><select name="category" id="category">
          <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
             <option value="Fiction">Fiction</option>
          <option value="Suspense">Suspense</option>
          <option value="Literature">Literature</option>
          <option value="Children">Children</option>
          </select></td>
      </tr>
      <tr>
        <td align="right">Product Details</td>
        <td><label>
          <textarea name="details" id="details" cols="64" rows="5"><?php echo $details; ?></textarea>
        </label></td>
      </tr>
      <tr>
        <td align="right">Product Image</td>
        <td><label>
          <input type="file" name="fileField" id="fileField" />
        </label></td>
      </tr>      
      <tr>
        <td>&nbsp;</td>
        <td><label>
          <input name="thisID" type="hidden" value="<?php echo $targetID; ?>" />
          <input type="submit" name="button" id="button" value="Make Changes" />
        </label></td>
      </tr>
    </table>
    </form>
    <br />
  <br />
  </div>
  <?php include_once("../template_footer.php");?>
</div>
</body>
</html>