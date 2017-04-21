<?php 
/*
@author: Gayathri
*/ 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?

<?php 
// get the product id from the URL and check with database to retrieve details of the product
if (isset($_GET['id'])) {
	// Connect to the MySQL database 
    include "../DB_Connect.php"; 
	$id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
	// Use this var to check to see if this ID exists, if yes then get the product details
	$sql = mysql_query("SELECT * FROM products WHERE id='$id' LIMIT 1");
	$productCount = mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysql_fetch_array($sql)){ 
			 $product_name = $row["product_name"];
			 $price = $row["price"];
			 $details = $row["details"];
			 $category = $row["category"];
			 $date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
         }
		 
	} else {
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
<link rel="stylesheet" href="../style/style.css" type="text/css"/>
</head>
<body>
<center>
<div id="mainWrapper">
    <?php include_once("../header.php"); ?>
    <div align="right" style="margin-right:32px"><a href="logout.php">Logout</a><br /><a href="index.php">Back to main</a></div>
    <div id="pageContent" style="height:500px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="15">
  <tr>
    <td width="19%" valign="top"><img src="../inventory_images/<?php echo $id; ?>.jpg" width="142" height="188" alt="<?php echo $product_name; ?>" /><br />
      <a href="../inventory_images/<?php echo $id; ?>.jpg">View Full Size Image</a></td>
    <td width="81%" valign="top"><h3><?php echo $product_name; ?></h3>
      <p><?php echo "$".$price; ?><br />
        <br />
        <?php echo "$category"; ?> <br />
<br />
        <?php echo $details; ?>
<br />
        </p>
      </td>
    </tr>
</table>
    </div>
    <?php include_once("../footer.php"); ?>
</div>
</center>
</body>
</html>