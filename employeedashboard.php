<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


$employee = "employee";

$employeeID = $_SESSION['db_employeeID'];


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if(isset($_SESSION['db_employeeID']) && $_SESSION['db_jobTitle'] = $employee ){

          if(isset($_POST['ClockIn'])){

              $employeeID = $_SESSION['db_employeeID'];
              $clock_in_time = date("Y-m-d H:i:s");

              $q  = "INSERT INTO employee_timesheets (";
              $q .= "db_employeeID, db_startDatetime";
              $q .= ") VALUES (";
              $q .= "'$employeeID', '$clock_in_time')";

              $result = $db->query($q);
              echo "You have clocked in ";
          }

          if(isset($_POST['ClockOut'])){

              $employeeID = $_SESSION['db_employeeID'];
              $clock_out_time = date("Y-m-d H:i:s");

              $query = "SELECT db_timesheetID FROM employee_timesheets WHERE db_employeeID = '$employeeID' ORDER  BY db_startDatetime DESC LIMIT  1";

              $result1 = $db->query($query);
              $row = mysqli_fetch_assoc($result1);
              $timesheetID = $row['db_timesheetID'];

              $query1 = "UPDATE employee_timesheets SET db_endDatetime = '$clock_out_time' WHERE db_timesheetID = '$timesheetID'";
              $result = $db->query($query1);
              echo "You have clocked out";

          }

        }
    }

?>




<div class="row" style="padding-top:25px;">
  <div class="col-lg-1">

  </div>

  <div class="col-lg-4">
    <h2>Clock In or Clock Out:</h2>
    <form method="post" action="">

            <input class="btn btn-success"type="submit" value = "Clock In" name="ClockIn">
            <input class="btn btn-danger"type="submit" name="ClockOut" value="Clock Out">
    </form>

    <h2 style="padding-top:25px;">Current Status: </h2>

    <?php
      $status_query = "SELECT db_timesheetID, db_startDatetime, db_endDatetime FROM employee_timesheets WHERE db_employeeID = '$employeeID' ORDER  BY db_timesheetID DESC LIMIT  1";

      $employee_status = $db->query($status_query);
      $row1 = mysqli_fetch_assoc($employee_status);
      $start_time = $row1['db_startDatetime'];
      $end_time = $row1['db_endDatetime'];


      if ($end_time == "0000-00-00 00:00:00") {
        echo "You are clocked in since : ", $start_time;
      }
      else if ($end_time !== "0000-00-00 00:00:00") {
        echo "You are clocked out";
      }
     ?>

     <h2 style="padding-top:25px;">Employee Details: </h2>
     <?php
     $details_query = "SELECT db_employeeID, db_employeeName, db_jobTitle FROM `employees`
                             WHERE db_employeeID = '$employeeID'";
     $employee_details = $db->query($details_query);
     $row2 = mysqli_fetch_assoc($employee_details);
     $employee_id = $row2['db_employeeID'] ;
     $employee_name = $row2['db_employeeName'] ;
     $employee_job_title = $row2['db_jobTitle'] ;

     echo "Employee ID: ", $employee_id, "<br>";
           echo "Name: ", $employee_name, "<br>";
           echo "Job Title: ", $employee_job_title, "<br>";

      ?>


  </div>

  <div class="col-lg-6">
    <h2>My Timesheets: </h2>
    <?php
    $time_query = "SELECT db_timesheetID, db_startDatetime, db_endDatetime
                          FROM `employee_timesheets`
                          WHERE db_employeeID = '$employeeID'";
    $time_details = $db->query($time_query);
    echo '<table border="2">';
    echo '<tr class="first-row-database">';
        echo "<td>Timesheet ID</td>";
        echo "<td>Start Time</td>";
        echo "<td>End Time</td>";
        echo "<td>Hours Worked</td>";
      echo "</tr>";
    $total_hours_worked = 0;
    while($row3 = mysqli_fetch_row($time_details))
    {
        echo "<tr>";
        echo "<td>$row3[0]</td>";
        echo "<td>$row3[1]</td>"; $timestamp_start = strtotime($row3[1]);
        echo "<td>$row3[2]</td>"; $timestamp_end = strtotime($row3[2]);
        echo "<td>", round(abs($timestamp_end - $timestamp_start) / (60*60), 2) ,"</td>";
        echo "</tr>";
        $total_hours_worked += round(abs($timestamp_end - $timestamp_start) / (60*60), 2);
    }
    echo "<tr>";
    echo "<td> </td>";
    echo "<td> </td>";
    echo "<td><strong>TOTAL HOURS</strong></td>";
    echo "<td>$total_hours_worked </td>";
    echo "</tr>";

    echo '</table>';

    ?>

  </div>

</div>
