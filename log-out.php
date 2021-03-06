<?php
// need to do this 
session_start();
session_unset();
unset($_SESSION['db_customerID']);
unset($_SESSION['cart']);
session_destroy();
header("Location: index.php");

?>
