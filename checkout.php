<?php 
 
session_start(); // Start session first thing in script
// Script Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Connect to the MySQL database  
include "storescripts/connect_to_mysql.php"; 
?>
<?php 
// Gather this product's full information for inserting automatically into the edit form below on page
if (isset($_POST['cmd'])) {	
	$total_num = $_POST['total_num'];
 	$pp_checkout_btn=""; 
			
       
	for($x=1;$x<=$total_num;$x++){
		$quantity =$_POST["quantity_$x"];
		$book_name = $_POST["item_name_$x"];
		$price = $_POST["amount_$x"];	
		$category = $_POST["category_$x"];
		$item_1=$_POST['pricetotal'];		
		$pp_checkout_btn .= '
        <input type="hidden" name="category_' . $x . '" value="' . $category . '">		
        <input type="hidden" name="total_num" value="' . $x .' ">  
		<input type="hidden" name="item_name_' . $x . '" value="' . $book_name . '">
		<input type="hidden" name="amount_' . $x . '" value="' . $price . '">
        <input type="hidden" name="quantity_' . $x . '" value="' . $quantity . '"> 
		<input type="hidden" name="total_num" value="' . $x .' ">  ';		
		
	}   
    }?>

 
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
<center>
<h2>CHECKOUT<br/>
  <br/>
  </h2>
<form action="CompleteOrder.php" method="post">
  <label for='email' >TOTAL PRICE   :</label>
 <?php echo $item_1; ?>
  <br/><br/>
  <label for="card_type">CARD TYPE</label>
  <select name="card_type" id="card_type">
    <option>VISA</option>
    <option>MASTER CARD</option>
    <option>DISCOVER</option>
    <option>AMERICAN EXPRESS</option>
  </select>
<br/><br/>
   <label for='email' >CARD HOLDER NAME:</label>
  <input type='text' name='c_holderN' id='c_holderN' maxlength="50" />
  <br/><br/>
  <label for='username' >CARD NUMBER:</label>
  <input type='number' name='c_Number' id='c_Number' maxlength="50" />
  <br/><br/>
  <label for='author' >EXPIRY DATE:</label>
  <input type='text' name='expirydate' id='expirydate' maxlength="50" />
  <br/><br/>
  <label for='author' >CVV:</label>
  <input type='text' name='cvv' id='cvv' maxlength="50" />
  <br/><br/>
  <label for="S_TYPE">SHIPPING TYPE:</label>
  <select name="S_TYPE" id="S_TYPE">
    <option selected="selected">STANDARD</option>
    <option>EXPRESS</option>
    <option>OVERNIGHT</option>
  </select>
   <br/><br/>
   <label>RECEIVER'S NAME</label><input type="text" id="R_name" name="R_name" /><br /><br />
    
   <label>STREET ADDRESS</label><input type="text" id="street_address" name="street_address" /><br /><br />
    <label>CITY</label><input type="text" id="city" name="city"  /><br /><br />
    <label>STATE</label><input type="text" id="state" name="state"  /><br /><br />
    <label>ZIP CODE</label><input type="text" id="zipcode" name="zipcode" />    
<br/><br/>
<?php echo $pp_checkout_btn?>
  <input type="submit" value="COMPLETE MY ORDER"/>
<br/><br/> 

  </form>
</center>
</body>
</div>
<?php include_once("template_footer.php"); ?>
</div>
</html>
