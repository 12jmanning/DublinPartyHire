<?php
include('inc/detail.php');
include('inc/navbar.php');

// currently clocked in employees
// force clock out someone
// add notification to admin dashboard so they see who is clocked in after 5pm on that day
// order status
// exceeding 39 hours in a week for an employee 
?>

<div class="col-lg-6">
  <h2>Hours Worked Report Past 7 Days: </h2>
  <?php

  $last_week = date("Y-m-d H:i:s", strtotime("-1 week"));

  $time_query = "SELECT employee_timesheets.db_timesheetID, employee_timesheets.db_startDatetime, employee_timesheets.db_endDatetime, employees.db_employeeName
                        FROM `employee_timesheets` , `employees`
                        WHERE db_startDatetime >= '$last_week' AND employee_timesheets.db_employeeID = employees.db_employeeID";
  $time_details = $db->query($time_query);
  $num_time_results = mysqli_num_rows($time_details);

  echo '<table border="2">';
  echo '<tr class="first-row-database">';
      echo "<td>Timesheet ID</td>";
      echo "<td>Employee</td>";
      echo "<td>Start Time</td>";
      echo "<td>End Time</td>";
      echo "<td>Hours Worked</td>";
    echo "</tr>";
  $total_hours_worked = 0;
  while($row3 = mysqli_fetch_row($time_details))
  {
      echo "<tr>";
      echo "<td>$row3[0]</td>";
      echo "<td>$row3[3]</td>";
      echo "<td>$row3[1]</td>"; $timestamp_start = strtotime($row3[1]);
      echo "<td>$row3[2]</td>"; $timestamp_end = strtotime($row3[2]);
      echo "<td>", round(abs($timestamp_end - $timestamp_start) / (60*60), 2) ,"</td>";
      echo "</tr>";
      $total_hours_worked += round(abs($timestamp_end - $timestamp_start) / (60*60), 2);
  }
  echo "<tr>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td> </td>";
  echo "<td><strong>TOTAL HOURS</strong></td>";
  echo "<td>$total_hours_worked </td>";
  echo "</tr>";

  echo '</table>';

  ?>

</div>

<?php
$shiftErr= "";
$timeErr="";
$valid= true;

if ($_SERVER["REQUEST_METHOD"] == "POST"&& isset($_POST['submit'])) {
    if (($_POST["timesheet_id"])== "select") {
        $shiftErr = "You must select a shift";
        $valid=false;
    }
    if (empty($_POST["db_endDatetime"])) {
        $timeErr = "End Date must be inputted";
        $valid=false;
    }
    // if($valid)
    // {
    //     if (!is_numeric($_POST["db_productPrice"])) {
    //         $priceErr = "Product Price must be numeric";
    //         $valid=false;
    //     }
    //     else if ($_POST["db_productPrice"]<=0) {
    //         $priceErr = "Product Price must be greater than 0";
    //         $valid=false;
    //     }
    // }

    if($valid!=false)
    {
        $db_timesheetID =$_POST['timesheet_id'];
        $db_endDatetime=$_POST['db_endDatetime'];
        $query = "UPDATE employee_timesheets SET db_endDatetime = '$db_endDatetime' WHERE db_timesheetID = '$db_timesheetID'";
        $edit_product = $db->query($query);

    }

}

?>

<div class="col-lg-6" >
  <h2>Alter Employee End Time:</h2>
  <form class="dd" action="" method="post" >

  <table class="dd">

  <tr>
    <td><label for="order_id">Employee Shift:</label></td>
    <td style="width: 399px; height: 38px;" class="auto-style2">
    <select name="timesheet_id" style="width: 399px" class="auto-style1" required>
    <option value= "select">--Select a Shift--</option>
    <?php
    $time_query = "SELECT employee_timesheets.db_timesheetID, employee_timesheets.db_startDatetime, employee_timesheets.db_endDatetime, employees.db_employeeName
                          FROM `employee_timesheets` , `employees`
                          WHERE db_startDatetime >= '$last_week' AND employee_timesheets.db_employeeID = employees.db_employeeID";
    $time_details = $db->query($time_query);
      for($i = 0;$i<$num_time_results;$i++)
      {
        //Move query up top and iterate through results here with an if statement
        $row1 = mysqli_fetch_assoc($time_details);
        echo '<option value = "'.$row1['db_timesheetID'].'"> Staff Name: '.$row1['db_employeeName']." Current End Date: ".$row1['db_endDatetime'].' </option>';

      }
    ?>
    <td><?php echo $shiftErr ?></td>
  </tr>
  <tr>
      <td><label for ="members">New End Date Time:</label></td>
      <td><input type="datetime-local" name="db_endDatetime" id="db_endDatetime" size = 20><span class='error'> <?php echo $timeErr ?> <span></td>
  </tr>
  <tr>
    <td></td>
    <td><input class="btn btn-success" type="submit" value="Submit" name ="submit"><input style="margin-left: 4px;"class="btn btn-danger" type="reset" value="Reset"></td>
  </tr>
  </table>

  </form>
</div>
