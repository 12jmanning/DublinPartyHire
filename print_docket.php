<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$order_ID = $_POST['order_id'];

$query1="SELECT * FROM orders WHERE db_orderID = '$order_ID'";
$order_results1 = $db->query($query1);
$num_order_results = mysqli_num_rows($order_results1);
$row1 = mysqli_fetch_assoc($order_results1);
$db_deliveryDatetime= $row1['db_deliveryDatetime'];
$db_collectionDatetime= $row1['db_collectionDatetime'];
$customer_ID = $row1['db_customerID'];
$delivery_collection_pref = $row1['db_deliveryPreference'];
$set_up_pref = $row1['db_setUpPreference'];

?>
<div >
      <button class="btn btn-success" style="margin-left: 40%;
    margin-right: 40%;
    margin-top: 20px;
    margin-bottom: 20px;
    width: 20%;" onClick="window.print()">Print Me</button>
</div>


<div class="row" style="margin-left: auto;margin-right: auto;padding-left: 25%;">
  <div class="col-lg-4">
    <img src="img/logo.png" alt="">
    <p>15 Blackthorn Avenue</p>
    <p>Dublin Industrial Estate, Dublin 12, D12GL43</p>
    <p>Phone: 01 756 1111</p>
  </div>
  <div class="col-lg-4">
    <h1>Delivery Docket</h1>
  </div>
</div>

<div class="row" style="margin-left: auto;margin-right: auto;padding-left: 25%;">
  <div class="col-lg-4">
    <p><strong>DELIVERY/COLLECTION:</strong></p>
    <?php echo "$delivery_collection_pref"; ?>
  </div>
  <div class="col-lg-4">
    <p><strong>SETUP:</strong></p>
    <?php echo "$set_up_pref"; ?>
  </div>
</div>
<br>
<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 25%;
    padding-right: 25%;">
  <div class="col-lg-6">
    <p><strong>CUSTOMER DETAILS:</strong></p>
    <?php $address_query = "SELECT db_customerName, db_customerAddress, db_county, db_customerEircode, db_customerPhone FROM `customers`
                            WHERE db_customerID = '$customer_ID'";
    $address_details = $db->query($address_query);
    $row = mysqli_fetch_assoc($address_details);
    $customer_name = $row['db_customerName'] ; echo $customer_name, "<br>";
    $customer_address = $row['db_customerAddress'] ; echo $customer_address, "<br>";
    $customer_county = $row['db_county'] ; echo $customer_county, "<br>";
    $customer_eircode = $row['db_customerEircode'] ; echo $customer_eircode, "<br>";
    $customer_phone = $row['db_customerPhone'] ; echo "Phone: " , $customer_phone;

   ?>

  </div>
  <br>
  <div class="col-lg-4">
    <p><strong>DELIVERY DATE:</strong></p>
    <p><?php echo $db_deliveryDatetime ?></p>

    <p><strong>COLLECTION DATE:</strong></p>
    <p><?php echo $db_collectionDatetime; ?></p>

  </div>

  <div class="col-lg-2">
      <p><strong>ORDER #: </strong></p> <?php echo $order_ID, "<br>" ?>

      <p><strong>ORDERED ON: </strong></p>
      <?php $invoice_date_query = "SELECT db_orderCreatedAt FROM `orders`
                              WHERE db_orderID = '$order_ID'";
      $invoice_date_details = $db->query($invoice_date_query);
      $row = mysqli_fetch_assoc($invoice_date_details);
      $created_at = $row['db_orderCreatedAt'] ; echo $created_at, "<br>";
     ?>

  </div>

</div>
<br>
<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 25%;
    padding-right: 25%;">
  <div class="col-lg-8">
    <p><strong>COMMENTS OR SPECIAL INSTRUCTIONS:</strong></p>
    <?php $comment_query = "SELECT db_orderComment FROM `orders`
                            WHERE db_orderID = '$order_ID'";
    $comment_details = $db->query($comment_query);
    $row = mysqli_fetch_assoc($comment_details);
    $comment = $row['db_orderComment'] ; echo $comment, "<br>";
   ?>

  </div>
</div>

<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 33%;
    padding-right: 33%;">
  <?php
  $invoice_query = "SELECT product_orders.db_quantityOrdered, products.db_productName, products.db_productPrice, products.db_setUpPrice, orders.db_deliveryPrice
                        FROM `orders`, `products`, `product_orders`
                        WHERE orders.db_orderID = '$order_ID' AND orders.db_orderID = product_orders.db_orderID AND product_orders.db_productID = products.db_productID" ;
  $invoice_details = $db->query($invoice_query);
  echo '<table border="2">';
  echo '<tr class="first-row-database">';
      echo "<td><strong>Quantity</strong></td>";
      echo "<td><strong>Description</strong></td>";
    echo "<td><strong>Damaged Quantity</strong></td>";
    echo "</tr>";
    $subtotal = 0;
    $delivery = 0;
  while($row = mysqli_fetch_row($invoice_details))
  {
      echo "<tr>";
      echo "<td>$row[0]</td>";
      echo "<td>$row[1]</td>";
      echo "<td> </td>";
  }

  echo '</table>';
  ?>


</div>
<br>
<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 25%;
    padding-right: 25%;">
  <br>
  <p>Please mark down any breakages and record in the dashboard.</p>
</div>
<div class="row" >
  <p style="margin-left:auto; margin-right: auto;"><strong>THANK YOU</strong></p>
</div>

<div class="row" >
  <p style="margin-left:auto; margin-right: auto;"><strong>Signed By: </strong></p>
</div>

<div class="row" >
  <p style="margin-left:auto; margin-right: auto;"><strong>_________________ </strong></p>
</div>
