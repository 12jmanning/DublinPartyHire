<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$today_date = date("Y-m-d");
$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";

$query1 = "select orders.db_orderID, transit.db_transitType from orders,transit where db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_deliveryDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
$orders_today = $db->query($query1);
$num_results = mysqli_num_rows($orders_today);
?>