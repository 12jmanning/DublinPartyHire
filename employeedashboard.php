<?php
session_start();
include('inc/detail.php');
include('inc/navbar.php');


$employee = "employee";



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




<!DOCTYPE html>
<html lang="en">
<body>



<div class="">
<h1>Clock In or Clock Out:</h1>
<form method="post" action="">

        <input type="submit" value = "Clock In" name="ClockIn">
        <input type="submit" name="ClockOut" value="Clock Out">
</form>
</div>

</body>
</html>
