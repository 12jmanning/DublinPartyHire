<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


$customer_ID = $_SESSION['db_customerID'];
$query = "SELECT * FROM orders where db_customerID = $customer_ID";
$customer_orders = $db->query($query);
$num_results = mysqli_num_rows($customer_orders);

?>


<div class="row" style="margin-top: 3%;">

  <div class="col-lg-6">
    <h2 style="text-align: center;">My Details:</h2>
    <?php echo $customer_ID ?>
  </div>


  <div class="col-lg-6" >
    <h2 style="text-align: center;">Print Invoices:</h2>
    <form class="" action="print_invoice.php" method="post" name="invoice" id="invoice">

    <table class="">

    <tr>
      <td><label for="order_id">Select an Order ID:</label></td>
      <td style="width: 618px; height: 38px;" class="auto-style2">
      <select name="order_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select an Order--</option>
      <?php
        for($i = 0;$i<$num_results;$i++)
        {
          $row = mysqli_fetch_assoc($customer_orders);
          $q = 'select * from orders where '.$row['db_orderID'].'= orders.db_orderID';
          $result2 = $db->query($q);
          $row2 = mysqli_fetch_assoc($result2);

          echo '<<option value ="'.$row['db_orderID'].'">Order ID: '.$row['db_orderID']." On ".$row['db_deliveryDatetime'].'</option>';
        }
      ?>


    </tr>

    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>
    </table>

    </form>

  </div>

</div>






<div class="row" style="margin-left: auto; margin-right: auto; justify-content: center;">
  <h2>My Orders</h2>
</div>

<div class="row" style="margin-left: auto; margin-right: auto; justify-content: center;">

  <?php
  $customer_query = "SELECT db_orderID, db_deliveryDatetime, db_collectionDatetime, db_setUpPreference, db_deliveryPreference, db_setUpPrice, db_deliveryPrice, db_rentalPrice
                        FROM `orders`
                        WHERE db_customerID = '$customer_ID'";
  $order_details = $db->query($customer_query);
  echo '<table border="2">';
  echo '<tr class="first-row-database">';
      echo "<td>Order ID</td>";
      echo "<td>Delivery Time</td>";
      echo "<td>Collection Time</td>";
      echo "<td>Set Up Preference</td>";
      echo "<td>Delivery Preference</td>";
      echo "<td>Set Up Price</td>";
    echo "<td>Delivery Price</td>";
    echo "<td>Total Price</td>";
    echo "</tr>";
  while($row = mysqli_fetch_row($order_details))
  {
      echo "<tr>";
      echo "<td>$row[0]</td>";
      echo "<td>$row[1]</td>";
      echo "<td>$row[2]</td>";
      echo "<td>$row[3]</td>";
      echo "<td>$row[4]</td>";
      echo "<td>$row[5]</td>";
      echo "<td>$row[6]</td>";
      echo "<td>$row[7]</td>";
      echo "</tr>";
  }
  echo '</table>';?>

</div>

