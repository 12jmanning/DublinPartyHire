<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$today_date = date("Y-m-d");
$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";
$order_ID = $_POST['order_id'];

?>