<?php
// need to do this 
session_start();
session_unset();
unset($_SESSION['db_customerID']);
unset($_SESSION['cart']);
unset($_SESSION['link']);
unset($_SESSION['db_jobTitle']);
unset($_SESSION['db_employeeName']);
unset($_SESSION['db_employeeID']);
session_destroy();
header("Location: index.php");

?>
