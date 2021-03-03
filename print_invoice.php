<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$customer_ID = $_SESSION['db_customerID'];
$order_ID = $_POST['order_id'];

$query1="SELECT * FROM orders WHERE db_orderID = '$order_ID'";
$order_results1 = $db->query($query1);
$num_order_results = mysqli_num_rows($order_results1);
$row1 = mysqli_fetch_assoc($order_results1);
$db_deliveryDatetime= $row1['db_deliveryDatetime'];
$db_collectionDatetime= $row1['db_collectionDatetime'];

//$number_periods =ceil(dateDiffInDays($db_deliveryDatetime, $db_collectionDatetime)/2);
//$number_periods=2;
$number_periods=ceil(((new DateTime($db_collectionDatetime))->diff(new DateTime($db_deliveryDatetime))->days)/2);

$query="SELECT * FROM vat";
$vat_results = $db->query($query);
$num_vat_results = mysqli_num_rows($vat_results);
$dv_vatRate =0;
for($i=0; $i<$num_vat_results; $i++)
{
  $row = mysqli_fetch_assoc($vat_results);
  $dv_vatRate= $row['dv_vatRate'];
}


?>
<div >
      <button class="btn btn-success" style="    margin-left: 40%;
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
    <h1>Invoice</h1>
  </div>
</div>
<br>
<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 25%;
    padding-right: 25%;">
  <div class="col-lg-6">
    <p><strong>TO:</strong></p>
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
    <p><strong>DELIVER TO:</strong></p>
    <p>Same as billing address</p>

  </div>

  <div class="col-lg-2">
      <p><strong>INVOICE #: </strong></p> <?php echo $order_ID, "<br>" ?>

      <p><strong>DATE: </strong></p>
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
      echo "<td><strong>Unit Price</strong></td>";
      echo "<td><strong>Set Up Price</strong></td>";
    echo "<td><strong>Total</strong></td>";
    echo "</tr>";
    $subtotal = 0;
    $delivery = 0;
  while($row = mysqli_fetch_row($invoice_details))
  {
      echo "<tr>";
      echo "<td>$row[0]</td>";
      echo "<td>$row[1]</td>";
      echo "<td>$row[2]</td>";
      echo "<td>$row[3]</td>";
      echo "<td>", ((($row[3] + $row[2])* $row[0])*$number_periods) , "</td>";
      echo "</tr>";
      $subtotal += ((($row[3] + $row[2])* $row[0])*$number_periods);
      $delivery = $row[4];
  }
  echo "<tr>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> SUBTOTAL</td>";
  echo "<td>$subtotal </td>";
  echo "</tr>";

  echo "<tr>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> VAT @ 23% </td>";
  echo "<td>", $subtotal * ($dv_vatRate/100), "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> DELIVERY CHARGES</td>";
  echo "<td>", $delivery, "</td>";
  echo "</tr>";

  echo "<tr>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td></td>";
  echo "<td> TOTAL DUE </td>";
  echo "<td>", (round($subtotal * (1+ ($dv_vatRate/100)),2)) + $row[4] +$delivery , "</td>";
  echo "</tr>";


  echo '</table>';
  ?>


</div>
<br>
<div class="row" style="margin-left: auto;
    margin-right: auto;
    padding-left: 25%;
    padding-right: 25%;">
  <br>
  <p>Payment due before delivery date. If you have any questions concerning this invoice, contact Accounts Payable, 01 756 1113, accounts@dph.ie</p>
</div>
<div class="row" >
  <p style="margin-left:auto; margin-right: auto;"><strong>THANK YOU FOR YOUR BUSINESS</strong></p>
</div>
