<?php
// need to do this 
session_start();
session_unset();
unset($_SESSION['db_customerID']);
unset($_SESSION['cart']);
unset($_SESSION['link']);
session_destroy();
header("Location: index.php");

?>
