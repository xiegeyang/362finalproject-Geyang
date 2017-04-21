<?php
/*
@author: Gayathri
Logout functionality
*/
?>
<?php
// This destroys the existing session and redirects to the index page which in turn redirects to admin_login page
session_start();
unset($_SESSION['manager']);
session_destroy();
header("Location: AdminLogin.php");
exit;
?>