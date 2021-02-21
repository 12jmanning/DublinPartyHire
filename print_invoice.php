<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$customer_ID = $_SESSION['db_customerID']
$order_ID = $_POST['order_id'];

echo "$order_ID";



?>

<div class="row">
  <div class="col-lg-6">
    <img src="img/logo.png" alt="">
    <p>15 Blackthorn Avenue</p>
    <p>Dublin Industrial Estate, Dublin 12, D12GL43</p>
    <p>Phone: 01 756 1111</p>
  </div>
  <div class="col-lg-6">
    <h1>Invoice</h1>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <p>TO:</p>
    <?php $address_query = "SELECT db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerPhone FROM `customers`
                            WHERE db_customerID = '$customer_ID'";
    $address_details = $db->query($address_query);
   ?>

  </div>

  <div class="col-lg-4">

  </div>

  <div class="col-lg-2">

  </div>

</div>
