<?php 
 
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php
// This block to to check the session. If previous session is still valid, redirects to index page else to the admin_login page
session_start();
if(!isset($_SESSION["manager"])){
	header("location: registration.php");
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
if (isset($_GET['id'])) {
	// Connect to the MySQL database  
    include "storescripts/connect_to_mysql.php"; 
	// Use this var to check to see if this ID exists, if yes then get the product 
	// details, if no then exit this script and give message why
	$id=$_GET['id'];
	$sql = mysql_query("SELECT * FROM book_inventory WHERE book_name='$id' LIMIT 1");
	$productCount = mysql_num_rows($sql); // count the output amount
    if ($productCount > 0) {
		// get all the product details
		while($row = mysql_fetch_array($sql)){ 
			 $ISBN = $row["book_ID"];
			 $Book_Name = $row["book_name"];
			 $author= $row["author"];
			 $category = $row["genre"];
         }
		 
	} else {
		echo "That item does not exist.";
	    exit();
	}
}
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
<form id="form1" name="form1" method="post" action="Submit_Review.php">
  <p><br/>
    <br/>
    <label for='email' >ISBN    :</label>
<input type="hidden" name="book_ID" value="<?php echo $ISBN;?>"/>  <?php echo $ISBN?>   <br/><br/>
    <label for='username' >BOOK NAME:</label><?php echo $Book_Name?>
   <br/><br/>
    <label for='author' >AUTHOR  :</label><?php echo $author?>
    <br/><br/>
    <label for="Review">REVIEW</label>
    <textarea name="Review" id="Review" cols="45" rows="5"></textarea>
  </p>
  <p>
    <label for="rating">RATING</label>
    <select name="rating" id="rating">
      
      <option value="Worse">1 - Worse</option>
      <option value="Bad">2 - Bad</option>
      <option value="Average">3 - Average</option>
      <option value="Good" selected="selected">4 - Good</option>
      <option value="Excelent">5 - Excelent</option>
    </select>
    <br/>
    <br/>
    <input type="submit" value="SUBMIT REVIEW"/>
  </p>
  </form>
</center>
</body></div>
<?php include_once("template_footer.php"); ?>
</div>
</html>
