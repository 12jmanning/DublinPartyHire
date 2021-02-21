<?php

session_unset();
unset($_SESSION['db_customerID']);
session_destroy();
header("Location: index.php");

?>
