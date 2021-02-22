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


<div class="row" style="margin-top: 3%;">

  <div class="col-lg-6">
    <h2 style="text-align: center;">My Details:</h2>
    <?php echo $customer_ID ?>
    <table border="2">
      <tr>
        <td> Employee ID </td>
        <td> <?php echo $employee_ID; ?> </td>
      </tr>
      <tr>
        <td> Employee Name </td>
        <td> <?php echo $employee_name; ?> </td>
      </tr>
      <tr>
        <td> Job Title </td>
        <td> <?php echo $job_title; ?> </td>
      </tr>
    </table>
  </div>


  <div class="col-lg-6" >
    <h2 style="text-align: center;">Assign Employees and Vans to Transit Orders:</h2>
    <form class="" action="assign_employees.php" method="post" name="invoice" id="invoice">

    <table class="">

    <tr>
      <td><label for="order_id">Order ID:</label></td>
      <td style="width: 618px; height: 38px;" class="auto-style2">
      <select name="order_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select an Order--</option>
      <?php
        for($i = 0;$i<$num_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row = mysqli_fetch_assoc($orders_today);
          echo '<option value = "'.$row['db_orderID'].'"> Order ID: '.$row['db_orderID']." Type: ".$row['db_transitType'].' </option>';

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

