<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');

$db_employeeErr=$db_vanErr="";
$valid=true;

$now_today_date = date("Y-m-d H:i:s");
$start_today_date = date("Y-m-d");
$start_today_date = $start_today_date.''."T00:00:00.00";
$no_time = "0000-00-00T00:00:00.00";
$employee_title ="employee";

$employee_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";
$transit_ID = $_SESSION['transit_ID'];


$van_query = "SELECT * FROM vans";
$van_results = $db->query($van_query);
$num_van_results = mysqli_num_rows($van_results);

$employee_query = "SELECT employees.db_employeeID, employees.db_employeeName FROM employees, employee_timesheets WHERE employees.db_employeeID=employee_timesheets.db_employeeID AND employees.db_jobTitle='$employee_title' AND (employee_timesheets.db_StartDatetime BETWEEN '$start_today_date' AND '$now_today_date') AND employee_timesheets.db_endDatetime = '0'";
$employee_results = $db->query($employee_query);
$num_employee_results = mysqli_num_rows($employee_results);


$today_date = date("Y-m-d");
$admin_ID = $_SESSION['db_employeeID'];
$employee_name = $_SESSION['db_employeeName'];
$job_title = $_SESSION['db_jobTitle'];
$yes = "Yes";

$query1 = "select orders.db_orderID, transit.db_transitType, transit.db_transitID from orders,transit where orders.db_orderID = transit.db_orderID AND db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
$orders_today = $db->query($query1);
$num_results = mysqli_num_rows($orders_today);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["employee_id"])||empty($_POST["van_id"])||empty($_POST['transit_id'])) {
      $db_employeeErr = "Both fields are required";
      $db_vanErr = "Both fields are required";
      $valid=false;
  }
  if($valid==true ){
      $employee_id = $_POST["employee_id"];
      $van_id = $_POST["van_id"];
      $transit_ID= $_POST['transit_id'];
      $insert_query = "INSERT INTO employee_work_records (";
      $insert_query .= "db_transitID, db_employeeID, db_vanID";
      $insert_query .= ") VALUES (";
      $insert_query .= "'$transit_ID','$employee_id','$van_id')";
      $result_insert = $db->query($insert_query);

      // echo '<table border="2">';
      // echo '<tr class="first-row-database">';
      //     echo "<td></td>";
      //     echo "<td><strong>Transit ID</strong></td>";
      //     echo "<td><strong>Employee ID</strong></td>";
      //     echo "<td><strong>Van ID</strong></td>";
      // echo "</tr>";
      // echo "<tr>";
      //     echo "<td></td>";
      //     echo "<td> $transit_ID </td>";
      //     echo "<td> $employee_id </td>";
      //     echo "<td> $van_id </td>";
      // echo "</tr>";


  }
}
?>


<div class="row" style="padding-top:25px;">

  <div class="col-lg-1">

  </div>
  <div class="col-lg-4">
    <h2>My Details:</h2>
    <?php
          echo "Employee ID: ", $admin_ID, "<br>";
          echo "Name: ", $employee_name, "<br>";
          echo "Job Title: ", $job_title, "<br>";
     ?>

     <h2 style="padding-top:25px;">Transits Today:</h2>

     <?php
     $orders_today_query = "select orders.db_orderID, transit.db_transitType, transit.db_transitID from orders,transit where orders.db_orderID = transit.db_orderID AND db_deliveryPreference = '$yes' AND ((orders.db_deliveryDatetime= '$today_date' AND orders.db_deliveryID = transit.db_transitID ) OR (orders.db_collectionDatetime= '$today_date' AND orders.db_collectionID = transit.db_transitID))";
     $orders_today_details = $db->query($orders_today_query);
     $num_orders_today = mysqli_num_rows($orders_today_details);

     echo '<table border="2">';
     echo '<tr class="first-row-database">';
         echo "<td>Order ID</td>";
         echo "<td>Type</td>";
         echo "<td>Transit ID</td>";
       echo "</tr>";
     while($row_orders_today = mysqli_fetch_row($orders_today_details))
     {
         echo "<tr>";
         echo "<td>$row_orders_today[0]</td>";
         echo "<td>$row_orders_today[1]</td>";
         echo "<td>$row_orders_today[2]</td>";
         echo "</tr>";
     }
       echo '</table>';
     ?>



  </div>


  <div class="col-lg-6" >
    <h2>Assign Employees and Vans to Transit Orders:</h2>
    <form class="dd" action="" method="post" >

    <table class="dd">

    <tr>
      <td><label for="order_id">Order ID:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="transit_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select an Order--</option>
      <?php
        for($i = 0;$i<$num_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row = mysqli_fetch_assoc($orders_today);
          echo '<option value = "'.$row['db_transitID'].'"> Order ID: '.$row['db_orderID']." Type: ".$row['db_transitType'].' </option>';

        }
      ?>
    </tr>
    <tr>
      <td><label for="order_id">Van ID:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="van_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select a Van--</option>
      <?php
        for($i = 0;$i<$num_van_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row_van = mysqli_fetch_assoc($van_results);
          echo '<option value = "'.$row_van['db_vanID'].'"> Van ID: '.$row_van['db_vanID']." Van Name: ".$row_van['db_vanName'].' </option>';

        }
      ?>
      <span class='error'> <?php echo $db_vanErr ?> <span></td>
    </tr>
    <tr>
      <td><label for="order_id">Employee ID:</label></td>
      <td style="width: 399px; height: 38px;" class="auto-style2">
      <select name="employee_id" style="width: 399px" class="auto-style1" required>
      <option value= "select">--Select an Employee--</option>
      <?php
        for($i = 0;$i<$num_employee_results;$i++)
        {
          //Move query up top and iterate through results here with an if statement
          $row_employee = mysqli_fetch_assoc($employee_results);
          echo '<option value = "'.$row_employee['db_employeeID'].'"> Employee ID: '.$row_employee['db_employeeID']." Name: ".$row_employee['db_employeeName'].' </option>';

        }
      ?>
      <span class='error'> <?php echo $db_employeeErr ?> <span></td>
    </tr>

    <tr>
      <td></td>
      <td><input class="btn btn-success" type="submit" value="Submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
    </tr>

    <tr>
      <td></td>
      <td><p>Edit Product Prices <a href="alter_products.php">HERE</a></p></td>
    </tr>
    </table>

    </form>

  </div>

</div>
